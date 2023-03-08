<section id="tabs">
  <div class="container">
    <div class="row">
      <h2 class="ui--titlebar-heading font-weight-bold">Reviews</h2>
      <!-- <div class="w-100 mb-3 mt-1 pb-2">
        <div class="d-flex">
          <button type="button" class="btn btn-light p-0 border-0 custom--func-buttons"><i class="fas fa-download"></i> Import reviews</button>
          <button type="button" class="btn btn-light p-0 ml-4 border-0  custom--func-buttons"><i class="fas fa-upload"></i> Export</button>
          <button type="button" class="btn btn-light p-0 ml-4 border-0  custom--func-buttons">More actions</button>
        </div>
      </div> -->
    </div>
    <div class="row">
      <div class="container my-4 px-0 bg-white" id="summary">
        <div class="row">
          <div class="col-md-12" id="reviewsummary">
            <table class="table mb-0">
              <tbody>
                <?php
                  foreach ($summary as $s ) { ?>
                    <tr>
                        <td>
                          <center>
                            <img class="img-thumbnail" src="<?php echo !empty($s->src) ? $s->src: base_url('assets/img/product_image_not_available.png'); ?>" alt="" style="width:80px;height:90px">
                          </center>
                        </td>
                        <td>
                          <center>
                            <h3>
                             <?php
                             for ($j = 1; $j <= 5; $j++) {
                                 if($s->average >= $j)  {
                                 echo  '<i class="fa fa-star"  ></i>';
                                 }else{
                                 echo '<i class="fa fa-star-o" aria-hidden="true"></i>';
                                 }
                             }
                             ?>
                           </h3>
                           <p>Average Rating</p>
                         </center>
                       </td>
                         <td><center><h3><?php echo $s->published ?> </h3><p>Published</p></center></td>
                         <td><center><h3> <?php echo $s->unpublished ?> </h3><p>Unpublished</p></center></td>
                         <td><center><h3><?php echo $s->flagged ?> </h3><p>Flagged</p></center></td>
                      </tr>

                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
      </div>
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
                      <th> <input type="checkbox" id="checkall" value='1'></th>
                      <th>Rating</th>
                      <th>Review</th>
                      <th>Date</th>
                      <th>Status</th>
                    </thead>
                    <tbody>
                        <?php if (count($reviews)>0) { ?>
                          <?php foreach ($reviews as $review) { ?>
                      <tr id='tr_<?= $review->id ?>'>
                        <td class="custom--select">
                          <input type="checkbox" class='checkbox checkthis' name='delete' value='<?php echo $review->id ?>'/>
                        </td>
                        <td class="star--Rating">
                          <?php
                            for ($i = 1; $i <= 5; $i++) {
                                if($review->rating >= $i)  {
                                echo   '<i class="fa fa-star"></i>';
                                }else{
                                    echo '<i class="fa fa-star-o" aria-hidden="true"></i>';
                                }
                            }  ?>
                        </td>
                        <td class="custom--info">
                          <a href="<?php echo base_url().'reviews/show?id='.$review->id.'&product_id='.$review->product_id.'&shop='.$_GET['shop']; ?>"><?php echo $review->review_title ?></a>
                          <p class="m-0">
                            <?php echo $review->body_of_review ?>
                          </p>
                          <p class="m-0"><span>-<?php echo $review->name ?></span><button type="button" class="btn btn-link submitSummary" data-url="<?php echo base_url() . 'Home/showsummary?product_id='.$review->product_id.'&shop='.$_GET['shop'] ?>"><?php echo $review->product_title ?></button></p>
                        </td>
                        <td class="custom--date">
                          <p class="m-0"><?php $date = $review->created_at;
                                                          echo date('j F Y h:i:s A', strtotime(str_replace('-', '/', $date)));
                                                          ?></p>
                        </td>
                        <td class="custom--status">
                          <?php
                              if ($review->state == "published") {
                                  echo '<span class="badge badge-pill badge-success">' . $review->state . '</span>';
                              } else if ($review->state == "unpublished") {
                                  echo '<span class="badge  badge-pill badge-warning">' . $review->state . '</span>';
                              } else if ($review->state == "flagged") {
                                  echo '<span class="badge  badge-pill badge-info"> ' . $review->state . '</span>';
                              }
                              ?>
                        </td>
                      </tr>
                      <?php } }
                      else{
                        echo "<tr><td colspan='5'><3>No data is available! </td></td></tr>";
                      }
                       ?>
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
