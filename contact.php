<?php require_once 'header.php' ?>
<?php
$sqlstore = $pdo->query(" select * from tbl_store where 1 ");
$rs_store = $sqlstore->fetch(PDO::FETCH_ASSOC);
if($_GET['action']=='sendmail'){
	$strTo = $_POST["txtTo"];
	$strSubject = $_POST["txtSubject"];
	$strHeader = "Content-type: text/html; charset=utf-8\r\n"; // or UTF-8 //
	$strHeader .= "From: ".$_POST["txtFormName"]."<".$_POST["txtFormEmail"].">\r\nReply-To: ".$_POST["txtFormEmail"]."";
	$strMessage = nl2br($_POST["txtDescription"]);
	$flgSend = @mail($strTo,$strSubject,$strMessage,$strHeader);  // @ = No Show Error //
	if($flgSend)
	{
        echo "<script>alert('ส่งอีเมล์สำเร็จ');</script>";
        echo "<script>window.history.back();</script>";
	}
	else
	{
        echo "<script>alert('ไม่สามารถส่งอีเมล์ได้ค่ะ');</script>";
        echo "<script>window.history.back();</script>";
    }
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
    <form action="contact.php?action=sendmail" method="post" name="frmMain">
        <div class="form-group">
            ถึง
            <input required class="form-control" value="<?php echo $rs_store['email'] ?>" name="txtTo" type="text" id="txtTo">
        </div> 
        <div class="form-group">
            หัวเรื่อง
            <input required class="form-control" name="txtSubject" type="text" id="txtSubject">
        </div>
        <div class="form-group">
            รายละเอียด
            <textarea required class="form-control" name="txtDescription" cols="30" rows="4" id="txtDescription"></textarea>
        </div>
        <div class="form-group">
            ชื่อ - สกุล
            <input required class="form-control" value="<?php echo $rs_member->name." ".$rs_member->surname; ?>" name="txtFormName" type="text">
        </div>
        <div class="form-group">
            อีเมล์
            <input required class="form-control" value="<?php echo $rs_member->email ?>" name="txtFormEmail" type="text">
        </div>
        <button class="btn btn-primary" type="submit" name="Submit">ส่งอีเมล์</button>
    </form>
</div>
<script src="js/foundation.min.js"></script>
<script src="js/setup.js"></script>
<?php require_once 'footer.php' ?>