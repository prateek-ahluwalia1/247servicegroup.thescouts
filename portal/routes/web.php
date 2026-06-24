<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Administrator;
use App\Http\Controllers\Customers;
use App\Http\Controllers\Contractors;
use App\Http\Controllers\Guards;
use App\Http\Controllers\Jobs;
use App\Http\Controllers\Payrates;
use App\Http\Controllers\AwardPayrates;
use App\Http\Controllers\Charged_rates;
use App\Http\Controllers\Notifications;
use App\Http\Controllers\Support;

use App\Http\Controllers\Timeclocks;
use App\Http\Controllers\Timesheet;
use App\Http\Controllers\Job_tracker;
use App\Http\Middleware\ValidateSession;
use App\Http\Middleware\ValidateGuardSession;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Reports;
use App\Http\Controllers\JobRoster;
use App\Http\Controllers\Inductions;
use App\Http\Controllers\Announcements;
use App\Http\Controllers\GoogleAuthenticator;
use App\Http\Controllers\Payslip;

use App\Http\Controllers\Feeds;
use App\Http\Controllers\Operation_Notes;
use App\Http\Controllers\Chats;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\ClickSend;



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
Route::any('/test_email', [Guards::class, 'test_email']);
Route::any('/Apply_rates', [Guards::class, 'Apply_rates']);


Route::any('mercy_hospital', [Dashboard::class, 'mercy_hospital']);
Route::any('server_time', [Dashboard::class, 'server_time']);
Route::any('updateTime', [Dashboard::class, 'updateTime']);
Route::any('mercy_hospital_signin_form', [Dashboard::class, 'mercy_hospital_signin_form']);
Route::any('getGuardShift', [Dashboard::class, 'getGuardShift']);
Route::any('checkCoreGuardShift', [Dashboard::class, 'checkCoreGuardShift']);

