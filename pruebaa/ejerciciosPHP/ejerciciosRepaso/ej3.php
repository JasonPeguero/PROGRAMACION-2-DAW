<?php
$frase = "hola mundo php";

function invertirpalabra($frase){
    $fraseInvertida = "";
    for($i=0; $i < strlen($frase); $i++) {
        $fraseInvertida .= $frase[strlen($frase) -1 -$i];
    }
return $fraseInvertida;

}

echo "palabra " . $frase . "<br>";
echo "invertida " . invertirpalabra($frase);
?>