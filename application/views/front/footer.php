		<footer style="background-color: #0081b6; color: #fff;">
			<div class="container">
				<div class="row">
					<div class="col-lg-2">
						<hr><h5>Sosial Media</h5><hr>
						<a href="https://facebook.com" style="color: #fff;">Facebook</a> <hr>
						<a href="https://www.instagram.com/jimshoney_crbn/?hl=id" style="color: #fff;">Instagram</a> <hr>

						<!-- <li><a href="https://facebook.com">Facebook</a></li>
						<li><a href="https://www.instagram.com/jimshoney_crbn/?hl=id">Instagram</a></li> -->
						</ul>
					</div>
					<div class="col-lg-3">
						<hr><h5>Halaman</h5><hr>
						<a href="<?php echo base_url() ?>" style="color: #fff;">Home</a> <hr>
						<a href="<?php echo base_url('profil') ?>" style="color: #fff;">Profil</a> <hr>
						<a href="<?php echo base_url('blog/arsip') ?>" style="color: #fff;">Blog</a> <hr>
						<a href="<?php echo base_url('produk/katalog') ?>" style="color: #fff;">Katalog Produk</a> <hr>
						<a href="<?php echo base_url('cara_pembelian') ?>" style="color: #fff;">Cara Pembelian</a> <hr>

						<!-- <li><a href="<?php echo base_url() ?>">Home</a></li>
						<li><a href="<?php echo base_url('profil') ?>">Profil</a></li>
						<li><a href="<?php echo base_url('blog/arsip') ?>">Blog</a></li>
						<li><a href="<?php echo base_url('produk/katalog') ?>">Katalog Produk</a></li>
						<li><a href="<?php echo base_url('cara_pembelian') ?>">Cara Pembelian</a></li> -->
						<!-- <li><a href="<?php echo base_url('konfirmasi_pembayaran') ?>">Konfirmasi Pembayaran</a></li> -->
					</div>
					<div class="col-lg-2">
						<hr><h5>Kontak</h5><hr>
						<?php foreach($kontak as $kontak){?>
							<b><?php echo $kontak->nama ?></b><br>
							+<?php echo $kontak->nohp ?><br>
							<a href="https://api.whatsapp.com/send?phone=<?php echo $kontak->nohp ?>&text=Hi%20Gan,%20Saya%20minat%20dengan%20barangnya%20yang%20di%20website">
								<button class="btn btn-sm btn-success" type="submit" name="button">Chat via Whatsapp</button>
							</a><br><br>
						<?php } ?>
					</div>
					<div class="col-md-5">
						<hr><h5>Lokasi/ Map</h5><hr>
						<?php echo $company_data->company_maps;?>
					</div>
					<div class="col-lg-12"><hr>
						<div class="row">
							<div class="col-md-9">
								Additional by <a href="http://facebook.com/an.atsa2" style="color: #fff;">Mr. An</a>
							</div>
							<div class="col-md-3"><a href="#top" style="color: #fff;">Kembali ke atas</a></div>
						</div>
					</div>
				</div>
			</div>
		</footer>
  </body>
</html>
