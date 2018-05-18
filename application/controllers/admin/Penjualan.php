<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Penjualan extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->helper('berat_helper');

    $this->load->model('Cart_model');
    $this->load->model('Company_model');

    $this->data['module'] = 'Penjualan';

    $this->data['company_data'] 			= $this->Company_model->get_by_company();

    if (!$this->ion_auth->logged_in()){redirect('admin/auth/login', 'refresh');}
  }

  public function index()
  {
    $this->data['title']            = 'Data '.$this->data['module'];
    $this->data['penjualan_data']   = $this->Cart_model->get_all();

    $this->load->view('back/penjualan/penjualan_list', $this->data);
  }

  public function view($id)
  {
    $row      = $this->Cart_model->get_by_id($id);
    $invoice = $row->id_trans;

    $this->data['penjualan'] = $this->Cart_model->get_by_id($id);

    if($row)
    {
      $this->data['title']              = 'Detail '.$this->data['module'];

      // ambil data keranjang
  		$this->data['cart_data'] 			    			= $this->Cart_model->get_cart_per_customer_finished_back($invoice);
  		// ambil total_berat_dan_subtotal
  		$this->data['total_berat_dan_subtotal'] = $this->Cart_model->get_total_berat_dan_subtotal_finished_back($invoice);
      $this->data['customer_data'] 			    	= $this->Cart_model->get_data_customer_back($invoice);

      $this->load->view('back/penjualan/penjualan_detail', $this->data);
    }
      else
      {
        $this->session->set_flashdata('message', '<div class="alert alert-warning alert">Data tidak ditemukan</div>');
        redirect(site_url('admin/penjualan'));
      }
  }

  public function update($id)
  {
    $row      = $this->Cart_model->get_by_id($id);
    $invoice  = $row->id_trans;

    $this->data['penjualan'] = $this->Cart_model->get_by_id($id);

    if($row)
    {
      $this->data['title']              = 'Update Status '.$this->data['module'];

      $this->data['id_trans'] = array(
        'name'  => 'id_trans',
        'id'    => 'id_trans',
        'class' => 'form-control',
        'type'  => 'hidden',
      );
      $this->data['resi'] = array(
        'name'  => 'resi',
        'id'    => 'resi',
        'class' => 'form-control',
        'required' => ''
      );

      $this->load->view('back/penjualan/penjualan_status', $this->data);
    }
      else
      {
        $this->session->set_flashdata('message', '<div class="alert alert-warning alert">Data tidak ditemukan</div>');
        redirect(site_url('admin/penjualan'));
      }
  }

  public function update_action()
  {
    $this->_rules();

    if ($this->form_validation->run() == FALSE)
    {
      $this->update($this->input->post('id_trans'));
    }
      else
      {
        $data = array(
          'resi'    => $this->input->post('resi'),
          'status'  => '2',
        );

        $this->Cart_model->update($this->input->post('id_trans'), $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert">Edit Data Berhasil</div>');
        redirect(site_url('admin/penjualan'));
      }
  }

  public function _rules()
  {
    $this->form_validation->set_rules('resi', 'No. Resi', 'trim|required');

    // set pesan form validasi error
    $this->form_validation->set_message('required', '{field} wajib diisi');

    $this->form_validation->set_rules('id_trans', 'id_trans', 'trim');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert">', '</div>');
  }

}
