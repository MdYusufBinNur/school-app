<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Contact_Page;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $all_contacts = Contact::all();
        return view('admin.contact.contact_list',compact('all_contacts'));
    }

    public function create()
    {
        return view('admin.contact.add_new_contact');
    }

    public function store(Request $request)
    {
        $email = $request->get('email');
        $phone = $request->get('phone');
        $website = $request->get('website');

        $result = Contact::create([
            'email' => $email,
            'phone' => $phone,
            'website' => $website,
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

    public function show(Contact $contact)
    {
        //
    }

    public function edit($id)
    {
        $result = Contact::find($id);
        return json_encode($result);
    }

    public function update(Request $request)
    {
        $result = Contact::find($request->get('contact_id'))->update([
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'website' => $request->get('website')
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
        $check  = Contact::find($id);

        if (!empty($check))
        {
            Contact::find($id)->delete();
            return back()->with('success','Deleted Successfully');
        }
        else
        {
            return back()->with('error','Failed To Update');

        }
    }

    public function destroy_message($id)
    {
        $check  = Contact_Page::find($id);

        if (!empty($check))
        {
            Contact_Page::find($id)->delete();
            return back()->with('success','Deleted Successfully');
        }
        else
        {
            return back()->with('error','Failed To Update');

        }
    }

    public function save_message(Request $request)
    {
        Contact_Page::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'subject' => $request->get('subject'),
            'message' => $request->get('message'),
        ]);
        return back()->with('success','Message Sent');
    }


    public function view_message()
    {
        $all_contacts = Contact_Page::query()->select('*')->orderBy('id','DESC')->get();

        return view('admin.contact.contact_page_list',compact('all_contacts'));
    }
}
