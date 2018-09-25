<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<div class="panel panel-primary">
    <div class="panel-heading">
    	<h4 class="panel-title">{L_3500_1015510}</h4>
    </div>
    <div class="panel-body">
		<table class="table table-bordered">
          	<tbody>
               	<tr>
                  	<td>{L_30_0224}</td>
                 	<td>{L_3500_1015512}</td>
                 	<td>
                     	<!-- IF B_SUB_ADMIN -->
                    	<form name="sub" action="" method="post" enctype="multipart/form-data">
                    		<input type="hidden" name="offset" value="{OFFSET}">
                    		<input type="hidden" name="admin" value="sub">
                    		<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
                          	<input type="submit" name="submit" class="btn btn-success" value="{L_3500_1015508}">
                       	</form>
                     	<!-- ELSE -->
                       	{L_30_0226}
                     	<!-- ENDIF -->
                 	</td>
              	</tr>
            	<tr>
                  	<td>{L_30_0225}</td>
                 	<td>{L_3500_1015511}</td>
                   	<td>
                  		<!-- IF B_MAIN_ADMIN or B_UPGRADE_ADMIN-->
                   		<form name="main" action="" method="post" enctype="multipart/form-data">
                    		<input type="hidden" name="offset" value="{OFFSET}">
                    		<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
                           	<input type="hidden" name="admin" value="main">
                           	<input type="submit" name="submit" class="btn btn-success" value="{L_3500_1015509}">
                     	</form>
						<!-- ELSE -->
						{L_30_0227}
						<!-- ENDIF -->
                  	</td>
              	</tr>
               	<tr>
                  	<td>{L_3500_1015506}</td>
                 	<td>{L_3500_1015513}</td>
                   	<td>
                      	<!-- IF B_UPGRADE_NORMAL -->
                     	<form name="normal" action="" method="post" enctype="multipart/form-data">
                    		<input type="hidden" name="offset" value="{OFFSET}">
                    		<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
                           	<input type="hidden" name="admin" value="normal">
                           	<input type="submit" name="submit" class="btn btn-success" value="{L_3500_1015506}">
                       	</form>
						<!-- ELSE -->
						{L_3500_1015507}
						<!-- ENDIF -->
                   	</td>
              	</tr>
          	</tbody>
     	</table>
	</div>
</div>
<form name="edit" action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="{ID}">
   	<input type="hidden" name="offset" value="{OFFSET}">
   	<input type="hidden" name="action" value="update">
  	<input type="hidden" name="idhidden" value="{ID}">
 	<input type="hidden" name="mode" value="{MODE}">
   	<input type="hidden" name="email_sent" value="{EMAIL_SENT}">
    <input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<div class="panel-title">
	    		{PAGENAME}
		    	<input type="submit" name="act" class="btn btn-xs btn-success" value="{L_071}"> 
                <a class="btn btn-xs btn-warning" href="{SITEURL}{ADMIN_FOLDER}/userfeedback.php?id={ID}">{L_208}</a> 
               	<a class="btn btn-xs btn-primary" href="{SITEURL}{ADMIN_FOLDER}/listusers.php">{L_285}</a>
	    	</div>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
              	<tbody>
                  	<tr>
                      	<td>{L_448}</td>
                      	<td>{USERGROUPS}</td>
                 	</tr>
                  	<tr>
                       	<td>{L_302} *</td>
                       	<td><input type="text" name="name" size="40" maxlength="255" value="{REALNAME}"></td>
                    </tr>
                  	<tr>
                    	<td>{L_003}</td>
                     	<td>{USERNAME}</td>
                   	</tr>
                   	<tr>
                     	<td>&nbsp;</td>
                      	<td>{L_243}</td>
                  	</tr>
                  	<tr class="bg">
		               	<td>{L_004} *</td>
		              	<td><input type="password" name="password" size="20" maxlength="20"></td>
		         	</tr>
		           	<tr class="bg">
		              	<td>{L_004} *</td>
		               	<td><input type="password" name="repeat_password" size="20" maxlength="20"></td>
		         	</tr>
		          	<tr>
		               	<td>{L_303} *</td>
		           		<td><input type="text" name="email" size="50" maxlength="50" value="{EMAIL}"></td>
		           	</tr>
		          	<tr>
		               	<td>{L_252}{REQUIRED(0)}</td>
		             	<td><input type="text" name="birthdate" size="10" maxlength="10" value="{DOB}"></td>
		           	</tr>
		          	<tr>
		              	<td>{L_009}{REQUIRED(1)}</td>
		               	<td><input type="text" name="address" size="40" maxlength="255" value="{ADDRESS}"></td>
		         	</tr>
		           	<tr>
		             	<td>{L_010}{REQUIRED(2)}</td>
		               	<td><input type="text" name="city" size="40" maxlength="255" value="{CITY}"></td>
		           	</tr>
		          	<tr>
		             	<td>{L_011}{REQUIRED(3)}</td>
		              	<td><input type="text" name="prov" size="40" maxlength="255" value="{PROV}"></td>
		           	</tr>
		           	<tr>
		                <td>{L_012}{REQUIRED(5)}</td>
		               	<td><input type="text" name="zip" size="15" maxlength="15" value="{ZIP}"></td>
		           	</tr>
		        	<tr>
		              	<td>{L_014}{REQUIRED(4)}</td>
		              	<td>
		                  	<select name="country">
		                        <option value=""></option>
		                       	{COUNTRY_LIST}
		                 	</select>
		              	</td>
		           	</tr>
		          	<tr>
		              	<td>{L_013}{REQUIRED(6)}</td>
		             	<td><input type="text" name="phone" size="40" maxlength="40" value="{PHONE}"></td>
		          	</tr>
		          	<tr>
		            	<td>{L_763}</td>
		             	<td><input type="text" name="balance" size="40" maxlength="10" value="{BALANCE}"></td>
		         	</tr>
             	</tbody>
        	</table>
		</div>
	</div>
</form>
