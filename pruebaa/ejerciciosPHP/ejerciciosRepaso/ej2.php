<?php
$palabras = ["radar", "reconocer", "casa"];

for($i=0; $i < count($palabras); $i++ ){
    $palindromo = true;

    $palabra = $palabras[$i];

for($j = 0; $j < (strlen($palabra)/2); $j++){
    if($palindromo === false){
        $j = strlen($palabra)/2;
    }
    else if($palabra[$j] !== $palabra[(strlen($palabra) - 1) - $j]){
        $palindromo = false;
    }
}

if($palindromo === false){
    echo "Palabra : " . $palabras[$i] . " no es palindromo". "\n" . "<br>";
}
else{
     echo "Palabra : " . $palabras[$i] . " es palindromo". "\n" . "<br>";
}
}

?>