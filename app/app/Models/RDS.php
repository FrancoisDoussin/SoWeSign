<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RDS extends Model
{
    protected $table = 'rds';

    // auto load signatories when fetching model
    protected $with = array('signatories');

    protected $fillable = [
        'subject',
        'description',
        'date',
        'place',
        'url',
        'file_name',
        'invitation_subject',
        'invitation_description',
        'invitation_delay',
        'invitation_frequency',
        'invitation_quantity',
        'admin_first_name',
        'admin_last_name',
        'admin_email',
        'url_one_hash',
        'url_two_hash',
        'url_three_hash',
    ];

    protected $dates = [
        'date',
        'created_at',
        'updated_at'
    ];

    public function signatories() {
        return $this->hasMany('App\Models\Signatory', 'id_rds', 'id');
    }
}
