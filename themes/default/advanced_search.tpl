<legend> {L_464} </legend>
<!-- IF ERROR ne '' -->
<div class="alert alert-warning">{ERROR}</div>
<!-- ENDIF -->
<form class="form-horizontal well" name="adsearch" method="post" action="">
	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
	<input name="action" type="hidden" value="search">
	<div class="form-group">
	    <label for="title" class="col-sm-4 control-label">{L_1000}</label>
	    <div class="col-sm-7">
	     	<input class="form-control" type="text" id="title" placeholder="{L_1000}" name="title">
	   	</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-10">
			<div class="checkbox">
		   		<label><input name="desc" type="checkbox" value="y"> {L_1001}</label>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-10">
			<div class="checkbox">
		   		<label><input name="closed" type="checkbox" id="closed" value="y"> {L_25_0214}</label>
		 	</div>
		</div>
	</div>
	<div class="form-group">
	    <label class="col-sm-4 control-label">{L_1002}</label>
	    <div class="col-sm-7">
	     	{CATEGORY_LIST}
	    </div>
	</div>
	<div class="form-group">
	 	<label class="col-sm-4 control-label">{L_1003}</label>
	 	<div class="col-sm-7">
			<div class="input-group">
		     	<div class="input-group-addon">{L_1004}</div>
		      	<input class="form-control" type="text" name="minprice" maxlength="15" placeholder="0.02">
		      	<div class="input-group-addon">{L_1005}</div>
		      	<input type="text" class="form-control" name="maxprice" maxlength="15" placeholder="900.00">
		       	<div class="input-group-addon">{CURRENCY}</div>
		  	</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-4 control-label">{L_2__0025}</label>
		<div class="col-sm-7">
			<div class="checkbox">
				<label class="checkbox inline">
			   		<input type="checkbox" name="buyitnow" value="y"> {L_30_0100} <br>
			   		<input type="checkbox" name="buyitnowonly" value="y"> {L_30_0101}
			   	</label>
			</div>
		</div>
	</div>
	<div class="form-group">
	 	<label class="col-sm-4 control-label">{L_1006}</label>
	   	<div class="col-sm-7">
		   	<div class="checkbox">
		   		{PAYMENTS_LIST}
		   	</div>
		</div>
	</div>
	<div class="form-group">
	    <label class="col-sm-4 control-label">{L_125}</label>
	    <div class="col-sm-7">
	     	<input class="form-control" type="text" placeholder="{L_125}" name="seller">
	    </div>
	</div>
	<div class="form-group">
	    <label class="col-sm-4 control-label">{L_1008}</label>
	    <div class="col-sm-7">
	     	{COUNTRY_LIST}
	   	</div>
	</div>
	<div class="form-group">
	 	<label class="col-sm-4 control-label">{L_012}</label>
	    <div class="col-sm-7">
	      	<input type="text" name="zipcode" class="form-control" placeholder="{L_012}" maxlength="12">
	    </div>
	</div>
	<div class="form-group">
		<label class="col-sm-4 control-label">{L_1009}</label>
	    <div class="col-sm-7">
	    	<select class="form-control" name="ending" size="1">
	        	<option></option>
	        	<option value="1">{L_1010}</option>
	        	<option value="2">{L_1011}</option>
	        	<option value="4">{L_1012}</option>
	        	<option value="6">{L_1013}</option>
	      	</select>
	    </div>
	</div>
	<div class="form-group">
	  	<label class="col-sm-4 control-label">{L_1014}</label>
	    <div class="col-sm-7">
	      	<select class="form-control" name="SortProperty" size="1">
	        	<option></option>
	        	<option value="ends">{L_1015}</option>
	        	<option value="starts">{L_1016}</option>
	        	<option value="min_bid">{L_1017}</option>
	        	<option value="max_bid">{L_1018}</option>
	      	</select>
	   	</div>
	</div>
	<div class="form-group">
		<label class="col-sm-4 control-label">{L_718}</label>
	  	<div class="col-sm-7">
	    	<select class="form-control" name="type" size="1">
	        	<option></option>
	        	<option value="2">{L_1020}</option>
	        	<option value="1">{L_1021}</option>
	      	</select>
	  	</div>
	</div>
	<hr />
	<div class="form-actions">
		<input type="submit" name="go" value="{L_5029}" class="btn btn-primary">
	</div>
</form>
