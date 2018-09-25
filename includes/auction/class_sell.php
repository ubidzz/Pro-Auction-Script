<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
if (!defined('InProAuctionScript')) exit('Access denied');

class AuctionSetup
{
	public $with_reserve; public $reserve_price; public $minimum_bid; public $pict_url; public $imgtype; public $title; public $subtitle; public $description;
	public $atype; public $iquantity; public $buy_now; public $buy_now_price; public $is_taxed; public $tax_included; public $additional_shipping_cost;
	public $freeItime; public $google_map; public $duration; public $relist; public $increments; public $customincrement; public $shipping; public $shipping_terms;
	public $payment; public $international; public $sellcat1; public $sellcat2; public $buy_now_only; public $a_starts; public $shipping_cost; public $is_bold;
	public $is_highlighted; public $is_featured; public $digital_item; public $item_condition; public $item_manufacturer; public $item_model; public $item_color;
	public $item_year; public $returns; public $start_now; public $auction_id;
	
	private $security; private $system; private $DBPrefix; private $database; private $user; private $listingType; private $conf;
	
	function __construct()
	{
		global $_POST, $DBPrefix, $db, $user;
		
		// system settings
		$this->system = new global_class();
		$this->DBPrefix = $DBPrefix;
		$this->database = $db;
		$this->user = $user;
		$this->security = new security();
		
		// htmLawed settings
		$this->conf = array();
		$this->conf['safe'] = $this->system->SETTINGS['htmLawed_safe'];
		$this->conf['deny_attribute'] = $this->system->SETTINGS['htmLawed_deny_attribute'];
		
		//pre setting the auction sell type based on what is set in the AdminCP
		if($this->system->SETTINGS['auction_setup_types'] == 0) $this->listingType = 'free';
		if($this->system->SETTINGS['auction_setup_types'] == 1) $this->listingType = 'sell';
		if($this->system->SETTINGS['auction_setup_types'] == 2) $this->listingType = 'sell';
	}	
    	
	private function generate_id()
	{
		$query = "SELECT id FROM " . $this->DBPrefix . "auctions";
		$this->database->direct_query($query);
		$idCount = $this->database->numrows('id');
		$newID = $idCount + 1; //Adding 1 to the count so the db id is always the next id
		//Checking to see if we need a new ID or if the ID exists
		if (!isset($_SESSION['SELL_auction_id'])) {
			$id = $newID;
		} else {
			$id = $_SESSION['SELL_auction_id'];
		}
		return $id;
	}
	
