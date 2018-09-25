<!-- IF PAGE eq 0 -->

<script type="text/javascript"> 

$(document).ready(function(){

	$('#images').load('{SITEURL}uploaded/index.php?action=2 #displayImages').fadeIn("slow");

	$('#setdefaultimg').load('{SITEURL}uploaded/index.php?action=4 #defaultPicture').fadeIn("slow");



	// set up the page

	// do something

	//sell javascript
	
	$("#atype").change(function(){

		var type = $(this).find(':selected').val();

		var freeitem = $("#free_item_yes").prop('checked');

		var SHIPPINGTERM = "{SHIPPINGTERM_OPTIONS}";

		var SHIPPINGCONDITION = "{SHIPPINGCONDITION_OPTIONS}";

		

		if (type == 3) { //Digital items auction

			if (freeitem == "free")

			{

				$("#iqty").val("999999");

		        $("#with_reserve_no").attr("checked", "checked");

				$("#bn_only_yes").attr("checked", "checked");

				$("#bn_yes").attr("checked", "checked");

				$("#inc1").attr("checked", "checked");

				$("#iqty").removeAttr("disabled","disabled");

				$("#bn").removeAttr("disabled","disabled");

				$("#custominc").attr("disabled","disabled");

				$("#bn").val("0.00");

				$("#shipping_cost").val("0.00");

				$("#additional_shipping_cost").val("0.00");

				$("#min_bid").val("0.00");

				$("#returns").val("1");

				$("#custominc").val("0.00");

				$("#free_item_no").removeAttr("disabled","disabled");

				$("#free_item_yes").removeAttr("disabled","disabled");

				$("#returns").removeAttr("checked", "checked");

				$("#googleMap").removeAttr("checked", "checked");

				$(".hide1").show();

				$(".hide2").hide();

				$(".hide3").hide();

				$(".hide4").hide();

				$(".hide5").hide();

				$(".hide6").hide();

				$(".hide7").hide();

				$(".hide8").hide();

				$(".hide9").hide();

				$(".hide10").hide();

				$(".hide11").hide();

				$(".hide12").hide();

			}else{

				$("#iqty").val("99999");

		        $("#with_reserve_no").attr("checked", "checked");

				$("#bn_only_yes").attr("checked", "checked");

				$("#bn_yes").attr("checked", "checked");

				$("#returns").val("1");

				$("#inc1").attr("checked", "checked");

				$("#iqty").removeAttr("disabled","disabled");

				$("#bn").removeAttr("disabled","disabled");

				$("#custominc").attr("disabled","disabled");

				$("#bn").val("0.99");

				$("#shipping_cost").val("0.00");

				$("#additional_shipping_cost").val("0.00");

				$("#min_bid").val("0.00");

				$("#custominc").val("0.00");

				$("#free_item_no").removeAttr("disabled","disabled");

				$("#free_item_yes").removeAttr("disabled","disabled");

				$("#returns").removeAttr("checked", "checked");

				$("#googleMap").removeAttr("checked", "checked");

				$(".hide1").show();

				$(".hide2").hide();

				$(".hide3").hide();

				$(".hide4").hide();

				$(".hide5").hide();

				$(".hide6").hide();

				$(".hide7").show();

				$(".hide8").hide();

				$(".hide9").hide();

				$(".hide10").hide();

				$(".hide11").show();

				$(".hide12").hide();

			}

	    }

	    if (type == 2) { //dutch auction
			
			if (freeitem == "free")

			{
				$("#free_item_yes").attr("checked", "checked");
				$("#free_item_no").removeAttr("checked", "checked");
				
			}
			
			$("#with_reserve_no").attr("checked", "checked");

			$("#bn_only_no").attr("checked", "checked");

			$("#bn_no").attr("checked", "checked");

			$("#bn").attr("disabled","disabled");

			$("#custominc").attr("disabled","disabled");

			$("#custominc").val("0.00");

			$("#bn").val("0.00");

			$("#inc1").attr("checked", "checked");

			$("#free_item_no").attr("disabled","disabled");

			$("#free_item_yes").attr("disabled","disabled");

			$("#iqty").removeAttr("disabled","disabled");

			$("#additional_shipping_cost").attr("disabled","disabled");

			$("#additional_shipping_cost").val("0.00");

			$("#shipping_cost").val("0.00");

			$("#min_bid").attr("disabled");

			$("#min_bid").val("0.99");

			$("#iqty").val("1");

			$("#minval_text").text("{L_038}");

			$("#returns").removeAttr("checked", "checked");

			$("#googleMap").removeAttr("checked", "checked");

			$(".hide1").hide();

			$(".hide2").show();

			$(".hide3").show();

			$(".hide4").show();

			$(".hide5").hide();

			$(".hide6").hide();

			$(".hide7").hide();

			$(".hide8").hide();

			$(".hide9").show();

			if(SHIPPINGCONDITION == 'y'){

				$(".hide10").show();

			}else{

				$(".hide10").hide();

			}

			$(".hide11").show();

			if(SHIPPINGTERM == 'y'){

				$(".hide12").show();

			}else{

				$(".hide12").hide();

			}

	    }

	    if (type == 1) { //normal auction

	    	if (freeitem == "free")

			{

				$("#additional_shipping_cost").val("0.00");

				$("#additional_shipping_cost").attr("disabled","disabled");

				$("#iqty").removeAttr("disabled","disabled");

				$("#bn_only_no").removeAttr("checked", "checked");

				$("#googleMap").attr("checked", "checked");

				$("#bn_only_yes").attr("checked", "checked");

				$("#bn_no").removeAttr("checked", "checked");

				$("#bn_yes").attr("checked", "checked");

				$("#bn").val("0.00");

				$("#bn").attr("disabled","disabled");

				$("#iqty").val("1");

				$("#minval_text").text("{L_020}");

				$("#min_bid").removeAttr("disabled","disabled");

				$("#min_bid").val("0.00");

				$("#custominc").attr("disabled","disabled");

				$("#inc1").attr("checked", "checked");

				$("#free_item_no").removeAttr("disabled","disabled");

				$("#free_item_yes").removeAttr("disabled","disabled");

				$("#returns").removeAttr("checked", "checked");

				$(".hide1").hide();

				$(".hide2").hide();

				$(".hide3").show();

				$(".hide4").hide();

				$(".hide5").hide();

				$(".hide6").hide();

				$(".hide7").hide();

				$(".hide8").hide();

				$(".hide9").show();

				if(SHIPPINGCONDITION == 'y'){

					$(".hide10").show();

				}else{

					$(".hide10").hide();

				}

				$(".hide11").show();

				if(SHIPPINGTERM == 'y'){

					$(".hide12").show();

				}else{

					$(".hide12").hide();

				}

			}else{

				$("#additional_shipping_cost").val("0.00");

				$("#additional_shipping_cost").attr("disabled","disabled");

				$("#iqty").attr("disabled","disabled");

				$("#bn_only_no").attr("checked", "checked");

				$("#bn_no").attr("checked", "checked");

				$("#bn").val("0.00");

				$("#bn").attr("disabled","disabled");

				$("#iqty").val("1");

				$("#minval_text").text("{L_020}");

				$("#min_bid").removeAttr("disabled","disabled");

				$("#min_bid").val("0.99");

				$("#custominc").attr("disabled","disabled");

				$("#inc1").attr("checked", "checked");

				$("#free_item_no").removeAttr("disabled","disabled");

				$("#free_item_yes").removeAttr("disabled","disabled");

				$("#returns").removeAttr("checked", "checked");

				$("#googleMap").removeAttr("checked", "checked");

				$(".hide1").hide();

				$(".hide2").show();

				$(".hide3").show();

				$(".hide4").hide();

				$(".hide5").show();

				$(".hide6").show();

				$(".hide7").show();

				$(".hide8").show();

				$(".hide9").show();

				if(SHIPPINGCONDITION == 'y'){

					$(".hide10").show();

				}else{

					$(".hide10").hide();

				}

				$(".hide11").show();

				if(SHIPPINGTERM == 'y')

				{

					$(".hide12").show();

				}else{

					$(".hide12").hide();

				}

			}

	    }

	});


	$("#bn_only_no").click(function(){

		$(".hide4").hide();

		$("#additional_shipping_cost").attr("disabled","disabled");

		$("#min_bid").removeAttr("disabled");

		$("#iqty").attr("disabled","disabled");

		$("#bn").val("0.00");

		$("#iqty").val("1");

		$(".hide2").show();

	});

	

	$("#bn_only_yes").click(function(){

		$(".hide4").show();

		$("#additional_shipping_cost").removeAttr("disabled","disabled");

		$("#min_bid").removeAttr("disabled","disabled");

		$("#reserve_price").attr("disabled","disabled");

		$("#iqty").removeAttr("disabled");

		$("#bn_yes").attr("checked", "checked");

		$("#bn").removeAttr("disabled","disabled");

		$("#bn").val("0.99");

		$(".hide2").hide();

	});

	

	$("#with_reserve_yes").click(function(){

		$("#reserve_price").removeAttr("disabled","disabled");

		$("#reserve_price").val("0.99");

	});

		

	$("#with_reserve_no").click(function(){

		$("#reserve_price").attr("disabled","disabled");

		$("#reserve_price").val("0.00");

	});

	

	$("#free_item_yes").focus(function(){

		var atype = $("#atype").find(':selected').val();

		var SHIPPINGTERM = "{SHIPPINGTERM_OPTIONS}";

		var SHIPPINGCONDITION = "{SHIPPINGCONDITION_OPTIONS}";

		if (atype == 3)

		{

			$("#free_item_no").removeAttr("checked", "checked");

			$("#free_item_yes").attr("checked", "checked");

			$(".hide6").hide();

			$(".hide7").hide();

			$(".hide2").hide();

			$(".hide3").hide();

			$(".hide4").hide();

			$(".hide5").hide();

			$(".hide8").hide();

			$(".hide9").hide();

			$(".hide10").hide();

			$(".hide11").hide();

			$(".hide12").hide();

			$("#bn").val("0.00");

			$("#shipping_cost").val("0.00");

			$("#additional_shipping_cost").val("0.00");

			$("#min_bid").val("0.00");

			$("#custominc").val("0.00");

			$("#iqty").removeAttr("disabled","disabled");

			$("#iqty").val("999999");

			$("#returns").removeAttr("checked", "checked");

			$("#googleMap").removeAttr("checked", "checked");

		}

		if (atype == 1)

		{

			$("#free_item_no").removeAttr("checked", "checked");

			$("#free_item_yes").attr("checked", "checked");

			$("#googleMap").removeAttr("checked", "checked");

			$(".hide6").hide();

			$(".hide7").hide();

			$(".hide2").hide();

			$(".hide3").show();

			$(".hide4").hide();

			$(".hide5").hide();

			$(".hide8").hide();

			$(".hide9").show();

			if(SHIPPINGCONDITION == "y"){

				$(".hide10").show();

			}else{

				$(".hide10").hide();

			}

			$(".hide11").show();

			if(SHIPPINGTERM == "y"){

				$(".hide12").show();

			}else{

				$(".hide12").hide();

			}

			$("#bn").val("0.00");

			$("#shipping_cost").val("0.00");

			$("#additional_shipping_cost").val("0.00");

			$("#min_bid").val("0.00");

			$("#custominc").val("0.00");

			$("#iqty").removeAttr("disabled","disabled");

			$("#iqty").val("1");

			$("#returns").removeAttr("checked", "checked");

		}

	});

	

	$("#free_item_no").focus(function(){

		$("#free_item_yes").removeAttr("checked", "checked");

		$("#free_item_no").attr("checked", "checked");

		var atype = $("#atype").find(':selected').val();

		var SHIPPINGTERM = "{SHIPPINGTERM_OPTIONS}";

		var SHIPPINGCONDITION = "{SHIPPINGCONDITION_OPTIONS}";



		if (atype == 3)

		{

			$(".hide1").show();

			$(".hide2").hide();

			$(".hide3").hide();

			$(".hide4").hide();

			$(".hide5").hide();

			$(".hide6").hide();

			$(".hide7").show();

			$(".hide8").hide();

			$(".hide10").hide();

			$(".hide11").show();

			$(".hide12").hide();

			$("#iqty").val("999999");

	        $("#with_reserve_no").attr("checked", "checked");

			$("#bn_only_yes").attr("checked", "checked");

			$("#bn_yes").attr("checked", "checked");

			$("#inc1").attr("checked", "checked");

			$("#iqty").removeAttr("disabled","disabled");

			$("#bn").removeAttr("disabled","disabled");

			$("#custominc").attr("disabled","disabled");

			$("#bn").val("0.99");

			$("#shipping_cost").val("0.00");

			$("#additional_shipping_cost").val("0.00");

			$("#min_bid").val("0.00");

			$("#custominc").val("0.00");

			$("#returns").removeAttr("checked", "checked");

			$("#googleMap").removeAttr("checked", "checked");

		}

		if (atype == 1)

		{

			$(".hide1").hide();

			$(".hide2").show();

			$(".hide3").show();

			$(".hide4").hide();

			$(".hide5").show();

			$(".hide6").show();

			$(".hide7").show();

			$(".hide8").show();

			if(SHIPPINGCONDITION == 'y'){

				$(".hide10").show();

			}else{

				$(".hide10").hide();

			}

			$(".hide11").show();

			if(SHIPPINGTERM == 'y'){

				$(".hide12").show();

			}else{

				$(".hide12").hide();

			}

			$("#additional_shipping_cost").val("0.00");

			$("#additional_shipping_cost").attr("disabled","disabled");

			$("#iqty").attr("disabled","disabled");

			$("#bn_only_no").attr("checked", "checked");

			$("#bn_no").attr("checked", "checked");

			$("#bn").val("0.00");

			$("#bn").attr("disabled","disabled");

			$("#iqty").val("1");

			$("#minval_text").text("{L_020}");

			$("#min_bid").removeAttr("disabled","disabled");

			$("#custominc").attr("disabled","disabled");

			$("#inc1").attr("checked", "checked");

			$("#returns").removeAttr("checked", "checked");

			$("#googleMap").removeAttr("checked", "checked");

		}

	});

	

	$("#bn_yes").click(function(){

		$("#bn").removeAttr("disabled","disabled");

		$("#bn").val("0.99");

	});



	$("#bn_no").click(function(){

		$("#bn_only_no").attr("checked", "checked");

		$("#min_bid").removeAttr("disabled","disabled");

		$("#reserve_price").attr("disabled","disabled");

		$("#iqty").attr("disabled","disabled");

		$("#bn").attr("disabled","disabled");

		$("#iqty").val("1");

		$("#bn").val("0.00");

	});

	

	$("#inc1").focus(function(){

		$("#custominc").attr("disabled","disabled");

	});

	

	$("#inc2").focus(function(){

		$("#custominc").removeAttr("disabled","disabled");

	});





	$("#bps").click(function(){

		$("#shipping_cost").removeAttr("disabled");

	});

	

	$(".sps").click(function(){

		$("#additional_shipping_cost").removeAttr("disabled","disabled");

		$(".hide4").hide();

		$("#shipping_cost").attr("disabled","disabled");

		$("#shipping_cost").val("0.00");

	});


	<!-- IF B_FEES -->

	{FEE_JS}

	// something

	var min_bid_fee = {FEE_MIN_BID};

	var bn = {FEE_BN};

	var rp = {FEE_RP};

	var st = {FEE_SUBTITLE};

	st = st * 1;

	var rl = {FEE_RELIST};

	$("#min_bid").blur(function(){

		var min_bid = parseFloat($("#min_bid").val());

		updatefee(min_bid_fee * -1);

		min_bid_fee = 0; // just incase theres nothing

		if (min_bid == 0) {

			min_bid_fee = 0;

		} else {

			for (var i = 0; i < setup.length; i++) {

				if (setup[i][0] <= min_bid && setup[i][1] >= min_bid) {

					if (setup[i][3] == 'flat') {

						min_bid_fee = setup[i][2];

						updatefee(setup[i][2]);

					} else {

						min_bid_fee = (setup[i][2] / 100) * min_bid;

						updatefee(min_bid_fee);

					}

					break;

				}

			}

		}

	});
	
	function updateBnFee(){

		if (bn != parseInt($("#bn").val())){

			if (parseInt($("#bn").val()) > 0)

				updatefee(buyout_fee);

			else

				updatefee(buyout_fee * -1);

			bn = parseInt($("#bn").val());

		}

	}


	$("#resetbt").click(function(){

		current_fee = current_fee.toFixed({FEE_DECIMALS});

		$("#fee_exact").val(current_fee);

		$("#to_pay").text(current_fee);

	});

	$("#bn").blur(function(){

		updateBnFee();

	});

	$("#bn_yes").click(function(){

		updateBnFee();

	});

	$("#bn_no").click(function(){

		$("#bn").val(0.00);

		updateBnFee();

	});

	$("#reserve_price").blur(function(){

		reserve();

	});

	$("#with_reserve_yes").click(function(){

		reserve();

	});

	$("#with_reserve_no").click(function(){

		$("#reserve_price").val(0.00);

		reserve();

	});

	function reserve(){

		if (rp != parseInt($("#reserve_price").val())){

			if (parseInt($("#reserve_price").val()) > 0)

				updatefee(rp_fee);

			else

				updatefee(rp_fee * -1);

			rp = parseInt($("#reserve_price").val());

		}

	}

	$("#is_featured").click(function(){

		if ($('#is_featured').is(':checked'))

			updatefee(hpfeat_fee);

		else

			updatefee(hpfeat_fee * -1);

	});

	$("#is_bold").click(function(){

		if ($('#is_bold').is(':checked'))

			updatefee(bolditem_fee);

		else

			updatefee(bolditem_fee * -1);

	});

	$("#is_highlighted").click(function(){

		if ($('#is_highlighted').is(':checked'))

			updatefee(hlitem_fee);

		else

			updatefee(hlitem_fee * -1);

	});

	$("#googleMap").click(function(){

		if ($('#googleMap').is(':checked'))

			updatefee(geomap_fee);

		else

			updatefee(geomap_fee * -1);

	});

		<!-- IF B_SUBTITLE -->

	$("#subtitle").blur(function(){

		if (st > 0 && $("#subtitle").val().length == 0)

		{

			updatefee(subtitle_fee * -1);

			st = 0;

		}

		if (st == 0 && $("#subtitle").val().length > 0)

		{

			updatefee(subtitle_fee);

			st = subtitle_fee;

		}

	});

		<!-- ENDIF -->

		<!-- IF B_AUTORELIST -->

	$("#relist").click(function(){

		var rl_times = $("#relist").val();
		
		updatefee(relist_fee * rl * -1);

		updatefee(relist_fee * rl_times);

		rl = rl_times;

	});

		<!-- ENDIF -->

	function updatefee(newfee){

		var nowfee = parseFloat($("#fee_exact").val()) + newfee;

		$("#fee_exact").val(nowfee);

		if (nowfee < 0){

			nowfee = 0;

		}

		nowfee = nowfee.toFixed({FEE_DECIMALS});

		$("#to_pay").text(nowfee);

	}

	<!-- ENDIF -->

});

