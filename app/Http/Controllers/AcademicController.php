<?php

namespace App\Http\Controllers;

use App\Models\Academic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class AcademicController extends Controller
{
    public function index()
    {
        $all_academies = Academic::all();
        return view('admin.academy.academy_list', compact('all_academies'));
    }

    public function create()
    {
        return view('admin.academy.add_new_academy');
    }

    public function store(Request $request)
    {
        //return $request;
        $image = $request->file('image');
        if (!empty($image)) {


            $fileType = $image->getClientOriginalExtension();
            $imageName = rand() . '.' . $fileType;
            $path_info = pathinfo($imageName, PATHINFO_EXTENSION);
            $directory = 'Academic_Images/';
            if ($path_info == 'pdf' || 'docx') {
                $imageUrl = $directory . $imageName;
                //return $imageUrl;
                $image->move($directory, $imageName);
            } else {
                $imageUrl = $directory . $imageName;
                Image::make($image)->save($imageUrl);
            }

        } //return $request->file('image');
        else {
            $imageUrl = null;
        }

        $result = Academic::create([
            'academy_name' => $request->get('academy_name'),
            'academy_description' => $request->get('academy_description'),
            'image' => $imageUrl,
        ]);
        if ($result) {
            return back()->with('success', 'Added Successfully');
        } else {
            return back()->with('error', 'Failed To Add');
        }
    }

    public function edit($id)
    {
        $result = Academic::find($id);
        return json_encode($result);
    }

    public function update(Request $request)
    {
        //return $request;
        $image = $request->file('image');
        $old_academic_info = Academic::find($request->academy_id);

        //return $request->file('title_image');
        if (!empty($image)) {
            File::delete($old_academic_info->image);
            $fileType = $image->getClientOriginalExtension();
            $imageName = rand() . '.' . $fileType;
            $path_info = pathinfo($imageName, PATHINFO_EXTENSION);
            $directory = 'Academic_Images/';
            if ($path_info == 'pdf' || 'docx') {
                $imageUrl = $directory . $imageName;
                //return $imageUrl;
                $image->move($directory, $imageName);
            } else {
                $imageUrl = $directory . $imageName;
                Image::make($image)->save($imageUrl);
            }

            $result = Academic::find($request->academy_id)->update([
                'academy_name' => $request->get('academy_name'),
                'academy_description' => $request->get('academy_description'),
                'image' => $imageUrl,
            ]);
        } else {
            $result = Academic::find($request->academy_id)->update([
                'academy_name' => $request->get('academy_name'),
                'academy_description' => $request->get('academy_description'),
            ]);
        }

        if ($result) {
            return back()->with('success', 'Updated Successfully');
        } else {
            return back()->with('error', 'Failed To Update');
        }
    }

    public function destroy($id)
    {
//        return $id;
        $academy = Academic::find($id);

        if (!$academy) {

            return back()->with('error', 'Failed To Delete');
        } else {
            File::delete($academy->image);
            Academic::find($id)->delete();
            return back()->with('success', 'Data Deleted');
        }
    }
}
