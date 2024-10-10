<?php
namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::all(); // Ambil semua satuan
        return view('pages.units.index', compact('units'));
    }

    public function create()
    {
        return view('pages.units.create'); // Form tambah satuan
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Unit::create($request->all()); // Simpan satuan baru

        return redirect()->route('pages.units.index')->with('success', 'Satuan berhasil ditambahkan.');
    }

    public function edit(Unit $unit)
    {
        return view('pages.units.edit', compact('unit')); // Form edit satuan
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $unit->update($request->all()); // Update satuan

        return redirect()->route('pages.units.index')->with('success', 'Satuan berhasil diperbarui.');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete(); // Hapus satuan

        return redirect()->route('pages.units.index')->with('success', 'Satuan berhasil dihapus.');
    }
}
