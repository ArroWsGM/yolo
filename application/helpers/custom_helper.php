<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * Custom Helpers
 *
 * @package		None
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Arrows
 * @link		
 */

// ------------------------------------------------------------------------

/**
 * Convert bytes to human readable format
 *
 * @param integer bytes Size in bytes to convert
 * @return string
 */
function bytesToSize($bytes, $precision = 2){  
	$kilobyte = 1024;
	$megabyte = $kilobyte * 1024;
	$gigabyte = $megabyte * 1024;
	$terabyte = $gigabyte * 1024;
	
	if (($bytes >= 0) && ($bytes < $kilobyte)) {
		return $bytes . ' B';
	
	} elseif (($bytes >= $kilobyte) && ($bytes < $megabyte)) {
		return round($bytes / $kilobyte, $precision) . ' KB';
	
	} elseif (($bytes >= $megabyte) && ($bytes < $gigabyte)) {
		return round($bytes / $megabyte, $precision) . ' MB';
	
	} elseif (($bytes >= $gigabyte) && ($bytes < $terabyte)) {
		return round($bytes / $gigabyte, $precision) . ' GB';
	
	} elseif ($bytes >= $terabyte) {
		return round($bytes / $terabyte, $precision) . ' TB';
	} else {
		return $bytes . ' B';
	}
}

function locMonth($str, $lang='ru'){
	$eng=array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
	$ukr=array('Січень', 'Лютого', 'Березня', 'Квітня', 'Травня', 'Червня', 'Липня', 'Серпня', 'Вересня', 'Жовтня', 'Листопада', 'Грудня');
	$rus=array('Января', 'Февраля',	'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');
	switch ($lang){
		case 'ua':
		case 'uk':
		case 'ukrainian':
		case 'ukr': return str_ireplace($eng, $ukr, $str);
		default: return str_ireplace($eng, $rus, $str);
	}
}
// ------------------------------------------------------------------------



/* End of file custom_helper.php */
/* Location: ./application/helpers/custom_helper.php */
