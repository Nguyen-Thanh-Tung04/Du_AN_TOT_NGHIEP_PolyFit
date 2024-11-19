<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Repositories\DistrictRepository;
use App\Repositories\ProvinceRepository;
use App\Repositories\WardRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class ProfileController extends Controller
{
    protected $provinceRepository;
    protected $wardRepository;
    protected $districtRepository;
    public function __construct(
         ProvinceRepository $provinceRepository,
         WardRepository $wardRepository,
         DistrictRepository $districtRepository

    ){
        $this->provinceRepository = $provinceRepository;
        $this->wardRepository = $wardRepository;
        $this->districtRepository =$districtRepository;
    }
    public function listProfile() {
        $profile = Auth::user(); // Lấy thông tin tài khoản đang đăng nhập
        $provinces = $this->provinceRepository->all();
        $wards = $this->wardRepository->all();
        $districts = $this->districtRepository->all();
        return view('client.page.profile', compact(['profile','provinces','wards','districts']));
    }

    public function updateProfile($idUser,UpdateProfileRequest $req){
        $profile = User::find( $idUser);
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
    public function updatePassword(UpdatePasswordRequest $request)
    {
       // Kiểm tra xem mật khẩu hiện tại có khớp không
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        };
        // Cập nhật mật khẩu
        Auth::user()->update(['password' => Hash::make($request->new_password)]);
        return back()->with('success', 'Mật khẩu đã được thay đổi thành công');
    }


 }
