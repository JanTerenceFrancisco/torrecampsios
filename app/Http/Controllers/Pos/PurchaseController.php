<?php

namespace App\Http\Controllers\Pos;

use App\Models\Unit;
use App\Models\Product;
use App\Models\Category;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PurchaseController extends Controller
{
    public function PurchaseAll()
    {
        $allData = Purchase::orderBy('date', 'DESC')->orderBy('id', 'DESC')->get();
        return view('backend.purchase.purchase_all', compact('allData'));
    }

    public function PurchaseAdd()
    {
        $supplier = Supplier::all();
        $category = Category::all();
        $unit = Unit::all();
        return view('backend.purchase.purchase_add', compact('supplier', 'category', 'unit'));
    }
}
