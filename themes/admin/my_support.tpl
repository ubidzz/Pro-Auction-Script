<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<script type="text/javascript">
$(document).ready(function () {
    $("#checkboxalldelete").click(function () {
        var checked_status = this.checked
        $(".deleteid").each(function () {
            this.checked = checked_status;
        });
    });
});

$(document).ready(function () {
    $("#checkboxallclose").click(function () {
        var checked_status = this.checked
        $(".closeid").each(function () {
            this.checked = checked_status;
        });
    });
});
</script>
<div class="panel panel-primary">
	<form name="update" action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{L_3500_1015432} <input style="float:right" type="submit" name="submit" value="{L_071}" class="btn btn-xs btn-success"></h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
	         	<thead>
					<tr>
						<th width="10%">{L_3500_1015439d}</th>
						<th width="10%">{L_240} {L_313}</th>
						<th>{L_332}</th>
						<th width="10%">{L_3500_1015439e}</th>
						<th width="8%">{L_3500_1015439f}</th>
						<th width="10%">{L_3500_1015439g}</th>
						<th width="5%"><small><span class="muted">{L_678}</span></small><br>
						 	<input type="checkbox" name="" id="checkboxallclose" value="">
						</th>
						<th width="5%"><small><span class="muted">{L_008}</span></small><br>
						 	<input type="checkbox" name="" id="checkboxalldelete" value="">
						</th>
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
						<td>{ticket.USER}</td>
						<td><a href="{SITEURL}{ADMIN_FOLDER}/admin_support_messages.php?x={ticket.TICKET_ID}">{ticket.TICKET_TITLE}</a></td>
						<td>{ticket.LAST_UPDATE_USER}</td>
						<td><!-- IF ticket.TICKET_STATUS --> <span style="color:green"><b>{L_3500_1015439a}</b></span><!-- ELSE --><span style="color:red"><b>{L_3500_1015439b}</b></span><!-- ENDIF --></td>
						<td>{ticket.LAST_UPDATED_TIME}</td>
						<!-- IF ticket.TICKET_STATUS -->
						<td style="text-align:center">
						  	<input type="checkbox" name="closeid[]" class="closeid" value="{ticket.TICKET_ID}">
						</td>
						<!-- ELSE -->
						<td></td>
						  	<!-- ENDIF -->
						<td style="text-align:center">
						  	<input type="checkbox" name="deleteid[]" class="deleteid" value="{ticket.TICKET_ID}">
						</td>
					</tr>
					<!-- END ticket -->
					<!-- ENDIF -->
				</tbody>
	     	</table>
		</div>
	</form>
</div>
