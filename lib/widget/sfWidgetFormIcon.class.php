<?php
class sfWidgetFormIcon extends sfWidgetFormInput
{

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $imgs = "";
    for ($i = 1; $i <= 12; $i++ )
    {
      if ($i == $value)
        $class = "active";
      else
        $class = "";

      $img = $this->renderContentTag("img", "", array("src" => "/images/membericons/40x40/icon_".$i."_40x40.png", "class" => "user  {$class}"));
      $a = $this->renderContentTag("a",  $img, array("href" => "javascript:void(0)", "id" => "icon_{$i}"));
      $imgs.= $this->renderContentTag("span",  $a, array("class" => "user small"));
    }

    $this->setOption('type', 'hidden');

    $div = $this->renderContentTag("div", $imgs, array("class" => "icon"));
    return $div.parent::render($name, $value, $attributes, $errors);
  }

  
}