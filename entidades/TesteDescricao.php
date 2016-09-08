<?php

class TesteDescricao {
    private $id,$descricao,$status,$recreateby,$recmodify,$recmodifidon, $tipo;
    
  public function set_id($id){
    $this->id = $id;
  }
  public function get_id(){
    return $this->id;
  }
}