	private function checkSessions($variable)
	{
		if($variable == 'with_reserve')
		{
			return ($_SESSION['SELL_with_reserve'] > 0) ? $_SESSION['SELL_with_reserve'] : $this->system->print_money_nosymbol('0.00');
		}
		if($variable == 'reserve_price')
		{
			return ($_SESSION['SELL_reserve_price'] !=0) ? $_SESSION['SELL_reserve_price'] : $this->system->print_money_nosymbol('0.00');
		}
		if($variable == 'minimum_bid')
		{
			if($this->freeItime == 'free')
			{
				return (isset($_SESSION['SELL_minimum_bid']) && $_SESSION['SELL_minimum_bid'] > 0) ? $this->ystem->print_money_nosymbol('0.00') : $this->system->print_money_nosymbol('0.00');
			}else{
				return (isset($_SESSION['SELL_minimum_bid']) && $_SESSION['SELL_minimum_bid'] > $this->system->SETTINGS['default_minbid']) ? $_SESSION['SELL_minimum_bid'] : $this->system->print_money_nosymbol($this->system->SETTINGS['default_minbid']);
			}
		}
		if($variable == 'shipping_cost')
		{
			return (isset($_SESSION['SELL_shipping_cost']) && $_SESSION['SELL_shipping_cost'] > 0) ? $_SESSION['SELL_shipping_cost'] : $this->system->print_money_nosymbol('0.00');
		}
		if($variable == 'additional_shipping_cost')
		{
			return (isset($_SESSION['additional_shipping_cost']) && $_SESSION['additional_shipping_cost'] > 0) ? $_SESSION['additional_shipping_cost'] : $this->system->print_money_nosymbol('0.00');
		}
		if($variable == 'file_uploaded')
		{
			return (isset($_SESSION['SELL_file_uploaded']) && count($_SESSION['SELL_file_uploaded']) > 0) ? $_SESSION['SELL_file_uploaded'] : '';
		}
		if($variable == 'title')
		{
			return (isset($_SESSION['SELL_title']) && $_SESSION['SELL_title'] !='') ? $_SESSION['SELL_title'] : '';
		}
		if($variable == 'subtitle')
		{
			return (isset($_SESSION['SELL_subtitle']) && $_SESSION['SELL_subtitle'] !='') ? $_SESSION['SELL_subtitle'] : '';
		}
		if($variable == 'description')
		{
			return (isset($_SESSION['SELL_description']) && $_SESSION['SELL_description'] !='') ? htmLawed($_SESSION['SELL_description'], $this->conf) : '';
		}
		if($variable == 'pict_url')
		{
			return (isset($_SESSION['SELL_pict_url']) && count($_SESSION['SELL_pict_url']) == 1) ? $_SESSION['SELL_pict_url'] : ''; 
		}
		if($variable == 'atype')
		{
			return (isset($_SESSION['SELL_atype']) && $_SESSION['SELL_atype'] > 1) ? $_SESSION['SELL_atype'] : 1;
		}
		if($variable == 'iquantity')
		{
			return (isset($_SESSION['iquantity']) && $_SESSION['iquantity'] > 1) ? $_SESSION['iquantity'] : ($this->atype == 3) ? 9999 : 1;
		}
		if($variable == 'with_buy_now')
		{
			return (isset($_SESSION['SELL_with_buy_now']) && $_SESSION['SELL_with_buy_now'] == 'y') ? $_SESSION['SELL_with_buy_now'] : 'n';
		}
		if($variable == 'buy_now_price')
		{
			return (isset($_SESSION['SELL_buy_now_price']) && $_SESSION['SELL_buy_now_price'] > 0) ? $_SESSION['SELL_buy_now_price'] : $this->system->print_money_nosymbol('0.00');
		}
		if($variable == 'duration')
		{
			return (isset($_SESSION['SELL_duration']) && $_SESSION['SELL_duration'] > 1) ? $_SESSION['SELL_duration'] : 1;
		}
		if($variable == 'relist')
		{
			return (isset($_SESSION['SELL_relist']) && $_SESSION['SELL_relist'] > 1) ? $_SESSION['SELL_relist'] : 0;
		}
		if($variable == 'increments')
		{
			return (isset($_SESSION['SELL_increments']) && $_SESSION['SELL_increments'] > 0) ? $_SESSION['SELL_increments'] : $this->system->print_money_nosymbol('0.00');
		}
		if($variable == 'customincrement')
		{
			return (isset($_SESSION['SELL_customincrement']) && $_SESSION['SELL_customincrement'] > 0) ? $_SESSION['SELL_customincrement'] : $this->system->print_money_nosymbol('0.00');
		}
		if($variable == 'shipping')
		{
			return (isset($_SESSION['SELL_shipping']) && $_SESSION['SELL_shipping'] !='') ? $_SESSION['SELL_shipping'] : $this->system->print_money_nosymbol('0.00');
		}
		if($variable == 'shipping_terms')
		{
			return (isset($_SESSION['SELL_shipping_terms']) && $_SESSION['SELL_shipping_terms'] !='') ? $_SESSION['SELL_shipping_terms'] : '';
		}
		if($variable == 'payment')
		{
			return (is_array($_SESSION['SELL_payment'])) ? $_SESSION['SELL_payment'] : array();
		}
		if($variable == 'international')
		{
			return (isset($_SESSION['SELL_international']) && $_SESSION['SELL_international'] == 1) ? $_SESSION['SELL_international'] : '';
		}
		if($variable == 'sellcat1')
		{
			return $_SESSION['SELL_sellcat1'];
		}
		if($variable == 'sellcat2')
		{
			return (isset($_SESSION['SELL_sellcat2'])) ? $_SESSION['SELL_sellcat2'] : $this->system->print_money_nosymbol('0.00');
		}
		if($variable == 'buy_now_only')
		{
			return (isset($_SESSION['SELL_buy_now_only']) && $_SESSION['SELL_buy_now_only'] == 'y') ? $_SESSION['SELL_buy_now_only'] : 'n';
		}
		if($variable == 'starts')
		{
			return (isset($_SESSION['SELL_starts']) && $_SESSION['SELL_starts'] > 0) ? $_SESSION['SELL_starts'] : $this->system->CTIME;
		}
		if($variable == 'is_bold')
		{
			return (isset($_SESSION['SELL_is_bold']) && $_SESSION['SELL_is_bold'] == 'y') ? $_SESSION['SELL_is_bold'] : 'n';
		}
		if($variable == 'is_featured')
		{
			return (isset($_SESSION['SELL_is_featured']) && $_SESSION['SELL_is_featured'] == 'y') ? $_SESSION['SELL_is_featured'] : 'n';
		}
		if($variable == 'is_highlighted')
		{
			return (isset($_SESSION['SELL_is_highlighted']) && $_SESSION['SELL_is_highlighted'] == 'y') ? $_SESSION['SELL_is_featured'] : 'n';
		}
		if($variable == 'upload_file')
		{
			return (isset($_SESSION['SELL_upload_file']) !='') ? $_SESSION['SELL_upload_file'] : '';
		}
		if($variable == 'item_condition')
		{
			return (isset($_SESSION['SELL_item_condition']) && $_SESSION['SELL_item_condition'] !='') ? $_SESSION['SELL_item_condition'] : '';
		}
		if($variable == 'item_manufacturer')
		{
			return (isset($_SESSION['SELL_item_manufacturer']) && $_SESSION['SELL_item_manufacturer'] !='') ? $_SESSION['SELL_item_manufacturer'] : '';
		}
		if($variable == 'item_model')
		{
			return (isset($_SESSION['SELL_item_model']) && $_SESSION['SELL_item_model'] !='') ? $_SESSION['SELL_item_model'] : '';
		}
		if($variable == 'item_color')
		{
			return (isset($_SESSION['SELL_item_color']) && $_SESSION['SELL_item_color'] !='') ? $_SESSION['SELL_item_color'] : '';
		}
		if($variable == 'item_year')
		{
			return (isset($_SESSION['SELL_item_year']) && $_SESSION['SELL_item_year'] !='') ? $_SESSION['SELL_item_year'] : '';
		}
		if($variable == 'returns')
		{
			return (isset($_SESSION['SELL_returns']) && $_SESSION['SELL_returns'] > 0) ? $_SESSION['SELL_returns'] : $this->system->print_money_nosymbol('0.00');
		}
		if($variable == 'uploaded_pics')
		{
			return (isset($_SESSION['UPLOADED_PICTURES']) && count($_SESSION['UPLOADED_PICTURES']) > 0) ? $_SESSION['UPLOADED_PICTURES'] : array();
		}
		if($variable == 'geoMap')
		{
			return (!empty($_SESSION['SELL_googleMap']) && $_SESSION['SELL_googleMap'] == 'y') ? $_SESSION['SELL_googleMap'] : 'n';
		}
		if($variable == 'is_taxed')
		{
			return (isset($_SESSION['SELL_is_taxed']) && $_SESSION['SELL_is_taxed'] == 'y') ? $_SESSION['SELL_is_taxed'] : 'n';
		}
		if($variable == 'tax_included')
		{
			return (isset($_SESSION['SELL_tax_included']) && $_SESSION['SELL_tax_included'] == 'y') ? $_SESSION['SELL_tax_included'] : 'n';
		}
	}
	public function buildVariables()
	{
		//including the htmLawed page so that the item description is always cleaned
		include PLUGIN_PATH . 'htmLawed/htmLawed.php';
		
		$this->auction_id = (!isset($_SESSION['SELL_auction_id'])) ? self::generate_id() : $_SESSION['SELL_auction_id'];
		$this->with_reserve = (isset($_POST['with_reserve'])) ? $_POST['with_reserve'] : self::checkSessions('with_reserve');
		$this->reserve_price = (isset($_POST['reserve_price'])) ? $_POST['reserve_price'] : self::checkSessions('reserve_price');
		$this->minimum_bid = (isset($_POST['minimum_bid'])) ? $_POST['minimum_bid'] : self::checkSessions('minimum_bid');
		$this->default_minbid = $this->system->print_money_nosymbol($this->system->SETTINGS['default_minbid']);
		$this->shipping_cost = (isset($_POST['shipping_cost'])) ? $_POST['shipping_cost'] : self::checkSessions('shipping_cost');
		$this->additional_shipping_cost = (isset($_POST['additional_shipping_cost'])) ? $_POST['additional_shipping_cost'] : self::checkSessions('additional_shipping_cost');
		$this->imgtype = (isset($_POST['imgtype'])) ? $_POST['imgtype'] : '';
		$this->title = (isset($_POST['auctionTitle'])) ? $_POST['auctionTitle'] : self::checkSessions('title');
		$this->subtitle = (isset($_POST['subtitle'])) ? $_POST['subtitle'] : self::checkSessions('subtitle');
		$this->description = (isset($_POST['itemDescription'])) ? htmLawed($_POST['itemDescription'], $this->conf) : self::checkSessions('description');
		$this->pict_url = (isset($_POST['pict_url'])) ? $_POST['pict_url'] : self::checkSessions('pict_url');
		$this->atype = (isset($_POST['atype'])) ? $_POST['atype'] : self::checkSessions('atype');
		$this->iquantity = (isset($_POST['iquantity'])) ? $_POST['iquantity'] : self::checkSessions('iquantity');
		$this->buy_now = (isset($_POST['buy_now'])) ? $_POST['buy_now'] : self::checkSessions('buy_now');
		$this->buy_now_price = (isset($_POST['buy_now_price'])) ? $_POST['buy_now_price'] : self::checkSessions('buy_now_price');
		$this->duration = (isset($_POST['duration'])) ? $_POST['duration'] : self::checkSessions('duration');
		$this->relist = (isset($_POST['autorelist'])) ? $_POST['autorelist'] : self::checkSessions('relist');
		$this->increments = (isset($_POST['increments'])) ? $_POST['increments'] : self::checkSessions('increments');
		$this->customincrement = (isset($_POST['customincrement'])) ? $_POST['customincrement'] : self::checkSessions('customincrement');
		$this->shipping = (isset($_POST['shipping'])) ? $_POST['shipping'] : self::checkSessions('shipping');
		$this->shipping_terms = (isset($_POST['shipping_terms'])) ? $_POST['shipping_terms'] : self::checkSessions('shipping_terms');
		$this->payment = (isset($_POST['payment'])) ? $_POST['payment'] : self::checkSessions('payment');
		$this->international = (isset($_POST['international'])) ? $_POST['international'] : self::checkSessions('international'); 
		$this->sellcat1 = self::checkSessions('sellcat1');
		$this->sellcat2 = self::checkSessions('sellcat2');
		$this->buy_now_only = (isset($_POST['buy_now_only'])) ? $_POST['buy_now_only'] : self::checkSessions('buy_now_only');
		$this->a_starts = (isset($_POST['a_starts'])) ? $_POST['a_starts'] : self::checkSessions('starts');
		$this->is_bold = (isset($_POST['is_bold']) && $_POST['is_bold'] == 'y') ? $_POST['is_bold'] : self::checkSessions('is_bold');
		$this->is_featured = (isset($_POST['is_featured']) && $_POST['is_featured'] == 'y') ? 'y' : self::checkSessions('is_featured');
		$this->is_highlighted = (isset($_POST['is_highlighted']) && $_POST['is_highlighted'] == 'y') ? 'y' : self::checkSessions('is_highlighted');
		$this->digital_item = self::checkSessions('upload_file');
		$this->item_condition = (isset($_POST['item_condition'])) ? $_POST['item_condition'] : self::checkSessions('item_condition');
		$this->item_manufacturer = (isset($_POST['item_manufacturer'])) ? $_POST['item_manufacturer'] : self::checkSessions('item_manufacturer');
		$this->item_model = (isset($_POST['item_model'])) ? $_POST['item_model'] : self::checkSessions('item_model');
		$this->item_color = (isset($_POST['item_color'])) ? $_POST['item_color'] : self::checkSessions('item_color');
		$this->item_year = (isset($_POST['item_year'])) ? $_POST['item_year'] : self::checkSessions('item_year');
		$this->returns = (isset($_POST['returns'])) ? $_POST['returns'] : self::checkSessions('returns');
		$this->uploaded_pictures = self::checkSessions('uploaded_pics');
		$this->google_map = (isset($_POST['geoMap'])) ? $_POST['geoMap'] : self::checkSessions('geoMap');
		$this->is_taxed = (isset($_POST['is_taxed'])) ? 'y' : self::checkSessions('is_taxed');
		$this->tax_included = (isset($_POST['tax_included'])) ? 'y' : self::checkSessions('tax_included');
		
		if(isset($_SESSION['SELL_ends'])) $this->ends = $_SESSION['SELL_ends'];
		if (isset($_POST['sellType'])) $this->freeItime = $_POST['sellType'];
		elseif (!isset($_SESSION['SELL_sell_type'])) $this->freeItime = $this->listingType;
		else $this->freeItime = $_SESSION['SELL_sell_type'];
			
		if (isset($_POST['a_starts'])) {
			if (isset($_POST['start_now'])) {
				$this->start_now = 1;
			} else {
				$this->start_now = 0;
			}
		} else {
			if(isset($_SESSION['SELL_start_now']))
			{
				$this->start_now = $_SESSION['SELL_start_now'];
			}else{
				$this->start_now = 0;
			}
		}
		self::buildSessions();
	}
	
