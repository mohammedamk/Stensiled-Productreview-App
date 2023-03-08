<?php
class SettingController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        //Do your magic here
        $this->load->model('SettingModel');
    }
    public function getshopdomain($shop)
    {

        if (strpos($shop, 'https://') !== false) {
            $shop = preg_replace('#^https?://#', '', $shop);
        }
        return $shop;
    }
    public function index()
    {
        $data= array();
        $shop = $_GET['shop'];
        $shop = $this->getshopdomain($shop);

        $shopAccess = getShop_accessToken_byShop($shop);
        $data['shop'] = $shopAccess['SHOP_DOMAIN'];
        $data['api_key'] = $shopAccess['API_KEY'];

        $data['setting'] = $this->SettingModel->getSetting();
        // $this->load->view('layouts/header');
        $this->load->view('setting/index', $data);
        // $this->load->view('layouts/footer');
    }
    public function updateSetting()
    {
        // echo "<pre>";
        // print_r($_GET);
        // exit;
        $data = array(
            'auto_publish' => $this->input->post('auto_publish'),
            'receive_email_for_review' => $this->input->post('receive_email_for_review'),
            'receive_email_addr' => $this->input->post('receive_email_addr'),
            'review_headline' => $this->input->post('review_headline'),
            'show_form_on_load' => $this->input->post('show_form_on_load'),
            'show_powered_by' => $this->input->post('show_powered_by'),
            'review_form_title' => $this->input->post('review_form_title'),
            'review_link' => $this->input->post('review_link'),
            'summary_with_no_review' => $this->input->post('summary_with_no_review'),
            'report_as_inappropriate' => $this->input->post('report_as_inappropriate'),
            'report_as_inappropriate_mgs' => $this->input->post('report_as_inappropriate_mgs'),
            'author_email' => $this->input->post('author_email'),
            'author_email_help_msg' => $this->input->post('author_email_help_msg'),
            'author_email_type' => $this->input->post('author_email_type'),
            'author_name' => $this->input->post('author_name'),
            'author_name_help_msg' => $this->input->post('author_name_help_msg'),
            'author_name_type' => $this->input->post('author_name_type'),
            'review_rating' => $this->input->post('review_rating'),
            'review_title' => $this->input->post('review_title'),
            'review_title_help_msg' => $this->input->post('review_title_help_msg'),
            'review_body' => $this->input->post('review_body'),
            'review_body_help_msg' => $this->input->post('review_body_help_msg'),
            'submit_button' => $this->input->post('submit_button'),
            'success_msg' => $this->input->post('success_msg'),
            'err_msg' => $this->input->post('err_msg'),
        );
        // echo "<pre>";
        // print_r($data);
        // exit;
        $res = $this->SettingModel->storeSetting($data);

        if ($res == 1) {
            $this->session->set_flashdata('success', "Data updated seccessfully");
            redirect('index.php/setting');
        } else {
            $this->session->set_flashdata('error', "Soemthing goes wrong. Please try again");
            redirect('index.php/setting');
        }
    }
}
