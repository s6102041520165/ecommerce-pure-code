<?php require_once 'header.php' ?>
<style>
.checked {
    color: orange;
}
</style>
<?php 
if(isset($_GET['action']) && $_GET['action']=="remove" && isset($_GET['reviewsID'])){
  $sql = $pdo->query("DELETE FROM tbl_reviews WHERE reviewsID='".$_GET['reviewsID']."' ");
  echo "<script>window.history.back();</script>";
} elseif(isset($_GET['action']) && $_GET['action']=="comment"){
  $sql = $pdo->query("INSERT INTO tbl_reviews (username,proID,comment,DateReviews) 
  VALUES ('".$_POST['username']."',
  '".$_POST['proID']."',
  '".$_POST['comment']."',
  NOW() ) ");
  echo "<script>window.history.back();</script>";
} elseif(isset($_GET['action']) && $_GET['action']=="rating" && isset($_GET['rating']) && isset($_GET['proID'])){
  if(isset($rs_member->username)){
    $sql=$pdo->query(" REPLACE INTO tbl_rating (username,proID,rating) 
    VALUES ('".$rs_member->username."','".$_GET['proID']."','".$_GET['rating']."') ");
  } else {
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อนค่ะ!!!');</script>";
  }
  echo "<script>window.history.back();</script>";
}
?>
<?php require_once 'sidebar.php' ?>
<script>
$(document).ready(function(){
  /* $('.carousel').carousel({
    interval: 10000,
    animateIn: 'fadeIn',
    animateOut: 'fadeOut'
  }); */
});
</script>
<div class="col-md-9">
    <br>
    <div class="row">
      <!--แสดงสินค้า-->
      <?php 
      $sql = " select *, DATE_FORMAT(proDate,'%D %M %Y') as dateP from tbl_product where proID = '".$_GET['proID']."' ";
      $query = $pdo->query($sql);
      $rowproduct = $query->fetch(PDO::FETCH_OBJ);
      $sql2 = $pdo->query("SELECT SUM(qty) AS sumqty,payoption
              FROM tbl_order_detail left join tbl_order
              ON (tbl_order_detail.orderID=tbl_order.orderID)
              WHERE proID = '".$rowproduct->proID."' AND status = 'no'
              AND showOrder <> 'no'
              GROUP BY proID; ");
      $rsqty = $sql2->fetch(PDO::FETCH_OBJ);
      ?>
        <div class="row">
          <div class="col-md-6 col-lg-6">
            <div class="xzoom-container">
              <img class="xzoom" id="xzoom-default" src="image/<?php echo $rowproduct->proPic; ?>" xoriginal="image/<?php echo $rowproduct->proPic; ?>" />
              <div class="xzoom-thumbs">
              <a href="image/<?php echo $rowproduct->proPic; ?>">
              <img class="xzoom-gallery" width="80" src="image/<?php echo $rowproduct->proPic; ?>" xpreview="image/<?php echo $rowproduct->proPic; ?>" title="<?php echo $rowproduct->proName; ?>"></a>
                <?php 
                $sql = " select * from tbl_pic_product where proID = '".$rowproduct->proID."' ";
                $query = $pdo->query($sql);
                while($rowpic = $query->fetch(PDO::FETCH_OBJ)){
                ?>
                <a href="image/<?php echo $rowpic->proPicName; ?>" >
                <img class="xzoom-gallery" width="80" src="image/<?php echo $rowpic->proPicName; ?>" title="<?php echo $rowproduct->proName; ?>"></a>
                <?php } ?>
            </div>
          </div> 
            
        </div>
        <div class="col-md-6 col-lg-6">
          <p>
            <h4><?php echo $rowproduct->proName; ?></h4>
          </p>
          <h4 class="text-info">ราคา : <?php echo number_format($rowproduct->proPrice,2); ?> THB</h4>
            <p>คงเหลือ : <?php echo $rowproduct->proQty." ".$rowproduct->UnitName; ?></p>
          <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
              <?php 
                $key = @array_search($rowproduct->proID,$_SESSION['proID']);
                if($_SESSION['qty'][$key]<$rowproduct->proQty-$rsqty->sumqty && $rsqty->sumqty < $rowproduct->proQty){                 
                  ?>
                <button type="button" onclick="window.location='bookingcart.php?proID=<?php echo $rowproduct->proID; ?>'" class="btn btn-info"><i>สั่งซื้อ</i></button>
              <?php } ?>
              <button type="button" onclick="window.history.back()" class="btn btn-info"><i>ย้อนกลับ</i></button>
            </div>
            <span class="badge badge-info"><?php echo $rowproduct->dateP; ?></span>
          </div>
          
          <hr>
          <h3>ให้คะแนนสินค้า</h3>
          <div>
            <?php 
              $ratingsql = $pdo->query("select *,AVG(rating) AS ratingAVG from tbl_rating where proID='".$rowproduct->proID."' ");
              $rs_rating = $ratingsql->fetch(PDO::FETCH_OBJ);
              if($rs_rating->ratingAVG<0.5){
                $show_star = 0;
              } elseif($rs_rating->ratingAVG<1.5){
                $show_star = 1;
              } elseif($rs_rating->ratingAVG<2.5){
                $show_star = 2;
              } elseif($rs_rating->ratingAVG<3.5){
                $show_star = 3;
              }  elseif($rs_rating->ratingAVG<4.5){
                $show_star = 4;
              }  elseif($rs_rating->ratingAVG<=5) {
                $show_star = 5;
              }
              for($i=1;$i<=5;$i++){
                if($i<=$show_star){
                  echo "<a href=\"details.php?action=rating&rating=$i&proID=$rowproduct->proID\"><span class=\"fa fa-star checked\"></span></a>";
                } else {
                  echo "<a class=\"text-dark\" href=\"details.php?action=rating&rating=$i&proID=$rowproduct->proID\"><span class=\"fa fa-star\"></span></a>";
                }
              }
              echo " (ค่าเฉลี่ย ".number_format($rs_rating->ratingAVG,2).")";
              
              $sqlrating = $pdo->query("select * from tbl_rating 
              where username = '".$rs_member->username."' AND proID = '".$rowproduct->proID."' ");

              $rs_check_rate = $sqlrating->fetch(PDO::FETCH_OBJ);

              if(isset($rs_check_rate))
              {
                echo "<br> คะแนนที่คุณให้ : ";
                
                for($k=1;$k<=(int)$rs_check_rate->rating;$k++){
                  echo "<span class=\"fa fa-star checked\"></span>";
                }
              }
            ?>
          </div>
        </div>
      </div>
    <!--สิ้นสุดการแสดงสินค้า-->
    </div>
    <p class="card-text">
      <?php echo nl2br($rowproduct->proDetails); ?>
    </p>


    <center><h3>รีวิวสินค้า</h3></center>
    <?php 
      $reviewsql = $pdo->query(" SELECT tbl_reviews.*,tbl_user.*, DATE_FORMAT(DateReviews,'%D %M %Y') AS dateR 
      FROM tbl_reviews INNER JOIN tbl_user ON (tbl_reviews.username = tbl_user.username) 
      WHERE proID = '".$rowproduct->proID."' ");

      while($rs_reviews = $reviewsql->fetch(PDO::FETCH_OBJ)){
      ?>
    <div class="media border p-3">
      <!--รูปโปรไฟล์สมาชิก-->
      <img src="image/<?php if($rs_reviews->profiles!=NULL) { echo $rs_reviews->profiles; } else { echo "noprofiles.png"; } ?>" class="mr-3 mt-3 rounded-circle" style="width:60px;">

      <div class="media-body">
        <h4><?php echo $rs_reviews->name." ".$rs_reviews->surname; ?> 
        <small><i>Comment on <?php echo $rs_reviews->dateR; ?></i></small></h4>
        <p><?php echo nl2br($rs_reviews->comment); ?></p><!--รายละเอียดที่รีวิว-->
        <?php if($rs_reviews->username==$rs_member->username){ ?>
          <a onclick="return chkfirm('ต้องการลบความคิดเห็นนี้ ใช่หรือไม่');" href="?action=remove&reviewsID=<?php echo $rs_reviews->reviewsID; ?>" class="btn btn-danger"><span class="fa fa-trash"></span></a>
        <?php } ?>
      </div>
    </div><br>
    <?php } ?>


    <br>
    <form action="?action=comment" method="post">
      <div class="form-group">
        <textarea <?php if(!isset($rs_member->username)) { echo "disabled"; } ?> required name="comment" id="" cols="30" rows="5" class="form-control"></textarea>
      </div>
      <input type="hidden" name="username" value="<?php echo $rs_member->username; ?>">
      <input type="hidden" name="proID" value="<?php echo $rowproduct->proID; ?>">
      <button <?php if(!isset($rs_member->username)) { echo "disabled"; } ?> type="submit" class="btn btn-primary">รีวิวสินค้า</button>
    </form>
</div>

<script src="js/foundation.min.js"></script>
<script src="js/setup.js"></script>
<?php require_once 'footer.php' ?>