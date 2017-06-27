<?php
set_time_limit(0);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Verify Email</title>
        <style type='text/css'>
            input[type=submit]{
                display: block;
                background: #a2b4f5;
                color: #FFF;
                height: 30px;
                line-height: 20px;
                border: none;
                margin: 5px;
            }
            table, tr, td{
                border-collapse: collapse;
            }
            table {
                font-size: 16px;
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                border-spacing: 0;
                width: 500px;
                margin: 20px;
            }
            th {
                padding-top: 11px;
                padding-bottom: 11px;
                background-color: #ccc;
                color: white;
            }
            tr td {
                border: 1px solid #ddd;
                text-align: left;
                padding: 8px;
            }
            tr:odd {
                background: #ddd;
            }
            table.valid th{
                background-color: #4CAF50;
            }
            table.invalid th{
                background-color: #F00;
            }
            div.column{
                display: inline-block;
                width: 45%;
            }
            div.column.left {
                float: left;
            }
            div.column.right {
                float: right;
            }
        </style>
        <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script type="text/javascript">
            var result = [];
            function afterUpload(){
                $('#processingMsg').html('Showing data...Please wait');
                $.ajax({
                    data: {'action': 'VIEW_DATA'}, 
                    url: 'api.php', 
                    method: 'post',
                    dataType: 'json',
                    success: function (data) {
                        result = data;
                        $('#processingMsg').empty();
                        for(var i=0; i < data.length; i++){
                            $('table.upload tbody')
                                .append('<tr><td>'+data[i]+'</td><td>Uploaded</td></tr>')
                        }
                        validateEmail();
                }});

            }
            function validateEmail(){
                $('#processingMsg').html('Testing emails...Please email');
                for(var i=0; i < result.length; i++){
                    $.ajax({
                        data: {'action': 'VALIDATE', 'email': result[i]}, 
                        url: 'api.php', 
                        method: 'post',
                        success: function (data) {
                            $('#processingMsg').empty();
                            var response = data.split('|');
                            if(response[0] == 'valid'){
                                $('table.valid tbody').append('<tr><td>'+response[1]+'</td></tr>');
                            }
                            if(response[0] == 'invalid'){
                                $('table.invalid tbody').append('<tr><td>'+response[1]+'</td></tr>');
                            }
                        }
                    });
                }
            }
        </script>
        <?php
            if(isset($_GET['msg']) && $_GET['msg'] == 'done'){
                echo "<script type='text/javascript'>afterUpload();</script>";
            }
        ?>
    </head>
    <body>
		<form action="api.php" method="post" enctype='multipart/form-data'>
			<input type="file" name="file"/>
			<input type="submit" name="btnUploadData" value="Upload CSV">
            <div id="processingMsg"></div>
            <table class="upload">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Uploaded</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div> 
                <div class="column left">
                    <table class='valid'>
                        <thead>
                            <tr>
                                <th>Valid Email</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="column right">
                    <table class="invalid">
                        <thead>
                            <tr>
                                <th>Invalid Email</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            
		</form>
    </body>
</html>
