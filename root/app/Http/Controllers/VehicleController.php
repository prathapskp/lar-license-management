<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator, Input, Redirect, Auth, Session, Response, DB,Datatables;
use App\VehicleType;
use App\Vehicle;
use App\User;
use App\LicenseTypeVehicle;
use App\LicenseRenewalRequest;
use App\LicenseNotification;
class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vehicle.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicle_types = VehicleType::all()->toArray();
        $clients = User::select('id','first_name','last_name')->where('user_role','=','2')->get()->toArray();
      
        $client_options = array();
        if(!empty($clients)) {
            foreach ($clients as $client) {
                $client_options[$client['id']] = $client['first_name']." ".$client['last_name'];
            }
        }
        $vehicle_type_options = array();
         if(!empty($vehicle_types)) {
            foreach ($vehicle_types as $vehicle_type) {
                $vehicle_type_options[$vehicle_type['id']] = $vehicle_type['type'];
            }
         }      
         $license_type_options = array();
        return view('vehicle.create',compact('vehicle_type_options', 'license_type_options','client_options'));
    }
    /** passing data for datatables. */
    public function ajax_data() {
            $rows = DB::table('vehicles')
            ->select(DB::raw('id, plate_number, registration_number, owner_name, owner_email, owner_phone, created_at'))
            ->whereNull('deleted_at');
            

        return Datatables::of($rows)
            ->add_column('action', '<a href="'.url('vehicle/edit').'/{{ $id }}">Edit</a>&nbsp;<a href="'.url('vehicle/delete').'/{{ $id }}">Delete</a>&nbsp;<a href="'.url('vehicle/update-license').'/update/{{ $id }}">Update License</a>')
            ->make(true);
    }
    /** license types based on vehicle type selection. */
    public function ajax_get_license_types($id) {
        $license_types = VehicleType::find($id)->license_types->toArray();
         $option = array();
         foreach ($license_types as $license_type) {
            $option[$license_type['id']] = $license_type['type'];
        }
       $data['option'] = $option;
        return $data;

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array('plate_number' => 'required|unique:vehicles',
            'vehicle_type_id' => 'required',
            'license_type_id' => 'required');
        $messages = [
            'plate_number.required' => trans('vehicle.plate_number_error_message'),
            'vehicle_type_id.required' => trans('vehicle.vehicle_type_error_message'),
            'license_type_id.required' => trans('vehicle.license_type_error_message'),
        ];
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();          
        }        
        $license_types = $request->license_type_id; 
        if(empty($license_types[0])) {
            return redirect()->back()->with('error', 'Atleast select one license type');
        }           
        $model = Vehicle::create($request->all()); 
        foreach ($license_types as $license_type) {
            $model1 = new LicenseTypeVehicle;           
            $model1->license_type_id = $license_type;
            $model1->vehicle_id = $model->id;
            $model1->save();
        }
        Session::flash('flash_message', trans('vehicle.vehicle_on_create'));
        return Redirect::to('/vehicles');
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $license_types = VehicleType::find($vehicle->vehicle_type_id)->license_types->toArray();
        $vehicle_types = VehicleType::all()->toArray();
        $vehicle_type_options = array();
         if(!empty($vehicle_types)) {
            foreach ($vehicle_types as $vehicle_type) {
                $vehicle_type_options[$vehicle_type['id']] = $vehicle_type['type'];
            }
         }   
        $license_type_options = array();
         if(!empty($license_types)) {
            foreach ($license_types as $license_type) {
            $license_type_options[$license_type['id']] = $license_type['type'];
        }
         }
        $clients = User::select('id','first_name','last_name')->where('user_role','=','2')->get()->toArray();
      
        $client_options = array();
        if(!empty($clients)) {
            foreach ($clients as $client) {
                $client_options[$client['id']] = $client['first_name']." ".$client['last_name'];
            }
        }
        $license_type_arr = array();
        $license_types = Vehicle::find($id)->license_types->toArray();
        if(!empty($license_types)) {
            foreach ($license_types as $license_type) {
                $license_type_arr[] =  $license_type['id'];
            }
        }
        return view('vehicle.update',compact('vehicle', 'vehicle_type_options','license_type_options', 'client_options', 'license_type_arr'));
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
        $vehicle = Vehicle::findOrFail($id);   // check and exit if user not present

        $rules = array('plate_number' => 'required|unique:vehicles,plate_number,'.$request->id,
            'vehicle_type_id' => 'required',
            'license_type_id' => 'required');
        $messages = [
            'plate_number.required' => trans('vehicle.plate_number_error_message'),
            'vehicle_type_id.required' => trans('vehicle.vehicle_type_error_message'),
            'license_type_id.required' => trans('vehicle.license_type_error_message'),
        ];
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();                      
        } 
        $license_types_arr = $request->license_type_id; 
        if(empty($license_types_arr[0])) {
            return redirect()->back()->with('error', 'Atleast select one license type');
        }
        $vehicle_id = $request->id;  
        // validate all the required fields
        $vehicle->fill($request->all())->save();

        //DB::delete("DELETE FROM license_type_vehicle WHERE license_type_id NOT IN  ( '" . implode($license_types_arr, "', '") . "' ) AND vehicle_id = $vehicle_id"); 
        DB::update("UPDATE license_type_vehicle SET deleted_at=NOW() WHERE license_type_id NOT IN  ( '" . implode($license_types_arr, "', '") . "' ) AND vehicle_id = $vehicle_id"); 
        $values_arr = array();
       if(!empty($license_types_arr))
            foreach ($license_types_arr as $license_type_id) {
                $values_arr[] = "('$license_type_id', '$vehicle_id')";
            }
        // from db
       /* $selected_license_type_arr = VehicleType::find($vehicle->vehicle_type_id)->license_types->toArray();
        $license_type_options = array();
         if(!empty($selected_license_type_arr)) {
            foreach ($selected_license_type_arr as $selected_license_type) {
                if(!in_array($selected_license_type['id'], ))
            $license_type_options[$selected_license_type['id']] = $selected_license_type['type'];
            }
        }*/
        DB::insert("INSERT IGNORE INTO license_type_vehicle (license_type_id,vehicle_id) VALUES ".implode(", ", $values_arr));
        
        Session::flash('flash_message', trans('vehicle.vehicle_on_update'));
        return Redirect::to('/vehicles');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Vehicle::findOrFail($id);
        $model->delete();
        Session::flash('flash_message', trans('vehicle.vehicle_on_delete'));
        return redirect()->back();
    }
    /**  */
    public function update_license($page_type, $id) {       
        $license_types = DB::table('license_types')
            ->join('license_type_vehicle','license_types.id', '=', 'license_type_vehicle.license_type_id')
            ->select('license_types.id as license_type_id','license_types.type', 'license_type_vehicle.license_start_on', 'license_type_vehicle.license_end_on')
            ->where('license_type_vehicle.vehicle_id','=',$id)
            ->whereNull('license_type_vehicle.deleted_at')
            ->get();          
        $vehicle_id = $id; 
      $renewal_request = DB::select(DB::raw("SELECT vehicle_id, license_type_id, status FROM( SELECT * FROM `license_renewal_requests` WHERE vehicle_id={$id} ORDER BY requested_on DESC) as inv GROUP BY license_type_id,vehicle_id"));
      $request = array();
      if(!empty($renewal_request)) {
        foreach ($renewal_request as $value) {
            $request[$value->license_type_id] = $value->status;
        }
      }       
      if($page_type == 'renewal')
            return view('vehicle.renewal_license',compact('license_types','vehicle_id','request'));
    elseif ($page_type == 'update') 
        return view('vehicle.update_license',compact('license_types','vehicle_id','request'));
    
    }

    /** calculate and return the expiry date for the selected license start date */
    public function get_expiry_date(Request $request) {
        return date('m/d/Y', strtotime('+365 days',strtotime($request->date))); 
    }
    /** store vehicles license */
    public function store_license(Request $request) {
        $license_types = LicenseTypeVehicle::where('vehicle_id', $request->vehicle_id)->get();
        $vehicle = Vehicle::select('plate_number','client_id')->findOrFail($request->vehicle_id); 
        $cur_date = date("Y-m-d H:i:s");
        foreach ($license_types as $license_type) {
            $license_type_id = $license_type->license_type_id;
            if(isset($request->{'status_'.$license_type_id})) {
                $save = LicenseRenewalRequest::where('license_type_id','=',$license_type->license_type_id)
                ->where('vehicle_id','=',$request->vehicle_id)
                ->where('status','!=',$request->{'status_'.$license_type_id})
                ->update(['status' => $request->{'status_'.$license_type_id}]);
                //update renewal request where there is chnage in the status.
                
        
                 if($save) { // create notification.
                    switch ($request->{'status_'.$license_type_id}) {
                        case 'pending':
                            $status = "The renewal request for the vehicle {$vehicle->plate_number} status has marked pending";
                            $type = "renewal_request";
                            break;
                        case 'in-progress':
                            $status = "Your renewal request for the vehicle {$vehicle->plate_number} is in progress";
                            $type = "renewal_request";
                            break;
                        case 'completed':
                            $status = "Your renewal request for the vehicle {$vehicle->plate_number} has completed";
                            $type = "renewal_completed";
                            break;
                    }
                    $input_data = array('sent_to' => $vehicle->client_id, 'sent_on' => $cur_date, 'message' => $status, 'type' => $type);
                    LicenseNotification::create($input_data);

                 }
                 //
                
            }
                global $formated_start_date;
                $start_date = $request->{'license_type_start_'.$license_type->license_type_id};
                $formated_start_date = date('Y-m-d', strtotime($start_date));
                
                $formated_end_date = date('Y-m-d', strtotime('+365 days',strtotime($start_date)));
                $saved_license = LicenseTypeVehicle::where('vehicle_id', $request->vehicle_id)
                ->where('license_type_id', $license_type_id)
                ->where(function ($query) {
                    global $formated_start_date;
                $query->where('license_start_on', '=', $formated_start_date)
                      ->orWhere('license_start_on', '=', '0000-00-00 00:00:00');
                })
                ->get()->toArray();
               
                // check the form license date with the db license date
                if(empty($saved_license)) { // license date has changed
                    LicenseTypeVehicle::where('id', $license_type->id)
             ->update(['deleted_at' => date("Y-m-d H:i:s")]);
                    $insert_data = array('license_type_id' => $license_type->license_type_id, 'vehicle_id' => $request->vehicle_id,'license_start_on' => $formated_start_date, 'license_end_on' => $formated_end_date);
                    LicenseTypeVehicle::create($insert_data);
                    //soft delete the previous license date
                    //insert the new date

                }else {
                     LicenseTypeVehicle::where('id', $license_type->id)
             ->update(['license_start_on' => $formated_start_date, 'license_end_on' => $formated_end_date]);
               }
           
            /* $start_date = $request->{'license_type_start_'.$license_type->license_type_id};
             $formated_start_date = date('Y-m-d', strtotime($start_date));
             $formated_end_date = date('Y-m-d', strtotime('+365 days',strtotime($start_date)));
             LicenseTypeVehicle::where('id', $license_type->id)
             ->update(['license_start_on' => $formated_start_date, 'license_end_on' => $formated_end_date, 'updated_at' => date("Y-m-d H:i:s")]);
          */
        }
        Session::flash('flash_message', trans('vehicle.vehicle_on_update'));
        return Redirect::to($request->redirect_to);  
    }

     /** vehicle license renewal request view */ 
    public function renewal_request($id) {
        $check = Vehicle::findOrFail($id);
     
        $vehicle = DB::table('vehicles')
            ->join('vehicle_types', 'vehicle_types.id', '=', 'vehicles.vehicle_type_id')           
            ->select('vehicles.*', 'vehicle_types.type')
            ->where('vehicles.id',$id)
            ->first();
    /* $license_types = DB::table('license_types')
            ->join('license_type_vehicle','license_types.id', '=', 'license_type_vehicle.license_type_id')
            ->leftJoin('license_renewal_requests', 'license_type_vehicle.license_type_id', '=', 'license_renewal_requests.license_type_id')
            ->select('license_types.id as license_type_id','license_types.type', 'license_type_vehicle.license_start_on', 'license_type_vehicle.license_end_on','license_type_vehicle.id as license_type_vehicle_id','license_renewal_requests.status')
            ->where('license_type_vehicle.vehicle_id','=',$id)
            ->whereNull('license_type_vehicle.deleted_at')
            ->get();*/
        $license_types = DB::table('license_types')
            ->join('license_type_vehicle','license_types.id', '=', 'license_type_vehicle.license_type_id')
            ->select('license_types.id as license_type_id','license_types.type', 'license_type_vehicle.license_start_on', 'license_type_vehicle.license_end_on')
            ->where('license_type_vehicle.vehicle_id','=',$id)
            ->whereNull('license_type_vehicle.deleted_at')           
            ->get();    
               
     $renewal_request = DB::select(DB::raw("SELECT vehicle_id, license_type_id, status FROM( SELECT * FROM `license_renewal_requests` WHERE vehicle_id={$id} ORDER BY requested_on DESC) as inv GROUP BY license_type_id,vehicle_id"));
      $request = array();
      if(!empty($renewal_request)) {
        foreach ($renewal_request as $value) {
            $request[$value->license_type_id] = $value->status;
        }
      }
      return view('vehicle.renewal_request',compact('vehicle','license_types','request'));      
    }

    /** create a renewal request */
    public function create_renewal_request(Request $request) {
        /*if(empty($request->license_type_vehicle_id)) {
             return redirect()->back()->with('error', trans('vehicle.request_renewal_error'));
        }*/
        $cur_date = date("Y-m-d H:i:s");
        $input_data = array('vehicle_id' => $request->vehicle_id,'license_type_id' => $request->license_type_id, 'requested_on' => $cur_date, 'status' => 'pending');

        LicenseRenewalRequest::create($input_data);
        $input_data = array('sent_to' => 0, 'sent_on' => $cur_date, 'message' => 'A renewal request has recieved', 'type' => 'renewal_request');
        LicenseNotification::create($input_data);
        Session::flash('flash_message', trans('vehicle.license_renewal_request'));
        return redirect()->back();       

    }
/** list the vehicles waiting for renewal. */
    public function renewal_listing() {
         return view('vehicle.renewal_listing');
    }

     /** passing data for datatables. */
    public function renewal_listing_ajax_data() {
            $rows = DB::table('vehicles')
            ->join('license_type_vehicle','vehicles.id', '=', 'license_type_vehicle.vehicle_id')
            ->join('license_renewal_requests','license_renewal_requests.vehicle_id', '=', 'vehicles.id')
            ->select(DB::raw('vehicles.*'))
            ->whereNull('vehicles.deleted_at')
            ->groupBy('vehicles.id');            

        return Datatables::of($rows)
            ->add_column('action', '<a href="'.url('vehicle/renew-license').'/renewal/{{ $id }}">Renew License</a>')
            ->make(true);
    }
}
