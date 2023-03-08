<?php
class AuthModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function check_ShopExist($shop = NULL)
    {
        $query = $this->db->query("SELECT * FROM `shopify_stores` where  shop='" . $shop . "'");
        $rows  = $query->num_rows();
        if ($rows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_shop_details($shop = NULL)
    {
        $shop_details = $this->db->select('charge_id')->where('shop', $shop)->get('shopify_stores');
        if ($shop_details->num_rows() > 0) {
            return $shop_details->row();
        } else {
            return false;
        }
    }

    public function check_SettingExist($shop = NULL)
    {
        $query = $this->db->query("SELECT * FROM `review_setting_tbl` where  shop='" . $shop . "'");
        $rows  = $query->num_rows();
        if ($rows > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function check_shopstatus($shop = NULL)
    {
        $query = $this->db->query("SELECT * FROM `review_setting_tbl` where  shop='" . $shop . "' and shop_status = 'uninstalls'");
        $rows  = $query->num_rows();
        if ($rows > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function check_reviewFormExist($shop = NULL)
    {
      $query = $this->db->query("SELECT * FROM `shopify_stores` where  is_reviewform = 0 ");
      $rows  = $query->num_rows();
      if ($rows > 0) {
          return TRUE;
      } else {
          return FALSE;
      }
    }

    public function save_token($getdata)
    {
        $this->db->select("*");
        $this->db->from("tokenTable");
        $this->db->where("access_token", $getdata["access_token"]); // will check row by column name in database
        // $this->db->where("shop", $getdata["shop"]); // will check row by column name in database
        $this->result = $this->db->get();

        if ($this->result->num_rows() > 0) {
            // you data exist
            return false;
        } else {
            // data not exist insert you information
            $this->db->insert('tokenTable', $getdata);
            return true;
        }
    }
    public function check($shop)
    {
        // $data = array();
        $this->db->select('*');
        $this->db->from('tokenTable');
        $this->db->where('shop', $shop);
        $query = $this->db->get();
        if ($query->num_rows() > 0)

            return $query->result();
    }

    public function update_Shop($data, $accessToken)
    {
        if ($accessToken) {
            $sql = "update  shopify_stores set code='" . $data['code'] . "', hmac='" . $data['code'] . "', token='" . $accessToken . "' where  shop='" . $data['shop'] . "' ";
            $this->db->query($sql);
        }
    }

    public function UpdateShopDetails($where = array(), $data = array())
    {
        $this->db->where($where)->update('shopify_stores', $data);
        return $this->db->affected_rows();
    }

    public function add_newShop($data, $accessToken)
    {
        $sql = "insert into shopify_stores set code='" . $data['code'] . "', hmac='" . $data['code'] . "', domain='" . $data['shop'] . "',shop='" . $data['shop'] . "', token='" . $accessToken . "' ";
        $this->db->query($sql);
    }

    function getShopIdby_shop($shop)
    {
      $query=$this->db->query("SELECT * FROM `shopify_stores` where domain='".$shop."' limit  0,1");
      $rowdata=$query->row();
      if($rowdata)
      {
        return $rowdata->id;
      }
    }

    function getstatusbyShop($shop)
    {
      $query=$this->db->query("SELECT * FROM `review_setting_tbl` where shop='".$shop."' limit  0,1");
      $rowdata=$query->row();
      if($rowdata)
      {
        return $rowdata->shop_status;
      }
    }

    public function updateshopstatus($shop)
    {
        $sql = "update  review_setting_tbl set shop_status='uninstall' where  shop='".$shop."' ";
        $this->db->query($sql);
    }

    public function updateshopstatusinstall($shop)
    {
        $sql = "update  review_setting_tbl set shop_status='Installed' where  shop='".$shop."' ";
        $this->db->query($sql);
    }

    public function insertSetting($shop)
    {
      $getdata = array(
          'shop' => $shop,
          'shop_id' => $this->getShopIdby_shop($shop),
          'auto_publish' => 1,
          'customer_logged_in' => 0,
          'layout' => 'grid',
          'receive_email_for_review' => 0,
          'receive_email_addr' => '',
          'review_headline' => 'CUSTOMER REVIEW FORM',
          'show_form_on_load' => 1,
          'show_powered_by' => 1,
          'review_form_title' => 'Customer review',
          'review_link' => 'Write a review',
          'summary_with_no_review' => 'No Reviews Yet ..!',
          'report_as_inappropriate' => 'Report as Inappropriate',
          'report_as_inappropriate_mgs' => 'Reported as inappropriate review',
          'author_email' => 'Email',
          'author_email_help_msg' => 'Enter Your email',
          'author_email_type' => '',
          'author_name' => 'Your Name',
          'author_name_help_msg' => 'Please Enter Name',
          'author_name_type' => '',
          'review_rating' => 'Rating',
          'review_title' => 'Title',
          'review_title_help_msg' => 'write the title',
          'review_body' => 'Body of Review',
          'review_body_help_msg' => 'Enter your comments here',
          'submit_button' => 'Submit',
          'success_msg' => 'Thank you! Your review is submitted.',
          'err_msg' => 'Error! Try again.',
          'shop_status' => 'Installed',
      );
          $this->db->insert('review_setting_tbl', $getdata);
    }
}
