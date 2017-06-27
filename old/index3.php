<?php
set_time_limit(0);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <!--<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">-->
        <meta http-equiv="Content-Type" content="text/html; charset=Windows-1251">
        <title>Sample</title>
    </head>
    <body>
		<style type="text/css">
			input[type=submit]{
				background-image: -webkit-gradient(linear,left top,left bottom,from(#f5f5f5),to(#f1f1f1));
				background-image: -webkit-linear-gradient(top,#f5f5f5,#f1f1f1);
				-webkit-border-radius: 2px;
				-webkit-user-select: none;
				background-color: #f2f2f2;
				border: 1px solid #f2f2f2;
				border-radius: 2px;
				color: #757575;
				cursor: default;
				font-family: arial,sans-serif;
				font-size: 13px;
				font-weight: bold;
				margin: 11px 4px;
				min-width: 54px;
				padding: 0 16px;
				text-align: center;
				height: 40px;
			}
			input[type=]
		</style>
		<form action="" method="post">
			<input type="text" size="100" name="email"/>
			<input type="submit" name="submit" value="Validate Email">
		</form>
		<?php
		include_once 'SMTP_validateEmail.php';

		if(isset($_POST['submit'])){
			$email = $_POST['email'];
			$sender = 'ankitit14@gmail.com';
			$SMTP_Validator = new SMTP_validateEmail();
			// turn on debugging if you want to view the SMTP transaction
			$SMTP_Validator->debug = true;
			// do the validation
			$results = $SMTP_Validator->validate(array($email), $sender);
			// view results
			echo $email.' is '.($results[$email] ? 'valid' : 'invalid')."\n";
			// send email? 
			if ($results[$email]) {
			  //mail($email, 'Confirm Email', 'Please reply to this email to confirm', 'From:'.$sender."\r\n"); // send email
			} else {
			  echo 'The email addresses you entered is not valid';
			}
		}
		?>
    </body>
</html>
