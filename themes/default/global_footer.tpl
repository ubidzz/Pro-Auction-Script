			<nav class="navbar navbar-inverse navbar-fixed-bottom">

			  	<div class="container-fluid">

			    	<div class="navbar-header">

			      		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#footernavbar" aria-expanded="false">

				        	<span class="sr-only">Toggle navigation</span>

				        	<span class="icon-bar"></span>

				        	<span class="icon-bar"></span>

				        	<span class="icon-bar"></span>

			      		</button>

			      		<a class="navbar-brand" href="{SITEURL}home">{L_COPY}</a>	

			      	</div>

			      	<div class="collapse navbar-collapse" id="footernavbar">

			      		<ul class="nav navbar-nav">

			      			<!-- IF B_LOGGED_IN -->

			      			<li><a href="{SITEURL}logout.php?"><i class="fa fa-sign-out" aria-hidden="true"></i> {L_245}</a></li>

			      			<!-- ELSE -->

			      			<li><a href="{SITEURL}new_account"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> {L_235}</a></li>

			      			<li><a href="#" data-toggle="modal" data-target="#loginModal"><i class="fa fa-sign-in" aria-hidden="true"></i> {L_052}</a></li>

			      			<!-- ENDIF -->

			      			<li class="dropdown">

			      				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="HelpColumn"><i class="fa fa-question-circle" aria-hidden="true"></i> {L_281} <span class="caret"></span></a>

								<ul class="dropdown-menu multi-level" aria-labelledby="HelpColumn">

									<!-- IF B_VIEW_ABOUTUS -->

					      			<li><a href="{SITEURL}contents.php?show=aboutus" >{L_5085}</a></li>

					      			<!-- ENDIF -->

					      			<!-- IF B_VIEW_PRIVPOL -->

			  						<li><a href="{SITEURL}contents.php?show=priv">{L_401}</a></li>

			  						<!-- ENDIF -->

			  						<!-- IF B_VIEW_COOKIES -->

			  						<li><a href="{SITEURL}contents.php?show=cookies"> {L_30_0239}</a></li>

									<!-- ENDIF --> 

			  						<!-- IF B_VIEW_TERMS -->

			  						<li><a href="{SITEURL}contents.php?show=terms">{L_5086}</a></li>

			  						<!-- ENDIF -->

			  						<!-- IF B_FEES -->

					      			<li><a href="{SITEURL}fees.php">{L_25_0012}</a></li>

					      			<!-- ENDIF -->

					      			<!-- IF B_BOARDS -->

			      					<li><a href="{SITEURL}boards.php">{L_5030}</a></li>

			      					<!-- ENDIF -->

			  						<li><a href="{SITEURL}email_request_support.php">{L_350_10207}</a></li>

			  						<!-- IF B_LIVECHAT -->

			  						<!-- IF B_LOGGED_IN -->

			  						<li><a href="{SITEURL}chat">{L_3500_1015949}</a></li>

			  						<!-- ENDIF -->

			  						<!-- ENDIF -->

								</ul>

			      			</li>

			      			<!-- IF FLAGS ne '' -->

							<li class="dropdown">

								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{L_2__0001} <span class="caret"></span></a>

								<ul class="dropdown-menu">

									<li>{FLAGS}</li>

								</ul>

							</li>

							<!-- ENDIF -->

							<!-- IF B_ADMIN -->

							<li><a href="{SITEURL}{ADMIN_FOLDER}/login.php" target="_blank">{L_3500_1015692}</a></li>

							<!-- ENDIF -->

			      		</ul>

			      	</div>

			    </div>

			</nav>

		</div>

	</div>

</div>

</body>

</html>