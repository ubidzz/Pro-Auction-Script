<table border="0" width="100%">
	<tr>
		<td colspan="3" height="35"><div style="font-size: 14px; font-weight: bold;">Congratulations, your item has sold!</div></td>
	</tr>
	<tr>
		<td colspan="3" style="font-size: 12px;">Hello <b>{S_NAME}</b>,</td>
	</tr>
	<tr>
		<td colspan="3" height="50" style="font-size: 12px; padding-right: 6px;"><i>Congratulations</i> your item has just sold!
		Below are the details.</td>
	</tr>
	<tr>
		<td width="9%" rowspan="2"><img width="150px" height="150px" border="0" src="{A_PICURL}" style="max-width:{MAXIMAGESIZE}px; max-height:{MAXIMAGESIZE}px; width: auto; height: auto;"></td>
		<td width="55%" rowspan="2">
		<table border="0" width="100%">
			<tr>
				<td colspan="2" style="font-size: 12px;"><a href="{A_URL}">{A_TITLE}</a></td>

			</tr>
			<tr>
				<td width="18%" style="font-size: 12px;">Sale price:</td>
				<td align="left" style="font-size: 12px;">{A_CURRENTBID}</td>
			</tr>
			<tr>
				<td width="18%" style="font-size: 12px;">Quantity:</td>
				<td align="left" style="font-size: 12px;">{A_QTY}</td>
			</tr>
			<tr>
				<td width="18%" style="font-size: 12px;">End date:</td>
				<td align="left" style="font-size: 12px;">{A_ENDS}</td>
			</tr>
			<tr>
				<td width="18%" style="font-size: 12px;">Paid:</td>
				<td align="left" style="font-size: 12px;">{PAID}</td>
			</tr>

			<tr>
				<td width="18%" style="font-size: 12px;">Auction URL:</td>
				<td align="left" style="font-size: 12px;"><a href="{A_URL}">{A_URL}</a></td>
			</tr>
			<tr>
				<td width="18%" style="font-size: 12px;"></td>
				<td align="left" style="font-size: 12px;"><a href="{SITE_URL}user_menu.php?">Goto My {SITENAME}</a></td>
			</tr>
		</table>
		</td>
		<td width="34%" style="font-size: 12px;">Check Payment Details</td>
	</tr>
	<tr>
		<td width="34%" height="90" valign="top">
		<a href="{SITE_URL}buying.php">
		<img border="0" src="{SITE_URL}images/email_alerts/Total_Due_Btn.jpg" width="120" height="32"></a></td>
	</tr>
 </table><br />
 
<table border="1" width="100%">
	<tr>
		<td colspan="2" style="font-size: 12px;"><b>Buyer's Information</b></td>
	</tr>
	<tr>
		<td style="font-size: 12px;">Email:</td>
		<td>{WINNER_EMAIL}</td>
	</tr>
	<tr>
		<td style="font-size: 12px;">Name:</td>
		<td>{WINNER_NAME}</td>
	</tr>
	<tr>
		<td style="font-size: 12px;">Address:</td>
		<td>{WINNER_ADDRESS}</td>
	</tr>
	<tr>
		<td style="font-size: 12px;">City:</td>
		<td>{WINNER_CITY}</td>
	</tr>
	<tr>
		<td style="font-size: 12px;">State/Province:</td>
		<td>{WINNER_PROV}</td>
	</tr>
	<tr>
		<td style="font-size: 12px;">Country:</td>
		<td>{WINNER_COUNTRY}</td>
	</tr>
	<tr>
		<td style="font-size: 12px;">ZIP/Post Code:</td>
		<td>{WINNER_ZIP}</td>
	</tr>


</table><br />
<div style="font-size: 12px;"><i>An email has been sent to the winner(s) with your email address.</i></div>