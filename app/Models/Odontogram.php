<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odontogram extends Model
{
    protected $table = 'odontogram';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id');
    }
    public function region()
    {
        return $this->belongsTo('App\Models\Region', 'id_region');
    }
    public function diagnosis()
    {
        return $this->belongsTo('App\Models\Diagnosis', 'diagnosis_id');
    }
}