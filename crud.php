<?php

ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conecta a la base de datos  con usuario, contraseña y name de la BD
$servidor = "localhost"; $usuario = "sebasttti"; $contrasenia = "fjn120716"; $nameBaseDatos = "sebasttti";
$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nameBaseDatos);


// Consulta datos y recepciona una clave para consultar dichos datos con dicha clave
if (isset($_GET["fetch"])){
    $sqlEmpleaados = mysqli_query($conexionBD,"SELECT * FROM employees WHERE id=".$_GET["consultar"]);
    if(mysqli_num_rows($sqlEmpleaados) > 0){
        $empleaados = mysqli_fetch_all($sqlEmpleaados,MYSQLI_ASSOC);
        echo json_encode($empleaados);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//borrar pero se le debe de enviar una clave ( para borrado )
if (isset($_GET["delete"])){
    $sqlEmpleaados = mysqli_query($conexionBD,"DELETE FROM employees WHERE id=".$_GET["delete"]);
    if($sqlEmpleaados){
        echo json_encode(["success"=>1]);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//Inserta un nuevo registro y recepciona en método post los datos de name y email
if(isset($_GET["insert"])){
    $data = json_decode(file_get_contents("php://input"));
    $name=$data->name;
    $email=$data->email;
        if(($email!="")&&($name!="")){
            
    $sqlEmpleaados = mysqli_query($conexionBD,"INSERT INTO employees(name,email) VALUES('$name','$email') ");
    echo json_encode(["success"=>1]);
        }
    exit();
}
// Actualiza datos pero recepciona datos de name, email y una clave para realizar la actualización
if(isset($_GET["update"])){
    
    $data = json_decode(file_get_contents("php://input"));

    $id=$data->id;
    $name=$data->name;
    $email=$data->email;
    
    $sqlEmpleaados = mysqli_query($conexionBD,"UPDATE employees SET name='$name',email='$email' WHERE id='$id'");
    echo json_encode(["success"=>1]);
    exit();
}

/**
 * En caso de que no exista ningún parametro get
 */


// Consulta todos los registros de la tabla employees
$sqlEmpleaados = mysqli_query($conexionBD,"SELECT * FROM employees ");
if(mysqli_num_rows($sqlEmpleaados) > 0){
    $empleaados = mysqli_fetch_all($sqlEmpleaados,MYSQLI_ASSOC);
    echo json_encode($empleaados);
}
else{ echo json_encode([["success"=>0]]); }


?>