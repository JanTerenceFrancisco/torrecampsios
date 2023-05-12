<?php

namespace App\Http\Controllers\Pos;

use App\Models\Unit;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function ProductAll()
    {
        $products = Product::latest()->get();
        return view('backend.product.product_all', compact('products'));
    }

    public function ProductAdd()
    {
        $supplier = Supplier::all();
        $category = Category::all();
        $unit = Unit::all();
        return view('backend.product.product_add', compact('supplier', 'category', 'unit'));
    }

    public function ProductStore(Request $request)
    {
        $image = $request->file('product_image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(200, 200)->save('upload/products/' . $name_gen);
        $save_url = 'upload/products/' . $name_gen;

        Product::insert([
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ', '-', $request->product_name)),
            'supplier_id' => $request->supplier_id,
            'unit_id' => $request->unit_id,
            'category_id' => $request->category_id,
            'quantity' => '0',
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
            'product_image' => $save_url,
        ]);

        $notification = array(
            'message' => 'Product Created',
            'alert-type' => 'success',
        );

        return redirect()->route('product.all')->with($notification);
    }

    public function ProductEdit($id)
    {
        $supplier = Supplier::all();
        $category = Category::all();
        $unit = Unit::all();
        $product = Product::findOrFail($id);
        return view('backend.product.product_edit', compact('supplier', 'category', 'unit', 'product'));
    }

    public function ProductUpdate(Request $request)
    {
        $product_id = $request->id;

        if ($request->file('product_image')) {
            $image = $request->file('product_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(200, 200)->save('upload/products/' . $name_gen);
            $save_url = 'upload/products/' . $name_gen;

            Product::findOrFail($product_id)->update([
                'product_name' => $request->product_name,
                'product_slug' => strtolower(str_replace(' ', '-', $request->product_name)),
                'supplier_id' => $request->supplier_id,
                'unit_id' => $request->unit_id,
                'category_id' => $request->category_id,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
                'product_image' => $save_url,
            ]);
    
            $notification = array(
                'message' => 'Product Updated',
                'alert-type' => 'success',
            );
    
            return redirect()->route('product.all')->with($notification);
        } else {
            Product::findOrFail($product_id)->update([
                'product_name' => $request->product_name,
                'product_slug' => strtolower(str_replace(' ', '-', $request->product_name)),
                'supplier_id' => $request->supplier_id,
                'unit_id' => $request->unit_id,
                'category_id' => $request->category_id,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'message' => 'Product Updated',
                'alert-type' => 'info',
            );
    
            return redirect()->route('product.all')->with($notification);
        }
    }
    public function ProductDelete($id)
    {
        $product = Product::findOrFail($id);
        $img = $product->product_image;
        unlink($img);

        Product::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Product Deleted',
            'alert-type' => 'info',
        );

        return redirect()->back()->with($notification);
    }
}
