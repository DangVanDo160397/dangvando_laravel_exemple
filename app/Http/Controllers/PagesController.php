<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Theloai;
use App\Slide;
use App\loaiTin;
use App\TinTuc;
use App\Comment;
use App\User;
use Illuminate\Support\Facades\Auth;
class PagesController extends Controller
{
	function __construct() {

		View::share('theloai', Theloai::all());
		View::share('slide', Slide::all());
        if(Auth::check()) {
            View::share('nguoidung',Auth::user());
        }
	}

    public function trangchu() {
    	return view('pages/trangchu');
    }

    public function lienhe() {
    	return view('pages/lienhe');
    }

    public function gioithieu() {
        return view('pages/gioithieu');
    }

    public function loaitin($id) {
    	$loaitin = LoaiTin::find($id);
    	$tintuc = TinTuc::where('idLoaiTin',$id)->paginate(5);
    	return view('pages/loaitin',['loaitin'=>$loaitin,'tintuc'=>$tintuc]);
    }
    public function tintuc($id) {
        $tintuc = TinTuc::find($id);
        $tinnoibat = TinTuc::where('NoiBat',1)->take(4)->get();
        $tinlienquan = TinTuc::where('idLoaiTin',$id)->take(4)->get();
        return view('pages/tintuc',['tintuc' => $tintuc,'tinnoibat' => $tinnoibat,'tinlienquan' => $tinlienquan]);
    }

    public function getDangnhap() {
        return view('pages.dangnhap');
    }
    public function postDangnhap(Request $request) {
        $this->validate($request,[
            "email" => "required|email",
            "password" => "required|min:3|max:32"
        ],[
            "email.required" => "Bạn chưa nhập email.",
            "email.email" => "Bạn nhập sai định dạng email.",
            "password.required" => "Bạn chưa nhập mật khẩu.",
            "password.min" => "Password không được nhập ít hơn 3 ký tự.",
            "password.max" => "Mật khẩu không được nhập tối đa 32 ký tự."
        ]);

        if(Auth::attempt(['email' => $request->email , 'password' => $request->password])) {
            return redirect('trangchu');
        }
        else {
            return redirect('dangnhap')->with('thongbao','Email hoặc mật khẩu không đúng.');
        }
    }

    public function getDangXuat() {
        Auth::logout();
        return redirect('trangchu');
    }

    public function getNguoiDung() {
        $user = Auth::user();
        return view('pages.nguoidung',['user' => $user]);
    }
    public function postNguoiDung(Request $request) {
        $this->validate($request,[
            "name" => "required|min:3"
            
        ],[
            "name.required" => "Bạn chưa nhập tên.",
            "name.min" => "Tên không đươc nhập ít hơn 3 ký tự."
            
        ]);

        $user = Auth::user();
        $user->name = $request->name;

        if($request->changePassword == "on") {
            $this->validate($request,[
            "password" => "required|min:3|max:32",
            "passwordAgain" => "required|same:password",
        ],[
            "password.required" => "Bạn chưa nhập mật khẩu.",
            "password.min" => "Password không đươc nhập ít hơn 3 ký tự.",
            "password.max" => "Mật khẩu không được nhập tối đa 32 ký tự.",
            "passwordAgain.required" => "Bạn chưa nhập lại mật khẩu.",
            "passwordAgain.same" => "Nhập lại mật khẩu không đúng."
        ]);
            $request->password = bcrypt($request->password);
        }
        $user->save();
        return redirect('nguoidung')->with('thongbao','Sửa thành công.');
    }

    public function getDangKy() {
        return view('pages.dangky');
    }
    
    public function postDangKy(Request $re) {
        $this->validate($re,[
            "name" => "required|min:3",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:3|max:32",
            "passwordAgain" => "required|same:password",
        ],[
            "name.required" => "Bạn chưa nhập tên.",
            "name.min" => "Tên không đươc nhập ít hơn 3 ký tự.",
            "email.required" => "Bạn chưa nhập email.",
            "email.email" => "Bạn nhập email sai.",
            "email.unique" => "email đã tồn tại",
            "password.required" => "Bạn chưa nhập mật khẩu.",
            "password.min" => "Password không đươc nhập ít hơn 3 ký tự.",
            "password.max" => "Mật khẩu không được nhập tối đa 32 ký tự.",
            "passwordAgain.required" => "Bạn chưa nhập lại mật khẩu.",
            "passwordAgain.same" => "Nhập lại mật khẩu không đúng."
        ]);

        $user = new User();
        $user->name = $re->name;
        $user->email = $re->email;
        $user->password = bcrypt($re->password);
        $user->quyen = 0;

        $user->save();

        return redirect('dangky')->with('thongbao','Đăng ký thành công.');
    }

    public function postTimKiem(Request $request) {
        $tukhoa = $request->tukhoa;

        $tintuc = TinTuc::where('TieuDe','like',"%$tukhoa%")->orWhere('TomTat','like',"%$tukhoa%")->orWhere('NoiDung','like',"%$tukhoa%")->take(30)->paginate(5);

        return view('pages.timkiem',['tintuc' => $tintuc , 'tukhoa' => $tukhoa]); 
    }
}
