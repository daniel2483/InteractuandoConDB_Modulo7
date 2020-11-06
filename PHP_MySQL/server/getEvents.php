<?php

  require('./lib.php');

  session_start();
  #error_reporting(0);

  $con = new ConectorBD('localhost','nextu','12345');
  $events_data['DBCon'] = $con->initConexion('agenda_db');

  $user_info = $con->checkLogin($_SESSION['username']);

  $fila_user = $user_info->fetch_assoc();

  $events_data['UserId'] = $fila_user['id'];

  $user_events = $con->getEvents($fila_user['id']);

  if ($user_events->num_rows != 0) {
    $events_data['EventMessage'] = 'There are events';
    while ($evento = $user_events->fetch_assoc()) {
      $response['Events'][$i]['titulo']=$evento['titulo'];
      $response['Events'][$i]['fecha_inicio']=$evento['fecha_inicio'];
      $response['Events'][$i]['hora_inicio']=$evento['hora_inicio'];
      $response['Events'][$i]['fecha_fin']=$evento['fecha_fin'];
      $response['Events'][$i]['hora_fin']=$evento['hora_fin'];
      $response['Events'][$i]['dia_completo']=$evento['dia_completo'];
      $i++;
    }
    $events_data['msg'] = $events_data['DBCon'];
  }
  else{
    $events_data['EventMessage'] = 'There are no events';
    $events_data['msg'] = $events_data['DBCon'];
  }

  echo json_encode($events_data);

  $con->cerrarConexion();

 ?>
