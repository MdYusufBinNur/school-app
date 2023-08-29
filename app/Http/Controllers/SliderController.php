<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class SliderController extends Controller
{
    public function index()
    {
        $all_sliders = Slider::all();
        return view('admin.slider.slider_list',compact('all_sliders'));
    }

    public function create()
    {
        return view('admin.slider.add_new_slider');
    }

    public function store(Request $request)
    {
        //return $request;
        $image = $request->file('slider_image');
        if (!empty($image))
        {
            $fileType    = $image->getClientOriginalExtension();
            $imageName   = rand().'.'.$fileType;
            $directory   = 'Slider_Images/';
            $imageUrl    = $directory.$imageName;
            Image::make($image)->save($imageUrl);
        }
        //return $request->file('image');
        else
        {
            $imageUrl = null;
        }

        $result = Slider::create(
            [
                'slider_name' => $request->get('title'),
                'slider_image' => $imageUrl
            ]
        );


        if ($result)
        {
            return back()->with('success','Updated Successfully');
        }
        else
        {
            return back()->with('error','Failed To Update');
        }
    }

    public function show(Slider $slider)
    {
        //
    }

    public function edit($id)
    {
        $result = Slider::find($id);
        return json_encode($result);
    }

    public function update(Request $request)
    {
        $image = $request->file('slider_image');
        $old_category_info =  Slider::find($request->slider_id);

        //return $request->file('title_image');
        if (!empty($image)){

            File::delete($old_category_info->slider_image);

            $fileType    = $image->getClientOriginalExtension();
            $imageName   = rand().'.'.$fileType;
            $directory   = 'Slider_Images/';
            $imageUrl    = $directory.$imageName;
            Image::make($image)->save($imageUrl);

            $result = Slider::find($request->slider_id)->update([
                'slider_name' => $request->get('title'),

                'slider_image' => $imageUrl,
            ]);
        }
        else
        {
            $result =Slider::find($request->slider_id)->update([
                'slider_name' => $request->get('title'),
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
        $about = Slider::find($id);

        if (!$about)
        {
            return back()->with('error','Failed To Delete');
        }
        else{
            File::delete($about->slider_image);
            Slider::find($id)->delete();
            return back()->with('success','Data Deleted');
        }
    }
}
