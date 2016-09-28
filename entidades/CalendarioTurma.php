<?php

/*
 * CLASSE CalendarioTurma.php
 * OBJETIVO: PORTADOR DE ATRIBUTOS
 * CRIADA: 20/09/2016
 * ULTIMA ATUALIZACAO : 21/09/2016
 * 
 * DS-> LEANDRO BRITO
 */
class CalendarioTurma {
    private $codigoTurma;
    private $aula;
    private $idHoraTurma;
    private $codFilial;
    private $dataInicial;
    private $dataEfetiva;
    private $horaInicial;
    private $horaFinal;
    private $codHora;
    private $codTurno;
    private $diaSemana;
    private $status;
    private $aulaHorarios;
    private $userCadastrante;
    private $codCurso;
    private $codDisciplina;
    private $id;
    private $diasRecesso;
    
    
    public function set_diasRecesso($diasRecesso){
        $this->diasRecesso = $diasRecesso;
    }

    public function get_diasRecesso(){
        return $this->diasRecesso;
    }
    
    public function set_id($id){
        $this->id = $id;
    }

    public function get_id(){
        return $this->id;
    }
     
    public function set_dataInicial($dataInicial){
        $this->dataInicial = $dataInicial;
    }

    public function get_dataInicial(){
        return $this->dataInicial;
    }
    public function set_codDisciplina($codDisciplina){
        $this->codDisciplina = $codDisciplina;
    }

    public function get_codDisciplina(){
        return $this->codDisciplina;
    }
    public function set_codCurso($codCurso){
        $this->codCurso = $codCurso;
    }
    public function get_codCurso(){
        return $this->codCurso;
    }
    
    public function set_codTurma($codTurma){
        $this->codigoTurma = $codTurma;
    }
    public function get_codTurma(){
        return $this->codigoTurma;
    }
    public function set_aula($aula){
        $this->aula= $aula;
    }
    public function get_aula(){
        return $this->aula;
    }
    public function set_idHoraTurma($idHoraTurma){
        $this->idHoraTurma= $idHoraTurma;
    }
    public function get_ididHoraTurma(){
        return $this->idHoraTurma;
    }
    public function set_codFilial($codFilial){
        $this->codFilial = $codFilial;
    }
    public function get_codFilial(){
        return $this->codFilial;
    }
    public function set_dataEfetiva($dataEfetiva){
        $this->dataEfetiva = $dataEfetiva;
    }
    public function get_dataEfetiva(){
        return $this->dataEfetiva;
    }
    public function set_horaInicial($horaInicial){
        $this->horaInicial = $horaInicial;
    }
    public function get_horaInicial(){
        return $this->horaInicial;
    }
    public function set_horaFinal($horaFinal){
        $this->horaFinal = $horaFinal;
    }
    public function get_horaFinal(){
        return $this->horaFinal;
    }
    public function set_codHora($codHora){
        $this->codHora = $codHora;
    }
    public function get_codHora(){
        return $this->codHora;
    }
    public function set_codTurno($codTurno){
        $this->codTurno = $codTurno;
    }
    public function get_codTurno(){
        return $this->codTurno;
    }
    public function set_diaSemana($diaSemana){
        $this->diaSemana = $diaSemana;
    }
    public function get_diaSemana(){
        return $this->diaSemana;
    }
    public function set_status($status){
        $this->status = $status;
    }
    public function get_status(){
        return $this->status;
    }
    public function set_aulaHorarios($aulaHorarios){
        $this->aulaHorarios = $aulaHorarios;
    }
    public function get_aulaHorarios(){
        return $this->aulaHorarios;
    }
     public function set_userCadastrante($userCadastrante){
        $this->userCadastrante = $userCadastrante;
    }
    public function get_userCadastrante(){
        return $this->userCadastrante;
    }
}
