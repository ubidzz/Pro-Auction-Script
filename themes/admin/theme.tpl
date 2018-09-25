<!-- IF ERROR ne '' -->

<div class="alert alert-info alert-dismissible">

	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>

</div>

<!-- ENDIF -->





<!-- IF B_EDIT_FILE -->

<div class="col-xs col-sm-12 col-md-12 col-lg-12">

	<form name="editFile" action="{SITEURL}{ADMIN_FOLDER}/theme.php" method="post">

		<input type="hidden" name="filename" value="{FILENAME}">

		<input type="hidden" name="theme" value="{THEME}">

		<input type="hidden" name="action" value="<!-- IF FILENAME ne '' -->edit<!-- ELSE -->add<!-- ENDIF -->">

		<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">

		<div class="panel panel-primary">

		    <div class="panel-heading">

		    	<h4 class="panel-title">{L_26_0003} <input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{L_089}"></h4>

		    </div>

		    <div class="panel-body">

				<table class="table table-bordered">

	              <tbody>

	                   	<tr>

	                      	<td>{L_812}</td>

	                    	<td><!-- IF FILENAME ne '' --><b>{FILENAME}</b><!-- ELSE --><input type="text" name="new_filename" value="" style="width:600px;"><!-- ENDIF -->

	                  	</tr>

	                   	<tr>

	                       	<td>{L_813}</td>

	                      	<td><textarea style="width:600px; height:400px;" name="content">{FILECONTENTS}</textarea></td>

	                 	</tr>

	             	</tbody>

	           	</table>

			</div>

		</div>

	</form>

</div>

<!-- ENDIF -->

<div class="col-md-6">

	<form name="logo" action="{SITEURL}{ADMIN_FOLDER}/theme.php" method="post" enctype="multipart/form-data">

		<input type="hidden" name="action" value="update_logo">

		<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">

		<div class="box box-info">

		    <div class="box-header">

		    	<h4 class="box-title">{L_30_0031a}</h4>

				<div class="pull-right box-tools">

					<input type="submit" name="act" class="btn btn-sm btn-success" value="{L_3500_1015665}">

	            	<button type="button" class="btn btn-danger btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>

		  		</div>

				<div class="box-body table-responsive">

					<table class="table table-hover table-striped">

			        	<tbody>

			             	<tr>

			                 	<td><img height="120px" src="{IMAGEURL}"></td>

			               	</tr>

			               	<tr>

			                 	<td>{L_602}</td>

			              	</tr>

			              	<tr>

			               		<td><input type="file" name="logo" size="40"></td>

			              	</tr>

			        	</tbody>

			     	</table>

			     </div>

		     </div>

		</div>

	</form>

</div>

<div class="col-md-6">

	<form name="cache" action="{SITEURL}{ADMIN_FOLDER}/theme.php" method="post">

		<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">

		<input type="hidden" name="action" value="clear_cache">

		<div class="box box-info">

			<div class="box-header">

		    	<h4 class="box-title">{L_3500_1015466}</h4>

		    	<!-- tools box -->

	            <div class="pull-right box-tools">

	            	<input type="submit" name="act" class="btn btn-sm btn-success" value="{L_30_0031}">

	            	<button type="button" class="btn btn-danger btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>

		  		</div>

		  		<div class="box-body table-responsive">

					<table class="table table-hover table-striped">

			       		<tbody>

			            	<tr>

			                 	<td>{L_30_0032}</td>

			            	</tr>   

			       		</tbody>

			     	</table>

				</div>

			</div>

		</div>

	</form>

</div>

