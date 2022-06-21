<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class DashboardUserController extends Controller
{
    public function index() {
        return view('dashboard-user.index');
    }
    public function getBiodata() {
        $kabupaten = Regency::where('name', 'like', '%JEMBER%')->first();
        $id_kab = $kabupaten->id;
        $kecamatan = District::where('regency_id', '=', $id_kab)->get();
        $desa = Village::all();
        return view('dashboard-user.biodata', ['kecamatan' => $kecamatan]);
    }
}
