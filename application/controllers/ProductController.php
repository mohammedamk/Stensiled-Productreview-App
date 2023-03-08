<?php
class ProductController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('AuthModel');
    }
    public function index()
    {
        $shop = $_GET['shop'];
        $shopAccess = getShop_accessToken_byShop($shop);
        $this->load->library('Shopify', $shopAccess);
        $viewdata = array();
        $year = getYear();
        $viewdata['products_list'] = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/products.json'], true);
        $this->load->view('welcome', $viewdata);
    }
}
