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

use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsAndEventController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('web.home');
});

Auth::routes([
    'register'=> false,
    'reset'=> false,

]);

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

//---------------SOCIAL LINKER---------------------
Route::get('linker',['middleware' => 'auth','uses'=>'App\Http\Controllers\SocialLinkerController@create'])->name('linker');
Route::get('linker_list',['middleware' => 'auth','uses'=>'App\Http\Controllers\SocialLinkerController@index'])->name('linker_list');
Route::post('add_new_linker','App\Http\Controllers\SocialApp\Http\Controllers\LinkerController@store')->name('add_new_linker');
Route::get('/get_linker_info/{id}','SocialLinkerController@edit');
Route::post('/update_linker_info','App\Http\Controllers\SocialLinkerController@update');
Route::get('/delete_linker/{id}','App\Http\Controllers\SocialLinkerController@destroy');


//----------------- SLIDER ------------------------------
Route::get('slider',['middleware' => 'auth','uses'=>'App\Http\Controllers\SliderController@create'])->name('slider');
Route::get('slider_list',['middleware' => 'auth','uses'=>'App\Http\Controllers\SliderController@index'])->name('slider_list');
Route::post('add_new_slider','App\Http\Controllers\SliderController@store')->name('add_new_slider');
Route::get('/get_slider_info/{id}','App\Http\Controllers\SliderController@edit');
Route::post('/update_slider_info','App\Http\Controllers\SliderController@update');
Route::get('/delete_slider/{id}','App\Http\Controllers\SliderController@destroy');

//------------------CONTACT-------------------------
Route::get('contact',['middleware' => 'auth','uses' =>'App\Http\Controllers\ContactController@create'])->name('contact');
Route::get('contact_list',['middleware' => 'auth','uses'=>'App\Http\Controllers\ContactController@index'])->name('contact_list');
Route::post('add_new_contact','App\Http\Controllers\ContactController@store')->name('add_new_contact');
Route::get('/get_contact_info/{id}','App\Http\Controllers\ContactController@edit');
Route::post('/update_contact_info','App\Http\Controllers\ContactController@update');
Route::get('/delete_contact/{id}','App\Http\Controllers\ContactController@destroy');

Route::get('/delete_contact_page/{id}','App\Http\Controllers\ContactController@destroy_message');
Route::get('/contact_page_list',['middleware' => 'auth','uses'=>'App\Http\Controllers\ContactController@view_message']);

//------------------ADDRESS-------------------------
Route::get('address',['middleware' => 'auth','uses' =>'App\Http\Controllers\AddressController@create']);
Route::get('address_list',['middleware' => 'auth','uses'=>'App\Http\Controllers\AddressController@index']);
Route::post('add_new_address','App\Http\Controllers\AddressController@store');
Route::get('/get_address_info/{id}','App\Http\Controllers\AddressController@edit');
Route::post('/update_address_info','App\Http\Controllers\AddressController@update');
Route::get('/delete_address/{id}','App\Http\Controllers\AddressController@destroy');


//----------------- ABOUT ------------------------------
Route::get('about',['middleware' => 'auth','uses'=>'App\Http\Controllers\AboutController@create'])->name('about');
Route::get('about_list',['middleware' => 'auth','uses'=>'App\Http\Controllers\AboutController@index'])->name('about_list');
Route::post('add_new_about','App\Http\Controllers\AboutController@store')->name('add_new_about');
Route::get('/get_about_info/{id}','App\Http\Controllers\AboutController@edit');
Route::post('/update_about_info','AboutController@update');
Route::get('/delete_about/{id}','App\Http\Controllers\AboutController@destroy');

//----------------- MESSAGE ------------------------------
Route::get('message',['middleware' => 'auth','uses'=>'App\Http\Controllers\CornerMessageController@create'])->name('about');
Route::get('message_list',['middleware' => 'auth','uses'=>'App\Http\Controllers\CornerMessageController@index'])->name('about_list');
Route::post('add_new_message','App\Http\Controllers\CornerMessageController@store')->name('add_new_about');
Route::get('/get_message_info/{id}','App\Http\Controllers\CornerMessageController@edit');
Route::post('/update_message_info','App\Http\Controllers\CornerMessageController@update');
Route::get('/delete_message/{id}','App\Http\Controllers\CornerMessageController@destroy');

//----------------- NOTICE ------------------------------
Route::get('notice',['middleware' => 'auth','uses'=>'App\Http\Controllers\NoticeController@create'])->name('about');
Route::get('notice_list',['middleware' => 'auth','uses'=>'App\Http\Controllers\NoticeController@index'])->name('about_list');
Route::post('add_new_notice','App\Http\Controllers\NoticeController@store')->name('add_new_about');
Route::get('/get_notice_info/{id}','App\Http\Controllers\NoticeController@edit');
Route::post('/update_notice_info','App\Http\Controllers\NoticeController@update');
Route::get('/delete_notice/{id}','App\Http\Controllers\NoticeController@destroy');


