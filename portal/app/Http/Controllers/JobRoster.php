<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job_new_roster;
use DB;
use App\Exports\SigninoutReport;
use  Maatwebsite\Excel\Facades\Excel;
use App\Models\Guard;
use Carbon\Carbon;
class JobRoster extends Controller
{

 function signin_out_report($request)
 {
    if (isset($request['date'])) {
        $date = $request['date'];
        $date = explode('-', $date);
        $from = strtotime(trim($date[0]));
        $to = strtotime(trim($date[1]));
        $to = $to;
        }else{
        $to = time();
        $from = time() - (60*60*24*30);
        }
    $from = date('Y-m-d 00:00:00', $from);
    $to = date('Y-m-d 23:59:59', $to);
    $query = Job_new_roster::with(['GreenCall', 'WelfareCall', 'activity', 'Guards', 'Site'])
    ->whereBetween('temp_start', [$from, $to]);
    if (isset($request['sites'])) {
        $query->whereIn('site_id', $request['date']);
    }
    if (isset($request['customer_id'])) {
        $customer_id = explode(',', $request['customer_id']);
        $query->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id');
        $query->whereIn('jobs.customer_id', $customer_id);
    }
    $query->where('guard_id', '>', 0);
    return $query->get();
 }  
 function signinout_report()
 {
    $customers=DB::table('customers')->where('status','!=','deleted')->orderBy('name','ASC')->get();
    $type = "Signin-out";
    return view('admin/report/signinout_report',['customers'=>$customers, 'report_type' => $type]);
 } 
 public function generate_signinout_report(Request $request)
 {
    return Excel::download(new SigninoutReport, 'signinout_report.xlsx'); 
 }
 function app_status()
 {
   $data = Job_new_roster::with(['Guards', 'Site', 'activity'])
   ->where('signin_status', 1)
   ->orderBy('temp_start', 'DESC')
   ->paginate(100);
   $data->setPath('portal/app_status');
   // $data->appends(Request::except('page'));
   // dd($data);
   return view('/admin/report/app_status',['data'=> $data]);


 }
    public function testingapis(){
        $expiryDate = Carbon::now()->addDays(15)->toDateString();
        $guardDocPasport = Guard::whereDate('passport_expiration', $expiryDate)->where('status', 'active')->select('id', 'name', 'phone')->get();
        $guardDocVisa = Guard::whereDate('visa_expiration', $expiryDate)->where('status', 'active')->select('id', 'name', 'phone')->get();
        $guardSL = DB::table('guards')->select('id','name','security_license_expiration','security_license_number', 'phone')->get();
        $guardDocSL = [];
        for ($i=0; $i < count($guardSL) ; $i++) {
            if (strpos($guardSL[$i]->security_license_expiration, '/') !== false) {
                $guardSL[$i]->security_license_expiration = str_replace('/', '-', $guardSL[$i]->security_license_expiration);
                $guardSL[$i]->formated_date = date('Y-m-d', strtotime($guardSL[$i]->security_license_expiration));
            }else{
                $guardSL[$i]->formated_date = date('Y-m-d', strtotime($guardSL[$i]->security_license_expiration));
            }
            if(Carbon::parse($guardSL[$i]->formated_date)->toDateString() == $expiryDate){
                $guardDocSL[] = $guardSL[$i]; 
            }
        }
        $root = $_SERVER['HTTP_HOST'];
        $root = explode('.', $root);
        $postfix = 'staffingsolution';
        if ($root[0] != 'wwww') {
            $postfix = $root[0];
        } else {
            $postfix = $root[1];
        }
        $subject = "Guard Documents Expire in 15 days";
        // $users = DB::table('administrators')->where('is_super_admin', 1)->get();
        // foreach ($users as $key => $user) {
            $config_title = config('custom.title');
            $to = 'abdulsamad.idenbrid@gmail.com';
            // $subject = $subject;
                // $from = 'no-reply@'.$_SERVER['HTTP_HOST'];
            $from = $postfix . '@247staffingsolution.com.au';
            $logo1 = '' . config('custom.logo') . '';
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: ' . $from . "\r\n" .
            'Reply-To: ' . $from . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

            $message = 'Hello Samad ,<br><br>';
            $message .= ' <div style="padding-bottom: 30px"><h3>Security License</h3><table>
            <tr>
              <th>Name</th>
              <th>Phone</th>
            </tr>';
            foreach($guardDocSL as $guard){
                $message = $message.'<tr>
                  <td>'.$guard->name.'</td>
                  <td>'.$guard->phone.'</td>
                </tr>';
            }
            $message .= '</table></div>';
            $message .= ' <div style="padding-bottom: 30px"><h3>Passport</h3><table>
            <tr>
              <th>Name</th>
              <th>Phone</th>
            </tr>';
            foreach($guardDocPasport as $guard){
                $message = $message.'<tr>
                  <td>'.$guard->name.'</td>
                  <td>'.$guard->phone.'</td>
                </tr>';
            }
            $message .= '</table></div>';
            $message .= ' <div style="padding-bottom: 30px"><h3>Visa</h3><table>
            <tr>
              <th>Name</th>
              <th>Phone</th>
            </tr>';
            foreach($guardDocVisa as $guard){
                $message = $message.'<tr>
                  <td>'.$guard->name.'</td>
                  <td>'.$guard->phone.'</td>
                </tr>';
            }
            $message .= '</table></div>';
            $message .= '<div style="padding-bottom: 10px">Kind regards,
            <br> ' . $config_title . ' Team.
            </div></div></td></tr><tr>
            <td align="center" valign="center" style="font-size: 13px; text-align:center;padding: 20px; color: #6d6e7c;">
            <p>' . config('custom.address') . '</p>
            <p>Copyright ©
            <a href="" rel="noopener" target="_blank">' . $config_title . '</a>.</p>
            </td></tr></tbody>
            </table>
            </div>';

            // try {
                mail($to, $subject, $message, $headers);
            // } catch (Exception $e) {
            // }
        // }
    }
    public function updateGuardToActive(){
        $guardsMail = ['Abdullahhaider502@gmail.com',
            'ahmedranjha@outlook.com',
            'ahsan_tagar@hotmail.com',
            'asadjagg200@gmail.com',
            'atif_shabbir69@hotmail.com',
            'dawoodzamankhan12@gmail.com',
            'Lovemama1975@gmail.com',
            'wwarmice@gmail.com',
            'garryaus@gmail.com',
            'harinder.moudgill@gmail.com',
            'Inayatau222@outlook.com',
            'jassipreetsingh3@gmail.com',
            'Joesrecruitment@gmail.com',
            'Mr.kawallehar5@gmail.com',
            'akaalassociates@gmail.com',
            'meenakshibagga4@gmail.com',
            'saeed.hassanzada90@gmail.com',
            'Ayyanshafi3@gmail.com',
            'danishq074@gmail.com',
            'Mtbwkhan@gmail.com',
            'Saadhate6@gmail.com',
            'muhammadtalhanadeem24@gmail.com',
            'tariq.muhammad66@gmail.com',
            'kzain8349@gmail.com',
            'dawoodabdullah8048@gmail.com',
            'zh312197@gmail.com',
            'royal.dil89@gmail.com',
            'paramkang07@gmail.com',
            'vkaler46@yahoo.com',
            'poojamehra23694@gmail.com',
            'shksaad55@icloud.com',
            'sahalalikhan21@gmail.com',
            'abbaszadehshahrokh3@gmail.com',
            'syedfazalabbas58@gmail.com',
            'Syedhasaan.ali@gmail.com',
            'uzairghumman80@gmail.com',
            'vishalladani32@outlook.com',
            'waqarbutt1724@gmail.com',
            'zohaibbutt4343@gmail.com'        
        ];
        $getGuards = Guard::whereIn('email', $guardsMail)->update([
            'address' => 'sample',
            'coordinates' => '123,789',
            'city' => 'sample',
            'state' => 'sample',
            'postal_code' => '1234',
            'security_license_number' => '12345678s',
            'security_license_expiration' => '31/01/2024',
            'security_license_file' => 'abc.jpg',
            'status' => 'active',
            'is_approved' => 'yes',
        ]);
        return 'done';
    }
}
