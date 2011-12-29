<?php 
/*
 * plugin name: PopUp While searching
 * author: Mahibul Hasan
 * plugin uri: http://usedcarwestpalmbeach.net/
 * author uri: http://sohag07hasan.elance.com
 */

define('POPUP_DIR', dirname(__FILE__));
define('POPUP_CLASSES', dirname(__FILE__) . '/classes');
define('POPUP_CORES', dirname(__FILE__) . '/cores');
define('POPUP_CSS', plugins_url('',__FILE__) . '/css');
define('POPUP_JS', plugins_url('',__FILE__) . '/js');

include POPUP_CLASSES . '/simple_popup_class.php';

?>