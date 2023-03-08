<?php

class Auth extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('AuthModel');
        $this->load->model('ReviewModel');
        $this->load->model('SettingModel');
    }

    //App Install View Page
    public function Install_login() {
      $this->load->view('auth/appinstall');
    }

    // public function access()
    // {
    //     $shop = $this->input->get('shop');
    //     if (isset($shop)) {
    //
    //         $data = $this->AuthModel->check($shop);
    //         if ($data) {
    //             $shop  = $this->input->get('shop');
    //             $shopAccess = getShop_accessToken_byShop($shop);
    //             // echo "<pre>";
    //             // print_r($data);
    //             // exit;
    //             $this->load->library('Shopify', $shopAccess);
    //             $url = base_url().'index.php/review/create?shop='.$shop;
    //             redirect($url, 'refresh');
    //         } else {
    //             $this->auth($shop);
    //         }
    //     } else {
    //         $this->auth($shop);
    //     }
    // }

    public function access() {
      $shop = $this->input->get('shop');
      if ($shop != '') {
        if ($this->db->table_exists('shopify_stores') === TRUE) {
          $this->auth($shop);
        } else {
          $this->CreateTable($shop);
        }
      } else {
        echo 'Unauthorized Access!';
  			exit;
        // redirect('Auth/Install_login');
      }
    }

    public function CreateTable($shop='')
    {
      $query = "CREATE TABLE `shopify_stores` (
        `id` int(11) NOT NULL,
        `token` varchar(100) DEFAULT NULL,
        `shop` varchar(100) DEFAULT NULL,
        `store_id` int(11) DEFAULT NULL,
        `domain` varchar(100) DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `active` tinyint(1) NOT NULL DEFAULT '1',
        `code` text,
        `hmac` text,
        `charge_id` varchar(100) DEFAULT NULL
      )";
      $this->db->query($query);
      $this->auth($shop);
    }

    public function auth($shop)
    {

        $data = array(
            'API_KEY' => $this->config->item('shopify_api_key'),
            'API_SECRET' => $this->config->item('shopify_secret'),
            'SHOP_DOMAIN' => $shop,
            'ACCESS_TOKEN' => ''
        );

        $this->load->library('Shopify', $data); //load shopify library and pass values in constructor

        $scopes = array('read_products', 'write_products','read_themes', 'write_themes','read_script_tags', 'write_script_tags');
        $redirect_url = $this->config->item('redirect_url'); //redirect url specified in app setting at shopify
        $paramsforInstallURL = array(
            'scopes' => $scopes,
            'redirect' => $redirect_url
        );

        $permission_url = $this->shopify->installURL($paramsforInstallURL);

        $this->load->view('auth/escapeIframe', ['installUrl' => $permission_url]);
    }

    public function authCallback()
    {
        $code = $this->input->get('code');
        $shop = $this->input->get('shop');

        if (isset($code)) {
            $data = array(
                'API_KEY' => $this->config->item('shopify_api_key'),
                'API_SECRET' => $this->config->item('shopify_secret'),
                'SHOP_DOMAIN' => $shop,
                'ACCESS_TOKEN' => ''
            );
            $this->load->library('Shopify', $data); //load shopify library and pass values in constructor
        }
        $accessToken = $this->shopify->getAccessToken($code);
        // $getdata = array(
        //     'shop' => $shop,
        //     'access_token' => $accessToken
        // );
        // $this->load->model('AuthModel');
        //$this->AuthModel->save_token($getdata);
        $this->updateAccess_Token($accessToken);
        if ($accessToken != '') {
          $this->charge_exist($shop);
          //redirect('Auth/home?shop=' . $shop);
        } else {
          redirect('Auth/Install_login');
        }
        //redirect('https://' . $shop . '/admin/apps');
    }

    public function charge_exist($shop = '') {

      if (!empty($shop)) {
  			$shop_details = $this->AuthModel->get_shop_details($shop);
  			if ($shop_details) {
  				if (empty($shop_details->charge_id)) {
  					redirect('Auth/CreateCharge?shop=' . $shop);
  				} else {
  					redirect('Auth/GetCharge?shop=' . $shop . '&charge_id=' . $shop_details->charge_id);
  				}
  			} else {
  				redirect('Auth/Install_login');
  			}
  		} else {
  			redirect('Auth/Install_login');
  		}
  	}

    public function CreateCharge() {
      if (isset($_GET['shop']) && !empty($_GET['shop'])) {
        $shop = $_GET['shop'];

        $price = 4.99;
        $plan = 1;
        $name = "Basic Plan";

        $shopAccess = getShop_accessToken_byShop($shop);
        $this->load->library('Shopify', $shopAccess);

        $data = array(
          "recurring_application_charge" => array(
            "name" => $name,
            "price" => $price,
            "trial_days" => 7,
            "return_url" => base_url('Auth/Charge_return_url?shop=' . $shop.'&plan_id='.$plan),
          ),
        );
        $year = getYear();
        $charge = $this->shopify->call(['METHOD' => 'POST', 'URL' => '/admin/api/'.$year.'/recurring_application_charges.json', 'DATA' => $data], true);

        if ($charge->recurring_application_charge) {
          $charge = $charge->recurring_application_charge;
          // echo "<pre>";
          // print_r($charge);
          // // $che['installUrl'] = $charge;
          // // prin
          $this->load->view('auth/escapeIframe', ['installUrl'=>$charge->confirmation_url]);
          // redirect($charge->confirmation_url);
        } else {
          redirect('Auth/Install_login');
        }
      } else {
        redirect('Auth/Install_login');
      }
    }

    public function Charge_return_url() {

      $shop = $_GET['shop'];
      $charge_id = $_GET['charge_id'];
      $plan_id = $_GET['plan_id'];
      if (!empty($shop)) {

        $shopAccess = getShop_accessToken_byShop($shop);
        $this->load->library('Shopify', $shopAccess);

        $data = array(
          "recurring_application_charge" => array(
            "id" => $charge_id,
            "status" => "accepted"
          ),
        );
        $year = getYear();
        $charge = $this->shopify->call(['METHOD' => 'POST', 'URL' => '/admin/api/'.$year.'/recurring_application_charges/' . $charge_id . '/activate.json', 'DATA' => $data], true);
        if ($charge) {
          $where = array('shop' => $shop);
          $data1 = array('charge_id' => $charge_id,"plan_id"=>$plan_id);
          $update = $this->AuthModel->UpdateShopDetails($where,$data1);
          if ($update) {
            redirect('Auth/AppLoader?shop=' . $shop);
          } else {
            $charge = $charge->recurring_application_charge;
            $data['installUrl'] = $charge->confirmation_url;
            $this->load->view('auth/escapeIframe', $data);
          }
        } else {
          redirect('Auth/Install_login');
        }
      }
    }

    public function CancelCharge(){
      $shop = $_GET['shop'];
      $shop_details = $this->AuthModel->get_shop_details($shop);
      $shopAccess = getShop_accessToken_byShop($shop);
      $this->load->library('Shopify', $shopAccess);

      $year = getYear();
      $cancel_charge_res = $this->shopify->call(['DELETE' => 'POST', 'URL' => '/admin/api/'.$year.'/recurring_application_charges/'.$shop_details->charge_id.'.json'], true);
      if ($cancel_charge_res) {
        $where = array('shop' => $shop);
        $data1 = array('charge_id' => '',"plan_id"=>0);
        $update = $this->AuthModel->UpdateShopDetails($where,$data1);
        redirect('Auth/AppLoader?shop=' . $shop);
      }
    }

    public function GetCharge() {
  		$shop = $_GET['shop'];
  		$charge_id = $_GET['charge_id'];

  		if (!empty($shop)) {
  			$shopAccess = getShop_accessToken_byShop($shop);
  			$this->load->library('Shopify', $shopAccess);
  			$year = getYear();
  			$charge = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/recurring_application_charges/' . $charge_id . '.json'], true);
  			if ($charge) {
  				$charge = $charge->recurring_application_charge;
  				$date2 = date_create(date('Y-m-d'));
  				$date1 = date_create($charge->trial_ends_on);
  				$diff = date_diff($date2, $date1);
  				$diff = (int) $diff->format("%R%a");

  				if ($charge->status != 'active') {
  					if ($diff < 0) {
  						redirect('Auth/CreateCharge?shop=' . $shop . '&charge_id=' . $charge_id . '&trial_days=0');
  					} else {
  						redirect('Auth/CreateCharge?shop=' . $shop . '&charge_id=' . $charge_id . '&trial_days=' . $diff);
  					}
  				} else {
  					redirect('Auth/AppLoader?shop=' . $shop);
  				}
  			}
  		}
  	}

    public function updateAccess_Token($accessToken) {
      if ($_GET['shop'] != '' && $_GET['code'] != '' && $_GET['hmac'] != '') {
        $shopdata = array('shop' => $_GET['shop'], 'code' => $_GET['code'], 'hmac' => $_GET['hmac']);
        $check_shop_exist = $this->AuthModel->check_ShopExist($_GET['shop']);
        if ($check_shop_exist) {
          $this->AuthModel->update_Shop($shopdata, $accessToken);
        } else {
          $this->AuthModel->add_newShop($shopdata, $accessToken);
        }
      }
    }

    public function add_default_setting() {
      if ($_GET['shop'] != '') {

        $check_setting_exist = $this->AuthModel->check_SettingExist($_GET['shop']);
        if ($check_setting_exist == 0) {
          $this->AuthModel->insertSetting($_GET['shop']);
        }else{
          $check_status = $this->AuthModel->check_shopstatus($_GET['shop']);
          if ($check_setting_exist == 1) {
            $this->AuthModel->updateshopstatusinstall($_GET['shop']);
          }
        }
        return true;
      }
    }

    public function createWebhook($shop='')
    {
      $shop = $this->input->get('shop');
      $accessData=getShop_accessToken_byShop($shop);
      $payload  = array(
          "webhook" => array(
              "topic" => "app/uninstalled",
              "address" => base_url()."Home/deleteScripts?shop=".$shop,
              "format" => "json"
        )
      );
      $year = getYear();
      $payload_address = $payload['webhook']['address'];
      if ($accessData['ACCESS_TOKEN']!='') {
          $this->load->library('Shopify', $accessData);
          $webhookCount = $this->shopify->call(['METHOD' => 'GET', 'URL' =>'/admin/api/'.$year.'/webhooks/count.json'], true);
          $webhook = $this->shopify->call(['METHOD' => 'GET', 'URL' =>'/admin/api/'.$year.'/webhooks.json'], true);
          if ($webhookCount->count > 0) {
            foreach ($webhook as $value) {
              $existing_address = $value[0]->address;
              if ($payload_address == $existing_address) {
                echo "Webhook already created for this address";
              }else {
                $this->shopify->call(['METHOD' => 'POST', 'URL' =>'/admin/api/'.$year.'/webhooks.json', 'DATA'=>$payload], true);
              }
            }
          }else{
            $this->shopify->call(['METHOD' => 'POST', 'URL' =>'/admin/api/'.$year.'/webhooks.json', 'DATA'=>$payload], true);
          }
      }
    }

    public function home() {
      $code = $this->input->get('code');
      $shop = $this->input->get('shop');
      if (empty($shop)) {
        echo 'Unauthorized Access!';
        exit;
      }
      $this->AppLoader($shop);
    }

    public function AppLoader($shop='') {
      $shop = $this->input->get('shop');
      if (empty($shop)) {
        echo 'Unauthorized Access!';
        exit;
      }
      if (isset($shop)) {
        if ($shop != '') {
          $accessData = getShop_accessToken_byShop($shop);
          if (count($accessData) > 0) {
            if ($accessData['ACCESS_TOKEN'] != '') {
              $data['access_token'] = $accessData['ACCESS_TOKEN'];
              $this->add_default_setting();
              $this->addScript();
              $this->createWebhook($shop);
              redirect('ReviewController/productList?shop='.$shop);
            } else {
              redirect('Auth/Install_login');
            }
          } else {
            redirect('Auth/Install_login');
          }
        }
      } else {
        redirect('Auth/Install_login');
      }
    }
    public function addScript() {
    $shop       = $_GET['shop'];
    $year = getYear();
    // echo $_GET['shop'];
    // print_r($shop);
    $shopAccess = getShop_accessToken_byShop($shop);

    $this->load->library('Shopify', $shopAccess);

    // Run themes api in order to get all the themes info installed in the store
    $themes = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes.json']);

    $themes_array = $themes->themes;

    // Get published theme id
    $theme_id;
    foreach ($themes_array as $theme) {
      if ($theme->role == "main") {
        $theme_id = $theme->id;
      }
    }

    $check_reviewform_exist = $this->AuthModel->check_reviewFormExist($_GET['shop']);
    if ($check_reviewform_exist) {

      $data = array();
      $data['setting'] = $this->SettingModel->getformsetting($shop);
      $setting = $data['setting'];
      if ($setting->enable_review_form == 1) {
          $enable_review_form = 'style="display: block"';
      } else {
          $enable_review_form = 'style="display: none"';
      }
      // echo "<pre>";
      // print_r($setting->show_form_on_load);
      // exit;
      $reviewform_script = '<div '.$enable_review_form.'>
                          <head>
                      <link href=' .  base_url('assets/css/main.css') . ' type="text/css" rel="stylesheet">
                      <link href=' . base_url('assets/css/custome.css') . ' type="text/css" rel="stylesheet">
                      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
                      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

                  </head>';
          if ($setting->show_form_on_load == 1) {
              $show = 'style="display: block"';
          } else {
              $show = 'style="display: none"';
          }
          if ($setting->show_powered_by == 1) {
              $show_powered_by = 'style="display: block"';
          } else {
              $show_powered_by = 'style="display: none"';
          }

          if ($setting->shop_status == 'Installed') {
              $show_form = 'style="display: block"';
          } else {
              $show_form = 'style="display: none"';
          }

          if ($setting->auto_publish == 1) {
              $state = 'published';
          } else {
              $state = 'unpublished';
          }
          $col = $setting->show_powered_by == 1? '6':'12';
          $reviewform_script .= '
      <section class="review-bg-white" id="review-bg-white" '.$show_form.'>
      <div id="spinner" style="display:none"><center><img style="width:100px" src="https://cdn.lowgif.com/small/ee5eaba393614b5e-pehliseedhi-suitable-candidate-suitable-job.gif" /></center></div>
       <div class="review-container" id="review-container" style="display:none">
           <div class="review-row">
               <div class="review-col-md-12 review-mx-auto review-border review-px-4 review-py-3">
                   <div>
                       <div class="review-row" >
                          <div class="review-col-'.$col.'">
                              <h1 class="review-pb-3 spr-header-title">' .$setting->review_headline . '</h1>
                          </div>

                         <div class="review-col-6 review-text-right" '.$show_powered_by.'>
                          <a href=""><p>Powered by Stensiled Product Review</p></a>
                         </div>
                      </div>

                       <div class="review-row">
                           <div class="review-col-xs-12 review-col-sm-12 review-col-md-3 review-col-lg-3">
                           <input type="hidden" value="' . $setting->summary_with_no_review . '" name="summary_with_no_review" id="summary_with_no_review">
                               <div class="review-row" id="reviewcount">
                               <div id="spinner" style="display:none"><img style="width:100px" src="https://cdn.lowgif.com/small/ee5eaba393614b5e-pehliseedhi-suitable-candidate-suitable-job.gif" /></div>
                               </div>
                           </div>
                           <div class="review-col-xs-12 review-col-sm-12 review-col-md-6  review-col-lg-6">
                           <ul class="review_graph review-p-0 review-m-0" id="reviewcountarea">

                           </ul>
                           </div>
                           <div class="review-col-xs-12 review-col-sm-12  review-col-md-3 review-col-lg-3 review-text-md-right review-text-lg-right review-pt-3">';
                           if ($setting->customer_logged_in == 1) {
                            $reviewform_script .='{% if customer %}
                                <button id="show_review_form"  class="btn review-mb-3">Write a review</button>
                              {% else %}
                                <a href="https://{{ shop.permanent_domain }}/account"  class="btn review-mb-3">Write a review</a>
                              {% endif %}';

                           } else {
                               $reviewform_script .='<button id="show_review_form"  class="btn review-mb-3">' . $setting->review_link . '</button>';
                           }
                           $reviewform_script .='
                              <div>
                                 <select class="reviewFilter  review-mb-3" style="width: 172px;">
                                    <option value="most-recent">Most Recent</option>
                                    <option value="highest-rating">Highest Rating</option>
                                    <option value="lowest-rating">Lowest Rating</option>
                                </select>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div id="message" style="display:none;">
                     <hr></hr><p style=\"font-size:16px;color:#28a745;font-weight:600; \">Thanks You! Your review has been submitted.</p>
                   </div>

                   <div id="review_form" ' . $show . '>
                   <div style="height:1px; background:rgb(236, 236, 236)"></div>
                       <h6 class="review-pt-3">' . $setting->review_form_title . '</h6>
                       <form id="form" action="'.base_url().'review/store?product_id={{ product.id }}">
                       <p class= "review-text-danger" id="error"></p>
                           <input type="hidden" value="{{ product.id }}" name="product_id" id="product_id">
                           <input type="hidden" value="{{ product.title }}" name="product_title" id="product_title">
                           <input type="hidden" name="starRating" value="'. base_url() ."ReviewController/getreviewcount?product_id=". '{{ product.id }}">
                           <input type="hidden" value="{{ image.src | product_img_url: \'300x\' }}" name="product_img_url" id="product_img_url">
                           <input type="hidden" value="' . $setting->auto_publish . '" name="auto_publish" id="auto_publish">
                           <input type="hidden" value="' . $state . '" name="state" id="state">
                           <input type="hidden" value="' . $setting->report_as_inappropriate . '" name="report_as_inappropriate" id="report_as_inappropriate">
                           <input type="hidden" value="' . $setting->report_as_inappropriate_mgs . '" name="report_as_inappropriate_mgs" id="report_as_inappropriate_mgs">
                           <input type="hidden" value="'.$_GET['shop'].'" name="shop" id="shop">
                           <input type="hidden" value="'.$setting->customer_logged_in.'" id="shopform">
                           <div class="review-form-group">
                               <label for="name" class="spr-form-label">' . $setting->author_name . '</label>
                               <input type="text" class="review-form-control" name="name" id="name" value="" placeholder="' . $setting->author_name_help_msg . '" required>
                           </div>
                           <div class="review-form-group">
                               <label for="email" class="spr-form-label">' . $setting->author_email . '</label>
                               <input type="email" class="review-form-control" name="email" value="" id="email" placeholder="' . $setting->author_email_help_msg . '" required>

                           </div>
                           <div class="review-form-group">
                               <input type="hidden" value="" name="rating" id="rating">
                               <label for="rating" class="spr-form-label">' . $setting->review_rating . '</label>
                               <div class="rating-stars">
                                   <ul id="stars">
                                       <ul id="stars">
                                           <li class="star" title="Poor" data-value="1">
                                               <i class="fa fa-star fa-fw"></i>
                                           </li>
                                           <li class="star" title="Fair" data-value="2">
                                               <i class="fa fa-star fa-fw"></i>
                                           </li>
                                           <li class="star" title="Good" data-value="3">
                                               <i class="fa fa-star fa-fw"></i>
                                           </li>
                                           <li class="star" title="Excellent" data-value="4">
                                               <i class="fa fa-star fa-fw"></i>
                                           </li>
                                           <li class="star" title="WOW!!!" data-value="5">
                                               <i class="fa fa-star fa-fw"></i>
                                           </li>
                                       </ul>
                                   </ul>
                               </div>
                           </div>
                           <div class="review-form-group">
                               <label for="review_title" class="spr-form-label">' . $setting->review_title . '</label>
                               <input class="review-form-control" value="" id="review_title" type="text" name="review_title" placeholder="' . $setting->review_title_help_msg . '" autocomplete="off" required>

                           </div>
                           <div class="review-form-group">
                               <label for="review_image" class="spr-form-label">Review image</label>
                             <input type="file"  class="review-form-control" id="review_image" name="review_image[]"  autocomplete="off"  multiple accept=".jpg, .png, .gif" >
                           </div>
                           <div class="review-form-group">
                               <label for="body_of_review" class="spr-form-label">' . $setting->review_body . '</label>
                               <textarea class="review-form-control" id="body_of_review" name="body_of_review" rows="5" placeholder="' . $setting->review_body_help_msg . '" required></textarea>
                           </div>
                           <div class="review-form-group">
                               <button class="review-btn review-btn-success" type="submit" class="submit" id="save">' . $setting->submit_button . '</button>
                           </div>
                       </form>

                   </div>

               </div>
           </div>';
           $url = base_url()."ReviewController/getreviewbyproduct?product_id={{ product.id }}";


     $reviewform_script .="
        <div class='review-row'>
           <div class='review'>
           <input type='hidden' name='report_url' id='report_url' value='". base_url() .'ReviewController/setStatusFlagged?id='."'>
             <input type='hidden' name='product_id' value='{{ product.id }}' data-url='". base_url() .'ReviewController/getreviewbyproduct?product_id='. "{{ product.id }}'>
             <input type='hidden' name='layout' value='$setting->layout'/>
             <input type='hidden' id='str_img' value='".base_url('assets/img/uploads')."'>
             <input type = 'hidden' id='status_url' value='". base_url() .'ReviewController/getstatus?shop='.$_GET['shop']."'>
           </div>
         </div>
         <div id='reviewDiv'>
           <div class='review-row' id=\"static-pagination-list\">

           </div>
         </div>
         <nav aria-label=\"Page navigation\">
            <ul id=\"static-pagination\" class=\"review-pagination review-justify-content-center review-mt-5\">
            </ul>
        </nav>
      </div>
  </section>
     ";
          $reviewform_script .= "

          <script>
          function report(id)
          {
            var report_url = $('.review input[name=\"report_url\"]').val();
            var reportLink = $('span#reportLink_' + id);
            var reportText = $('#report_as_inappropriate_mgs').val();
            url = report_url + id;
            // alert(reportLink);
            if (confirm(\"Are you sure you want to report this review as inappropriate?\")) {
              $.ajax({
                 url:url,
                 type: 'GET',
                 dataType: 'JSON',
                 error: function() {
                     alert('Something is wrong');
                   },
                   success: function(data) {
                     console.log(data);
                     reportLink.text(reportText);
                   }
                });
            }
          }
          function showreply(id)
          {
            $(window).unbind('scroll');
            var txt = $('#replyDiv_' + id).is(':visible') ? 'View reply' : 'Hide reply';
            var replyDiv = $('#replyDiv_' + id);
            // alert(replyDiv);
            $('#replyDivLink_' + id).text(txt);
            replyDiv.slideToggle();
          }
          // script for Pagination
          let _currentPage, _perPage, _showPage, _paginationLength, staticPaginationList;

          let list = $('#static-pagination-list');
          let pagination = $('#static-pagination');
          function staticPagination(userList, userOptions) {
              staticPaginationList = userList;
          console.log(staticPaginationList);
              if (userOptions.perPage != null) {
                  _perPage = userOptions.perPage;
              } else {
                  _perPage = 10;
              }

              if (userOptions.showPage != null) {
                  _showPage = userOptions.showPage;
              } else {
                  _showPage = 10;
              }
              _paginationLength = parseInt(staticPaginationList.length / _perPage) + 1;
              _staticPagination(1);
          }


          function _staticPagination(page) {
              if (page === 0 && _currentPage !== 1) {
                  // 이전 (previous)
                  _staticPagination(_currentPage - 1);
              } else if (page === _paginationLength + 1 && _currentPage !== _paginationLength + 1) {
                  // 다음 (next)
                  _staticPagination(_currentPage + 1);
              } else {
                  // 일반 선택 (normal select)
                  _currentPage = page;
                  list.empty();
                  for (let i = _currentPage * _perPage - _perPage; i < _currentPage * _perPage; i++) {
                      try {
                        var str = staticPaginationList[i].name;
                        var firstletter = str.charAt(0);
                        var html ='';
                        var layout = $('.review input[name=\"layout\"]').val();
                        var shop = $('#shop').val();
                        var report_as_inappropriate = $('#report_as_inappropriate').val();
                        var str_img = $('.review #str_img').val();
                        console.log(layout);
                        if(layout == \"list\")
                        {
                            html +='<div class=\"review-col-xs-12  review-col-sm-12 review-col-md-12 review-col-lg-12  review-px-0 \" > ';
                            html += '<div style=\"display:  block;background: #fcfcfc;padding: 1em 1em;font-size: 17px;;margin: auto;border-bottom: 1px solid black;border-top: 1px solid black;\" class=\"gallery \">';
                            html += '<div style=\"margin-bottom: 1em;\">';
                            html += '<div style=\"width: auto;display: inline-block;vertical-align: middle;\">';
                            html += '<figure style=\"width: 60px;height: 60px;display: inline-block;vertical-align: middle;margin: 0;padding: 0;position: relative;border-radius: 50%;-webkit-border-radius: 50%;-moz-border-radius: 50%;overflow: hidden;margin-right: 10px;background-color: #e6e6e6;text-align: center;\">';
                            html += '<span style=\"width: 100%; font-size: 30px; font-weight: 600; line-height: inherit; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); -webkit-transform: translate(-50%, -50%); -moz-transform: translate(-50%, -50%); -o-transform: translate(-50%, -50%); -ms-transform: translate(-50%, -50%);\">' + firstletter + '</span>';
                            html += '</figure>';
                            html += '</div>';
                            html += '<div style=\"width: 68%;display: inline-block;vertical-align: middle;text-align: left;\">';
                            html += '<div style=\"width: 100%;display: inline-block;vertical-align: middle;padding-bottom: 5px;\">';
                            html += '<h6 style=\"width: auto;display: inline-block;vertical-align: middle;font-size: 20px;line-height: inherit;padding: 0;padding-right: 4px;margin: 0 !important;\">' + staticPaginationList[i].name + '</h6>';
                            html += '</div>';
                            html += '<div style=\"width: 100%; display: inline-block; vertical-align: middle;\">';
                            html += '<div style=\"width: auto;display: inline-block; vertical-align: middle;\">';
                            for (j = 1; j <= 5; j++) {
                                if(staticPaginationList[i].rating >= j)  {
                                html +=  '<i class=\"fa fa-star\"></i>';
                                }else{
                                html += '<i class=\"fa fa-star-o\" aria-hidden=\"true\"></i>';
                                }
                            }
                            html += '</div>';
                            html += '<span style=\"padding-left: 8px;width: auto; display: inline-block; vertical-align: bottom; font-size: 12px; line-height: inherit;\">' + staticPaginationList[i].created_at + '</span>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '<div style=\"height: auto;\"  class=\"gallery-block grid-gallery\"> ';
                            html += '<div class=\"review-row\"> ';
                            html += '<div class=\"review-col-12 review-mb-3\"> ';
                            html += '<h4 style=\"width: 100%;float: left;margin: 0;padding-bottom: 10px;text-align: left;border: none;font-size: 25px;font-weight: 600;padding-left: 10px;\">' + staticPaginationList[i].review_title + '</h4> ';
                            html += '<p style=\"font-size: 17px;line-height: 20px;margin: 0;width: 100%;float: left;text-align: left;word-wrap: break-word;white-space: normal;padding-left: 10px;\">' + staticPaginationList[i].body_of_review + '</p> ';
                            html += '</div> ';
                            html += '</div> ';
                            var review_image = staticPaginationList[i].review_image;
                            var images = review_image.split(\",\");
                            // console.log(images);
                            var images_count = images.length;
                              // console.log(images.length);
                            if( staticPaginationList[i].review_image != '' ){
                            html += '<div class=\"review-col-12 review-row\">';
                              for(d = 0; d<images_count; d++)
                              {
                              html += '<div class=\"review-col-md-1 review-col-lg-1 item review-p-1\">';
                              html += '<a class=\"lightbox\" href=\" '+ str_img + '/'+ images[d] +' \" target=\"_blank\"> ';
                              html += '<img class=\"review-img-fluid image\" src=\" '+ str_img + '/' +  images[d] +' \">';
                              html += '</a> ';
                              html += '</div>';
                              }
                              html += '</div>';
                            }
                            html += '</div>';
                            if( staticPaginationList[i].reply != '' ){
                            html += '<div style=\" text-align: right;\"><button type=\"button\" style=\"  color: crimson;background: transparent; border: none; \" onclick=\"showreply('+ staticPaginationList[i].id +')\" id=\"replyDivLink_' + staticPaginationList[i].id +'\">View reply</button></div>';
                            html += '<div style=\"padding-left: 10px;display:none;\" id=\"replyDiv_' + staticPaginationList[i].id +'\">';
                            html += '<div style=\"padding: 1em;text-align: right;background: beige;\">';
                            html += '<p style=\"margin: 0;margin: 5px 0;\">'+ staticPaginationList[i].reply +'</p>';
                            html += '<span style=\"font-style: italic;\">'+ '&#8211;' + ' ' + shop +'</span>';
                            html += '</div>';
                            html += '</div>';
                          }
                            html += '<div style=\"text-align: right;font-size: 14px;padding: 10px;\">';
                            html += '<span id=\"reportLink_' + staticPaginationList[i].id +'\"><a type=\" button\" style=\"color: blue;\" class=\"report\" data-id=\"' + staticPaginationList[i].id +'  \" onclick=\"  report('+staticPaginationList[i].id+');\">' + report_as_inappropriate + '</a></span>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                        }
                        if(layout == \"grid\")
                        {
                        html +='<div class=\"review-col-xs-12  review-col-sm-12 review-col-md-4 review-col-lg-4  review-px-0  \"> ';
                        html += '<div style=\"display:  block;background: #fcfcfc;padding: 1em 1em;font-size: 17px;width: 97.4%;margin: auto;border-bottom: 1px solid black;border-top: 1px solid black;\">';
                        html += '<div style=\"margin-bottom: 1em;\">';
                        html += '<div style=\"width: auto;display: inline-block;vertical-align: middle;\">';
                        html += '<figure style=\"width: 60px;height: 60px;display: inline-block;vertical-align: middle;margin: 0;padding: 0;position: relative;border-radius: 50%;-webkit-border-radius: 50%;-moz-border-radius: 50%;overflow: hidden;margin-right: 10px;background-color: #e6e6e6;text-align: center;\">';
                        html += '<span style=\"width: 100%; font-size: 30px; font-weight: 600; line-height: inherit; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); -webkit-transform: translate(-50%, -50%); -moz-transform: translate(-50%, -50%); -o-transform: translate(-50%, -50%); -ms-transform: translate(-50%, -50%);\">' + firstletter + '</span>';
                        html += '</figure>';
                        html += '</div>';
                        html += '<div style=\"width: 68%;display: inline-block;vertical-align: middle;text-align: left;\">';
                        html += '<div style=\"width: 100%;display: inline-block;vertical-align: middle;padding-bottom: 5px;\">';
                        html += '<h6 style=\"width: auto;display: inline-block;vertical-align: middle;font-size: 20px;line-height: inherit;padding: 0;padding-right: 4px;margin: 0 !important;\">' + staticPaginationList[i].name + '</h6>';
                        html += '</div>';
                        html += '<div style=\"width: 100%; display: inline-block; vertical-align: middle;\">';
                        html += '<div style=\"width: auto;display: inline-block; vertical-align: middle;\">';
                        for (j = 1; j <= 5; j++) {
                            if(staticPaginationList[i].rating >= j)  {
                            html +=  '<i class=\"fa fa-star\"></i>';
                            }else{
                            html += '<i class=\"fa fa-star-o\" aria-hidden=\"true\"></i>';
                            }
                        }
                        html += '</div>';
                        html += '<span style=\"padding-left: 8px;width: auto; display: inline-block; vertical-align: bottom; font-size: 12px; line-height: inherit;\">' + staticPaginationList[i].created_at + '</span>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div style=\"height: auto;\"  class=\"gallery-block grid-gallery\"> ';
                        html += '<div class=\"review-row\"> ';
                        html += '<div class=\"review-col-12 review-mb-3\"> ';
                        html += '<h4 style=\"width: 100%;float: left;margin: 0;padding-bottom: 10px;text-align: left;border: none;font-size: 25px;font-weight: 600;padding-left: 10px;\">' + staticPaginationList[i].review_title + '</h4> ';
                        html += '<p style=\"font-size: 17px;line-height: 20px;margin: 0;width: 100%;float: left;text-align: left;word-wrap: break-word;white-space: normal;padding-left: 10px;\">' + staticPaginationList[i].body_of_review + '</p> ';
                        html += '</div> ';
                        html += '</div> ';
                        var review_image = staticPaginationList[i].review_image;
                        var images = review_image.split(\",\");
                        // console.log(images);
                        var images_count = images.length;
                          // console.log(images.length);
                        if( staticPaginationList[i].review_image != '' ){
                        html += '<div class=\"review-col-12 review-row\">';
                        for(d = 0; d<images_count; d++)
                        {
                        html += '<div class=\"review-col-md-3 review-col-lg-3 item review-p-1\">';
                        html += '<a class=\"lightbox\" href=\" '+ str_img + '/'+ images[d] +' \" target=\"_blank\"> ';
                        html += '<img class=\"review-img-fluid image review-img\" src=\"'+ str_img + '/'+ images[d] +' \">';
                        html += '</a> ';
                        html += '</div>';
                       }
                        html += '</div>';
                        }
                        html += '</div>';
                        if( staticPaginationList[i].reply != '' ){
                        html += '<div style=\" text-align: right;\"><button type=\"button\" style=\"  color: crimson;background: transparent; border: none; \" onclick=\"showreply('+ staticPaginationList[i].id +')\" id=\"replyDivLink_' + staticPaginationList[i].id +'\">View reply</button></div>';
                        html += '<div style=\"padding-left: 10px;display:none;\" id=\"replyDiv_' + staticPaginationList[i].id +'\">';
                        html += '<div style=\"padding: 1em;text-align: right;background: beige;\">';
                        html += '<p style=\"margin: 0;margin: 5px 0;\">'+ staticPaginationList[i].reply +'</p>';
                        html += '<span style=\"font-style: italic;\">'+ '&#8211;' + ' ' + shop +'</span>';
                        html += '</div>';
                        html += '</div>';
                      }
                        html += '<div style=\"text-align: right;font-size: 14px;padding: 10px;\">';
                        html += '<span id=\"reportLink_' + staticPaginationList[i].id +'\"><a type=\" button\" style=\"color: blue;\" class=\"report\" data-id=\"' + staticPaginationList[i].id +'  \" onclick=\"  report('+staticPaginationList[i].id+');\">' + report_as_inappropriate+ '</a></span>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        }
                          // list 추가, example 확인 (list append, Please refer to example for this)
                          list.append(html);
                      } catch (exception) {
                          break;
                      }
                  }
              }

              if (_paginationLength > 1) {
                  pagination.empty();
                  if (_currentPage === 1) {
                      pagination.append('<li class=\"review-page-item\">' +
                          '<a class=\"review-page-link\" href=\"#/\" onclick=\"_staticPagination(' + 0 + ');\" style=\"color: #6c757d; pointer-events: none; cursor: auto; background-color: #fff; border-color: #dee2e6;\">' +
                          '<' +
                          '</a>' +
                          '</li>');
                  } else {
                      pagination.append('<li class=\"review-page-item\">' +
                          '<a class=\"review-page-link\" href=\"#/\" onclick=\"_staticPagination(' + 0 + ');\">' +
                          '<' +
                          '</a>' +
                          '</li>');
                  }

                  for (let _page = 1; _page <= _paginationLength; _page++) {
                      if (_page === _currentPage) {
                          pagination.append('<li class=\"review-page-item\">' +
                              '<a class=\"review-page-link\" href=\"#/\" onclick=\"_staticPagination(' + _page + ');\" style=\"z-index: 3; color: #fff; background-color: #007bff; border-color: #007bff;\">' + _page + '</a>' +
                              '</li>');
                      } else {
                          pagination.append('<li class=\"review-page-item\">' +
                              '<a class=\"review-page-link\" href=\"#/\" onclick=\"_staticPagination(' + _page + ');\">' + _page + '</a>' +
                              '</li>');
                      }
                  }

                  if (_currentPage === _paginationLength) {
                      pagination.append('<li class=\"review-page-item \">' +
                          '<a class=\"review-page-link\" href=\"#/\" onclick=\"_staticPagination(' + (_paginationLength + 1) + ');\" style=\"color: #6c757d; pointer-events: none; cursor: auto; background-color: #fff; border-color: #dee2e6;\">' +
                          '>' +
                          '</a>' +
                          '</li>');
                  } else {
                      pagination.append('<li class=\"review-page-item\">' +
                          '<a class=\"review-page-link\" href=\"#/\" onclick=\"_staticPagination(' + (_paginationLength + 1) + ');\">' +
                          '>' +
                          '</a>' +
                          '</li>');
                  }
              }
          }


          $(document).ready(function() {
            $('#review-bg-white').hide()
            $('#spinner').hide();
            var urlstatus=$('#status_url').val();
            $.ajax({
               url:urlstatus,
               type: 'GET',
               dataType: 'JSON',
               error: function() {
                  console.log(urlstatus,'something went wrong')
                 },
                 success: function(data) {
                   //alert(data)
                   if(data == 'Installed'){
                     $('#spinner').show();
                     $('#review-bg-white').show()
                   }else{
                     $('#review-bg-white').hide()
                   }
                 }
              });


            var showform = $('#shopform').val();
            var customer = '{{ customer }}';
            if(showform ==1){
              if(customer){
                  $('#review_form').show();
              }else{
                  $('#review_form').hide();
              }
          }
              loadreview();
              function loadreview(){
                var html = '';
              var str_img = $('.review #str_img').val();
              var DataURL = $('.review input[name=\"product_id\"]').data('url');
              var layout = $('.review input[name=\"layout\"]').val();
              var shop = $('#shop').val();
              var summary_with_no_review = $('#summary_with_no_review').val();
              console.log(layout);
               $.ajax({
                  url:DataURL,
                  type: 'GET',
                  dataType: 'JSON',
                  async: true,
                  beforeSend: function() { $('#review-bg-white #review-container').hide(); $('#review-bg-white #spinner').show();},
                  complete: function() { $('#review-bg-white #spinner').hide(); $('#review-bg-white #review-container').show();},
                  error: function() {
                      alert('Something is wrong');
                    },
                    success: function(data) {
                      // passing data for pagination
                      staticPagination(data.review, {
                          perPage: 3
                      });
                      console.log(data.ratingCounts);
                      //passing data rating parameter
                      ratingCount(data.ratingCounts, data.review);
                      var html = '';
                      var i; var j ; var avg;
                      var reviewcount = data.review.length;
                      console.log(reviewcount);
                      if(reviewcount > 0)
                      {
                        var value = '';var sum = 0;
                        for(i=0; i<reviewcount; i++){
                          sum = parseInt(sum) + parseInt(data.review[i].rating);
                        }

                        avg = sum/reviewcount;
                        value +=  '<div class=\"review-col-xs-3 review-col-sm-3 review-col-md-12 review-col-lg-12  review-pr-xs-0 review-pr-sm-0 \">';
                        for (j = 1; j <= 5; j++) {
                            if(avg >= j)  {
                            value +=  '<i class=\"fa fa-star\"></i>';
                            }else{
                            value += '<i class=\"fa fa-star-o\" aria-hidden=\"true\"></i>';
                            }
                        }
                        value += '</div>';
                        value +=  '<div class=\"review-col-xs-9 review-col-sm-9 review-col-md-12 review-col-lg-12 review-pl-xs-0 review-pl-sm-0 \">';
                        value += 'Based on ' + reviewcount + ' reviews' ;
                        value += '</div>'
                        $('#reviewcount').html(value);
                      }
                      else{
                          $('#reviewcount').text(summary_with_no_review);
                      }


                    }
                  });
            } //loading() ends here

            // function ratingCount stsrt here
            function ratingCount(ratingArray,reviewArray)
            {
              var reviewscounthtml = '';var count,j;
              var reviewcountarea = $('#reviewcountarea');
              //empty before appending data
              reviewcountarea.empty();
              console.log(reviewcountarea);
              for(count = 0; count<ratingArray.length; count++)
              {
                 reviewscounthtml = '<li class=\"star_graph_li wc_wf_cls review-list-unstyled\" >';
                 reviewscounthtml += '<div class=\"rating_filter\" >';
                 reviewscounthtml +=        '<ul class=\"review-list-inline\">';
                 reviewscounthtml +=            '<li class=\"review-list-inline-item\">';
                 reviewscounthtml +=                '<div class=\"graph_star\">';
                 for (j = 5; j > 0; j--) {
                     if(count < j)  {
                     reviewscounthtml +=  '<i class=\"fa fa-star\"></i>';
                     }else{
                     reviewscounthtml += '<i class=\"fa fa-star-o\" aria-hidden=\"true\"></i>';
                     }
                 }
                 reviewscounthtml +=                '</div>';
                 reviewscounthtml +=          '</li>';
                 reviewscounthtml +=            '<li class=\"review-list-inline-item\">';
                 reviewscounthtml +=                '<div class=\"graph_value\">';
                 var showgraph = '';var rating = ''; var ratingPer;
                 var ratingVar = ratingArray[count];
                 if(ratingArray[count]== 0){  showgraph = 'visibility: hidden;' }
                 if(ratingVar == 0){  rating = 0 } else{ ratingcopy = ratingArray[count]; rating = Math.round(ratingcopy) ; }
                 if(ratingVar == 0 )
                 {  ratingPer = 0 }
                 else{ ratingPercopy = (ratingArray[count]/reviewArray.length)*100;  ratingPer = Math.round(ratingPercopy); }

                 reviewscounthtml +=                    '<div class=\"progress\" style=\"width: 100px; border-radius: 0;' + showgraph +'\">';
                 reviewscounthtml +=                      '<div class=\"progress-bar\" role=\"progressbar\" aria-valuenow=\"100\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width:'+ ratingPer +'%\">';
                 reviewscounthtml +=                  '<span class=\"sr-only\" style=\" color:transparent\">'+ ratingPer +'%</span></div>';
                 reviewscounthtml +=                '</div>';
                 reviewscounthtml +=            '</li>';
                 reviewscounthtml +=            '<li class=\"review-list-inline-item\">';
                 reviewscounthtml +=                '<div class=\"graph_per_count\"> <ul class=\"review-list-inline\">';
                 reviewscounthtml +=                    '<li class=\" review-list-inline-item\"><div class=\"graph_bar_persent review-pr-3\" style=\"width:50px \">'+ ratingPer +'%</div></li>';
                 reviewscounthtml +=                    '<li class=\" review-list-inline-item\"><div class=\"graph_review_count\">('+ rating +')</div><li>';
                 reviewscounthtml +=                '</ul></div>';
                 reviewscounthtml +=            '</li>';
                 reviewscounthtml +=        '</ul>';
                 reviewscounthtml +=    '</div>';
                 reviewscounthtml +='</li>';
                 reviewcountarea.append(reviewscounthtml);
                }//end for loop here of rating counter
            }//end of function ratingCount()

            //  subitting the review form
                $('#form').submit(function(e) {
                    e.preventDefault();
                    var myForm = document.getElementById('form');
                    var form_data = new FormData(myForm);
                    var url = $('#form').attr('action');

                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        processData:false,
                        contentType:false,
                        cache:false,
                        data: form_data,
                        beforeSend: function() { $('#save').addClass('spinner'); },
                        complete: function() { $('#save').removeClass('spinner');},
                        success: function(data) {
                          console.log(data);
                            $('#form').each(function() {
                                this.reset();
                            });

                            $('#review_form').hide(function(){
                                $('#message').show();
                            });

                            loadreview();
                        }
                    })

                    return false;

                });
            //  ends submitting the review form

              $('.reviewFilter').change(function(){
                //get the selected value
                var html = '';
              var DataURL = $('.review input[name=\"product_id\"]').data('url');
              var layout = $('.review input[name=\"layout\"]').val();
              var shop = $('#shop').val();
              var summary_with_no_review = $('#summary_with_no_review').val();
              var report_as_inappropriate = $('#report_as_inappropriate').val();
               var selectedValue = $('.reviewFilter option:selected').val()  ;
               var product_id = $('#product_id').val();
               var url = '". base_url() ."' + 'ReviewController/reviewFilter?product_id=' + product_id;
               $.ajax({
                     url: url,
                     type: 'POST',
                     data: {option : selectedValue},
                     success: function(review) {
                         console.log(review.length);
                         // passing data for pagination
                         staticPagination(review, {
                             perPage: 3
                         });
                     }
                 });
              });
              //review filter ends here

                  $('#show_review_form').click(function() {
                      $('#review_form').slideToggle();
                  });

                 /* 1. Visualizing things on Hover - See next part for action on click */
                 $('#stars li').on('mouseover', function() {
                     var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

                     // Now highlight all the stars that's not after the current hovered star
                     $(this).parent().children('li.star').each(function(e) {
                         if (e < onStar) {
                             $(this).addClass('hover');
                         } else {
                             $(this).removeClass('hover');
                         }
                     });

                 }).on('mouseout', function() {
                     $(this).parent().children('li.star').each(function(e) {
                         $(this).removeClass('hover');
                     });
                 });


                 /* 2. Action to perform on click */
                 $('#stars li').on('click', function() {
                     var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                     var stars = $(this).parent().children('li.star');

                     for (i = 0; i < stars.length; i++) {
                         $(stars[i]).removeClass('selected');
                     }

                     for (i = 0; i < onStar; i++) {
                         $(stars[i]).addClass('selected');
                     }

                     // JUST RESPONSE (Not needed)
                     var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
                     $('#rating').val(ratingValue);


                 });

           });

</script>

</div>" ;

         $reviewform_params = array(
           'asset' => array(
             "key" => "snippets/reviewform.liquid",
             "value" => $reviewform_script
           )
         );

         $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/'.$theme_id.'/assets.json', 'DATA' => $reviewform_params], true);
         $where = array('shop' => $shop);
         $data1 = array('is_reviewform' => 1);
         $this->AuthModel->UpdateShopDetails($where,$data1);

    }

    // Get contents of product.liquid
    $product_template_contents = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/'.$theme_id.'/assets.json?asset[key]=sections/product-template.liquid'], true);
    $product_template_contents = $product_template_contents->asset->value;

    // Custom script
    $custom_script = "<div>       {% include 'reviewform' %}    </div> ";

    if (strpos($product_template_contents, $custom_script) !== false) {
      return;
    }

    $params = array(
      'asset' => array(
        "key" => "sections/product_template_backup.liquid",
        "source_key" => "sections/product-template.liquid"
      )
    );
    // Run backup api
    $product_backup = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/'.$theme_id.'/assets.json', 'DATA' => $params], true);
      // concatinate product-template.liquid and custom script
      $new_product_template_contens = $product_template_contents . PHP_EOL  . $custom_script;

      $params = array(
        'asset' => array(
          "key" => "sections/product-template.liquid",
          "value" => $new_product_template_contens
        )
      );

      // Finally create a button
      $product_template = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/'.$theme_id.'/assets.json', 'DATA' => $params], true);
}

}
