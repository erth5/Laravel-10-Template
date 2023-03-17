<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Debug\UserController;
use App\Http\Controllers\Debug\DebugController;
use App\Http\Controllers\Debug\ImageController;
use App\Http\Controllers\Helper\LangController;
use App\Http\Controllers\Debug\PersonController;
use App\Http\Controllers\Helper\PermissionAndRoleController;

/*
|--------------------------------------------------------------------------
| Web Routes Debug
|--------------------------------------------------------------------------
|
| This routes file register some routes, which help you analyse
| your Laravel Environement. By disabling DEBUG Mode in env file,
| this routes will be deactivated
|
| possible issues:
| routes at top overrides Routes at buttom in this file
| ressource has exact predefined and indirect routes
|
*/

Route::get('hello world', function () {
    echo 'hello World';
});

// unconventional, because no redirect
$debugRoutes = array('example', 'test', 'debug', 'info', 'help');
foreach ($debugRoutes as $route) {
    Route::redirect($route . '/debug', '/debug', 301);  //generates 'any'
    Route::get($route . '/{name?}', [DebugController::class, 'index'])->name('debug');
}

Route::controller(PermissionAndRoleController::class)->group(function () {
    Route::match(array('GET', 'POST'), '/permission/role', 'role')->name('editRolePermissions');
    Route::match(array('GET', 'POST'), '/permission/user', 'user')->name('editUserPermissions');
});

Route::controller(PersonController::class)->group(function () {
    Route::get('/person/test', 'test');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/user/test', [UserController::class, 'test']);
});

Route::controller(ImageController::class)->group(function () {
    Route::get('/images', 'index')->name('image');
    Route::post('/images/store', 'store')->name('store image');
    Route::get('/images/create', 'create')->name('create image');
    Route::get('/images/{image}/show')->name('show image');
    Route::put('/images/{image}/update', 'update')->name('update image');
    Route::delete('/images/{image}/destroy', 'destroy')->name('destroy image');
    Route::post('/images/{image}/rename', 'rename')->name('rename image');

    Route::get('/images/{image}/restore', 'restore')->name('restore image');
    Route::get('/images/clear', 'clear')->name('clear images');
    Route::post('/images/debug', 'debug')->name('debug image');
});

Route::controller(LangController::class)->group(function () {
    Route::get('/lang/home', 'index');
    Route::get('/lang/lang_debug', 'debug');
    Route::get('/lang/change', 'change')->name('langChange');
});

// Route::get('{alias}', 'HomeController@someAction')
//     ->where('alias', 'alias1|alias1.html|alias1.php|alias4');
// public function someAction($alias)
// {
//     ...
// }

// Route::match(array('GET', 'POST'), '/', function()
// {
//     return 'Hello World';
// });

/* OnePager */
// Route::get('/', function () {
//     return redirect('/');
// });
