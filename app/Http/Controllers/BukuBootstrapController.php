<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuBootstrapController extends Controller
{
    /**
     * Index - Menampilkan semua data buku (versi Bootstrap)
     */
    public function index()
    {
        $bukus = Buku::latest()->get();

        return view('buku-bootstrap.index', compact('bukus'));
    }

    /**
     * Create - Menampilkan form tambah buku (versi Bootstrap)
     */
    public function create()
    {
        return view('buku-bootstrap.create');
    }

    /**
     * Edit - Menampilkan form edit buku (versi Bootstrap)
     */
    public function edit(Buku $buku)
    {
        return view('buku-bootstrap.edit', compact('buku'));
    }
}
