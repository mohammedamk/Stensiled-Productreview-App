<?php
//  echo "<pre>";
//         print_r($setting);
//         exit;
?>

   <?php
   foreach ($setting as $s) { ?>
    <?php $show = $s["show_form_on_load"] == 1 ? "block" : "none"; ?>
    <section class="review-bg-white">
        <div class="review-container">
            <div class="review-row">
                <div class="review-col-md-12 review-mx-auto review-border review-px-4 review-py-3">
                    <div>
                        <h3 class="review-pb-3 spr-header-title"><?php echo $s['review_headline'] ?></h3>
                        <div class="review-row">
                            <div class="review-col-6">
                                <h6 class="review-pb-3"><?php echo $s['summary_with_no_review'] ?></h6>
                            </div>
                            <div class="review-col-6">
                                <h6 class="review-pb-3"><a id="show_review_form" onclick="" class="review-text-primary"><?php echo $s['review_link'] ?></a></h6>
                            </div>
                        </div>
                    </div>
                    <div style="height:1px; background:rgb(236, 236, 236)"></div>
                    <div id="review_form" style=" display: <?php $show; ?>">
                        <h6 class="review-pt-3"><?php echo $s['review_form_title'] ?></h6>
                        <form id="form" action="<?php echo base_url() . 'review/store' ?>">
                            <input type="hidden" value="4586491773059" name="product_id" id="product_id">
                            <input type="hidden" value="shirt" name="product_title" id="product_title">
                            <input type="hidden" value="<?php echo $_GET['shop'] ?>" name="shop" id="shop">
                            <div class="review-form-group">
                                <label for="name" class="spr-form-label">Name</label>
                                <input type="text" class="review-form-control" name="name" id="name" value="<?php echo set_value('name'); ?>" placeholder="<?php echo $s['author_name_help_msg'] ?>" required>
                            </div>
                            <div class="review-form-group">
                                <label for="email" class="spr-form-label">Email</label>
                                <input type="email" class="review-form-control" name="email" value="<?php echo set_value('email'); ?>" id="email" placeholder="<?php echo $s['author_email_help_msg'] ?>" required>

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
                                <label for="body_of_review" class="spr-form-label"><?php echo $s['review_body'] ?></label>
                                <textarea class="review-form-control" id="body_of_review" name="body_of_review" rows="5" placeholder="<?php echo $s['review_body_help_msg'] ?>" required><?php echo set_value('body_of_review'); ?></textarea>
                                <?php echo form_error('body_of_review', '<small class="error">', '</small>'); ?>
                            </div>
                            <div class="review-form-group">
                                <button class="review-btn review-btn-success" type="submit" class="submit" id="save"><?php echo $s['submit_button'] ?></button>
                            </div>
                        </form>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
