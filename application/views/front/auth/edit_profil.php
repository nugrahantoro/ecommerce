<?php $this->load->view('front/header'); ?>
<?php $this->load->view('front/navbar'); ?>

<div class="container">
	<div class="row">
    <div class="col-lg-12">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a></li>
					<li class="breadcrumb-item active">Edit Profil</li>
				</ol>
			</nav>
    </div>

		<div class="col-lg-12"><h1>Edit Profil</h1><hr>
			<?php if($this->ion_auth->logged_in()){ ?>
				<?php echo $message ?>
				<?php echo validation_errors() ?>
				<?php echo form_open_multipart(uri_string());?>
				<div class="form-row">
			    <div class="form-group col-lg-6"><label>Nama</label><br>
			      <?php echo form_input($name);?>
			    </div>
			    <div class="form-group col-lg-6"><label>Username</label><br>
			      <?php echo form_input($username);?>
			    </div>
				</div>
				<div class="form-row">
					<div class="form-group col-lg-6"><label>Password</label><br>
			      <?php echo form_input($password);?>
			    </div>
					<div class="form-group col-lg-6"><label>Konfirmasi Password</label><br>
			      <?php echo form_input($password_confirm);?>
			    </div>
				</div>
				<div class="form-row">
			    <div class="form-group col-lg-6"><label>No. HP</label><br>
			      <?php echo form_input($phone);?>
			    </div>
			    <div class="form-group col-lg-6"><label>Email</label><br>
			      <?php echo form_input($email);?>
			    </div>
				</div>
		    <div class="form-group"><label>Alamat</label><br>
		      <?php echo form_textarea($address);?>
		    </div>
				<?php echo form_hidden('id', $user->id);?>
				<?php echo form_hidden($csrf); ?>
				<button type="submit" name="submit" class="btn btn-primary">Update</button>
				<button type="reset" name="reset" class="btn btn-danger">Reset</button>
				<?php echo form_close() ?>
			<?php } else { ?>
				<?php redirect(base_url(), 'refresh'); ?>
			<?php } ?>
		</div>
	</div>
</div>

<?php $this->load->view('front/footer'); ?>
<script type="text/javascript">
function tampilKota()
{
	provinsi_id = document.getElementById("provinsi_id").value;
	$.ajax({
		url:"<?php echo base_url();?>auth/pilih_kota/"+provinsi_id+"",
		success: function(response){
			$("#kota_id").html(response);
		},
		dataType:"html"
	});
	return false;
}
</script>
