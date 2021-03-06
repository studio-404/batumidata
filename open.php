<?php 
session_start();
session_name("batumidatabase");
/*check last activity*/
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] > 5800) {
    // session started more than 30 minutes ago
    session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
    $_SESSION['CREATED'] = time();  // update creation time
} 
error_reporting(E_ALL); 
ini_set("display_errors", 1);
header('X-Frame-Options: DENY');
header("Content-type: text/html; charset=utf-8");

$dir_explode = explode("open.php",__FILE__);
define("DIR",$dir_explode[0]);
define("WEBSITE","http://batumi.404.ge/");
define("WEBSITE_","http://batumi.404.ge");
define('START_TIME', microtime(TRUE));
define('START_MEMORY', memory_get_usage());
define('PLUGINS', WEBSITE.'_plugins/');
define('PLUGINS_FOLDER', '_plugins/');
define('FILES', WEBSITE.'files/');
define('INVOICE', DIR.'files/invoices/');
define('FLASH', WEBSITE.'flash/');
define('IMG', WEBSITE.'images/');
define('SCRIPTS', WEBSITE.'scripts/');
define('STYLES', WEBSITE.'styles/');
/*
** includs /home/geoweb/trade.404.ge/
*/

@require_once("config.php"); 
date_default_timezone_set($c['date.timezone']); // set timezone 
set_time_limit($c["time.limit"]); // time limit
ini_set('max_execution_time',$c['execution.time']); // execute time limit
ini_set('post_max_size',$c['post.max.size']); // post max size limit
ini_set('upload_max_filesize',$c['upload.max.filesize']); // upload max file size limit


function __autoload($class_name){
	$class_load = false;
	if(file_exists('functions/'.$class_name.'.php')){// auto load function
    	@include 'functions/'.$class_name.'.php';
    	$class_load = true;
	}
	if(file_exists('controller/'.$class_name.'.php')){// auto load module
		@include 'controller/'.$class_name.'.php';
		$class_load = true;
	}
	if(file_exists('controller/custom/'.$class_name.'.php')){// auto load module
		@include 'controller/custom/'.$class_name.'.php';
		$class_load = true;
	}
	if(file_exists('model/'.$class_name.'.php')){// auto load module
		@include 'model/'.$class_name.'.php';
		$class_load = true;
	}
	if(!$class_load){
		echo "Class: <b>".$class_name."</b> can't load.."; exit();
	}
}

$actual_link = "$_SERVER[REQUEST_URI]";

$findme   = array('\'','~','!','@','$','^','*','(',')','{','}','|',';','<','>','\\','..');
foreach ($findme as $f) {
	$pos = strpos($actual_link, $f);
	if ($pos !== false) {
	    $redirect = new redirect();
		$redirect->go(WEBSITE);
		die();
	}
}

/*
** call main classes
*/
$obj  = new url_controll(); // url controlls

/*
** important variables if more language edit this line 
*/
$LANG = $obj->url("segment",$c['site.language.slash.position']);
$_SESSION['SLUG.AFTER.LANG'] = $obj->url("segment",($c['site.language.slash.position']+1));
// if($LANG==$c['admin.slug']){
// 	redirect::url(WEBSITE.$c['main.language']."/".$c['admin.slug']);
// }

if(empty($LANG)){ // just domain name
	$redirect = new redirect();
	$redirect->go(WEBSITE.$c['main.language']."/".$c["welcome.page.slug"]); 
}else if(!in_array($LANG, $c['languages.array']) && $LANG != "image" && $LANG!=$c['admin.slug']){
	$welcome_class = $c["welcome.page.slug"];
	$main_language = $c['main.language'];
	$redirect = new redirect();
	$redirect->go(WEBSITE.$main_language."/".$welcome_class);
}else if($LANG==$c['admin.slug']){
	redirect::url(WEBSITE.$c['main.language']."/".$c['admin.slug']);
}

$get_ip = new get_ip();
$ip = $get_ip->ip;

if(empty($LANG)){ // just domain name
	$redirect = new redirect();
	$redirect->go(WEBSITE.$c['main.language']."/".$c["welcome.page.slug"]);
}


/*
insert log
*/
// $file_manipulate = new file_manipulate(); 
// $file_manipulate->insertLog("[".$ip."][".date("d-m-Y G:m:s")."] - ".WEBSITE_.$actual_link);
/* token */
$_SESSION["token_generator"] = ustring::random(10);
/*
** some more define
*/
$get_lang_id = new get_lang_id();
$lang_id = $get_lang_id->id($c,$LANG);
define('LANG', $LANG);
define('LANG_ID', $lang_id);
define('PRE_VIEW', $c["product.view.pre.slug"]);
define('PRE_GALLERY', $c["gallery.view.pre.slug"]);
define('WEB_DIR', $c["website.directory"]);
define('TEMPLATE', WEBSITE.$c["website.directory"].'/');
define('MAIN_DIR', WEBSITE.LANG.'/');
define('MAIN_PAGE', MAIN_DIR.$c["welcome.page.slug"]);
define('ADMIN_SLUG',$c['admin.slug']);
/*
** Controller function
*/
ob_start(); 
$controller = new controller($c);
$controller->loadpage($obj,$c);
// try{}catch(Exception $e){
// 	echo "Critical error !";
// }
?>