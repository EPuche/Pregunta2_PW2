CREATE DATABASE IF NOT EXISTS preguntados_bd;
USE preguntados_bd;
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-06-2026 a las 22:05:06
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `preguntados_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
                             `id` int(11) NOT NULL,
                             `nombre` varchar(50) NOT NULL,
                             `color` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`, `color`) VALUES
                                                      (1, 'Arte', '#ADD8E6'),
                                                      (2, 'Ciencia', '#C1E1C1'),
                                                      (3, 'Historia', '#FFFACD'),
                                                      (4, 'Deporte', '#FF9232'),
                                                      (5, 'Entretenimiento', '#FFB6B2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opcion`
--

CREATE TABLE `opcion` (
                          `id` int(11) NOT NULL,
                          `pregunta_id` int(11) NOT NULL,
                          `contenido` varchar(255) NOT NULL,
                          `es_correcta` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `opcion`
--

INSERT INTO `opcion` (`id`, `pregunta_id`, `contenido`, `es_correcta`) VALUES
                                                                           (1, 1, 'Leonardo da Vinci', 0),
                                                                           (2, 1, 'Vincent van Gogh', 1),
                                                                           (3, 1, 'Pablo Picasso', 0),
                                                                           (4, 1, 'Claude Monet', 0),
                                                                           (5, 2, 'Museo de Orsay', 0),
                                                                           (6, 2, 'Museo del Prado', 0),
                                                                           (7, 2, 'Museo del Louvre', 1),
                                                                           (8, 2, 'Centro Pompidou', 0),
                                                                           (9, 3, 'Salvador Dalí', 1),
                                                                           (10, 3, 'Michelangelo', 0),
                                                                           (11, 3, 'Diego Velázquez', 0),
                                                                           (12, 3, 'Andy Warhol', 0),
                                                                           (13, 4, 'Donatello', 0),
                                                                           (14, 4, 'Gian Lorenzo Bernini', 0),
                                                                           (15, 4, 'Auguste Rodin', 0),
                                                                           (16, 4, 'Miguel Ángel', 1),
                                                                           (17, 5, 'Impresionismo', 0),
                                                                           (18, 5, 'Cubismo', 1),
                                                                           (19, 5, 'Expresionismo', 0),
                                                                           (20, 5, 'Futurismo', 0),
                                                                           (21, 6, 'Venus', 0),
                                                                           (22, 6, 'Marte', 0),
                                                                           (23, 6, 'Mercurio', 1),
                                                                           (24, 6, 'Júpiter', 0),
                                                                           (25, 7, 'Oxígeno', 0),
                                                                           (26, 7, 'Nitrógeno', 1),
                                                                           (27, 7, 'Dióxido de carbono', 0),
                                                                           (28, 7, 'Argón', 0),
                                                                           (29, 8, 'Or', 0),
                                                                           (30, 8, 'Fe', 0),
                                                                           (31, 8, 'Ag', 0),
                                                                           (32, 8, 'Au', 1),
                                                                           (33, 9, 'El corazón', 0),
                                                                           (34, 9, 'El cerebro', 1),
                                                                           (35, 9, 'El hígado', 0),
                                                                           (36, 9, 'Los pulmones', 0),
                                                                           (37, 10, 'Fuerza magnética', 0),
                                                                           (38, 10, 'Fuerza de fricción', 0),
                                                                           (39, 10, 'Fuerza de gravedad', 1),
                                                                           (40, 10, 'Fuerza centrífuga', 0),
                                                                           (41, 11, '1492', 1),
                                                                           (42, 11, '1588', 0),
                                                                           (43, 11, '1345', 0),
                                                                           (44, 11, '1501', 0),
                                                                           (45, 12, 'Abraham Lincoln', 0),
                                                                           (46, 12, 'Thomas Jefferson', 0),
                                                                           (47, 12, 'George Washington', 1),
                                                                           (48, 12, 'Benjamin Franklin', 0),
                                                                           (49, 13, 'Los Mayas', 0),
                                                                           (50, 13, 'Los Egipcios', 1),
                                                                           (51, 13, 'Los Romanos', 0),
                                                                           (52, 13, 'Los Griegos', 0),
                                                                           (53, 14, 'La caída de Constantinopla', 1),
                                                                           (54, 14, 'El descubrimiento de América', 0),
                                                                           (55, 14, 'La Revolución Francesa', 0),
                                                                           (56, 14, 'La coronación de Carlomagno', 0),
                                                                           (57, 15, 'Imperio Otomano', 0),
                                                                           (58, 15, 'Imperio Romano', 1),
                                                                           (59, 15, 'Imperio Bizantino', 0),
                                                                           (60, 15, 'Imperio Carolingio', 0),
                                                                           (61, 16, 'Cada 2 años', 0),
                                                                           (62, 16, 'Cada 4 años', 1),
                                                                           (63, 16, 'Cada 5 años', 0),
                                                                           (64, 16, 'Cada 6 años', 0),
                                                                           (65, 17, 'Miroslav Klose', 1),
                                                                           (66, 17, 'Pelé', 0),
                                                                           (67, 17, 'Lionel Messi', 0),
                                                                           (68, 17, 'Ronaldo Nazário', 0),
                                                                           (69, 18, 'Bádminton', 0),
                                                                           (70, 18, 'Golf', 0),
                                                                           (71, 18, 'Tenis', 1),
                                                                           (72, 18, 'Paddle', 0),
                                                                           (73, 19, 'China', 0),
                                                                           (74, 19, 'Corea del Sur', 0),
                                                                           (75, 19, 'Tailandia', 0),
                                                                           (76, 19, 'Japón', 1),
                                                                           (77, 20, 'Roger Federer', 0),
                                                                           (78, 20, 'Novak Djokovic', 0),
                                                                           (79, 20, 'Rafael Nadal', 1),
                                                                           (80, 20, 'Björn Borg', 0),
                                                                           (81, 21, 'Arendelle', 1),
                                                                           (82, 21, 'Narnia', 0),
                                                                           (83, 21, 'Genovia', 0),
                                                                           (84, 21, 'Atlántica', 0),
                                                                           (85, 22, 'The Witcher', 0),
                                                                           (86, 22, 'Breaking Bad', 0),
                                                                           (87, 22, 'Game of Thrones', 1),
                                                                           (88, 22, 'El Señor de los Anillos', 0),
                                                                           (89, 23, 'The Beatles', 0),
                                                                           (90, 23, 'Pink Floyd', 0),
                                                                           (91, 23, 'Led Zeppelin', 0),
                                                                           (92, 23, 'Queen', 1),
                                                                           (93, 24, 'Brad Pitt', 0),
                                                                           (94, 24, 'Tom Cruise', 1),
                                                                           (95, 24, 'Keanu Reeves', 0),
                                                                           (96, 24, 'Matt Damon', 0),
                                                                           (97, 25, 'Luigi', 0),
                                                                           (98, 25, 'Link', 0),
                                                                           (99, 25, 'Mario', 1),
                                                                           (100, 25, 'Sonic', 0),
                                                                           (101, 26, 'Johannes Vermeer', 0),
                                                                           (102, 26, 'Rembrandt van Rijn', 1),
                                                                           (103, 26, 'Hieronymus Bosch', 0),
                                                                           (104, 26, 'Frans Hals', 0),
                                                                           (105, 27, 'Abstraccionismo', 1),
                                                                           (106, 27, 'Realismo', 0),
                                                                           (107, 27, 'Fauvismo', 0),
                                                                           (108, 27, 'Dadaísmo', 0),
                                                                           (109, 28, 'Filippo Brunelleschi', 1),
                                                                           (110, 28, 'Donato Bramante', 0),
                                                                           (111, 28, 'Andrea Palladio', 0),
                                                                           (112, 28, 'Leon Battista Alberti', 0),
                                                                           (113, 29, 'Siglo XVII', 0),
                                                                           (114, 29, 'Siglo XVIII', 0),
                                                                           (115, 29, 'Siglo XIX y XX', 1),
                                                                           (116, 29, 'Siglo XVI', 0),
                                                                           (117, 30, 'Domenikos Theotokopoulos', 1),
                                                                           (118, 30, 'Alejandro de Atenas', 0),
                                                                           (119, 30, 'Giorgios Papandreu', 0),
                                                                           (120, 30, 'Antonio Vassilacchi', 0),
                                                                           (121, 31, 'Neutrino', 0),
                                                                           (122, 31, 'Fotón', 0),
                                                                           (123, 31, 'Bosón de Higgs', 1),
                                                                           (124, 31, 'Quark arriba', 0),
                                                                           (125, 32, 'Galo', 0),
                                                                           (126, 32, 'Mercurio', 1),
                                                                           (127, 32, 'Cesio', 0),
                                                                           (128, 32, 'Francio', 0),
                                                                           (129, 33, 'Ácido sulfúrico', 0),
                                                                           (130, 33, 'Ácido nítrico', 0),
                                                                           (131, 33, 'Ácido clorhídrico', 1),
                                                                           (132, 33, 'Ácido acético', 0),
                                                                           (133, 34, 'Meiosis', 0),
                                                                           (134, 34, 'Mitosis', 1),
                                                                           (135, 34, 'Fisión binaria', 0),
                                                                           (136, 34, 'Esporulación', 0),
                                                                           (137, 35, 'Alrededor de 1 minuto', 0),
                                                                           (138, 35, 'Alrededor de 8 minutos', 1),
                                                                           (139, 35, 'Alrededor de 15 minutos', 0),
                                                                           (140, 35, 'Es instantáneo', 0),
                                                                           (141, 36, 'Tratado de Utrecht', 0),
                                                                           (142, 36, 'Paz de Westfalia', 1),
                                                                           (143, 36, 'Tratado de Versalles', 0),
                                                                           (144, 36, 'Paz de Augsburgo', 0),
                                                                           (145, 37, 'Alejandro III', 0),
                                                                           (146, 37, 'Pedro el Grande', 0),
                                                                           (147, 37, 'Nicolás II', 1),
                                                                           (148, 37, 'Iván el Terrible', 0),
                                                                           (149, 38, '1789', 0),
                                                                           (150, 38, '1805', 0),
                                                                           (151, 38, '1812', 0),
                                                                           (152, 38, '1815', 1),
                                                                           (153, 39, 'Código de Hammurabi', 1),
                                                                           (154, 39, 'Código de Manú', 0),
                                                                           (155, 39, 'Ley de las Doce Tablas', 0),
                                                                           (156, 39, 'Código Justiniano', 0),
                                                                           (157, 40, 'Nerón', 0),
                                                                           (158, 40, 'Calígula', 0),
                                                                           (159, 40, 'Constantino el Grande', 1),
                                                                           (160, 40, 'Julio César', 0),
                                                                           (161, 41, 'Eddy Merckx', 1),
                                                                           (162, 41, 'Bernard Hinault', 0),
                                                                           (163, 41, 'Jacques Anquetil', 0),
                                                                           (164, 41, 'Miguel Induráin', 0),
                                                                           (165, 42, 'Argentina', 0),
                                                                           (166, 42, 'Brasil', 0),
                                                                           (167, 42, 'Uruguay', 1),
                                                                           (168, 42, 'Italia', 0),
                                                                           (169, 43, 'Toronto', 0),
                                                                           (170, 43, 'Vancouver', 0),
                                                                           (171, 43, 'Calgary', 0),
                                                                           (172, 43, 'Montreal', 1),
                                                                           (173, 44, '40 kilómetros', 0),
                                                                           (174, 44, '42,195 kilómetros', 1),
                                                                           (175, 44, '45 kilómetros', 0),
                                                                           (176, 44, '38,500 kilómetros', 0),
                                                                           (177, 45, 'Lewis Hamilton', 0),
                                                                           (178, 45, 'Ayrton Senna', 0),
                                                                           (179, 45, 'Michael Schumacher', 1),
                                                                           (180, 45, 'Juan Manuel Fangio', 0),
                                                                           (181, 46, 'Stanley Kubrick', 0),
                                                                           (182, 46, 'Alfred Hitchcock', 1),
                                                                           (183, 46, 'Orson Welles', 0),
                                                                           (184, 46, 'Ridley Scott', 0),
                                                                           (185, 47, 'Pinocho', 0),
                                                                           (186, 47, 'Fantasía', 0),
                                                                           (187, 47, 'Blancanieves y los siete enanitos', 1),
                                                                           (188, 47, 'Dumbo', 0),
                                                                           (189, 48, 'Robert De Niro', 0),
                                                                           (190, 48, 'Al Pacino', 1),
                                                                           (191, 48, 'Marlon Brando', 0),
                                                                           (192, 48, 'Jack Nicholson', 0),
                                                                           (193, 49, 'Un mundo feliz', 0),
                                                                           (194, 49, 'Fahrenheit 451', 0),
                                                                           (195, 49, '1984', 1),
                                                                           (196, 49, 'Rebelión en la granja', 0),
                                                                           (197, 50, 'Hans Zimmer', 0),
                                                                           (198, 50, 'Ennio Morricone', 0),
                                                                           (199, 50, 'John Williams', 1),
                                                                           (200, 50, 'Danny Elfman', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
                            `id` int(11) NOT NULL,
                            `categoria_id` int(11) NOT NULL,
                            `contenido` text NOT NULL,
                            `imagen_url` varchar(255) DEFAULT NULL,
                            `estado` enum('sugerida','aprobada','reportada','eliminada') DEFAULT 'aprobada',
                            `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`id`, `categoria_id`, `contenido`, `imagen_url`, `estado`, `fecha_creacion`) VALUES
                                                                                                         (1, 1, '¿Quién pintó la famosa obra \"La noche estrellada\"?', NULL, 'aprobada', '2026-06-01 20:02:28'),
                                                                                                         (2, 1, '¿En qué museo de París se encuentra la pintura de la Mona Lisa?', NULL, 'aprobada', '2026-06-01 20:02:28'),
                                                                                                         (3, 1, '¿Cuál de estos artistas es conocido como uno de los máximos exponentes del Surrealismo?', NULL, 'aprobada', '2026-06-01 20:02:28'),
                                                                                                         (4, 1, '¿Qué famoso escultor italiano esculpió la estatua del \"David\"?', NULL, 'aprobada', '2026-06-01 20:02:28'),
                                                                                                         (5, 1, '¿Qué movimiento artístico se caracteriza por el uso de formas geométricas y fue coliderado por Picasso?', NULL, 'aprobada', '2026-06-01 20:02:28'),
                                                                                                         (6, 2, '¿Cuál es el planeta más cercano al Sol en nuestro sistema solar?', NULL, 'aprobada', '2026-06-01 20:02:28'),
                                                                                                         (7, 2, '¿Qué gas representa aproximadamente el 78% de la atmósfera terrestre?', NULL, 'aprobada', '2026-06-01 20:02:28'),
                                                                                                         (8, 2, '¿Cuál es el símbolo químico del oro en la tabla periódica?', NULL, 'aprobada', '2026-06-01 20:02:28'),
                                                                                                         (9, 2, '¿Qué órgano del cuerpo humano consume la mayor cantidad de energía?', NULL, 'aprobada', '2026-06-01 20:02:29'),
                                                                                                         (10, 2, '¿Cómo se llama la fuerza que atrae a los objetos hacia el centro de la Tierra?', NULL, 'aprobada', '2026-06-01 20:02:29'),
                                                                                                         (11, 3, '¿En qué año llegó Cristóbal Colón al continente americano?', NULL, 'aprobada', '2026-06-01 20:02:29'),
                                                                                                         (12, 3, '¿Quién fue el primer presidente de los Estados Unidos?', NULL, 'aprobada', '2026-06-01 20:02:29'),
                                                                                                         (13, 3, '¿Qué antigua civilización construyó las pirámides de Guiza?', NULL, 'aprobada', '2026-06-01 20:02:29'),
                                                                                                         (14, 3, '¿Qué hito histórico marcó el fin de la Edad Media en 1453?', NULL, 'aprobada', '2026-06-01 20:02:29'),
                                                                                                         (15, 3, '¿Qué Imperio estuvo gobernado por Julio César y se extendió por gran parte de Europa y el Mediterráneo?', NULL, 'aprobada', '2026-06-01 20:02:29'),
                                                                                                         (16, 4, '¿Cada cuántos años se celebran los Juegos Olímpicos de Verano?', NULL, 'aprobada', '2026-06-01 20:02:29'),
                                                                                                         (17, 4, '¿Quién es considerado el máximo goleador histórico de los mundiales de fútbol masculino?', NULL, 'aprobada', '2026-06-01 20:02:29'),
                                                                                                         (18, 4, '¿En qué deporte se utiliza una raqueta y se puede jugar en una superficie de césped, polvo de ladrillo o cemento?', NULL, 'aprobada', '2026-06-01 20:02:29'),
                                                                                                         (19, 4, '¿Qué país es famoso por originar el arte marcial del Sumo?', NULL, 'aprobada', '2026-06-01 20:02:29'),
                                                                                                         (20, 4, '¿Qué tenista masculino ha ganado la mayor cantidad de títulos de Roland Garros en la historia?', NULL, 'aprobada', '2026-06-01 20:02:29'),
                                                                                                         (21, 5, '¿Cómo se llama el reino congelado donde se desarrolla la película de Disney \"Frozen\"?', NULL, 'aprobada', '2026-06-01 20:02:29'),
                                                                                                         (22, 5, '¿Cuál es la serie de televisión de drama fantástico basada en los libros de George R.R. Martin?', NULL, 'aprobada', '2026-06-01 20:02:29'),
                                                                                                         (23, 5, '¿Qué banda británica de rock lideró Freddie Mercury?', NULL, 'aprobada', '2026-06-01 20:02:29'),
                                                                                                         (24, 5, '¿Qué actor protagoniza la saga de películas de acción \"Misión Imposible\"?', NULL, 'aprobada', '2026-06-01 20:02:29'),
                                                                                                         (25, 5, '¿Cómo se llama el fontanero de traje rojo y gorra que es el personaje principal de Nintendo?', NULL, 'aprobada', '2026-06-01 20:02:29'),
                                                                                                         (26, 1, '¿Cuál de los siguientes pintores holandeses es famoso por su obra \"La ronda de noche\"?', NULL, 'aprobada', '2026-06-01 20:03:32'),
                                                                                                         (27, 1, '¿A qué movimiento artístico de principios del siglo XX perteneció el pintor húngaro Wassily Kandinsky?', NULL, 'aprobada', '2026-06-01 20:03:32'),
                                                                                                         (28, 1, '¿Qué arquitecto renacentista diseñó la famosa cúpula de la Catedral de Santa María del Fiore en Florencia?', NULL, 'aprobada', '2026-06-01 20:03:32'),
                                                                                                         (29, 1, '¿En qué siglo vivió y pintó el artista expresionista Edvard Munch, autor de \"El grito\"?', NULL, 'aprobada', '2026-06-01 20:03:32'),
                                                                                                         (30, 1, '¿Cuál era el verdadero nombre del pintor griego afincado en España conocido como \"El Greco\"?', NULL, 'aprobada', '2026-06-01 20:03:32'),
                                                                                                         (31, 2, '¿Qué partícula subatómica, cuya existencia fue confirmada en 2012, es responsable de otorgar masa a las demás partículas?', NULL, 'aprobada', '2026-06-01 20:03:32'),
                                                                                                         (32, 2, '¿Cuál es el único metal que se encuentra en estado líquido a temperatura ambiente (20°C)?', NULL, 'aprobada', '2026-06-01 20:03:33'),
                                                                                                         (33, 2, '¿Qué tipo de ácido se encuentra de forma predominante y natural en el estómago humano para ayudar a la digestión?', NULL, 'aprobada', '2026-06-01 20:03:33'),
                                                                                                         (34, 2, '¿Cómo se denomina al proceso biológico por el cual una célula se divide dando origen a dos células hijas genéticamente idénticas?', NULL, 'aprobada', '2026-06-01 20:03:33'),
                                                                                                         (35, 2, '¿Aproximadamente cuántos minutos tarda la luz del Sol en llegar a la superficie de la Tierra?', NULL, 'aprobada', '2026-06-01 20:03:33'),
                                                                                                         (36, 3, '¿Qué tratado de paz, firmado en 1648, puso fin a la Guerra de los Treinta Años en Europa?', NULL, 'aprobada', '2026-06-01 20:03:33'),
                                                                                                         (37, 3, '¿Quién fue el último zar de la Rusia Imperial antes de la Revolución Bolchevique de 1917?', NULL, 'aprobada', '2026-06-01 20:03:33'),
                                                                                                         (38, 3, '¿En qué año se produjo la famosa Batalla de Waterloo, que marcó la derrota definitiva de Napoleón Bonaparte?', NULL, 'aprobada', '2026-06-01 20:03:33'),
                                                                                                         (39, 3, '¿Qué código de leyes unificado, creado en la antigua Mesopotamia, es famoso por aplicar la ley del talión (\"ojo por ojo\")?', NULL, 'aprobada', '2026-06-01 20:03:33'),
                                                                                                         (40, 3, '¿Qué emperador romano legalizó el cristianismo en el Imperio mediante el Edicto de Milán en el año 313 d.C.?', NULL, 'aprobada', '2026-06-01 20:03:33'),
                                                                                                         (41, 4, '¿Qué ciclista belga, apodado \"El Caníbal\", es considerado históricamente el más grande ciclista de todos los tiempos por ganar 5 Tours de Francia?', NULL, 'aprobada', '2026-06-01 20:03:33'),
                                                                                                         (42, 4, '¿Qué selección nacional de fútbol ganó la primera Copa Mundial de la FIFA celebrada en el año 1930?', NULL, 'aprobada', '2026-06-01 20:03:33'),
                                                                                                         (43, 4, '¿En qué ciudad canadiense se celebraron los Juegos Olímpicos de Verano de 1976, famosos por el puntaje perfecto de Nadia Comăneci?', NULL, 'aprobada', '2026-06-01 20:03:33'),
                                                                                                         (44, 4, '¿Cuál es la distancia exacta de una carrera de maratón oficial en el atletismo moderno?', NULL, 'aprobada', '2026-06-01 20:03:33'),
                                                                                                         (45, 4, '¿Qué piloto de Fórmula 1 ostenta el récord histórico de haber ganado la mayor cantidad de campeonatos mundiales de manera consecutiva (5 títulos seguidos)?', NULL, 'aprobada', '2026-06-01 20:03:33'),
                                                                                                         (46, 5, '¿Qué director de cine británico dirigió las clásicas películas de suspenso \"Psicosis\" (1960) y \"Los pájaros\" (1963)?', NULL, 'aprobada', '2026-06-01 20:03:33'),
                                                                                                         (47, 5, '¿Cuál fue el primer largometraje animado de la historia del cine lanzado por Walt Disney en 1937?', NULL, 'aprobada', '2026-06-01 20:03:33'),
                                                                                                         (48, 5, '¿Qué actor interpretó al icónico personaje de Michael Corleone en la trilogía cinematográfica de \"El Padrino\"?', NULL, 'aprobada', '2026-06-01 20:03:33'),
                                                                                                         (49, 5, '¿Qué novela distópica del escritor George Orwell introdujo por primera vez el concepto del \"Gran Hermano\" (Big Brother)?', NULL, 'aprobada', '2026-06-01 20:03:33'),
                                                                                                         (50, 5, '¿Quién compuso la icónica banda sonora de películas como \"Star Wars\", \"Tiburón\", \"Indiana Jones\" y \"Harry Potter\"?', NULL, 'aprobada', '2026-06-01 20:03:33');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `opcion`
--
ALTER TABLE `opcion`
    ADD PRIMARY KEY (`id`),
    ADD KEY `pregunta_id` (`pregunta_id`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
    ADD PRIMARY KEY (`id`),
    ADD KEY `categoria_id` (`categoria_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `opcion`
--
ALTER TABLE `opcion`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `opcion`
--
ALTER TABLE `opcion`
    ADD CONSTRAINT `opcion_ibfk_1` FOREIGN KEY (`pregunta_id`) REFERENCES `pregunta` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
    ADD CONSTRAINT `pregunta_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
