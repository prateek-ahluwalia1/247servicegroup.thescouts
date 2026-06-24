<!DOCTYPE html>
<html>
<head>
	<title>Operation report</title>
</head>
<style type="text/css">

</style>
<body>
	<body class="bod">
		<div class="container-fluid">
			<div class="row">
				<header>
				<table style="width:100%; margin-bottom: 20px;">
					<tr>
						<td style="width: 50%;">
							<img src="{{$logo}}" height="100">
						</td>
						<td style="width: 50%;text-align: right;">
							<span>{{$title}}</span><br>
							<span>{{$address}}</span>
						</td>
					</tr>
				</table>
				<table style="width:100%; margin-bottom: 20px;">
					<tr>
						<td style="width: 100%; text-align: center; font-size: 18px;    margin-top: 5px;">
							<span>{{$admin->name}} Activity Log {{date('D d M', $from)}} To {{date('D d M', $to)}} {{date('Y', $from)}}</span>
						</td>
					</tr>
				</table>
				</header>
				<table style="width:100%;">
					@foreach($data as $d)
					@if(isset($d['type']) && $d['type'] == 'activity')
					<tr>
						<td style="width: 30%;position: absolute;    margin-top: 5px;">
							<span style="background-color: {{$color[$d['action']]}};width:90%; margin: 0 auto; display: inline-block; color: #fff;padding: 5px 10px; font-weight:400; position: relative;">{{strtoupper(str_replace('_', ' ', $d['action']))}}</span>
						</td>
						<td style="width: 70%; text-align: left; line-height: 1.4; padding-left: 10px;    margin-top: 5px;">
							<span>{{date('D d M, H:i', strtotime($d['created_at']))}} - {{$d['user']}}</span><br>
							<span>Activity Detail:</span><br>
							@if($d['action'] == 'shift_change' || $d['action'] == 'shift_delete' || $d['action'] == 'shift_add')
							<span>Site: {{$d['site']}}</span><br>
							<span>{{config('custom.guard')}}: {{$d['guard_name']}}</span><br>
							<span>Shift Start: {{date('m/d/Y H:i', strtotime($d['act_data']['temp_start']))}}</span><br>
							<span>Shift End: {{date('m/d/Y H:i', strtotime($d['act_data']['temp_end']))}}</span><br>
							@endif

							@if($d['action'] == 'guard_creation')
							<span>{{config('custom.guard')}}: {{$d['act_data']['name']}}</span><br>
							
							@endif

						</td>
					</tr>
					<tr>
						<td style="width: 30%;text-align: left; height: 0.3px; background: #eee;">
						</td>
						<td style="width: 70%; text-align: left;text-align: left; height: 0.3px; background: #eee;">
						</td>
					</tr>
					
					@else
					<tr>
						<td style="width: 30%;position: absolute;    margin-top: 5px;">
							<span style="background-color: {{$color['message']}};width:90%; margin: 0 auto; display: inline-block; color: #fff;padding: 5px 10px; font-weight:400;position: relative;">MESSAGE {{strtoupper($d['status'])}}</span>
						</td>
						<td style="width: 70%; text-align: left; line-height: 1.4; padding-left: 10px;">
							<span>{{date('D d M, H:i', $d['date'])}} - {{$d['to']}}</span><br>
							<span>{{$d['body']}}</span>
						</td>
					</tr>
					<tr>
						<td style="width: 30%;height: 0.3px;  background: #eee;">
						</td>
						<td style="width: 70%; text-align: left; height: 0.3px; background: #eee; margin-n">
						</td>
					</tr>
					@endif
					@endforeach
				</table>
			</div>
		</div>
	</body>
</body>
</html>