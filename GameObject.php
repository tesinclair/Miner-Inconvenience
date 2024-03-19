<?php
  class GameObject{
    protected $position;
    private $type;

    public function __construct($position, $type){
      $this->position = $position;
      $this->type = $type;
    }

    public function set_position($position){
      $this->position = $position;
    }
    
    public function get_position(){
      return $this->position;
    }

    public function get_type(){
      return $this->type;
    }
  }