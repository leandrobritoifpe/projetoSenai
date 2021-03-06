/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  leandro.brito
 * Created: Oct 21, 2016
 */

/* TABELA DE CURSO*/

-- ORIGEM
SELECT COUNT(CODCURSO) 
FROM  SCURSO  
WHERE ((CODAREA IS NOT NULL) 
AND (CODTIPOCURSO IS NOT NULL) 
AND (IDFT IS NOT NULL) 
AND (IDEIXOTECNOLOGICO IS NOT NULL)
AND (CODTIPOCURSO IS NOT NULL)) 
AND CODCOLIGADA = 3;

--DESTINO
SELECT COUNT(CODCURSO) FROM PHE_SCURSO;

/* TABELA DE TURNO*/
--ORIGEM
SELECT COUNT(CODCOLIGADA) FROM dbo.STURNO WHERE IDFT IS NOT NULL AND CODCOLIGADA = 3;

--DESTINO
SELECT COUNT(CODTURNO) FROM PHE_STURNO;


/* TABELA DE FILIAL*/

--ORIGEM
SELECT COUNT(CODCOLIGADA) FROM dbo.GFILIAL WHERE CODCOLIGADA = 3;

--DESTINO
SELECT COUNT(CODFILIAL) FROM PHE_GFILIAL;


/* TABELA DE dbo.SEIXOTECNOLOGICO */

--ORIGEM
SELECT COUNT(IDEIXOTECNOLOGICO) FROM dbo.SEIXOTECNOLOGICO;

--DESTINO
SELECT COUNT(IDEIXOTECNOLOGICO) FROM PHE_SEIXOTECNOLOGICO;


/* TABELA DE dbo.SDISCIPLINA */

--ORIGEM
SELECT COUNT(CODCOLIGADA) FROM dbo.SDISCIPLINA WHERE CH IS NOT NULL AND CODCOLIGADA = 3;

--DESTINO
SELECT COUNT(CODCOLIGADA) FROM PHE_SDISCIPLINA;


/* TABELA DE dbo.STIPOSALA */

--ORIGEM
SELECT COUNT(CODCOLIGADA) FROM dbo.STIPOSALA WHERE CODCOLIGADA = 3;

--DESTINO
SELECT COUNT(CODCOLIGADA) FROM PHE_STIPOSALA;


/* TABELA DE dbo.SSALA */

--ORIGEM
SELECT COUNT(CODCOLIGADA) 
FROM dbo.SSALA 
WHERE ((CODTIPOSALA IS NOT NULL)
AND (CAPACIDADE IS NOT NULL)
AND (CAPACIDADEMAXIMA IS NOT NULL)
AND (CAPACIDADEPROVA IS NOT NULL))
AND CODCOLIGADA = 3;

--DESTINO
SELECT COUNT(CODCOLIGADA) FROM PHE_SSALA;



/* TABELA DE dbo.SPREDIOCOMPL */

--ORIGEM
SELECT COUNT(CODCOLIGADA) FROM dbo.SPREDIOCOMPL WHERE (CODFILIAL IS NOT NULL) AND CODCOLIGADA = 3;

--DESTINO
SELECT COUNT(CODCOLIGADA) FROM PHE_SPREDIOCOMPL;


/* TABELA DE dbo.SPREDIO */

--ORIGEM
SELECT COUNT(CODCOLIGADA) 
FROM dbo.SPREDIOCOMPL 
WHERE ((CODFILIAL IS NOT NULL) 
AND (CODCOLIGADA IS NOT NULL))
AND CODCOLIGADA = 3;

--DESTINO
SELECT COUNT(CODCOLIGADA) FROM PHE_SPREDIO;



/* TABELA DE dbo.SHORARIO */

--ORIGEM
SELECT COUNT(CODCOLIGADA) FROM dbo.SHORARIO  WHERE (DIASEMANA IS NOT NULL) AND CODCOLIGADA = 3

--DESTINO
SELECT COUNT(CODCOLIGADA) FROM PHE_SHORARIO;




