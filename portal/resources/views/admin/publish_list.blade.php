@foreach($data as $d)
<input type="checkbox" name="{{$from}}selected_list" value="{{$d->id}}" class="publish_list">
<label>{{$d->title}}</label><br>
@endforeach