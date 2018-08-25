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

Route::get('/', 'HomeController@index')->name('home');
Route::get('verifyemailfirst', 'Auth\RegisterController@verifyEmailFirst')->name('verifyemailfirst');
Route::get('verify/{email}/{verifyEmailToken}', 'Auth\RegisterController@emailSent')->name('sendVerifyEmail');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/userlogout', 'Auth\LoginController@logout')->name('userlogout');

Route::prefix('admin')->group(function () {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/add-bus', 'Admin\BusController@index')->name('admin.add-bus');
    Route::post('/add-bus-detail', 'BusController@save_bus_data')->name('save-bus-data');
});


Route::get('/route', 'RouteController@index')->name('route');
Route::post('/route', 'RouteController@addRoute')->name('route.add');
Route::post('/routeupdate','RouteController@update')->name('route.update');

Route::get('/add-schedule', 'ScheduleController@index')->name('add-schedule');
Route::post('/add-schedule', 'ScheduleController@addSchedule')->name('schedule.add');
Route::post('/view-schedule', 'ScheduleController@viewSchedule')->name('schedule.view');
Route::post('/deleteschedule', 'ScheduleController@deleteSchedule')->name('schedule.delete');
Route::post('/updateschedule', 'ScheduleController@updateSchedule')->name('schedule.update');


Route::get('/adminseat', 'AdminSeatController@index')->name('adminseat');
Route::post('/adminseatlayout','AdminSeatController@addSeatLayout')->name('add.bus.seat.layout');
Route::get('/seat/{value}', 'ClientSeatController@index')->name('client.seat');
Route::get('/fetchseat', 'ClientSeatController@fetch')->name('client.seat.book');

Route::post('/search', 'SearchController@searchBus')->name('search.bus');
Route::get('/search', function () {
    return redirect('/');
});
Route::post('/extendedsearch')->name('extendedSearch');

Route::post('/booking', function () {
    return view('client-seat-view.booking');
})->name('booking');

Route::post('/payment', function () {
    return view('client-seat-view.payment');
})->name('payment');


Route::group(['middleware' => ['auth:admin']], function () {
    Route::resource('addbus', 'BusController');
    Route::POST('addbus', 'BusController@addBus');
    Route::POST('editBus', 'BusController@editBus');
    Route::POST('deleteBus', 'BusController@deleteBus');
});



