<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Constants\Status;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'Manage Product';
        $products  = Product::searchable(['name', 'sku'])->orderBy('id', 'desc')->with('brand', 'category')->paginate(getPaginate());
        return view('admin.product.index', compact('pageTitle', 'products'));
    }

    public function addPage()
    {
        $pageTitle  = 'Add Product';
        $categories = Category::active()->get();
        $brands     = Brand::active()->get();
        return view('admin.product.add', compact('pageTitle', 'categories', 'brands'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'category'    => 'required|exists:categories,id',
            'brand'       => 'required|exists:brands,id',
            'name'        => 'required|max:255|unique:products,name',
            'price'       => 'required|numeric|gt:0',
            'discount'    => 'nullable|numeric|gte:0',
            'description' => 'required',
            'image'       => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'status'      => 'sometimes|in:on',
            'stock'       => 'required|gte:0',
            'sku'         => 'required|unique:products,sku',
        ]);

        $product              = new Product();
        $product->category_id = $request->category;
        $product->brand_id    = $request->brand;
        $product->sku         = $request->sku;
        $product->name        = $request->name;
        $product->slug        = slug($request->name);
        $product->price       = $request->price;
        $product->stock       = $request->stock;
        $product->description = $request->description;
        $product->discount    = $request->discount ?? 0;
        $product->featured    = $request->featured ? 1 : 0;

        if ($request->hasFile('image')) {
            try {
                $product->image = fileUploader($request->image, getFilePath('product'), getFileSize('product'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $product->save();

        $notify[] = ['success', 'Product added successfully'];
        return back()->withNotify($notify);
    }

    public function updatePage($id)
    {
        $product    = Product::findOrFail($id);
        $pageTitle  = 'Update Product';
        $categories = Category::active()->get();
        $brands     = Brand::active()->get();
        return view('admin.product.update', compact('pageTitle', 'categories', 'product', 'brands'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'category'    => 'required|exists:categories,id',
            'brand'       => 'required|exists:brands,id',
            'id'          => 'required|exists:products,id',
            'name'        => 'required|max:255|unique:products,name,' . $request->id,
            'price'       => 'required|numeric|gt:0',
            'discount'    => 'nullable|numeric|gte:0',
            'description' => 'required',
            'image'       => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'status'      => 'sometimes|in:on',
            'stock'       => 'required|gte:0',
            'sku'         => 'required|unique:products,sku,' . $request->id,
        ]);

        $product              = Product::findOrFail($request->id);
        $product->category_id = $request->category;
        $product->brand_id    = $request->brand;
        $product->sku         = $request->sku;
        $product->name        = $request->name;
        $product->slug        = slug($request->name);
        $product->price       = $request->price;
        $product->stock       = $request->stock;
        $product->discount    = $request->discount ?? 0;
        $product->description = $request->description;
        $product->featured    = $request->featured ? Status::YES : Status::NO;

        if ($request->hasFile('image')) {
            try {
                $old            = $product->image;
                $product->image = fileUploader($request->image, getFilePath('product'), getFileSize('product'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $product->save();
        $notify[] = ['success', 'Product updated successfully'];
        return back()->withNotify($notify);
    }

    public function imagePage($id)
    {
        $product   = Product::findOrFail($id);
        $pageTitle = 'Product Images';
        return view('admin.product.images', compact('pageTitle', 'product'));
    }

    public function deleteImage(Request $request, $productId, $productImageId)
    {
        $product = ProductImage::where('id', $productImageId)->where('product_id', $productId)->firstOrFail();
        removeFile(getFilePath('product') . '/' . $product->image);
        $product->delete();

        $notify[] = ['success', 'Product image deleted successfully'];
        return back()->withNotify($notify);
    }

    public function addImage(Request $request)
    {
        $request->validate([
            'id'      => 'required|exists:products,id',
            'id'      => 'required|exists:products,id',
            'image'   => 'array',
            'image.*' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);
        if (!$request->image) {
            $notify[] = ['error', 'Please select your product image'];
            return back()->withNotify($notify);
        }
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $data) {
                $new             = new ProductImage();
                $new->product_id = $request->id;
                try {
                    $new->image = fileUploader($data, getFilePath('product'), getFileSize('product'));
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload your image'];
                    return back()->withNotify($notify);
                }
                $new->save();
            }
        }
        $notify[] = ['success', 'Product image added successfully'];
        return back()->withNotify($notify);
    }

    public function hotDeal($id)
    {
        $product = Product::findOrFail($id);
        if ($product->hot_deal == Status::HOT_DEAL_ADD) {
            $product->hot_deal = Status::HOT_DEAL_REMOVE;
            $msg               = 'Product removed from hot deals';
        } else {
            $product->hot_deal = Status::HOT_DEAL_ADD;
            $msg               = 'Product added as hot deals.';
        }
        $product->save();

        $notify[] = ['success', $msg];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        return Product::changeStatus($id);
    }
}