Route::middleware([ValidateSession::class])->group(function () {

Route::get('uploads/{slug}', [Administrator::class, 'showImage']);
	
Route::get('users/export/', [Administrator::class, 'export']);
Route::any('administrators', [Administrator::class, 'administrators']);
Route::any('changeAdminStatus', [Administrator::class, 'changeAdminStatus']);
Route::any('roster/doCallAction', [Administrator::class, 'doCallAction']);
// Route::any('job_roster', [Administrator::class, 'job_roster_new']);
Route::any('basic_setting', [Administrator::class, 'basic_setting']);
Route::any('portal_email_settings', [Administrator::class, 'portal_email_settings']);
Route::any('feature_setting', [Administrator::class, 'feature_setting']);
Route::any('notification_setting', [Administrator::class, 'notification_setting']);
Route::any('ph_settings', [Administrator::class, 'ph_settings']);
Route::any('admin/ph', [Administrator::class, 'ph']);
Route::any('admin/geteditPHForm', [Administrator::class, 'geteditPHForm']);
Route::any('admin/updatePH', [Administrator::class, 'updatePH']);
Route::any('admin/getaddPHForm', [Administrator::class, 'getaddPHForm']);
Route::any('admin/addPH', [Administrator::class, 'addPH']);
Route::any('admin/deletePH', [Administrator::class, 'deletePH']);
Route::any('color_settings', [Administrator::class, 'color_settings']);
Route::any('update_portal_colors', [Administrator::class, 'update_portal_colors']);



Route::any('update_admin_email_permissions', [Administrator::class, 'update_admin_email_permissions']);
Route::any('update_guard_email_permissions', [Administrator::class, 'update_guard_email_permissions']);

Route::any('update_feature_selection', [Administrator::class, 'update_feature_selection']);
Route::any('update_feature_setting', [Administrator::class, 'update_feature_setting']);
Route::any('update_notification_selection', [Administrator::class, 'update_notification_selection']);
Route::any('update_basic_communication', [Administrator::class, 'update_basic_communication']);
Route::any('update_basic_display', [Administrator::class, 'update_basic_display']);
Route::any('update_basic_job', [Administrator::class, 'update_basic_job']);
Route::any('update_basic_green_call', [Administrator::class, 'update_basic_green_call']);
Route::any('fetch_setting_features', [Administrator::class, 'fetch_setting_features']);
Route::any('fetch_setting_notifications', [Administrator::class, 'fetch_setting_notifications']);
Route::any('fetch_setting_basic', [Administrator::class, 'fetch_setting_basic']);
Route::any('admin/change_password', [Administrator::class, 'change_password']);
//chat

Route::any('load_user_into_chat', [Chats::class, 'load_user_into_chat'])->name('load_user_into_chat');
Route::any('insert_chat_msg', [Chats::class, 'insert_chat_msg'])->name('insert_chat_msg');
Route::any('get_chat', [Chats::class, 'get_chat'])->name('get_chat');



//dashboard

Route::any('count_dashboard', [Dashboard::class, 'count_dashboard']);
Route::any('roster_progress', [Dashboard::class, 'roster_progress']);
Route::any('monthly_jobs_progress', [Dashboard::class, 'monthly_jobs_progress']);

Route::any('asap_jobs', [Dashboard::class, 'asap_jobs']);
Route::any('asap_jobs_data', [Dashboard::class, 'asap_jobs_data']);
Route::any('shifts_hour_chart', [Dashboard::class, 'shifts_hour_chart']);
Route::any('shift_hours_detail', [Dashboard::class, 'shift_hours_detail']);
Route::any('shift_hours_detail_data', [Dashboard::class, 'shift_hours_detail_data']);

Route::any('security_license_expiry_check', [Dashboard::class, 'security_license_expiry_check']);
Route::any('uncovered_shifts_check', [Dashboard::class, 'uncovered_shifts_check']);
//sidebar

Route::any('incident_report_page', [Reports::class, 'incident_report_page']);
Route::any('report/get_incident_report', [Reports::class, 'get_incident_report']);

Route::any('audit_report', [Reports::class, 'audit_report_page']);
Route::any('report/get_audit_report', [Reports::class, 'get_audit_report']);

Route::any('guard/getPayChargeRate', [Guards::class, 'getPayChargeRate']);
Route::any('dashboard', [Dashboard::class, 'index']);
Route::any('job_roster', [Administrator::class, 'job_roster']);
Route::any('timesheet/', [Timesheet::class, 'timesheet']);
Route::any('job_tracker', [Job_tracker::class, 'job_tracker']);
Route::any('guard/activeGuardLeaveManagement', [Guards::class, 'activeGuardLeaveManagement']);
Route::any('guard/guardLicenseFind', [Guards::class, 'guardLicenseFind']);
Route::any('guard/guardLicenseSearch', [Guards::class, 'guardLicenseSearch']);
Route::any('customers', [Customers::class, 'customers']);
Route::any('guards', [Guards::class, 'guards']);
Route::any('contractors', [Contractors::class, 'contractors']);
Route::any('access', [Administrator::class, 'access']);
Route::any('chat', [Chats::class, 'chat']);
Route::any('announcements/inductions', [Announcements::class, 'index']);
Route::any('announcements/new', [Announcements::class, 'new']);
Route::any('add_new_announcement_induction', [Announcements::class, 'add_new_announcement_induction']);
Route::any('delete_ann_data/{id}', [Announcements::class, 'delete_ann_data']);
Route::any('getEditData/{id}', [Announcements::class, 'getEditData']);
Route::any('inductions', [Inductions::class, 'index']);
Route::any('task_report/', [Reports::class, 'task_report']);
Route::any('contractor_report/', [Reports::class, 'contractor_report']);
Route::any('customer_report/', [Reports::class, 'customer_report']);
Route::any('customer_detail_report/', [Reports::class, 'customer_detail_report']);
Route::any('guard_detail_report/', [Reports::class, 'guard_detail_report']);
Route::any('/guard_payseet', [Reports::class, 'guard_paysheet']);
Route::any('/guard_paysheet_report', [Reports::class, 'guard_paysheet_report']);
Route::any('/guard_timesheet', [Reports::class, 'guard_timesheet']);
Route::any('/invoice_report', [Reports::class, 'invoice_report']);
Route::any('report/invoice_report_data', [Reports::class, 'invoice_report_data']);
Route::any('report/generate_invoice_report', [Reports::class, 'generate_invoice_report']);
Route::any('signin_out_report/', [Reports::class, 'signin_out_report']);
Route::any('export_signin_out_report/', [Reports::class, 'export_signin_out_report']);

Route::any('report/customer_sites', [Reports::class, 'customer_sites']);
Route::any('report/site_guards', [Reports::class, 'site_guards']);
Route::any('/charged_rates', [Charged_rates::class, 'charged_rates']);
Route::any('/payrates', [Payrates::class, 'payrates']);
Route::any('/payrates_new', [Payrates::class, 'payrates_new']);
Route::any('/changeStatusPayRate', [Payrates::class, 'changeStatusPayRate']);
Route::any('/fetch_log_user_activity', [Administrator::class, 'fetch_log_user_activity']);
Route::any('/getAdminsList', [Administrator::class, 'getAdminsList']);
Route::any('/fetch_log_data', [Administrator::class, 'fetch_log_data']);
Route::any('/fetch_activity_log', [Administrator::class, 'fetch_activity_log']);
Route::any('/activity_log', [Administrator::class, 'activity_log']);
Route::any('/user_activity_log', [Administrator::class, 'user_activity_log']);

});
Route::any('/', [Administrator::class, 'index']);
Route::any('bussiness_management', [Administrator::class, 'bussiness_management']);
Route::any('bussiness_management_config/{id}', [Administrator::class, 'bussiness_management_config']);
Route::any('bussiness_management_config_check', [Administrator::class, 'bussiness_management_config_check']);
Route::any('bussiness/approve_bussiness', [Administrator::class, 'approve_bussiness']);
Route::any('get_bussiness', [Administrator::class, 'get_bussiness']);
Route::any('deletebussiness', [Administrator::class, 'delete_bussiness']);
Route::any('update_bussiness', [Administrator::class, 'update_bussiness']);
Route::any('login_bussiness', [Administrator::class, 'login_bussiness']);
Route::any('bussiness_do_login', [Administrator::class, 'bussiness_do_login']);
Route::any('bussiness_do_logout', [Administrator::class, 'bussiness_do_logout']);
Route::any('about_us', [Administrator::class, 'about_us']);
Route::any('update_about_us', [Administrator::class, 'update_about_us']);
Route::any('getMoreInputs', [Administrator::class, 'getMoreInputs']);
Route::any('add_about_us_file', [Administrator::class, 'add_about_us_file']);
Route::any('deleteAboutFile/{id}', [Administrator::class, 'deleteAboutFile']);
Route::any('deleteAboutFilePer/{id}', [Administrator::class, 'deleteAboutFilePer']);
Route::any('update_about_us_file', [Administrator::class, 'update_about_us_file']);


