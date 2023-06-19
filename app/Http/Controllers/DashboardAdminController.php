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
use App\Models\District;
use App\Models\Regency;
use App\Models\Village;
use PDF;
use DateTime;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $gender = ['Laki-laki', 'Perempuan'];
        //Responden secara keseluruhan
        $jml_responden = DB::table('users')->select(DB::raw('b.gender as jenis_kelamin,count(b.id) as jumlah'))->join('users_biodata as b', 'users.id', '=', 'b.users_id')->where('users.is_admin', '=', 0)
            ->where('users.is_deleted', '=', 0)->whereIn('b.gender', $gender)->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users.created_at, b.birth_date)), "%Y")+0 between 7 and 13')->groupBy('b.gender')->get();
        $query_klp_usia = DB::table('users as u')->select(DB::raw(' 
            case when DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 < 8 then \'7\'
            when DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 8 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 < 9 then \'8\'
            when DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 9 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 < 10 then \'9\'
            when DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 10 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 < 11 then \'10\'
            when DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 11 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 < 12 then \'11\'     
            when DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 12 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 <= 13 then \'12\' end as kategori_umur, 
            count(u.id) as jumlah, sum(dmft_score)/count(u.id) as rata_rata_dmft, sum(deft_score)/count(u.id) as rata_rata_deft, sum(u.num_decay)/sum(dmft_score) as rata_rata_rti,
            sum(u.num_decay_anak)/sum(deft_score) as rata_rata_rti_anak'))->leftJoin('users_biodata as b', 'b.users_id', '=', 'u.id')->where('u.is_admin', '=', 0)
            ->where('u.is_deleted', '=', 0)->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 <= 13')->groupBy('kategori_umur')->get();

        $query_by_gender = DB::table('users as u')->select(DB::raw('b.gender as jenis_kelamin, 
            count(u.id) as jumlah, sum(dmft_score)/count(u.id) as rata_rata_dmft, sum(deft_score)/count(u.id) as rata_rata_deft, sum(u.num_decay)/sum(dmft_score) as rata_rata_rti,
            sum(u.num_decay_anak)/sum(deft_score) as rata_rata_rti_anak'))->leftJoin('users_biodata as b', 'b.users_id', '=', 'u.id')->where('u.is_admin', '=', 0)
            ->where('u.is_deleted', '=', 0)->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 <= 13')->groupBy('jenis_kelamin')->get();
        $total_responden = DB::table('users')->join('users_biodata as b', 'users.id', '=', 'b.users_id')->where('users.is_admin', '=', 0)
            ->where('users.is_deleted', '=', 0)->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users.created_at, b.birth_date)), "%Y")+0 between 7 and 13')->count();
        //array num decay missing filling - by gender
        $num_decay = [];
        $num_missing = [];
        $num_filling = [];
        $num_decay_anak = [];
        $num_missing_anak = [];
        $num_filling_anak = [];

        foreach ($gender as $g) {
            $users_id = User::select('users.id')->join('users_biodata as b', 'b.users_id', '=', 'users.id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users.created_at, b.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users.created_at, b.birth_date)), "%Y")+0 <= 13')->where('b.gender', $g)->get();
            $diagnosis_decay = Diagnosis::whereIn('users_id', $users_id)->where('is_decay', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
            array_push($num_decay, $diagnosis_decay);
            $diagnosis_missing = Diagnosis::whereIn('users_id', $users_id)->where('is_missing', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
            array_push($num_missing, $diagnosis_missing);
            $diagnosis_filling = Diagnosis::whereIn('users_id', $users_id)->where('is_filling', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
            array_push($num_filling, $diagnosis_filling);
            $diagnosis_decay = Diagnosis::whereIn('users_id', $users_id)->where('is_decay', '=', 1)->whereBetween('id_gigi', [51, 85])->count();
            array_push($num_decay_anak, $diagnosis_decay);
            $diagnosis_missing = Diagnosis::whereIn('users_id', $users_id)->where('is_missing', '=', 1)->whereBetween('id_gigi', [51, 85])->count();
            array_push($num_missing_anak, $diagnosis_missing);
            $diagnosis_filling = Diagnosis::whereIn('users_id', $users_id)->where('is_filling', '=', 1)->whereBetween('id_gigi', [51, 85])->count();
            array_push($num_filling_anak, $diagnosis_filling);
        }

        //array num decay missing filing - by age
        $num_decay_age = [];
        $num_missing_age = [];
        $num_filling_age = [];
        $num_decay_anak_age = [];
        $num_missing_anak_age = [];
        $num_filling_anak_age = [];

        for ($i = 7; $i < 13; $i++) {
            $users_id = '';
            if ($i != 12) {
                $users_id = User::select('users.id')->join('users_biodata as b', 'b.users_id', '=', 'users.id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users.created_at, b.birth_date)), "%Y")+0 >=' . $i . ' and DATE_FORMAT(FROM_DAYS(DATEDIFF(users.created_at, b.birth_date)), "%Y")+0 <' . $i + 1)->get();
            } else {
                $users_id = User::select('users.id')->join('users_biodata as b', 'b.users_id', '=', 'users.id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users.created_at, b.birth_date)), "%Y")+0 >=' . $i . ' and DATE_FORMAT(FROM_DAYS(DATEDIFF(users.created_at, b.birth_date)), "%Y")+0 <=' . $i + 1)->get();
            }
            $diagnosis_decay = Diagnosis::whereIn('users_id', $users_id)->where('is_decay', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
            array_push($num_decay_age, $diagnosis_decay);
            $diagnosis_missing = Diagnosis::whereIn('users_id', $users_id)->where('is_missing', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
            array_push($num_missing_age, $diagnosis_missing);
            $diagnosis_filling = Diagnosis::whereIn('users_id', $users_id)->where('is_filling', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
            array_push($num_filling_age, $diagnosis_filling);
            $diagnosis_decay = Diagnosis::whereIn('users_id', $users_id)->where('is_decay', '=', 1)->whereBetween('id_gigi', [51, 85])->count();
            array_push($num_decay_anak_age, $diagnosis_decay);
            $diagnosis_missing = Diagnosis::whereIn('users_id', $users_id)->where('is_missing', '=', 1)->whereBetween('id_gigi', [51, 85])->count();
            array_push($num_missing_anak_age, $diagnosis_missing);
            $diagnosis_filling = Diagnosis::whereIn('users_id', $users_id)->where('is_filling', '=', 1)->whereBetween('id_gigi', [51, 85])->count();
            array_push($num_filling_anak_age, $diagnosis_filling);
        }

        $array_usia = [];
        $array_dmft_by_gender = [];
        $array_dmft_by_age = [];
        $array_deft_by_gender = [];
        $array_deft_by_age = [];
        $array_rti_by_gender = [];
        $array_rti_by_age = [];
        $array_rti_anak_by_gender = [];
        $array_rti_anak_by_age = [];
        $age = 7;
        $j = 0;
        for ($i = 7; $i <= 12; $i++) {
            foreach ($query_klp_usia as $q) {
                if ($q->kategori_umur == $i) {
                    array_push($array_usia, (int)$q->jumlah);
                    array_push($array_dmft_by_age, (float)number_format(($num_decay_age[$j] + $num_missing_age[$j] + $num_filling_age[$j]) / $q->jumlah, 2, '.', ''));
                    array_push($array_deft_by_age, (float)number_format(($num_decay_anak_age[$j] + $num_missing_anak_age[$j] + $num_filling_anak_age[$j]) / $q->jumlah, 2, '.', ''));
                    array_push($array_rti_by_age, (float)number_format($num_decay_age[$j] / ($num_decay_age[$j] + $num_missing_age[$j] + $num_filling_age[$j]) * 100, 2, '.', ''));
                    array_push($array_rti_anak_by_age, (float)number_format($num_decay_anak_age[$j] / ($num_decay_anak_age[$j] + $num_missing_anak_age[$j] + $num_filling_anak_age[$j]) * 100, 2, '.', ''));
                }
            }
            $j++;
        }
        $i = 0;
        foreach ($query_by_gender as $qg) {
            array_push($array_dmft_by_gender, (float)number_format(($num_decay[$i] + $num_missing[$i] + $num_filling[$i]) / $qg->jumlah, 2, '.', ''));
            array_push($array_deft_by_gender, (float)number_format(($num_decay_anak[$i] + $num_missing_anak[$i] + $num_filling_anak[$i]) / $qg->jumlah, 2, '.', ''));
            array_push($array_rti_by_gender, (float)number_format($num_decay[$i] / ($num_decay[$i] + $num_missing[$i] + $num_filling[$i]) * 100, 2, '.', ''));
            array_push($array_rti_anak_by_gender, (float)number_format($num_decay_anak[$i] / ($num_decay_anak[$i] + $num_missing_anak[$i] + $num_filling_anak[$i]) * 100, 2, '.', ''));
            $i++;
        }

        //array push
        $gender_label = [];
        $gender_sum = [];
        $sum_responden = 0;

        foreach ($jml_responden as $r) {
            array_push($gender_label, $r->jenis_kelamin);
            array_push($gender_sum, (int) $r->jumlah);
            $sum_responden += $r->jumlah;
        }
        //push total siswa/responden
        array_push($gender_label, 'Total');
        array_push($gender_sum, (int) $sum_responden);

        return view('dashboard-admin.index', [
            'gender_label' => $gender_label,
            'gender_sum' => $gender_sum,
            'array_usia' => $array_usia,
            'label_usia' => ['7 tahun', '8 tahun', '9 tahun', '10 tahun', '11 tahun', '12 tahun'],
            'array_dmft_by_gender' => $array_dmft_by_gender,
            'array_dmft_by_age' => $array_dmft_by_age,
            'array_deft_by_gender' => $array_deft_by_gender,
            'array_deft_by_age' => $array_deft_by_age,
            'array_rti_by_gender' => $array_rti_by_gender,
            'array_rti_by_age' => $array_rti_by_age,
            'array_rti_anak_by_gender' => $array_rti_anak_by_gender,
            'array_rti_anak_by_age' => $array_rti_anak_by_age,
            'total_responden' => $total_responden
        ]);
    }
    public function getAllAnak()
    {
        $anak = User::join('users_biodata as b', 'users.id', '=', 'b.users_id')->where('users.is_admin', '=', 0)
        ->where('users.is_deleted', '=', 0)->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users.created_at, b.birth_date)), "%Y")+0 between 7 and 13')->where('is_admin', '=', 0)->where('is_deleted', '=', 0)->get();
        return view('dashboard-admin.list-anak', ['anak' => $anak]);
    }
    public function getAllUsers()
    {
        $anak = User::where('is_deleted', '=', 0)->get();
        return view('dashboard-admin.list-user', ['anak' => $anak]);
    }
    public function makeAdmin(Request $request)
    {
        $user = User::where('id', '=', $request->id)->first();
        $user->is_admin = 1;
        $user->save();

        return redirect('/daftar-user');
    }
    public function makeUser(Request $request)
    {
        $user = User::where('id', '=', $request->id)->first();
        $user->is_admin = 0;
        $user->save();

        return redirect('/daftar-user');
    }
    public function getDetailAnak(Request $request)
    {
        $user = User::where('id', '=', $request->id)->first();
        $biodata = Biodata::where('users_id', '=', $request->id)->first();
        $ortu = BiodataOrtu::where('users_id', '=', $request->id)->first();
        $foto = Foto::where('users_id', '=', $request->id)->first();
        $screening = UsersCovid::where('users_id', '=', $request->id)->first();
        //$region_gigi = Region::all();
        $diagnosis = Diagnosis::where('users_id', '=', $request->id)->get();
        //id gigi
        $id_gigi = [
            '11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '31', '32', '33', '34', '35', '36', '37', '38', '41', '42', '43', '44', '45', '46', '47', '48',
            '51', '52', '53', '54', '55', '61', '62', '63', '64', '65', '71', '72', '73', '74', '75', '81', '82', '83', '84', '85'
        ];
        //gigi tetap
        $id_gigi_tetap_kiri_atas = ['11', '12', '13', '14', '15', '16', '17', '18'];
        $id_gigi_tetap_kanan_atas = ['21', '22', '23', '24', '25', '26', '27', '28'];
        $id_gigi_tetap_kiri_bawah = ['41', '42', '43', '44', '45', '46', '47', '48'];
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
        $sum_decay_susu = Diagnosis::where('users_id', '=', $request->id)->where('is_decay', '=', 1)->whereBetween('id_gigi', [51, 85])->count();
        $sum_missing_susu = Diagnosis::where('users_id', '=', $request->id)->where('is_missing', '=', 1)->whereBetween('id_gigi', [51, 85])->count();
        $sum_filling_susu = Diagnosis::where('users_id', '=', $request->id)->where('is_filling', '=', 1)->whereBetween('id_gigi', [51, 85])->count();

        #kriteria DMFT (Yulia et al., 2013)
        $kriteria_dmft = '';
        $kriteria_deft = '';
        if ($user->dmft_score >= 0 && $user->dmft_score <= 1.1) {
            $kriteria_dmft = 'Sangat Rendah';
        } else if ($user->dmft_score > 1.1 && $user->dmft_score <= 2.6) {
            $kriteria_dmft = 'Rendah';
        } else if ($user->dmft_score > 2.6 && $user->dmft_score <= 4.4) {
            $kriteria_dmft = 'Sedang';
        } else if ($user->dmft_score > 4.4 && $user->dmft_score <= 6.5) {
            $kriteria_dmft = 'Tinggi';
        } else if ($user->dmft_score > 6.5) {
            $kriteria_dmft = 'Sangat Tinggi';
        }
        #kriteria DEFT (Yulia et al., 2013)
        if ($user->deft_score >= 0 && $user->deft_score <= 1.1) {
            $kriteria_deft = 'Sangat Rendah';
        } else if ($user->deft_score > 1.1 && $user->deft_score <= 2.6) {
            $kriteria_deft = 'Rendah';
        } else if ($user->deft_score > 2.6 && $user->deft_score <= 4.4) {
            $kriteria_deft = 'Sedang';
        } else if ($user->deft_score > 4.4 && $user->deft_score <= 6.5) {
            $kriteria_deft = 'Tinggi';
        } else if ($user->deft_score > 6.5) {
            $kriteria_deft = 'Sangat Tinggi';
        }

        //handle tanggal foto jika null
        $tanggal_foto_senyum = null;
        $tanggal_foto_depan = null;
        $tanggal_foto_kiri = null;
        $tanggal_foto_atas = null;
        $tanggal_foto_kanan = null;
        $tanggal_foto_bawah = null;
        if ($tanggal_foto_senyum != null) {
            $tanggal_foto_senyum = $this->tgl_indo($foto->date_taken_senyum);
        }
        if ($tanggal_foto_depan != null) {
            $tanggal_foto_depan = $this->tgl_indo($foto->date_taken_depan);
        }
        if ($tanggal_foto_kiri != null) {
            $tanggal_foto_kiri = $this->tgl_indo($foto->date_taken_kiri);
        }
        if ($tanggal_foto_atas != null) {
            $tanggal_foto_atas = $this->tgl_indo($foto->date_taken_atas);
        }
        if ($tanggal_foto_kanan != null) {
            $tanggal_foto_kanan = $this->tgl_indo($foto->date_taken_kanan);
        }
        if ($tanggal_foto_bawah != null) {
            $tanggal_foto_bawah = $this->tgl_indo($foto->date_taken_bawah);
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
            'tanggal_lahir' => $this->tgl_indo($biodata->birth_date),
            'tanggal_foto_senyum' => $tanggal_foto_senyum,
            'tanggal_foto_depan' => $tanggal_foto_depan,
            'tanggal_foto_kiri' => $tanggal_foto_kiri,
            'tanggal_foto_atas' => $tanggal_foto_atas,
            'tanggal_foto_kanan' => $tanggal_foto_kanan,
            'tanggal_foto_bawah' => $tanggal_foto_bawah,
        ]);
    }
    public function submitOdontogram(Request $request)
    {
        $users_id = $request->usersId;
        $decay = $request->decay;
        $missing = $request->missing;
        $filling = $request->filling;

        $id_decay = explode(',', $decay);
        $id_missing = explode(',', $missing);
        $id_filling = explode(',', $filling);

        #delete existing record
        $diagnosis = Diagnosis::where('users_id', '=', $users_id)->delete();

        #data gigi decay
        if ($decay) {
            foreach ($id_decay as $d) {
                $data = Diagnosis::where('users_id', '=', $users_id)->where('id_gigi', '=', $d)->first();
                if (!$data) {
                    $data = new Diagnosis;
                }
                $data->users_id = $users_id;
                $data->id_gigi = $d;
                $data->is_decay = 1;
                $data->save();
            }
        }

        if ($missing) {
            #data gigi missing
            foreach ($id_missing as $m) {
                $data = Diagnosis::where('users_id', '=', $users_id)->where('id_gigi', '=', $m)->first();
                if (!$data) {
                    $data = new Diagnosis;
                }
                $data->users_id = $users_id;
                $data->id_gigi = $m;
                $data->is_missing = 1;
                $data->save();
            }
        }

        if ($filling) {
            #data gigi filling
            foreach ($id_filling as $f) {
                $data = Diagnosis::where('users_id', '=', $users_id)->where('id_gigi', '=', $f)->first();
                if (!$data) {
                    $data = new Diagnosis;
                }
                $data->users_id = $users_id;
                $data->id_gigi = $f;
                $data->is_filling = 1;
                $data->save();
            }
        }

        #itung dmft
        ##gigi tetap
        $sum_decay_tetap = Diagnosis::where('users_id', '=', $users_id)->where('is_decay', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
        $sum_missing_tetap = Diagnosis::where('users_id', '=', $users_id)->where('is_missing', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
        $sum_filling_tetap = Diagnosis::where('users_id', '=', $users_id)->where('is_filling', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
        ##gigi susu
        $sum_decay_susu = Diagnosis::where('users_id', '=', $users_id)->where('is_decay', '=', 1)->whereBetween('id_gigi', [51, 85])->count();
        $sum_missing_susu = Diagnosis::where('users_id', '=', $users_id)->where('is_missing', '=', 1)->whereBetween('id_gigi', [51, 85])->count();
        $sum_filling_susu = Diagnosis::where('users_id', '=', $users_id)->where('is_filling', '=', 1)->whereBetween('id_gigi', [51, 85])->count();

        $dmftIndex = $sum_decay_tetap + $sum_missing_tetap + $sum_filling_tetap;
        $deftIndex = $sum_decay_susu + $sum_missing_susu + $sum_filling_susu;

        $users = User::where('id', '=', $users_id)->first();
        $users->num_decay = $sum_decay_tetap;
        $users->num_decay_anak = $sum_decay_susu;
        $users->dmft_score = $dmftIndex;
        $users->deft_score = $deftIndex;
        $users->save();

        $url = '/daftar-anak/detail?id=' . $users_id;

        return redirect($url);
    }
    public function getAllArticle()
    {
        $article = Article::all();
        return view('dashboard-admin.list-artikel', [
            'article' => $article,
        ]);
    }
    public function getNewArticle()
    {
        return view('dashboard-admin.artikel.new');
    }
    public function submitNewArticle(Request $request)
    {
        $this->validate($request, [
            'file' => 'file',
        ]);
        $title = $request->title;
        $deskripsi = $request->deskripsi;
        $file = $request->file('file');

        $fileName = NULL;
        $base_file_name = NULL;

        if ($file) {
            $rand = substr(md5(microtime()), 0, 10);
            $fileName = 'artikel/' . $rand . '_' . $file->getClientOriginalName();
            $base_file_name = $rand . '_' . $file->getClientOriginalName();
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
    public function getEditArticle(Request $request)
    {
        $artikel = Article::find($request->id);

        return view('dashboard-admin.artikel.edit', ['article' => $artikel]);
    }
    public function submitEditArticle(Request $request)
    {
        $this->validate($request, [
            'file' => 'file',
        ]);
        $title = $request->title;
        $deskripsi = $request->deskripsi;
        $file = $request->file('file');

        $fileName = NULL;
        $base_file_name = NULL;

        if ($file) {
            $rand = substr(md5(microtime()), 0, 10);
            $fileName = 'artikel/' . $rand . '_' . $file->getClientOriginalName();
            $base_file_name = $rand . '_' . $file->getClientOriginalName();
            $file->move(public_path('artikel/'), $fileName);
        }

        $url = str_replace(" ", "-", strtolower($title));

        $artikel = Article::find($request->id);
        $artikel->title = $title;
        $artikel->text = $deskripsi;
        if ($file) {
            $artikel->image = $fileName;
        }
        $artikel->link = $url;
        $artikel->save();

        return redirect('/admin/artikel');
    }
    public function deleteArticle(Request $request)
    {
        $artikel = Article::find($request->id);
        $artikel->delete();

        return redirect('/admin/artikel');
    }
    public function inputKomentarFotoAdmin(Request $request)
    {
        $id = $request->id;
        $komentar_foto = $request->komentar_foto;
        $status_persetujuan = 0;
        if ($request->action == 'tolak') {
            $status_persetujuan = 0;
        } else {
            $status_persetujuan = 1;
        }
        $user = User::where('id', '=', $id)->first();
        $user->is_photo_verified = $status_persetujuan;
        $user->photo_comments = $komentar_foto;
        if ($status_persetujuan == 1) {
            $user->photo_verified_at = date('Y-m-d H:i:s');
        }
        $user->save();

        $url = '/daftar-anak/detail?id=' . $id;

        return redirect($url);
    }
    public function submitKomentar(Request $request)
    {
        $id = $request->id;
        $komentar = $request->komentar;

        $user = User::where('id', '=', $id)->first();
        $user->comments = $komentar;
        $user->save();

        $url = '/daftar-anak/detail?id=' . $id;

        return redirect($url);
    }
    public function deleteAnak(Request $request)
    {
        $id = $request->id;
        $user = User::where('id', '=', $id)->first();
        $user->is_deleted = 1;
        $user->save();

        return redirect('/daftar-anak');
    }
    public function cetakInformedConsent(Request $request)
    {
        $id = $request->id;
        $user = User::where('id', '=', $id)->first();
        $biodata = Biodata::where('users_id', '=', $id)->first();
        $ortu = BiodataOrtu::where('users_id', '=', $id)->first();
        $data = NULL;
        $tanggal = $this->tgl_indo((date('Y-m-d')));
        if ($biodata && $ortu) {
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
        } else {
            $data = [
                'biodata' => $biodata,
                'ortu' => $ortu,
                'user' => $user,
                'tanggal' => $tanggal
            ];
        }
        $pdf = PDF::loadView('pdf.consent', $data);

        $fileName = 'Informed Consent ' . $user->name . '.pdf';
        $output = $pdf->output();
        if (file_exists($fileName)) {
            unlink($output);
        }
        file_put_contents($fileName, $output);

        return redirect('/daftar-anak');
    }
    public function cetakLaporan(Request $request)
    {
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
        $sum_decay_susu = Diagnosis::where('users_id', '=', $request->id)->where('is_decay', '=', 1)->whereBetween('id_gigi', [51, 85])->count();
        $sum_missing_susu = Diagnosis::where('users_id', '=', $request->id)->where('is_missing', '=', 1)->whereBetween('id_gigi', [51, 85])->count();
        $sum_filling_susu = Diagnosis::where('users_id', '=', $request->id)->where('is_filling', '=', 1)->whereBetween('id_gigi', [51, 85])->count();

        #kriteria DMFT (Yulia et al., 2013)
        $kriteria_dmft = '';
        $kriteria_deft = '';
        if ($user->dmft_score >= 0 && $user->dmft_score <= 1.1) {
            $kriteria_dmft = 'Sangat Rendah';
        } else if ($user->dmft_score > 1.1 && $user->dmft_score <= 2.6) {
            $kriteria_dmft = 'Rendah';
        } else if ($user->dmft_score > 2.6 && $user->dmft_score <= 4.4) {
            $kriteria_dmft = 'Sedang';
        } else if ($user->dmft_score > 4.4 && $user->dmft_score <= 6.5) {
            $kriteria_dmft = 'Tinggi';
        } else if ($user->dmft_score > 6.5) {
            $kriteria_dmft = 'Sangat Tinggi';
        }
        #kriteria DEFT (Yulia et al., 2013)
        if ($user->deft_score >= 0 && $user->deft_score <= 1.1) {
            $kriteria_deft = 'Sangat Rendah';
        } else if ($user->deft_score > 1.1 && $user->deft_score <= 2.6) {
            $kriteria_deft = 'Rendah';
        } else if ($user->deft_score > 2.6 && $user->deft_score <= 4.4) {
            $kriteria_deft = 'Sedang';
        } else if ($user->deft_score > 4.4 && $user->deft_score <= 6.5) {
            $kriteria_deft = 'Tinggi';
        } else if ($user->deft_score > 6.5) {
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
            'tanggal_daftar' => $this->tgl_indo(date('Y-m-d', strtotime($user->created_at))),
            'tanggal_lahir' => $this->tgl_indo($biodata->birth_date),
            'tanggal_foto_senyum' => $this->tgl_indo($foto->date_taken_senyum),
            'tanggal_foto_depan' => $this->tgl_indo($foto->date_taken_depan),
            'tanggal_foto_kiri' => $this->tgl_indo($foto->date_taken_kiri),
            'tanggal_foto_atas' => $this->tgl_indo($foto->date_taken_atas),
            'tanggal_foto_kanan' => $this->tgl_indo($foto->date_taken_kanan),
            'tanggal_foto_bawah' => $this->tgl_indo($foto->date_taken_bawah),
        ];

        $pdf = PDF::loadView('pdf.report', $data);

        $fileName = 'Laporan ' . $user->name . '.pdf';

        $output = $pdf->output();
        if (file_exists($fileName)) {
            unlink($fileName);
        }
        file_put_contents($fileName, $output);

        $data = User::find($id);
        $data->report_filename = $fileName;
        $data->save();

        return view('dashboard-admin.cetak-laporan', [
            'data' => $data,
        ]);
    }
    public function generateReportGeneral()
    {
        $array_decay = [];
        $array_missing = [];
        $array_filling = [];
        $array_decay_anak = [];
        $array_missing_anak = [];
        $array_filling_anak = [];

        $query_general = DB::table('users as u')->select(DB::raw('b.gender as jenis_kelamin, count(u.id) as jumlah, sum(dmft_score)/count(u.id) as rata_rata_dmft, sum(deft_score)/count(u.id) as rata_rata_deft,
        sum(u.num_decay)/sum(dmft_score) as rata_rata_rti, sum(u.num_decay_anak)/sum(deft_score) as rata_rata_rti_anak'))->leftJoin('users_biodata as b', 'b.users_id', '=', 'u.id')->where('u.is_admin', '=', 0)
            ->where('u.is_deleted', '=', 0)->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 <= 13')->groupBy('b.gender')->get();
        $query_klp_usia = DB::table('users as u')->select(DB::raw('b.gender as jenis_kelamin, 
        case when DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 < 8 then \'Usia 7 th\'
        when DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 8 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 < 9 then \'Usia 8 th\'
        when DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 9 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 < 10 then \'Usia 9 th\'
        when DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 10 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 < 11 then \'Usia 10 th\'
        when DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 11 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 < 12 then \'Usia 11 th\'     
        when DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 12 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 <= 13 then \'Usia 12 th\' end as kategori_umur, 
        count(u.id) as jumlah, sum(dmft_score)/count(u.id) as rata_rata_dmft, sum(deft_score)/count(u.id) as rata_rata_deft, sum(u.num_decay)/sum(dmft_score) as rata_rata_rti,
        sum(u.num_decay_anak)/sum(deft_score) as rata_rata_rti_anak'))->leftJoin('users_biodata as b', 'b.users_id', '=', 'u.id')->where('u.is_admin', '=', 0)
            ->where('u.is_deleted', '=', 0)->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 <= 13')->groupBy('b.gender', 'kategori_umur')->get();

        $query_total = DB::table('users as u')->select(DB::raw('count(u.id) as jumlah, sum(dmft_score)/count(u.id) as rata_rata_dmft, sum(deft_score)/count(u.id) as rata_rata_deft,
            sum(u.num_decay)/sum(dmft_score) as rata_rata_rti, sum(u.num_decay_anak)/sum(deft_score) as rata_rata_rti_anak'))->leftJoin('users_biodata as b', 'b.users_id', '=', 'u.id')->where('u.is_admin', '=', 0)
            ->where('u.is_deleted', '=', 0)->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 <= 13')->get();

        $query_total_by_age = DB::table('users as u')->select(DB::raw('DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 as age, count(u.id) as jumlah, sum(dmft_score)/count(u.id) as rata_rata_dmft, sum(deft_score)/count(u.id) as rata_rata_deft,
            sum(u.num_decay)/sum(dmft_score) as rata_rata_rti, sum(u.num_decay_anak)/sum(deft_score) as rata_rata_rti_anak'))->leftJoin('users_biodata as b', 'b.users_id', '=', 'u.id')->where('u.is_admin', '=', 0)
            ->where('u.is_deleted', '=', 0)->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 <= 13')->groupByRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0')->get();

        $users_id_lk_79 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 10')
            ->where('gender', '=', 'Laki-laki')->get();
        $users_id_pr_79 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 10')
            ->where('gender', '=', 'Perempuan')->get();
        $users_id_lk_912 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 10 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 <= 13')
            ->where('gender', '=', 'Laki-laki')->get();
        $users_id_pr_912 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 10 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 <= 13')
            ->where('gender', '=', 'Perempuan')->get();
        ##decay num.
        $jml_decay_lk_79 = Diagnosis::whereIn('users_id', $users_id_lk_79)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_79 = Diagnosis::whereIn('users_id', $users_id_pr_79)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_lk_912 = Diagnosis::whereIn('users_id', $users_id_lk_912)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_912 = Diagnosis::whereIn('users_id', $users_id_pr_912)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        ##decay num. (anak)
        $jml_decay_lk_79_anak = Diagnosis::whereIn('users_id', $users_id_lk_79)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_79_anak = Diagnosis::whereIn('users_id', $users_id_pr_79)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_lk_912_anak = Diagnosis::whereIn('users_id', $users_id_lk_912)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_912_anak = Diagnosis::whereIn('users_id', $users_id_pr_912)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        ##missing num.
        $jml_missing_lk_79 = Diagnosis::whereIn('users_id', $users_id_lk_79)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_79 = Diagnosis::whereIn('users_id', $users_id_pr_79)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_lk_912 = Diagnosis::whereIn('users_id', $users_id_lk_912)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_912 = Diagnosis::whereIn('users_id', $users_id_pr_912)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        ##missing num. (anak)
        $jml_missing_lk_79_anak = Diagnosis::whereIn('users_id', $users_id_lk_79)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_79_anak = Diagnosis::whereIn('users_id', $users_id_pr_79)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_lk_912_anak = Diagnosis::whereIn('users_id', $users_id_lk_912)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_912_anak = Diagnosis::whereIn('users_id', $users_id_pr_912)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        ##filling num.
        $jml_filling_lk_79 = Diagnosis::whereIn('users_id', $users_id_lk_79)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_79 = Diagnosis::whereIn('users_id', $users_id_pr_79)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_lk_912 = Diagnosis::whereIn('users_id', $users_id_lk_912)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_912 = Diagnosis::whereIn('users_id', $users_id_pr_912)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        ##filling num. (anak)
        $jml_filling_lk_79_anak = Diagnosis::whereIn('users_id', $users_id_lk_79)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_79_anak = Diagnosis::whereIn('users_id', $users_id_pr_79)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_lk_912_anak = Diagnosis::whereIn('users_id', $users_id_lk_912)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_912_anak = Diagnosis::whereIn('users_id', $users_id_pr_912)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();

        //pengelompokan usia
        $users_id_lk_7 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 8')
            ->where('gender', '=', 'Laki-laki')->get();
        $users_id_pr_7 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 8')
            ->where('gender', '=', 'Perempuan')->get();
        $users_id_lk_8 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 8 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 9')
            ->where('gender', '=', 'Laki-laki')->get();
        $users_id_pr_8 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 8 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 9')
            ->where('gender', '=', 'Perempuan')->get();
        $users_id_lk_9 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 9 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 10')
            ->where('gender', '=', 'Laki-laki')->get();
        $users_id_pr_9 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 9 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 10')
            ->where('gender', '=', 'Perempuan')->get();
        $users_id_lk_10 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 10 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 11')
            ->where('gender', '=', 'Laki-laki')->get();
        $users_id_pr_10 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 10 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 11')
            ->where('gender', '=', 'Perempuan')->get();
        $users_id_lk_11 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 11 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 12')
            ->where('gender', '=', 'Laki-laki')->get();
        $users_id_pr_11 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 11 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 12')
            ->where('gender', '=', 'Perempuan')->get();
        $users_id_lk_12 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 12 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 <= 13')
            ->where('gender', '=', 'Laki-laki')->get();
        $users_id_pr_12 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 12 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 <= 13')
            ->where('gender', '=', 'Perempuan')->get();

        ##decay num.
        $jml_decay_lk_7 = Diagnosis::whereIn('users_id', $users_id_lk_7)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_7 = Diagnosis::whereIn('users_id', $users_id_pr_7)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        array_push($array_decay, $jml_decay_lk_7 + $jml_decay_pr_7);
        $jml_decay_lk_8 = Diagnosis::whereIn('users_id', $users_id_lk_8)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_8 = Diagnosis::whereIn('users_id', $users_id_pr_8)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        array_push($array_decay, $jml_decay_lk_8 + $jml_decay_pr_8);
        $jml_decay_lk_9 = Diagnosis::whereIn('users_id', $users_id_lk_9)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_9 = Diagnosis::whereIn('users_id', $users_id_pr_9)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        array_push($array_decay, $jml_decay_lk_9 + $jml_decay_pr_9);
        $jml_decay_lk_10 = Diagnosis::whereIn('users_id', $users_id_lk_10)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_10 = Diagnosis::whereIn('users_id', $users_id_pr_10)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        array_push($array_decay, $jml_decay_pr_10 + $jml_decay_lk_10);
        $jml_decay_lk_11 = Diagnosis::whereIn('users_id', $users_id_lk_11)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_11 = Diagnosis::whereIn('users_id', $users_id_pr_11)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        array_push($array_decay, $jml_decay_lk_11 + $jml_decay_pr_11);
        $jml_decay_lk_12 = Diagnosis::whereIn('users_id', $users_id_lk_12)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_12 = Diagnosis::whereIn('users_id', $users_id_pr_12)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        array_push($array_decay, $jml_decay_lk_12 + $jml_decay_pr_12);

        ##decay num. (anak)
        $jml_decay_lk_7_anak = Diagnosis::whereIn('users_id', $users_id_lk_7)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_7_anak = Diagnosis::whereIn('users_id', $users_id_pr_7)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_lk_8_anak = Diagnosis::whereIn('users_id', $users_id_lk_8)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_8_anak = Diagnosis::whereIn('users_id', $users_id_pr_8)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_lk_9_anak = Diagnosis::whereIn('users_id', $users_id_lk_9)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_9_anak = Diagnosis::whereIn('users_id', $users_id_pr_9)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_lk_10_anak = Diagnosis::whereIn('users_id', $users_id_lk_10)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_10_anak = Diagnosis::whereIn('users_id', $users_id_pr_10)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_lk_11_anak = Diagnosis::whereIn('users_id', $users_id_lk_11)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_11_anak = Diagnosis::whereIn('users_id', $users_id_pr_11)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_lk_12_anak = Diagnosis::whereIn('users_id', $users_id_lk_12)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_12_anak = Diagnosis::whereIn('users_id', $users_id_pr_12)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();

        ## missing
        $jml_missing_lk_7 = Diagnosis::whereIn('users_id', $users_id_lk_7)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_7 = Diagnosis::whereIn('users_id', $users_id_pr_7)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        array_push($array_missing, $jml_missing_lk_7 + $jml_missing_pr_7);
        $jml_missing_lk_8 = Diagnosis::whereIn('users_id', $users_id_lk_8)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_8 = Diagnosis::whereIn('users_id', $users_id_pr_8)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        array_push($array_missing, $jml_missing_lk_8 + $jml_missing_pr_8);
        $jml_missing_lk_9 = Diagnosis::whereIn('users_id', $users_id_lk_9)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_9 = Diagnosis::whereIn('users_id', $users_id_pr_9)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        array_push($array_missing, $jml_missing_lk_9 + $jml_missing_pr_9);
        $jml_missing_lk_10 = Diagnosis::whereIn('users_id', $users_id_lk_10)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_10 = Diagnosis::whereIn('users_id', $users_id_pr_10)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        array_push($array_missing, $jml_missing_lk_10 + $jml_missing_pr_10);
        $jml_missing_lk_11 = Diagnosis::whereIn('users_id', $users_id_lk_11)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_11 = Diagnosis::whereIn('users_id', $users_id_pr_11)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        array_push($array_missing, $jml_missing_lk_11 + $jml_missing_pr_11);
        $jml_missing_lk_12 = Diagnosis::whereIn('users_id', $users_id_lk_12)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_12 = Diagnosis::whereIn('users_id', $users_id_pr_12)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        array_push($array_missing, $jml_missing_lk_12 + $jml_missing_pr_12);

        ##missing num. (anak)
        $jml_missing_lk_7_anak = Diagnosis::whereIn('users_id', $users_id_lk_7)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_7_anak = Diagnosis::whereIn('users_id', $users_id_pr_7)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_lk_8_anak = Diagnosis::whereIn('users_id', $users_id_lk_8)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_8_anak = Diagnosis::whereIn('users_id', $users_id_pr_8)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_lk_9_anak = Diagnosis::whereIn('users_id', $users_id_lk_9)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_9_anak = Diagnosis::whereIn('users_id', $users_id_pr_9)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_lk_10_anak = Diagnosis::whereIn('users_id', $users_id_lk_10)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_10_anak = Diagnosis::whereIn('users_id', $users_id_pr_10)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_lk_11_anak = Diagnosis::whereIn('users_id', $users_id_lk_11)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_11_anak = Diagnosis::whereIn('users_id', $users_id_pr_11)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_lk_12_anak = Diagnosis::whereIn('users_id', $users_id_lk_12)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_12_anak = Diagnosis::whereIn('users_id', $users_id_pr_12)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();

        ##filling
        ##decay num.
        $jml_filling_lk_7 = Diagnosis::whereIn('users_id', $users_id_lk_7)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_7 = Diagnosis::whereIn('users_id', $users_id_pr_7)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        array_push($array_filling, $jml_filling_lk_7 + $jml_filling_pr_7);
        $jml_filling_lk_8 = Diagnosis::whereIn('users_id', $users_id_lk_8)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_8 = Diagnosis::whereIn('users_id', $users_id_pr_8)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        array_push($array_filling, $jml_filling_lk_8 + $jml_filling_pr_8);
        $jml_filling_lk_9 = Diagnosis::whereIn('users_id', $users_id_lk_9)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_9 = Diagnosis::whereIn('users_id', $users_id_pr_9)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        array_push($array_filling, $jml_filling_lk_9 + $jml_filling_pr_9);
        $jml_filling_lk_10 = Diagnosis::whereIn('users_id', $users_id_lk_10)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_10 = Diagnosis::whereIn('users_id', $users_id_pr_10)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        array_push($array_filling, $jml_filling_lk_10 + $jml_filling_pr_10);
        $jml_filling_lk_11 = Diagnosis::whereIn('users_id', $users_id_lk_11)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_11 = Diagnosis::whereIn('users_id', $users_id_pr_11)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        array_push($array_filling, $jml_filling_lk_11 + $jml_filling_pr_11);
        $jml_filling_lk_12 = Diagnosis::whereIn('users_id', $users_id_lk_12)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_12 = Diagnosis::whereIn('users_id', $users_id_pr_12)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        array_push($array_filling, $jml_filling_lk_12 + $jml_filling_pr_12);

        ##filling num. (anak)
        $jml_filling_lk_7_anak = Diagnosis::whereIn('users_id', $users_id_lk_7)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_7_anak = Diagnosis::whereIn('users_id', $users_id_pr_7)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_lk_8_anak = Diagnosis::whereIn('users_id', $users_id_lk_8)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_8_anak = Diagnosis::whereIn('users_id', $users_id_pr_8)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_lk_9_anak = Diagnosis::whereIn('users_id', $users_id_lk_9)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_9_anak = Diagnosis::whereIn('users_id', $users_id_pr_9)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_lk_10_anak = Diagnosis::whereIn('users_id', $users_id_lk_10)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_10_anak = Diagnosis::whereIn('users_id', $users_id_pr_10)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_lk_11_anak = Diagnosis::whereIn('users_id', $users_id_lk_11)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_11_anak = Diagnosis::whereIn('users_id', $users_id_pr_11)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_lk_12_anak = Diagnosis::whereIn('users_id', $users_id_lk_12)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_12_anak = Diagnosis::whereIn('users_id', $users_id_pr_12)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();

        //array num decay missing filing - by age
        $num_decay_age = [];
        $num_missing_age = [];
        $num_filling_age = [];
        $num_decay_anak_age = [];
        $num_missing_anak_age = [];
        $num_filling_anak_age = [];

        for ($i = 7; $i < 13; $i++) {
            $users_id = '';
            if ($i != 12) {
                $users_id = User::select('users.id')->join('users_biodata as b', 'b.users_id', '=', 'users.id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users.created_at, b.birth_date)), "%Y")+0 >=' . $i . ' and DATE_FORMAT(FROM_DAYS(DATEDIFF(users.created_at, b.birth_date)), "%Y")+0 <' . $i + 1)->get();
            } else {
                $users_id = User::select('users.id')->join('users_biodata as b', 'b.users_id', '=', 'users.id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users.created_at, b.birth_date)), "%Y")+0 >=' . $i . ' and DATE_FORMAT(FROM_DAYS(DATEDIFF(users.created_at, b.birth_date)), "%Y")+0 <=' . $i + 1)->get();
            }
            $diagnosis_decay = Diagnosis::whereIn('users_id', $users_id)->where('is_decay', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
            array_push($num_decay_age, $diagnosis_decay);
            $diagnosis_missing = Diagnosis::whereIn('users_id', $users_id)->where('is_missing', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
            array_push($num_missing_age, $diagnosis_missing);
            $diagnosis_filling = Diagnosis::whereIn('users_id', $users_id)->where('is_filling', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
            array_push($num_filling_age, $diagnosis_filling);
            $diagnosis_decay = Diagnosis::whereIn('users_id', $users_id)->where('is_decay', '=', 1)->whereBetween('id_gigi', [51, 85])->count();
            array_push($num_decay_anak_age, $diagnosis_decay);
            $diagnosis_missing = Diagnosis::whereIn('users_id', $users_id)->where('is_missing', '=', 1)->whereBetween('id_gigi', [51, 85])->count();
            array_push($num_missing_anak_age, $diagnosis_missing);
            $diagnosis_filling = Diagnosis::whereIn('users_id', $users_id)->where('is_filling', '=', 1)->whereBetween('id_gigi', [51, 85])->count();
            array_push($num_filling_anak_age, $diagnosis_filling);
        }

        $min_dmft = 999999;
        $min_dmft_label = '';
        $max_dmft = 0;
        $max_dmft_label = '';
        $min_deft = 999999;
        $min_deft_label = '';
        $max_deft = 0;
        $max_deft_label = '';
        $min_rti = 999999;
        $min_rti_label = '';
        $max_rti = 0;
        $max_rti_label = '';
        $min_rti_anak = 999999;
        $min_rti_anak_label = '';
        $max_rti_anak = 0;
        $max_rti_anak_label = '';
        foreach ($query_total_by_age as $q) {
            if ($q->rata_rata_dmft >= $max_dmft) {
                $max_dmft = $q->rata_rata_dmft;
                $max_dmft_label = $q->age;
            }
            if ($q->rata_rata_dmft <= $min_dmft) {
                $min_dmft = $q->rata_rata_dmft;
                $min_dmft_label = $q->age;
            }
            if ($q->rata_rata_deft >= $max_deft) {
                $max_deft = $q->rata_rata_deft;
                $max_deft_label = $q->age;
            }
            if ($q->rata_rata_deft <= $min_deft) {
                $min_deft = $q->rata_rata_deft;
                $min_deft_label = $q->age;
            }
        }
        $j = 0;
        for ($i = 7; $i < 13; $i++) {
            if ($num_decay_age[$j] / ($num_decay_age[$j] + $num_missing_age[$j] + $num_filling_age[$j]) >= $max_rti) {
                $max_rti = $num_decay_age[$j] / ($num_decay_age[$j] + $num_missing_age[$j] + $num_filling_age[$j]);
                $max_rti_label = $i;
            }
            if ($num_decay_age[$j] / ($num_decay_age[$j] + $num_missing_age[$j] + $num_filling_age[$j]) <= $min_rti) {
                $min_rti = $num_decay_age[$j] / ($num_decay_age[$j] + $num_missing_age[$j] + $num_filling_age[$j]);
                $min_rti_label = $i;
            }
            if ($num_decay_anak_age[$j] / ($num_decay_anak_age[$j] + $num_missing_anak_age[$j] + $num_filling_anak_age[$j]) >= $max_rti_anak) {
                $max_rti_anak = $num_decay_anak_age[$j] / ($num_decay_anak_age[$j] + $num_missing_anak_age[$j] + $num_filling_anak_age[$j]);
                $max_rti_anak_label = $i;
            }
            if ($num_decay_anak_age[$j] / ($num_decay_anak_age[$j] + $num_missing_anak_age[$j] + $num_filling_anak_age[$j]) <= $min_rti_anak) {
                $min_rti_anak = $num_decay_anak_age[$j] / ($num_decay_anak_age[$j] + $num_missing_anak_age[$j] + $num_filling_anak_age[$j]);
                $min_rti_anak_label = $i;
            }
            $j++;
        }
        $total_responden = DB::table('users')->join('users_biodata as b', 'users.id', '=', 'b.users_id')->where('users.is_admin', '=', 0)
            ->where('users.is_deleted', '=', 0)->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users.created_at, b.birth_date)), "%Y")+0 between 7 and 13')->count();

        if (request()->is('report')) {
            return view('dashboard-admin.laporan.general', [
                'query_klp_usia' => $query_klp_usia,
                'query_general' => $query_general,
                'query_total' => $query_total,
                'query_total_by_age' => $query_total_by_age,
                'jml_decay_lk_79' => $jml_decay_lk_79,
                'jml_decay_pr_79' => $jml_decay_pr_79,
                'jml_decay_lk_912' => $jml_decay_lk_912,
                'jml_decay_pr_912' => $jml_decay_pr_912,
                'jml_decay_lk_79_anak' => $jml_decay_lk_79_anak,
                'jml_decay_pr_79_anak' => $jml_decay_pr_79_anak,
                'jml_decay_lk_912_anak' => $jml_decay_lk_912_anak,
                'jml_decay_pr_912_anak' => $jml_decay_pr_912_anak,
                'jml_missing_lk_79' => $jml_missing_lk_79,
                'jml_missing_pr_79' => $jml_missing_pr_79,
                'jml_missing_lk_912' => $jml_missing_lk_912,
                'jml_missing_pr_912' => $jml_missing_pr_912,
                'jml_missing_lk_79_anak' => $jml_missing_lk_79_anak,
                'jml_missing_pr_79_anak' => $jml_missing_pr_79_anak,
                'jml_missing_lk_912_anak' => $jml_missing_lk_912_anak,
                'jml_missing_pr_912_anak' => $jml_missing_pr_912_anak,
                'jml_filling_lk_79' => $jml_filling_lk_79,
                'jml_filling_pr_79' => $jml_filling_pr_79,
                'jml_filling_lk_912' => $jml_filling_lk_912,
                'jml_filling_pr_912' => $jml_filling_pr_912,
                'jml_filling_lk_79_anak' => $jml_filling_lk_79_anak,
                'jml_filling_pr_79_anak' => $jml_filling_pr_79_anak,
                'jml_filling_lk_912_anak' => $jml_filling_lk_912_anak,
                'jml_filling_pr_912_anak' => $jml_filling_pr_912_anak,
                #Decay
                'jml_decay_lk_7' => $jml_decay_lk_7,
                'jml_decay_pr_7' => $jml_decay_pr_7,
                'jml_decay_lk_8' => $jml_decay_lk_8,
                'jml_decay_pr_8' => $jml_decay_pr_8,
                'jml_decay_lk_9' => $jml_decay_lk_9,
                'jml_decay_pr_9' => $jml_decay_pr_9,
                'jml_decay_lk_10' => $jml_decay_lk_10,
                'jml_decay_pr_10' => $jml_decay_pr_10,
                'jml_decay_lk_11' => $jml_decay_lk_11,
                'jml_decay_pr_11' => $jml_decay_pr_11,
                'jml_decay_lk_12' => $jml_decay_lk_12,
                'jml_decay_pr_12' => $jml_decay_pr_12,
                #Decay-anak
                'jml_decay_lk_7_anak' => $jml_decay_lk_7_anak,
                'jml_decay_pr_7_anak' => $jml_decay_pr_7_anak,
                'jml_decay_lk_8_anak' => $jml_decay_lk_8_anak,
                'jml_decay_pr_8_anak' => $jml_decay_pr_8_anak,
                'jml_decay_lk_9_anak' => $jml_decay_lk_9_anak,
                'jml_decay_pr_9_anak' => $jml_decay_pr_9_anak,
                'jml_decay_lk_10_anak' => $jml_decay_lk_10_anak,
                'jml_decay_pr_10_anak' => $jml_decay_pr_10_anak,
                'jml_decay_lk_11_anak' => $jml_decay_lk_11_anak,
                'jml_decay_pr_11_anak' => $jml_decay_pr_11_anak,
                'jml_decay_lk_12_anak' => $jml_decay_lk_12_anak,
                'jml_decay_pr_12_anak' => $jml_decay_pr_12_anak,
                #Missing
                'jml_missing_lk_7' => $jml_missing_lk_7,
                'jml_missing_pr_7' => $jml_missing_pr_7,
                'jml_missing_lk_8' => $jml_missing_lk_8,
                'jml_missing_pr_8' => $jml_missing_pr_8,
                'jml_missing_lk_9' => $jml_missing_lk_9,
                'jml_missing_pr_9' => $jml_missing_pr_9,
                'jml_missing_lk_10' => $jml_missing_lk_10,
                'jml_missing_pr_10' => $jml_missing_pr_10,
                'jml_missing_lk_11' => $jml_missing_lk_11,
                'jml_missing_pr_11' => $jml_missing_pr_11,
                'jml_missing_lk_12' => $jml_missing_lk_12,
                'jml_missing_pr_12' => $jml_missing_pr_12,
                #missing-anak
                'jml_missing_lk_7_anak' => $jml_missing_lk_7_anak,
                'jml_missing_pr_7_anak' => $jml_missing_pr_7_anak,
                'jml_missing_lk_8_anak' => $jml_missing_lk_8_anak,
                'jml_missing_pr_8_anak' => $jml_missing_pr_8_anak,
                'jml_missing_lk_9_anak' => $jml_missing_lk_9_anak,
                'jml_missing_pr_9_anak' => $jml_missing_pr_9_anak,
                'jml_missing_lk_10_anak' => $jml_missing_lk_10_anak,
                'jml_missing_pr_10_anak' => $jml_missing_pr_10_anak,
                'jml_missing_lk_11_anak' => $jml_missing_lk_11_anak,
                'jml_missing_pr_11_anak' => $jml_missing_pr_11_anak,
                'jml_missing_lk_12_anak' => $jml_missing_lk_12_anak,
                'jml_missing_pr_12_anak' => $jml_missing_pr_12_anak,
                #filling
                'jml_filling_lk_7' => $jml_filling_lk_7,
                'jml_filling_pr_7' => $jml_filling_pr_7,
                'jml_filling_lk_8' => $jml_filling_lk_8,
                'jml_filling_pr_8' => $jml_filling_pr_8,
                'jml_filling_lk_9' => $jml_filling_lk_9,
                'jml_filling_pr_9' => $jml_filling_pr_9,
                'jml_filling_lk_10' => $jml_filling_lk_10,
                'jml_filling_pr_10' => $jml_filling_pr_10,
                'jml_filling_lk_11' => $jml_filling_lk_11,
                'jml_filling_pr_11' => $jml_filling_pr_11,
                'jml_filling_lk_12' => $jml_filling_lk_12,
                'jml_filling_pr_12' => $jml_filling_pr_12,
                #filling-anak
                'jml_filling_lk_7_anak' => $jml_filling_lk_7_anak,
                'jml_filling_pr_7_anak' => $jml_filling_pr_7_anak,
                'jml_filling_lk_8_anak' => $jml_filling_lk_8_anak,
                'jml_filling_pr_8_anak' => $jml_filling_pr_8_anak,
                'jml_filling_lk_9_anak' => $jml_filling_lk_9_anak,
                'jml_filling_pr_9_anak' => $jml_filling_pr_9_anak,
                'jml_filling_lk_10_anak' => $jml_filling_lk_10_anak,
                'jml_filling_pr_10_anak' => $jml_filling_pr_10_anak,
                'jml_filling_lk_11_anak' => $jml_filling_lk_11_anak,
                'jml_filling_pr_11_anak' => $jml_filling_pr_11_anak,
                'jml_filling_lk_12_anak' => $jml_filling_lk_12_anak,
                'jml_filling_pr_12_anak' => $jml_filling_pr_12_anak,
                'total_responden' => $total_responden
            ]);
        }
        if (request()->is('report')) {
            return view('dashboard-admin.laporan.general', [
                'query_klp_usia' => $query_klp_usia,
                'query_general' => $query_general,
                'query_total' => $query_total,
                'query_total_by_age' => $query_total_by_age,
                'jml_decay_lk_79' => $jml_decay_lk_79,
                'jml_decay_pr_79' => $jml_decay_pr_79,
                'jml_decay_lk_912' => $jml_decay_lk_912,
                'jml_decay_pr_912' => $jml_decay_pr_912,
                'jml_decay_lk_79_anak' => $jml_decay_lk_79_anak,
                'jml_decay_pr_79_anak' => $jml_decay_pr_79_anak,
                'jml_decay_lk_912_anak' => $jml_decay_lk_912_anak,
                'jml_decay_pr_912_anak' => $jml_decay_pr_912_anak,
                'jml_missing_lk_79' => $jml_missing_lk_79,
                'jml_missing_pr_79' => $jml_missing_pr_79,
                'jml_missing_lk_912' => $jml_missing_lk_912,
                'jml_missing_pr_912' => $jml_missing_pr_912,
                'jml_missing_lk_79_anak' => $jml_missing_lk_79_anak,
                'jml_missing_pr_79_anak' => $jml_missing_pr_79_anak,
                'jml_missing_lk_912_anak' => $jml_missing_lk_912_anak,
                'jml_missing_pr_912_anak' => $jml_missing_pr_912_anak,
                'jml_filling_lk_79' => $jml_filling_lk_79,
                'jml_filling_pr_79' => $jml_filling_pr_79,
                'jml_filling_lk_912' => $jml_filling_lk_912,
                'jml_filling_pr_912' => $jml_filling_pr_912,
                'jml_filling_lk_79_anak' => $jml_filling_lk_79_anak,
                'jml_filling_pr_79_anak' => $jml_filling_pr_79_anak,
                'jml_filling_lk_912_anak' => $jml_filling_lk_912_anak,
                'jml_filling_pr_912_anak' => $jml_filling_pr_912_anak,
                #Decay
                'jml_decay_lk_7' => $jml_decay_lk_7,
                'jml_decay_pr_7' => $jml_decay_pr_7,
                'jml_decay_lk_8' => $jml_decay_lk_8,
                'jml_decay_pr_8' => $jml_decay_pr_8,
                'jml_decay_lk_9' => $jml_decay_lk_9,
                'jml_decay_pr_9' => $jml_decay_pr_9,
                'jml_decay_lk_10' => $jml_decay_lk_10,
                'jml_decay_pr_10' => $jml_decay_pr_10,
                'jml_decay_lk_11' => $jml_decay_lk_11,
                'jml_decay_pr_11' => $jml_decay_pr_11,
                'jml_decay_lk_12' => $jml_decay_lk_12,
                'jml_decay_pr_12' => $jml_decay_pr_12,
                #Decay-anak
                'jml_decay_lk_7_anak' => $jml_decay_lk_7_anak,
                'jml_decay_pr_7_anak' => $jml_decay_pr_7_anak,
                'jml_decay_lk_8_anak' => $jml_decay_lk_8_anak,
                'jml_decay_pr_8_anak' => $jml_decay_pr_8_anak,
                'jml_decay_lk_9_anak' => $jml_decay_lk_9_anak,
                'jml_decay_pr_9_anak' => $jml_decay_pr_9_anak,
                'jml_decay_lk_10_anak' => $jml_decay_lk_10_anak,
                'jml_decay_pr_10_anak' => $jml_decay_pr_10_anak,
                'jml_decay_lk_11_anak' => $jml_decay_lk_11_anak,
                'jml_decay_pr_11_anak' => $jml_decay_pr_11_anak,
                'jml_decay_lk_12_anak' => $jml_decay_lk_12_anak,
                'jml_decay_pr_12_anak' => $jml_decay_pr_12_anak,
                #Missing
                'jml_missing_lk_7' => $jml_missing_lk_7,
                'jml_missing_pr_7' => $jml_missing_pr_7,
                'jml_missing_lk_8' => $jml_missing_lk_8,
                'jml_missing_pr_8' => $jml_missing_pr_8,
                'jml_missing_lk_9' => $jml_missing_lk_9,
                'jml_missing_pr_9' => $jml_missing_pr_9,
                'jml_missing_lk_10' => $jml_missing_lk_10,
                'jml_missing_pr_10' => $jml_missing_pr_10,
                'jml_missing_lk_11' => $jml_missing_lk_11,
                'jml_missing_pr_11' => $jml_missing_pr_11,
                'jml_missing_lk_12' => $jml_missing_lk_12,
                'jml_missing_pr_12' => $jml_missing_pr_12,
                #missing-anak
                'jml_missing_lk_7_anak' => $jml_missing_lk_7_anak,
                'jml_missing_pr_7_anak' => $jml_missing_pr_7_anak,
                'jml_missing_lk_8_anak' => $jml_missing_lk_8_anak,
                'jml_missing_pr_8_anak' => $jml_missing_pr_8_anak,
                'jml_missing_lk_9_anak' => $jml_missing_lk_9_anak,
                'jml_missing_pr_9_anak' => $jml_missing_pr_9_anak,
                'jml_missing_lk_10_anak' => $jml_missing_lk_10_anak,
                'jml_missing_pr_10_anak' => $jml_missing_pr_10_anak,
                'jml_missing_lk_11_anak' => $jml_missing_lk_11_anak,
                'jml_missing_pr_11_anak' => $jml_missing_pr_11_anak,
                'jml_missing_lk_12_anak' => $jml_missing_lk_12_anak,
                'jml_missing_pr_12_anak' => $jml_missing_pr_12_anak,
                #filling
                'jml_filling_lk_7' => $jml_filling_lk_7,
                'jml_filling_pr_7' => $jml_filling_pr_7,
                'jml_filling_lk_8' => $jml_filling_lk_8,
                'jml_filling_pr_8' => $jml_filling_pr_8,
                'jml_filling_lk_9' => $jml_filling_lk_9,
                'jml_filling_pr_9' => $jml_filling_pr_9,
                'jml_filling_lk_10' => $jml_filling_lk_10,
                'jml_filling_pr_10' => $jml_filling_pr_10,
                'jml_filling_lk_11' => $jml_filling_lk_11,
                'jml_filling_pr_11' => $jml_filling_pr_11,
                'jml_filling_lk_12' => $jml_filling_lk_12,
                'jml_filling_pr_12' => $jml_filling_pr_12,
                #filling-anak
                'jml_filling_lk_7_anak' => $jml_filling_lk_7_anak,
                'jml_filling_pr_7_anak' => $jml_filling_pr_7_anak,
                'jml_filling_lk_8_anak' => $jml_filling_lk_8_anak,
                'jml_filling_pr_8_anak' => $jml_filling_pr_8_anak,
                'jml_filling_lk_9_anak' => $jml_filling_lk_9_anak,
                'jml_filling_pr_9_anak' => $jml_filling_pr_9_anak,
                'jml_filling_lk_10_anak' => $jml_filling_lk_10_anak,
                'jml_filling_pr_10_anak' => $jml_filling_pr_10_anak,
                'jml_filling_lk_11_anak' => $jml_filling_lk_11_anak,
                'jml_filling_pr_11_anak' => $jml_filling_pr_11_anak,
                'jml_filling_lk_12_anak' => $jml_filling_lk_12_anak,
                'jml_filling_pr_12_anak' => $jml_filling_pr_12_anak,
                'total_responden' => $total_responden
            ]);
        } else if (request()->is('report/responden')) {
            return view('dashboard-admin.laporan.responden', [
                'query_klp_usia' => $query_klp_usia,
                'query_general' => $query_general,
                'query_total' => $query_total,
                'query_total_by_age' => $query_total_by_age,
                'jml_decay_lk_79' => $jml_decay_lk_79,
                'jml_decay_pr_79' => $jml_decay_pr_79,
                'jml_decay_lk_912' => $jml_decay_lk_912,
                'jml_decay_pr_912' => $jml_decay_pr_912,
                'jml_decay_lk_79_anak' => $jml_decay_lk_79_anak,
                'jml_decay_pr_79_anak' => $jml_decay_pr_79_anak,
                'jml_decay_lk_912_anak' => $jml_decay_lk_912_anak,
                'jml_decay_pr_912_anak' => $jml_decay_pr_912_anak,
                'jml_missing_lk_79' => $jml_missing_lk_79,
                'jml_missing_pr_79' => $jml_missing_pr_79,
                'jml_missing_lk_912' => $jml_missing_lk_912,
                'jml_missing_pr_912' => $jml_missing_pr_912,
                'jml_missing_lk_79_anak' => $jml_missing_lk_79_anak,
                'jml_missing_pr_79_anak' => $jml_missing_pr_79_anak,
                'jml_missing_lk_912_anak' => $jml_missing_lk_912_anak,
                'jml_missing_pr_912_anak' => $jml_missing_pr_912_anak,
                'jml_filling_lk_79' => $jml_filling_lk_79,
                'jml_filling_pr_79' => $jml_filling_pr_79,
                'jml_filling_lk_912' => $jml_filling_lk_912,
                'jml_filling_pr_912' => $jml_filling_pr_912,
                'jml_filling_lk_79_anak' => $jml_filling_lk_79_anak,
                'jml_filling_pr_79_anak' => $jml_filling_pr_79_anak,
                'jml_filling_lk_912_anak' => $jml_filling_lk_912_anak,
                'jml_filling_pr_912_anak' => $jml_filling_pr_912_anak,
                #Decay
                'jml_decay_lk_7' => $jml_decay_lk_7,
                'jml_decay_pr_7' => $jml_decay_pr_7,
                'jml_decay_lk_8' => $jml_decay_lk_8,
                'jml_decay_pr_8' => $jml_decay_pr_8,
                'jml_decay_lk_9' => $jml_decay_lk_9,
                'jml_decay_pr_9' => $jml_decay_pr_9,
                'jml_decay_lk_10' => $jml_decay_lk_10,
                'jml_decay_pr_10' => $jml_decay_pr_10,
                'jml_decay_lk_11' => $jml_decay_lk_11,
                'jml_decay_pr_11' => $jml_decay_pr_11,
                'jml_decay_lk_12' => $jml_decay_lk_12,
                'jml_decay_pr_12' => $jml_decay_pr_12,
                #Decay-anak
                'jml_decay_lk_7_anak' => $jml_decay_lk_7_anak,
                'jml_decay_pr_7_anak' => $jml_decay_pr_7_anak,
                'jml_decay_lk_8_anak' => $jml_decay_lk_8_anak,
                'jml_decay_pr_8_anak' => $jml_decay_pr_8_anak,
                'jml_decay_lk_9_anak' => $jml_decay_lk_9_anak,
                'jml_decay_pr_9_anak' => $jml_decay_pr_9_anak,
                'jml_decay_lk_10_anak' => $jml_decay_lk_10_anak,
                'jml_decay_pr_10_anak' => $jml_decay_pr_10_anak,
                'jml_decay_lk_11_anak' => $jml_decay_lk_11_anak,
                'jml_decay_pr_11_anak' => $jml_decay_pr_11_anak,
                'jml_decay_lk_12_anak' => $jml_decay_lk_12_anak,
                'jml_decay_pr_12_anak' => $jml_decay_pr_12_anak,
                #Missing
                'jml_missing_lk_7' => $jml_missing_lk_7,
                'jml_missing_pr_7' => $jml_missing_pr_7,
                'jml_missing_lk_8' => $jml_missing_lk_8,
                'jml_missing_pr_8' => $jml_missing_pr_8,
                'jml_missing_lk_9' => $jml_missing_lk_9,
                'jml_missing_pr_9' => $jml_missing_pr_9,
                'jml_missing_lk_10' => $jml_missing_lk_10,
                'jml_missing_pr_10' => $jml_missing_pr_10,
                'jml_missing_lk_11' => $jml_missing_lk_11,
                'jml_missing_pr_11' => $jml_missing_pr_11,
                'jml_missing_lk_12' => $jml_missing_lk_12,
                'jml_missing_pr_12' => $jml_missing_pr_12,
                #missing-anak
                'jml_missing_lk_7_anak' => $jml_missing_lk_7_anak,
                'jml_missing_pr_7_anak' => $jml_missing_pr_7_anak,
                'jml_missing_lk_8_anak' => $jml_missing_lk_8_anak,
                'jml_missing_pr_8_anak' => $jml_missing_pr_8_anak,
                'jml_missing_lk_9_anak' => $jml_missing_lk_9_anak,
                'jml_missing_pr_9_anak' => $jml_missing_pr_9_anak,
                'jml_missing_lk_10_anak' => $jml_missing_lk_10_anak,
                'jml_missing_pr_10_anak' => $jml_missing_pr_10_anak,
                'jml_missing_lk_11_anak' => $jml_missing_lk_11_anak,
                'jml_missing_pr_11_anak' => $jml_missing_pr_11_anak,
                'jml_missing_lk_12_anak' => $jml_missing_lk_12_anak,
                'jml_missing_pr_12_anak' => $jml_missing_pr_12_anak,
                #filling
                'jml_filling_lk_7' => $jml_filling_lk_7,
                'jml_filling_pr_7' => $jml_filling_pr_7,
                'jml_filling_lk_8' => $jml_filling_lk_8,
                'jml_filling_pr_8' => $jml_filling_pr_8,
                'jml_filling_lk_9' => $jml_filling_lk_9,
                'jml_filling_pr_9' => $jml_filling_pr_9,
                'jml_filling_lk_10' => $jml_filling_lk_10,
                'jml_filling_pr_10' => $jml_filling_pr_10,
                'jml_filling_lk_11' => $jml_filling_lk_11,
                'jml_filling_pr_11' => $jml_filling_pr_11,
                'jml_filling_lk_12' => $jml_filling_lk_12,
                'jml_filling_pr_12' => $jml_filling_pr_12,
                #filling-anak
                'jml_filling_lk_7_anak' => $jml_filling_lk_7_anak,
                'jml_filling_pr_7_anak' => $jml_filling_pr_7_anak,
                'jml_filling_lk_8_anak' => $jml_filling_lk_8_anak,
                'jml_filling_pr_8_anak' => $jml_filling_pr_8_anak,
                'jml_filling_lk_9_anak' => $jml_filling_lk_9_anak,
                'jml_filling_pr_9_anak' => $jml_filling_pr_9_anak,
                'jml_filling_lk_10_anak' => $jml_filling_lk_10_anak,
                'jml_filling_pr_10_anak' => $jml_filling_pr_10_anak,
                'jml_filling_lk_11_anak' => $jml_filling_lk_11_anak,
                'jml_filling_pr_11_anak' => $jml_filling_pr_11_anak,
                'jml_filling_lk_12_anak' => $jml_filling_lk_12_anak,
                'jml_filling_pr_12_anak' => $jml_filling_pr_12_anak,
                #array
                'array_decay' => $array_decay,
                'array_missing' => $array_missing,
                'array_filling' => $array_filling,
                #label
                'max_dmft' => $max_dmft,
                'min_dmft' => $min_dmft,
                'max_dmft_label' => $max_dmft_label,
                'min_dmft_label' => $min_dmft_label,
                'total_responden' => $total_responden
            ]);
        } else if (request()->is('report/deft')) {
            return view('dashboard-admin.laporan.general-deft', [
                'query_klp_usia' => $query_klp_usia,
                'query_general' => $query_general,
                'query_total' => $query_total,
                'query_total_by_age' => $query_total_by_age,
                'jml_decay_lk_79' => $jml_decay_lk_79,
                'jml_decay_pr_79' => $jml_decay_pr_79,
                'jml_decay_lk_912' => $jml_decay_lk_912,
                'jml_decay_pr_912' => $jml_decay_pr_912,
                'jml_decay_lk_79_anak' => $jml_decay_lk_79_anak,
                'jml_decay_pr_79_anak' => $jml_decay_pr_79_anak,
                'jml_decay_lk_912_anak' => $jml_decay_lk_912_anak,
                'jml_decay_pr_912_anak' => $jml_decay_pr_912_anak,
                'jml_missing_lk_79' => $jml_missing_lk_79,
                'jml_missing_pr_79' => $jml_missing_pr_79,
                'jml_missing_lk_912' => $jml_missing_lk_912,
                'jml_missing_pr_912' => $jml_missing_pr_912,
                'jml_missing_lk_79_anak' => $jml_missing_lk_79_anak,
                'jml_missing_pr_79_anak' => $jml_missing_pr_79_anak,
                'jml_missing_lk_912_anak' => $jml_missing_lk_912_anak,
                'jml_missing_pr_912_anak' => $jml_missing_pr_912_anak,
                'jml_filling_lk_79' => $jml_filling_lk_79,
                'jml_filling_pr_79' => $jml_filling_pr_79,
                'jml_filling_lk_912' => $jml_filling_lk_912,
                'jml_filling_pr_912' => $jml_filling_pr_912,
                'jml_filling_lk_79_anak' => $jml_filling_lk_79_anak,
                'jml_filling_pr_79_anak' => $jml_filling_pr_79_anak,
                'jml_filling_lk_912_anak' => $jml_filling_lk_912_anak,
                'jml_filling_pr_912_anak' => $jml_filling_pr_912_anak,
                #Decay
                'jml_decay_lk_7' => $jml_decay_lk_7,
                'jml_decay_pr_7' => $jml_decay_pr_7,
                'jml_decay_lk_8' => $jml_decay_lk_8,
                'jml_decay_pr_8' => $jml_decay_pr_8,
                'jml_decay_lk_9' => $jml_decay_lk_9,
                'jml_decay_pr_9' => $jml_decay_pr_9,
                'jml_decay_lk_10' => $jml_decay_lk_10,
                'jml_decay_pr_10' => $jml_decay_pr_10,
                'jml_decay_lk_11' => $jml_decay_lk_11,
                'jml_decay_pr_11' => $jml_decay_pr_11,
                'jml_decay_lk_12' => $jml_decay_lk_12,
                'jml_decay_pr_12' => $jml_decay_pr_12,
                #Decay-anak
                'jml_decay_lk_7_anak' => $jml_decay_lk_7_anak,
                'jml_decay_pr_7_anak' => $jml_decay_pr_7_anak,
                'jml_decay_lk_8_anak' => $jml_decay_lk_8_anak,
                'jml_decay_pr_8_anak' => $jml_decay_pr_8_anak,
                'jml_decay_lk_9_anak' => $jml_decay_lk_9_anak,
                'jml_decay_pr_9_anak' => $jml_decay_pr_9_anak,
                'jml_decay_lk_10_anak' => $jml_decay_lk_10_anak,
                'jml_decay_pr_10_anak' => $jml_decay_pr_10_anak,
                'jml_decay_lk_11_anak' => $jml_decay_lk_11_anak,
                'jml_decay_pr_11_anak' => $jml_decay_pr_11_anak,
                'jml_decay_lk_12_anak' => $jml_decay_lk_12_anak,
                'jml_decay_pr_12_anak' => $jml_decay_pr_12_anak,
                #Missing
                'jml_missing_lk_7' => $jml_missing_lk_7,
                'jml_missing_pr_7' => $jml_missing_pr_7,
                'jml_missing_lk_8' => $jml_missing_lk_8,
                'jml_missing_pr_8' => $jml_missing_pr_8,
                'jml_missing_lk_9' => $jml_missing_lk_9,
                'jml_missing_pr_9' => $jml_missing_pr_9,
                'jml_missing_lk_10' => $jml_missing_lk_10,
                'jml_missing_pr_10' => $jml_missing_pr_10,
                'jml_missing_lk_11' => $jml_missing_lk_11,
                'jml_missing_pr_11' => $jml_missing_pr_11,
                'jml_missing_lk_12' => $jml_missing_lk_12,
                'jml_missing_pr_12' => $jml_missing_pr_12,
                #missing-anak
                'jml_missing_lk_7_anak' => $jml_missing_lk_7_anak,
                'jml_missing_pr_7_anak' => $jml_missing_pr_7_anak,
                'jml_missing_lk_8_anak' => $jml_missing_lk_8_anak,
                'jml_missing_pr_8_anak' => $jml_missing_pr_8_anak,
                'jml_missing_lk_9_anak' => $jml_missing_lk_9_anak,
                'jml_missing_pr_9_anak' => $jml_missing_pr_9_anak,
                'jml_missing_lk_10_anak' => $jml_missing_lk_10_anak,
                'jml_missing_pr_10_anak' => $jml_missing_pr_10_anak,
                'jml_missing_lk_11_anak' => $jml_missing_lk_11_anak,
                'jml_missing_pr_11_anak' => $jml_missing_pr_11_anak,
                'jml_missing_lk_12_anak' => $jml_missing_lk_12_anak,
                'jml_missing_pr_12_anak' => $jml_missing_pr_12_anak,
                #filling
                'jml_filling_lk_7' => $jml_filling_lk_7,
                'jml_filling_pr_7' => $jml_filling_pr_7,
                'jml_filling_lk_8' => $jml_filling_lk_8,
                'jml_filling_pr_8' => $jml_filling_pr_8,
                'jml_filling_lk_9' => $jml_filling_lk_9,
                'jml_filling_pr_9' => $jml_filling_pr_9,
                'jml_filling_lk_10' => $jml_filling_lk_10,
                'jml_filling_pr_10' => $jml_filling_pr_10,
                'jml_filling_lk_11' => $jml_filling_lk_11,
                'jml_filling_pr_11' => $jml_filling_pr_11,
                'jml_filling_lk_12' => $jml_filling_lk_12,
                'jml_filling_pr_12' => $jml_filling_pr_12,
                #filling-anak
                'jml_filling_lk_7_anak' => $jml_filling_lk_7_anak,
                'jml_filling_pr_7_anak' => $jml_filling_pr_7_anak,
                'jml_filling_lk_8_anak' => $jml_filling_lk_8_anak,
                'jml_filling_pr_8_anak' => $jml_filling_pr_8_anak,
                'jml_filling_lk_9_anak' => $jml_filling_lk_9_anak,
                'jml_filling_pr_9_anak' => $jml_filling_pr_9_anak,
                'jml_filling_lk_10_anak' => $jml_filling_lk_10_anak,
                'jml_filling_pr_10_anak' => $jml_filling_pr_10_anak,
                'jml_filling_lk_11_anak' => $jml_filling_lk_11_anak,
                'jml_filling_pr_11_anak' => $jml_filling_pr_11_anak,
                'jml_filling_lk_12_anak' => $jml_filling_lk_12_anak,
                'jml_filling_pr_12_anak' => $jml_filling_pr_12_anak,
                #array
                'array_decay' => $array_decay,
                'array_missing' => $array_missing,
                'array_filling' => $array_filling,
                #label
                'max_deft' => $max_deft,
                'min_deft' => $min_deft,
                'max_deft_label' => $max_deft_label,
                'min_deft_label' => $min_deft_label,
                'total_responden' => $total_responden
            ]);
        } else if (request()->is('report/rti')) {
            return view('dashboard-admin.laporan.general-rti', [
                'query_klp_usia' => $query_klp_usia,
                'query_general' => $query_general,
                'query_total' => $query_total,
                'query_total_by_age' => $query_total_by_age,
                'jml_decay_lk_79' => $jml_decay_lk_79,
                'jml_decay_pr_79' => $jml_decay_pr_79,
                'jml_decay_lk_912' => $jml_decay_lk_912,
                'jml_decay_pr_912' => $jml_decay_pr_912,
                'jml_decay_lk_79_anak' => $jml_decay_lk_79_anak,
                'jml_decay_pr_79_anak' => $jml_decay_pr_79_anak,
                'jml_decay_lk_912_anak' => $jml_decay_lk_912_anak,
                'jml_decay_pr_912_anak' => $jml_decay_pr_912_anak,
                'jml_missing_lk_79' => $jml_missing_lk_79,
                'jml_missing_pr_79' => $jml_missing_pr_79,
                'jml_missing_lk_912' => $jml_missing_lk_912,
                'jml_missing_pr_912' => $jml_missing_pr_912,
                'jml_missing_lk_79_anak' => $jml_missing_lk_79_anak,
                'jml_missing_pr_79_anak' => $jml_missing_pr_79_anak,
                'jml_missing_lk_912_anak' => $jml_missing_lk_912_anak,
                'jml_missing_pr_912_anak' => $jml_missing_pr_912_anak,
                'jml_filling_lk_79' => $jml_filling_lk_79,
                'jml_filling_pr_79' => $jml_filling_pr_79,
                'jml_filling_lk_912' => $jml_filling_lk_912,
                'jml_filling_pr_912' => $jml_filling_pr_912,
                'jml_filling_lk_79_anak' => $jml_filling_lk_79_anak,
                'jml_filling_pr_79_anak' => $jml_filling_pr_79_anak,
                'jml_filling_lk_912_anak' => $jml_filling_lk_912_anak,
                'jml_filling_pr_912_anak' => $jml_filling_pr_912_anak,
                #Decay
                'jml_decay_lk_7' => $jml_decay_lk_7,
                'jml_decay_pr_7' => $jml_decay_pr_7,
                'jml_decay_lk_8' => $jml_decay_lk_8,
                'jml_decay_pr_8' => $jml_decay_pr_8,
                'jml_decay_lk_9' => $jml_decay_lk_9,
                'jml_decay_pr_9' => $jml_decay_pr_9,
                'jml_decay_lk_10' => $jml_decay_lk_10,
                'jml_decay_pr_10' => $jml_decay_pr_10,
                'jml_decay_lk_11' => $jml_decay_lk_11,
                'jml_decay_pr_11' => $jml_decay_pr_11,
                'jml_decay_lk_12' => $jml_decay_lk_12,
                'jml_decay_pr_12' => $jml_decay_pr_12,
                #Decay-anak
                'jml_decay_lk_7_anak' => $jml_decay_lk_7_anak,
                'jml_decay_pr_7_anak' => $jml_decay_pr_7_anak,
                'jml_decay_lk_8_anak' => $jml_decay_lk_8_anak,
                'jml_decay_pr_8_anak' => $jml_decay_pr_8_anak,
                'jml_decay_lk_9_anak' => $jml_decay_lk_9_anak,
                'jml_decay_pr_9_anak' => $jml_decay_pr_9_anak,
                'jml_decay_lk_10_anak' => $jml_decay_lk_10_anak,
                'jml_decay_pr_10_anak' => $jml_decay_pr_10_anak,
                'jml_decay_lk_11_anak' => $jml_decay_lk_11_anak,
                'jml_decay_pr_11_anak' => $jml_decay_pr_11_anak,
                'jml_decay_lk_12_anak' => $jml_decay_lk_12_anak,
                'jml_decay_pr_12_anak' => $jml_decay_pr_12_anak,
                #Missing
                'jml_missing_lk_7' => $jml_missing_lk_7,
                'jml_missing_pr_7' => $jml_missing_pr_7,
                'jml_missing_lk_8' => $jml_missing_lk_8,
                'jml_missing_pr_8' => $jml_missing_pr_8,
                'jml_missing_lk_9' => $jml_missing_lk_9,
                'jml_missing_pr_9' => $jml_missing_pr_9,
                'jml_missing_lk_10' => $jml_missing_lk_10,
                'jml_missing_pr_10' => $jml_missing_pr_10,
                'jml_missing_lk_11' => $jml_missing_lk_11,
                'jml_missing_pr_11' => $jml_missing_pr_11,
                'jml_missing_lk_12' => $jml_missing_lk_12,
                'jml_missing_pr_12' => $jml_missing_pr_12,
                #missing-anak
                'jml_missing_lk_7_anak' => $jml_missing_lk_7_anak,
                'jml_missing_pr_7_anak' => $jml_missing_pr_7_anak,
                'jml_missing_lk_8_anak' => $jml_missing_lk_8_anak,
                'jml_missing_pr_8_anak' => $jml_missing_pr_8_anak,
                'jml_missing_lk_9_anak' => $jml_missing_lk_9_anak,
                'jml_missing_pr_9_anak' => $jml_missing_pr_9_anak,
                'jml_missing_lk_10_anak' => $jml_missing_lk_10_anak,
                'jml_missing_pr_10_anak' => $jml_missing_pr_10_anak,
                'jml_missing_lk_11_anak' => $jml_missing_lk_11_anak,
                'jml_missing_pr_11_anak' => $jml_missing_pr_11_anak,
                'jml_missing_lk_12_anak' => $jml_missing_lk_12_anak,
                'jml_missing_pr_12_anak' => $jml_missing_pr_12_anak,
                #filling
                'jml_filling_lk_7' => $jml_filling_lk_7,
                'jml_filling_pr_7' => $jml_filling_pr_7,
                'jml_filling_lk_8' => $jml_filling_lk_8,
                'jml_filling_pr_8' => $jml_filling_pr_8,
                'jml_filling_lk_9' => $jml_filling_lk_9,
                'jml_filling_pr_9' => $jml_filling_pr_9,
                'jml_filling_lk_10' => $jml_filling_lk_10,
                'jml_filling_pr_10' => $jml_filling_pr_10,
                'jml_filling_lk_11' => $jml_filling_lk_11,
                'jml_filling_pr_11' => $jml_filling_pr_11,
                'jml_filling_lk_12' => $jml_filling_lk_12,
                'jml_filling_pr_12' => $jml_filling_pr_12,
                #filling-anak
                'jml_filling_lk_7_anak' => $jml_filling_lk_7_anak,
                'jml_filling_pr_7_anak' => $jml_filling_pr_7_anak,
                'jml_filling_lk_8_anak' => $jml_filling_lk_8_anak,
                'jml_filling_pr_8_anak' => $jml_filling_pr_8_anak,
                'jml_filling_lk_9_anak' => $jml_filling_lk_9_anak,
                'jml_filling_pr_9_anak' => $jml_filling_pr_9_anak,
                'jml_filling_lk_10_anak' => $jml_filling_lk_10_anak,
                'jml_filling_pr_10_anak' => $jml_filling_pr_10_anak,
                'jml_filling_lk_11_anak' => $jml_filling_lk_11_anak,
                'jml_filling_pr_11_anak' => $jml_filling_pr_11_anak,
                'jml_filling_lk_12_anak' => $jml_filling_lk_12_anak,
                'jml_filling_pr_12_anak' => $jml_filling_pr_12_anak,
                #array
                'array_decay' => $array_decay,
                'array_missing' => $array_missing,
                'array_filling' => $array_filling,
                #label
                'max_rti' => $max_rti,
                'min_rti' => $min_rti,
                'max_rti_label' => $max_rti_label,
                'min_rti_label' => $min_rti_label,
                'max_rti_anak' => $max_rti_anak,
                'min_rti_anak' => $min_rti_anak,
                'max_rti_anak_label' => $max_rti_anak_label,
                'min_rti_anak_label' => $min_rti_anak_label,
                'total_responden' => $total_responden
            ]);
        }
    }
    public function generateReportBySchool()
    {
        $sekolah = ['SDN Biting 04', 'SDN Candijati 01'];

        return view('dashboard-admin.laporan.by_school', [
            'sekolah' => $sekolah,
            'result' => 0,
        ]);
    }
    public function submitgenerateReportBySchool(Request $request)
    {
        $sekolah = $request->sekolah;
        $type = $request->type;

        $query_general = DB::table('users as u')->select(DB::raw(' b.gender as jenis_kelamin, count(u.id) as jumlah, sum(dmft_score)/count(u.id) as rata_rata_dmft, 
        sum(deft_score)/count(u.id) as rata_rata_deft, sum(u.num_decay)/sum(dmft_score) as rata_rata_rti, sum(u.num_decay_anak)/sum(deft_score) as rata_rata_rti_anak'))
            ->leftJoin('users_biodata as b', 'b.users_id', '=', 'u.id')->where('u.is_admin', '=', 0)->where('b.id_sekolah', '=', $sekolah)->where('u.is_deleted', '=', 0)
            ->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 
        <= 13')->groupBy('b.gender')->get();
        $query_klp_usia = DB::table('users as u')->select(DB::raw('b.gender as jenis_kelamin, 
            case when DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 < 8 then \'Usia 7 th\'
            when DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 8 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 < 9 then \'Usia 8 th\'
            when DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 9 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 < 10 then \'Usia 9 th\'
            when DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 10 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 < 11 then \'Usia 10 th\'
            when DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 11 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 < 12 then \'Usia 11 th\'     
            when DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 12 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 <= 13 then \'Usia 12 th\' end as kategori_umur, 
            count(u.id) as jumlah, sum(dmft_score)/count(u.id) as rata_rata_dmft, sum(deft_score)/count(u.id) as rata_rata_deft, sum(u.num_decay)/sum(dmft_score) as rata_rata_rti,
            sum(u.num_decay_anak)/sum(deft_score) as rata_rata_rti_anak'))->leftJoin('users_biodata as b', 'b.users_id', '=', 'u.id')->where('u.is_admin', '=', 0)
            ->where('u.is_deleted', '=', 0)->where('b.id_sekolah', '=', $sekolah)->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 <= 13')->groupBy('b.gender', 'kategori_umur')->get();
        $query_total = DB::table('users as u')->select(DB::raw('count(u.id) as jumlah, sum(dmft_score)/count(u.id) as rata_rata_dmft, sum(deft_score)/count(u.id) as rata_rata_deft,
            sum(u.num_decay)/sum(dmft_score) as rata_rata_rti, sum(u.num_decay_anak)/sum(deft_score) as rata_rata_rti_anak'))->leftJoin('users_biodata as b', 'b.users_id', '=', 'u.id')->where('u.is_admin', '=', 0)
            ->where('b.id_sekolah', '=', $sekolah)->where('u.is_deleted', '=', 0)->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 <= 13')->get();

        $query_total_by_age = DB::table('users as u')->select(DB::raw('DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 as age, count(u.id) as jumlah, sum(dmft_score)/count(u.id) as rata_rata_dmft, sum(deft_score)/count(u.id) as rata_rata_deft,
            sum(u.num_decay)/sum(dmft_score) as rata_rata_rti, sum(u.num_decay_anak)/sum(deft_score) as rata_rata_rti_anak'))->leftJoin('users_biodata as b', 'b.users_id', '=', 'u.id')->where('u.is_admin', '=', 0)
            ->where('u.is_deleted', '=', 0)->where('b.id_sekolah', '=', $sekolah)->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0 <= 13')->groupByRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(u.created_at, b.birth_date)), "%Y")+0')->get();

        $users_id_lk_79 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 10')
            ->where('gender', '=', 'Laki-laki')->where('id_sekolah', '=', $sekolah)->get();
        $users_id_pr_79 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 10')
            ->where('gender', '=', 'Perempuan')->where('id_sekolah', '=', $sekolah)->get();
        $users_id_lk_912 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 10 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 <= 13')
            ->where('gender', '=', 'Laki-laki')->where('id_sekolah', '=', $sekolah)->get();
        $users_id_pr_912 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 10 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 <= 13')
            ->where('gender', '=', 'Perempuan')->where('id_sekolah', '=', $sekolah)->get();

        //pengelompokan usia
        $users_id_lk_7 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 8')
            ->where('gender', '=', 'Laki-laki')->where('id_sekolah', '=', $sekolah)->get();
        $users_id_pr_7 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 7 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 8')
            ->where('gender', '=', 'Perempuan')->where('id_sekolah', '=', $sekolah)->get();
        $users_id_lk_8 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 8 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 9')
            ->where('gender', '=', 'Laki-laki')->where('id_sekolah', '=', $sekolah)->get();
        $users_id_pr_8 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 8 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 9')
            ->where('gender', '=', 'Perempuan')->where('id_sekolah', '=', $sekolah)->get();
        $users_id_lk_9 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 9 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 10')
            ->where('gender', '=', 'Laki-laki')->where('id_sekolah', '=', $sekolah)->get();
        $users_id_pr_9 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 9 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 10')
            ->where('gender', '=', 'Perempuan')->where('id_sekolah', '=', $sekolah)->get();
        $users_id_lk_10 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 10 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 11')
            ->where('gender', '=', 'Laki-laki')->where('id_sekolah', '=', $sekolah)->get();
        $users_id_pr_10 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 10 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 11')
            ->where('gender', '=', 'Perempuan')->where('id_sekolah', '=', $sekolah)->get();
        $users_id_lk_11 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 11 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 12')
            ->where('gender', '=', 'Laki-laki')->where('id_sekolah', '=', $sekolah)->get();
        $users_id_pr_11 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 11 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 < 12')
            ->where('gender', '=', 'Perempuan')->where('id_sekolah', '=', $sekolah)->get();
        $users_id_lk_12 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 12 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 <= 13')
            ->where('gender', '=', 'Laki-laki')->where('id_sekolah', '=', $sekolah)->get();
        $users_id_pr_12 = Biodata::select('users_id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 >= 12 and DATE_FORMAT(FROM_DAYS(DATEDIFF(users_biodata.created_at, users_biodata.birth_date)), "%Y")+0 <= 13')
            ->where('gender', '=', 'Perempuan')->where('id_sekolah', '=', $sekolah)->get();

        ##decay num.
        $jml_decay_lk_79 = Diagnosis::whereIn('users_id', $users_id_lk_79)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_79 = Diagnosis::whereIn('users_id', $users_id_pr_79)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_lk_912 = Diagnosis::whereIn('users_id', $users_id_lk_912)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_912 = Diagnosis::whereIn('users_id', $users_id_pr_912)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        ##decay num. (anak)
        $jml_decay_lk_79_anak = Diagnosis::whereIn('users_id', $users_id_lk_79)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_79_anak = Diagnosis::whereIn('users_id', $users_id_pr_79)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_lk_912_anak = Diagnosis::whereIn('users_id', $users_id_lk_912)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_912_anak = Diagnosis::whereIn('users_id', $users_id_pr_912)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        ##missing num.
        $jml_missing_lk_79 = Diagnosis::whereIn('users_id', $users_id_lk_79)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_79 = Diagnosis::whereIn('users_id', $users_id_pr_79)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_lk_912 = Diagnosis::whereIn('users_id', $users_id_lk_912)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_912 = Diagnosis::whereIn('users_id', $users_id_pr_912)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        ##missing num. (anak)
        $jml_missing_lk_79_anak = Diagnosis::whereIn('users_id', $users_id_lk_79)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_79_anak = Diagnosis::whereIn('users_id', $users_id_pr_79)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_lk_912_anak = Diagnosis::whereIn('users_id', $users_id_lk_912)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_912_anak = Diagnosis::whereIn('users_id', $users_id_pr_912)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        ##filling num.
        $jml_filling_lk_79 = Diagnosis::whereIn('users_id', $users_id_lk_79)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_79 = Diagnosis::whereIn('users_id', $users_id_pr_79)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_lk_912 = Diagnosis::whereIn('users_id', $users_id_lk_912)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_912 = Diagnosis::whereIn('users_id', $users_id_pr_912)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        ##filling num. (anak)
        $jml_filling_lk_79_anak = Diagnosis::whereIn('users_id', $users_id_lk_79)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_79_anak = Diagnosis::whereIn('users_id', $users_id_pr_79)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_lk_912_anak = Diagnosis::whereIn('users_id', $users_id_lk_912)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_912_anak = Diagnosis::whereIn('users_id', $users_id_pr_912)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();

        ##decay num.
        $jml_decay_lk_7 = Diagnosis::whereIn('users_id', $users_id_lk_7)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_7 = Diagnosis::whereIn('users_id', $users_id_pr_7)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_lk_8 = Diagnosis::whereIn('users_id', $users_id_lk_8)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_8 = Diagnosis::whereIn('users_id', $users_id_pr_8)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_lk_9 = Diagnosis::whereIn('users_id', $users_id_lk_9)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_9 = Diagnosis::whereIn('users_id', $users_id_pr_9)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_lk_10 = Diagnosis::whereIn('users_id', $users_id_lk_10)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_10 = Diagnosis::whereIn('users_id', $users_id_pr_10)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_lk_11 = Diagnosis::whereIn('users_id', $users_id_lk_11)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_11 = Diagnosis::whereIn('users_id', $users_id_pr_11)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_lk_12 = Diagnosis::whereIn('users_id', $users_id_lk_12)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_12 = Diagnosis::whereIn('users_id', $users_id_pr_12)->whereBetween('id_gigi', [11, 48])->where('is_decay', '=', 1)
            ->count();

        ##decay num. (anak)
        $jml_decay_lk_7_anak = Diagnosis::whereIn('users_id', $users_id_lk_7)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_7_anak = Diagnosis::whereIn('users_id', $users_id_pr_7)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_lk_8_anak = Diagnosis::whereIn('users_id', $users_id_lk_8)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_8_anak = Diagnosis::whereIn('users_id', $users_id_pr_8)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_lk_9_anak = Diagnosis::whereIn('users_id', $users_id_lk_9)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_9_anak = Diagnosis::whereIn('users_id', $users_id_pr_9)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_lk_10_anak = Diagnosis::whereIn('users_id', $users_id_lk_10)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_10_anak = Diagnosis::whereIn('users_id', $users_id_pr_10)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_lk_11_anak = Diagnosis::whereIn('users_id', $users_id_lk_11)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_11_anak = Diagnosis::whereIn('users_id', $users_id_pr_11)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_lk_12_anak = Diagnosis::whereIn('users_id', $users_id_lk_12)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();
        $jml_decay_pr_12_anak = Diagnosis::whereIn('users_id', $users_id_pr_12)->whereBetween('id_gigi', [51, 85])->where('is_decay', '=', 1)
            ->count();

        ## missing
        $jml_missing_lk_7 = Diagnosis::whereIn('users_id', $users_id_lk_7)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_7 = Diagnosis::whereIn('users_id', $users_id_pr_7)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_lk_8 = Diagnosis::whereIn('users_id', $users_id_lk_8)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_8 = Diagnosis::whereIn('users_id', $users_id_pr_8)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_lk_9 = Diagnosis::whereIn('users_id', $users_id_lk_9)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_9 = Diagnosis::whereIn('users_id', $users_id_pr_9)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_lk_10 = Diagnosis::whereIn('users_id', $users_id_lk_10)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_10 = Diagnosis::whereIn('users_id', $users_id_pr_10)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_lk_11 = Diagnosis::whereIn('users_id', $users_id_lk_11)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_11 = Diagnosis::whereIn('users_id', $users_id_pr_11)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_lk_12 = Diagnosis::whereIn('users_id', $users_id_lk_12)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_12 = Diagnosis::whereIn('users_id', $users_id_pr_12)->whereBetween('id_gigi', [11, 48])->where('is_missing', '=', 1)
            ->count();

        ##missing num. (anak)
        $jml_missing_lk_7_anak = Diagnosis::whereIn('users_id', $users_id_lk_7)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_7_anak = Diagnosis::whereIn('users_id', $users_id_pr_7)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_lk_8_anak = Diagnosis::whereIn('users_id', $users_id_lk_8)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_8_anak = Diagnosis::whereIn('users_id', $users_id_pr_8)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_lk_9_anak = Diagnosis::whereIn('users_id', $users_id_lk_9)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_9_anak = Diagnosis::whereIn('users_id', $users_id_pr_9)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_lk_10_anak = Diagnosis::whereIn('users_id', $users_id_lk_10)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_10_anak = Diagnosis::whereIn('users_id', $users_id_pr_10)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_lk_11_anak = Diagnosis::whereIn('users_id', $users_id_lk_11)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_11_anak = Diagnosis::whereIn('users_id', $users_id_pr_11)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_lk_12_anak = Diagnosis::whereIn('users_id', $users_id_lk_12)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();
        $jml_missing_pr_12_anak = Diagnosis::whereIn('users_id', $users_id_pr_12)->whereBetween('id_gigi', [51, 85])->where('is_missing', '=', 1)
            ->count();

        ##filling
        ##decay num.
        $jml_filling_lk_7 = Diagnosis::whereIn('users_id', $users_id_lk_7)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_7 = Diagnosis::whereIn('users_id', $users_id_pr_7)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_lk_8 = Diagnosis::whereIn('users_id', $users_id_lk_8)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_8 = Diagnosis::whereIn('users_id', $users_id_pr_8)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_lk_9 = Diagnosis::whereIn('users_id', $users_id_lk_9)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_9 = Diagnosis::whereIn('users_id', $users_id_pr_9)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_lk_10 = Diagnosis::whereIn('users_id', $users_id_lk_10)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_10 = Diagnosis::whereIn('users_id', $users_id_pr_10)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_lk_11 = Diagnosis::whereIn('users_id', $users_id_lk_11)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_11 = Diagnosis::whereIn('users_id', $users_id_pr_11)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_lk_12 = Diagnosis::whereIn('users_id', $users_id_lk_12)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_12 = Diagnosis::whereIn('users_id', $users_id_pr_12)->whereBetween('id_gigi', [11, 48])->where('is_filling', '=', 1)
            ->count();

        ##filling num. (anak)
        $jml_filling_lk_7_anak = Diagnosis::whereIn('users_id', $users_id_lk_7)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_7_anak = Diagnosis::whereIn('users_id', $users_id_pr_7)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_lk_8_anak = Diagnosis::whereIn('users_id', $users_id_lk_8)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_8_anak = Diagnosis::whereIn('users_id', $users_id_pr_8)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_lk_9_anak = Diagnosis::whereIn('users_id', $users_id_lk_9)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_9_anak = Diagnosis::whereIn('users_id', $users_id_pr_9)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_lk_10_anak = Diagnosis::whereIn('users_id', $users_id_lk_10)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_10_anak = Diagnosis::whereIn('users_id', $users_id_pr_10)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_lk_11_anak = Diagnosis::whereIn('users_id', $users_id_lk_11)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_11_anak = Diagnosis::whereIn('users_id', $users_id_pr_11)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_lk_12_anak = Diagnosis::whereIn('users_id', $users_id_lk_12)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();
        $jml_filling_pr_12_anak = Diagnosis::whereIn('users_id', $users_id_pr_12)->whereBetween('id_gigi', [51, 85])->where('is_filling', '=', 1)
            ->count();

        //array num decay missing filing - by age
        $num_decay_age = [];
        $num_missing_age = [];
        $num_filling_age = [];
        $num_decay_anak_age = [];
        $num_missing_anak_age = [];
        $num_filling_anak_age = [];

        for ($i = 7; $i < 13; $i++) {
            $users_id = '';
            if ($i != 12) {
                $users_id = User::select('users.id')->join('users_biodata as b', 'b.users_id', '=', 'users.id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users.created_at, b.birth_date)), "%Y")+0 >=' . $i . ' and DATE_FORMAT(FROM_DAYS(DATEDIFF(users.created_at, b.birth_date)), "%Y")+0 <' . $i + 1)->where('b.id_sekolah', '=', $sekolah)->get();
            } else {
                $users_id = User::select('users.id')->join('users_biodata as b', 'b.users_id', '=', 'users.id')->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users.created_at, b.birth_date)), "%Y")+0 >=' . $i . ' and DATE_FORMAT(FROM_DAYS(DATEDIFF(users.created_at, b.birth_date)), "%Y")+0 <=' . $i + 1)->where('b.id_sekolah', '=', $sekolah)->get();
            }
            $diagnosis_decay = Diagnosis::whereIn('users_id', $users_id)->where('is_decay', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
            array_push($num_decay_age, $diagnosis_decay);
            $diagnosis_missing = Diagnosis::whereIn('users_id', $users_id)->where('is_missing', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
            array_push($num_missing_age, $diagnosis_missing);
            $diagnosis_filling = Diagnosis::whereIn('users_id', $users_id)->where('is_filling', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
            array_push($num_filling_age, $diagnosis_filling);
            $diagnosis_decay = Diagnosis::whereIn('users_id', $users_id)->where('is_decay', '=', 1)->whereBetween('id_gigi', [51, 85])->count();
            array_push($num_decay_anak_age, $diagnosis_decay);
            $diagnosis_missing = Diagnosis::whereIn('users_id', $users_id)->where('is_missing', '=', 1)->whereBetween('id_gigi', [51, 85])->count();
            array_push($num_missing_anak_age, $diagnosis_missing);
            $diagnosis_filling = Diagnosis::whereIn('users_id', $users_id)->where('is_filling', '=', 1)->whereBetween('id_gigi', [51, 85])->count();
            array_push($num_filling_anak_age, $diagnosis_filling);
        }

        $min_dmft = 999999;
        $min_dmft_label = '';
        $max_dmft = 0;
        $max_dmft_label = '';
        $min_deft = 999999;
        $min_deft_label = '';
        $max_deft = 0;
        $max_deft_label = '';
        $min_rti = 999999;
        $min_rti_label = '';
        $max_rti = 0;
        $max_rti_label = '';
        $min_rti_anak = 999999;
        $min_rti_anak_label = '';
        $max_rti_anak = 0;
        $max_rti_anak_label = '';
        foreach ($query_total_by_age as $q) {
            if ($q->rata_rata_dmft >= $max_dmft) {
                $max_dmft = $q->rata_rata_dmft;
                $max_dmft_label = $q->age;
            }
            if ($q->rata_rata_dmft <= $min_dmft) {
                $min_dmft = $q->rata_rata_dmft;
                $min_dmft_label = $q->age;
            }
            if ($q->rata_rata_deft >= $max_deft) {
                $max_deft = $q->rata_rata_deft;
                $max_deft_label = $q->age;
            }
            if ($q->rata_rata_deft <= $min_deft) {
                $min_deft = $q->rata_rata_deft;
                $min_deft_label = $q->age;
            }
        }
        $j = 0;
        for ($i = 7; $i < 13; $i++) {
            if ($num_decay_age[$j] / ($num_decay_age[$j] + $num_missing_age[$j] + $num_filling_age[$j]) >= $max_rti) {
                $max_rti = $num_decay_age[$j] / ($num_decay_age[$j] + $num_missing_age[$j] + $num_filling_age[$j]);
                $max_rti_label = $i;
            }
            if ($num_decay_age[$j] / ($num_decay_age[$j] + $num_missing_age[$j] + $num_filling_age[$j]) <= $min_rti) {
                $min_rti = $num_decay_age[$j] / ($num_decay_age[$j] + $num_missing_age[$j] + $num_filling_age[$j]);
                $min_rti_label = $i;
            }
            if ($num_decay_anak_age[$j] / ($num_decay_anak_age[$j] + $num_missing_anak_age[$j] + $num_filling_anak_age[$j]) >= $max_rti_anak) {
                $max_rti_anak = $num_decay_anak_age[$j] / ($num_decay_anak_age[$j] + $num_missing_anak_age[$j] + $num_filling_anak_age[$j]);
                $max_rti_anak_label = $i;
            }
            if ($num_decay_anak_age[$j] / ($num_decay_anak_age[$j] + $num_missing_anak_age[$j] + $num_filling_anak_age[$j]) <= $min_rti_anak) {
                $min_rti_anak = $num_decay_anak_age[$j] / ($num_decay_anak_age[$j] + $num_missing_anak_age[$j] + $num_filling_anak_age[$j]);
                $min_rti_anak_label = $i;
            }
            $j++;
        }

        $total_responden = DB::table('users')->join('users_biodata as b', 'users.id', '=', 'b.users_id')->where('users.is_admin', '=', 0)
            ->where('users.is_deleted', '=', 0)->where('b.id_sekolah', '=', $sekolah)->whereRaw('DATE_FORMAT(FROM_DAYS(DATEDIFF(users.created_at, b.birth_date)), "%Y")+0 between 7 and 13')->count();

        $sekolah = ['SDN Biting 04', 'SDN Candijati 01'];
        if ($type == null) {
            return view('dashboard-admin.laporan.by_school', [
                'query_klp_usia' => $query_klp_usia,
                'query_general' => $query_general,
                'query_total' => $query_total,
                'result' => 1,
                'sekolah' => $sekolah,
                'sekolah_selected' => $request->sekolah,
                'query_total_by_age' => $query_total_by_age,
                'jml_decay_lk_79' => $jml_decay_lk_79,
                'jml_decay_pr_79' => $jml_decay_pr_79,
                'jml_decay_lk_912' => $jml_decay_lk_912,
                'jml_decay_pr_912' => $jml_decay_pr_912,
                'jml_decay_lk_79_anak' => $jml_decay_lk_79_anak,
                'jml_decay_pr_79_anak' => $jml_decay_pr_79_anak,
                'jml_decay_lk_912_anak' => $jml_decay_lk_912_anak,
                'jml_decay_pr_912_anak' => $jml_decay_pr_912_anak,
                'jml_missing_lk_79' => $jml_missing_lk_79,
                'jml_missing_pr_79' => $jml_missing_pr_79,
                'jml_missing_lk_912' => $jml_missing_lk_912,
                'jml_missing_pr_912' => $jml_missing_pr_912,
                'jml_missing_lk_79_anak' => $jml_missing_lk_79_anak,
                'jml_missing_pr_79_anak' => $jml_missing_pr_79_anak,
                'jml_missing_lk_912_anak' => $jml_missing_lk_912_anak,
                'jml_missing_pr_912_anak' => $jml_missing_pr_912_anak,
                'jml_filling_lk_79' => $jml_filling_lk_79,
                'jml_filling_pr_79' => $jml_filling_pr_79,
                'jml_filling_lk_912' => $jml_filling_lk_912,
                'jml_filling_pr_912' => $jml_filling_pr_912,
                'jml_filling_lk_79_anak' => $jml_filling_lk_79_anak,
                'jml_filling_pr_79_anak' => $jml_filling_pr_79_anak,
                'jml_filling_lk_912_anak' => $jml_filling_lk_912_anak,
                'jml_filling_pr_912_anak' => $jml_filling_pr_912_anak,
                #Decay
                'jml_decay_lk_7' => $jml_decay_lk_7,
                'jml_decay_pr_7' => $jml_decay_pr_7,
                'jml_decay_lk_8' => $jml_decay_lk_8,
                'jml_decay_pr_8' => $jml_decay_pr_8,
                'jml_decay_lk_9' => $jml_decay_lk_9,
                'jml_decay_pr_9' => $jml_decay_pr_9,
                'jml_decay_lk_10' => $jml_decay_lk_10,
                'jml_decay_pr_10' => $jml_decay_pr_10,
                'jml_decay_lk_11' => $jml_decay_lk_11,
                'jml_decay_pr_11' => $jml_decay_pr_11,
                'jml_decay_lk_12' => $jml_decay_lk_12,
                'jml_decay_pr_12' => $jml_decay_pr_12,
                #Decay-anak
                'jml_decay_lk_7_anak' => $jml_decay_lk_7_anak,
                'jml_decay_pr_7_anak' => $jml_decay_pr_7_anak,
                'jml_decay_lk_8_anak' => $jml_decay_lk_8_anak,
                'jml_decay_pr_8_anak' => $jml_decay_pr_8_anak,
                'jml_decay_lk_9_anak' => $jml_decay_lk_9_anak,
                'jml_decay_pr_9_anak' => $jml_decay_pr_9_anak,
                'jml_decay_lk_10_anak' => $jml_decay_lk_10_anak,
                'jml_decay_pr_10_anak' => $jml_decay_pr_10_anak,
                'jml_decay_lk_11_anak' => $jml_decay_lk_11_anak,
                'jml_decay_pr_11_anak' => $jml_decay_pr_11_anak,
                'jml_decay_lk_12_anak' => $jml_decay_lk_12_anak,
                'jml_decay_pr_12_anak' => $jml_decay_pr_12_anak,
                #Missing
                'jml_missing_lk_7' => $jml_missing_lk_7,
                'jml_missing_pr_7' => $jml_missing_pr_7,
                'jml_missing_lk_8' => $jml_missing_lk_8,
                'jml_missing_pr_8' => $jml_missing_pr_8,
                'jml_missing_lk_9' => $jml_missing_lk_9,
                'jml_missing_pr_9' => $jml_missing_pr_9,
                'jml_missing_lk_10' => $jml_missing_lk_10,
                'jml_missing_pr_10' => $jml_missing_pr_10,
                'jml_missing_lk_11' => $jml_missing_lk_11,
                'jml_missing_pr_11' => $jml_missing_pr_11,
                'jml_missing_lk_12' => $jml_missing_lk_12,
                'jml_missing_pr_12' => $jml_missing_pr_12,
                #missing-anak
                'jml_missing_lk_7_anak' => $jml_missing_lk_7_anak,
                'jml_missing_pr_7_anak' => $jml_missing_pr_7_anak,
                'jml_missing_lk_8_anak' => $jml_missing_lk_8_anak,
                'jml_missing_pr_8_anak' => $jml_missing_pr_8_anak,
                'jml_missing_lk_9_anak' => $jml_missing_lk_9_anak,
                'jml_missing_pr_9_anak' => $jml_missing_pr_9_anak,
                'jml_missing_lk_10_anak' => $jml_missing_lk_10_anak,
                'jml_missing_pr_10_anak' => $jml_missing_pr_10_anak,
                'jml_missing_lk_11_anak' => $jml_missing_lk_11_anak,
                'jml_missing_pr_11_anak' => $jml_missing_pr_11_anak,
                'jml_missing_lk_12_anak' => $jml_missing_lk_12_anak,
                'jml_missing_pr_12_anak' => $jml_missing_pr_12_anak,
                #filling
                'jml_filling_lk_7' => $jml_filling_lk_7,
                'jml_filling_pr_7' => $jml_filling_pr_7,
                'jml_filling_lk_8' => $jml_filling_lk_8,
                'jml_filling_pr_8' => $jml_filling_pr_8,
                'jml_filling_lk_9' => $jml_filling_lk_9,
                'jml_filling_pr_9' => $jml_filling_pr_9,
                'jml_filling_lk_10' => $jml_filling_lk_10,
                'jml_filling_pr_10' => $jml_filling_pr_10,
                'jml_filling_lk_11' => $jml_filling_lk_11,
                'jml_filling_pr_11' => $jml_filling_pr_11,
                'jml_filling_lk_12' => $jml_filling_lk_12,
                'jml_filling_pr_12' => $jml_filling_pr_12,
                #filling-anak
                'jml_filling_lk_7_anak' => $jml_filling_lk_7_anak,
                'jml_filling_pr_7_anak' => $jml_filling_pr_7_anak,
                'jml_filling_lk_8_anak' => $jml_filling_lk_8_anak,
                'jml_filling_pr_8_anak' => $jml_filling_pr_8_anak,
                'jml_filling_lk_9_anak' => $jml_filling_lk_9_anak,
                'jml_filling_pr_9_anak' => $jml_filling_pr_9_anak,
                'jml_filling_lk_10_anak' => $jml_filling_lk_10_anak,
                'jml_filling_pr_10_anak' => $jml_filling_pr_10_anak,
                'jml_filling_lk_11_anak' => $jml_filling_lk_11_anak,
                'jml_filling_pr_11_anak' => $jml_filling_pr_11_anak,
                'jml_filling_lk_12_anak' => $jml_filling_lk_12_anak,
                'jml_filling_pr_12_anak' => $jml_filling_pr_12_anak,
                'total_responden' => $total_responden
            ]);
        } else if ($type == 'responden') {
            return view('dashboard-admin.laporan.responden-by_school', [
                'type' => 'responden',
                'query_klp_usia' => $query_klp_usia,
                'query_general' => $query_general,
                'query_total' => $query_total,
                'result' => 1,
                'sekolah' => $sekolah,
                'sekolah_selected' => $request->sekolah,
                'query_total_by_age' => $query_total_by_age,
                'jml_decay_lk_79' => $jml_decay_lk_79,
                'jml_decay_pr_79' => $jml_decay_pr_79,
                'jml_decay_lk_912' => $jml_decay_lk_912,
                'jml_decay_pr_912' => $jml_decay_pr_912,
                'jml_decay_lk_79_anak' => $jml_decay_lk_79_anak,
                'jml_decay_pr_79_anak' => $jml_decay_pr_79_anak,
                'jml_decay_lk_912_anak' => $jml_decay_lk_912_anak,
                'jml_decay_pr_912_anak' => $jml_decay_pr_912_anak,
                'jml_missing_lk_79' => $jml_missing_lk_79,
                'jml_missing_pr_79' => $jml_missing_pr_79,
                'jml_missing_lk_912' => $jml_missing_lk_912,
                'jml_missing_pr_912' => $jml_missing_pr_912,
                'jml_missing_lk_79_anak' => $jml_missing_lk_79_anak,
                'jml_missing_pr_79_anak' => $jml_missing_pr_79_anak,
                'jml_missing_lk_912_anak' => $jml_missing_lk_912_anak,
                'jml_missing_pr_912_anak' => $jml_missing_pr_912_anak,
                'jml_filling_lk_79' => $jml_filling_lk_79,
                'jml_filling_pr_79' => $jml_filling_pr_79,
                'jml_filling_lk_912' => $jml_filling_lk_912,
                'jml_filling_pr_912' => $jml_filling_pr_912,
                'jml_filling_lk_79_anak' => $jml_filling_lk_79_anak,
                'jml_filling_pr_79_anak' => $jml_filling_pr_79_anak,
                'jml_filling_lk_912_anak' => $jml_filling_lk_912_anak,
                'jml_filling_pr_912_anak' => $jml_filling_pr_912_anak,
                #Decay
                'jml_decay_lk_7' => $jml_decay_lk_7,
                'jml_decay_pr_7' => $jml_decay_pr_7,
                'jml_decay_lk_8' => $jml_decay_lk_8,
                'jml_decay_pr_8' => $jml_decay_pr_8,
                'jml_decay_lk_9' => $jml_decay_lk_9,
                'jml_decay_pr_9' => $jml_decay_pr_9,
                'jml_decay_lk_10' => $jml_decay_lk_10,
                'jml_decay_pr_10' => $jml_decay_pr_10,
                'jml_decay_lk_11' => $jml_decay_lk_11,
                'jml_decay_pr_11' => $jml_decay_pr_11,
                'jml_decay_lk_12' => $jml_decay_lk_12,
                'jml_decay_pr_12' => $jml_decay_pr_12,
                #Decay-anak
                'jml_decay_lk_7_anak' => $jml_decay_lk_7_anak,
                'jml_decay_pr_7_anak' => $jml_decay_pr_7_anak,
                'jml_decay_lk_8_anak' => $jml_decay_lk_8_anak,
                'jml_decay_pr_8_anak' => $jml_decay_pr_8_anak,
                'jml_decay_lk_9_anak' => $jml_decay_lk_9_anak,
                'jml_decay_pr_9_anak' => $jml_decay_pr_9_anak,
                'jml_decay_lk_10_anak' => $jml_decay_lk_10_anak,
                'jml_decay_pr_10_anak' => $jml_decay_pr_10_anak,
                'jml_decay_lk_11_anak' => $jml_decay_lk_11_anak,
                'jml_decay_pr_11_anak' => $jml_decay_pr_11_anak,
                'jml_decay_lk_12_anak' => $jml_decay_lk_12_anak,
                'jml_decay_pr_12_anak' => $jml_decay_pr_12_anak,
                #Missing
                'jml_missing_lk_7' => $jml_missing_lk_7,
                'jml_missing_pr_7' => $jml_missing_pr_7,
                'jml_missing_lk_8' => $jml_missing_lk_8,
                'jml_missing_pr_8' => $jml_missing_pr_8,
                'jml_missing_lk_9' => $jml_missing_lk_9,
                'jml_missing_pr_9' => $jml_missing_pr_9,
                'jml_missing_lk_10' => $jml_missing_lk_10,
                'jml_missing_pr_10' => $jml_missing_pr_10,
                'jml_missing_lk_11' => $jml_missing_lk_11,
                'jml_missing_pr_11' => $jml_missing_pr_11,
                'jml_missing_lk_12' => $jml_missing_lk_12,
                'jml_missing_pr_12' => $jml_missing_pr_12,
                #missing-anak
                'jml_missing_lk_7_anak' => $jml_missing_lk_7_anak,
                'jml_missing_pr_7_anak' => $jml_missing_pr_7_anak,
                'jml_missing_lk_8_anak' => $jml_missing_lk_8_anak,
                'jml_missing_pr_8_anak' => $jml_missing_pr_8_anak,
                'jml_missing_lk_9_anak' => $jml_missing_lk_9_anak,
                'jml_missing_pr_9_anak' => $jml_missing_pr_9_anak,
                'jml_missing_lk_10_anak' => $jml_missing_lk_10_anak,
                'jml_missing_pr_10_anak' => $jml_missing_pr_10_anak,
                'jml_missing_lk_11_anak' => $jml_missing_lk_11_anak,
                'jml_missing_pr_11_anak' => $jml_missing_pr_11_anak,
                'jml_missing_lk_12_anak' => $jml_missing_lk_12_anak,
                'jml_missing_pr_12_anak' => $jml_missing_pr_12_anak,
                #filling
                'jml_filling_lk_7' => $jml_filling_lk_7,
                'jml_filling_pr_7' => $jml_filling_pr_7,
                'jml_filling_lk_8' => $jml_filling_lk_8,
                'jml_filling_pr_8' => $jml_filling_pr_8,
                'jml_filling_lk_9' => $jml_filling_lk_9,
                'jml_filling_pr_9' => $jml_filling_pr_9,
                'jml_filling_lk_10' => $jml_filling_lk_10,
                'jml_filling_pr_10' => $jml_filling_pr_10,
                'jml_filling_lk_11' => $jml_filling_lk_11,
                'jml_filling_pr_11' => $jml_filling_pr_11,
                'jml_filling_lk_12' => $jml_filling_lk_12,
                'jml_filling_pr_12' => $jml_filling_pr_12,
                #filling-anak
                'jml_filling_lk_7_anak' => $jml_filling_lk_7_anak,
                'jml_filling_pr_7_anak' => $jml_filling_pr_7_anak,
                'jml_filling_lk_8_anak' => $jml_filling_lk_8_anak,
                'jml_filling_pr_8_anak' => $jml_filling_pr_8_anak,
                'jml_filling_lk_9_anak' => $jml_filling_lk_9_anak,
                'jml_filling_pr_9_anak' => $jml_filling_pr_9_anak,
                'jml_filling_lk_10_anak' => $jml_filling_lk_10_anak,
                'jml_filling_pr_10_anak' => $jml_filling_pr_10_anak,
                'jml_filling_lk_11_anak' => $jml_filling_lk_11_anak,
                'jml_filling_pr_11_anak' => $jml_filling_pr_11_anak,
                'jml_filling_lk_12_anak' => $jml_filling_lk_12_anak,
                'jml_filling_pr_12_anak' => $jml_filling_pr_12_anak,
                #label
                'max_dmft' => $max_dmft,
                'min_dmft' => $min_dmft,
                'max_dmft_label' => $max_dmft_label,
                'min_dmft_label' => $min_dmft_label,
                'total_responden' => $total_responden
            ]);
        } else if ($type == 'dmft') {
            return view('dashboard-admin.laporan.by_school-dmft', [
                'query_klp_usia' => $query_klp_usia,
                'query_general' => $query_general,
                'query_total' => $query_total,
                'result' => 1,
                'sekolah' => $sekolah,
                'sekolah_selected' => $request->sekolah,
                'query_total_by_age' => $query_total_by_age,
                'jml_decay_lk_79' => $jml_decay_lk_79,
                'jml_decay_pr_79' => $jml_decay_pr_79,
                'jml_decay_lk_912' => $jml_decay_lk_912,
                'jml_decay_pr_912' => $jml_decay_pr_912,
                'jml_decay_lk_79_anak' => $jml_decay_lk_79_anak,
                'jml_decay_pr_79_anak' => $jml_decay_pr_79_anak,
                'jml_decay_lk_912_anak' => $jml_decay_lk_912_anak,
                'jml_decay_pr_912_anak' => $jml_decay_pr_912_anak,
                'jml_missing_lk_79' => $jml_missing_lk_79,
                'jml_missing_pr_79' => $jml_missing_pr_79,
                'jml_missing_lk_912' => $jml_missing_lk_912,
                'jml_missing_pr_912' => $jml_missing_pr_912,
                'jml_missing_lk_79_anak' => $jml_missing_lk_79_anak,
                'jml_missing_pr_79_anak' => $jml_missing_pr_79_anak,
                'jml_missing_lk_912_anak' => $jml_missing_lk_912_anak,
                'jml_missing_pr_912_anak' => $jml_missing_pr_912_anak,
                'jml_filling_lk_79' => $jml_filling_lk_79,
                'jml_filling_pr_79' => $jml_filling_pr_79,
                'jml_filling_lk_912' => $jml_filling_lk_912,
                'jml_filling_pr_912' => $jml_filling_pr_912,
                'jml_filling_lk_79_anak' => $jml_filling_lk_79_anak,
                'jml_filling_pr_79_anak' => $jml_filling_pr_79_anak,
                'jml_filling_lk_912_anak' => $jml_filling_lk_912_anak,
                'jml_filling_pr_912_anak' => $jml_filling_pr_912_anak,
                #Decay
                'jml_decay_lk_7' => $jml_decay_lk_7,
                'jml_decay_pr_7' => $jml_decay_pr_7,
                'jml_decay_lk_8' => $jml_decay_lk_8,
                'jml_decay_pr_8' => $jml_decay_pr_8,
                'jml_decay_lk_9' => $jml_decay_lk_9,
                'jml_decay_pr_9' => $jml_decay_pr_9,
                'jml_decay_lk_10' => $jml_decay_lk_10,
                'jml_decay_pr_10' => $jml_decay_pr_10,
                'jml_decay_lk_11' => $jml_decay_lk_11,
                'jml_decay_pr_11' => $jml_decay_pr_11,
                'jml_decay_lk_12' => $jml_decay_lk_12,
                'jml_decay_pr_12' => $jml_decay_pr_12,
                #Decay-anak
                'jml_decay_lk_7_anak' => $jml_decay_lk_7_anak,
                'jml_decay_pr_7_anak' => $jml_decay_pr_7_anak,
                'jml_decay_lk_8_anak' => $jml_decay_lk_8_anak,
                'jml_decay_pr_8_anak' => $jml_decay_pr_8_anak,
                'jml_decay_lk_9_anak' => $jml_decay_lk_9_anak,
                'jml_decay_pr_9_anak' => $jml_decay_pr_9_anak,
                'jml_decay_lk_10_anak' => $jml_decay_lk_10_anak,
                'jml_decay_pr_10_anak' => $jml_decay_pr_10_anak,
                'jml_decay_lk_11_anak' => $jml_decay_lk_11_anak,
                'jml_decay_pr_11_anak' => $jml_decay_pr_11_anak,
                'jml_decay_lk_12_anak' => $jml_decay_lk_12_anak,
                'jml_decay_pr_12_anak' => $jml_decay_pr_12_anak,
                #Missing
                'jml_missing_lk_7' => $jml_missing_lk_7,
                'jml_missing_pr_7' => $jml_missing_pr_7,
                'jml_missing_lk_8' => $jml_missing_lk_8,
                'jml_missing_pr_8' => $jml_missing_pr_8,
                'jml_missing_lk_9' => $jml_missing_lk_9,
                'jml_missing_pr_9' => $jml_missing_pr_9,
                'jml_missing_lk_10' => $jml_missing_lk_10,
                'jml_missing_pr_10' => $jml_missing_pr_10,
                'jml_missing_lk_11' => $jml_missing_lk_11,
                'jml_missing_pr_11' => $jml_missing_pr_11,
                'jml_missing_lk_12' => $jml_missing_lk_12,
                'jml_missing_pr_12' => $jml_missing_pr_12,
                #missing-anak
                'jml_missing_lk_7_anak' => $jml_missing_lk_7_anak,
                'jml_missing_pr_7_anak' => $jml_missing_pr_7_anak,
                'jml_missing_lk_8_anak' => $jml_missing_lk_8_anak,
                'jml_missing_pr_8_anak' => $jml_missing_pr_8_anak,
                'jml_missing_lk_9_anak' => $jml_missing_lk_9_anak,
                'jml_missing_pr_9_anak' => $jml_missing_pr_9_anak,
                'jml_missing_lk_10_anak' => $jml_missing_lk_10_anak,
                'jml_missing_pr_10_anak' => $jml_missing_pr_10_anak,
                'jml_missing_lk_11_anak' => $jml_missing_lk_11_anak,
                'jml_missing_pr_11_anak' => $jml_missing_pr_11_anak,
                'jml_missing_lk_12_anak' => $jml_missing_lk_12_anak,
                'jml_missing_pr_12_anak' => $jml_missing_pr_12_anak,
                #filling
                'jml_filling_lk_7' => $jml_filling_lk_7,
                'jml_filling_pr_7' => $jml_filling_pr_7,
                'jml_filling_lk_8' => $jml_filling_lk_8,
                'jml_filling_pr_8' => $jml_filling_pr_8,
                'jml_filling_lk_9' => $jml_filling_lk_9,
                'jml_filling_pr_9' => $jml_filling_pr_9,
                'jml_filling_lk_10' => $jml_filling_lk_10,
                'jml_filling_pr_10' => $jml_filling_pr_10,
                'jml_filling_lk_11' => $jml_filling_lk_11,
                'jml_filling_pr_11' => $jml_filling_pr_11,
                'jml_filling_lk_12' => $jml_filling_lk_12,
                'jml_filling_pr_12' => $jml_filling_pr_12,
                #filling-anak
                'jml_filling_lk_7_anak' => $jml_filling_lk_7_anak,
                'jml_filling_pr_7_anak' => $jml_filling_pr_7_anak,
                'jml_filling_lk_8_anak' => $jml_filling_lk_8_anak,
                'jml_filling_pr_8_anak' => $jml_filling_pr_8_anak,
                'jml_filling_lk_9_anak' => $jml_filling_lk_9_anak,
                'jml_filling_pr_9_anak' => $jml_filling_pr_9_anak,
                'jml_filling_lk_10_anak' => $jml_filling_lk_10_anak,
                'jml_filling_pr_10_anak' => $jml_filling_pr_10_anak,
                'jml_filling_lk_11_anak' => $jml_filling_lk_11_anak,
                'jml_filling_pr_11_anak' => $jml_filling_pr_11_anak,
                'jml_filling_lk_12_anak' => $jml_filling_lk_12_anak,
                'jml_filling_pr_12_anak' => $jml_filling_pr_12_anak,
                #label
                'max_dmft' => $max_dmft,
                'min_dmft' => $min_dmft,
                'max_dmft_label' => $max_dmft_label,
                'min_dmft_label' => $min_dmft_label,
                'total_responden' => $total_responden
            ]);
        } else if ($type == 'deft') {
            return view('dashboard-admin.laporan.by_school-deft', [
                'query_klp_usia' => $query_klp_usia,
                'query_general' => $query_general,
                'query_total' => $query_total,
                'result' => 1,
                'sekolah' => $sekolah,
                'sekolah_selected' => $request->sekolah,
                'query_total_by_age' => $query_total_by_age,
                'jml_decay_lk_79' => $jml_decay_lk_79,
                'jml_decay_pr_79' => $jml_decay_pr_79,
                'jml_decay_lk_912' => $jml_decay_lk_912,
                'jml_decay_pr_912' => $jml_decay_pr_912,
                'jml_decay_lk_79_anak' => $jml_decay_lk_79_anak,
                'jml_decay_pr_79_anak' => $jml_decay_pr_79_anak,
                'jml_decay_lk_912_anak' => $jml_decay_lk_912_anak,
                'jml_decay_pr_912_anak' => $jml_decay_pr_912_anak,
                'jml_missing_lk_79' => $jml_missing_lk_79,
                'jml_missing_pr_79' => $jml_missing_pr_79,
                'jml_missing_lk_912' => $jml_missing_lk_912,
                'jml_missing_pr_912' => $jml_missing_pr_912,
                'jml_missing_lk_79_anak' => $jml_missing_lk_79_anak,
                'jml_missing_pr_79_anak' => $jml_missing_pr_79_anak,
                'jml_missing_lk_912_anak' => $jml_missing_lk_912_anak,
                'jml_missing_pr_912_anak' => $jml_missing_pr_912_anak,
                'jml_filling_lk_79' => $jml_filling_lk_79,
                'jml_filling_pr_79' => $jml_filling_pr_79,
                'jml_filling_lk_912' => $jml_filling_lk_912,
                'jml_filling_pr_912' => $jml_filling_pr_912,
                'jml_filling_lk_79_anak' => $jml_filling_lk_79_anak,
                'jml_filling_pr_79_anak' => $jml_filling_pr_79_anak,
                'jml_filling_lk_912_anak' => $jml_filling_lk_912_anak,
                'jml_filling_pr_912_anak' => $jml_filling_pr_912_anak,
                #Decay
                'jml_decay_lk_7' => $jml_decay_lk_7,
                'jml_decay_pr_7' => $jml_decay_pr_7,
                'jml_decay_lk_8' => $jml_decay_lk_8,
                'jml_decay_pr_8' => $jml_decay_pr_8,
                'jml_decay_lk_9' => $jml_decay_lk_9,
                'jml_decay_pr_9' => $jml_decay_pr_9,
                'jml_decay_lk_10' => $jml_decay_lk_10,
                'jml_decay_pr_10' => $jml_decay_pr_10,
                'jml_decay_lk_11' => $jml_decay_lk_11,
                'jml_decay_pr_11' => $jml_decay_pr_11,
                'jml_decay_lk_12' => $jml_decay_lk_12,
                'jml_decay_pr_12' => $jml_decay_pr_12,
                #Decay-anak
                'jml_decay_lk_7_anak' => $jml_decay_lk_7_anak,
                'jml_decay_pr_7_anak' => $jml_decay_pr_7_anak,
                'jml_decay_lk_8_anak' => $jml_decay_lk_8_anak,
                'jml_decay_pr_8_anak' => $jml_decay_pr_8_anak,
                'jml_decay_lk_9_anak' => $jml_decay_lk_9_anak,
                'jml_decay_pr_9_anak' => $jml_decay_pr_9_anak,
                'jml_decay_lk_10_anak' => $jml_decay_lk_10_anak,
                'jml_decay_pr_10_anak' => $jml_decay_pr_10_anak,
                'jml_decay_lk_11_anak' => $jml_decay_lk_11_anak,
                'jml_decay_pr_11_anak' => $jml_decay_pr_11_anak,
                'jml_decay_lk_12_anak' => $jml_decay_lk_12_anak,
                'jml_decay_pr_12_anak' => $jml_decay_pr_12_anak,
                #Missing
                'jml_missing_lk_7' => $jml_missing_lk_7,
                'jml_missing_pr_7' => $jml_missing_pr_7,
                'jml_missing_lk_8' => $jml_missing_lk_8,
                'jml_missing_pr_8' => $jml_missing_pr_8,
                'jml_missing_lk_9' => $jml_missing_lk_9,
                'jml_missing_pr_9' => $jml_missing_pr_9,
                'jml_missing_lk_10' => $jml_missing_lk_10,
                'jml_missing_pr_10' => $jml_missing_pr_10,
                'jml_missing_lk_11' => $jml_missing_lk_11,
                'jml_missing_pr_11' => $jml_missing_pr_11,
                'jml_missing_lk_12' => $jml_missing_lk_12,
                'jml_missing_pr_12' => $jml_missing_pr_12,
                #missing-anak
                'jml_missing_lk_7_anak' => $jml_missing_lk_7_anak,
                'jml_missing_pr_7_anak' => $jml_missing_pr_7_anak,
                'jml_missing_lk_8_anak' => $jml_missing_lk_8_anak,
                'jml_missing_pr_8_anak' => $jml_missing_pr_8_anak,
                'jml_missing_lk_9_anak' => $jml_missing_lk_9_anak,
                'jml_missing_pr_9_anak' => $jml_missing_pr_9_anak,
                'jml_missing_lk_10_anak' => $jml_missing_lk_10_anak,
                'jml_missing_pr_10_anak' => $jml_missing_pr_10_anak,
                'jml_missing_lk_11_anak' => $jml_missing_lk_11_anak,
                'jml_missing_pr_11_anak' => $jml_missing_pr_11_anak,
                'jml_missing_lk_12_anak' => $jml_missing_lk_12_anak,
                'jml_missing_pr_12_anak' => $jml_missing_pr_12_anak,
                #filling
                'jml_filling_lk_7' => $jml_filling_lk_7,
                'jml_filling_pr_7' => $jml_filling_pr_7,
                'jml_filling_lk_8' => $jml_filling_lk_8,
                'jml_filling_pr_8' => $jml_filling_pr_8,
                'jml_filling_lk_9' => $jml_filling_lk_9,
                'jml_filling_pr_9' => $jml_filling_pr_9,
                'jml_filling_lk_10' => $jml_filling_lk_10,
                'jml_filling_pr_10' => $jml_filling_pr_10,
                'jml_filling_lk_11' => $jml_filling_lk_11,
                'jml_filling_pr_11' => $jml_filling_pr_11,
                'jml_filling_lk_12' => $jml_filling_lk_12,
                'jml_filling_pr_12' => $jml_filling_pr_12,
                #filling-anak
                'jml_filling_lk_7_anak' => $jml_filling_lk_7_anak,
                'jml_filling_pr_7_anak' => $jml_filling_pr_7_anak,
                'jml_filling_lk_8_anak' => $jml_filling_lk_8_anak,
                'jml_filling_pr_8_anak' => $jml_filling_pr_8_anak,
                'jml_filling_lk_9_anak' => $jml_filling_lk_9_anak,
                'jml_filling_pr_9_anak' => $jml_filling_pr_9_anak,
                'jml_filling_lk_10_anak' => $jml_filling_lk_10_anak,
                'jml_filling_pr_10_anak' => $jml_filling_pr_10_anak,
                'jml_filling_lk_11_anak' => $jml_filling_lk_11_anak,
                'jml_filling_pr_11_anak' => $jml_filling_pr_11_anak,
                'jml_filling_lk_12_anak' => $jml_filling_lk_12_anak,
                'jml_filling_pr_12_anak' => $jml_filling_pr_12_anak,
                #label
                'max_deft' => $max_deft,
                'min_deft' => $min_deft,
                'max_deft_label' => $max_deft_label,
                'min_deft_label' => $min_deft_label,
                'total_responden' => $total_responden
            ]);
        } else if ($type == 'rti') {
            return view('dashboard-admin.laporan.by_school-rti', [
                'query_klp_usia' => $query_klp_usia,
                'query_general' => $query_general,
                'query_total' => $query_total,
                'result' => 1,
                'sekolah' => $sekolah,
                'sekolah_selected' => $request->sekolah,
                'query_total_by_age' => $query_total_by_age,
                'jml_decay_lk_79' => $jml_decay_lk_79,
                'jml_decay_pr_79' => $jml_decay_pr_79,
                'jml_decay_lk_912' => $jml_decay_lk_912,
                'jml_decay_pr_912' => $jml_decay_pr_912,
                'jml_decay_lk_79_anak' => $jml_decay_lk_79_anak,
                'jml_decay_pr_79_anak' => $jml_decay_pr_79_anak,
                'jml_decay_lk_912_anak' => $jml_decay_lk_912_anak,
                'jml_decay_pr_912_anak' => $jml_decay_pr_912_anak,
                'jml_missing_lk_79' => $jml_missing_lk_79,
                'jml_missing_pr_79' => $jml_missing_pr_79,
                'jml_missing_lk_912' => $jml_missing_lk_912,
                'jml_missing_pr_912' => $jml_missing_pr_912,
                'jml_missing_lk_79_anak' => $jml_missing_lk_79_anak,
                'jml_missing_pr_79_anak' => $jml_missing_pr_79_anak,
                'jml_missing_lk_912_anak' => $jml_missing_lk_912_anak,
                'jml_missing_pr_912_anak' => $jml_missing_pr_912_anak,
                'jml_filling_lk_79' => $jml_filling_lk_79,
                'jml_filling_pr_79' => $jml_filling_pr_79,
                'jml_filling_lk_912' => $jml_filling_lk_912,
                'jml_filling_pr_912' => $jml_filling_pr_912,
                'jml_filling_lk_79_anak' => $jml_filling_lk_79_anak,
                'jml_filling_pr_79_anak' => $jml_filling_pr_79_anak,
                'jml_filling_lk_912_anak' => $jml_filling_lk_912_anak,
                'jml_filling_pr_912_anak' => $jml_filling_pr_912_anak,
                #Decay
                'jml_decay_lk_7' => $jml_decay_lk_7,
                'jml_decay_pr_7' => $jml_decay_pr_7,
                'jml_decay_lk_8' => $jml_decay_lk_8,
                'jml_decay_pr_8' => $jml_decay_pr_8,
                'jml_decay_lk_9' => $jml_decay_lk_9,
                'jml_decay_pr_9' => $jml_decay_pr_9,
                'jml_decay_lk_10' => $jml_decay_lk_10,
                'jml_decay_pr_10' => $jml_decay_pr_10,
                'jml_decay_lk_11' => $jml_decay_lk_11,
                'jml_decay_pr_11' => $jml_decay_pr_11,
                'jml_decay_lk_12' => $jml_decay_lk_12,
                'jml_decay_pr_12' => $jml_decay_pr_12,
                #Decay-anak
                'jml_decay_lk_7_anak' => $jml_decay_lk_7_anak,
                'jml_decay_pr_7_anak' => $jml_decay_pr_7_anak,
                'jml_decay_lk_8_anak' => $jml_decay_lk_8_anak,
                'jml_decay_pr_8_anak' => $jml_decay_pr_8_anak,
                'jml_decay_lk_9_anak' => $jml_decay_lk_9_anak,
                'jml_decay_pr_9_anak' => $jml_decay_pr_9_anak,
                'jml_decay_lk_10_anak' => $jml_decay_lk_10_anak,
                'jml_decay_pr_10_anak' => $jml_decay_pr_10_anak,
                'jml_decay_lk_11_anak' => $jml_decay_lk_11_anak,
                'jml_decay_pr_11_anak' => $jml_decay_pr_11_anak,
                'jml_decay_lk_12_anak' => $jml_decay_lk_12_anak,
                'jml_decay_pr_12_anak' => $jml_decay_pr_12_anak,
                #Missing
                'jml_missing_lk_7' => $jml_missing_lk_7,
                'jml_missing_pr_7' => $jml_missing_pr_7,
                'jml_missing_lk_8' => $jml_missing_lk_8,
                'jml_missing_pr_8' => $jml_missing_pr_8,
                'jml_missing_lk_9' => $jml_missing_lk_9,
                'jml_missing_pr_9' => $jml_missing_pr_9,
                'jml_missing_lk_10' => $jml_missing_lk_10,
                'jml_missing_pr_10' => $jml_missing_pr_10,
                'jml_missing_lk_11' => $jml_missing_lk_11,
                'jml_missing_pr_11' => $jml_missing_pr_11,
                'jml_missing_lk_12' => $jml_missing_lk_12,
                'jml_missing_pr_12' => $jml_missing_pr_12,
                #missing-anak
                'jml_missing_lk_7_anak' => $jml_missing_lk_7_anak,
                'jml_missing_pr_7_anak' => $jml_missing_pr_7_anak,
                'jml_missing_lk_8_anak' => $jml_missing_lk_8_anak,
                'jml_missing_pr_8_anak' => $jml_missing_pr_8_anak,
                'jml_missing_lk_9_anak' => $jml_missing_lk_9_anak,
                'jml_missing_pr_9_anak' => $jml_missing_pr_9_anak,
                'jml_missing_lk_10_anak' => $jml_missing_lk_10_anak,
                'jml_missing_pr_10_anak' => $jml_missing_pr_10_anak,
                'jml_missing_lk_11_anak' => $jml_missing_lk_11_anak,
                'jml_missing_pr_11_anak' => $jml_missing_pr_11_anak,
                'jml_missing_lk_12_anak' => $jml_missing_lk_12_anak,
                'jml_missing_pr_12_anak' => $jml_missing_pr_12_anak,
                #filling
                'jml_filling_lk_7' => $jml_filling_lk_7,
                'jml_filling_pr_7' => $jml_filling_pr_7,
                'jml_filling_lk_8' => $jml_filling_lk_8,
                'jml_filling_pr_8' => $jml_filling_pr_8,
                'jml_filling_lk_9' => $jml_filling_lk_9,
                'jml_filling_pr_9' => $jml_filling_pr_9,
                'jml_filling_lk_10' => $jml_filling_lk_10,
                'jml_filling_pr_10' => $jml_filling_pr_10,
                'jml_filling_lk_11' => $jml_filling_lk_11,
                'jml_filling_pr_11' => $jml_filling_pr_11,
                'jml_filling_lk_12' => $jml_filling_lk_12,
                'jml_filling_pr_12' => $jml_filling_pr_12,
                #filling-anak
                'jml_filling_lk_7_anak' => $jml_filling_lk_7_anak,
                'jml_filling_pr_7_anak' => $jml_filling_pr_7_anak,
                'jml_filling_lk_8_anak' => $jml_filling_lk_8_anak,
                'jml_filling_pr_8_anak' => $jml_filling_pr_8_anak,
                'jml_filling_lk_9_anak' => $jml_filling_lk_9_anak,
                'jml_filling_pr_9_anak' => $jml_filling_pr_9_anak,
                'jml_filling_lk_10_anak' => $jml_filling_lk_10_anak,
                'jml_filling_pr_10_anak' => $jml_filling_pr_10_anak,
                'jml_filling_lk_11_anak' => $jml_filling_lk_11_anak,
                'jml_filling_pr_11_anak' => $jml_filling_pr_11_anak,
                'jml_filling_lk_12_anak' => $jml_filling_lk_12_anak,
                'jml_filling_pr_12_anak' => $jml_filling_pr_12_anak,
                #label
                'max_rti' => $max_rti,
                'min_rti' => $min_rti,
                'max_rti_label' => $max_rti_label,
                'min_rti_label' => $min_rti_label,
                'max_rti_anak' => $max_rti_anak,
                'min_rti_anak' => $min_rti_anak,
                'max_rti_anak_label' => $max_rti_anak_label,
                'min_rti_anak_label' => $min_rti_anak_label,
                'total_responden' => $total_responden
            ]);
        }
    }
    public function getEditData(Request $request)
    {
        $user = User::find($request->id);
        $biodata = Biodata::where('users_id', '=', $request->id)->first();
        $ortu = BiodataOrtu::where('users_id', '=', $request->id)->first();
        $foto = Foto::where('users_id', '=', $request->id)->first();
        $gender = ['Laki-laki', 'Perempuan'];
        $label_gaji = ['<1 juta', '1-3 juta', '>3 juta'];
        $label_listrik = ['450 VA', '900 VA', '1300 VA', '2200 VA', '> 2200 VA'];
        $kabupaten = Regency::where('name', 'like', '%JEMBER%')->first();
        $id_kab = $kabupaten->id;
        $kecamatan = District::where('regency_id', '=', $id_kab)->orderBy('name')->get();
        $sekolah = ['SDN Biting 04', 'SDN Candijati 01'];
        $pendidikan = ['TK', 'SD', 'SMP', 'SMA', 'Diploma 1, 2, 3', 'D4/S1', 'S2', 'S3'];
        $pekerjaan = ['Guru/Dosen', 'Petani/Nelayan', 'Wiraswasta', 'TNI/POLRI', 'Pensiunan', 'Pegawai Negeri', 'Pegawai BUMN/BUMD', 'Pegawai Swasta', 'Lainnya'];
        $id_kecamatan = '';
        $id_desa = '';
        if ($ortu) {
            if ($ortu->kecamatan) {
                $id_kecamatan = District::where('name', '=', $ortu->kecamatan)->where('regency_id', '=', '3509')->first();
                $id_kecamatan = $id_kecamatan->id;
            }
            if ($ortu->desa) {
                $id_desa = Village::where('name', '=', $ortu->desa)->where('district_id', '=', $id_kecamatan)->first();
                $id_desa = $id_desa->id;
            }
        }

        return view('dashboard-admin.edit-data', [
            'user' => $user,
            'biodata' => $biodata,
            'ortu' => $ortu,
            'foto' => $foto,
            'gender' => $gender,
            'label_gaji' => $label_gaji,
            'label_listrik' => $label_listrik,
            'kecamatan' => $kecamatan,
            'sekolah' => $sekolah,
            'pendidikan' => $pendidikan,
            'pekerjaan' => $pekerjaan,
            'id_kecamatan' => $id_kecamatan,
            'id_desa' => $id_desa,
        ]);
    }
    public function submitEditData(Request $request)
    {
        $this->validate($request, [
            'gigi_senyum' => 'file',
            'gigi_kiri' => 'file',
            'gigi_depan' => 'file',
            'gigi_atas' => 'file',
            'gigi_kanan' => 'file',
            'gigi_bawah' => 'file',
        ]);
        $gigi_senyum = $request->file('gigi_senyum');
        $gigi_kiri = $request->file('gigi_kiri');
        $date_gigi_senyum = $request->date_gigi_senyum;
        $date_gigi_kiri = $request->date_gigi_kiri;
        $gigi_depan = $request->file('gigi_depan');
        $gigi_atas = $request->file('gigi_atas');
        $date_gigi_depan = $request->date_gigi_depan;
        $date_gigi_atas = $request->date_gigi_atas;
        $gigi_kanan = $request->file('gigi_kanan');
        $gigi_bawah = $request->file('gigi_bawah');
        $date_gigi_kanan = $request->date_gigi_kanan;
        $date_gigi_bawah = $request->date_gigi_bawah;
        $rand = substr(md5(microtime()), 0, 10);
        $file_name_senyum = '';
        $file_name_gigi_kiri = '';
        $file_name_gigi_depan = '';
        $file_name_gigi_atas = '';
        $file_name_gigi_kanan = '';
        $file_name_gigi_bawah = '';

        if (filesize($gigi_senyum) > 1024 * 1024 * 50 || filesize($gigi_kiri) > 1024 * 1024 * 50 || filesize($gigi_depan) > 1024 * 1024 * 50 || filesize($gigi_atas) > 1024 * 1024 * 50 || filesize($gigi_kanan) > 1024 * 1024 * 50 || filesize($gigi_bawah) > 1024 * 1024 * 50) {
            return redirect()->back()->with(['danger' => 'Ukuran maksimum file 50 MB']);
        }

        $tujuan_upload = 'data_peserta/' . $request->id;

        #check apakah folder tujuan ada atau tidak
        if (!file_exists($tujuan_upload)) {
            mkdir($tujuan_upload);
        }

        if ($gigi_senyum) {
            $ext_gigi_senyum = $gigi_senyum->getClientOriginalExtension();
            if ($ext_gigi_senyum != 'jpg' && $ext_gigi_senyum != 'jpeg' && $ext_gigi_senyum != 'JPG' && $ext_gigi_senyum != 'JPEG' && $ext_gigi_senyum != 'heic' && $ext_gigi_senyum != 'HEIC') {
                return redirect()->back()->with(['danger' => 'File ekstensi foto yang diizinkan: JPG']);
            }
            $file_name_senyum = $rand . '_' . $gigi_senyum->getClientOriginalName();
            $imageSenyum = $gigi_senyum->move(public_path($tujuan_upload), $file_name_senyum);
        }
        if ($gigi_kiri) {
            $ext_gigi_kiri = $gigi_kiri->getClientOriginalExtension();
            if ($ext_gigi_kiri != 'jpg' && $ext_gigi_kiri != 'jpeg' && $ext_gigi_kiri != 'JPG' && $ext_gigi_kiri != 'JPEG' && $ext_gigi_kiri != 'heic' && $ext_gigi_kiri != 'HEIC') {
                return redirect()->back()->with(['danger' => 'File ekstensi foto yang diizinkan: JPG']);
            }
            $file_name_gigi_kiri = $rand . '_' . $gigi_kiri->getClientOriginalName();
            $imagekiri = $gigi_kiri->move(public_path($tujuan_upload), $file_name_gigi_kiri);
        }
        if ($gigi_depan) {
            $ext_gigi_depan = $gigi_depan->getClientOriginalExtension();
            if ($ext_gigi_depan != 'jpg' && $ext_gigi_depan != 'jpeg' && $ext_gigi_depan != 'JPG' && $ext_gigi_depan != 'JPEG' && $ext_gigi_depan != 'heic' && $ext_gigi_depan != 'HEIC') {
                return redirect()->back()->with(['danger' => 'File ekstensi foto yang diizinkan: JPG']);
            }
            $file_name_gigi_depan = $rand . '_' . $gigi_depan->getClientOriginalName();
            $imagedepan = $gigi_depan->move(public_path($tujuan_upload), $file_name_gigi_depan);
        }
        if ($gigi_atas) {
            $ext_gigi_atas = $gigi_atas->getClientOriginalExtension();
            if ($ext_gigi_atas != 'jpg' && $ext_gigi_atas != 'jpeg' && $ext_gigi_atas != 'JPG' && $ext_gigi_atas != 'JPEG' && $ext_gigi_atas != 'heic' && $ext_gigi_atas != 'HEIC') {
                return redirect()->back()->with(['danger' => 'File ekstensi foto yang diizinkan: JPG']);
            }
            $file_name_gigi_atas = $rand . '_' . $gigi_atas->getClientOriginalName();
            $imageatas = $gigi_atas->move(public_path($tujuan_upload), $file_name_gigi_atas);
        }
        if ($gigi_kanan) {
            $ext_gigi_kanan = $gigi_kanan->getClientOriginalExtension();
            if ($ext_gigi_kanan != 'jpg' && $ext_gigi_kanan != 'jpeg' && $ext_gigi_kanan != 'JPG' && $ext_gigi_kanan != 'JPEG' && $ext_gigi_kanan != 'heic' && $ext_gigi_kanan != 'HEIC') {
                return redirect()->back()->with(['danger' => 'File ekstensi foto yang diizinkan: JPG']);
            }
            $file_name_gigi_kanan = $rand . '_' . $gigi_kanan->getClientOriginalName();
            $imagekanan = $gigi_kanan->move(public_path($tujuan_upload), $file_name_gigi_kanan);
        }
        if ($gigi_bawah) {
            $ext_gigi_bawah = $gigi_bawah->getClientOriginalExtension();
            if ($ext_gigi_bawah != 'jpg' && $ext_gigi_bawah != 'jpeg' && $ext_gigi_bawah != 'JPG' && $ext_gigi_bawah != 'JPEG' && $ext_gigi_bawah != 'heic' && $ext_gigi_bawah != 'HEIC') {
                return redirect()->back()->with(['danger' => 'File ekstensi foto yang diizinkan: JPG']);
            }
            $file_name_gigi_bawah = $rand . '_' . $gigi_bawah->getClientOriginalName();
            $imagebawah = $gigi_bawah->move(public_path($tujuan_upload), $file_name_gigi_bawah);
        }

        $name = $request->name;
        $gender = $request->gender;
        $birthplace = $request->birthplace;
        $birthdate = $request->birthdate;
        $sekolah = $request->sekolah;
        $name_ortu = $request->name_ortu;
        $address = $request->address;
        $pendidikan_terakhir = $request->pendidikan_terakhir;
        $pekerjaan = $request->pekerjaan;
        $gaji = $request->gaji;
        $luas_rumah = $request->luas_rumah;
        $daya_listrik = $request->daya_listrik;
        $phone = $request->phone;
        $kecamatan = $request->kecamatan;
        $desa = $request->desa;
        $rt = $request->rt;
        $rw = $request->rw;

        #edit data user
        $user = User::find($request->id);
        $user->name = $name;
        $user->save();

        #edit biodata
        $biodata = Biodata::where('users_id', '=', $request->id)->first();
        if (!$biodata) {
            $biodata = new Biodata;
        }
        $biodata->users_id = $request->id;
        $biodata->gender = $gender;
        $biodata->birth_place = $birthplace;
        $biodata->birth_date = $birthdate;
        $biodata->id_sekolah = $sekolah;
        $biodata->save();

        #edit ortu
        $ortu = BiodataOrtu::where('users_id', '=', $request->id)->first();
        if (!$ortu) {
            $ortu = new BiodataOrtu;
        }
        $ortu->users_id = $request->id;
        $ortu->name_ortu = $name_ortu;
        $ortu->address = $address;
        $ortu->pendidikan_terakhir = $pendidikan_terakhir;
        $ortu->pekerjaan = $pekerjaan;
        $ortu->gaji = $gaji;
        $ortu->luas_rumah = $luas_rumah;
        $ortu->daya_listrik = $daya_listrik;
        $kecamatan_dom_name = District::where('id', '=', $kecamatan)->first();
        $kecamatan_dom_name = $kecamatan_dom_name->name;
        $desa_dom_name = Village::where('id', '=', $desa)->first();
        $desa_dom_name = $desa_dom_name->name;
        $ortu->kecamatan = $kecamatan_dom_name;
        $ortu->desa = $desa_dom_name;
        $ortu->rt = $rt;
        $ortu->rw = $rw;
        $ortu->phone = $phone;
        $ortu->save();

        //input to database
        $foto = Foto::where('users_id', '=', $request->id)->first();
        if (!$foto) {
            $foto = new Foto;
        }
        $foto->users_id = $request->id;
        if ($gigi_senyum) {
            $foto->foto_senyum = $tujuan_upload . '/' . $file_name_senyum;
            $foto->date_taken_senyum = $date_gigi_senyum;
        }
        if ($gigi_kiri) {
            $foto->foto_kiri = $tujuan_upload . '/' . $file_name_gigi_kiri;
            $foto->date_taken_kiri = $date_gigi_kiri;
        }
        if ($gigi_depan) {
            $foto->foto_depan = $tujuan_upload . '/' . $file_name_gigi_depan;
            $foto->date_taken_depan = $date_gigi_depan;
        }
        if ($gigi_atas) {
            $foto->foto_atas = $tujuan_upload . '/' . $file_name_gigi_atas;
            $foto->date_taken_atas = $date_gigi_atas;
        }
        if ($gigi_kanan) {
            $foto->foto_kanan = $tujuan_upload . '/' . $file_name_gigi_kanan;
            $foto->date_taken_kanan = $date_gigi_kanan;
        }
        if ($gigi_bawah) {
            $foto->foto_bawah = $tujuan_upload . '/' . $file_name_gigi_bawah;
            $foto->date_taken_bawah = $date_gigi_bawah;
        }
        $foto->save();

        $url = '/daftar-anak/detail?id=' . $request->id;

        return redirect($url);
    }
}
