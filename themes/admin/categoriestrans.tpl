<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="panel-title">{L_3500_1015829}</h4>
	</div>
	<div class="panel-body">
		<table class="table table-bordered">
			<thead>
				<!-- BEGIN langs -->
                <tr>
                    <th>{L_161}</th>
                	<th><a href="categoriestrans.php?lang={langs.LANG}"><img align="middle" src="{SITEURL}language/flags/{langs.LANG}.gif" border="0"></a></th>
               	</tr>
             	<!-- END langs -->
			</thead>
		</table>
	</div>
</div>
<form name="errorlog" action="" method="post">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{PAGENAME} <input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{L_089}"></h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
            	<thead>
                    <tr>
                   		<th>{L_771}</th>
                        <th>{L_772}</th>
                    </tr>
             	</thead>
                <tbody>
                	<!-- BEGIN cats -->
                	<tr {cats.BG}>
                    	<td><input type="text" name="categories_o[]" value="{cats.CAT_NAME}" size="45" disabled></td>
                        <td><input type="text" name="categories[{cats.CAT_ID}]" value="{cats.TRAN_CAT}" size="45"></td>
                   	</tr>
                    <!-- END cats -->
             	</tbody>
         	</table>
		</div>
	</div>
</form>
