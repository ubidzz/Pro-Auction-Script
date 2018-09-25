<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<script type="text/javascript">
	$(document).ready(function() {
		$("#download").submit(function() {
			if (confirm('{L_3500_1015736}')){
				return true;
			} 
			else 
			{
				return false;
			}
		});
		$("#upgrade").submit(function() {
			if (confirm('{L_3500_1015737}')){
				return true;
			} 
			else 
			{
				return false;
			}
		});
</script>
<div class="col-md-6">
	<form id="key" name="APIKey" action="{SITEURL}{ADMIN_FOLDER}/upgradescript.php" method="post">
		<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
		<input type="hidden" name="action" value="apikey">
		<div class="box box-info">
			<div class="box-header">
		    	<h4 class="box-title">{L_3500_1015833}</h4>
		    	<!-- tools box -->
		       	<div class="pull-right box-tools">
		       		<input type="submit" name="act" class="btn btn-sm btn-success" value="{L_3500_1015834}">
			  	</div>
				<div class="box-body table-responsive">
					<table class="table table-bordered">
			        	<tbody>
			        		<tr>
			        			<td colspan="2">{L_3500_1015835}</td>
			        		</tr>
			        		<tr>
			        			<td>
			        				<label>{L_3500_1015836}</label>
			        				<textarea name="api_key" class="form-control" rows="4">{APIKEY}</textarea>
			        			</td>
			        		</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="col-md-6">
		<div class="box box-info">
			<div class="box-header">
		    	<h4 class="box-title">{L_3500_1015989}</h4>
		    	<!-- tools box -->
				<div class="box-body table-responsive">
					<table class="table table-hover table-striped">
				       	<tbody>
				            <tr>
				                 <td>{L_3500_1015990}</td>
				            </tr>
				            <tr>
				            	<td><a href="{SITEURL}{ADMIN_FOLDER}/loading.php" class="btn btn-sm btn-success">Update</a></td>
				            </tr>
				       	</tbody>
					</table>
				</div>
			</div>
		</div>
</div>
<div class="col-md-12">
	<!-- BEGIN upgrade_list -->
	<form id="download" name="{upgrade_list.NEW_VERSION}" action="{SITEURL}{ADMIN_FOLDER}/upgradescript.php" method="post">
		<input type="hidden" name="action" value="upgrading">
		<input type="hidden" name="path" value="{upgrade_list.PATH}">
		<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
		<div class="box box-info">
			<div class="box-header">
		    	<h4 class="box-title">{upgrade_list.PAGE_NAME}</h4>
		    	<!-- IF upgrade_list.HIDE_BUTTON -->
		    	<!-- tools box -->
		       	<div class="pull-right box-tools">
		       		<input type="submit" name="act" class="btn btn-sm btn-success" value="Download {upgrade_list.NEW_VERSION}">
			  	</div>
			  	<!-- ENDIF -->
				<div class="box-body table-responsive">
					<table class="table table-bordered">
			        	<tbody>
			            	<tr>
			                	<th width="17%">{L_3500_1015710}</th>
			                    <td>{upgrade_list.TITLE}</td>
			               	</tr>
		 	               	<tr>
			                	<th>{L_3500_1015711}</th>
			                    <td>{upgrade_list.INSTALLED_VERSION}</td>
			               	</tr>
							<tr>
			                	<th>{L_3500_1015712}</th>
			                    <td>{upgrade_list.OLD_VERSION}
			                    	<input type="hidden" name="required_version" value="{upgrade_list.OLD_VERSION}">	                    	
			                    	<input type="hidden" name="old_version" value="{upgrade_list.OLD_VERSION}">
			                    </td>
			               	</tr>
			               	<tr>
			                	<th>{L_3500_1015713}</th>
			                    <td>{upgrade_list.NEW_VERSION}
			                    	<input type="hidden" name="new_version" value="{upgrade_list.NEW_VERSION}"></td>
			               	</tr>
			          	</tbody>
			     	</table>
			 	</div>
			</div>
		</div>
	</form>
	<!-- END upgrade_list -->
	<!-- IF PAGE -->
	<form id="upgrade" name="upgrade_details" action="{SITEURL}{ADMIN_FOLDER}/upgradescript.php" method="post">
		<input type="hidden" name="action" value="start_upgrading">
		<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
		<div class="box box-info">
				<div class="box-header">
		    	<h4 class="box-title">{L_3500_1015697}</h4>
			    <!-- tools box -->
		      	<div class="pull-right box-tools">
		        	<input type="submit" name="act" class="btn btn-sm btn-success" value="{L_3500_1015718}">
				</div>
				<div class="box-body table-responsive">
					<table class="table table-bordered">
				   		<tbody>
				        	<tr>
				             	<th colspan="2">{L_3500_1015709}</th>
				           	</tr>
				        	<!-- BEGIN upgrade_info-->
				           	<tr>
				             	<th width="17%">{L_3500_1015710}</th>
				              	<td>{upgrade_info.TITLE}</td>
				           	</tr>
			 	          	<tr>
				           		<th>{L_3500_1015711}</th>
				              	<td>{upgrade_info.INSTALLED_VERSION}</td>
				           	</tr>
							<tr>
				               	<th>{L_3500_1015712}</th>
				             	<td>{upgrade_info.OLD_VERSION}</td>
				           	</tr>
				           	<tr>
				              	<th>{L_3500_1015713}</th>
				             	<td>{upgrade_info.NEW_VERSION}</td>
				          	</tr>
				          	<tr>
				              	<th>{L_3500_1015726}</th>
				             	<td>{upgrade_info.SCRIPT_BITBUCKET}</td>
				           	</tr>
				          	<tr>
				               	<th>{L_3500_1015731}</th>
				           		<td>{upgrade_info.LANGUAGE_BITBUCKET}</td>
				           	</tr>
				           	<tr>
				             	<th>{L_1063}</th>
				            	<td>{upgrade_info.HELP}</td>
				          	</tr>
				          	<tr>
				             	<th>{L_3500_1015734}</th>
				             	<td>{upgrade_info.EXTRAS}</td>
				          	</tr>
				         	<tr>
				           		<th colspan="2">{L_3500_1015714}</th>
				         	</tr>
				           	<tr>
				             	<td colspan="2">{upgrade_info.DEC}</td>
				           	</tr>
				        	<!-- END upgrade_info-->
				      	</tbody>
				  	</table>
				</div>
			</div>
		</div>
		<div class="box box-info">
			<div class="box-header">
		    	<h4 class="box-title">{L_3500_1015715}</h4>
			  	<div class="box-body">
					<!-- BEGIN upgrade_dir -->
					<div class="col-md-4">
						<div class="box box-success">
							<div class="box-header">
								<h3 class="box-title"><b>{L_3500_1015716}</b> {upgrade_dir.FOLDER}</h3>
								<input type="hidden" name="folders[]" value="{upgrade_dir.FOLDER}">
								<div class="box-body table-responsive">
									<table class="table table-bordered table-hover">
										<thead>
											<tr>
												<th>{L_3500_1015717}</th>
											</tr>
										</thead>
										<tbody>
											<!-- BEGIN upgrade_pages -->
											<tr>
												<td>{upgrade_pages.PAGE}
													<input type="hidden" name="pages[]" value="{upgrade_pages.PAGE}">
												</td>
											</tr>
											<!-- END upgrade_pages -->
										</tbody>
									</table>
								</div> 
							</div> 	
						</div>
					</div>
					<!-- END upgrade_dir -->
				</div>
			</div>
		</div>
	</form>
	<!-- ENDIF -->
</div>

