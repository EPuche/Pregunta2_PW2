-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-07-2026 a las 00:38:46
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
-- Estructura de tabla para la tabla `partida`
--

CREATE TABLE `partida` (
  `idPartida` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `preguntasCorrectas` int(11) NOT NULL DEFAULT 0,
  `puntaje` int(11) NOT NULL DEFAULT 0,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `partida`
--

INSERT INTO `partida` (`idPartida`, `idUsuario`, `preguntasCorrectas`, `puntaje`, `fecha`) VALUES
(3, 2, 0, 0, '2026-06-25 22:08:31'),
(4, 2, 1, 1, '2026-06-25 22:14:21'),
(5, 2, 0, 0, '2026-06-25 22:23:47'),
(6, 2, 2, 2, '2026-06-25 22:24:06'),
(9, 3, 0, 0, '2026-06-25 23:26:50'),
(10, 3, 4, 4, '2026-06-25 23:27:20'),
(11, 3, 2, 2, '2026-06-26 14:19:00'),
(12, 3, 0, 0, '2026-06-26 14:23:54'),
(13, 3, 0, 0, '2026-06-26 19:01:08'),
(14, 3, 0, 0, '2026-06-26 19:01:29'),
(15, 4, 0, 0, '2026-06-26 22:34:45'),
(16, 4, 0, 0, '2026-06-26 22:35:21'),
(17, 4, 0, 0, '2026-06-26 22:37:21'),
(18, 3, 2, 2, '2026-06-26 22:53:28'),
(19, 2, 1, 1, '2026-06-26 22:54:27'),
(20, 4, 0, 0, '2026-06-29 16:20:17'),
(21, 4, 2, 2, '2026-06-29 16:20:40'),
(22, 3, 0, 0, '2026-06-29 19:11:06'),
(23, 4, 0, 0, '2026-06-29 22:11:58'),
(24, 4, 0, 0, '2026-06-29 22:36:03'),
(25, 4, 0, 0, '2026-06-29 22:36:26'),
(26, 4, 0, 0, '2026-06-29 22:40:59'),
(27, 4, 0, 0, '2026-06-29 22:43:22'),
(28, 4, 0, 0, '2026-06-29 22:48:33'),
(29, 4, 0, 0, '2026-06-29 22:49:56'),
(30, 4, 0, 0, '2026-06-29 22:49:57'),
(31, 4, 0, 0, '2026-06-29 22:51:30'),
(32, 5, 0, 0, '2026-06-29 23:24:44'),
(33, 5, 0, 0, '2026-07-02 14:57:51'),
(34, 5, 0, 0, '2026-07-02 15:11:42'),
(35, 5, 0, 0, '2026-07-06 16:31:52'),
(36, 5, 0, 0, '2026-07-06 16:42:09'),
(37, 5, 0, 0, '2026-07-06 19:18:20'),
(38, 5, 0, 0, '2026-07-06 19:18:23'),
(39, 5, 0, 0, '2026-07-06 19:22:08'),
(40, 5, 0, 0, '2026-07-06 21:04:11'),
(41, 4, 0, 0, '2026-07-09 15:06:37'),
(42, 4, 0, 0, '2026-07-09 15:14:39'),
(43, 4, 0, 0, '2026-07-09 15:17:46'),
(44, 4, 0, 0, '2026-07-09 15:18:20'),
(45, 4, 0, 0, '2026-07-09 15:18:33'),
(46, 4, 0, 0, '2026-07-09 15:27:38'),
(47, 4, 0, 0, '2026-07-09 15:27:40'),
(48, 4, 0, 0, '2026-07-09 16:23:42'),
(49, 4, 0, 0, '2026-07-09 19:13:22'),
(50, 4, 0, 0, '2026-07-09 19:13:44'),
(51, 4, 0, 0, '2026-07-09 19:38:28'),
(52, 4, 0, 0, '2026-07-09 22:52:59'),
(53, 4, 0, 0, '2026-07-10 20:11:14'),
(54, 4, 0, 0, '2026-07-10 20:22:14'),
(55, 4, 0, 0, '2026-07-10 22:14:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `imagen_url` varchar(255) DEFAULT NULL,
  `estado` enum('aprobada','pendiente','reportada','rechazada','eliminada') NOT NULL DEFAULT 'aprobada',
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
(25, 5, '¿Cómo se llama el fontanero de traje rojo y gorra que es el personaje principal de Nintendo?', NULL, 'reportada', '2026-06-01 20:02:29'),
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
(37, 3, '¿Quién fue el último zar de la Rusia Imperial antes de la Revolución Bolchevique de 1917?', NULL, 'reportada', '2026-06-01 20:03:33'),
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

CREATE TABLE `reporte` (
  `id` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `motivo` text NOT NULL,
  `fecha_reporte` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reporte`
--

INSERT INTO `reporte` (`id`, `id_pregunta`, `motivo`, `fecha_reporte`) VALUES
(1, 37, 'nal', '2026-07-06 21:04:23'),
(2, 25, 'MUY FEA', '2026-07-09 15:06:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `anio_nacimiento` year(4) NOT NULL,
  `sexo` enum('Masculino','Femenino','Otro') NOT NULL,
  `email` varchar(255) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `longitud` decimal(10,7) DEFAULT NULL,
  `latitud` decimal(10,7) DEFAULT NULL,
  `token_verificacion` varchar(64) DEFAULT NULL,
  `verificado` tinyint(1) NOT NULL DEFAULT 0,
  `puntaje` int(11) NOT NULL DEFAULT 0,
  `rol` enum('jugador','editor','admin') NOT NULL DEFAULT 'jugador',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `pais` varchar(100) DEFAULT NULL,
  `trampitas` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre_completo`, `anio_nacimiento`, `sexo`, `email`, `nombre_usuario`, `contrasena`, `foto_perfil`, `longitud`, `latitud`, `token_verificacion`, `verificado`, `puntaje`, `rol`, `fecha_registro`, `pais`, `trampitas`) VALUES
(2, 'Esteban', '2000', 'Masculino', 'esteban_alejo12@hotmail.com', 'epuche', '$2y$10$4olqYXk1DTNo/kgdL1sG.exx9lwBOUkgQDYQ0i2sKzKt2MeuYtfi2', '/assets/imgPerfiles/epuche_1782425268.jpg', -58.3816000, -34.6037000, NULL, 1, 4, 'admin', '2026-07-08 15:42:48', 'Argentina', 0),
(3, 'Cecilia Fernández ', '1992', 'Femenino', 'cefernandez92@gmail.com', 'Ceci', '$2y$10$W27p2d4udtbw0waTvfD5N.dLwTFdpSYrXQ3hIAjkEXwgqgXC.COe.', '/assets/imgPerfiles/Ceci_1782430261.jpg', -58.4126707, -34.6176318, NULL, 1, 8, 'jugador', '2026-07-08 15:42:48', 'Argentina', 0),
(4, 'Valentinita', '2003', 'Femenino', 'valenvdz7@gmail.com', 'valentinita123', '$2y$10$1NtF295XNJCcL22Z0LQXXemgFJMYGhM2iXOdXE3sWadoG2.BmbFmS', '/assets/imgPerfiles/valentinita123_1782513239.jpg', -58.3672337, -34.5674943, NULL, 1, 2, 'jugador', '2026-07-08 15:42:48', 'Argentina', 19),
(5, 'Candela Roger', '2006', 'Femenino', 'rogercandela58@gmail.com', 'Can07', '$2y$10$f1nihMY/oIQ.NKfEWCIhS.9wxErm5tUD396rZK1iKqt46DJa0hXoW', NULL, -58.3816000, -34.6037000, NULL, 1, 0, 'editor', '2026-07-08 15:42:48', 'Argentina', 0),
(6, 'Valentinita', '2003', 'Femenino', 'valen7@gmail.com', 'valentinita1234', '$2y$10$1NtF295XNJCcL22Z0LQXXemgFJMYGhM2iXOdXE3sWadoG2.BmbFmS', '/assets/imgPerfiles/valentinita123_1782513239.jpg', -58.3672337, -34.5674943, NULL, 1, 0, 'editor', '2026-07-08 15:42:49', 'Argentina', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_pregunta`
--

CREATE TABLE `usuario_pregunta` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `pregunta_id` int(11) NOT NULL,
  `respondida_correctamente` tinyint(1) NOT NULL DEFAULT 0,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_pregunta`
--

INSERT INTO `usuario_pregunta` (`id`, `usuario_id`, `pregunta_id`, `respondida_correctamente`, `fecha`) VALUES
(1, 2, 45, 0, '2026-07-08 15:42:48'),
(2, 2, 48, 1, '2026-07-08 15:42:48'),
(3, 2, 39, 0, '2026-07-08 15:42:48'),
(4, 2, 43, 0, '2026-07-08 15:42:48'),
(5, 2, 3, 1, '2026-07-08 15:42:48'),
(6, 2, 24, 1, '2026-07-08 15:42:48'),
(7, 2, 35, 0, '2026-07-08 15:42:48'),
(8, 3, 36, 0, '2026-07-08 15:42:48'),
(9, 3, 2, 1, '2026-07-08 15:42:48'),
(10, 3, 15, 1, '2026-07-08 15:42:48'),
(11, 3, 8, 1, '2026-07-08 15:42:48'),
(12, 3, 9, 1, '2026-07-08 15:42:48'),
(13, 3, 28, 0, '2026-07-08 15:42:48'),
(14, 3, 17, 1, '2026-07-08 15:42:48'),
(15, 3, 4, 1, '2026-07-08 15:42:48'),
(16, 3, 29, 0, '2026-07-08 15:42:48'),
(17, 3, 42, 1, '2026-07-08 15:42:48'),
(18, 4, 43, 0, '2026-07-08 15:42:48'),
(19, 4, 5, 1, '2026-07-08 15:42:48'),
(20, 4, 32, 1, '2026-07-08 15:42:48'),
(21, 4, 8, 1, '2026-07-08 15:42:48'),
(22, 4, 50, 1, '2026-07-08 15:42:48'),
(23, 4, 40, 1, '2026-07-08 15:42:48'),
(24, 3, 47, 1, '2026-07-08 15:42:48'),
(25, 3, 31, 1, '2026-07-08 15:42:48'),
(26, 3, 26, 0, '2026-07-08 15:42:48'),
(27, 2, 32, 1, '2026-07-08 15:42:48'),
(28, 2, 27, 0, '2026-07-08 15:42:48'),
(29, 4, 41, 0, '2026-07-08 15:42:48'),
(30, 4, 22, 1, '2026-07-08 15:42:48'),
(31, 4, 34, 1, '2026-07-08 15:42:48'),
(32, 4, 45, 0, '2026-07-08 15:42:48'),
(33, 3, 22, 1, '2026-07-08 15:42:48'),
(34, 4, 1, 0, '2026-07-08 15:42:48'),
(35, 4, 25, 0, '2026-07-09 15:06:45'),
(36, 4, 15, 0, '2026-07-09 15:14:49'),
(37, 4, 16, 0, '2026-07-09 15:17:54'),
(38, 4, 7, 0, '2026-07-09 15:18:27'),
(39, 4, 18, 0, '2026-07-09 15:27:50'),
(40, 4, 35, 0, '2026-07-09 16:23:50'),
(41, 4, 31, 0, '2026-07-09 19:13:37');

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
-- Indices de la tabla `partida`
--
ALTER TABLE `partida`
  ADD PRIMARY KEY (`idPartida`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reportes_preguntas` (`id_pregunta`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`);

--
-- Indices de la tabla `usuario_pregunta`
--
ALTER TABLE `usuario_pregunta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `pregunta_id` (`pregunta_id`);

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
-- AUTO_INCREMENT de la tabla `partida`
--
ALTER TABLE `partida`
  MODIFY `idPartida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `reporte`
--
ALTER TABLE `reporte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario_pregunta`
--
ALTER TABLE `usuario_pregunta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `opcion`
--
ALTER TABLE `opcion`
  ADD CONSTRAINT `opcion_ibfk_1` FOREIGN KEY (`pregunta_id`) REFERENCES `pregunta` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `partida`
--
ALTER TABLE `partida`
  ADD CONSTRAINT `partida_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `pregunta_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`);

--
-- Filtros para la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD CONSTRAINT `fk_reportes_preguntas` FOREIGN KEY (`id_pregunta`) REFERENCES `pregunta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_pregunta`
--
ALTER TABLE `usuario_pregunta`
  ADD CONSTRAINT `usuario_pregunta_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuario_pregunta_ibfk_2` FOREIGN KEY (`pregunta_id`) REFERENCES `pregunta` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
