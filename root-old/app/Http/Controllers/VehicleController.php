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
class VehicleController extends Controller
{
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
            ->add_column('action', '<a href="'.url('vehicle/edit').'/{{ $id }}">Edit</a>&nbsp;<a href="'.url('vehicle/delete').'/{{ $id }}">Delete</a>&nbsp;<a href="'.url('vehicle/update_license').'/{{ $id }}">Update License</a>')
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
    public function update_license($id) {
        $license_types = Vehicle::findOrFail($id)->license_types->toArray();
        $license_type_arr = array();
         if(!empty($license_types)) {
            foreach ($license_types as $license_type) {
                $license_type_arr[$license_type['id']] =  $license_type['type'];
            }
        }
        $vehicle_id = $id;        
        return view('vehicle.update_license',compact('license_type_arr','vehicle_id'));
    }

    /** calculate and return the expiry date for the selected license start date */
    public function get_expiry_date(Request $request) {
        return date('m/d/Y', strtotime('+365 days',strtotime($request->date))); 
    }

    public function store_license(Request $request) {
        $license_types = LicenseTypeVehicle::where('vehicle_id', $request->vehicle_id)->get();
        foreach ($license_types as $license_type) {
             $start_date = $request->{'license_type_start_'.$license_type->license_type_id};
             $formated_start_date = date('Y-m-d', strtotime($start_date));
             $formated_end_date = date('Y-m-d', strtotime('+365 days',strtotime($start_date)));
             LicenseTypeVehicle::where('id', $license_type->id)
             ->update(['license_start_on' => $formated_start_date, 'license_end_on' => $formated_end_date, 'updated_at' => date("Y-m-d H:i:s")]);
          
        }
        Session::flash('flash_message', trans('vehicle.vehicle_on_update'));
        return Redirect::to('/vehicles');  
    }
}
