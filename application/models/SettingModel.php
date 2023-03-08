<?php
class SettingModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function getformsetting($shop)
    {
      $row = $this->db->get_where('review_setting_tbl', array('shop' => $shop))->row();
      return $row;
    }

    public function getshopId($shop)
    {
        $this->db->select('id');
        $this->db->where('shop', $shop);
        $q = $this->db->get('shopify_stores');
        $data = $q->row()->id;
        return $data;
    }
    public function getSetting($shop)
    {
        $this->db->select('*');
        $this->db->where('shop', $shop);
        $q = $this->db->get('review_setting_tbl');
        $data = $q->result_array();
        return $data;
    }
    public function storeSetting($data, $shop)
    {
      $this->db->where('shop',$shop);
      $query = $this->db->get('review_setting_tbl');

      if ($query->num_rows() > 0){
        $this->db->where('shop', $shop);
        $ok = $this->db->update('review_setting_tbl', $data);

        return $ok;
      }
      else{
        $this->db->where('shop', $shop);
        $ok = $this->db->insert('review_setting_tbl', $data);
        return $ok;
      }

    }
}
