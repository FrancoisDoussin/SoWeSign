<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signatory extends Model
{
    protected $fillable = [
        'id_rds',
        'firstname',
        'lastname',
        'email',
        'company',
        'url_hash',
        'sign_coord',
        'sign_name',
        'tag_number',
        'has_signed',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'has_signed' => 'boolean',
        'sign_coord' => 'array'
    ];

    public function getCoordAttribute() {
       return json_decode($this->sign_coord);
    }

    public function rds() {
        return $this->belongsTo('App\Models\RDS', 'id_rds', 'id');
    }
}


