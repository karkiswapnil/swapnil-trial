<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MailSubscribers;

use App\Notifications\NewUser;

class MailSubscribersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MailSubscribers::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'first_name'=>'required|string|max:191',
            'last_name'=>'required|string|max:191',
            'email'=>'required|string|max:191|email|unique:mail_subscribers',
          
        ]);
        $susbcriber = MailSubscribers:: create([
            'first_name'=>$request['first_name'],
            'last_name'=>$request['last_name'],
            'email'=>$request['email']
        ]);

        $susbcriber->notify(new NewUser($susbcriber));

        return $susbcriber;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $susbcriber = MailSubscribers::findorFail($id);

        $this->validate($request,[
            'first_name'=>'required|string|max:191',
            'last_name'=>'required|string|max:191',
            'email'=>'required|string|max:191|email|unique:users,email,'.$susbcriber->id,
        ]);
        $susbcriber->update($request->all());

        return['message'=>'updated susbscriber info '];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $susbcriber = MailSubscribers::findorFail($id);

        //delete user
        $susbcriber->delete();

        return['message'=>'user deleted'];
    }
}
