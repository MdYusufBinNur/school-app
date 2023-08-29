<?php

namespace App\Http\Controllers;

use App\Models\NewsAndEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class NewsAndEventController extends Controller
{
    public function index()
    {
        $all_news_events = NewsAndEvent::query()->select('*')->orderBy('id','DESC')->paginate(10);
        return view('admin.news_and_events.news_events_list',compact('all_news_events'));
    }

    public function create()
    {
        return view('admin.news_and_events.add_news_events');
    }

    public function store(Request $request)
    {

        $image = $request->file('image');
//        pathinfo($image, PATHINFO_EXTENSION);
//
//        $uniqueFileName = uniqid() . $request->file('image')->getClientOriginalName();
//
//        $request->get('upload_file')->move(public_path('files') . $uniqueFileName);

        if (empty($request->get('title')))
        {
            $details = null;
        }
        else
        {
            $details =  $request->get('title');
        }
        if (!empty($image))
        {
            $fileType    = $image->getClientOriginalExtension();
            $imageName   = rand().'.'.$fileType;
            $path_info = pathinfo($imageName, PATHINFO_EXTENSION);
            $directory   = 'NewsAndEvent_Images/';
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

        $result = NewsAndEvent::create([
            'title' => $request->get('title'),
            'date' => $request->get('date'),

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

    public function show(NewsAndEvent $notice)
    {
        //
    }

    public function edit($id)
    {
        $result = NewsAndEvent::find($id);
        return json_encode($result);
    }

    public function update(Request $request)
    {
        $id = $request->get('news_events_id');
        //return $id;
        $old_val = NewsAndEvent::find($id);
        //return $old_val;
        $image = $request->file('image');

        if (!empty($image))
        {
            File::delete($old_val->image);
            $fileType    = $image->getClientOriginalExtension();
            $imageName   = rand().'.'.$fileType;
            $directory   = 'NewsAndEvent_Images/';

            $path_info = pathinfo($imageName, PATHINFO_EXTENSION);
            $directory   = 'NewsAndEvent_Images/';
            if ($path_info == 'pdf' || 'docx')
            {
                $imageUrl   = $directory.$imageName;

                $image->move($directory,$imageName);
            }
            else{
                $imageUrl    = $directory.$imageName;
                Image::make($image)->save($imageUrl);
            }
;
        }
        else
        {
            $imageUrl = $old_val->image;
        }

        $result = NewsAndEvent::find($id)->update([
            'title' => $request->get('title'),
            'date' => $request->get('date'),

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
        $about = NewsAndEvent::find($id);

        //dd($about);
        if (!$about)
        {
            return back()->with('error','Failed To Delete');
        }
        else
        {
            File::delete($about->image);
            NewsAndEvent::find($id)->delete();
            return back()->with('success','Data Deleted');
        }
    }
}
