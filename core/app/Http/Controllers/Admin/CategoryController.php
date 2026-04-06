<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    public function category()
    {
        $pageTitle  = 'Manage Category';
        $categories = Category::latest()->paginate(getPaginate());
        return view('admin.category.index', compact('pageTitle', 'categories'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'string|max:40|required|unique:categories,name',
        ]);

        $newCategory       = new Category();
        $newCategory->name = $request->name;
        $newCategory->slug = slug($request->name);
        $newCategory->save();

        $notify[] = ['success', 'Category added successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'string|max:40|required|unique:categories,name,' . $request->id,
            'id'   => 'required|exists:categories,id',
        ]);

        $findCategory       = Category::findOrFail($request->id);
        $findCategory->name = $request->name;
        $findCategory->slug = slug($request->name);
        $findCategory->save();

        $notify[] = ['success', 'Category updated successfully'];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        return Category::changeStatus($id);
    }
}
