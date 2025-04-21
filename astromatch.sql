CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    edad INT GENERATED ALWAYS AS (TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE())) STORED,
    genero ENUM('Masculino', 'Femenino') NOT NULL,

    signo_solar VARCHAR(20) DEFAULT NULL,
    signo_lunar VARCHAR(20) DEFAULT NULL,
    signo_ascendente VARCHAR(20) DEFAULT NULL,

    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    ultima_actividad DATETIME NULL DEFAULT NULL,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    foto_perfil VARCHAR(255) DEFAULT NULL,
    descripcion TEXT DEFAULT NULL,

    ip_registro VARCHAR(45) DEFAULT NULL,
    pais VARCHAR(100) DEFAULT NULL,
    ciudad VARCHAR(100) DEFAULT NULL,
    latitud DECIMAL(10,8) DEFAULT NULL,
    longitud DECIMAL(11,8) DEFAULT NULL,
    ubicacion_manual VARCHAR(255) DEFAULT NULL,

    trabaja BOOLEAN DEFAULT NULL,

    estudia BOOLEAN DEFAULT NULL,
    institucion VARCHAR(100) DEFAULT NULL,

    motivo ENUM('Amistad', 'Relación Seria', 'Casual') DEFAULT NULL,

    altura DECIMAL(4,2) DEFAULT NULL,
    hijos BOOLEAN DEFAULT NULL,
    bebe ENUM('Nunca', 'Ocasionalmente', 'Frecuentemente') DEFAULT NULL,
    fuma ENUM('No', 'Ocasionalmente', 'Frecuentemente') DEFAULT NULL,

    idiomas TEXT DEFAULT NULL, 
    mascotas TEXT DEFAULT NULL,

    relacion_actual ENUM('Soltero', 'Casado', 'Divorciado', 'Viudo', 'En una relación', 'Abierta') DEFAULT NULL,
    sexualidad ENUM('Heterosexual', 'Homosexual') DEFAULT NULL,
    religion VARCHAR(50) DEFAULT NULL,
    personalidad ENUM('Introvertido', 'Extrovertido', 'Intermedio') DEFAULT NULL,
    nivel_educativo ENUM('Primaria', 'Secundaria', 'Universitario', 'Postgrado') DEFAULT NULL,

    tipo_relacion ENUM('Casual', 'Seria', 'Amistad') DEFAULT NULL,
    aceptar_hijos BOOLEAN DEFAULT NULL,
    dispuesto_mudarse BOOLEAN DEFAULT NULL,
    citas_virtuales BOOLEAN DEFAULT NULL,

    tipo_cuerpo ENUM('Delgado', 'Atlético', 'Normal', 'Robusto') DEFAULT NULL,
    alimentacion ENUM('Omnívoro', 'Vegetariano', 'Vegano') DEFAULT NULL,
    actividad_fisica ENUM('Sedentario', 'Activo', 'Deportista') DEFAULT NULL,

    valores TEXT DEFAULT NULL,
    ingresos ENUM('Bajo', 'Medio', 'Alto') DEFAULT NULL,
    compartir_gastos BOOLEAN DEFAULT NULL,

    musica_favorita TEXT DEFAULT NULL,
    entretenimiento TEXT DEFAULT NULL,
    estilo_comunicacion ENUM('Mensajes cortos', 'Mensajes largos', 'Llamadas') DEFAULT NULL,

    estado_cuenta ENUM('Activo', 'Suspendido', 'Eliminado') DEFAULT 'Activo'
);
