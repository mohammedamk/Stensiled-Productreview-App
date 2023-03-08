<?php
// echo "<pre>";
// print_r($this->session->keep_flashdata('success'));
// exit;
foreach ($setting as $s) {
?>
    <div class="wrapper" id="contentdiv">
        <section class="">
            <div class="review-container review-border-top review-border-bottom">
                <div class="review-row">
                    <form action="<?php echo base_url() ?>setting/update?shop=<?php echo $_GET['shop'] ?>" method="post" id="formSetting">
                        <div class="review-col-md-12 review-py-3">
                            <div class="review-row">
                                <div class="review-col-6">
                                    <h2 class="review-my-2">Review form settings</h2>
                                    <p>Choose the setting how you want to review form.</p>
                                    <button type="submit" class="review-btn review-btn-success" id="savesetting">Submit</button>
                                  </div>

                                <div class="review-col-6">
                                    <div class="review-card">
                                        <div class="review-card-body">
                                          <div class="review-border-bottom mb-1rem">
                                              <h6 style="font-weight:500" class="review-text-primary" title="Enable review form"></h6>
                                                <div class="form-group form-row">
                                                  <div class="col-6">
                                                    <b>Enable Review Form</b>
                                                  </div>
                                                  <div class="col-6 text-right">
                                                    <input type="checkbox" <?php echo $s['enable_review_form'] == 1 ? 'checked' : '' ?> id="toggler1" data-onstyle="primary" data-offstyle="danger">
                                                    <input type="hidden" value="<?php echo $s['enable_review_form'] ?>" name="enable_review_form"  id="console-event">
                                                  </div>
                                                </div>
                                          </div>
                                          <div class="review-border-bottom mb-1rem">
                                              <h6 style="font-weight:500" class="review-text-primary" title="Customer can give review only when logged in">Customer Accounts</h6>
                                              <div class="review-custom-control review-custom-radio">
                                                  <input type="radio" value="1" <?php echo $s['customer_logged_in'] == 1 ? 'checked' : $s['customer_logged_in'] ?> class="review-custom-control-input" id="customer_logged_in" name="customer_logged_in">
                                                  <label class="review-custom-control-label" for="customer_logged_in">Enabled</label>
                                                  <p class="text-gray review-mt-0">Reviews can given only when customer is logged in</p>
                                              </div>
                                              <div class="review-custom-control review-custom-radio">
                                                  <input type="radio" value="0" <?php echo $s['customer_logged_in'] == 0 ? 'checked' : '' ?> class="review-custom-control-input" id="customer_logged_in_dis" name="customer_logged_in">
                                                  <label class="review-custom-control-label" for="customer_logged_in_dis">Disabled</label>
                                                  <p class="text-gray review-mt-0">Reviews can given when customer is not logged in</p>
                                              </div>
                                          </div>
                                            <div class="review-border-bottom mb-1rem">
                                                <h6 style="font-weight:500" class="review-text-primary" title="Automatically check new reviews for spam and then publish them.">Auto publish</h6>
                                                <div class="review-custom-control review-custom-radio">
                                                    <input type="radio" value="1" <?php echo $s['auto_publish'] == 1 ? 'checked' : $s['auto_publish'] ?> class="review-custom-control-input" id="auto_publish" name="auto_publish">
                                                    <label class="review-custom-control-label" for="auto_publish">Enabled</label>
                                                    <p class="text-gray review-mt-0">New reviews are checked for spam and then automatically published.</p>
                                                </div>
                                                <div class="review-custom-control review-custom-radio">
                                                    <input type="radio" value="0" <?php echo $s['auto_publish'] == 0 ? 'checked' : '' ?> class="review-custom-control-input" id="auto_publish_dis" name="auto_publish">
                                                    <label class="review-custom-control-label" for="auto_publish_dis">Disabled</label>
                                                    <p class="text-gray review-mt-0">You must manually publish new reviews.</p>
                                                </div>
                                            </div>

                                            <!-- <div class="review-border-bottom mb-1rem">
                                                <h6 style="font-weight:500" class="review-text-primary" title="Choose if you want to receive email notifications for each review.">Email setting</h6>
                                                <div class="review-custom-control review-custom-checkbox">
                                                    <input type="hidden" name="receive_email_for_review" value="0">
                                                    <input type="checkbox" value="1" <?php // echo $s['receive_email_for_review'] == 1 ? 'checked' : '' ?> class="review-custom-control-input" id="receive_email_for_review" name="receive_email_for_review">
                                                    <label class="review-custom-control-label" for="receive_email_for_review">Send me an email</label>
                                                    <p class="text-gray review-mt-0">Send me an email when a review is submitted.</p>
                                                </div>
                                                <?php //if ($s['receive_email_for_review'] == 1) {
                                                ?>
                                                <div class="review-form-group receive_email">
                                                    <label for="spr-form-label">Email address</label>
                                                    <input type="text" id="receive_email_addr" name="receive_email_addr" <?php //echo ($s['receive_email_addr'] == "hidden" ? "disabled" : "") ?> value="<?php //echo $s['receive_email_addr'] ?>" class="type_name review-form-control" required>
                                                </div>
                                                <?php //}
                                                ?>
                                            </div> -->

                                            <div class="review-border-bottom mb-1rem">
                                              <h6 style="font-weight:500" class="review-text-primary" title="Customize the layout for the reviews are displayed on your website.">Layout</h6>
                                              <div class="custom-control custom-radio custom-control-inline">
                                                  <input type="radio" id="grid" name="layout" value="grid" class="custom-control-input" <?php echo $s['layout'] == "grid" ? 'checked' : '' ?>>
                                                  <label class="custom-control-label" for="grid">Grid<br>
                                                    <img src="<?php echo base_url('assets/img/grid.png') ?>"/>
                                                  </label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                  <input type="radio" id="list" name="layout" value="list" class="custom-control-input" <?php echo $s['layout'] == "list" ? 'checked' : '' ?>>
                                                  <label class="custom-control-label" for="list">List<br>
                                                    <img src="<?php echo base_url('assets/img/list.png') ?>"/>
                                                  </label>

                                                </div>
                                                <!-- <div class="custom-control custom-radio custom-control-inline">
                                                  <input type="radio" id="masonry" name="layout" value="masonry" class="custom-control-input" <?php //echo $s['layout'] == "mosonry" ? 'checked' : '' ?>>
                                                  <label class="custom-control-label" for="masonry">Masnry<br>
                                                    <img src="<?php //echo base_url('assets/img/Masonry.png') ?>"/>
                                                  </label>
                                                </div> -->
                                            </div>

                                            <div class="review-border-bottom mb-1rem">
                                                <h6 style="font-weight:500" class="review-text-primary" title="Customize the text for the area that reviews are displayed on your website.">Review listing text</h6>
                                                <div class="review-custom-control review-custom-checkbox">
                                                    <input type="hidden" name="show_form_on_load" value="0">
                                                    <input type="hidden" name="shop" value="">
                                                    <input type="checkbox" value="1" <?php echo $s['show_form_on_load'] == 1 ? 'checked' : '' ?> class="review-custom-control-input" id="show_form_on_load" name="show_form_on_load">
                                                    <label class="review-custom-control-label" for="show_form_on_load">Show review form on load</label>
                                                    <p class="text-gray review-mt-0">The new review form will be visible for all users by default.</p>
                                                </div>
                                                <div class="review-custom-control review-custom-checkbox">
                                                    <input type="hidden" name="show_powered_by" value="0">
                                                    <input type="checkbox" value="1" <?php echo $s['show_powered_by'] == 1 ? 'checked' : '' ?> class="review-custom-control-input" id="show_powered_by" name="show_powered_by">
                                                    <label class="review-custom-control-label" for="show_powered_by">Show Powered by text</label>
                                                    <p class="text-gray review-mt-0">Show "Powered by something" text.</p>
                                                </div>
                                                <div class="review-form-group">
                                                    <label for="spr-form-label">Review headline</label>
                                                    <input type="text" id="review_headline" name="review_headline" value="<?php echo $s['review_headline'] ?>" class="review-form-control">
                                                </div>
                                                <div class="review-form-group">
                                                    <label for="spr-form-label">Review form title</label>
                                                    <input type="text" id="review_form_title" name="review_form_title" value="<?php echo $s['review_form_title'] ?>" class="review-form-control">
                                                </div>
                                                <div class="review-form-group">
                                                    <label for="spr-form-label">Write a review link</label>
                                                    <input type="text" id="review_link" name="review_link" value="<?php echo $s['review_link'] ?>" class="review-form-control">
                                                </div>
                                                <div class="review-form-group">
                                                    <label for="spr-form-label">Review summary with no reviews</label>
                                                    <input type="text" id="summary_with_no_review" name="summary_with_no_review" value="<?php echo $s['summary_with_no_review'] ?>" class="review-form-control">
                                                </div>
                                                <div class="review-form-group">
                                                    <label for="spr-form-label">Report as inappropriate</label>
                                                    <input type="text" id="report_as_inappropriate" name="report_as_inappropriate" value="<?php echo $s['report_as_inappropriate'] ?>" class="review-form-control">
                                                </div>
                                                <div class="review-form-group">
                                                    <label for="spr-form-label">Reported as inappropriate message</label>
                                                    <input type="text" id="report_as_inappropriate_mgs" name="report_as_inappropriate_mgs" value="<?php echo $s['report_as_inappropriate_mgs'] ?>" class="review-form-control">
                                                </div>
                                            </div>

                                            <div class="review-border-bottom  mb-1rem">
                                                <h6 style="font-weight:500" class="review-text-primary">Form input setting</h6>
                                                <div class="review-form-group">
                                                    <label for="spr-form-label">Label name</label>
                                                    <input type="hidden" name="author_name" value="<?php echo $s['author_name'] ?>">
                                                    <input type="text" id="author_name" name="author_name" <?php echo ($s['author_name_type'] == "hidden" ? "disabled" : "") ?> value="<?php echo $s['author_name'] ?>" class="type_name review-form-control">
                                                </div>
                                                <div class="review-form-group">
                                                    <label for="spr-form-label">Placeholder value</label>
                                                    <input type="hidden" name="author_name_help_msg" value="<?php echo $s['author_name_help_msg'] ?>">
                                                    <input type="text" id="author_name_help_msg" <?php echo ($s['author_name_type'] == "hidden" ? "disabled" : "") ?> name="author_name_help_msg" value="<?php echo $s['author_name_help_msg'] ?>" class="type_name review-form-control">
                                                </div>
                                            </div>

                                            <div class="review-border-bottom  mb-1rem">
                                                <!-- <h6 style="font-weight:500" class="review-text-primary">Form input setting: Email</h6> -->
                                                <div class="review-form-group">
                                                    <label for="spr-form-label">Label name</label>
                                                    <input type="hidden" name="author_email" value="<?php echo $s['author_email'] ?>">
                                                    <input type="text" id="author_email" <?php echo ($s['author_email_type'] == "hidden" ? "disabled" : "") ?> name="author_email" value="<?php echo $s['author_email'] ?>" class="type_email review-form-control">
                                                </div>
                                                <div class="review-form-group">
                                                    <label for="spr-form-label">Placeholder value</label>
                                                    <input type="hidden" name="author_email_help_msg" value="<?php echo $s['author_email_help_msg'] ?>">
                                                    <input type="text" id="author_email_help_msg" <?php echo ($s['author_email_type'] == "hidden" ? "disabled" : "") ?> name="author_email_help_msg" value="<?php echo $s['author_email_help_msg'] ?>" class="type_email review-form-control">
                                                </div>
                                            </div>

                                            <div class="review-border-bottom mb-1rem">
                                              <!-- <h6 style="font-weight:500" class="review-text-primary">Form input setting: Rating</h6> -->
                                                <div class="review-form-group">
                                                    <label for="spr-form-label">Label name</label>
                                                    <input type="text" id="review_rating" name="review_rating" value="<?php echo $s['review_rating'] ?>" class="review-form-control">
                                                </div>
                                            </div>
                                            <div class="review-border-bottom mb-1rem">
                                              <!-- <h6 style="font-weight:500" class="review-text-primary">Form input setting: Review title</h6> -->
                                                <div class="review-form-group">
                                                    <label for="spr-form-label">Label name</label>
                                                    <input type="text" id="review_title" name="review_title" value="<?php echo $s['review_title'] ?>" class="review-form-control">
                                                </div>
                                                <div class="review-form-group">
                                                    <label for="spr-form-label">Placeholder value</label>
                                                    <input type="text" id="review_title_help_msg" name="review_title_help_msg" value="<?php echo $s['review_title_help_msg'] ?>" class="review-form-control">
                                                </div>
                                            </div>
                                            <div class="review-border-bottom mb-1rem">
                                              <!-- <h6 style="font-weight:500" class="review-text-primary">Form input setting: Body of review</h6> -->
                                                <div class="review-form-group">
                                                    <label for="spr-form-label">Label name</label>
                                                    <input type="text" id="review_body" name="review_body" value="<?php echo $s['review_body'] ?>" class="review-form-control">
                                                </div>
                                                <div class="review-form-group">
                                                    <label for="spr-form-label">Placeholder value</label>
                                                    <input type="text" id="	review_body_help_msg" name="review_body_help_msg" value="<?php echo $s['review_body_help_msg'] ?>" class=" review-form-control">
                                                </div>
                                            </div>
                                            <div class="review-border-bottom mb-1rem">
                                              <!-- <h6 style="font-weight:500" class="review-text-primary">Form input setting: Submit button</h6> -->
                                                <div class="review-form-group">
                                                    <label for="spr-form-label">Label name</label>
                                                    <input type="text" id="submit_button" name="submit_button" value="<?php echo $s['submit_button'] ?>" class="review-form-control">
                                                </div>
                                                <div class="review-form-group">
                                                    <label for="spr-form-label">Success message</label>
                                                    <input type="text" id="success_msg" name="success_msg" value="<?php echo $s['success_msg'] ?>" class="review-form-control">
                                                </div>
                                                <div class="review-form-group">
                                                    <label for="spr-form-label">Error message</label>
                                                    <input type="text" id="err_msg" name="err_msg" value="<?php echo $s['err_msg'] ?>" class="review-form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
        </section>
    </div>
<?php
} ?>
