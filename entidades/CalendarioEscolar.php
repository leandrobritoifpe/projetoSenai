
<?php
/*
 * CLASSE DiaNaoLetivoDao
 * OJETIVO : RESPOSAVEL POR TODA A COMUNICACAO COM O BANCO DE DADOS
 * CRIADA : 25/08/2016
 * ULTIMA ATUALIZACAO : 30/08/2016
 * 
 * DS -> LEANDRO BRITO ;)
 */
class CalendarioEscolar {
  
    private $codFilial;
    private $descricao;
    private $status;
    private $diaDaSemana;
    private $nomeDoDia;
    private $dataDia;
    

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