	private function buildSessions()
	{		
		$_SESSION['SELL_auction_id'] = $this->auction_id;
		$_SESSION['SELL_with_reserve'] = $this->with_reserve;
		$_SESSION['SELL_reserve_price'] = $this->reserve_price;
		$_SESSION['SELL_minimum_bid'] = $this->minimum_bid;
		$_SESSION['SELL_shipping_cost'] = $this->shipping_cost;
		$_SESSION['SELL_additional_shipping_cost'] = $this->additional_shipping_cost;
		$_SESSION['SELL_file_uploaded'] = $this->imgtype;
		$_SESSION['SELL_title'] = $this->title;
		$_SESSION['SELL_subtitle'] = $this->subtitle;
		$_SESSION['SELL_description'] = $this->description;
		$_SESSION['SELL_pict_url'] = $this->pict_url;
		$_SESSION['SELL_atype'] = $this->atype;
		$_SESSION['SELL_iquantity'] = $this->iquantity;
		$_SESSION['SELL_with_buy_now'] = $this->buy_now;
		$_SESSION['SELL_buy_now_price'] = $this->buy_now_price;
		$_SESSION['SELL_duration'] = $this->duration;
		$_SESSION['SELL_relist'] = $this->relist;
		$_SESSION['SELL_increments'] = $this->increments;
		$_SESSION['SELL_customincrement'] = $this->customincrement;
		$_SESSION['SELL_shipping'] = $this->shipping;
		$_SESSION['SELL_shipping_terms'] = $this->shipping_terms;
		$_SESSION['SELL_payment'] = $this->payment;
		$_SESSION['SELL_international'] = $this->international;
		$_SESSION['SELL_buy_now_only'] = $this->buy_now_only;
		$_SESSION['SELL_starts'] = $this->a_starts;
		$_SESSION['SELL_is_bold'] = $this->is_bold;
		$_SESSION['SELL_is_highlighted'] = $this->is_highlighted;
		$_SESSION['SELL_is_featured'] = $this->is_featured;
		$_SESSION['SELL_start_now'] = $this->start_now;
		$_SESSION['SELL_is_taxed'] = $this->is_taxed;
		$_SESSION['SELL_tax_included'] = $this->tax_included;
		$_SESSION['SELL_upload_file'] = $this->digital_item;
		$_SESSION['SELL_item_condition'] = $this->item_condition;
		$_SESSION['SELL_item_manufacturer'] = $this->item_manufacturer;
		$_SESSION['SELL_item_model'] = $this->item_model;
		$_SESSION['SELL_item_color'] = $this->item_color;
		$_SESSION['SELL_item_year'] = $this->item_year;
		$_SESSION['SELL_returns'] = $this->returns;
		$_SESSION['SELL_sell_type'] = $this->freeItime;
		$_SESSION['SELL_googleMap'] = $this->google_map;
		$_SESSION['SELL_sellcat2'] = $this->sellcat2;
		$_SESSION['SELL_ends'] = isset($this->ends) ? $this->ends : '';
	}
	
