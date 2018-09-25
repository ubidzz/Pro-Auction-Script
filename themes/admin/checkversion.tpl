<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<div class="box box-info">
	<div class="box-header">
    	<h4 class="box-title">{VERSION_TITLE}</h4>
		<div class="box-body table-responsive">
			<table class="table table-bordered table-hover">
		      	<tbody>
		          	<tr>
		               	<td>{L_3500_1015473}</td>
		            	<td>{MYVERSION}</td>
		           	</tr>
		          	<tr>
		             	<td>{L_3500_1015474}</td>
		            	<td>{REALVERSION}</td>
		         	</tr>
		          	<tr>
		             	<td colspan="2">{TEXT}</td>
		        	</tr>
		     	</tbody>
			</table>
		</div>
	</div>
</div>
<div class="box box-info">
	<div class="box-header">
    	<h4 class="box-title">{REQUIREMENTS_TITLE}</h4>
    	<div class="box-body table-responsive">
	   		<table class="table table-bordered table-hover">
	        	<tbody>
	            	<tr>
	                	<td>{L_3500_1015648}</td>
	                    <td><!-- IF PHP_VERSION --><span style="color:green"><b>{CURRENT_PHP_VERSION}</b></span><!-- ELSE --><span style="color:red"><b>{CURRENT_PHP_VERSION}</b></span><!-- ENDIF --></td>
	               	</tr>
	                <tr>
	                    <td>{L_3500_1015649}</td>
	                    <td><!-- IF GD --><span style="color:green"><b>{L_2__0066}</b></span><!-- ELSE --><span style="color:red"><b>{L_2__0067}</b></span><!-- ENDIF --></td>
	               	</tr>
	               	<tr>
	               		<td>{L_3500_1015830}</td>
	               		<td><!-- IF FREETYPE --><span style="color:green"><b>{L_2__0066}</b></span><!-- ELSE --><span style="color:red"><b>{L_2__0067}</b></span><!-- ENDIF --></td>
	               	</tr>
	               	<tr>
	                    <td>{L_3500_1015650}</td>
	                    <td><!-- IF BCMATH --><span style="color:green"><b>{L_2__0066}</b></span><!-- ELSE --><span style="color:red"><b>{L_2__0067}</b></span><!-- ENDIF --></td>
	               	</tr>
					<tr>
	                    <td>{L_3500_1015651}</td>
	                    <td><!-- IF PDO --><span style="color:green"><b>{L_2__0066}</b></span><!-- ELSE --><span style="color:red"><b>{L_2__0067}</b></span><!-- ENDIF --></td>
	               	</tr>
	               	<tr>
	                    <td>{L_3500_1015652}</td>
	                    <td><!-- IF MBSTRING --><span style="color:green"><b>{L_2__0066}</b></span><!-- ELSE --><span style="color:red"><b>{L_2__0067}</b></span><!-- ENDIF --></td>
	               	</tr>
	               	<tr>
	                    <td>{L_3500_1015653}</td>
	                    <td><!-- IF HEADERS_SUPPORT --><span style="color:green"><b>{L_2__0066}</b></span><!-- ELSE --><span style="color:red"><b>{L_2__0067}</b></span><!-- ENDIF --></td>
	               	</tr>
	               	<tr>
	                    <td>{L_3500_1015796}</td>
	                    <td><!-- IF HASH_HMAC --><span style="color:green"><b>{L_2__0066}</b></span><!-- ELSE --><span style="color:red"><b>{L_2__0067}</b></span><!-- ENDIF --></td>
	               	</tr>
	               	<tr>
	                    <td>{L_3500_1015841}</td>
	                    <td><!-- IF OPENSSL --><span style="color:green"><b>{L_2__0066}</b></span><!-- ELSE --><span style="color:red"><b>{L_2__0067}</b></span><!-- ENDIF --></td>
	               	</tr>
	
	               	<tr>
	                    <td>{L_3500_1015654}</td>
	                    <td><!-- IF MCRYPT_ENCRYPT --><span style="color:green"><b>{L_2__0066}</b></span><!-- ELSE --><span style="color:red"><b>{L_2__0067}</b></span><!-- ENDIF --></td>
	               	</tr>
	               	<tr>
	                    <td>{L_3500_1015655}</td>
	                    <td><!-- IF OPEN_BASEDIR --><span style="color:red"><b>{L_2__0066}</b></span><!-- ELSE --><span style="color:green"><b>{L_2__0067}</b></span><!-- ENDIF --></td>
	               	</tr>
	               	<tr>
	                    <td>{L_3500_1015656}</td>
	                    <td><!-- IF ALLOW_URL_FOPEN --><span style="color:green"><b>{L_2__0066}</b></span><!-- ELSE --><span style="color:red"><b>{L_2__0067}</b></span><!-- ENDIF --></td>
	               	</tr>
	               	<tr>
	                    <td>{L_3500_1015657}</td>
	                    <td><!-- IF FOPEN --><span style="color:green"><b>{L_2__0066}</b></span><!-- ELSE --><span style="color:red"><b>{L_2__0067}</b></span><!-- ENDIF --></td>
	               	</tr>
					<tr>
	                    <td>{L_3500_1015658}</td>
	                    <td><!-- IF FREAD --><span style="color:green"><b>{L_2__0066}</b></span><!-- ELSE --><span style="color:red"><b>{L_2__0067}</b></span><!-- ENDIF --></td>
	               	</tr>
	               	<tr>
	                    <td>{L_3500_1015659}</td>
	                    <td><!-- IF FILE_GET_CONTENTS --><span style="color:green"><b>{L_2__0066}</b></span><!-- ELSE --><span style="color:red"><b>{L_2__0067}</b></span><!-- ENDIF --></td>
	               	</tr>
					<tr>
	                    <td>{L_3500_1015660}</td>
	                    <td><!-- IF CURL --><span style="color:green"><b>{L_2__0066}</b></span><!-- ELSE --><span style="color:red"><b>{L_2__0067}</b></span><!-- ENDIF --></td>
	               	</tr>
	          	</tbody>
	     	</table>
	     </div>
	</div>
</div>

