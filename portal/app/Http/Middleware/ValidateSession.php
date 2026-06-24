<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ValidateSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('userType') && $request->session()->get('userType') == 'admin') {
            $permissions = DB::table('acces_level_defination')->join('administrators', 'administrators.access_level_id', '=', 'acces_level_defination.id')->select('acces_level_defination.permissions','administrators.specific_customer', 'administrators.specific_sites')->where('administrators.id', session()->get('userId'))->first();
            $colors = '';
            $colr = DB::table('portal_settings')->where('permission_name', 'portal_colors')->first();
              if (!empty($colr)) {
                $colors = $colr->users_emails;
              }
            // print_r('<pre>');
            // print_r($permissions);
            // exit();
           session([
            'permissions' => $permissions->permissions,
            'specific_customer' => $permissions->specific_customer,
            'specific_sites' => $permissions->specific_sites,
            'colors' => $colors,
            // 'own_payrates' 
            ]);
            return $next($request);
        }
        if ($request->session()->has('userType') && $request->session()->get('userType') == 'customer') {
            return $next($request);
        }
        
        return $next($request);
            // return redirect('/');
    }
}
