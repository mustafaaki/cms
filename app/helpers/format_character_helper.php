<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

if (! function_exists ( 'format_character' )) {
	function formatUrl($var = '', $langTr = TRUE) {
		
		/*$langTr true ise ,urlde turkce  karakterleri silmeden eng formatina cevirir*/
		if ($langTr) {
			/*turkce karakterler dahil buyuk harfleri  kucultur*/
			$var = mb_strtolower ( $var );
			$tr  = array ('ş', 'Ş', 'ı', 'İ', 'ğ', 'Ğ', 'ü', 'Ü', 'ö', 'Ö', 'Ç', 'ç' );
			$eng = array ('s', 'S', 'i', 'I', 'g', 'G', 'u', 'U', 'o', 'O', 'C', 'c' );
			
			/*tr dizisindeki isaretleri eng dizisindeki isaretlere cevirir*/
			$var = str_replace ( $tr, $eng, $var );
		}
		/*bir veya birden  cok - isaretini tek - isareti yapar */
		//$var = eregi_replace ( '-+', "-", $var );
		/*a-z ve 0-9 dışındaki bir ve daha çok karakteri tek - yapar*/
		$var = preg_replace( "/[^a-z0-9-]+/", "-", $var );
		return $var;
	}
	
	/*buyuk harfleri turkce karakterler dahil  kucuk  harf yapar*/
	function trToLower($var) {
		$var = mb_strtolower ( $var );
		return $var;
	}
	
	/*kucuk harfleri turkce karakterler dahil buyuk harf yapar */
	function trToUpper($var = '') {
		$var = mb_strtoupper ( $var );
		return $var;
	}
	
	/*bosluklari  belirtilen karakter yapar, default tek bosluk*/
	function cleanSpace($var, $character = " ") {
		$var = eregi_replace ( '\s+', $format, $var );
		return $var;
	}
	
	function root_url($var){
		$base = str_replace("manager/","",base_url());
		$url=$base.$var;
		return $url;
	}
	
	function quote_esc($val,$typ=ENT_QUOTES){
	   return htmlspecialchars($val,$typ);
	}
	function quote_esc_dec($val,$typ=ENT_QUOTES){
	    return htmlspecialchars_decode($val,$typ);
	}
}