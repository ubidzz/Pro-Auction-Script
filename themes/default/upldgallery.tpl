<div id="imageUploader" class="modal fade">

	<!-- INCLUDE uploadhandler.tpl -->

	<div class="modal-dialog">

 		<div class="modal-content">

			<div class="modal-header">

		     	<h4 class="modal-title">{L_3500_1015494} <button class="btn btn-danger btn-xs pull-right" data-dismiss="modal">{L_678}</button></h4>

		   	</div>

		   	<div class="modal-body">

		   		<div class="alert alert-warning" role="alert">{L_3500_1015897}</div>

				<div class="well">

		    		{MAXPICS}<br>{FREEMAXPIC}<br>{ALLOWEDPICTURETYPES}

			    </div>

			    <div id="returnMessage"></div>

			    <ul class="nav nav-tabs" role="tablist">

			    	<li role="presentation" class="active"><a href="#dragNdropUploader" aria-controls="dragNdropUploader" role="tab" data-toggle="tab">{L_677}</a></li>

			    	<li><a href="#pickDefault" aria-controls="pickDefault" role="tab" data-toggle="tab">{L_3500_1015900}</a></li>

			    </ul>

			    <div class="tab-content">

			    	<div role="tabpanel" class="tab-pane active" id="dragNdropUploader">

					    <div class="well" id="dragandrophandler" align="center"><strong>{L_3500_1015894}</strong></div>

					    <div class="input-group">

							<form id="upload_form" enctype="multipart/form-data" method="post">

								<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">

								<div class="input-group-btn">

								  	<input multiple="multiple"  type="file" class="btn btn-info" name="file" id="file">

								</div >

								<div class="input-group-btn">

								  	<button type="button" class="btn btn-success"  value="Upload File" id="manualhandler">Upload File</button>

								</div>

							</form>

						</div>

					    <div id="statusUpload"></div>

				 	</div>

					<div role="tabpanel" class="tab-pane" id="pickDefault">

					    <table class="table table-striped table-bordered table-condensed table-responsive">
							<tbody id="images">
							</tbody>
						</table>

				 	</div>

				</div>

			</div>

		</div>

	</div>

</div>

