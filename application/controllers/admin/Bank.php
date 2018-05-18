<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bank extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Bank_model');

    $this->data['module'] = 'Bank';

		if (!$this->ion_auth->logged_in()){redirect('admin/auth/login', 'refresh');}
  }

  public function index()
  {
    $this->data['title'] = "Data Bank";
    $this->load->view('back/bank/bank_list', $this->data);
  }

  public function ajax_list()
	{
		//get_datatables terletak di model
    $list = $this->Bank_model->get_datatables();
    $data = array();
		$no = $_POST['start'];

    // Membuat loop/ perulangan
    foreach ($list as $data_bank) {
			$no++;
			$row = array();
      $row[] = '<p style="text-align: center">'.$no.'</p>';
      $row[] = '<p style="text-align: left">'.$data_bank->nama_bank.'</p>';
      $row[] = '<p style="text-align: center">'.$data_bank->atas_nama.'</p>';
      $row[] = '<p style="text-align: center">'.$data_bank->norek.'</p>';

      // Penambahan tombol edit dan hapus
      $row[] = '
      <p style="text-align: center">
      	<a class="btn btn-sm btn-warning" href="'.base_url('admin/bank/update/').$data_bank->id_bank.'" title="Edit"><i class="fa fa-pencil"></i></a>
        <a class="btn btn-sm btn-danger" href="'.base_url('admin/bank/delete/').$data_bank->id_bank.'" title="Hapus" onclick="javasciprt: return confirm(\'Apakah Anda yakin ?\')"><i class="glyphicon glyphicon-remove"></i></a>
			</p>';

      $data[] = $row;
    }

    $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->Bank_model->count_all(),
              "recordsFiltered" => $this->Bank_model->count_filtered(),
              "data" => $data
              );
    //output to json format
    echo json_encode($output);
  }

  public function create()
  {
    $this->data['title']          = 'Tambah Data '.$this->data['module'];
    $this->data['action']         = site_url('admin/bank/create_action');
    $this->data['button_submit']  = 'Simpan';
    $this->data['button_reset']   = 'Reset';

    $this->data['nama_bank'] = array(
      'name'  => 'nama_bank',
      'id'    => 'nama_bank',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('nama_bank'),
    );

    $this->data['atas_nama'] = array(
      'name'  => 'atas_nama',
      'id'    => 'atas_nama',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('atas_nama'),
    );

    $this->data['norek'] = array(
      'name'  => 'norek',
      'id'    => 'norek',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('norek'),
    );

    $this->load->view('back/bank/bank_add', $this->data);
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
          'nama_bank'  => $this->input->post('nama_bank'),
          'atas_nama'  => $this->input->post('atas_nama'),
          'norek'      => $this->input->post('norek'),
        );

        // eksekusi query INSERT
        $this->Bank_model->insert($data);
        // set pesan data berhasil dibuat
        $this->session->set_flashdata('message', '
        <div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
					<i class="ace-icon fa fa-bullhorn green"></i> Data berhasil disimpan
        </div>');
        redirect(site_url('admin/bank'));
      }
  }

  public function update($id)
  {
    $row = $this->Bank_model->get_by_id($id);
    $this->data['bank'] = $this->Bank_model->get_by_id($id);

    if ($row)
    {
      $this->data['title']          = 'Ubah Data '.$this->data['module'];
      $this->data['action']         = site_url('admin/bank/update_action');
      $this->data['button_submit']  = 'Simpan';
      $this->data['button_reset']   = 'Reset';

      $this->data['id_bank'] = array(
        'name'  => 'id_bank',
        'id'    => 'id_bank',
        'type'  => 'hidden',
      );

      $this->data['nama_bank'] = array(
        'name'  => 'nama_bank',
        'id'    => 'nama_bank',
        'class' => 'form-control',
      );

      $this->data['atas_nama'] = array(
        'name'  => 'atas_nama',
        'id'    => 'atas_nama',
        'class' => 'form-control',
      );

      $this->data['norek'] = array(
        'name'  => 'norek',
        'id'    => 'norek',
        'class' => 'form-control',
      );

      $this->load->view('back/bank/bank_edit', $this->data);
    }
      else
      {
        $this->session->set_flashdata('message', '
        <div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
					<i class="ace-icon fa fa-bullhorn green"></i> Data tidak ditemukan
        </div>');
        redirect(site_url('admin/bank'));
      }
  }

  public function update_action()
  {
    $this->_rules();

    if ($this->form_validation->run() == FALSE)
    {
      $this->update($this->input->post('id_bank'));
    }
      else
      {
        $data = array(
          'nama_bank'  => $this->input->post('nama_bank'),
          'atas_nama'  => $this->input->post('atas_nama'),
          'norek'      => $this->input->post('norek'),
        );

        $this->Bank_model->update($this->input->post('id_bank'), $data);
        $this->session->set_flashdata('message', '
        <div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
					<i class="ace-icon fa fa-bullhorn green"></i> Data berhasil disimpan
        </div>');
        redirect(site_url('admin/bank'));
      }
  }

  public function delete($id)
  {
    $row = $this->Bank_model->get_by_id($id);

    if ($row)
    {
      $this->Bank_model->delete($id);
      $this->session->set_flashdata('message', '
      <div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
        <i class="ace-icon fa fa-bullhorn green"></i> Data berhasil dihapus
      </div>');
      redirect(site_url('admin/bank'));
    }
      // Jika data tidak ada
      else
      {
        $this->session->set_flashdata('message', '
        <div class="alert alert-block alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
          <i class="ace-icon fa fa-bullhorn green"></i> Data tidak ditemukan
        </div>');
        redirect(site_url('admin/bank'));
      }
  }

  public function _rules()
  {
    $this->form_validation->set_rules('nama_bank', 'Nama Bank', 'trim|required');

    // set pesan form validasi error
    $this->form_validation->set_message('required', '{field} wajib diisi');

    $this->form_validation->set_rules('id_bank', 'id_bank', 'trim');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert" align="left">', '</div>');
  }

}
