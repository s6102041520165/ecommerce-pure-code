<?php require_once 'header.php' ?>
<?php require_once 'sidebar.php' ?>
<?php
$trackingArr = [];
$rawObj = "";
$sql = $pdo->query("select * from tbl_activities_heading");

?>


<div class="col-md-9 col-lg-9">
    <br>
    <div class="card border-pink">
        <div class="card-header bg-pink text-light">
            <span class="fa fa-image"></span> กิจกรรม
        </div>
        <div class="card-body">
            <ul class="list-group">
            <?php while ($data = $sql->fetch(PDO::FETCH_ASSOC)) : ?>
                <li class="list-group-item"><a href="activity.php?activity_id=<?=$data['id']?>"><?=$data['caption']?></a></li>
            <?php endwhile; ?>
            </ul>
        </div>
    </div>
</div>


<?php require_once 'footer.php' ?>