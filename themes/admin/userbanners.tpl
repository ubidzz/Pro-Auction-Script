<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<div class="panel panel-primary">
    <div class="panel-heading">
    	<h4 class="panel-title">{PAGENAME}</h4>
    </div>
    <div class="panel-body">
		<table class="table table-bordered">
        	<tbody>
            	<tr>
                	<td>{L_5180}</td>
                  	<td>{NAME}</td>
                  	<td><a href="editbannersuser.php?id={ID}"><img src="{SITEURL}themes/admin/images/bullet_wrench.png"></a></td>
              	</tr>
               	<tr>
                 	<td>{L__0022}</td>
                   	<td>{COMPANY}</td>
                  	<td>&nbsp;</td>
               	</tr>
               	<tr>
                	<td>{L_303}</td>
                  	<td>{EMAIL}</td>
                  	<td>&nbsp;</td>
              	</tr>
				<!-- BEGIN paidbanners-->
                <form name="paidbanner" action="{SITEURL}userbanners.php?id={ID}&activate=activate_acc" method="post" enctype="multipart/form-data">
              		<input type="hidden" name="activate" value="paid">
               		<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	               	<tr>
	                  	<td>{L_350_1012555}</td>
	                  	<td><!-- IF paidbanners.B_PAID -->
	                    	<input type="hidden" name="paid" value="1">
	  						<input type="submit" name="submit" class="btn btn-success" value="{L_350_1012555}">
							<!-- ELSE -->
							{L_350_10126}
							<!-- ENDIF -->
	                 	</td>
	                  	<td>&nbsp;</td>
	               	</tr>
             	</form>
               	<form name="paidextrabanner" action="{SITEURL}userbanners.php?id={ID}&activate=add_extra" method="post" enctype="multipart/form-data">
               		<input type="hidden" name="activate_extra" value="add_extra">
                 	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
                  	<tr>
                     	<td>{L_350_1015444}</td>
                       	<td>
                     		<!-- IF paidbanners.B_EX_PAID-->
                        	<input type="hidden" name="extra_banner_paid" value="2">
                          	<input type="submit" name="submit" class="btn btn-success" value="{L_350_1015444}">
                        	<!-- ELSE -->
                          	{L_350_10153}
                         	<!-- ENDIF -->
                      	</td>
                     	<td>&nbsp;</td>
                 	</tr>
              	</form>
              	<!-- END paidbanners-->
          	</tbody>
        </table>
	</div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
    	<h4 class="panel-title">{L__0043}</h4>
    </div>
    <div class="panel-body">
		<table class="table table-bordered">
         	<tbody>
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
                     	<a href="viewfilters.php?banner={banners.ID}&amp;id={ID}" class="new-window" alt="{L__0052}"><img src="{SITEURL}themes/admin/images/cog.png" alt="{L__0052}"></a>
                		<!-- IF NOTEDIT -->
                    	<a href="editbanner.php?banner={banners.ID}&amp;id={ID}"><img src="{SITEURL}themes/admin/images/application_form_edit.png" alt="{L__0055}"></a>
                     	<a href="deletebanner.php?banner={banners.ID}&amp;id={ID}"><img src="{SITEURL}themes/admin/images/bin.png" alt="{L_008}"></a>
                		<!-- ENDIF -->
                  	</td>
              	</tr>
            	<!-- END banners -->
          	</tbody>
      	</table>
	</div>
</div>
<form name="upldbanner" action="{SITEURL}userbanners.php?id={ID}&activate=insert" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="{ID}">
	<input type="hidden" name="banner" value="{BANNERID}">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{L__0040} <input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="<!-- IF NOTEDIT -->{L__0040}<!-- ELSE -->{L__0055}<!-- ENDIF -->"></h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
               	<tbody>
                  	<tr>
                     	<td>{L__0029}</td>
                     	<td><input type="file" name="bannerfile" size="40">{L__0042}<p>{L__0036}</p></td>
                   	</tr>
                   	<tr>
                    	<td>{L__0030}</td>
                      	<td><input type="text" name="url" SIZE="45" value="{URL}">{L__0042}<p>{L__0037}</p></td>
                  	</tr>
                   	<tr>
                       	<td>{L__0031}</td>
                     	<td><input type="text" name="sponsortext" SIZE="45" value="{SPONSORTEXT}"><p>{L__0038}</p></td>
                   	</tr>
                  	<tr>
                      	<td>{L__0032}</td>
                      	<td><input type="text" name="alt" SIZE="45" value="{ALT}"><p>{L__0038}</p></td>
                  	</tr>
                  	<tr>
                       	<td>{L__0045}</td>
                      	<td><input type="text" name="purchased" SIZE="8" value="{PURCHASED}"><p>{L__0046}</p></td>
                  	</tr>
                  	<tr>
                    	<td colspan="2">
                           	<p>{L__0033}</p>
                        	<p>{L__0039}</p>
                     	</td>
                 	</tr>
                 	<tr>
                       	<td>{L_276}</td>
                    	<td>{CATEGORIES}</td>
                   	</tr>
                  	<tr>
                      	<td>{L__0035}</td>
                     	<td><textarea name="keywords" cols="45" rows="8">{KEYWORDS}</textarea></td>
                  	</tr>
             	</tbody>
         	</table>
		</div>
	</div>
</form>
