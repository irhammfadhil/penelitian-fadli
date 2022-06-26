<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class AjaxController extends Controller
{
    public function getKelurahan (Request $request) {
        $id_district = $request->id_district;
        $kelurahan = Village::where('district_id', '=', $id_district)->get();
        echo "<option value=''>Pilih Desa/Kelurahan</option>";
        foreach($kelurahan as $k){
            echo "<option value='$k->id'>$k->name</option>";
        }
    }
}
