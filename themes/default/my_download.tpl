<!-- INCLUDE user_menu_header.tpl -->
<div class="col-sm-9 table-responsive">
  	<legend> {L_3500_1015430}</legend>
  	<table class="table table-bordered table-striped table-condensed">
    	<!-- BEGIN items -->
    	<tr>
      		<td colspan="6"> {L_458} <b><a href="{SITEURL}products/{items.SEO_TITLE}-{items.AUC_ID}" target="_blank">{items.TITLE}</a></b> (ID: <a href="{SITEURL}products/{items.SEO_TITLE}-{items.AUC_ID}" target="_blank">{items.AUC_ID}</a>) </td>
    	</tr>
    	<tr>
      		<th class="col-sm-5">{L_125}</th>
      		<th>{L_460}</th>
      		<th class="col-sm-2"><!-- IF items.B_DIGITAL_ITEM -->{L_350_10026}<!-- ENDIF --></th>
      		<th class="col-sm-2"> {L_755}</th>
    	</tr>
    	<tr>
      		<td> {items.SELLNICK}<br><small>{items.FB_LINK}</small> </td>
      		<td><small><a href="mailto:{items.SELLEMAIL}">{items.SELLEMAIL}</a></small> </td>
      		<td>
      			<!-- IF items.B_DIGITAL_ITEM_PAID -->
    			<a class="btn btn-success btn-sm" href="{SITEURL}my_downloads.php?diupload=3&fromfile={items.DIGITAL_ITEM}"><span class="glyphicon glyphicon-save"></span> {L_350_10177}</a>
    			<!-- ELSE -->
    			{L_3500_1015431}
    			<!-- ENDIF -->
      		</td>
      		<td>
        		<!-- IF items.B_PAID -->
        		{L_755}
        		<!-- ELSE -->
        		<form name="" method="post" action="{SITEURL}pay.php?a=10" id="fees">
          			<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
          			<input type="hidden" name="pfval" value="{items.ID}">
          			<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> {L_756}</button>
        		</form>
        		<!-- ENDIF -->
      		</td>
    	</tr>
    	<!-- END items -->
  	</table>
    <ul class="pagination">
      {PREV}
      <!-- BEGIN pages -->
      {pages.PAGE}
      <!-- END pages -->
      {NEXT}
    </ul>
</div>