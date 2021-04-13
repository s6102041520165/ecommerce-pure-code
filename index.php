<?php require_once 'header.php' ?>
<?php require_once 'sidebar.php' ?>

<div class="col-md-9 col-lg-9">
  <br>
  <div class="row">
    <!--แสดงสินค้า-->
    <?php
    if (isset($_GET['catgID'])) {
      $catgId = isset($_GET['catgID']) ? htmlspecialchars($_GET['catgID']) : '';
      $sql = " SELECT *, DATE_FORMAT(proDate,'%D %M %Y') as dateP 
      from tbl_product 
      WHERE catgID = :catg";
      $query = $pdo->prepare($sql);
      $query->bindParam(':catg', $catgId);
    } elseif (isset($_GET['keyword'])) {
      $keyword = isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '';
      $sql = "SELECT *, DATE_FORMAT(proDate,'%D %M %Y') as dateP 
      FROM tbl_product 
      WHERE proName LIKE '%:keyword%' ";
      $query = $pdo->prepare($sql);
      $query->bindParam(':keyword', $keyword);
    } else {
      $sql = " SELECT *, DATE_FORMAT(proDate,'%D %M %Y') as dateP FROM tbl_product ";
      $query = $pdo->prepare($sql);
    }
    $query->execute();
    $Num_Rows = $query->rowCount();
    $Per_Page = 10;   // Per Page
    $Page = isset($_GET["page"]) ? $_GET["page"] : 1;
    $Prev_Page = $Page - 1;
    $Next_Page = $Page + 1;
    $Page_Start = (($Per_Page * $Page) - $Per_Page);
    if ($Num_Rows <= $Per_Page) {
      $Num_Pages = 1;
    } else if (($Num_Rows % $Per_Page) == 0) {
      $Num_Pages = ($Num_Rows / $Per_Page);
    } else {
      $Num_Pages = ($Num_Rows / $Per_Page) + 1;
      $Num_Pages = (int)$Num_Pages;
    }
    $sql .= " LIMIT $Page_Start , $Per_Page";
    $query  = $pdo->query($sql);
    while ($rowproduct = $query->fetch(PDO::FETCH_OBJ)) {
      $sql2 = $pdo->prepare("SELECT SUM(qty) AS sumqty,payoption
                  FROM tbl_order_detail left join tbl_order USING orderID
                  WHERE proID = ':proID' AND status = 'no'
                  AND showOrder <> 'no'
                  GROUP BY proID; ");
      $sql2->bindParam(':proID', $rowproduct->proID);
      $sql2->execute();
      $rsqty = $sql2->fetch(PDO::FETCH_OBJ);
    ?>
      <div class="col-md-6 col-lg-6">
        <div class="card mb-4 box-shadow">
          <img class="card-img-top" style="height: auto; width: 100%; display: block;" src="image/<?php echo $rowproduct->proPic ?>" data-holder-rendered="true">
          <div class="card-body">
            <p>
              <i><strong><?php echo $rowproduct->proName; ?></strong></i>
            </p>
            <p class="card-text details-product">
              <?php echo nl2br($rowproduct->proDetails); ?>
            </p>
            <h4 class="text-info">ราคา : <?php echo number_format($rowproduct->proPrice, 2); ?> THB</h4>
            <p>คงเหลือ : <?php echo $rowproduct->proQty . " " . $rowproduct->UnitName; ?>
              <?php if (isset($rsqty) && $rsqty != false) { ?>(รอชำระเงิน : <?php echo $rsqty->sumqty; ?>)<?php } ?></p>
            <div class="d-flex justify-content-between align-items-center">
              <div class="btn-group">
                <?php

                $key = @array_search($rowproduct->proID, $_SESSION['proID']);
                $qty = isset($_SESSION['qty'][$key]) ? $_SESSION['qty'][$key] : 0;
                if (isset($rsqty) && $rsqty !== false) :
                  if ($qty < $rowproduct->proQty - $rsqty->sumqty && $rsqty->sumqty < $rowproduct->proQty) {
                ?>
                    <button type="button" onclick="window.location='bookingcart.php?proID=<?php echo $rowproduct->proID; ?>'" class="btn btn-sm btn-info"><i>สั่งซื้อ</i></button>
                <?php
                  }
                endif;
                ?>
                <button type="button" onclick="window.location='details.php?proID=<?php echo $rowproduct->proID; ?>'" class="btn btn-sm btn-info"><i>รายละเอียด</i></button>
              </div>
              <span class="badge badge-info"><?php echo $rowproduct->dateP; ?></span>
            </div>
          </div>
        </div>
      </div>
    <?php
    } ?>
    <!--สิ้นสุดการแสดงสินค้า-->
  </div>
  <hr>
  <nav aria-label="Page navigation example">
    <ul class="pagination">
      <?php if ($Prev_Page) { ?>
        <li class="page-item">
          <a class="page-link" href="<?php echo $_SERVER['SCRIP_NAME'] ?>?<?php if ($_GET['catgID']) { ?>catgID=<?php echo $_GET['catgID'] . "&"; ?><?php } elseif ($_GET['keyword']) { ?>keyword=<?php echo $_GET['keyword'] . "&"; ?><?php } ?>page=<?php echo $Prev_Page; ?>" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
      <?php } ?>
      <?php for ($i = 1; $i <= $Num_Pages; $i++) { ?>
        <?php if ($i != $Page) { ?>
          <li class="page-item">
            <a class="page-link" href="<?php echo $_SERVER['SCRIP_NAME'] ?>?<?php if ($_GET['catgID']) { ?>catgID=<?php echo $_GET['catgID'] . "&"; ?><?php } elseif ($_GET['keyword']) { ?>keyword=<?php echo $_GET['keyword'] . "&"; ?><?php } ?>page=<?php echo $i; ?>"><?php echo $i; ?></a>
          </li>
        <?php } else { ?>
          <li class="page-item active">
            <a class="page-link"><?php echo $i; ?></a>
          </li>
        <?php } ?>
      <?php }
      if ($Page != $Num_Pages) {
      ?>
        <li class="page-item">
          <a class="page-link" href="<?php echo $_SERVER['SCRIP_NAME'] ?>?<?php if ($_GET['catgID']) { ?>catgID=<?php echo $_GET['catgID'] . "&"; ?><?php } elseif ($_GET['keyword']) { ?>keyword=<?php echo $_GET['keyword'] . "&"; ?><?php } ?>page=<?php echo $Next_Page; ?>" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      <?php } ?>
    </ul>
  </nav>

</div>
<?php require_once 'footer.php' ?>