// Route::any('division_consolidation', [Reports::class, 'division_consolidation']);
Route::any('add_division_consolidation', [Reports::class, 'add_division_consolidation']);
Route::any('add_division_consolidation_rates', [Reports::class, 'add_division_consolidation_rates']);
Route::any('export_division_consolidation_report', [Reports::class, 'export_division_consolidation_report']);
Route::post('deleteDivision/{id}', [Reports::class, 'deleteDivision']);
Route::post('report/getDivisionFrom', [Reports::class, 'getDivisionFrom']);
// Route::any('exportDivision', [Reports::class, 'exportDivision']);
Route::any('exportDivision', [Reports::class, 'export_division_consolidation_report']);
// Route::any('exportDivision', [Reports::class, 'export_division_consolidation_report']);

Route::any('division_consolidation', [Reports::class, 'division_consolidation_report']);
Route::any('get_division_consolidation', [Reports::class, 'get_division_consolidation']);
Route::any('getCustomerPieChart', [Reports::class, 'getCustomerPieChart']);
Route::any('getCutsomerProfitLoss', [Reports::class, 'getCutsomerProfitLoss']);


// Route::get('/', function () {
//     return view('welcome');
// });
//welcome

Route::any('not_found', [Administrator::class, 'not_found']);
Route::any('activitiesLog', [Administrator::class, 'get_log_activities']);




Route::any('/home', [Administrator::class, 'home'])->middleware('auth');
Route::any('do_login', [Administrator::class, 'do_login']);
Route::any('do_logout', [Administrator::class, 'do_logout']);
Route::any('do_logout_contractor', [Administrator::class, 'do_logout_contractor']);
Route::any('do_logout_guard', [Administrator::class, 'do_logout_guard']);
Route::any('do_logout_customer', [Administrator::class, 'do_logout_customer']);



//admin



Route::any('profile/{id}', [Administrator::class, 'profile']);
Route::post('insertUser', [Administrator::class, 'insert']);
Route::post('editUser/{id}', [Administrator::class, 'editUser']);
Route::post('deleteUser/{id}', [Administrator::class, 'deleteUser']);
Route::any('getUser/', [Administrator::class, 'getUser']);
Route::any('admin/downloadpdf/', [Administrator::class, 'downloadpdf']);
Route::any('/admin/admin_pdf', [Administrator::class, 'admin_pdf']);


//customer


Route::any('customer', [Customers::class, 'customer']);
Route::any('customer/contacts_form', [Customers::class, 'contacts_form']);
Route::any('customers_login', [Customers::class, 'do_login']);


Route::any('getcontractors', [Contractors::class, 'getcontractors']);
Route::any('fetch_contractor_id_range', [Contractors::class, 'fetch_contractor_id_range']);

Route::any('contractor_total_shifts', [Contractors::class, 'contractor_total_shifts']);
Route::any('contractor_total_sites', [Contractors::class, 'contractor_total_sites']);

Route::any('customer_total_shifts', [Customers::class, 'customer_total_shifts']);
Route::any('customer_total_sites', [Customers::class, 'customer_total_sites']);

Route::post('insertCustomer', [Customers::class, 'insertCustomer']);
Route::post('editCustomer/{id}', [Customers::class, 'editCustomer']);
Route::post('deleteCustomer/{id}', [Customers::class, 'deleteCustomer']);
Route::post('inactiveCustomer/{id}', [Customers::class, 'inactiveCustomer']);
Route::post('activeCustomer/{id}', [Customers::class, 'activeCustomer']);
Route::any('getCustomer/{id}', [Customers::class, 'getCustomer']);
Route::any('/customer/get_personal_data', [Customers::class, 'personal_data']);
Route::any('/customer/save_personal_form', [Customers::class, 'save_personal_form']);
Route::any('/customer/upload_files', [Customers::class, 'upload_files']);
Route::any('/customer/save_charged_rates', [Customers::class, 'save_charged_rates']);
Route::any('/customer/get_customer_payrates', [Customers::class, 'get_customer_payrates']);
Route::any('/customer/documents_form', [Customers::class, 'save_documents_form']);
Route::any('/customer/get_documents_data', [Customers::class, 'get_documents_data']);
Route::any('/customer/save_contacts', [Customers::class, 'save_contacts']);
Route::any('/customer/get_contacts', [Customers::class, 'get_contacts']);
Route::any('customer_profile/{id}', [Customers::class, 'Customerprofile']);
Route::any('/customer/customer_pdf', [Customers::class, 'customer_pdf']);
Route::any('/customer/get_customers', [Customers::class, 'get_customers']);

