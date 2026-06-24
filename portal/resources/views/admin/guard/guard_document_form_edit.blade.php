
    @foreach ($files as $index => $file)
    <div style="text-align:center;text-align: center; padding-bottom:55px;" class="documents-section _index_documents mt-4 mb-4"
        id="other-file-{{ $file->id }}">
        <div class="" style="text-align: right;">
            <a class="text-danger" onclick="deleteOtherFile({{ $file->id }})"><i
                    class="fas fa-trash text-danger text-danger"></i></a>
        </div>
        <div class="col-6 col-sm-12">
            <!--begin::Card-->
            <div class="card-header border-0">
                <!--begin::Card title-->
                <div class="card-title">
                    <h2>File</h2>
                </div>
                <!--end::Card title-->
            </div>
            <div class="card h-100 flex-center">
                <div id="doc_otherFile" class="symbol symbol-60px mb-6 form-group row mt-2">
                    <div class="col-sm-6" style="float:left;">
                        <a href="{{ config('custom.asset_url') . $file->file_path }}" style="margin-left: 123px;"
                            target="_blank">
                            <img style="width:87px;margin-left:44px" src="{{ asset('') }}media/svg/files/Places folder.png" alt="">

                        </a>
                    </div>
                    <div class="col-sm-6" style="float:right;position: relative;top: 34px;left: 60px;">
                        <a type="button" style="margin-left: 90px;margin-top: -16px;" class="btn btn-primary"
                            onclick="this.parentElement.parentElement.style.display = 'none'; $('#div_otherFile_{{ $index }}').show();">
                            X
                        </a>
                    </div>
                </div>
                <div class="form-group files" id="div_otherFile_{{ $index }}" style="display: none;">

                    <input type="file" class="form-control form-control-md"
                        name="guard_documents_image_<?php echo $index; ?>" id="guard_documents_image_<?php echo $index; ?>"
                        onchange="upload_file('guard_documents_image_<?php echo $index; ?>', 'guard_documents_image_<?php echo $index; ?>_uploaded')">
                    <input type="hidden" name="guard_documents[<?php echo $index; ?>][file_name]"
                        id="guard_documents_image_<?php echo $index; ?>_uploaded" value="{{ $file->file_path }}">
                    <input type="hidden" name="guard_documents[<?php echo $index; ?>][file_id]"
                        value="{{ $file->file_path }}">

                </div>

                <div class=" form-group mb-4">
                    <label for="name" class="col-form-label">File Type</label>
                    <input type="text" class="form-control form-control-md" value="{{ $file->file_type }}"
                        name="guard_documents[<?php echo $index; ?>][file_type]" required="">

                    <label for="name" class="col-form-label">Expiration expiration</label>
                    <input type="date" class="form-control form-control-md" value="{{ $file->file_expiry }}"
                        name="guard_documents[<?php echo $index; ?>][file_expiry]">

                </div>
            </div>
        </div>
    </div>
@endforeach
