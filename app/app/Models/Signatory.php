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
        'tag_number',
        'has_signed',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'has_signed' => 'boolean'
    ];

    public function rds() {
        return $this->belongsTo('App\Models\RDS', 'id_rds', 'id');
    }
}


