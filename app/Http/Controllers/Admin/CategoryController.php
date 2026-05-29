<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index() { return view('admin.categories.index', ['categories' => Category::with('products')->get()]); }
    public function create() { return view('admin.categories.create'); }
    public function store() {
        request()->validate(['name' => 'required']);
        Category::create(['name' => request('name'), 'slug' => Str::slug(request('name'))]);
        return redirect()->route('admin.categories.index')->with('success', 'Ajouté!');
    }
    public function edit(Category $category) { return view('admin.categories.edit', compact('category')); }
    public function update(Category $category) {
        request()->validate(['name' => 'required']);
        $category->update(['name' => request('name'), 'slug' => Str::slug(request('name'))]);
        return redirect()->route('admin.categories.index')->with('success', 'Mis à jour!');
    }
    public function destroy(Category $category) { $category->delete(); return redirect()->route('admin.categories.index')->with('success', 'Supprimé!'); }
    public function show(Category $category) {}
}
