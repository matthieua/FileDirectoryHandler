<?php
/**
 * Created by PhpStorm.
 * User: Matthieu
 * Date: Apr 3, 2011
 * Time: 1:58:23 PM
 * To change this template use File | Settings | File Templates.
 */

class Notification {
  private $message;
  private $type;


  public function __construct($message, $type = 'good') {
    $this->message = $message;
    $this->type = $type;
  }

  public function getType() {
    return $this->type;
  }
  
  public function setType($type) {
    if (false != preg_match('/good|bad/i', strtolower($type)) && ($this->type != strtolower($type))) {
      $this->type = strtolower($type);
    }
  }


  public function getMessage() {
    if (!empty($this->message)) {
      return "<div class=\"{$this->type}\"><strong>{$this->message}</strong></div>";
    }
    return false;
  }

  public function setMessage($message) {
    if (!empty($message)) {
      $this->message = $message;
    }
  }


}
 
