<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Regency;
use App\Models\District;
use App\Models\Biodata;
use App\Models\BiodataOrtu;
use App\Models\Village;
use Illuminate\Support\Facades\Auth;
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
        $kecamatan = District::where('regency_id', '=', $id_kab)->get();
        $desa = Village::all();
        $gender = ['Laki-laki', 'Perempuan'];
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
        $date1 = new DateTime($biodata->birth_date);
        $date2 = new DateTime("now");
        $age = $date1->diff($date2);
        return view('dashboard-user.consent', [
            'biodata' => $biodata,
            'ortu' => $ortu,
            'age' => $age->y,
        ]);
    }
}
