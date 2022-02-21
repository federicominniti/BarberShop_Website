-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Lug 25, 2021 alle 11:34
-- Versione del server: 5.6.20
-- PHP Version: 5.5.15

DROP DATABASE if exists barbershop; 
CREATE DATABASE barbershop; 
USE barbershop; 

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `barbershop`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `appuntamento`
--

CREATE TABLE IF NOT EXISTS `appuntamento` (
`CodiceAppuntamento` int(11) NOT NULL,
  `NomeUtente` varchar(30) NOT NULL,
  `NumeroServizio` int(11) NOT NULL,
  `NomeUBarber` varchar(30) NOT NULL,
  `DataAppuntamento` date NOT NULL,
  `OraAppuntamento` time NOT NULL,
  `Fatto` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dump dei dati per la tabella `appuntamento`
--

INSERT INTO `appuntamento` (`CodiceAppuntamento`, `NomeUtente`, `NumeroServizio`, `NomeUBarber`, `DataAppuntamento`, `OraAppuntamento`, `Fatto`) VALUES
(1, 'pippo30', 4, 'a.cini', '2021-08-25', '17:30:00', 0),
(2, 'pippo30', 3, 'm.pini', '2021-09-21', '12:30:00', 0),
(3, 'pippo30', 3, 'm.pini', '2021-07-13', '10:00:00', 1),
(4, 'pippo30', 5, 'a.cini', '2021-07-10', '16:00:00', 1),
(7, 'pippo30', 2, 'm.pini', '2021-09-30', '17:00:00', 0),
(8, 'pippo30', 4, 'a.cini', '2021-07-04', '18:00:00', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `barber`
--

CREATE TABLE IF NOT EXISTS `barber` (
  `Cognome` varchar(20) NOT NULL,
  `Nome` varchar(15) NOT NULL,
  `NomeUBarber` varchar(30) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `Attivo` int(11) NOT NULL,
  `Admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `barber`
--

INSERT INTO `barber` (`Cognome`, `Nome`, `NomeUBarber`, `Password`, `Attivo`, `Admin`) VALUES
('Cini', 'Alessio', 'a.cini', 'fa71de15713a3e9e3ad5a5e07513838e', 1, 0),
('Rini', 'Fabio', 'f.rini', 'eb7c9cfa0a84aace9038b4fda6f37efa', 0, 0),
('Pini', 'Marco', 'm.pini', 'f334460279e86ed7985098e85a762d3c', 1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `ferie`
--

CREATE TABLE IF NOT EXISTS `ferie` (
`CodiceRichiesta` int(11) NOT NULL,
  `NomeUBarber` varchar(30) NOT NULL,
  `Data1` date NOT NULL,
  `Data2` date NOT NULL,
  `DataRichiesta` date NOT NULL,
  `Stato` varchar(9) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dump dei dati per la tabella `ferie`
--

INSERT INTO `ferie` (`CodiceRichiesta`, `NomeUBarber`, `Data1`, `Data2`, `DataRichiesta`, `Stato`) VALUES
(3, 'a.cini', '2021-07-21', '2021-07-24', '2021-07-13', 'accettate'),
(4, 'a.cini', '2021-07-30', '2021-08-05', '2021-07-13', 'rifiutate'),
(7, 'a.cini', '2021-08-28', '2021-08-29', '2021-07-13', 'rifiutate'),
(8, 'a.cini', '2021-08-30', '2021-08-31', '2021-07-12', 'accettate'),
(9, 'm.pini', '2021-07-19', '2021-07-21', '2021-07-16', 'accettate'),
(10, 'm.pini', '2021-07-30', '2021-08-03', '2021-07-16', 'accettate'),
(15, 'a.cini', '2022-07-21', '2022-08-28', '2021-07-24', 'rifiutate'),
(16, 'a.cini', '2022-10-26', '2021-12-31', '2021-07-24', 'rifiutate'),
(32, 'f.rini', '2021-07-27', '2021-07-30', '2021-07-24', 'rifiutate'),
(34, 'f.rini', '2021-09-14', '2021-09-15', '2021-07-24', 'rifiutate'),
(35, 'a.cini', '2021-10-12', '2021-10-14', '2021-07-25', 'pending'),
(36, 'a.cini', '2021-11-17', '2021-11-19', '2021-07-25', 'pending');

-- --------------------------------------------------------

--
-- Struttura della tabella `servizio`
--

CREATE TABLE IF NOT EXISTS `servizio` (
`NumeroServizio` int(11) NOT NULL,
  `Nome` varchar(30) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dump dei dati per la tabella `servizio`
--

INSERT INTO `servizio` (`NumeroServizio`, `Nome`) VALUES
(1, 'TAGLIO CAPELLI'),
(2, 'SINGLE CLIPPER'),
(3, 'RITOCCO BARBA'),
(4, 'TAGLIO BARBA AL RASOIO'),
(5, 'COLORE');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE IF NOT EXISTS `utente` (
  `Nome` varchar(15) NOT NULL,
  `Cognome` varchar(20) NOT NULL,
  `DataDiNascita` date NOT NULL,
  `NomeUtente` varchar(30) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `ImmagineProfilo` varchar(200) NOT NULL,
  `Attivo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`Nome`, `Cognome`, `DataDiNascita`, `NomeUtente`, `Email`, `Password`, `ImmagineProfilo`, `Attivo`) VALUES
('Pippo', 'Lini', '1983-10-10', 'pippo30', 'pippo29@hugy.hgf', '1b364d072ff8614536288fdc3013de49', 'avatar.png', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appuntamento`
--
ALTER TABLE `appuntamento`
 ADD PRIMARY KEY (`CodiceAppuntamento`);

--
-- Indexes for table `barber`
--
ALTER TABLE `barber`
 ADD PRIMARY KEY (`NomeUBarber`);

--
-- Indexes for table `ferie`
--
ALTER TABLE `ferie`
 ADD PRIMARY KEY (`CodiceRichiesta`);

--
-- Indexes for table `servizio`
--
ALTER TABLE `servizio`
 ADD PRIMARY KEY (`NumeroServizio`);

--
-- Indexes for table `utente`
--
ALTER TABLE `utente`
 ADD PRIMARY KEY (`NomeUtente`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appuntamento`
--
ALTER TABLE `appuntamento`
MODIFY `CodiceAppuntamento` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `ferie`
--
ALTER TABLE `ferie`
MODIFY `CodiceRichiesta` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `servizio`
--
ALTER TABLE `servizio`
MODIFY `NumeroServizio` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
