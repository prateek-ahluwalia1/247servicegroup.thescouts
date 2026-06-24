<div class="padding" style="padding: 10px;">
    <h2 style="text-align: center;">Audit Form Report</h2>
    <div class="site"
        style="background-color: black; text-align: center; border-radius: 10px; height: 40px; padding-top: 5px;">
        <h4 class="siteDetails" style="color: white; margin-top: 10px;">{{$data->site_name}}</h4>
    </div>

    <div style="text-align: right; margin-top: -10px;">
        <p>Date: {{$data->created_at}}</p>
    </div>
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%; text-align: left;">
                <h4 style="margin: 0;">Site Name:</h4>
            </td>
            <td style="width: 50%; text-align: right;">
                <p style="margin: 0;">{{$data->site_name}}</p>
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left;">
                <h4 style="margin: 0;">Audit By:</h4>
            </td>
            <td style="width: 50%; text-align: right;">
                <p style="margin: 0;">{{$data->audit_by}}</p>
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left;">
                <h4 style="margin: 0;">Name of Guards:</h4>
            </td>
            <td style="width: 50%; text-align: right;">
                <p style="margin: 0;">{{$data->guard_name}}</p>
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left;">
                <h4 style="margin: 0;">Contact Details:</h4>
            </td>
            <td style="width: 50%; text-align: right;">
                <p style="margin: 0;">{{$data->guard_phone}}</p>
            </td>
        </tr>
    </table>

    <!-- <table style="width: 100%; margin-top: 10px;">
        <tr>
            <td style="width: 50%; text-align: left;">
                <h4 style="margin: 0;">Name of Guards:</h4>
            </td>
            <td style="width: 50%; text-align: right;">
                <p style="margin: 0;">{{$data->guard_name}}</p>
            </td>
        </tr>
    </table>
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%; text-align: left;">
                <h4 style="margin: 0;">Contact Details:</h4>
            </td>
            <td style="width: 50%; text-align: right;">
                <p style="margin: 0;">{{$data->guard_phone}}</p>
            </td>
        </tr>
    </table> -->


    <div>
        <div>
            <table class="table-row" style="background-color: black; width: 100%; border-collapse: collapse;">
                <tr class="row-height" style="height: 40px;background-color: black; ">
                    <th class="header-cell-left" style="text-align: left; color: white;padding-left:10px;">Questions
                    </th>
                    <th class="header-cell-right" style="color: white; margin-right: 20px;">Status</th>
                </tr>
                <tr class="row-width" style="background-color: white;">
                    <td class="no-center-border"
                        style="position: relative; border: 1px solid black; padding-left: 10px;">
                        <h4 style="text-align: left; margin-bottom: 10px;">Staff is wearing the right uniform?</h4>
                        <strong>
                            <p class="left-align" style="margin: 0;">Comments</p>
                        </strong>
                        <p style="margin-top: 0; margin-bottom: 0;">{{ $data->uniform_text ?? 'N/A' }}</p>
                    </td>
                    <td class="img" style="text-align: center; border: 1px solid black;">
                        <span class="text" style="display: block; margin-bottom: 10px;">{{ $data->have_uniform }}</span>
                        <img src="{{ $data->uniform_image }}" class="img-style"
                            style="width: 100px; height: 100px;">
                    </td>
                </tr>


                <tr class="row-width" style="background-color: white;">
                    <td class="no-center-border" style="position: relative; border: 1px solid black;padding-left:10px;">
                        <h4 style="text-align: left; margin-bottom: 10px;">Staff has their security license on them?
                        </h4>
                        <strong>
                            <p class="left-align" style="margin: 0;">Comments</p>
                        </strong>
                        <p style="margin-top: 0; margin-bottom: 0;">{{ $data->license_text ?? 'N/A' }}</p>
                    </td>
                    <td class="img" style="text-align: center; border: 1px solid black;">
                        <span class="text" style="display: block; margin-bottom: 10px;">{{ $data->have_license }}</span>
                        <img src="{{ $data->license_image }}" class="img-style"
                            style="width: 100px; height: 100px; margin-top: 0;">
                    </td>
                </tr>

                <tr class="row-width" style="background-color: white;">
                    <td class="no-center-border" style="position: relative; border: 1px solid black;padding-left:10px;">
                        <h4 style="text-align: left; margin-bottom: 10px;">Staff has their Induction card on them?</h4>
                        <strong>
                            <p class="left-align" style="margin: 0;">Comments</p>
                        </strong>
                        <p style="margin-top: 0; margin-bottom: 0;">{{ $data->license_text ?? 'N/A' }}</p>
                    </td>
                    <td class="img" style="text-align: center; border: 1px solid black;">
                        <span class="text" style="display: block; margin-bottom: 10px;">{{ $data->have_license }}</span>
                        <img src="{{ $data->induction_card_image }}" class="img-style"
                            style="width: 100px; height: 100px; margin-top: 0;">
                    </td>
                </tr>

                <tr class="row-width" style="background-color: white;">
                    <td class="no-center-border" style="position: relative; border: 1px solid black;padding-left:10px;">
                        <h4 style="text-align: left; margin-bottom: 10px;">Staff has access to stationary items?</h4>
                        <strong>
                            <p class="left-align" style="margin: 0;">Comments</p>
                        </strong>
                        <p style="margin-top: 0; margin-bottom: 0;">{{ $data->notebook_pen_text ?? 'N/A' }}</p>
                    </td>
                    <td class="img" style="text-align: center; border: 1px solid black;">
                        <span class="text"
                            style="display: block; margin-bottom: 10px;">{{ $data->have_notebook_pen }}</span>
                        <img src="{{ $data->notebook_pen_image }}" class="img-style"
                            style="width: 100px; height: 100px; margin-top: 0;">
                    </td>

                </tr>

                <tr class="row-width" style="background-color: white">
                    <td class="no-center-border" style="position: relative; border: 1px solid black;padding-left:10px;">
                        <h4 style="text-align: left; margin-bottom: 10px;">Staff has Signed-in on time on the app?</h4>
                        <strong>
                            <p class="left-align" style="margin: 0;">Comments</p>
                        </strong>
                        <p style="margin-top: 0; margin-bottom: 0;">{{ $data->on_time_text ?? 'N/A' }}</p>
                    </td>
                    <td class="img" style="text-align: center; border: 1px solid black;">
                        <span class="text" style="display: block; margin-bottom: 10px;">{{ $data->on_time }}</span>
                        <img src="{{ $data->on_time_image }}" class="img-style"
                            style="width: 100px; height: 100px; margin-top: 0;">
                    </td>
                    </td>

                </tr>

                <tr class="row-width" style="background-color: white;">
                    <td class="no-center-border" style="position: relative; border: 1px solid black;padding-left:10px;">
                        <h4 style="text-align: left; margin-bottom: 10px;">Staff is on-site?</h4>
                        <strong>
                            <p class="left-align" style="margin: 0;">Comments</p>
                        </strong>
                        <p style="margin-top: 0; margin-bottom: 0;">{{$data->on_site_text ?? 'N/A'}}</p>
                    </td>
                    <td class="img" style="text-align: center; border: 1px solid black ;padding-left:10px;">
                        <span class="text" style="display: block; margin-bottom: 10px;">{{$data->have_on_site}}</span>
                        <img src="{{ $data->on_site_image }}" class="img-style"
                            style="width: 100px; height: 100px; margin-top: 0;">
                    </td>
                </tr>

                <tr class="row-width" style="background-color: white;">
                    <td class="no-center-border" style="position: relative; border: 1px solid black;padding-left:10px;">
                        <h4 style="text-align: left; margin-bottom: 10px;">Staff is well groomed (according to job
                            requirement)?</h4>
                        <strong>
                            <p class="left-align" style="margin: 0;">Comments</p>
                        </strong>
                        <p style="margin-top: 0; margin-bottom: 0;">{{ $data->well_groomed_text ?? 'N/A' }}</p>
                    </td>
                    <td class="img" style="text-align: center; border: 1px solid black;">
                        <span class="text" style="display: block; margin-bottom: 10px;">{{ $data->have_well_groomed }}</span>
                        <img src="{{ $data->well_groomed_image }}" class="img-style"
                            style="width: 100px; height: 100px; margin-top: 0;">
                    </td>
                </tr>

                <tr class="row-width" style="background-color: white;">
                    <td class="no-center-border" style="position: relative; border: 1px solid black;padding-left:10px;">
                        <h4 style="text-align: left; margin-bottom: 10px;">Staff has access to Site equipment?</h4>
                        <strong>
                            <p class="left-align" style="margin: 0;">Comments</p>
                        </strong>
                        <p style="margin-top: 0; margin-bottom: 0;">{{ $data->site_eqipment_text ?? 'N/A' }}</p>
                    </td>
                    <td class="img" style="text-align: center; border: 1px solid black;">
                        <span class="text"
                            style="display: block; margin-bottom: 10px;">{{ $data->have_site_eqipment }}</span>
                        <img src="{{ $data->site_eqipment_image }}" class="img-style"
                            style="width: 100px; height: 100px; margin-top: 0;">
                    </td>

                </tr>

                <tr class="row-width" style="background-color: white;">
                    <td class="no-center-border" style="position: relative; border: 1px solid black;padding-left:10px;">

                        <h4 style="text-align: left; margin-bottom: 10px;">Staff has Working with Children Check on
                            them?</h4>
                        <strong>
                            <p class="left-align" style="margin: 0;">Comments</p>
                        </strong>
                        <p style="margin-top: 0; margin-bottom: 0;">{{ $data->children_check_text ?? 'N/A' }}</p>
                    </td>
                    <td class="img" style="text-align: center; border: 1px solid black;">
                        <span class="text"
                            style="display: block; margin-bottom: 10px;">{{ $data->have_children_check }}</span>
                        <img src="{{ $data->children_check_image }}" class="img-style"
                            style="width: 100px; height: 100px; margin-top: 0;">
                </tr>





                <tr class="row-width" style="background-color: white">
                    <td class="no-center-border" style="position: relative; border: 1px solid black;padding-left:10px;">

                        <h4 style="text-align: left; margin-bottom: 10px;">Staff has White Card on them?</h4>
                        <strong>
                            <p class="left-align" style="margin: 0;">Comments</p>
                        </strong>
                        <p style="margin-top: 0; margin-bottom: 0;">{{ $data->white_card_text ?? 'N/A' }}</p>
                    </td>
                    <td class="img" style="text-align: center; border: 1px solid black;">
                        <span class="text"
                            style="display: block; margin-bottom: 10px;">{{ $data->have_white_card }}</span>
                        <img src="{{ $data->white_card_image }}" class="img-style"
                            style="width: 100px; height: 100px; margin-top: 0;">
                    </td>
                </tr>




                <tr class="row-width" style="background-color: white;">
                    <td class="no-center-border" style="position: relative; border: 1px solid black;padding-left:10px;">
                        <h4 style="text-align: left; margin-bottom: 10px;">Staff has RSA certificate on them?</h4>
                        <strong>
                            <p class="left-align" style="margin: 0;">Comments</p>
                        </strong>
                        <p style="margin-top: 0; margin-bottom: 0;">{{ $data->rsa_certificate_text ?? 'N/A' }}</p>
                    </td>
                    <td class="img" style="text-align: center; border: 1px solid black;">
                        <span class="text"
                            style="display: block; margin-bottom: 10px;">{{ $data->have_rsa_certificate }}</span>
                        <img src="{{ $data->rsa_certificate_image }}" class="img-style"
                            style="width: 100px; height: 100px; margin-top: 0;">
                    </td>
                </tr>




                <tr class="row-width" style="background-color: white;">
                    <td class="no-center-border" style="position: relative; border: 1px solid black;padding-left:10px;">

                        <h4 style="text-align: left; margin-bottom: 10px;">Staff has done regular Patrols of assigned
                            areas?</h4>
                        <strong>
                            <p class="left-align" style="margin: 0;">Comments</p>
                        </strong>
                        <p style="margin-top: 0; margin-bottom: 0;">{{ $data->assigned_petrol_text ?? 'N/A' }}</p>
                    </td>
                    <td class="img" style="text-align: center; border: 1px solid black;">
                        <span class="text"
                            style="display: block; margin-bottom: 10px;">{{ $data->have_assigned_petrol }}</span>
                        <img src="{{ $data->assigned_petrol_image }}" class="img-style"
                            style="width: 100px; height: 100px; margin-top: 0;">
                    </td>
                </tr>




                <tr class="row-width" style="background-color: white;">
                    <td class="no-center-border" style="position: relative; border: 1px solid black;padding-left:10px;">
                        <h4 style="text-align: left; margin-bottom: 10px;">Staff has knowledge of Site,i.e, doors,
                            windows, all entry points?</h4>
                        <strong>
                            <p class="left-align" style="margin: 0;">Comments</p>
                        </strong>
                        <p style="margin-top: 0; margin-bottom: 0;">{{ $data->site_knowledge_text ?? 'N/A' }}</p>
                    </td>
                    <td class="img" style="text-align: center; border: 1px solid black;padding-left:10px;">
                        <span class="text"
                            style="display: block; margin-bottom: 10px;">{{ $data->have_site_knowledge }}</span>
                        <img src="{{ $data->site_knowledge_image }}" class="img-style"
                            style="width: 100px; height: 100px; margin-top: 0;">
                </tr>




                <tr class="row-width" style="background-color: white;">
                    <td class="no-center-border" style="position: relative; border: 1px solid black;padding-left:10px;">
                        <h4 style="text-align: left; margin-bottom: 10px;">Staff has knowledge of First aid procedures
                            and knows the whereabouts of the first aid kit.?</h4>
                        <strong>
                            <p class="left-align" style="margin: 0;">Comments</p>
                        </strong>
                        <p style="margin-top: 0; margin-bottom: 0;">{{ $data->firstaid_text ?? 'N/A' }}</p>
                    </td>
                    <td class="img" style="text-align: center; border: 1px solid black;padding-left:10px; ">
                        <span class="text"
                            style="display: block; margin-bottom: 10px;">{{ $data->have_firstaid }}</span>
                        <img src="{{ $data->firstaid_image }}" class="img-style"
                            style="width: 100px; height: 100px; margin-top: 0;">
                    </td>
                </tr>




                <tr class="row-width" style="background-color: white;">
                    <td class="no-center-border" style="position: relative; border: 1px solid black;padding-left:10px;">
                        <h4 style="text-align: left; margin-bottom: 10px;">Staff has the Know-how of Emergency protocols
                            ,i.e , Police, Fire brigade, Ambulancet?</h4>
                        <strong>
                            <p class="left-align" style="margin: 0;">Comments</p>
                        </strong>
                        <p style="margin-top: 0; margin-bottom: 0;">{{ $data->emergency_protocol_text ?? 'N/A' }}</p>
                    </td>
                    <td class="img" style="text-align: center; border: 1px solid black;">
                        <span class="text"
                            style="display: block; margin-bottom: 10px;">{{ $data->have_emergency_protocol }} </span>
                        <img src="{{ $data->emergency_protocol_image }}" class="img-style"
                            style="width: 100px; height: 100px; margin-top: 0;">
                    </td>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <table style="width: 100%;">
        <tr>
            <td style="padding: 10px;">
                <h4 style="text-align: left; margin: 0;font-size: 19px;">Audit Notes</h4>
                <p style="margin: 10px 0px;">{{ $data->notes ?? 'N/A' }}</p>
            </td>


        </tr>
        <tr>
            <td style="padding: 10px;">
                <h4 style="text-align: left; margin-right: 10px; display: inline;">Signature:</h4>
                <img src="{{ $data->signature }}" class="img-style"
                    style="width: 100px; height: 100px; margin-top: 0; float: right;">

                <!-- <td style="padding: 0px; text-align: right;">
            <img src="{{ $data->signature }}"  class="img-style" style="width: 100px; height: 100px; margin-top: 0; float: right;">
          </td> -->
        </tr>
    </table>
</div>