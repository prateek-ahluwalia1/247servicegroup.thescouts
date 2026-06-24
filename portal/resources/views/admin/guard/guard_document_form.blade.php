<!-- <div class="row documents-section _index_documents">
    <div class="col-md-4 form-group">
        <label for="recipient-name" class="col-form-label">File Type</label>
        <input type="text" class="form-control form-control-md" value="" name="guard_documents[<?php echo $index; ?>][file_type]" required="">
    </div>
    <div class="col-md-4 form-group">
        <label for="recipient-name" class="col-form-label">Expiration</label>
        <input type="date" class="form-control form-control-md" value="" name="guard_documents[<?php echo $index; ?>][file_expiry]">
    </div>

    <div class="col-md-4 form-group">
        <label for="recipient-name" class="col-form-label">File
        </label>
        <input type="file" class="form-control form-control-md" name="guard_documents_image_<?php echo $index; ?>" id="guard_documents_image_<?php echo $index; ?>" onchange="upload_file('guard_documents_image_<?php echo $index; ?>', 'guard_documents_image_<?php echo $index; ?>_uploaded')">
        <input type="hidden" name="firearmLicenseFileUploaded" id="guard_documents_image_<?php echo $index; ?>_uploaded" name="guard_documents_image_<?php echo $index; ?>_uploaded">
    </div>
</div>


 -->
<div style="text-center;text-align: center; padding-top:60px padding-bottom:100px" class="row documents-section _index_documents">


    <div class="col-12 col-sm-12 col-xl ">
        <!--begin::Card-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>File</h2>
            </div>
            <!--end::Card title-->
        </div>
        <div class="card h-100 flex-center">
            <div class="removedivfromdom" style="text-align: right;position: relative;margin-right: -684px;" >
                <a class="text-danger" ><i
                        class="fas fa-times text-danger" style="font-size: 18px;" ></i></a>
            </div>
            <div class=""></div>
            <div id="doc_visaFile" class="symbol symbol-60px mb-6 form-group row " style="display: none;">
                <div class="col-sm-6" style="float:left;">
                    <a href="" style="margin-left: 123px;">
                        <img src="{{ asset('') }}media/svg/files/doc.svg" alt="">

                    </a>
                </div>
                <div class="col-sm-6" style="float:right;">

                    <a type="button" style="margin-left: 90px;margin-top: -16px;" class="btn btn-primary"
                        onclick="this.parentElement.parentElement.style.display = 'none';$('#div_visaFile').show();$('#visaFileUploaded').val('');$('#visaNumber').val('');$('#visaExpiration').val( '')">
                        X
                    </a>

                </div>





            </div>
            <div class="form-group files" id="div_visaFile">

                <input type="file" class="form-control form-control-md"
                    name="guard_documents_image_<?php echo $index; ?>" id="guard_documents_image_<?php echo $index; ?>"
                    onchange="upload_file('guard_documents_image_<?php echo $index; ?>', 'guard_documents_image_<?php echo $index; ?>_uploaded')">
                <input type="hidden" name="guard_documents[<?php echo $index; ?>][file_name]"
                    id="guard_documents_image_<?php echo $index; ?>_uploaded">

            </div>

            <div class=" form-group">
                <label for="name" class="col-form-label">File Type</label>
                <input type="text" class="form-control form-control-md" value=""
                    name="guard_documents[<?php echo $index; ?>][file_type]" required="">

                <label for="name" class="col-form-label">Expiration expiration</label>
                <input type="date" class="form-control form-control-md" value=""
                    name="guard_documents[<?php echo $index; ?>][file_expiry]">

            </div>
        </div>
    </div>
    <br>
    <br>
</div>
<br>
<br>
<br>
