<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller
{
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

	public function read($id)
	{
    /* mengambil data berdasarkan id */
		$row = $this->Produk_model->get_by_id_front($id);

    /* melakukan pengecekan data, apabila ada maka akan ditampilkan */
		if ($row)
    {
      /* memanggil function dari masing2 model yang akan digunakan */
    	$this->data['produk']       	= $this->Produk_model->get_by_id_front($id);
			$this->data['produk_lainnya']	= $this->Produk_model->get_random();

			$this->data['title'] = $row->judul_produk;

      /* memanggil view yang telah disiapkan dan passing data dari model ke view*/
			$this->load->view('front/produk/body', $this->data);
		}
			else
	    {
				echo "<script>alert('Produk tidak ditemukan');location.replace('".base_url()."')</script>";
	    }
	}

	public function cari_produk()
  {
    /* menyiapkan data yang akan disertakan/ ditampilkan pada view */
  	$this->data['title'] = 'Hasil Pencarian Anda';

    /* memanggil function dari model yang akan digunakan */
    $this->data['hasil_pencarian'] = $this->Produk_model->get_cari_produk();

    /* memanggil view yang telah disiapkan dan passing data dari model ke view*/
    $this->load->view('front/produk/hasil_pencarian', $this->data);
  }

  public function katalog()
  {
    /* menyiapkan data yang akan disertakan/ ditampilkan pada view */
    $this->data['title'] = "Katalog Produk";

    /* memanggil library pagination (membuat halaman) */
    $this->load->library('pagination');

    /* menghitung jumlah total data */
    $jumlah = $this->Produk_model->total_rows();

    // Mengatur base_url
    $config['base_url'] = base_url().'produk/katalog/halaman/';
    //menghitung total baris
    $config['total_rows'] = $jumlah;
    //mengatur total data yang tampil per halamannya
    $config['per_page'] = 9;
    // tag pagination bootstrap

		$config['full_tag_open'] 		= '<nav><ul class="pagination">';
		$config['full_tag_close'] 	= '</ul></nav>';
		$config['num_tag_open'] 		= '<li class="page-item"><span class="page-link">';
		$config['num_tag_close'] 		= '</span></li>';
		$config['cur_tag_open'] 		= '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] 		= '<span class="sr-only">(current)</span></span></li>';
		$config['next_link']        = "Selanjutnya";
		$config['next_tag_open'] 		= '<li class="page-item"><span class="page-link">';
		$config['next_tagl_close'] 	= '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_link']        = "Sebelumnya";
		$config['prev_tag_open'] 		= '<li class="page-item"><span class="page-link">';
		$config['prev_tagl_close'] 	= '</span></li>';
		$config['first_link']       = "Awal";
		$config['first_tag_open'] 	= '<li class="page-item"><span class="page-link">';
		$config['first_tagl_close'] = '</span></li>';
		$config['last_link']        = 'Terakhir';
		$config['last_tag_open'] 		= '<li class="page-item"><span class="page-link">';
		$config['last_tagl_close'] 	= '</span></li>';

    // mengambil uri segment ke-4
    $dari = $this->uri->segment('4');

    /* eksekusi library pagination ke model penampilan data */
    $this->data['katalog_data'] = $this->Produk_model->get_all_katalog($config['per_page'],$dari);
		
    $this->pagination->initialize($config);

    /* memanggil view yang telah disiapkan dan passing data dari model ke view*/
    $this->load->view('front/produk/katalog', $this->data);
  }

}
