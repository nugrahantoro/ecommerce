<?php $this->load->view('front/header'); ?>
<?php $this->load->view('front/navbar'); ?>

<div class="container">
	<div class="row">
    <div class="col-lg-12">
			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a></li>
					<li class="breadcrumb-item active">Keranjang Belanja</li>
			  </ol>
			</nav>
    </div>

    <div class="col-lg-12"><h1>Keranjang Belanja</h1><hr>
			<div class="row">
			  <div class="col-lg-12">
					<?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
          <div class="box-body table-responsive padding">
            <table id="datatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th style="text-align: center">No.</th>
                  <th style="text-align: center">Barang</th>
									<th style="text-align: center">Harga</th>
                  <th style="text-align: center">Berat</th>
                  <th style="text-align: center">J.Berat</th>
									<th style="text-align: center">Qty</th>
                  <th style="text-align: center">Total</th>
                  <th style="text-align: center">Aksi</th>
                </tr>
              </thead>
              <tbody>
              <?php $no=1; foreach ($cart_data as $cart){ ?>
                <tr>
                  <td style="text-align:center"><?php echo $no++ ?></td>
                  <td style="text-align:left"><a href="<?php echo base_url('produk/read/').$cart->slug_produk ?>"><?php echo $cart->judul_produk ?></a></td>
									<td style="text-align:center"><?php echo number_format($cart->harga_diskon) ?></td>
									<td style="text-align:center"><?php echo $cart->berat ?></td>
                  <td style="text-align:center"><?php echo $cart->total_berat ?></td>
									<form action="<?php echo base_url('cart/update/').$cart->produk_id ?>" method="post">
									<td style="text-align:center">
										<input type="hidden" name="produk_id" value="<?php echo $cart->produk_id ?>">
										<input type="number" name="qty" style="width: 50px" value="<?php echo $cart->total_qty ?>">
									</td>
                  <td style="text-align:center"><?php echo number_format($cart->subtotal) ?></td>
                  <td style="text-align:center">
										<button type="submit" name="update" class="btn btn-sm btn-warning"><i class="fa fa-refresh"></i></button>
										<button type="submit" name="delete" class="btn btn-sm btn-danger"><i class="fa fa-remove"></i></button>
                  </td>
									</form>
                </tr>
              <?php } ?>
              </tbody>
            </table>
  			  </div>
  			</div>
  		</div>

			<?php echo form_open('cart/checkout') ?>
				<table class="table table-striped table-bordered">
				  <tbody>
						<tr>
							<th>Total Berat</th>
							<td colspan="2" align="right"><?php echo $total_berat_dan_subtotal->total_berat ?> (gram) / <?php echo berat($total_berat_dan_subtotal->total_berat) ?> (kg)</td>
						</tr>
				    <tr>
							<th>SubTotal</th>
							<td></td>
							<td align="right"><?php echo $total_berat_dan_subtotal->subtotal ?></td>
						</tr>
						<tr>
				      <th>Ongkos Kirim</th>
				      <td>Via:
								<select name="kurir" class="kurir" required>
									<option value="">--Silahkan Pilih--</option>
								<?php
								$kurir=array('jne','pos','tiki');
								foreach($kurir as $data_kurir){
								?>
									<option value="<?=$data_kurir;?>"><?=strtoupper($data_kurir);?></option>
								<?php } ?>
								</select>

								<div id="kuririnfo" style="display: none;"><br>
									<label>Service</label>
									<div class="col-lg-12">
										<p class="form-control-static" id="kurirserviceinfo"></p>
									</div>
								</div>
							</td>
							<td align="right"><font id="totalongkir"></font></td>
				    </tr>
						<tr>
				      <th scope="row">Grand Total</th>
				      <td align="right">Subtotal + Total Ongkir</td>
				      <td align="right"><b><div id="grandtotal"></div></b></td>
				    </tr>
					</tbody>
				</table>

				<div class="row">
					<div class="col-lg-12">
						<hr><h4>Alamat Tujuan</h4><hr>
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th style="text-align: center">Nama</th>
									<th style="text-align: center">No. HP</th>
									<th style="text-align: center">Alamat</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align="center"><?php if($customer_data){echo $customer_data->name;} ?></td>
									<td align="center"><?php if($customer_data){echo $customer_data->phone;} ?></td>
									<td align="center"><?php if($customer_data){echo $customer_data->address.', '.$customer_data->nama_kota.', '.$customer_data->nama_provinsi;}?></td>
								</tr>
							</tbody>
						</table>
						<h4>Perhatian</h4>
						<ul>
							<?php if($this->ion_auth->logged_in()){ ?>
								<li>Apabila terdapat kesalahan pada data diatas, harap mengubahnya pada halaman edit profil pada menu berikut ini, <a href="<?php echo base_url('auth/edit_profil/').$this->session->userdata('user_id') ?>">klik disini</a></li>
								<li>Ongkos kirim <b>JNE</b> dibawah 1.4kg akan dianggap 1kg (toleransi 300gram), sedangkan <b>TIKI</b> dan <b>POS</b> dibawah 1.3kg akan dianggap 1kg (toleransi 200gram)</li>
							<?php } else { ?>
								<li>Ongkos kirim <b>JNE</b> dibawah 1.4kg akan dianggap 1kg (toleransi 300gram), sedangkan <b>TIKI</b> dan <b>POS</b> dibawah 1.3kg akan dianggap 1kg (toleransi 200gram)</li>
							<?php } ?>
						</ul>
					</div>
				</div>

				<?php if(!empty($cart->produk_id)){ ?>
					<div class="row">
						<div class="col-lg-12">
							<a href="<?php echo base_url('cart/empty_cart/').$customer_data->id_trans ?>">
								<button name="hapus" type="button" class="btn btn-danger" aria-label="Left Align" title="Kosongkan Keranjang" OnClick="return confirm('Apakah Anda yakin?');">
								  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Kosongkan Keranjang
								</button>
							</a>
							<a href="<?php echo base_url() ?>">
								<button name="hapus" type="button" class="btn btn-primary" aria-label="Left Align" title="Lanjut Belanja">
								  <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Lanjut Belanja
								</button>
							</a>
							<button name="checkout" type="submit" class="btn btn-success" aria-label="Left Align" title="Checkout">
							  <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Selesai Belanja
							</button>
						</div>
					</div>
					<input type="hidden" name="id_trans" value="<?php echo $customer_data->id_trans ?>">
					<input type="hidden" name="total" id="total" value="<?php echo $total_berat_dan_subtotal->subtotal ?>"/>
					<input type="hidden" name="ongkir" id="ongkir" value="0"/>
				<?php } else { ?>
					<div class="row">
						<div class="col-lg-12">
							<a href="<?php echo base_url() ?>">
								<button name="hapus" type="button" class="btn btn-primary" aria-label="Left Align" title="Lanjut Belanja">
								  <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Lanjut Belanja
								</button>
							</a>
						</div>
					</div>
				<?php } ?>
			<?php echo form_close() ?>
	  </div>

		<script type="text/javascript">
		$(document).ready(function()
		{
			$(".kurir").each(function(){
				$(this).on("change",function(){
					var did=$(this).val();
					var berat="<?php echo $total_berat_dan_subtotal->total_berat ?>";
					var kota="<?php echo $customer_data->kota ?>";
					$.ajax({
						method: "get",
						dataType:"html",
						url: "<?=base_url();?>cart/kurirdata",
						data: "kurir="+did+"&berat="+berat+"&kota="+kota,
					})
					.done(function(x) {
						$("#kurirserviceinfo").html(x);
						$("#kuririnfo").show();
					})
					.fail(function() {
						$("#kurirserviceinfo").html("");
						$("#kuririnfo").hide();
					});
				});
			});
			hitung();
		});

		function hitung()
		{
			var total=$('#total').val();
			var ongkir=$("#ongkir").val();
			var totalongkir= ongkir;
			var bayar=(parseFloat(total)+parseFloat(totalongkir));
			if(parseFloat(ongkir) > 0)
			{
				$("#oksimpan").show();
			}else{
				$("#oksimpan").hide();
			}
			$("#totalongkir").html(totalongkir);
			$("#grandtotal").html(bayar);
		}
		</script>
	</div>
</div>
<br>
<?php $this->load->view('front/footer'); ?>
