<?php
  class Player extends GameObject{
    private $isDead;
    
    public function __construct($position){
      parent::__construct($position, 3);
      $this->isDead = false;
      $this->icon = "P";
    }
    public function set_isDead($isDead){
      $this->isDead = $isDead;
    }
    public function get_isDead(){
      return $this->isDead; 
    }
    public function get_icon(){
      return $this->icon;
    }
    public function move($direction, $board){
      $objects = $board->get_path_objects($this->position, $direction);
      if (count($objects) > 0){
        $found_gold = false;
        foreach($objects as $obj){
          switch($obj->get_type()){
            case 1:
              if (!$found_gold){
                $obj->update();
                $this->set_position($obj->get_position());
                $found_gold = true;
              }
              break;
            case 2:
              if (!$found_gold){
                $obj->update();
              }
              break;
            case 3:
              if ($obj->get_status() == 1){
                $this->set_isDead(true);
              }
              break;
            case 9:
              if (!$found_gold){
                $this->set_isDead(true);
              }
              break;
            default:
              exit();
          }
        }
      }else{
        throw new Exception;
      }

    }

  }