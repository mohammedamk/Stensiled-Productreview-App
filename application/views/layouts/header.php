<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css'>
    <link href="<?php echo base_url('assets/css/main.css') ?>" type="text/css" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/custome.css') ?>" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css" />
    <!-- <link href="<?php //echo site_url(); ?>assets/css/seaff.css" type="text/css" rel="stylesheet"> -->
    <link rel='stylesheet' href='//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css'>
    <link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css'>
    <link rel='stylesheet' href='https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
	   <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
     <!-- toggle button-->
     <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
     <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

     <script type="text/javascript">
         ShopifyApp.init({
            apiKey: '<?php echo $this->config->item('shopify_api_key'); ?>',
            shopOrigin: '<?php echo 'https://'.$_GET['shop'];?>'
        });
    </script>
  </head>
</head>

<body>

         <div class="custom--header border-bottom sticky-top">
        <div class="d-flex pt-2 pb-2 pl-4 pr-4">
          <div class="mr-auto mt-auto mb-auto">
            <h1 class="custom--heading m-0"><span class="fas fa-star heading--star mr-1"></span>Product Reviews</h1>
          </div>
          <div class="ml-auto mt-auto mb-auto">
            <div class="dropdown  d-inline-block">
              <button class="btn custom--top-buttons dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Setting
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a href="<?php echo base_url(); ?>setting?shop=<?php echo $_GET['shop'];?>"   class="dropdown-item">Review Form Settings</a>
                <a href="<?php echo base_url(); ?>setting/addreview?shop=<?php echo $_GET['shop'];  ?>" class="dropdown-item">Add review</a>
              </div>
            </div>
            <a href="<?php echo base_url(); ?>reviews/index?shop=<?php echo $_GET['shop'];  ?>" class="btn custom--top-buttons ml-2">Reviews</a>
            <a href="<?php echo base_url(); ?>productList?shop=<?php echo $_GET['shop'];  ?>" class="btn custom--top-buttons ml-2">Products</a>
            <a href="<?php echo base_url(); ?>Home/feedback?shop=<?php echo $_GET['shop'];  ?>" class="btn custom--top-buttons ml-2">Give feedback</a>
            <a href="<?php echo base_url(); ?>Home/instruction?shop=<?php echo $_GET['shop'];  ?>" class="btn custom--top-buttons ml-2">Instruction</a>
          </div>
        </div>
      </div>
