<?php

if (!class_exists('DotEnv')) {
    include(__DIR__.'/lib/cockpit/lib/DotEnv.php');
}

// load .env file if exists
DotEnv::load(__DIR__);

// check for custom defines
if (\file_exists(__DIR__.'/defines.php')) {
    include(__DIR__.'/defines.php');
}

if (!defined('MP_ADMINFOLDER'))  define('MP_ADMINFOLDER',  'cockpit');
if (!defined('MP_BASE_URL'))     define('MP_BASE_URL',  '');
if (!defined('COCKPIT_CLI'))     define('COCKPIT_CLI',  false);

// admin route
if (!COCKPIT_CLI && !defined('MP_COCKPIT_ADMIN_ROUTE')) {
    $route = preg_replace('#'.preg_quote(MP_BASE_URL, '#').'#', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), 1);
    define('MP_COCKPIT_ADMIN_ROUTE', $route == '' ? '/' : $route);
}

define('COCKPIT_ADMIN', COCKPIT_CLI ? 0 : strpos(MP_COCKPIT_ADMIN_ROUTE, '/'.MP_ADMINFOLDER) === 0);


if (!COCKPIT_ADMIN || COCKPIT_CLI) {

    /*** bootstrap CpMultiplane ***/

    require(__DIR__.'/lib/CpMultiplane/bootstrap.php');

}

else {

    /*** bootstrap cockpit ***/

    if (!defined('COCKPIT_DOCS_ROOT'))  {

        $COCKPIT_DIR         = str_replace(DIRECTORY_SEPARATOR, '/', __DIR__);
        $COCKPIT_DOCS_ROOT   = str_replace(DIRECTORY_SEPARATOR, '/', isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : dirname(__DIR__));

        # make sure that $_SERVER['DOCUMENT_ROOT'] is set correctly
        if (strpos($COCKPIT_DIR, $COCKPIT_DOCS_ROOT)!==0 && isset($_SERVER['SCRIPT_NAME'])) {
            $COCKPIT_DOCS_ROOT = str_replace(dirname(str_replace(DIRECTORY_SEPARATOR, '/', $_SERVER['SCRIPT_NAME'])), '', $COCKPIT_DIR);
        }

        define('COCKPIT_DOCS_ROOT'  , $COCKPIT_DOCS_ROOT);
    }
    if (!defined('COCKPIT_BASE_URL'))   define('COCKPIT_BASE_URL'   , '/'.MP_ADMINFOLDER);
    if (!defined('COCKPIT_BASE_ROUTE')) define('COCKPIT_BASE_ROUTE' , '/'.MP_ADMINFOLDER);

    // bootstrap cockpit
    require(COCKPIT_DIR.'/bootstrap.php');

    // fix broken assets paths for App.base() and App.route()
    $cockpit->set('base_url', CPMP_COCKPIT_PATH);
    $cockpit->on('app.layout.header', function() {

        $env_url = $this->pathToUrl(COCKPIT_ENV_ROOT);

        echo '<script>
            App.env_url = "'. $env_url .'";
            App.base = function(url) {
                return url.indexOf("/addons") === 0 || url.indexOf("/config") === 0 ? this.env_url+url : this.base_url+url;
            };
            App.route = function(url) {
                if (url.indexOf("/assets") === 0 && url.indexOf("/assetsmanager") !== 0) {
                    return this.base_route+"'. CPMP_COCKPIT_PATH .'"+url;
                }
                if (url.indexOf("/addons") === 0 || url.indexOf("/config") === 0) {
                    return this.env_url+url;
                }
                return this.base_route+url;
            };
        </script>';
    });

}
