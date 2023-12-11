<?php

use App\Models\RoomReservation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RescheduleController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\dashboard\RoomController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\dashboard\ReportController;
use App\Http\Controllers\authentications\ForgotPassword;
use App\Http\Controllers\dashboard\DepartmentController;
use App\Http\Controllers\dashboard\YearsController;
use App\Http\Controllers\dashboard\SessionController;
use App\Http\Controllers\dashboard\ReservationController;
use App\Http\Controllers\authentications\SocialiteController;
use App\Http\Controllers\dashboard\BuildingViewController;
use App\Http\Controllers\dashboard\BuildingViewConditionalController;
use App\Http\Controllers\dashboard\BuildingController;
use App\Http\Controllers\dashboard\RoomReservationController;
use App\Http\Controllers\dashboard\RoomReservationConditionalController;
use App\Http\Controllers\dashboard\ReservationConditionalController;

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

$controller_path = 'App\Http\Controllers';

// Auth
Route::get('/', $controller_path . '\authentications\Login@index')->name('login')->middleware('guest');
Route::post('/', $controller_path . '\authentications\Login@auth')->name('login')->middleware('guest');
Route::get('/register', $controller_path . '\authentications\Register@index')->name('register')->middleware('guest');
Route::post('/register', $controller_path . '\authentications\Register@registration')->name('register')->middleware('guest');
Route::get('/logout', $controller_path . '\authentications\Logout@index')->name('logout')->middleware('auth');
Route::get('/forgot-password', $controller_path . '\authentications\ForgotPassword@index')->name('forgot-password')->middleware('guest');
Route::post('/forgot-password', $controller_path . '\authentications\ForgotPassword@action')->name('forgot-password')->middleware('guest');

//socialite
Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider']);
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback']);


