<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0"/>
    <link rel="stylesheet" type="text/css" href="cv.css"/>
    <title>Tarea 03 B</title>
</head>

<body>


<?php

// Patrón para usar en expresiones regulares (admite letras acentuadas y espacios):
$patron_texto= "/^[A-ZÑa-zñáéíóúÁÉÍÓÚ'° .]+$/";
//Patron para el nombre de la empresa que admite letras, acentuadas, espacios y números.
$patron_empresa = "/^[A-ZÑa-zñáéíóúÁÉÍÓÚ'° 0-9]+$/";
//Patron número de la calle que incluye un número de longitud de 1 a 4 y la expresión s/n para indicar que no posee número
$patron_numero_calle = "/^[0-9]{1,4}|(s\/n)$/";
//Patron para comprabar el correo electrónico
$patron_correo = "/[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+/";
//Patron que solo admite números y con las estructuras +000666666666 666666666 (034)666666666 000-666666666
$patron_telefono = "/^([\+]?[(]?[0-9]{3}[)]?)?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{6}$/";
//Patron para la comprobación de las páginas webs adminte las formas https:\\www.ip.com http:\\www.ip.com
$patron_web = "/((https?)\:\/\/)?([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?([a-z0-9-.]*)\.([a-z]{2,3})(\:[0-9]{2,5})?(\/([a-z0-9+\$_-]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?/";
//Patron para averiguar una fecha entre 1950 (por debajo de esta fecha la persona es posible que este jubilada) y 2022 que es el año actual
//para modificar la fecha máxima mas adelante solo se deberá de moficiar este patron.
$patron_ano = "/^([5-9][0-9]|19[5-9][0-9]|20[0-1][0-9]|202[0-2])$/";
//Array (patrón) para comprobar que la provincia es la correcta.
$aProvincias = array("Álava","Albacete","Alicante","Almería","Asturias","Ávila","Badajoz","Barcelona","Burgos","Cáceres","Cádiz","Cantabria","Castellón","Ciudad Real","Córdoba","La Coruña","Cuenca","Gerona","Granada","Guadalajara","Guipúzcoa","Huelva","Huesca","Baleares","Jaén","León","Lérida","Lugo","Madrid","Málaga","Murcia","Navarra","Orense","Palencia","Las Palmas","Pontevedra","La Rioja","Salamanca","Segovia","Sevilla","Soria","Tarragona","Santa Cruz de Tenerife","Teruel","Toledo","Valencia","Valladolid","Vizcaya","Zamora","Zaragoza","Extranjero");

$arrayExperiencia = (($_POST)['experiencia']);
$arrayestudio = (($_POST)['estudios']);
$arrayentradaestudio = ['escuela', 'titulo', 'anoinicio', 'anofinal'];
$arrayentradaexperiencia = ['empresa', 'trabajo', 'anoinicio', 'anofinal', 'descripcion'];
$contador2 = 0;
$aErrores = array();
$aMensajes = array();

