<?php

namespace App\Http\Controllers\Registration;
use Illuminate\Http\Request;
use App\Http\Controllers\DatabaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Registration\RegistrationServices;

use Carbon\Carbon;

class RegistrationController extends Controller
{

	protected $service;

	public function __construct(RegistrationServices $service)
	{
		$this->service = $service;
	}



	// CONTROLLER (FIX: keep data but DO NOT reuse globally for both cities)
// CONTROLLER (RETURN DATA GROUPED BY CITY)

	public function index()
	{
		$rows = DB::connection('special_db')
			->table('exhibitor')
			->select('city', 'state', DB::raw('COUNT(*) as total'))
			->groupBy('city', 'state')
			->get();

		$data = $rows->groupBy('city')->map(function ($items, $city) {
			return [
				'city' => $city,
				'data' => collect($items)->mapWithKeys(function ($item) {
					return [
						strtolower($item->state) => (int) $item->total
					];
				}),
			];
		})->values();
		// echo $data;

		return view('registration.home', compact('data'));
	}

	public function delegatesstore(Request $request, $key)
	{

		// dd($request->all());


		$company = $request->company_name;
		$stallno = $request->stallno;
		$delegates = json_decode($request->delegates, true);
		$specialKey = $key;

		// Check for JSON errors
		if (json_last_error() !== JSON_ERROR_NONE) {
			return back()->with('error', 'Invalid delegates JSON.');
		}

		// dd($delegates);

		$segments = explode('/', trim($request->path(), '/'));

		$lastSegment = $segments[count($segments) - 1] ?? null;
		$Exhibitingin = $segments[count($segments) - 2] ?? null;

		if ($lastSegment !== 'exhibitorform') {
			$sourcename = $lastSegment;
		} else {
			$Exhibitingin = null;
			$sourcename = null;
		}

		// $specialKey = $request->identifierkey;
		$Exhibitingin = $request->city;
		$sourcename = $request->state;
		$lastSegment = $sourcename;
		$Exhibitingin = $Exhibitingin;

		$result = [];
		$name = null;
		// $specialKey = generateKeyforIdnedtifies
		$exhibitInRestore = $Exhibitingin;


		foreach ($delegates as $delegate) {


			$name = $delegate['name'];
			$designation = $delegate['designation'];

			$mobile = $delegate['mobile'];
			$email = $delegate['email'];


			// dd($name, $mobile, $email);
			$db = DB::connection('special_db');
			$key = "exh" . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 2) . str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT);
			if ($Exhibitingin == "lara" || $Exhibitingin == "form") {
				$Exhibitingin = $lastSegment;
			}

			$this->service->storeOne(
				$key,
				$name,
				$designation,
				$company,
				$Exhibitingin,
				$mobile,
				$email,
				$lastSegment,
				$stallno,
				$specialKey
			);
			$Exhibitingin = $exhibitInRestore;

