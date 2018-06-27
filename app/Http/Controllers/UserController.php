<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
class UserController extends Controller
{
    public function getDanhSach() {
    	$user = User::all();

    	return view('admin/user/danhsach',['user' => $user]);
    }

    public function getThem() {
    	return view('admin/user/them');
    }

    public function postThem(Request $re) {
    	$this->validate($re,[
    		"name" => "required|min:3",
            //required: không trống
            //min: tối thiểu 3
    		"email" => "required|email|unique:users,email",
            //email: sai dạng email
            //unique: không trùng
    		"password" => "required|min:3|max:32",
    		"passwordAgain" => "required|same:password",
            //same: phải giống pass trên
    	],[
    		"name.required" => "Bạn chưa nhập tên.",
    		"name.min" => "Tên không được nhập ít hơn 3 ký tự.",
    		"email.required" => "Bạn chưa nhập email.",
    		"email.email" => "Bạn nhập email sai.",
    		"email.unique" => "email đã tồn tại",
    		"password.required" => "Bạn chưa nhập mật khẩu.",
    		"password.min" => "Password không được nhập ít hơn 3 ký tự.",
    		"password.max" => "Mật khẩu không được nhập tối đa 32 ký tự.",
    		"passwordAgain.required" => "Bạn chưa nhập lại mật khẩu.",
    		"passwordAgain.same" => "Nhập lại mật khẩu không đúng."
    	]);

    	$user = new User();
    	$user->name = $re->name;
    	$user->email = $re->email;
    	$user->password = bcrypt($re->password);
    	$user->quyen = $re->quyen;

    	$user->save();

    	return redirect('admin/user/them')->with('thongbao','Thêm thành công.');

    }

    public function getSua($id) {
    	$user = User::find($id);
    	return view('admin/user/sua',["user" => $user]);
    }

    public function postSua(Request $request,$id) {
    	$this->validate($request,[
    		"name" => "required|min:3"
    		
    	],[
    		"name.required" => "Bạn chưa nhập tên.",
    		"name.min" => "Tên không được nhập ít hơn 3 ký tự."
    		
    	]);

    	$user = User::find($id);
    	$user->name = $request->name;
    	$user->quyen = $request->quyen;

    	if($request->changePassword == "on") {
    		$this->validate($request,[
    		"password" => "required|min:3|max:32",
    		"passwordAgain" => "required|same:password",
    	],[
    		"password.required" => "Bạn chưa nhập mật khẩu.",
    		"password.min" => "Password không được nhập ít hơn 3 ký tự.",
    		"password.max" => "Mật khẩu không được nhập tối đa 32 ký tự.",
    		"passwordAgain.required" => "Bạn chưa nhập lại mật khẩu.",
    		"passwordAgain.same" => "Nhập lại mật khẩu không đúng."
    	]);
    		$request->password = bcrypt($request->password);
    	}
    	$user->save();
    	return redirect('admin/user/sua/'.$id)->with('thongbao','Sửa thành công.');
    }

    public function getXoa($id) {
    	$user = User::find($id);
    	$user->delete();
    	return redirect('admin/user/danhsach')->with('thongbao','Xóa thành công.');
    }
    public function getAdminLogin() {
        return view('admin/login');
    }

    public function postAdminLogin(Request $request) {
        $this->validate($request,[
            "email" => "required|email",
            "password" => "required|min:3|max:32",
        ],[
            "email.required" => "Bạn chưa nhập tên.",
            "email.email" => "Bạn nhập sai định dạng email.",
            "password.required" => "Bạn chưa nhập mật khẩu.",
            "password.min" => "Password không được nhập ít hơn 3 ký tự.",
            "password.max" => "Mật khẩu không được nhập tối đa 32 ký tự."
        ]);

        if(Auth::attempt(['email' => $request->email , 'password' => $request->password])) {
            return redirect('admin/theloai/danhsach')->with('thongbao','Đăng nhập thành công.');
        }
        else {
            return redirect('admin/login')->with('thongbao','Đăng nhập không thành công.');
        }
    }
 }
