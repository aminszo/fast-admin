<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('dashboard');
});

// [amin] a test route for temporary tests.
Route::get('/test', [Controllers\testController::class, 'one'])->name("test");

// [amin] all main routes of project are here, and all of them need authentication.
Route::middleware('auth')->middleware('can:do-all')->group(function () {

    // [amin] Temporary route for managing user roles
    Route::get('/role', [Controller\RolesManagerController::class, 'index']);

    Route::get('/dashboard', [Controllers\adminController::class, 'showDashboard'])
        ->name('dashboard');

    Route::get('/products', [Controllers\adminController::class, 'showProducts'])
        ->name('products');

    Route::get('/products/update', [Controllers\productUpdate::class, 'update'])
        ->name('update-product');

    Route::get('/products/bulk', [Controllers\bulkUpdate::class, 'show'])
        ->name('bulk-product-edit');

    Route::post('/products/bulk/update', [Controllers\bulkUpdate::class, 'update'])
        ->name('bulk-product-update');

    Route::get('/products/bulk/update', function () {
        return redirect()->route('bulk-product-edit');
    });

    Route::post('/products/bulk/cache', [Controllers\bulkUpdate::class, 'delete_cache'])
        ->name('bulk-product-delete-cache');

    Route::get('/festival', [Controllers\festival::class, 'show'])
        ->name('festival');

    Route::post('/festival/create', [Controllers\festival::class, 'create'])
        ->name('create-price-backup');

    Route::post('/festival/apply', [Controllers\festival::class, 'apply'])
        ->name('apply-backup');


      
    Route::get('/sms', [Controllers\SMS\smsController::class, 'show_sms_page'])
        ->name('sms');

    Route::get('/sms/pattern', [Controllers\SMS\smsController::class, 'show_pattern_sms_page'])
        ->name('sms-pattern');

    Route::get('/sms/send', function () {
        return redirect()->route('sms');
    });

    Route::post('/sms/send/pattern', [Controllers\SMS\smsController::class, 'send_pattern_sms'])
        ->name('send-pattern-sms');
    Route::get('/sms/send/pattern', function () {
        return redirect()->route('sms');
    });

    Route::get('/cache/clear', function () {
        delete_cache_api([], true);
    });
});

// these routes are accessible only if the user is authenticated (logged in)
Route::middleware('auth')->group(function () {

    Route::get('/sms/book', [Controllers\SMS\smsController::class, 'show_sms_book'])
        ->name('sms-book');
    Route::post('/sms/send', [Controllers\SMS\smsController::class, 'send_sms'])
        ->name('send-single-sms');
    Route::get('/sms/status', [Controllers\SMS\smsController::class, 'show_deliver_status'])
        ->name('show-sms-status');
});

// [amin] all authentication routes are imported here
require __DIR__ . '/auth.php';
