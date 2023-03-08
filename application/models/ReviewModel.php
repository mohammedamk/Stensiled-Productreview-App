<?php
class ReviewModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function getall($shop)
    {
        $this->db->order_by('created_at', 'DESC');
        $this->db->select('*');
        $this->db->where('shop', $shop);
        $q = $this->db->get('review_tbl');
        $reviews = $q->result();
        return $reviews;
    }
    public function getReviewByState($state,$shop)
    {
      $this->db->order_by('created_at', 'DESC');
        $q =  $this->db->select('*')->where(array('shop' => $shop,'state' => $state))->get('review_tbl');
        $reviews = $q->result();
        return $reviews;
    }
    public function insertreview($data)
    {

      // echo "<pre>";
      // print_r($data);
      // exit;
        $result = $this->db->insert('review_tbl', $data);
        return $result;
    }
    public function deleteReviewMultiple($review_ids = array())
    {

        foreach ($review_ids as $reviewid) {
            $this->db->delete('review_tbl', array('id' => $reviewid));
        }

        return 1;
    }
    public function publishedReviewMultiple($review_ids = array())
    {

        foreach ($review_ids as $reviewid) {
            $data = array(
                'state' => 'published',
            );

            $this->db->where('id', $reviewid);
            $this->db->update('review_tbl', $data);
            // $this->db->delete('review_tbl', array('id' => $reviewid));
        }

        return 1;
    }
    public function unpublishedReviewMultiple($review_ids = array())
    {

        foreach ($review_ids as $reviewid) {
            $data = array(
                'state' => 'unpublished',
            );

            $this->db->where('id', $reviewid);
            $this->db->update('review_tbl', $data);
            // $this->db->delete('review_tbl', array('id' => $reviewid));
        }

        return 1;
    }
    public function flaggedReviewMultiple($review_ids = array())
    {

        foreach ($review_ids as $reviewid) {
            $data = array(
                'state' => 'flagged',
            );

            $this->db->where('id', $reviewid);
            $this->db->update('review_tbl', $data);
            // $this->db->delete('review_tbl', array('id' => $reviewid));
        }

        return 1;
    }
    public function showreview($id)
    {
        $review =  $this->db->get_where('review_tbl', array('id' => $id))->row();
        return $review;
    }

    //setting reply
    public function setreply($id, $data)
    {
        $this->db->where('id', $id);
       $ok =  $this->db->update('review_tbl', $data);
       if(isset($ok))
       {
           return true;
       }
    }

    public function productcount($product_id)
    {
        $this->db->where('product_id', $product_id);
        $num_rows = $this->db->count_all_results('review_tbl');
        return $num_rows;
    }
    public function getreviewbyproduct($product_id)
    {
      // $this->db->order_by('created_at', 'DESC');
      // $q =  $this->db->select('*')->where(array('product_id' => $product_id , 'state' => 'published'))->get('review_tbl');
      //$reviews = $q->result();
      $q = 'SELECT * FROM `review_tbl` WHERE `product_id`="'.$product_id.'" and state !="unpublished" ORDER by created_at DESC';
      $reviews = $this->db->query($q)->result(); 
      return $reviews;
    }
    public function updateReview($id, $newStatus)
    {
        $data = array(
            'state' => $newStatus,
        );

         $this->db->where('id', $id);
         $ok =  $this->db->update('review_tbl', $data);
        if(isset($ok))
        {
            return true;
        }
    }

    public function deletereview($id)
    {
        $ok = $this->db->delete('review_tbl', array('id' => $id));
        if(isset($ok))
        {
            return true;
        }
    }
    public function showsummary($product_id)
    {
        $product_id = $_GET['product_id'];
        $result = $this->db->query('SELECT
                                    AVG(`rating`) AS average,
                                    COUNT(CASE WHEN `state`="published" THEN 1 END) AS published,
                                    COUNT(CASE WHEN `state`="unpublished" THEN 1 END) AS unpublished,
                                    COUNT(CASE WHEN `state`="flagged" THEN 1 END) AS flagged
                                    FROM `review_tbl` WHERE product_id='.$product_id);
                                    $data= $result->result();
        return $data;

    }

    public function getreviewcount($product_id)
    {
      $this->db->select('count(*)');
      $this->db->from('review_tbl');
      $this->db->where('product_id', $product_id);
      $query = $this->db->get();
      $reviewcount = $query->num_rows();
      return $reviewcount;
    }

    public function productreviewcount($product_id)
    {

      $reviewcount = $this->db->where('product_id',$product_id)->from("review_tbl")->count_all_results();
      return $reviewcount;
    }
    public function avg_rating($product_id)
    {
      $avg_rating = $this->db->where('product_id',$product_id)->select_avg('rating')->get("review_tbl")->result();
      return $avg_rating[0];
    }
    public function setStatusFlagged($id)
    {
          $data = array(
              'state' => 'flagged',
          );

          $this->db->where('id', $id);
        $ok =  $this->db->update('review_tbl', $data);
        if(isset($ok))
        {
            return true;
        }
    }

    public function productList($shop)
    {
      $this->db->distinct();

      $this->db->select('product_id,product_title');
      $this->db->from('review_tbl');
      $this->db->where('shop', $shop);
      $query = $this->db->get();

      // $this->db->order_by('created_at', 'DESC');
      $reviews = $query->result();
      return $reviews;
    }

    public function reviewlistbyproduct($product_id)
    {
      $this->db->order_by('created_at', 'DESC');
      $q =  $this->db->select('*')->where(array('product_id' => $product_id ))->get('review_tbl');
      $reviews = $q->result();
      return $reviews;
    }
    public function get_review_pages($limit, $start, $product_id)
	   {
        $product_id = $_GET['product_id'];
        $this->db->limit($limit, $start);
        $this->db->order_by('created_at', 'DESC');
        $q =  $this->db->select('*')->where(array('product_id' => $product_id , 'state' => 'published'))->get('review_tbl');
        $reviews = $q->result();
        return $reviews;
    }
    public function get_review_pages_count($product_id)
	   {
        $product_id = $_GET['product_id'];

        $q =  $this->db->select('*')->where(array('product_id' => $product_id , 'state' => 'published'))->get('review_tbl');
        $query = $q->result();
        $reviewcount = $query->num_rows();
        return $reviewcount;
    }
    public function ratingCounts($product_id)
    {
      $product_id = $_GET['product_id'];
      $result = $this->db->query('SELECT
                                  count(CASE WHEN `rating`="5" THEN 1 END) AS fivestar,
                                  count(CASE WHEN `rating`="4" THEN 1 END) AS fourstar,
                                  count(CASE WHEN `rating`="3" THEN 1 END) AS threestar,
                                  count(CASE WHEN `rating`="2" THEN 1 END) AS twostar,
                                  count(CASE WHEN `rating`="1" THEN 1 END) AS onestar
                                  FROM `review_tbl` WHERE state ="published" && product_id='.$product_id);
      $data= $result->row();

                                  // echo "<pre>";
                                  // print_r($data);
                                  // exit;
      return $data;
    }

    public function reviewFilter($option, $product_id)
    {
      if($option == "most-recent")
      {
        $this->db->order_by('created_at', 'DESC');
        $q =  $this->db->select('*')->where(array('product_id' => $product_id , 'state' => 'published'))->get('review_tbl');
        $reviews = $q->result();
        return $reviews;
      }
      elseif ($option == "highest-rating") {
        $this->db->order_by('rating', 'DESC');
        $q =  $this->db->select('*')->where(array('product_id' => $product_id , 'state' => 'published'))->get('review_tbl');
        $reviews = $q->result();
        return $reviews;
      }
      else
      {
        $this->db->order_by('rating', 'ASC');
        $q =  $this->db->select('*')->where(array('product_id' => $product_id , 'state' => 'published'))->get('review_tbl');
        $reviews = $q->result();
        return $reviews;
      }
    }

    public function saveFeedback($data)
    {
      $res = $this->db->insert('feedback_tbl', $data);
      return $res;
    }
}
