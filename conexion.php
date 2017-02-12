<?php

class Connection {

    public function conectar() {
        $conex = "host=localhost port=5432 dbname=sapitbd user=admin password=admin";
        $cnx = pg_connect($conex) or die("<h1>Error de conexion.</h1> " . pg_last_error());
    }

    public function getGruposTutorGrupos($idTutor) {
        $this->conectar();
        $result = pg_query('select grupos.id, grupos.nombre from grupos, tutores where (grupos.id_tutor1 = tutores.id or grupos.id_tutor2 = tutores.id) and tutores.identificador = \'' . $idTutor . '\'');
        $res = array();

        while ($row = pg_fetch_array($result)) {
            array_push($res, array('id' => $row['id'], 'nombre' => $row['nombre']));
        }
        return $res;
    }

    public function getTutor($idTutor) {
        $this->conectar();
        $result = pg_query('select nombres, ap_paterno, ap_materno, correo, departamentos.nombre as nombre_departamento, telefono,  grupos.lugar_tutoria, grupos.horario, grupos.nombre as nombre_grupo from tutores, departamentos, grupos where departamentos.id = tutores.id_departamento  and (grupos.id_tutor1 = tutores.id or grupos.id_tutor2 = tutores.id) and tutores.id =' . $idTutor);
        $row = pg_fetch_array($result);
        $res = array('nombres' => $row['nombres'], 'apPaterno' => $row['ap_paterno'], 'apMaterno' => $row['ap_materno'], 'correo' => $row['correo'], 'nombreDpto' => $row['nombre_departamento'], 'telefono' => $row['telefono'], 'lugarTutoria' => $row['lugar_tutoria'], 'horario' => $row['horario'], 'nombreGrupo' => $row['nombre_grupo']);
        return $res;
    }

    public function getTutores() {
        $this->conectar();
        $result = pg_query('select nombres, ap_paterno, ap_materno, correo, departamentos.nombre as nombre_departamento, telefono,  grupos.lugar_tutoria, grupos.horario, grupos.nombre as nombre_grupo from tutores, departamentos, grupos where departamentos.id = tutores.id_departamento  and (grupos.id_tutor1 = tutores.id or grupos.id_tutor2 = tutores.id)');
        $res = array();
        while ($row = pg_fetch_array($result)) {
            array_push($res, array('nombres' => $row['nombres'], 'apPaterno' => $row['ap_paterno'], 'apMaterno' => $row['ap_materno'], 'correo' => $row['correo'], 'nombreDpto' => $row['nombre_departamento'], 'telefono' => $row['telefono'], 'lugarTutoria' => $row['lugar_tutoria'], 'horario' => $row['horario'], 'nombreGrupo' => $row['nombre_grupo']));
        }
        return $res;
    }

