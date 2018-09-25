<!-- INCLUDE user_menu_header.tpl -->

<div class="col-sm-9">

	<legend>{L_25_0080}</legend>

	<!-- IF B_CAN_SELL -->

	<!-- ELSE -->

	<div class="col-sm-6">

		<div class="panel panel-warning">

			<div class="panel-heading">{L_25_0141}</div>

			<div class="panel-body">

				{L_25_0140}

			</div>

			<div class="panel-footer">

				<form name="request" action="" method="post" enctype="multipart/form-data">

				 	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">

				 	<input type="hidden" name="requesttoadmin" value="send">

				 	<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-check"></span> {L_3500_1015867}</button>

				</form>

			</div>

		</div>

	</div>

	<!-- ENDIF -->

	<div class="col-sm-6">

	<div class="panel panel-success">

		<div class="panel-heading">{L_593}</div>

			<table class="table table-condensed table-striped table-bordered">

				{FBTOLEAVE}

			   	{NEWMESSAGES}

				{NO_REMINDERS}

			   	{TO_PAY}

				{BENDING_SOON}

			   	{BOUTBID}

			    {SOLD_ITEM8}

			</table>

	</div>

</div>

