<?php
/*
 * CLASSE DiaNaoLetivoDao
 * OJETIVO : RESPOSAVEL POR TODA A COMUNICACAO COM O BANCO DE DADOS
 * CRIADA : 25/08/2016
 * ULTIMA ATUALIZACAO : 30/08/2016
 * 
 * DS -> LEANDRO BRITO ;)
 */
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
    private $usuarioCadastrante;
    private $dataInicial;
    private $dataFinal;
    
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
  public function set_usuarioCadastrante($usuarioCadatrante){
      $this->usuarioCadastrante = $usuarioCadatrante;
  }
  public function get_usuarioCadastrante() {
      return $this->usuarioCadastrante;
  }
  public function set_dataInicial($dataInicial){
      $this->dataInicial = $dataInicial;
  }
  public function get_dataInicial(){
      return $this->dataInicial;
  }
  public function set_dataFinal($dataFinal){
      $this->dataFinal = $dataFinal;
  }
  public function get_dataFinal(){
      return $this->dataFinal;
  }
}
