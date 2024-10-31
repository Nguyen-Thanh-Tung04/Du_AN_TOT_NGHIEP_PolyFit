<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
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
        ],[
            'name.required'=> 'Không được để trống tên ',
            'email.required'=>'Không được để trống email',
            'email.email'=>'Email không đúng định dạng',
            'phone.required'=>'Số điện thoại không được để trống',
            'phone.digits:10'=>'Số điện thoại không đúng',
            'birthday.required'=>'Không được để trống ngày sinh',
            'birthday.date'=>'Ngày sinh không đúng',
            'province_id.required'=>'Không được để trống địa chỉ',
            'district_id.required'=>'Không được để trống địa chỉ',
            'ward_id.required'=>'Không được để trống địa chỉ',
            'address.required'=>'Không được để trống địa chỉ'
        ]);


        if ($validator->fails()) {
            $e= "";
            foreach ($validator->errors()->all() as $error){
                $e .= $error . ' ';
            }
            return redirect()->back()->with('error', 'Cập nhật không thành công! '.$e);

        }
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
    public function updatePassword(Request $request)
    {

         $request->validate([
            'current_password'=>['required'],
            'new_password' => ['required', 'string', 'min:8','confirmed'],
            'new_password_confirmation'=>['required','string','min:8'],
        ],[
            'current_password.require'=>'Không được để trống mật khẩu',
            'new_password.required'=>'Không được để trống mật khẩu',
            'new_password.string'=>'Mật khẩu phải là một chuỗi ký tự',
            'new_password.min:8'=>'Mật khẩu tối thiểu 8 ký tự',
            'new_password.confirmed'=>'Mật khẩu phải trùng khớp',
            'new_password_confirmation.required'=>'Mật khẩu không được để trống',
            'new_password_confirmation.string'=>'Mật khẩu phải là một chuỗi ký tự',
            'new_password_confirmation.min:8'=>'Mật khẩu tối thiểu 8 ký tự',
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
