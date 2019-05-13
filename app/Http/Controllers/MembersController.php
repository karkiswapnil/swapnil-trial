<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Member;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::orderBy('id','asc')->paginate(10);
        return view('members.index')->with('members',$members);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('members.create');
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
            //'first_name'=>'required',
           // 'last_name'=>'required',
        ]);
        //create member
        $member = new Member;
        $member->name = $request->input('name');
        $member->dob = $request->input('dob');
        $member->gender = $request->input('gender');
        $member->phone_number = $request->input('phone_number');
        $member->mobile_number = $request->input('mobile_number');
        $member->religion = $request->input('religion');
        $member->save();

        return redirect('/members')->with('success','New member added');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member= Member::find($id);
        return view('members.edit')->with('member',$member);
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
        $this->validate($request,[
           
        ]);
        //create member
        $member = Member::find($id);
        $member->name = $request->input('name');
        $member->dob = $request->input('dob');
        $member->gender = $request->input('gender');
        $member->phone_number = $request->input('phone_number');
        $member->mobile_number = $request->input('mobile_number');
        $member->religion = $request->input('religion');
        $member->save();

        return redirect('/members')->with('success','Member edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = Member::find($id);
        $member->delete();

        return redirect('/members')->with('error','Member deleted');
    }
}
