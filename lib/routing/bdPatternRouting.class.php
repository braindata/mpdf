<?php
  /**
   * Created by PhpStorm.
   * User: johannestyra
   * Date: 21.09.18
   * Time: 15:11
   */

  class bdPatternRouting extends sfPatternRouting
  {
    public function setHost($host){
      $this->options['context']['host'] = $host;
    }
  }