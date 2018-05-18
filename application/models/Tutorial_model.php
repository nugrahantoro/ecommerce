<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tutorial_model extends CI_Model
{
  public $table = 'tutorial';
  public $id    = 'id_tutorial';
  public $order = 'ASC';

  function update($id, $data)
  {
    $this->db->where($this->id,$id);
    $this->db->update($this->table, $data);
  }

  // delete data
  function delete($id)
  {
    $this->db->where($this->id, $id);
    $this->db->delete($this->table);
  }

  // get data by id
  function get_by_id($id)
  {
    $this->db->where('id_tutorial', $id);
    return $this->db->get($this->table)->row();
  }


  function get_by_tutorial()
  {
    $this->db->where('id_tutorial', '1');
    return $this->db->get($this->table)->row();
  }

  function total_rows() {
    return $this->db->get($this->table)->num_rows();
  }

}
