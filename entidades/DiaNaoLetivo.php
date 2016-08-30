<?php
// 30/08/2016
class DiaNaoLetivo {
    private $descricao;
    private $horaInicial;
    private $horaFinal;
    private $data;
    private $id;
    private $codTurno;
    private $codFilial;
    private $status;
    private $diaDaSemana;
    
  public function set_descricao($Vdescricao){
    $this->descricao = $Vdescricao;
  }
  public function get_descricao(){
    return $this->descricao;
  }
  public function set_horaInicial($VhoraInicial){
      $this->horaInicial = $VhoraInicial;
  }
  public function get_horaInicial(){
     return $this->horaInicial;
  }
  public function set_horaFinal($VhoraFinal){
      $this->horaFinal = $VhoraFinal;
  }
  public function get_horaFinal(){
      return $this->horaFinal;
 }
   public function set_data($Vdata){
      $this->data = $Vdata;
  }
  public function get_data(){
      return $this->data;
  }
   public function set_id($Vid){
      $this->id = $Vid;
  }
  public function get_id(){
      return $this->id;
  }
   public function set_codTurno($VcodTurno){
      $this->codTurno = $VcodTurno;
  }
  public function get_codTurno(){
      return $this->codTurno;
  }
   public function set_codFilial($VcodFilial){
      $this->codFilial = $VcodFilial;
  }
  public function get_codFilial(){
      return $this->codFilial;
  }
  public function set_status($Vstatus){
     $this->status = $Vstatus;
  }
  public function get_status(){
      return $this->status;
  }
  public function set_diaSemana($VdiaSemana){
      $this->diaDaSemana = $VdiaSemana;
  }
  public function get_diaSemana(){
      return $this->diaDaSemana;
  }
 
}
