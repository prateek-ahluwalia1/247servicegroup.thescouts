<!DOCTYPE html>
    <html><head>
    <style>
    .bod{
      font-size: 14px;
      line-height: 1.42857143;
      color: #333;
      background-color: #fbfbfb;
    }
    .container-fluid{
      padding-right: 15px;
      padding-left: 15px;
      margin-right: auto;
      margin-left: auto;
    }
    .title{
      font-size: 25px;
      color:#000;
    }
    td{
      padding: 5px 0px;
    }
    strong{
    font-size: 16px;
    }
    th{
      text-align:left:
    }
    .bod-1{
      border: 1px solid #000000;
      text-align: left;
    }
    </style>
    </head><body class="bod">
    <div class="container-fluid">
    <div class="row">
    <table style="width:100%;">
    <tr>
    <td>
    <div>
    <div style="text-align: center;">
    </div>
    <div style="text-align: center;" class="title">Roster Activity Report</div>
    <div style="text-align: center;" class="title">{{$details->site_name}} ({{$details->site_description}})</div>
    </div>
    </td>
    </tr>
    </table>
    <table style="width:100%;">
    <tr>
    <td>
      {{config('custom.guard')}} Name: <strong>{{$details->name}}</strong><br>
      {{config('custom.guard')}} Phone: <strong>{{$details->phone}}</strong>
    </td>
    <td>Start: <strong>{{date('d/m/Y H:i', $details->job_start)}}</strong><br>
      End: <strong>{{date('d/m/Y H:i', $details->job_end)}}</strong></td>
  </tr>
</table>
    <table style="width:100%;">
      <tr>
        <th class="bod-1">Activity</th>
        <th class="bod-1">Activity Type</th>
        <th class="bod-1">Date & Time</th>
      </tr>
      @foreach($data as $d)
      <tr>
        <td class="bod-1">{{$d->activity}}</td>
        <td class="bod-1">{{ucfirst(str_replace('_', ' ', $d->type))}}</td>
        <td class="bod-1">{{date('d/m/Y H:i', strtotime($d->created_at))}}</td>
      </tr>

      @endforeach
    </table>
  </div>
</div>
</body>
</html>
