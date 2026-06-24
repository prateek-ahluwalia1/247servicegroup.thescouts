public function calendarResouces(Request $request)
{
    $resources = array();
    if(session()->get('userType')!='guard'){
        if (!is_array($request->search_value)) {
            if ($request->resource_by == 'guard') {
                $resources[] = array('id' => 'a-0', 'r_id' => 0, 'title' => '<b>Shifts without '.{{ config('custom.guard') }}.'</b>');
            }
        }
    }
    if (!is_array($request->customerIds)) {
        $request->customerIds = json_decode($request->customerIds, true);
    }
    if (!is_array($request->search_value)) {
        $request->search_value = json_decode($request->search_value, true);
    }
    $start = explode('T',$request->start);
    $request->start = $start[0];
    $end = explode('T', $request->end);
    $request->end = $end[0];
    $customerIds = $request->customerIds;
        // foreach ($request->customerIds as $index => $customerId) {

    if(session()->get('userType')=='guard'){
        $request->resource_by ='guard';
        $data = DB::table('guards')
        ->where('guards.id', session()->get('userId'))
        ->where('guards.state', $request->state)
        ->select('guards.id', 'guards.name', 'guards.phone')
        ->get();

    }
    else{

        if ($request->resource_by == 'guard') {
           $query = DB::table('guards')
           ->join('jobs_guards', 'jobs_guards.guard_id', '=', 'guards.id')
           ->join('jobs', 'jobs.id' , '=', 'jobs_guards.job_id');
           // ->join('job_new_roster', 'job_new_roster.guard_id', '=', 'guards.id')
           // commnetd by mohsin 
           // $query->where('jobs.customer_id', $customerId);
           $query->where(function ($query) use($customerIds){
            $i = 0;
            foreach ($customerIds as $key => $customerId) {
                if ($i = 0) {
                    $query->where('jobs.customer_id', $customerId);
                }else{
                    $query->orWhere('jobs.customer_id', $customerId);
                }
                $i++;
            }

        });
           // ->where('job_new_roster.temp_start', '>=', $request->start)
           // ->where('job_new_roster.temp_start', '<=', $request->end)
           $query->where('jobs.status', 'active')->where('jobs.state', $request->state);
        //    ->where('jobs.state', $request->state);
           if ($request->has('search_value') && $request->search_value != 'undefined' && !empty($request->search_value)) {
            $search_value = $request->search_value;
            

            $query->where(function ($query1) use ($search_value){
                $i = 0;
                foreach ($search_value as $key => $index) {
                    if ($i == 0) {
                        $query1->where('jobs_guards.guard_id', $index);
                    }else{
                        $query1->orWhere('jobs_guards.guard_id', $index);
                    }
                    $i++;
                }
            });
        }
           // ->where('jobs.state', $request->state);
        //    if ($request->has('search_value') && $request->search_value != 'undefined' && !empty($request->search_value)) {
        //     $search_value = (object)$request->search_value;
            // foreach($search_value as $search_val){
            //          $query->where(function ($query1) use($search_val){
            //         $query1->orwhere('jobs.id',$search_val);
            //  });
            // // $query1->orwhere('jobs.id',$search_val);
            // }
        //    }
        $data = $query->select('guards.id', 'guards.name','guards.phone', 'guards.fortnightly_working_hours')
        ->orderBy('guards.name', 'ASC')
        ->groupBy('guards.id')
        ->get();


    }else{
        $query =  DB::table('jobs')
            // commented by mohsin
            // ->where('customer_id', $customerId)
        ->where(function ($query) use($customerIds){
            $i = 0;
            foreach ($customerIds as $key => $customerId) {
                if ($i = 0) {
                    $query->where('customer_id', $customerId);
                }else{
                    $query->orWhere('customer_id', $customerId);
                }
                $i++;
            }

        })
        ->select('id', 'site_name', 'site_description')->where('status', 'active')->where('jobs.state', $request->state);

        if ($request->has('search_value') && $request->search_value != 'undefined' && !empty($request->search_value)) {
            $search_value = $request->search_value;


            $query->where(function ($query1) use ($search_value){
                $i = 0;
                foreach ($search_value as $key => $index) {
                    if ($i == 0) {
                        $query1->where('jobs.id', $index);
                    }else{
                        $query1->orWhere('jobs.id', $index);
                    }
                    $i++;
                }
            });
                // $search_value =(object)$request->search_value;
                // return $search_value;
                // exit();
                //   foreach($search_value as $search_val){
                // // $query->where('name','LIKE','%'.$search_val.'%');
                //     $query->where('id',$search_val);
                // }
                 // foreach($search_value as $search_val){
                     // $query->where(function ($query1) use($search_val){
                        // $query1->orwhere('id',$search_val);
             // });
            // }
                // $query->where(function ($query1) use($search_value){
                // $query1->where('site_name','LIKE','%'.$search_value.'%');
                // $query1->orWhere('site_description','LIKE','%'.$search_value.'%');
            //  });
        }elseif (session()->has('specific_sites') && session()->get('specific_sites') != '') {
            $specific_sites = json_decode(session()->get('specific_sites'));
            $query->where(function($query1)  use($specific_sites){
                foreach ($specific_sites as $key => $id) {
                    if ($key == 0) {
                        $query1->where('jobs.id', $id);
                    }else{
                        $query1->orWhere('jobs.id', $id);
                    }
                }
            });
        }
        $data = $query->orderBy('site_name', 'ASC')->get();
    }
}
$permissions = array();
$is_super_admin = 0;
if (session()->has('permissions')) {
    $permissions = json_decode(session()->get('permissions'), true);
}
if (session()->has('isAdmin')) {
    $is_super_admin = session()->get('isAdmin');
}

foreach ($data as $key => $value) {
    $site_edit_delete = '';       
    if($request->resource_by == 'guard' && $value->fortnightly_working_hours > 0 ){
                // $value->fortnightly_working_hours = $value->fortnightly_working_hours / 2;
        $roster_data = DB::table('job_new_roster')->where('temp_start', '>=', $request->start)->where('temp_start', '<=', $request->end)->where('guard_id', $value->id)->get();
        $hours = 0;
        foreach ($roster_data as $r) {
         $time = $this->getTimeDiff($r->temp_start, $r->temp_end);
         $hours += $time['hours'];
     }
     $total_hours = explode('.', $hours);
     if (sizeof($total_hours) > 1 ) {
         $partial = '.'.$total_hours[1];
         if ($partial < 0.1) {
           $hours = $total_hours[0];
       }
       if ($partial < 0.27 && $partial > 0.1) {
           $hours = $total_hours[0].'.25';
       }
       if ($partial > 0.27 && $partial < 0.52) {
           $hours = $total_hours[0].'.5';
       }
       if ($partial > 0.52 && $partial < 0.77) {
           $hours = $total_hours[0].'.75';
       }
       if ($partial > 0.77 && $partial < 1) {
           $hours = $total_hours[0]+ 1;
       }
   }
   $value->fortnightly_working_hours = $value->fortnightly_working_hours.'-'.$hours.' = '.($value->fortnightly_working_hours - $hours);
}
$resourceId = '';
if ($request->resource_by == 'guard') {
    $resourceId = str_replace(' ', '-', $value->name);
}else{
    $resourceId = str_replace(' ', '-', $value->site_name);
}
if ($request->has('filter') && $request->filter != '' && $request->filter != 'all') {
    if ($request->filter == 'active') {
        if ($request->resource_by == 'guard') {
            $roster_data = DB::table('job_new_roster')
            ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')->where('job_new_roster.temp_start', '>=', $request->start)->where('job_new_roster.temp_start', '<=', $request->end)->where('job_new_roster.guard_id', $value->id)
                    // ->where('jobs.customer_id', $customerId)
            ->where(function ($query) use($customerIds){
                $i = 0;
                foreach ($customerIds as $key => $customerId) {
                    if ($i = 0) {
                        $query->where('jobs.customer_id', $customerId);
                    }else{
                        $query->orWhere('jobs.customer_id', $customerId);
                    }
                    $i++;
                }

            })
            ->orderBy('job_new_roster.roster_id', 'desc')
            ->first();
        }else{
            $roster_data = DB::table('job_new_roster')->where('temp_start', '>=', $request->start)->where('temp_start', '<=', $request->end)->where('site_id', $value->id)
            ->orderBy('job_new_roster.roster_id', 'desc')
            ->first();
        }
        if (!empty($roster_data)) {
            if ($is_super_admin == 1 || (isset($permissions['site_edit_delete']) && $permissions['site_edit_delete'] == true)) {
                $site_edit_delete = '<span class="siteBtn" style="display: inline-block;"><i class="fas fa-edit m-1" onclick="editSite('.$value->id.')"></i><i onclick="deleteSite('.$value->id.')" class="fas fa-trash"></i><div class="dropdown m-1" style="display:inline-block;" onclick="selectSite(\''.$resourceId.'-'.$value->id.'\', '.$value->id.')"><span id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></span></div></span>';
            }else{
                $site_edit_delete = '';
            }
            $resources[] = array(
                'id' => $resourceId.'-'.$value->id,
                'r_id' => $value->id,
                'title' => ($request->resource_by == 'guard') ? $value->name.'<br>'.$value->phone.'<br>'.$value->fortnightly_working_hours.'<br>'.('<span class="siteBtn" style="display: inline-block;"><div class="dropdown m-1" style="display:inline-block;" onclick="selectGuard(\''.$resourceId.'-'.$value->id.'\', '.$value->id.')"><span id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></span></div></span>') : ('<span style="display: inline-block;">'.$value->site_name .' <br>('.$value->site_description.')</span>'.$site_edit_delete));
        }

    }elseif($request->filter == 'inactive'){
        if ($request->resource_by == 'guard') {
            $roster_data = DB::table('job_new_roster')->where('temp_start', '>=', $request->start)->where('temp_start', '<=', $request->end)->where('guard_id', $value->id)->first();
        }else{
            $roster_data = DB::table('job_new_roster')->where('temp_start', '>=', $request->start)->where('temp_start', '<=', $request->end)->where('site_id', $value->id)->first();
        }
        if (empty($roster_data)) {
            if ($is_super_admin == 1 || (isset($permissions['site_edit_delete']) && $permissions['site_edit_delete'] == true)) {
                $site_edit_delete = '<span class="siteBtn" style="display: inline-block;"><i class="fas fa-edit m-1" onclick="editSite('.$value->id.')"></i><i onclick="deleteSite('.$value->id.')" class="fas fa-trash"></i><div class="dropdown m-1" style="display:inline-block;" onclick="selectSite(\''.$resourceId.'-'.$value->id.'\', '.$value->id.')"><span id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></span></div></span>';
            }else{
                $site_edit_delete = '';
            }
            $resources[] = array(
                'id' => $resourceId.'-'.$value->id,
                'r_id' => $value->id,
                'title' => ($request->resource_by == 'guard') ? $value->name.'<br>'.$value->phone.'<br>'.$value->fortnightly_working_hours.'<br>'.('<span class="siteBtn" style="display: inline-block;"><div class="dropdown m-1" style="display:inline-block;" onclick="selectGuard(\''.$resourceId.'-'.$value->id.'\', '.$value->id.')"><span id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></span></div></span>') : ('<span style="display: inline-block;">'.$value->site_name .' <br>('.$value->site_description.')</span>'.$site_edit_delete));
        }
    }else{
        if ($is_super_admin == 1 || (isset($permissions['site_edit_delete']) && $permissions['site_edit_delete'] == true)) {
            $site_edit_delete = '<span class="siteBtn" style="display: inline-block;"><i class="fas fa-edit m-1" onclick="editSite('.$value->id.')"></i><i onclick="deleteSite('.$value->id.')" class="fas fa-trash"></i><div class="dropdown m-1" style="display:inline-block;" onclick="selectSite(\''.$resourceId.'-'.$value->id.'\', '.$value->id.')"><span id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></span></div></span>';
        }else{
            $site_edit_delete = '';
        }
        $resources[] = array(
            'r_id' => $value->id,
            'id' => $resourceId.'-'.$value->id,
            'title' => ($request->resource_by == 'guard') ? $value->name.'<br>'.$value->phone.'<br>'.$value->fortnightly_working_hours.'<br>'.('<span class="siteBtn" style="display: inline-block;"><div class="dropdown m-1" style="display:inline-block;" onclick="selectGuard(\''.$resourceId.'-'.$value->id.'\', '.$value->id.')"><span id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></span></div></span>') : ('<span style="display: inline-block;">'.$value->site_name .' <br>('.$value->site_description.')</span>'.$site_edit_delete));
    }
}else{
    if ($is_super_admin == 1 || (isset($permissions['site_edit_delete']) && $permissions['site_edit_delete'] == true)) {
        $site_edit_delete = '<span class="siteBtn" style="display: inline-block;"><i class="fas fa-edit m-1" onclick="editSite('.$value->id.')"></i><i onclick="deleteSite('.$value->id.')" class="fas fa-trash"></i><div class="dropdown m-1" style="display:inline-block;" onclick="selectSite(\''.$resourceId.'-'.$value->id.'\', '.$value->id.')"><span id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></span></div></span>';
    }else{
        $site_edit_delete = '';
    }
    $resources[] = array(
        'r_id' => $value->id,
        'id' => $resourceId.'-'.$value->id,
        'title' => ($request->resource_by == 'guard') ? $value->name.'<br>'.$value->phone.'<br>'.$value->fortnightly_working_hours.'<br>'.('<span class="siteBtn" style="display: inline-block;"><div class="dropdown m-1" style="display:inline-block;" onclick="selectGuard(\''.$resourceId.'-'.$value->id.'\', '.$value->id.')"><span id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></span></div></span>') : ('<span style="display: inline-block;">'.$value->site_name .' <br>('.$value->site_description.')</span>'.$site_edit_delete));
}
}