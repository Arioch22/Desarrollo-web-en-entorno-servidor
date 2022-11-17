<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0"/>
    <link rel="stylesheet" type="text/css" href="juego.css"/>
    <title>Document</title>
</head>
<body>
<?php
$array = array("papel", "piedra", "tijera", "lagarto", "spock");
$array2 = array("papel", "piedra", "tijera", "lagarto", "spock");
$mensajeError;

if (!empty($_POST['jugador1']))
{
    $jugador1=$_POST['jugador1'];
    
}else{
    $jugador1=$array2[array_rand($array2)];
    $mensajeError = "Al no escoger valor se dará uno aleatorio.";
}



$jugador2=$array[array_rand($array)];
$salidaError;

function play_prs($jugador1, $jugador2, $rules)
{
    if ($jugador1 === $jugador2) {
        return 0;
    }
 
    // Compruebo si el jugador 1 tiene una acción valida y si su acción
    // "mata" a la de su oponente
    if (isset($rules[$jugador1]) && in_array($jugador2, $rules[$jugador1])) {
        return "humano.";
    }
    
 
    return "máquina.";
}
 
$rules = array(
    'papel' => ['piedra', 'spock'],
    'piedra' => ['tijera', 'lagarto'],
    'tijera' => ['papel', 'lagarto'],
    'lagarto' => ['spock', 'papel'],
    'spock' => ['tijera', 'piedra']
);
 

if (!$mensajeError){
    $resultado = play_prs($jugador1, $jugador2, $rules);
    echo nl2br("Tu has jugado: " . $jugador1 . "\n");// ."<br>";
    echo nl2br("La máquina ha jugado: " . $jugador2 . "\n");//."<br>";
    echo ($resultado === 0 ? 'Empate' : 'Gana el jugador '.$resultado);
}else{
    echo $mensajeError;
    $resultado = play_prs($jugador1, $jugador2, $rules);
    echo nl2br("\nTu has jugado: " . $jugador1 . "\n");// ."<br>";
    echo nl2br("La máquina ha jugado: " . $jugador2 . "\n");//."<br>";
    echo ($resultado === 0 ? 'Empate' : 'Gana el jugador '.$resultado);
}
?>
<br/>
<a href="../juego con graficos/">Atras</a> <?php
?>
</body>
</html>