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
    echo "<br>" . $mensajeError;
    $resultado = play_prs($jugador1, $jugador2, $rules);
    echo nl2br("\nTu has jugado: " . $jugador1 . "\n");// ."<br>";
    echo nl2br("La máquina ha jugado: " . $jugador2 . "\n");//."<br>";
    echo ($resultado === 0 ? 'Empate' : 'Gana el jugador '.$resultado);
}
?>