Route::any('/customer/get_charged_rates', [Customers::class, 'get_charged_rates']);
Route::any('/customer/reload_charged_rates', [Customers::class, 'reload_charged_rates']);


//contractor

Route::any('contractor', [Contractors::class, 'contractor']);

Route::any('contractors_login', [Contractors::class, 'do_login']);

Route::post('insertContractor', [Contractors::class, 'insertContractor']);
Route::post('editContractor/{id}', [Contractors::class, 'editContractor']);
Route::post('deleteContractor/{id}', [Contractors::class, 'deleteContractor']);
Route::any('getContractor/{id}', [Contractors::class, 'getContractor']);
Route::any('/contractor/get_personal_data', [contractors::class, 'personal_data']);
Route::any('/contractor/save_personal_form', [contractors::class, 'save_personal_form']);
Route::any('/contractor/upload_files', [contractors::class, 'upload_files']);
Route::any('/contractor/save_charged_rates', [contractors::class, 'save_charged_rates']);
Route::any('/contractor/get_contractor_payrates', [contractors::class, 'get_contractor_payrates']);
Route::any('/contractor/documents_form', [contractors::class, 'save_documents_form']);
Route::any('/contractor/get_documents_data', [contractors::class, 'get_documents_data']);
Route::any('/contractor/save_contacts', [contractors::class, 'save_contacts']);
Route::any('/contractor/get_contacts', [contractors::class, 'get_contacts']);
Route::any('contractor_profile/{id}', [contractors::class, 'contractorprofile']);
Route::any('/contractor/contractor_pdf', [Contractors::class, 'contractor_pdf']);


Route::any('/contractor/get_charged_rates', [Contractors::class, 'get_charged_rates']);
Route::any('/contractor/reload_charged_rates', [Contractors::class, 'reload_charged_rates']);


// access_roles
Route::post('insertAccess', [Administrator::class, 'insertAccess']);
Route::any('getAccess/{id}', [Administrator::class, 'getAccess']);
Route::post('editAccess/{id}', [Administrator::class, 'editAccess']);
Route::post('deleteAccess/{id}', [Administrator::class, 'deleteAccess']);
// guard




Route::any('guard/profile_tracker', [Guards::class, 'profile_tracker']);

Route::any('guard/convert_asap', [Guards::class, 'convert_asap']);
Route::any('guard_active_inactive_status', [Guards::class, 'guard_active_inactive_status']);
Route::any('guard/guard_leave_management', [Guards::class, 'guard_leave_management']);
Route::any('guard/update_guard_leave_management', [Guards::class, 'update_guard_leave_management']);

Route::any('guard/update_guard_uniform', [Guards::class, 'update_guard_uniform']);
Route::any('guard/get_guard_uniform', [Guards::class, 'get_guard_uniform']);
Route::any('guard_job_rating', [Guards::class, 'guard_job_rating']);
Route::any('guard_rating', [Guards::class, 'guard_rating']);

// Route::any('generate_payroll_id', [Guards::class, 'generate_payroll_id']);
Route::any('create_guard', [Guards::class, 'create_guard']);
Route::any('edit_guard/{id}', [Guards::class, 'edit_guard']);
Route::any('guard/get_guard_ids', [Guards::class, 'guard_ids']);
Route::any('guard/guard_payroll_id', [Guards::class, 'guard_payroll_id']);
Route::any('guard/get_guard_payroll_ids', [Guards::class, 'guard_payroll_ids']);
Route::any('guard/get_guard_ids_form', [Guards::class, 'guard_ids_form']);
Route::any('guard/get_guard_payroll_ids_form', [Guards::class, 'guard_payroll_ids_form']);
Route::any('save_ids_form', [Guards::class, 'save_ids_form']);
Route::any('personal_form', [Guards::class, 'personal_form']);
Route::any('guard/save_personal_form', [Guards::class, 'save_personal_form']);
Route::any('/guard/get_guard_site_block_form', [Guards::class, 'gaurd_site_block_form']);
Route::any('/guard/get_guard_site_train_form', [Guards::class, 'guard_site_train_form']);
Route::any('/guard/upload_files', [Guards::class, 'upload_files']);
Route::any('/guard/get_guard_payrol', [Guards::class, 'get_guard_payrol']);
Route::any('/guard/save_payroll_form', [Guards::class, 'save_payroll_form']);
Route::any('/guard/get_guard_payrates', [Guards::class, 'get_guard_payrates']);
Route::any('/guard/save_guard_payrates', [Guards::class, 'save_guard_payrates']);
Route::any('/guard/get_guard_site_trained', [Guards::class, 'get_guard_site_trained']);
Route::any('/guard/save_sites_trained_form', [Guards::class, 'save_sites_trained_form']);
Route::any('/guard/get_guard_site_blocked', [Guards::class, 'get_guard_site_blocked']);
Route::any('/guard/sites_blocked_form', [Guards::class, 'sites_blocked_form']);
Route::any('/guard/get_personal_data', [Guards::class, 'personal_data']);
Route::any('/documents_form', [Guards::class, 'save_documents_form']);
Route::any('guard/del_guard_documents', [Guards::class, 'del_guard_documents']);
Route::any('/guard/get_guard_documents', [Guards::class, 'guard_documents']);
Route::any('/guard/get_guard_document_form', [Guards::class, 'get_guard_document_form']);
Route::any('/guard/get_gaurd_other_files', [Guards::class, 'get_gaurd_other_files']);
Route::any('/guard/upload_any_files', [Guards::class, 'upload_any_files']);

