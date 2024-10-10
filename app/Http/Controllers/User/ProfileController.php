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
        $profile = User::where('id', $idUser)->first();
        $linkImage = $profile->image;

        if($req->hasFile('imageUser')){
            File::delete(public_path($profile->image));
            $image = $req->file('imageUser');
            $newName = time(). '.' . $image->getClientOriginalExtension();
            $linkStorage = 'theme/client/assets/images/user';
            $image->move(public_path($linkStorage), $newName);

            $linkImage = $linkStorage.$newName;
        }
        $data = [
            'name'=> $req->name,
            'phone' => $req->phone,
            'email' => $req->email,
            'birthday' => $req->birthday,
            'address' => $req->address
        ];
        User::where('id',$idUser)->update($data);
        return redirect()->route('listProfile');



    }


}
