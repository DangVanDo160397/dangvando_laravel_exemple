<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TheLoai;

class LoaiTinController extends Controller
{
    public function getDanhSach() {
    	$loaitin = LoaiTin::all();

    	return view('admin/loaitin/danhsach',['loaitin' => $loaitin]);
    }

    public function getThem() {
    	$theloai = TheLoai::all();
    	return view('admin/loaitin/them',['theloai' => $theloai]);
    }

    public function postThem(Request $request) {
        $this->validate($request,[
            'Ten' => 'required|unique:LoaiTin,Ten|min:1|max:100',
            'TheLoai' => 'required'

        ],[ 
            'Ten.required' => 'Bạn cần nhập thông tin.',
            'Ten.unique' => 'Tên loại tin đã tồn tại',
            'Ten.min' => 'Đồ dài từ 1 đến 100',
            'Ten.max' => 'Đồ dài từ 1 đến 100',
            'TheLoai.required' => 'Bạn cần nhập thông tin.'
        ]);
        $loaitin = new LoaiTin();
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->Ten = $request->Ten;
        $loaitin->TenKhongDau = changeTitle($request->Ten);

        $loaitin->save();

        return redirect('admin/loaitin/them')->with('thongbao','Thêm thành công.');
    }
    public function getXoa($id) {
    	$loaitin = LoaiTin::find($id);

    	$loaitin->delete();

    	return redirect('admin/loaitin/danhsach')->with('thongbao','Xóa thành công.');
    }

    public function getSua($id) {
         $loaitin = LoaiTin::find($id);
        $theloai = TheLoai::all();
       

        return view('admin/loaitin/sua',['theloai' => $theloai, 'loaitin' => $loaitin]);
    }

    public function postSua(Request $request,$id) {
        $this->validate($request,[
            'Ten' => 'required|unique:LoaiTin,Ten|min:1|max:100',
            'TheLoai' => 'required'

        ],[ 
            'Ten.required' => 'Bạn cần nhập thông tin.',
            'Ten.unique' => 'Tên loại tin đã tồn tại',
            'Ten.min' => 'Đồ dài từ 1 đến 100',
            'Ten.max' => 'Đồ dài từ 1 đến 100',
            'TheLoai.required' => 'Bạn cần nhập thông tin.'
        ]);
        $loaitin = LoaiTin::find($id);
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->Ten = $request->Ten;
        $loaitin->TenKhongDau = changeTitle($request->Ten) ;
        $loaitin->save();

        return redirect('admin/loaitin/sua/'.$id)->with('thongbao','Sửa thành công.');
    }
}
