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
use App\Models\Article;

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
        //$region_gigi = Region::all();
        //$diagnosis = Diagnosis::all();
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
        //$odontogram = Odontogram::where('users_id', '=', $request->id)->orderBy('id_gigi')->get();
        $sum_decay = Diagnosis::where('users_id', '=', $request->id)->where('is_decay', '=', 1)->count();
        $sum_missing = Diagnosis::where('users_id', '=', $request->id)->where('is_missing', '=', 1)->count();
        $sum_filling = Diagnosis::where('users_id', '=', $request->id)->where('is_filling', '=', 1)->count();

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
            'sum_decay' => $sum_decay,
            'sum_missing' => $sum_missing,
            'sum_filling' => $sum_filling,
            //'region' => $region_gigi,
            //'diagnosis' => $diagnosis,
            //'odontogram' => $odontogram
        ]);
    }
    public function submitOdontogram(Request $request) {
        $users_id = $request->usersId;
        $gigi = $request->gigi;
        $decay = $request->has('decay');
        $missing = $request->has('missing');
        $filling = $request->has('filling');

        if(!$decay) {
            $decay = 0;
        }

        if(!$missing) {
            $missing = 0;
        }
        
        if(!$filling) {
            $filling = 0;
        }

        $data = Diagnosis::where('users_id', '=', $users_id)->where('id_gigi', '=', $gigi)->first();
        if(!$data) {
            $data = new Diagnosis;
        }
        $data->users_id = $users_id;
        $data->id_gigi = $gigi;
        $data->is_decay = $decay;
        $data->is_missing = $missing;
        $data->is_filling = $filling;
        $data->save();

        #itung dmft
        ##gigi tetap
        $sum_decay_tetap = Diagnosis::where('users_id', '=', $users_id)->where('is_decay', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
        $sum_missing_tetap = Diagnosis::where('users_id', '=', $users_id)->where('is_missing', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
        $sum_filling_tetap = Diagnosis::where('users_id', '=', $users_id)->where('is_filling', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
        ##gigi susu
        $sum_decay_susu = Diagnosis::where('users_id', '=', $users_id)->where('is_decay', '=', 1)->whereBetween('id_gigi', [51,85])->count();
        $sum_missing_susu = Diagnosis::where('users_id', '=', $users_id)->where('is_missing', '=', 1)->whereBetween('id_gigi', [51,85])->count();
        $sum_filling_susu = Diagnosis::where('users_id', '=', $users_id)->where('is_filling', '=', 1)->whereBetween('id_gigi', [51,85])->count();

        $dmftIndex = $sum_decay_tetap + $sum_missing_tetap + $sum_filling_tetap;
        $deftIndex = $sum_decay_susu + $sum_missing_susu + $sum_filling_susu;

        $users = User::where('id', '=', $users_id)->first();
        $users->dmft_score = $dmftIndex;
        $users->deft_score = $deftIndex;
        $users->save();

        $url = '/daftar-anak/detail?id='.$users_id;

        return redirect($url);
    }
    public function getAllArticle() {
        $article = Article::all();
        return view('dashboard-admin.list-artikel', [
            'article' => $article,
        ]);
    }
}
