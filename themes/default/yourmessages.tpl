<!-- INCLUDE user_menu_header.tpl -->
<div class="col-sm-9 table-responsive">
	<legend>{L_333}</legend>
  	<table class="table table-bordered table-condensed">
    	<tbody>
      		<tr>
        		<td width="150">{L_332}:</td>
        		<td><strong>{SUBJECT}</strong></td>
      		</tr>
      		<tr>
        		<td>{L_340}:</td>
        		<td>{SENDERNAME} <small>{SENT}</small></td>
      		</tr>
      		<tr>
        		<td>{L_333}:</td>
        		<td>{MESSAGE}</td>
      		</tr>
    	</tbody>
  	</table>
  	<p> 
  		<a class="btn btn-success btn-sm" href="{SITEURL}mail.php?x=1&amp;message={HASH}"><span class="glyphicon glyphicon-ok"></span> {L_349}</a> 
  		<a class="btn btn-danger btn-sm" href="{SITEURL}mail.php?deleteid[]={ID}" onClick="if ( !confirm('{L_3500_1015941}') ) { return false; }"><span class="glyphicon glyphicon-remove"></span> {L_008}</a> 
  		<a class="btn btn-primary btn-sm" href="{SITEURL}mail.php"><span class="glyphicon glyphicon-arrow-left"></span> {L_351}</a>
  	</p>

</div>