Route::any('/guard/getGuards', [Guards::class, 'getGuardsList']);
Route::any('/guard/eventStatus', [Guards::class, 'eventStatus']);
Route::any('/guard/getAllGuards', [Guards::class, 'getAllGuards']);
Route::any('/guard/getAllnotCustomersGuards', [Guards::class, 'getAllnotCustomersGuards']);
Route::any('/guard/saveJobGuard', [Guards::class, 'saveJobGuard']);
Route::any('/guard/addNewShift', [Guards::class, 'addNewShift']);

Route::any('/guard/checkAvailability', [Guards::class, 'checkAvailability']);
Route::any('validate_passcode', [Guards::class, 'validate_passcode']);
Route::any('bypass_job', [Guards::class, 'bypass_job']);

Route::any('guard_profile/{id}', [Guards::class, 'guard_profile']);

Route::any('/guard/change_password/', [Guards::class, 'change_password']);

Route::any('/guard/publishRoster/', [Guards::class, 'publishRoster']);
Route::any('/guard/saveRoster/', [Guards::class, 'saveRoster']);
Route::any('/guard/publishRosterNew/', [Guards::class, 'publishRosterNew']);

Route::any('/guard/get_payrates', [Guards::class, 'get_payrates']);
Route::any('/guard/reload_payrates', [Guards::class, 'reload_payrates']);
Route::any('/guard/add_site_guard', [Guards::class, 'add_site_guard']);
Route::any('/guard/calendarResouces', [Guards::class, 'calendarResouces']);
Route::any('/guard/getAddGuardFrom', [Guards::class, 'getAddGuardFrom']);
Route::any('/guard/geteditGuardFrom', [Guards::class, 'geteditGuardFrom']);
Route::any('/guard/addMultipleShiftsForm', [Guards::class, 'addMultipleShiftsForm']);
Route::any('/guard/getCalendarHours', [Guards::class, 'getCalendarHours']);
Route::any('/guard/getShiftNotes', [Guards::class, 'getShiftNotes']);
Route::any('/guard/updateNotes', [Guards::class, 'updateNotes']);

Route::any('guard/getPublishList', [Guards::class, 'getPublishList']);
Route::any('/checkUpdateHoursDistribution', [Guards::class, 'checkUpdateHoursDistribution']);
Route::any('guard/getSelectedListPublish', [Guards::class, 'getSelectedListPublish']);
Route::any('guard/copyRosterNew', [Guards::class, 'copyRosterNew']);
Route::any('guard/copyShiftNew', [Guards::class, 'copyShiftNew']);


Route::any('covid_status', [Guards::class, 'covid_status']);
Route::any('admin_approval_status', [Guards::class, 'admin_approval_status']);
Route::any('guard_shift_hours_stats', [Guards::class, 'guard_shift_hours_stats']);
Route::any('deleteguard/{id}', [Guards::class, 'deleteguard']);
Route::any('restoreguard/{id}', [Guards::class, 'restoreguard']);
Route::any('guard_activation/{id}', [Guards::class, 'guard_activation']);

// Route::any('do_login_guard', [Guards::class, 'do_login_guard']);
// Route::any('guard_login', [Guards::class, 'guard_login']);


Route::any('test_table_view/', [Guards::class, 'test_table_view']);
Route::any('activeGuardLeaveManagement/', [Guards::class, 'activeGuardLeaveManagement']);
Route::any('guard/update_guard_avability_weak', [Guards::class, 'update_guard_avability_weak']);
Route::any('guard/guard_avability_weak', [Guards::class, 'guard_avability_weak']);

Route::any('guard/guard_work_limitation', [Guards::class, 'guard_work_limitation']);
Route::any('guard/update_guard_work_limitation', [Guards::class, 'update_guard_work_limitation']);


