<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="mascat" action="" method="post">
	<input type="hidden" name="parent" value="{PARENT}">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{L_3500_1015633} <input style="float:right" type="submit" name="action" class="btn btn-xs btn-success" value="{L_518}"></h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
            	<thead>
                    <tr>
                    	<th>&nbsp;</th>
                        <th>{L_087}</th>
                        <th>{L_328}</th>
                        <th>{L_329}</th>
                  	</tr>
              	</thead>
                <tbody>
                	<tr>
                    	<td>{L_394}</td>
                        <td><input type="text" name="new_category" size="25"></td>
                        <td><input type="text" name="cat_color" size="25"></td>
                        <td><input type="text" name="cat_image" size="25"></td>
                   	</tr>
                    <tr>
                    	<td>&nbsp;</td>
                        <td>{L_368}</td>
                        <td colspan="3"><textarea name="mass_add" cols="55" rows="6"></textarea></td>       
                   	</tr>
				</tbody>
			</table>
		</div>
	</div>
</form>
<form name="newcat" action="" method="post">
	<input type="hidden" name="parent" value="{PARENT}">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{PAGENAME} <input style="float:right" type="submit" name="action" class="btn btn-xs btn-success" value="{L_089}"></h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
            	<thead>
                	<tr>
                    	<th colspan="5">{L_845}</th>
                    </tr>
                    <tr>
                    	<th>&nbsp;</th>
                        <th>{L_087}</th>
                        <th>{L_328}</th>
                        <th>{L_329}</th>
                        <th>{L_008}</th>
                  	</tr>
              	</thead>
                <tbody>
                    <!-- BEGIN cats -->
                    <tr>
                   		<td><a href="categories.php?parent={cats.CAT_ID}"><img src="{SITEURL}images/plus.gif" border="0" alt="Browse Subcategories"></a></td>
                        <td><input type="text" name="categories[{cats.CAT_ID}]" value="{cats.CAT_NAME}" size="33"></td>
                        <td><input type="text" name="color[{cats.CAT_ID}]" value="{cats.CAT_COLOR}"></td>
                        <td><input type="text" name="image[{cats.CAT_ID}]" value="{cats.CAT_IMAGE}"></td>
                        <td>
	                        <input type="checkbox" name="delete[]" value="{cats.CAT_ID}" id="delete">
	    					<!-- IF cats.B_SUBCATS -->
	                        <img src="{SITEURL}themes/admin/images/bullet_blue.png">
	    					<!-- ENDIF -->
	    					<!-- IF cats.B_AUCTIONS -->
	                        <img src="{SITEURL}themes/admin/images/bullet_red.png">
	    					<!-- ENDIF -->
						</td>
                  	</tr>
                    <!-- END cats -->
                    <tr>
                    	<td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>{L_30_0102}</td>
                        <td><input type="checkbox" id="deleteall"></td>
                   	</tr>
            	</tbody>
          	</table>
		</div>
	</div>
</form>
