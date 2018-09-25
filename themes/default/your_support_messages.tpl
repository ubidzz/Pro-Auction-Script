<!-- INCLUDE user_menu_header.tpl -->
<div class="col-sm-9">
<legend>{L_3500_1015432}</legend>
  	<!-- IF B_ISERROR -->
  	<div class="alert alert-success">
      	<button type="button" class="close" data-dismiss="alert">&times;</button>
    	{ERROR} 
    </div>
  	<!-- ENDIF -->
	<ul class="nav nav-tabs">
		<li class="active"><a href="#submitted" data-toggle="tab"><span class="glyphicon glyphicon-comment"></span> {L_3500_1015874}</a></li>
		<!-- IF B_OPEN -->
		<li><a href="#reply" data-toggle="tab"><span class="glyphicon glyphicon-pencil"></span> {L_3500_1015439j}</a></li>
		<!-- ENDIF -->
		<li><a href="{SITEURL}support" data-toggle="link"><span class="glyphicon glyphicon-saved"></span> {L_3500_1015439i}</a></li>
	</ul>
	<!-- IF B_OPEN -->
	<div class="tab-content">
		<div class="tab-pane tab-pane fade in" id="reply">
			<form name="submite_new_ticket" id="form1" method="post" class="form-horizontal" action="{SITEURL}support-{ID}" enctype="multipart/form-data">
		    	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
		    	<input type="hidden" name="reply" value="reply_back">
		    	<div class="panel panel-primary">
					<div class="panel-heading">{L_3500_1015439j}</div>
					<div class="panel-body">

				    	<div class="form-group">
				      		<label class="col-sm-2 control-label" for="to">{L_241}:</label>
				      		<div class="col-sm-10">
				      			<select id="to" class="form-control"><option>{L_3500_1015436}</option></select>
				      		</div>
				    	</div>
				    	<div class="form-group">
				      		<label class="col-sm-2 control-label" for="subject">{L_332}:</label>
				      		<div class="col-sm-10">
				      			<select id="subject" name="subject" class="form-control"><option value="{SUBJECT}">{SUBJECT}</option></select>
				      		</div>
				    	</div>
				      	<label class="control-label" for="message">{L_333}:</label>
				      	{MESSAGE}
		    		</div>
		    		<div class="panel-footer text-right">
		    			<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-file"></span> {L_3500_1015873}</button>
		    		</div>
		    	</div>
			</form>
		</div>
		<!-- ENDIF -->
		<div class="tab-pane tab-pane fade in active table-responsive" id="submitted">
			<table class="table table-bordered table-striped">
				<thead>
				 	<tr>
				      	<th>{L_3500_1015439d}</th>
				      	<th>{L_332}</th>
				      	<th>{L_3500_1015439e}</th>
				      	<th>{L_3500_1015439f}</th>
				      	<th>{L_3500_1015439g}</th>
				      	<!-- IF B_OPEN -->
				    	<th></th>
				     	<!-- ENDIF -->
					</tr>
				</thead>
				<tbody>
				 	<!-- IF MSGCOUNT eq 0 -->
				 	<tr>
				    	<td colspan="5">{L_2__0029}</td>
				  	</tr>
				  	<!-- ELSE -->
				 	<!-- BEGIN ticket -->
				  	<tr>
				      	<td><small>{ticket.CREATED}</small></td>
				      	<td>{ticket.TICKET_TITLE}</td>
				      	<td>{ticket.LAST_UPDATE_USER}</td>
				      	<td>
				      		<!-- IF ticket.TICKET_STATUS --> 
				      		<span style="color:green"><b>{L_3500_1015439a}</b></span>
				      		<!-- ELSE -->
				      		<span style="color:red"><b>{L_3500_1015439b}</b></span>
				      		<!-- ENDIF -->
				      	</td>
				      	<td>{ticket.LAST_UPDATED_TIME}</td>
				     	<!-- IF ticket.TICKET_STATUS -->
				      	<td>
				          	<form name="close_ticket" id="form1" method="post" action="{SITEURL}support">
				          		<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				          		<input type="hidden" name="closeid[]" class="closeid" value="{ticket.TICKET_ID}">
				          		<button class="btn btn-success" type="submit" name="submit"><span class="glyphicon glyphicon-ok"></span> {L_678}</button>
				       	   	</form>
				      	</td>
				   		<!-- ENDIF -->
				  	</tr>
				   	<!-- END ticket -->
					<!-- ENDIF -->
				</tbody>
			</table>
		    <table class="table table-bordered table-striped">
				<thead>
			     	<tr>
			        	<th width="20%">{L_240}</th>
			        	<th>{L_3500_1015438}</th>
			    	</tr>
				</thead>
				<tbody>
			        <!-- IF MSGCOUNT eq 0 -->
			        <tr>
			         	<td colspan="2">{L_2__0029}</td>
			        </tr>
			        <!-- ELSE -->
			        <!-- BEGIN ticket_mess -->
			      	<tr>
			          	<td>
			          		<b>{ticket_mess.LAST_USER}</b><br>
			          		<small>{ticket_mess.CREATED}</small>
			          	</td>
			        	<td>{ticket_mess.TICKET_MESSAGE}</td>
			       	</tr>
			      	<!-- END ticket_mess -->
			    	<!-- ENDIF -->
				</tbody>
			</table>
		</div>
	</div>

</div>
