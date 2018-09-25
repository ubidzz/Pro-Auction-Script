<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="banips" action="" method="post">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{PAGENAME}<input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{L_2_0015}"></h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
            	<thead>
               		<tr>
                        <th colspan="5">
                            {L_2_0021}
                            <input type="text" name="ip" placeholder="185.39.51.63">
                            <input type="submit" class="btn btn-success btn-sm" name="Submit2" value="{L_3500_1015828}">
                        	{L_2_0024}
                    	</th>
                   	</tr>
                    <tr>
                        <th>{L_087}</th>
                        <th>{L_2_0009}</th>
                        <th>{L_560}</th>
                        <th>{L_5028}</th>
                    	<th>{L_008}</th>
                	</tr>
                </thead>
             	<tbody>
                    <!-- BEGIN ips -->
                   	<tr>
                        <td>{L_2_0025}</td>
                        <td>{ips.IP}</td>
                        <td>
                            <!-- IF ips.ACTION eq 'accept' -->
                            {L_2_0012}
            				<!-- ELSE -->
                            {L_2_0013}
            				<!-- ENDIF -->
    					</td>
                        <td>
                           	<!-- IF ips.ACTION eq 'accept' -->
                            <input type="checkbox" name="deny[]" value="{ips.ID}">
                            &nbsp;{L_2_0006}
            				<!-- ELSE -->
                            <input type="checkbox" name="accept[]" value="{ips.ID}">
                            &nbsp;{L_2_0007}
            				<!-- ENDIF -->
                        </td>
                        <td><input type="checkbox" name="delete[]" value="{ips.ID}"></td>
                        <!-- BEGINELSE -->
                        <td colspan="5">{L_831}</td>
                    	<!-- END ips -->
                	</tr>
            	</tbody>
        	</table>
		</div>
	</div>
</form>

