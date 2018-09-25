<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form class="form-horizontal" name="addnew" action="" method="post">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<!-- IF ID ne '' -->
	<input type="hidden" name="id" value="{ID}">
	<!-- ENDIF -->
	<div class="box box-success">
		<div class="box-header">
	    	<h4 class="box-title">{PAGENAME}</h4>
		    <!-- tools box -->
	       	<div class="pull-right box-tools">
	       		<input type="submit" class="btn btn-sm btn-success" value="{BUTTON}">
	       		<a class="btn btn-sm btn-info" href="{SITEURL}{ADMIN_FOLDER}/news.php"><i class="icol-cross"></i> {L_516}</a>
		  	</div>
		  	<div class="box-body">
	        	<div class="form-group">
	            	<label class="col-sm-2 control-label">{L_521}: </label>
	                <div class="col-sm-10">
	                	<input type="radio" name="suspended" value="0"<!-- IF B_ACTIVE --> checked="checked"<!-- ENDIF -->> {L_030} 
	                 	<input type="radio" name="suspended" value="1"<!-- IF B_INACTIVE --> checked="checked"<!-- ENDIF -->> {L_029}
	             	</div>
	        	</div>
	           	<!-- BEGIN lang -->
				<div class="form-group">
	            	<label class="col-sm-2 control-label">{L_519}: <img src="../language/flags/{lang.LANG}.gif"></label>
	              	<div class="col-sm-10">
	                 	<input type="text" name="title[{lang.LANG}]" maxlength="255" value="{lang.TITLE}" class="form-control">
	             	</div>
	         	</div>
	       		<!-- END lang -->
	        	<!-- BEGIN lang -->
	        	<div class="form-group">
	            	<label class="control-label">{L_520}: <img src="../language/flags/{lang.LANG}.gif"></label>
	             	{lang.CONTENT}
	         	</div>
	        	<!-- END lang -->
			</div>
		</div>
	</div>
</form>