	public function unsetBuildSessions()
	{	
		unset($_SESSION['SELL_with_reserve']);
		unset($_SESSION['SELL_reserve_price']);
		unset($_SESSION['SELL_minimum_bid']);
		unset($_SESSION['SELL_shipping_cost']);
		unset($_SESSION['SELL_additional_shipping_cost']);
		unset($_SESSION['SELL_file_uploaded']);
		unset($_SESSION['SELL_title']);
		unset($_SESSION['SELL_subtitle']);
		unset($_SESSION['SELL_description']);
		unset($_SESSION['SELL_pict_url']);
		unset($_SESSION['SELL_pict_url_temp']);
		unset($_SESSION['SELL_atype']);
		unset($_SESSION['SELL_iquantity']);
		unset($_SESSION['SELL_with_buy_now']);
		unset($_SESSION['SELL_buy_now_price']);
		unset($_SESSION['SELL_duration']);
		unset($_SESSION['SELL_relist']);
		unset($_SESSION['SELL_increments']);
		unset($_SESSION['SELL_customincrement']);
		unset($_SESSION['SELL_shipping']);
		unset($_SESSION['SELL_shipping_terms']);
		unset($_SESSION['SELL_payment']);
		unset($_SESSION['SELL_international']);
		unset($_SESSION['SELL_sendemail']);
		unset($_SESSION['SELL_starts']);
		unset($_SESSION['SELL_action']);
		unset($_SESSION['SELL_is_bold']);
		unset($_SESSION['SELL_is_highlighted']);
		unset($_SESSION['SELL_is_featured']);
		unset($_SESSION['SELL_start_now']);
		unset($_SESSION['SELL_is_taxed']);
		unset($_SESSION['SELL_tax_included']);
		unset($_SESSION['SELL_upload_file']);
		unset($_SESSION['SELL_item_condition']);
		unset($_SESSION['SELL_item_manufacturer']);
		unset($_SESSION['SELL_item_model']);
		unset($_SESSION['SELL_item_color']);
		unset($_SESSION['SELL_item_year']);
		unset($_SESSION['SELL_digital_item']);
		unset($_SESSION['SELL_returns']);
		unset($_SESSION['SELL_upload_file']);
		unset($_SESSION['SELL_sell_type']);
		unset($_SESSION['SELL_googleMap']);
		unset($_SESSION['SELL_sellcat2']);
	}
	//update auction database
	public function updateauction($type)
	{
		global $payment_text, $fee;
		
		//only runs if the auction is being relisted
		$extraquery = $type == 2 ? ",relisted = relisted + 1, current_bid = 0, starts = '" . $this->a_starts . "', num_bids = 0" : '';
		
		//sorting the bool coding
		$minimum_bid = $this->system->input_money($this->buy_now_only == 'n' ? $this->minimum_bid : $this->buy_now_price);
		$reserve_price = $this->system->input_money($this->with_reserve == 'yes' ? $this->reserve_price : 0);
		$buy_now = $this->system->input_money($this->buy_now == 'yes' ? $this->buy_now_price : 0);
		$international = $this->international ? 1 : 0;
		$photo_uploaded = $this->imgtype == 1 ? 1 : 0;
		$returns = $this->returns == 1 ? 1 : 0;
		
		$query = "UPDATE " . $this->DBPrefix . "auctions SET title = :title, subtitle = :subtitle, description = :description, pict_url = :pict_url, category = :category,
			secondcat = :secondcat, minimum_bid = :minimum_bid, shipping_cost = :shipping_cost, shipping_cost_additional = :shipping_cost_additional, reserve_price = :reserve_price,
			buy_now = :buy_now, bn_only = :bn_only, auction_type = :auction_type, duration = :duration, increment = :increment, shipping = :shipping, payment = :payment_text, 
			international = :international, ends = :a_ends, photo_uploaded = :photo_uploaded, quantity = :quantity, relist = :relist, shipping_terms = :shipping_terms, 
			closed = 0, bold = :bold, highlighted = highlighted, featured = :featured, tax = :tax, taxinc = :taxinc, item_condition = :item_condition, 
			item_manufacturer = :item_manufacturer, item_model = :item_model, item_color = :item_color, item_year = :item_year, returns = :returns, sell_type = :sell_type,
			locationMap = :locationMap, current_fee = current_fee + " . $fee . $extraquery . " WHERE id = :auc_id";
		$params = array(
			array(':title', stripslashes($this->title), 'str'),
			array(':subtitle', stripslashes($this->subtitle), 'str'),
			array(':description', $this->description, 'str'),
			array(':pict_url', $this->system->cleanvars($this->pict_url), 'str'),
			array(':category', $this->sellcat1, 'int'),
			array(':secondcat', $this->sellcat2, 'int'),
			array(':minimum_bid', $minimum_bid, 'float'),
			array(':shipping_cost', $this->system->input_money($this->shipping_cost), 'float'),
			array(':shipping_cost_additional', $this->system->input_money($this->additional_shipping_cost), 'float'),
			array(':reserve_price', $reserve_price, 'float'),
			array(':buy_now', $buy_now, 'float'),
			array(':bn_only', $this->buy_now_only, 'bool'),
			array(':auction_type', $this->atype, 'str'),
			array(':duration', $this->duration, 'str'),
			array(':increment', $this->system->input_money($this->customincrement), 'float'),
			array(':shipping', $this->shipping, 'str'),
			array(':payment_text', $payment_text, 'str'),
			array(':international', $international, 'str'),
			array(':a_ends', $this->ends, 'int'),
			array(':photo_uploaded', $photo_uploaded, 'str'),
			array(':quantity', $this->iquantity, 'int'),
			array(':relist', $this->relist, 'int'),
			array(':shipping_terms', $this->system->cleanvars($this->shipping_terms), 'str'),
			array(':bold', $this->is_bold, 'bool'),
			array(':highlighted', $this->is_highlighted, 'bool'),
			array(':featured', $this->is_featured, 'bool'),
			array(':tax', $this->is_taxed, 'bool'),
			array(':taxinc', $this->is_taxed, 'bool'),
			array(':item_condition', $this->item_condition, 'str'),
			array(':item_manufacturer', $this->item_manufacturer, 'str'),
			array(':item_model', $this->item_model, 'str'),
			array(':item_color', $this->item_color, 'str'),
			array(':item_year', $this->item_year, 'str'),
			array(':returns', $returns, 'int'),
			array(':sell_type', $this->freeItime, 'bool'),
			array(':locationMap', $this->google_map, 'bool'),
			array(':auc_id', $this->auction_id, 'int')
		);
		$this->database->query($query, $params);
		self::unsetBuildSessions();
	}
	
	//add new auction to database
	public function addauction()
	{
		global $a_starts, $payment_text, $fee;
		
		//Predetermining the bool Variables
		$min_bid = $this->system->input_money($this->buy_now_only == 'n' ? $this->minimum_bid : $this->buy_now_price);
		$reserve_price = $this->system->input_money($this->with_reserve == 'yes' ? $this->reserve_price : 0);
		$bn_price = $this->system->input_money($this->buy_now == 'yes' ? $this->buy_now_price : 0);
		$international = $this->international ? 1 : 0;
		$file_uploaded = $this->imgtype ? 1 : 0;
		$returns = $this->returns ? 1 : 0;
		
		$query = "INSERT INTO " . $this->DBPrefix . "auctions (user,title,subtitle,starts,description,pict_url,category,secondcat,minimum_bid,shipping_cost,shipping_cost_additional,reserve_price,buy_now,auction_type,duration,increment,shipping,payment,international,ends,photo_uploaded,quantity,relist,shipping_terms,bn_only,bold,highlighted,featured,current_fee,tax,taxinc, item_condition, item_manufacturer, item_model, item_color, item_year, returns, sell_type, locationMap) VALUES
			(:seller_id, :auction_title, :auction_subtitle, :auction_start, :auction_description, :auction_pict_url, :auction_sellcat1, :auction_sellcat2, :auction_minimum_bid, :auction_shipping_cost, :auction_additional_shipping_cost, :auction_reserve_price, :auction_bn_price, :auction_atype, :auction_duration, :auction_customincrement, :auction_shipping, :auction_payment_text, :auction_international, :auction_ends, :auction_file_uploaded, :auction_iquantity, :auction_relist, :auction_shipping_terms, :auction_buy_now_only, :auction_is_bold, :auction_is_highlighted, :auction_is_featured, :auction_fee, :auction_is_taxed, :auction_tax_included, :auction_item_condition, :auction_item_manufacturer, 
			:auction_item_model, :auction_item_color, :auction_item_year, :auction_returns, :auction_sell_type, :auction_googleMap)";
		$params = array(
			array(':seller_id', $this->user->user_data['id'], 'int'),
			array(':auction_title', stripslashes($this->title), 'str'),
			array(':auction_subtitle', stripslashes($this->subtitle), 'str'),
			array(':auction_start', $a_starts, 'int'),
			array(':auction_description', addslashes($this->description), 'str'),
			array(':auction_pict_url', $this->system->cleanvars($this->pict_url), 'str'),
			array(':auction_sellcat1', $this->sellcat1, 'int'),
			array(':auction_sellcat2', $this->sellcat2, 'int'),
			array(':auction_minimum_bid', $min_bid, 'float'),
			array(':auction_shipping_cost', $this->system->input_money($this->shipping_cost), 'float'),
			array(':auction_additional_shipping_cost', $this->system->input_money($this->additional_shipping_cost), 'float'),
			array(':auction_reserve_price', $this->system->input_money($reserve_price), 'float'),
			array(':auction_bn_price', $this->system->input_money($bn_price), 'float'),
			array(':auction_atype', $this->atype, 'int'),
			array(':auction_duration', $this->duration, 'int'),
			array(':auction_customincrement', $this->system->input_money($this->customincrement), 'float'),
			array(':auction_shipping', $this->shipping, 'int'),
			array(':auction_payment_text', $payment_text, 'str'),
			array(':auction_international', $international, 'int'),
			array(':auction_ends', $this->ends, 'int'),
			array(':auction_file_uploaded', $file_uploaded, 'int'),
			array(':auction_iquantity', $this->iquantity, 'int'),
			array(':auction_relist', $this->relist, 'int'),
			array(':auction_shipping_terms', $this->system->cleanvars($this->shipping_terms), 'str'),
			array(':auction_buy_now_only', $this->buy_now_only, 'bool'),
			array(':auction_is_bold', $this->is_bold, 'bool'),
			array(':auction_is_highlighted', $this->is_highlighted, 'bool'),
			array(':auction_is_featured', $this->is_featured, 'bool'),
			array(':auction_fee', $this->system->input_money($fee), 'float'),
			array(':auction_is_taxed', $this->is_taxed, 'bool'),
			array(':auction_tax_included', $this->tax_included, 'bool'),
			array(':auction_item_condition', $this->system->cleanvars($this->item_condition), 'str'),
			array(':auction_item_manufacturer', $this->system->cleanvars($this->item_manufacturer), 'str'),
			array(':auction_item_model', $this->system->cleanvars($this->item_model), 'str'),
			array(':auction_item_color', $this->system->cleanvars($this->item_color), 'str'),
			array(':auction_item_year', $this->item_year, 'int'),
			array(':auction_returns', $returns, 'int'),
			array(':auction_sell_type', $this->freeItime, 'str'),
			array(':auction_googleMap', empty($this->google_map) ? 'n' : $this->google_map, 'bool')
		);
		$this->database->query($query, $params);
		$this->auction_id = $this->database->lastInsertId();
		if($this->auction_id > 0)
		{
			return $this->auction_id;
		}else{
			return 0;
		}
	}

