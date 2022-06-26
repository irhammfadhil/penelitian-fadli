<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    protected $table = 'users_biodata';
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id');
    }
}
