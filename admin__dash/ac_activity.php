<?php
require_once '../condb.php';
if (isset($_GET['action']) && $_GET['action'] == "add") {
    $update = $pdo->query(" INSERT INTO tbl_activities_heading (`caption`, `description`)
            VALUES ('" . $_POST['caption'] . "', 
            '" . $_POST['description'] . "'
            ) ");
    $id = $pdo->lastInsertId();

    if ($_FILES['picture']['tmp_name']) {
        for ($i = 0; $i < count($_FILES['picture']['tmp_name']); $i++) {
            $picname = $_FILES['picture']['name'];
            $ext2 = pathinfo($picname[$i], PATHINFO_EXTENSION);
            $name2 = "activity_" . $rand . "_" . $i . "." . $ext2;
            $tmp2 = $_FILES['picture']['tmp_name'];
            if ($tmp2[$i] != NULL) {
                move_uploaded_file($tmp2[$i], "../image/" . $name2);
                $update2 = $pdo->query(" INSERT INTO tbl_sub_activity (picture,activity_id)
                        VALUES ('" . $name2 . "','" . $id . "') ");
            }
        }
    }
    if ($update) {
        echo "<script>window.history.go(-2);</script>";
    } else {
        echo "<script>alert('ไม่สามารถเพิ่มข้อมูลได้');</script>";
        echo "<script>window.history.back();</script>";
    }
} elseif (isset($_GET['action']) && $_GET['action'] == "remove" && isset($_GET['activity_id'])) {
    $update = $pdo->query(" DELETE FROM tbl_activities_heading where id = '" . $_GET['activity_id'] . "' ");
    echo "<script>window.history.back();</script>";
} elseif (isset($_GET['action']) && $_GET['action'] == "edit" && isset($_POST['activity_id'])) {

    $update = $pdo->query(" UPDATE tbl_activities_heading SET
            caption = '" . $_POST['caption'] . "', 
            description = '" . $_POST['description'] . "'
            WHERE id = '" . $_POST['activity_id'] . "' ");

    if (isset($_FILES['picture']['tmp_name'])) {
        for ($i = 0; $i < count($_FILES['picture']['tmp_name']); $i++) {
            $picname = $_FILES['picture']['name'];
            $ext2 = pathinfo($picname[$i], PATHINFO_EXTENSION);
            $name2 = "activity_" . $rand . "_" . $i . "." . $ext2;
            $tmp2 = $_FILES['picture']['tmp_name'];
            if ($tmp2[$i] != NULL) {
                move_uploaded_file($tmp2[$i], "../image/" . $name2);
                $update2 = $pdo->query(" INSERT INTO tbl_sub_activity (picture,activity_id)
                         VALUES ('" . $name2 . "','" . $_POST['activity_id'] . "') ");
            }
        }
    }
    if ($update) {
        echo "<script>window.history.go(-2);</script>";
    } else {
        echo "<script>alert('ไม่สามารถแก้ไขข้อมูลได้');</script>";
        echo "<script>window.history.back();</script>";
    }
} elseif (isset($_GET['action']) && $_GET['action'] == "remove_pic" && isset($_GET['id'])) {
    $update = $pdo->query(" DELETE FROM tbl_sub_activity WHERE id='" . $_GET['id'] . "' ");
    @unlink("../image/" . $_GET['picture']);
    echo "<script>window.history.back();</script>";
}
?>
<meta charset="utf-8" />