<?php

/**
 * Description of BaseTable
 *
 * @author Johannes
 */
class BaseTable extends Doctrine_Table {

  public static function getTranslations($table, $ids)
  {
    if(! is_array($ids)) {
      $ids = array($ids);
    }

    $q = Doctrine_Query::create();

    $q->from(sprintf('%sTranslation t', $table))
      ->whereIn('t.id', $ids);

    return $q->execute();
  }

  public function getTranslation(Doctrine_Query $q, $culture = false) {
    $rootAlias = $q->getRootAlias();

    if ($culture === false)
      $culture = sfContext::getInstance()->getUser()->getCulture();

    if ($culture) {
      $q->innerJoin(sprintf("%s.Translation t ON %s.id = t.id AND t.lang = '%s'", $rootAlias, $rootAlias, $culture));
    }

    return $q;
  }

  public static function getTranslationsForLucene($table, $id)
  {
    $translations = self::getTranslations($table, $id);
    $stack = array();

    foreach($translations as $entry)
    {
      foreach($entry as $val)
      {
        if($val) {
          $stack[] = $val;
        }
      }
    }

    return implode(' ', $stack);
  }

  public function getBaseTranslation(Doctrine_Query $q, $culture = false) {
    $rootAlias = $q->getRootAlias();

    if ($culture === false)
      $culture = sfContext::getInstance()->getUser()->getCulture();

    if ($culture) {
      $q->leftJoin(sprintf("%s.Translation t ON %s.id = t.id AND t.lang = '%s'", $rootAlias, $rootAlias, $culture));
    }

    return $q;
  }

  public function getDataAreaItem($dataarea, $key, $value) {
    $q = $this->createQuery('i')
      ->where('dataareaid = ? ', $dataarea)
      ->andWhere("$key = ?", $value);

    return $q->fetchOne();
  }

  public function getItem($id) {
    $q = $this->createQuery('i')
      ->where('id = ? ', $id);

    return $this->getBaseTranslation($q)->fetchOne();
  }

  public function getItems() {
    $q = $this->createQuery('i');
    return $this->getTranslation($q)->execute();
  }

  public function getBaseItem($id) {
    $q = $this->createQuery('i')
      ->where('id = ? ', $id);

    return $this->getBaseTranslation($q)->fetchOne();
  }

  public function getBaseItems() {
    $q = $this->createQuery('i');
    return $this->getBaseTranslation($q)->execute();
  }

  public function getAllIds() {
    $q = $this->createQuery('i')->select('i.id')->orderBy('id');
    return $q->execute();
  }

  public function getAllRefs($options = array()) {
    $q = $this->createQuery('i')
      ->select('name_ref')
      ->groupBy('name_ref')
      ->orderBy('name_ref');

    if (array_key_exists('model-ref', $options) && $options['model-ref'])
      $q->where('i.model_ref = ?', $options['model-ref']);

    return $q->setHydrationMode(DOCTRINE_CORE::HYDRATE_ARRAY)->execute();
  }

  public function getItemsByRef($name_ref, $culture) {
    $q = $this->createQuery('i')
      ->select('i.name_ref, t.*')
      ->where('name_ref = ? ', $name_ref);

    return $this->getBaseTranslation($q, $culture)->execute();
  }

}

?>