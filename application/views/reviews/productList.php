<?php
// echo "<pre>";
// print_r($reviews);
// exit;
?>
<section id="tabs">
  <div class="container">
    <div class="row">
      <h2 class="ui--titlebar-heading font-weight-bold">Products</h2>
    </div>
    <div class="row">
      <div class="col-xs-12 w-100 custom--ui-border">

        <div class="tab-content py-2 px-md-3 px-sm-0" id="myTabContent">
          <div class="tab-pane fade show active" id="all-reviews" role="tabpanel">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-hover custom--table"  id="all-review-table" >
                    <thead>
                      <th><center>Image</center></th>
                      <th><center>Product</center></th>
                      <th><center>Rating</center></th>
                      <th><center>Reviews</center></th>
                    </thead>
                    <tbody>
                        <?php if (count($reviews)>0) { ?>
                          <?php foreach ($reviews as $review) { ?>
                      <tr>
                        <td class="custom--select">
                            <img src="<?php echo isset($review->src)? $review->src: base_url('assets/img/product_image_not_available.png'); ?>" style="width:80px; height:90px">
                        </td>
                        <td class="custom--info">
                          <center>
                            <!-- <p class="m-0"><button type="button" class="btn btn-link submitSummary" data-url="<?php //echo base_url() . 'Home/showsummary?product_id='.$review->product_id.'&shop='.$_GET['shop'] ?>"><?php //echo $review->product_title ?></button></p> -->
                          <p class="m-0"> <a href="<?php echo base_url() . 'reviewlistbyproduct?product_id='.$review->product_id.'&shop='.$_GET['shop'] ?>"><?php echo $review->product_title ?></a></p>
                          </center>
                        </td>

                        <td class="star--Rating">
                          <p><?php //echo isset($review->avg_rating->rating)? $review->avg_rating->rating: "Avrage rating not available!" ?></p>
                          <?php
                            for ($i = 1; $i <= 5; $i++) {
                                if($review->avg_rating->rating >= $i)  {
                                echo   '<i class="fa fa-star"></i>';
                                }else{
                                    echo '<i class="fa fa-star-o" aria-hidden="true"></i>';
                                }
                            }  ?>
                        </td>
                        <td class="custom--status">
                          <!-- <center> -->
                            <p><?php echo isset($review->reviewcount)? $review->reviewcount: "Total reviews not available!" ?></p>
                          <!-- </center> -->
                        </td>
                      </tr>
                      <?php }
                     }
                      else {
                        echo "<tr><td colspan='4'><h3>No data in table</h3></td></tr>";
                      } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
