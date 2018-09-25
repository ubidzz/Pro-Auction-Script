<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="mods" action="{FORM_2}" method="post">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{L_3500_1015451}<input style="float:right" type="submit" name="act" class="btn btn-success" value="{BUTTON_TITLE}"></h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
            	<thead>
                	<tr>
                    	<th>{L_3500_1015452}452345</th>
                        <th>{L_3500_1015455}</th>
                   	</tr>
              	</thead>
                <tbody>
                	<!-- BEGIN mod -->
                   	<input type="hidden" name="update" value="yes">
                	<input type="hidden" name="do" value="install">
	               	<tr>
	                    <td>{L_3500_1015475}</td>
	                	<td>{mod.MAKER}</td>
	                </tr>
	                <tr>
	                    <td>{L_3500_1015476}</td>
	                	<td>{mod.MOD}</td>
	                </tr>
	                <tr>
	                    <td>{L_3500_1015477}</td>
	                	<td>{mod.VERSION}</td>
	                </tr>
	                <tr>
	                    <td>{L_3500_1015478}</td>
	               		<td>{mod.FOLDER}</td>
	                </tr>
	                <tr>
	                    <td>{L_3500_1015479}</td>
	                	<td>{mod.PAGE}</td>
	                </tr>
	               	<tr>
	                    <td>{L_3500_1015480}</td>
	                	<td>{mod.FIND}</td>
	               	</tr>
	                <tr>
	                    <td>{L_3500_1015481}</td>
	                	<td>{mod.REPLACE}</td>
	                </tr>
	                <tr>
	                    <td>{L_3500_1015482}</td>
	                	<td>{mod.ADDAFTER}</td>
	                </tr>
	                <tr>
	                    <td>{L_3500_1015483}</td>
	                	<td>{mod.ADDBEFORE}</td>
	            	</tr>
	            </tbody>
	        	<!-- END mod -->
        	</table>
		</div>
	</div>
	