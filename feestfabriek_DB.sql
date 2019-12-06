-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 13 nov 2019 om 14:23
-- Serverversie: 10.4.6-MariaDB
-- PHP-versie: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `feestfabriek`
--
CREATE DATABASE IF NOT EXISTS `feestfabriek` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `feestfabriek`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `adres`
--

CREATE TABLE `adres` (
  `adresID` int(11) NOT NULL,
  `Adres` varchar(256) NOT NULL,
  `Huisnummer` varchar(45) NOT NULL,
  `Postcode` varchar(6) NOT NULL,
  `Land` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `adres`
--

INSERT INTO `adres` (`adresID`, `Adres`, `Huisnummer`, `Postcode`, `Land`) VALUES
(45, 'Oosterbroekstraat', '16', '7841EL', 'Nederland'),
(46, 'Harrystraat', '16', '8451SA', 'Nederland'),
(49, 'Hanze straat', '16', '4444EL', 'Nederland'),
(51, 'Voorstraat', '18', '9348GA', 'Nederland'),
(52, 'Zwarte laan', '56A', '2158TT', 'Nederland'),
(53, 'West Straat', '18', '9645AF', 'nederland'),
(54, 'West Straat', '16', '8451SA', 'Nederland'),
(55, 'Spoorstraat', '34', '2156VB', 'Nederland'),
(56, 'Verlengde spoor straat', '5', '7892IO', 'Nederland'),
(57, 'Parkweg', '1A1', '7772xp', 'Nederland');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `artikel`
--

CREATE TABLE `artikel` (
  `ID` int(11) NOT NULL,
  `Naam` varchar(256) NOT NULL,
  `Omschrijving` text NOT NULL,
  `Prijs` int(11) NOT NULL,
  `Categorie_ID` int(3) NOT NULL,
  `Code` varchar(10) NOT NULL,
  `Verkoopwijze_ID` int(3) NOT NULL,
  `Image` varchar(256) DEFAULT NULL,
  `Onderhoud` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `artikel`
--

INSERT INTO `artikel` (`ID`, `Naam`, `Omschrijving`, `Prijs`, `Categorie_ID`, `Code`, `Verkoopwijze_ID`, `Image`, `Onderhoud`) VALUES
(1, 'Kasteel Springkussen', 'Springkussen met een kasteel', 200, 1, '8520', 3, 'springkussen_kasteel.jpg', 1),
(2, 'Glijbaan Sprinkussen', 'Springkussen met een glijbaan', 200, 1, '8521', 3, 'springkussen_glijbaan.jpg', 1),
(3, 'Plastic Bekers', '20 bekers', 50, 2, '78520', 4, 'plastic_bekers.jpg', 1),
(4, 'Witte Filjtes', '20 filtjes', 50, 3, '9874', 4, 'witte_filtjes.jpg', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorie`
--

CREATE TABLE `categorie` (
  `Categorie_ID` int(11) NOT NULL,
  `Categorie_naam` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `categorie`
--

INSERT INTO `categorie` (`Categorie_ID`, `Categorie_naam`) VALUES
(1, 'Springkussen'),
(2, 'Bekers'),
(3, 'Filtjes');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klant`
--

CREATE TABLE `klant` (
  `ID` int(11) NOT NULL,
  `Naam` varchar(256) NOT NULL,
  `Tussenvoegsel` varchar(45) NOT NULL,
  `Achternaam` varchar(256) NOT NULL,
  `Email` text NOT NULL,
  `Telefoonnummer` varchar(13) NOT NULL,
  `Aanhef` varchar(256) DEFAULT NULL,
  `Korting` int(3) NOT NULL,
  `Adres_ID` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `klant`
--

INSERT INTO `klant` (`ID`, `Naam`, `Tussenvoegsel`, `Achternaam`, `Email`, `Telefoonnummer`, `Aanhef`, `Korting`, `Adres_ID`) VALUES
(21, 'Sander', '', 'Kroeze', 'Sander20kro@gmail.com', '0629220485', 'De heer', 15, 57),
(22, 'Harry', 'van', 'Steen', 'harry@nee.nl', '0629220485', 'De heer', 0, 54),
(28, 'Henk', '', 'Zwart', 'Henk@zwart.nl', '0629220485', 'De heer', 0, 45),
(29, 'Herman', 'te', 'Straat', 'Herman@straat.nl', '0687654321', 'De heer', 0, 51),
(30, 'Gert', '', 'Zwaar', 'Gert@zwaar.nl', '0687654321', 'De heer', 0, 52),
(31, 'Harm', '', 'Graaf', 'Harm@graaf.nl', '0629220485', 'De heer', 0, 45),
(32, 'Fred', 'van', 'Beek', 'FredV@beek.nl', '0698745632', 'De heer', 0, 55),
(33, 'Karel', 'ver', 'Hek', 'Karelver@hek.nl', '0629220485', 'De heer', 0, 56);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `medewerker`
--

CREATE TABLE `medewerker` (
  `ID` int(11) NOT NULL,
  `Naam` varchar(256) NOT NULL,
  `Email` text NOT NULL,
  `Wachtwoord` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `medewerker`
--

INSERT INTO `medewerker` (`ID`, `Naam`, `Email`, `Wachtwoord`) VALUES
(1, 'Sander', 'admin@admin.nl', '$2y$10$BHRG.ryfkOlv5s3qVfBTO.0KkpUANDc21j79K9Jpw.YAkDtPrdq5K');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orderregel`
--

CREATE TABLE `orderregel` (
  `orderregel_ID` int(11) NOT NULL,
  `Order_ID` int(3) NOT NULL,
  `Artikel_ID` int(3) NOT NULL,
  `Aantal` int(200) NOT NULL,
  `Price` varchar(11) DEFAULT NULL,
  `BeginDatum` varchar(256) NOT NULL,
  `EindDatum` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `orderregel`
--

INSERT INTO `orderregel` (`orderregel_ID`, `Order_ID`, `Artikel_ID`, `Aantal`, `Price`, `BeginDatum`, `EindDatum`) VALUES
(2, 114, 2, 8, '200.00', '2019-11-14', '2019-11-22'),
(3, 115, 3, 5, '50.00', '', ''),
(4, 115, 2, 14, '200.00', '2019-11-15', '2019-11-29'),
(5, 116, 3, 10, '50.00', '', ''),
(6, 116, 4, 30, '50.00', '', ''),
(7, 117, 2, 23, '200', '2019-11-14', '2019-12-07'),
(8, 118, 1, 8, '200', '2019-11-20', '2019-11-28'),
(9, 119, 4, 2147483647, '50.00', '', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orders`
--

CREATE TABLE `orders` (
  `orders_ID` int(11) NOT NULL,
  `BezorgOpties` varchar(256) NOT NULL,
  `OrderDatum` date NOT NULL,
  `BezorgStatus` varchar(256) NOT NULL,
  `BetaalStatus` varchar(256) NOT NULL,
  `Klant_ID` int(4) NOT NULL,
  `Adres_ID` int(4) NOT NULL,
  `totaalPrijs` varchar(200) DEFAULT NULL,
  `Retour` varchar(255) DEFAULT 'nee'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `orders`
--

INSERT INTO `orders` (`orders_ID`, `BezorgOpties`, `OrderDatum`, `BezorgStatus`, `BetaalStatus`, `Klant_ID`, `Adres_ID`, `totaalPrijs`, `Retour`) VALUES
(114, 'Bezorgen', '2019-11-13', 'In Magazijn', 'Niet Betaald', 21, 45, '69.64', 'nee'),
(115, 'Bezorgen', '2019-11-13', 'In Magazijn', 'Niet Betaald', 31, 45, '94.11', 'nee'),
(116, 'Ophalen', '2019-11-13', 'In Magazijn', 'Niet Betaald', 22, 54, '33.20', 'nee'),
(117, 'Ophalen', '2019-11-13', 'In Magazijn', 'Niet Betaald', 32, 55, '66.61', 'nee'),
(118, 'Bezorgen', '2019-11-13', 'In Magazijn', 'Niet Betaald', 33, 56, '73.31', 'nee'),
(119, 'Bezorgen', '2019-11-13', 'In Magazijn', 'Niet Betaald', 21, 57, '96.51', 'nee');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `verkoopwijze`
--

CREATE TABLE `verkoopwijze` (
  `Verkoopwijze_ID` int(11) NOT NULL,
  `Verkoopwijze_Naam` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `verkoopwijze`
--

INSERT INTO `verkoopwijze` (`Verkoopwijze_ID`, `Verkoopwijze_Naam`) VALUES
(3, 'Huur'),
(4, 'Betaal');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `adres`
--
ALTER TABLE `adres`
  ADD PRIMARY KEY (`adresID`);

--
-- Indexen voor tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Link_categorie` (`Categorie_ID`),
  ADD KEY `LInk_verkoopwijze` (`Verkoopwijze_ID`);

--
-- Indexen voor tabel `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`Categorie_ID`);

--
-- Indexen voor tabel `klant`
--
ALTER TABLE `klant`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `LINK_adres_id` (`Adres_ID`);

--
-- Indexen voor tabel `medewerker`
--
ALTER TABLE `medewerker`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `orderregel`
--
ALTER TABLE `orderregel`
  ADD PRIMARY KEY (`orderregel_ID`),
  ADD KEY `Link_Order_ID` (`Order_ID`),
  ADD KEY `Link_artikel` (`Artikel_ID`);

--
-- Indexen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orders_ID`),
  ADD KEY `link_adres` (`Adres_ID`),
  ADD KEY `link_klant` (`Klant_ID`);

--
-- Indexen voor tabel `verkoopwijze`
--
ALTER TABLE `verkoopwijze`
  ADD PRIMARY KEY (`Verkoopwijze_ID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `adres`
--
ALTER TABLE `adres`
  MODIFY `adresID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT voor een tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `categorie`
--
ALTER TABLE `categorie`
  MODIFY `Categorie_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `klant`
--
ALTER TABLE `klant`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT voor een tabel `medewerker`
--
ALTER TABLE `medewerker`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `orderregel`
--
ALTER TABLE `orderregel`
  MODIFY `orderregel_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT voor een tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `orders_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `artikel`
--
ALTER TABLE `artikel`
  ADD CONSTRAINT `LInk_verkoopwijze` FOREIGN KEY (`Verkoopwijze_ID`) REFERENCES `verkoopwijze` (`Verkoopwijze_ID`),
  ADD CONSTRAINT `Link_categorie` FOREIGN KEY (`Categorie_ID`) REFERENCES `categorie` (`Categorie_ID`);

--
-- Beperkingen voor tabel `klant`
--
ALTER TABLE `klant`
  ADD CONSTRAINT `LINK_adres_id` FOREIGN KEY (`Adres_ID`) REFERENCES `adres` (`adresID`);

--
-- Beperkingen voor tabel `orderregel`
--
ALTER TABLE `orderregel`
  ADD CONSTRAINT `Link_Order_ID` FOREIGN KEY (`Order_ID`) REFERENCES `orders` (`orders_ID`),
  ADD CONSTRAINT `Link_artikel` FOREIGN KEY (`Artikel_ID`) REFERENCES `artikel` (`ID`);

--
-- Beperkingen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `link_adres` FOREIGN KEY (`Adres_ID`) REFERENCES `adres` (`adresID`),
  ADD CONSTRAINT `link_klant` FOREIGN KEY (`Klant_ID`) REFERENCES `klant` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
