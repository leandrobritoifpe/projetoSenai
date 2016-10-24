<?php

/*
 * CLASSE Disciplina
 * OBJETIVO: PORTADOR DE ATRIBUTOS
 * CRIADA: 08/09/2016
 * ULTIMA ATUALIZACAO : 21/09/2016
 * 
 * DS-> LEANDRO BRITO
 */
class CursoDisciplina {
    private $codigoDisciplina;
    private $descricaoDisciplina;
    private $horaDisciplina;
    private $codPeriodo;
    private $periodo;
    private $cargaHora;
    private $ordemDeEnsino;
    private $codCurso;
    private $codHabilitacao;
    private $codGrade;
    private $objetivo;
    private $recmodfiedon;
    private $nomeDisciplina;
    private $nomeReduzido;
    private $complemento;
    private $codTipoCurso;
    private $cargaHorariaTeorica;
    private $cargaHorariaPratica;
    private $chLaboratorio;
    private $idftDisciplina;
    private $recmodifidonDisc;
    private $status;
    private $objetivoSgrade;
    private $ch;
    private $subCodigo;
    private $subDiscOrdem;
    private $subHora;
    private $codFilial;
    
    public function set_codFilial($codFilial){
        $this->codFilial = $codFilial;
    }
    public function get_codFilial(){
        return $this->codFilial;
    }
    public function set_subHora($subHora){
        $this->subHora = $subHora;
    }
    public function get_subHora(){
        return $this->subHora;
    }
    
    public function set_subDiscOrdem ($subDiscOrdem ){
        $this->subDiscOrdem = $subDiscOrdem;
    }
    public function get_subDiscOrdem (){
        return $this->subDiscOrdem;
    }
    public function set_subCodigo($subCodigo){
        $this->subCodigo = $subCodigo;
    }
    public function get_subCodigo(){
        return $this->subCodigo;
    }
    
    public function set_ch($ch){
        $this->ch = $ch;
    }
    public function get_ch(){
        return $this->ch;
    }
    
    public function set_objetivoSgrade($objetivoSgrade){
        $this->objetivoSgrade = $objetivoSgrade;
    }
    public function get_objetivoSgrade(){
        return $this->objetivoSgrade;
    }
    public function set_chLaboratorio($chLaboratorio){
        $this->chLaboratorio = $chLaboratorio;
    }
    public function get_chLaboratorio(){
        return $this->chLaboratorio;
    }
    public function set_status($status){
        $this->status = $status;
    }
    public function get_status(){
        return $this->status;
    }
    public function set_recmodifidonDisc($recmodifidonDisc){
        $this->recmodifidonDisc = $recmodifidonDisc;
    }
    public function get_recmodifidonDisc(){
        return $this->recmodifidonDisc;
    }
     public function set_idftDisciplina($idftDisciplina){
        $this->idftDisciplina = $idftDisciplina;
    }
    public function get_idftDisciplina(){
        return $this->idftDisciplina;
    }
    public function set_cargaHorariaTeorica($cargaHorariaTeorica){
        $this->cargaHorariaTeorica = $cargaHorariaTeorica;
    }
    public function get_cargaHorariaTeorica(){
        return $this->cargaHorariaTeorica;
    }
    public function set_cargaHorariaPratica($cargaHorariaPratica){
        $this->cargaHorariaPratica = $cargaHorariaPratica;
    }
    public function get_cargaHorariaPratica(){
        return $this->cargaHorariaPratica;
    }
    
    public function set_codTipoCurso($codTipoCurso){
        $this->codTipoCurso = $codTipoCurso;
    }
    public function get_codTipoCurso(){
        return $this->codTipoCurso;
    }
    public function set_complemento($complemento){
        $this->complemento = $complemento;
    }
    public function get_complemento(){
        return $this->complemento;
    }
    public function set_codCurso($codCurso){
        $this->codCurso = $codCurso;
    }
    public function get_codCurso(){
        return $this->codCurso;
    }
    public function set_codHab($codHab){
        $this->codHabilitacao = $codHab;
    }
    public function get_codHab(){
        return $this->codHabilitacao;
    }
    public function set_codGrade($codGrade){
        $this->codGrade = $codGrade;
    }
    public function get_codGrade(){
        return $this->codGrade;
    }
    public function set_objetivo($objetivo){
        $this->objetivo = $objetivo;
    }
    public function get_objetivo(){
        return $this->objetivo;
    }
    public function set_recmodifiendo($recmodifiendo){
        $this->recmodfiedon = $recmodifiendo;
    }
    public function get_recmodifiendo(){
        return $this->recmodfiedon;
    }
    public function set_nomeDisciplina($nomeDisciplina){
        $this->nomeDisciplina = $nomeDisciplina;
    }
    public function get_nomeDisciplina(){
        return $this->nomeDisciplina;
    }
    public function set_nomeReduzido($nomeReduzido){
        $this->nomeReduzido = $nomeReduzido;
    }
    public function get_nomeReduzido(){
        return $this->nomeReduzido;
    }
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
        $this->codPeriodo = $codPeriodo;
    }
    public function get_codPeriodo(){
        return $this->codPeriodo;
    }
}