	public function remove_bids($auction_id)
	{
		$query = "DELETE FROM " . $this->DBPrefix . "bids WHERE auction = :auction_id";
		$params = array(
			array(':auction_id', $auction_id, 'int')
		);
		$this->database->query($query, $params);
	}
	
	public function update_cat_counters($add, $category)
	{	
		global $catscontrol;
		$query = "SELECT left_id, right_id, level FROM " . $this->DBPrefix . "categories WHERE cat_id = :cat_id";
		$params = array(
			array(':cat_id', $category, 'int')
		);
		$this->database->query($query, $params);
		
		$parent_node = $this->database->result();
		$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
	
		$addsub = ($add) ? '+' : '-';
		for ($i = 0; $i < count($crumbs); $i++)
		{
			$query = "UPDATE " . $this->DBPrefix . "categories SET sub_counter = sub_counter " . $addsub . " 1 WHERE cat_id = :cat_id";
			$params = array(
				array(':cat_id', $crumbs[$i]['cat_id'], 'int')
			);
			$this->database->query($query, $params);
		}
	}
	
	public function get_category_string($sellcat)
	{
		global $catscontrol, $category_names;
	
		if (empty($sellcat) || !isset($sellcat))
			return '';
	
		$query = "SELECT left_id, right_id, level FROM " . $this->DBPrefix . "categories WHERE cat_id = :cat_id";
		$params = array(
			array(':cat_id', $sellcat, 'int')
		);
		$this->database->query($query, $params);
		$parent_node = $this->database->result();
	
		$TPL_categories_list = '';
		$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
		for ($i = 0; $i < count($crumbs); $i++)
		{
			if ($crumbs[$i]['cat_id'] > 0)
			{
				if ($i > 0)
				{
					$TPL_categories_list .= ' <img class="bc_divider" src="images/bc_divider.png" alt="">';
				}
				$TPL_categories_list .= $category_names[$crumbs[$i]['cat_id']];
			}
		}
		return $TPL_categories_list;
	}
	
