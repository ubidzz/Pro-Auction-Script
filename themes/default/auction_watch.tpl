<!-- INCLUDE user_menu_header.tpl -->
<div class="col-sm-9">
	<legend>{L_25_0084}</legend>
	<div class="alert alert-info" role="alert"> {L_30_0210}
	  	<form action="auction_watch.php?insert=true" method="post">
	    	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
	    	<div class="input-append">

	    			<div class="input-group">
	      				<input class="form-control col-sm-5" name="add" id="appendedInputButton" type="text">
	      				<span class="input-group-btn">
	      					<button class="btn btn-success" type="submit" value="{L_5204}">{L_5204}</button>
	      				</span>
	      			</div>
	    	</div>
	  	</form>
	</div>
	<legend>{L__0035}</legend>
	<div class="alert alert-info" role="alert">{L_3500_1015905}</div>
    <!-- BEGIN items -->
    <a href="{SITEURL}auction_watch.php?delete={items.ITEMENCODE}" type="button" class="btn btn-success btn-sm">{items.ITEM}</a>
    <!-- END items -->
</div>
