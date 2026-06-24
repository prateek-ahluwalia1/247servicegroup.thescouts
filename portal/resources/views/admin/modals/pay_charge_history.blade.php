<div class="container-fluid">
										<div id="other-table" style="overflow-x: auto; max-width: 100%;">
											<table id="example" class="table table-responsive table-striped table-bordered" >
												<thead style="background-color: white; padding: 10px;" >
													<tr>
														<th>ID</th>
														<th >Name</th>
														<th >Apply From</th>
														<th >Apply To</th>
														<th >Changed By</th>
														<th >Updated At</th>
													</tr>
												</thead>
												<tbody id="example_body">

													@foreach($history as $key => $h)
														<tr>
															<td>{{$key+1}}</td>
															<td>{{$h->title}}</td>
															<td>{{date('d/m/Y', $h->apply_date)}}</td>
															<td>{{(isset($history[$key]) && isset($history[$key]->apply_to_date) > 0) ? date('d/m/Y', (int)$history[$key]->apply_to_date) : 'Till today'}}</td>
															<td>{{$h->name}}</td>
															<td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $history[$key]->updated_at)->format('d-m-Y')}}</td>
														</tr>
													@endforeach
												</tbody>

											</table>
										</div>
									</div>