<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Disciplina
 *
 * @author leandro.brito
 */
class Disciplina {
    private $codigoDisciplina;
    private $descricaoDisciplina;
    private $horaDisciplina;
    private $codPeriodo;
    private $periodo;
    private $cargaHora;
    private $ordemDeEnsino;
    
     public function set_ordemDeEnsino($ordemDeEnsino){
        $this->ordemDeEnsino = $ordemDeEnsino;
    }
    public function get_ordemDeEnsino(){
        return $this->ordemDeEnsino;
    }
    
    public function set_cargaHora($cargaHora){
        $this->cargaHora = $cargaHora;
    }
    public function get_cargaHora(){
        return $this->cargaHora;
    }
    
     public function set_periodo($periodo){
        $this->periodo = $periodo;
    }
    public function get_periodo(){
        return $this->periodo;
    }
   
    public function set_descricaoDisciplina($descricaoDisciplina){
        $this->descricaoDisciplina = $descricaoDisciplina;
    }
    public function get_descricaoDisciplina(){
        return $this->descricaoDisciplina;
    }
    
    public function set_codDisciplina($codDisciplina){
        $this->codigoDisciplina = $codDisciplina;
    }
    public function get_codDisciplina(){
        return $this->codigoDisciplina;
    }
    public function set_horaDisciplina($horaDisciplina){
        $this->horaDisciplina = $horaDisciplina;
    }
    public function get_horaDisciplina(){
        return $this->horaDisciplina;
    }
     public function set_codPeriodo($codPeriodo){
        $this->codPeriodo = $codPeriodoa;
    }
    public function get_codPeriodo(){
        return $this->codPeriodo;
    }
}
