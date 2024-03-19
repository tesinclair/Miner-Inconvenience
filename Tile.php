<?php
  class Tile extends GameObject{
    private $status;
    private $icon;
    public function __construct($position, $type = 0, $status = null) {
      parent::__construct($position, $type);
      $this->type = $type;
      $this->status = $status;
      $this->update_icon();
    }
    private function update_icon(){
      switch($this->type){
        case 0:
          $this->icon = "+";
          break;
        case 1:
          if ($this->status === 0){
            $this->type = 0;
            $this->status = null;
            $this->update_icon();
          }else{
          $this->icon = strval($this->status);
          }
          break;
        case 2:
          if($this->status == 2){
            $this->icon = "C";
          }elseif($this->status == 1){
            $this->icon = "H";
          }
          break;
        case 9:
          $this->icon = "E";
          break;
        default:
          echo $this->status . $this->type;
          throw new Exception;
      }
    }
    public function update(){
      if ($this->status && $this->status > 0){
        $this->status--;
        $this->update_icon($this->type, $this->status);
      }
      }
    public function get_status(){
      return $this->status;
    }
    public function get_icon(){
      return $this->icon;
    }

  }