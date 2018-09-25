<!-- INCLUDE user_menu_header.tpl -->

<div class="col-sm-9 table-responsive">

	<legend>{L_350_1012212}</legend>

	<!-- IF ERROR ne '' -->

	<div class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {ERROR}</div>

	<!-- ENDIF -->

    <form name="upldbanner" action="" method="post" enctype="multipart/form-data"><br>

   		<table class="table table-bordered table-condense table-striped">

         	<tr>

            	<td width="30%">{L_5180}:</td>

               	<td>{NAME}</td>

            </tr>

            <tr>

             	<td width="30%">{L__0022}:</td>

              	<td>{COMPANY}</td>

         	</tr>

           	<tr>

            	<td width="30%">{L_303}:</td>

             	<td>{EMAIL}</td>

       		</tr>

         	<tr>

             	<td width="30%">

                	<a class="btn btn-success" href="editbannersuser.php?id={ID}">{L_350_10150}</a>

           		</td>

              	<td></td>

          	</tr>

     	</table>

        <table class="table table-bordered table-condense table-striped">

         	<tr>

            	<th colspan="5">{L__0043}</th>

          	</tr>

			<!-- BEGIN banners -->

          	<tr>

            	<td colspan="5" align="center"><br/><br/>

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

          	<tr><br><br>

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

      	

      	<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {IMAGESIZE}<p>{L__0036}</p></div>

      	<table class="table table-bordered table-condense table-striped">

          	<tr>

            	<th colspan="2"><!-- IF NOTEDIT -->{L__0041}<!-- ELSE -->{L__0055}<!-- ENDIF --></th>

          	</tr>

           	<tr>

             	<td width="30%">{L__0029}</td>

                <td class="has-feedback has-error">

                	<input type="file" class="form-control" name="bannerfile" size="40">

                	<span class="glyphicon glyphicon-asterisk form-control-feedback" aria-hidden="true"></span>

                </td>

           	</tr>

            <tr>

           		<td>{L__0030}</td>

             	<td class="has-feedback has-error">

             		<input type="text" name="url" SIZE="45" value="{URL}" class="form-control" placeholder="{L__0037}">

             		<span class="glyphicon glyphicon-asterisk form-control-feedback" aria-hidden="true"></span>

             	</td>

          	</tr>

          	<tr>

             	<td>{L__0031}</td>

              	<td class="has-feedback has-success">

              		<input type="text" class="form-control" name="sponsortext" value="{SPONSORTEXT}" placeholder="{L__0038}">

              		<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>

              	</td>

          	</tr>

          	<tr>

             	<td>{L__0032}</td>

             	<td class="has-feedback has-success">

             		<input type="text" class="form-control" name="alt" value="{ALT}" placeholder="{L__0038}">

             		<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>

             	</td>

          	</tr>

          	<tr>

            	<td>{L__0045}</td>

               	<td class="has-feedback has-success">

               		<input type="text" class="form-control" name="purchased" value="{PURCHASED}" placeholder="{L__0046}">

               		<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>

               	</td>

          	</tr>

           	<tr>

             	<td>{L__0035}</td>

              	<td class="has-feedback has-success">

              		<textarea name="keywords" class="form-control" rows="8">{KEYWORDS}</textarea>

              		<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>

              	</td>

          	</tr>

      	</table>

      	<input type="hidden" name="id" value="{ID}">

      	<input type="hidden" name="banner" value="{BANNERID}">

      	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">

      	<!-- IF B_BANNER_PAID -->

       	<input type="hidden" name="action" value="insert">

      	<input type="submit" name="act" class="btn btn-success" value="{L__0040}">

       	<!-- ENDIF -->

       	<!-- IF B_EXBANNER_PAID -->

      	<input type="hidden" name="action" value="insert">

       	<input type="submit" name="act" class="btn btn-success" value="{L__0040}">

       	<!-- ENDIF -->

		<span><a class="btn btn-danger" href="{SITEURL}managebanners.php">{L_350_1012222}</a></span>

	</form>

</div>