<div class="col-md-12">

	<form name="theme" action="{SITEURL}{ADMIN_FOLDER}/theme.php" method="post">

		<input type="hidden" name="action" value="updateFront" id="action">

		<input type="hidden" name="theme" value="" id="theme">

		<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">

		<div class="box box-info">

			<div class="box-header">

		    	<h4 class="box-title">

		    		{L_26_0002}

		    	</h4>

		    	<!-- tools box -->

	            <div class="pull-right box-tools">

	            	<input type="submit" name="" class="btn btn-sm btn-success" value="{L_26_0000}">

	            	<button type="button" class="btn btn-danger btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>

		  		</div>

		  		<div class="box-body table-responsive">

					<table class="table table-hover table-striped">

			        	<tbody>

			            	<!-- BEGIN themes -->

			              	<tr>

			                 	<td>

			                     	<input type="radio" name="dtheme" value="{themes.NAME}" <!-- IF themes.B_CHECKED -->checked="checked" <!-- ENDIF -->/>

			                     	<b>{themes.NAME}</b>

			                   	</td>

			                   	<td>

			                    	<p><a class="btn btn-sm btn-info" href="theme.php?do=listfiles&theme={themes.NAME}">{L_26_0003}</a> <a class="btn btn-sm btn-success" href="theme.php?do=addfile&theme={themes.NAME}">{L_26_0004}</a></p>

			                  	</td>

			             	</tr>

			              	<!-- IF themes.B_LISTFILES -->

			               	<tr>

			                 	<td colspan="2">

			                     	<select name="file" multiple size="24" style="font-weight:bold; width:350px"

										ondblclick="document.getElementById('action').value = ''; document.getElementById('theme').value = '{themes.NAME}'; this.form.submit();">

										<!-- BEGIN files -->

										<option value="{themes.files.FILE}">{themes.files.FILE}</option>

										<!-- END files -->

			                     	</select>

			                  	</td>

			             	</tr>

			              	<!-- ENDIF -->

			              	<!-- END themes -->

			           	</tbody>

			      	</table>

				</div>

			</div>

	   </div>

	</form>

</div>

<div class="col-md-12">

	<form name="adminTheme" action="{SITEURL}{ADMIN_FOLDER}/theme.php" method="post">

		<input type="hidden" name="action" value="updateAdmin" id="action">

		<input type="hidden" name="theme" value="" id="adminTheme">

		<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">

		<div class="box box-info">

			<div class="box-header">

				<h4 class="box-title">{L_3500_1015837}</h4>

		   		<!-- tools box -->

	            <div class="pull-right box-tools">

	            	<input type="submit" name="" class="btn btn-sm btn-success" value="{L_26_0000}">

	            	<button type="button" class="btn btn-danger btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>

		  		</div>

		  		<div class="box-body table-responsive">

					<table class="table table-hover table-striped">

			        	<tbody>

			            	<!-- BEGIN admin_themes -->

			              	<tr>

			                	<td>

			                     	<input type="radio" name="admin_theme" value="{admin_themes.NAME}" <!-- IF admin_themes.B_CHECKED -->checked="checked" <!-- ENDIF -->/>

			                       	<b>{admin_themes.NAME}</b>

			                  	</td>

			                  	<td>

			                     	<p><a class="btn btn-sm btn-info" href="theme.php?do=listfiles&theme={admin_themes.NAME}">{L_26_0003}</a> <a class="btn btn-sm btn-success" href="theme.php?do=addfile&theme={admin_themes.NAME}">{L_26_0004}</a></p>

			                  	</td>

			              	</tr>

			             	<!-- IF admin_themes.B_LISTFILES -->

			              	<tr>

			                	<td colspan="2">

			                    	<select name="file" multiple size="24" style="font-weight:bold; width:350px"

										ondblclick="document.getElementById('action').value = ''; document.getElementById('adminTheme').value = '{admin_themes.NAME}'; this.form.submit();">

										<!-- BEGIN files -->

										<option value="{admin_themes.files.FILE}">{admin_themes.files.FILE}</option>

										<!-- END files -->

			                       	</select>

			                  	</td>

			             	</tr>

			             	<!-- ENDIF -->

							<!-- END admin_themes -->

			          	</tbody>

			      	</table>

				</div>

			</div>

		</div>

	</form>

</div>

