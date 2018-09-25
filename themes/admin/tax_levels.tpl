<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="tax_edit" action="" method="post">
	<input type="hidden" name="tax_id" value="{TAX_ID}">
	<input type="hidden" name="action" value="add">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{PAGENAME} <input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{L_089}"></h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
               	<thead>
                  	<tr>
                       	<th>{L_1082}</th>
                      	<th>{L_1083}</th>
                       	<th>{L_1084}</th>
                     	<th>{L_1085}</th>
                  	</tr>
              	</thead>
              	<tbody>
                  	<tr>
                      	<td><input type="text" name="tax_name" value="{TAX_NAME}"></td>
                      	<td><input style="width:90%" type="text" name="tax_rate" value="{TAX_RATE}"> %</td>
                      	<td><select name="seller_countries[]" multiple>{TAX_SELLER}</select></td>
                     	<td><select name="buyer_countries[]" multiple>{TAX_BUYER}</select></td>
                 	</tr>
             	</tbody>
         	</table>
		</div>
	</div>
</form>
<form name="tax_update" action="" method="post">
	<input type="hidden" name="action" value="sitefee">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{L_1045}</h4>
	    </div>
	    <div class="panel-body">
			<table class="table">
              	<thead>
                  	<tr>
                       	<th>{L_1082}</th>
                      	<th>{L_1083}</th>
                      	<th>{L_1084}</th>
                      	<th>{L_1085}</th>
                      	<th>{L_1086}</th>
                      	<th>&nbsp;</th>
                   	</tr>
               	</thead>
               	<tbody>
                	<!-- BEGIN tax_rates -->
                    <tr>
                       	<td>{tax_rates.TAX_NAME}</td>
                       	<td>{tax_rates.TAX_RATE}%</td>
                     	<td>{tax_rates.TAX_SELLER}</td>
                      	<td>{tax_rates.TAX_BUYER}</td>
                       	<td><input type="radio" name="site_fee" value="{tax_rates.ID}"<!-- IF tax_rates.TAX_SITE_RATE eq 1 --> checked="checked"<!-- ENDIF -->></td>
                      	<td>
                          	<a href="tax_levels.php?id={tax_rates.ID}&type=edit">{L_298}</a><br>
							<a href="tax_levels.php?id={tax_rates.ID}&type=delete" onClick="return confirm('{L_1087}')">{L_008}</a>
                     	</td>
                 	</tr>
                  	<!-- END tax_rates -->
              	</tbody>
          	</table>
		</div>
	</div>
</form>
