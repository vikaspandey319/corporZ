<form id='edit' action="" enctype="multipart/form-data" method="post"
      accept-charset="utf-8">
	<div class="box-body">
		<div id="status"></div>
		<div class="form-group col-md-4 col-sm-12">
			<label for=""> First Name </label>
			<input type="text" class="form-control" id="first_name" name="first_name" value="<?= $user->first_name ?>"
			       placeholder="" required>
			<input type="hidden" name="updateId" class="form-control" value="<?= $user->id ?>">
			<span id="error_first_name" class="has-error"></span>
		</div>
		<div class="form-group col-md-4 col-sm-12">
			<label for=""> Last Name </label>
			<input type="text" class="form-control" id="last_name" name="last_name" value="<?= $user->last_name ?>"
			       placeholder="" required>
			<span id="error_last_name" class="has-error"></span>
		</div>
		<div class="form-group col-md-4 col-sm-12">
			<label for=""> Login Name </label>
			<input type="text" class="form-control" id="username" name="username" value="<?= $user->username ?>"
			       placeholder="" required>
			<span id="error_username" class="has-error"></span>
		</div>
		<div class="clearfix"></div>
		<div class="form-group col-md-4 col-sm-12">
			<label for=""> User Email </label>
			<input type="text" class="form-control" id="email" name="email" value="<?= $user->email ?>"
			       placeholder="" required>
			<span id="error_email" class="has-error"></span>
		</div>
		<div class="form-group col-md-4 col-sm-12">
			<label for=""> Phone </label>
			<input type="text" class="form-control" id="user_phone" name="user_phone" value="<?= $user->phone ?>"
			       placeholder="" required>
			<span id="error_user_phone" class="has-error"></span>
		</div>
		<div class="form-group col-md-4 col-sm-12">
			<label>User Group</label>
			<select class="form-control" id="group_id" name="group_id">
				<?php
				foreach ( $groups as $group ) {
					?>
					<option <?php if ( $group->id == $user_group->id )
						echo "selected" ?>
						value="<?= $group->id ?>">
						<?= $group->name ?></option>
					<?php
				}
				?>
			</select>
		</div>
		<div class="clearfix"></div>
		<div class="form-group col-md-8">
			<label> User Image </label>
			<!--     <label for = "user_image"><?php // echo $this->lang->line('admin_image'); ?></label>  -->
			<input id="user_image" type="file" name="user_image" style="display:none">

			<div class="input-group">
				<div class="input-group-btn">
					<a class="btn btn-primary" onclick="$('input[id=user_image]').click();">Browse</a>

				</div>
				<!-- /btn-group -->

				<input type="text" name="SelectedFileName" class="form-control" id="SelectedFileName"
				       value="<?= $user->file_path ?>" readonly>

			</div>
			<div class="clearfix"></div>
			<p class="help-block">File Extension must be jpg, jpeg, png, allowed dimension less than(800*800) and Size
				less than 2MB </p>
			<script type="text/javascript">
				$('input[id=user_image]').change(function () {
					$('#SelectedFileName').val($(this).val());
				});
			</script>
			<span id="error_SelectedFileName" class="has-error"></span>
		</div>
		<div class="form-group col-md-4">
			<label for=""> Status </label><br/>
			<input type="radio" name="status" class="flat-red" value="1" <?php if ( $user->active == '1' ) {
				echo 'checked="checked"';
			} ?>" /> Active
			<input type="radio" name="status" class="flat-red" value="0" <?php if ( $user->active == '0' ) {
				echo 'checked="checked"';
			} ?>" /> In Active
		</div>
		<div class="clearfix"></div>
		<div class="form-group col-md-12">
			<input type="submit" id="submit" name="submit" value="Save" class="btn btn-primary">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			<small><img id="loader" src="<?php echo site_url( 'assets/images/loadingg.gif' ); ?>"/></small>
		</div>
	</div>
	<!-- /.box-body -->
</form>
<script type="text/javascript">
	//Flat red color scheme for iCheck
	$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});
</script>
<script>
	$(document).ready(function () {
		$('#loader').hide();
		$('#edit').validate({// <- attach '.validate()' to your form
			// Rules for form validation
			rules: {
				username: {
					required: true
				}
			},
			// Messages for form validation
			messages: {
				user_name: {
					required: 'Please enter user name'
				}
			},
			submitHandler: function (form) {

				var myData = new FormData($("#edit")[0]);

				$.ajax({
					url: BASE_URL + 'admin/user/edit',
					type: 'POST',
					data: myData,
					dataType: 'json',
					cache: false,
					processData: false,
					contentType: false,
					beforeSend: function () {
						$('#loader').show();
						$("#submit").prop('disabled', true); // disable button
					},
					success: function (data) {

						if (data.type === 'success') {
							reload_table();
							notify_view(data.type, data.message);
							$('#loader').hide();
							$("#submit").prop('disabled', false); // disable button
							$("html, body").animate({scrollTop: 0}, "slow");
							$('#modalUser').modal('hide'); // hide bootstrap modal

						} else if (data.type === 'danger') {
							if (data.errors) {
								$.each(data.errors, function (key, val) {
									$('#error_' + key).html(val);
								});
							}
							$("#status").html(data.message);
							$('#loader').hide();
							$("#submit").prop('disabled', false); // disable button
							$("html, body").animate({scrollTop: 0}, "slow");

						}
					}
				});
			}
			// <- end 'submitHandler' callback
		});                    // <- end '.validate()'

	});
</script>