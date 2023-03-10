<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Http\Request;
use App\Http\Requests\Contacts\CreateFormRequest;
use App\Http\Requests\Contacts\UpdateFormRequest;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    protected $contactService;

    public function __construct()
    {
        $this->contactService = new ContactService();
        // Initiate Permission
        $this->middleware('permission:contact-list', ['only' => ['index']]);
        $this->middleware('permission:contact-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:contact-view', ['only' => ['show']]);
        $this->middleware('permission:contact-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:contact-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->all();
        return view('contacts.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFormRequest $request)
    {
        $type = $request->contactable_type;
        $validatedData = $request->all();
        $contact = $this->contactService->updateOrCreate($validatedData);

        if (is_null($contact) === false) {
            $message = message("Contact has been successfully created.");
        } else {
            $message = message("Contact has not created.", "error");
        }
        session()->flash("message", $message);
        if ($type == 'Vendor') {
            return redirect()->route('vendors.index');
        } else {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        $data = ['id' => $contact->contactable_id, 'type' => Str::remove('App\Models\\',$contact->contactable_type)];
        return view("contacts.edit", compact(["contact", "data"]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormRequest $request, Contact $contact)
    {
        $validatedData = $request->all();
        $updated_contact = $this->contactService->updateOrCreate($validatedData, $contact);

        if(is_null($updated_contact) === false){
            $message = message("Contact has been successfully updated.");
        }else{
            $message = message("Contact has not updated.", "error");
        }
        session()->flash("message", $message);
        if ($request->contactable_type == 'Vendor') {
            return redirect()->route('vendors.show', $request->contactable_id);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->back();
    }
}
