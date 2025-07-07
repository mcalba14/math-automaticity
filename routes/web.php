<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('filament.student.auth.login');
});
// Route::get('/login', function () {
//     return redirect()->route('filament.student.auth.login');
// });
Route::get('/admin', function () {
    return redirect(route('filament.admin.auth.login'));
})->name('login');

// Route::get('/admin/login', function () {
//     return redirect()->route('filament.admin.auth.login')->name('login');
// });
// Route::post('/admin/logout', function () {
//     return redirect()->route('filament.admin.auth.logout');
// });
