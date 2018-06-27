<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TinTuc;
use App\LoaiTin;
use App\TheLoai;

class TinTucController extends Controller
{
    public function getDanhSach() {
    	$tintuc = TinTuc::orderBy('id','Asc')->paginate(10);

    	return view('admin/tintuc/danhsach',['tintuc' => $tintuc]);
    }

    public function getThem() {
    	$theloai = TheLoai::all();
    	$loaitin = LoaiTin::all();
    	return view('admin/tintuc/them',['theloai'=>$theloai,'loaitin'=>$loaitin]);
    }
    public function postThem(Request $request) {


    	$this->validate($request,[
            "LoaiTin" => "required",
            "TieuDe" => "required||min:3 | unique:TinTuc,TieuDe",
            "TomTat" => "required",
            "NoiDung" => "required"
        ],[
            "LoaiTin.required" => "Bạn chưa nhập loại tin.",
            "TieuDe.required" => "Bạn chưa nhập tiêu đề.",
            "TieuDe.min" => "Độ dài phải có 3 ký tự.",
            "TieuDe.unique" => "Tiêu đề đã tồn tại.",
            "TomTat.required" => "Bạn chưa nhập tóm tắt.",
            "NoiDung.required" => "Bạn chưa nhập nội dung"
        ]);
    	$tintuc = new TinTuc();
    	$tintuc->TieuDe = $request->TieuDe;
    	$tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
    	$tintuc->TomTat = $request->TomTat;
    	$tintuc->NoiDung = $request->NoiDung;
    	$tintuc->idLoaiTin = $request->LoaiTin;
    	$tintuc->SoLuotXem = 0;
        if($request->hasFile("image"))
        {
            $file = $request->file('image');

            $duoi = $file->getClientOriginalExtension();

            if($duoi != 'jpg' && $duoi != 'png' && $duoi != "jpeg" )
            {
                return redirect("admin/tintuc/them")->with('loi','Bạn chỉ được nhập file ảnh có đuôi png,jpg,jpeg');
            } 
            $name = $file->getClientOriginalName();
            $Hinh = str_random(4)."_". $name;
            while (file_exists("upload/tintuc".$Hinh)) {
                $Hinh = str_random(4)."_". $name;
            }
            $file->move("upload/tintuc",$Hinh);

            $tintuc->Hinh = $Hinh;

        }
        else {
            $tintuc->Hinh = "";
        }
    	
    	$tintuc->save();	
    	return redirect('admin/tintuc/them')->with('thongbao',"Bạn đã thêm thành công.");
    }

    public function getSua($id) {
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        $tintuc = TinTuc::find($id);

        return view('admin/tintuc/sua',["theloai" => $theloai , "loaitin" => $loaitin , "tintuc" => $tintuc]);
    }
    public function postSua(Request $request,$id) {
        $this->validate($request,[
            "LoaiTin" => "required",
            "TieuDe" => "required||min:3 | unique:TinTuc,TieuDe",
            "TomTat" => "required",
            "NoiDung" => "required"
        ],[
            "LoaiTin.required" => "Bạn chưa nhập loại tin.",
            "TieuDe.required" => "Bạn chưa nhập tiêu đề.",
            "TieuDe.min" => "Độ dài phải có 3 ký tự.",
            "TieuDe.unique" => "Tiêu đề đã tồn tại.",
            "TomTat.required" => "Bạn chưa nhập tóm tắt.",
            "NoiDung.required" => "Bạn chưa nhập nội dung"
        ]);

        $tintuc = TinTuc::find($id);
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->SoLuotXem = 0;
        if($request->hasFile("image"))
        {
            $file = $request->file('image');

            $duoi = $file->getClientOriginalExtension();

            if($duoi != 'jpg' && $duoi != 'png' && $duoi != "jpeg" )
            {
                return redirect("admin/tintuc/them")->with('loi','Bạn chỉ được nhập file ảnh có đuôi png,jpg,jpeg');
            } 
            $name = $file->getClientOriginalName();
            $Hinh = str_random(4)."_". $name;
            while (file_exists("upload/tintuc".$Hinh)) {
                $Hinh = str_random(4)."_". $name;
            }
            $file->move("upload/tintuc",$Hinh);
            unlink("upload/tintuc/".$tintuc->Hinh);
            $tintuc->Hinh = $Hinh;

        }
      
        $tintuc->save();  
        return redirect('admin/tintuc/sua/'.$id)->with('thongbao',"Sửa thành công.");  
    }
    public function getXoa($id) {
        $tintuc = TinTuc::find($id);
        $tintuc->delete();
        return redirect('admin/tintuc/danhsach')->with('thongbao',"Xóa thành công.");
    }
}
