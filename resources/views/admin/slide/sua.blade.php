@extends('admin.layout.index')

@section('content')
<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Slide
                            <small>Sửa</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    @if(count($errors) > 0 )    
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $er)
                                {{$er}} <br>
                            @endforeach
                        </div>
                    @endif

                    @if(session('thongbao'))
                        <div class="alert alert-success">
                            {{session('thongbao')}}
                        </div>
                    @endif
                    <div class="col-lg-7" style="padding-bottom:120px">
                        <form action="admin/slide/sua/{{$slide->id}}" method="POST" enctype="multipart/form-data" >
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="form-group">
                                <label>Tên</label>
                                <input class="form-control" name="Ten" value="{{$slide->Ten}}" placeholder="Mời nhập tên.." />
                            </div>
                            <div class="form-group">
                                <label>Nội Dung</label>
                                <textarea id="demo" name="NoiDung" class="form-control ckeditor" rows="5">
                                    {{$slide->NoiDung}}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label>Hình ảnh</label>
                                <p>
                                    <img src="upload/slide/{{$slide->Hinh}}" width="200px">
                                </p>
                                <input type="file" class="form-control" name="Hinh" placeholder="Please Enter Category Keywords" />
                            </div>
                            <div class="form-group">
                                <label>Link</label>
                                <input class="form-control" name="Link" value="{{$slide->link}}" placeholder="Nhập nội dung hình..." />
                            </div>
                            <button type="submit" class="btn btn-default">Sửa</button>
                            <button type="reset" class="btn btn-default">Làm mới</button>
                        </form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
@endsection