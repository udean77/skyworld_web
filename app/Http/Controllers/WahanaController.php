<?php

namespace App\Http\Controllers;

use App\Models\Wahana;
use Illuminate\Http\Request;

class WahanaController extends Controller
{
    public function index()
    {
        $data = Wahana::all();
        return view('v_wahana.index', compact('data'));
    }

    public function create()
    {
        return view('v_wahana.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer|min:0', // Validasi stok
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $path = $file->store('wahana', 'public');
            $data['gambar'] = $path;
        }

        Wahana::create($data);

        return redirect()->route('wahana.index')->with('success', 'Wahana ditambahkan');
    }
    public function edit(Wahana $wahana)
    {
        return view('v_wahana.edit', compact('wahana'));
    }

    public function update(Request $request, Wahana $wahana)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer|min:0', // Validasi stok
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $path = $file->store('wahana', 'public');
            $data['gambar'] = $path;
        }

        $wahana->update($data);

        return redirect()->route('wahana.index')->with('success', 'Wahana diperbarui');
    }

    public function destroy(Wahana $wahana)
    {
        $wahana->delete();
        return redirect()->route('wahana.index')->with('success', 'Wahana dihapus');
    }
}
