<?php

namespace App\Console\Commands;

use App\Models\Guard;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GuardExpiryDoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'guard:expiry-document';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mail to admin with all info of guard whos document going to expire after 15 day exectly';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $config_dbs = DB::connection('mysql2')->table('business_data')->where('show_status', 1)->get();
        foreach($config_dbs as $db)
        {
            $connectionConfig['driver'] = 'mysql';
            $connectionConfig['host'] = env('DB_HOST');
            $connectionConfig['database'] = $db->database_name;
            $connectionConfig['username'] = env('DB_USERNAME');
            $connectionConfig['password'] = env('DB_PASSWORD');
            $newConnection = 'mysql';
            config(['database.connections.' . $newConnection => $connectionConfig]);
            $dynamicDbConnection = DB::connection($newConnection);
        
            $expiryDate = Carbon::now()->addDays(15)->toDateString();
            $guardDocPasport = Guard::whereDate('passport_expiration', $expiryDate)->where('status', 'active')->select('id', 'name', 'phone')->get();
            $guardDocVisa = Guard::whereDate('visa_expiration', $expiryDate)->where('status', 'active')->select('id', 'name', 'phone')->get();
            $guardSL = $dynamicDbConnection->table('guards')->select('id','name','security_license_expiration','security_license_number', 'phone')->get();
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
            // $root = $_SERVER['HTTP_HOST'];
            // $root = explode('.', $root);
            // $postfix = 'staffingsolution';
            // if ($root[0] != 'wwww') {
            //     $postfix = $root[0];
            // } else {
            //     $postfix = $root[1];
            // }
            $subject = "Guard Documents Expire in 15 days";
            $excludeAdmin = ['accounts@247securitygroup.com.au', 'moizalig16@gmail.com', 'operations@eliteguards.com.au', 'accounts.vic@vcpgsecurity.com.au'];
            $users = $dynamicDbConnection->table('administrators')->where('is_super_admin', 1)->whereNotIn('email', $excludeAdmin)->get();
            foreach ($users as $key => $user) {
                $config_title = config('custom.title');
                $to = $user->email;
                // $subject = $subject;
                    // $from = 'no-reply@'.$_SERVER['HTTP_HOST'];
                $from = $db->domain . '@247staffingsolution.com.au';
                $logo1 = '' . config('custom.logo') . '';
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: ' . $from . "\r\n" .
                'Reply-To: ' . $from . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
    
                $message = 'Hello '.$user->name.',<br><br>';
                $message .= '<p>Here is list of all guard which is going to expire in 15 days</p>';
                
                $message .= ' <div style="padding-bottom: 30px"><h3>Security License</h3><table>
                <tr>
                  <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">Name</th>
                  <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">Phone</th>
                </tr>';
                if(count($guardDocSL) > 0){
                    foreach($guardDocSL as $guard){
                        $message = $message.'<tr>
                          <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">'.$guard->name.'</td>
                          <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">'.$guard->phone.'</td>
                        </tr>';
                    }
                }else{
                    $message = $message.'<tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;" colspan="2">No Data Available</td></tr>';
                }
                $message .= '</table></div>';
                $message .= ' <div style="padding-bottom: 30px"><h3>Passport</h3><table>
                <tr>
                  <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">Name</th>
                  <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">Phone</th>
                </tr>';
                if(count($guardDocPasport) > 0){
                    foreach($guardDocPasport as $guard){
                        $message = $message.'<tr>
                          <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">'.$guard->name.'</td>
                          <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">'.$guard->phone.'</td>
                        </tr>';
                    }
                }else{
                    $message = $message.'<tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;" colspan="2">No Data Available</td></tr>';
                }
                $message .= '</table></div>';
                $message .= ' <div style="padding-bottom: 30px"><h3>Visa</h3><table>
                <tr>
                  <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">Name</th>
                  <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">Phone</th>
                </tr>';
                if(count($guardDocVisa) > 0){
                    foreach($guardDocVisa as $guard){
                        $message = $message.'<tr>
                          <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">'.$guard->name.'</td>
                          <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">'.$guard->phone.'</td>
                        </tr>';
                    }
                }else{
                    $message = $message.'<tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;" colspan="2">No Data Available</td></tr>';
                }
                $message .= '</table></div>';
                $message .= '<div style="padding-bottom: 10px">Kind regards,
                <br>  Team.
                </div></div></td></tr><tr>
                <td align="center" valign="center" style="font-size: 13px; text-align:center;padding: 20px; color: #6d6e7c;">
                <p>' . config('custom.address') . '</p>
                <p>Copyright ©
                <a href="" rel="noopener" target="_blank">' . $config_title . '</a>.</p>
                </td></tr></tbody>
                </table>
                </div>';
                mail($to, $subject, $message, $headers);
                // return 'mail sent';
            }
            DB::disconnect($newConnection);
        }
    }
}
