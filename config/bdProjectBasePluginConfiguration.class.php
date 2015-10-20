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

    if (!defined('DOMPDF_ENABLE_AUTOLOAD'))
      define('DOMPDF_ENABLE_AUTOLOAD', false);

    if (!defined("DOMPDF_ENABLE_HTML5PARSER"))
      define("DOMPDF_ENABLE_HTML5PARSER", true);

    if (!defined("DOMPDF_ENABLE_FONTSUBSETTING"))
      define("DOMPDF_ENABLE_FONTSUBSETTING", true);

    if (!defined("DOMPDF_UNICODE_ENABLED"))
      define("DOMPDF_UNICODE_ENABLED", true);

    if (!defined("DOMPDF_ENABLE_CSS_FLOAT"))
      define("DOMPDF_ENABLE_CSS_FLOAT", true);

    if (!defined("DOMPDF_ENABLE_REMOTE"))
      define("DOMPDF_ENABLE_REMOTE", true);

    // include DOMPDF's default configuration
    require_once sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'bdProjectBasePlugin/lib/vendor/dompdf/dompdf_config.inc.php';

  }
}