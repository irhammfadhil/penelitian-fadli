<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiodataOrtu extends Model
{
    protected $table = 'users_ortu';
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id');
    }
}
