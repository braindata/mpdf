<?php

class CountCacheable extends Doctrine_Template
{
  protected $_options = array(
    'relations' => array()
  );
        
  public function setTableDefinition()
  {
    foreach ($this->_options['relations'] as $relation => $options)
    {
      // Build ColumName if no oen is given
      if (!isset($options['columnName']))
      {
        $this->_options['relations'][$relation]['columnName'] = 'num_'.Doctrine_Inflector::tableize($relation);     
      }
      
      // Add column to the model (Parent Relation)
      $columnName = $this->_options['relations'][$relation]['columnName'];
      $relatedTable = $this->_table->getRelation($relation)->getTable();
      
      $this->_options['relations'][$relation]['className'] = $relatedTable->getOption('name');
      $relatedTable->setColumn($columnName, "integer", null, array("default" =>0));
  
      $this->addListener(new CountCacheableListener($this->_options));
    }
  }
  
  public function setUp()
  {
    
  }
}