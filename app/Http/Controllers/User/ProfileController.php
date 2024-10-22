<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ProfileController extends Controller
{


    public function listProfile() {
    $profile = Auth::user(); // Lấy thông tin tài khoản đang đăng nhập
    return view('client.page.profile', compact('profile') );
}

    public function updateProfile($idUser,Request $req){

        $validator = Validator::make($req->all(),[
            'name' => 'required|max:255',
            'email' => 'required|email|',
            'phone' => 'required|digits:10',
            'birthday' =>'required|date',
            'province_id' => 'required|max:255',
            'district_id' => 'required|max:255',
            'ward_id' => 'required|max:255',
            'address' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Cập nhật không thành công');

        }
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
            return redirect()->back()->with('success', 'Cập nhật thành công.');


    }

    public function changePassword(){
        return view('client.page.changepassword');
    }
    public function updatePassword(Request $request)
    {

         $request->validate([

            'new_password' => ['required', 'string', 'min:8','confirmed'],
            'new_password_confirmation'=>['required','string','min8',],

        ]);

       // Kiểm tra xem mật khẩu hiện tại có khớp không
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }
        // Cập nhật mật khẩu
        Auth::user()->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Mật khẩu đã được thay đổi thành công');
    }


}
