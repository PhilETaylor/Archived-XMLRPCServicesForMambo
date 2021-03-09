<?php
/**
* @version $Id: xmlrpc.server.php,v 1.2 2005/04/04 02:21:28 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** Set flag that this is a parent file */
define( "_VALID_MOS", 1 );

// crank up mambo
require_once( '../../configuration.php' );
if (!$mosConfig_xmlrpc_server) {
	die( 'XML-RPC server not enabled.' );
}
require_once( $mosConfig_absolute_path . '/globals.php' );
require_once( $mosConfig_absolute_path . '/includes/mambo.php' );


$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );

$mainframe = new mosMainFrame( $database, '', '../../' );
$mainframe->initSession();

/** get the information about the current user from the sessions table */
$GLOBALS['my'] =& $mainframe->getUser();

function domXmlRpcFault( &$server, $methodName, &$params ) {
	//one option would be to return a custom fault
	//(implementation defined errors should be
	//in the range  -32099 .. -32000 according to
	//Specification for Fault Code Interoperability)
	$server->serverError = 123456;
	$server->serverErrorString = 'I don\'t know about ' . $methodName;
	return $server->raiseFault();
}

// Includes the required class file for the XML-RPC Server
require_once( $mosConfig_absolute_path . '/includes/domit/dom_xmlrpc_server.php' );
require_once( DOM_XMLRPC_INCLUDE_PATH . 'dom_xmlrpc_fault.php' );

$xmlrpcServer =& new dom_xmlrpc_server();
$xmlrpcServer->setMethodNotFoundHandler( 'domXmlRpcFault' );

// load all available remote calls
$_MAMBOTS->loadBotGroup( 'xmlrpc' );
$allCalls = $_MAMBOTS->trigger( 'onGetWebServices' );

// add all calls to the connector object
foreach ($allCalls as $calls) {

	foreach ($calls as $call) {
		$r = new dom_xmlrpc_method( $call );
		$xmlrpcServer->addMethod( $r );
	}
}

// pass individual arguments to the called method
$xmlrpcServer->tokenizeParams( true );

// process the call
$xmlrpcServer->receive();
?>