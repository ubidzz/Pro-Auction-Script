<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->
<div id="flags" class="modal fade" role="dialog">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title">Installed Country Flags</h4>
      		</div>
      		<div class="modal-body">
      			<p>If your flag is not shown below please upload it.</p>
        		<!-- BEGIN flags -->
        		<img width="29" height="19" src="{SITEURL}language/flags/{flags.FLAG}" border="0">
        		<!-- END flags -->
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      		</div>
    	</div>
  	</div>
</div>

<form name="newLang" action="{SITEURL}{ADMIN_FOLDER}/newlanguage.php" method="post" class="col-sm-8">
	<input type="hidden" name="action" value="newlanguage">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="box box-primary">
	    <div class="box-heading">
	    	<div class="box-title">
	    		<b>{L_3500_1016006}</b>
	    		<button style="float:right" type="submit" class="btn btn-sm btn-success">{L_394}</button>
	    	</div>
	    </div>
	    <div class="box-body">
	    	{L_3500_1016012}
	    	<div class="form-group">
	    		<label>{L_3500_1016009}</label>
	    		<input type="text" class="form-control" name="langcode" value="" placeholder="EN" maxlength="2">
	    	</div>
	    	<div class="form-group">
	    		<label>{L_3500_1016010}</label>
	    		<input type="text" class="form-control" name="charset" value="" placeholder="UTF-8" maxlength="10">
	    	</div>
	    	<div class="form-group">
	    		<label>{L_3500_1016011}</label>
	    		<input type="text" class="form-control" name="docdir" value="" placeholder="ltr" maxlength="3">
	    	</div>
		</div>
	</div>
</form>
<form name="newFlag" action="{SITEURL}{ADMIN_FOLDER}/newlanguage.php" method="post" enctype="multipart/form-data" class="col-sm-4">
	<input type="hidden" name="action" value="uploadFlag">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="box box-primary">
	    <div class="box-heading">
	    	<div class="box-title">
	    		<b>Upload New Language Flag</b>
	    	</div>
	    </div>
	    <div class="box-body">
	    	<p>Requirements<br>
		    	<ol>
		    		<li>The image must be a gif image.</li>
		    		<li>The width and hight cannot be greater than 29x19 px.</li>
		    		<li>The image name must be 2 letters long.</li>
		    		<li>The image name must be in capital letters.</li>
		    		<li>The image name must be the language country code. (Example: FR) = French</li>
		    	</ol>
	    	</p>
	    	<p><button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#flags">Click Here</button> to view all installed language flags.</p>
	    	<hr />
	    	<input type="file" name="flagFile"><br>
	    	<button type="submit" class="btn btn-sm btn-success">Upload</button>
		</div>
	</div>
</form>