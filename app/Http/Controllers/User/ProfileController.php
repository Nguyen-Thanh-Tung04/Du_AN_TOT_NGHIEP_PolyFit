<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ProfileController extends Controller
{
    public function listProfile(){
        $profile = User::all();
        return view('client.page.profile')->with([
            'profile' => $profile
        ]);
    }
    // public function updateProfile($idUser){
    //     $profile = User::where('id',$idUser)->first();
    //     return view('client.page.profile')->with([
    //         'profile' => $profile
    //     ]);
    // }
    public function updateProfile($idUser,Request $req){
        $data = $req->all();
        User::find($idUser)->update($data);
        return redirect()->route('listProfile');
    }
    

}
