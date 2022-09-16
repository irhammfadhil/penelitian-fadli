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
use App\Models\UsersCovid;
use PDF;
use DateTime;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    public function index() {
        $gender = ['Laki-laki', 'Perempuan'];
        //Responden secara keseluruhan
        $jml_responden = DB::table('users')->select(DB::raw('b.gender as jenis_kelamin,count(b.id) as jumlah'))->join('users_biodata as b', 'users.id', '=','b.users_id')->where('users.is_admin', '=', 0)
        ->where('users.is_deleted', '=', 0)->whereIn('b.gender', $gender)->whereRaw('(YEAR(users.created_at) - YEAR(b.birth_date)) between 7 and 12')->groupBy('b.gender')->get();
        //Responden berdasarkan usia
        $query_79th = DB::table('users')->select(DB::raw('b.gender as jenis_kelamin,count(b.id) as jumlah'))->join('users_biodata as b', 'users.id', '=','b.users_id')->where('users.is_admin', '=', 0)
        ->where('users.is_deleted', '=', 0)->whereIn('b.gender', $gender)->whereRaw('(YEAR(users.created_at) - YEAR(b.birth_date)) >= 7 and (YEAR(users.created_at) - YEAR(b.birth_date)) < 10')->groupBy('b.gender')->get();
        $query_912th = DB::table('users')->select(DB::raw('b.gender as jenis_kelamin,count(b.id) as jumlah'))->join('users_biodata as b', 'users.id', '=','b.users_id')->where('users.is_admin', '=', 0)
        ->where('users.is_deleted', '=', 0)->whereIn('b.gender', $gender)->whereRaw('(YEAR(users.created_at) - YEAR(b.birth_date)) >= 10 and (YEAR(users.created_at) - YEAR(b.birth_date)) <= 12')->groupBy('b.gender')->get();
        //persyaratan dmft dan rti
        $users_count = Biodata::whereRaw('(YEAR(users_biodata.created_at) - YEAR(users_biodata.birth_date)) between 7 and 12')->count();
        $users_id_lk_79 = Biodata::select('users_id')->whereRaw('(YEAR(users_biodata.created_at) - YEAR(users_biodata.birth_date)) >= 7 and (YEAR(users_biodata.created_at) - YEAR(users_biodata.birth_date)) < 10')
        ->where('gender', '=', 'Laki-laki')->get();
        $users_id_pr_79 = Biodata::select('users_id')->whereRaw('(YEAR(users_biodata.created_at) - YEAR(users_biodata.birth_date)) >= 7 and (YEAR(users_biodata.created_at) - YEAR(users_biodata.birth_date)) < 10')
        ->where('gender', '=', 'Perempuan')->get();
        $users_id_lk_912 = Biodata::select('users_id')->whereRaw('(YEAR(users_biodata.created_at) - YEAR(users_biodata.birth_date)) >= 10 and (YEAR(users_biodata.created_at) - YEAR(users_biodata.birth_date)) <= 12')
        ->where('gender', '=', 'Laki-laki')->get();
        $users_id_pr_912 = Biodata::select('users_id')->whereRaw('(YEAR(users_biodata.created_at) - YEAR(users_biodata.birth_date)) >= 10 and (YEAR(users_biodata.created_at) - YEAR(users_biodata.birth_date)) <= 12')
        ->where('gender', '=', 'Perempuan')->get();
        //dmft dan rti
        $users_dmft_lk_79 = User::select(DB::raw('sum(users.dmft_score) as rata_rata_dmft, sum(users.deft_score) as rata_rata_deft, sum(users.num_decay)/sum(users.dmft_score) as rata_rata_rti_tetap, sum(users.num_decay_anak)/sum(users.dmft_score) as rata_rata_rti_sulung'))
        ->whereIn('id', $users_id_lk_79)->get();
        $users_dmft_pr_79 = User::select(DB::raw('sum(users.dmft_score) as rata_rata_dmft, sum(users.deft_score) as rata_rata_deft, sum(users.num_decay)/sum(users.dmft_score) as rata_rata_rti_tetap, sum(users.num_decay_anak)/sum(users.dmft_score) as rata_rata_rti_sulung'))
        ->whereIn('id', $users_id_pr_79)->get();
        $users_dmft_lk_912 = User::select(DB::raw('sum(users.dmft_score) as rata_rata_dmft, sum(users.deft_score) as rata_rata_deft, sum(users.num_decay)/sum(users.dmft_score) as rata_rata_rti_tetap, sum(users.num_decay_anak)/sum(users.dmft_score) as rata_rata_rti_sulung'))
        ->whereIn('id', $users_id_lk_912)->get();
        $users_dmft_pr_912 = User::select(DB::raw('sum(users.dmft_score) as rata_rata_dmft, sum(users.deft_score) as rata_rata_deft, sum(users.num_decay)/sum(users.dmft_score) as rata_rata_rti_tetap, sum(users.num_decay_anak)/sum(users.dmft_score) as rata_rata_rti_sulung'))
        ->whereIn('id', $users_id_pr_912)->get();

        //array push
        $gender_label = [];
        $gender_sum = [];
        $sum_79th = [0,0];
        $sum_912th = [0,0];
        $array_dmft_79 = [];
        $array_dmft_912 = [];
        $array_deft_79 = [];
        $array_deft_912 = [];
        $array_rti_79 = [];
        $array_rti_912 = [];
        $array_rti_sulung_79 = [];
        $array_rti_sulung_912 = [];
        foreach($jml_responden as $r) {
            array_push($gender_label, $r->jenis_kelamin);
            array_push($gender_sum, (int) $r->jumlah);
        }
        //anak umur 7-9 thn
        foreach($query_79th as $q) {
            if($q->jenis_kelamin == 'Laki-laki') {
                $sum_79th[0] = (int) $q->jumlah;
            }
            else if ($q->jenis_kelamin == 'Perempuan') {
                $sum_79th[1] = (int) $q->jumlah;
            }
        }
        //anak umur 9-12 thn
        foreach($query_912th as $q) {
            if($q->jenis_kelamin == 'Laki-laki') {
                $sum_912th[0] = (int) $q->jumlah;
            }
            else if ($q->jenis_kelamin == 'Perempuan') {
                $sum_912th[1] = (int) $q->jumlah;
            }
        }
        //masukin ke array indek DMFT dan rti
        foreach($users_dmft_lk_79 as $u) {
            if(!is_null($u->rata_rata_dmft)) {
                array_push($array_dmft_79, (float) ($u->rata_rata_dmft/$users_count));
            }
            else {
                array_push($array_dmft_79, 0);
            }
            if(!is_null($u->rata_rata_deft)) {
                array_push($array_deft_79, (float) $u->rata_rata_deft/$users_count);
            }
            else {
                array_push($array_deft_79, 0);
            }
            if(!is_null($u->rata_rata_rti_tetap)) {
                array_push($array_rti_79, (float) $u->rata_rata_rti_tetap*100);
            }
            else {
                array_push($array_rti_79, 0);
            }
            if(!is_null($u->rata_rata_rti_sulung)) {
                array_push($array_rti_sulung_79, (float) $u->rata_rata_rti_sulung*100);
            }
            else {
                array_push($array_rti_sulung_79, 0);
            }
        }
        foreach($users_dmft_pr_79 as $u) {
            if(!is_null($u->rata_rata_dmft)) {
                array_push($array_dmft_79, (float) $u->rata_rata_dmft/$users_count);
            }
            else {
                array_push($array_dmft_79, 0);
            }
            if(!is_null($u->rata_rata_deft)) {
                array_push($array_deft_79, (float) $u->rata_rata_deft/$users_count);
            }
            else {
                array_push($array_deft_79, 0);
            }
            if(!is_null($u->rata_rata_rti_tetap)) {
                array_push($array_rti_79, (float) $u->rata_rata_rti_tetap*100);
            }
            else {
                array_push($array_rti_79, 0);
            }
            if(!is_null($u->rata_rata_rti_sulung)) {
                array_push($array_rti_sulung_79, (float) $u->rata_rata_rti_sulung*100);
            }
            else {
                array_push($array_rti_sulung_79, 0);
            }
        }
        foreach($users_dmft_lk_912 as $u) {
            if(!is_null($u->rata_rata_dmft)) {
                array_push($array_dmft_912, (float) $u->rata_rata_dmft/$users_count);
            }
            else {
                array_push($array_dmft_912, 0);
            }
            if(!is_null($u->rata_rata_deft)) {
                array_push($array_deft_912, (float) $u->rata_rata_deft/$users_count);
            }
            else {
                array_push($array_deft_912, 0);
            }
            if(!is_null($u->rata_rata_rti_tetap)) {
                array_push($array_rti_912, (float) $u->rata_rata_rti_tetap*100);
            }
            else {
                array_push($array_rti_912, 0);
            }
            if(!is_null($u->rata_rata_rti_sulung)) {
                array_push($array_rti_sulung_912, (float) $u->rata_rata_rti_sulung*100);
            }
            else {
                array_push($array_rti_sulung_912, 0);
            }
        }
        foreach($users_dmft_pr_912 as $u) {
            if(!is_null($u->rata_rata_dmft)) {
                array_push($array_dmft_912, (float) $u->rata_rata_dmft/$users_count);
            }
            else {
                array_push($array_dmft_912, 0);
            }
            if(!is_null($u->rata_rata_deft)) {
                array_push($array_deft_912, (float) $u->rata_rata_deft/$users_count);
            }
            else {
                array_push($array_deft_912, 0);
            }
            if(!is_null($u->rata_rata_rti_tetap)) {
                array_push($array_rti_912, (float) $u->rata_rata_rti_tetap*100);
            }
            else {
                array_push($array_rti_912, 0);
            }
            if(!is_null($u->rata_rata_rti_sulung)) {
                array_push($array_rti_sulung_912, (float) $u->rata_rata_rti_sulung*100);
            }
            else {
                array_push($array_rti_sulung_912, 0);
            }
        }
        return view('dashboard-admin.index', [
            'gender_label' => $gender_label,
            'gender_sum' => $gender_sum,
            'sum_79th' => $sum_79th,
            'sum_912th' => $sum_912th,
            'array_dmft_79' => $array_dmft_79,
            'array_dmft_912' => $array_dmft_912,
            'array_deft_79' => $array_deft_79,
            'array_deft_912' => $array_deft_912,
            'array_rti_912' => $array_rti_912,
            'array_rti_79' => $array_rti_79,
            'array_rti_912' => $array_rti_912,
            'array_rti_sulung_79' => $array_rti_sulung_79,
            'array_rti_sulung_912' => $array_rti_sulung_912
        ]);
    }
    public function getAllAnak(){
        $anak = User::where('is_admin', '=', 0)->where('is_deleted', '=', 0)->get();
        return view('dashboard-admin.list-anak', ['anak' => $anak]);
    }
    public function getAllUsers(){
        $anak = User::where('is_deleted', '=', 0)->get();
        return view('dashboard-admin.list-user', ['anak' => $anak]);
    }
    public function makeAdmin(Request $request) {
        $user = User::where('id', '=', $request->id)->first();
        $user->is_admin = 1;
        $user->save();

        return redirect('/daftar-user');
    }
    public function makeUser(Request $request) {
        $user = User::where('id', '=', $request->id)->first();
        $user->is_admin = 0;
        $user->save();

        return redirect('/daftar-user');
    }
    public function getDetailAnak(Request $request) {
        $user = User::where('id', '=', $request->id)->first();
        $biodata = Biodata::where('users_id', '=', $request->id)->first();
        $ortu = BiodataOrtu::where('users_id', '=', $request->id)->first();
        $foto = Foto::where('users_id', '=', $request->id)->first();
        $screening = UsersCovid::where('users_id', '=', $request->id)->first();
        //$region_gigi = Region::all();
        $diagnosis = Diagnosis::where('users_id', '=', $request->id)->get();
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
            'diagnosis' => $diagnosis,
            'id_gigi' => $id_gigi,
            'screening' => $screening, 
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
        $users->num_decay = $sum_decay_tetap;
        $users->num_decay_anak = $sum_decay_susu;
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
        if($status_persetujuan == 1) {
            $user->photo_verified_at = date('Y-m-d H:i:s');
        }
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
    public function deleteAnak(Request $request) {
        $id = $request->id;
        $user = User::where('id', '=', $id)->first();
        $user->is_deleted = 1;
        $user->save();

        return redirect('/daftar-anak');
    }
    public function cetakInformedConsent(Request $request) {
        $id = $request->id;
        $user = User::where('id', '=', $id)->first();
        $biodata = Biodata::where('users_id', '=', $id)->first();
        $ortu = BiodataOrtu::where('users_id', '=', $id)->first();
        $data = NULL;
        $tanggal = $this->tgl_indo((date('Y-m-d')));
        if($biodata && $ortu) {
            $date1 = new DateTime($biodata->birth_date);
            $date2 = new DateTime("now");
            $age = $date1->diff($date2);
            $data = [
                'biodata' => $biodata,
                'ortu' => $ortu,
                'age' => $age->y,
                'user' => $user,
                'tanggal' => $tanggal
            ];
        }
        else {
            $data = [
                'biodata' => $biodata,
                'ortu' => $ortu,
                'user' => $user,
                'tanggal' => $tanggal
            ];
        }
        $pdf = PDF::loadView('pdf.consent', $data);

        $fileName = 'Informed Consent '.$user->name.'.pdf';

        return $pdf->download($fileName);
    }
    public function cetakLaporan(Request $request) {
        $id = $request->id;
        $user = User::where('id', '=', $id)->first();
        $biodata = Biodata::where('users_id', '=', $id)->first();
        $ortu = BiodataOrtu::where('users_id', '=', $id)->first();
        $foto = Foto::where('users_id', '=', $id)->first();
        $diagnosis = Diagnosis::where('users_id', '=', $id)->get();

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

        $data = [
            'user' => $user,
            'biodata' => $biodata,
            'ortu' => $ortu,
            'foto' => $foto,
            'diagnosis' => $diagnosis,
            'sum_decay_tetap' => $sum_decay_tetap,
            'sum_missing_tetap' => $sum_missing_tetap,
            'sum_filling_tetap' => $sum_filling_tetap,
            'sum_decay_susu' => $sum_decay_susu,
            'sum_missing_susu' => $sum_missing_susu,
            'sum_filling_susu' => $sum_filling_susu,
            'kriteria_dmft' => $kriteria_dmft,
            'kriteria_deft' => $kriteria_deft,
        ];

        $pdf = PDF::loadView('pdf.report', $data);

        $fileName = 'Laporan '.$user->name.'.pdf';

        return $pdf->download($fileName);
    }
    public function generateReportGeneral() {
        $query_general = DB::table('users as u')->select(DB::raw(' b.gender as jenis_kelamin, count(u.id) as jumlah, sum(dmft_score)/count(u.id) as rata_rata_dmft, 
        sum(u.num_decay)/sum(dmft_score) as rata_rata_rti'))->leftJoin('users_biodata as b', 'b.users_id', '=', 'u.id')->where('u.is_admin', '=', 0)->whereRaw('(YEAR(u.finalisasi_at) - YEAR(b.birth_date)) between 7 and 12')
        ->groupBy('b.gender')->get();
        $query_klp_usia = DB::table('users as u')->select(DB::raw(' b.gender as jenis_kelamin, case when (YEAR(u.finalisasi_at) - YEAR(b.birth_date)) >= 7 and (YEAR(u.finalisasi_at) - YEAR(b.birth_date)) < 10 then \'Usia 7-10 th\' 
        when (YEAR(u.finalisasi_at) - YEAR(b.birth_date)) between 10 and 12 then \'Usia 10-12 th\' end as kategori_umur, 
        count(u.id) as jumlah, sum(dmft_score)/count(u.id) as rata_rata_dmft, 
        sum(u.num_decay)/sum(dmft_score) as rata_rata_rti'))->leftJoin('users_biodata as b', 'b.users_id', '=', 'u.id')->where('u.is_admin', '=', 0)->whereRaw('(YEAR(u.finalisasi_at) - YEAR(b.birth_date)) between 7 and 12')
        ->groupBy('b.gender', 'kategori_umur')->get();
        return view('dashboard-admin.laporan.general', [
            'query_klp_usia' => $query_klp_usia,
            'query_general' => $query_general,
        ]);
    }
    public function generateReportBySchool() {
        $sekolah = ['SDN Biting 04', 'SDN Candijati 01'];
        return view('dashboard-admin.laporan.by_school', [
            'sekolah' => $sekolah,
            'result' => 0,
        ]);
    }
    public function submitgenerateReportBySchool (Request $request) {
        $sekolah = $request->sekolah;

        $query_general = DB::table('users as u')->select(DB::raw(' b.gender as jenis_kelamin, count(u.id) as jumlah, sum(dmft_score)/count(u.id) as rata_rata_dmft, 
        sum(u.num_decay)/sum(dmft_score) as rata_rata_rti'))->leftJoin('users_biodata as b', 'b.users_id', '=', 'u.id')->where('u.is_admin', '=', 0)
        ->where('b.id_sekolah', '=', $sekolah)->whereRaw('(YEAR(u.finalisasi_at) - YEAR(b.birth_date)) between 7 and 12')->groupBy('b.gender')->get();
        $query_klp_usia = DB::table('users as u')->select(DB::raw(' b.gender as jenis_kelamin, case when (YEAR(u.finalisasi_at) - YEAR(b.birth_date)) >= 7 and (YEAR(u.finalisasi_at) - YEAR(b.birth_date)) < 10 then \'Usia 7-10 th\' 
        when (YEAR(u.finalisasi_at) - YEAR(b.birth_date)) between 10 and 12 then \'Usia 10-12 th\' end as kategori_umur, 
        count(u.id) as jumlah, sum(dmft_score)/count(u.id) as rata_rata_dmft, 
        sum(u.num_decay)/sum(dmft_score) as rata_rata_rti'))->leftJoin('users_biodata as b', 'b.users_id', '=', 'u.id')->where('u.is_admin', '=', 0)
        ->where('b.id_sekolah', '=', $sekolah)->whereRaw('(YEAR(u.finalisasi_at) - YEAR(b.birth_date)) between 7 and 12')->groupBy('b.gender', 'kategori_umur')->get();

        $sekolah = ['SDN Biting 04', 'SDN Candijati 01'];
        return view('dashboard-admin.laporan.by_school', [
            'query_klp_usia' => $query_klp_usia,
            'query_general' => $query_general,
            'result' => 1,
            'sekolah' => $sekolah,
            'sekolah_selected' => $request->sekolah,
        ]);
    }
}