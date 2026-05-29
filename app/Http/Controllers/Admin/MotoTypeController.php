<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\MotoType;
use Illuminate\Support\Str;

class MotoTypeController extends Controller
{
    public function index() { return view('admin.moto_types.index', ['motoTypes' => MotoType::all()]); }
    public function create() { return view('admin.moto_types.create'); }
    public function store() {
        request()->validate(['name' => 'required']);
        MotoType::create(['name' => request('name'), 'slug' => Str::slug(request('name'))]);
        return redirect()->route('admin.moto-types.index')->with('success', 'Type ajouté!');
    }
    public function destroy(MotoType $motoType) {
        $motoType->delete();
        return redirect()->route('admin.moto-types.index')->with('success', 'Supprimé!');
    }
    public function edit(MotoType $motoType) { return view('admin.moto_types.edit', compact('motoType')); }
    public function update(MotoType $motoType) {
        request()->validate(['name' => 'required']);
        $motoType->update(['name' => request('name'), 'slug' => Str::slug(request('name'))]);
        return redirect()->route('admin.moto-types.index')->with('success', 'Mis à jour!');
    }
    public function show(MotoType $motoType) {}
}
