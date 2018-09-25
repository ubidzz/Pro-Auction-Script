<!-- INCLUDE user_menu_header.tpl -->
<div class="col-sm-9 table-responsive">
	<legend>{L_350_1012212}</legend>
	<div class="alert alert-info" role="alert">
		<div>{L_350_10129}</div>
        <div> 
		<form name="" method="post" action="{SITEURL}pay.php?a=9" id="fees">
        	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
    		<input type="hidden" name="pfval" value="{ID}">
    		{L_350_10128}: {EX_BANNER_FEE} 
       		<input type="submit" name="Pay" value="{L_496}" class="btn btn-success btn-xs">
     	</form>
     	</div>
	</div>
     <table class="table table-bordered table-condense table-striped" width="98%" cellpadding="0" cellspacing="0">
        <tr>
           	<td width="10%" style="height: 19px">{L_5180}:</td>
            <td width="80%" style="height: 19px">{NAME}</td>
        </tr>
        <tr>
          	<td>{L__0022}:</td>
           	<td>{COMPANY}</td>
       	</tr>
      	<tr>
          	<td>{L_303}:</td>
            <td>{EMAIL}</td>
       	</tr>
        <tr>
         	<td width="30%"><a class="btn btn-sm btn-primary" href="editbannersuser.php?id={ID}"><span class="glyphicon glyphicon-pencil"></span> {L_350_10150}</a></td>
            <td></td>
        </tr>
   	</table>
   	<table class="table table-bordered table-condense table-striped" width="98%" cellpadding="0" cellspacing="0">
     	<tr>
         	<th colspan="5">{L__0043}</th>
      	</tr>
		<!-- BEGIN banners -->
        <tr>
      		<td colspan="5" align="center">
				<!-- IF banners.TYPE eq 'swf' -->
               	<object type="application/x-shockwave-flash" data="{SITEURL}{banners.BANNER}" width="{banners.WIDTH}" height="{banners.HEIGHT}">
              		<param name="quality" value="high">
                   	<param name="play" value="true">
                   	<param name="LOOP" value="true">
                   	<param name="wmode" value="transparent">
                   	<param name="allowScriptAccess" value="true">
              	</object>
				<!-- ELSE -->			
                <a target="_blank" href="{banners.URL}"><img border="0" alt="{banners.ALT}" src="{SITEURL}{banners.BANNER}"></a>
				<!-- ENDIF -->
    			<p><a target="_blank" href="{banners.URL}">{banners.SPONSERTEXT}</a></p>
       		</td>
      	</tr>
       	<tr>
           	<td>{L__0050} <strong><a target="_blank" href="{banners.URL}">{banners.URL}</a></strong></td>
           	<td>{L__0049} <strong>{banners.VIEWS}</strong></td>
           	<td>{L__0051} <strong>{banners.CLICKS}</strong></td>
           	<td>{L__0045}: <strong>{banners.PURCHASED}</strong></td>
          	<td align="center">
              	<!-- IF NOTEDIT -->
               	<a href="editbanner.php?banner={banners.ID}&amp;id={ID}" class="btn btn-sm btn-success">{L__0055}</a>
               	<a href="deletebanner.php?banner={banners.ID}&amp;id={ID}" class="btn btn-sm btn-danger">{L_008}</a>
				<!-- ENDIF -->
            </td>
       	</tr>
		<!-- END banners -->
   	</table>
</div>