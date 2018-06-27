<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\TinTuc;
use Illuminate\Support\Facades\Auth;
class CommentController extends Controller
{
    public function getXoa($id,$idTinTuc) {
    	$commet = Comment::find($id);
    	$commet->delete();

    	return redirect('admin/tintuc/sua/'.$idTinTuc)->with('thongbao','Xóa commet thành công.');
    }

    public function postComment($id,Request $request) {
        
        $comment = new Comment();
        $tintuc = TinTuc::find($id);
        $comment->idTinTuc = $id;
        $comment->idUser = Auth::user()->id;
        $comment->NoiDung = $request->NoiDung;
        $comment->save();

        return redirect("tintuc/$id/".$tintuc->TieuDeKhongDau.".html")->with('thongbao','Thêm bình luận thành công.');
    }
}
