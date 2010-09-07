<?php defined('SYSPATH') or die('No direct script access.');

//-- Environment setup --------------------------------------------------------

/* error_reporting( E_ERROR & E_WARNING ); */

/**
 * Set the default time zone.
 *
 * @see  http://docs.kohanaphp.com/features/localization#time
 * @see  http://php.net/timezones
 */
date_default_timezone_set('US/Central');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://docs.kohanaphp.com/features/autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

//-- Configuration and initialization -----------------------------------------

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(	
	//'base_url'		=> ! IN_PRODUCTION ? '/kohana/longy/' : '/lab/kohana/longy/',
	'base_url'		=> '/',
	'index_file'	=> FALSE,
	'profiling'		=> !IN_PRODUCTION,
	'errors'			=> !IN_PRODUCTION,
	'caching'			=> IN_PRODUCTION
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Kohana_Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'database'   => MODPATH.'database',   // Database access
));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */

Route::set('app/media', 'm(/<file>)', array('file' => '.+'))
	->defaults(array(
		'controller' => 'media',
		'action'     => 'getfile',
		'file'       => null
	));
	
// page
Route::set('app/static', '<page>', array('page' => 'api|contact|faq')) // match specific pages.
	->defaults(array(
		'controller' => 'static',
		'action'     => 'load',
		'page'       => 'contact'
	));
		
// API routes
Route::set('app/api', 'api(/<singlekey>)/<action>.<type>', array('action' => '.+', 'singlekey' => '[a-zA-Z0-9_]+')) // FIX
	->defaults(array(
		'controller' => 'api',
		'action'     => 'create',
		'singlekey' => null,
		'type' => 'json'
	));

// not found
Route::set('not_found', 'not-found')
	->defaults(array(
		'controller' => 'front',
		'action'     => 'index',
		'id'				=> 'not-found'
	));

// hash Redirect
Route::set('redirect/hash', 'go/<hash>', array('hash' => '[a-zA-Z0-9_]+'))
	->defaults(array(
		'controller' => 'redirect',
		'action'     => 'go',
		'hash'				=> false,
	));

// catch all
Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'front',
		'action'     => 'index'
	));

/**
 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
 * If no source is specified, the URI will be automatically detected.
 */
echo Request::instance()
	->execute()
	->send_headers()
	->response;
