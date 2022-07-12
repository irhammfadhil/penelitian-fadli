<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biodata;
use App\Models\User;
use App\Models\BiodataOrtu;
use App\Models\Foto;
use App\Models\Region;
use App\Models\Diagnosis;
use App\Models\Odontogram;

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
        $region_gigi = Region::all();
        $diagnosis = Diagnosis::all();
        //id gigi
        $id_gigi = ['11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '31', '32', '33', '34', '35', '36', '37', '38', '41', '42', '43', '44', '45', '46', '47', '48',
        '51', '52', '53', '54', '55', '61', '62', '63', '64', '65', '71', '72', '73', '74', '75', '81', '82', '83', '84', '85'];
        //gigi tetap
        $id_gigi_tetap_kiri_atas = ['11', '12', '13', '14', '15', '16', '17', '18'];
        $id_gigi_tetap_kanan_atas = ['21', '22', '23', '24', '25', '26', '27', '28'];
        $id_gigi_tetap_kiri_bawah = [ '41', '42', '43', '44', '45', '46', '47', '48'];
        $id_gigi_tetap_kanan_bawah = ['31', '32', '33', '34', '35', '36', '37', '38'];
        //giggi sulung
        $id_gigi_sulung_kiri_atas = ['51', '52', '53', '54', '55'];
        $id_gigi_sulung_kanan_atas = ['61', '62', '63', '64', '65'];
        $id_gigi_sulung_kanan_bawah = ['71', '72', '73', '74', '75'];
        $id_gigi_sulung_kiri_bawah = ['81', '82', '83', '84', '85'];
        $odontogram = Odontogram::where('users_id', '=', $request->id)->orderBy('id_gigi')->get();

        return view('dashboard-admin.detail-anak', [
            'user' => $user,
            'biodata' => $biodata,
            'ortu' => $ortu,
            'foto' => $foto,
            'id_gigi' => $id_gigi,
            'id_gigi_tetap_kiri_atas' => $id_gigi_tetap_kiri_atas,
            'id_gigi_tetap_kanan_atas' => $id_gigi_tetap_kanan_atas,
            'id_gigi_tetap_kiri_bawah' => $id_gigi_tetap_kiri_bawah,
            'id_gigi_tetap_kanan_bawah' => $id_gigi_tetap_kanan_bawah,
            'id_gigi_sulung_kiri_atas' => $id_gigi_sulung_kiri_atas,
            'id_gigi_sulung_kanan_atas' => $id_gigi_sulung_kanan_atas,
            'id_gigi_sulung_kanan_bawah' => $id_gigi_sulung_kanan_bawah,
            'id_gigi_sulung_kiri_bawah' => $id_gigi_sulung_kiri_bawah,
            'region' => $region_gigi,
            'diagnosis' => $diagnosis,
            'odontogram' => $odontogram
        ]);
    }
    public function submitOdontogram(Request $request) {
        $users_id = $request->usersId;
        $gigi = $request->gigi;
        $regio = $request->regio;
        $diagnosis = $request->diagnosis;
        $catatan = $request->catatan;

        $data = new Odontogram;
        $data->users_id = $users_id;
        $data->id_gigi = $gigi;
        $data->id_region = $regio;
        $data->diagnosis_id = $diagnosis;
        $data->note = $catatan;
        $data->save();

        $url = '/daftar-anak/detail?id='.$users_id;
        return redirect($url);
    }
}
