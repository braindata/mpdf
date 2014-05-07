<?php
class sfWidgetFormSelectFriends extends sfWidgetFormInput
{
  public function configure( $options = array(), $attributes = array() )
  {
    parent::configure($options, $attributes);
    $this->addOption("exclude", false);
    $this->addOption("friends", true);
  }
  
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('Tag');
    $imgs = "";
    
    if ($this->getOption('exclude'))
    {
      if ($this->getOption('friends') == false)
        $exclude_friends = Doctrine_Core::getTable('UserFriend')->getUser($this->getOption('exclude'));
      else
        $exclude_friends = array();
      
      $friends = Doctrine_Core::getTable('UserFriend')->getNewUser(sfContext::getInstance()->getUser(), $this->getOption('exclude'), $this->getOption('friends'));
    }       
    else
    {
      $friends = Doctrine_Core::getTable('UserFriend')->getUser(sfContext::getInstance()->getUser());
    }
    
    foreach ($friends as $friend)
    {

      $img = image_tag($friend->getSfGuardUser()->getProfileImage(), array("class" => "user", "title" => $friend->getSfGuardUser()->printUser()));
      $a = $this->renderContentTag("a",  $img, array("href" => "javascript:void(0)", "rel" => $friend->getSfGuardUser()->getId()));
      $imgs.= $this->renderContentTag("span",  $a, array("class" => "user small"));
    }

    $this->setOption('type', 'hidden');
    
    $imgs.= $this->renderContentTag("div", "", array("class" => "clear"));
    
    $div = $this->renderContentTag("div", $imgs, array("class" => "box box_user box_user_medium select_user"));
    $div_box = $this->renderContentTag("div", $div, array("class" => "content_box"));
    
    return $div_box.parent::render($name, $value, $attributes, $errors);
  }

  
}