<?php
  class Board{
    private $level;
    private $data;
    private $DIMENSIONS = array(10, 15);
    public function __construct($level){
      $this->level = $level;
      $this->data = $this->get_level_data();
    }
    public function display(){
      echo(chr(27).chr(91).'H'.chr(27).chr(91).'J'); // clear terminal
      $count = 1;
      foreach ($this->data as $tile){
        echo($tile->get_icon() . ' ');
        if (($count % $this->DIMENSIONS[0]) == 0){ // If Current position is at the end of the line
          echo(PHP_EOL);
        }
        $count++;
      }
    }
    private function get_level_data(){
      $level_data = array();
      $raw_level_data = json_decode(file_get_contents("map_data/level_$this->level.json"));

      $x_pos = 0;
      $y_pos = 0;
      foreach ($raw_level_data as $row){
        foreach($row as $element){ // for each bit of data in the list
          $pos = array($x_pos, $y_pos);

          $obj = match($element){
            0 => new Tile($pos), // Dirt
            1, 2, 3 => new Tile($pos, 1, $element), // Gold
            4, 5 => new Tile($pos, 2, $element - 3), // hole
            8 => new Player($pos), //Player
            9 => new Tile($pos, 9), // Edge
            default => throw new Exception
          }; // create an object depending on the type of element

          $level_data[] = $obj;
          $y_pos++;
        }
        $y_pos = 0;
        $x_pos++;
      }
      return $level_data;
    }
    public function get_path_objects($position, $direction){
      $objects = (array) null;
      foreach ($this->data as $obj){
        if (($obj->get_position()[0] == $position[0] xor $obj->get_position()[1] == $position[1]) && $obj->get_type() != 0){ // if obj in row or collumn of player, and not std tile
          switch($direction){
            case 'UP':
              if ($obj->get_position()[0] < $position[0] && $obj->get_position()[1] == $position[1]){
                $objects[] = $obj;
              }
              break;
            case 'DOWN':
              if ($obj->get_position()[0] > $position[0] && $obj->get_position()[1] == $position[1]){
                $objects[] = $obj;
              }
              break;
            case 'LEFT':
              if ($obj->get_position()[1] < $position[1] && $obj->get_position()[0] == $position[0]){
                $objects[] = $obj;
              }
              break;
            case 'RIGHT':
              if ($obj->get_position()[1] > $position[1] && $obj->get_position()[0] == $position[0]){
                $objects[] = $obj;
              }
              break;
            default:
              throw new Exception;
          }
        }
      }
      return $this->array_sort($objects, $direction);
    }
    public function get_object($position){
      $object = null;
      foreach ($this->data as $obj){
        if ($obj->get_position()[0] == $position[0] && $obj->get_position()[1] == $position[1]){
          $object = $obj;
        }
      }
      return $object;
    }
    public function get_gold(){
      $gold;
      $counter = 0;
      foreach($this->data as $obj){
        if ($obj->get_type() == 2 or $obj->get_type() == 3 or $obj->get_type() == 1){
          $counter++;
        }
      }
      if($counter){
        $gold = false;
      }else{
        $gold = true;
      }
      return $gold;
    }
    public function get_player(){
      foreach ($this->data as $obj){
        if ($obj->get_type() == 3){
          return $obj;
        }
      }
    }
    public function array_sort($array, $direction){
      $sorted_array = $array;
      switch($direction){
        case 'UP':
          arsort($sorted_array);
          break; // no down case as down gives correct order
        case 'LEFT':
          arsort($sorted_array);
          break; // no Right case as right gives correct order
      }
      return $sorted_array;
    }
  }