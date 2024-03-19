<?php
  require_once('classes.php');


  function main(){
    $players = json_decode(file_get_contents('save_data.json'));

    $player = find_account('GUEST', $players);

    $quit = false;
    while (!$quit){
      echo(chr(27).chr(91).'H'.chr(27).chr(91).'J');
      echo('Minor Inconvenience' . PHP_EOL . PHP_EOL);
      echo('Please view read me for rules' . PHP_EOL . PHP_EOL);
      echo('Logged in as: ' . $player->name . PHP_EOL . PHP_EOL);
      echo('Options:' . PHP_EOL);
      echo('[q] : Quit the program' . PHP_EOL);
      echo('[l] : Login' . PHP_EOL);
      echo('[c] : Create login' . PHP_EOL);
      //echo('[d] : Delete account' . PHP_EOL);
      echo('[p] : Play game' . PHP_EOL);

      $choice = fgetc(STDIN);
      switch($choice){
        case 'q':
          $quit = quit();
          break;
        case 'l':
          $player = login($players);
          break;
        case 'c':
          $player = create($players);
          break;
        case 'p':
          play($player);
          break;
      }
    }

  }

  function quit(){
    echo(chr(27).chr(91).'H'.chr(27).chr(91).'J');
    echo('Thanks For Playing!');
    return true;
  }
  function login($players){

    echo(chr(27).chr(91).'H'.chr(27).chr(91).'J');
    echo('Login' . PHP_EOL . PHP_EOL . PHP_EOL);
    echo('Enter [b] at any stage to return to the menu' . PHP_EOL . PHP_EOL);
    echo('Enter Name: ');

    fgets(STDIN);
    $name = fgets(STDIN);

    if (trim($name) == 'b'){
      return find_account('GUEST', $players);
    }else{
      $returned_player = find_account(trim(strtoupper($name)), $players);
      if($returned_player){
        return $returned_player;
      }else{
        echo('Account does not exist (enter any key to return)');
        fgetc(STDIN);
        return find_account('GUEST', $players);
      }
    }
  }
  function create($players){
    echo(chr(27).chr(91).'H'.chr(27).chr(91).'J');
    echo('Create Account' . PHP_EOL . PHP_EOL . PHP_EOL);
    echo('Enter [b] at any stage to return to the menu' . PHP_EOL . PHP_EOL);
    echo('Enter Name: ');

    fgets(STDIN);
    $name = fgets(STDIN);

    if (trim($name) == 'b'){
      return find_account('GUEST', $players);
    }else{
      $added_acc = add_account(trim(strtoupper($name)), $players);
      if($added_acc){
        echo('Account created successfully' . PHP_EOL);
        fgetc(STDIN);
        return find_account(trim(strtoupper($name)), $players);
      }else{
        echo('Error adding account (Enter any key to continue');
        fgetc(STDIN);
        return find_account('GUEST', $players);
      }
    }
  }
  function find_account($account, $accounts){
    foreach ($accounts as $acc){
      if ($account == $acc->name){
        return $acc;
      }
    }
    return null;
  }
  function add_account($account, &$accounts){
    try{
      if (find_account($account, $accounts)){
        echo('Account name already exists (Enter any key to continue)');
        fgetc(STDIN);
        return false;
      }else{
        $obj = new stdClass();
        $obj->name = $account;
        $obj->level = 1;
        $accounts[] = $obj;
        $encoded = json_encode($accounts);
        file_put_contents('save_data.json', $encoded);
        return true;
      }
    }catch(Exception $e){
      return false;
    }
  }
  function update_level($level, $account){

  }
  function play($player){
    
    $playing = true;
    $board = new Board($player->level);
    while($playing){
      $board->display();
      $player = $board->get_player();
      fgets(STDIN);
      $move = fgetc(STDIN);
      $moved = false;
      while(!$moved){
        switch($move){
          case 'w':
            $player->move('UP', $board);
            $moved = true;
            break;
          case 'a':
            $player->move('LEFT', $board);
            $moved = true;
            break;
          case 'd':
            $player->move('RIGHT', $board);
            $moved = true;
            break;
          case 's':
            $player->move('DOWN', $board);
            $moved = true;
            break;
          case 'q':
            $moved = true;
            break;
        }
      }
      if ($player->get_isDead()){
        echo(chr(27).chr(91).'H'.chr(27).chr(91).'J');
        echo('Game Over. You Made Dave Cry!');
        fgets(STDIN);
        fgetc(STDIN);
        $playing = false;
      }
      if ($board->get_gold()){
        $nextround = false;
        while(!$nextround){
          //echo(chr(27).chr(91).'H'.chr(27).chr(91).'J');
          echo('You Win!');
          echo(' Next Round [y/n]');
          fgets(STDIN);
          $choice = fgetc(STDIN);
          if ($choice == "n"){
            $playing = false;
            $nextround = false;
          }elseif ($choice == 'y'){
            update_level();
            $nextround = true;
          }
        }
      }
    }
  }
  main();