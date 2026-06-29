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


	public function index()
	{
		return view('registration.home');
	}
	public function store(Request $request)
	{

		// dd($request->all());
		$names = $request->input('delegates', []);
		$company = $request->input('company_name');
		$mobile = $request->input('mobile');
		$stallno = $request->input('stallno');

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
		$exhibitInRestore = $Exhibitingin;
		foreach ($names as $name) {

			$db = DB::connection('special_db');
			$key = "exh" . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 2) . str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT);
			if ($Exhibitingin == "lara") {
				$Exhibitingin = $lastSegment;
			}

			$this->service->storeOne(
				$key,
				$name,
				$company,
				$Exhibitingin,
				$mobile,
				$lastSegment,
				$stallno
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



		return view('registration.complete', [
			'delegates' => $result,

			'company' => $company,
			'mobile' => $mobile,
			'stallno' => $stallno,
			'result' => $result
		]);
	}


	public function form($location = null, $person = null)
	{

		return view('registration.form');

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