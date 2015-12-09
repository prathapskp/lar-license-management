<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LicenseRenewalRequest extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'license_renewal_requests';
     public $timestamps = false;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['license_type_id', 'vehicle_id', 'requested_on', 'renewed_on', 'status'];

}
