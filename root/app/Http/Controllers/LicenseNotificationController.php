<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail, DB;
//use App\ExternalLibraries\Twilio;
class LicenseNotificationController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notify() {
       
        /*Mail::send('emails.reminder', ['testVar' => 'Just a silly test'], function ($message) {
            $message->to('prathap.srishtis@gmail.com')->subject('A simple test');
        });*/
        global $data;
        /*$data = array( 'email' => 'prathap.srishtis@gmail.com', 'first_name' => 'Lar', 'from' => 'pratap@nextsoftwaresolutions.com', 'from_name' => 'Vel', 'testVar' => 'dai prathap!' );

        Mail::queue( 'emails.reminder', $data, function( $message )
        {
            global $data;
            $message->to( $data['email'] )->from( $data['from'], $data['first_name'] )->subject( 'Welcome!' );
        });*/
        $data = array( 'email' => 'prathap.srishtis@gmail.com', 'first_name' => 'Lar', 'from' => 'pratap@nextsoftwaresolutions.com', 'from_name' => 'Vel', 'content' => 'dai prathap!' );
        Mail::queueOn('notification-queue', 'emails.reminder', $data, function ($message) {
            global $data;
            $message->to( $data['email'] )->from( $data['from'], $data['first_name'] )->subject( 'Welcome!' );
        });

        /*if (count(Mail::failures()) > 0) {
            
            echo "There was one or more failures. They were: <br />";
            
            foreach (Mail::failures as $email_address) {
                echo " - $email_address <br />";
            }
        } 
        else {
            echo "No errors, all sent successfully!";
        }*/
        
        // 30 days notification.
        $results = DB::select(DB::raw("select `users`.`email` as email,`license_type_vehicle`.`license_type_id`, `license_type_vehicle`.`vehicle_id`, `vehicles`.`client_id`, `vehicles`.`plate_number`, `license_types`.`type` from `license_type_vehicle` inner join `vehicles` on `vehicles`.`id` = `license_type_vehicle`.`vehicle_id` inner join `license_types` on `license_types`.`id` = `license_type_vehicle`.`license_type_id` inner join `users` on `users`.`id` = `vehicles`.`client_id` where `license_type_vehicle`.`license_end_on` = CURDATE()+INTERVAL 30 DAY AND `license_type_vehicle`.`deleted_at` is null"));
        
        // where `license_type_vehicle`.`license_end_on` = CURDATE()+INTERVAL 30 DAY
        /*
        
        */
        $insert_data = array();
        if (!empty($results)) {
            foreach ($results as $value) {             
                $message = "License {$value->type} for the vehicle no {$value->plate_number} is going to expire in next 30 days";
                $insert_data[] = array('license_type_id' => $value->license_type_id, 'vehicle_id' => $value->vehicle_id, 'sent_to' => $value->client_id, 'sent_on' => date("Y-m-d H:i:s"), 'message' => $message, 'type' => 'expiry');
                $data = array( 'email' => $value->email, 'name' => 'eazypapers', 'from' => 'pratap@nextsoftwaresolutions.com', 'content' => $message );
                Mail::laterOn('notification-queue', 5, 'emails.reminder', $data, function ($message) {
                    global $data;
                    $message->to( $data['email'] )->from( $data['from'], $data['name'] )->subject( 'Reminder Notification' );
                });
            }
            //DB::table('license_notifications')->insert($insert_data);
        }
        exit;
        // 15 days notification.
        $results = DB::select(DB::raw("select `users`.`email` as email,`license_type_vehicle`.`license_type_id`, `license_type_vehicle`.`vehicle_id`, `vehicles`.`client_id`, `vehicles`.`plate_number`, `license_types`.`type` from `license_type_vehicle` inner join `vehicles` on `vehicles`.`id` = `license_type_vehicle`.`vehicle_id` inner join `license_types` on `license_types`.`id` = `license_type_vehicle`.`license_type_id` inner join `users` on `users`.`id` = `vehicles`.`client_id` where `license_type_vehicle`.`license_end_on` = CURDATE()+INTERVAL 15 DAY"));
        
        $insert_data = array();
        if (!empty($results)) {
            foreach ($results as $value) {
                $message = "License {$value->type} for the vehicle no {$value->plate_number} is going to expire in next 30 days";
                $insert_data[] = array('license_type_id' => $value->license_type_id, 'vehicle_id' => $value->vehicle_id, 'sent_to' => $value->client_id, 'sent_on' => date("Y-m-d H:i:s"), 'message' => $message, 'type' => 'expiry');
                $data = array( 'email' => $value->email, 'name' => 'eazypapers', 'from' => 'pratap@nextsoftwaresolutions.com', 'content' => $message );
                Mail::laterOn('notification-queue', 5, 'emails.reminder', $data, function ($message) {
                    global $data;
                    $message->to( $data['email'] )->from( $data['from'], $data['name'] )->subject( 'Reminder Notification' );
                });
            }
            DB::table('license_notifications')->insert($insert_data);
        }
        
        // 7 days notification.
        $results = DB::select(DB::raw("select `users`.`email` as email,`license_type_vehicle`.`license_type_id`, `license_type_vehicle`.`vehicle_id`, `vehicles`.`client_id`, `vehicles`.`plate_number`, `license_types`.`type` from `license_type_vehicle` inner join `vehicles` on `vehicles`.`id` = `license_type_vehicle`.`vehicle_id` inner join `license_types` on `license_types`.`id` = `license_type_vehicle`.`license_type_id` inner join `users` on `users`.`id` = `vehicles`.`client_id` where `license_type_vehicle`.`license_end_on` = CURDATE()+INTERVAL 7 DAY"));
        
        $insert_data = array();
        if (!empty($results)) {
            foreach ($results as $value) {
                $message = "License {$value->type} for the vehicle no {$value->plate_number} is going to expire in next 30 days";
                $insert_data[] = array('license_type_id' => $value->license_type_id, 'vehicle_id' => $value->vehicle_id, 'sent_to' => $value->client_id, 'sent_on' => date("Y-m-d H:i:s"), 'message' => $message, 'type' => 'expiry');
                $data = array( 'email' => $value->email, 'name' => 'eazypapers', 'from' => 'pratap@nextsoftwaresolutions.com', 'content' => $message );
                Mail::laterOn('notification-queue', 5, 'emails.reminder', $data, function ($message) {
                    global $data;
                    $message->to( $data['email'] )->from( $data['from'], $data['name'] )->subject( 'Reminder Notification' );
                });
            }
            DB::table('license_notifications')->insert($insert_data);
        }       
        
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        
        //
        
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        
        //
        
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        
        //
        
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        
        //
        
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        
        //
        
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        
        //
        
    }
}
