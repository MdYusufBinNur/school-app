<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class MemberController extends Controller
{
    public function index()
    {
        $all_members = Member::paginate(10);
        return view('admin.member.member_list',compact('all_members'));
    }

    public function create()
    {
        return view('admin.member.add_new_member');
    }

    public function store(Request $request)
    {
//        return $request;
        $image = $request->file('image');
        if (!empty($image))
        {
            $fileType    = $image->getClientOriginalExtension();
            $imageName   = rand().'.'.$fileType;
            $directory   = 'Member_Image/';
            $imageUrl    = $directory.$imageName;
            Image::make($image)->save($imageUrl);
        }
        //return $request->file('image');
        else
        {
            $imageUrl = null;
        }
        $result = Member::create(
            [
                'name' => $request->get('name'),
                'member_type' => $request->get('member_type'),
                'designation' => $request->get('designation'),
                'mobile' => $request->get('mobile'),
                'image' => $imageUrl

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

    public function show(Member $member)
    {
        //
    }

    public function edit($id)
    {
        $res = Member::find($id);
        return json_encode($res);
    }

    public function update(Request $request)
    {
        //return $request;
        $id = $request->get('member_id');
        $old_cat = Member::find($id);
        $type = $request->get('member_type');

        $image = $request->file('image');
        if (!empty($image))
        {
            $fileType    = $image->getClientOriginalExtension();
            $imageName   = rand().'.'.$fileType;
            $directory   = 'Member_Image/';
            $imageUrl    = $directory.$imageName;
            Image::make($image)->save($imageUrl);
        }
        //return $request->file('image');
        else
        {
            $imageUrl = $old_cat->image;
        }
        if (!empty($type))
        {
            $member_type = $type;
        }
        else
        {
            $member_type = $old_cat->member_type;
        }

        $result = Member::find($id)->update(
            [
                'name' => $request->get('name'),
                'member_type' => $member_type,
                'designation' => $request->get('designation'),
                'mobile' => $request->get('mobile'),
                'image' => $imageUrl
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
//        return $id;
        $member = Member::find($id);

        if (!$member)
        {
            return back()->with('error','Failed To Delete');
        }
        else{
            File::delete($member->image);
            Member::find($id)->delete();
            return back()->with('success','Data Deleted');
        }
    }
}
