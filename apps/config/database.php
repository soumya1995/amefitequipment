<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

// Local

$db['local']['hostname'] = 'localhost';
$db['local']['username'] = 'root';
$db['local']['password'] = '';
$db['local']['database'] = 'db_amefitequip';
$db['local']['dbdriver'] = 'mysql';
$db['local']['dbprefix'] = '';
$db['local']['stricton'] = FALSE;
$db['local']['active_r'] = TRUE;
$db['local']['pconnect'] = FALSE;
$db['local']['db_debug'] = TRUE;
$db['local']['cache_on'] = FALSE;
$db['local']['cachedir'] = '';
$db['local']['char_set'] = 'utf8';
$db['local']['dbcollat'] = 'utf8_unicode_ci';
$db['local']['port'] 	 = 3306;

// Testing

/*
on project
database: ajwa_international
user: 
password: 
*/

$db['testing']['hostname'] = 'localhost';
$db['testing']['username'] = 'amefitequipm';//prem_tl
$db['testing']['password'] = 'Fmk6#r82';//P_s%k7vr&
$db['testing']['database'] = 'amefitequipm_eamefit';//
$db['testing']['dbdriver'] = 'mysql';
$db['testing']['dbprefix'] = '';
$db['testing']['stricton'] = FALSE;
$db['testing']['active_r'] = TRUE;
$db['testing']['pconnect'] = FALSE;
$db['testing']['db_debug'] = TRUE;
$db['testing']['cache_on'] = FALSE;
$db['testing']['cachedir'] = '';
$db['testing']['char_set'] = 'utf8';
$db['testing']['dbcollat'] = 'utf8_unicode_ci';
$db['testing']['port']     = 3306;

// Live
$db['live']['hostname'] = 'localhost';
$db['live']['username'] = 'username';
$db['live']['password'] = 'password';
$db['live']['database'] = 'database';
$db['live']['dbdriver'] = 'mysql';
$db['live']['dbprefix'] = '';
$db['live']['stricton'] = FALSE;
$db['live']['active_r'] = TRUE;
$db['live']['pconnect'] = FALSE;
$db['live']['db_debug'] = TRUE;
$db['live']['cache_on'] = FALSE;
$db['live']['cachedir'] = '';
$db['live']['char_set'] = 'utf8';
$db['live']['dbcollat'] = 'utf8_unicode_ci';
$db['live']['port'] 	= 3306;

// Check the configuration group in use exists
if(!array_key_exists(ENVIRONMENT, $db))
{
	show_error(sprintf(lang('error_invalid_db_group'), ENVIRONMENT));
}

// Assign the group to be used

$active_group = ENVIRONMENT;


/* End of file database.php */
/* Location: ./application/config/database.php */
