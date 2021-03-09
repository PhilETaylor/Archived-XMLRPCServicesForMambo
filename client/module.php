<?
defined ('_VALID_INCLUDE') or die;

/* Turn on debug mode */
$debug=_DEBUG;

/* Path to domit directory (Full absolute path or relative to this file - with no trailing slash!) */
$domit_path = _DOMIT_PATH;

/* Host where Mambo is installed - starting http: and ending with no trailing slash */
$host = _HOST;

/* If mambo is in a sub folder enter it here with a / prefix and NO training slash */
$subfoldertomambo = _MAMBOSUBFOLDER; 

/* path to the xmlrpc.server.php file SHOULD NOT NEED CHANGING */
$pathtoxmlserver = _MAMBOSUBFOLDER . _PATHTOXMLRPCSERVER;

/* the value os mosConfig_secret on your mambo site */
$secret = _SECRET;

/* The method to load */
$method = _METHODTOCALL;

/* The expected arguments for the above method */
//	pxt.LoadModulePosition
	$position = _POSITION;
	$style =_STYLE;

	

// NOTHING needs changing below here!
// ##################################################
//error_reporting( E_ALL );
require_once($domit_path.'/dom_xmlrpc_client.php' );

$client =& new dom_xmlrpc_client( $host, $pathtoxmlserver );
$client->setResponseType( 'array' );

if ($debug) {
	$client->setHTTPEvent( 'onRequest', true );
	$client->setHTTPEvent( 'onResponse', true );
}

$myXmlRpc =& new dom_xmlrpc_methodcall( $method, array(md5($secret), $position, $style) );

$xmlrpcdoc = $client->send( $myXmlRpc );

if (!$xmlrpcdoc->isFault()) {
	$output =  $xmlrpcdoc->getParam(0);
} else {
	print $xmlrpcdoc->getFaultString();
}

/* Tidy things up */
$output = str_replace('href="index','href="'.$host.$subfoldertomambo.'/index',$output);
$output = str_replace('href="images','href="'.$host.$subfoldertomambo.'/images',$output);

/* Display the result! - Sit back and be amazed! */
echo $output;
?>