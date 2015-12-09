<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    /** perform soft delete */
    use SoftDeletes;
    protected $dates = ['deleted_at'];

     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vehicles';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['plate_number', 'vehicle_type_id', 'client_id', 'registration_number', 'owner_name', 'owner_email', 'owner_phone', 'location', 'chassis_number'];

    
    /**
     * define the vehicle type relation
     * 
     */
    public function vehicle_type()
    {
        return $this->belongsTo('App\VehicleType');
    }
    /**
     * define the client relation
     * 
     */
    public function clients()
    {
        return $this->belongsTo('App\User','id','client_id');
    }

     /**get the license types associated with the vehicle. */

    public function license_types()
    {
        return $this->belongsToMany('App\LicenseType')
                ->whereNull('license_type_vehicle.deleted_at');
    }


}
