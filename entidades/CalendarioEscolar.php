<?php

class CalendarioEscolar {
   // private $dataInicial;
    //private $dataFinal;
    private $codFilial;
    private $descricao;
    private $status;
    private $diaDaSemana;
    private $nomeDoDia;
    private $dataDia;
    
//    public function set_dataInicial($dataInical) {
//        $this->dataInicial = $dataInical;
//    }
//    public function get_dataInicial() {
//        return $this->dataInicial;
//    }
//    public function set_dataFinal($dataFinal) {
//        $this->dataFinal = $dataFinal;
//    }
//    public function get_dataFinal() {
//        return $this->dataFinal;
//    }
    public function set_codFilial($codFilial) {
        $this->codFilial = $codFilial;
    }
    public function get_codFilial() {
        return $this->codFilial;
    }
    public function set_descricao($descricao) {
        $this->descricao = $descricao;
    }
    public function get_descricao() {
        return $this->descricao;
    }
    public function set_status($status) {
        $this->status = $status;
    }
    public function get_status() {
        return $this->status;
    }
    public function set_nomeDoDia($nomeDoDia) {
        $this->nomeDoDia = $nomeDoDia;
    }
    public function get_nomeDoDia() {
        return $this->nomeDoDia;
    }
     public function set_diaDaSemana($diaDaSemana) {
        $this->diaDaSemana = $diaDaSemana;
    }
    public function get_diaDaSemana() {
        return $this->diaDaSemana;
    }
    public function set_dataDia($dataDia) {
        $this->dataDia = $dataDia;
    }
    public function get_dataDia() {
        return $this->dataDia;
    }
    
}
