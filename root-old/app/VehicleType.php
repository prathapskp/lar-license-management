<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleType extends Model
{
    /** perform soft delete */
    use SoftDeletes;
    protected $dates = ['deleted_at'];

     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vehicle_types';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type'];

    //**get the vehcile types associated with the license type. */

     
    public function license_types()
    {
        return $this->belongsToMany('App\LicenseType');
    }

    /**
     * define the vehicle relation
     * 
     */
    public function vehicle()
    {
        return $this->hasMany('App\Vehicle');
    }


}