Route::get('/reset-password/{token}', [ForgotPassword::class, 'reset_password'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [ForgotPassword::class, 'reset_password_action'])->middleware('guest')->name('password.update');

// Main Page
Route::get('/dashboard', $controller_path . '\dashboard\Dashboard@index')->name('dashboard')->middleware('auth');

// Data master
Route::resource('rooms', RoomController::class)->middleware(['auth', 'role:admin,head_baak,head_bm,staff_bm,staff_baak'])->except('show');
Route::get('rooms/{id}', [RoomController::class, 'show'])->middleware(['auth', 'role:admin,head_baak,head_bm,user,staff_bm,staff_baak,lecturer'])->name('rooms.show');
Route::get('/add-slider/{id}', [RoomController::class, 'add_slider'])->name('add-slider')->middleware(['auth', 'role:admin,head_baak,head_bm,staff_bm,staff_baak']);
Route::post('/upload-slider/{id}', [RoomController::class, 'upload_slider'])->middleware(['auth', 'role:admin,head_baak,head_bm,staff_bm,staff_baak']);
Route::delete('/delete-slider/{id}', [RoomController::class, 'delete_slider'])->middleware(['auth', 'role:admin,head_baak,head_bm,staff_bm,staff_baak']);
Route::resource('departments', DepartmentController::class)->middleware(['auth', 'role:admin']);
Route::resource('years', YearsController::class)->middleware(['auth', 'role:admin']);
Route::resource('sessions', SessionController::class)->middleware(['auth', 'role:admin']);
Route::resource('users', UserController::class)->middleware(['auth', 'role:admin']);
Route::resource('building', BuildingController::class)->middleware(['auth', 'role:admin,head_baak,head_bm,staff_bm,staff_baak'])->except('show');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware(['auth', 'role:admin']);
Route::get('/profile/{slug}', [UserController::class, 'profile'])->name('profile')->middleware('auth');

// report
Route::get('/report', [ReportController::class, 'index'])->name('report')->middleware(['auth', 'role:admin,head_baak,head_bm,staff_bm,staff_baak']);;
Route::get('/export', [ReportController::class, 'export'])->middleware(['auth', 'role:admin,head_baak,head_bm,staff_bm,staff_baak']);;
Route::get('/export_view', [RoomReservationController::class, 'export_view'])->middleware(['auth', 'role:admin,head_baak,head_bm,staff_bm,staff_baak']);;

// aksi peminjama
Route::get('/approve/{id}', [ReservationController::class, 'approve'])->name('approve')->middleware(['auth', 'role:admin,head_baak,head_bm,staff_bm,staff_baak']);
Route::post('/not_approve', [ReservationController::class, 'not_approve'])->name('not_approve')->middleware(['auth', 'role:admin,head_baak,head_bm,staff_bm,staff_baak']);
Route::get('/returned/{id}', [ReservationController::class, 'returned'])->name('returned')->middleware(['auth', 'role:admin,head_baak,head_bm,staff_bm,staff_baak']);
Route::get('/return/{id}/{room_id}', [ReservationController::class, 'return'])->name('return')->middleware('auth');
Route::get('/cancel/{id}/{room_id}', [ReservationController::class, 'cancel'])->name('cancel')->middleware('auth');
Route::post('/complete_personal_data/{id}', [RoomReservationController::class, 'complete_personal_data'])->middleware('auth');
Route::get('/open/{id}', [ReservationController::class, 'open'])->name('open')->middleware(['auth', 'role:admin,head_baak,head_bm,staff_bm,staff_baak,pengelola_gedung']);
Route::get('/offday/{id}', [ReservationController::class, 'offday'])->name('offday')->middleware(['auth', 'role:admin,head_baak,head_bm,staff_bm,staff_baak,pengelola_gedung']);

// peminjaman
Route::resource('building_view', BuildingViewController::class)->middleware('auth');
Route::resource('building_view_con', BuildingViewConditionalController::class)->middleware('auth');
// Route::resource('building_view', BuildingViewController::class)->middleware(['auth', 'role:admin,head_baak,head_bm,staff_bm,staff_baak']);
Route::resource('room_reservation', RoomReservationController::class)->middleware('auth');
Route::get('/all-ruangan/{id}/{floor?}',[RoomReservationController::class,'allruangan'])->middleware('auth')->name('all-ruangan');
Route::get('/reservation/{id?}', [ReservationController::class, 'index'])->name('reservation')->middleware(['auth', 'role:admin,head_baak,head_bm,staff_bm,staff_baak,pengelola_gedung']);
Route::get('/my_reservation', [ReservationController::class, 'my_reservation'])->name('my_reservation')->middleware('auth');
Route::get('/history', [ReservationController::class, 'history'])->name('history')->middleware('auth');
Route::get('/reschedule/{id}', [ReservationController::class, 'show'])->middleware('auth')->name('reschedule');
Route::get('/update_sks/{id}', [ReservationController::class, 'change_sks'])->middleware('auth')->name('change-sks');
Route::post('/update_sks/{id}', [ReservationController::class, 'update_sks'])->middleware('auth')->name('update-sks');
Route::post('/reschedule/{id}', [ReservationController::class, 'update'])->middleware('auth')->name('reschedule-jadwal');
Route::post('/get', [RoomReservationController::class, 'get'])->middleware('auth')->name('get');
Route::get('/detail/{date}/{start_time}', [ReservationController::class, 'detail'])->name('detail')->middleware('auth');

// setting
Route::get('/settings', [UserController::class, 'settings'])->name('settings')->middleware('auth');
Route::put('/settings/{id}', [UserController::class, 'settings_action'])->name('settings.update')->middleware('auth');
Route::get('/delete_signature', [UserController::class, 'delete_signature'])->middleware('auth');

// tahunajaran
Route::get('/set/{id}', [YearsController::class, 'set'])->middleware('auth')->name('set-tahun-ajaran');

//building
// building
Route::get('/set2/{id}', [BuildingController::class, 'set'])->middleware('auth')->name('building-name');
// conditional
Route::resource('room_reservation_conditional', RoomReservationConditionalController::class)->middleware('auth');
Route::post('/get_conditional', [RoomReservationConditionalController::class, 'get'])->middleware('auth')->name('get');
Route::get('/all-ruangan-con/{id}/{floor?}',[RoomReservationConditionalController::class,'allruangan'])->middleware('auth')->name('all-ruangan-con');

// peminjaman kondisoinal
Route::get('/reservation_conditional/{id?}', [ReservationConditionalController::class, 'index'])->name('reservation_conditional')->middleware(['auth', 'role:admin,head_baak,head_bm,staff_bm,staff_baak,pengelola_gedung']);
Route::get('/approve_conditional/{id}', [ReservationConditionalController::class, 'approve_conditional'])->name('approve_conditonal')->middleware(['auth', 'role:admin,head_baak,head_bm,staff_bm,staff_baak']);

// open calendar
Route::resource('jadwal', CalendarController::class);
Route::get('/get_room/{id}/{floor?}', [CalendarController::class,'room'])->name('get_room');
Route::get('/get_jadwal/{id}/{id_building}', [CalendarController::class,'calendar'])->name('get_jadwal');
Route::post('/get_lantai', [CalendarController::class, 'get'])->middleware('auth')->name('get_lantai');
Route::post('/get-ruangan', [CalendarController::class, 'cariroom']);

