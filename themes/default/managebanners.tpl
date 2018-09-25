<!-- INCLUDE user_menu_header.tpl -->
<div class="col-sm-9">
	<legend>{L_350_1012212}</legend>
	<!-- IF B_BANNERMANAGER -->
    <form name="newuser" action="" method="post" class="table-responsive">
     	<!-- IF B_SIGNUP_FEE -->
     	<div class="alert alert-info" role="alert">
     		<p>{L_350_10149}</p>
     		<p>{L_350_10127}: {SIGNUP_FEE}</p>
     	</div>
     	<!-- ENDIF -->
        <table class="table table-bordered table-striped">
        	<tr>
            	<td>{L_302}:</td>
             	<td class="has-feedback has-error">
                 	<input type="text" name="name" value="{NAME}" class="form-control">
                 	<span class="glyphicon glyphicon-asterisk form-control-feedback" aria-hidden="true"></span>
             	</td>
			</tr>
			<tr>
			 	<td>{L__0022}:</td>
				<td class="has-feedback has-error">
			      	<input type="text" name="company" value="{COMPANY}" class="form-control">
			      	<span class="glyphicon glyphicon-asterisk form-control-feedback" aria-hidden="true"></span>
			  	</td>
			</tr>
			<tr>
			   	<td>{L_107}:</td>
			 	<td class="has-feedback has-error">
			      	<input type="text" name="email" value="{EMAIL}" class="form-control">
			     	<span class="glyphicon glyphicon-asterisk form-control-feedback" aria-hidden="true"></span>
			  	</td>
			 </tr>
		</table>
		<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
		<input type="hidden" name="action" value="insert">
		<input type="submit" name="act" class="btn btn-success" value="{L_350_101244}">
	</form><br>
	<!-- ENDIF -->
	<legend>{L_3500_1015906}</legend>
    <form name="deleteusers" action="" method="post" class="table-responsive">
     	<table class="table table-bordered table-striped" width="98%" cellpadding="0" cellspacing="0">
        	<tr>
             	<th>{L_5180}</th>
              	<th>{L__0022}</th>
              	<th>{L_303}</th>
              	<th>{L__0025}</th>
             	<th>{L_3500_1015825}</th>
         	</tr>
			<!-- BEGIN busers -->
			<tr>
                <td>{busers.NAME}<br><a href="editbannersuser.php?id={busers.ID}" class="btn btn-primary btn-sm">{L_350_10150}</a></td>
                <td>{busers.COMPANY}</td>
                <td><a href="mailto:{busers.EMAIL}">{busers.EMAIL}</a></td>
                <td align="center">{busers.NUM_BANNERS}</td>
                <td align="center">
                	<input type="checkbox" name="delete[]" value="{busers.ID}"> {L_008}<br><br>
                	<a href="newuserbanner.php?id={busers.ID}" class="btn btn-success btn-sm">{L__0024}</a>
                </td>
           	</tr>
			<!-- END busers -->
		</table>
        <input type="hidden" name="action" value="deleteusers">
        <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
        <input type="submit" name="act" class="btn btn-danger" value="{L_350_10131}">
	</form>
</div>