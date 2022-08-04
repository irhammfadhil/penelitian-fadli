<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class HomeController extends Controller
{
    public function index() {
        $artikel = Article::orderByDesc('created_at')->limit(3)->get();
        return view('index', [
            'artikel' => $artikel
        ]);
    }
    public function getArtikel() {
        $artikel = Article::all();
        return view('artikel', [
            'artikel' => $artikel
        ]);
    }
    public function getDetailArtikel($url) {
        $artikel = Article::where('link', '=', $url)->first();
        return view('detail-artikel', [
            'artikel' => $artikel
        ]);
    }
    public function getCaraPenggunaan() {
        return view('cara-penggunaan');
    }
}
