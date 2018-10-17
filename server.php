<?php
// tabla test.alumnos
// +-----------+-------------+------+-----+---------+----------------+
// | Field     | Type        | Null | Key | Default | Extra          |
// +-----------+-------------+------+-----+---------+----------------+
// | id        | int(11)     | NO   | PRI | NULL    | auto_increment |
// | apellidos | varchar(45) | YES  |     | NULL    |                |
// | nombre    | varchar(45) | YES  |     | NULL    |                |
// | gitlab    | varchar(45) | YES  | MUL | NULL    |                |
// | fecha     | date        | YES  |     | NULL    |                |
// +-----------+-------------+------+-----+---------+----------------+


$conexion = new mysqli('localhost', 'root', 'a', 'test');
if ( $conexion->connect_error){ die('Error de conexión'); }
$conexion->set_charset('utf8');
header('Access-Control-Allow-Origin: *'); 
header('Content-type: application/json; charset=utf-8'); 

function listar(){
  global $conexion;
  $datos = $conexion->query('select * from alumnos order by nombre');   
  $resp = [];
  while ( $doc = $datos->fetch_assoc() ){ array_push($resp, $doc); }
  echo json_encode($resp);
}

function insertar(){    
    global $conexion;
    $datos = json_decode($_POST['datos']);
    $sql = $conexion->prepare('insert into alumnos (id, nombre, apellidos, gitlab, fecha ) values (0, ?, ?, ?,?) ');
    $sql->bind_param('ssss', $datos->nombre, $datos->apellidos, $datos->gitlab, $datos->fecha);
    echo $sql->execute();
}

function actualizar(){    
    global $conexion;
    $datos = json_decode($_POST['datos']);
    $sql = $conexion->prepare('update alumnos set nombre = ?, apellidos = ?, gitlab = ?, fecha = ? where id = ?');
    $sql->bind_param('ssssi', $datos->nombre, $datos->apellidos, $datos->gitlab, $datos->fecha, $datos->id);
    echo $sql->execute();
}

function borrar(){    
    global $conexion;
    $datos = json_decode($_POST['datos']);
    $sql = $conexion->prepare('delete from alumnos where id = ?');
    $sql->bind_param('i', $datos->id);
    echo $sql->execute();
}


switch ($_POST['accion']) {

 case 'listar':
   listar();
   break;

 case 'insertar':   
   insertar();
   break;   

 case 'actualizar':   
   actualizar();
   break;      

case 'borrar':   
   borrar();
   break;      

}

?>
