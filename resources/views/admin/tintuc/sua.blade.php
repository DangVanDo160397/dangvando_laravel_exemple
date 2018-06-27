@extends('admin.layout.index')

@section('content')
<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Tin tức
                            <small>{{$tintuc->TieuDe}}</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    @if(count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $er)
                                {{$er}} <br />
                            @endforeach
                        </div>
                    @endif

                    @if(session('thongbao'))
                        <div class="alert alert-success">
                            {{session('thongbao')}}
                        </div>
                    @endif

                    @if(session('loi'))
                        <div class="alert alert-danger">
                            {{session('loi')}}
                        </div>
                    @endif

                    <div class="col-lg-7" style="padding-bottom:120px">
                        <form action="admin/tintuc/sua/{{$tintuc->id}}" enctype="multipart/form-data" method="POST" >
                            <input type="hidden" name="_token" value="{{csrf_token()}}" />
                            <div class="form-group" >
                                <label>Thể loại</label>
                                <select class="form-control" name="TheLoai" id="TheLoai">
                                    @foreach($theloai as $tl)
                                    <option 
                                    @if($tintuc->loaitin->theloai->id == $tl->id)
                                        {{"selected"}}
                                    @endif

                                    value="{{$tl->id}}">{{$tl->Ten}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Loại tin</label>
                                <select class="form-control" name="LoaiTin" id="LoaiTin">
                                    @foreach($loaitin as $lt)
                                    <option
                                    @if($tintuc->loaitin->id == $lt->id)
                                        {{"selected"}}
                                    @endif 
                                     value="{{$lt->id}}">{{$lt->Ten}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tiêu đề</label>
                                <input class="form-control" name="TieuDe" value="{{$tintuc->TieuDe}}" placeholder="Nhập tiêu đề...." />
                            </div>
                            
                            <div class="form-group">
                                <label>Tóm tắt</label>
                                <textarea id="demo" name="TomTat" class="form-control ckeditor" rows="3">
                                    {{$tintuc->TomTat}}
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label>Nội Dung</label>
                                <textarea id="demo" name="NoiDung" class="form-control ckeditor" rows="5">
                                    {{$tintuc->NoiDung}}
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label>Ảnh</label>
                                <p>
                                    <img height="300px"  src="upload/tintuc/{{$tintuc->Hinh}}">
                                </p>
                                
                                <input type="file" name="image" value="{{$tintuc->Hinh}}" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label>Nổi bật</label>
                                <label class="radio-inline">
                                    <input name="NoiBat" value="0"
                                    @if($tintuc->NoiBat == 0) 
                                        {{"checked"}} 
                                    @endif 

                                    type="radio">Không
                                </label>
                                <label class="radio-inline">
                                    <input name="NoiBat" value="1"
                                        @if($tintuc->NoiBat == 1) 
                                            {{"checked"}} 
                                        @endif 
                                     type="radio">Có
                                </label>
                            </div>
                            <button type="submit" value="upload" class="btn btn-default">Sửa</button>
                            <button type="reset" class="btn btn-default">Làm mới</button>
                        </form>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Comment
                            <small>Danh Sách</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>Tên người dùng</th>
                                <th>Nội dung</th>
                                <th>Ngày đăng</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tintuc->comment as $cm)
                            <tr class="odd gradeX" align="center">
                                <td>{{$cm->id}}</td>
                                <td>{{$cm->user->name}}</td>
                                <td>{{$cm->NoiDung}}</td>
                                <td>{{$cm->created_at}}</td>
                                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/comment/xoa/{{$cm->id}}/{{$tintuc->id}}}"> Xóa</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#TheLoai").change(function() {
                var idTheLoai = $(this).val();
                $.get('admin/ajax/loaitin/'+idTheLoai,function(data) {
                    $("#LoaiTin").html(data);
                });
            });
        });
    </script>
@endsection