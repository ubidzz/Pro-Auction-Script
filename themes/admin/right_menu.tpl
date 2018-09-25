<aside class="control-sidebar control-sidebar-dark">

	<!-- Create the tabs -->

    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">

    	<li class="active"><a href="#control-sidebar-profile-tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-user"></i></a></li>

      	<li><a href="#control-sidebar-note-tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-sticky-note"></i></a></li>

      	<li><a href="#control-sidebar-info-tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-info"></i></a></li>

      	<!-- IF B_MULT_LANGS -->

      	<li><a href="#control-sidebar-language-tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-flag"></i></a></li>

      	<!-- ENDIF -->

    </ul>

    <!-- Tab panes -->

    <div class="tab-content">

      	<div class="tab-pane" id="control-sidebar-note-tab">

        	<h3 class="control-sidebar-heading">{L_1061}</h3>

        	<ul class="control-sidebar-menu">

          		<li>

            		<form name="anotes" action="" method="post">

	             		<textarea rows="15" style="width:100%" name="anotes" class="anotes">{ADMIN_NOTES}</textarea><br />

	              		<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">

	              		<input type="hidden" name="submitdata" value="data">

	             		<input type="submit" class="btn btn-success" name="act" value="{L_007}"> 

						<input type="submit" class="btn btn-danger" name="act" value="{L_008}">

					</form>

          		</li>

        	</ul>

      	</div>

      	<!-- IF B_MULT_LANGS -->

      	<div class="tab-pane" id="control-sidebar-language-tab">

        	<h3 class="control-sidebar-heading">{L_091}</h3>

        	<ul class="control-sidebar-menu">

          		<li>

          			{FLAGS}

          		</li>

        	</ul>

      	</div>

      	<!-- ENDIF -->

      	<div class="tab-pane active" id="control-sidebar-profile-tab">

        	<h3 class="control-sidebar-heading">{L_3500_1015824}</h3>

        	<ul class="control-sidebar-menu">

	          	<li>

	            	<a href="{SITEURL}{ADMIN_FOLDER}/editadminuser.php?id={ADMIN_ID}">

		              	<i class="menu-icon fa fa-user bg-green"></i>

		              	<div class="menu-info">

		                	<h4 class="control-sidebar-subheading">{L_200} {ADMIN_USER}</h4>

		                	<p>{L_559}: {LAST_LOGIN}</p>

		              	</div>

	            	</a>

	          	</li>

	          	<li>

	            	<a href="{SITEURL}{ADMIN_FOLDER}/logout.php">

	              		<i class="menu-icon fa fa-power-off bg-red"></i>

	              		<div class="menu-info">

	                		<h4 class="control-sidebar-subheading">{L_245}</h4>

	              		</div>

	            	</a>

	          	</li>

       		</ul>

      	</div>

      	<div class="tab-pane" id="control-sidebar-info-tab">

        	<h3 class="control-sidebar-heading">{L_148}</h3>

        	<ul class="control-sidebar-menu">

	          	<li>

	            	<a href="https://www.pro-auction-script.com/forums/viewforum.php?f=29" target="_blank">

		              	<i class="menu-icon fa fa-comments-o bg-green"></i>

		              	<div class="menu-info">

		                	<h4 class="control-sidebar-subheading">{L_1063}</h4>

		              	</div>

	            	</a>

	          	</li>

	          	<li>

	            	<a href="https://www.pro-auction-script.com/Themes" target="_blank">

	              		<i class="menu-icon fa fa-image bg-green"></i>

	              		<div class="menu-info">

	                		<h4 class="control-sidebar-subheading">{L_1069}</h4>

	              		</div>

	            	</a>

	          	</li>

	          	<li>

	            	<a href="https://www.pro-auction-script.com/forums/viewforum.php?f=34" target="_blank">

	              		<i class="menu-icon fa fa-file-code-o bg-green"></i>

	              		<div class="menu-info">

	                		<h4 class="control-sidebar-subheading">{L_1071}</h4>

	              		</div>

	            	</a>

	          	</li>

	          	<li>

	            	<a href="https://www.pro-auction-script.com/Languages" target="_blank">

	              		<i class="menu-icon fa fa-flag bg-green"></i>

	              		<div class="menu-info">

	                		<h4 class="control-sidebar-subheading">{L_1073}</h4>

	              		</div>

	            	</a>

	          	</li>

	          	<li>

	            	<a href="https://www.pro-auction-script.com/forums/viewforum.php?f=32" target="_blank">

	              		<i class="menu-icon fa fa-bug bg-red"></i>

	              		<div class="menu-info">

	                		<h4 class="control-sidebar-subheading">{L_1076}</h4>

	              		</div>

	            	</a>

	          	</li>

	          	<li>

	            	<a href="https://www.pro-auction-script.com/donation" target="_blank">

	              		<i class="menu-icon fa fa-dollar bg-green"></i>

	              		<div class="menu-info">

	                		<h4 class="control-sidebar-subheading">{L_1080}</h4>

	              		</div>

	            	</a>

	          	</li>

       		</ul>

      	</div>     	

	</div>

</aside>