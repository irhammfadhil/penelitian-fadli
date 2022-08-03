<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Regency;
use App\Models\District;
use App\Models\Biodata;
use App\Models\BiodataOrtu;
use App\Models\Village;
use App\Models\Foto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DateTime;

class DashboardUserController extends Controller
{
    public function index() {
        return view('dashboard-user.index');
    }
    public function getBiodata() {
        $biodata = Biodata::where('users_id', '=', Auth::user()->id)->first();
        $ortu = BiodataOrtu::where('users_id', '=', Auth::user()->id)->first();
        $kabupaten = Regency::where('name', 'like', '%JEMBER%')->first();
        $id_kab = $kabupaten->id;
        $kecamatan = District::where('regency_id', '=', $id_kab)->orderBy('name')->get();
        $desa = Village::all();
        $gender = ['Laki-laki', 'Perempuan', 'Memilih untuk tidak menjawab'];
        return view('dashboard-user.biodata', [
            'kecamatan' => $kecamatan,
            'biodata' => $biodata,
            'ortu' => $ortu,
            'gender' => $gender,
        ]);
    }
    public function submitBiodata (Request $request) {
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

        $biodata = Biodata::where('users_id', '=', Auth::user()->id)->first();
        if(!$biodata) {
            $biodata = new Biodata;
        }
        $biodata->users_id = Auth::user()->id;
        $biodata->gender = $gender;
        $biodata->birth_place = $birthplace;
        $biodata->birth_date = $birthdate;
        $biodata->id_sekolah = $sekolah;
        $biodata->save();

        $ortu = BiodataOrtu::where('users_id', '=', Auth::user()->id)->first();
        if(!$ortu) {
            $ortu = new BiodataOrtu;
        }
        $ortu->users_id = Auth::user()->id;
        $ortu->name_ortu = $name_ortu;
        $ortu->address = $address;
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

        return redirect('/informed-consent');
    }
    public function getConsent() {
        $biodata = Biodata::where('users_id', '=', Auth::user()->id)->first();
        $ortu = BiodataOrtu::where('users_id', '=', Auth::user()->id)->first();
        if($biodata && $ortu) {
            $date1 = new DateTime($biodata->birth_date);
            $date2 = new DateTime("now");
            $age = $date1->diff($date2);
            return view('dashboard-user.consent', [
                'biodata' => $biodata,
                'ortu' => $ortu,
                'age' => $age->y,
            ]);
        }
        else {
            return view('dashboard-user.consent', [
                'biodata' => $biodata,
                'ortu' => $ortu,
            ]);
        }
    }
    public function tandatanganInformedConsent(Request $request) {
        $id_user = Auth::user()->id;
        $folderPath = 'upload/';
        
        $image_parts = explode(";base64,", $request->signed);
              
        $image_type_aux = explode("image/", $image_parts[0]);
           
        $image_type = $image_type_aux[1];
           
        $image_base64 = base64_decode($image_parts[1]);
           
        $file = $folderPath . uniqid() . '.'.$image_type;
        file_put_contents($file, $image_base64);

        $tandatangan = DB::table('users')->where('id', '=', Auth::user()->id)->update([
            'signature' => $file
        ]);

        $url = '/informed-consent';
        return redirect($url)->with('success', 'Tandatangan Informed Consent Berhasil');
    }
    public function getFotoGigi() {
        $foto = Foto::where('users_id', '=', Auth::user()->id)->first();
        return view('dashboard-user.foto', ['foto' => $foto]);
    }
    public function submitFotoGigi(Request $request) {
        $this->validate($request, [
    		'gigi_senyum' => 'required|file',
            'gigi_kiri' => 'required|file',
            'gigi_depan' => 'required|file',
    		'gigi_atas' => 'required|file',
            'gigi_kanan' => 'required|file',
            'gigi_bawah' => 'required|file',
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

        $ext_gigi_senyum = $gigi_senyum->getClientOriginalExtension();
        $ext_gigi_kiri = $gigi_kiri->getClientOriginalExtension();
        $ext_gigi_depan= $gigi_depan->getClientOriginalExtension();
        $ext_gigi_atas = $gigi_atas->getClientOriginalExtension();
        $ext_gigi_kanan= $gigi_kanan->getClientOriginalExtension();
        $ext_gigi_bawah = $gigi_bawah->getClientOriginalExtension();

        if($ext_gigi_senyum != 'jpg' && $ext_gigi_senyum != 'jpeg') {
            return redirect()->back()->with(['danger' => 'File ekstensi foto yang diizinkan: JPG']);
        }
        if($ext_gigi_kiri != 'jpg' && $ext_gigi_kiri != 'jpeg') {
            return redirect()->back()->with(['danger' => 'File ekstensi foto yang diizinkan: JPG']);
        }
        if($ext_gigi_depan != 'jpg' && $ext_gigi_depan != 'jpeg') {
            return redirect()->back()->with(['danger' => 'File ekstensi foto yang diizinkan: JPG']);
        }
        if($ext_gigi_atas != 'jpg' && $ext_gigi_atas != 'jpeg') {
            return redirect()->back()->with(['danger' => 'File ekstensi foto yang diizinkan: JPG']);
        }
        if($ext_gigi_kanan != 'jpg' && $ext_gigi_kanan != 'jpeg') {
            return redirect()->back()->with(['danger' => 'File ekstensi foto yang diizinkan: JPG']);
        }
        if($ext_gigi_bawah != 'jpg' && $ext_gigi_bawah != 'jpeg') {
            return redirect()->back()->with(['danger' => 'File ekstensi foto yang diizinkan: JPG']);
        }
        if(filesize($gigi_senyum) > 1024*1024*2 || filesize($gigi_kiri) > 1024*1024*2 || filesize($gigi_depan) > 1024*1024*2 || filesize($gigi_atas) > 1024*1024*2 || filesize($gigi_kanan) > 1024*1024*2 || filesize($gigi_bawah) > 1024*1024*2) {
            return redirect()->back()->with(['danger' => 'Ukuran maksimum file 2 MB']);
        }

        $rand = substr(md5(microtime()), 0, 10);

        $file_name_senyum = $rand.'_'.$gigi_senyum->getClientOriginalName();
        $file_name_gigi_kiri = $rand.'_'.$gigi_kiri->getClientOriginalName();
        $file_name_gigi_depan = $rand.'_'.$gigi_depan->getClientOriginalName();
        $file_name_gigi_atas = $rand.'_'.$gigi_atas->getClientOriginalName();
        $file_name_gigi_kanan = $rand.'_'.$gigi_kanan->getClientOriginalName();
        $file_name_gigi_bawah = $rand.'_'.$gigi_bawah->getClientOriginalName();

        $tujuan_upload = 'data_peserta/'.Auth::user()->id;
        
        #check apakah folder tujuan ada atau tidak
        if (!file_exists($tujuan_upload)) {
            mkdir($tujuan_upload);
        }

        $imageSenyum = $gigi_senyum->move(public_path($tujuan_upload), $file_name_senyum);
        $imagekiri = $gigi_kiri->move(public_path($tujuan_upload), $file_name_gigi_kiri);
        $imagedepan = $gigi_depan->move(public_path($tujuan_upload), $file_name_gigi_depan);
        $imageatas = $gigi_atas->move(public_path($tujuan_upload), $file_name_gigi_atas);
        $imagekanan = $gigi_kanan->move(public_path($tujuan_upload), $file_name_gigi_kanan);
        $imagebawah = $gigi_bawah->move(public_path($tujuan_upload), $file_name_gigi_bawah);

        //input to database
        $foto = Foto::where('users_id', '=', Auth::user()->id)->first();
        if(!$foto) {
            $foto = new Foto;
        }
        $foto->users_id = Auth::user()->id;
        $foto->foto_senyum = $tujuan_upload.'/'.$file_name_senyum;
        $foto->foto_depan = $tujuan_upload.'/'.$file_name_gigi_depan;
        $foto->foto_kiri = $tujuan_upload.'/'.$file_name_gigi_kiri;
        $foto->foto_atas = $tujuan_upload.'/'.$file_name_gigi_atas;
        $foto->foto_kanan = $tujuan_upload.'/'.$file_name_gigi_kanan;
        $foto->foto_bawah = $tujuan_upload.'/'.$file_name_gigi_bawah;
        $foto->date_taken_senyum = $date_gigi_senyum;
        $foto->date_taken_depan = $date_gigi_depan;
        $foto->date_taken_kiri = $date_gigi_kiri;
        $foto->date_taken_atas = $date_gigi_atas;
        $foto->date_taken_kanan = $date_gigi_kanan;
        $foto->date_taken_bawah = $date_gigi_bawah;
        $foto->save();

        return redirect('/foto-gigi')->with('success', 'Unggah Foto Berhasil');
    }
}
