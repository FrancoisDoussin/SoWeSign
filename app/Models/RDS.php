<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RDS extends Model
{
    protected $table = 'rds';

    protected $fillable = [
        'name',
        'description',
        'date',
        'place',
        'file_path',
        'invitation_subject',
        'invitation_delay',
        'invitation_frequence',
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
        return $this->hasMany('App\Signatory');
    }
}