Route::prefix('guard')->group(function () {
	Route::any('addMultipleShifts', [Guards::class, 'addMultipleShifts']);
	Route::any('calendarData', [Guards::class, 'calendarData']);
	Route::any('getUnpublishedShiftCount', [Guards::class, 'getUnpublishedShiftCount']);
	Route::any('getAavailableGuards', [Guards::class, 'getAavailableGuards']);
	Route::any('getAllAavailableGuards', [Guards::class, 'getAllAavailableGuards']);
	Route::any('checkGuardLeave', [Guards::class, 'checkGuardLeave']);
	Route::any('assignGuardLeave', [Guards::class, 'assignGuardLeave']);
	
	Route::any('incident_report_pdf/{id}', [Reports::class, 'generate_incident_report_pdf_new']);
	Route::any('foot_patrol_report_pdf/{id}', [Reports::class, 'generate_foot_patrol_report_pdf_new']);
	Route::any('audit_report_pdf/{id}', [Reports::class, 'generate_audit_report_pdf']);
	Route::any('checkUpdtaeCalendarEvent', [Guards::class, 'checkUpdtaeCalendarEvent']);
	Route::any('loadTabData', [Guards::class, 'loadTabData']);
	Route::any('deleteShift', [Guards::class, 'deleteShift']);
	Route::any('documentsOnlineVerification', [Guards::class, 'documentsOnlineVerification']);
	Route::any('leaveDetails', [Guards::class, 'leaveDetails']);
	Route::any('changeLeaveStatus', [Guards::class, 'changeLeaveStatus']);
	Route::any('load_payrates', [Guards::class, 'load_payrates']);
	Route::any('load_chargerates', [Guards::class, 'load_chargerates']);
	Route::any('getSelectedSitesShifts', [Guards::class, 'getSelectedSitesShifts']);
	Route::any('removeRosterIdsOfSites', [Guards::class, 'removeRosterIdsOfSites']);
	Route::any('send_custom_push_notifications', [Guards::class, 'send_custom_push_notifications']);
	Route::any('deleteOtherFile', [Guards::class, 'deleteOtherFile']);
});





// Jobs
Route::any('/job/get_customers_jobs_list', [Jobs::class, 'get_customers_jobs_list']);
Route::any('/job/get_customers_jobs', [Jobs::class, 'get_customers_jobs']);

Route::any('/job/add_site_from', [Jobs::class, 'add_site_from']);
Route::any('/job/add_guard_from', [Jobs::class, 'add_guard_from']);
Route::any('/job/add_site', [Jobs::class, 'add_site']);
Route::any('/job/get_site_data', [Jobs::class, 'get_site_data']);
Route::any('/job/edit_site_form', [Jobs::class, 'edit_site_form']);
Route::any('/job/deleteSite', [Jobs::class, 'deleteSite']);
Route::any('/site_list', [Jobs::class, 'site_list']);
Route::any('/site_list_detail', [Jobs::class, 'site_list_detail']);

Route::any('/get_site_list', [Jobs::class, 'get_site_list']);
Route::any('job/pay_charge_history', [Jobs::class, 'pay_charge_history']);
Route::any('job/getWeekList', [Jobs::class, 'getWeekList']);
Route::any('job/getDayList', [Jobs::class, 'getDayList']);
Route::any('restore_site/{id}', [Jobs::class, 'restore_site']);

// FPDF

// app/Http/routes.php | app/routes/web.php

Route::get('/pdftest', function (Codedge\Fpdf\Fpdf\Fpdf $fpdf) {

    $fpdf->AddPage();
    $fpdf->SetFont('Courier', 'B', 18);

    $fpdf->Cell(50, 25, 'Hello World!');
    $fpdf->Image("https://247staffingsolutions.com.au/assets/images/logo/logo.png",10,10,-300);

    $fpdf->Output();

});



// payrates

Route::any('/create_payrate', [Payrates::class, 'create_payrate']);
Route::any('/create_payrate_customized', [Payrates::class, 'create_payrate_customized']);
Route::any('/create_payrate_new', [Payrates::class, 'create_payrate_new']);
Route::any('/get_payrates/{id}', [Payrates::class, 'get_payrates']);
Route::any('/update_payrates/{id}', [Payrates::class, 'update_payrates']);
Route::any('/delete_payrate/{id}', [Payrates::class, 'delete_payrate']);
Route::any('/guard/save_guard_own_payrates', [Payrates::class, 'save_guard_own_payrates']);
Route::any('/guard/save_guard_own_payrates_new', [Payrates::class, 'save_guard_own_payrates_new']);
Route::any('/payrates/getTypePayrate', [Payrates::class, 'getTypePayrate']);

// Award rates Routes
Route::any('/award_payrates', [AwardPayrates::class, 'payrates']);
Route::any('/get_award_payrates/{id}', [AwardPayrates::class, 'get_payrates']);
Route::any('/create_award_payrate', [AwardPayrates::class, 'create_payrate']);
Route::any('/update_award_payrates/{id}', [AwardPayrates::class, 'update_payrates']);
Route::any('/delete_award_payrate/{id}', [AwardPayrates::class, 'delete_payrate']);

//timesheet
Route::any('timesheet_search/', [Timesheet::class, 'timesheet_search']);
Route::any('timesheet_record/', [Timesheet::class, 'timesheet_record']);

// timeclock

Route::any('timeclock/', [Timeclocks::class, 'timeclock']);
Route::any('timeclock/today', [Timeclocks::class, 'today']);
Route::any('timeclock/timesheet', [Timeclocks::class, 'timesheet']);

// charged_rates

