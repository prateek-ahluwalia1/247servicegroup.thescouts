<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use ClickSend\Configuration;
use ClickSend\Api\SMSApi;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Fpdf\Fpdf;
use \PDF;
// use ClickSend\;

class ClickSend extends Controller
{
	public function __construct()
	{
		// require_once(base_path() . '/vendor/autoload.php');
	}

	function getClickSendHistory(Request $request)
	{
		// dd($request->admin_id);
		$from = strtotime($request->from);
		$to = strtotime($request->to);
		$admin_id = $request->admin_id;

		// $from = strtotime('2022-10-19 12:00');
		// $to = strtotime('2022-10-21 12:00');
		// $admin_id = 1;
		$page = 1;
		$last_page = 1;
		$limit = 15;
		$sms_data = [];
		$logo = '';
		do{
		$data = $this->getHistory($from, $to, $page, $limit);
		$page++;
		if ($data != false) {
			$last_page = $data['data']['last_page'];
			$sms_data = array_merge($sms_data, $data['data']['data']);
		}else{
			$last_page = 0;
		}
		}while($page <= $last_page);
        // $logo = $this->image_to_base64(config('custom.logo'));
        // exit();
        $logo = config('custom.logo');
        $title = config('custom.title');
        $address = config('custom.address');
        $admin = DB::table('administrators')->where('id', $admin_id)->first();
        $admin_activity = json_decode(json_encode($this->admin_activity($admin_id, $from, $to)), true);
        $sms_data = array_merge($sms_data, $admin_activity);
        $keys = array_column($sms_data, 'date');
		array_multisort($keys, SORT_DESC, $sms_data);
		// var_dump($new);	
        // print_r('<pre>');
        // print_r($sms_data);
        // exit();
        $colors = array(
        	'shift_change' =>  '#5D6D7E',
        	'shift_delete' => '#900C3F',
        	'shift_add' => '#F39C12',
        	'guard_creation' => '#2874A6',
        	'guard_update' => '#F1948A',
        	'message' => '#45B39D',
        	'guard_delete' => '#C0392B'
        );
		$pdf = PDF::loadView('reports/operationReport', ['data' => $sms_data,'logo' => $logo, 'title' => $title, 'address' => $address, 'admin' => $admin, 'from' => $from, 'to' => $to, 'activity' => $admin_activity, 'color' => $colors]);
		// $pdf = view('reports/operationReport', ['data' => $sms_data,'logo' => $logo, 'title' => $title, 'address' => $address, 'admin' => $admin, 'from' => $from, 'to' => $to, 'activity' => $admin_activity, 'color' => $colors])->render();
		// echo $pdf;
		return $pdf->stream($admin->name.'_'.date('d/m/Y').'_operation_report.pdf');
    	// return $pdf->download(date('d/m/Y').'_roster_acticity_report.pdf');
		// print_r('<pre>');
		// print_r($admin_activity);
	}

	function admin_activity($admin_id, $from, $to)
	{
		$log= DB::table('log_user_activities')->join('administrators','log_user_activities.user_id','=','administrators.id')->select(
      'administrators.name AS user',
      'log_user_activities.created_at',
      'log_user_activities.data',
      'log_user_activities.action' 
    )->where('log_user_activities.user_id',$admin_id);
	$log = $log
	->where('log_user_activities.created_at', '>=', date('Y-m-d H:i:s', $from))
	->where('log_user_activities.created_at', '<=', date('Y-m-d H:i:s', $to))
	->orderBy('created_at', 'desc')->get();
	foreach ($log as $key => $act) {
    $act->current_data = array();
    $data = json_decode($act->data, true);
    if ($act->action == 'shift_add' || $act->action == 'shift_change' || $act->action == 'shift_delete') {
      $guard_id = !empty($data) ? (isset($data[0]) ? $data[0]['guard_id'] : $data['guard_id']) : 0;
      $site_id = !empty($data) ? (isset($data[0]) ? $data[0]['site_id'] : $data['site_id']) : 0;
      $roster_id = !empty($data) ? (isset($data[0]) ? $data[0]['roster_id'] : $data['roster_id']) : 0;
      $site = DB::table('jobs')->where('id', $site_id)->select('site_name','site_description')->first();
      $guard = DB::table('guards')->where('id', $guard_id)->select('name')->first();
      if (empty($guard)) {
        $act->guard_name = 'N/A';
      }else{
        $act->guard_name = $guard->name;
      }
      if (empty($site)) {
        $act->site = 'N/A';
      }else{
        $act->site = $site->site_name.' ('.$site->site_description.')';
      }
      // if ($act->action == 'shift_add' || $act->action == 'shift_change' ){
      //   $act->current_data = DB::table('job_new_roster')->where('roster_id', $roster_id)->first();
      // }
    }
    $dat = isset($data[0]) ? $data[0] : $data;
    $act->act_data = $dat;
    $act->date = strtotime($act->created_at);
    $act->type = 'activity';
    unset($act->data);
  }
  return $log;
	}

	function image_to_base64($image)
{
    $img = file_get_contents($image);

        // Encode the image string data into base64
    $data = base64_encode($img);
        // Display the output
    return $data;
}

	function getHistory($from, $to, $page = 1, $limit = 15)
	{
		$config = Configuration::getDefaultConfiguration()
		->setUsername(getenv('CLICK_SEND_USERNAME'))
		->setPassword(getenv('CLICK_SEND_API_KEY'));

		$apiInstance = new SMSApi(new Client(),$config);
		$q = "opertation_report"; // string | Custom query Example: from:{number},status_code:201.
		$date_from = $from; // int | Start date
		$date_to = $to; // int | End date
		$page = $page; // int | Page number
		$limit = $limit; // int | Number of records per page

		try {
			$result = $apiInstance->smsHistoryGet($q, $date_from, $date_to, $page, $limit);
			return json_decode($result, true);
		} catch (Exception $e) {
			return false;
			// echo 'Exception when calling SMSApi->smsHistoryGet: ', $e->getMessage(), PHP_EOL;
		}
	}

	function sendSMSC()
	{
		$config = Configuration::getDefaultConfiguration()
              ->setUsername(getenv('CLICK_SEND_USERNAME'))
              ->setPassword(getenv('CLICK_SEND_API_KEY'));

$apiInstance = new SMSApi(new Client(),$config);
$msg = new \ClickSend\Model\SmsMessage();
$msg->setBody("Hi"); 
$msg->setTo("0405701993");
$msg->setSource("sdk");

// \ClickSend\Model\SmsMessageCollection | SmsMessageCollection model
$sms_messages = new \ClickSend\Model\SmsMessageCollection(); 
$sms_messages->setMessages([$msg]);

try {
    $result = $apiInstance->smsSendPost($sms_messages);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SMSApi->smsSendPost: ', $e->getMessage(), PHP_EOL;
}
	}

	function operationReport(Request $request)
	{
		$admins = DB::table('administrators')->where('id', '!=', session()->get('userId'))->where('hide_status', 0)->where('status', 'active')->select('id', 'name')->get();
		return view('operationReport', compact( 'admins'));
	}
}
