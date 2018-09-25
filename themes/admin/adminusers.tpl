<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="errorlog" action="" method="post">
<div class="panel panel-primary">
    <div class="panel-heading">
    	<div class="panel-title">
    		{PAGENAME}
    		<input style="float:right" type="submit" name="Submit" class="btn btn-xs btn-danger" value="{L_561}">
    		<a style="float:right" href="{SITEURL}{ADMIN_FOLDER}/newadminuser.php" class="btn btn-xs btn-success">{L_367}</a>
		</div>
    </div>
    <div class="panel-body">
		<table class="table table-bordered">
       		<thead>
            	<tr>
               		<th>{L_003}</th>
                    <th>{L_558}</th>
                    <th>{L_559}</th>
                    <th>{L_560}</th>
                    <th>{L_561}</th>
               	</tr>
          	</thead>
           	<tbody>
            	<!-- BEGIN users -->
                <tr>
                	<td><a href="editadminuser.php?id={users.ID}">{users.USERNAME}</a></td>
                    <td>{users.CREATED}</td>
                    <td>{users.LASTLOGIN}</td>
                    <td>{users.STATUS}</td>
                    <td><input type="checkbox" name="delete[]" value="{users.ID}"></td>
             	</tr>
                <!-- END users -->
          	</tbody>
   		</table>
	</div>
</div>
