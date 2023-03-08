
<?php
// echo "<pre> .in view";
// print_r($reviews);
// exit;
?>
<?php foreach ($reviews as $review) { ?>
    <tr>
        <td>
            <div class="next-input-wrapper"><label for=""></label><input type="checkbox" name=""></div>
        </td>
        <td>
            <?php for ($i = 1; $i <= $review->rating; $i++) { ?>
                <i class="fa fa-star"></i>
            <?php } ?>
        </td>
        <td>
            <a href=""><?php echo $review->title ?></a>
            <p class="review-my-2">
                <?php echo $review->body_of_review ?>
            </p>
            <span class="">– <?php echo $review->name ?> <a class="" href="">U.S. POLO ASSN.</a></span>
        </td>
        <td>
            <?php
            $date = $review->created_at;
            echo date('j F Y h:i:s A', strtotime(str_replace('-', '/', $date)));
            ?>
        </td>
        <td>
            <span class="review-badge review-badge-success"><?php echo $review->state ?></span>
        </td>
    </tr>
<?php } ?>
