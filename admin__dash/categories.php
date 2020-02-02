<?php require_once 'header.php' ?>

<?php if($_GET['form']=='add') { ?>
    <p><button onclick="window.history.back()" class="btn btn-warning"><span class="fa fa-undo-alt" ></span> Back</button></p>
    <form enctype="multipart/form-data" name="frmadd" action="ac_categories.php?action=add" onsubmit="return checkpass();" method="post">
        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">ประเภทสินค้า</label>
            </div>
            <input type="text" class="form-control" required name="catgName">
        </div>

        <button type="submit" class="btn btn-primary">เพิ่มประเภทสินค้า</button>
    </form>
<?php } elseif($_GET['form']=='edit') { ?>
    <?php 
    $sql = " select * from tbl_categories where catgID = '".$_GET['catgID']."' ";
    $query = $pdo->query( $sql);
    $rs_categories = $query->fetch(PDO::FETCH_ASSOC);
    ?>
    <form enctype="multipart/form-data" name="frmedit" action="ac_categories.php?action=edit" onsubmit="return checkpass();" method="post">
        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">รหัสประเภทสินค้า</label>
            </div>
            <input type="text" value="<?php echo $rs_categories['catgID'] ?>" disabled autocomplete="off" class="form-control" required >
            <input type="hidden" name="catgID" value="<?php echo $rs_categories['catgID'] ?>">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">ประเภทสินค้า</label>
            </div>
            <input type="text" value="<?php echo $rs_categories['catgName'] ?>" class="form-control" required name="catgName">
        </div>

        <button type="submit" class="btn btn-primary">บันทึก</button>
    </form>
<?php } else { ?>
    <?php
    if(isset($_GET['keyword'])){
        $sql = " SELECT * from tbl_categories WHERE catgName LIKE '%".$_GET['keyword']."%' ";
        $query = $pdo->query( $sql);
    } else {
        $sql = " select * from tbl_categories ";
        $query = $pdo->query( $sql);
    }
    $Num_Rows = $query->rowCount();
    $Per_Page = 5;   // Per Page
    $Page = $_GET["page"];
    if(!$_GET["page"])
    {
        $Page=1;
    }
    $Prev_Page = $Page-1;
    $Next_Page = $Page+1;
    $Page_Start = (($Per_Page*$Page)-$Per_Page);
    if($Num_Rows<=$Per_Page)
    {
        $Num_Pages =1;
    }
    else if(($Num_Rows % $Per_Page)==0)
    {
        $Num_Pages =($Num_Rows/$Per_Page) ;
    }
    else
    {
        $Num_Pages =($Num_Rows/$Per_Page)+1;
        $Num_Pages = (int)$Num_Pages;
    }
    $sql .=" order by catgName ASC LIMIT $Page_Start , $Per_Page";
    $query  = $pdo->query($sql) or die(mysqli_error($conn));
    $number = 1;
    ?>
    <p><button onclick="window.location='<?php echo $_SERVER['SCRIPT_NAME']; ?>?form=add'" class="btn btn-primary"><span class="fa fa-plus"></span> เพิ่มประเภทสินค้า</button></p>
    <div class="table-responsive-sm table-responsive-md table-responsive-lg">
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>ลำดับ</td>
                    <td>ประเภทสินค้า</td>
                    <td>การจัดการ</td>
                </tr>
            </thead>
            <tbody>
            <?php 
                while($rs_categories=$query->fetch(PDO::FETCH_ASSOC)){
            ?>
                <tr>
                    <td width="10%"><?php echo $number; ?></td>
                    <td width="80%"><?php echo $rs_categories['catgName']; ?></td>

                    <td width="10%">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?form=edit&catgID=<?php echo $rs_categories['catgID'] ?>" class="btn btn-outline-primary btn-sm "><span class="fa fa-edit"></span></a>
                            <a href="ac_categories.php?action=remove&catgID=<?php echo $rs_categories['catgID'] ?>" onclick="return chkfirm('คุณต้องการลบข้อมูลใช่หรือไม่')" class="btn btn-outline-danger btn-sm "><span class="fa fa-trash-alt"></span></a>
                        </div>
                    </td>
                </tr>
            <?php $number+=1; } ?>
            </tbody>
        </table>
    </div>
    <span class="badge badge-primary ">หน้า : <?php echo $Page."/".$Num_Pages; ?></span>
    <nav aria-label="Page navigation example">
        <br>
        <ul class="pagination">
        <?php if($Prev_Page){ ?>
            <li class="page-item">
                <a class="page-link"  href="<?php echo $_SERVER['SCRIP_NAME'] ?>?page=<?php echo $Prev_Page; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php } ?>
            <?php for($i=1; $i<=$Num_Pages; $i++){ ?>
                <?php if($i != $Page){ ?>
                    <li class="page-item">
                        <a class="page-link"  href="<?php echo $_SERVER['SCRIP_NAME'] ?>?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } else { ?>
                    <li class="page-item active">
                        <a class="page-link" ><?php echo $i; ?></a>
                    </li>
                <?php } ?>
            <?php } 
            if($Page!=$Num_Pages){
            ?>
            <li class="page-item">
                <a class="page-link"  href="<?php echo $_SERVER['SCRIP_NAME'] ?>?page=<?php echo $Next_Page;?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
            <?php } ?>
        </ul>
    </nav>
<?php } ?>
<?php require_once 'footer.php' ?>