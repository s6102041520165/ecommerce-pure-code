<?php require_once 'header.php' ?>

<?php if($_GET['form']=='add') { ?>
    <p><button onclick="window.history.back()" class="btn btn-warning"><span class="fa fa-undo-alt" ></span> Back</button></p>
    <form enctype="multipart/form-data" name="frmadd" action="ac_member.php?action=add" onsubmit="return checkpass();" method="post">
        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Username</label>
            </div>
            <input type="text" autocomplete="off" class="form-control" required name="username">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Password</label>
            </div>
            <input type="password" class="form-control" required name="password">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Re-Password</label>
            </div>
            <input type="password" class="form-control" required name="repassword">
        </div>
        <hr>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">ชื่อ</label>
            </div>
            <input type="text" class="form-control" required name="name">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">นามสกุล</label>
            </div>
            <input type="text" class="form-control" required name="surname">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">โปรไฟล์</label>
            </div>
            <input type="file" class="form-control" name="profiles">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">อีเมล์</label>
            </div>
            <input type="email" class="form-control" required name="email">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">เบอร์โทร</label>
            </div>
            <input type="text" maxlength="10" class="form-control" required name="tel">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">ที่อยู่</label>
            </div>
            <textarea rows="5" class="form-control" required name="addr"></textarea>
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">ตำบล/แขวง</label>
            </div>
            <input type="text" class="form-control" required name="locality">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">อำเภอ/เขต</label>
            </div>
            <input type="text"class="form-control" required name="district">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">จังหวัด</label>
            </div>
            <input type="text"class="form-control" required name="province">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">รหัสไปรษณีย์</label>
            </div>
            <input type="text"class="form-control" required name="zipcode">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">ระดับผู้ใช้งาน</label>
            </div>
            <select class="form-control" name="level" id="" required>
                <option value="">--กรุณาเลือกระดับผู้ใช้งาน--</option>
                <option value="customer">ลูกค้า</option>
                <option value="admin">ผู้ดูแลระบบ</option>
            </select>
        </div>


        <button type="submit" class="btn btn-primary">เพิ่มสมาชิก</button>
    </form>
<?php } elseif($_GET['form']=='edit') { ?>
    <?php 
    $sql = " select * from tbl_user where username = '".$_GET['username']."' ";
    $query = $pdo->query( $sql);
    $rs_user = $query->fetch(PDO::FETCH_ASSOC);
    ?>
    <form enctype="multipart/form-data" name="frmedit" action="ac_member.php?action=edit" onsubmit="return checkpass();" method="post">
        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Username</label>
            </div>
            <input type="text" value="<?php echo $rs_user['username'] ?>" disabled autocomplete="off" class="form-control" required >
            <input type="hidden" name="username" value="<?php echo $rs_user['username'] ?>">
        </div>

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
                <label class="input-group-text" for="inputGroupSelect01">โปรไฟล์</label>
            </div>
            <input type="file" class="form-control" name="profiles">
            <input type="hidden" name="noselect" value="<?php echo $rs_user['profiles'] ?>">
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

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">ระดับผู้ใช้งาน</label>
            </div>
            <select class="form-control" name="level" id="" required>
                <option value="" >--กรุณาเลือกระดับผู้ใช้งาน--</option>
                <option value="customer" <?php if($rs_user['level']=='customer'){ echo "selected"; } ?>>ลูกค้า</option>
                <option value="admin" <?php if($rs_user['level']=='admin'){ echo "selected"; } ?>>ผู้ดูแลระบบ</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">บันทึก</button>
    </form>
<?php } else { ?>
    <?php
    if(isset($_GET['keyword'])){
        $sql = " SELECT * from tbl_user WHERE name LIKE '%".$_GET['keyword']."%' OR surname LIKE '%".$_GET['keyword']."%' ";
        $query = $pdo->query( $sql);
    } else {
        $sql = " select * from tbl_user ";
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
    $sql .=" order by name ASC LIMIT $Page_Start , $Per_Page";
    $query  = $pdo->query($sql) or die(mysqli_error($conn));
    $number = 1;
    ?>
    <p><button onclick="window.location='<?php echo $_SERVER['SCRIPT_NAME']; ?>?form=add'" class="btn btn-primary"><span class="fa fa-plus"></span> เพิ่มสมาชิก</button></p>
    <div class="table-responsive-sm table-responsive-md table-responsive-lg">
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>ลำดับ</td>
                    <td>ชื่อ - สกุล</td>
                    <td>อีเมล์</td>
                    <td>เบอร์โทร</td>
                    <td>การจัดการ</td>
                </tr>
            </thead>
            <tbody>
            <?php 
                while($rs_user=$query->fetch(PDO::FETCH_ASSOC)){
                if($rs_user['username']!=$rs_member['username']){
            ?>
                <tr>
                    <td width="5%"><?php echo $number; ?></td>
                    <td width="45%"><?php echo $rs_user['name']." ".$rs_user['surname'] ?></td>
                    <td width="20%">
                        <?php echo $rs_user['email'] ?>
                    </td>
                    <td width="20%">
                        <?php echo $rs_user['tel'] ?>
                    </td>
                    <td width="10%">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?form=edit&username=<?php echo $rs_user['username'] ?>" class="btn btn-outline-primary btn-sm "><span class="fa fa-edit"></span></a>
                            <a href="ac_member.php?action=remove&username=<?php echo $rs_user['username'] ?>" onclick="return chkfirm('คุณต้องการลบข้อมูลใช่หรือไม่')" class="btn btn-outline-danger btn-sm "><span class="fa fa-trash-alt"></span></a>
                        </div>
                    </td>
                </tr>
            <?php $number+=1; } } ?>
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