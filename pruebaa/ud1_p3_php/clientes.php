<?php
$array_clientes = json_decode(file_get_contents('clientes.json'), true);
$txAccion = ($_POST['txAccion']?? '');

switch ($txAccion) {
    case 'crearNuevo':
        echo "Creando nuevo cliente...<br>";
        $txNombre = ($_POST['txNombre']?? '');
        $txEmpresa = ($_POST['txEmpresa']?? '');
        $txEmail = ($_POST['txEmail']?? '');
        $txTelefono = ($_POST['txTelefono']?? '');

        agregarCliente($array_clientes, $txNombre, $txEmpresa, $txEmail, $txTelefono);
        header("Location: index.php?mensaje=Cliente agregado correctamente");
        break;

    case 'eliminar':
        $idCliente = $_POST['idCliente'];
     // Debugging line to check the value of $idCliente

        $array_clientes = eliminarCliente($array_clientes, $idCliente);
        header("Location: index.php?mensaje=Cliente eliminado correctamente");
        break;

    case 'accionBuscar':
        $txBuscar = $_GET['txBuscar'];
        // Debugging line to check the value of $idCliente

        $array_clientes = consultarClientes($array_clientes, $txBuscar);
        header("Location: index.php?mensaje=Clientes encontrados correctamente");
        break;

    default:
        echo "";
}



function agregarCliente($array_clientes, $nombre, $empresa, $email, $telefono) {


    $nuevoCliente = [
        'id' => $array_clientes != NULL ? count($array_clientes) + 1:1,
        'nombre' => $nombre,
        'empresa' => $empresa,
        'email' => $email,
        'telefono' => $telefono
    ];


    $array_clientes[] = $nuevoCliente;



    file_put_contents('clientes.json', json_encode($array_clientes));

    echo '<script>alert("Cliente agregado correctamente");</script>';

}

function eliminarCliente($array_clientes, $id) {

    foreach ($array_clientes as $key => $cliente) {
        if ($cliente['id'].'' == $id.'') {
            unset($array_clientes[$key]);
            break;
        }
    }
    file_put_contents('clientes.json', json_encode($array_clientes));
    echo '<script>alert("Cliente eliminado correctamente");</script>';
}

function consultarClientes($array_clientes, $txBuscar) {

    $clientesEncontrados = [];
    foreach ($array_clientes as $cliente) {
            if (stripos($cliente['nombre'], $txBuscar) !== false 
            || stripos($cliente['empresa'], $txBuscar) !== false 
            || stripos($cliente['email'], $txBuscar) !== false 
            || stripos($cliente['telefono'], $txBuscar) !== false) {
            $clientesEncontrados[] = $cliente;
        }
    }
    return $clientesEncontrados;
}

function modificarClientes($array_clientes, $idCliente, $txNombre, $txEmpresa, $txEmail, $txTelefono) {
    $c =null;
    $clientesEncontrados = [];
    foreach ($array_clientes as $key => $c) {
            if ($c['id'] == $id){
                $clientesModificado= [
            'id' => $idCliente,
            'nombre' => $nombre, 
            'empresa' => $empresa, 
            'email' => $email,
            'telefono' => $telefono,
            ];
            $array_clientes[$key] = $clientesModificado;
            break;
        }
    }
    file_put_contents('clientes.json', json_encode($array_clientes));
}

