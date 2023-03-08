   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
   <script src="https://kit.fontawesome.com/784056f904.js" crossorigin="anonymous"></script>
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
   <script src="<?php echo base_url()?>assets/js/custome.js"></script>
<script>
        $(document).ready(function() {
        $("#show_review_form").click(function() {
            $("#review_form").slideToggle();
        });
        $(function() {
          $('#toggler1').bootstrapToggle({
            on: 'Enabled',
            off: 'Disabled'
          });
        });
        $(function() {
            $('#toggler1').change(function() {
              var val;
              if($(this).prop('checked') == true)
              {
                val =1;
              }
              else {
                val =0;
              }
              $('#console-event').val(val)
            })
          });

        $('#savesetting').click(function(){
          var loader = $.LoadingOverlay("show");

           $("#contentdiv").load("content.php?id=<? echo $uid; ?>&show=profile", function() {
               loader.hide();
           });
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
            var msg = "";
            if (ratingValue > 1) {
                msg = "Thanks! You rated this " + ratingValue + " stars.";
            } else {
                msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
            }
            responseMessage(msg);

        });


        function responseMessage(msg) {
            $('.success-box').fadeIn(200);
            $('.success-box div.text-message').html("<span>" + msg + "</span>");
        }
        //set hidden inputs for product id and product_title
        $('#product_list').on('change', function() {
          var product_title = $(this).find("option:selected").text();
            var product_id = $(this).val();
            // alert("Selected Text: " + selectedText + " Value: " + selectedValue);
            $('input[name="product_id"]').val(product_id);
            $('input[name="product_title"]').val(product_title);
          });
       //  subitting the review form
           $('#form').submit(function(e) {
               e.preventDefault();
               var myForm = document.getElementById('form');
               var form_data = new FormData(myForm);
               var url = $('#form').attr('action');

               $.ajax({
                   url: url,
                   type: "POST",
                   dataType: 'json',
                   processData:false,
                   contentType:false,
                   cache:false,
                   data: form_data,
                   beforeSend: function() { $.LoadingOverlay("show"); },
                   complete: function() { $.LoadingOverlay("hide"); },
                   success: function(data) {
                     console.log(data);
                       $('#form').each(function() {
                           this.reset();
                       });
                       $('.rating-stars ul>li').removeClass('selected');
                       toastr.success('Success', 'Thank you for submitting a review!');
                   },
                   error: function() {
                     $.LoadingOverlay("hide");
                     toastr.error('Failed', 'Please try again');
                   },
               }).always(function(){
                  // Always hide LoadingOverlay when ajax request is over
                  $.LoadingOverlay("hide");
              }).done(function(){
                  // Hurray, everything went smooth!
                  console.log("Done!");
              }).fail(function(jqXHR){
                  // Ups, something went wrong, inform the user about that maybe...
                  console.log(jqXHR.responseText);
              });

               return false;

           });


        //  $('#all-review-table').DataTable(function() {});
        oTable = $('#all-review-table').DataTable({
                "bSort" : false
                }); //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
        $('#search').keyup(function() {
            oTable.search($(this).val()).draw();
        });

        // Check all
        $("#checkall").change(function() {

            var checked = $(this).is(':checked');
            if (checked) {
                $(".checkbox").each(function() {
                    $(this).prop("checked", true);
                });
            } else {
                $(".checkbox").each(function() {
                    $(this).prop("checked", false);
                });
            }
        });

        // Changing state of CheckAll checkbox
        $(".checkbox").click(function() {

            if ($(".checkbox").length == $(".checkbox:checked").length) {
                $("#checkall").prop("checked", true);
            } else {
                $("#checkall").prop("checked", false);
            }

        });

        $('.success').fadeOut(5000);
        // bulk action
       $('.multi').click(function() {

           // Confirm alert
           var deleteConfirm = confirm("Are you sure?");
           if (deleteConfirm == true) {

               // Get reviewid from checked checkboxes
               var reviews_arr = [];
               $(".checkbox:checked").each(function() {
                   var reviewid = $(this).val();

                   reviews_arr.push(reviewid);
               });

               // Array length
               var length = reviews_arr.length;

               if (length > 0) {

                   // AJAX request
                   $.ajax({
                       url: $(this).data('url'),
                       type: 'post',
                       data: {
                           review_ids: reviews_arr
                       },
                       beforeSend: function() { $.LoadingOverlay("show"); },
                       complete: function() { $.LoadingOverlay("hide"); },
                       success: function(response) {
                           window.location.reload('#all-review-table');
                           toastr.success('Success', 'Updated the table');
                       },
                       error: function() {
                           toastr.error('Failed', 'Please try again');
                       }
                   });
               } else {
                   toastr.warning('Warning', 'please select at least one row!!');
                   // alert('please select at least one row!')
               }
           }

       });

       //  SHOW REVIEW PAGE SCRIPT
       $('#replyform').submit(function(e) {
           // alert ('hi');
           e.preventDefault();
           var url = $('#replyform').attr('action');
            var reply = $('#reply').val();

            $.ajax({
                url: url,
                type: "POST",
                dataType: "JSON",
                error: function() {
                   toastr.error('Failed', 'Please try again');
                },
                data: {
                    reply: reply,
                },
                beforeSend: function() { $.LoadingOverlay("show"); },
                complete: function() { $.LoadingOverlay("hide"); },
                success: function(data) {
                    window.location.reload('#replydiv');
                    toastr.success('Success', 'Reply updated');
                }
            });
            return false;
        });

        $('#modalbtn').click(function(){
           $('#reviewModal').modal('show');
           $('#deletereview').click(function(e) {
            e.preventDefault();
            var url = $('#deletereview').attr('action')
           //   alert (url);
            $.ajax({
                url: url,
                type: "POST",
                dataType: "JSON",
               //  data: data,
               beforeSend: function() { $.LoadingOverlay("show"); },
               complete: function() { $.LoadingOverlay("hide"); },
                success: function(data) {
                    // console.log(data);
                    if (data) {
                        $('#reviewModal').modal('hide');
                       // data.redirect contains the string URL to redirect to
                       toastr.success('Success', 'Deleted the review.');
                       window.location.href = "<?php echo base_url() . 'Home/index?shop='.$_GET['shop'] ?>" ;
                   }
                },
               error: function () {
                   $('#exampleModal').modal('hide');
                   toastr.error('Failed', 'Please try again');
               }
            });
            return false;
        });
        });


        $('#updateStatus').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).data('url'),
                type: "POST",
                dataType: "JSON",
               //  data: data,
               beforeSend: function() { $.LoadingOverlay("show"); },
               complete: function() { $.LoadingOverlay("hide"); },
                success: function(data) {
                    // console.log(data);
                    if (data) {
                       // data.redirect contains the string URL to redirect to
                       window.location.reload('#updateStatus');
                       toastr.success('Success', 'Updated the Status.');
                   }
                },
               error: function () {
                   toastr.error('Failed', 'Please try again');
               }
            });
            return false;
        });

       $('.submitSummary').click(function(e) {
            e.preventDefault();
           //  alert($(this).data('url'));
            var html = '';
            var data = '';

           // alert(html);
            $.ajax({
                url: $(this).data('url'),
                type: "POST",
                dataType: "JSON",
                beforeSend: function() { $.LoadingOverlay("show"); },
                complete: function() { $.LoadingOverlay("hide"); },
                success: function(data) {

            html += '<div class="row"><div class="col-md-12" id="reviewsummary"><table class="table"><tbody><tr>';
           html +=  '<td><center><img src="' + data['src'].src + ' " style="height: 80px;width: 70px;"></center></td>';
           html += '<td><center><h3>';
           for (j = 1; j <= 5; j++) {
               if(data['summary'][0].average >= j)  {
               html +=  '<i class=\"fa fa-star\"  ></i>';
               }else{
               html +='<i class=\"fa fa-star-o\" aria-hidden=\"true\"></i>';
               }
           }
           html += '</h3><p>Average Rating</p></center></td>';
           html += '<td><center><h3>' + data['summary'][0].published + '</h3><p>Published</p></center></td>';
           html += '<td><center><h3>' + data['summary'][0].unpublished + '</h3><p>Unpublished</p></center></td>';
           html += '<td><center><h3>' + data['summary'][0].flagged + '</h3><p>Flagged</p></center></td>';
           html += '</tr></tbody></table></div></div> ';
                       $('#summary').html(html);
                       // alert(html);
                       console.log(data);
                    }
            });
            return false;
        });

       $('.btnreviewtab').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'ajax',
                url: $(this).data('url'),
                async: false,
                dataType: 'json',
                type: 'POST',
                cache: false,
                beforeSend: function() { $.LoadingOverlay("show"); },
                complete: function() { $.LoadingOverlay("hide"); },
                error: function() {
                    toastr.error('Failed', 'Please try again');
                },
                success: function(data) {
                    // console.log(data);
                    var html = '';
                    var i;
                    if(data.length > 0){
                      for (i = 0; i < data.length; i++) {
                        // console.log(data);
                        html += '<tr id="tr_'+ data[i].id + '">';
                        html += '<td class="custom--select">';
                        html += '<input type="checkbox" class="checkbox checkthis" name="delete"  value="'+ data[i].id + '">' ;
                        html += '</td>';
                        html += '<td class="star--Rating"> ';
                        for ($j = 1; $j <= 5; $j++) {
                            if(data[i].rating >= $j)  {
                            html +=  '<i class="fa fa-star"></i>';
                            }else{
                            html += '<i class="fa fa-star-o" aria-hidden="true"></i>';
                            }
                        }
                        html += '</td>';
                        html += '<td class="custom--info">';
                        html += '<a href="<?php echo base_url() ?>' + 'reviews/show?id=' + data[i].id + '&product_id=' + data[i].product_id +'&shop=<?php echo $_GET["shop"] ?> ">'+ data[i].review_title + '</a>';
                        html += '<p class="m-0">' + data[i].body_of_review + '</p>';
                        html += '<p class="m-0"><span>-' + data[i].name + '</span><button type="button" class="btn btn-link submitSummary" data-url="<?php echo base_url() ?>' + 'Home/showsummary?product_id=' + data[i].product_id + '&shop=<?php echo $_GET["shop"] ?> ">' + data[i].product_title + '</button></p>';
                        html += '</td>';
                        html += '<td class="custom--date"><p class="m-0">';
                        html += data[i].created_at;
                        html += '</td>';
                        html += '<td class="custom--status">';
                        if (data[i].state== "published") {
                           html +=  '<span class="badge badge-pill badge-success">'  +  data[i].state + '</span>';
                        } else if ( data[i].state== "unpublished") {
                           html +=  '<span class="badge  badge-pill badge-warning">' +  data[i].state + '</span>';
                        } else if ( data[i].state== "flagged") {
                           html +=  '<span class="badge  badge-pill badge-info"> '  + data[i].state +'</span>';
                        }
                        html += ' </td>';
                        html += '</tr>';
                      }
                    }
                      else {
                          html += '<tr>';
                          html += '<td colspan="5"><h5><center> No data in table</center></h5></td>';
                          html += '</tr>';
                        }
                    console.log(html);
                    $('#all-review-table tbody').html(html);
                },
            });
        });


        <?php if ($this->session->flashdata('success')) {
        //echo true;
          echo  "toastr.success('Success', '".$this->session->flashdata('success')."');";
        }
         ?>
        <?php if ($this->session->flashdata('error')) {
              echo  "toastr.error('Success', '".$this->session->flashdata('error')."');";
        }
        ?>
    });

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
<script>
    baguetteBox.run('.grid-gallery', { animation: 'slideIn'});
</script>
<script>
    toastr.options = {
      "closeButton": true,
       "debug": false,
       "positionClass": "toast-bottom-full-width",
       "onclick": null,
       "fadeIn": 300,
       "fadeOut": 1000,
       "timeOut": 5000,
       "extendedTimeOut": 1000 }
</script>
</body>

</html>
