<?php
include_once('db.php');
// Use isset $_POST['']
if(isset($_POST['updateData'])) {
    // use addslashes() to accept strings with slashes
    // use strip_tags() to avoid html/script tags
    $up_ids = strip_tags(trim(addslashes($_POST['up_ids'])));
    $username = strip_tags(trim(addslashes($_POST['user_name'])));
    $f_name = strip_tags(trim(addslashes($_POST['f_name'])));
    $l_name =  strip_tags(trim(addslashes($_POST['l_name'])));
    $email = strip_tags(trim(addslashes($_POST['email'])));
    // Check the fields to make sure they are not empty
    // If one field has no string, it won't be saved into database
    if ($username == '' || $f_name == '' || $l_name == '' || $email == '') {
       $res = [
            'status' => 422,
            'message' => 'All fields are required!'
        ];
        echo json_encode($res);
        return;
    }
    else {
        // Prepare to insert into table
        $mySQL = "UPDATE `tbl_user` SET `f_name`='$f_name', `l_name`='$l_name', `email`='$email' WHERE `id`='$up_ids'";
        $sql_query = mysqli_query($mysqli, $mySQL);
        // Query if mySQL is true or false
        if ($sql_query == TRUE) {
           $res = [
                'status' => 200,
                'message' => 'Data Updated Successfully!'
            ];
            echo json_encode($res);
            return;
        }
        else {
            $res = [
                'status' => 500,
                'message' => 'Data not updated!'
            ];
            echo json_encode($res);
            return;
        }
    }
}

if(isset($_GET['get_info'])) {
    $get_id = $_GET['get_id'];
    $mySQL = "SELECT * FROM `tbl_user` WHERE `id`='$get_id'";
    $query = mysqli_query($mysqli, $mySQL);
    if(mysqli_num_rows($query) >= 1) {
        $dataFetch = mysqli_fetch_array($query);

        $res = [
            'status' => 200,
            'message' => 'Data Fetch Successfully By iD',
            'data' => $dataFetch
        ];
        echo json_encode($res);
        return;
    }
    else {
        $res = [
            'status' => 404,
            'message' => 'Data Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}

if(isset($_GET['delete_data'])) {
    $del_ids = strip_tags(trim(addslashes($_GET['del_ids'])));
    $mySQL = "DELETE FROM `tbl_user` WHERE `id`='$del_ids'";
    $query = mysqli_query($mysqli, $mySQL);

    if($query==true) {
        $res = [
            'status' => 200,
            'message' => 'Data Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else {
        $res = [
            'status' => 500,
            'message' => 'Data Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

$sqlData = "SELECT * FROM `tbl_user`";
$queryData = mysqli_query($mysqli, $sqlData);
// Loop through $result and display messages
while ($row = mysqli_fetch_assoc($queryData)) {
    echo "<tr><td>{$row['username']}</td><td>{$row['f_name']}</td><td>{$row['l_name']}</td><td>{$row['email']}</td><td align='center'><a id='{$row['id']}' class='updateData' href='javascript:void();'>edit</a> | <a id='{$row['id']}' class='deleteData' href='javascript:void();'>del</a></td><tr>";
}
?>
