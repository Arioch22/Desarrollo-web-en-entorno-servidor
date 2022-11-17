<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0"/>
    <link rel="stylesheet" type="text/css" href="areaylongitud.css"/>
    <title>Formulario</title>
</head>

<body>
<?php
 $aErrores = array();
 $aMensajes = array();
 $patron_numero="/^[0-9]+$/";

 if( !empty($_POST) ){
    echo "Medida del lado del cuadrado recibido."
    ?> <p> <?php echo "===================="; ?> </p> <?php

    // Mostrar la información recibida del formulario: 
        print_r( $_POST );
        ?> <p> <?php echo "===================="; ?> </p> <?php

        if( preg_match($patron_numero, $_POST['lado']) ){
                    $aMensajes[] = "El área del cuadrado es: [".$_POST['lado']*$_POST['lado']."]";
                    $aMensajes[] = "El perímetro del cuadrado es: [".$_POST['lado']+$_POST['lado']+$_POST['lado']+$_POST['lado']."]";
        }
        else{
            $aErrores[] = "El dato introducido no es el correcto.";}

        // Si han habido errores se muestran, sino se mostrán los mensajes
        if( count($aErrores) > 0 )
        {
            ?> <p> <?php echo "ERRORES ENCONTRADOS:"; ?> </p> <?php
            // Mostrar los errores:
            for( $contador=0; $contador < count($aErrores); $contador++ )
                echo $aErrores[$contador]."<br>";
        }
        else
        {
            // Mostrar los mensajes:
            ?> <div id="salida"> <?php
            //for( $contador=0; $contador < count($aMensajes); $contador++ ){
            /* ?> <p> <?php echo $aMensajes[$contador]; ?> </p> <?php*/
                
            foreach($aMensajes as $contado){
                    echo $contado . "<br>";}
            ?> </div> <?php

        }
 }



?>