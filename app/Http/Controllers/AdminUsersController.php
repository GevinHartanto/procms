<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use App\Photo;
use App\Role;
use App\Http\Requests\UsersEditRequest;
use App\Http\Requests\UsersRequest;
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
        //
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
        //
		$roles = Role::lists('name', 'id')->all();
		return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        //
		//return view('admin.users.store');
		//User::create($request->all());
		
		if(trim($request->password) == '')
		{
			$input = $request->except('password');
		}
		else{
			$input = $request->all();
			$input['password'] = bcrypt($request->password);
		}
		
		//$input = $request->all();
		
		//jika user mengupload file, maka ini akan dijalankan
		if($file = $request->file('photo_id'))
		{
			//set nama file --> waktu + nama original file
			$name = time() .$file->getClientOriginalName();
			
			//move file to image folder
			$file->move('images', $name);
			
			//buat object photo dari file yang diupload
			$photo = Photo::create(['file'=>$name]);
			
			//set photo_id
			$input['photo_id'] = $photo->id;	
		}
		
		//enkrip password sebelum di simpan ke database
		//$input['password'] = bcrypt($request->password);
		//simpan ke database
		User::create($input);
		
		return redirect('/admin/users');
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
        //
		$user = User::findorFail($id);
		$roles = Role::lists('name', 'id')->all();
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
        //
		
		$user = User::findOrFail($id);
		
		if(trim($request->password) == ''){
			$input = $request->except('password');
		}
		else{
			$input = $request->all();
			$input['password'] = bcrypt($request->password);
		}

		//$input = $request->all();
		
		if($file = $request->file('photo_id')){
			$name = time() . $file->getClientOriginalName();
			$file->move('images', $name);
			$photo = Photo::create(['file'=>$name]);
			$input['photo_id'] = $photo->id;
		}
		
		$user->update($input);
		
		return redirect('/admin/users');
		
		
		//return $request->all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
		$user=User::findOrFail($id)->delete();
		unlink(public_path() . $user->photo->file);
		$user->delete();
		
		Session::flash('deleted_user', 'The user has been deleted.');
		return redirect('/admin/users');
    }
}
