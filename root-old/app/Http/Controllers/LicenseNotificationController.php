<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail, DB;

class LicenseNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notify()
    {
         /*$data = DB::select(DB::raw("SELECT license_type_id from `license_type_vehicle` where CURDATE()+INTERVAL 31 DAY =`license_end_on`"));
         if(!empty($result)) {
            $data = array('license_type_id' => ,$result->license_type_id, 'vehicle_id' => $result->vehicle_id, '' );
         }
         DB::table('users')->insert([
            ['email' => 'taylor@example.com', 'votes' => 0],
            ['email' => 'dayle@example.com', 'votes' => 0]
        ]);*/
        $results = DB::table('license_type_vehicle')
            ->join('vehicles', 'vehicles.id', '=', 'license_type_vehicle.vehicle_id')            
            ->select('license_type_vehicle.license_type_id', 'license_type_vehicle.vehicle_id','vehicles.client_id')
             ->where( 'license_type_vehicle.license_end_on', '=','CURDATE()+INTERVAL 30 DAY')
            ->get();
        print_r($results);
       /* Mail::send('emails.welcome', ['key' => 'value'], function($message)
        {
            $message->to('pratap@nextsoftwaresolutions.com', 'John Smith')->subject('Welcome!');
        });*/
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
