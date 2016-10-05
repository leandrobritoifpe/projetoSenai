<?php

/*
 * 
 *
 * CRIADA: 05/10/2016
 * ULTIMA ATUALIZACAO : 05/10/2016
 * 
 * DS-> LEANDRO BRITO
 */

/**
 * Description of ProfessorExpertises
 *
 * @author leandro.brito
 */
class ProfessorExpertises {
    //put your code here
    private $id;
    private $codDisciplina;
    private $codSubDisciplina;
    private $codProfesor;
    private $escala;
    
    public function __construct($id,$codDisciplina,$codSubDisciplina, $codProfessor,$esala) {
        $this->id = $id;
        $this->codDisciplina = $codDisciplina;
        $this->codSubDisciplina = $codSubDisciplina;
        $this->codProfesor = $codProfessor;
        $this->escala = $esala;
    }

    
}
