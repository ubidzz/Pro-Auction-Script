<!-- INCLUDE user_menu_header.tpl -->
<div class="col-sm-9 table-responsive">
	<legend>{L_5030}</legend>
	<table class="table table-bordered table-striped table-condensed">
  		<tr>
    		<th> {L_5034} </th>
    		<th> {L_5043} </th>
    		<th> {L_5053} </th>
  		</tr>
  		<!-- BEGIN boards -->
  		<tr>
    		<td><a href="{SITEURL}msgboard.php?board_id={boards.ID}">{boards.NAME}</a> </td>
    		<td> {boards.NUMMSG} </td>
    		<td> {boards.LASTMSG} </td>
  		</tr>
  		<!-- END boards -->
	</table>
</div>