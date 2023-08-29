<?php

namespace App\Http\Controllers;

use App\Models\CornerMessage;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class NoticeController extends Controller
{
    public function index()
    {
        $all_notices = Notice::query()->select('*')->orderBy('id','DESC')->paginate(10);
        return view('admin.notice.notice_list',compact('all_notices'));
    }

    public function create()
    {
        return view('admin.notice.add_new_notice');
    }

    public function store(Request $request)
    {

        $image = $request->file('image');
//        pathinfo($image, PATHINFO_EXTENSION);
//
//        $uniqueFileName = uniqid() . $request->file('image')->getClientOriginalName();
//
//        $request->get('upload_file')->move(public_path('files') . $uniqueFileName);

        if (empty($request->get('notice_title')))
        {
            $details = null;
        }
        else
        {
            $details =  $request->get('notice_title');
        }
        if (!empty($image))
        {
            $fileType    = $image->getClientOriginalExtension();
            $imageName   = rand().'.'.$fileType;
            $path_info = pathinfo($imageName, PATHINFO_EXTENSION);
            $directory   = 'Notice_Images/';
            if ($path_info == 'pdf' || 'docx')
            {
                $imageUrl   = $directory.$imageName;
                //return $imageUrl;
                $image->move($directory,$imageName);
            }
            else{
                $imageUrl    = $directory.$imageName;
                Image::make($image)->save($imageUrl);
            }

        }
        //return $request->file('image');
        else
        {
            $imageUrl = null;
        }

        $result = Notice::create([
           'title' => $request->get('notice_title'),
           'date' => $request->get('date'),
           'notice_details' => $details,
            'image' => $imageUrl
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

    public function show(Notice $notice)
    {
        //
    }

    public function edit($id)
    {
        $result = Notice::find($id);
        return json_encode($result);
    }

    public function update(Request $request)
    {
        $id = $request->get('notice_id');
        $old_val = Notice::find($id);
        $image = $request->file('image');
        if (empty($request->get('notice_title')))
        {
            $details = $old_val->notice_title;
        }
        else
        {
            $details = $request->get('notice_title');
        }
        if (!empty($image))
        {
            File::delete($old_val->image);
            $fileType    = $image->getClientOriginalExtension();
            $imageName   = rand().'.'.$fileType;
            $path_info = pathinfo($imageName, PATHINFO_EXTENSION);
            $directory   = 'Notice_Images/';
            if ($path_info == 'pdf' || 'docx')
            {
                $imageUrl   = $directory.$imageName;
                //return $imageUrl;
                $image->move($directory,$imageName);
            }
            else{
                $imageUrl    = $directory.$imageName;
                Image::make($image)->save($imageUrl);
            }
//            $imageUrl    = $directory.$imageName;
//            Image::make($image)->save($imageUrl);
        }
        else
        {
            $imageUrl = $old_val->image;
        }

        $result = Notice::find($id)->update([
            'title' => $request->get('notice_title'),
            'date' => $request->get('date'),
            'notice_details' => $details,
            'image' => $imageUrl
        ]);
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
        $about = Notice::find($id);

        //dd($about);
        if (!$about)
        {
            return back()->with('error','Failed To Delete');
        }
        else
            {
            File::delete($about->image);
            Notice::find($id)->delete();
            return back()->with('success','Data Deleted');
        }
    }
}
