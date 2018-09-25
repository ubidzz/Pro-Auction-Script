<!-- INCLUDE user_menu_header.tpl -->

<script type="text/javascript">

$(document).ready(function(){

	$('.hiddenbar').hide();

});

function passwordStrength(password) {

	var desc = [{'width':'0px'}, {'width':'10%'}, {'width':'20%'}, {'width':'30%'}, {'width':'40%'}, {'width':'50%'}, {'width':'60%'}, {'width':'70%'}, {'width':'80%'}, {'width':'90%'}, {'width':'95%'}, {'width':'100%'}];

	var descClass = ['', 'progress-bar-danger', 'progress-bar-danger', 'progress-bar-danger', 'progress-bar-warning', 'progress-bar-warning', 'progress-bar-warning', 'progress-bar-success', 'progress-bar-success', 'progress-bar-success', 'progress-bar-success', 'progress-bar-success'];

	var scoreMessages = ['<b>{L_3500_1015862}</b>', '<b>{L_3500_1015862}</b>', '<b>{L_3500_1015862}</b>', '<b>{L_3500_1015862}</b>', '<b>{L_3500_1015863}</b>', '<b>{L_3500_1015863}</b>', '<b>{L_3500_1015863}</b>', '<b>{L_3500_1015864}</b>', '<b>{L_3500_1015864}</b>', '<b>{L_3500_1015865}</b>', '<b>{L_3500_1015865}</b>', '<b>{L_3500_1015865}</b>'];

	var score = 0;

	var text = '<b>{L_3500_1015862}</b>';

	var limited = "{ALLOWEDSIZE}";

	//if password bigger than 0 give 1 point up to 10 points

	if (password.length > 0) score++;

	if (password.length > 1) score++;

	if (password.length > 2) score++;

	if (password.length > 3) score++;

	if (password.length > 4) score++;

	if (password.length > 5) score++;

	if (password.length > 6) score++;

	if (password.length > 7) score++;

	if (password.length > 8 ) score++;

	if (password.length > 9) score++;

	if (password.length > 10) score++;

	

	if(password.length > 0)

	{

		$('.hiddenbar').show();

	}else{

		$('.hiddenbar').hide();

	}

	if(score < limited) {

		document.getElementById("errorMessage").innerHTML = '{PASSWORD_SIZE}';

	}

	else{

		document.getElementById("errorMessage").innerHTML = '';

	}

	document.getElementById("message").innerHTML = scoreMessages[score];

	$("#passwordStrength").removeClass(descClass[score-1]).addClass(descClass[score]).css(desc[score]);

}			

</script>

