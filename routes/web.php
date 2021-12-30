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
    return view('index');
});

Route::get('/index', 'Index\IndexController@index');
Route::get('apply/index', 'Apply\ApplyController@index');
Route::get('apply/memento', 'Apply\ApplyController@memento');
Route::get('apply/zuhe', 'Apply\ApplyController@zuhe');
Route::get('apply/iterator', 'Apply\ApplyController@iterator');
Route::get('apply/danli', 'Apply\ApplyController@danli');
Route::get('apply/index5', 'Apply\ApplyController@index');
Route::get('apply/index6', 'Apply\ApplyController@index');
Route::get('/add', 'Index\IndexController@add');
Route::get('/danmu', function() {
    return view('danmu');
});

Route::get('/task/test', function () {
    $task = new \App\Jobs\TestTask('测试异步任务');
    $success = \Hhxsv5\LaravelS\Swoole\Task\Task::deliver($task);  // 异步投递任务，触发调用任务类的 handle 方法
    var_dump($success);
});

Route::get('/socket.io', 'SocketIOController@upgrade');
Route::post('/socket.io', 'SocketIOController@ok');

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
