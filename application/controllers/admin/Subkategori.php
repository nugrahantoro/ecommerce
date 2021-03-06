<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Subkategori extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Kategori_model');
    $this->load->model('Subkategori_model');

    $this->data['module'] = 'SubKategori';

    if (!$this->ion_auth->logged_in()){redirect('admin/auth/login', 'refresh');}
    // elseif($this->ion_auth->is_user()){redirect('admin/auth/login', 'refresh');}
  }

  public function index()
  {
    $this->data['title'] = 'Data '.$this->data['module'];
    $this->load->view('back/subkategori/subkategori_list', $this->data);
  }

  public function ajax_list()
	{
		//get_datatables terletak di model
    $list = $this->Subkategori_model->get_datatables();
    $data = array();
		$no = $_POST['start'];

    // Membuat loop/ perulangan
    foreach ($list as $data_subkategori) {
			$no++;
			$row = array();
      $row[] = '<p style="text-align: center">'.$no.'</p>';
      $row[] = '<p style="text-align: left">'.$data_subkategori->judul_subkategori.'</p>';
      $row[] = '<p style="text-align: left">'.$data_subkategori->judul_kategori.'</p>';

      // Penambahan tombol edit dan hapus
      $row[] = '
      <p style="text-align: center">
      	<a class="btn btn-sm btn-warning" href="'.base_url('admin/subkategori/update/').$data_subkategori->id_subkategori.'" title="Edit"><i class="fa fa-pencil"></i></a>
        <a class="btn btn-sm btn-danger" href="'.base_url('admin/subkategori/delete/').$data_subkategori->id_subkategori.'" title="Hapus" onclick="javasciprt: return confirm(\'Apakah Anda yakin ?\')"><i class="glyphicon glyphicon-remove"></i></a>
			</p>';

      $data[] = $row;
    }

    $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->Subkategori_model->count_all(),
              "recordsFiltered" => $this->Subkategori_model->count_filtered(),
              "data" => $data
              );
    //output to json format
    echo json_encode($output);
  }

  public function create()
  {
    $this->data['title']          = 'Tambah Data '.$this->data['module'];
    $this->data['action']         = site_url('admin/subkategori/create_action');
    $this->data['button_submit']  = 'Simpan';
    $this->data['button_reset']   = 'Reset';

    $this->data['kat_id'] = array(
      'name'  => 'kat_id',
      'id'    => 'kat_id',
      'class' => 'form-control',
      'required'    => '',
    );

    $this->data['judul_subkategori'] = array(
      'name'  => 'judul_subkategori',
      'id'    => 'judul_subkategori',
      'type'  => 'text',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('judul_subkategori'),
    );

    $this->data['ambil_kategori'] = $this->Kategori_model->ambil_kategori();

    $this->load->view('back/subkategori/subkategori_add', $this->data);
  }

  public function create_action()
  {
    $this->_rules();

    if ($this->form_validation->run() == FALSE)
    {
      $this->create();
    }
      else
      {
        $data = array(
          'id_kat'  => $this->input->post('kat_id'),
          'judul_subkategori'  => $this->input->post('judul_subkategori'),
          'slug_subkat'  => strtolower(url_title($this->input->post('judul_subkategori'))),
        );

        // eksekusi query INSERT
        $this->Subkategori_model->insert($data);
        // set pesan data berhasil dibuat
        $this->session->set_flashdata('message', '<div class="alert alert-success alert">Data berhasil dibuat</div>');
        redirect(site_url('admin/subkategori'));
      }
  }

  public function update($id)
  {
    $row = $this->Subkategori_model->get_by_id($id);
    $this->data['subkategori'] = $this->Subkategori_model->get_by_id($id);

    if ($row)
    {
      $this->data['title']          = 'Ubah Data '.$this->data['module'];
      $this->data['action']         = site_url('admin/subkategori/update_action');
      $this->data['button_submit']  = 'Simpan';
      $this->data['button_reset']   = 'Reset';

      $this->data['id_subkategori'] = array(
        'name'  => 'id_subkategori',
        'id'    => 'id_subkategori',
        'type'  => 'hidden',
      );

      $this->data['kat_id'] = array(
        'name'  => 'kat_id',
        'id'    => 'kat_id',
        'class' => 'form-control',
        'required'    => '',
      );

      $this->data['judul_subkategori'] = array(
        'name'  => 'judul_subkategori',
        'id'    => 'judul_subkategori',
        'type'  => 'text',
        'class' => 'form-control',
      );

      $this->data['ambil_kategori'] = $this->Kategori_model->ambil_kategori();

      $this->load->view('back/subkategori/subkategori_edit', $this->data);
    }
      else
      {
        $this->session->set_flashdata('message', '<div class="alert alert-warning alert">Data tidak ditemukan</div>');
        redirect(site_url('admin/subkategori'));
      }
  }

  public function update_action()
  {
    $this->_rules();

    if ($this->form_validation->run() == FALSE)
    {
      $this->update($this->input->post('id_subkategori'));
    }
      else
      {
        $data = array(
          'id_kat'  => $this->input->post('kat_id'),
          'judul_subkategori'  => $this->input->post('judul_subkategori'),
          'slug_subkat'  => strtolower(url_title($this->input->post('judul_subkategori'))),
        );

        $this->Subkategori_model->update($this->input->post('id_subkategori'), $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert">Edit Data Berhasil</div>');
        redirect(site_url('admin/subkategori'));
      }
  }

  public function delete($id)
  {
    $row = $this->Subkategori_model->get_by_id($id);

    if ($row)
    {
      $this->Subkategori_model->delete($id);
      $this->session->set_flashdata('message', '<div class="alert alert-success alert">Data berhasil dihapus</div>');
      redirect(site_url('admin/subkategori'));
    }
      // Jika data tidak ada
      else
      {
        $this->session->set_flashdata('message', '<div class="alert alert-warning alert">Data tidak ditemukan</div>');
        redirect(site_url('admin/subkategori'));
      }
  }

  public function _rules()
  {
    $this->form_validation->set_rules('judul_subkategori', 'Judul Subkategori', 'trim|required');

    // set pesan form validasi error
    $this->form_validation->set_message('required', '{field} wajib diisi');

    $this->form_validation->set_rules('id_subkategori', 'id_subkategori', 'trim');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert">', '</div>');
  }

}

/* End of file Subkategori.php */
/* Location: ./application/controllers/Subkategori.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-10-17 02:19:21 */
/* http://harviacode.com */
