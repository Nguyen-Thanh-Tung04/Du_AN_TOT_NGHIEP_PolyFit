<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ProfileController extends Controller
{
    public function listProfile(){
        $profile = User::all();
        return view('client.page.profile', compact('profile') );
    }

    public function updateProfile($idUser,Request $req){

        $req->validate([
            'name' => 'required|alpha|max:255',
            'email' => 'required|email|',
            'phone' => 'required|digits:10',
            'birthday' =>'required|date',
            'address' => 'required|max:255',
        ]);

        $profile = User::find( $idUser)->first();
        $data = $req->except('image');
        if($req->hasFile('image')){
            $path_image = $req->file('image')->store('user','public');
            $data['image'] = $path_image;
        }
        else{
            $data['image'] =$profile->image;
        }
        $profile->update($data);

        return redirect()->back();



    }
    public function changePassword(){
        $password = User::all();
        return view('client.page.changeword',compact('password'));
    }
    public function updatePassword(Request $req){
        $req->validate([
            'password'=>'required|alpha_num|unique:users,password|min:8',
            'newPassword'=>'required|alpha_num|min:8',
            're-enter password'=> 'required|same:newPassword'
        ]);
    }


}
