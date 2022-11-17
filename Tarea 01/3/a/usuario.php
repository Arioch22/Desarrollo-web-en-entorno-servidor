<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0"/>
    <link rel="stylesheet" type="text/css" href="usuario.css"/>
    <title>Tarea 03 A</title>
</head>
<body>
<?php
// Arrays para guardar mensajes y errores:
     $aErrores = array();
     $aMensajes = array();

    //Lista de patrones para validar los datos.

    // Patrón para usar en expresiones regulares (admite letras acentuadas y espacios):
    $patron_texto= "/^[A-ZÑa-zñáéíóúÁÉÍÓÚ'° ]+$/";
    //Patron para comprabar el correo electrónico
    $patron_correo = "/[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+/";
    //Patron que solo admite números y con las estructuras +000666666666 666666666 (034)666666666 000-666666666
    $patron_telefono = "/^([\+]?[(]?[0-9]{3}[)]?)?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{6}$/";
    //Patron para la comprobación de las páginas webs adminte las formas https:\\www.ip.com http:\\www.ip.com
    $patron_web = "/((https?)\:\/\/)?([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?([a-z0-9-.]*)\.([a-z]{2,3})(\:[0-9]{2,5})?(\/([a-z0-9+\$_-]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?/";
    
     // Comprobar si se ha enviado el formulario:
    if( !empty($_POST) )
    {
        echo "FORMULARIO RECIBIDO:";
        ?> <p> <?php echo "===================="; ?> </p> <?php
        // Mostrar la información recibida del formulario:
        print_r( $_POST );
        ?> <hr/> <?php
        // Comprobar si llegaron los campos requeridos:
         if( isset($_POST['nombre']) && isset($_POST['correo']))
        {
            // Nombre:
             if( empty($_POST['nombre']) )
                $aErrores[] = "Debe especificar el nombre";
            else
            {
                // Comprobar mediante una expresión regular, que sólo contiene letras y espacios:
                 if( preg_match($patron_texto, $_POST['nombre']) )
                    $aMensajes[] = "Nombre y Apellidos: [".$_POST['nombre']."]";
                else
                    $aErrores[] = "El nombre sólo puede contener letras y espacios.";
            }

            if (empty($_POST['correo']))
                $aErrores[] = "Debe especificar un correo electrónico";
            else{
                // Comprobar mediante una expresión regular, que posee estructura de correo válida.
                if (preg_match($patron_correo, $_POST['correo']))
                    $aMensajes[] = "El correo introducido es: [".$_POST['correo']."]";
                else
                    $aErrores[] = "El correo electrónico introducido no es válido.";
            }
        }

        else{
        ?> <p> <?php echo "No se han especificado campos nombre y correo obligatorios."; ?></p> <?php
        }

        if (!empty($_POST['telefono']))
        {
            if(preg_match($patron_telefono, $_POST['telefono']))
                $aMensajes[] = "El teléfono introducido es: [".$_POST['telefono']."]";
            else
                $aErrores[] = "El formato del teléfono no es el correcto.";
        }

        if (!empty($_POST['web']))
        {
            if(preg_match($patron_web, $_POST['web']))
                $aMensajes[] = "El teléfono introducido es: [".$_POST['web']."]";
            else
                $aErrores[] = "El formato de la página no es el correcto.";
        }

        if( isset($_POST['texto']))
        {
            
             if( empty($_POST['texto']) )
                $aErrores[] = "Debe especificar consulta";

            else{ 
                    $aMensajes[] = "La consulta expuesta es: [".$_POST['texto']."]";
            }
        }

        else{
            ?> <p> <?php echo "No se ha especificado campo texto obligatorio."; ?></p> <?php
        }

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
            for( $contador=0; $contador < count($aMensajes); $contador++ ){

                
               ?> <p> <?php echo $aMensajes[$contador]; ?> </p> <?php
                

            //foreach($aMensajes as $contado){
            //        echo $contado . "<br>";}
            }?> </div> <?php

        }
    }

    else{
         ?>
        
        <p><?php echo "No se ha introducido nada en el formulario." ?></p>
    <?php 
    }
?>

</body>
</html>
