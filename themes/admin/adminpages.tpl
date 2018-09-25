<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="conf" action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="box box-info">
		<div class="box-header">
	    	<h4 class="box-title">{PAGENAME}</h4>
	    	<!-- tools box -->
	        <div class="pull-right box-tools">
	        	<input class="btn btn-sm btn-success" type="submit" name="act" value="{L_530}">
		  	</div>
		 	<div class="box-body table-responsive">
			 	<table class="table table-hover table-striped">
			    	<!-- BEGIN block -->
			   		<tbody>
				    	<tr>
							<!-- IF block.B_HEADER -->
							<td colspan="2" style="padding:3px; border-top:#0083D7 1px solid; background:#ECECEC;">
								<b>{block.TITLE}</b>
							</td>
							<!-- ELSE -->
							<td width="175">{block.TITLE}</td>
							<td style="padding:3px;">
								{block.DESCRIPTION}
								<!-- IF block.TYPE eq 'yesno' -->
								<input type="radio" name="{block.NAME}" value="y"<!-- IF block.DEFAULT eq 'y' --> checked<!-- ENDIF -->> {block.TAGLINE1}
								<input type="radio" name="{block.NAME}" value="n"<!-- IF block.DEFAULT eq 'n' --> checked<!-- ENDIF -->> {block.TAGLINE2}
								<!-- ELSEIF block.TYPE eq 'batch' -->
								<input type="radio" name="{block.NAME}" value="1"<!-- IF block.DEFAULT eq '1' --> checked<!-- ENDIF -->> {block.TAGLINE1}
								<input type="radio" name="{block.NAME}" value="2"<!-- IF block.DEFAULT eq '2' --> checked<!-- ENDIF -->> {block.TAGLINE2}
								<!-- ELSEIF block.TYPE eq 'batchstacked' -->
								<input type="radio" name="{block.NAME}" value="1"<!-- IF block.DEFAULT eq '1' --> checked<!-- ENDIF -->> {block.TAGLINE1}
								<br><input type="radio" name="{block.NAME}" value="2"<!-- IF block.DEFAULT eq '2' --> checked<!-- ENDIF -->> {block.TAGLINE2}	
								<!-- ELSEIF block.TYPE eq 'datestacked' -->
								<input type="radio" name="{block.NAME}" value="USA"<!-- IF block.DEFAULT eq 'USA' --> checked<!-- ENDIF -->> {block.TAGLINE1}
								<br><input type="radio" name="{block.NAME}" value="EUR"<!-- IF block.DEFAULT eq 'EUR' --> checked<!-- ENDIF -->> {block.TAGLINE2}	
								<!-- ELSEIF block.TYPE eq 'select3num' -->
								<input type="radio" name="{block.NAME}" value="0"<!-- IF block.DEFAULT eq '0' --> checked<!-- ENDIF -->> {block.TAGLINE1}<br>
								<input type="radio" name="{block.NAME}" value="1"<!-- IF block.DEFAULT eq '1' --> checked<!-- ENDIF -->> {block.TAGLINE2}<br>
								<input type="radio" name="{block.NAME}" value="2"<!-- IF block.DEFAULT eq '2' --> checked<!-- ENDIF -->> {block.TAGLINE3}<br>
								<!-- ELSEIF block.TYPE eq 'select4num' -->
								<input type="radio" name="{block.NAME}" value="0"<!-- IF block.DEFAULT eq '0' --> checked<!-- ENDIF -->> {block.TAGLINE1}<br>
								<input type="radio" name="{block.NAME}" value="1"<!-- IF block.DEFAULT eq '1' --> checked<!-- ENDIF -->> {block.TAGLINE2}<br>
								<input type="radio" name="{block.NAME}" value="2"<!-- IF block.DEFAULT eq '2' --> checked<!-- ENDIF -->> {block.TAGLINE3}<br>
								<input type="radio" name="{block.NAME}" value="3"<!-- IF block.DEFAULT eq '3' --> checked<!-- ENDIF -->> {block.TAGLINE4}<br>
								<!-- ELSEIF block.TYPE eq 'select5num' -->
								<input type="radio" name="{block.NAME}" value="0"<!-- IF block.DEFAULT eq '0' --> checked<!-- ENDIF -->> {block.TAGLINE1}<br>
								<input type="radio" name="{block.NAME}" value="1"<!-- IF block.DEFAULT eq '1' --> checked<!-- ENDIF -->> {block.TAGLINE2}<br>
								<input type="radio" name="{block.NAME}" value="2"<!-- IF block.DEFAULT eq '2' --> checked<!-- ENDIF -->> {block.TAGLINE3}<br>
								<input type="radio" name="{block.NAME}" value="3"<!-- IF block.DEFAULT eq '3' --> checked<!-- ENDIF -->> {block.TAGLINE4}<br>
								<input type="radio" name="{block.NAME}" value="4"<!-- IF block.DEFAULT eq '4' --> checked<!-- ENDIF -->> {block.TAGLINE5}<br>
								<!-- ELSEIF block.TYPE eq 'select5num' -->
								<input type="radio" name="{block.NAME}" value="0"<!-- IF block.DEFAULT eq '0' --> checked<!-- ENDIF -->> {block.TAGLINE1}<br>
								<input type="radio" name="{block.NAME}" value="1"<!-- IF block.DEFAULT eq '1' --> checked<!-- ENDIF -->> {block.TAGLINE2}<br>
								<input type="radio" name="{block.NAME}" value="2"<!-- IF block.DEFAULT eq '2' --> checked<!-- ENDIF -->> {block.TAGLINE3}<br>
								<input type="radio" name="{block.NAME}" value="3"<!-- IF block.DEFAULT eq '3' --> checked<!-- ENDIF -->> {block.TAGLINE4}<br>
								<input type="radio" name="{block.NAME}" value="4"<!-- IF block.DEFAULT eq '4' --> checked<!-- ENDIF -->> {block.TAGLINE5}<br>
								<input type="radio" name="{block.NAME}" value="5"<!-- IF block.DEFAULT eq '5' --> checked<!-- ENDIF -->> {block.TAGLINE6}<br>
								<!-- ELSEIF block.TYPE eq 'select3contact' -->
								<input type="radio" name="{block.NAME}" value="always"<!-- IF block.DEFAULT eq 'always' --> checked<!-- ENDIF -->> {block.TAGLINE1}<br>
								<input type="radio" name="{block.NAME}" value="logged"<!-- IF block.DEFAULT eq 'logged' --> checked<!-- ENDIF -->> {block.TAGLINE2}<br>
								<input type="radio" name="{block.NAME}" value="never"<!-- IF block.DEFAULT eq 'never' --> checked<!-- ENDIF -->> {block.TAGLINE3}<br>
								<!-- ELSEIF block.TYPE eq 'text' -->
								<input class="form-control" type="text" name="{block.NAME}" value="{block.DEFAULT}" size="50" maxlength="255">
								<!-- ELSEIF block.TYPE eq 'password' -->
								<input class="form-control" type="password" name="{block.NAME}" value="{block.DEFAULT}">
								<!-- ELSEIF block.TYPE eq 'textarea' -->
								<textarea name="{block.NAME}" cols="65" rows="10">{block.DEFAULT}</textarea>
								<!-- ELSEIF block.TYPE eq 'days' -->
								<input type="text" name="{block.NAME}" value="{block.DEFAULT}" size="4" maxlength="4"> {block.TAGLINE1}
								<!-- ELSEIF block.TYPE eq 'percent' -->
								<input type="text" name="{block.NAME}" value="{block.DEFAULT}" size="3" maxlength="3"> {block.TAGLINE1}
								<!-- ELSEIF block.TYPE eq 'decimals' -->
								<input type="text" name="{block.NAME}" value="{block.DEFAULT}" size="5" maxlength="10"> {block.TAGLINE1}
								<!-- ELSEIF block.TYPE eq 'yesnostacked' -->
								<input type="radio" name="{block.NAME}" value="y"<!-- IF block.DEFAULT eq 'y' --> checked<!-- ENDIF -->> {block.TAGLINE1}
								<br><input type="radio" name="{block.NAME}" value="n"<!-- IF block.DEFAULT eq 'n' --> checked<!-- ENDIF -->> {block.TAGLINE2}
								<!-- ELSEIF block.TYPE eq 'sortstacked' -->
								<input type="radio" name="{block.NAME}" value="alpha"<!-- IF block.DEFAULT eq 'alpha' --> checked<!-- ENDIF -->> {block.TAGLINE1}
								<br><input type="radio" name="{block.NAME}" value="counter"<!-- IF block.DEFAULT eq 'counter' --> checked<!-- ENDIF -->> {block.TAGLINE2}
								<!-- ELSEIF block.TYPE eq 'checkbox' -->
								<input type="checkbox" name="{block.NAME}" id="{block.DEFAULT}" value="y"<!-- IF block.DEFAULT eq 'y' --> checked<!-- ENDIF -->> {block.TAGLINE1}
								<!-- ELSEIF block.TYPE eq 'dropdown' -->
								<div class="Browse">
									{DROPDOWN}
								</div>
								<!-- ELSEIF block.TYPE eq 'upload' -->
								<input type="file" name="{block.NAME}" size="25" maxlength="100">
								<input type="hidden" name="MAX_FILE_SIZE" value="51200">
								<!-- ELSEIF block.TYPE eq 'image' -->
								<img src="{IMAGEURL}">{block.TAGLINE1}<br>
								<!-- ELSEIF block.TYPE eq 'link' -->
								<a href="{LINKURL}">{block.TAGLINE1}</a>
								<!-- ELSE -->
								{block.TYPE}
								<!-- ENDIF -->
							</td>
							<!-- ENDIF -->
						</tr>
			       	</tbody>
			     	<!-- END block -->
			  	</table>
			</div>
		</div>
	</div>
 </form>
