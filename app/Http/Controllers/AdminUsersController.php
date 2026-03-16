<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersRequest;
use App\Http\Requests\UsersEditRequest;
use App\Role;
use App\User;
use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminUsersController extends Controller
{
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
    public function create()
    {
        //if you put 'id'/,'name' backwards here it will not order roles the same:
        $roles = Role::pluck('name', 'id')->all();
        
        return view('admin.users.create', compact('roles'));
    }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */

        
        // UsersRequest in Requests! 
    public function store(UsersRequest $request)
    {
        if(trim($request->password) == '') {

            $input = $request->except('password');
        }
        else {

            $input = $request->all();
            $input['password'] = bcrypt($request->password);
        }

        
        if($file = $request->file('photo_id'))
        {
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file'=>$name]); 
            $input['photo_id'] = $photo->id;

        }

        
        User::create($input);

        return redirect('/admin/users');
        // return ($request->all());
    }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
    public function show($id)
    {
        return view('admin.users.show');
    }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
    public function edit($id)
    {
        //if it's just finding id, findOrFail will work.  If it's something like 'name' and 'id'
        // for role, you must use pluck() and plug in params.
        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'id')->all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
    public function update(UsersEditRequest $request, $id)
    {
        //include use UsersEditRequest at top
        $user = User::findOrFail($id);

        // If no password, do request without it. If not, encrypt it:
        if(trim($request->password) == '') {

            $input = $request->except('password');
        }
        else {
            
            $input = $request->all();
            $input['password'] = bcrypt($request->password);
        }

        //Creates (moves) photo into images folder, updates this 'file' part of request:
        if($file = $request->file('photo_id'))
        {
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file'=>$name]);
            $input['photo_id'] = $photo->id;
        }
        $user->update($input);
        return redirect('/admin/users');
    }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
    public function destroy($id)
    {
        // Illuminate\Support\Facades\Session;
        $user = User::findOrFail($id);

        // Delete file from images folder:
        // unlink( 'path-to-public' . $user->photo->file);
        unlink(public_path() . $user->photo->file);
        $user->delete();

        Session::flash('deleted_user', 'User has been deleted.');

        return redirect('/admin/users');


    }
}