Route::any('/create_charged_rate', [Charged_rates::class, 'create_charged_rate']);
Route::any('/get_charged_rates/{id}', [Charged_rates::class, 'get_charged_rates']);
Route::any('/update_charged_rates/{id}', [Charged_rates::class, 'update_charged_rates']);
Route::any('/delete_charged_rate/{id}', [Charged_rates::class, 'delete_charged_rate']);
Route::any('/changeStatusChargeRate', [Charged_rates::class, 'changeStatusChargeRate']);



// job_tracker

Route::any('job_tracker/get_customers_jobs_list', [Job_tracker::class, 'get_customers_jobs_list']);
Route::any('job_tracker/get_customers_jobs_list_filter', [Job_tracker::class, 'get_customers_jobs_list_filter']);
Route::any('job_tracker/get_customers_guards_list_filter', [Job_tracker::class, 'get_customers_guards_list_filter']);

Route::any('job_tracker/timesheet_search/', [Job_tracker::class, 'timesheet_search']);
Route::any('job_tracker/timesheet_record/', [Job_tracker::class, 'timesheet_record']);
Route::any('tracker_approval_status', [Job_tracker::class, 'tracker_approval_status']);

Route::any('job_tracker/update_signin', [Job_tracker::class, 'update_signin']);
Route::any('job_tracker/update_signout', [Job_tracker::class, 'update_signout']);



Route::any('get_tracker_data', [Job_tracker::class, 'get_tracker_data']);

//Reports


Route::any('calculate_hours', [Reports::class, 'calculate_hours']);
Route::any('customer_report/customer_report_search/', [Reports::class, 'customer_report_search']);
Route::any('customer_report/customer_report_record/', [Reports::class, 'customer_report_record']);


Route::any('contractor_report/contractor_report_search/', [Reports::class, 'contractor_report_search']);
Route::any('contractor_report/contractor_report_record/', [Reports::class, 'contractor_report_record']);



Route::any('guard_detail_report/guard_detail_report_search/', [Reports::class, 'guard_detail_report_search']);
Route::any('guard_detail_report/guard_detail_report_record/', [Reports::class, 'guard_detail_report_record']);



Route::any('task/task_report_search/', [Reports::class, 'task_report_search']);
Route::any('task_report/task_report_record/', [Reports::class, 'task_report_record']);


Route::any('/task/get_customers_jobs_list', [Reports::class, 'get_customers_jobs_list']);
Route::any('/task/task_report_onchange', [Reports::class, 'task_report_onchange']);
Route::any('/task/export_table', [Reports::class, 'export_table']);

// paysheet

Route::any('/guard_complete_report', [Reports::class, 'guard_complete_report']);
Route::any('/export_guard_complete_report', [Reports::class, 'export_guard_complete_report']);
Route::any('/generate_paysheet_pdf', [Reports::class, 'generate_paysheet_pdf']);
Route::any('/report/paysheet_excel', [Reports::class, 'paysheet_excel']);

// Inductions
Route::any('induction/{id}', [Inductions::class, 'induction']);
Route::any('get_send_by_list/', [Inductions::class, 'get_send_by_list']);
Route::any('get_guard_list/', [Inductions::class, 'get_guard_list']);
Route::any('add_induction', [Inductions::class, 'add_induction']);
Route::any('upload_image_induction', [Inductions::class, 'upload_image_induction']);
Route::any('update_induction', [Inductions::class, 'update_induction']);
Route::any('get_send_by_list_induction', [Inductions::class, 'get_send_by_list_induction']);

Route::any('edit_induction', [Inductions::class, 'edit_induction']);
Route::any('delete_induction/{id}', [Inductions::class, 'delete_induction']);
Route::any('get_induction_images', [Inductions::class, 'get_induction_images']);
Route::any('induction_seen_status', [Inductions::class, 'induction_seen_status']);






Route::any('announcements/induction/{id}', [Announcements::class, 'induction']);
Route::any('announcements/get_send_by_list/', [Announcements::class, 'get_send_by_list']);
Route::any('announcements/get_guard_list/', [Announcements::class, 'get_guard_list']);
Route::any('announcements/add_induction', [Announcements::class, 'add_induction']);
Route::any('announcements/upload_image_induction', [Announcements::class, 'upload_image_induction']);
Route::any('announcements/update_induction', [Announcements::class, 'update_induction']);
Route::any('announcements/get_send_by_list_induction', [Announcements::class, 'get_send_by_list_induction']);

Route::any('announcements/edit_induction', [Announcements::class, 'edit_induction']);
Route::any('announcements/delete_induction/{id}', [Announcements::class, 'delete_induction']);
Route::any('announcements/get_induction_images', [Announcements::class, 'get_induction_images']);
Route::any('announcements/induction_seen_status', [Announcements::class, 'induction_seen_status']);




// news_and_feeds
Route::any('news_and_feeds', [Feeds::class, 'news_and_feeds']);
Route::any('create_feed', [Feeds::class, 'create_feed']);
Route::any('get_feed', [Feeds::class, 'get_feed']);
Route::any('post_comment', [Feeds::class, 'post_comment']);
Route::any('get_comment', [Feeds::class, 'get_comment']);
Route::any('check_like', [Feeds::class, 'check_like']);
Route::any('delete_comment', [Feeds::class, 'delete_comment']);
Route::any('delete_feed', [Feeds::class, 'delete_feed']);
Route::any('view_feed_status', [Feeds::class, 'view_feed_status']);





