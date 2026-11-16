<?php
$palabra = "programacion";

function invertirpalabra($palabra){
    $palabraInvertida = "";
    for($i=0; $i < strlen($palabra); $i++) {
        $palabraInvertida .= $palabra[strlen($palabra) -1 -$i];
    }
return $palabraInvertida;

}

echo "palabra " . $palabra . "<br>";
echo "invertida " . invertirpalabra($palabra);
?>