<!-- IF ERROR ne '' -->

<div class="alert alert-info alert-dismissible">

	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>

</div>

<!-- ENDIF -->



<!-- IF B_EDIT -->

<form name="edit_group" action="" method="post">

	<input type="hidden" name="action" value="update">

	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">

	<div class="panel panel-primary">

	    <div class="panel-heading">

	    	<h4 class="panel-title">{PAGENAME} <input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{L_530}"><a style="float:right" class="btn btn-xs btn-warning" href="{SITEURL}{ADMIN_FOLDER}/usergroups.php">{L_285}</a></h4>

	    </div>

	    <div class="panel-body">

			<table class="table table-bordered">

        		<thead>

        			<tr>

        				<th colspan="8">{L_3500_1015724}</th>

        			</tr>

        		</thead>

            	<thead>

                	<tr>

                    	<th>{L_449}</th>

                        <th>{L_450}</th>

                        <th>{L_451}</th>

                        <th>{L_578}</th>

                        <th>{L_579}</th>

                        <th>{L_580}</th>
                        
                        <th>{L_3500_1015673}</th>

                   	</tr>

              	</thead>

                <tbody>

                	<tr>

                		<!-- IF B_EDIT -->

                    	<td><input type="hidden" name="id" value="{GROUP_ID}">{GROUP_ID}</td>

                        <td><input type="text" name="group_name" value="{EDIT_NAME}"></td>

                        <td><input type="text" name="user_count" placeholder="{L_3500_1015674}" value="{USER_COUNT}"></td>

                        <td>

                        	<select name="can_sell">

                            	<option value="1" {CAN_SELL_Y}>{L_030}</option>

                                <option value="0" {CAN_SELL_N}>{L_029}</option>

                            </select>

                        </td>

                        <td>

                        	<select name="can_buy">

	                            <option value="1" {CAN_BUY_Y}>{L_030}</option>

	                           	<option value="0" {CAN_BUY_N}>{L_029}</option>

                            </select>

                      	</td>

                        <td>

                       		<select name="auto_join">

                            	<option value="1" {AUTO_JOIN_Y}>{L_030}</option>

                                <option value="0" {AUTO_JOIN_N}>{L_029}</option>

                            </select>

                        </td>

                  		<!-- ENDIF -->
                  		
                  		<td>

                       		<select name="no_fees">

                            	<option value="1" {NO_FEES_Y}>{L_030}</option>

                                <option value="0" {NO_FEES_N}>{L_029}</option>

                            </select>

                       	</td>

					</tr>

				</tbody>

			</table>

		</div>

	</div>

</form>

<!-- ELSE -->

<div class="panel panel-primary">

    <div class="panel-heading">

    	<h4 class="panel-title">{PAGENAME} <a style="float:right" class="btn btn-xs btn-success" href="{SITEURL}{ADMIN_FOLDER}/usergroups.php?action=new">{L_518}</a></h4>

    </div>

    <div class="panel-body">

		<table class="table table-bordered">

        	<thead>

            	<tr>

                	<th>{L_449}</th>

                    <th>{L_450}</th>

                    <th>{L_451}</th>

                    <th>{L_578}</th>

                    <th>{L_579}</th>

                    <th>{L_580}</th>

                    <th>{L_3500_1015673}</th>

                    <th>&nbsp;</th>

                </tr>

          	</thead>

      		<tbody>

           		<!-- BEGIN groups -->

                <tr>

                	<td>{groups.ID}</td>

                    <td>{groups.NAME}</td>

                    <td>{groups.USER_COUNT}</td>

                    <td>{groups.CAN_SELL}</td>

                    <td>{groups.CAN_BUY}</td>

                    <td>{groups.AUTO_JOIN}</td>

                    <td>{groups.NO_FEES}</td>

                    <td>

                    	<a class="btn btn-info" href="{SITEURL}{ADMIN_FOLDER}/usergroups.php?id={groups.ID}&action=edit">{L_298}</a> 

                    	<a class="btn btn-danger" href="{SITEURL}{ADMIN_FOLDER}/usergroups.php?id={groups.ID}&action=delete">{L_008}</a>

                    </td>

                </tr>

            	<!-- END groups -->

            </tbody>

       	</table>

	</div>

</div>

<!-- ENDIF -->



