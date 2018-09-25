<!-- IF CHECKAPI eq true -->

<div class="alert alert-info alert-dismissible">

	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

	<h4><i class="icon fa fa-info"></i> {L_3500_1015945}</h4>

	<p>{SCRIPTMESSAGE}</p>

</div>

<!-- ENDIF -->



<!-- IF ERROR ne '' -->

<div class="alert alert-info alert-dismissible">

	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>

</div>

<!-- ENDIF -->

	<div class="col-md-6">

		<div class="box box-info">

			<div class="box-header">

	            <h3 class="box-title">{L_25_0025}</h3>

	            <!-- tools box -->

	            <div class="pull-right box-tools">

	            	<button type="button" class="btn btn-danger btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>

		  		</div>

		  		<div class="box-body table-responsive">

			  		<table class="table table-bordered table-hover">

						<tbody>

							<tr>

								<td><strong>{L_30_0214}</strong></td>

								<td>{MYVERSION} ({REALVERSION})</td>

							</tr>

				          	<tr>

				            	<td><strong>{L_528}</strong></td>

				            	<td>{SITEURL}</td>

				         	</tr>

				          	<tr>

				              	<td><strong>{L_527}</strong></td>

				              	<td>{SITENAME}</td>

				         	</tr>

				         	<tr>

				             	<td><strong>{L_540}</strong></td>

				              	<td>{ADMINMAIL}</td>

				          	</tr>

				          	<tr>

				             	<td><strong>{L_25_0026}</strong></td>

				              	<td>{CRON}</td>

				           	</tr>

				        	<tr>

				              	<td><strong>{L_663}</strong></td>

				              	<td>{GALLERY}</td>

				          	</tr>

				         	<tr>

				             	<td><strong>{L_3500_1015585}</strong></td>

				             	<td><strong>{CACHE}</strong></td>

				         	</tr>

				          	<tr>

				             	<td><strong>{L_3500_1015634}</strong></td>

				             	<td><strong>{COOKIE_DIRECTIVE}</strong></td>

				          	</tr>

				          	<tr>

				              	<td><strong>{L_2__0025}</strong></td>

				               	<td>{BUY_NOW}</td>

				          	</tr>

				          	<tr>

				              	<td><strong>{L_5008}</strong></td>

				             	<td>{CURRENCY}</td>

				           	</tr>

				          	<tr>

				             	<td><strong>{L_25_0035}</strong></td>

				              	<td>{TIMEZONE}</td>

				         	</tr>

				          	<tr>

				           		<td><strong>{L_363}</strong></td>

				            	<td>{DATEFORMAT} <small>({DATEEXAMPLE})</small></td>

				          	</tr>

				           	<tr>

				               	<td><strong>{L_3500_1015550}</strong></td>

				              	<td>{EMAIL_HANDLER}</td>

				         	</tr>

				          	<tr>

				             	<td><strong>{L_5322}</strong></td>

				          		<td>{DEFULTCONTRY}</td>

				        	</tr>

				        	<tr>

				          		<td><strong>{L_2__0002}</strong></td>

				            	<td>

				            		<!-- BEGIN langs -->

				                  	<p>{langs.LANG}<!-- IF langs.B_DEFAULT --> ({L_2__0005})<!-- ENDIF --></p>

				            		<!-- END langs -->

				             	</td>

				       		</tr>

				    	</tbody>

				  	</table>

				</div>

			 </div>

		</div>

  	</div>

  	<!-- Custom statistics chart for this template -->

	<link rel="stylesheet" href="{SITEURL}themes/{ADMIN_THEME}/css/morris.css">

	<!-- Custom javascript for the statistics charts -->

	<script src="{SITEURL}themes/{ADMIN_THEME}/js/morris.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>

	<!-- IF B_VISITS ne '' -->

	<div class="col-md-3">

		<div class="box box-info">

			<div class="box-header">

	            <h3 class="box-title">{L_25_0063}</h3>

	            <div class="box-tools pull-right">

	                <button type="button" class="btn btn-danger btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>

	            </div>

	            <div class="box-body chart-responsive" style="display: block;">

				    <div class="chart" id="visits"></div>

				    <script type="text/javascript">

						Morris.Donut({

							element: 'visits',

								data: [

									{value: '{A_PAGEVIEWS}', label: '{L_5161}'},

									{value: '{A_UVISITS}', label: '{L_5162}'},

									{value: '{A_USESSIONS}', label: '{L_5163}'}

								],

								resize: true,

								colors: [

							    	'#2eb82e',

							    	'#0066ff',

							    	'#ff3333',

							  	],

								formatter: function (x) { return x}

							}).on('click', function(i, row){

							console.log(i, row);

						});

					</script>

				</div>

			</div>

    	</div>

    </div>

    <!-- ENDIF -->

    <!-- IF B_AUCTIONS ne '' -->

	<div class="col-md-3">

		<div class="box box-info">

			<div class="box-header">

	            <h3 class="box-title">{L_3500_1015838}</h3>

	            <div class="box-tools pull-right">

	                <button type="button" class="btn btn-danger btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>

	            </div>

	            <div class="box-body chart-responsive" style="display: block;">

		   			<div class="chart" id="auctions"></div>

				   	<script type="text/javascript">

						Morris.Donut({

							element: 'auctions',

								data: [

									{value: '{C_AUCTIONS}', label: '{L_25_0057}'},

									{value: '{C_CLOSED}', label: '{L_354}'},

									{value: '{C_BIDS}', label: '{L_25_0059}'},

									{value: '{C_ISOLD}', label: '{L_3500_1015549}'}

								],

								resize: true,

								colors: [

							    	'#1a8cff',

							    	'#ff1a1a',

							    	'#ac00e6',

							    	'#009933'

							  	],

								formatter: function (x) { return x}

							}).on('click', function(i, row){

							console.log(i, row);

						});

					</script>

				</div>

			</div>

    	</div>

   	</div>

   	<!-- ENDIF -->

	<div class="col-xs col-sm-12 col-md-6 col-lg-6">

		<div class="box box-info">

			<div class="box-header">

	            <h3 class="box-title">{L_3500_1015823}</h3>

	            <!-- tools box -->

	            <div class="pull-right box-tools">

	            	<button type="button" class="btn btn-danger btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>

		  		</div>

		  		<div class="box-body table-responsive">

					<table class="table table-hover table-striped">

						<tbody>

				          	<tr>

				               	<td><strong>{L_25_0055}</strong></td>

				            	<td>{C_USERS}</td>

				         	</tr>

				        	<tr>

				           		<td><strong>{L_25_0056}</strong></td>

				             	<td>

				                 	<!-- IF USERCONF eq 0 -->

				               		<strong>{L_893}</strong>: {C_IUSERS}<br>

				                	<strong>{L_892}</strong>: {C_UUSERS} (<a href="{SITEURL}{ADMIN_FOLDER}/listusers.php?usersfilter=admin_approve">{L_5295}</a>)

									<!-- ELSE -->

				                   	{C_IUSERS}

									<!-- ENDIF -->

								</td>

				         	</tr>              

				    	</tbody>

					</table>

				</div>

			</div>

		</div>

	</div>

	<div class="col-xs col-sm-12 col-md-6 col-lg-6">

		<div class="box box-info">

			<div class="box-header">

	            <h3 class="box-title">{L_080}</h3>

	            <!-- tools box -->

	            <div class="pull-right box-tools">

	            	<button type="button" class="btn btn-danger btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>

		  		</div>

		  		<div class="box-body table-responsive">

			  		<table class="table table-bordered table-hover">

						<tbody>

				        	<tr>

				            	<td >{L_30_0032}</td>

				              	<td>

				                 	<form action="{SITEURL}{ADMIN_FOLDER}/index.php" method="post">

				                     	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">

				                     	<input type="hidden" name="action" value="clearcache">

				                      	<input type="submit" name="submit" class="btn btn-success" value="{L_30_0031}">

				                  	</form>

				               	</td>

				           	</tr>

				           	<tr>

				              	<td width="50%">{L_1030}</td>

				             	<td>

				                  	<form action="{SITEURL}{ADMIN_FOLDER}/index.php" method="post">

				                     	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">

				                     	<input type="hidden" name="action" value="updatecounters">

				                    	<input type="submit" name="submit" class="btn btn-success" value="{L_1031}">

				                 	</form>

				            	</td>

				       		</tr>      

				   		</tbody>

					</table>

				</div>

			</div>

		</div>

	</div>

	