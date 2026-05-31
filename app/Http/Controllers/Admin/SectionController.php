<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Support\Str;

class SectionController extends Controller
{
    public function index()
    {
        return view('admin.sections.index', ['sections' => Section::orderBy('sort_order')->get()]);
    }

    public function create()
    {
        return view('admin.sections.create');
    }

    public function store()
    {
        request()->validate(['name' => 'required', 'icon' => 'required']);
        Section::create([
            'name'       => request('name'),
            'slug'       => Str::slug(request('name')),
            'icon'       => request('icon'),
            'sort_order' => request('sort_order', 0),
        ]);
        return redirect()->route('admin.sections.index')->with('success', 'Section ajoutée!');
    }

    public function edit(Section $section)
    {
        return view('admin.sections.edit', compact('section'));
    }

    public function update(Section $section)
    {
        request()->validate(['name' => 'required', 'icon' => 'required']);
        $section->update([
            'name'       => request('name'),
            'slug'       => Str::slug(request('name')),
            'icon'       => request('icon'),
            'sort_order' => request('sort_order', 0),
        ]);
        return redirect()->route('admin.sections.index')->with('success', 'Mis à jour!');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('admin.sections.index')->with('success', 'Supprimée!');
    }

    public function show(Section $section) {}
}
