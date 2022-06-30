<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biodata;
use App\Models\User;
use App\Models\BiodataOrtu;
use App\Models\Foto;

class DashboardAdminController extends Controller
{
    public function index() {
        return view('dashboard-admin.index');
    }
    public function getAllAnak(){
        $anak = User::where('is_admin', '=', 0)->get();
        return view('dashboard-admin.list-anak', ['anak' => $anak]);
    }
    public function getDetailAnak(Request $request) {
        $user = User::where('id', '=', $request->id)->first();
        $biodata = Biodata::where('users_id', '=', $request->id)->first();
        $ortu = BiodataOrtu::where('users_id', '=', $request->id)->first();
        $foto = Foto::where('users_id', '=', $request->id)->first();
        return view('dashboard-admin.detail-anak', [
            'user' => $user,
            'biodata' => $biodata,
            'ortu' => $ortu,
            'foto' => $foto,
        ]);
    }
}
