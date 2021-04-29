<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Checkin\CheckinController;
use App\Http\Controllers\API\Checkin\CheckinResourceController;
use App\Http\Controllers\API\Common\CommonController;
use App\Http\Controllers\API\Department\DepartmentResourceController;
use App\Http\Controllers\API\Manager\ManagerController;
use App\Http\Controllers\API\Request\RequestController;
use App\Http\Controllers\API\Request\RequestResourceController;
use App\Http\Controllers\API\Storage\StorageController;
use App\Http\Controllers\API\User\UserResourceController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth Router
Route::post('login', [AuthController::class, 'login']);

// Active Account
Route::get('active', [AuthController::class, 'active']);

// Reset Password
Route::post('reset-password', [AuthController::class, 'resetPassword']);

// Check Token is valid
Route::get('check-token', [AuthController::class, 'checkToken']);

// Change Password With Token
Route::post('change-password-token', [AuthController::class, 'changePasswordToken']);

Route::middleware('auth:api')->group(function () {
    // Get User
    Route::get('me', [AuthController::class, 'me']);
    // Logout
    Route::get('logout', [AuthController::class, 'logout']);

    // Change password
    Route::post('change-password', [AuthController::class, 'changePassword']);

    // Change User Info
    Route::post('change-user-info', [AuthController::class, 'changeUserInfo']);

    // Storage
    Route::prefix('storage')->group(function () {
        Route::post('store-file', [StorageController::class, 'storeFile']);
    });

    // User
    Route::prefix('user')->group(function () {
        Route::resource('user', UserResourceController::class);
        Route::post('dropdown', [UserResourceController::class, 'dropdown']);
    });

    // Department
    Route::prefix('department')->group(function () {
        Route::resource('department', DepartmentResourceController::class);
        Route::post('dropdown', [DepartmentResourceController::class, 'dropdown']);
    });

    // Checkin
    Route::prefix('checkin')->group(function () {
        Route::resource('checkin', CheckinResourceController::class);
        Route::get('calendar', [CheckinController::class, 'getCalendar']);
        Route::prefix('me')->group(function () {
            Route::get('checkin', [CheckinController::class, 'checkin']);
            Route::get('checkout', [CheckinController::class, 'checkout']);
            Route::get('last-checkin', [CheckinController::class, 'getLastCheckin']);
        });
    });

    // Request
    Route::prefix('request')->group(function () {
        Route::resource('request', RequestResourceController::class);
        Route::get('my-request', [RequestController::class, 'myRequest']);
    });

    // Common
    Route::prefix('common')->group(function () {
        Route::post('check-unique/{table}/{column}/{id?}', [CommonController::class, 'checkUnique']);
    });

    // Manager
    Route::prefix('manager')->group(function () {
        Route::get('list-department', [ManagerController::class, 'listDepartment']);
        Route::get('list-user-by-department/{department_id}', [ManagerController::class, 'listUserByDepartmentId']);

        Route::get('export-user/{department_id}', [ManagerController::class, 'exportExcelUserByDepartmentId']);
    });

});

Route::get('export-user/{department_id}', [ManagerController::class, 'exportExcelUserByDepartmentId']);
Route::get('export-checkin/{user_id}', [ManagerController::class, 'exportUserCheckinByUserId']);
