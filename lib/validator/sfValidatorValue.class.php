<?php
class sfValidatorValue extends sfValidatorBase
{
  /**
   * @param array $options   An array of options
   * @param array $messages  An array of error messages
   * @see sfValidatorBase
   */
  protected function configure($options = array(), $messages = array())
  {
    $this->addOption('value');
  }
 
  /**
   * Cleans the input value.
   *
   * @param  mixed $value  The input value
   * @return mixed The cleaned value
   * @throws sfValidatorError
   */
  protected function doClean($value)
  {
    if ($this->getOption('value') != $value)
    {
      throw new sfValidatorError($this, 'invalid', array('value' => $value));
    }
 
    return $value;
  }
}
?>
