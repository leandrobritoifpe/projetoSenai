<?php
/* ARQUVOS CadastraDiaNaoLetivo
 * OBJETIVO: SERVIR DE CONTROLE PARA O DAO
 * CRIADA: 13/08/2016
 * ULTIMA ATUALIZACAO : 14/09/2016
 * 
 * DS -> LEANDRO BRITO
 */
class CalendarioProfessor {
    private $codigoDocente;
    private $codCalendarioEscola;
    private $dataDia;
    private $descricao;
    private $horaIni;
    private $horaFini;
    private $codigoTurno;
    private $codFilial;
    private $diaLetivo;
    private $aula;
    private $status;
    private $diaDaSemana;
    private $quantidadeHora;
    private $ano;
    private $flagFeriado;
    private $userCadastrante;
    
    public function set_userCadastrante($userCadastrante){
        $this->userCadastrante = $userCadastrante;
    }
    public function get_userCadastrante(){
        return $this->userCadastrante;
    }
    public function set_flagFeriado($flagFeriado){
        $this->flagFeriado = $flagFeriado;
    }
    public function get_flagFeriado(){
        return $this->flagFeriado;
    }
    public function set_ano($ano){
       $this->ano = $ano;
   }
   public function get_ano(){
       return $this->ano;   }
    
   public function set_qtdHoras($qtdHoras){
       $this->quantidadeHora = $qtdHoras;
   }
   public function get_qtdHoras(){
       return $this->quantidadeHora;   }
    public function set_codigoDocente($codigoDocente){
        $this->codigoDocente = $codigoDocente;
    }
     public function get_codigoDocente() {
         return $this->codigoDocente;
     }
     public function set_codCalendario($codCalendario){
        $this->codCalendarioEscola = $codCalendario;
    }
     public function get_codCalendario() {
         return $this->codCalendarioEscola;
     }
     public function set_dataDia($dataDia){
        $this->dataDia = $dataDia;
    }
     public function get_dataDia() {
         return $this->dataDia;
     } 
     public function set_descricao($descricao){
        $this->descricao = $descricao;
    }
     public function get_descricao() {
        return $this->descricao;
     }
     public function set_horaIni($horaIni){
       $this->horaIni = $horaIni;
    }
     public function get_horaIni() {
         return $this->horaIni;
     } 
      public function set_horaFini($horaFini){
        $this->horaFini = $horaFini;
    }
     public function get_horaFini() {
         return $this->horaFini;
     }
     public function set_codigoTurno($codigoTurno){
        $this->codigoTurno = $codigoTurno;
    }
     public function get_codigoTurno() {
         return $this->codigoTurno;
     }
     public function set_codigoFilial($codigoFilial){
        $this->codFilial = $codigoFilial;
    }
     public function get_codigoFilial() {
         return $this->codFilial;
     } 
     public function set_diaLetivo($diaLetivo){
        $this->diaLetivo = $diaLetivo;
    }
     public function get_diaLetivo() {
         return $this->diaLetivo;
     }
     public function set_aula($aula){
        $this->aula = $aula;
    }
     public function get_aula() {
         return $this->aula;
     }
     public function set_estatus($status){
        $this->status = $status;
    }
     public function get_status() {
         return $this->status;
     } 
     public function set_diaDaSemana($diaDaSemana){
        $this->diaDaSemana = $diaDaSemana;
    }
     public function get_diaDaSemana() {
         return $this->diaDaSemana;
     }     
}
