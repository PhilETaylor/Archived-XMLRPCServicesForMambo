<?
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_MAMBOTS->registerFunction( 'onGetWebServices', 'wsGetMamboWebServices' );

/**
* @return array An array of associative arrays defining the available methods
*/
function wsGetMamboWebServices() {
	return array(
	array(
	'name'=>'check.wsMamboSystemInfo',
	'method'=> 'wsMamboSystemInfo',
	'help' => 'Checks the connection'
	),
	array(
	'name'=>'pxt.LoadModulePosition',
	'method'=> 'pxtLoadModulePosition',
	'help' => 'Loads a particular Module position'
	)
	);

}



function pxtLoadModulePosition( &$args ) {
	$secret = $args[0] ? $args[0] : 'mambo';
	$position= $args[1] ? $args[1] : 'left';
	$style= $args[2] ? $args[2] : '1';
	
	if (checkSecret($secret)==false){
		return "Invalid Shared Key!";
	}
	global $mosConfig_gzip, $mosConfig_absolute_path, $database, $my, $Itemid, $mosConfig_caching, $mosConfig_lang, $mosConfig_sef;

	ob_start();

	require_once($GLOBALS['mosConfig_absolute_path']."/includes/frontend.php");
	require_once( $mosConfig_absolute_path . '/includes/frontend.html.php' );
	
	/* bug with SEF turned on! */
	$mosConfig_sef = '0';
	$GLOBALS['mosConfig_sef'] = '0';
	require_once( $mosConfig_absolute_path . '/includes/sef.php' );
	

	// loads english language file by default
	if ( $mosConfig_lang == '' ) {
		$mosConfig_lang = 'english';
	}
	include_once (	$mosConfig_absolute_path . '/language/'.$mosConfig_lang.'.php' );
	$tp = mosGetParam( $_GET, 'tp', 0 );
	if ($tp) {
		echo '<div style="height:50px;background-color:#eee;margin:2px;padding:10px;border:1px solid #f00;color:#700;">';
		echo $position;
		echo '</div>';
		return;
	}
	$style = intval( $style );
	$cache =& mosCache::getCache( 'com_content' );

	$Itemid="1";

	$allModules =& initModules();

	if (isset( $GLOBALS['_MOS_MODULES'][$position] )) {
		$modules = $GLOBALS['_MOS_MODULES'][$position];
	} else {
		$modules = array();
	}

	if (count( $modules ) < 1) {
		$style = 0;
	}
	if ($style == 1) {
		echo "<table cellspacing=\"1\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n";
		
		echo "<tr>\n";
	}
	$prepend = ($style == 1) ? "<td valign=\"top\">\n" : '';
	$postpend = ($style == 1) ? "</td>\n" : '';

	$count = 1;
	foreach ($modules as $module) {
		$params =& new mosParameters( $module->params );

		echo $prepend;

		if ((substr("$module->module",0,4))=="mod_") {
			if ($params->get('cache') == 1 && $mosConfig_caching == 1) {
				$cache->call('modules_html::module2', $module, $params, $Itemid, $style );
			} else {
				modules_html::module2( $module, $params, $Itemid, $style, $count );
			}
		} else {
			if ($params->get('cache') == 1 && $mosConfig_caching == 1) {
				$cache->call('modules_html::module', $module, $params, $Itemid, $style );
			} else {
				modules_html::module( $module, $params, $Itemid, $style );
			}
		}

		echo $postpend;
		$count++;
	}
	if ($style == 1) {
		echo "</tr>\n</table>\n";
	}

	$buffer = ob_get_contents();
	ob_clean();
	return $buffer;
}

function checkSecret($secret){
	if ($secret == md5($GLOBALS['mosConfig_secret'])){
		return true;
	} else {
		return false;
	}
}
?>