if( !empty($_POST) ){
    //comprobar el apartado datos personlas
    if( isset($_POST['nombre']) && isset($_POST['correo']) && isset($_POST['telefono'])){
        // Nombre:
        if( empty($_POST['nombre']) )
            $aErrores[] = "Debe especificar el nombre";
    
        else{
            // Comprobar mediante una expresión regular, que sólo contiene letras y espacios:
            if( preg_match($patron_texto, $_POST['nombre']))
                $nombre = $_POST['nombre'];
            else
                $aErrores[] = "El nombre sólo puede contener letras y espacios.";
        }

        if (empty($_POST['correo']))
            $aErrores[] = "Debe especificar un correo electrónico";
        else{
            // Comprobar mediante una expresión regular, que posee estructura de correo válida.
            if (preg_match($patron_correo, $_POST['correo']))
                $correo = $_POST['correo'];
            else
                $aErrores[] = "El correo electrónico introducido no es válido.";
        }

        if (empty($_POST['telefono']))
            $aErrores[] = "Debe especificar un telefono";
        else{
            // Comprobar mediante una expresión regular, que posee estructura de correo válida.
            if (preg_match($patron_telefono, $_POST['telefono']))
                $telefono = $_POST['telefono'];
            else
                $aErrores[] = "El telefono introducido no es válido.";
        }
    }

    if (!empty($_POST['web'])){
        if(preg_match($patron_web, $_POST['web']))
            $web = $_POST['web'];
        else
            $aErrores[] = "El formato de la página no es el correcto.";
    }

    if( isset($_POST['direccion']) && isset($_POST['numero']) && isset($_POST['localidad']) && isset($_POST['provincia'])){
        if( empty($_POST['direccion']) )
            $aErrores[] = "Debe especificar una calle";
    
        else{
            // Comprobar mediante una expresión regular, que sólo contiene letras y espacios:
            if( preg_match($patron_texto, $_POST['direccion']))
                $direccion = $_POST['direccion'];
            else
                $aErrores[] = "La direccion sólo puede contener letras y espacios.";
        }

        if( empty($_POST['numero']) )
            $aErrores[] = "Debe especificar un numero";
    
        else{
            // Comprobar mediante una expresión regular, que sólo contiene letras y espacios:
            if( preg_match($patron_numero_calle, $_POST['numero']))
                $numero = $_POST['numero'];
            else
                $aErrores[] = "La direccion sólo puede contener letras, espacios y la forma s/n para indicar que no posee número.";
        }

        if( empty($_POST['localidad']) )
            $aErrores[] = "Debe especificar una localidad válida";
    
        else{
            // Comprobar mediante una expresión regular, que sólo contiene letras y espacios:
            if( preg_match($patron_texto, $_POST['localidad']))
                $localidad = $_POST['localidad'];
            else
                $aErrores[] = "La localidad no es válida.";
        }

        if( empty($_POST['provincia']) )
            $aErrores[] = "Debe especificar una provincia válida";
    
        else{
            // Comprobar mediante un array, que sea una provincia válida:
            $matches = in_array($_POST['provincia'], $aProvincias);
            if($matches)
                $provincia = $_POST['provincia'];
            else
                $aErrores[] = "La provincia no es válida.";
        }

    }

    //Validando datos de la descripción personal
    if (isset($_POST['descripcion_personal'])){
        if(empty($_POST['descripcion_personal']))
            $aErrores[] = "Debe escribir una pequeña descripción";
        else{
            if(preg_match($patron_texto, $_POST['descripcion_personal']))
                $descripcionPersonal = $_POST['descripcion_personal'];
            else
                $aErrores[] = "La descripción solo puede tener letras y espacios.";
        }
    }


    //Validar datos del apartado Estudios.
    for($contador=0; $contador < count($arrayestudio); $contador++){
        $contador2 = 0;
        if(isset($arrayestudio[$contador][$arrayentradaestudio[$contador2]])){
            if (empty($arrayestudio[$contador][$arrayentradaestudio[$contador2]]))
                $aErrores[] = "Debe introducir Intituto/Universidad.";
            else{
                //Comprobamos que introduzca nombre son solo texto y espacios.
                if(preg_match($patron_texto, $arrayestudio[$contador][$arrayentradaestudio[$contador2]]))
                    $instiUni[$contador] = $arrayestudio[$contador][$arrayentradaestudio[$contador2]];
                else
                    $aErrores[] = "El nombre del Intituto/Universidad solo puede contener letras y espacio.";
            }
        }

        if(isset($arrayestudio[$contador][$arrayentradaestudio[$contador2+1]])){
            if (empty($arrayestudio[$contador][$arrayentradaestudio[$contador2+1]]))
                $aErrores[] = "Debe introducir Titulación.";
            else{
                //Comprobamos que introduzca nombre son solo texto y espacios.
                if(preg_match($patron_texto, $arrayestudio[$contador][$arrayentradaestudio[$contador2+1]]))
                    $titulacion[$contador] = $arrayestudio[$contador][$arrayentradaestudio[$contador2+1]];
                else
                    $aErrores[] = "El nombre del titulo solo puede contener letras y espacio.";
            }
        }
        if(isset($arrayestudio[$contador][$arrayentradaestudio[$contador2+2]])){
            if (empty($arrayestudio[$contador][$arrayentradaestudio[$contador2+2]]))
                $aErrores[] = "Debe introducir año inicio de la titulación.";
            else{
                //Comprobamos que introduzca fechas entre 1950 y 2022.
                if(preg_match($patron_ano, $arrayestudio[$contador][$arrayentradaestudio[$contador2+2]]))
                    $anoInicioTitulacion[$contador] = $arrayestudio[$contador][$arrayentradaestudio[$contador2+2]];
                else
                    $aErrores[] = "Debe introducir fecha inicio estudio entre 1950 y " . date("Y");
            }
        }

        if(isset($arrayestudio[$contador][$arrayentradaestudio[$contador2+3]])){
            if (empty($arrayestudio[$contador][$arrayentradaestudio[$contador2+3]]))
                $aErrores[] = "Debe introducir año final de la titulación.";
            else{
                //Comprobamos que introduzca fechas entre 1950 y 2022.
                if(preg_match($patron_ano, $arrayestudio[$contador][$arrayentradaestudio[$contador2+3]]) && $arrayestudio[$contador][$arrayentradaestudio[$contador2+3]] >= $arrayestudio[$contador][$arrayentradaestudio[$contador2+2]])
                    $anoFinalTitulacion[$contador] = $arrayestudio[$contador][$arrayentradaestudio[$contador2+3]];
                else
                    $aErrores[] = "Debe introducir fecha fin del estudio entre 1950 y " . date("Y") . " o superior o igual al año de inicio.";
            }
        }



    }

    //Validar datos del apartado Experiencia.
    for($contador=0; $contador < count($arrayExperiencia); $contador++){
        $contador2 = 0;
        if(isset($arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2]])){
            if (empty($arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2]]))
                $aErrores[] = "Debe introducir nombre Empresa.";
            else{
                //Comprobamos que introduzca nombre son solo texto y espacios.
                if(preg_match($patron_empresa, $arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2]]))
                    $empresa[$contador] = $arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2]];
                else
                    $aErrores[] = "El nombre de la Empresa solo puede contener letras, espacio y números.";
            }
        }

        if(isset($arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2+1]])){
            if (empty($arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2+1]]))
                $aErrores[] = "Debe introducir Puesto de Trabajo.";
            else{
                //Comprobamos que introduzca nombre son solo texto y espacios.
                if(preg_match($patron_texto, $arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2+1]]))
                    $trabajo[$contador] = $arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2+1]];
                else
                    $aErrores[] = "El nombre del Puesto de Trabajo solo puede contener letras y espacio.";
            }
        }
        if(isset($arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2+2]])){
            if (empty($arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2+2]]))
                $aErrores[] = "Debe introducir año inicio de la titulación.";
            else{
                //Comprobamos que introduzca fechas entre 1950 y 2022.
                if(preg_match($patron_ano, $arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2+2]]))
                    $anoInicioTrabajo[$contador] = $arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2+2]];
                else
                    $aErrores[] = "Debe introducir fecha inicio experiencia entre 1950 y " . date("Y");
            }
        }

        if(isset($arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2+3]])){
            if (empty($arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2+3]]))
                $aErrores[] = "Debe introducir año final de la titulación.";
            else{
                //Comprobamos que introduzca fechas entre 1950 y 2022.
                if(preg_match($patron_ano, $arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2+3]]) && $arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2+3]] >= $arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2+2]])
                    $anoFinalTrabajo[$contador] = $arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2+3]];
                else
                    $aErrores[] = "Debe introducir final experiencia entre 1950 y " . date("Y") . " o igual o superior al año de inicio del empleo.";
            }
        }

        if(isset($arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2+4]])){
            if (empty($arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2+4]]))
                $aErrores[] = "Debe introducir descripción del puesto de trabajo.";
            else{
                //Comprobamos que introduzca texto solamente.
                if(preg_match($patron_texto, $arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2+4]]))
                    $descripcion[$contador] = $arrayExperiencia[$contador][$arrayentradaexperiencia[$contador2+4]];
                else
                    $aErrores[] = "Debe introducir solamente texto y espacios en la descripción del puesto de trabajo.";
            }
        }



    }




        
    if(count($aErrores) > 0 ){?>
        <p> 
            <?php echo "ERRORES ENCONTRADOS:"; ?> 
        </p> <?php
        // Mostrar los errores:
        for( $contador=0; $contador < count($aErrores); $contador++ ){
            echo $aErrores[$contador]."<br>";
        }
    }
    else{ ?>
        <div id="page-wrap">
        
        <img src="img/cthulu.png" alt="Photo of Cthulu" id="pic" />

        <div id="contact-info" class="vcard">
        
            <!-- Microformats! -->
        
            <h1 class="fn"><?php echo ($nombre); ?></h1>
        
                <p>
                    <strong>Móvil:</strong> <span class="tel"><?php echo $telefono; ?> </span><br />
                    <strong>Correo_Electrónico:</strong> <a class="email"href="mailto: <?php echo $correo; ?> "><?php echo $correo;?></a><br/>
                    <strong>Página Web Personal:</strong> <span class="web"><?php echo $web;?>  </span><br/>
                    <strong> Dirección: </strong>
                    <span class="direccion">
                        <?PHP echo $direccion ?>, <?php echo $numero ?><br/>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php echo $localidad ?>,  <?php echo $provincia ?>
                    </span>
                </p>
        </div> 

        <div id="descripcion_personal">
            <p>
            <?php echo ($descripcionPersonal); ?>
            </p>
        </div>

        <div class="clear"></div>
        <dl><?php
            for($contador=0; $contador < count($arrayestudio); $contador++){?>
            
            <dt>Estudios 0<?php echo $contador+1; ?></dt>
                <dd>
                    <h2><?php echo "Escuela/Universidad" ?> </h2>
                    <p>
                        <?php echo ($instiUni[$contador]) ?>
                    </p>
                        
                    <h2><?php echo "Título" ?></h2>
                    <p>
                        <?php echo ($titulacion[$contador]) ?>
                    </p>

                    <h2><?php echo "Año de Inicio" ?></h2>
                    <p>
                        <?php echo ($anoInicioTitulacion[$contador]) ?>
                    </p>

                    <h2><?php echo "Año final" ?></h2>
                    <p>
                        <?php echo ($anoFinalTitulacion[$contador]) ?>
                    </p>

                    <br/>
                </dd>
            <div class="clear"></div><?php
            }?>

        </dl>
        <div class="clear"></div>
        <dl><?php
            for($contador=0; $contador < count($arrayExperiencia); $contador++){?>
            
            <dt>Experiencia 0<?php echo $contador+1; ?></dt>
                <dd>
                    <h2><?php echo "Empresa" ?> </h2>
                    <p>
                        <?php echo ($empresa[$contador]) ?>
                    </p>
                        
                    <h2><?php echo "Puesto de Trabajo" ?></h2>
                    <p>
                        <?php echo ($trabajo[$contador]) ?>
                    </p>

                    <h2><?php echo "Año de Inicio" ?></h2>
                    <p>
                        <?php echo ($anoInicioTrabajo[$contador]) ?>
                    </p>

                    <h2><?php echo "Año final" ?></h2>
                    <p>
                        <?php echo ($anoFinalTrabajo[$contador]) ?>
                    </p>

                    <h2><?php echo "Descripción puesto de trabajo" ?></h2>
                    <p>
                        <?php echo ($descripcion[$contador]) ?>
                    </p>

                    <br/>
                </dd>
            <div class="clear"></div><?php
            }?>

        </dl>
        <div class="clear"></div>
        
        
        
        <?php

        
    
    }
}


else{?>
   
   <p><?php echo "No se ha introducido nada en el formulario." ?></p>
<?php 
}?>

</body>
</html>