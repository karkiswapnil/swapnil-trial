<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->paginate(10);
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
            'name'=>'required|string|max:191',
            'email'=>'required|string|max:191|email|unique:users',
            'password'=>'required|string|min:6',
            'role'=>'required|string|max:191',
        ]);

        return User:: create([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'password' => Hash::make($request['password']),
            'role'=>$request['role']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::all();
    }

    public function profile()
    {
        return auth('api')->user();
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();

        $this->validate($request,[
            'name'=>'required|string|max:191',
            'email'=>'required|string|max:191|email|unique:users,email,'.$user->id,
            'password'=>'sometimes|min:6',
            'role'=>'nullable|string|max:191',
            
        ]);

        $currentPhoto= $user->photo;

        if($request->photo != $currentPhoto){
            $name=time().'.'.explode('/',explode(':',substr($request->photo,0,strpos($request->photo,';')))[1])[1];
           // $name = 'name.png';
           //Intervention image put
            \Image::make($request->photo)->save(public_path('img/profile/').$name);

            $request->merge(['photo' => $name]);
        }

        if(!empty($request->password))
        {
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user->update($request->all());
        return ['message'=>"Updated user profile"];

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
        $user = User::findorFail($id);

        $this->validate($request,[
            'name'=>'required|string|max:191',
            'email'=>'required|string|max:191|email|unique:users,email,'.$user->id,
            'password'=>'sometimes|min:6',
            'role'=>'required|string|max:191',
        ]);
        $user->update($request->all());

        return['message'=>'updated user info '];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findorFail($id);

        //delete user
        $user->delete();

        return['message'=>'user deleted'];
    }
}
