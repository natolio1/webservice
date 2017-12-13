<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Obtener todos los esudiantes

$app->get('/api/estudiantes', function(Request $request, Response $response){
  //echo "Estudiantes";
  $sql = "select * from estudiante";

  try{
    //Get DB Object
    $db = new db();
    //connect
    $db = $db->connect();

    $stmt = $db->query($sql);
    $estudiantes = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    //echo json_encode($estudiantes);
    print_r($estudiantes);
  } catch(PDOException $e){
    echo '{"error": {"text":'.$e->getMessage().'}';
  }
});
// Obtener un estudiante por no de control
$app->get('/api/estudiantes/{No_control}', function(Request $request, Response $response){
    $No_control = $request->getAttribute('No_control');

    $sql = "SELECT * FROM estudiante WHERE No_control = '$No_control'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $estudiantes = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($estudiantes);
          //print_r($estudiantes);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar un estudiante
$app->post('/api/estudiantes/add', function(Request $request, Response $response){
    $No_control = $request->getParam('No_control');
    $nombre_estudiante = $request->getParam('nombre_estudiante');
    $apellido_p_estudiante = $request->getParam('apellido_p_estudiante');
    $apellido_m_estudiante = $request->getParam('apellido_m_estudiante');
    $semestre = $request->getParam('semestre');
    $carrera_clave = $request->getParam('carrera_clave');

    $sql = "INSERT INTO estudiante (No_control, nombre_estudiante, apellido_p_estudiante, apellido_m_estudiante, semestre, carrera_clave) VALUES (:No_control, :nombre_estudiante, :apellido_p_estudiante, :apellido_m_estudiante, :semestre, :carrera_clave)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':No_control',      $No_control);
        $stmt->bindParam(':nombre_estudiante',         $nombre_estudiante);
        $stmt->bindParam(':apellido_p_estudiante',      $apellido_p_estudiante);
        $stmt->bindParam(':apellido_m_estudiante',      $apellido_m_estudiante);
        $stmt->bindParam(':semestre',       $semestre);
        $stmt->bindParam(':carrera_clave',  $carrera_clave);

        $stmt->execute();

        echo '{"notice": {"text": "Estudiante agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Actualizar estudiante
$app->put('/api/estudiantes/update/{No_control}', function(Request $request, Response $response){
    $No_control = $request->getParam('No_control');
    $nombre_estudiante = $request->getParam('nombre_estudiante');
    $apellido_p_estudiante = $request->getParam('apellido_p_estudiante');
    $apellido_m_estudiante = $request->getParam('apellido_m_estudiante');
    $semestre = $request->getParam('semestre');
    $carrera_clave = $request->getParam('carrera_clave');

    $sql = "UPDATE estudiante SET
                No_control               = :No_control,
                nombre_estudiante       = :nombre_estudiante,
                apellido_p_estudiante   = :apellido_p_estudiante,
                apellido_m_estudiante   = :apellido_m_estudiante,
                semestre                = :semestre,
                carrera_clave           = :carrera_clave
            WHERE No_control = '$No_control'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':No_control',      $No_control);
        $stmt->bindParam(':nombre_estudiante',         $nombre_estudiante);
        $stmt->bindParam(':apellido_p_estudiante',      $apellido_p_estudiante);
        $stmt->bindParam(':apellido_m_estudiante',      $apellido_m_estudiante);
        $stmt->bindParam(':semestre',       $semestre);
        $stmt->bindParam(':carrera_clave',  $carrera_clave);

        $stmt->execute();

        echo '{"notice": {"text": "Estudiante actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar estudiante
$app->delete('/api/estudiantes/delete/{No_control}', function(Request $request, Response $response){
    $No_control = $request->getAttribute('No_control');

    $sql = "DELETE FROM estudiante WHERE No_control = $No_control";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Estudiante eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener todos las carreras

$app->get('/api/carrera', function(Request $request, Response $response){
	//echo "Carreras";
	$sql = "select * from carrera";

	try{
		// Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $carrera = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
      // echo json_encode($carrera);
       print_r($carrera);
	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener una carrera por clave
$app->get('/api/carrera/{clave_carrera}', function(Request $request, Response $response){
    $clave_carrera = $request->getAttribute('clave_carrera');

    $sql = "SELECT * FROM carrera WHERE clave_carrera = '$clave_carrera'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $clave_carrera = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
       //echo json_encode($clave_carrera);
				print_r($clave_carrera);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar una carrera
$app->post('/api/carrera/add', function(Request $request, Response $response){
    $clave_carrera = $request->getParam('clave_carrera');
    $nombre_carrera = $request->getParam('nombre_carrera');


    $sql = "INSERT INTO carrera (clave_carrera, nombre_carrera) VALUES (:clave_carrera, :nombre_carrera)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_carrera',      $clave_carrera);
        $stmt->bindParam(':nombre_carrera',         $nombre_carrera);


        $stmt->execute();

        echo '{"notice": {"text": "carrera agregada"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Actualizar carrera
$app->put('/api/carrera/update/{clave_carrera}', function(Request $request, Response $response){
    $clave_carrera = $request->getParam('clave_carrera');
    $nombre_carrera = $request->getParam('nombre_carrera');


    $sql = "UPDATE carrera SET
                clave_carrera               = :clave_carrera,
                nombre_carrera          = :nombre_carrera

            WHERE clave_carrera = '$clave_carrera'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_carrera',      $clave_carrera);
        $stmt->bindParam(':nombre_carrera',         $nombre_carrera);

        $stmt->execute();

        echo '{"notice": {"text": "carrera actualizada"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Borrar carrera
$app->delete('/api/carrera/delete/{clave_carrera}', function(Request $request, Response $response){
    $No_control = $request->getAttribute('clave_carrera');

    $sql = "DELETE FROM carrera WHERE clave_carrera =' $No_control'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Carrera eliminada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//Obtener todas las actividades

$app->get('/api/act_complementaria', function(Request $request, Response $response){
  //echo "actividades";
  $sql = "select * from act_complementaria";

  try{
    //Get DB Object
    $db = new db();
    //connect
    $db = $db->connect();

    $stmt = $db->query($sql);
    $act_complementaria = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    //echo json_encode($estudiantes);
    print_r($act_complementaria);
  } catch(PDOException $e){
    echo '{"error": {"text":'.$e->getMessage().'}';
  }
});

// Obtener una act_complementaria por clave
$app->get('/api/act_complementaria/{clave_act}', function(Request $request, Response $response){
    $clave_act = $request->getAttribute('clave_act');

    $sql = "SELECT * FROM act_complementaria WHERE clave_act = '$clave_act'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $calve_act = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($calve_act);
          //print_r($estudiantes);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar una actividad
$app->post('/api/act_complementaria/add', function(Request $request, Response $response){
    $clave_act = $request->getParam('clave_act');
    $nombre_complementarias = $request->getParam('nombre_complementarias');


    $sql = "INSERT INTO act_complementaria (clave_act, nombre_complementarias) VALUES (:clave_act, :nombre_complementarias)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_act',      $clave_act);
        $stmt->bindParam(':nombre_complementarias',         $nombre_complementarias);


        $stmt->execute();

        echo '{"notice": {"text": "actividad agregada"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Actualizar actividad
$app->put('/api/act_complementaria/update/{clave_act}', function(Request $request, Response $response){
    $clave_act = $request->getParam('clave_act');
    $nombre_complementarias = $request->getParam('nombre_complementarias');


    $sql = "UPDATE act_complementaria SET
                clave_act               = :clave_act,
                nombre_complementarias       = :nombre_complementarias

            WHERE clave_act = '$clave_act'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_act',      $clave_act);
        $stmt->bindParam(':nombre_complementarias',         $nombre_complementarias);

        $stmt->execute();

        echo '{"notice": {"text": "actividad actualizada"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Borrar estudiante
$app->delete('/api/act_complementaria/delete/{clave_act}', function(Request $request, Response $response){
    $clave_act = $request->getAttribute('clave_act');

    $sql = "DELETE FROM act_complementaria WHERE clave_act = $clave_act";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "actividad  eliminada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


//Obtener todos los departamentos

$app->get('/api/departamento', function(Request $request, Response $response){
  //echo "Departamento";
  $sql = "select * from departamento";

  try{
    //Get DB Object
    $db = new db();
    //connect
    $db = $db->connect();

    $stmt = $db->query($sql);
    $departamento = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    //echo json_encode($estudiantes);
    print_r($departamento);
  } catch(PDOException $e){
    echo '{"error": {"text":'.$e->getMessage().'}';
  }
});
// Obtener un departamento por rfc_departamento
$app->get('/api/departamento/{rfc_departamento}', function(Request $request, Response $response){
    $rfc_departamento = $request->getAttribute('rfc_departamento');

    $sql = "SELECT * FROM departamento WHERE rfc_departamento = '$rfc_departamento'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $rfc_departamento = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($rfc_departamento);
          //print_r($estudiantes);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar un departamento
$app->post('/api/departamento/add', function(Request $request, Response $response){
    $rfc_departamento = $request->getParam('rfc_departamento');
    $nombre_departamento = $request->getParam('nombre_departamento');
    $trabajador_rfc = $request->getParam('trabajador_rfc');

    $sql = "INSERT INTO departamento (rfc_departamento, nombre_departamento, trabajador_rfc) VALUES (:rfc_departamento, :nombre_departamento, :trabajador_rfc)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfc_departamento',      $rfc_departamento);
        $stmt->bindParam(':nombre_departamento',         $nombre_departamento);
        $stmt->bindParam(':trabajador_rfc',      $trabajador_rfc);

        $stmt->execute();

        echo '{"notice": {"text": "Departamento agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar departamento
$app->put('/api/departamento/update/{rfc_departamento}', function(Request $request, Response $response){
    $rfc_departamento = $request->getParam('rfc_departamento');
    $nombre_departa = $request->getParam('nombre_departamento');
    $trabajador_rfc = $request->getParam('trabajador_rfc');

    $sql = "UPDATE departamento SET
                rfc_departamento               = :rfc_departamento,
                nombre_departamento       = :nombre_departamento,
                trabajador_rfc   = :trabajador_rfc

            WHERE rfc_departamento = '$rfc_departamento'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfc_departamento',      $rfc_departamento);
        $stmt->bindParam(':nombre_departamento',         $nombre_departamento);
        $stmt->bindParam(':trabajador_rfc',      $trabajador_rfc);

        $stmt->execute();

        echo '{"notice": {"text": "Departamento actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Borrar departamentos
$app->delete('/api/departamento/delete/{rfc_departamento}', function(Request $request, Response $response){
    $rfc_departamento = $request->getAttribute('rfc_departamento');

    $sql = "DELETE FROM departamento WHERE rfc_departamento = '$rfc_departamento'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Departamento eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//Obtener todos los instructores

$app->get('/api/instructor', function(Request $request, Response $response){
  //echo "instructor";
  $sql = "select * from instructor";

  try{
    //Get DB Object
    $db = new db();
    //connect
    $db = $db->connect();

    $stmt = $db->query($sql);
    $instructor = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($instructor);
    //print_r($instructor);
  } catch(PDOException $e){
    echo '{"error": {"text":'.$e->getMessage().'}';
  }
});
// Obtener un instructorpor rfc_instructor
$app->get('/api/instructor/{rfc_instructor}', function(Request $request, Response $response){
    $rfc_instructor = $request->getAttribute('rfc_instructor');

    $sql = "SELECT * FROM instructor WHERE rfc_instructor = '$rfc_instructor'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $rfc_instructor = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($rfc_instructor);
          //print_r($estudiantes);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Agregar un instructor
$app->post('/api/instructor/add', function(Request $request, Response $response){
    $rfc_instructor = $request->getParam('rfc_instructor');
    $nombre_instructor = $request->getParam('nombre_instructor');
    $apellido_p_instructor = $request->getParam('apellido_p_instructor');
    $apellido_m_instructor = $request->getParam('apellido_m_instructor');
    $act_complementaria_clave_act = $request->getParam('act_complementaria_clave_act');

    $sql = "INSERT INTO instructor (rfc_instructor, nombre_instructor, apellido_p_instructor, apellido_m_instructor, act_complementaria_clave_act) VALUES (:rfc_instructor, :nombre_instructor, :apellido_p_instructor, :apellido_m_instructor, :act_complementaria_clave_act)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfc_instructor',      $rfc_instructor);
        $stmt->bindParam(':nombre_instructor',         $nombre_instructor);
        $stmt->bindParam(':apellido_p_instructor',      $apellido_p_instructor);
        $stmt->bindParam(':apellido_m_instructor',      $apellido_m_instructor);
        $stmt->bindParam(':act_complementaria_clave_act',       $act_complementaria_clave_act);


        $stmt->execute();

        echo '{"notice": {"text": "instructor agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Actualizar instructor
$app->put('/api/instructor/update/{rfc_instructor}', function(Request $request, Response $response){
    $rfc_instructor = $request->getParam('rfc_instructor');
    $nombre_instructor = $request->getParam('nombre_instructor');
    $apellido_p_instructor = $request->getParam('apellido_p_instructor');
    $apellido_m_instructor = $request->getParam('apellido_m_instructor');
    $act_complementaria_clave_act = $request->getParam('act_complementaria_clave_act');

    $sql = "UPDATE instructor SET
                rfc_instructor               = :rfc_instructor,
                nombre_instructor       = :nombre_instructor,
                apellido_p_instructor   = :apellido_p_instructor,
                apellido_m_instructor   = :apellido_m_instructor,
                act_complementaria_clave_act                = :act_complementaria_clave_act
            WHERE rfc_instructor = '$rfc_instructor'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfc_instructor',      $rfc_instructor);
        $stmt->bindParam(':nombre_instructor',         $nombre_instructor);
        $stmt->bindParam(':apellido_p_instructor',      $apellido_p_instructor);
        $stmt->bindParam(':apellido_m_instructor',      $apellido_m_instructor);
        $stmt->bindParam(':act_complementaria_clave_act',       $act_complementaria_clave_act);

        $stmt->execute();

        echo '{"notice": {"text": "instructor actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Borrar instructor
$app->delete('/api/instructor/delete/{rfc_instructor}', function(Request $request, Response $response){
    $rfc_instructor = $request->getAttribute('rfc_instructor');

    $sql = "DELETE FROM instructor WHERE rfc_instructor = $rfc_instructor";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "instructor eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
//Obtener todas las solicitudes

$app->get('/api/solicitud', function(Request $request, Response $response){
  //echo "solicitud";
  $sql = "select * from solicitud";

  try{
    //Get DB Object
    $db = new db();
    //connect
    $db = $db->connect();

    $stmt = $db->query($sql);
    $solicitud = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    //echo json_encode($estudiantes);
    print_r($solicitud);
  } catch(PDOException $e){
    echo '{"error": {"text":'.$e->getMessage().'}';
  }
});
// Obtener una solicitud por folio
$app->get('/api/solicitud/{folio}', function(Request $request, Response $response){
    $folio = $request->getAttribute('folio');

    $sql = "SELECT * FROM solicitud WHERE folio = '$folio'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $folio = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($folio);
          //print_r($estudiantes);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Agregar una solicitudes
$app->post('/api/solicitud/add', function(Request $request, Response $response){
    $folio = $request->getParam('folio');
    $asunto = $request->getParam('asunto');
    $fecha = $request->getParam('fecha');
    $lugar = $request->getParam('lugar');
    $instituto_clave = $request->getParam('instituto_clave');
    $instructor_rfc = $request->getParam('instructor_rfc');
    $estudiante_No_contro = $request->getParam('estudiante_No_contro');


    $sql = "INSERT INTO solicitud (folio, asunto, fecha, lugar, instituto_clave, instructor_rfc, estudiante_No_contro) VALUES (:folio, :asunto, :fecha, :lugar, :instituto_clave, :instructor_rfc, :estudiante_No_contro)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':folio',      $folio);
        $stmt->bindParam(':asunto',         $asunto);
        $stmt->bindParam(':fecha',      $fecha);
        $stmt->bindParam(':lugar',         $lugar);
        $stmt->bindParam(':instituto_clave',     $instituto_clave);
        $stmt->bindParam(':instructor_rfc',         $instructor_rfc);
        $stmt->bindParam(':estudiante_No_contro',     $estudiante_No_contro);


        $stmt->execute();

        echo '{"notice": {"text": "solicitud agregada"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar solicitud
$app->put('/api/solicitud/update/{folio}', function(Request $request, Response $response){
    $folio = $request->getParam('folio');
    $asunto = $request->getParam('asunto');
    $fecha = $request->getParam('fecha');
    $lugar = $request->getParam('lugar');
    $instituto_clave = $request->getParam('instituto_clave');
    $instructor_rfc = $request->getParam('instructor_rfc');
    $estudiante_No_contro = $request->getParam('estudiante_No_contro');

    $sql = "UPDATE solicitud SET
                folio               = :folio,
                asunto       = :asunto,
                fecha   = :fecha,
                lugar                = :lugar,
                instituto_clave           = :instituto_clave,
                instructor_rfc           = :instructor_rfc,
                estudiante_No_contro           = :estudiante_No_contro

            WHERE folio = '$folio'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':folio',      $folio);
        $stmt->bindParam(':asunto',         $asunto);
        $stmt->bindParam(':fecha',     $fecha);
        $stmt->bindParam(':lugar',      $lugar);
        $stmt->bindParam(':instituto_clave',       $instituto_clave);
        $stmt->bindParam(':instructor_rfc',  $instructor_rfc);
        $stmt->bindParam(':estudiante_No_contro',  $estudiante_No_contro);

        $stmt->execute();

        echo '{"notice": {"text": "Solicitud actualizada"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Borrar solicitud
$app->delete('/api/solicitud/delete/{folio}', function(Request $request, Response $response){
    $folio = $request->getAttribute('folio');

    $sql = "DELETE FROM solicitud WHERE folio = $folio";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "solicitud eliminada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
//Obtener todos los trabajadores

$app->get('/api/trabajador', function(Request $request, Response $response){
  //echo "trabajador";
  $sql = "select * from trabajador";

  try{
    //Get DB Object
    $db = new db();
    //connect
    $db = $db->connect();

    $stmt = $db->query($sql);
    $trabajador = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    //echo json_encode($estudiantes);
    print_r($trabajador);
  } catch(PDOException $e){
    echo '{"error": {"text":'.$e->getMessage().'}';
  }
});
// Obtener un trabajador por rfc_trabajador
$app->get('/api/trabajador/{rfc_trabajador}', function(Request $request, Response $response){
    $rfc_trabajador = $request->getAttribute('rfc_trabajador');

    $sql = "SELECT * FROM trabajador WHERE rfc_trabajador = '$rfc_trabajador'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $rfc_trabajador = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($rfc_trabajador);
          //print_r($estudiantes);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Agregar un trabajador
$app->post('/api/trabajador/add', function(Request $request, Response $response){
    $rfc_trabajador = $request->getParam('rfc_trabajador');
    $nombre_trabajador = $request->getParam('nombre_trabajador');
    $apellido_p = $request->getParam('apellido_p');
    $apellido_m = $request->getParam('apellido_m');
    $clave_presupuestal = $request->getParam('clave_presupuestal');

    $sql = "INSERT INTO trabajador (rfc_trabajador, nombre_trabajador, apellido_p, apellido_m, clave_presupuestal) VALUES (:rfc_trabajador, :nombre_trabajador, :apellido_p, :apellido_m, :clave_presupuestal)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfc_trabajador',      $rfc_trabajador);
        $stmt->bindParam(':nombre_trabajador',         $nombre_trabajador);
        $stmt->bindParam(':apellido_p',      $apellido_p);
        $stmt->bindParam(':apellido_m',      $apellido_m);
        $stmt->bindParam(':clave_presupuestal',       $clave_presupuestal);

        $stmt->execute();

        echo '{"notice": {"text": "trabajador agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Actualizar trabajador
$app->put('/api/trabajador/update/{rfc_trabajador}', function(Request $request, Response $response){
    $rfc_trabajador = $request->getParam('rfc_trabajador');
    $nombre_trabajador = $request->getParam('nombre_trabajador');
    $apellido_p = $request->getParam('apellido_p');
    $apellido_m = $request->getParam('apellido_m');
    $clave_presupuestal = $request->getParam('clave_presupuestal');

    $sql = "UPDATE trabajador SET
                rfc_trabajador               = :rfc_trabajador,
                nombre_trabajador       = :nombre_trabajador,
                apellido_p   = :apellido_p,
                apellido_m   = :apellido_m,
                clave_presupuestal                = :clave_presupuestal
            WHERE rfc_trabajador = '$rfc_trabajador'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfc_trabajador',      $rfc_trabajador);
        $stmt->bindParam(':nombre_trabajador',         $nombre_trabajador);
        $stmt->bindParam(':apellido_p',      $apellido_p);
        $stmt->bindParam(':apellido_m',      $apellido_m);
        $stmt->bindParam(':clave_presupuestal',  $clave_presupuestal);

        $stmt->execute();

        echo '{"notice": {"text": "trabajador actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar trabajador
$app->delete('/api/trabajador/delete/{rfc_trabajador}', function(Request $request, Response $response){
    $rfc_trabajador = $request->getAttribute('rfc_trabajador');

    $sql = "DELETE FROM trabajador WHERE rfc_trabajador = $rfc_trabajador";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "trabajador eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
//Obtener todos los institutos

$app->get('/api/instituto', function(Request $request, Response $response){
  //echo "instituto";
  $sql = "select * from instituto";

  try{
    //Get DB Object
    $db = new db();
    //connect
    $db = $db->connect();

    $stmt = $db->query($sql);
    $instituto = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    //echo json_encode($estudiantes);
    print_r($instituto);
  } catch(PDOException $e){
    echo '{"error": {"text":'.$e->getMessage().'}';
  }
});
// Obtener un estudiante por no de control
$app->get('/api/instituto/{clave_instituto}', function(Request $request, Response $response){
    $clave_instituto = $request->getAttribute('clave_instituto');

    $sql = "SELECT * FROM instituto WHERE clave_instituto = '$clave_instituto'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $clave_instituto = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($clave_instituto);
          //print_r($estudiantes);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar un instituto
$app->post('/api/instituto/add', function(Request $request, Response $response){
    $clave_instituto = $request->getParam('clave_instituto');
    $nombre_instituto = $request->getParam('nombre_instituto');

    $sql = "INSERT INTO instituto (clave_instituto, nombre_instituto) VALUES (:clave_instituto, :nombre_instituto)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_instituto',      $clave_instituto);
        $stmt->bindParam(':nombre_instituto',         $nombre_instituto);

        $stmt->execute();

        echo '{"notice": {"text": "instituto agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Actualizar instituto
$app->put('/api/instituto/update/{clave_instituto}', function(Request $request, Response $response){
    $clave_instituto = $request->getParam('clave_instituto');
    $nombre_instituto = $request->getParam('nombre_instituto');

    $sql = "UPDATE instituto SET
                clave_instituto               = :clave_instituto,
                nombre_instituto       = :nombre_instituto

            WHERE clave_instituto = '$clave_instituto'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_instituto',      $clave_instituto);
        $stmt->bindParam(':nombre_instituto',         $nombre_instituto);

        $stmt->execute();

        echo '{"notice": {"text": "instituto actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar instituto
$app->delete('/api/instituto/delete/{clave_instituto}', function(Request $request, Response $response){
    $clave_instituto = $request->getAttribute('clave_instituto');

    $sql = "DELETE FROM instituto WHERE clave_instituto = '$clave_instituto'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "instituto eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
