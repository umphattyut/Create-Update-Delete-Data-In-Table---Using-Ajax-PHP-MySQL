<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update & Delete Data In Table</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
<form id="update_form" enctype="multipart/form-data">
    <input type="hidden" id="get_ids" name="id">
    <label for="username">Username(unable to update):</label><br>
    <input type="text" id="username" name="username" readonly><br><br>
    <label for="fistname">First Name:</label><br>
    <input type="text" id="firstname" name="f_name"><br><br>
    <label for="lastname">Last Name:</label><br>
    <input type="text" id="lastname" name="l_name"><br><br>
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email"><br><br>
    <input type="submit" value="Update">
</form>
<br>
<!-- To Show Message -->
<div id="response"></div>
<table width="50%" border="1" cellspacing="0" cellpadding="0" style="text-align: center;">
    <thead>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Action</th>
    </thead>
    <tbody id="load_table">
        
    </tbody>
</table>
<script>
$(document).ready(function(){
    function loadData() {
        $.ajax({
            url: 'sql.php',
            success: function(response) {
                // Get data and show inside HTML/Tags
                $('#load_table').html(response);
            }
        });
    }

    loadData();

    $('#update_form').on('submit', function(e) {
        e.preventDefault();
        var get_ids = $('#get_ids').val();
        var username = $('#username').val();
        var f_name = $('#firstname').val();
        var l_name = $('#lastname').val();
        var email = $('#email').val();
        $.ajax({
            url: 'sql.php',
            type: 'POST',
            data: {
                updateData: true,
                user_name: username,
                up_ids: get_ids,
                f_name: f_name,
                l_name: l_name,
                email: email
            },
            success: function(response) {
                var res = jQuery.parseJSON(response);
                if(res.status == 422) {
                    $('#response').text(res.message);
                } else if(res.status == 500) {
                    $('#response').text(res.message);
                } else{
                    $('#response').text(res.message);
                    // Clear textbox after saved
                    $('#username').val('');
                    $('#firstname').val('');
                    $('#lastname').val('');
                    $('#email').val('');
                    $('#response').text(res.message);
                    loadData();
                    return false;
                }
            }
        });
    });

    $(document).on('click', '.updateData', function () {
        var data_id = $(this).attr('id');
        // alert(data_id);
        $.ajax({
            url: "sql.php",
            type: "GET",
            data: {
                get_info: true,
                get_id: data_id
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if(res.status == 404) {
                    $('#response').text(res.message);
                } else if(res.status == 200){
                    $('#get_ids').val(res.data.id);
                    $('#username').val(res.data.username);
                    $('#firstname').val(res.data.f_name);
                    $('#lastname').val(res.data.l_name);
                    $('#email').val(res.data.email);
                    $('#response').text(res.message);
                }
            }
        });
    });

    $(document).on('click', '.deleteData', function () {
        var data_id = $(this).attr('id');
        // alert(data_id);
        $.ajax({
            url: "sql.php",
            type: "GET",
            data: {
                delete_data: true,
                del_ids: data_id
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if(res.status == 404) {
                    $('#response').text(res.message);
                } else if(res.status == 200){
                    $('#response').text(res.message);
                    loadData();
                    return false;
                }
            }
        });
    });
});
</script>
</body>
</html>
