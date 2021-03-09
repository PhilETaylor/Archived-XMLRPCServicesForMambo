<?
define('_VALID_INCLUDE','1');
/* Path to domit directory (Full absolute path or relative to this file - with no trailing slash!) */
define('_DOMIT_PATH','includes/domit');

/* Host where Mambo is installed - starting http: and ending with no trailing slash */
define('_HOST','http://www.phil-taylor.com');

/* If mambo is in a sub folder enter it here with a / prefix and NO training slash
If mambo not in a sub folder leave this as ''  */
define('_MAMBOSUBFOLDER','');

/* path to the xmlrpc.server.php file SHOULD NOT NEED CHANGING */
define('_PATHTOXMLRPCSERVER','/mambots/xmlrpc/xmlrpc.server.php');

/* the value os mosConfig_secret on your mambo site */
define('_SECRET','');

/* The method to load */
define('_METHODTOCALL','pxt.LoadModulePosition');


/* The expected arguments for the above method */
//pxt.LoadModulePosition
define('_POSITION','left'); /* The module position to load */
define('_STYLE','-2'); /* Thestyle */

define('_DEBUG','0');

include ('module.php');
?>
