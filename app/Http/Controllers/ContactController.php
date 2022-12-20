<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Crypt;

class ContactController extends Controller
{

    public function index(Request $request)
    {
        $contacts = Contact::all();
        // dd($contacts);
        return view('contacts.index', compact('contacts'))
            ->with('i');
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required'
        ]);

        $contact = new Contact([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'job_title' => $request->get('job_title'),
            'city' => $request->get('city'),
            'country' => $request->get('country')
        ]);
        $contact->save();
        return redirect('/contacts')
            ->with('success', 'Contact saved!');
    }

    public function show($id)
    {
        // $contact = Contact::find(Crypt::decrypt($id));
        $contact = Contact::find(Crypt::decryptString($id));
        return view('contacts.show', compact('contact'));
    }

    public function edit($id)
    {
        $contact = Contact::find(Crypt::decryptString($id));
        return view('contacts.edit  ', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required'
        ]);

        $contact = Contact::find(Crypt::decryptString($id));
        $contact->first_name =  $request->get('first_name');
        $contact->last_name = $request->get('last_name');
        $contact->email = $request->get('email');
        $contact->job_title = $request->get('job_title');
        $contact->city = $request->get('city');
        $contact->country = $request->get('country');
        $contact->save();
        return redirect('/contacts')
            ->with('success', 'Contact updated!');
    }

    public function destroy($id)
    {
        $contact = Contact::find(Crypt::decryptString($id));
        $contact->delete();
        return redirect('/contacts')
            ->with('success', 'Contact deleted!');
    }
}
