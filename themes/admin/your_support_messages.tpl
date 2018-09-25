<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<script type="text/javascript">
	$(".form1").submit(function () {
	    if ($(".to").val() == "") {
	        return false;
	    }
	    if ($(".subject").val() == "") {
	        return false;
	    }
	    if ($(".message").val() == "") {
	        return false;
	    }
	    return true;
	});
</script>
<!-- IF B_OPEN -->
<form action="{SITEURL}{ADMIN_FOLDER}/admin_support_messages.php?x={ID}" id="form1" method="post" name="reply_back" enctype="multipart/form-data">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<input type="hidden" name="reply" value="reply_back">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{L_3500_1015439j} 
	    		<a style="float:right" href="{SITEURL}{ADMIN_FOLDER}/admin_support_messages.php?x={ID}" class="btn btn-xs btn-danger">{L_618}</a>
	    		<input style="float:right" name="submit" type="submit" value="{L_007}" class="btn btn-xs btn-success">
	    	</h4>
	    </div>
			<table class="table table-hover table-striped">
       		<tbody>
         		<tr>
             		<td>{L_241}:</td>
             		<td>{USER}</td>
             	</tr>
             	<tr>
             		<td>{L_332}:</td>
             		<td><input class="small" type="hidden" name="subject" value="{SUBJECT}">{SUBJECT}</td>
             	</tr>
             	<tr>
             		<td>{L_333}:</td>
             		<td>{MESSAGE}</td>
             	</tr>
       		</tbody>
      	</table>
		</div>
</form>
<!-- ENDIF -->
<form action="{SITEURL}{ADMIN_FOLDER}/admin_support.php" method="post" name="closemessages" enctype="multipart/form-data">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{L_3500_1015439f}
	    		<a style="float:right" href="{SITEURL}{ADMIN_FOLDER}/admin_support_messages.php?x={ID}&reply" class="btn btn-xs btn-success">{L_3500_1015439j}</a>
	    		<a style="float:right" href="{SITEURL}{ADMIN_FOLDER}/admin_support.php" class="btn btn-xs btn-info">{L_285}</a>
	    	</h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>{L_3500_1015439d}</th>
					    <th>{L_332}</th>
					    <th>{L_3500_1015439e}</th>
					    <th>{L_3500_1015439f}</th>
					    <th>{L_3500_1015439g}</th>
					    <!-- IF B_OPENED -->
					    <th>&nbsp;</th>
					   	<!-- ENDIF -->
					</tr>
				</thead>
				<tbody>
					<!-- IF MSGCOUNT eq 0 -->
					<tr>
						<td colspan="5">{L_3500_1015439s}</td>
					</tr>
					<!-- ELSE -->
					<!-- BEGIN ticket -->
						<tr>
						<td><small><span class="muted">{ticket.CREATED}</span></small></td>
					    <td>{ticket.TICKET_TITLE}</td>
					    <td>{ticket.LAST_UPDATE_USER}</td>
					    <td><!-- IF ticket.TICKET_STATUS --> <span style="color:green"><b>{L_3500_1015439a}</b></span><!-- ELSE --><span style="color:red"><b>{L_3500_1015439b}</b></span><!-- ENDIF --></td>
					    <td>{ticket.LAST_UPDATED_TIME}</td>
					    <!-- IF ticket.TICKET_STATUS -->
					    <td style="text-align:center">
					    	<input type="hidden" name="user" value="{USER_ID}">
					    	<input type="hidden" name="closeid[]" class="closeid" value="{ticket.TICKET_ID}">
					       	<input class="btn btn-danger" type="submit" name="submit" value="{L_678}">
					    </td>
					   	<!-- ENDIF -->
					</tr>
					<!-- END ticket -->
					<!-- ENDIF -->
				</tbody>
			</table>
		</div>
	</div>
</form>
<div class="panel panel-primary">
    <div class="panel-heading">
    	<h4 class="panel-title">{L_3500_1015438}</h4>
    </div>
    <div class="panel-body">
		<table class="table table-bordered">
    		<thead>
				<tr>
			    	<th width="15%">{L_240}</th>
			        <th>{L_3500_1015438}</th>
				</tr>
			</thead>
			<tbody>
				<!-- IF MSGCOUNT eq 0 -->
			    <tr>
			    	<td colspan="5">{L_2__0029}</td>
			    </tr>
			    <!-- ELSE -->
			    <!-- BEGIN ticket_mess -->
			    <tr>
			    	<td>{ticket_mess.LAST_USER}<br><small><span class="muted">{ticket_mess.CREATED}</span></small></td>
			        <td>{ticket_mess.TICKET_MESSAGE}</td>
			    </tr>
			    <!-- END ticket_mess -->
			    <!-- ENDIF -->
			</tbody>
    	</table>
	</div>
</div>

