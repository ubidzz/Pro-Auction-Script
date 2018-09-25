<!-- INCLUDE sell_js.tpl -->

<!-- IF PAGE eq 0 or PAGE eq 1 -->
<!-- IF ERROR ne '' -->

<div class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {ERROR}</div>

<!-- ENDIF -->
<!-- ENDIF -->


<div class="well">

  	<legend> {TITLE}</legend>

  	<a name="goto"></a>

  	<!-- IF PAGE eq 0 -->

  	<!-- INCLUDE upldgallery.tpl -->
  	<!-- IF B_SELL_DI -->
    <!-- INCLUDE digital_item.tpl -->
	<!-- ENDIF -->

  	<form id="myForm" name="sell" class="form-horizontal"  action="{SITEURL}sell.php" method="post" enctype="multipart/form-data">

    	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">

    	<div class="form-group">

      		<label class="col-sm-2 control-label">{L_287}</label>

        	<div style="padding:5px;"> {CAT_LIST1}

          		<!-- IF CAT_LIST2 ne '' -->

          		<br /><br />{CAT_LIST2}

          		<!-- ENDIF -->

          		<a href="{SITEURL}select_category.php?change=yes" class="btn btn-xs btn-success">{L_5113}</a>

    		</div>

    	</div>

    	<div class="form-group">

	      	<label class="col-sm-2 control-label">{L_017}</label>

	      	<div class="col-sm-5">

	       		<input class="form-control" type="text" name="auctionTitle" size="40" maxlength="70" value="{AUC_TITLE}">

	      	</div>

    	</div>

    	<!-- IF B_SUBTITLE -->

    	<div class="form-group">

      		<label class="col-sm-2 control-label">{L_806}</label>

      		<div class="col-sm-5">

        		<input class="form-control" type="text" name="subtitle" id="subtitle" size="40" maxlength="70" value="{AUC_SUBTITLE}">

      		</div>

    	</div>

    	<!-- ENDIF -->

    	<div class="form-group">

      		<label class="col-sm-2 control-label">{L_018}</label>

      		<div class="col-sm-10">

      			{AUC_DESCRIPTION}

         		<input type="hidden" name="imgtype" value="1">

        	</div>

        </div>

       	<div class="clear"></div>

    	<hr  />

    	<input type="hidden" name="imgtype" value="1">

		<!-- IF B_GALLERY -->	

		<div align="center">													

			{L_663}<br>

			<p>{MAXPICS}</p>

			<a class="btn btn-info btn-sm" href="#" data-toggle="modal" data-target="#imageUploader" data-content="{L_1049}" data-original-title="{L_677}" id="popover">

				<span class="glyphicon glyphicon-picture"></span> {L_677}

			</a>

    		<input type="hidden" name="numimages" value="{NUMIMAGES}" id="numimages">

		</div>	

		<!-- ENDIF -->

		<hr />

    	<div class="form-group">

      		<label class="col-sm-2 control-label">{L_257}</label>

      		<div class="col-sm-3">

      			{ATYPE}

      		</div>

    	</div>

    	<!-- IF B_FREEITEM -->

		<div class="form-group">

    		<label class="col-sm-2 control-label">{L_3500_1015744}</label>

	    	<div class="col-sm-5">

	    		<div class="radio">

		   			<label><input title="{L_3500_1015752}" data-toggle="tooltip" type="radio" name="sellType" id="free_item_yes" value="free" {FREEITEM_Y}>{L_3500_1015745}</label>

	        	</div>

	        	<div class="radio">

	        		<label><input title="{L_3500_1015753}" data-toggle="tooltip" type="radio" name="sellType" id="free_item_no" value="sell" {FREEITEM_N}>{L_3500_1015746}</label>

        		</div>

			</div>

    	</div>
		<hr />
    	<!-- ENDIF -->

    	<!-- IF B_SELL_DI -->

    	<div class="form-group hide1" {DIGITAL_ITEM}>

     		<label class="col-sm-2 control-label">{L_350_1010}</label>

      		<div class="col-sm-2">

      			<a href="#" data-toggle="modal" data-target="#uploadFile" class="btn btn-primary"><i class="fa fa-upload" aria-hidden="true"></i> {L_677_a}</a>

      		</div>

    	</div>

		<!-- ENDIF -->
	    
    	<div class="form-group hide9">

      		<label class="col-sm-2 control-label">{L_258}</label>

      		<div class="col-sm-2">

        		<input class="form-control" type="text" name="iquantity" id="iqty" size="5" value="{ITEMQTY}" {ITEMQTYD}>

      		</div>

    	</div>

    	<div class="form-group hide2">

	      	<label class="col-sm-2 control-label" id="minval_text">{MINTEXT}</label>

	      	<div class="col-sm-5">

	      		<div class="input-group">

	       			<input class="form-control" type="text" size="10" name="minimum_bid" id="min_bid" value="{MIN_BID}" {BID_PRICE}>

	       			<span class="input-group-addon">

	       				<a href="{SITEURL}converter.php" alt="converter" data-fancybox-type="iframe" class="converter">{CURRENCY}</a>

	       			</span> 

	       		</div>

	       	</div>

    	</div>

	    <div class="form-group hide3">

	    	<label class="col-sm-2 control-label">{L_023}</label>

	      	<div class="col-sm-5">

	      		<div class="input-group">

	        		<input class="form-control" type="text" size="10" name="shipping_cost" id="shipping_cost" value="{SHIPPING_COST}"<!-- IF SHIPPING1 eq '' -->disabled="disabled"<!-- ENDIF -->>

	        		<span class="input-group-addon">

	        			<a href="{SITEURL}converter.php" alt="converter" data-fancybox-type="iframe" class="converter">{CURRENCY}</a>

	        		</span> 

	        	</div>

	        </div>

	    </div>

	    <div class="form-group hide4">

	      	<label class="col-sm-2 control-label">{L_350_1008}</label>

	      	<div class="col-sm-5">

	      		<div class="input-group">

	        		<input class="form-control" data-toggle="tooltip" title="{L_3500_1015739}" type="text" size="10" name="additional_shipping_cost" id="additional_shipping_cost" value="{ADDITIONAL_SHIPPING_COST}" <!-- IF SHIPPING1 eq '' -->disabled="disabled"<!-- ENDIF -->>

	        		<span class="input-group-addon">

	        			<a href="{SITEURL}converter.php" alt="converter" data-fancybox-type="iframe" class="converter">{CURRENCY}</a>

	        		</span> 

	        	</div>

	        </div>

	    </div>

	    <div class="form-group hide5">

	     	<label class="col-sm-2 control-label">{L_021}</label>

	      	<div class="col-sm-3">

	      		<div class="input-group">

		        	<span class="input-group-addon">

				        <input type="radio" name="with_reserve" id="with_reserve_no" value="no" {RESERVE_N}> {L_029}

				    </span>

				    <span class="input-group-addon">

				        <input type="radio" name="with_reserve" id="with_reserve_yes" value="yes" {RESERVE_Y}> {L_030}

				    </span>
				</div>
				<div class="input-group">
				    <input class="form-control" type="text" name="reserve_price" id="reserve_price" size="10" value="{RESERVE}" {BN_ONLY}>

				    <span class="input-group-addon">

				        <a href="{SITEURL}converter.php" alt="converter" data-fancybox-type="iframe" class="converter">{CURRENCY}</a>

				    </span>

		        </div>

	        </div>

		</div>
		
		<!-- IF B_BN_ONLY -->

	    <div class="form-group hide6">

	      	<label class="col-sm-2 control-label">{L_30_0063}</label>

	      	<div class="col-sm-1">

		      	<div class="input-group">

		        	<span class="input-group-addon">

		        		<input type="radio" name="buy_now_only" value="n" {BN_ONLY_N} id="bn_only_no"> {L_029}

		        	</span>

		        	<span class="input-group-addon">

		        		<input type="radio" name="buy_now_only" value="y" {BN_ONLY_Y} id="bn_only_yes"> {L_030}

		        	</span>

		      	</div>

	      	</div>

	    </div>

	    <!-- ENDIF -->

	    <!-- IF B_BN -->

	    <div class="form-group hide7">

	      	<label class="col-sm-2 control-label">{L_496}</label>

	      	<div class="col-sm-3">

		      	<div class="input-group">

		        	<span class="input-group-addon">

		        		<input type="radio" name="buy_now" id="bn_no" value="no" {BN_N}> {L_029}

		        	</span>

		        	<span class="input-group-addon">

		        		<input type="radio" name="buy_now" id="bn_yes" value="yes" {BN_Y}> {L_030}

		        	</span>
				</div>
				<div class="input-group">
		        	<input class="form-control" type="text" name="buy_now_price" id="bn" size="10" value="{BN_PRICE}" {BN}>

		        	<span class="input-group-addon">

		        		<a href="{SITEURL}converter.php" alt="converter" data-fancybox-type="iframe" class="converter">{CURRENCY}</a> 

		        	</span>

		        </div>

		    </div>

	  	</div>

	    <!-- ENDIF -->

	    <!-- IF B_CUSINC -->

	    <div class="form-group hide8">

	      	<label class="col-sm-2 control-label">{L_120}</label>

	      	<div class="col-sm-10">

	      		<div class="radio">

		        	<label>

		        		<input type="radio" name="increments" id="inc1" value="1" {INCREMENTS1}> {L_614}

		        	</label>

		        </div>

		        <div class="radio">

		        	<label>

		       			<input type="radio" name="increments" id="inc2" value="2" {INCREMENTS2}> {L_615}

		       		</label>

		       	</div>

		       	<div class="col-xs-5 col-sm-4">

	       			<input class="form-control" type="text" name="customincrement" id="custominc" size="10" value="{CUSTOM_INC}" {INCREMENTS3}>

	       			<small>{CURRENCY}&nbsp;&nbsp;(<a href="{SITEURL}converter.php" alt="converter" data-fancybox-type="iframe" class="converter">{L_5010}</a>) </small> 

	       		</div>

	       	</div>

	   	</div>

	   	<!-- ELSE -->

	   	<input type="hidden" name="increments" id="inc1" value="1">

	   	<!-- ENDIF -->

    	<hr />

	   	<!-- IF B_EDIT_STARTTIME -->

	   	<div class="form-group">

	     	<label class="col-sm-2 control-label">{L_2__0016}</label>

	      	<div class="col-sm-5">

		      	<div class="input-group">

		       		<!-- IF B_EDITING -->

		        	<input type="text" class="form-control" name="start_now" id="disabledTextInput" value="{START_TIME}" disabled>

		        	<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>

		       		<!-- ELSE -->

		       		<span class="input-group-addon">

		       		{L_211}

		       		</span>

		       		<span class="input-group-addon">

		        		<input data-toggle="tooltip" title="{L_3500_1015740}" type="checkbox" name="start_now" {START_NOW}>

		        	</span>
		        </div>
			</div>
		</div>
		       			
		<!-- ENDIF -->

	   	<!-- ELSE -->

	    <input type="hidden" name="start_now" value="1">

	    <!-- ENDIF -->

	    <div class="form-group">

	      	<label class="col-sm-2 control-label">{L_022}</label>

	      	<div class="col-sm-2"> {DURATIONS} </div>

	    </div>
		
		<hr />
		
	    <div class="form-group hide10">

	      	<label class="col-sm-2 control-label">{L_025}</label>

	      	<div class="col-sm-10">

	      		<div class="col-xs-8 col-sm-5">

		        	<label class="radio ">

		        		<input type="radio" name="shipping" id="bps" value="1" {SHIPPING1}>{L_031}

		        	</label>

		        	<label class="radio ">

		        		<input type="radio" name="shipping" id="sps" value="2" {SHIPPING2}>{L_032}

		        	</label>

		        	<label class="checkbox ">

		        		<input type="checkbox" name="returns" id="returns" value="1" {RETURNS}>{L_025_E}

		        	</label>

		        	<label class="checkbox ">

		        		<input type="checkbox" name="international" value="1" {INTERNATIONAL}>{L_033}

		        	</label>

	        	</div>

	      	</div>

	    </div>

	   	<div class="form-group hide12">

	      	<label class="col-sm-2 control-label">{L_25_0215}</label>

	      	<div class="col-sm-5">

	        	<textarea class="form-control" name="shipping_terms" rows="3">{SHIPPING_TERMS}</textarea>

	      	</div>

	    </div>
			   	
	    <hr />

	    <div class="form-group hide11">

	      	<label class="col-sm-2 control-label">{L_026}</label>

	      	<div class="col-sm-10"> 

	      		<div class="col-xs-4 col-sm-3">

	      			{PAYMENTS} 

	      		</div>

	      	</div>

	    </div>
		
		<hr />
		
	   	<!-- IF B_MKFEATURED or B_MKBOLD or B_MKHIGHLIGHT -->

	   	<div class="form-group">

	      	<label class="col-sm-2 control-label">{L_268}</label>

	      	<div class="col-sm-10">

	       		<!-- IF B_MKFEATURED -->

	       		<div class="checkbox">

		       		<label>

		       			<input type="checkbox" name="is_featured" id="is_featured" value="y" {IS_FEATURED}> <b>{L_273}</b>

		       		</label>

	       		</div>

	       		<!-- ENDIF -->

	       		<!-- IF B_MKBOLD -->

	       		<div class="checkbox">

        		<label>

	        		<input type="checkbox" name="is_bold" id="is_bold" value="y" {IS_BOLD}> <b>{L_274}</b>

	        	</label>

	        	</div>

	        	<!-- ENDIF -->

	       		<!-- IF B_MKHIGHLIGHT -->

	       		<div class="checkbox">

		       		<label>

		       			<input type="checkbox" name="is_highlighted" id="is_highlighted" value="y" {IS_HIGHLIGHTED}> <b>{L_292}</b>

		       		</label>

	       		</div>

	       		<!-- ENDIF -->

	      	</div>

	   	</div>

	   	<!-- ENDIF  -->

	    <!-- IF B_AUTORELIST -->

	    <div class="form-group">

		    <label class="col-sm-2 control-label">{L__0161}</label>

			<div class="col-sm-2"> 

		    	{RELIST} 

		   	</div>

		</div>

	    <!-- ENDIF -->

	    <!-- IF B_CAN_TAX -->

	    <div class="form-group">

	      	<label class="col-sm-2 control-label">{L_1102}</label>

	      	<div class="col-sm-5">

	      	<div class="radio">

	      		<label><input type="radio" name="is_taxed" value="y" {TAX_Y}> {L_030}</label>

	        </div>

	        <div class="radio">

	      		<label><input type="radio" name="is_taxed" value="n" {TAX_N}> {L_029}</label>

	        </div>

	    </div>

	    </div>

	    <div class="form-group">

	      	<label class="col-sm-2 control-label">{L_1103}</label>

	      	<div class="col-sm-5">

	      		<div class="radio">

		      		<label><input type="radio" name="tax_included" value="y" {TAXINC_Y}> {L_030}</label>

	        	</div>

				<div class="radio">

		      		<label><input type="radio" name="tax_included" value="n" {TAXINC_N}> {L_029}</label>

	        	</div>

	      	</div>

	    </div>

	    <!-- ENDIF -->
	   	
	    <!-- IF B_FEES -->

	    <div class="form-group">

	     	<label class="col-sm-2 control-label">{L_263}</label>

	      	<div class="col-sm-5">

	        	<input type="hidden" name="fee_exact" id="fee_exact" value="{FEE_VALUE}">

	       		<p class="form-control-static"><span id="to_pay">{FEE_VALUE_F}</span> {CURRENCY}</p>

	       	</div>

	    </div>

	    <!-- ENDIF -->

	    <hr>

	    <div class="form-actions" align="center">

	      	<input type="hidden" value="3" name="action">

	      	<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> {L_5189}</button>

	      	<a href="{SITEURL}" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> {L_618}</a>

	    </div>

	</form>

	<!-- ELSEIF PAGE eq 2 -->

	<form name="preview" class="form-horizontal table-responsive" action="{SITEURL}sell.php" method="post">

	    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">

	    <table class="table table-bordered table-striped">

	      	<div class="alert alert-info">{L_046}</div>

	      	<tr>

	        	<td width="40%" align="right"  valign="top"><b>{L_017}</b></td>

	        	<td width="60%" >{TITLE}</td>

	      	</tr>

	      	<!-- IF B_SUBTITLE -->

	      	<tr>

	      	  	<td width="40%" align="right"  valign="top"><b>{L_806}</b></td>

	      	  	<td width="60%" >{SUBTITLE}</td>

	      	</tr>

	      	<!-- ENDIF -->

			<tr>

	        	<td  valign="top" align="right"><b>{L_018}</b></td>

	        	<td>{AUC_DESCRIPTION}</td>

	      	</tr>

	      	<tr>

		        <td  valign="top" align="right"><b>{L_019}</b></td>

		        <td>{MAINIMAGE}</td>

	      	</tr>

	      	<!-- IF B_GALLERY -->

	      	<tr>
				<td valign="top" align="right"><b>{L_663}</b></td>
	        	<td>
				
					<!-- BEGIN gallery -->

	          		<a href="{gallery.IMAGE}" data-fancybox-type="image" class="pics col-sm-2" style="width:120px; height:120px" rel="{gallery.K}">
	          			<img class="img-responsive img-thumbnail" src="{gallery.IMAGE}" alt="{gallery.K}">
	          		</a>

	          		<!-- END gallery -->

	        	</td>

	      	</tr>

	      	<!-- ENDIF -->
			
	      	<!-- IF ATYPE_PLAIN eq '3' -->

			<tr>

				<td valign="top" align="right"><b>{L_350_10173}</b></td>

				<td>
	      			<!-- BEGIN d_items-->
					<div class="alert alert-success" role="alert"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {d_items.ITEM}</div>
	        		<!-- END d_items-->

	    		</td>

			</tr>
			<!-- IF B_BN -->

	      	<tr>

	        	<td valign="top" align="right"><b>{L_496}</b></td>

	        	<td>{BN_PRICE}</td>

	      	</tr>

	      	<!-- ENDIF -->


			<!-- ENDIF -->
			
	      	<!-- IF ATYPE_PLAIN eq '1' -->
			
			<tr>
				<td valign="top" align="right"><b>{MINTEXT}</b></td>
				<td>{MIN_BID}</td>
			</tr>
	      	<!-- IF B_BN_ONLY -->

	     	<tr>

	        	<td valign="top" align="right"><b>{L_021}</b></td>

	        	<td>{RESERVE}</td>

	      	</tr>

	      	<!-- ENDIF -->

	      	<!-- IF B_BN -->

	      	<tr>

	        	<td valign="top" align="right"><b>{L_496}</b></td>

	        	<td>{BN_PRICE}</td>

	      	</tr>

	      	<!-- ENDIF -->

	      	<!-- ENDIF -->

	      	<tr>

	        	<td valign="top" align="right"><b>{L_023}</b></td>

	        	<td>{SHIPPING_COST}</td>

	      	</tr>

	      	<tr>

	        	<td valign="top" align="right"><b>{L_2__0016}</b></td>

	        	<td>{STARTDATE}</td>

	      	</tr>

	      	<tr>

	        	<td valign="top" align="right"><b>{L_022}</b></td>

	        	<td>{DURATION}</td>

	      	</tr>
	      	<!-- IF B_RELIST -->
	      	<tr>

	        	<td valign="top" align="right"><b>{L__0161}</b></td>

	        	<td>{RELIST}</td>

	      	</tr>
			<!-- ENDIF -->

	      	<!-- IF B_CUSINC -->

	      	<tr>

	        	<td valign="top" align="right"><b>{L_120}</b> </td>

	        	<td>{INCREMENTS}</td>

	      	</tr>

	      	<!-- ENDIF -->

	      	<tr>

	        	<td valign="top" align="right"><b>{L_261}</b> </td>

	        	<td>{ATYPE}</td>

	      	</tr>

	      	<tr>

	        	<td valign="top" align="right"><b>{L_025}</b></td>

	        	<td>

	        		{SHIPPING}<br>

	          		{INTERNATIONAL}

	          	</td>

	      	</tr>

	      	<tr> 

	        	<td valign="top" align="right"><b>{L_025_C}</b></td> 

	    		<td>{RETURNS}</td> 

		  	</tr>

	      	<tr>

	        	<td align="right" valign="top"><b>{L_25_0215}</b></td>

	        	<td>{SHIPPING_TERMS}</td>

	      	</tr>

	      	<tr>

	        	<td valign="top" align="right"><b>{L_026}</b> </td>

	        	<td>{PAYMENTS_METHODS}</td>

	      	</tr>

	      	<tr>

	        	<td  valign="top" align="right"><b>{L_027}</b></td>

	        	<td> 

	        		{CAT_LIST1}

	          		<!-- IF CAT_LIST2 ne '' -->

	          		<br>{CAT_LIST2}

	          		<!-- ENDIF -->

	        	</td>

	      	</tr>
	      	<!-- IF B_MKFEATURED or B_MKBOLD or B_MKHIGHLIGHT -->
	      	<tr>
	      		<td valign="top" align="right"><b>{L_268}</b></td>
	      		<td>
	      			<!-- IF B_MKFEATURED -->
	      			<p>{L_273} <b>({FEATURED})</b></p>
	      			<!-- ENDIF -->
	      			<!-- IF B_MKBOLD -->
	      			<p>{L_274} <b>({BOLD})</b></p>
	      			<!-- ENDIF -->
	      			<!-- IF B_MKHIGHLIGHT -->
	      			<p>{L_292} <b>({HIGHLIGHTED})</b></p>
	      			<!-- ENDIF -->
	      		</td>
	      	</tr>
	      	<!-- ENDIF -->

	      	<!-- IF B_FEES -->

	      	<tr>

	        	<td valign="top" align="right"><b>{L_263}</b> </td>

	        	<td>{FEE}</td>

	      	</tr>

	      	<!-- ENDIF -->

	      	<tr> </tr>

	      	<!-- IF B_USERAUTH -->

	      	<tr>

	        	<td align="right"><b>{L_003}</b></td>

	        	<td>

	        		<b>{YOURUSERNAME}</b>

	          		<input type="hidden" name="nick" value="{YOURUSERNAME}">

	          	</td>

	      	</tr>

	      	<tr>

	        	<td align="right"><b>{L_004}</b></td>

	        	<td><input type="password" class="form-control" name="password" value=""></td>

	      	</tr>

	      	<!-- ENDIF -->

		</table>

	    <div class="alert alert-info">{L_046}</div>

	    <div class="form-actions">

	      <input type="hidden" value="4" name="action">

	      <input type="submit" name="" value="{L_2__0037}" class="btn btn-primary">

	    </div>

	</form>

  	<!-- ELSEIF PAGE eq 3 -->

  	<div style="text-align:center">

    	<p><!-- IF B_EMAIL -->{L_100}<!-- ELSE -->{L_100_b}<!-- ENDIF -->

    	{L_101}:&nbsp;&nbsp;<a href="{SITEURL}products/{SEO_TITLE}-{AUCTION_ID}">{SITEURL}products/{SEO_TITLE}-{AUCTION_ID}</a><br>

    	{MESSAGE}<br><br>

    	<a class="btn btn-success" href="{SITEURL}edit_active_auction.php?id={AUCTION_ID}">{L_30_0069}</a> <a class="btn btn-info" href="{SITEURL}sellsimilar.php?id={AUCTION_ID}">{L_2__0050}</a>

    	<p> 

  	</div>

  	<!-- ENDIF -->

</div>

