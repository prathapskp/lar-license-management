<?php namespace App\Http\Controllers;
use DB;
class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		/** next month expiring license */
		$formated_start = date("Y-m-01",strtotime("+1 month"));
		$next_month_end = date("Y-m-01",strtotime("+2 month"));
		$formated_end = date("Y-m-d",strtotime("-1 day", strtotime($next_month_end)));
		$next_month_license_type_expiry_data = DB::table('license_type_vehicle')
        ->join('license_types', 'license_types.id', '=', 'license_type_vehicle.license_type_id')
        ->select(DB::raw('count(license_type_vehicle.id) as type_count, license_types.type as type'))
        ->whereBetween('license_type_vehicle.license_end_on',[$formated_start,$formated_end])
         ->whereNull('license_type_vehicle.deleted_at')
        ->groupBy('license_types.id')
        ->get();
        /** current month expiring license */
        $formated_start = date("Y-m-01");
		$month_end = date("Y-m-01",strtotime("+1 month"));
		$formated_end = date("Y-m-d",strtotime("-1 day", strtotime($month_end)));
        $current_month_license_type_expiry_data = DB::table('license_type_vehicle')
        ->join('license_types', 'license_types.id', '=', 'license_type_vehicle.license_type_id')
        ->select(DB::raw('count(license_type_vehicle.id) as type_count, license_types.type as type'))
        ->whereBetween('license_type_vehicle.license_end_on',[$formated_start,$formated_end])
         ->whereNull('license_type_vehicle.deleted_at')
        ->groupBy('license_types.id')
        ->get();
        /** No. of Vehicles with expired licenses */
         $total_vehicle_with_expired_papers = DB::select(DB::raw("Select count(*) as `total_expired` from (SELECT count(license_type_vehicle.id) AS `count`
							FROM `vehicles`
							INNER JOIN `license_type_vehicle` ON `license_type_vehicle`.`vehicle_id` = `vehicles`.`id`
							WHERE NOW() > `license_type_vehicle`.`license_end_on`
							AND `license_type_vehicle`.`deleted_at` IS NULL
							GROUP BY `license_type_vehicle`.`vehicle_id`) groups"));
        $expired_vehicle_count = $total_vehicle_with_expired_papers[0]->total_expired;
         /** No. of expired licenses */
         $total_expired_licenses = DB::select(DB::raw("Select sum(`count`) as `total_expired` from (SELECT count(license_type_vehicle.id) AS `count`
							FROM `vehicles`
							INNER JOIN `license_type_vehicle` ON `license_type_vehicle`.`vehicle_id` = `vehicles`.`id`
							WHERE NOW() > `license_type_vehicle`.`license_end_on`
							AND `license_type_vehicle`.`deleted_at` IS NULL
							GROUP BY `license_type_vehicle`.`vehicle_id`) groups"));
        $expired_papers_count = $total_expired_licenses[0]->total_expired;
        /** client list */
        $month_end = date("Y-m-01",strtotime("+1 month"));
		$formated_end = date("Y-m-d",strtotime("-1 day", strtotime($month_end)));
        $client_list = DB::select(DB::raw("SELECT count(license_type_vehicle.id) AS `count`, CONCAT(`users`.`first_name`, ' ', `users`.`last_name`) AS `client_name`
							FROM `vehicles`
							INNER JOIN `users` ON `users`.`id` = `vehicles`.`client_id`
							INNER JOIN `license_type_vehicle` ON `license_type_vehicle`.`vehicle_id` = `vehicles`.`id`
							WHERE `license_type_vehicle`.`license_end_on` BETWEEN NOW() AND '{$formated_end}'
							AND `license_type_vehicle`.`deleted_at` IS NULL
							GROUP BY `vehicles`.`client_id`"));

        return view('home.dashboard',compact('client_list','current_month_license_type_expiry_data','expired_papers_count','expired_vehicle_count'));
	}
public function dashboard()
	{
		/** next month expiring license */
		$formated_start = date("Y-m-01",strtotime("+1 month"));
		$next_month_end = date("Y-m-01",strtotime("+2 month"));
		$formated_end = date("Y-m-d",strtotime("-1 day", strtotime($next_month_end)));
		$next_month_license_type_expiry_data = DB::table('license_type_vehicle')
        ->join('license_types', 'license_types.id', '=', 'license_type_vehicle.license_type_id')
        ->select(DB::raw('count(license_type_vehicle.id) as type_count, license_types.type as type'))
        ->whereBetween('license_type_vehicle.license_end_on',[$formated_start,$formated_end])
         ->whereNull('license_type_vehicle.deleted_at')
        ->groupBy('license_types.id')
        ->get();
        /** current month expiring license */
        $formated_start = date("Y-m-01");
		$month_end = date("Y-m-01",strtotime("+1 month"));
		$formated_end = date("Y-m-d",strtotime("-1 day", strtotime($month_end)));
        $current_month_license_type_expiry_data = DB::table('license_type_vehicle')
        ->join('license_types', 'license_types.id', '=', 'license_type_vehicle.license_type_id')
        ->select(DB::raw('count(license_type_vehicle.id) as type_count, license_types.type as type'))
        ->whereBetween('license_type_vehicle.license_end_on',[$formated_start,$formated_end])
         ->whereNull('license_type_vehicle.deleted_at')
        ->groupBy('license_types.id')
        ->get();
        /** No. of Vehicles with expired licenses */
         $total_vehicle_with_expired_papers = DB::select(DB::raw("Select count(*) as `total_expired` from (SELECT count(license_type_vehicle.id) AS `count`
							FROM `vehicles`
							INNER JOIN `license_type_vehicle` ON `license_type_vehicle`.`vehicle_id` = `vehicles`.`id`
							WHERE NOW() > `license_type_vehicle`.`license_end_on`
							AND `license_type_vehicle`.`deleted_at` IS NULL
							GROUP BY `license_type_vehicle`.`vehicle_id`) groups"));
        $expired_vehicle_count = $total_vehicle_with_expired_papers[0]->total_expired;
         /** No. of license with expired licenses */
         $total_expired_licenses = DB::select(DB::raw("Select sum(`count`) as `total_expired` from (SELECT count(license_type_vehicle.id) AS `count`
							FROM `vehicles`
							INNER JOIN `license_type_vehicle` ON `license_type_vehicle`.`vehicle_id` = `vehicles`.`id`
							WHERE NOW() > `license_type_vehicle`.`license_end_on`
							AND `license_type_vehicle`.`deleted_at` IS NULL
							GROUP BY `license_type_vehicle`.`vehicle_id`) groups"));
        $expired_papers_count = $total_expired_licenses[0]->total_expired;
        return view('home.dashboard',compact('next_month_license_type_expiry_data','current_month_license_type_expiry_data','expired_papers_count','expired_vehicle_count'));
	}
}
