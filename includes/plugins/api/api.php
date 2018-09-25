<?
class api
{
	private $system;
	private $html_copyright;
	private $html_string;
	
	public function __construct()
	{
		global $system;
		
		$this->html_copyright = '<br><div align="center" class="col-sm-12 well well-sm"><a href="https://www.pro-auction-script.com" target="_blank">Pro-Auction-Script</a> © 2014-2018</div>
			<nav class="navbar navbar-inverse navbar-fixed-bottom">';
		$this->html_string = file_get_contents(MAIN_PATH . 'themes/default/global_footer.tpl');

		$this->system = $system;
		self::checkDonation();
	}
	private function getData(array $params)
	{	
		$Exists = true;
		$url = 'https://www.pro-auction-script.com/api.php';
		if(@file_get_contents('https://www.pro-auction-script.com/api.php',false,NULL,0,1))
		{
			$url = 'https://www.pro-auction-script.com/api.php';
		}
		elseif(@file_get_contents('http://51.254.6.224/api.php',false,NULL,0,1))
		{
			$url = 'http://51.254.6.224/api.php';
		}
		else
		{
			$Exists = false;
		}
		if($Exists !=false)
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);    
			$output = curl_exec($ch);	    
			curl_close($ch);
			return json_decode($output, true);
		}
	}
	
	public function check()
	{	
		$getMessage = self::getData(array('action' => 'Free-Version-Check'));
		if($getMessage['check'] == 1)
		{
			return $getMessage['message'];
		}else{
			return 'Unknown';
		}
	}

	public function version_check($realversion)
	{		
		if ($realversion != $this->system->SETTINGS['version'])
		{
			$myversion = '<span style="color:red;">' . $this->system->SETTINGS['version'] . '</span>';
		}
		else
		{
			$myversion = '<span style="color:green;">' . $this->system->SETTINGS['version'] . '</span>';
		}
		return $myversion;
	}
		
	private function checkDonation()
	{			
		$params = array(
			'action' => 'api-check_donation', 
			'site_url' => $this->system->SETTINGS['siteurl'],
			'site_ip' => $_SERVER['SERVER_ADDR'],
			'admin_email' => $this->system->SETTINGS['adminmail']
		);
		if (!($message = self::getData($params))) //checking to see if a donation was made
		{
			return false;
		}
		if($message['status'] == 'y')
		{
			self::removeCopyright();
		}else{
			self::checkCopyright();
		}
		return $message['message'];
	}
	
	private function contains_substr($mainStr, $str, $loc = false) {
	    if ($loc === false) return (strpos($mainStr, $str) !== false);
	    if (strlen($mainStr) < strlen($str)) return false;
	    if (($loc + strlen($str)) > strlen($mainStr)) return false;
	    return (strcmp(substr($mainStr, $loc, strlen($str)), $str) == 0);
	}
	
	private function checkCopyright()
	{
		if(self::contains_substr($this->html_string, $this->html_copyright) !=true)
		{
			$new_html = str_replace('<nav class="navbar navbar-inverse navbar-fixed-bottom">', $this->html_copyright, $this->html_string);
			file_put_contents(MAIN_PATH . 'themes/default/global_footer.tpl', $new_html);
		}
	}
	
	private function removeCopyright()
	{				
		if(self::contains_substr($this->html_string, $this->html_copyright) !=false)
		{
			$new_html = str_replace($this->html_copyright, '<br><nav class="navbar navbar-inverse navbar-fixed-bottom">', $this->html_string);
			file_put_contents(MAIN_PATH . 'themes/default/global_footer.tpl', $new_html);
		}
	}
	
	public function donationMessage()
	{
		return self::checkDonation();
	}
		
	public function scriptMessages()
	{			
		$params = array(
			'action' => 'Free-Messages'
		);
		
		if (!($message = self::getData($params)))
		{
			return false;
		}
		if($message['check'] == 1)
		{
			return $message['message'];
		}
	}
	
	// close everything down
	public function __destruct()
	{
		// close database connection
		$this->system = NULL;
	}
}
