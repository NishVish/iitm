<?php

namespace App\Http\Controllers\Registration;
use Illuminate\Http\Request;
use App\Http\Controllers\DatabaseController;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Registration\RegistrationServices;

use Carbon\Carbon;

class RegistrationoldController extends Controller
{

	protected $service;

	public function __construct(RegistrationServices $service)
	{
		$this->service = $service;
	}



	// CONTROLLER (FIX: keep data but DO NOT reuse globally for both cities)
// CONTROLLER (RETURN DATA GROUPED BY CITY)


	public function choose()
	{

		return view('web.registrationold.index');
	}

	public function store(Request $request)
	{

		// dd(config('database.connections.special_db2'));
		// dd($request->all());
		$db = DB::connection('special_db2');

		// $lastId = $db->table('exhibitor')->max('id');
		// $newId = $lastId + 1;




		$lastsegment = request()->segment(count(request()->segments()));

		if ($lastsegment == 'exhibitor') {

			$db::table('exhibitor2025')->insert([
				'title' => $request->title,
				'select' => trim($request->firstname . ' ' . $request->lastname),
				'designation' => $request->designation,
				'organisation' => $request->organisation,
				'email' => $request->email,
				'phone' => $request->phone,
				// 'country_code'   => $request->country_code,
				'mobile' => $request->mobile,
				'address' => $request->address,
				'city' => $request->city,
				'state' => $request->state,
				'pincode' => $request->pincode,
				'country' => $request->country,
				'category' => $request->category,
				'website' => $request->website,
				'bengaluru' => $request->city_name == 'bengaluru' ? 'Yes' : null,
				'chennai' => $request->city_name == 'chennai' ? 'Yes' : null,
				'delhi' => $request->city_name == 'delhi' ? 'Yes' : null,
				'mumbai' => $request->city_name == 'mumbai' ? 'Yes' : null,
				'pune' => $request->city_name == 'pune' ? 'Yes' : null,
				'hydrabad' => $request->city_name == 'hydrabad' ? 'Yes' : null,
				'kochi' => $request->city_name == 'kochi' ? 'Yes' : null,
				'kolkata' => $request->city_name == 'kolkata' ? 'Yes' : null,
				'ahmedabad' => $request->city_name == 'ahmedabad' ? 'Yes' : null,
				'ip_address' => $request->ip(),
				'date_reg' => now(),
			]);

			//send mail	

		} else {

			$db->table('tradev')->insert([
				'title' => $request->title,
				'select2' => trim($request->firstname . ' ' . $request->lastname),
				'designation' => $request->designation,
				'organisation' => $request->organisation,
				'email' => $request->email,
				'phone' => $request->phone,
				'mobile' => $request->mobile,
				'address' => $request->address,
				'city' => $request->city,
				'state' => $request->state,
				'pincode' => $request->pincode,
				'country' => $request->country,
				'website' => $request->website,
				'category' => $request->category,
				'city_name' => $request->city_name,
				'eventinfo' => $request->eventinfo,
				'date_reg' => now(),
			]);

			$id = $db->table('tradev')
				->where('mobile', $request->mobile)
				->latest('id')
				->value('id');

			// send mail

			return redirect('badge/' . $id);

		}
		return view('web.registrationold.index', compact('id', 'type'));

	}


	public function badge($id)
	{



		// registraion
		// date and city
		$db = DB::connection('special_db2');

		$data = $db->table('tradev')->where('id', $id)->first();


		// dd($data);
		if (!$data) {
			abort(404);
		}

		// stdClass -> array
		$data = (array) $data;

		$data['emailpage'] = true;
		$data['preview'] = true;
		$data['print'] = false;

		$data['contactName'] = $data['select2'];

		$data['companyName'] = $data['organisation'];

		if (empty($data['eventinfo']) || !is_array($data['eventinfo']) || empty($eventinfo['venue_details'])) {
			return redirect('retry');
		}
		$eventinfo = json_decode($data['eventinfo'], true);

		$data['venue'] = $eventinfo['venue_details'];


		$data['eventname'] = $eventinfo['name'];
		$data['year'] = $eventinfo['year'];
		$data['databasename'] = "hello";
		$eventinfo = json_decode($data['eventinfo'], true);

		$all_dates = [];

		if (!empty($eventinfo['start_date']) && !empty($eventinfo['end_date'])) {

			$start = \Carbon\Carbon::parse($eventinfo['start_date']);
			$end = \Carbon\Carbon::parse($eventinfo['end_date']);

			while ($start->lte($end)) {
				$all_dates[] = $start->format('Y-m-d');
				$start->addDay();
			}
		}


		$data['all_dates'] = $all_dates;
		print_r($data);
		return view('web.registrationold.email.index', compact('data'));
	}
	public function eventlist()
	{

		$segments = request()->segments();

		$lastSegment = end($segments);
		$secondlastSegment = count($segments) > 1
			? $segments[count($segments) - 2]
			: null;


		if ($lastSegment == 'retry') {

			$message = "try again";			// exit;
		}

		$message = "Ok";			// exit;

		return view('web.registrationold.index', compact('message'));
	}



	public function exhibitorform()
	{

		$events = DB::table('events')
			->where('start_date', '>=', date('Y-m-d'))
			->orderBy('start_date', 'asc')
			->get();

		$event1 = $events->first();
		// Different variable: cities
		$cities = $events->map(function ($event) {
			return str_replace('IITM ', '', $event->name);
		});


		return view('web.registrationold.index', compact('event1', 'cities'));
	}


	public function tradeform($location)
	{



		if (in_array($location, ['chennai', 'bangalore', 'kolkata', 'delhi', 'kochi', 'mumbai', 'hyderabad', 'ahmedabad'])) {

			$events = DB::table('events')
				->where('start_date', '>=', date('Y-m-d'))
				->where('name', 'LIKE', '%' . $location . '%')
				->orderBy('start_date', 'asc')
				->get();


			$event1 = $events->first();
			$city = $location;
			print_r($event1);
			print_r($location);
			// Different variable: cities
			$cities = $events->map(function ($event) {
				return str_replace('IITM ', '', $event->name);
			});

			return view('web.registrationold.index', compact('event1', 'city', 'cities'));
		} else {


			return redirect('register/eventlist');
		}
	}


}
