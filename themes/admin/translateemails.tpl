<div class="box box-info">
	<div class="box-heading">
		<h4 class="box-title">{L_3500_1015829}</h4>
	</div>
	<div class="box-body">
		<table class="table table-bordered">
			<thead>
				<!-- BEGIN languages -->
                <tr>
                    <th>Edit language emails using the form below.</th>
                	<th><a href="{SITEURL}{ADMIN_FOLDER}/editlangemails.php?country={languages.LANGS}"><img align="middle" src="{SITEURL}language/flags/{languages.LANG}.gif" border="0"></a></th>
               	</tr>
             	<!-- END languages -->
			</thead>
		</table>
	</div>
</div>
<!-- IF B_EDIT_FILE -->
<form name="editFile" action="{SITEURL}{ADMIN_FOLDER}/editlangemails.php?country={COUNTRY}{URL_PAGETYPE}&do=listfiles" method="post">
	<input type="hidden" name="action" value="edit">
	<input type="hidden" name="type" value="{PAGETYPE}">
	<input type="hidden" name="country" value="{COUNTRY}">
	<input type="hidden" name="filename" value="{FILENAME}">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="box box-info">
		<div class="box-heading">
			<h4 class="box-title">Edit Email File <input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{L_089}"></h4>
		</div>
		<div class="box-body">
			<table class="table table-bordered">
	       		<tbody>
	       			<tr>
	       				<td>Email type:</td>
	       				<td>{PAGETYPE}</td>
	       			</tr>
	            	<tr>
	                 	<td>{L_812}</td>
	                	<td><!-- IF FILENAME ne '' --><b>{FILENAME}</b><!-- ELSE --><input type="text" name="new_filename" value="" style="width:600px;"><!-- ENDIF -->
	              	</tr>
	               	<tr>
	                   	<td>{L_813}</td>
	                   	<!-- IF B_PAGETYPE -->
	                   	<td>{FILECONTENTS}</td>
	                   	<!-- ELSE -->
	                 	<td><h4><b>Do not use or add HTML tags in to the text emails.</b></h4><br><textarea class="form-control" style="height:400px;" name="content">{FILECONTENTS}</textarea></td>
	                 	<!-- ENDIF -->
	            	</tr>
	        	</tbody>
	      	</table>
		</div>
	</div>
</form>
<!-- ENDIF -->
<!-- IF B_COUNTRY -->
<form name="fileList" action="{SITEURL}{ADMIN_FOLDER}/editlangemails.php?country={COUNTRY}{URL_PAGETYPE}&do=listfiles" method="post">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<input type="hidden" name="action" value="updateEmail">
	<div class="box box-info">
		<div class="box-header">
			<h4 class="box-title">{D_COUNTRY} emails</h4>
		  	<div class="box-body table-responsive">
				<table class="table">
			       	<tbody>
			         	<tr>
			           		<td>Which files you wish to edit?
			                	<a class="btn btn-sm btn-success" href="{SITEURL}{ADMIN_FOLDER}/editlangemails.php?country={COUNTRY}&do=listfiles&emailtype=html">HTML Emails</a> <a class="btn btn-sm btn-success" href="{SITEURL}{ADMIN_FOLDER}/editlangemails.php?country={COUNTRY}&do=listfiles&emailtype=text">Text Emails</a>
			                </td>
			          	</tr>
			          	<!-- IF B_LISTFILES -->
			          	<tr>
			            	<td colspan="2">
			                	<h4><b>{D_COUNTRY} {PAGETYPE} emails files</b></h4>
			                  	<select name="file" multiple size="24" style="font-weight:bold; width:350px" ondblclick="this.form.submit();">
									<!-- BEGIN files -->
									<option value="{files.FILE}" {files.SELECTED}>{files.FILE}</option>
									<!-- END files -->
			                    </select>
			                </td>
			            </tr>
			            <!-- ENDIF -->
			        </tbody>
			    </table>
			</div>
		</div>
	</div>
</form>
<!-- ENDIF -->