	/// Work out the auction setup fees
	public function fee_amount()
	{
		$query = "SELECT * FROM " . $this->DBPrefix . "fees ORDER BY type, fee_from ASC";
			$this->database->direct_query($query);
		
		$fee_value = 0;
		$fee_data = array(
		  	'setup' => 0,
		   	'buyout_fee' => 0,
		   	'rp_fee' => 0,
		   	'bolditem_fee' => 0,
		   	'hlitem_fee' => 0,
		   	'geomap_fee' => 0,
		   	'hpfeat_fee' => 0,
		  	'picture_fee' => 0,
		  	'subtitle_fee' => 0,
		   	'excat_fee' => 0,
		 	'relist_fee' => 0
		);

		if(!$this->user->no_fees)
		{		    
		    while ($row = $this->database->fetch())
			{
				if ($this->minimum_bid >= $row['fee_from'] && $this->minimum_bid <= $row['fee_to'] && $row['type'] == 'setup' && !$this->user->no_setup_fee)
				{
					if ($row['fee_type'] == 'flat')
					{
						$fee_data['setup'] = $row['value'];
						$fee_value = bcadd($fee_value, $row['value'], $this->system->SETTINGS['moneydecimals']);
					}
					else
					{
						$tmp = bcdiv($row['value'], '100', $this->system->SETTINGS['moneydecimals']);
						$tmp = bcmul($tmp, $this->minimum_bid, $this->system->SETTINGS['moneydecimals']);
						$fee_data['setup'] = $tmp;
						$fee_value = bcadd($fee_value, $tmp, $this->system->SETTINGS['moneydecimals']);
					}
				}
				if ($row['type'] == 'buyout_fee' && $this->buy_now_price > 0 && !$this->user->no_buyout_fee)
				{
					$fee_data['buyout_fee'] = $row['value'];
					$fee_value = bcadd($fee_value, $row['value'], $this->system->SETTINGS['moneydecimals']);
				}
				if ($row['type'] == 'rp_fee' && $this->reserve_price > 0 && !$this->user->no_rp_fee)
				{
					$fee_data['rp_fee'] = $row['value'];
					$fee_value = bcadd($fee_value, $row['value'], $this->system->SETTINGS['moneydecimals']);
				}
				if ($row['type'] == 'bolditem_fee' && $this->is_bold == 'y' && !$this->user->no_bolditem_fee)
				{
					$fee_data['bolditem_fee'] = $row['value'];
					$fee_value = bcadd($fee_value, $row['value'], $this->system->SETTINGS['moneydecimals']);
				}
				if ($row['type'] == 'hlitem_fee' && $this->is_highlighted == 'y' && !$this->user->no_hlitem_fee)
				{
					$fee_data['hlitem_fee'] = $row['value'];
					$fee_value = bcadd($fee_value, $row['value'], $this->system->SETTINGS['moneydecimals']);
				}
				if ($row['type'] == 'geomap_fee' && $this->google_map == 'y' && !$this->user->no_geomap_fee)
				{
					$fee_data['geomap_fee'] = $row['value'];
					$fee_value = bcadd($fee_value, $row['value'], $this->system->SETTINGS['moneydecimals']);
				}
				if ($row['type'] == 'hpfeat_fee' && $this->is_featured == 'y' && !$this->user->no_hpfeat_fee)
				{
					$fee_data['hpfeat_fee'] = $row['value'];
					$fee_value = bcadd($fee_value, $row['value'], $this->system->SETTINGS['moneydecimals']);
				}
				if ($row['type'] == 'picture_fee' && count($_SESSION['UPLOADED_PICTURES']) > 0 && !$this->user->no_picture_fee)
				{
					//count the total number of pictures uploaded and subtract the max. free pictures allowed
					$picCount = count($_SESSION['UPLOADED_PICTURES']);
					if ($picCount > $this->system->SETTINGS['freemaxpictures'])
					{
						$totalPic = $picCount - $this->system->SETTINGS['freemaxpictures'];
						$tmp = bcmul($totalPic, $row['value'], $this->system->SETTINGS['moneydecimals']);
					}else{
						$tmp = "0.00";
					}
					$fee_data['picture_fee'] = $tmp;
					$fee_value = bcadd($fee_value, $tmp, $this->system->SETTINGS['moneydecimals']);
				}
				if ($row['type'] == 'subtitle_fee' && !empty($this->subtitle) && !$this->user->no_subtitle_fee)
				{
					$fee_data['subtitle_fee'] = $row['value'];
					$fee_value = bcadd($fee_value, $row['value'], $this->system->SETTINGS['moneydecimals']);
				}
				if ($row['type'] == 'excat_fee' && $this->sellcat2 > 0 && !$this->user->no_excat_fee)
				{
					$fee_data['excat_fee'] = $row['value'];
					$fee_value = bcadd($fee_value, $row['value'], $this->system->SETTINGS['moneydecimals']);
				}
				if ($row['type'] == 'relist_fee' && $this->relist > 0 && !$this->user->no_relist_fee)
				{
					$fee_data['relist_fee'] = ($row['value'] * $this->relist);
					$fee_value = bcadd($fee_value, ($row['value'] * $this->relist), $this->system->SETTINGS['moneydecimals']);
				}
			}
			return $fee_data;
		}
	}
	public function get_fee($minimum_bid, $just_fee = true)
	{
		if ($_SESSION['SELL_action'] == 'edit' && !$this->user->no_fees)
		{
			$query = "SELECT * FROM " . $this->DBPrefix . "useraccounts WHERE auc_id = :auction_id AND user_id = :user_id";
			$params = array(
				array(':auction_id', $_SESSION['SELL_auction_id'], 'int'),
				array(':user_id', $this->user->user_data['id'], 'int')
			);
			$this->database->query($query, $params);
			// build an array full of everything the user has been charged for the auction do far
			$past_fees = array();
			while ($row = $this->database->result())
			{
				foreach ($row as $k => $v)
				{
					if (isset($past_fees[$k]))
					{
						$past_fees[$k] += $v;
					}
					else
					{
						$past_fees[$k] = $v;
					}
				}
			}
	
			$diff = 0; // difference from last payment
			$fee_data['setup'] = 0; // shouldn't have to pay setup for an edit...
			$diff = isset($past_fees['setup']) ? bcadd($diff, $past_fees['setup'], $this->system->SETTINGS['moneydecimals']) : 0;
			if (isset($fee_data['bolditem_fee']) && $past_fees['bold'] == $fee_data['bolditem_fee'] && !$this->user->no_bolditem_fee)
			{
				$diff = bcadd($diff, $fee_data['bolditem_fee'], $this->system->SETTINGS['moneydecimals']);
				$fee_data['bolditem_fee'] = 0;
			}
			if (isset($fee_data['hlitem_fee']) && $past_fees['highlighted'] == $fee_data['hlitem_fee'] && !$this->user->no_hlitem_fee)
			{
				$diff = bcadd($diff, $fee_data['hlitem_fee'], $this->system->SETTINGS['moneydecimals']);
				$fee_data['hlitem_fee'] = 0;
			}
			if (isset($fee_data['geomap_fee']) && $past_fees['geomap'] == $fee_data['geomap_fee'] && !$this->user->no_geomap_fee)
			{
				$diff = bcadd($diff, $fee_data['geomap_fee'], $this->system->SETTINGS['moneydecimals']);
				$fee_data['geomap_fee'] = 0;
			}
			if (isset($fee_data['subtitle_fee']) && $past_fees['subtitle'] == $fee_data['subtitle_fee'] && !$this->user->no_subtitle_fee)
			{
				$diff = bcadd($diff, $fee_data['subtitle_fee'], $this->system->SETTINGS['moneydecimals']);
				$fee_data['subtitle_fee'] = 0;
			}
			if (isset($fee_data['relist_fee']) && $past_fees['relist'] == $fee_data['relist_fee'] && !$this->user->no_relist_fee)
			{
				$diff = bcadd($diff, $fee_data['relist_fee'], $this->system->SETTINGS['moneydecimals']);
				$fee_data['relist_fee'] = 0;
			}
			if (isset($fee_data['rp_fee']) && $past_fees['reserve'] == $fee_data['rp_fee'] && !$this->user->no_rp_fee)
			{
				$diff = bcadd($diff, $fee_data['rp_fee'], $this->system->SETTINGS['moneydecimals']);
				$fee_data['rp_fee'] = 0;
			}
			if (isset($fee_data['buyout_fee']) && $past_fees['buynow'] == $fee_data['buyout_fee'] && !$this->user->no_buyout_fee)
			{
				$diff = bcadd($diff, $fee_data['buyout_fee'], $this->system->SETTINGS['moneydecimals']);
				$fee_data['buyout_fee'] = 0;
			}
			if (isset($fee_data['picture_fee']) && $past_fees['image'] == $fee_data['picture_fee'] && !$this->user->no_picture_fee)
			{
				$diff = bcadd($diff, $fee_data['picture_fee'], $this->system->SETTINGS['moneydecimals']);
				$fee_data['picture_fee'] = 0;
			}
			if (isset($fee_data['excat_fee']) && $past_fees['extcat'] == $fee_data['excat_fee'] && !$this->user->no_excat_fee)
			{
				$diff = bcadd($diff, $fee_data['excat_fee'], $this->system->SETTINGS['moneydecimals']);
				$fee_data['excat_fee'] = 0;
			}
			$fee_value = isset($fee_value) ? bcsub($fee_value, $diff, $this->system->SETTINGS['moneydecimals']) : 0;
			if ($fee_value < 0)
			{
				$fee_value = 0;
			}
		}
		else
		{
			$query = "SELECT * FROM " . $this->DBPrefix . "fees ORDER BY type, fee_from ASC";
			$this->database->direct_query($query);
		
			$fee_value = 0;
			$fee_data = array(
		        'setup' => 0,
		        'buyout_fee' => 0,
		        'rp_fee' => 0,
		        'bolditem_fee' => 0,
		        'hlitem_fee' => 0,
		        'geomap_fee' => 0,
		        'hpfeat_fee' => 0,
		        'picture_fee' => 0,
		        'subtitle_fee' => 0,
		        'excat_fee' => 0,
		        'relist_fee' => 0
		    );
			if(!$this->user->no_fees)
			{
				while ($row = $this->database->fetch())
				{
					if ($minimum_bid >= $row['fee_from'] && $minimum_bid <= $row['fee_to'] && $row['type'] == 'setup' && !$this->user->no_setup_fee)
					{
						if ($row['fee_type'] == 'flat')
						{
							$fee_data['setup'] = $row['value'];
							$fee_value = bcadd($fee_value, $row['value'], $this->system->SETTINGS['moneydecimals']);
						}
						else
						{
							$tmp = bcdiv($row['value'], '100', $this->system->SETTINGS['moneydecimals']);
							$tmp = bcmul($tmp, $minimum_bid, $this->system->SETTINGS['moneydecimals']);
							$fee_data['setup'] = $tmp;
							$fee_value = bcadd($fee_value, $tmp, $this->system->SETTINGS['moneydecimals']);
						}
					}
					if ($row['type'] == 'buyout_fee' && $this->buy_now_price > 0 && !$this->user->no_buyout_fee)
					{
						$fee_data['buyout_fee'] = $row['value'];
						$fee_value = bcadd($fee_value, $row['value'], $this->system->SETTINGS['moneydecimals']);
					}
					if ($row['type'] == 'rp_fee' && $this->reserve_price > 0 && !$this->user->no_rp_fee)
					{
						$fee_data['rp_fee'] = $row['value'];
						$fee_value = bcadd($fee_value, $row['value'], $this->system->SETTINGS['moneydecimals']);
					}
					if ($row['type'] == 'bolditem_fee' && $this->is_bold == 'y' && !$this->user->no_bolditem_fee)
					{
						$fee_data['bolditem_fee'] = $row['value'];
						$fee_value = bcadd($fee_value, $row['value'], $this->system->SETTINGS['moneydecimals']);
					}
					if ($row['type'] == 'hlitem_fee' && $this->is_highlighted == 'y' && !$this->user->no_hlitem_fee)
					{
						$fee_data['hlitem_fee'] = $row['value'];
						$fee_value = bcadd($fee_value, $row['value'], $this->system->SETTINGS['moneydecimals']);
					}
					if ($row['type'] == 'geomap_fee' && $this->google_map == 'y' && !$this->user->no_geomap_fee)
					{
						$fee_data['geomap_fee'] = $row['value'];
						$fee_value = bcadd($fee_value, $row['value'], $this->system->SETTINGS['moneydecimals']);
					}
					if ($row['type'] == 'hpfeat_fee' && $this->is_featured == 'y' && !$this->user->no_hpfeat_fee)
					{
						$fee_data['hpfeat_fee'] = $row['value'];
						$fee_value = bcadd($fee_value, $row['value'], $this->system->SETTINGS['moneydecimals']);
					}
					if ($row['type'] == 'picture_fee' && count($_SESSION['UPLOADED_PICTURES']) > 0 && !$this->user->no_picture_fee)
					{
						//count the total number of pictures uploaded and subtract the max. free pictures allowed
						$picCount = count($_SESSION['UPLOADED_PICTURES']);
						if ($picCount > $this->system->SETTINGS['freemaxpictures'])
						{
							$totalPic = $picCount - $this->system->SETTINGS['freemaxpictures'];
							$tmp = bcmul($totalPic, $row['value'], $this->system->SETTINGS['moneydecimals']);
						}else{
							$tmp = "0.00";
						}
						$fee_data['picture_fee'] = $tmp;
						$fee_value = bcadd($fee_value, $tmp, $this->system->SETTINGS['moneydecimals']);
					}
					if ($row['type'] == 'subtitle_fee' && !empty($this->subtitle) && !$this->user->no_subtitle_fee)
					{
						$fee_data['subtitle_fee'] = $row['value'];
						$fee_value = bcadd($fee_value, $row['value'], $this->system->SETTINGS['moneydecimals']);
					}
					if ($row['type'] == 'excat_fee' && $this->sellcat2 > 0 && !$this->user->no_excat_fee)
					{
						$fee_data['excat_fee'] = $row['value'];
						$fee_value = bcadd($fee_value, $row['value'], $this->system->SETTINGS['moneydecimals']);
					}
					if ($row['type'] == 'relist_fee' && $this->relist > 0 && !$this->user->no_relist_fee)
					{
						$fee_data['relist_fee'] = ($row['value'] * $this->relist);
						$fee_value = bcadd($fee_value, ($row['value'] * $this->relist), $this->system->SETTINGS['moneydecimals']);
					}
				}
			}
		}
		if ($just_fee)
		{
			$return_val = $fee_value;
		}
		else
		{
			$return_val = array($fee_value, $fee_data);
		}
		return $return_val;
	}
	public function addoutstanding($fee_data, $fee)
	{		
		if ($_SESSION['SELL_action'] == 'edit')
		{
			$query = "SELECT * FROM " . $this->DBPrefix . "useraccounts 		
				WHERE auc_id = :auct_id AND user_id = :users_ids";
			$params = array(
				array(':auct_id', $_SESSION['SELL_auction_id'], 'int'),
				array(':users_ids', $this->user->user_data['id'], 'int')
			);
			$this->database->query($query, $params);
			$stored_fee = $this->database->result();
			if(!$this->user->no_fees)
			{
				if(!$this->user->no_setup_fee)
				{
					if ($stored_fee['setup'] > 0)
					{
						$setup_data = $stored_fee['setup'];
					}
					else
					{
						$setup_data = $fee_data['setup'];
					}
				}
				else
				{
					$setup = $this->system->print_money_nosymbol(0);
				}
		
				if(!$this->user->no_hpfeat_fee)
				{
					if ($stored_fee['featured'] > 0)
					{
						$hpfeat_fee_data = $stored_fee['featured'];
					}
					else
					{
						$hpfeat_fee_data = $fee_data['hpfeat_fee'];
					}
				}
				else
				{
					$hpfeat_fee_data = $this->system->print_money_nosymbol(0);
				}
				if(!$this->user->no_bolditem_fee)
				{
					if ($stored_fee['bold'] > 0)
					{
						$bold_data = $stored_fee['bold'];
					}
					else
					{
						$bold_data = $fee_data['bolditem_fee'];
					}
				}
				else
				{
					$bold_data = $this->system->print_money_nosymbol(0);
				}
				if(!$this->user->no_hlitem_fee)
				{
					if ($stored_fee['highlighted'] > 0)
					{
						$highlighted_data = $stored_fee['highlighted'];
					}
					else
					{
						$highlighted_data = $fee_data['hlitem_fee'];
					}
				}
				else
				{
					$highlighted_data = $this->system->print_money_nosymbol(0);
				}
				if(!$this->user->no_subtitle_fee)
				{
					if ($stored_fee['subtitle'] > 0)
					{
						$subtitle_data = $stored_fee['subtitle'];
					}
					else
					{
						$subtitle_data = $fee_data['subtitle_fee'];
					}
				}
				else
				{
					$subtitle_data = $this->system->print_money_nosymbol(0);
				}
				if(!$this->user->no_relist_fee)
				{
					if ($stored_fee['relist'] > 0)
					{
						$relist_data = $stored_fee['relist'];
					}
					else
					{
						$relist_data = $fee_data['relist_fee'];
					}
				}
				else
				{
					$relist_data = $this->system->print_money_nosymbol(0);
				}
				
				if(!$this->user->no_geomap_fee)
				{
					if ($stored_fee['geomap'] > 0)
					{
						$geomap_data = $stored_fee['geomap'];
					}
					else
					{
						$geomap_data = $fee_data['geomap_fee'];
					}
				}
				else
				{
					$geomap_data = $this->system->print_money_nosymbol(0);
				}
	
				
				if(!$this->user->no_rp_fee)
				{
					if ($stored_fee['reserve'] > 0)
					{
						$reserve_data = $stored_fee['reserve'];
					}
					else
					{
						$reserve_data = $fee_data['rp_fee'];
					}
				}
				else
				{
					$reserve_data = $this->system->print_money_nosymbol(0);
				}
				if(!$this->user->no_buyout_fee)
				{
					if ($stored_fee['buynow'] > 0)
					{
						$buynow_data = $stored_fee['buynow'];
					}
					else
					{
						$buynow_data = $fee_data['buyout_fee'] && !$this->user->no_buyout_fee;
					}
				}
				else
				{
					$buynow_data = $this->system->print_money_nosymbol(0);
				}
				if(!$this->user->no_picture_fee)
				{
					if ($stored_fee['image'] > 0)
					{
						$image_data = $stored_fee['image'];
					}
					else
					{
						$image_data = $fee_data['picture_fee'];
					}
				}
				else
				{
					$image_data = $this->system->print_money_nosymbol(0);
				}
				if(!$this->user->no_excat_fee)
				{
					if ($stored_fee['extcat'] > 0)
					{
						$extcat_data = $stored_fee['extcat'];
					}
					else
					{
						$extcat_data = $fee_data['excat_fee'];
					}
				}
				else
				{
					$extcat_data = $this->system->print_money_nosymbol(0);
				}
			}
			if ($fee > 0)
			{
				$total_data = $stored_fee['total'];
			}
			else
			{
				$total = $hpfeat_fee_data + $bold_data + $highlighted_data + $subtitle_data + $relist_data + $reserve_data + $buynow_data + $image_data + $extcat_data + $geomap_data;
				$total_data = $total;
			}	
			
			$query = "UPDATE " . $this->DBPrefix . "useraccounts SET 
				setup = '" . $setup_data . "',
				featured = '" . $hpfeat_fee_data . "',
				bold = '" . $bold_data . "',
				highlighted = '" . $highlighted_data . "',
				subtitle = '" . $subtitle_data . "',
				relist = '" . $relist_data . "',
				reserve = '" . $reserve_data . "',
				buynow = '" . $buynow_data . "',
				image = '" . $image_data . "',
				extcat = '" . $extcat_data . "',
				geomap = '" . $geomap_data . "',
				total = '" . $total_data . "',
				paid = 0
				WHERE auc_id = " . $_SESSION['SELL_auction_id'] . " AND user_id = " . $this->user->user_data['id'];
			$this->database->direct_query($query);
		}
		else
		{
			//build the fees
			$setup_fee = !$this->user->no_setup_fee ? $fee_data['setup'] : $this->system->input_money(0);
			$hpfeat_fee = !$this->user->no_hpfeat_fee ? $fee_data['hpfeat_fee'] : $this->system->input_money(0);
			$bolditem_fee = !$this->user->no_bolditem_fee ? $fee_data['bolditem_fee'] : $this->input_money(0);
			$hlitem_fee = !$this->user->no_hlitem_fee ? $fee_data['hlitem_fee'] : $this->system->input_money(0);
			$subtitle_fee = !$this->user->no_subtitle_fee ? $fee_data['subtitle_fee'] : $this->system->input_money(0);
			$relist_fee = !$this->user->no_relist_fee ? $fee_data['relist_fee'] : $this->system->input_money(0);
			$rp_fee = !$this->user->no_rp_fee ? $fee_data['rp_fee'] : $this->system->input_money(0);
			$buyout_fee = !$this->user->no_buyout_fee ? $fee_data['buyout_fee'] : $this->input_money(0);
			$picture_fee = !$this->user->no_picture_fee ? $fee_data['picture_fee'] : $this->system->input_money(0);
			$excat_fee = !$this->user->no_excat_fee ? $fee_data['excat_fee'] : $this->system->input_money(0);
			$geomap_fee = !$this->user->no_geomap_fee ? $fee_data['geomap_fee'] : $this->system->input_money(0);
			
			$query = "INSERT INTO " . $this->DBPrefix . "useraccounts (useracc_id,auc_id,user_id,setup,featured,bold,highlighted,subtitle,relist,reserve,buynow,picture,extracat,signup,buyer,finalval,geomap,balance,total,paid) VALUES
				(NULL, :auction_id, :user_id, :setup_fee, :featured_fee, :bold_fee, :highlighted_fee, :subtitle_fee, :relist_fee, :reserve_fee, :buynow_fee, :picture_fee, :extracat_fee, 0, 0, 0, :geomap_fee, 0 :fee, 0)";			
			$params = array(
				array(':auction_id', $_SESSION['SELL_auction_id'], 'int'),
				array(':user_id', $this->user->user_data['id'], 'int'),
			    array(':setup_fee', $setup_fee, 'float'),
			    array(':featured_fee', $hpfeat_fee, 'float'),
			    array(':bold_fee', $bolditem_fee, 'float'),
			    array(':highlighted_fee', $hlitem_fee, 'float'),
			    array(':subtitle_fee', $subtitle_fee, 'float'),
			    array(':relist_fee', $relist_fee, 'float'),
			    array(':reserve_fee', $rp_fee, 'float'),
			    array(':buynow_fee', $buyout_fee, 'float'),
			    array(':picture_fee', $picture_fee, 'float'),
			    array(':extracat_fee', $excat_fee, 'float'),
			    array(':geomap_fee', $geomap_fee, 'float'),
			    array(':fee', $fee, 'float')
   			);
			$this->database->query($query, $params);
			$error = $this->database->error;
			if(is_array($error))
			{
				self::logError($error);
			}
		}
	}
	private function logError($error)
	{
		foreach($error as $k => $v)
		{
				$this->system->log($v);
		}
	}
	public function check_gateway($gateway)
	{
		if ($gateway == 'paypal' && !empty($this->user->user_data['paypal_email']))
			return true;
		if ($gateway == 'authnet' && !empty($this->user->user_data['authnet_id']) && !empty($this->user->user_data['authnet_pass']))
			return true;
		if ($gateway == 'worldpay' && !empty($this->user->user_data['worldpay_id']))
			return true;
		if ($gateway == 'skrill' && !empty($this->user->user_data['skrill_email']))
			return true;
		if ($gateway == 'toocheckout' && !empty($this->user->user_data['toocheckout_id']))
			return true;
		if ($gateway == 'bank' && !empty($this->user->user_data['bank_name']) && !empty($this->user->user_data['bank_account']) && !empty($this->user->user_data['bank_routing']))
			return true;
		return false;
	}
	
