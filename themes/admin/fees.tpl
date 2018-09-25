<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<!-- IF FEETYPE ne '' -->
<form name="editFee" action="" method="post">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{FEETYPE} <input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{L_530}"></h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
            	<!-- IF B_SINGLE -->
               	<tbody>
                  	<tr>
                     	<td>{L_263}</td>
                    	<td><input type="text" size="12" name="value" value="{VALUE}"> {CURRENCY}</td>
               		</tr>
              	<!-- ELSE -->
              	<thead>
                   	<tr>
                      	<th>&nbsp;</th>
                       	<th>{L_240} ({CURRENCY})</th>
                      	<th>{L_241} ({CURRENCY})</th>
                       	<th>{L_391} ({CURRENCY})</th>
                      	<th>{L_392}</th>
                      	<th>{L_008}</th>
                   	</tr>
                </thead>
              	<tbody>
                  	<!-- BEGIN fees -->
                  	<tr>
                     	<td>&nbsp;</td>
                     	<td>
                           	<input type="hidden" name="tier_id[]" value="{fees.ID}">
                            <input name="fee_from[]" type="text" value="{fees.FROM}" size="9">
                       	</td>
                       	<td><input name="fee_to[]" type="text" value="{fees.TO}" size="9"></td>
                       	<td><input name="value[]" type="text" value="{fees.VALUE}" size="9"></td>
                       	<td>
                          	<select name="type[]">
                              	<option value="flat"{fees.FLATTYPE}>{L_393}</option>
                             	<option value="perc"{fees.PERCTYPE}>{L_357}</option>
                        	</select>
                       	</td>
                    	<td align="center"><input type="checkbox" name="fee_delete[]" value="{fees.ID}"></td>
                   	</tr>
                	<!-- END fees -->
                	<tr>
                      	<td>{L_394}</td>
                       	<td><input name="new_fee_from" type="text" size="9" value="{FEE_FROM}"></td>
                      	<td><input name="new_fee_to" type="text" size="9" value="{FEE_TO}"></td>
                      	<td><input name="new_value" type="text" size="9" value="{FEE_VALUE}"></td>
                       	<td>
                           	<select name="new_type">
                               	<option value="flat"<!-- IF FEE_TYPE eq 'flat' --> selected<!-- ENDIF -->>{L_393}</option>
                             	<option value="perc"<!-- IF FEE_TYPE eq 'perc' --> selected<!-- ENDIF -->>{L_357}</option>
                          	</select>
                       	</td>
                       	<td>&nbsp;</td>
                  	</tr>
            		<!-- ENDIF -->
              	</tbody>
         	</table>
		</div>
	</div>
</form>
<!-- ENDIF -->
<div class="panel panel-primary">
    <div class="panel-heading">
    	<h4 class="panel-title">{PAGENAME1}</h4>
    </div>
    <div class="panel-body">
		<table class="table table-bordered">
          	<tbody>
             	<tr>
                  	<td><a href="{SITEURL}{ADMIN_FOLDER}/fees.php?type=signup_fee">{L_430}</a></td>
                	<td><a href="{SITEURL}{ADMIN_FOLDER}/fees.php?type=banner_fee">{L_350_10133}</a></td>
              	</tr>
               	<tr>
                   	<td>&nbsp;</td>
                	<td><a href="{SITEURL}{ADMIN_FOLDER}/fees.php?type=ex_banner_fee">{L_350_10134}</a></td>
              	</tr>
           	</tbody>
     	</table>
	</div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
    	<h4 class="panel-title">{PAGENAME2}</h4>
    </div>
    <div class="panel-body">
		<table class="table table-bordered">
         	<tbody>
              	<tr>
               		<td><a href="{SITEURL}{ADMIN_FOLDER}/fees.php?type=setup">{L_432}</a> </td>
                 	<td><a href="{SITEURL}{ADMIN_FOLDER}/fees.php?type=relist_fee">{L_437}</a> </td>
              	</tr>
               	<tr>
                 	<td><a href="{SITEURL}{ADMIN_FOLDER}/fees.php?type=hpfeat_fee">{L_433}</a> </td>
                  	<td><a href="{SITEURL}{ADMIN_FOLDER}/fees.php?type=bolditem_fee">{L_439}</a> </td>
             	</tr>
             	<tr>
                 	<td><a href="{SITEURL}{ADMIN_FOLDER}/fees.php?type=hlitem_fee">{L_434}</a> </td>
                   	<td><a href="{SITEURL}{ADMIN_FOLDER}/fees.php?type=rp_fee">{L_440}</a> </td>
              	</tr>
               	<tr>
                  	<td><a href="{SITEURL}{ADMIN_FOLDER}/fees.php?type=picture_fee">{L_435}</a> </td>
                  	<td><a href="{SITEURL}{ADMIN_FOLDER}/fees.php?type=buyout_fee">{L_436}</a> </td>
              	</tr>
              	<tr>
                  	<td><a href="{SITEURL}{ADMIN_FOLDER}/fees.php?type=buyer_fee">{L_775}</a></td>
                 	<td><a href="{SITEURL}{ADMIN_FOLDER}/fees.php?type=endauc_fee">{L_791}</a></td>
              	</tr>
             	<tr>
                 	<td><a href="{SITEURL}{ADMIN_FOLDER}/fees.php?type=subtitle_fee">{L_803}</a></td>
                	<td><a href="{SITEURL}{ADMIN_FOLDER}/fees.php?type=excat_fee">{L_804}</a></td>
               	</tr>
              	<tr>
                  	<td><a href="{SITEURL}{ADMIN_FOLDER}/fees.php?type=geomap_fee">{L_3500_1015816}</a></td>
                	<td>&nbsp;</td>
              	</tr>
        	</tbody>
      	</table>
	</div>
</div>
