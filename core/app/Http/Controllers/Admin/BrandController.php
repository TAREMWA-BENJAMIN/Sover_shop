<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{

    public function brand()
    {
        $pageTitle = 'Manage Brand';
        $brands    = Brand::latest()->paginate(getPaginate());
        return view('admin.brand.index', compact('pageTitle', 'brands'));
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'name' => 'string|max:40|required|unique:brands,name',
        ]);
        $newCategory       = new Brand();
        $newCategory->name = $request->name;
        $newCategory->slug = slug($request->name);
        $newCategory->save();

        $notify[] = ['success', 'New brand added successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'string|max:40|required|unique:brands,name,' . $request->id,
            'id'   => 'required|exists:brands,id',
        ]);

        $findBrand       = Brand::findOrFail($request->id);
        $findBrand->name = $request->name;
        $findBrand->slug = slug($request->name);
        $findBrand->save();

        $notify[] = ['success', 'Brand updated successfully'];
        return back()->withNotify($notify);
    }
    
    public function status($id)
    {
        return Brand::changeStatus($id);
    }
}
