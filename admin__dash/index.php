<?php require_once 'header.php' ?>
<style>
.col-lg-4{
    padding:5px;
}
</style>
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card border-success">
            <div class="card-body text-success">
                <center>
                    <span class="fa fa-user fa-5x"></span>
                    <h1>สมาชิก</h1>
                    <p>
                        <h4>
                        <?php 
                        $sqluser = $pdo->query("SELECT * FROM tbl_user ");
                        $numuser = $sqluser->rowCount();
                        echo $numuser;
                        ?>
                        </h4>
                    </p>

                </center>
            </div>
            <div class="card-footer bg-success border-success text-white"><h5><a href="member.php">View & Edit</a> <span class="fa fa-tachometer-alt"></span></h5></div>
        </div>        
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card border-primary">
            <div class="card-body text-primary">
                <center>
                    <span class="fa fa-list-alt fa-5x"></span>
                    <h1>ประเภทสินค้า</h1>
                    <p>
                        <h4>
                        <?php 
                        $sqlcatg = $pdo->query("SELECT * FROM tbl_categories ");
                        $numcatg = $sqlcatg->rowCount();;
                        echo $numcatg;
                        ?>
                        </h4>
                    </p>

                </center>
            </div>
            <div class="card-footer bg-primary border-primary text-white"><h5><a href="categories.php">View & Edit</a> <span class="fa fa-tachometer-alt"></span></h5></div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card border-danger">
            <div class="card-body text-danger">
                <center>
                    <span class="fa fa-th-list fa-5x"></span>
                    <h1>สินค้า</h1>
                    <p>
                        <h4>
                        <?php 
                        $sqlproduct = $pdo->query("SELECT * FROM tbl_product ");
                        $numproduct = $sqlproduct->rowCount();
                        echo $numproduct;
                        ?>
                        </h4>
                    </p>

                </center>
            </div>
            <div class="card-footer bg-danger border-danger text-white">
            <h5><a href="product.php">View & Edit</a> <span class="fa fa-tachometer-alt"></span></h5></div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card border-info">
            <div class="card-body text-info">
                <center>
                    <span class="fa fa-shopping-cart fa-5x"></span>
                    <h1>ใบสั่งซื้อรอดำเนินการ</h1>
                    <p>
                        <h4>
                        <?php 
                        $sqlorder = $pdo->query("SELECT * FROM tbl_order WHERE status = 'no' AND showOrder='yes' ");
                        $numorder = $sqlorder->rowCount();
                        echo $numorder;
                        ?>
                        </h4>
                    </p>

                </center>
            </div>
            <div class="card-footer bg-info border-info text-white">
            <h5><a href="order.php?status=1">View & Edit</a> <span class="fa fa-tachometer-alt"></span></h5></div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card border-secondary">
            <div class="card-body text-secondary">
                <center>
                    <span class="fa fa-shopping-cart fa-5x"></span>
                    <h1>ใบสั่งซื้อดำเนินการแล้ว</h1>
                    <p>
                        <h4>
                        <?php 
                        $sqlorder2 = $pdo->query("SELECT * FROM tbl_order WHERE status = 'yes' AND showOrder='yes' ");
                        $numorder2 = $sqlorder2->rowCount();
                        echo $numorder2;
                        ?>
                        </h4>
                    </p>

                </center>
            </div>
            <div class="card-footer bg-secondary border-secondary text-white">
            <h5><a href="order.php?status=2">View & Edit</a> <span class="fa fa-tachometer-alt"></span></h5></div>
        </div>
    </div>
</div>
<hr>
<div class="col-lg-12">
<?php 
    $sql = " select * from tbl_store where 1 ";
    $query = $pdo->query( $sql);
    $rs_user = $query->fetch(PDO::FETCH_ASSOC);
    ?>
    <form enctype="multipart/form-data" name="frmedit" action="ac_store.php?action=edit" onsubmit="return chkfirm('คุณต้องการดำเนินการต่อหรือไม่');" method="post">
        <center><h1>ข้อมูลร้านค้า</h1></center>
        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">ชื่อ</label>
            </div>
            <input type="text" value="<?php echo $rs_user['name'] ?>" class="form-control" required name="name">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">นามสกุล</label>
            </div>
            <input type="text" value="<?php echo $rs_user['surname'] ?>" class="form-control" required name="surname">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">อีเมล์</label>
            </div>
            <input type="email" value="<?php echo $rs_user['email'] ?>" class="form-control" required name="email">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">เบอร์โทร</label>
            </div>
            <input type="text" value="<?php echo $rs_user['tel'] ?>" maxlength="10" class="form-control" required name="tel">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">ที่อยู่</label>
            </div>
            <textarea rows="5" class="form-control" required name="addr"><?php echo $rs_user['addr'] ?></textarea>
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">ตำบล/แขวง</label>
            </div>
            <input type="text" value="<?php echo $rs_user['locality'] ?>" class="form-control" required name="locality">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">อำเภอ/เขต</label>
            </div>
            <input type="text" value="<?php echo $rs_user['district'] ?>" class="form-control" required name="district">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">จังหวัด</label>
            </div>
            <input type="text" value="<?php echo $rs_user['province'] ?>" class="form-control" required name="province">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">รหัสไปรษณีย์</label>
            </div>
            <input type="text" value="<?php echo $rs_user['zipcode'] ?>" class="form-control" required name="zipcode">
        </div>

        <button type="submit" class="btn btn-primary">บันทึก</button>
    </form>
</div>
<?php require_once 'footer.php' ?>