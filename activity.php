<?php require_once 'header.php' ?>
<?php require_once 'sidebar.php' ?>
<?php
$trackingArr = [];
$rawObj = "";
$sql = $pdo->query("SELECT tbl_sub_activity.*, tbl_sub_activity.*
        from tbl_activities_heading inner join tbl_sub_activity 
        on tbl_sub_activity.activity_id = tbl_activities_heading.id
        where tbl_sub_activity.activity_id = " . $_GET['activity_id'] . " ;");
//var_dump($sql);

?>
<!-- Add mousewheel plugin (this is optional) -->
<!-- Add fancyBox -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<link rel="stylesheet" href="fancybox/fancybox-master/dist/jquery.fancybox.min.css" />
<script src="fancybox/fancybox-master/dist/jquery.fancybox.min.js"></script>

<script>
    $('[data-fancybox="gallery"]').fancybox({
        // Options will go here
    });
</script>

<div class="col-md-9 col-lg-9">
    <br>
    <div class="card border-pink">
        <div class="card-header bg-pink text-light">
            <span class="fa fa-image"></span> กิจกรรม
        </div>
        <div class="card-body">
            <?php 
            $sqlContent = $pdo->query('select * from tbl_activities_heading where id = '.$_GET['activity_id'].';');
            $ft = $sqlContent->fetch(PDO::FETCH_ASSOC);
            ?>
            <h4>หัวข้อ : <?=$ft['caption']?></h4>
            <p>
                <?=$ft['description']?>
            </p>
            <?php while ($data = $sql->fetch(PDO::FETCH_ASSOC)) : ?>
                <a data-fancybox="gallery" data-caption="<?= $data['caption'] ?>" rel="group" href="image/<?= $data['picture'] ?>">
                    <img style="max-width: 300px;height:auto;margin:10px" src="image/<?= $data['picture'] ?>" alt="" />
                </a>
            <?php endwhile; ?>
        </div>
    </div>
</div>


<?php require_once 'footer.php' ?>