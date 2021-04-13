        <div class="col-md-3">
          <br>
          <div class="card " >
            <div class="card-header bg-info text-white">
              <h5><i class="fa fa-tags" aria-hidden="true"></i> ประเภทสินค้า</h5>
            </div>
            <div class="card-body">
              <ul class="list-group list-group-flush">

                <li class="list-group-item"><a href="index.php">สินค้าทั้งหมด</a></li>

                <?php 
                $result_catg = $pdo->query(" select * from tbl_categories ");
                while($rs_catg = $result_catg->fetch(PDO::FETCH_OBJ)){
                ?>

                <li class="list-group-item"><a href="index.php?catgID=<?php echo $rs_catg->catgID ?>"><?php echo $rs_catg->catgName; ?></a></li>

                <?php } ?>
                  
              </ul>
            </div>
          </div>


          <br>
            <div class="card " >
              <div class="card-header bg-info text-white">
                <h5><i class="fa fa-tags" aria-hidden="true"></i> สินค้ายอดนิยม</h5>
              </div>
              <div class="card-body">
                  <ul class="list-group list-group-flush">
                    <?php 
                    $sqlavg = $pdo->query("SELECT *,AVG(rating) AS avgrate
                          FROM tbl_product 
                          INNER JOIN tbl_rating 
                          ON (tbl_product.proID = tbl_rating.proID) 
                          GROUP BY tbl_rating.proID ORDER BY avgrate DESC LIMIT 4");
                    while ($rsavg=$sqlavg->fetch(PDO::FETCH_OBJ)) {
                    ?>
                    <li class="list-group-item">
                      <?php echo $rsavg->proName."<br>(คะแนน : ".number_format($rsavg->avgrate,2).")"; ?>
                      <a class="btn btn-info btn-sm" href="details.php?proID=<?php echo $rsavg->proID ?>">รายละเอียด</a>
                    </li>
                    <?php } ?>
                  </ul>
              </div>
            </div>


          <br>
          <div class="card " >
            <div class="card-header bg-info text-white">
              <h5><i class="fa fa-tags" aria-hidden="true"></i> สินค้าใหม่</h5>
            </div>
            <div class="card-body">
              <ul class="list-group list-group-flush">
                <?php
                  $sql = $pdo->query(" SELECT * from tbl_product 
                  WHERE curdate()<date_add(proDate,interval 7 day) ORDER BY RAND() LIMIT 3 ");
                  while($rs_new = $sql->fetch(PDO::FETCH_OBJ)){
                ?>
                  <li class="list-group-item">
                    <span class="badge badge-warning">New</span> <?php echo $rs_new->proName; ?><br>
                    <a class="btn btn-info btn-sm" href="details.php?proID=<?php echo $rs_new->proID ?>">รายละเอียด</a>
                  </li>
                <?php } ?>
              </ul>
            </div>
          </div>

        </div>