Route::any('count_likes', [Feeds::class, 'count_likes']);














// Guard routes

Route::any('guard', [Guards::class, 'login']);
Route::any('guard_login', [Guards::class, 'do_login']);
Route::any('guard/forgot_password', [Guards::class, 'forgot_password']);
Route::any('guard_reset_password', [Guards::class, 'guard_reset_password']);
// Route::any('guard_reset_password', [Guards::class, 'guard_reset_password']);
Route::any('guard_forgot_email_success/{any}', [Guards::class, 'guard_forgot_email_success']);
Route::any('reset_gaurd_password/{any}', [Guards::class, 'reset_gaurd_password']);
Route::any('update_guard_password', [Guards::class, 'update_guard_password']);
Route::any('/guard/deleteTask', [Guards::class, 'deleteTask']);
Route::any('resend_guard_email', [Guards::class, 'resend_guard_email']);
Route::any('get_specific_guard_customer', [Guards::class, 'get_specific_guard_customer']);
Route::any('applyPayRates', [Guards::class, 'applyPayRates']);




Route::middleware([ValidateGuardSession::class])->group(function () {
Route::any('guard/profile', [Guards::class, 'profile']);


});


// Route::any('get_inductions', [Inductions::class, 'get_inductions']);

//operation_notes



Route::any('create_operation_notes', [Operation_Notes::class, 'create_operation_notes']);
Route::any('get_admin_toid', [Operation_Notes::class, 'get_admin_toid']);

Route::any('get_operations', [Operation_Notes::class, 'get_operations']);
Route::any('get_operations_send', [Operation_Notes::class, 'get_operations_send']);
Route::any('most_recent_operation_note', [Operation_Notes::class, 'most_recent_operation_note']);


Route::any('mark_as_read', [Operation_Notes::class, 'mark_as_read']);

Route::any('get_operations_n_times', [Operation_Notes::class, 'get_operations_n_times']);
Route::any('detail_popup_operation', [Operation_Notes::class, 'detail_popup_operation']);

Route::any('get_count_notes', [Operation_Notes::class, 'get_count_notes']);


// Notifications routes

Route::any('guard_leave_location', [Notifications::class, 'guard_leave_location']);
Route::any('guard_green_call', [Notifications::class, 'green_call']);
Route::any('guard_welfare_call', [Notifications::class, 'welfare_call']);
Route::any('guard_incident_report', [Notifications::class, 'guard_incident_report']);
Route::any('guard_other_notifications', [Notifications::class, 'guard_other_notifications']);
Route::any('seen_all_notifications', [Notifications::class, 'seen_all_notifications']);
Route::any('unseen_all_notifications', [Notifications::class, 'unseen_all_notifications']);
Route::any('unread_messages', [Notifications::class, 'unread_messages']);

// reports routes

Route::any('generate_complete_activity_report/{id}', [Reports::class, 'generate_complete_activity_report']);
Route::any('report/generateRosterReport', [Reports::class, 'generateRosterReport']);
Route::any('report/geneateCustomerReport', [Reports::class, 'geneateCustomerReport']);
Route::any('report/geneateCustomerReport_Excel_PDF', [Reports::class, 'geneateCustomerReport_Excel_PDF']);
Route::any('sendSMS', [Guards::class, 'sendSMS']);





Route::any('clickSendTest', [ClickSend::class, 'getHistory']);
Route::any('getHistory', [ClickSend::class, 'getClickSendHistory']);
Route::any('sendSMSC', [ClickSend::class, 'sendSMSC']);
Route::any('operationReport', [ClickSend::class, 'operationReport']);

// Suport Routes
Route::any('support', [Support::class, 'login']);
Route::any('support_login', [Support::class, 'support_login']);


Route::post('/generateQR', [GoogleAuthenticator::class, 'generateQR']);
Route::get('/authenticationQr', [GoogleAuthenticator::class, 'authenticationQr']);
Route::post('/2fa', [Administrator::class, 'twofaEnable'])->name('twofaEnable');


Route::any('/payslip', [Payslip::class, 'payslip'])->name('payslip');


Route::any('signin_out_report', [JobRoster::class, 'signin_out_report']);
Route::any('/signinout_report', [JobRoster::class, 'signinout_report']);
Route::any('report/generate_signinout_report', [JobRoster::class, 'generate_signinout_report']);

Route::any('/combine_report', [Reports::class, 'combine_report']);
Route::any('generateMultiReport', [Reports::class, 'generateMultiReport']);

Route::any('/award_report', [Reports::class, 'award_report']);
Route::any('generateAwardReport', [Reports::class, 'generateAwardReport']);

Route::any('app_status', [JobRoster::class, 'app_status']);

Route::any('update-guard-to-active', [JobRoster::class, 'updateGuardToActive']);

Route::get('/send-birthday-mail', [Guards::class, 'sendBirthdayMail'])->name('sendBirthdayMail');













