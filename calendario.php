<?php
/**
 * Created by PhpStorm.
 * User: Dário Nascimento
 * Date: 23/08/2016
 * Time: 08:29
 */

//==================================================================

for ($i = strtotime({CCDataInicial}); $i <= strtotime({CCDataTermino}); $i=$i+86400) {

    $datai =  date("d-m-Y",$i);
    $datai2 =  date("Y-m-d",$i);


    $diasemana = array(0,1,2,3,4,5,6);

    $diasemana_numero = date('w', strtotime($datai2));
    $ds = $diasemana[$diasemana_numero];

    switch($ds){
        case"0": $diasemana = "Dom";   break;
        case"1": $diasemana = "Seg";   break;
        case"2": $diasemana = "Ter";   break;
        case"3": $diasemana = "Qua";   break;
        case"4": $diasemana = "Qui";   break;
        case"5": $diasemana = "Sex";   break;
        case"6": $diasemana = "Sab";   break;
    }


    sc_lookup(meus_dados, "

SELECT
   data
FROM
    horario_docente
WHERE 
   data = '$datai2' and turno = '{CCTurno}' and iddocente = '{CCDocente}'



");
    if ({meus_dados} === false)
{
    echo "Erro de acesso. Mensagem = " . {meus_dados_erro};
}
elseif (empty({meus_dados}))
{

// echo $datai2;

        if($diasemana == "Dom"){

            $status = "i";

            sc_exec_sql(INSERT INTO horario_docente
            (

                data,
                iddocente,
                turno,
                diadasemana,
                descricao,
                status
            )
			 VALUES
             ('$datai2','{CCDocente}','{CCTurno}','$diasemana',"Domingo","i"));

} elseif ($diasemana == "Sab"){

            $status = "a";

            sc_exec_sql(INSERT INTO horario_docente
            (

                data,
                iddocente,
                turno,
                diadasemana,
                descricao,
                status
            )
			 VALUES
             ('$datai2','{CCDocente}','{CCTurno}','$diasemana',"Sábado","a"));

}else{


            $status = "a";

            sc_exec_sql(INSERT INTO horario_docente
            (

                data,
                iddocente,
                turno,
                diadasemana,
                descricao,
                status



            )
			 VALUES
             ('$datai2','{CCDocente}','{CCTurno}','$diasemana',"Livre","a"));

echo '<img src="http://www.eadmob.com.br/ssa/verde.jpg" width="20" height="20" />';

}

    }
else
{


    echo '<img src="http://www.eadmob.com.br/ssa/vermelho.jpg" width="20" height="20" />'.date('d/m/Y', strtotime($datai2))." - Data cadastrada"."<br>";

}





}
