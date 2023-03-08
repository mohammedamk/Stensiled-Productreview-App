<?php
// echo "<pre>";
// print_r($src->src);
// exit;
 ?>
<section>
    <div class="container">
      <div class="row">
        <h2 class="ui--titlebar-heading font-weight-bold mb-0 mt-auto pl-4 pl-md-0"><?php echo $review->review_title ?></h2>
        <p class="ml-2 mb-0 mt-auto"><?php echo $review->created_at ?></p>
        <div class="w-100 mb-3 mt-2 pb-2 pl-4 pl-md-0">
          <?php
              if ($review->state == "unpublished" || $review->state == "flagged"|| $review->state =="" ) {
                  echo '<button type="button" id="updateStatus" data-url="'.base_url().'updateReview?id='.$review->id.'&state='.$review->state.'" class="btn btn-light p-0 border-0 custom--func-buttons"> <i class="fa fa-check" aria-hidden="true"></i> Publish</button>';
              } else if ($review->state == "published") {
                  echo '<button type="button" id="updateStatus" data-url="'.base_url().'updateReview?id='.$review->id.'&state='.$review->state.'" class="btn btn-light p-0 border-0 custom--func-buttons"> <i class="fa fa-times" aria-hidden="true"></i> Unpublish</button>';
              }
          ?>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-md-8 pl-md-0 pr-md-3 w-100">
          <div class="mb-4 custom--ui-border custom--review-card">
            <div class="p-3 border-bottom">
              <div class="custom--ui-card-header d-flex pl-3 pr-3 pt-2">
                <div class="mr-auto mt-auto mb-auto">
                  <div class="star--Rating">
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        if($review->rating >= $i)  {
                        echo   '<i class="fa fa-star"></i>';
                        }else{
                            echo '<i class="fa fa-star-o" aria-hidden="true"></i>';
                        }
                    }  ?>
                  </div>
                </div>
                <div class="ml-auto mt-auto mb-auto custom--table">
                  <?php
                          if ($review->state == "published") {
                              echo '<span class="badge badge-success">' . $review->state . '</span>';
                          } else if ($review->state == "unpublished") {
                              echo '<span class="badge badge-danger">' . $review->state . '</span>';
                          } else if ($review->state == "flagged") {
                              echo '<span class="badge badge-warning"> ' . $review->state . '</span>';
                          }
                          ?>
                </div>
              </div>
              <div class="custom--ui-card-section pr-3 pl-3 pt-2 pb-1 mt-3">
                <p class="font-weight-bold custom--review-title"><?php echo $review->review_title; ?></p>
                <p class="custom--review-body mb-3"><?php echo $review->body_of_review; ?></p>
                <div class="gallery-block grid-gallery">
                   <div class="row">
                     <?php
                     if($review->review_image != ''){ //checkeing is images is available
                     $image_str = $review->review_image;
                     $images_arr = explode("," , $image_str);
                     foreach ($images_arr as $img) { ?>
                       <div class="col-2  item">
                           <a class="lightbox" href="<?php echo base_url('assets/img/uploads').'/'.$img ?>">
                               <img class="img-fluid image scale-on-hover" src="<?php echo base_url('assets/img/uploads').'/'.$img ?>">
                           </a>
                       </div>
                       <?php } }?>
                   </div>
                </div>
              </div>
            </div>
            <div class="p-3">
              <p class="pl-3 pr-3 pt-1 pb-1 mb-0">
                <span> <?php echo $review->name; ?></span>
                (<span class="text-primary"> <?php echo $review->email; ?></span>)
              </p>
            </div>
          </div>
          <div class="mb-4 custom--ui-border">
            <div class="p-3 border-bottom">
              <div class="custom--ui-card-section pr-3 pl-3 pt-2 pb-0">
                <h6 class="font-weight-bold mb-0">Reply to review</h6>
                <form action="<?php echo base_url() . 'Home/setreply?id='.$review->id ?>" method="post" id="replyform">
                <div class="input-group mt-3">
                  <textarea placeholder="Add a reply to this review..." name="reply" id="reply" class="form-control" aria-label="With textarea" rows="6"><?php echo isset($review->reply)? $review->reply: "" ;?></textarea>
                </div>
              </div>
            </div>
            <div class="p-3">
              <div class="pl-3 pr-3 pt-0 pb-0 text-right">
                <button type="submit" name="button" class="btn btn-primary">  <?php echo isset($review->reply) ? "Edit reply": "Post reply" ;?></button>
              </div>
            </form>
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-md-4 pr-md-0 pl-md-2 w-100 custom--review-card">
          <div class="mb-4 custom--ui-border">
            <div class="p-3 border-bottom">
              <div class="pl-3 pr-3 pt-2">
                <h6 class="font-weight-bold mb-3">Product details</h6>
                <img class="img-thumbnail" src="<?php echo !empty($src->src) ? $src->src: base_url('assets/img/product_image_not_available.png'); ?>" alt="" style="width:120px;height:120px">
              </div>
            </div>
            <div class="p-3">
              <div class="pl-3 pr-3 pt-2">
                <p class="font-weight-bold text-primary mb-2"><?php echo $review->product_title ?></p>
                <div class="star--Rating">
                  <?php
                      for ($i = 1; $i <= 5; $i++) {
                      if($review->rating >= $i)  {
                      echo   '<i class="fa fa-star"></i>';
                      }else{
                      echo '<i class="fa fa-star-o" aria-hidden="true"></i>';
                      }
                      }  ?>
                </div>
                <div class="">
                  <p><?php echo $productcount ?> review</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row border-top">
        <div class="col pt-3 pb-md-3 pl-md-0">
          <button type="button" class="btn btn-danger" id="modalbtn">Delete</button>
        </div>
      </div>
    </div>
  </section>
  <!-- Modal -->

  <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="reviewModalLabel">Delete</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      Are you sure You want delete this review?
    </div>
    <div class="modal-footer">
      <form action="<?php echo base_url() . 'Home/deletereview?id='.$review->id ?>" id="deletereview" class="d-inline">
          <button class="btn btn-danger" type="submit">Delete</button>
      </form>
    </div>
  </div>
  </div>
  </div>
  <!-- //modal -->
