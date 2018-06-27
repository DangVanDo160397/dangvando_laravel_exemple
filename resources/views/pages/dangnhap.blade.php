@extends('layouts.index')

@section('content')
	<!-- Page Content -->
                 @if(count($errors) > 0 )    
                        <div class="alert alert-danger" id="tb">
                            @foreach($errors->all() as $er)
                                {{$er}}
                            @endforeach
                        </div>
                    @endif
    <div class="container">

        <!-- slider -->
        <div class="row carousel-holder">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Đăng nhập</div>
                    @if(session('thongbao'))    
                        <div id="tb" class="alert alert-danger" >
                            {{session('thongbao')}}
                        </div>
                    @endif
                    <div class="panel-body">
                        <form action="dangnhap" method="POST" />
                            <input type="hidden" name="_token" value="{{csrf_token()}}" />
                            <div>
                                <label>Email</label>
                                <input id="user" type="text" class="form-control" placeholder="Email" name="email" 
                                >
                            </div>
                            <br>    
                            <div>
                                <label>Mật khẩu</label>
                                <input id="pass" type="password" class="form-control" name="password">
                            </div>
                            <br>
                            <button id="btndn" type="submit" class="btn btn-default">Đăng nhập
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
        <!-- end slide -->
    </div>
    <!-- end Page Content -->

@endsection