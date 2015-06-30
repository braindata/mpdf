<?php

/**
 *
 */
class bdProjectBasePluginConfiguration extends sfPluginConfiguration
{
  /**
   *
   * @return void
   */
  public function initialize()
  {
    // disable DOMPDF's internal autoloader if you are using Composer
    define('DOMPDF_ENABLE_AUTOLOAD', false);

    define("DOMPDF_ENABLE_HTML5PARSER", true);
    define("DOMPDF_ENABLE_FONTSUBSETTING", true);
    define("DOMPDF_UNICODE_ENABLED", true);
    define("DOMPDF_ENABLE_CSS_FLOAT", true);
    define("DOMPDF_ENABLE_REMOTE", true);

    // include DOMPDF's default configuration
    require_once sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'bdProjectBasePlugin/lib/vendor/dompdf/dompdf_config.inc.php';

  }
}