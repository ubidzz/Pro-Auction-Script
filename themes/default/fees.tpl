<legend>{L_25_0012} </legend>
		<!-- IF B_BONUS_FEE -->
		<table class="table table-condensed table-striped table-bordered">
		  <tr>
		    <th colspan="1">{L_350_1015404}</th >
		  </tr>
		  <tr>
		    <td>{L_736}: {BONUS}</td>
		  </tr>
		</table>
		<!-- ENDIF -->
		<table class="table table-condensed table-striped table-bordered">
		  <tr>
		    <th colspan="2">{L_350_1015405}</th>
		  </tr>
		  <tr>
			  <!-- IF B_BANNER_FEE -->
			  <td>{L_350_1015446}: {BANNER_FEE}</td>
			  <!-- ENDIF -->
			  <!-- IF B_EX_BANNER_FEE -->
			  <td>{L_350_10128}: {EX_BANNER_FEE}</td>
			  <!-- ENDIF -->
		  </tr>
		</table>
		<!-- IF B_SETUP_FEE -->
		<table class="table table-condensed table-striped table-bordered">
		  <tr>
		    <th colspan="2">{L_431}</th>
		  </tr>
		  <!-- BEGIN setup_fees -->
		  <tr>
		    <td width="40%">{L_240} {setup_fees.FROM} {L_241} {setup_fees.TO}</td>
		    <td>{setup_fees.VALUE}</td>
		    <!-- END setup_fees -->
		  </tr>
		</table>
		<!-- ENDIF -->
		<!-- IF B_BUYER_FEE -->
		<table class="table table-condensed table-striped table-bordered">
		  <tr>
		    <th colspan="2">{L_775}</th>
		  </tr>
		  <!-- BEGIN buyer_fee -->
		  <tr>
		    <td width="40%">{L_240}: {buyer_fee.FROM} {L_241}: {buyer_fee.TO}</td>
		    <td>{buyer_fee.VALUE}</td>
		    <!-- END buyer_fee -->
		  </tr>
		</table>
		<!-- ENDIF -->
		<!-- IF B_ENDAUC_FEE -->
		<table class="table table-condensed table-striped table-bordered">
		  <tr>
		    <th colspan="2">{L_791}</th>
		  </tr>
		  <!-- BEGIN endauc_fee -->
		  <tr>
		    <td width="40%">{L_240}: {endauc_fee.FROM} {L_241}: {endauc_fee.TO}</td>
		    <td>{endauc_fee.VALUE}</td>
		    <!-- END endauc_fee -->
		  </tr>
		</table>
		<!-- ENDIF -->
		<table class="table table-condensed table-striped table-bordered">
			<tr>
				<th width="35%">{L_3500_1015875}</th>
				<th></th>
			</tr>
			<!-- IF B_SIGNUP_FEE -->
			<tr>
				<td>{L_430}</td>
				<td>{SIGNUP_FEE}</td>
			</tr>
			<!-- ENDIF -->
			<!-- IF B_HPFEAT_FEE -->
			<tr>
				<td>{L_433}</td>
				<td>{HPFEAT_FEE}</td>
			</tr>
			<!-- ENDIF -->
			<!-- IF B_BOLD_FEE -->
			<tr>
				<td>{L_439}</td>
				<td>{BOLD_FEE}</td>
			</tr>
			<!-- ENDIF -->
			<!-- IF B_HL_FEE -->
			<tr>
				<td>{L_434}</td>
				<td>{HL_FEE}</td>
			</tr>
			<!-- ENDIF -->
			<!-- IF B_RP_FEE -->
			<tr>
				<td>{L_440}</td>
				<td>{RP_FEE}</td>
			</tr>
			<!-- ENDIF -->
			<!-- IF B_PICTURE_FEE -->
			<tr>
				<td>{L_435} <br> ({FREE_PICTURES})</td>
				<td>{PICTURE_FEE}</td>
			</tr>
			<!-- ENDIF -->
			<!-- IF B_RELIST_FEE -->
			<tr>
				<td>{L_437}</td>
				<td>{RELIST_FEE}</td>
			</tr>
			<!-- ENDIF -->
			<!-- IF B_BUYNOW_FEE -->
			<tr>
				<td>{L_436}</td>
				<td>{BUYNOW_FEE}</td>
			</tr>
			<!-- ENDIF -->
			<!-- IF B_EXCAT_FEE -->
			<tr>
				<td>{L_804}</td>
				<td>{EXCAT_FEE}</td>
			</tr>
			<!-- ENDIF -->
			<!-- IF B_SUBTITLE_FEE -->
			<tr>
				<td>{L_803}</td>
				<td>{SUBTITLE_FEE}</td>
			</tr>
			<!-- ENDIF -->
			<!-- IF B_GOOGLE_MAP_FEE -->
			<tr>
				<td>{L_3500_1015811}</td>
				<td>{GOOGLE_MAP_FEE}</td>
			</tr>
			<!-- ENDIF -->
		</table>

