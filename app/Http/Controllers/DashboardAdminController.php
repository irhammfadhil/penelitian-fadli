<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biodata;
use App\Models\User;

class DashboardAdminController extends Controller
{
    public function index() {
        return view('dashboard-admin.index');
    }
    public function getAllAnak(){
        $anak = User::where('is_admin', '=', 0)->get();
        return view('dashboard-admin.list-anak', ['anak' => $anak]);
    }
}
