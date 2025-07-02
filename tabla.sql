CREATE DATABASE IF NOT EXISTS `grandlux_seguridad` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `grandlux_seguridad`;

CREATE TABLE `hoteles` (
  `id_hotel` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_hotel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_completo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol` enum('administrador','gerente','vista') COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_hotel` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `usuario_unico` (`usuario`),
  KEY `fk_usuario_hotel` (`id_hotel`),
  CONSTRAINT `fk_usuario_hotel` FOREIGN KEY (`id_hotel`) REFERENCES `hoteles` (`id_hotel`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `comunicados` (
  `id_comunicado` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenido` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_publicacion` datetime NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_comunicado`),
  KEY `fk_comunicado_usuario` (`id_usuario`),
  CONSTRAINT `fk_comunicado_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `comentarios` (
  `id_comentario` int(11) NOT NULL AUTO_INCREMENT,
  `id_comunicado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `contenido` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_publicacion` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_comentario`),
  KEY `fk_comentario_comunicado` (`id_comunicado`),
  KEY `fk_comentario_usuario` (`id_usuario`),
  CONSTRAINT `fk_comentario_comunicado` FOREIGN KEY (`id_comunicado`) REFERENCES `comunicados` (`id_comunicado`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_comentario_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `capacitaciones` (
  `id_capacitacion` int(11) NOT NULL AUTO_INCREMENT,
  `id_hotel` int(11) NOT NULL,
  `tema` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instructor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date NOT NULL,
  `participantes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_usuario_carga` int(11) NOT NULL,
  PRIMARY KEY (`id_capacitacion`),
  KEY `fk_capacitacion_hotel` (`id_hotel`),
  KEY `fk_capacitacion_usuario` (`id_usuario_carga`),
  CONSTRAINT `fk_capacitacion_hotel` FOREIGN KEY (`id_hotel`) REFERENCES `hoteles` (`id_hotel`),
  CONSTRAINT `fk_capacitacion_usuario` FOREIGN KEY (`id_usuario_carga`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `documentos_capacitaciones` (
  `id_documento` int(11) NOT NULL AUTO_INCREMENT,
  `id_capacitacion` int(11) NOT NULL,
  `ruta_archivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_documento`),
  KEY `fk_documento_capacitacion` (`id_capacitacion`),
  CONSTRAINT `fk_documento_capacitacion` FOREIGN KEY (`id_capacitacion`) REFERENCES `capacitaciones` (`id_capacitacion`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `equipos` (
  `id_equipo` int(11) NOT NULL AUTO_INCREMENT,
  `id_hotel` int(11) NOT NULL,
  `tipo_equipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marca` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ubicacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `fecha_ultimo_mantenimiento` date DEFAULT NULL,
  `fecha_proximo_mantenimiento` date DEFAULT NULL,
  PRIMARY KEY (`id_equipo`),
  KEY `fk_equipo_hotel` (`id_hotel`),
  CONSTRAINT `fk_equipo_hotel` FOREIGN KEY (`id_hotel`) REFERENCES `hoteles` (`id_hotel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `historial_mantenimiento` (
  `id_historial` INT(11) NOT NULL AUTO_INCREMENT,
  `id_equipo` INT(11) NOT NULL,
  `fecha_mantenimiento` DATE NOT NULL,
  `descripcion` TEXT COLLATE utf8mb4_unicode_ci NULL,
  `ruta_archivo_prueba` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_usuario_carga` INT(11) NOT NULL,
  PRIMARY KEY (`id_historial`),
  KEY `fk_historial_equipo` (`id_equipo`),
  KEY `fk_historial_usuario` (`id_usuario_carga`),
  CONSTRAINT `fk_historial_equipo` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id_equipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_historial_usuario` FOREIGN KEY (`id_usuario_carga`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `accidentes` (
  `id_accidente` int(11) NOT NULL AUTO_INCREMENT,
  `id_hotel` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `tipo_evento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `afectados` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causa` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `medidas_tomadas` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_usuario_carga` int(11) NOT NULL,
  PRIMARY KEY (`id_accidente`),
  KEY `fk_accidente_hotel` (`id_hotel`),
  KEY `fk_accidente_usuario` (`id_usuario_carga`),
  CONSTRAINT `fk_accidente_hotel` FOREIGN KEY (`id_hotel`) REFERENCES `hoteles` (`id_hotel`),
  CONSTRAINT `fk_accidente_usuario` FOREIGN KEY (`id_usuario_carga`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `documentos_accidentes` (
  `id_documento` int(11) NOT NULL AUTO_INCREMENT,
  `id_accidente` int(11) NOT NULL,
  `ruta_archivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_documento`),
  KEY `fk_documento_accidente` (`id_accidente`),
  CONSTRAINT `fk_documento_accidente` FOREIGN KEY (`id_accidente`) REFERENCES `accidentes` (`id_accidente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `bitacora_actividades` (
  `id_bitacora` INT(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` INT(11) NOT NULL,
  `accion` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` TEXT COLLATE utf8mb4_unicode_ci,
  `fecha_hora` DATETIME NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_bitacora`),
  KEY `fk_bitacora_usuario` (`id_usuario`),
  CONSTRAINT `fk_bitacora_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `hoteles` (`id_hotel`, `nombre`, `activo`) VALUES (1, 'The Grand Hotel', 1), (2, 'Iguazú Grand', 1), (3, 'Panoramic Grand', 1), (4, 'Recoleta Grand', 1);
INSERT INTO `usuarios` (`usuario`, `password`, `nombre_completo`, `rol`, `id_hotel`) VALUES
('Ernesto', '$2y$10$TjL5Y.iN2.B3V.cR6.sNje2x4qgJ2/n1GzF.Z.d5gKz.E5hJ9.hOq', 'Ernesto Álvarez', 'administrador', NULL),
('panoramic123', '$2y$10$T8Z.V9Q3Q.eR8c.iB2.PGe4c.kL9w.oN7.yL3.nS6e.X7i.V5Gz.a', 'Gerente Panoramic', 'gerente', 3),
('iguazu123', '$2y$10$E9O.F8V.L7.sW6.aB1.gHe3r.hP2.eN5.zT1.oR4o.C9j.L2n.mY.', 'Gerente Iguazú', 'gerente', 2),
('recoleta123', '$2y$10$A.wS1.yL2.oB3.dG5.iJ9.nF6.eG7.hK8.zP5.jS2.lM4.iN1o.pC', 'Gerente Recoleta', 'gerente', 4);
