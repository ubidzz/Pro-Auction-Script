<?php

if(!function_exists('generate_seo_link'))
{
	function generate_seo_link($str, $options = array()) 
	{
		$char = 'UTF-8';
		$str = mb_convert_encoding((string)$str, $char, mb_list_encodings());
		
		$defaults = array(
			'delimiter' => '-',
			'limit' => 0,
			'lowercase' => 1,
			'replacements' => array(),
			'transliterate' => 1,
		);
		
		// Merge options
		$options = array_merge($defaults, $options);
				
		// Make custom replacements
		$r_keys = array_keys($options['replacements']);
		$str = preg_replace($r_keys, $options['replacements'], $str);
		
		// Transliterate characters to the correct $CHARSET
		if ($options['transliterate'] == 1) 
		{
			include PLUGIN_PATH . 'SEO/char_map.php';
			$maping = array_keys($char_map);
			$str = str_replace($maping, $char_map, $str);
		}
		
		// Replace non-alphanumeric characters with our delimiter
		$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
		
		// Remove duplicate delimiters
		$d_key = preg_quote($options['delimiter'], '/');
		$str = preg_replace('/(' . $d_key . '){2,}/', '$1', $str);
		
		// Truncate slug to max. characters
		if($options['limit'] > 0)
		{
			$limited = $options['limit'];
		}
		else
		{
			$limited = mb_strlen($str, $char);
		}
		$str = mb_substr($str, 0, $limited, $char);
		
		// Remove delimiter from ends
		$str = trim($str, $options['delimiter']);
		
		if($options['lowercase'] == 1)
		{
			$result = mb_strtolower($str, $char);
		}
		else
		{
			$result = $str;
		}
		
		return $result;
	}
}
?>