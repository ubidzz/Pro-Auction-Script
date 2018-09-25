<!-- IF B_SSL -->

<div class="alert alert-success"><img src="{SITEURL}images/ssl.png">{L_3500_1015493}</div>

<!-- ENDIF -->

<!-- IF ERROR ne '' -->

<div class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {ERROR}</div>

<!-- ENDIF -->

<!-- IF B_FIRST -->

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

	

	if(password.length > 0) {

		$('.hiddenbar').fadeIn('slow');

	}

	if(password.length == 0) {

		$('.hiddenbar').fadeOut('slow');

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

<form class="form-horizontal" name="registration" action="{SITEURL}new_account" method="post">

	<div class="col-xs col-sm-6">

		<!-- IF B_FBOOK_LOGIN -->

		<legend>{L_350_10204_a}</legend>

		<!-- IF FBOOK_EMAIL -->

		<div class="form-group">

			<label class="col-sm-4 control-label"><img src="images/longin1.png"></label>

		    <div class="col-sm-6">{L_350_10186}</div>

		</div>

		<input type="hidden" name="fbid" value="{FBID}">

		<input type="hidden" name="image" value="{FBIMAGE}">

		<!-- ELSE -->

		<div class="form-group">

			<label class="col-sm-4 control-label"><img src="images/redlogin1.png"></label>

		    <div class="col-sm-6">{L_350_10187}			    	

		    	<a id="popoverData" class="btn btn-sm btn-primary" href="#" data-content="{L_350_10202}" onclick="{B_FB_LINK}();" rel="popover" data-placement="bottom" data-original-title="Connect with Facebook" data-trigger="hover">{L_350_10204_b}</a>

		    </div>

		</div>

		<!-- ENDIF -->

		<!-- ENDIF -->

		<legend>{L_001}</legend>

		<div class="form-group">

			<label class="col-sm-4 control-label" for="InputName">{L_002} *</label>

			<div class="col-sm-6">

    			<input type="text" name="TPL_name" class="form-control" id="InputName" placeholder="{L_3500_1015532}" value="{V_YNAME}">

    		</div>

		</div>

		<div class="form-group">

			<label class="col-sm-4 control-label" for="InputUserame">{L_003} *</label>

			<div class="col-sm-6">

    			<input type="text" name="TPL_nick" class="form-control" id="InputUserame" placeholder="{USERNAME_SIZE}" value="{V_UNAME}">

    		</div>

		</div>

		<div class="form-group">

			<label class="col-sm-4 control-label" for="passwordname">{L_004} *</label>

			<div class="col-sm-6">

    			<input type="password" name="TPL_password" class="form-control first" id="passwordname" placeholder="{PASSWORD_SIZE}" value="">

    			<div class="hiddenbar">

	       			<div id="message"></div>

	    			<div id="errorMessage"></div>

	    			<div class="progress progress-striped active">

	          			<div id="passwordStrength" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>

	        		</div>

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

		<div class="form-group">

			<label class="col-sm-4 control-label" for="InputRepeatPassword">{L_005} *</label>

			<div class="col-sm-6">

    			<input type="password" name="TPL_repeat_password" class="form-control" id="InputRepeatPassword" value="">

    		</div>

		</div>

		<div class="form-group">

			<label class="col-sm-4 control-label" for="InputEmail">{L_006} *</label>

			<div class="col-sm-6">

				<div class="input-group">

					<span class="input-group-addon">@</span>

    				<input type="text" name="TPL_email" class="form-control" id="InputEmail" placeholder="{L_3500_1015640}" value="{V_EMAIL}">

    			</div>

    		</div>

		</div>

		<!-- IF BIRTHDATE -->

		<div class="form-group">

		  	<label class="col-sm-4 control-label">{L_252} {REQUIRED(0)}</label>

		  	<div class="col-sm-6">

			  	<div class="input-group-addon">

			      	{L_DATEFORMAT}

			      	<span class="input-group-btn">

			      		<input type="text" name="TPL_year" size="4" maxlength="4" value="{V_YEAR}" class="form-control">

			      	</span>

		  		</div>

		  	</div>

		</div>

		<!-- ENDIF -->

		<!-- IF ADDRESS -->

		<div class="form-group">

			<label class="col-sm-4 control-label" for="InputAddress">{L_009} {REQUIRED(1)}</label>

			<div class="col-sm-6">

    			<input type="text" name="TPL_address" class="form-control" id="InputAddress" value="{V_ADDRE}">

    		</div>

		</div>

		<!-- ENDIF -->

		<!-- IF CITY -->

		<div class="form-group">

			<label class="col-sm-4 control-label" for="InputCity">{L_010} {REQUIRED(2)}</label>

			<div class="col-sm-6">

    			<input type="text" name="TPL_city" class="form-control" id="InputCity" value="{V_CITY}">

    		</div>

		</div>

		<!-- ENDIF -->

		<!-- IF PROV -->

		<div class="form-group">

			<label class="col-sm-4 control-label" for="InputProv">{L_011} {REQUIRED(3)}</label>

			<div class="col-sm-6">

    			<input type="text" name="TPL_prov" class="form-control" id="InputProv" value="{V_PROV}">

    		</div>

		</div>

		<!-- ENDIF -->

		<!-- IF COUNTRY -->

		<div class="form-group">

			<label class="col-sm-4 control-label" for="InputCountry">{L_014} {REQUIRED(4)}</label>

			<div class="col-sm-6">

				<select name="TPL_country" class="form-control" id="InputCountry">

    			<option value="">{L_251}</option>

						{L_COUNTRIES}

	      		</select>

    		</div>

		</div>

		<!-- ENDIF -->

		<!-- IF ZIP -->

		<div class="form-group">

			<label class="col-sm-4 control-label" for="InputZip">{L_012} {REQUIRED(5)}</label>

			<div class="col-sm-6">

    			<input type="text" name="TPL_zip" class="form-control" id="InputZip" value="{V_POSTCODE}">

    		</div>

		</div>

		<!-- ENDIF -->

		<!-- IF TEL -->

		<div class="form-group">

			<label class="col-sm-4 control-label" for="InputPhone">{L_013} {REQUIRED(6)}</label>

			<div class="col-sm-6">

    			<input type="text" name="TPL_phone" class="form-control" id="InputPhone" value="{V_PHONE}">

    		</div>

		</div>

		<!-- ENDIF -->

		<div class="form-group">

			<label class="col-sm-4 control-label">{L_346}</label>

			<div class="col-sm-6">

    			{TIMEZONE}

    		</div>

		</div>

		<!-- IF B_NLETTER -->

		<div class="form-group">

			<label class="col-sm-4 control-label">{L_608}</label>

			<div class="col-sm-6">

				<div class="radio">

					<label><input type="radio" name="TPL_nletter" id="switch-labelText" value="1" {V_YNEWSL}>{L_030}</label>

				</div>

				<div class="radio">

					<label><input type="radio" name="TPL_nletter" value="2" {V_NNEWSL}>{L_029}</label>

				</div>

			</div>

		</div>

		<!-- ENDIF -->

	</div>

	<div class="col-xs col-sm-6">

		<legend>{L_719}</legend>

		<!-- IF B_PAYPAL -->

		<div class="form-group">

			<label class="col-sm-4 control-label" for="InputPP">{L_720}{REQUIRED(7)}</label>

			<div class="col-sm-6">

    			<input type="text" name="TPL_pp_email" class="form-control" id="InputPP" value="{PP_EMAIL}">

    		</div>

		</div>

		<!-- ENDIF -->

		<!-- IF B_AUTHNET -->

		<div class="form-group">

			<label class="col-sm-4 control-label" for="InputANID">{L_773}{REQUIRED(8)}</label>

			<div class="col-sm-6">

    			<input type="text" name="TPL_authnet_id" class="form-control" id="InputANID" value="{AN_ID}">

    		</div>

		</div>

		<div class="form-group">

			<label class="col-sm-4 control-label" for="InputANPass">{L_774}{REQUIRED(8)}</label>

			<div class="col-sm-6">

    			<input type="text" name="TPL_authnet_pass" class="form-control" id="InputANPass" value="{AN_PASS}">

    		</div>

		</div>

		<!-- ENDIF -->

		<!-- IF B_WORLDPAY -->

		<div class="form-group">

			<label class="col-sm-4 control-label" for="InputWPID">{L_824}{REQUIRED(9)}</label>

			<div class="col-sm-6">

    			<input type="text" name="TPL_worldpay_id" class="form-control" id="InputWPID" value="{WP_ID}">

    		</div>

		</div>

		<!-- ENDIF -->

		<!-- IF B_TOOCHECKOUT -->

		<div class="form-group">

			<label class="col-sm-4 control-label" for="InputTCID">{L_826}{REQUIRED(10)}</label>

			<div class="col-sm-6">

    			<input type="text" name="TPL_toocheckout_id" class="form-control" id="InputTCID" value="{TC_ID}">

    		</div>

		</div>

		<!-- ENDIF -->

		<!-- IF B_MONEYBOOKERS -->

		<div class="form-group">

			<label class="col-sm-4 control-label" for="InputMBEmail">{L_825}{REQUIRED(11)}</label>

			<div class="col-sm-6">

    			<input type="text" name="TPL_skrill_email" class="form-control" id="InputMBEmail" value="{MB_EMAIL}">

    		</div>

		</div>

		<!-- ENDIF -->

		<!-- IF B_BANK_TRANSFER -->

		<div class="form-group">

			<label class="col-sm-4 control-label" for="InputBankAddress">{L_30_0216}{REQUIRED(12)}</label>

			<div class="col-sm-6">

    			<textarea class="form-control" id="InputBankAddress" name="TPL_bank_name" value="{BANK}"></textarea>

    		</div>

		</div>

		<div class="form-group">

			<label class="col-sm-4 control-label" for="InputBankAccount">{L_30_0217}{REQUIRED(12)}</label>

			<div class="col-sm-6">

    			<input type="text" name="TPL_bank_account" class="form-control" id="InputBankAccount" value="{BANK_ACCOUNT}">

    		</div>

		</div>

		<div class="form-group">

			<label class="col-sm-4 control-label" for="InputBankRouting">{L_30_0218}{REQUIRED(12)}</label>

			<div class="col-sm-6">

    			<input type="text" name="TPL_bank_routing" class="form-control" id="InputBankRouting" value="{BANK_ROUTING}" data-content="{L_30_0218_a}" rel="popover" data-placement="bottom" data-original-title="{L_30_0218}" data-trigger="hover">

    		</div>

		</div>

		<!-- ENDIF -->

		<link href="{SITEURL}themes/{THEME}/plugins/bootstrap-switch/bootstrap-switch.css" rel="stylesheet">

		<script src="{SITEURL}themes/{THEME}/plugins/bootstrap-switch/bootstrap-switch.js"></script>

		<!-- IF B_GROUPS -->

		<div class="form-group">

			<label class="col-sm-4 control-label" >{L_448} *</label>

			<div class="col-sm-6">

				<!-- BEGIN groups -->

				<input type="checkbox" name="group[]" id="switch-labelText" value="{groups.ID}" data-label-text="{groups.GROUPNAME}">

				<!-- END groups -->

    		</div>

		</div>

		<!-- ENDIF -->

		<!-- IF B_SINGUP_FEE -->

		<div class="form-group">

			<label class="col-sm-4 control-label" for="InputBankAccount">{L_430}</label>

			<div class="col-sm-6">

    			{FEE}

    		</div>

		</div>

		<!-- ENDIF -->

		<!-- IF B_BONUS_FEE -->

		<div class="form-group">

			<label class="col-sm-4 control-label" for="InputBankAccount">{L_736}</label>

			<div class="col-sm-6">

    			{BONUS}

    		</div>

		</div>

		<!-- ENDIF -->

		<div class="form-group">

			<label class="col-sm-4 control-label">{L_858}</label>

			<div class="col-sm-6">

    			<input name="terms_check" id="switch-labelText" type="checkbox" data-label-text="{L_3500_1015866}">

    		</div>

		</div>

		<div class="form-group">

			<label class="col-sm-4 control-label">{L_858_a}</label>

			<div class="col-sm-6">

    			<input name="cookies_check" id="switch-labelText" type="checkbox" data-label-text="{L_3500_1015866}">

    		</div>

		</div>

		{CAPCHA}<br />

		<hr>

		<div align="center">

			<input type="hidden" name="action" value="first">

			<input type="submit" class="btn btn-success" value="{L_235}">

		</div>

	</div>

</form>

<script type="text/javascript">

	var options = {

		onText: "{L_030}",

		onColor: 'success',

		offColor: 'danger',

		offText: "{L_029}",

		animate: true

	};

	$("[name='group[]']").bootstrapSwitch(options);

	$("[name='terms_check']").bootstrapSwitch(options);

	$("[name='cookies_check']").bootstrapSwitch(options);

</script>

<!-- ELSE -->

<legend>{L_HEADER}</legend>

<p>{L_MESSAGE}</p>

<p>{L_860}</p>

<!-- ENDIF -->



