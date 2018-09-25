<!-- INCLUDE user_menu_header.tpl -->
<div class="col-sm-9">
	<legend>{L_350_1012212}</legend>
	<form name="upldbanner" action="" method="post" enctype="multipart/form-data">
		<table class="table table-bordered table-condense table-striped">
			<tbody>
				<tr>
					<td>{L_5180}:</td>
                	<td>{NAME}</td>
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
					<td colspan="2"><a class="btn btn-sm btn-info" href="editbannersuser.php?id={ID}"><span class="glyphicon glyphicon-pencil"></span> {L_350_10150}</a></td>
				</tr>
			</tbody>
		</table>
		<table class="table table-bordered table-condense table-striped">
			<tbody>
				<tr>
					<th colspan="5">{L__0043}</th>
				</tr>
				<!-- BEGIN banners -->
				<tr>
					<td colspan="5">
						<!-- IF banners.TYPE eq 'swf' -->
						<object width="{banners.WIDTH}" height="{banners.HEIGHT}">
                         	<param name="movie" value="{SITEURL}{banners.BANNER}">
                         	<param name="quality" value="high">
                     		<embed src="{SITEURL}{banners.BANNER}" width="{banners.WIDTH}" height="{banners.HEIGHT}"></embed>
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
                       	<a href="editbanner.php?banner={banners.ID}&amp;id={ID}"><img src="{SITEURL}themes/{THEME}/banner/img/application_form_edit.png" alt="{L__0055}"></a>
                       	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="deletebanner.php?banner={banners.ID}&amp;id={ID}"><img src="{SITEURL}themes/{THEME}/banner/img/bin.png" alt="{L_008}"></a>
						<!-- ENDIF -->
                  	</td>
				</tr>
				<!-- END banners -->
			</tbody>
		</table>
		<table class="table table-bordered table-condense table-striped">
			<tbody>
				<tr>
					<th colspan="2"><!-- IF NOTEDIT -->{L__0041}<!-- ELSE -->{L__0055}<!-- ENDIF --></th>
				</tr>
				<tr>
                   	<td width="30%">{L__0029}</td>
                   	<td><input type="file" name="bannerfile" class="form-control">{L__0042} <span style="text-align:right; font-size:0.9em;" class="bannersize rounded-top rounded-bottom">{L_350_10123}</span><p>{L__0036}</p></td>
             	</tr>
               	<tr>
                	<td>{L__0030}</td>
                	<td><input type="text" name="url" class="form-control" value="{URL}">{L__0042}<p>{L__0037}</p></td>
             	</tr>
              	<tr>
                	<td>{L__0031}</td>
               		<td><input type="text" name="sponsortext" class="form-control" value="{SPONSORTEXT}"><p>{L__0038}</p></td>
              	</tr>
            	<tr>
                	<td>{L__0032}</td>
                  	<td><input type="text" name="alt" class="form-control" value="{ALT}"><p>{L__0038}</p></td>
             	</tr>
              	<tr>
                	<td>{L__0045}</td>
                	<td><input type="text" name="purchased" class="form-control" value="{PURCHASED}"><p>{L__0046}</p></td>
              	</tr>
              	<tr>
                	<td>{L__0035}</td>
                  	<td>
                 		<textarea name="keywords" class="form-control" cols="45" rows="8">{KEYWORDS}</textarea><br />
                    	{L_350_10151}
                    </td>
               	</tr>
			</tbody>
		</table>
		<input type="hidden" name="action" value="insert">
       	<input type="hidden" name="id" value="{ID}">
       	<input type="hidden" name="banner" value="{BANNERID}">
      	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
      	<button type="submit" name="submit" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-ok"></span> {L__0055}</button>
		<span><a class="btn btn-sm btn-info" href="{SITEURL}managebanners.php"><span class="glyphicon glyphicon-remove"></span> {L_350_1012222}</a></span>
	</form>
</div>