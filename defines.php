<?php

/**
 * Define the cockpit path for later usage
 */
define('CPMP_COCKPIT_PATH', '/lib/cockpit');

/**
 * define COCKPIT_DIR explicitely so CpMultiplane knows, where to bootstrap
 */
define('COCKPIT_DIR',       str_replace(DIRECTORY_SEPARATOR, '/', __DIR__).CPMP_COCKPIT_PATH);

/**
 * In the core CpMultiplane, this is the folder name of Cockpit. Here it acts as a route to load Cockpit
 * instead of CpMultiplane if the url matches it. So `example.com/about` will bootstrap CpMultiplane to render
 * the page "About". `example.com/MP_ADMINFOLDER` will bootstrap the raw Cockpit and you can access the backend.
 */
define('MP_ADMINFOLDER',   'cockpit');

/**
 * Store all config files, databases, themes etc. in a custom data directory. This way you have a well-arranged
 * data structure and you prevent Cockpit from storing files inside the lib folder.
 */
define('COCKPIT_ENV_ROOT',  str_replace(DIRECTORY_SEPARATOR, '/', __DIR__).'/data/cp');

/**
 * Set MP_ENV_ROOT to tell CpMultiplane where to look for the themes folder
 */
define('MP_ENV_ROOT',       str_replace(DIRECTORY_SEPARATOR, '/', __DIR__).'/data/mp');

/**
 * Define docs root explicitely if `$_SERVER['DOCUMENT_ROOT']` is wrong.
 *
 * This happens e. g. on an Uberspace if you use a subdomain root instead of the default html folder.
 * In this case, you might also have to set `RewriteBase /` in `.htaccess`
 * see: https://manual.uberspace.de/web-documentroot.html#additional-documentroots
 */
// define('MP_DOCS_ROOT',      __DIR__);
// define('COCKPIT_DOCS_ROOT', __DIR__);
