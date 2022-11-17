<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0"/>
    <link rel="stylesheet" type="text/css" href="informe.css"/>
    <title>Informe tarea 04 C</title>
</head>
<body>

<?php

$aMensajeErrorIMC = [];
$aMensajeErrorMetabolismo= [];
//Patron peso que va desde 1kg hasta los 634.99 ya que el peso máximo he asumido el record de los 635Kg.
$patron_peso="/^([1-9]|[1-9][0-9]|[1-5][0-9][0-9]|6[0-3][0-4])([.,][0-9]?[0-9])?$/";
//Patron altura que irá desde 50cm (0.50m), altura normal de un recién nacido, hasta los 2.99m acercandome lo máximo al recor de altura en una persona.
$patron_altura = "/^(0)([.,][5-9][0-9])|([1-2])([.,][0-9][0-9]?)?$/";
//Patron sexo que sera u hombre o mujer.
$patron_sexo="/^((hombre)|(mujer))$/";
//patron edad de 0 a 100.
$patron_edad="/^([1-9]?[0-9]|100)$/";

if( !empty($_POST) )
{
    echo "FORMULARIO RECIBIDO:";
    ?> <p> <?php echo "===================="; ?> </p> <?php
    // Mostrar la información recibida del formulario:
    print_r( $_POST );
    ?> <hr/> <?php
    // Comprobar si llegaron los campos requeridos para el ICM:
    if( isset($_POST['peso']) && isset($_POST['altura'])){
        // Nombre:
        if( empty($_POST['peso']) )
            $aMensajeErrorIMC[] = "Debe especificar un peso";
    
        else{
            // Comprobar mediante una expresión regular, que esta en el rango del peso
            if( preg_match($patron_peso, $_POST['peso']) )
                $peso = $_POST['peso'];
            else
                $aMensajeErrorIMC[] = "El peso debe de estar entre 1kg y 634.99kg.";
        }
    

        if (empty($_POST['altura']))
            $aMensajeErrorIMC[] = "Debe especificar una altura";
        else{
            // Comprobar mediante una expresión regular, que la altura esta dentro del rango.
            if (preg_match($patron_altura, $_POST['altura']))
                $altura = $_POST['altura'];
            else
                $aMensajeErrorIMC[] = "La altura introducida no esta dentro del rango de 0.50m hasta 2.99m.";
        }
    }else{
        ?> <p> <?php echo "No se han especificado campos necesarios para el cálculo del IMC."; ?></p> <?php
        }
    
    if(count ($aMensajeErrorIMC) > 0){
            ?> <p> <?php echo "ERRORES ENCONTRADOS:"; ?> </p> <?php
            // Mostrar los errores:
            for( $contador=0; $contador < count($aMensajeErrorIMC); $contador++ )
                echo $aMensajeErrorIMC[$contador]."<br>";
    }
    else
    {
        //echo $peso;
        //echo $altura;
        echo nl2br ("Vamos a calcular su IMC\n");
        echo nl2br ("Los datos introducidos son:\nSu altura es: ". number_format((float)$altura, 2, '.', '') ."\nSu peso es: " . $peso . "\n");
        echo nl2br ("====================================\n");

        $IMC = number_format((float)$peso/($altura * $altura), 2, '.', '');

        if($IMC < 18.5){
            echo nl2br ("Su peso es bajo siendo su IMC de: " . $IMC);
        }elseif ($IMC < 25.00){
            echo nl2br ("Su peso es normal siendo su IMC de: " . $IMC);
        }elseif ($IMC < 30.00){
            echo nl2br ("Su peso es de sobrepeso siendo su IMC de: ". $IMC);
        }elseif ($IMC < 40.00){
            echo nl2br ("Su peso es de obesidad siendo su IMC de: " . $IMC);
        }else{
            echo nl2br ("Su peso es de obesidad mórbida siendo su IMC de: " . $IMC);
        }
    }

    ?> <hr/> <?php

    //Ahora vamos a calcular el metabolismo basal según la fórmula de Mifflin - St Jeor
    //como ya hemos validado la altura y el peso en el paso anterior ahora solo debemos validar el sexo y la edad.
    if( isset($_POST['sexo']) && isset($_POST['edad'])){
        // Nombre:
        if( empty($_POST['sexo']) )
            $aMensajeErrorMetabolismo[] = "Debe especificar un sexo";
    
        else{
            // Comprobar mediante una expresión regular, que esta en el rango del peso
            if( preg_match($patron_sexo, $_POST['sexo']) )
                $sexo = $_POST['sexo'];
            else
                $aMensajeErrorMetabolismo[] = "El sexo no es el correcto.";
        }
    

        if (empty($_POST['edad']))
            $aMensajeErrorMetabolismo[] = "Debe especificar una edad";
        else{
            // Comprobar mediante una expresión regular, que la altura esta dentro del rango.
            if (preg_match($patron_edad, $_POST['edad']))
                $edad = $_POST['edad'];
            
            else
                $aMensajeErrorMetabolismo[] = "La edad introducida no esta dentro del rango de 0 hasta 100.";
        }
    }else{
        ?> <p> <?php echo "No se han especificado campos necesarios para el cálculo del metabolismo."; ?></p> <?php
        }
    
    if(count ($aMensajeErrorMetabolismo) > 0){
            ?> <p> <?php echo "ERRORES ENCONTRADOS:"; ?> </p> <?php
            // Mostrar los errores:
            for( $contador=0; $contador < count($aMensajeErrorMetabolismo); $contador++ )
                echo $aMensajeErrorMetabolismo[$contador]."<br>";
    }
    else{
        echo nl2br ("Vamos a calcular su Metabolismo\n");
        echo nl2br ("Los datos introducidos son:\nSu edad es: ". $edad ."\nSu sexo es: " . $sexo . "\n");
        echo nl2br ("============================\n");

        $metabolismo = (10*$peso) +(6.25*($altura*100))-(5*$edad);

        if ($sexo === "mujer"){
            echo nl2br("Su metabolismo basal es :" . ($metabolismo - 161));
        }else{
            echo nl2br("Su metabolismo basal es :" . ($metabolismo + 5));
        }


    }
    
    
    
}else{
    ?><p><?php 
    echo "No se ha introducido nada en el formulario." 
    ?></p><?php 
}
?>
</body>
</html>

