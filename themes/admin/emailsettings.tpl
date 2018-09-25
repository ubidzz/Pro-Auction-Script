<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<div id="dialog-modal" class="modal modal-info fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">{L_3500_1015565}</h4>
			</div>
			<div class="modal-body">
				<div class="alert alert-warning" role="alert"><b>INFO!</b> {L_3500_1015688}</div>
				{L_3500_1015687}<br /><br />
				<b>{L_3500_1015551}</b> = {MAIL_PROTOCOL}<br>
				<b>{L_3500_1015560}</b> = {SMTP_AUTH}<br>
				<b>{L_3500_1015559}</b> = {SMTP_SEC}<br>
				<b>{L_3500_1015558}</b> = {SMTP_PORT}<br>
				<b>{L_3500_1015556}</b> = {SMTP_USER}<br>
				<b>{L_3500_1015557}</b> = {SMTP_PASS}<br>
				<b>{L_3500_1015554}</b> = {SMTP_HOST}<br>
				<b>{L_3500_1015561}</b> = {ALERT_EMAILS}<br><br />
				{L_3500_1015566}
				<textarea class="form-control" id="TestMessage"></textarea><br />
				<div class="form-style" id="ResponseForm">
					<div id="ContactResults"></div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-warning" onclick="$('form[name=conf]').submit();">{L_530}</button>
					<button class="SendTestEmail btn btn-success">{L_3500_1015567}</button>
        			<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      			</div>
      			<script type="text/javascript">
					$(document).ready(function() {
					$(document).on('click', '.SendTestEmail',  function(e) {
						e.preventDefault();
						if ($('#TestMessage').val() == '') alert('Empty messages cause errors!');
						        post_data = {
					                'user_name'     : '{L_110}', 
					                'user_email'    : '{ADMIN_EMAIL}', 
					                'subject'       : '{L_3500_1015569}', 
					                'message'       : $('#TestMessage').val(),
									'admincsrftoken'     : $('input[name=admincsrftoken]').val()
								};
					            //Ajax post data to server
					            $.post('{SITEURL}{ADMIN_FOLDER}/emailsettings.php?test_email', post_data, function(response){  
					                if(response.type == 'error'){ //load json data from server and output message     
					                    output = '<div class="panel panel-danger"><div class="panel-body">' + response.text + '</div></div>';
					                }else{
					                    output = '<div class="panel panel-success"><div class="panel-body">' + response.text + '</div></div>';
					                 }
					                $("#ResponseForm #ContactResults").hide().html(output).slideDown();
								 }, 'json');
					   });
					}); 
					$(document).ready(function() {
						if ($('select[name=mail_protocol] option:selected').val() == 2) {
							$('.smtp').parent().parent().show();
							$('.non_smtp').parent().parent().hide();
						} else {
							$('.smtp').parent().parent().hide();
							$('.non_smtp').parent().parent().show();
						}
						if ($('select[name=mail_protocol] option:selected').val() == 0) {
							$('.para').parent().parent().show();
						} else {
							$('.para').parent().parent().hide();
					    }
						
						$('select[name=mail_protocol]').on('change', function() {
						//alert('changid');
							if ($(this).val() == 2) {
								$('.smtp').parent().parent().show(300);
								$('.non_smtp').parent().parent().hide();
							} else {
								$('.smtp').parent().parent().hide();
								$('.non_smtp').parent().parent().show(300);
								}
							if ($(this).val() == 0) {
								$('.para').parent().parent().show(300);
							} else {
								$('.para').parent().parent().hide();
							}	
						});
					});
				</script>
			</div>
		</div>
	</div>
</div>
<div class="box box-info">
	<form name="changesettngs" action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="update">
		<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
		<div class="box-header">
	    	<h4 class="panel-title">{L_3500_1015550}</h4>
	   		<!-- tools box -->
	      	<div class="pull-right box-tools"> 
	      		<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#dialog-modal">{L_3500_1015568}</button>
	      		<input type="submit" name="act" class="btn btn-sm btn-success" value="{L_530}"> 
			</div>
		  	<div class="box-body table-responsive">
				<table class="table table-hover table-striped">
					<tbody>
						<!-- BEGIN block -->
						<tr>
			  				<!-- IF block.B_HEADER -->
							<td colspan="2"><b>{block.TITLE}</b></td>
			  				<!-- ELSE -->
							<td>{block.TITLE}</td>
							<td>{block.DESCRIPTION}
								<!-- IF block.TYPE eq 'yesno' -->
								<input type="radio" name="{block.NAME}" value="y"<!-- IF block.DEFAULT eq 'y' --> checked<!-- ENDIF -->> {block.TAGLINE1}
								<input type="radio" name="{block.NAME}" value="n"<!-- IF block.DEFAULT eq 'n' --> checked<!-- ENDIF -->> {block.TAGLINE2}
								<!-- ELSEIF block.TYPE eq 'text' -->
								<input class="form-control" type="text" name="{block.NAME}" value="{block.DEFAULT}">
								<!-- ELSEIF block.TYPE eq 'password' -->
								<input class="form-control" type="password" name="{block.NAME}" value="{block.DEFAULT}">
								<!-- ELSE -->
								{block.TYPE}
								<!-- ENDIF -->
							</td>
			 				<!-- ENDIF -->
						</tr>
						<!-- END block -->
					</tbody>
				</table>
			</div>
		</div>
	</form>
</div>
