<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\SoftDeletes;
class LicenseType extends Model
{
      /** perform soft delete */
    use SoftDeletes;
    protected $dates = ['deleted_at'];

     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'license_types';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type'];

    /**get the vehcile types associated with the license type. */
    public function vehicle_types()
    {
        return $this->belongsToMany('App\VehicleType');
    }
     /**get the vehciles associated with the license type. */
    public function vehicles()
    {
        return $this->belongsToMany('App\Vehicle');
    }

}