	public function add_digital_item()
	{
		$tempDIR = UPLOAD_PATH . 'temps/' . session_id() . '/' . 'items';
		// delete any existing files so only 1 file is stored
		if (isset($this->digital_item))
		{
			if($tempDIR)
			{
				if(is_dir(UPLOAD_PATH . 'items' . '/' . $this->user->user_data['id'] . '/' . $this->auction_id))
				{
					if($dir = opendir(UPLOAD_PATH . 'items' . '/' . $this->user->user_data['id'] . '/' . $this->auction_id))
					{
						while (($file = readdir($dir)) !== false)
						{
							if (!is_dir(UPLOAD_PATH . 'items' . '/' . $this->user->user_data['id'] . '/' . $this->auction_id . '/' . $file))
								unlink(UPLOAD_PATH . 'items' . '/' . $this->user->user_data['id'] . '/' . $this->auction_id . '/' . $file);
						}
						closedir($dir);
					}
				}
			}
		}
		// Copy digital item file
		if (isset($this->digital_item))
		{	
			$digital_pass = false;
			$split = explode('.', $this->digital_item);					
			if (is_dir(UPLOAD_PATH . 'items' . '/' . $this->user->user_data['id'] . '/' . $this->auction_id))
			{	
				// update the file name that is stored in the sql
				$query = "UPDATE  " . $this->DBPrefix . "digital_items SET item = :di_items WHERE auctions = :auct_ids AND seller = :user_ids";
				$params = array(
					array(':di_items', $this->digital_item, 'str'),
					array(':auct_ids', $this->auction_id, 'int'),
					array(':user_ids', $this->user->user_data['id'], 'int')
				);
				$this->database->query($query, $params);
															
				// move the file from the temp folder to the main folder
				$this->system->move_file($tempDIR . '/' . $split[0] . '.encrypted', UPLOAD_PATH . 'items' . '/' . $this->user->user_data['id'] . '/' . $this->auction_id . '/' . $split[0] . '.encrypted', true);
				chmod(UPLOAD_PATH . 'items' . '/' . $this->user->user_data['id'] . '/' . $this->auction_id . '/' . $split[0] . '.encrypted', 0700);
				$digital_pass = true;
			}
			elseif(file_exists($tempDIR . '/' . $split[0] . '.encrypted'))
			{
				// store the file name to the sql
				$query = "INSERT INTO " . $this->DBPrefix . "digital_items VALUES (NULL, :auct_ids, :user_ids, :di_items, :di_hash)";
				$params = array(
					array(':auct_ids', $this->auction_id, 'int'),
					array(':user_ids', $this->user->user_data['id'], 'int'),
					array(':di_items', $this->digital_item, 'str'),
					array(':di_hash', $this->security->genRandString(16), 'str')
				);
				$this->database->query($query, $params);
										
				//check to if the folders was made
				if (!is_dir(UPLOAD_PATH . 'items' . '/' . $this->user->user_data['id'])) mkdir(UPLOAD_PATH . 'items' . '/' . $this->user->user_data['id'], 0700);
				if (!is_dir(UPLOAD_PATH . 'items' . '/' . $this->user->user_data['id'] . '/' . $this->auction_id)) mkdir(UPLOAD_PATH . 'items' . '/' . $this->user->user_data['id'] . '/' . $this->auction_id, 0700);
										
				// move the file from the temp folder to the main folder
				$split = explode('.', $this->digital_item);
				$this->system->move_file($tempDIR . '/' . $split[0] . '.encrypted', UPLOAD_PATH . 'items' . '/' . $this->user->user_data['id'] . '/' . $this->auction_id . '/' . $split[0] . '.encrypted', true);
				chmod(UPLOAD_PATH . 'items' . '/' . $this->user->user_data['id'] . '/' . $this->auction_id . '/' . $split[0] . '.encrypted', 0700);
				$digital_pass = true;
			}
			//deleting all the temp folders and files
			if(is_dir(UPLOAD_PATH . 'items' . '/' . $this->user->user_data['id'] . '/' . $this->auction_id) && $digital_pass)
			{
				// Delete files, using dir (to eliminate eventual odd files)
				if (is_dir($tempDIR))
				{
					if ($dir = opendir($tempDIR))
					{
						while (($file = readdir($dir)) !== false)
						{
							if (!is_dir($tempDIR . '/' . $file))
								unlink($tempDIR . '/' . $file);
						}
						closedir($dir);
					}
				}
				if (is_dir(UPLOAD_PATH . 'temps/' . session_id()))
				{
					if ($dir = opendir(UPLOAD_PATH . 'temps/' . session_id()))
					{
						while (($file = readdir($dir)) !== false)
						{
							if (!is_dir(UPLOAD_PATH . 'temps/' . session_id() . '/' . $file))
								unlink(UPLOAD_PATH . 'temps/' . session_id() . '/' . $file);
						}
						closedir($dir);
					}
				}
				// making sure to delete the session folders
				if (is_dir($tempDIR)) rmdir($tempDIR);
				if (is_dir(UPLOAD_PATH . 'temps/' . session_id())) rmdir(UPLOAD_PATH . 'temps/' . session_id());
			}
		}
	}
}