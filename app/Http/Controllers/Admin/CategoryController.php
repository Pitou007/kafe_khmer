<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = DB::table('categories')->orderByDesc('id')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        DB::table('categories')->insert([
            'name' => $data['name'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created');
    }

    public function edit($id)
    {
        $category = DB::table('categories')->where('id', $id)->first();
        abort_if(!$category, 404);

        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = DB::table('categories')->where('id', $id)->first();
        abort_if(!$category, 404);

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ]);

        DB::table('categories')->where('id', $id)->update([
            'name' => $data['name'],
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated');
    }

    public function destroy($id)
    {
        DB::table('categories')->where('id', $id)->delete();
        return back()->with('success', 'Category deleted');
    }
}