<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="profile_feilds" action="" method="post">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{PAGENAME} <input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{L_530}"></h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
              	<tbody>
                	<tr>
                     	<td colspan="2"><b>{L_3500_1015641}</b></td>
                  	</tr>
                   	<tr>
                      	<td>{L_3500_1015642}</td>
                      	<td><input type="text" name="username_size" maxlength="2" value="{USERNAME_SIZE}"></td>
                   	</tr>
                   	<tr>
                      	<td>{L_3500_1015643}</td>
                      	<td><input type="text" name="password_size" maxlength="2" value="{PASSWORD_SIZE}"></td>
                   	</tr>
                   	<tr>
                    	<td colspan="2"><b>{L_3500_1015517}</b></td>
                   	</tr>
                  	<tr>
                       	<td>{L_781}</td>
                       	<td>
                           	{L_030} <input type="radio" name="birthdate" value="y" <!-- IF REQUIRED_0 -->checked="checked"<!-- ENDIF -->>
                        	{L_029} <input type="radio" name="birthdate" value="n" <!-- IF ! REQUIRED_0 -->checked="checked"<!-- ENDIF -->>
						</td>
                  	</tr>
                	<tr>
                      	<td>{L_780}</td>
                      	<td>
                           	{L_030} <input type="radio" name="birthdate_regshow" value="y" <!-- IF DISPLAYED_0 -->checked="checked"<!-- ENDIF -->>
                          	{L_029} <input type="radio" name="birthdate_regshow" value="n" <!-- IF ! DISPLAYED_0 -->checked="checked"<!-- ENDIF -->>
						</td>
                  	</tr>
                 	<tr>
                     	<td colspan="2"><b>{L_3500_1015518}</b></td>
                  	</tr>
                   	<tr>
                     	<td>{L_782}</td>
                       	<td>
                         	{L_030} <input type="radio" name="address" value="y" <!-- IF REQUIRED_1 -->checked="checked"<!-- ENDIF -->>
                          	{L_029} <input type="radio" name="address" value="n" <!-- IF ! REQUIRED_1 -->checked="checked"<!-- ENDIF -->>
                     	</td>
                  	</tr>
                  	<tr>
                     	<td>{L_780}</td>
                       	<td>
                           	{L_030} <input type="radio" name="address_regshow" value="y" <!-- IF DISPLAYED_1 -->checked="checked"<!-- ENDIF -->>
                          	{L_029} <input type="radio" name="address_regshow" value="n" <!-- IF ! DISPLAYED_1 -->checked="checked"<!-- ENDIF -->>
                      	</td>
                  	</tr>
                  	<tr>
                      	<td colspan="2"><b>{L_3500_1015519}</b></td>
                   	</tr>
                  	<tr>
                      	<td>{L_783}</td>
                       	<td>
                           	{L_030} <input type="radio" name="city" value="y" <!-- IF REQUIRED_2 -->checked="checked"<!-- ENDIF -->>
                          	{L_029} <input type="radio" name="city" value="n" <!-- IF ! REQUIRED_2 -->checked="checked"<!-- ENDIF -->>
                     	</td>
                	</tr>
                   	<tr>
                       	<td>{L_780}</td>
                       	<td>
                         	{L_030} <input type="radio" name="city_regshow" value="y" <!-- IF DISPLAYED_2 -->checked="checked"<!-- ENDIF -->>
                         	{L_029} <input type="radio" name="city_regshow" value="n" <!-- IF ! DISPLAYED_2 -->checked="checked"<!-- ENDIF -->>
                     	</td>
                  	</tr>
                   	<tr>
                      	<td colspan="2"><b>{L_3500_1015520}</b></td>
                  	</tr>
                  	<tr>
                      	<td>{L_784}</td>
                      	<td>
                          	{L_030} <input type="radio" name="prov" value="y" <!-- IF REQUIRED_3 -->checked="checked"<!-- ENDIF -->>
                         	{L_029} <input type="radio" name="prov" value="n" <!-- IF ! REQUIRED_3 -->checked="checked"<!-- ENDIF -->>
                      	</td>
                  	</tr>
                  	<tr>
                       	<td>{L_780}</td>
                      	<td>
                          	{L_030} <input type="radio" name="prov_regshow" value="y" <!-- IF DISPLAYED_3 -->checked="checked"<!-- ENDIF -->>
                           	{L_029} <input type="radio" name="prov_regshow" value="n" <!-- IF ! DISPLAYED_3 -->checked="checked"<!-- ENDIF -->>
                      	</td>
                   	</tr>
                  	<tr>
                      	<td colspan="2"><b>{L_3500_1015521}</b></td>
               		</tr>
                 	<tr>
                      	<td>{L_785}</td>
                       	<td>
                           	{L_030} <input type="radio" name="country" value="y" <!-- IF REQUIRED_4 -->checked="checked"<!-- ENDIF -->>
                         	{L_029} <input type="radio" name="country" value="n" <!-- IF ! REQUIRED_4 -->checked="checked"<!-- ENDIF -->>
                      	</td>
                   	</tr>
                  	<tr>
                      	<td>{L_780}</td>
                       	<td>
                           	{L_030} <input type="radio" name="country_regshow" value="y" <!-- IF DISPLAYED_4 -->checked="checked"<!-- ENDIF -->>
                          	{L_029} <input type="radio" name="country_regshow" value="n" <!-- IF ! DISPLAYED_4 -->checked="checked"<!-- ENDIF -->>
                      	</td>
                   	</tr>
                   	<tr>
                      	<td colspan="2"><b>{L_3500_1015522}</b></td>
                    </tr>
                  	<tr>
                       	<td>{L_786}</td>
                       	<td>
                          	{L_030} <input type="radio" name="zip" value="y" <!-- IF REQUIRED_5 -->checked="checked"<!-- ENDIF -->>
                          	{L_029} <input type="radio" name="zip" value="n" <!-- IF ! REQUIRED_5 -->checked="checked"<!-- ENDIF -->>
                       	</td>
                   	</tr>
                  	<tr>
                     	<td>{L_780}</td>
                       	<td>
                          	{L_030} <input type="radio" name="zip_regshow" value="y" <!-- IF DISPLAYED_5 -->checked="checked"<!-- ENDIF -->>
                          	{L_029} <input type="radio" name="zip_regshow" value="n" <!-- IF ! DISPLAYED_5 -->checked="checked"<!-- ENDIF -->>
                       	</td>
                   	</tr>
                  	<tr>
                       	<td colspan="2"><b>{L_3500_1015523}</b></td>
                  	</tr>
                   	<tr>
                      	<td>{L_787}</td>
                       	<td>
                          	{L_030} <input type="radio" name="tel" value="y" <!-- IF REQUIRED_6 -->checked="checked"<!-- ENDIF -->>
                           	{L_029} <input type="radio" name="tel" value="n" <!-- IF ! REQUIRED_6 -->checked="checked"<!-- ENDIF -->>
                     	</td>
                  	</tr>
                   	<tr>
                       	<td>{L_780}</td>
                      	<td>
                           	{L_030} <input type="radio" name="tel_regshow" value="y" <!-- IF DISPLAYED_6 -->checked="checked"<!-- ENDIF -->>
                          	{L_029} <input type="radio" name="tel_regshow" value="n" <!-- IF ! DISPLAYED_6 -->checked="checked"<!-- ENDIF -->>
                      	</td>
                	</tr>
             	</tbody>
         	</table>
		</div>
	</div>
</form>
