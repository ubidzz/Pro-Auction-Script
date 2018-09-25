<!-- IF ERROR ne '' -->

<div class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {ERROR}</div>

<!-- ENDIF -->

<div class="col-sm-6">

	<div class="well">

		<form name="user_login" action="{SITEURL}user_login.php" method="post">

			<div class="form-group">

    			<label for="usernameOrEmail">{L_187}</label>

    			<input type="text" class="form-control" name="username" id="usernameOrEmail" placeholder="{L_3500_1015861}" value="{USER}">

  			</div>

  			<div class="form-group">

    			<label for="userPassword">{L_004}</label>

    			<input type="password" class="form-control" name="password" id="userPassword" placeholder="{L_004}" value="">

  			</div>

  			<div class="checkbox">

	    		<label>

	      			<input type="checkbox" name="rememberme" value="1"> {L_25_0085}

	    		</label> 

	    		<label>

	      			<input type="checkbox" id="hide_online" name="hide_online" value="y"> {L_350_10114}

	    		</label>

  			</div>

  			<br />

  			<input type="hidden" name="action" value="login">

  			<button type="submit" class="btn btn-success">{L_052}</button>

  			<!-- IF B_FBOOK_LOGIN -->

    		<a class="btn btn-primary" rel="popover" id="facebook" href="#" data-content="{L_350_10193}" data-original-title="{L_350_10204_d}" data-trigger="hover" onclick="facebookLogin();">{L_350_10204_d}</a>

 			<!-- ENDIF -->

 			<a class="btn btn-danger" href="{SITEURL}forgotpasswd.php">{L_215}</a>

		</form>

	</div>

</div>

<div class="col-sm-6">

	<div class="well">

		{L_863}

		<!-- IF RESENDEMAIL -->

		{L_3500_1016003}

		<!-- ENDIF -->

	</div>

</div>

