@section('timesheet')


        <div class="table-responsive">
            <table  id="example" class="table table-responsive table-hover   gy-5 gs-7" style="width:100%">
            <thead>
                <tr class="fw-bold ">
                    <th class="min-w-">State Name</th>
                    <th class="min-w-">Published Location Name</th>
                    <th class="min-w-">Staff Name</th>
                    <th class="min-w-">Stafff Type</th>
                    <th class="min-w-">Customer</th>
                    <th class="min-w-">Authorized Start Date</th>
                    <th class="min-w-">Authorized Start Time</th>
                    <th class="min-w-">Authorized Finish Time</th>
                    <th class="min-w-">Schedule Start Time</th>
                    <th class="min-w-">Schedule Finish Time</th>
                    <th class="min-w-">Authorized Total Hours</th>
                </tr>
            </thead>
            <tbody id="example_body"> </tbody>
        </table>
    </div> {{-- cards --}}
@stop