			if ($Exhibitingin != "lara" && $Exhibitingin != "iitm") {

				$prefix = strtolower(substr($sourcename, 0, 3));


				$prefix = strtolower(substr($sourcename, 0, 3));

				$lastEntry = $db->table('exhibitor')
					->whereRaw('LOWER(LEFT(mobile, 3)) = ?', [$prefix])
					->orderBy('id', 'desc')
					->first();

				$num = 1;

				if ($lastEntry && !empty($lastEntry->mobile)) {

					$lastMobile = strtolower($lastEntry->mobile);

					// Example:
					// san01 -> 1
					// san009 -> 9
					// san123 -> 123
					$lastNumber = (int) preg_replace('/^\D+/', '', $lastMobile);

					$num = $lastNumber + 1;
				}

				$newMobile = $prefix . str_pad($num, 2, '0', STR_PAD_LEFT);

				$key = "exh" . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 2) . str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT);

				if (!in_array($Exhibitingin, ['bangalore', 'chennai', 'hyderabad', 'kolkata', 'ahmedabad', 'kochi', 'pune'])) {
					$newMobile = $key;
				}
				$this->service->storeOne(
					$key,
					$name,
					$company,
					$Exhibitingin,
					$newMobile,
					$lastSegment,
					$stallno
				);
				$result[] = [
					'name' => $name,
					'key' => $newMobile,
				];

			} else {
				$result[] = [
					'name' => $name,
					'key' => $key,
				];
			}


		}


		return redirect()->to(url('delegates/' . $specialKey));

	}
	public function store(Request $request)
	{

		// dd($request->all());

		$company = $request->company_name;
		$stallno = $request->stallno;
		$delegates = json_decode($request->delegates, true);

		// Check for JSON errors
		if (json_last_error() !== JSON_ERROR_NONE) {
			return back()->with('error', 'Invalid delegates JSON.');
		}

		// dd($delegates);

		$segments = explode('/', trim($request->path(), '/'));

		$lastSegment = $segments[count($segments) - 1] ?? null;
		$Exhibitingin = $segments[count($segments) - 2] ?? null;

		if ($lastSegment !== 'exhibitorform') {
			$sourcename = $lastSegment;
		} else {
			$Exhibitingin = null;
			$sourcename = null;
		}


		$result = [];
		$name = null;
		// $specialKey = generateKeyforIdnedtifies
		if ($request->has('identifierkey')) {

			$specialKey = $request->identifierkey;
			$Exhibitingin = $request->city;
			$sourcename = $request->state;

		} else {

			$specialKey = "key" . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 2) . str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT);

		}
		$exhibitInRestore = $Exhibitingin;


		foreach ($delegates as $delegate) {


			$name = $delegate['name'];
			$designation = $delegate['designation'];

			$mobile = $delegate['mobile'];
			$email = $delegate['email'];


			// dd($name, $mobile, $email);
			$db = DB::connection('special_db');
			$key = "exh" . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 2) . str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT);
			if ($Exhibitingin == "lara" || $Exhibitingin == "form") {
				$Exhibitingin = $lastSegment;
			}

			$this->service->storeOne(
				$key,
				$name,
				$designation,
				$company,
				$Exhibitingin,
				$mobile,
				$email,
				$lastSegment,
				$stallno,
				$specialKey
			);
			$Exhibitingin = $exhibitInRestore;

			if ($Exhibitingin != "lara" && $Exhibitingin != "iitm") {

				$prefix = strtolower(substr($sourcename, 0, 3));


				$prefix = strtolower(substr($sourcename, 0, 3));

				$lastEntry = $db->table('exhibitor')
					->whereRaw('LOWER(LEFT(mobile, 3)) = ?', [$prefix])
					->orderBy('id', 'desc')
					->first();

				$num = 1;

				if ($lastEntry && !empty($lastEntry->mobile)) {

					$lastMobile = strtolower($lastEntry->mobile);

					// Example:
					// san01 -> 1
					// san009 -> 9
					// san123 -> 123
					$lastNumber = (int) preg_replace('/^\D+/', '', $lastMobile);

					$num = $lastNumber + 1;
				}

				$newMobile = $prefix . str_pad($num, 2, '0', STR_PAD_LEFT);

				$key = "exh" . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 2) . str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT);

				if (!in_array($Exhibitingin, ['bangalore', 'chennai', 'hyderabad', 'kolkata', 'ahmedabad', 'kochi', 'pune'])) {
					$newMobile = $key;
				}
				$this->service->storeOne(
					$key,
					$name,
					$company,
					$Exhibitingin,
					$newMobile,
					$lastSegment,
					$stallno
				);
				$result[] = [
					'name' => $name,
					'key' => $newMobile,
				];

			} else {
				$result[] = [
					'name' => $name,
					'key' => $key,
				];
			}


		}


		return redirect()->to(url('delegates/' . $specialKey));

		return view('registration.complete', [
			'delegates' => $result,
			'identifierkey' => $specialKey,
			'company' => $company,
			'mobile' => $mobile,
			'stallno' => $stallno,
			'result' => $result
		]);
	}

	public function editentry(Request $request)
	{
		// Debug all incoming data
		// dd($request->all());

		// Example structure:
		// $request->persons = [
		//   0 => ['person_key'=>..., 'name'=>..., 'designation'=>..., 'mobile'=>..., 'email'=>...],
		//   1 => ...
		// ];

		foreach ($request->persons as $person) {
			$db = DB::connection('special_db');

			$db->table('exhibitor')
				->where('person_key', $person['person_key'])
				->update([
					'name' => $person['name'],
					'designation' => $person['designation'],
					'mobile' => $person['mobile'],
					'email' => $person['email'],
					'city' => $person['city'] ?? null,
					'state' => $person['state'] ?? null,
					'bag_collected' => $person['bag_collected'] ?? 0,
					'company_name' => $person['company_name'] ?? null,
				]);
		}

		return response()->json([
			'status' => true,
			'message' => 'Updated successfully'
		]);
	}

	public function enteryourmobile()
	{
		return view('registration.enteryourmobile');
	}
	public function delegatesInfobymobile($mobile)
	{
		// dd($mobile);
		$data = DB::connection('special_db')
			->table('exhibitor')
			->where('mobile', $mobile)
			->orderBy('id', 'desc')
			->get();
		// dd($data);


		if ($data->isEmpty()) {
			return redirect()
				->route('formexhibitor')
				->with('mobile', $mobile);
		}

		return view('registration.delegatesview', compact('data'));
	}
	public function delegatesInfo($specialKey)
	{

		$data = DB::connection('special_db')
			->table('exhibitor')
			->where('identifierkey', $specialKey)
			->get();

		// dd($data);

		return view('registration.delegatesview', compact('data'));
	}

	public function form($location = null, $person = null)
	{
		$data = null;
		return view('registration.form', compact('data'));

	}

	public function formentries($city = null, $state = null)
	{
		$query = DB::connection('special_db')
			->table('exhibitor');



		// If both are empty -> return full data
		$data = $query->orderBy('id', 'desc')
			->limit(500)
			->get();

		$cities = DB::connection('special_db')
			->table('exhibitor')
			->select('city')
			->distinct()
			->orderBy('city', 'asc')
			->get();

		$states = DB::connection('special_db')
			->table('exhibitor')
			->select('state')
			->distinct()
			->orderBy('state', 'asc')
			->get();

		return view('registration.entries', compact('data', 'cities', 'states'));
	}

	public function formentriesbyspecifics($city = null, $state = null)
	{
		$query = DB::connection('special_db')
			->table('exhibitor');

		// FILTER: CITY
		if (!empty($city)) {
			$query->where('city', $city);
		}

		// FILTER: STATE
		if (!empty($state)) {
			$query->where('state', $state);
		}

		// If both are empty -> return full data
		$data = $query->orderBy('id', 'desc')
			->limit(500)
			->get();

		$cities = DB::connection('special_db')
			->table('exhibitor')
			->select('city')
			->distinct()
			->orderBy('city', 'asc')
			->get();

		$states = DB::connection('special_db')
			->table('exhibitor')
			->select('state')
			->distinct()
			->orderBy('state', 'asc')
			->get();
		// echo $city . "==" . $state;
		// dd($data);
		return view('registration.entries', compact('data', 'cities', 'states'));
	}
}