//-----------------------Gallery----------------------
Route::get('gallery',['middleware' => 'auth','uses'=>'App\Http\Controllers\GalleryController@create'])->name('gallery');
Route::get('gallery_list',['middleware' => 'auth','uses'=>'App\Http\Controllers\GalleryController@index'])->name('gallery_list');
Route::post('add_new_gallery','App\Http\Controllers\GalleryController@store')->name('add_new_gallery');
Route::get('/get_gallery_info/{id}','App\Http\Controllers\GalleryController@edit');
Route::post('/update_gallery_info','App\Http\Controllers\GalleryController@update');
Route::get('/delete_gallery/{id}','App\Http\Controllers\GalleryController@destroy');

Route::get('delete_selected_image','App\Http\Controllers\GalleryController@delete_selected_image');
Route::post('projects/media', 'App\Http\Controllers\GalleryController@test_crud')->name('projects.storeMedia');

//----------------- FACILITY ------------------------------
Route::get('facility',['middleware' => 'auth','uses'=>'App\Http\Controllers\FacilityController@create']);
Route::get('facility_list',['middleware' => 'auth','uses'=>'App\Http\Controllers\FacilityController@index']);
Route::post('add_new_facility','App\Http\Controllers\FacilityController@store');
Route::get('/get_facility_info/{id}','App\Http\Controllers\FacilityController@edit');
Route::post('/update_facility_info','App\Http\Controllers\FacilityController@update');
Route::get('/delete_facility/{id}','App\Http\Controllers\FacilityController@destroy');


//----------------- ACADEMIC ------------------------------
Route::get('academy',['middleware' => 'auth','uses'=>'App\Http\Controllers\AcademicController@create']);
Route::get('academy_list',['middleware' => 'auth','uses'=>'App\Http\Controllers\AcademicController@index']);
Route::post('add_new_academy','App\Http\Controllers\AcademicController@store');
Route::get('/get_academy_info/{id}','App\Http\Controllers\AcademicController@edit');
Route::post('/update_academy_info','App\Http\Controllers\AcademicController@update');
Route::get('/delete_academy/{id}','App\Http\Controllers\AcademicController@destroy');

//----------------- MEMBER ------------------------------
Route::get('member',['middleware' => 'auth','uses'=>'App\Http\Controllers\MemberController@create']);
Route::get('member_list',['middleware' => 'auth','uses'=>'App\Http\Controllers\MemberController@index']);
Route::post('add_new_member','App\Http\Controllers\MemberController@store');
Route::get('/get_member_info/{id}','App\Http\Controllers\MemberController@edit');
Route::post('/update_member_info','App\Http\Controllers\MemberController@update');
Route::get('/delete_member/{id}','App\Http\Controllers\MemberController@destroy');

//----------------- NEWS AND EVENT ------------------------------
//Route::get('/news_events',['middleware' => 'auth','uses'=>'NewsAndEventController@create'])->name('news_events');
//Route::get('/news_events_list',['middleware' => 'auth','uses'=>'NewsAndEventController@index'])->name('news_events');
Route::post('/add_new_news_events',[NewsAndEventController::class,'store'])->name('news_events');
Route::get('/get_news_events_info/{id}','App\Http\Controllers\NewsAndEventController@edit');
Route::post('/update_news_events_info','App\Http\Controllers\NewsAndEventController@update');
Route::get('/delete_news_events/{id}','App\Http\Controllers\NewsAndEventController@destroy');

Route::middleware('auth')->group(function () {
    Route::get('/news_events',[NewsAndEventController::class,'create'])->name('news_events');
    Route::get('/news_events_list',[NewsAndEventController::class,'index'])->name('news_events');
});

//----------------------------WEB-------------------------------
Route::get('/',[WebController::class,'index']);
Route::get('web_gallery',[WebController::class, 'gallery']);
Route::get('/web_categorized_gallery/{id}',[WebController::class,'web_categorized_gallery']);
Route::get('/web_video',[WebController::class,'youtube_api']);
Route::get('/get_video_data',[WebController::class,'get_video_data']);
Route::get('/web_notice',[WebController::class,'notice']);
Route::get('/web_news_events',[WebController::class,'news_events']);
Route::get('/web_academy/{name}',[WebController::class,'academic']);
Route::get('/web_message/{id}',[WebController::class,'message']);
Route::get('/web_facility/{id}',[WebController::class,'facility']);
Route::get('/web_contact',[WebController::class,'contact_page']);
Route::get('/web_member_info/{name}',[WebController::class,'member_info']);
Route::get('/web_about',[WebController::class,'about']);
Route::get('/get_footer_address',[WebController::class,'get_footer_address']);
Route::get('/get_footer_contact',[WebController::class,'get_footer_contact']);
Route::get('/get_footer_social_linker',[WebController::class,'get_footer_social_linker']);
Route::get('/get_header_messages_list',[WebController::class,'get_header_messages_list']);
Route::get('/web_message_us',[ContactController::class,'save_message']);


