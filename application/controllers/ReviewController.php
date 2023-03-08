<?php
header('Access-Control-Allow-Origin: *');

class ReviewController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        /*load database libray manually*/
        $this->load->database();
        $this->load->helper('url','form');
        $this->load->library("pagination");
        //Do your magic here
        $this->load->model('AuthModel');
        $this->load->model('ReviewModel');
        $this->load->model('SettingModel');
    }

    public function getstatus()
    {
      $shop       = $_GET['shop'];
      json_send($this->AuthModel->getstatusbyShop($shop));
    }

    public function create()
    {
        $data= array();
        $shop = $this->input->get('shop');

        $data['setting'] = $this->SettingModel->getSetting($shop);
        // echo "<pre>";
        // print_r($shop);
        // exit;
        $this->load->load_admin('welcome',$data);
    }
    public function store()
    {
      // echo "<pre>";
      // print_r($_FILES);
      // exit;
      $uploadfile = array();
      $files = $_FILES;
      $cpt = count($_FILES['review_image']['name']);

      if(isset($_FILES['review_image']) && $_FILES['review_image']['error']['0'] !== 4) {
        // print_r('infunctuon');
        $this->load->library('upload');//loading the library
        $imagePath = realpath(APPPATH . '../assets/img/uploads');//this is your real path APPPATH means you are at the application folder
        if(!is_dir($imagePath)) {
           mkdir($imagePath, 0777, TRUE);
       }
        $number_of_files_uploaded = count($_FILES['review_image']['name']);

            for ($i = 0; $i <  $number_of_files_uploaded; $i++) {
                $_FILES['userfile']['name']     = $_FILES['review_image']['name'][$i];
                $_FILES['userfile']['type']     = $_FILES['review_image']['type'][$i];
                $_FILES['userfile']['tmp_name'] = $_FILES['review_image']['tmp_name'][$i];
                $_FILES['userfile']['error']    = $_FILES['review_image']['error'][$i];
                $_FILES['userfile']['size']     = $_FILES['review_image']['size'][$i];
                //configuration for upload your images
                $config = array(
                    'file_name'     => "img_".date('Ymdhis'),
                    'allowed_types' => 'jpg|jpeg|png|gif',
                    'max_size'      => 3000,
                    'overwrite'     => FALSE,
                    'upload_path'   => $imagePath
                );
                $this->upload->initialize($config);
                $errCount = 0;//counting errrs
                if (!$this->upload->do_upload())
                {
                    $error = array('error' => $this->upload->display_errors());
                    $result[] = array(
                        'errors'=> $error
                    );//saving arrors in the array

                }
                else
                {
                    $filename = $this->upload->data();
                    //compression code
                    // $config['image_library'] = 'gd2';
                    // $config['source_image'] = './assets/img/uploads/'.$filename["file_name"];
                    // echo "<pre>";
                    // print_r($config['source_image']);
                    // $config['create_thumb'] = FALSE;
                    // $config['maintain_ratio'] = FALSE;
                    // $config['quality'] = '60%';
                    // $config['width'] = 200;
                    // $config['height'] = 200;
                    // $config['new_image'] = './assets/img/uploads/'.$filename["file_name"];
                    // $this->load->library('image_lib', $config);
                    // $this->image_lib->resize();
                    //compression code ends here
                    $reviewImages[] = $filename['file_name'];
                    // echo "<pre>";
                    // print_r($reviewImages);


                } // if file uploaded

            }   // for loop ends here
            // if $_FILES ends here
              $uploadfiles_arr = implode(',',$reviewImages);
      }
        // echo "<pre>";
        // print_r($_POST);
        // exit;

        $userData = array(
          'product_id' => $this->input->post('product_id'),
          'shop' =>$this->input->post('shop'),
          'product_title' => $this->input->post('product_title'),
          'name'  => $this->input->post('name'),
          'email' => $this->input->post('email'),
          'rating' => $this->input->post('rating'),
          'review_title' => $this->input->post('review_title'),
          'body_of_review' => $this->input->post('body_of_review'),
          'state' => $this->input->post('state'),
          'review_image' => !empty($uploadfiles_arr) ? $uploadfiles_arr : ''
        );

        // echo "<pre>";
        // print_r($userData);
        // exit;
        $data= $this->ReviewModel->insertreview($userData);

        // echo "<pre>";
        // print_r($userData);
        // exit;
        // sending data to json
       echo json_encode($data);

    }
    public function paginate_review()
	{
        $product_id = $this->input->post('product_id');
        $config = array();
        $config["base_url"] =  "#";
        $config["total_rows"] = $this->ReviewModel->get_review_pages_count($product_id);
        $config["per_page"] = 3;
        $config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='active'><a href='#'>";
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['num_links'] = 3;

        $this->pagination->initialize($config);


		   $page = $this->uri->segment(3);

        $data["links"] = $this->pagination->create_links();
        $start = ($page - 1) * $config['per_page'];
        $output = array(
          'pagination_link'  => $this->pagination->create_links(),
          'review_list'      => $this->ReviewController->get_review_pages($config["per_page"], $page, $product_id)
          );
          echo json_encode($output);

    }
    private function set_upload_options()
    {
        //upload an image options
        $config = array();
        $config['upload_path'] = './resources/images/products/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = '0';
        $config['overwrite']     = FALSE;

        return $config;
    }
    public function getreviewbyproduct()
    {
      $data = array();
      $product_id = $_GET['product_id'];
      $data['review'] = $this->ReviewModel->getreviewbyproduct($product_id);
      $ratingCounts = $this->ReviewModel->ratingCounts($product_id);

      $count = count($data);
      $ratingAvg = '';
      // coverting date to 26th Mar, 2020 12:30 PM format
      foreach ($data['review'] as $d ) {
        $date = date_create($d->created_at);
        $date =  date_format($date,"dS M, Y H:i A");
        $d->created_at = $date;
      }


      $countofratings = array();

      array_push($countofratings, $ratingCounts->fivestar);
      array_push($countofratings, $ratingCounts->fourstar);
      array_push($countofratings, $ratingCounts->threestar);
      array_push($countofratings, $ratingCounts->twostar);
      array_push($countofratings, $ratingCounts->onestar);

      $data['ratingCounts'] = $countofratings;

      // echo "<pre";
      // print_r($data['ratingCounts']);
      // exit;


      json_send($data);

    }

    public function setStatusFlagged()
    {
      $id = $_GET['id'];
      $data = $this->ReviewModel->setStatusFlagged($id);
      echo json_encode($data);
    }

    //getting product list
    public function productList()
    {
      $data = array();
      $src = array();
      $shop = $_GET['shop'];

      $shopAccess = getShop_accessToken_byShop($shop);
      $this->load->library('Shopify', $shopAccess);
      $year = getYear();
      $data['reviews'] = $this->ReviewModel->productList($shop);
      // print_r($data['reviews']);
      // exit;
      foreach ($data['reviews'] as $review) {
        $products = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/products/'.$review->product_id.'/images.json'], true);
        foreach ($products->images as $image) {
          // echo "<pre>";
          // print_r($image->src);
          $review->src =  $image->src;
          break;
        }
        $review->reviewcount = $this->ReviewModel->productreviewcount($review->product_id);
        $review->avg_rating = $this->ReviewModel->avg_rating($review->product_id);

      }

      $this->load->load_admin('reviews/productList',$data);
    }

    //product inner view
    public function reviewlistbyproduct()
    {
      $data = array();
      $shop = $_GET['shop'];
      $product_id  = $_GET['product_id'];
      $data['reviews'] = $this->ReviewModel->reviewlistbyproduct($product_id);

      $data['summary'] = $this->ReviewModel->showsummary($product_id);
      $year = getYear();
      $shopAccess = getShop_accessToken_byShop($shop);
      $this->load->library('Shopify', $shopAccess);
      foreach ($data['summary'] as $s) {
        $products = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/products/'.$product_id.'/images.json'], true);
        foreach ($products->images as $image) {
          // echo "<pre>";
          // print_r($image->src);
          $s->src =  $image->src;
          break;
        }
      }

      // echo "<pre>";
      // print_r($data);
      // exit;

      $this->load->load_admin('reviews/productInner',$data);
    }
    public function reviewFilter()
    {
      $data = array();
      $product_id = $_GET['product_id'];
      $option = $this->input->post('option');
      $review = $this->ReviewModel->reviewFilter($option,  $product_id);

      json_send($review);
    }
    public function api()
    {}
}
