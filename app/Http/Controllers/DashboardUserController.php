<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Regency;
use App\Models\District;
use App\Models\Biodata;
use App\Models\BiodataOrtu;
use App\Models\Village;
use App\Models\Foto;
use App\Models\User;
use App\Models\Diagnosis;
use App\Models\UsersCovid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\ExportGraphService;
use DateTime;

class DashboardUserController extends Controller
{
    protected $exportGraphService;
    public function __construct(ExportGraphService $exportGraphService)
    {
        $this->exportGraphService = $exportGraphService;
    }
    public function index()
    {
        $id = Auth::user()->id;
        $data = $this->exportGraphService->exportRTIGraph($id);
        return view('dashboard-user.index', [
            'rti_index' => $data['rti_index'],
            'rti_index_sulung' => $data['rti_index_sulung'],
        ]);
    }
    public function getBiodata()
    {
        $biodata = Biodata::where('users_id', '=', Auth::user()->id)->first();
        $ortu = BiodataOrtu::where('users_id', '=', Auth::user()->id)->first();
        $kabupaten = Regency::where('name', 'like', '%JEMBER%')->first();
        $id_kab = $kabupaten->id;
        $kecamatan = District::where('regency_id', '=', $id_kab)->orderBy('name')->get();
        $desa = Village::all();
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

        return view('dashboard-user.biodata', [
            'kecamatan' => $kecamatan,
            'biodata' => $biodata,
            'ortu' => $ortu,
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
    public function submitBiodata(Request $request)
    {
        $gender = $request->gender;
        $birthplace = $request->birthplace;
        $birthdate = $request->birthdate;
        $sekolah = $request->sekolah;

        #data ortu
        $name_ortu = $request->name_ortu;
        $address = $request->address;
        $kecamatan = $request->kecamatan;
        $desa = $request->desa;
        $rt = $request->rt;
        $rw = $request->rw;
        $phone = $request->phone;
        $pendidikan_terakhir = $request->pendidikan_terakhir;
        $pekerjaan = $request->pekerjaan;
        $gaji = $request->gaji;
        $luas_rumah = $request->luas_rumah;
        $daya_listrik = $request->daya_listrik;

        $tanggal = substr($birthdate, 0, 2);
        $bulan = substr($birthdate, 3, 2);
        $tahun = substr($birthdate, 6, 4);
        $date_formatted = $tahun . '-' . $bulan . '-' . $tanggal;

        $biodata = Biodata::where('users_id', '=', Auth::user()->id)->first();
        if (!$biodata) {
            $biodata = new Biodata;
        }
        $biodata->users_id = Auth::user()->id;
        $biodata->gender = $gender;
        $biodata->birth_place = $birthplace;
        $biodata->birth_date = $birthdate;
        $biodata->id_sekolah = $sekolah;
        $biodata->save();

        $ortu = BiodataOrtu::where('users_id', '=', Auth::user()->id)->first();
        if (!$ortu) {
            $ortu = new BiodataOrtu;
        }
        $ortu->users_id = Auth::user()->id;
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

        return redirect('/foto-gigi');
    }
    public function getScreeningCovid()
    {
        $biodata = Biodata::where('users_id', '=', Auth::user()->id)->first();
        $ortu = BiodataOrtu::where('users_id', '=', Auth::user()->id)->first();
        $screening = UsersCovid::where('users_id', '=', Auth::user()->id)->first();
        return view('dashboard-user.covid', [
            'biodata' => $biodata,
            'ortu' => $ortu,
            'screening' => $screening,
        ]);
    }
    public function screeningCovid(Request $request)
    {
        $is_demam = $request->is_demam;
        $is_batuk = $request->is_batuk;
        $is_sesak = $request->is_sesak;
        $is_travel = $request->is_travel;
        $is_close_contact = $request->is_close_contact;
        $is_health_facilities_visit = $request->is_health_facilities_visit;

        $user = UsersCovid::where('users_id', '=', Auth::user()->id)->first();
        if (!$user) {
            $user = new UsersCovid;
        }
        $user->users_id = Auth::user()->id;
        $user->is_demam = $is_demam;
        $user->is_batuk = $is_batuk;
        $user->is_sesak = $is_sesak;
        $user->is_travel = $is_travel;
        $user->is_close_contact = $is_close_contact;
        $user->is_health_facilities_visit = $is_health_facilities_visit;
        $user->save();

        return redirect('/informed-consent');
    }
    public function getConsent()
    {
        $biodata = Biodata::where('users_id', '=', Auth::user()->id)->first();
        $ortu = BiodataOrtu::where('users_id', '=', Auth::user()->id)->first();
        $covid = UsersCovid::where('users_id', '=', Auth::user()->id)->first();
        if ($biodata && $ortu) {
            $date1 = new DateTime($biodata->birth_date);
            $date2 = new DateTime("now");
            $age = $date1->diff($date2);
            return view('dashboard-user.consent', [
                'biodata' => $biodata,
                'ortu' => $ortu,
                'covid' => $covid,
                'age' => $age->y,
            ]);
        } else {
            return view('dashboard-user.consent', [
                'biodata' => $biodata,
                'ortu' => $ortu,
                'covid' => $covid,
            ]);
        }
    }
    public function tandatanganInformedConsent(Request $request)
    {
        $id_user = Auth::user()->id;
        $folderPath = 'upload/';

        $image_parts = explode(";base64,", $request->signed);

        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

        $file = $folderPath . uniqid() . '.' . $image_type;
        file_put_contents($file, $image_base64);

        $tandatangan = DB::table('users')->where('id', '=', Auth::user()->id)->update([
            'signature' => $file
        ]);

        $url = '/informed-consent';
        return redirect($url)->with('success', 'Tandatangan Informed Consent Berhasil');
    }
    public function getFotoGigi()
    {
        $foto = Foto::where('users_id', '=', Auth::user()->id)->first();
        $user = User::where('id', '=', Auth::user()->id)->first();

        return view('dashboard-user.foto', ['foto' => $foto, 'user' => $user]);
    }
    public function submitFotoGigi(Request $request)
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

        $tujuan_upload = 'data_peserta/' . Auth::user()->id;

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
            if ($ext_gigi_depan != 'jpg' && $ext_gigi_depan != 'jpeg' && $ext_gigi_depan != 'JPG' && $ext_gigi_depan != 'JPEG' && $ext_gigi_depan != 'heic'&& $ext_gigi_depan != 'HEIC') {
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

        //input to database
        $foto = Foto::where('users_id', '=', Auth::user()->id)->first();
        if (!$foto) {
            $foto = new Foto;
        }
        $foto->users_id = Auth::user()->id;
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

        return redirect('/finalisasi')->with('success', 'Unggah Foto Berhasil');
    }
    public function getKomentar()
    {
        $user = User::where('id', '=', Auth::user()->id)->first();
        $biodata = Biodata::where('users_id', '=', Auth::user()->id)->first();
        ##gigi tetap
        $sum_decay_tetap = Diagnosis::where('users_id', '=', Auth::user()->id)->where('is_decay', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
        $sum_missing_tetap = Diagnosis::where('users_id', '=', Auth::user()->id)->where('is_missing', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
        $sum_filling_tetap = Diagnosis::where('users_id', '=', Auth::user()->id)->where('is_filling', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
        ##gigi susu
        $sum_decay_susu = Diagnosis::where('users_id', '=', Auth::user()->id)->where('is_decay', '=', 1)->whereBetween('id_gigi', [51, 85])->count();
        $sum_missing_susu = Diagnosis::where('users_id', '=', Auth::user()->id)->where('is_missing', '=', 1)->whereBetween('id_gigi', [51, 85])->count();
        $sum_filling_susu = Diagnosis::where('users_id', '=', Auth::user()->id)->where('is_filling', '=', 1)->whereBetween('id_gigi', [51, 85])->count();

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
        return view('dashboard-user.komentar', [
            'user' => $user,
            'biodata' => $biodata,
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
    public function getFinalisasi()
    {
        $foto = Foto::where('users_id', '=', Auth::user()->id)->first();
        return view('dashboard-user.finalisasi', ['foto' => $foto]);
    }
    public function submitFinalisasi()
    {
        $user = User::where('id', '=', Auth::user()->id)->first();
        $user->finalisasi_at = date('Y-m-d H:i:s');
        $user->save();

        return redirect('/dashboard/user');
    }
}
