<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersRequest;
use App\Http\Requests\UsersEditRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['role', 'photo'])->orderBy('id')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
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
     */
    // UsersRequest in Requests! 
    public function store(UsersRequest $request): RedirectResponse
    {
        $input = $request->validated();

        if ($file = $request->file('photo_id')) {
            $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                . '-' . time() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('', $name, 's3');

            $photo = Photo::create(['file' => $name]);
            $input['photo_id'] = $photo->id;
        }

        User::create($input);

        return redirect()->route('users.index')->with('success', 'User created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(UsersEditRequest $request, $id): RedirectResponse
    {
        // UsersEditRequest
        $user = User::findOrFail($id);
        $oldPhoto = $user->photo;
        $input = $request->validated();

        if (empty($input['password'])) {
            unset($input['password']);
        }

        if ($file = $request->file('photo_id'))
        {
            $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                . '-' . time() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('', $name, 's3');

            $photo = Photo::create(['file' => $name]);
            $input['photo_id'] = $photo->id;
        }
        
        $user->update($input);

        $oldPhoto = $user->photo;

        if ($oldPhoto && $oldPhoto->id !== $user->photo_id) {
            Storage::disk('s3')->delete($oldPhoto->file);
            $oldPhoto->delete();
        }

        return redirect()->route('users.index')->with('success', 'User updated.');
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->photo) {
            Storage::disk('s3')->delete($user->photo->file);
            $user->photo->delete();
        }

        $user->delete();

        return redirect()->route('users.index')->with('info', 'User deleted.');
    }
}
