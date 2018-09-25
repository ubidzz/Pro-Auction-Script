<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="editAuction" action="" method="post">
	<input type="hidden" name="id" value="{ID}">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<div class="panel-title">
	    		{PAGENAME}
	    		<input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{L_089}">
	    		<!-- IF B_CANRELIST -->
                <input style="float:right" type="submit" name="relist" class="btn btn-xs btn-warning" value="{L_2__0051}">
                <!-- ENDIF -->
                <!-- IF B_CLOSE -->
                <input style="float:right" type="submit" name="closed" class="btn btn-xs btn-warning" value="{L_3500_1015501}">
                <!-- ENDIF -->
	    	</div>
	    </div>
			<table class="table table-bordered">
              	<tbody>
                  	<tr>
                       	<td>{L_313}</td>
                        <td>{USER}</td>
                    </tr>
                    <tr>
                      	<td>{L_017}</td>
                        <td><input class="form-control" type="text" name="title" size="40" maxlength="255" value="{TITLE}"></td>
                    </tr>
                    <tr>
                      	<td>{L_806}</td>
                        <td><input class="form-control" type="text" name="subtitle" size="40" maxlength="255" value="{SUBTITLE}"></td>
                    </tr>
                    <!-- IF B_CONDITION -->
                   	<tr>
                        <td>{L_103600}</td>
                        <td>
                        	<div class="input-group">
                        		{ITEM_CONDITION}
		  						<span class="input-group-btn"><a href="{SITEURL}meanings.php" class="btn btn-info" data-toggle="modal" data-target="#conditions">{L_104400}</a></span>
							</div>
						</td>
                    </tr>
                    <tr>
                        <td>{L_103700}</td>
                      	<td><input class="form-control" type="text" name="item_manufacturer" id="item_manufacturer" size="32" maxlength="32" value="{ITEM_MANUFACTURER}"></td>
                    </tr>
                    <tr>
                        <td>{L_103800}</td>
                      	<td><input class="form-control" type="text" name="item_model" id="item_model" size="32" maxlength="32" value="{ITEM_MODEL}"></td>
                    </tr>
                    <tr>
                        <td>{L_103900}</td>
                      	<td><input class="form-control" type="text" name="item_color" id="item_color" size="32" maxlength="32" value="{ITEM_COLOR}"></td>
                    </tr>
                    <tr>
                        <td>{L_104000}</td>
                     	<td><input type="text" name="item_year"  onkeypress="return isNumericKey(event)"  id="item_year" size="4" maxlength="4" value="{ITEM_YEAR}"></td>
                    </tr>
					<!-- ENDIF -->
                    <tr>
                        <td>{L_287}</td>
                      	<td>{CATLIST1}</td>
                    </tr>
                    <tr>
                        <td>{L_814}</td>
                       	<td>{CATLIST2}</td>
                    </tr>
                    <tr>
                        <td>{L_018}</td>
                       	<td>{DESC}</td>
                   	</tr>
                   	<tr>
                        <td>{L_258}</td>
                      	<td><input type="text" name="quantity" size="40" maxlength="40" value="{QTY}"></td>
                    </tr>
                   	<tr>
                        <td>{L_022}</td>
                       	<td>
                            <select name="duration">
                                <option value=""> </option>
                             	{DURLIST}
                          	</select>
                     	</td>
                    </tr>                           
                    <tr>
                      	<td colspan="2">{L_817}</td>
                    </tr>
                    <tr>
                       	<td>{L_257}</td>
                     	<td>{ATYPE}</td>
                    </tr>
              		<tr>
                        <td>{L_3500_1015744}</td>
                        <td>
                            <input type="radio" name="sellType" id="free_item_yes" value="free" {FREEITEM_Y}> {L_3500_1015745} 
                          	<input type="radio" name="sellType" id="free_item_no" value="sell" {FREEITEM_N}> {L_3500_1015746} 
                     	</td>
                    </tr>
                    <tr>
                        <td>{L_116}</td>
                      	<td>{CURRENT_BID}</td>
                    </tr>
                    <tr>
                       	<td>{L_124}</td>
                       	<td><input type="text" name="min_bid" size="40" maxlength="40" value="{MIN_BID}"></td>
         			</tr>
                    <tr>
                        <td>{L_023}</td>
                     	<td><input type="text" name="shipping_cost" size="40" maxlength="40" value="{SHIPPING_COST}"></td>
                    </tr>
                    <tr>
                        <td>{L_021}</td>
                      	<td><input type="text" name="reserve_price" size="40" maxlength="40" value="{RESERVE}"></td>
                    </tr>
                   	<tr>
                        <td>{L_30_0063}</td>
                        <td>
                            <input type="radio" name="buy_now_only" value="n" {BN_ONLY_N}> {L_029}
                        	<input type="radio" name="buy_now_only" value="y" {BN_ONLY_Y}> {L_030}
                     	</td>
                    </tr>
                    <tr>
                        <td>{L_497}</td>
                       	<td><input type="text" name="buy_now" size="40" maxlength="40" value="{BN_PRICE}"></td>
                    </tr>
                    <tr>
                        <td>{L_120}</td>
                     	<td><input type="text" name="customincrement" size="10" value="{CUSTOM_INC}"></td>
                   	</tr>
                   	<tr>
                     	<td colspan="2">{L_319}</td>
                    </tr>
                   	<tr>
                        <td>{L_025}</td>
                        <td>
                            <input type="radio" name="shipping" value="1" {SHIPPING1}>	{L_031}<br>
                            <input type="radio" name="shipping" value="2" {SHIPPING2}>	{L_032}<br>
                            <input type="checkbox" name="international" value="1" {INTERNATIONAL}> {L_033}<br>
                          	<input type="checkbox" name="returns" value="1" {RETURNS}> {L_025_E}
                      	</td>
                    </tr>
                    <tr>
                        <td>{L_25_0215}</td>
                    	<td><textarea name="shipping_terms" rows="3" cols="34">{SHIPPING_TERMS}</textarea></td>
                    </tr>
                   	<tr>
                    	<td colspan="2">{L_5233}</td>
                    </tr>
                    <tr>
                        <td>{L_026}</td>
                     	<td>{PAYMENTS}</td>
                    </tr>
                   	<!-- IF B_MKFEATURED or B_MKBOLD or B_MKHIGHLIGHT -->
               		<tr>
                        <td>{L_268}</td>
                       	<td>
                            <!-- IF B_MKFEATURED -->
							<p><input type="checkbox" name="is_featured" {IS_FEATURED}> {L_273}</p>
                    		<!-- ENDIF -->
                    		<!-- IF B_MKBOLD -->
                            <p><input type="checkbox" name="is_bold" {IS_BOLD}> {L_274}</p>
                    		<!-- ENDIF -->
                    		<!-- IF B_MKHIGHLIGHT -->
                            <p><input type="checkbox" name="is_highlighted" {IS_HIGHLIGHTED}> {L_292}</p>
                    		<!-- ENDIF -->
                    	</td>
                    </tr>
                    <!-- ENDIF -->
                    <tr>
                        <td>{L_300}</td>
                    	<td>{SUSPENDED}</td>
                 	</tr>
            	</tbody>
         	</table>
		</div>
</form>
<link href="{SITEURL}themes/{ADMIN_THEME}/css/lightbox.css" rel="stylesheet">
<script src="{SITEURL}themes/{ADMIN_THEME}/js/lightbox.js"></script>
<div class="panel panel-primary">
    <div class="panel-heading">
    	<h4 class="panel-title">{L_816}</h4>
    </div>
    <div class="panel-body">
    <!-- BEGIN gallery -->
		<div class="col-xs-6 col-md-3 col-lg-3">
      		<div class="thumbnail">
            	<a href="{SITEURL}{UPLOADEDPATH}{gallery.V}" data-lightbox="auction-set"><img src="{SITEURL}{UPLOADEDPATH}{gallery.V}"></a>
            </div>
        </div>
        <!-- END gallery -->
	</div>
</div>
<!-- Item Conditions Modal HTML -->
<div id="conditions" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>
