<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class FacilityController extends Controller
{
    public function index()
    {
        $all_facilities = Facility::all();
        return view('admin.facility.facility_list',compact('all_facilities'));
    }

    public function create()
    {
        return view('admin.facility.add_new_facility');
    }

    public function store(Request $request)
    {
        //return $request;
        $image = $request->file('image');
        if (!empty($image))
        {
            $fileType    = $image->getClientOriginalExtension();
            $imageName   = rand().'.'.$fileType;
            $directory   = 'Facility_Images/';
            $imageUrl    = $directory.$imageName;
            Image::make($image)->save($imageUrl);
        }
        //return $request->file('image');
        else
        {
            $imageUrl = null;
        }

        $result = Facility::create([
            'facility_name' => $request->get('facility_name'),
            'facility_description' => $request->get('facility_description'),
            'image' => $imageUrl,
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

    public function show(Facility $Facility)
    {
        //
    }

    public function edit($id)
    {
        $result = Facility::find($id);
        return json_encode($result);
    }

    public function update(Request $request)
    {
        //return $request;
        $image = $request->file('image');
        $old_facility_info =  Facility::find($request->facility_id);

        //return $request->file('title_image');
        if (!empty($image))
        {
            File::delete($old_facility_info->image);
            $fileType    = $image->getClientOriginalExtension();
            $imageName   = rand().'.'.$fileType;
            $directory   = 'Facility_Images/';
            $imageUrl    = $directory.$imageName;
            Image::make($image)->save($imageUrl);

            $result = Facility::find($request->facility_id)->update([
                'facility_name' => $request->get('facility_name'),
                'facility_description' => $request->get('facility_description'),
                'image' => $imageUrl,
            ]);
        }
        else
        {
            $result =Facility::find($request->facility_id)->update([
                'facility_name' => $request->get('facility_name'),
                'facility_description' => $request->get('facility_description'),
            ]);
        }

        if ($result)
        {
            return back()->with('success','Updated Successfully');
        }
        else
        {
            return back()->with('error','Failed To Update');
        }
    }

    public function destroy($id)
    {
//        return $id;
        $Facility = Facility::find($id);

        if (!$Facility)
        {

            return back()->with('error','Failed To Delete');
        }
        else{
            File::delete($Facility->image);
            Facility::find($id)->delete();
            return back()->with('success','Data Deleted');
        }
    }
}
