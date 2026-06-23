<?php

class UsuarioModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getUsuarios()
    {
        $sql = "SELECT * FROM usuario";
        Log::info("SQL: $sql");
        return $this->database->query($sql);
    }

    public function getUsuario($id)
    {
        $sql = "SELECT id, nombre_usuario, nombre_completo, puntaje, 
                   anio_nacimiento, sexo, email, foto_perfil, latitud, longitud
            FROM usuario 
            WHERE id = ?";
        Log::info("SQL: $sql [$id]");
        $filas = $this->database->query($sql, [$id]);
        return !empty($filas) ? $filas[0] : null;
    }
    public function getUsuarioByName($nombre_usuario)
    {
        $sql = "SELECT * FROM usuario WHERE nombre_usuario = ?";
        Log::info("SQL: $sql [$nombre_usuario]");
        $filas = $this->database->query($sql, [$nombre_usuario]);
        return !empty($filas) ? $filas[0] : null;
    }

    public function alta(
        $nombreCompleto,
        $anioNacimiento,
        $sexo,
        $email,
        $nombreUsuario,
        $contrasena,
        $fotoPerfil = null,
        $longitud,
        $latitud
        
    ) {
        $token = bin2hex(random_bytes(16)); // 32 caracteres hexadecimales

        $sql = "INSERT INTO usuario 
            (nombre_completo, anio_nacimiento, sexo, email, nombre_usuario, contrasena, foto_perfil, longitud, latitud, token_verificacion, verificado)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";

        Log::info("SQL: $sql");

        $resultado = $this->database->execute($sql, [
            $nombreCompleto,
            $anioNacimiento,
            $sexo,
            $email,
            $nombreUsuario,
            $contrasena,
            $fotoPerfil,
            $longitud,
            $latitud,
            $token
        ]);

        if ($resultado) {
            return $token;
        }

        return false;
    }

    public function confirmarCuenta($token)
    {
        $usuario = $this->database->query("SELECT id/*id_usuario*/ 
        FROM usuario 
        WHERE token_verificacion = ? AND verificado = 0",
         [$token]
        );

        if (empty($usuario)) {
            return false;
        }

        return $this->database->execute(
            "UPDATE usuario
             SET verificado = 1,
             token_verificacion = NULL 
             WHERE token_verificacion = ?",
              [$token]
        );
    }
    public function actualizarFoto($nombreUsuario, $rutaFoto)
    {
        $sql = "UPDATE usuario
            SET foto_perfil = ?
            WHERE nombre_usuario = ?";

        return $this->database->execute($sql, [
            $rutaFoto,
            $nombreUsuario
        ]);
    }

  public function editar(
    $id,
    $nombreCompleto,
    $anioNacimiento,
    $sexo,
    $email,
    $nombreUsuario,
    $fotoPerfil = null,
    $longitud,
    $latitud,
    $contrasena = null 
) {
    $sql = "UPDATE usuario
            SET nombre_completo = ?,
                anio_nacimiento = ?,
                sexo = ?,
                email = ?,
                nombre_usuario = ?,
                foto_perfil = ?,
                longitud = ?,
                latitud = ?";


    if ($contrasena) {
        $sql .= ", contrasena = ?";
    }

    $sql .= " WHERE id = ?";

    Log::info("SQL: $sql");

    
    $this->database->execute($sql, [
        $nombreCompleto,
        $anioNacimiento,
        $sexo,
        $email,
        $nombreUsuario,
        $fotoPerfil,
        $longitud,
        $latitud,
        ...($contrasena ? [$contrasena] : []),
        $id
    ]);
}

    public function eliminar($id)
    {
        $sql = "DELETE FROM usuario WHERE id = ?";
        Log::info("SQL: $sql [$id]");
        $this->database->execute($sql, [$id]);
    }

    public function validarRegistro($email, $nombreUsuario, $contrasena, $repetirContrasena, $anioNacimiento)
    {
        if (empty($email) || empty($nombreUsuario) || empty($contrasena)) {
            return "Todos los campos obligatorios deben estar completos";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Correo con formato invalido";
        }
        if ($contrasena !== $repetirContrasena) {
            return "Las contraseñas no coinciden";
        }
        if (strlen($contrasena) < 8) {
            return "La contraseña debe tener al menos 8 caracteres.";
        }
        if (!is_numeric($anioNacimiento)) {
            return "El año de nacimiento debe ser un valor numérico.";
        }

        if ($this->existeCampo('nombre_usuario', $nombreUsuario)) {
            return "El nombre de usuario ya se encuentra registrado";
        }
        if ($this->existeCampo('email', $email)) {
            return "El correo electrónico ya se encuentra registrado";
        }
        return true;
    }
    private function existeCampo($columna, $valor): bool
    {
        $sql = "SELECT id FROM usuario WHERE $columna = ?";
        $resultado = $this->database->query($sql, [$valor]);
        return !empty($resultado);
    }

  /*  public function getPartidasActivas($usuarioId)
{
    
    return [
        ["oponente" => "Juan", "resultado" => "4-0"],
        ["oponente" => "María", "resultado" => "3-2"]
    ];
}*/

public function getPuntajeTotal($usuarioId)
{
    $sql = "SELECT SUM(puntaje) AS total 
            FROM partida 
            WHERE idUsuario = ?";
    $filas = $this->database->query($sql, [$usuarioId]);
    return !empty($filas) ? ($filas[0]['total'] ?? 0) : 0;
}



public function guardarPartidaContraBot($usuarioId, $preguntasCorrectas, $puntaje) {
    $sql = "INSERT INTO partida (idUsuario, preguntasCorrectas, puntaje, fecha)
            VALUES (?, ?, ?, NOW())";
    return $this->database->execute($sql, [$usuarioId, $preguntasCorrectas, $puntaje]);
}

public function getHistorial($usuarioId)
{

 $sql = "SELECT preguntasCorrectas, puntaje, fecha
            FROM partida
            WHERE idUsuario = ?
            ORDER BY fecha DESC";

    $filas = $this->database->query($sql, [$usuarioId]);

    $historial = [];
    foreach ($filas as $fila) {
        $historial[] = [
            'oponente'  => 'BOT', // siempre el bot
            'resultado' => $fila['preguntasCorrectas'].' correctas, '.$fila['puntaje'].' pts',
            'fecha'     => $fila['fecha'],
            'foto_oponente' => '/assets/imgPerfiles/bot-preguntados.png'
        ];
    }

    return $historial;
    /*Prueba de como se veria 
    return [
        ["oponente" => "Pedro", "resultado" => "2-4","perdio" => true],
        ["oponente" => "Lucía", "resultado" => "5-1","gano"=>true]
    ];*/
}

}
