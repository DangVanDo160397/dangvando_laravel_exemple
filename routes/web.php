<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});
Route::get('admin/login','UserController@getAdminLogin');
Route::post('admin/login','UserController@postAdminLogin');

Route::group(['prefix' => 'admin','middleware' => 'adminLogin'],function() {

	Route::get('admin/danhsach',function() {
		return view('admin/danhsach');
	});
	Route::group(['prefix' => 'theloai'],function() {
		//admin/theloai/danhsach
		Route::get('danhsach','TheloaiController@getDanhSach');

		Route::get('sua/{id}','TheloaiController@getSua');

		Route::post('sua/{id}','TheloaiController@postSua');

		Route::get('them','TheloaiController@getThem');

		Route::post('them','TheloaiController@postThem');

		Route::get('xoa/{id}','TheloaiController@getXoa');
	});
	Route::group(['prefix' => 'loaitin'],function() {
		//admin/theloai/loaitin
		Route::get('danhsach','LoaiTinController@getDanhSach');

		Route::get('sua/{id}','LoaiTinController@getSua');
		Route::post('sua/{id}','LoaiTinController@postSua');

		Route::get('them','LoaiTinController@getThem');
		Route::post('them','LoaiTinController@postThem');

		Route::get('xoa/{id}','LoaiTinController@getXoa');
	});
	Route::group(['prefix' => 'tintuc'],function() {
		//admin/tintuc
		Route::get('danhsach','TinTucController@getDanhSach');

		Route::get('sua/{id}','TinTucController@getSua');
		Route::post('sua/{id}','TinTucController@postSua');

		Route::get('them','TinTucController@getThem');
		Route::post('them','TinTucController@postThem');
		
		Route::get('xoa/{id}','TinTucController@getXoa');
	});

	Route::group(['prefix' => 'comment' ],function() {
		Route::get('xoa/{id}/{idTinTuc}','CommentController@getXoa');
	});

	Route::group(['prefix' => 'slide' ],function() {

		Route::get('danhsach','SlideController@getDanhSach');

		Route::get('them','SlideController@getThem');
		Route::post('them','SlideController@postThem');

		Route::get('sua/{id}','SlideController@getSua');
		Route::post('sua/{id}','SlideController@postSua');
		
		Route::get('xoa/{id}','SlideController@getXoa');
	});

	Route::group(['prefix' => 'user' ],function() {
		Route::get('danhsach','UserController@getDanhSach');

		Route::get('them','UserController@getThem');
		Route::post('them','UserController@postThem');

		Route::get('sua/{id}','UserController@getSua');
		Route::post('sua/{id}','UserController@postSua');
		
		Route::get('xoa/{id}','UserController@getXoa');
	});

	Route::group(['prefix' => 'ajax'],function() {
		Route::get('loaitin/{idTheLoai}','AjaxController@getLoaiTin');
	});
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('trangchu','PagesController@trangchu');
Route::get('lienhe','PagesController@lienhe');
Route::get('gioithieu','PagesController@gioithieu');
Route::get('loaitin/{id}/{TenKhongDau}.html','PagesController@loaitin');
Route::get('tintuc/{id}/{TenKhongDau}.html','PagesController@tintuc');
Route::get('dangnhap','PagesController@getDangnhap');
Route::post('dangnhap','PagesController@postDangnhap');
Route::get('dangxuat','PagesController@getDangXuat');

Route::post('comment/{id}','CommentController@postComment');

Route::get('nguoidung','PagesController@getNguoiDung');
Route::post('nguoidung','PagesController@postNguoiDung');

Route::get('dangky','PagesController@getDangKy');
Route::post('dangky','PagesController@postDangKy');

Route::post('timkiem','PagesController@postTimKiem');