<div class="col-sm-9">

  	<form class="form-horizontal" name="details" action="" method="post" enctype="multipart/form-data">

	  	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">

		<input type="hidden" name="FB_ids" value="{FBOOK_ID}">

		<input type="hidden" name="action" value="update">

	

	  	<div class="well">

			<!-- IF AVATAR ne '' -->

			<img class="img-responsive col-sm-2 col-xs-4" src="{AVATAR}" style="float:left">

			<!-- ELSE -->

			<img class="img-responsive col-sm-2 col-xs-4" src="{SITEURL}/uploaded/avatar/default.png" style="float:left">

			<!-- ENDIF -->

			<legend class="col-sm-10 col-xs-8">{L_200} {NAME} <small>( {NICK} )</small></legend>

			<ul class="nav nav-pills">

				<li class="active"><a href="#UserDetails" data-toggle="tab"><span class="glyphicon glyphicon-user"></span> {L_3500_1015869}</a></li>

				<li><a href="#UserPayment" data-toggle="tab" ><span class="glyphicon glyphicon-usd"></span> {L_719}</a></li>

				<li><a href="#changePnE" data-toggle="tab" ><span class="glyphicon glyphicon-lock"></span> {L_3500_1015868}</a></li>

				<li><a href="#Options" data-toggle="tab" ><span class="glyphicon glyphicon-cog"></span> {L_3500_1015825}</a></li>

			</ul>

		</div>

	  	<div class="tab-content">

	  		<div class="tab-pane tab-pane fade in active" id="UserDetails">

	  			<div class="panel panel-info">

					<div class="panel-heading">{L_3500_1015869}</div>

					<div class="panel-body">

						<div class="col-sm-12">

						    <div class="col-sm-6">

						    	<div class="form-group">

						  			<label for="inputNewEmail" class="col-sm-3 control-label">{L_006}</label>

						  			<div class="col-sm-8">

						  				<input type="text" class="form-control" name="TPL_email" id="inputNewEmail" value="{EMAIL}">

						  			</div>

						  		</div>

						    	<div class="form-group">

						        	<label for="InputAddress" class="col-sm-3 control-label">{L_009}</label>

						        	<div class="col-sm-8">

						        		<input type="text" class="form-control" id="InputAddress" name="TPL_address" value="{ADDRESS}">

						        	</div>

						        </div>

						        <div class="form-group">

						        	<label for="InputCity" class="col-sm-3 control-label">{L_010}</label>

						        	<div class="col-sm-8">

						        		<input type="text" class="form-control" id="InputCity" name="TPL_city" value="{CITY}">

						        	</div>

						        </div>

						        <div class="form-group">

						        	<label for="InputProv" class="col-sm-3 control-label">{L_011}</label>

						        	<div class="col-sm-8">

						        		<input type="text" class="form-control" id="InputProv" name="TPL_prov" value="{PROV}">

						        	</div>

						        </div>

						        <div class="form-group">

						        	<label class="col-sm-3 control-label">{L_252}</label>

						        	<div class="col-sm-8">

							        	<div class="input-group-addon">

							      			{DATEFORMAT}

							      			<span class="input-group-btn">

							      				<input type="text" name="TPL_year" size="4" maxlength="4" value="{YEAR}" class="form-control">

							      			</span>

						  				</div>

						        	</div>

						      	</div>

						    </div>

						   	<div class="col-sm-6">

						      	<div class="form-group">

						        	<label for="InputCountry" class="col-sm-3 control-label">{L_014}</label>

						        	<div class="col-sm-8">

						        		<select class="form-control" id="InputCountry" name="TPL_country">{COUNTRYLIST}</select>

						        	</div>

						        </div>

						        <div class="form-group">

						        	<label for="InputZip" class="col-sm-3 control-label">{L_012}</label>

						        	<div class="col-sm-8">

						        		<input type="text" class="form-control" id="InputZip" name="TPL_zip" size=15 value="{ZIP}">

						        	</div>

						        </div>

						        <div class="form-group">

						        	<label for="InputPhone" class="col-sm-3 control-label">{L_013}</label>

						        	<div class="col-sm-8">

						        		<input type="text" class="form-control" id="InputPhone" name="TPL_phone" size=15 value="{PHONE}">

						        	</div>

						        </div>

						        <div class="form-group">

						        	<label for="InputPhone" class="col-sm-3 control-label">{L_346}</label>

						        	<div class="col-sm-8">

						        		{TIMEZONE}

						        	</div>

						        </div>

						   	</div>

						</div>

					</div>

					<div class="panel-footer">

						<button  type="submit" name="Input" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> {L_530}</button>

					</div>

				</div>

			</div>

		  	<div class="tab-pane tab-pane fade in" id="UserPayment"> 

		  		<div class="panel panel-info">

					<div class="panel-heading">{L_3500_1015869}</div>

					<div class="panel-body">
						<ul class="nav nav-pills">
							<!-- IF B_PAYPAL -->
							<li class="active"><a href="#PAYPAL" data-toggle="tab"><i class="fa fa-paypal" aria-hidden="true"></i> {L_350_10119}</a></li>
							<!-- ENDIF -->
							<!-- IF B_AUTHNET -->
							<li><a href="#AUTHNET" data-toggle="tab"><i class="fa fa-credit-card" aria-hidden="true"></i> {L_350_10122}</a></li>
							<!-- ENDIF -->
							<!-- IF B_WORLDPAY -->
							<li><a href="#WORLDPAY" data-toggle="tab"><i class="fa fa-credit-card" aria-hidden="true"></i> {L_350_10123}</a></li>
							<!-- ENDIF -->
							<!-- IF B_TOOCHECKOUT -->
							<li><a href="#TOOCHECKOUT" data-toggle="tab"><i class="fa fa-credit-card" aria-hidden="true"></i> {L_350_10124}</a></li>
							<!-- ENDIF -->
							<!-- IF B_MONEYBOOKERS -->
							<li><a href="#MONEYBOOKERS" data-toggle="tab"><i class="fa fa-credit-card" aria-hidden="true"></i> {L_350_10125}</a></li>
							<!-- ENDIF -->
							<!-- IF B_BANK_TRANSFER -->
							<li><a href="#BANK_TRANSFER" data-toggle="tab"><i class="fa fa-university" aria-hidden="true"></i> {L_30_0219}</a></li>
							<!-- ENDIF -->

						</ul>
						
						<div class="tab-content">	
	
							<!-- IF B_PAYPAL -->
							<div class="tab-pane tab-pane fade in active" id="PAYPAL">
	
								<div class="form-group">
		
									<label for="InputPP" class="col-sm-3 control-label">{L_720}</label>
		
									<div class="col-sm-9">
		
										<input type="text" class="form-control" id="InputPP" name="TPL_pp_email" value="{PP_EMAIL}">
		
									</div>
		
								</div>
							</div>
	
							<!-- ENDIF -->
	
							<!-- IF B_AUTHNET -->
								    
							<div class="tab-pane tab-pane fade in" id="AUTHNET">
	
								<div class="form-group">
		
									<label for="InputANID" class="col-sm-3 control-label">{L_773}</label>
		
									<div class="col-sm-9">
		
										<input type="text" class="form-control" id="InputANID" name="TPL_authnet_id" value="{AN_ID}">
		
									</div>
		
								</div>
	
								<div class="form-group">
	
									<label for="InputANPass" class="col-sm-3 control-label">{L_774}</label>
	
									<div class="col-sm-9">
	
										<input type="text" class="form-control" id="InputANPass" name="TPL_authnet_pass" value="{AN_PASS}">
	
									</div>
								</div>
	
							</div>
	
							<!-- ENDIF -->
	
							<!-- IF B_WORLDPAY -->
							<div class="tab-pane tab-pane fade in" id="WORLDPAY">
	
								<div class="form-group">
		
									<label for="InputWPID" class="col-sm-3 control-label">{L_824}</label>
		
									<div class="col-sm-9">
		
										<input type="text" class="form-control" id="InputWPID" name="TPL_worldpay_id" value="{WP_ID}">
		
									</div>
		
								</div>
							</div>
	
							<!-- ENDIF -->
	
							<!-- IF B_TOOCHECKOUT -->
							<div class="tab-pane tab-pane fade in" id="TOOCHECKOUT">
	
								<div class="form-group">
		
									<label for="InputTCID" class="col-sm-3 control-label">{L_826}</label>
		
									<div class="col-sm-9">
		
										<input type="text" class="form-control" id="InputTCID" name="TPL_toocheckout_id" value="{TC_ID}">
		
									</div>
		
								</div>
							</div>
	
							<!-- ENDIF -->
		
							<!-- IF B_MONEYBOOKERS -->
							<div class="tab-pane tab-pane fade in" id="MONEYBOOKERS">
	
								<div class="form-group">
	
									<label for="InputMBEmail" class="col-sm-3 control-label">{L_825}</label>
	
									<div class="col-sm-9">
	
										<input type="text" class="form-control" id="InputMBEmail" name="TPL_skrill_email" value="{MB_EMAIL}">
	
									</div>
	
								</div>
							</div>
	
							<!-- ENDIF -->
	
							<!-- IF B_BANK_TRANSFER -->
							<div class="tab-pane tab-pane fade in" id="BANK_TRANSFER">
	
								<div class="form-group">
		
									<label for="InputBankInfo" class="col-sm-3 control-label">{L_30_0216}</label>
		
									<div class="col-sm-9">
		
										<textarea name="TPL_bank_name" class="form-control" id="InputBankInfo">{BANK}</textarea>
		
									</div>
		
								</div>
	
								<div class="form-group">
		
									<label for="InputBankAccount" class="col-sm-3 control-label">{L_30_0217}</label>
		
									<div class="col-sm-9">
		
										<input type="text" class="form-control" id="InputBankAccount" name="TPL_bank_account" value="{BANK_ACCOUNT}">
		
									</div>
		
								</div>
		
								<div class="form-group">
		
									<label for="InputBankRouter" class="col-sm-3 control-label">{L_30_0218}</label>
		
									<div class="col-sm-9">
		
										<input type="text" class="form-control" id="InputBankRouter" name="TPL_bank_routing" value="{BANK_ROUTING}">
		
									</div>
		
								</div>
							</div>
							<!-- ENDIF -->
						</div>
					</div>


				<div class="panel-footer">

					<button  type="submit" name="Input" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> {L_530}</button>

					</div>

				</div>

			</div>

			<!-- IF B_SMS -->

			<div class="tab-pane tab-pane fade in" id="smsalerts">

	  			<div class="panel panel-info">

					<div class="panel-heading">{L_3500_1015876}</div>

				 	<div class="panel-body">

				 		<ul class="nav nav-tabs">

							<li class="active"><a href="#carrier" data-toggle="tab"><span class="glyphicon glyphicon-globe"></span> {L_3500_1015937_a}</a></li>

							<!-- IF B_SMSACTIVATED ne true -->

							<li><a href="#settings" data-toggle="tab" ><span class="glyphicon glyphicon-tasks"></span> {L_3500_1015937_b}</a></li>

							<!-- ENDIF -->

						</ul>

						<div class="tab-content">

	  						<div class="tab-pane tab-pane fade in active" id="carrier">

					  			<div class="alert alert-info" role="alert">

					  				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

					  				<strong>{L_3500_1015891}</strong>

					  				<p>{L_3500_1015885}</p>

					  			</div>

						  		<!-- IF B_SMSACTIVATED ne false -->

					  			<div class="alert alert-danger" role="alert">

					  				<strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {L_3500_1015887}</strong>

					  				<p>{L_3500_1015890}</p>

					  			</div>

					  			<div class="form-inline">

					  				<div class="col-sm-5">

							  			<div class="form-group">

											<div class="input-group">

												<div class="input-group-addon">{L_3500_1015925}</div>

												<input type="text" maxlength="7" class="form-control" name="TPL_activate" value="">

											</div>

										</div>

									</div>

									<!-- IF RESENDCODE -->

									<div class="col-sm-5">

										<div class="form-group">

											<div class="input-group-addon">{L_3500_1015937}</div>

											<span class="input-group-addon">

												<input type="radio" name="resendCode" value="y"> {L_030} 

												<input type="radio" name="resendCode" value="n" checked="checked"> {L_029}  

											</span>

										</div>

									</div>

									<!-- ENDIF -->

								</div>

								<div class="col-sm-12">

									<div class="form-group">

										<div class="input-group">

											<div class="input-group-addon">{L_3500_1015882}</div>

											{CELLPHONECARRIERS}

										</div>

										<div class="input-group">

											<div class="input-group-addon">{L_3500_1015881}</div>

											<input class="form-control" maxlength="15" type="text" name="TPL_cellPhone" value="{SMSPHONENUMBER}" placeholder="4658235740"> 

										</div>

									</div>

								</div>

								<!-- ELSE -->

								<div class="col-sm-12">

									<div class="form-group">

										<div class="input-group">

											<div class="input-group-addon">{L_3500_1015882}</div>

											{CELLPHONECARRIERS}

										</div>

										<div class="input-group">

											<div class="input-group-addon">{L_3500_1015881}</div>

											<input class="form-control" maxlength="15" type="text" name="TPL_cellPhone" value="{SMSPHONENUMBER}" placeholder="4658235740"> 

										</div>

									</div>

								</div>

								<!-- ENDIF -->

							</div>

							<!-- IF B_SMSACTIVATED ne true -->

							<div class="tab-pane tab-pane fade in" id="settings">

								<div class="col-sm-3">

									<div class="form-group {WONITEMALERT}">

										<label>{L_3500_1015888}</label>

										<label class="radio-inline">

											<input type="radio" name="TPL_smsItemWonAlert" value="y" {WONITEMALERT1}> {L_030} 

										</label>

										<label class="radio-inline">

											<input type="radio" name="TPL_smsItemWonAlert" value="n" {WONITEMALERT2}> {L_029}  

										</label>

									</div>

								</div>

								<div class="col-sm-3 form-inline">

									<div class="form-group {BIDALERT}">

										<label>{L_3500_1015878}</label>

										<label class="radio-inline">

											<input type="radio" name="TPL_smsBidAlert" value="y" {BIDALERT1}> {L_030} 

										</label>

										<label class="radio-inline">

											<input type="radio" name="TPL_smsBidAlert" value="n" {BIDALERT2}> {L_029}  

										</label>

									</div>

								</div>

								<div class="col-sm-3 form-inline">

									<div class="form-group {MESSAGEALERT}">

										<label>{L_3500_1015879}</label>

										<label class="radio-inline">

											<input type="radio" name="TPL_smsMessagesAlert" value="y" {MESSAGEALERT1}> {L_030} 

										</label>

										<label class="radio-inline">

											<input type="radio" name="TPL_smsMessagesAlert" value="n" {MESSAGEALERT2}> {L_029}  

										</label>

									</div>

								</div>

								<div class="col-sm-3 form-inline">

									<div class="form-group {ITEMSOLDALERT}">

										<label>{L_3500_1015880}</label>

										<label class="radio-inline">

											<input type="radio" name="TPL_smsItemSoldAlert" value="y" {ITEMSOLDALERT1}> {L_030} 

										</label>

										<label class="radio-inline">

											<input type="radio" name="TPL_smsItemSoldAlert" value="n" {ITEMSOLDALERT2}> {L_029}  

										</label>

									</div>

								</div>

								<div class="col-sm-3">

									<div class="form-group {LOGINALERT}">

										<label>{L_3500_1015877}</label>

										<label class="radio-inline">

											<input type="radio" name="TPL_smsLoginAlert" value="y" {LOGINALERT1}> {L_030} 

										</label>

										<label class="radio-inline">

											<input type="radio" name="TPL_smsLoginAlert" value="n" {LOGINALERT2}> {L_029} 

										</label> 

									</div>

								</div>

								<div class="col-sm-3">

									<div class="form-group {CODESTRENGTH}">

										<label>{L_3500_1016018}</label>

										<label class="radio-inline">

											<input type="radio" name="TPL_smsStrength" value="y" {CODESTRENGTH1}> {L_3500_1015864} 

										</label>

										<label class="radio-inline">

											<input type="radio" name="TPL_smsStrength" value="n" {CODESTRENGTH2}> {L_3500_1015862} 

										</label> 

									</div>

								</div>

							</div>

							<!-- ENDIF -->

						</div>

					</div>

					<div class="panel-footer">

						<button  type="submit" name="Input" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> {L_530}</button>

					</div>

				</div>

			</div>

			<!-- ENDIF -->

			<div class="tab-pane tab-pane fade in" id="changePnE"> 

	  			<div class="panel panel-info">

					<div class="panel-heading">{L_3500_1015868}</div>

				  	<div class="panel-body">

				  		<div class="alert alert-info" role="alert">{L_617}</div>

				  		<div class="form-group">

				  			<label for="passwordname" class="col-sm-4 control-label">{L_004}</label>

							<div class="col-sm-7">

					  			<input type="password" class="form-control first" name="TPL_password" id="passwordname" placeholder="{L_050}">

					 		</div>

					  	</div>

					 	<div class="form-group">

					  		<label for="inputRepeatPassword" class="col-sm-4 control-label">{L_005}</label>

					  		<div class="col-sm-7">

					  			<input type="password" class="form-control" name="TPL_repeat_password" id="inputRepeatPassword">

							</div>

				  		</div>

				  		<div class="hiddenbar" id="message"></div>

		    			<div class="hiddenbar" id="errorMessage"></div>

		    			<div class="hiddenbar">

			    			<div class="progress progress-striped active">

			          			<div id="passwordStrength" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>

			        		</div>

		        		</div>

				  		<script type="text/javascript">

						    jQuery(document).ready(function(){

						    	jQuery("#passwordname").keyup(function() {

						    	  passwordStrength(jQuery(this).val());

						    	});

						    });

						</script>



				  	</div>

					<div class="panel-footer">

						<button  type="submit" name="Input" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> {L_530}</button>

					</div>

				</div>

			</div>

			<!-- IF B_FBOOK_LOGIN -->

			<div class="tab-pane tab-pane fade in" id="fblogin"> 

	  			<div class="panel panel-info">

					<div class="panel-heading">{L_350_10196}</div>

				  	<div class="panel-body">

				  		<span class="help-block alert alert-info">{L_350_10192}</span><br>

		  				{FBOOK_EMAIL}

				  	</div>

				</div>

			</div>

			<!-- ENDIF -->

			<div class="tab-pane tab-pane fade in" id="Options">

				<div class="panel panel-info">

					<div class="panel-heading">{L_3500_1015825}</div>

					<div class="panel-body">

						<div class="col-sm-12">

							<!-- IF B_NEWLETTER -->

							<div class="col-sm-6">

								<div class="panel panel-primary">

									<div class="panel-heading">{L_603}</div>

									<div class="panel-body">

										{L_609}<br>

										<div class="radio-inline">

											<label><input type="radio" name="TPL_nletter" value="1" {NLETTER1}>{L_030}</label>

										</div>

										<div class="radio-inline">

											<label><input type="radio" name="TPL_nletter" value="2" {NLETTER2}>{L_029}</label>

										</div>

									</div>

								</div>

							</div>

							<!-- ENDIF -->

							<div class="col-sm-6">

								<div class="panel panel-primary">

							   		<div class="panel-heading">{L_350_10115}</div>

							    	<div class="panel-body">

								      	{IS_ONLINE}<br>

								      	<div class="radio-inline">

								      		<label><input type="radio" name="TPL_HideStatus" value="y" {HIDEONLINE1}> {L_3500_1015583}</label>

								      	</div>

								      	<div class="radio-inline">

											<label><input type="radio" name="TPL_HideStatus" value="n" {HIDEONLINE2}> {L_3500_1015584}</label>

										</div>

							    	</div>

								</div>

							</div>

							<div class="col-sm-6">

								<div class="panel panel-primary">

									<div class="panel-heading">{L_352}</div>

									<div class="panel-body">

										<div class="radio-inline">

											<label><input type="radio" name="TPL_emailtype" value="html" {EMAILTYPE1} />{L_902}</label>

										</div>

										<div class="radio-inline">

											<label><input type="radio" name="TPL_emailtype" value="text" {EMAILTYPE2} />{L_915}</label>

										</div>

									</div>

								</div>

							</div>

							<div class="col-sm-6">

								<div class="panel panel-primary">

									<div class="panel-heading">{L_350_10025}</div>

									<div class="panel-body">

										 <input type="hidden" name="MAX_FILE_SIZE" value="{MAXUPLOADSIZE}">

										 <div class="form-inline">

										 	<div class="form-group">

										 		<input type="file" class="btn btn-info btn-sm col-xs-10" name="avatar" accept="image/*">

										 	</div>

										 	<div class="form-group">

										 		<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-upload"></span> {L_3500_1015496}</button>

											</div>

										</div>

									</div>

								</div>

							</div>

						</div>

					</div>

					<div class="panel-footer">

						<button  type="submit" name="Input" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> {L_530}</button>

					</div>

				</div>

			</div>

		</div>

  	</form>

</div>

