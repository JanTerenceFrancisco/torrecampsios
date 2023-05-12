<?php

namespace App\Http\Controllers\Pos;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function SupplierAll()
    {
        $suppliers = Supplier::latest()->get();
        return view('backend.supplier.supplier_all', compact('suppliers'));
    }

    public function SupplierAdd()
    {
        return view('backend.supplier.supplier_add');
        
    }

    public function SupplierStore(Request $request)
    {
        Supplier::insert([
            'supplier_name' => $request->supplier_name,
            'supplier_phone' => $request->supplier_phone,
            'supplier_email' => $request->supplier_email,
            'supplier_address' => $request->supplier_address,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Supplier Added',
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.all')->with($notification);
    }

    public function SupplierEdit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('backend.supplier.supplier_edit', compact('supplier'));
    }

    public function SupplierUpdate(Request $request)
    {
        $supplier_id = $request->id;

        Supplier::findOrFail($supplier_id)->update([
            'supplier_name' => $request->supplier_name,
            'supplier_phone' => $request->supplier_phone,
            'supplier_email' => $request->supplier_email,
            'supplier_address' => $request->supplier_address,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Supplier Updated',
            'alert-type' => 'info'
        );

        return redirect()->route('supplier.all')->with($notification);
    }

    public function SupplierDelete($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        $notification = array(
            'message' => 'Supplier Deleted',
            'alert-type' => 'info'
        );

        return redirect()->back()->with($notification);
    }
}
