<div class="wrapper">
  <section class="">
    <div class="review-container review-border-top review-border-bottom">
        <div class="review-row">
            <div class="review-col-md-12 review-py-3">
                <div class="row">
                  <div class="col-6">
                    <form action="<?php echo base_url() . 'Home/feedbackStore' ?>"  enctype="multipart/form-data" method="post">
                      <h2 class="my-2">Write feedback</h2>
                      <p>We would like to hear your feedback.</p>
                      <button class="review-btn review-btn-success" type="submit" class="submit" id="savesetting">Submit</button>
                  </div>
                  <div class="col-6">
                    <div class="card">
                      <div class="card-body">
                            <input type="hidden" value="<?php echo $_GET['shop'] ?>" name="shop" id="shop">
                            <div class="review-form-group">
                                <label for="email" class="spr-form-label">Email</label>
                                <input type="email" class="review-form-control" name="email" id="email" placeholder="Email" required>
                            </div>
                            <div class="review-form-group">
                                <label for="body_of_feedback" class="spr-form-label">Description</label>
                                <textarea class="review-form-control" id="body_of_feedback" name="body_of_feedback" rows="5" placeholder="Description" required></textarea>
                            </div>
                      </div>
                    </div>
                  </div>
                </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
