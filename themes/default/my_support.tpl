<!-- INCLUDE user_menu_header.tpl -->
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
<div class="col-sm-9">
	<legend>{L_3500_1015432}</legend>
  	<!-- IF B_ISERROR -->
  	<div class="alert alert-success">
    	<button type="button" class="close" data-dismiss="alert">&times;</button>
    	{ERROR} 
    </div>
  	<!-- ENDIF -->
	<ul class="nav nav-tabs">
		<li class="active"><a href="#submitted" data-toggle="tab"><span class="glyphicon glyphicon-saved"></span> {L_3500_1015439i}</a></li>
		<li><a href="#new" data-toggle="tab"><span class="glyphicon glyphicon-save-file"></span> {L_3500_1015439h}</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane tab-pane fade in active table-responsive" id="submitted">
			<form class="form-inline" action="{SITEURL}support" method="post" name="deletemessages" enctype="multipart/form-data">
		    	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
		    	<div class="panel panel-primary">
					<div class="panel-heading">{L_3500_1015439i}</div>
					<div class="panel-body">
				    	<table class="table table-bordered table-striped">
					      	<thead>
					        	<tr>
					          		<th>{L_3500_1015439d}</th>
					          		<th>{L_332}</th>
					          		<th>{L_3500_1015439e}</th>
					          		<th>{L_3500_1015439f}</th>
					          		<th>{L_3500_1015439g}</th>
					          		<th>{L_678}</th>
					          		<th>{L_008}</th>
					        	</tr>
					      	</thead>
					      	<tbody>
					        	<!-- IF MSGCOUNT eq 0 -->
					        	<tr>
					          		<td colspan="7">{L_3500_1015439r}</td>
					        	</tr>
					        	<!-- ELSE -->
					        	<!-- BEGIN ticket -->
					        	<tr>
					          		<td><small>{ticket.CREATED}</small></td>
					          		<td><a href="{SITEURL}support-{ticket.TICKET_ID}">{ticket.TICKET_TITLE}</a></td>
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
					        	<tr>
					        		<td colspan="5" style="text-align:right"><span class="muted"><small>{L_30_0102}</small></span></td>
						        	<td align="center-inline">
						        		<div class="checkbox-inline">
						        			<label><input type="checkbox" name="" id="checkboxallclose" value="">{L_678}</label>
						        		</div>
						        	</td>
						        	<td align="center-inline">
						        		<div class="checkbox-inline">
						        			<label><input type="checkbox" name="" id="checkboxalldelete" value="">{L_008}</label>
						        		</div>
						        	</td>
						      	</tr>
					      	</tbody>
				    	</table>
				    </div>
				    <div class="panel-footer text-right">
				    	<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> {L_071}</button>
				    </div>
		    	</div>
			</form>
		</div>
		<div class="tab-pane tab-pane fade in" id="new">
			<form name="submite_new_ticket" id="form1" method="post" class="form-horizontal" action="{SITEURL}support">
		    	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
		    	<div class="panel panel-primary">
					<div class="panel-heading">{L_3500_1015439h}</div>
					<div class="panel-body">
				    	<div class="form-group">
				      		<label for="to" class="col-sm-2 control-label">{L_241}:</label>
				      		<div class="col-sm-10">
				      			<select class="form-control"><option>{L_3500_1015436}</option></select>
				      		</div>
				    	</div>
				    	<div class="form-group">
				      		<label for="subject" class="col-sm-2 control-label">{L_332}:</label>
				      		<div class="col-sm-10">
				        		<input name="subject" class="form-control" type="text" value="{SUBJECT}" id="subject">
				        	</div>
				    	</div>
				    	<label class="control-label" for="message">{L_333}:</label>
				      	{MESSAGE}
					</div>
					<div class="panel-footer text-right">
						<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-file"></span> {L_3500_1015872}</button>
					</div>
				</div>
			</form>
		</div>

	</div>
</div>