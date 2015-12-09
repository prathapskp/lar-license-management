<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LicenseNotification extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'license_notifications';
     public $timestamps = false;
    protected $fillable = ['license_type_id', 'vehicle_id', 'sent_to', 'sent_on', 'message', 'type'];
}
