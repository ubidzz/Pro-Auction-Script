<!DOCTYPE html>
<html lang="{LANGUAGE}" dir="{DOCDIR}">
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="{LANGUAGE}" dir="{DOCDIR}"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="{LANGUAGE}" dir="{DOCDIR}"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="{LANGUAGE}" dir="{DOCDIR}"> <![endif]-->
<!--[if IE 9]>    <html class="lt-ie10" lang="{LANGUAGE}" dir="{DOCDIR}"> <![endif]-->
<!--[if gt IE 9]><!--><html lang="{LANGUAGE}" dir="{DOCDIR}"><!--<![endif]-->

<head>
	<meta charset="{CHARSET}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/ico" href="{SITEURL}{FAVICON}"/>
    <!-- Bootstrap -->
    <link href="{SITEURL}themes/{ADMIN_THEME}/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{SITEURL}themes/{ADMIN_THEME}/css/signin.css" rel="stylesheet">
    <title>{L_3500_1015826}</title>
    <script type="text/javascript" src="{SITEURL}loader.php?js=js/jquery.js{EXTRAJS}"></script>
</head>
<body>
	<div class="container">
		<form class="form-signin" action="login.php" method="post">
	        <h2 class="form-signin-heading">{L_052}</h2>
	        <!-- IF PAGE eq 1 -->
           	<h4>{L_441}</h4>
            <h4>{L_3500_1015459}</h4>
            <!-- ENDIF -->
	        <!-- IF ERROR ne '' -->
			<p style="color:red;">{ERROR}</p>
			<!-- ENDIF -->
	        <label for="inputUsername" class="sr-only">{L_003}</label>
	        <input type="text" name="username" id="inputUsername" class="form-control" placeholder="{L_003}">
	        <label for="inputPassword" class="sr-only">{L_004}</label>
	        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="{L_004}">
	        <!-- IF PAGE eq 1 -->
		        <h4>{L_3500_1015460}</h4>
		        <label for="inputfull_name" class="sr-only">{L_002}</label>
		        <input type="text" name="full_name" id="inputfull_name" class="form-control" placeholder="{L_002}">
				<label for="inputuser_name" class="sr-only">{L_003}</label>
		        <input type="text" name="user_name" id="inputuser_name" class="form-control" placeholder="{L_003}">
		        <label for="inputpass_word" class="sr-only">{L_004}</label>
		        <input type="password" name="pass_word" id="inputpass_word" class="form-control" placeholder="{L_004}">
		        <p><b>{L_3500_1015461}</b></p>
		        <div class="well well-sm">
		        	<input type="checkbox" name="noUser" value="y">{L_3500_1015831} 
		        </div>
		        <input type="hidden" name="action" value="insert">
		        <input type="submit" class="btn btn-lg btn-primary btn-block" value="{L_5204}">
			<!-- ELSE -->
				<!-- IF B_MULT_LANGS -->
				<div class="well well-sm">
				<h4>{L_2__0001}</h4>
	            <p>{FLAGS}</p>
	            </div>
				<!-- ENDIF -->
				<input type="hidden" name="action" value="login">
		        <input type="submit" class="btn btn-lg btn-primary btn-block" value="{L_052}">
	        <!-- ENDIF -->
      	</form>
	</div>
</body>
