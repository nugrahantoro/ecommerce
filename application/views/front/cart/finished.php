<?php $this->load->view('front/header'); ?>
<?php $this->load->view('front/navbar'); ?>

<div class="container">
	<div class="row">
    <div class="col-sm-12 col-lg-12">
			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a></li>
					<li class="breadcrumb-item active">Transaksi Selesai</li>
			  </ol>
			</nav>
    </div>

    <div class="col-lg-12"><h1>Transaksi Selesai</h1><hr>
			<h4>INVOICE NO. <?php echo $customer_data->id_trans ?></h4>
			<?php echo form_open('cart/download_invoice/'.$customer_data->id_trans) ?>
				<button type="submit" name="download_invoice" class="btn btn-sm btn-success">Download Invoice</button>
			<?php echo form_close() ?>
			<br>
			<div class="row">
			  <div class="col-lg-12">
          <div class="box-body table-responsive padding">
            <table id="datatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th style="text-align: center">No.</th>
                  <th style="text-align: center">Daftar Produk</th>
									<th style="text-align: center">Harga</th>
                  <th style="text-align: center">Berat</th>
                  <th style="text-align: center">Jumlah Berat (gram)</th>
									<th style="text-align: center">Qty</th>
                  <th style="text-align: center">Total</th>
                </tr>
              </thead>
              <tbody>
              <?php $no=1; foreach ($cart_finished as $cart){ ?>
                <tr>
                  <td style="text-align:center"><?php echo $no++ ?></td>
                  <td style="text-align:left"><?php echo $cart->judul_produk ?></td>
									<td style="text-align:center"><?php echo number_format($cart->harga_diskon) ?></td>
									<td style="text-align:center"><?php echo $cart->berat ?></td>
                  <td style="text-align:center"><?php echo $cart->total_berat ?></td>
									<td style="text-align:center"><?php echo $cart->total_qty ?></td>
                  <td style="text-align:right"><?php echo number_format($cart->subtotal) ?></td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
  			  </div>
  			</div>
  		</div>

			<div class="row">
				<div class="col-lg-12">
					<table class="table table-striped table-bordered">
			  <tbody>
					<tr>
						<th>Total Berat</th>
						<td colspan="2" align="right"><?php echo $total_berat_dan_subtotal->total_berat ?> (gram) / <?php echo berat($total_berat_dan_subtotal->total_berat) ?> (kg)</td>
					</tr>
			    <tr>
						<th>SubTotal</th>
						<td></td>
						<td align="right"><?php echo number_format($total_berat_dan_subtotal->subtotal) ?></td>
					</tr>
					<tr>
			      <th>Ongkos Kirim</th>
            <td align="right">Via: <?php echo strtoupper($customer_data->kurir).' '.$customer_data->service ?></td>
			      <td align="right"><?php echo number_format($customer_data->ongkir) ?></td>
			    </tr>
					<tr>
			      <th scope="row">Grand Total</th>
			      <td align="right">Subtotal + Total Ongkir</td>
						<td align="right"><b><?php echo number_format($customer_data->ongkir + $total_berat_dan_subtotal->subtotal) ?></b></td>
			    </tr>
				</tbody>
			</table>
				</div>
			</div>

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
								<td align="center"><?php echo $customer_data->name ?></td>
								<td align="center"><?php echo $customer_data->phone ?></td>
								<td align="center"><?php echo $customer_data->address.', '.$customer_data->nama_provinsi.', '.$customer_data->nama_kota?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<hr><h4>Pembayaran</h4><hr>
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th style="text-align: center">No.</th>
								<th style="text-align: center">Bank</th>
								<th style="text-align: center">Atas Nama</th>
								<th style="text-align: center">No. Rekening</th>
							</tr>
						</thead>
						<tbody>
							<?php $no=1; foreach($data_bank as $bank){ ?>
							<tr>
								<td align="center"><?php echo $no++ ?></td>
								<td align="center"><?php echo $bank->nama_bank ?></td>
								<td align="center"><?php echo $bank->atas_nama ?></td>
								<td align="center"><?php echo $bank->norek ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<hr><h4>PERHATIAN</h4><hr>
					<ul>
						<li>Silahkan melakukan konfirmasi pembayaran ke halaman berikut ini, <a href="../konfirmasi_pembayaran">klik disini</a> atau langsung menghubungi kami ke customer service yang telah disediakan dan melampirkan foto bukti bayar.</li>
						<li>Kami akan segera memproses pemesanan Anda setelah mendapatkan konfirmasi pembayaran segera mungkin.</li>
					</ul>
					<p>Terima kasih telah berbelanja bersama kami.</p>
				</div>
			</div>
	  </div>
  </div>
</div>

<?php $this->load->view('front/footer'); ?>
