<?php
 // echo "<pre>";
 //        print_r($setting);
 //        exit;
// echo "<pre>";
// print_r($products_list->products);
// exit;
//     foreach ($products_list->products as $products) {
//   echo $products->id. " " . $products->title ;
// }
?>
   <?php
   foreach ($setting as $s) { ?>
    <div class="wrapper">
      <section class="">
        <div class="review-container review-border-top review-border-bottom">
            <div class="review-row">
                <div class="review-col-md-12 review-py-3">
                    <div class="row">
                      <div class="col-6">
                        <form id="form" action="<?php echo base_url() . 'review/store' ?>"  enctype="multipart/form-data">
                          <h2 class="my-2">Add review</h2>
                          <p>Add review manually so you can view in your website.</p>
                          <button class="review-btn review-btn-success" type="submit" class="submit" id="save"><?php echo $s['submit_button'] ?></button>
                      </div>
                      <div class="col-6">
                        <div class="card">
                          <div class="card-body">

                                <input type="hidden" value="<?php echo $_GET['shop'] ?>" name="shop" id="shop">
                                <input type="hidden" value="<?php echo $s['auto_publish'] == 1 ? 'published' : 'unpublished' ?>" name="state" id="state">
                                <div class="review-form-group">
                                    <label for="name" class="spr-form-label"><?php echo  $s['author_name'] ?></label>
                                    <input type="text" class="review-form-control" name="name" id="name" value="<?php echo set_value('name'); ?>" placeholder="<?php echo $s['author_name_help_msg'] ?>" required>
                                </div>
                                <div class="review-form-group">
                                    <label for="email" class="spr-form-label"><?php echo  $s['author_email'] ?></label>
                                    <input type="email" class="review-form-control" name="email" value="<?php echo set_value('email'); ?>" id="email" placeholder="<?php echo $s['author_email_help_msg'] ?>" required>
                                </div>

                                <div class="review-form-group">
                                  <label for="product" class="spr-form-label">Products</label>
                                  <input type="hidden" id="product_id" value="" name="product_id">
                                  <input type="hidden" id="product_title" value="" name="product_title">
                                  <select class="custom-select" name="product_list"  id="product_list" required>
                                      <option selected>Select Product</option>
                                      <?php
                                          foreach ($products_list->products as $product) { ?>
                                        <option value='<?php echo $product->id ?>'><?php echo $product->title ?> </option>
                                      <?php  } ?>
                                  </select>
                                </div>
                                <div class="review-form-group">
                                    <input type="hidden" value="" name="rating" id="rating">
                                    <label for="rating" class="spr-form-label"><?php echo $s['review_rating'] ?></label>
                                    <div class='rating-stars'>
                                        <ul id='stars'>
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
                                    <?php echo form_error('rating', '<small class="error">', '</small>'); ?>
                                </div>
                                <div class="review-form-group">
                                    <label for="review_title" class="spr-form-label"><?php echo $s['review_title'] ?></label>
                                    <input class="review-form-control" value="<?php echo set_value('review_title'); ?>" id="review_title" type="text" name="review_title" placeholder="<?php echo $s['review_title_help_msg'] ?>" autocomplete="off" required>
                                    <?php echo form_error('review_title', '<small class="error">', '</small>'); ?>
                                </div>
                                <div class="review-form-group">
                                    <label for="review_image" class="spr-form-label">Review image</label>
                                  <input type="file"  class="review-form-control" id="review_image" name="review_image[]"  autocomplete="off"  multiple accept=".jpg, .png, .gif" >
                                    <?php echo form_error('review_image', '<small class="error">', '</small>'); ?>
                                </div>
                                <div class="review-form-group">
                                    <label for="body_of_review" class="spr-form-label"><?php echo $s['review_body'] ?></label>
                                    <textarea class="review-form-control" id="body_of_review" name="body_of_review" rows="5" placeholder="<?php echo $s['review_body_help_msg'] ?>" required><?php echo set_value('body_of_review'); ?></textarea>
                                    <?php echo form_error('body_of_review', '<small class="error">', '</small>'); ?>
                                </div>


                          </div>
                        </div>
                      </div>
                    </div>
                      </form>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
