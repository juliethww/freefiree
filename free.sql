-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2024 at 01:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `free`
--

-- --------------------------------------------------------

--
-- Table structure for table `armas`
--

CREATE TABLE `armas` (
  `id_arma` int(11) NOT NULL,
  `nombre_ar` varchar(50) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `cant_balas` int(11) NOT NULL,
  `dano` int(11) NOT NULL,
  `foto` varchar(300) NOT NULL,
  `id_puntos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `armas`
--

INSERT INTO `armas` (`id_arma`, `nombre_ar`, `id_tipo`, `cant_balas`, `dano`, `foto`, `id_puntos`) VALUES
(1, 'puño', 3, 100, 100, '../images/puño.png', 1),
(2, 'usp', 2, 29, 12, '../images/usp.png', 1),
(3, 'awm', 3, 12, 20, '../images/awmm.jpg', 1),
(4, 'kord', 4, 200, 30, '../images/kord.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `avatar`
--

CREATE TABLE `avatar` (
  `id_avatar` int(11) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `foto` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `avatar`
--

INSERT INTO `avatar` (`id_avatar`, `avatar`, `foto`) VALUES
(1, 'Kelly', '../images/kelly.jpg'),
(2, 'Moco', '../images/moco1.png'),
(3, 'Kapella', '../images/kapellaa.png'),
(4, 'Skyler', '../images/sky1.png'),
(5, 'Alok', '../images/alokk.png'),
(6, 'Orion', '../images/ori.png');

-- --------------------------------------------------------

--
-- Table structure for table `detalles_partida`
--

CREATE TABLE `detalles_partida` (
  `id_detalle` int(11) NOT NULL,
  `id_atacante` int(11) DEFAULT NULL,
  `id_atacado` int(11) DEFAULT NULL,
  `id_arma` int(11) DEFAULT NULL,
  `id_mundo` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detalles_partida`
--

INSERT INTO `detalles_partida` (`id_detalle`, `id_atacante`, `id_atacado`, `id_arma`, `id_mundo`, `fecha`) VALUES
(19, 35, 34, 2, 1, '2024-04-28 23:31:34'),
(20, 35, 37, 2, 1, '2024-04-29 00:36:44'),
(21, 35, 37, 2, 1, '2024-04-29 02:34:51'),
(22, 35, 37, 2, 1, '2024-04-29 02:47:35'),
(23, 35, 37, 1, 1, '2024-04-29 02:48:16'),
(24, 40, 39, 1, 1, '2024-04-29 03:17:47'),
(25, 40, 39, 1, 1, '2024-04-29 03:18:56');

-- --------------------------------------------------------

--
-- Table structure for table `estado`
--

CREATE TABLE `estado` (
  `id_estado` int(11) NOT NULL,
  `estado` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estado`
--

INSERT INTO `estado` (`id_estado`, `estado`) VALUES
(1, 'Bloqueado'),
(2, 'Activadoo');

-- --------------------------------------------------------

--
-- Table structure for table `mundo`
--

CREATE TABLE `mundo` (
  `id_mundo` int(11) NOT NULL,
  `nombre_fo` varchar(50) NOT NULL,
  `maxi_jugadores` int(11) NOT NULL,
  `foto` varchar(500) NOT NULL,
  `id_puntosm` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mundo`
--

INSERT INTO `mundo` (`id_mundo`, `nombre_fo`, `maxi_jugadores`, `foto`, `id_puntosm`) VALUES
(1, 'Bermuda', 5, '../images/ber.jpg', 1),
(2, 'Purgatorio', 5, '../images/pur.jpg', NULL),
(3, 'Nexterra', 5, '../images/nex.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `partida`
--

CREATE TABLE `partida` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_mundo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `puntos`
--

CREATE TABLE `puntos` (
  `id_puntos` int(11) NOT NULL,
  `puntos` int(11) NOT NULL,
  `nivel` int(11) NOT NULL,
  `rango` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `puntos`
--

INSERT INTO `puntos` (`id_puntos`, `puntos`, `nivel`, `rango`) VALUES
(1, 0, 1, 'Oro 1'),
(2, 500, 2, 'Platino 2'),
(3, 1000, 3, 'Diamante 1'),
(4, 1500, 4, 'Heroico 2'),
(5, 2000, 5, 'Maestro 3');

-- --------------------------------------------------------

--
-- Table structure for table `sala`
--

CREATE TABLE `sala` (
  `id_sala` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `id_mundo` int(11) NOT NULL,
  `id_arma` int(11) NOT NULL,
  `id_avatar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sala`
--

INSERT INTO `sala` (`id_sala`, `username`, `id_mundo`, `id_arma`, `id_avatar`) VALUES
(1, 'kenitor', 1, 1, 6),
(2, 'andreas', 1, 1, 3),
(3, 'alirio1', 1, 1, 5),
(4, 'hola2', 1, 1, 2),
(5, 'brian123', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tipo_arma`
--

CREATE TABLE `tipo_arma` (
  `id_tipo` int(11) NOT NULL,
  `tipo` varchar(60) NOT NULL,
  `id_arma` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipo_arma`
--

INSERT INTO `tipo_arma` (`id_tipo`, `tipo`, `id_arma`) VALUES
(1, 'Cuerpo a Cuerpo', 1),
(2, 'Pistolas', 2),
(3, 'Francos', 3),
(4, 'Ametralladora', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tip_user`
--

CREATE TABLE `tip_user` (
  `id_tip_user` int(11) NOT NULL,
  `tip_user` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tip_user`
--

INSERT INTO `tip_user` (`id_tip_user`, `tip_user`) VALUES
(1, 'Administrador'),
(2, 'Jugador');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `correo` varchar(60) NOT NULL,
  `username` varchar(20) NOT NULL,
  `contrasena` varchar(500) NOT NULL,
  `id_avatar` int(11) NOT NULL,
  `id_tip_user` int(11) NOT NULL,
  `nivel` int(100) NOT NULL,
  `id_puntos` int(11) NOT NULL,
  `puntos` int(11) NOT NULL,
  `vida` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT 2,
  `ultimo_ingreso` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `correo`, `username`, `contrasena`, `id_avatar`, `id_tip_user`, `nivel`, `id_puntos`, `puntos`, `vida`, `id_estado`, `ultimo_ingreso`) VALUES
(1, 'angie', 'angie@gmail.com', 'angie12', '$2y$10$GbC3aiEnWQbIGT.TXEEa4OdiIrNxO46PDmvvVCj5qZFsfdA9rQbYS', 6, 1, 1, 1, 0, 125, 2, '2024-04-27 21:24:37'),
(30, 'Julieta', 'julieta@gmail.com', 'julieta1', '$2y$10$uib1LYZcM2g7M1aZwznKROg7F7ZTL1dhqtdt5EVwqr3qSN4YTV23y', 3, 2, 1, 3, 780, 125, 2, '2024-04-28 23:47:33'),
(31, 'brian', 'brian@gmail.com', 'brian123', '$2y$10$WKwiONgAwuCKICd9jqVHke2byWY79EPvmvhZc6c5.E8h3KqINkP3S', 6, 2, 1, 2, 0, 125, 2, '2024-04-29 02:45:20'),
(34, 'bricont', 'bjulian1605@gmail.com', 'bricont1605', '$2y$10$IiRp3/T83ncnhdCuBMK4YeT0PglxY6xDf2Slme0mp9vLOe4C64/Zm', 5, 2, 1, 1, 0, 113, 2, '2024-04-28 23:31:34'),
(35, 'negro', 'negro@gmail.com', 'negro1', '$2y$10$wA8t853mNk4P9gTXuaxQYekFz07jLRLfNN5dNjIuCL5BpHd39bbpW', 3, 2, 1, 1, 40, 125, 2, '2024-04-29 02:48:16'),
(36, 'brian23', 'brian12@gmail.com', 'brian23', '$2y$10$zwEpvuL4La7OBAcxqEhdIOtZMIQXNFrn/PlKZZHFMeHYachJ5jk2q', 6, 2, 1, 1, 0, 125, 2, '2024-04-28 23:51:37'),
(37, 'holaaaa', 'hola1@gmail.com', 'hola23', '$2y$10$R5WG/N0z4ON8XixYyHwn/OzfiPg5o7ngf.hum4T1FUURabMcNENAq', 6, 2, 1, 1, 0, -11, 2, '2024-04-29 02:48:16'),
(38, 'jugador1', 'jugador1@gmail.com', 'jugador1', '$2y$10$eLqc0Sfmw3aVT/Sj01wE3eKoB1EYOJeUJAhDTWQ9TTL3cduO8gUgW', 4, 2, 1, 1, 0, 125, 2, '2024-04-29 03:10:16'),
(39, 'jugador2', 'jugador2@gmail.com', 'jugador2', '$2y$10$ulfZIvl5GxiDUcDcIVzBdO5MXU5kaP0s49oOLeRG94I/wqRTSskFu', 1, 2, 1, 1, 0, -75, 2, '2024-04-29 03:18:56'),
(40, 'jugador3', 'jugador3@gmail.com', 'jugador3', '$2y$10$mfTBigKQFQBTH.J2QLgOQ..VpQziY5ffO9XEyfydwIyf/OnkV828O', 2, 2, 1, 1, 20, 125, 2, '2024-04-29 03:18:56'),
(41, 'jugador4', 'jugador4@gmail.com', 'jugador4', '$2y$10$sph98abPGxk0dVDn6EZ83ehBuKfI851E5cDQ0dqwZ3C4QNLkQNYbO', 6, 2, 1, 1, 0, 125, 2, '2024-04-29 03:16:14'),
(42, 'Juliwww', 'andreasilva23433@gmail.com', 'juliwww', '$2y$10$ejT2tvAYzr6S0pMjEkREA.6769wDfz5kati0yYF2M0hX51CJ.8puC', 1, 1, 1, 0, 0, 125, 2, '2024-05-03 23:21:29');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios_sala`
--

CREATE TABLE `usuarios_sala` (
  `id` int(11) NOT NULL,
  `id_sala` int(11) NOT NULL,
  `username` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios_sala`
--

INSERT INTO `usuarios_sala` (`id`, `id_sala`, `username`) VALUES
(1, 1, 'kenitor'),
(2, 1, 'andreas'),
(3, 1, 'alirio1'),
(4, 1, 'hola1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `armas`
--
ALTER TABLE `armas`
  ADD PRIMARY KEY (`id_arma`),
  ADD UNIQUE KEY `nom_arma` (`nombre_ar`),
  ADD KEY `fk_id_puntos` (`id_puntos`);

--
-- Indexes for table `avatar`
--
ALTER TABLE `avatar`
  ADD PRIMARY KEY (`id_avatar`);

--
-- Indexes for table `detalles_partida`
--
ALTER TABLE `detalles_partida`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_atacante` (`id_atacante`),
  ADD KEY `id_atacado` (`id_atacado`),
  ADD KEY `id_arma` (`id_arma`),
  ADD KEY `id_mundo` (`id_mundo`);

--
-- Indexes for table `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indexes for table `mundo`
--
ALTER TABLE `mundo`
  ADD PRIMARY KEY (`id_mundo`),
  ADD KEY `fk_id_puntosm` (`id_puntosm`);

--
-- Indexes for table `partida`
--
ALTER TABLE `partida`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_mundo` (`id_mundo`);

--
-- Indexes for table `puntos`
--
ALTER TABLE `puntos`
  ADD PRIMARY KEY (`id_puntos`);

--
-- Indexes for table `sala`
--
ALTER TABLE `sala`
  ADD PRIMARY KEY (`id_sala`);

--
-- Indexes for table `tipo_arma`
--
ALTER TABLE `tipo_arma`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indexes for table `tip_user`
--
ALTER TABLE `tip_user`
  ADD PRIMARY KEY (`id_tip_user`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indexes for table `usuarios_sala`
--
ALTER TABLE `usuarios_sala`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `armas`
--
ALTER TABLE `armas`
  MODIFY `id_arma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `avatar`
--
ALTER TABLE `avatar`
  MODIFY `id_avatar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `detalles_partida`
--
ALTER TABLE `detalles_partida`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `estado`
--
ALTER TABLE `estado`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mundo`
--
ALTER TABLE `mundo`
  MODIFY `id_mundo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `partida`
--
ALTER TABLE `partida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `puntos`
--
ALTER TABLE `puntos`
  MODIFY `id_puntos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sala`
--
ALTER TABLE `sala`
  MODIFY `id_sala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tipo_arma`
--
ALTER TABLE `tipo_arma`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tip_user`
--
ALTER TABLE `tip_user`
  MODIFY `id_tip_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `usuarios_sala`
--
ALTER TABLE `usuarios_sala`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `armas`
--
ALTER TABLE `armas`
  ADD CONSTRAINT `fk_id_puntos` FOREIGN KEY (`id_puntos`) REFERENCES `puntos` (`id_puntos`);

--
-- Constraints for table `detalles_partida`
--
ALTER TABLE `detalles_partida`
  ADD CONSTRAINT `detalles_partida_ibfk_1` FOREIGN KEY (`id_atacante`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `detalles_partida_ibfk_2` FOREIGN KEY (`id_atacado`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `detalles_partida_ibfk_3` FOREIGN KEY (`id_arma`) REFERENCES `armas` (`id_arma`),
  ADD CONSTRAINT `detalles_partida_ibfk_4` FOREIGN KEY (`id_mundo`) REFERENCES `mundo` (`id_mundo`);

--
-- Constraints for table `mundo`
--
ALTER TABLE `mundo`
  ADD CONSTRAINT `fk_id_puntosm` FOREIGN KEY (`id_puntosm`) REFERENCES `puntos` (`id_puntos`);

--
-- Constraints for table `partida`
--
ALTER TABLE `partida`
  ADD CONSTRAINT `partida_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `partida_ibfk_2` FOREIGN KEY (`id_mundo`) REFERENCES `mundo` (`id_mundo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
