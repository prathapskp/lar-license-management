<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LicenseTypeVehicle extends Model
{
	 protected $table = 'license_type_vehicle';
     /** perform soft delete */
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
