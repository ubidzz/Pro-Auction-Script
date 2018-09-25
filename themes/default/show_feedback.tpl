<!-- INCLUDE user_menu_header.tpl -->
<div class="col-sm-9 table-responsive">
	<legend>{L_208}</legend>
  	<div class="form-actions"> 
  		<a class="btn btn-primary btn-sm" href="{BACK_TO_AUCTION}"><span class="glyphicon glyphicon-arrow-left"></span> {L_138}</a> 
  		<a class="btn btn-success btn-sm" href="{SITEURL}profile.php?user_id={ID}"><span class="glyphicon glyphicon-user"></span> {L_505}</a> 
  	</div>
  	<hr>
    <legend>{L_185}{USERNICK} ({USERFB}){USERFBIMG}</legend>
  	<table class="table table-bordered" >
    	<tr>
      		<th width="9%" align="center">
				<img src="{SITEURL}images/positive.png"border="0" alt="+1">   
	   			<img src="{SITEURL}images/neutral.png" border="0" alt="0">   
				<img src="{SITEURL}images/negative.png" border="0" alt="-1">
      		</th>
      		<th>{L_503}</th>
      		<th>{L_240}</th>
      		<th>{L_364}</th>
    	</tr>
    	<!-- BEGIN fbs -->
    	<tr>
      		<td align="center"><img src="{fbs.IMG}" align="middle" alt=""></td>
      		<td>{fbs.FEEDBACK}<br>{L_259}: {fbs.AUCTIONURL} (#{fbs.AUCTIONID})</td>
      		<td><a href="{fbs.USFLINK}">{fbs.USERNAME}</a> (<a href="{SITEURL}feedback.php?id={fbs.USERID}&faction=show">{fbs.USFEED}</a>) {fbs.USICON} </td>
      		<td><small>{fbs.FBDATE}</small> </td>
    	</tr>
    	<!-- END fbs -->
  	</table>
    <ul class="pagination ">
      <li>{PREV}</li>
      <!-- BEGIN pages -->
      {pages.PAGE}
      <!-- END pages -->
      <li>{NEXT}</li>
     </ul>
</div>