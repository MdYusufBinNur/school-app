<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class AboutController extends Controller
{
    public function index()
    {
        $all_abouts = About::all();
        return view('admin.about.about_list',compact('all_abouts'));
    }

    public function create()
    {
        return view('admin.about.add_new_about');
    }

    public function store(Request $request)
    {
       //return $request;
        $image = $request->file('title_image');
        if (!empty($image))
        {
            $fileType    = $image->getClientOriginalExtension();
            $imageName   = rand().'.'.$fileType;
            $directory   = 'About_Images/';
            $imageUrl    = $directory.$imageName;
            Image::make($image)->save($imageUrl);
        }
        //return $request->file('image');
        else
        {
            $imageUrl = null;
        }

        $result = About::create([
            'title' => $request->get('title'),
            'title_description' => $request->get('title_description'),
            'title_image' => $imageUrl,
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

    public function show(About $about)
    {
        //
    }

    public function edit($id)
    {
        $result = About::find($id);
        return json_encode($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        //return $request;
        $image = $request->file('title_image');
        $old_category_info =  About::find($request->about_id);

        //return $request->file('title_image');
        if (!empty($image))
        {
            File::delete($old_category_info->title_image);
            $fileType    = $image->getClientOriginalExtension();
            $imageName   = rand().'.'.$fileType;
            $directory   = 'About_Images/';
            $imageUrl    = $directory.$imageName;
            Image::make($image)->save($imageUrl);

            $result = About::find($request->about_id)->update([
                'title' => $request->get('title'),

                'title_description' => $request->get('title_description'),
                'title_image' => $imageUrl,
            ]);
        }
        else
        {
            $result =About::find($request->about_id)->update([
                'title' => $request->get('title'),

                'title_description' => $request->get('title_description'),
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

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $about = About::find($id);

        if (!$about)
        {
            return back()->with('error','Failed To Delete');
        }
        else{
            File::delete($about->title_image);
            About::find($id)->delete();
            return back()->with('success','Data Deleted');
        }
    }
}