    public function getTutorPorId($idTutor){
        $this->conectar();
        $result = pg_query('select tutores.id as tutores_id, tutores.nombres as tutores_nombre, tutores.ap_paterno as 
            tutores_appaterno, tutores.ap_materno as tutores_apmaterno, tutores.correo as tutores_correo, tutores.nip as 
            tutores_nip, tutores.telefono as tutores_telefono, tutores.cuidad as tutores_ciudad, tutores.domicilio as 
            tutores_domicilio, tutores.identificador as tutores_identificador, departamentos.id as departamentos_id, 
            departamentos.nombre as departamentos_nombre from tutores INNER JOIN departamentos ON (tutores.id_departamento =
            departamentos.id) where tutores.id = '.$idTutor);
        $res = array();
        $row = pg_fetch_array($result);
        $res = array("id"=>$row['tutores_id'], "nombre"=>$row['tutores_nombre'], "apPaterno" => $row['tutores_appaterno'],
            "apMaterno" => $row['tutores_apmaterno'], "correo"=> $row['tutores_correo'], "nip" => $row['tutores_nip'],
            "telefono" => $row['tutores_telefono'], "ciudad"=> $row['tutores_ciudad'], "domicilio" => $row['tutores_domicilio'],
            "identificador" => $row['tutores_identificador'], "idDepartamento"=>$row['departamentos_id'],
             "nombreDepartamento" => $row['departamentos_nombre']);
        return $res;

    }

    public function getListaTutores(){
        $this->conectar();
        $result = pg_query('select tutores.id as tutores_id, tutores.nombres as tutores_nombres, tutores.ap_paterno as tutores_appaterno, tutores.ap_materno as tutores_apmaterno, departamentos.nombre as tutores_departamento, tutores.identificador as tutores_identificador from tutores INNER JOIN departamentos ON(tutores.id_departamento = departamentos.id)');
        $res = array();
        while($row = pg_fetch_array($result)){
            array_push($res, array("id"=> $row['tutores_id'], "nombre"=> $row['tutores_nombres'], "apPaterno"=> $row['tutores_appaterno'], "apMaterno"=>$row['tutores_apmaterno'], "departamento"=>$row['tutores_departamento'], "identificador"=>$row['tutores_identificador']));
        }
        return $res;
    }
    public function getListaTutoriasIndividualesPorTutor($idTutor){
        $this->conectar();
        $result = pg_query('select tutorias_individual.id as id_tutorias_individual, tutorias_individual.id_grupo as id_grupo, tutorias_individual.fecha as fecha, tutorias_individual.solicitada_por as solicitada_por, tutorias_individual.motivos as motivos, tutorias_individual.aspectos_tratados as aspectos_tratados, tutorias_individual.conclusiones as conclusiones, tutorias_individual.observaciones as observaciones, tutorias_individual.fecha_prox_visita as fecha_prox_visita, tutorias_individual.id_alumno as id_alumno, tutorias_individual.id_tutor as id_tutor from tutorias_individual where tutorias_individual.id_tutor = '.$idTutor);
        $res = array();
        while($row = pg_fetch_array($result)){
            array_push($res, array("id"=> $row['id_tutorias_individual'], "idGrupo"=> $row['id_grupo'], "fecha"=> $row['fecha'], "solicitadaPor"=>$row['solicitada_por'], "motivos"=>$row['motivos'], "aspectosTratados"=>$row['aspectos_tratados'], "conclusiones"=>$row['conclusiones'], "observaciones"=>$row['observaciones'], "fechaProxVisita"=>$row['fecha_prox_visita'], "idAlumno"=>$row['id_alumno'], "idTutor"=>$row['id_tutor']));
        }
        return $res;
    }
    public function getListaGrupos(){
        $this->conectar();
        $result = pg_query('select id, nombre , lugar_tutoria, id_periodo, id_tutor1, id_tutor2, horario from grupos');
        $res = array();
        while($row = pg_fetch_array($result)){
            array_push($res, array("id"=> $row['id'], "nombre"=> $row['nombre'], "lugarTutoria"=> $row['lugar_tutoria'], "idPeriodo"=>$row['id_periodo'], "idTutor1"=>$row['id_tutor1'], "idTutor2"=>$row['id_tutor2'], "horario"=>$row['horario']));
        }
        return $res;
    }

    public function getListaAlumnos(){
        $this->conectar();
        $result = pg_query('select alumnos.id as alumnos_id, alumnos.nombres as alumnos_nombres, alumnos.ap_paterno as 
            alumnos_appaterno, alumnos.ap_materno as alumnos_apmaterno, carreras.nombre as alumnos_carrera, grupos.nombre 
            as alumnos_grupo from alumnos INNER JOIN carreras ON (alumnos.id_carrera = carreras.id) INNER JOIN grupos 
            ON (alumnos.id_grupo = grupos.id)');
        $res = array();
        while($row = pg_fetch_array($result)){
            array_push($res, array("id" => $row['alumnos_id'], "nombre" => $row['alumnos_nombres'].' '.$row['alumnos_appaterno'].' '.$row['alumnos_apmaterno'], "carrera"=> $row['alumnos_carrera'], "grupo"=> $row['alumnos_grupo']));
        }
        return $res;
    }

    public function getAlumnoPorId($idAlumno){
        $this->conectar();
        $result = pg_query('select alumnos.id as alumnos_id, alumnos.nombres as alumnos_nombres, alumnos.ap_paterno as 
            alumnos_appaterno, alumnos.ap_materno as alumnos_apmaterno, alumnos.correo as alumnos_correo, alumnos.no_control as 
            alumnos_nocontrol, alumnos.nip as alumnos_nip, alumnos.telefono as alumnos_telefono, alumnos.ciudad as alumnos_ciudad,
            alumnos.domicilio as alumnos_domicilio, alumnos.id_carrera as alumnos_idcarrera, alumnos.id_grupo as alumnos_idgrupo, 
            alumnos.nombres_tutor as alumnos_nombrestutor, alumnos.domicilio_tutor as alumnos_domiciliotutor, alumnos.telefono_tutor as 
            alumnos_telefonotutor, alumnos.ciudad_tutor as alumnos_ciudadtutor from alumnos where id='.$idAlumno);
        $row = pg_fetch_array($result);
        $res = array("id"=>$row['alumnos_id'], "nombre"=>$row['alumnos_nombres'], "apPaterno"=>$row['alumnos_appaterno'], 
            "apMaterno"=>$row['alumnos_apmaterno'], "correo"=>$row['alumnos_correo'], "noControl"=>$row['alumnos_nocontrol'],
            "nip"=>$row['alumnos_nip'], "telefono"=>$row['alumnos_telefono'], "ciudad"=>$row['alumnos_ciudad'], "domicilio"=>
            $row['alumnos_domicilio'], "idCarrera"=>$row['alumnos_idcarrera'], "idGrupo"=>$row['alumnos_idgrupo'], "nombreTutor"=>
            $row['alumnos_nombrestutor'], "domicilioTutor"=>$row['alumnos_domiciliotutor'], "telefonoTutor"=>$row['alumnos_telefonotutor'],
            "ciudadTutor"=>$row['alumnos_ciudadtutor']);
        return $res;
    }

    public function actualizarDatosTutor($idTutor, $nombres, $apPaterno, $apMaterno, $correo, $telefono, $lugar, $horario) {
        $this->conectar();
        pg_query('begin') or die("No se pudo comenzar la transacción");

        $result = pg_query('update tutores set nombres = \'' . $nombres . '\', ap_paterno = \'' . $apPaterno . '\', ap_materno = \'' . $apMaterno . '\', correo = \'' . $correo . '\', telefono = \'' . $telefono . '\' where id = ' . $idTutor);

        $result = pg_query('update grupos set lugar_tutoria = \'' . $lugar . '\', horario = \'' . $horario . '\' where id_tutor1 = ' . $idTutor . ' or id_tutor2 = ' . $idTutor);

        pg_query('commit') or die('Ocurrió un error durante la transacción');
        return $result;
    }

    public function getCantidadEstudiantesGrupalTutor($idTutor) {
        $this->conectar();
        $res = pg_query('select id from grupos where id_tutor1 =' . $idTutor . ' or id_tutor2 =' . $idTutor . ';');
        $row = pg_fetch_array($res);
        $idGrupo = $row['id'];
        $res = pg_query('select count(*) as cnt from tutorias_grupal where id_grupo = ' . $idGrupo);
        $row = pg_fetch_array($res);
        $cntGrupo = $row['cnt'];

        return $cntGrupo;
    }

    public function getCantidadEstudiantesIndividualTutor($idTutor) {
        $this->conectar();
        $res = pg_query('select id from grupos where id_tutor1 =' . $idTutor . ' or id_tutor2 =' . $idTutor . ';');
        $row = pg_fetch_array($res);
        $idGrupo = $row['id'];
        $res = pg_query('select count(*) as cnt from tutorias_individual where id_grupo = ' . $idGrupo . 'and id_tutor = ' .$idTutor);
        $row = pg_fetch_array($res);
        $cntGrupo = $row['cnt'];

        return $cntGrupo;
    }

    public function getGrupoTutor($idTutor) {
        $this->conectar();
        $res = pg_query('select nombre from grupos where id_tutor1 = ' . $idTutor . ' or id_tutor2 = ' . $idTutor);
        $row = pg_fetch_array($res);
        $nombreGrupo = $row['nombre'];

        return $nombreGrupo;
    }

    public function getCarreraGrupo($idGrupo) {
        $this->conectar();
        $res = pg_query('select nombre from carreras, alumnos, det_grupos where carreras.id = alumnos.id_carrera and alumnos.id = det_grupos.id_alumno and det_grupos.id_grupo = ' . $idGrupo . ' group by nombre');
        $row = pg_fetch_array($res);
        $nombreCarrera = $row['nombre'];
        return $nombreCarrera;
    }

    public function getTutoresDpto($idDpto) {
        $this->conectar();
        $result = pg_query('select id, nombres, ap_paterno, ap_materno from tutores where id_departamento = ' . $idDpto);
        $res = array();
        while ($row = pg_fetch_array($result)) {
            array_push($res, array('id' => $row['id'], 'nombre' => $row['nombres'] . ' ' . $row['ap_paterno'] . ' ' . $row['ap_materno']));
        }
        return $res;
    }

    public function getTutoresGrupo($idGrupo) {
        $this->conectar();
        $result = pg_query('select tutores.id, tutores.nombres, tutores.ap_paterno, tutores.ap_materno from tutores, grupos where (tutores.id = grupos.id_tutor1 or tutores.id = grupos.id_tutor2) and grupos.id = ' . $idGrupo);
        $res = array();

        while ($row = pg_fetch_array($result)) {
            array_push($res, array('id' => $row['id'], 'nombres' => $row['nombres'], 'ap_paterno' => $row['ap_paterno'], 'ap_materno' => $row['ap_materno']));
        }
        return $res;
    }

    public function getDptoUsuario($idUsuario) {
        $this->conectar();
        $result = pg_query('select departamentos.id from departamentos, usuarios where departamentos.id = usuarios.iddpto and usuarios.id = ' . $idUsuario);
        $row = pg_fetch_array($result);
        $res = $row['id'];
        return $res;
    }

    public function getIdDpto($idUsuario) {
        $this->conectar();
        $result = pg_query('select iddpto from  usuarios where id = ' . $idUsuario);
        $row = pg_fetch_array($result);
        $res = $row['iddpto'];
        return $res;
    }

    public function getAlumnosGrupo($idGrupo) {
        $this->conectar();
        $result = pg_query('select alumnos.id, alumnos.nombres, alumnos.ap_paterno, alumnos.ap_materno, alumnos.correo, alumnos.no_control, alumnos.nip, alumnos.telefono, alumnos.domicilio, alumnos.ciudad, carreras.nombre, alumnos.nombres_tutor, alumnos.telefono_tutor, alumnos.domicilio_tutor,  alumnos.ciudad_tutor from alumnos, carreras, det_grupos where alumnos.id_carrera = carreras.id and det_grupos.id_alumno = alumnos.id  and det_grupos.id_grupo = ' . $idGrupo);
        $res = array();

        while ($row = pg_fetch_array($result)) {
            array_push($res, array('id' => $row['id'], 'nombres' => $row['nombres'], 'ap_paterno' => $row['ap_paterno'], 'ap_materno' => $row['ap_materno'], 'correo' => $row['correo'], 'no_control' => $row['no_control'], 'nip' => $row['nip'], 'telefono' => $row['telefono'], 'domicilio' => $row['domicilio'], 'ciudad' => $row['ciudad'], 'nombre' => $row['nombre'], 'nombres_tutor' => $row['nombres_tutor'], 'telefono_tutor' => $row['telefono_tutor'], 'domicilio_tutor' => $row['domicilio_tutor'], 'ciudad_tutor' => $row['ciudad_tutor']));
        }
        return $res;
    }

    public function hasTutoGrup($idAlumno) {
        $this->conectar();
        $result = pg_query('select alumnos.id from tutorias_grupal, det_grupos, alumnos where tutorias_grupal.id_grupo = det_grupos.id_grupo and det_grupos.id_alumno = alumnos.id and alumnos.id = ' . $idAlumno);
        $row = pg_fetch_array($result);
        if ($row) {
            return true;
        } else {
            return false;
        }
    }

    public function hasTutoIndiv($idAlumno) {
        $this->conectar();
        $result = pg_query('select id_alumno from tutorias_individual where id_alumno = ' . $idAlumno);
        $row = pg_fetch_array($result);
        if ($row) {
            return true;
        } else {
            return false;
        }
    }

    public function getLugarTutoria($idGrupo) {
        $this->conectar();
        $result = pg_query('select lugar_tutoria from grupos where id =' . $idGrupo);
        $row = pg_fetch_array($result);
        $res = $row['lugar_tutoria'];
        return $res;
    }

    public function getListaDepartamentos() {
        $this->conectar();
        $result = pg_query('select id, nombre from departamentos order by id');
        $res = array();
        while ($row = pg_fetch_array($result)) {
            array_push($res, array('id' => $row['id'], 'nombre' => $row['nombre']));
        }
        return $res;
    }

    public function getListaPeriodos() {
        $this->conectar();
        $result = pg_query('select id, identificador, fecha_inicio, fecha_fin from periodos order by id');
        $res = array();
        while ($row = pg_fetch_array($result)) {
            array_push($res, array('id' => $row['id'], 'identificador' => $row['identificador'], 'fecha_inicio' => $row['fecha_inicio'], 'fecha_fin' => $row['fecha_fin']));
        }
        return $res;
    }

    public function getDepartamentoPorId($idDepartamento) {
        $this->conectar();
        $result = pg_query('select id, nombre from departamentos where id =' . $idDepartamento);
        $res = array();
        while ($row = pg_fetch_array($result)) {
            array_push($res, $row['id']);
            array_push($res, $row['nombre']);
        }
        return $res;
    }

    public function getListaCarreras() {
        $this->conectar();
        $result = pg_query('select carreras.id as carreras_id, carreras.nombre as carreras_nombre, departamentos.nombre as carreras_departamento from carreras INNER JOIN departamentos ON (carreras.id_departamento = departamentos.id) order by carreras.id asc');
        $res = array();
        while ($row = pg_fetch_array($result)) {
            array_push($res, array('id' => $row['carreras_id'], 'nombre' => $row['carreras_nombre'], 'departamento' => $row['carreras_departamento']));
        }
        return $res;
    }

    public function getCarreraPorId($idCarrera) {
        $this->conectar();
        $result = pg_query('select carreras.id as carreras_id, carreras.nombre as carreras_nombre, carreras.id_departamento as carreras_iddepartamento, departamentos.nombre as carreras_departamento from carreras INNER JOIN departamentos ON (carreras.id_departamento = departamentos.id) where carreras.id = ' . $idCarrera);
        $res = array();
        while ($row = pg_fetch_array($result)) {
            array_push($res, $row['carreras_id']);
            array_push($res, $row['carreras_nombre']);
            array_push($res, $row['carreras_iddepartamento']);
            array_push($res, $row['carreras_departamento']);
        }
        return $res;
    }

    public function guardarTutoriasIndividual($idGrupo, $fecha, $solicPor, $motivos, $aspectos, $conclusiones, $observaciones, $proxFecha, $idAlumno, $idTutor) {
        $this->conectar();
        $res = pg_query('insert into tutorias_individual values (default, ' . $idGrupo . ',\'' . $fecha . '\',\'' . $solicPor . '\',\'' . $motivos . '\',\'' . $aspectos . '\',\'' . $conclusiones . '\',\'' . $observaciones . '\',' . (($proxFecha == '') ? 'cast(NULL as timestamp)' : '\'' . $proxFecha . '\'') . ',' . $idAlumno . ',' . $idTutor . ')');
        return $res;
    }
    public function getTutoriaIndividualPorId($idTutoriaIndividual) {
        $this->conectar();
        $result = pg_query('select id, id_grupo, fecha, solicitada_por, motivos, aspectos_tratados, conclusiones, observaciones, fecha_prox_visita, id_alumno, id_tutor from tutorias_individual where id = '.$idTutoriaIndividual);
        $res = array();
        $row = pg_fetch_array($result);
        $res = array('id' => $row['id'], 'idGrupo' => $row['id_grupo'], 'fecha' => $row['fecha'], 'solicitadaPor' => $row['solicitada_por'], 'motivos' => $row['motivos'], 'aspectosTratados' => $row['aspectos_tratados'], 'conclusiones' => $row['conclusiones'], 'observaciones' => $row['observaciones'], 'fechaProxVisita' => $row['fecha_prox_visita'], 'idAlumno' => $row['id_alumno'], 'idTutor' => $row['id_tutor']);
        
        return $res;
    }

    public function guardarTutoriasGrupal($idGrupo, $fecha, $tema, $lugar) {
        $this->conectar();
        $res = pg_query('insert into tutorias_grupal values (default, ' . $idGrupo . ',\'' . $fecha . '\',\'' . $tema . '\',\'' . $lugar . '\')');
        return $res;
    }

    public function guardarDiagnosticoGrupo($idGrupo, $fecha, $semestre, $tabla) {
        $this->conectar();
        pg_query('begin') or die("No se pudo comenzar la transacción");

        $result = pg_query('insert into diagnostico_grupo values (default, ' . $idGrupo . ',\'' . $fecha . '\',\'' . $semestre . '\') returning id');
        $row = pg_fetch_array($result);
        if ($row) {
            $a = explode("|", $tabla);
            foreach ($a as $s) {
                $query = 'insert into det_diagnostico_grupo values (' . $row[0];
                $b = explode("^", $s);
                foreach ($b as $d) {
                    $query = $query . ', \'' . $d . '\'';
                }
                $query = $query . ')';
                $result = pg_query($query);
            }
        }
        pg_query('commit') or die('Ocurrió un error durante la transacción');
        return $result;
    }

    public function guardarReporteTutor($idTutor, $idGrupo, $fecha, $tabla, $observaciones) {
        $this->conectar();
        pg_query('begin') or die("No se pudo comenzar la transacción");
        $result = pg_query('insert into reporte_tutor values (default, ' . $idTutor . ',\'' . $fecha . '\',' . $idGrupo . ',\'' . $observaciones . '\') returning id');
        $row = pg_fetch_array($result);
        if ($row) {
            $a = explode("|", $tabla);
            $cnt = 0;
            foreach ($a as $s) {
                $query = 'insert into det_reporte_tutor values (' . $row[0];
                $b = explode("^", $s);
                foreach ($b as $d) {
                    $query = $query . ', \'' . $d . '\'';
                }

                $query = $query . ')';
                $result = pg_query($query);
                $cnt++;
            }
        }
        pg_query('commit') or die('Ocurrió un error durante la transacción');
        return $result;
    }
    public function guardarReporteCoordinadorDepartamental($fecha, $idCrdDpt, $programaEducativo, $departamentoAcademico, $idPeriodo, $tabla, $observaciones) {
        $this->conectar();
        pg_query('begin') or die("No se pudo comenzar la transacción");
        $result = pg_query('insert into reporte_coordinador_departamental values (default,\'' . $fecha . '\',\'' . $programaEducativo . '\',\'' . $departamentoAcademico . '\',' . $idPeriodo . ',\'' . $observaciones . '\',' . $idCrdDpt . ') returning id');
        $row = pg_fetch_array($result);
        if ($row) {
            $a = explode("|", $tabla);
            $cnt = 0;
            foreach ($a as $s) {
                $query = 'insert into det_reporte_coordinador_departamental values (' . $row[0];
                $b = explode("^", $s);
                foreach ($b as $d) {
                    $query = $query . ', \'' . $d . '\'';
                }

                $query = $query . ')';
                $result = pg_query($query);
                $cnt++;
            }
        }
        pg_query('commit') or die('Ocurrió un error durante la transacción');
        return $result;
    }

    public function guardarDiagnosticoDepartamental($nombreCrdDpt, $idDpto, $fecha, $tabla) {
        $this->conectar();
        pg_query('begin') or die("No se pudo comenzar la transacción");

        $result = pg_query('insert into diagnostico_departamental values (default, \'' . $nombreCrdDpt . '\',\'' . $idDpto . '\',\'' . $fecha . '\') returning id');
        $row = pg_fetch_array($result);
        if ($row) {
            $a = explode("|", $tabla);
            foreach ($a as $s) {
                $query = 'insert into det_diagnostico_departamental values (' . $row[0];
                $b = explode("^", $s);
                foreach ($b as $d) {
                    $query = $query . ', \'' . $d . '\'';
                }
                $query = $query . ')';
                $result = pg_query($query);
            }
        }
        pg_query('commit') or die('Ocurrió un error durante la transacción');
        return $result;
    }

    public function getProblematicasGrupo($idGrupo) {
        $this->conectar();
        $res = array();
        $result = pg_query('select problematica, valor, objetivos, acciones from det_plan_accion_tutorial_problematicas, plan_accion_tutorial where det_plan_accion_tutorial_problematicas.id_plan_accion_tutorial = plan_accion_tutorial.id and plan_accion_tutorial.id_grupo = ' . $idGrupo);
        while ($row = pg_fetch_array($result)) {
            array_push($res, array('problematica' => $row['problematica'], 'valor' => $row['valor'], 'objetivos' => $row['objetivos'], 'acciones' => $row['acciones']));
        }
        return $res;
    }

    public function guardarPlanAccionTutorial($idGrupo, $tablaProb, $fecha, $tabla) {
        $this->conectar();
        pg_query('begin') or die("No se pudo comenzar la transacción");

        $query = pg_query('insert into plan_accion_tutorial values (default, ' . $idGrupo . ',\'' . $fecha . '\') returning id');
        $row = pg_fetch_row($query);
        $id = $row['0'];
        if ($id) {

            $a = explode("|", $tablaProb);
            foreach ($a as $s) {
                $query = 'insert into det_plan_accion_tutorial_problematicas values (' . $id;
                $b = explode("^", $s);
                foreach ($b as $d) {
                    $query = $query . ', \'' . $d . '\'';
                }
                $query = $query . ')';
                $result = pg_query($query);
            }

            $a = explode("|", $tabla);
            foreach ($a as $s) {
                $query = 'insert into det_plan_accion_tutorial values (' . $id;
                $b = explode("^", $s);
                foreach ($b as $d) {
                    $query = $query . ', \'' . $d . '\'';
                }
                $query = $query . ')';
                $result = pg_query($query);
            }
        }
        pg_query('commit') or die('Ocurrió un error durante la transacción');
        return $result;
    }

    public function guardarPlanAccionTutorialDpt($nombreCrdDpt, $idDepartamento, $fecha, $tablaProb, $evaluacion, $tabla) {
        $this->conectar();
        pg_query('begin') or die("No se pudo comenzar la transacción");

        $query = pg_query('insert into plan_accion_tutorial_departamental values (default, \'' . $nombreCrdDpt . '\',' . $idDepartamento . ',\'' . $fecha . '\',\'' . $evaluacion . '\') returning id');
        $row = pg_fetch_row($query);
        $id = $row['0'];
        if ($id) {

            $a = explode("|", $tablaProb);
            foreach ($a as $s) {
                $query = 'insert into det_plan_accion_tutorial_departamental_problematicas values (' . $id;
                $b = explode("^", $s);
                foreach ($b as $d) {
                    $query = $query . ', \'' . $d . '\'';
                }
                $query = $query . ')';
                $result = pg_query($query);
            }

            $a = explode("|", $tabla);
            foreach ($a as $s) {
                $query = 'insert into det_plan_accion_tutorial_departamental values (' . $id;
                $b = explode("^", $s);
                foreach ($b as $d) {
                    $query = $query . ', \'' . $d . '\'';
                }
                $query = $query . ')';
                $result = pg_query($query);
            }
        }
        pg_query('commit') or die('Ocurrió un error durante la transacción');
        return $result;
    }

    public function guardarPlaneacionDiagnosticoDpt($idDpto, $fecha, $tabla, $listaIdGrupos) {
        $this->conectar();

        pg_query('begin') or die("No se pudo comenzar la transacción");

        $tabla = substr($tabla, 1);
        echo ($tabla);
        $query = pg_query('insert into planeacion_diagnostico_departamental values (default, ' . $idDpto . ',\'' . $fecha . '\') returning id');
        $row = pg_fetch_row($query);
        $id = $row['0'];
        $listaIdGrp = explode(" ", $listaIdGrupos);
        if ($id) {
            $first = true;
            $a = explode("|", $tabla);
            foreach ($a as $s) {
                echo('IN> ');
                $b = explode("^", $s);
                $cnt = 0;
                foreach ($b as $d) {
                    if ($first) {
                        $query = pg_query('insert into det_planeacion_diagnostico_departamental values ( default,' . $id . ', \'' . $d . '\') returning id');
                        $row = pg_fetch_row($query);
                        $idDetPlanAccionTutorialDpt = $row['0'];
                        $first = false;
                    } else {
                        if ($d !== '' && ($cnt < count($listaIdGrp)) && $idDetPlanAccionTutorialDpt !== '' && $listaIdGrp[$cnt]) {
                            echo ('IF Cnt: ' . $cnt);
                            echo ('idGrp' . $listaIdGrp[$cnt]);
                            $prepQuery = "insert into det_planeacion_diagnostico_departamental_grupos values ( " . $idDetPlanAccionTutorialDpt . "," . $listaIdGrp[$cnt] . ",'" . $d . "')";
                            $result = pg_query($prepQuery);
                        } else {
                            echo ('$d: ' . $d);
                            echo ('ELSE>');
                        }
                        $cnt = $cnt + 1;
                    }
                }
                $first = true;
            }
        }
        pg_query('commit') or die('Ocurrió un error durante la transacción');
        return $result;
    }

    public function getAlumno($idAlumno) {
        $this->conectar();
        $result = pg_query('select nombres, ap_paterno, ap_materno from alumnos where id = ' . $idAlumno);
        $row = pg_fetch_array($result);
        $res = $row['nombres'] . ' ' . $row['ap_paterno'] . ' ' . $row['ap_materno'];
        return $res;
    }

    public function getDpto($idDpto) {
        $this->conectar();
        $result = pg_query('select nombre from departamentos where id = ' . $idDpto);
        $row = pg_fetch_array($result);
        return $row['nombre'];
    }

    public function getCarrera($idCarrera) {
        $this->conectar();
        $result = pg_query('select nombre from carreras where id = ' . $idCarrera);
        $row = pg_fetch_array($result);
        return $row['nombre'];
    }

    public function getGrupo($idGrupo) {
        $this->conectar();
        $result = pg_query('select nombre from grupos where id = ' . $idGrupo);
        $row = pg_fetch_array($result);
        return $row['nombre'];
    }
    public function getGrupoPorId($idGrupo) {
        $this->conectar();
        $res = pg_query('select id, nombre, lugar_tutoria, id_periodo, id_tutor1, id_tutor2, horario from grupos where id = ' . $idGrupo);
        $result = array();
        while ($row = pg_fetch_array($res)) {
            array_push($result, $row['id']);
            array_push($result, $row['nombre']);
            array_push($result, $row['lugar_tutoria']);
            array_push($result, $row['id_periodo']);
            array_push($result, $row['id_tutor1']);
            array_push($result, $row['id_tutor2']);
            array_push($result, $row['horario']);
        }
        return $result;
    }

    public function getPeriodo($idGrupo) {
        $this->conectar();
        $result = pg_query('select identificador from periodos, grupos where periodos.id = grupos.id_periodo and grupos.id = ' . $idGrupo . ' group by periodos.identificador');
        $row = pg_fetch_array($result);
        return $row['identificador'];
    }

    public function getPeriodoPorId($idPeriodo) {
        $this->conectar();
        $res = pg_query('select identificador, fecha_inicio, fecha_fin from periodos where id = ' . $idPeriodo);
        $result = array();
        while ($row = pg_fetch_array($res)) {
            array_push($result, $row['identificador']);
            array_push($result, $row['fecha_inicio']);
            array_push($result, $row['fecha_fin']);
        }
        return $result;
    }

    public function getCarreras() {
        $this->conectar();
        $res = array();
        $result = pg_query('select id, nombre from carreras');
        while ($row = pg_fetch_array($result)) {
            array_push($res, array('id' => $row['id'], 'nombre' => $row['nombre']));
        }
        return $res;
    }

    public function getCarrerasDpto($idDpto) {
        $this->conectar();
        $res = array();
        $result = pg_query('select id, nombre from carreras where id_departamento = ' . $idDpto);
        while ($row = pg_fetch_array($result)) {
            array_push($res, array('id' => $row['id'], 'nombre' => $row['nombre']));
        }
        return $res;
    }

    public function getGruposDpto($idDpto) {
        $this->conectar();
        $res = array();
        $result = pg_query('select distinct grupos.id, grupos.nombre from grupos, det_grupos, alumnos, carreras, departamentos where departamentos.id = carreras.id_departamento and carreras.id = alumnos.id_carrera and alumnos.id = det_grupos.id_alumno and det_grupos.id_grupo = grupos.id and departamentos.id = ' . $idDpto);
        while ($row = pg_fetch_array($result)) {
            array_push($res, array('id' => $row['id'], 'nombre' => $row['nombre']));
        }
        return $res;
    }

    public function getValorProblematicaGrupo($idGrupo) {
        $this->conectar();
        $result = pg_query('select valor_asignado from plan_accion_tutorial where id_grupo =' . $idGrupo);
        $row = pg_fetch_array($result);
        $res = $row['valor_asignado'];
        return $res;
    }

    public function getSemestresDpto($idDpto) {
        $this->conectar();
        $res = array();
        $result = pg_query('select distinct periodos.identificador from periodos, grupos, det_grupos, alumnos, carreras, departamentos where periodos.id = grupos.id_periodo and grupos.id = det_grupos.id_grupo and det_grupos.id_alumno = alumnos.id and alumnos.id_carrera = carreras.id and carreras.id_departamento = departamentos.id and departamentos.id =' . $idDpto);
        while ($row = pg_fetch_array($result)) {
            array_push($res, array('ident' => $row['identificador']));
        }
        return $res;
    }

    public function getDptos() {
        $this->conectar();
        $res = array();
        $result = pg_query('select id, nombre from departamentos');
        while ($row = pg_fetch_array($result)) {
            array_push($res, array('id' => $row['id'], 'nombre' => $row['nombre']));
        }
        return $res;
    }

    public function getGrupoCarreraDpto($idGrupo) {
        $this->conectar();
        $result = pg_query('select grupos.nombre, carreras.id as idcarr, departamentos.id as iddpto from grupos, det_grupos, carreras, departamentos, alumnos where  grupos.id = det_grupos.id_grupo and det_grupos.id_alumno = alumnos.id and alumnos.id_carrera = carreras.id and carreras.id_departamento = departamentos.id and grupos.id = ' . $idGrupo . ' limit 1');
        $row = pg_fetch_array($result);

        $res = array('nombre' => $row['nombre'], 'idcarr' => $row['idcarr'], 'iddpto' => $row['iddpto']);
        return $res;
    }

    public function getNumeroAlumnos($idGrupo) {
        $this->conectar();
        $result = pg_query('select count(*) as numalumnos from det_grupos where id_grupo = ' . $idGrupo);
        $row = pg_fetch_array($result);
        $res = $row['numalumnos'];
        return $res;
    }

}
