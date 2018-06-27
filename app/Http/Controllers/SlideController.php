<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slide;
class SlideController extends Controller
{
    public function getDanhSach() {
    	$slide = Slide::all();

    	return view('admin/slide/danhsach',['slide' => $slide]);
    }

    public function getThem() {
    	return view('admin/slide/them');
    }

    public function postThem(Request $re) {

    	$this->validate($re,[
    		"Ten" => "required",
    		"NoiDung" => "required"
    	],[
    		"Ten.required" => "Bạn chưa nhập tên ảnh.",
    		"NoiDung.required" => "Bạn chưa nhập nội dung."
    	]);

    	$slide = new Slide();
    	$slide->Ten = $re->Ten;
    	$slide->NoiDung = $re->NoiDung;
    	if($re->has('Link')) {
    		$slide->link = $re->Link;
    	}
    	if($re->hasFile('Hinh')) {
    		$file = $re->file('Hinh');
    		$name = $file->getClientOriginalName();
    		$Hinh = str_random(4)."_".$name;

    		while (file_exists("upload/slide/".$Hinh)) {
    			$Hinh = str_random(4)."_".$name;
    		}

    		$file->move("upload/slide",$Hinh);

    		$slide->Hinh =$Hinh;
     	}
     	else {
     		$slide->Hinh = "";
     	}
     	$slide->save();

     	return redirect('admin/slide/them')->with('thongbao','Thêm thành công.');

    }
    public function getXoa($id) {
    	$slide = Slide::find($id);
    	$slide->delete();

    	return redirect('admin/slide/danhsach')->with('thongbao','Xóa thành công.');
    }

    public function getSua($id) {
    	$slide = Slide::find($id);
    	return view('admin/slide/sua',["slide" => $slide]);
    }

    public function postSua(Request $re,$id) {
    	$this->validate($re,[
    		"Ten" => "required",
    		"NoiDung" => "required"
    	],[
    		"Ten.required" => "Bạn chưa nhập tên ảnh.",
    		"NoiDung.required" => "Bạn chưa nhập nội dung."
    	]);

    	$slide = Slide::find($id);

    	$slide->Ten = $re->Ten;
    	$slide->NoiDung = $re->NoiDung;
    	if($re->has('Link')) {
    		$slide->link = $re->Link;
    	}
    	if($re->hasFile('Hinh')) {
    		$file = $re->file('Hinh');
    		$name = $file->getClientOriginalName();
    		$Hinh = str_random(4)."_".$name;

    		while (file_exists("upload/slide/".$Hinh)) {
    			$Hinh = str_random(4)."_".$name;
    		}
            unlink("upload/slide/".$slide->Hinh);
    		$file->move("upload/slide",$Hinh);

    		$slide->Hinh =$Hinh;
     	}
     	else {
     		$slide->Hinh = "";
     	}
     	$slide->save();
     	return redirect('admin/slide/sua/'.$id)->with('thongbao','Sửa thành công.');
    }
}
