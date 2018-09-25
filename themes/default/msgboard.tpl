<!-- INCLUDE user_menu_header.tpl -->
<div class="col-sm-9 table-responsive">
	<legend> {L_5030}: {BOARD_NAME}</legend>
	<ul class="nav nav-tabs nav-inline">
		<li class="active"><a href="#messages" data-toggle="tab">{L_5059}</a></li>
		<li><a href="#newMessage" data-toggle="tab" >{L_5057}</a></li>
	 </ul>
	<div class="tab-content">
		<div class="tab-pane tab-pane fade in active" id="messages">
		    <table align="center" class="table table-bordered table-condensed table-striped" cellspacing="0" cellpadding="2">
		    	<tr>
		    		<th>{L_5059}</th>
		    		<th class="col-sm-2">{L_5060}</th>
		    		<th class="col-sm-2">{L_314}</th>
		    	</tr>
		        <!-- BEGIN msgs -->
		        <tr>
		          	<td> {msgs.MSG} </td>
		          	<td>
		          		<!-- IF msgs.USERNAME ne '' -->
		            	<b>{msgs.USERNAME}</b>
		            	<!-- ELSE -->
		            	<b>{L_5061}</b>
		            	<!-- ENDIF -->
		          	</td>
		          	<td>{msgs.POSTED}</td>
		        </tr>
		        <!-- END msgs -->
		  	</table>
		   	<div align="center" class="padding centre"> {L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}
			    <ul class="pagination">
			    	{PREV}
			        <!-- BEGIN pages -->
			        {pages.PAGE}
			        <!-- END pages -->
			        {NEXT} 
			  	</ul>
			</div>
		</div>
		<div class="tab-pane tab-pane fade in" id="newMessage">
			<div align="center">
		       	<form name="messageboard" action="" method="post">
		          	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
		           	<input type="hidden" name="action" value="insertmessage">
		          	<input type="hidden" name="board_id" value="{BOARD_ID}">
		           	{BOARDMSG}
		           	<hr>
		           	<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> {L_5057}</button>
		           	<a class="btn btn-danger btn-sm" href="{SITEURL}boards.php"><span class="glyphicon glyphicon-arrow-left"></span> {L_5058}</a>
		        </form>
		  	</div>
		</div>
	</div>
</div>