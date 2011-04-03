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
  private $flag;


  public function __construct($message = '', $flag = 'good') {
    $this->message = $message;
    $this->flag = $flag;
  }

  public function getFlag() {
    return $this->flag;
  }
  
  public function setFlag($flag) {
    if (false != preg_match('/good|bad/i', strtolower($flag)) && ($this->flag != strtolower($flag))) {
      $this->flag = strtolower($flag);
    }
  }

  public function getMessage() {
    if (!empty($this->message)) {
      return "<div class=\"{$this->flag}\"><strong>{$this->message}</strong></div>";
    }
    return false;
  }

  public function setMessage($message, $flag = '') {
    $this->message = $message;
    if (!empty($flag)) $this->flag = $flag;
  }


}
 
