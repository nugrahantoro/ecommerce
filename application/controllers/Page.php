<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

	function __construct()
  {
    parent::__construct();

    /* memanggil model untuk ditampilkan pada masing2 modul */
		$this->load->model('Blog_model');
		$this->load->model('Cart_model');
    $this->load->model('Company_model');
		$this->load->model('Featured_model');
		$this->load->model('Kategori_model');
		$this->load->model('Kontak_model');
    $this->load->model('Produk_model');

    /* memanggil function dari masing2 model yang akan digunakan */
    $this->data['blog_data'] 					= $this->Blog_model->get_all_sidebar();
    $this->data['company_data'] 			= $this->Company_model->get_by_company();
    $this->data['featured_data'] 			= $this->Featured_model->get_all_front();
    $this->data['kategori_data'] 			= $this->Kategori_model->get_all();
		$this->data['kontak'] 						= $this->Kontak_model->get_all();
		$this->data['total_cart_navbar'] 	= $this->Cart_model->total_cart_navbar();
  }

	public function company()
	{
		$this->data['title'] 							= 'Profil Toko';

    /* melakukan pengecekan data, apabila ada maka akan ditampilkan */
  	$this->data['company']            = $this->Company_model->get_by_company();

    /* memanggil view yang telah disiapkan dan passing data dari model ke view*/
		$this->load->view('front/company/body', $this->data);
	}


	public function konfirmasi_pembayaran()
	{
		$this->data['title'] 							= 'Konfirmasi Pembayaran';

		$this->load->view('front/page/konfirmasi_pembayaran', $this->data);
	}

	public function konfirmasi_kirim()
	{
		$config['upload_path']='./assets/images/bukti/';
		$config['allowed_types']='jpg|jpeg|png|';
		$this->load->library('upload',$config);
		$this->upload->do_upload();
		$data =  $this->upload->data();
		$gambar = $data['file_name'];

		// ambil value dari masing2 form input
		$invoice 			= $this->input->post('invoice');
		$nama 				= $this->input->post('nama');
		$jumlah 			= $this->input->post('jumlah');
		$bank_asal 		= $this->input->post('bank_asal');
		$bank_tujuan 	= $this->input->post('bank_tujuan');

		// setingan default tanpa smtp
		// $this->load->library('email');
		//
		// $this->email->from('huntershop80@gmail.com', 'Konfirmasi Pembayaran Baru');
		// $this->email->to('anatsa88@gmail.com');
		// $this->email->subject('Konfirmasi Pembayaran Baru');
		// $this->email->message('Halo bos, ada konfirmasi pembayaran baru dengan rincian sebagai berikut: <br>
		// No. Invoice: '.$invoice.'<br>
		// Nama Lengkap: '.$nama.'<br>
		// Jumlah: '.$jumlah.'<br>
		// Bank Asal: '.$bank_asal.'<br>
		// Bank Tujuan: '.$bank_tujuan.'<br>
		// Silahkan diproses bos pesanannya. Customer menunggu.
		// ');
		//
		// if ($this->email->send())
    // {
		// 	$this->session->set_flashdata('message', '<div class="row"><div class="col-lg-12"><div class="alert alert-success alert">Konfirmasi pembayaran telah berhasil</div></div></div>');
		// 	redirect(site_url('konfirmasi_pembayaran'));
    // }
    // else
    // {
		// 	$this->session->set_flashdata('message', '<div class="row"><div class="col-lg-12"><div class="alert alert-success alert">Konfirmasi pembayaran gagal, silahkan coba kembali</div></div></div>');
		// 	redirect(site_url('konfirmasi_pembayaran'));
    // }

		// Konfigurasi email dengan smtp
    $config = [
       'smtp_host' => 'ssl://smtp.gmail.com',
       'smtp_user' => 'huntershop80@gmail.com',   // Ganti dengan email gmail Anda.
       'smtp_pass' => 'localhost7',             // Password gmail Anda.
       'smtp_port' => 465,
   	];

    // Load library email dan konfigurasinya.
    $this->load->library('email', $config);

    // Pengirim dan penerima email.
    $this->email->from('huntershop80@gmail.com', 'no-reply');    // Email dan nama pegirim.
    $this->email->to('anatsa88@gmail.com');                       // Penerima email.

    // Subject email.
    $this->email->subject('Konfirmasi Pembayaran di Amara Gallery');

    // Isi email. Bisa dengan format html.
		$this->email->message('Halo bos, ada konfirmasi pembayaran baru dengan rincian sebagai berikut: <br>
		No. Invoice: '.$invoice.'<br>
		Nama Lengkap: '.$nama.'<br>
		Jumlah: '.$jumlah.'<br>
		Bank Asal: '.$bank_asal.'<br>
		Bank Tujuan: '.$bank_tujuan.'<br>
		Silahkan diproses bos pesanannya. Customer menunggu.
		');

    if ($this->email->send())
    {
      echo 'Sukses! email berhasil dikirim.';
    }
    else
    {
      echo 'Error! email tidak dapat dikirim.';
    }
	}

}