</script>

<!-- ENDIF -->
<!-- IF PAGE eq 0 or PAGE eq 1 -->
<!-- IF ATYPE_PLAIN eq 1 -->

	<!-- IF FREEITEM eq 'free' -->

		<style type="text/css">

		.hide1

		{

			display: none;

		}

		.hide2

		{

			display: none;

		}

		.hide4

		{

			display: none;

		}

		.hide5

		{

			display: none;

		}

		.hide6

		{

			display: none;

		}

		.hide7

		{

			display: none;

		}

		.hide8

		{

			display: none;

		}

		</style>

	<!-- ELSE -->

		<style type="text/css">

		.hide1 

		{

			display: none;

		}

		.hide4

		{

			display: none;

		}

		</style>

	<!-- ENDIF -->

	<!-- IF SHIPPINGTERM_OPTIONS eq 'n' -->

	<style type="text/css">

		.hide12

		{

			display: none;

		}

	</style>

	<!-- ENDIF -->

	<!-- IF SHIPPINGCONDITION_OPTIONS eq 'n' -->

	<style type="text/css">

		.hide10

		{

			display: none;

		}

	</style>

	<!-- ENDIF -->

<!-- ENDIF -->

<!-- IF ATYPE_PLAIN eq 2 -->

	<style type="text/css">

		.hide1

		{

			display: none;

		}

		.hide5

		{

			display: none;

		}

		.hide6

		{

			display: none;

		}

		.hide7

		{

			display: none;

		}

		.hide8

		{

			display: none;

		}

	</style>

	<!-- IF SHIPPINGTERM_OPTIONS eq n -->

	<style type="text/css">

		.hide12

		{

			display: none;

		}

	</style>

	<!-- ENDIF -->

	<!-- IF SHIPPINGCONDITION_OPTIONS eq n -->

	<style type="text/css">

		.hide10

		{

			display: none;

		}

	</style>

	<!-- ENDIF -->

<!-- ENDIF -->

<!-- IF ATYPE_PLAIN eq 3 -->

	<!-- IF FREEITEM eq 'free' -->

		<style type="text/css">

		.hide2

		{

			display: none;

		}

		.hide3

		{

			display: none;

		}

		.hide4

		{

			display: none;

		}

		.hide5

		{

			display: none;

		}

		.hide6

		{

			display: none;

		}

		.hide7

		{

			display: none;

		}

		.hide8

		{

			display: none;

		}

		.hide9

		{

			display: none;

		}

		.hide10

		{

			display: none;

		}

		.hide11

		{

			display: none;

		}

		.hide12

		{

			display: none;

		}

		</style>

	<!-- ELSE -->

		<style type="text/css">

		.hide2

		{

			display: none;

		}

		.hide3

		{

			display: none;

		}

		.hide4

		{

			display: none;

		}

		.hide5

		{

			display: none;

		}

		.hide6

		{

			display: none;

		}

		.hide8

		{

			display: none;

		}

		.hide9

		{

			display: none;

		}

		.hide10

		{

			display: none;

		}

		.hide12

		{

			display: none;

		}

		</style>

	<!-- ENDIF -->

<!-- ENDIF -->
<!-- ENDIF -->
