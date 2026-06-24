<form class="form add-files" action="{{url('add_about_us_file')}}" method="POST" enctype="multipart/form-data">
	<div class="row">
		<div class="col">
			<div class="form-group">
				<input type="file" name="file" class="form-control form-control-file">
			</div>
		</div>
		<div class="col">
			<input type="text" name="file_name" class="form-control" placeholder="File Name">
		</div>
		<div class="col">
			<input type="date" name="file_expiry" class="form-control" placeholder="Expiry" >
		</div>
		<div class="col">
			<button type="submit" class="btn btn-success mb-2">Save</button>
		</div>
	</div>
</form>

<script type="text/javascript">
	$(".add-files").on('submit', function(e) {
                e.preventDefault();
            // console.log(this.id)
                var data = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: this.action,
                    data: data,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(result) {
                        if(result.success) {
                            Swal.fire({
                                text: result.message,
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-light"
                                }
                            })
                            window.location.href = "{{ url('/about_us')}}";
                        } else {
                            Swal.fire({
                                text: result.error,
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-light"
                                }
                            })
                        }
                    }
                })
            });
</script>