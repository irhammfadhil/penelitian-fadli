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
        #itung dmft
        ##gigi tetap
        $sum_decay_tetap = Diagnosis::where('users_id', '=', $request->id)->where('is_decay', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
        $sum_missing_tetap = Diagnosis::where('users_id', '=', $request->id)->where('is_missing', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
        $sum_filling_tetap = Diagnosis::where('users_id', '=', $request->id)->where('is_filling', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
        ##gigi susu
        $sum_decay_susu = Diagnosis::where('users_id', '=', $request->id)->where('is_decay', '=', 1)->whereBetween('id_gigi', [51,85])->count();
        $sum_missing_susu = Diagnosis::where('users_id', '=', $request->id)->where('is_missing', '=', 1)->whereBetween('id_gigi', [51,85])->count();
        $sum_filling_susu = Diagnosis::where('users_id', '=', $request->id)->where('is_filling', '=', 1)->whereBetween('id_gigi', [51,85])->count();

        #kriteria DMFT (Yulia et al., 2013)
        $kriteria_dmft = '';
        $kriteria_deft = '';
        if($user->dmft_score >= 0 && $user->dmft_score <= 1.1) {
            $kriteria_dmft = 'Sangat Rendah';
        }
        else if ($user->dmft_score > 1.1 && $user->dmft_score <= 2.6) {
            $kriteria_dmft = 'Rendah';
        }
        else if ($user->dmft_score > 2.6 && $user->dmft_score <= 4.4) {
            $kriteria_dmft = 'Sedang';
        }
        else if ($user->dmft_score > 4.4 && $user->dmft_score <= 6.5) {
            $kriteria_dmft = 'Tinggi';
        }
        else if ($user->dmft_score > 6.5) {
            $kriteria_dmft = 'Sangat Tinggi';
        }
        #kriteria DEFT (Yulia et al., 2013)
        if($user->deft_score >= 0 && $user->deft_score <= 1.1) {
            $kriteria_deft = 'Sangat Rendah';
        }
        else if ($user->deft_score > 1.1 && $user->deft_score <= 2.6) {
            $kriteria_deft = 'Rendah';
        }
        else if ($user->deft_score > 2.6 && $user->deft_score <= 4.4) {
            $kriteria_deft = 'Sedang';
        }
        else if ($user->deft_score > 4.4 && $user->deft_score <= 6.5) {
            $kriteria_deft = 'Tinggi';
        }
        else if ($user->deft_score > 6.5) {
            $kriteria_deft = 'Sangat Tinggi';
        }

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
            'sum_decay_tetap' => $sum_decay_tetap,
            'sum_missing_tetap' => $sum_missing_tetap,
            'sum_filling_tetap' => $sum_filling_tetap,
            'sum_decay_susu' => $sum_decay_susu,
            'sum_missing_susu' => $sum_missing_susu,
            'sum_filling_susu' => $sum_filling_susu,
            'kriteria_dmft' => $kriteria_dmft,
            'kriteria_deft' => $kriteria_deft,
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
    public function getNewArticle() {
        return view('dashboard-admin.artikel.new');
    }
    public function submitNewArticle(Request $request) {
        $this->validate($request, [
            'file' => 'file',
    	]);
        $title = $request->title;
        $deskripsi = $request->deskripsi;
        $file = $request->file('file');

        $fileName = NULL;
        $base_file_name = NULL;

        if($file) {
            $rand = substr(md5(microtime()), 0, 10);
            $fileName = 'artikel/'.$rand.'_'.$file->getClientOriginalName();
            $base_file_name = $rand.'_'.$file->getClientOriginalName();
            $file->move(public_path('artikel/'), $fileName);
        }

        $url = str_replace(" ", "-", strtolower($title));

        $artikel = new Article;
        $artikel->title = $title;
        $artikel->text = $deskripsi;
        $artikel->image = $fileName;
        $artikel->link = $url;
        $artikel->save();

        return redirect('/admin/artikel');
    }
    public function getEditArticle(Request $request) {
        $artikel = Article::find($request->id);

        return view('dashboard-admin.artikel.edit', ['article' => $artikel]);
    }
    public function submitEditArticle(Request $request) {
        $this->validate($request, [
            'file' => 'file',
    	]);
        $title = $request->title;
        $deskripsi = $request->deskripsi;
        $file = $request->file('file');

        $fileName = NULL;
        $base_file_name = NULL;

        if($file) {
            $rand = substr(md5(microtime()), 0, 10);
            $fileName = 'artikel/'.$rand.'_'.$file->getClientOriginalName();
            $base_file_name = $rand.'_'.$file->getClientOriginalName();
            $file->move(public_path('artikel/'), $fileName);
        }

        $url = str_replace(" ", "-", strtolower($title));

        $artikel = Article::find($request->id);
        $artikel->title = $title;
        $artikel->text = $deskripsi;
        if($file) {
            $artikel->image = $fileName;
        }
        $artikel->link = $url;
        $artikel->save();

        return redirect('/admin/artikel');
    }
    public function deleteArticle(Request $request) {
        $artikel = Article::find($request->id);
        $artikel->delete();

        return redirect('/admin/artikel');
    }
    public function inputKomentarFotoAdmin (Request $request) {
        $id = $request->id;
        $komentar_foto = $request->komentar_foto;
        $status_persetujuan = 0;
        if($request->action == 'tolak') {
            $status_persetujuan = 0;
        }
        else {
            $status_persetujuan = 1;
        }
        $user = User::where('id', '=', $id)->first();
        $user->is_photo_verified = $status_persetujuan;
        $user->photo_comments = $komentar_foto;
        $user->save();

        $url = '/daftar-anak/detail?id='.$id;

        return redirect($url);
    }
    public function submitKomentar(Request $request) {
        $id = $request->id;
        $komentar = $request->komentar;

        $user = User::where('id', '=', $id)->first();
        $user->comments = $komentar;
        $user->save();

        $url = '/daftar-anak/detail?id='.$id;

        return redirect($url);
    }
}
