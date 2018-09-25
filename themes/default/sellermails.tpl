<!-- INCLUDE user_menu_header.tpl -->
<div class="col-sm-9">
	<legend>{L_25_0188}</legend>
  	<form action="" method="post" name="thisform" id="thisform">
    	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
    	<p>{L_25_0195}</p>
    	<div class="radio">
    		<label><input type="radio" name="startemailmod" value="yes"{B_AUCSETUPY}>{L_25_0196} </label>
    	</div>
    	<div class="radio">
    		<label><input type="radio" name="startemailmod" value="no"{B_AUCSETUPN}>{L_25_0197} </label>
    	</div>
    	<hr />
    	<p>{L_25_0189}</p>
    	<div class="radio">
    		<label><input type="radio" name="endemailmod" value="one"{B_CLOSEONE}>{L_25_0190} </label>
    	</div>
    	<div class="radio">
    		<label><input type="radio" name="endemailmod" value="cum"{B_CLOSEBULK}>{L_25_0191} </label>
    	</div>
    	<div class="radio">
    	<label><input type="radio" name="endemailmod" value="none"{B_CLOSENONE}>{L_25_0193} </label>
    	</div>
    	<hr />
    	<p>{L_903}</p>
    	<div class="radio">
    		<label><input type="radio" name="emailtype" value="text"{B_EMAILTYPET}>{L_915} </label>
    	</div>
    	<div class="radio">
    		<label><input type="radio" name="emailtype" value="html"{B_EMAILTYPEH}>{L_902} </label>
    	</div>
    	<hr />
    	<input type="hidden" name="action" value="update">
    	<button type="submit" name="Submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> {L_2_0015}</button>
  	</form>
</div>