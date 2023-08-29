<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $all_addresses = Address::all();
        return view('admin.address.address_list',compact('all_addresses'));
    }

    public function create()
    {
        return view('admin.address.add_new_address');
    }

    public function store(Request $request)
    {
        $result = Address::create([
           'ein_no' => $request->get('ein_no'),
           'college_code' => $request->get('college_code'),
           'school_code' => $request->get('school_code'),
           'phone' => $request->get('phone'),
           'address' => $request->get('address'),
        ]);
        if ($result)
        {
            return back()->with('success','Added Successfully');
        }
        else
        {
            return back()->with('error','Failed To Add');
        }
    }

    public function show(Address $address)
    {
        //
    }

    public function edit($id)
    {
        $res = Address::find($id);
        return json_encode($res);
    }

    public function update(Request $request)
    {
        //return $request;

        $id = $request->get('address_id');
        $result = Address::find($id)->update(
            [
                'ein_no' => $request->get('ein_no'),
                'college_code' => $request->get('college_code'),
                'school_code' => $request->get('school_code'),
                'phone' => $request->get('phone'),
                'address' => $request->get('address'),
            ]
        );
        if ($result)
        {
            return back()->with('success','Added Successfully');
        }
        else
        {
            return back()->with('error','Failed To Add');
        }
    }

    public function destroy($id)
    {
        $res = Address::find($id)->delete();
        if ($res)
        {
            return back()->with('success',' Successfully Deleted');
        }
        else
        {
            return back()->with('error','Failed To Delete');
        }
    }
}
