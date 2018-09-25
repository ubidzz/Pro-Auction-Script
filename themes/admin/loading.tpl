<!-- IF ERROR ne '' -->

<div class="alert alert-info alert-dismissible">

	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>

</div>

<!-- ENDIF -->
<form id="updatePageg" name="updatePageg" action="{SITEURL}{ADMIN_FOLDER}/loading.php" method="post" enctype="multipart/form-data">

		<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">

		<input type="hidden" name="action" value="UpdatePage">

		<div class="box box-info">

			<div class="box-header">

		    	<h4 class="box-title">{L_3500_1015989}</h4>

		    	<!-- tools box -->

		       	<div class="pull-right box-tools">
					<a href="{SITEURL}admin/upgradescript.php" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i> {L_285}</a>
		       		<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-download" aria-hidden="true"></i> {L_350_10177}</button>

			  	</div>

				<div class="box-body table-responsive">

					<table class="table table-hover table-striped">

				       	<tbody>

				       		<tr>

				       			<td colspan="2">{L_3500_1015998}</td>

				       		</tr>

				            <tr>

				                 <td>{L_30_0214}:</td>

				                 <td>

				                 	<select name="version" class="form-control">

				                 		{VERSIONS}

				                 	</select>

				                 </td>

				            </tr>

				       	</tbody>

					</table>

				</div>

			</div>

		</div>

	</form>

	