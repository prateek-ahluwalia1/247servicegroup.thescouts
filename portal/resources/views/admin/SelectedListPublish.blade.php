@foreach($data as $d)
<tr>
	<td><input type="checkbox" name="publish_selected_ids" value="{{$d->id}}" checked=""></td>
	<td>{{$d->title}}</td>
	<td><div class="output"><i  class="fa fa-thumbs-up"></i></div></td>
	<td><div class="output1"><i  class="fa fa-thumbs-up"></i></div></td>
</tr>
@endforeach