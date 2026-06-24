<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AdminController;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\ContractorController;
use App\Http\Controllers\api\JobRosterController;
use App\Http\Controllers\api\GuardController;
use App\Http\Controllers\Reports;
use App\Http\Controllers\Job_tracker;
use App\Http\Controllers\Timeclocks;
use App\Http\Controllers\Guards;
use App\Http\Controllers\Announcements;
use App\Http\Controllers\Inductions;
use App\Http\Controllers\Administrator;
use App\Http\Controllers\Jobs;
use App\Http\Controllers\Dashboard;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1'], function () use ($router) {
Route::post('/login', [AdminController::class , 'login']);
Route::any('/guardLeaveRequests', [AdminController::class , 'guardLeaveRequests']);
Route::any('/changeGuardLeaveStatus/{type}/{id}', [AdminController::class , 'changeGuardLeaveStatus']);
Route::any('/getCustomers', [CustomerController::class , 'getCustomers']);
Route::any('/getCustomerSites', [CustomerController::class , 'getCustomerSites']);
Route::any('/getJobRoster', [JobRosterController::class , 'getJobRoster']);
Route::any('/guard_timesheet', [Reports::class, 'guard_timesheet_api']);
Route::any('/job_tracker', [Job_tracker::class, 'timesheet_record_api']);
Route::any('/timeclock', [Timeclocks::class, 'timeclock_record_api']);
Route::any('/administrators', [AdminController::class, 'administrators']);
Route::any('/getContractors', [ContractorController::class, 'getContractors']);
Route::any('/getGuards/{type}', [GuardController::class, 'getGuards']);
Route::any('/getAccess', [AdminController::class , 'getAccess']);
Route::any('/updateAccess/{id}', [AdminController::class , 'updateAccess']);
Route::any('/getShiftDetails', [Guards::class , 'getShiftDetails']);
Route::any('/getShiftTabDetails', [Guards::class , 'getShiftTabDetails']);
Route::any('announcements', [Announcements::class, 'getAnnouncements']);
Route::any('inductions', [Inductions::class, 'getInductions']);
Route::any('/activity_log', [Administrator::class, 'GetActivityLog']);
Route::any('updateAdminProfile/{id}', [AdminController::class , 'editUser']);
Route::any('deleteAdminProfile/{id}', [AdminController::class , 'deleteUser']);
Route::any('/updateCustomerProfile/{id}', [CustomerController::class , 'editUser']);
Route::any('/deleteCustomerProfile/{id}', [CustomerController::class , 'deleteUser']);
Route::any('/checkShiftAvailability', [Guards::class , 'checkShiftAvailability']);
Route::any('/getSiteActiveGuards/{id}', [Guards::class , 'getSiteActiveGuards']);
Route::any('/deleteShift', [Guards::class , 'deleteShift']);
Route::any('deleteAccess/{id}', [AdminController::class, 'deleteAccess']);
Route::any('submitAuditForm', [AdminController::class, 'submitAuditForm']);
Route::any('getAduitData/{id}', [AdminController::class, 'getAduitData']);
Route::any('upload-image', [AdminController::class, 'uploadImage']);
Route::any('/getActiveGuards/{id}', [GuardController::class, 'getActiveGuards']);
Route::any('/BusinessData',[AdminController::class, 'BusinessData']);
Route::any('get_induction_images', [Inductions::class, 'get_induction_images_api']);
Route::any('complete_roster_report/{id}', [Reports::class, 'generate_complete_activity_report_api']);
Route::any('/publishRoster', [Guards::class , 'publishRoster']);
Route::any('getUnpublishedShiftCount', [Guards::class, 'getUnpublishedShiftCount']);
Route::any('getAavailableGuards', [Guards::class, 'getAavailableGuardsApi']);
Route::any('save_personal_form', [GuardController::class, 'save_personal_form']);
Route::any('/updateNotificationToken', [AdminController::class , 'updateNotificationToken']);
Route::any('/getStats', [AdminController::class , 'getStats']);
Route::any('/getGuardsList', [AdminController::class , 'getGuardsList']);
Route::any('checkCoreGuardShift', [Dashboard::class, 'checkCoreGuardShift']);
Route::any('getGuardShift', [Dashboard::class, 'getGuardShift']);
Route::any('mercy_hospital_signin_form', [Dashboard::class, 'mercy_hospital_signin_form']);
Route::any('/updateAuthenticationCode', [AdminController::class , 'updateAuthenticationCode']);


// Route::any('/timeclock', [Job_tracker::class, 'timesheet_record_api']);

// Route::any('/guardTimeClock', [AdminController::class , 'guardTimeClock']);
Route::any('/getSiteDetails/{id}', [Jobs::class, 'get_site_detail']);
Route::any('/getSiteList', [Jobs::class, 'get_site_list']);
Route::any('resend_guard_email', [Guards::class, 'resend_guard_email']);
Route::any('/restsoreDeletedGuard/{id}', [GuardController::class, 'restsoreDeletedGuard']);
Route::any('/updateSite', [Jobs::class, 'add_site']);


});
