<?php require_once 'header.php' ?>
<style>
.col-lg-4{
    padding:5px;
}
</style>
<div class="row">
    <div class="col-lg-4">
        <div class="card border-success">
            <div class="card-body text-success">
                <center>
                    <span class="fa fa-user fa-5x"></span>
                    <h1>สมาชิก</h1>
                    <p>
                        <h4>
                        <?php 
                        $sqluser = $pdo->query("SELECT * FROM tbl_user ");
                        $numuser = mysqli_num_rows($sqluser);
                        echo $numuser;
                        ?>
                        </h4>
                    </p>

                </center>
            </div>
            <div class="card-footer bg-success border-success text-white"><h5><a href="member.php">View & Edit</a> <span class="fa fa-tachometer-alt"></span></h5></div>
        </div>        
    </div>

    <div class="col-lg-4">
        <div class="card border-primary">
            <div class="card-body text-primary">
                <center>
                    <span class="fa fa-list-alt fa-5x"></span>
                    <h1>ประเภทสินค้า</h1>
                    <p>
                        <h4>
                        <?php 
                        $sqlcatg = $pdo->query("SELECT * FROM tbl_categories ");
                        $numcatg = mysqli_num_rows($sqlcatg);
                        echo $numcatg;
                        ?>
                        </h4>
                    </p>

                </center>
            </div>
            <div class="card-footer bg-primary border-primary text-white"><h5><a href="categories.php">View & Edit</a> <span class="fa fa-tachometer-alt"></span></h5></div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-danger">
            <div class="card-body text-danger">
                <center>
                    <span class="fa fa-th-list fa-5x"></span>
                    <h1>สินค้า</h1>
                    <p>
                        <h4>
                        <?php 
                        $sqlproduct = $pdo->query("SELECT * FROM tbl_product ");
                        $numproduct = mysqli_num_rows($sqlproduct);
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

    <div class="col-lg-4">
        <div class="card border-info">
            <div class="card-body text-info">
                <center>
                    <span class="fa fa-shopping-cart fa-5x"></span>
                    <h1>ใบสั่งซื้อรอดำเนินการ</h1>
                    <p>
                        <h4>
                        <?php 
                        $sqlorder = $pdo->query("SELECT * FROM tbl_order WHERE status = 'no' AND showOrder='yes' ");
                        $numorder = mysqli_num_rows($sqlorder);
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

    <div class="col-lg-4">
        <div class="card border-secondary">
            <div class="card-body text-secondary">
                <center>
                    <span class="fa fa-shopping-cart fa-5x"></span>
                    <h1>ใบสั่งซื้อดำเนินการแล้ว</h1>
                    <p>
                        <h4>
                        <?php 
                        $sqlorder2 = $pdo->query("SELECT * FROM tbl_order WHERE status = 'yes' AND showOrder='yes' ");
                        $numorder2 = mysqli_num_rows($sqlorder2);
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
<?php require_once 'footer.php' ?>