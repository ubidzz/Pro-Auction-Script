<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="newMineType" action="" method="post">
	<input type="hidden" name="action" value="new">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="box box-success">
		<div class="box-header">
	    	<h4 class="box-title">{L_3500_1015773}</h4>
	    	<!-- tools box -->
	       	<div class="pull-right box-tools">
	       		<input type="submit" name="act" class="btn btn-sm btn-success" value="{L_518}">
		  	</div>
		  	<div class="box-body">
				<table class="table table-hover table-striped">
		        	<tbody>
		            	<tr>
		            		<td align="center" colspan="4">{L_3500_1015779}</td>
		            	</tr>
		                <tr>
		                    <th>{L_302}</th>
		                	<th>{L_3500_1015771}</th>
		                 	<th>{L_3500_1015772}</th>
		                  	<th>{L_3500_1015777}</th>
		               	</tr>
		              	<tr>
		                 	<td><input class="form-control" type="text" name="name" value=""></td>
		                  	<td><input class="form-control" type="text" name="mine" value=""></td>
		                  	<td><input class="form-control" type="text" name="extension" value=""></td>
		                 	<td><input type="radio" name="used" value="y"> {L_030} 
		                  		<input type="radio" name="used" value="n" checked="checked"> {L_029}
		                  	</td>
		             	</tr>
		          	</tbody>
		      	</table>
		 	</div>
	   	</div>
	</div>
</form>
<form name="mineType" action="" method="post">
	<input type="hidden" name="action" value="edit">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="box box-primary">
		<div class="box-header">
	    	<h4 class="panel-title">{PAGENAME}</h4>
	    	<!-- tools box -->
	       	<div class="pull-right box-tools">
	       		<input type="submit" name="act" class="btn btn-sm btn-success" value="{L_530}">
		  	</div>
		  	<div class="box-body">
				<table class="table table-hover table-striped">
		            <tbody>
		            	<tr>
		            		<td align="center" colspan="4">{L_3500_1015779}</td>
		            	</tr>
		                <tr>
		                 	<th>{L_302}</th>
		                 	<th>{L_3500_1015771}</th>
		                  	<th>{L_3500_1015772}</th>
		                   	<th>{L_3500_1015777}</th>
		                   	<th>{L_008}</th>
		              	</tr>
		             	<!-- BEGIN mime_type -->
		              	<tr>
		                 	<td><input class="form-control" type="text" name="name[{mime_type.ID}]" value="{mime_type.NAME}"></td>
		                 	<td><input class="form-control" type="text" name="mine[{mime_type.ID}]" value="{mime_type.MINE}"></td>
		                	<td><input class="form-control" type="text" name="extension[{mime_type.ID}]" value="{mime_type.EXTENSION}"></td>
		                  	<td>
		                    	<input type="radio" id="yes" name="used[{mime_type.ID}]" value="y" {mime_type.USED_Y}> {L_030}
		                      	<input type="radio" id="no" name="used[{mime_type.ID}]" value="n" {mime_type.USED_N}> {L_029}
		                  	</td>
		                  	<td>
		                  		<input type="checkbox" name="delete[]" id="delete" value="{mime_type.ID}">
		                      	<input type="hidden" name="id[]" value="{mime_type.ID}">
		                  	</td>
		            	</tr>
		            	<!-- END mime_type -->
		            	<tr>
		            		<td></td>
		            		<td></td>
		            		<td>{L_30_0102}</td>
		            		<td>
		            			<input type="radio" id="yesall">{L_030}
		            			<input type="radio" id="noall" checked>{L_029}
		            		</td>
		                   	<td><input type="checkbox" id="deleteall"></td>
		            	</tr>
		         	</tbody>
		      	</table>
			</div>
		</div>
	</div>
</form>
