<?php

namespace App\Http\Controllers\Pos;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller
{
    public function CustomerAll()
    {
        $customers = Customer::latest()->get();
        return view('backend.customer.customer_all', compact('customers'));
    }

    public function CustomerAdd()
    {
        return view('backend.customer.customer_add');
    }

    public function CustomerStore(Request $request)
    {
        $image = $request->file('customer_image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(200, 200)->save('upload/customer/' . $name_gen);
        $save_url = 'upload/customer/' . $name_gen;

        Customer::insert([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'customer_address1' => $request->customer_address1,
            'customer_address2' => $request->customer_address2,
            'customer_city' => $request->customer_city,
            'customer_province' => $request->customer_province,
            'customer_zipcode' => $request->customer_zipcode,
            'customer_image' => $save_url,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Customer Created',
            'alert-type' => 'success'
        );

        return redirect()->route('customer.all')->with($notification);
    }

    public function CustomerEdit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('backend.customer.customer_edit', compact('customer'));
    }

    public function CustomerUpdate(Request $request)
    {
        $customer_id = $request->id;

        if ($request->file('customer_image')) {
            $image = $request->file('customer_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(200, 200)->save('upload/customer/' . $name_gen);
            $save_url = 'upload/customer/' . $name_gen;

            Customer::findOrFail($customer_id)->update([
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'customer_address1' => $request->customer_address1,
                'customer_address2' => $request->customer_address2,
                'customer_city' => $request->customer_city,
                'customer_province' => $request->customer_province,
                'customer_zipcode' => $request->customer_zipcode,
                'customer_image' => $save_url,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Customer Updated',
                'alert-type' => 'success'
            );

            return redirect()->route('customer.all')->with($notification);
        } else {
            Customer::findOrFail($customer_id)->update([
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'customer_address1' => $request->customer_address1,
                'customer_address2' => $request->customer_address2,
                'customer_city' => $request->customer_city,
                'customer_province' => $request->customer_province,
                'customer_zipcode' => $request->customer_zipcode,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Customer Updated',
                'alert-type' => 'success'
            );

            return redirect()->route('customer.all')->with($notification);
        }
    }

    public function CustomerDelete($id)
    {
        $customer = Customer::findOrFail($id);
        $img = $customer->customer_image;
        unlink($img);

        Customer::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Customer Deleted',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
