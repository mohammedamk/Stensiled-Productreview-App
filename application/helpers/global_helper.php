<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
function getShop_accessToken_byShop($shop = null)
{
    $ci      = &get_instance();
    $query   = $ci->db->query("SELECT * FROM `shopify_stores` where shop='" . $shop . "' limit  0,1");
    $rowdata = $query->row();
    if ($rowdata) {
        $data = array(
            'API_KEY'      => $ci->config->item('shopify_api_key'),
            'API_SECRET'   => $ci->config->item('shopify_secret'),
            'SHOP_DOMAIN'  => $rowdata->shop,
            'ACCESS_TOKEN' => $rowdata->token,
        );
        return $data;
    }
}

function json_send($data) {
  header('Content-Type: application/json');
  echo json_encode($data);
}

function getYear() {
  $curr_date = date('m/d/Y h:i:s a', time());
  $curr_month = date('m');
  $curr_year = date('Y');
  $api_arr = ['-01', '-04', '-07', '-10'];
  $api_end = '';

  if($curr_month === 1) {
    $api_end = ($curr_year - 1) . $api_arr[3];
  } else if($curr_month > 1 && $curr_month <= 4) {
    $api_end = $curr_year . $api_arr[0];
  } else if($curr_month > 4 && $curr_month <= 7) {
    $api_end = $curr_year . $api_arr[1];
  } else if($curr_month > 7 && $curr_month <= 10) {
    $api_end = $curr_year . $api_arr[2];
  } else if($curr_month > 10 && $curr_month <= 12) {
    $api_end = $curr_year . $api_arr[3];
  }

  // print_r($api_end);
  return $api_end;
}
