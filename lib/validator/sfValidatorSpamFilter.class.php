<?php
class sfValidatorSpamFilter extends sfValidatorString
{
  /**
   * @param array $options   An array of options
   * @param array $messages  An array of error messages
   * @see sfValidatorBase
   */
  protected function configure($options = array(), $messages = array())
  {
    $this->addOption('similar', 95);
    $this->addOption('min_letters', 100);
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
    $user = sfContext::getInstance()->getUser();
    
    $messages = $user->getAttribute('messages', array());
    $limit = $this->getOption('similar');
    
    if (strlen($value) < $this->getOption('min_letters')) // If message < 100 -> Message too short
    {
      return $value;
    }
    elseif (count($messages) < 2) // If counter < 2 Messages
    {
      $messages[] = $value;
      $user->setAttribute('messages', $messages);
      
      return $value;
    }
    
    $messages[] = $value;
    
    similar_text($messages[0], $messages[1], $percent1);
    similar_text($messages[1], $messages[2], $percent2);
    
    array_shift($messages);
    $user->setAttribute('messages', $messages);
    
    if ($percent1 > $limit && $percent2 > $limit)
    { 
      $user->getGuardUser()->setIsActive(false);
      $user->getGuardUser()->save();
      
      sfContext::getInstance()->getMailer()->send(new sfBaseMessage("message_block_spamuser", array(
              "sf_subject" => $user->getGuardUser(),
              "message" => $value
             )));
      
      $user->signOut();
      
      
      throw new sfValidatorError($this, 'invalid', array('value' => $value));
    }
 
    return $value;
  }
}
?>
