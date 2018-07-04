<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signatory extends Model
{
    protected $fillable = [
        'id_rds',
        'first_name',
        'last_name',
        'email',
        'company',
        'has_signed',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function rds() {
        return $this->belongsTo('App\RDS', 'id_rds', 'id');
    }
}


