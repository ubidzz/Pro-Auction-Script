<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->
<div class="col-xs col-sm-6 col-md-6 col-lg-6">
	<form name="search" action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
		<div class="panel panel-primary">
		    <div class="panel-heading">
		    	<h4 class="panel-title">{L_5024}</h4>
		    </div>
		    <div class="panel-body">
				<div class="form-group">
	            	<label for="nameUsernameEmail">{L_5022}</label>
	                <input type="text" id="nameUsernameEmail" class="form-control" name="keyword" size="25">
	          	</div>
	          	<button type="submit" class="btn btn-sm btn-success">{L_5023}</button>
			</div>
		</div>
	</form>
</div>
<div class="col-xs col-sm-6 col-md-6 col-lg-6">
	<form name="filter" id="filter" action="" method="get">
		<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
		<div class="panel panel-primary">
		    <div class="panel-heading">
		    	<h4 class="panel-title">{L__0052}</h4>
		    </div>
		    <div class="panel-body">
				<div class="form-group">
					<label for="userfilter">{L_1014}</label>
		          	<select name="usersfilter" id="userfilter" class="form-control">
		              	<option value="all">{L_5296}</option>
		              	<option value="active" <!-- IF USERFILTER eq 'active' -->selected<!-- ENDIF -->>{L_5291}</option>
		             	<option value="admin" <!-- IF USERFILTER eq 'admin' -->selected<!-- ENDIF -->>{L_5294}</option>
		             	<option value="fee" <!-- IF USERFILTER eq 'fee' -->selected<!-- ENDIF -->>{L_5293}</option>
		               	<option value="confirmed" <!-- IF USERFILTER eq 'confirmed' -->selected<!-- ENDIF -->>{L_5292}</option>
		              	<option value="admin_approve" <!-- IF USERFILTER eq 'admin_approve' -->selected<!-- ENDIF -->>{L_25_0136}</option>
	             	</select>
	          	</div>
	          	<button type="submit" class="btn btn-sm btn-success">{L_5029}</button>
			</div>
		</div>
	</form>
</div>
<div class="col-xs col-sm-12 col-md-12 col-lg-12">
	<div class="panel panel-primary table-responsive">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{PAGENAME}</h4>
	    </div>
		<table class="table table-hover table-striped">
	       	<thead>
	           	<tr>
	              	<th>{L_293}</th>
	               	<th>{L_294}</th>
	               	<th class="hidden-sm hidden-xs">{L_295}</th>
	               	<th>{L_296}</th>
	               	<th class="hidden-sm hidden-xs">{L_25_0079}</th>
	              	<th>{L_763}</th>
	            	<th>{L_560}</th>
	            	<th>{L_008}</th>
	        	</tr>
	     	</thead>
	     	<form action="{SITEURL}{ADMIN_FOLDER}/listusers.php" method="post">
		     	<tbody>
		         	<!-- BEGIN users -->
		         	<tr>
		            	<td>
		                	<b>{users.NICK}</b><br>
		                  	<div class="btn-group">
		                 		<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{L_297}
			                  		<span class="caret"></span>
			                  		<span class="sr-only">Toggle Dropdown</span>
		                     	</button>
		                     	<ul class="dropdown-menu">
		                     		<li><a href="listauctions.php?uid={users.ID}&offset={PAGE}">{L_5094}</a></li>
		                     		<li><a href="userfeedback.php?id={users.ID}&offset={PAGE}">{L_503}</a></li>
		                     		<li><a href="viewuserips.php?id={users.ID}&offset={PAGE}">{L_2_0004}</a></li>
		                     		<li role="separator" class="divider"></li>
			                     	<li><a href="edituser.php?userid={users.ID}&offset={PAGE}">{L_298}</a></li>
			                     	<li><a href="deleteuser.php?id={users.ID}&offset={PAGE}">{L_008}</a></li>
				                   	<li><a href="excludeuser.php?id={users.ID}&offset={PAGE}">
								    		<!-- IF users.SUSPENDED eq 0 -->
								          	{L_305}
								    		<!-- ELSEIF users.SUSPENDED eq 8 -->
								          	{L_515}
								    		<!-- ELSE -->
								           	{L_299}
								    		<!-- ENDIF -->
							        	</a>
							   		</li>
						    	</ul>
					   		</div>
		              	</td>
		              	<td>{users.NAME}</td>
		              	<td class="hidden-sm hidden-xs">{users.COUNTRY}</td>
		            	<td><a href="mailto:{users.EMAIL}">{users.EMAIL}</a></td>
		              	<td class="hidden-sm hidden-xs">{users.NEWSLETTER}</td>
		              	<td>{users.BALANCE}
		                   	<!-- IF users.BALANCE_CLEAN lt 0 -->
		                 	<form name="payreminder" action="" method="post" enctype="multipart/form-data">
		                    	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
		                    	<input type="hidden" name="payreminder_email" value="send">
		                    	<input type="hidden" name="user_id" value="{users.ID}">
		                    	<input type="submit" value="{L_764}" class="btn btn-danger btn-sm">
							</form>
		                	<!-- ENDIF -->
						</td>
		             	<td>
		                  	<!-- IF users.SUSPENDED eq 0 -->
		                  	<b><span style="color:green;">{L_5291}</span></b>
		                	<!-- ELSEIF users.SUSPENDED eq 1 -->
		                   	<b><span style="color:violet;">{L_5294}</span></b>
		                	<!-- ELSEIF users.SUSPENDED eq 7 -->
		                   	<b><span style="color:red;">{L_5297}</span></b>
		                	<!-- ELSEIF users.SUSPENDED eq 8 -->
		                  	<b><span style="color:orange;">{L_5292}</span></b><br>
		                   	<form name="resend" action="" method="post" enctype="multipart/form-data">
				               	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
				             	<input type="hidden" name="resend_email" value="send">
				              	<input type="hidden" name="user_id" value="{users.ID}">
				            	<input type="submit" value="{L_25_0074}" class="btn btn-danger btn-sm">
							</form>
		                	<!-- ELSEIF users.SUSPENDED eq 9 -->
		                 	<b><span style="color:red;">{L_5293}</span></b>
		                	<!-- ELSEIF users.SUSPENDED eq 10 -->
		                 	<b><small style="color:orange;"><a href="excludeuser.php?id={users.ID}&offset={PAGE}">{L_25_0136}</a></small></b>
		                	<!-- ENDIF -->
		           		</td>
		          	</tr>
		         	<!-- END users -->
		   		</tbody>
	   		</form>
	 	</table>
	  	<div align="center">
	    	<b>{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}</b>
	      	<nav>
	           	<ul class="pagination">
	              	<li>{PREV}</li>
			     	<!-- BEGIN pages -->
			      	{pages.PAGE}
			      	<!-- END pages -->
			    	<li>{NEXT}</li>
		    	</ul>
	    	</nav>
		</div>
	</div>
</div>
