XML-RPC Services For Mambo 4.5.2
GPL Licensed.


This is exciting!

1. INSTALL INSTRUCTIONS 

There are 2 parts to making this work.  You need to install the XML-RPC 
Server Mambot into mambo and then insert code into your non-mambo php 
files in order to pull the information from Mambo into a non-mambo page.

Step By Step - SERVER PART.
1. Login to Mambo Admin and go to the Mambots Install Screen
2. Select the /server/mambo.zip file from this package and install it
3. Go to SITE MAMBOTS in Mambo Admin and PUBLISH the Mambot "XML-RPC Server For Mambo"
4. if you are running Mambo 4.5.2 then you need an additional line in your configuration.php 
This line must be placed in configuration.php manually and will be removed everytime you save
 the Global Configuration in Mambo Admin (You have been warned!) You will need to insert it 
 again if that happens.
 
 The line to add is (Can be added anywhere):
 
 $mosConfig_xmlrpc_server = '1';
 
 While you are in this file you need to make a note of your value of mosConfig_secret as this is needed later!!!!!
 
 THE SERVER IS NOW READY!!!
 
Step By Step - CLIENT PART.
for the module to work it needs to be configured, for an example see the non_mambo_file.php

the module.php and the includes directory should be located in the same place as the file you wish to include module into.

Then in your non mambo php file add the code from the non_mambo_file.php (Using that as an example)

As long as you have configured it right you will see the modules that are assigned to that module position,

Tips:

Create a new module position (Also Module Positions under Template Menu in Mambo Admin) call it XML-RPC 
and assign the modules you wish to appear this that position.  Make sure you assign the module to ALL pages in the params
Then in the non_mambo_file.php file define the position as 'xml-rpc' :-)


