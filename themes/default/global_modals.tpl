<div id="loginModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
		     	<button type="button" class="close" data-dismiss="modal">&times;</button>
		       	<ul class="nav nav-tabs">
		         	<li class="active"><a href="#login" data-toggle="tab"><span class="glyphicon glyphicon-user"></span> {L_052}</a></li>
		         	<li><a href="#register" data-toggle="tab" ><span class="glyphicon glyphicon-pencil"></span> {L_235}</a></li>
		      	</ul>
			</div>
			<div class="modal-body">
				<div class="tab-content">
		     		<div class="tab-pane tab-pane fade in active" id="login">
						<form class="form-horizontal" name="login" action="{SITEURL}user_login.php" method="post">
				    		<input type="hidden" name="action" value="login">
				      		<div class="form-group">
								<label class="col-sm-2 control-label">{L_221}:</label>
								<div class="col-sm-10">
									<input type="text" name="username" placeholder="{L_3500_1015861}" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">{L_004}:</label>
								<div class="col-sm-10">
									<input type="password" name="password" placeholder="{L_004}" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<div class="checkbox-inline">
										<label><input type="checkbox" name="rememberme" id="rememberme" value="1"> {L_25_0085}</label>
									</div>
									<div class="checkbox-inline">
										<label><input type="checkbox" id="hide_online" name="hide_online" value="y"> {L_350_10114}</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<label><button type="submit" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-ok"></span> {L_052}</button></label>
									<!-- IF B_FBOOK_LOGIN -->
									<label><a class="btn btn-sm btn-info navbar-btn" onclick="facebookLogin();" id="popoverData" href="#" data-content="{L_350_10193}" rel="popover" data-placement="bottom" data-original-title="{L_350_10204_d}" data-trigger="hover"><span class="glyphicon glyphicon-ok"></span> {L_350_10204_d}</a></label>
									<!-- ENDIF -->
									<label><a class="btn btn-sm btn-danger navbar-btn" href="{SITEURL}forgotpasswd.php"><span class="glyphicon glyphicon-remove"></span> {L_215}</a></label>
								</div>
							</div>
					 	</form>
					</div>
					<div class="tab-pane tab-pane fade in" id="register">
				        {L_863}
			          	<!-- IF RESENDEMAIL -->
			          	{L_3500_1016003}
			          	<!-- ENDIF -->
			        </div>
				</div>
			</div>
		</div>
	</div>
</div>
