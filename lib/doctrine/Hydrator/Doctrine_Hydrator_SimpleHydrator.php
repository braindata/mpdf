<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Doctrine_Hydrator_TranslationHydrator
 *
 * @author Johannes
 */
class Doctrine_Hydrator_SimpleHydrator extends Doctrine_Hydrator_Abstract {

  public function hydrateResultSet($stmt) {
    $cache = array();
    $result = array();

    while ($data = $stmt->fetch(Doctrine_Core::FETCH_ASSOC)) {
      $result[] = $this->_gatherRowData($data, $cache);
    }

    return $result;
  }

  protected function _gatherRowData($data, &$cache, $aliasPrefix = true) {
    $rowData = array();
    foreach ($data as $key => $value) {
      $e = explode('__', $key);
      $rowData[$e[1]] = $value;
    }
    
    return $rowData;
  }

}

?>
