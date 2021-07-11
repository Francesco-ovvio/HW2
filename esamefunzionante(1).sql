-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Lug 11, 2021 alle 19:37
-- Versione del server: 10.4.14-MariaDB
-- Versione PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `esamefunzionante`
--

DELIMITER $$
--
-- Procedure
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `cambioProdotto` (IN `dip` VARCHAR(16), IN `qProd` INT, IN `codNuovoProd` INT)  begin
	start transaction;
		insert into STORICOPRODUZIONE(quantitaProdotta, orarioFine, dataFine, IDdip, IDprodotto) values (qProd, current_time, CURRENT_DATE, dip, (select prodottoAttuale from DIPENDENTE where CF=dip));
		
		update DIPENDENTE
		set prodottoAttuale=codNuovoProd, dataInizio=current_date, orarioInizio=current_time
		where CF=dip;
	commit;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cercaCat` (IN `tip` VARCHAR(9))  BEGIN
	drop TEMPORARY TABLE if EXISTS temp;
    create TEMPORARY TABLE temp(
        IDprodotto int,
        cognome varchar(255),
        nome varchar(255),
        quantitaProdotta int DEFAULT null,
        dataFine date DEFAULT null);
    
    INSERT INTO temp
    SELECT SP.IDprodotto, D.cognome, D.nome, SP.quantitaProdotta, SP.dataFine
    from dipendente D, storicoproduzione SP
    where D.CF=SP.IDdip and tip=(select tipologia FROM tipoprodotto where IDprodotto=SP.IDprodotto);
    
    INSERT INTO temp (IDprodotto, cognome, nome)
    select D1.prodottoAttuale, D1.cognome, D1.nome
   	FROM dipendente D1
    WHERE tip=(SELECT tipologia from tipoprodotto where D1.prodottoAttuale=IDprodotto);
    
    select * from temp;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `dettagliCliente` (IN `idCli` INT)  BEGIN
	select COUNT(IDordine), pagato, sum(costoTot)
    from ordine
    where IDcliente=idCli
    GROUP by pagato;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `mansDipendente` (IN `mans` VARCHAR(16))  begin
	select nome, cognome
    from dipendente
    where mansione = mans;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `nuovoOrdine` (IN `cliente` VARCHAR(16), IN `settDep` INT, IN `qRichiesta` INT, IN `dipMag` VARCHAR(16))  BEGIN
	start TRANSACTION;
    	INSERT into ordine(nDeposito, IDcliente, IDmagazz, quantitaRichiesta, dataOrdine, costoTot, pagato) values
        	(settDep, cliente, dipMag, qRichiesta, CURRENT_DATE, (select costouni from prezzounitinv where settD=settDep)*qRichiesta, false);
        case
        	when (qRichiesta <= (select quantitaTot from inventarios where settoreDeposito=settDep)) then
            	UPDATE inventarios
                set quantitaTot = quantitaTot - qRichiesta, spazioDisp= spazioDisp+qRichiesta
                where settoreDeposito=settDep;
            else
            	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La richiesta supera la massima capacità di inventario';
        end case;
    commit;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `nuovoProdotto` (IN `nomeP` VARCHAR(255), IN `tipo` VARCHAR(9), IN `cpu` FLOAT, IN `descr` VARCHAR(255), IN `img` VARCHAR(255), IN `nomeTrad` VARCHAR(255))  begin
	insert into TIPO_PRODOTTOS(nomeProdotto, tipologia, costoPerUnita, descrizione, img, nomeTrad) values (nomeP, tipo, cpu, descr, img, nomeTrad);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pagaOrdine` (IN `idord` INT)  BEGIN
	update ordine
    set pagato = true
    WHERE IDordine=idord;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `clientes`
--

CREATE TABLE `clientes` (
  `id` varchar(16) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `cognome` varchar(255) DEFAULT NULL,
  `indirizzo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `cognome`, `indirizzo`) VALUES
('13579', 'Giangiorgio', 'Bevilacqua', 'via Menestrello 3'),
('24680', 'Giancarlo', 'Fragalà', 'Via Rossi 5'),
('53806', 'Gigi', 'del Popolo', 'Via Mazzini 1'),
('6njfji06', 'Giuseppe', 'Peppino', 'Via da mo casa 1'),
('86427', 'Giuseppe', 'Garibaldi', 'Via Pacinotti 8'),
('97037', 'Enrico', 'Pratticò', 'Via San Giovanni 34'),
('abc123', 'Francesco', 'Vattiato', 'Via Pacinotti 135'),
('axc345', 'Gianni', 'Giorgioc', 'Via Pacinotti 135'),
('eeeh789', 'Gerardo', 'Vecchio', 'Via San Matteo');

-- --------------------------------------------------------

--
-- Struttura della tabella `dipendente`
--

CREATE TABLE `dipendente` (
  `CF` varchar(16) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `cognome` varchar(255) DEFAULT NULL,
  `mansione` varchar(16) NOT NULL,
  `prodottoAttuale` int(11) DEFAULT NULL,
  `orarioInizio` time DEFAULT NULL,
  `dataInizio` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `dipendente`
--

INSERT INTO `dipendente` (`CF`, `nome`, `cognome`, `mansione`, `prodottoAttuale`, `orarioInizio`, `dataInizio`) VALUES
('abc123', 'Mario', 'Rossi', 'magazziniere', NULL, '17:07:56', '2021-05-01'),
('dqwth58', 'Enrico', 'Enrichino', 'magazziniere', NULL, '17:07:56', '2021-05-01'),
('efg456', 'Giuseppe', 'Vasta', 'addettoCereali', 4, '12:04:55', '2021-05-04'),
('fwke6', 'Franco', 'Franchino', 'addettoCereali', 1, '17:20:36', '2021-05-01'),
('hil789', 'Carlo', 'Carletto', 'addettoFormaggi', 2, '10:41:08', '2021-07-11'),
('jhoe08', 'Lucio', 'Lupo', 'addettoFormaggi', 2, '17:20:36', '2021-05-01');

--
-- Trigger `dipendente`
--
DELIMITER $$
CREATE TRIGGER `cambioProdottoDip` BEFORE UPDATE ON `dipendente` FOR EACH ROW begin
	if ((new.mansione='addettoFormaggi' and (select TPR1.tipologia from tipo_prodottos TPR1 where TPR1.IDprodotto=new.prodottoAttuale)!='latticino') or
		(new.mansione='addettoCereali' and (select TPR2.tipologia from tipo_prodottos TPR2 where TPR2.IDprodotto=new.prodottoAttuale)!='cereale')) then
			SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Il dipendente non è autorizato a produrre quel prodotto';
	end if;
	
	if (new.mansione='magazziniere') then
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Il magazziniere non può essere coinvolto in un processo di produzione';
	end if;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `checkDipendente` BEFORE INSERT ON `dipendente` FOR EACH ROW begin
	if (new.mansione='magazziniere' and new.prodottoAttuale is not null) then
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Il magazziniere non può essere coinvolto in un processo di produzione';
	end if;
	
	if ((new.mansione='addettoFormaggi' and (select TPR1.tipologia from tipo_prodottos TPR1 where TPR1.IDprodotto=new.prodottoAttuale)!='latticino') or
		(new.mansione='addettoCereali' and (select TPR2.tipologia from tipo_prodottos TPR2 where TPR2.IDprodotto=new.prodottoAttuale)!='cereale')) then
			SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Verifica la mansione del dipendente e il tipo di prodotto';
	end if;
	
	if((new.mansione='addettoFormaggi' or new.mansione='addettoCereali') and new.prodottoAttuale is null) then
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Verifica che il dipendente abbia un prodotto da produrre assegnato';
	end if;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `inventarios`
--

CREATE TABLE `inventarios` (
  `settoreDeposito` int(11) NOT NULL,
  `tipoProd` int(11) DEFAULT NULL,
  `quantitaTot` int(11) DEFAULT 0,
  `spazioDisp` int(11) DEFAULT 200
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `inventarios`
--

INSERT INTO `inventarios` (`settoreDeposito`, `tipoProd`, `quantitaTot`, `spazioDisp`) VALUES
(1, 1, 1, 199),
(2, 3, 28, 172),
(7, 7, 4, 196),
(8, 2, 8, 192),
(9, 6, 5, 195),
(10, 5, 7, 193),
(12, 4, 0, 200),
(13, 0, 24, 176);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `oldbuy`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `oldbuy` (
`IDordine` int(11)
,`nDeposito` int(11)
,`IDcliente` varchar(16)
,`IDmagazz` varchar(16)
,`quantitaRichiesta` int(11)
,`dataOrdine` date
,`costoTot` float
,`pagato` tinyint(1)
,`settoreDeposito` int(11)
,`tipoProd` int(11)
,`quantitaTot` int(11)
,`spazioDisp` int(11)
,`IDprodotto` int(11)
,`nomeProdotto` varchar(255)
,`tipologia` varchar(9)
,`costoPerUnita` float
,`descrizione` varchar(255)
,`img` varchar(255)
);

-- --------------------------------------------------------

--
-- Struttura della tabella `ordine`
--

CREATE TABLE `ordine` (
  `IDordine` int(11) NOT NULL,
  `nDeposito` int(11) DEFAULT NULL,
  `IDcliente` varchar(16) DEFAULT NULL,
  `IDmagazz` varchar(16) DEFAULT NULL,
  `quantitaRichiesta` int(11) DEFAULT NULL,
  `dataOrdine` date DEFAULT NULL,
  `costoTot` float DEFAULT NULL,
  `pagato` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `ordine`
--

INSERT INTO `ordine` (`IDordine`, `nDeposito`, `IDcliente`, `IDmagazz`, `quantitaRichiesta`, `dataOrdine`, `costoTot`, `pagato`) VALUES
(1, 1, '53806', 'abc123', 2, '2021-05-17', 5, 1),
(2, 8, '53806', 'dqwth58', 2, '2021-05-17', 6.6, 1),
(3, 2, '53806', 'dqwth58', 2, '2021-05-17', 6, 1),
(4, 1, '6njfji06', 'dqwth58', 6, '2021-05-20', 15, 1),
(5, 10, '6njfji06', 'abc123', 3, '2021-05-20', 11.4, 1),
(6, 2, '13579', 'dqwth58', 3, '2021-06-04', 9, 1),
(7, 7, '6njfji06', 'abc123', 5, '2021-07-01', 31, 1),
(15, 1, 'abc123', 'dqwth58', 3, '2021-07-05', 7.5, 0),
(16, 1, 'abc123', 'dqwth58', 3, '2021-07-05', 7.5, 0),
(17, 13, 'abc123', 'dqwth58', 1, '2021-07-11', 10, 0),
(18, 2, 'abc123', 'abc123', 2, '2021-07-11', 6, 0),
(19, 7, 'abc123', 'dqwth58', 1, '2021-07-11', 6.2, 0);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `prezzounitinv`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `prezzounitinv` (
`settD` int(11)
,`costouni` float
);

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotto`
--

CREATE TABLE `prodotto` (
  `nTimbro` int(11) NOT NULL,
  `tipoPr` int(11) NOT NULL,
  `prProdutt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `prodotto`
--

INSERT INTO `prodotto` (`nTimbro`, `tipoPr`, `prProdutt`) VALUES
(1129, 3, 2),
(1181, 3, 13),
(1390, 3, 2),
(1450, 0, 15),
(1504, 3, 13),
(1611, 0, 15),
(1643, 6, 9),
(1648, 3, 13),
(1672, 1, 1),
(2081, 0, 15),
(2099, 7, 7),
(2118, 0, 15),
(2237, 3, 13),
(2258, 2, 16),
(2273, 1, 1),
(2274, 2, 16),
(2319, 3, 2),
(2332, 0, 17),
(2393, 3, 2),
(2504, 3, 2),
(2534, 5, 11),
(2540, 0, 15),
(2564, 5, 11),
(2583, 1, 1),
(2592, 0, 15),
(2592, 1, 1),
(2652, 0, 15),
(2691, 0, 15),
(2694, 3, 2),
(2720, 3, 13),
(2742, 2, 8),
(2758, 3, 13),
(2783, 1, 1),
(2969, 3, 2),
(3130, 0, 15),
(3280, 3, 13),
(3286, 5, 11),
(3295, 0, 15),
(3389, 2, 8),
(3421, 3, 13),
(3499, 5, 11),
(3664, 5, 11),
(3774, 6, 9),
(3798, 1, 1),
(3894, 6, 9),
(3939, 2, 8),
(3977, 5, 11),
(3986, 1, 1),
(4087, 0, 15),
(4115, 1, 1),
(4256, 2, 16),
(4432, 0, 15),
(4482, 3, 2),
(4498, 3, 2),
(4556, 3, 2),
(4632, 3, 13),
(4768, 7, 7),
(5073, 3, 13),
(5085, 0, 15),
(5134, 3, 2),
(5235, 1, 1),
(5246, 0, 15),
(5261, 2, 8),
(5282, 1, 1),
(5300, 3, 2),
(5330, 0, 15),
(5362, 3, 2),
(5517, 3, 2),
(5540, 6, 9),
(5561, 3, 2),
(5645, 1, 1),
(5646, 2, 8),
(5692, 5, 11),
(5751, 3, 2),
(5762, 5, 11),
(5773, 0, 15),
(5859, 7, 7),
(5888, 3, 13),
(5919, 7, 7),
(6056, 3, 13),
(6088, 3, 2),
(6104, 0, 17),
(6331, 3, 2),
(6527, 0, 17),
(6544, 3, 13),
(6638, 5, 11),
(6643, 3, 13),
(6759, 2, 16),
(6851, 0, 17),
(6934, 2, 8),
(7021, 6, 9),
(7027, 1, 1),
(7071, 7, 7),
(7082, 7, 7),
(7305, 2, 8),
(7317, 0, 15),
(7396, 0, 15),
(7397, 7, 7),
(7421, 2, 8),
(7485, 0, 15),
(7548, 5, 11),
(7642, 0, 17),
(7658, 1, 1),
(7739, 7, 7),
(7834, 1, 1),
(7949, 3, 2),
(7955, 1, 1),
(8005, 2, 16),
(8008, 0, 15),
(8162, 2, 8),
(8273, 3, 2),
(8648, 7, 7),
(8750, 2, 8),
(8833, 7, 7),
(8889, 3, 13);

-- --------------------------------------------------------

--
-- Struttura della tabella `storicoproduzione`
--

CREATE TABLE `storicoproduzione` (
  `IDproduzione` int(11) NOT NULL,
  `quantitaProdotta` int(11) DEFAULT NULL,
  `orarioFine` time DEFAULT NULL,
  `dataFine` date DEFAULT NULL,
  `IDdip` varchar(16) DEFAULT NULL,
  `IDprodotto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `storicoproduzione`
--

INSERT INTO `storicoproduzione` (`IDproduzione`, `quantitaProdotta`, `orarioFine`, `dataFine`, `IDdip`, `IDprodotto`) VALUES
(1, 15, '17:19:40', '2021-05-01', 'efg456', 1),
(2, 20, '17:19:40', '2021-05-01', 'hil789', 3),
(7, 10, '17:20:36', '2021-05-01', 'fwke6', 7),
(8, 10, '17:20:36', '2021-05-01', 'hil789', 2),
(9, 5, '17:20:36', '2021-05-01', 'jhoe08', 6),
(11, 10, '12:04:55', '2021-05-04', 'efg456', 5),
(13, 15, '10:37:55', '2021-07-11', 'hil789', 3),
(15, 20, '10:39:14', '2021-07-11', 'hil789', 0),
(16, 5, '10:40:36', '2021-07-11', 'hil789', 2),
(17, 5, '10:41:08', '2021-07-11', 'hil789', 0);

--
-- Trigger `storicoproduzione`
--
DELIMITER $$
CREATE TRIGGER `checkCambio` BEFORE INSERT ON `storicoproduzione` FOR EACH ROW begin
	if ((select I1.spazioDisp from INVENTARIOS I1 where I1.tipoProd=new.IDprodotto)<new.quantitaProdotta) then
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Non posso depositare tutte queste unità';
	end if;

	if not exists (select I.settoreDeposito from INVENTARIOS I where I.tipoProd=new.IDprodotto) then
		insert into INVENTARIOS(tipoProd, quantitaTot, spazioDisp) values (new.IDprodotto, 0, 200);
	end if;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nuovoProdotto` AFTER INSERT ON `storicoproduzione` FOR EACH ROW begin
	declare i int default 0;
	
	update INVENTARIOS
	set quantitaTot=quantitaTot+new.quantitaProdotta, spazioDisp=200-quantitaTot
	where tipoProd=new.IDprodotto;
	
	while i<new.quantitaProdotta do
		insert into PRODOTTO values(FLOOR(RAND()*(8999-1000+1)+1000), new.IDprodotto, new.IDproduzione);
		set i=i+1;
	end while;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `tipo_prodottos`
--

CREATE TABLE `tipo_prodottos` (
  `IDprodotto` int(11) NOT NULL,
  `nomeProdotto` varchar(255) DEFAULT NULL,
  `tipologia` varchar(9) NOT NULL,
  `costoPerUnita` float NOT NULL,
  `descrizione` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `nomeTrad` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `tipo_prodottos`
--

INSERT INTO `tipo_prodottos` (`IDprodotto`, `nomeProdotto`, `tipologia`, `costoPerUnita`, `descrizione`, `img`, `nomeTrad`) VALUES
(0, 'Mozzarella di bufala', 'latticino', 10, 'Latticinio fresco tipico della Campania prodotto con latte di bufala in piccole forme rotondeggianti oppure in trecce.', 'https://i.imgur.com/qhNdYkC.jpg', 'mozzarella'),
(1, 'Orzo', 'cereale', 2.5, 'L’orzo comune è la specie economicamente più importante tra quelle coltivate del genere Hordeum, quella da cui si ricava l\'orzo alimentare da cui dipende una considerevole parte dell\'alimentazione mondiale.', 'https://i.imgur.com/LIYpK4U.jpg', 'barley'),
(2, 'Ricotta', 'latticino', 3.3, 'La ricotta (dal latino recocta) è un prodotto caseario, più precisamente un latticino. La ricotta viene ottenuta attraverso la coagulazione delle proteine del siero di latte, cioè la parte liquida che si separa dalla cagliata durante la caseificazione.', 'https://i.imgur.com/SfvOSUk.jpg', 'ricotta'),
(3, 'Pecorino', 'latticino', 3, 'Il Pecorino Romano è un formaggio italiano a denominazione di origine protetta, la cui zona di origine comprende il Lazio e la provincia di Grosseto.', 'https://i.imgur.com/evyP8Ia.jpg', 'romano'),
(4, 'Frumento', 'cereale', 2, 'Il grano o frumento, arcaicamente anche trittico, è un genere della famiglia graminacee, cereale di antica coltura, la cui area d\'origine è localizzata tra Mar Mediterraneo, Mar Nero e Mar Caspio.', 'https://i.imgur.com/rzCB39C.jpg', 'wheat'),
(5, 'Granturco', 'cereale', 3.8, 'Il mais è una pianta erbacea annuale della famiglia delle Poaceae, tribù delle Maydeae: addomesticato dalle popolazioni indigene in Messico centrale in tempi preistorici circa 10.000 anni fa.', 'https://i.imgur.com/YN7ZKIO.jpg', 'corn'),
(6, 'Provola', 'latticino', 4.5, 'La provola è un formaggio di latte vaccino, a latte crudo e a pasta cotta o pasta semicotta e filata. In genere ha la forma di una sfera schiacciata, dal peso di circa mezzo chilo. Una provola ottenuta da latte bufalino viene prodotta in Campania.', 'https://i.imgur.com/Aw243VD.jpg', 'provolone'),
(7, 'Riso', 'cereale', 6.2, 'Il riso o risoide è un alimento costituito dalla cariosside prodotta da diverse piante dei generi Oryza e Zizania, opportunamente lavorata. Le più note specie utilizzate sono l\'Oryza sativa e l\'Oryza glaberrima.', 'https://i.imgur.com/s7TzyB8.jpg', 'rice');

--
-- Trigger `tipo_prodottos`
--
DELIMITER $$
CREATE TRIGGER `insNewProd` AFTER INSERT ON `tipo_prodottos` FOR EACH ROW begin
	insert into INVENTARIOS(tipoProd, quantitaTot, spazioDisp) values (new.IDprodotto, 0, 200);
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `adminFlag` tinyint(1) DEFAULT 0,
  `pIvaCliente` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `adminFlag`, `pIvaCliente`) VALUES
(2, 'gigimix', '5f4dcc3b5aa765d61d8327deb882cf99', 'gigimix99@gmail.com', 0, '53806'),
(3, 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', 'francesco.vattiato@hotmail.it', 1, 'abc123'),
(6, 'cicciox', '5f4dcc3b5aa765d61d8327deb882cf99', 'gianni@gmail.com', 0, 'axc345'),
(7, 'gerry', '5f4dcc3b5aa765d61d8327deb882cf99', 'Gerardovecchio2@hotmail.it', 0, 'eeeh789');

-- --------------------------------------------------------

--
-- Struttura per vista `oldbuy`
--
DROP TABLE IF EXISTS `oldbuy`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `oldbuy`  AS SELECT `o`.`IDordine` AS `IDordine`, `o`.`nDeposito` AS `nDeposito`, `o`.`IDcliente` AS `IDcliente`, `o`.`IDmagazz` AS `IDmagazz`, `o`.`quantitaRichiesta` AS `quantitaRichiesta`, `o`.`dataOrdine` AS `dataOrdine`, `o`.`costoTot` AS `costoTot`, `o`.`pagato` AS `pagato`, `i`.`settoreDeposito` AS `settoreDeposito`, `i`.`tipoProd` AS `tipoProd`, `i`.`quantitaTot` AS `quantitaTot`, `i`.`spazioDisp` AS `spazioDisp`, `tp`.`IDprodotto` AS `IDprodotto`, `tp`.`nomeProdotto` AS `nomeProdotto`, `tp`.`tipologia` AS `tipologia`, `tp`.`costoPerUnita` AS `costoPerUnita`, `tp`.`descrizione` AS `descrizione`, `tp`.`img` AS `img` FROM ((`ordine` `o` join `inventarios` `i` on(`o`.`nDeposito` = `i`.`settoreDeposito`)) join `tipo_prodottos` `tp` on(`tp`.`IDprodotto` = `i`.`tipoProd`)) ;

-- --------------------------------------------------------

--
-- Struttura per vista `prezzounitinv`
--
DROP TABLE IF EXISTS `prezzounitinv`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `prezzounitinv`  AS SELECT `i`.`settoreDeposito` AS `settD`, `tp`.`costoPerUnita` AS `costouni` FROM (`inventarios` `i` join `tipo_prodottos` `tp` on(`i`.`tipoProd` = `tp`.`IDprodotto`)) ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `dipendente`
--
ALTER TABLE `dipendente`
  ADD PRIMARY KEY (`CF`),
  ADD KEY `idx_pa` (`prodottoAttuale`);

--
-- Indici per le tabelle `inventarios`
--
ALTER TABLE `inventarios`
  ADD PRIMARY KEY (`settoreDeposito`),
  ADD UNIQUE KEY `tipoProd` (`tipoProd`) USING BTREE,
  ADD KEY `idx_tp1` (`tipoProd`);

--
-- Indici per le tabelle `ordine`
--
ALTER TABLE `ordine`
  ADD PRIMARY KEY (`IDordine`),
  ADD KEY `idx_nDep` (`nDeposito`),
  ADD KEY `idx_idc` (`IDcliente`),
  ADD KEY `idx_mag` (`IDmagazz`);

--
-- Indici per le tabelle `prodotto`
--
ALTER TABLE `prodotto`
  ADD PRIMARY KEY (`nTimbro`,`tipoPr`,`prProdutt`),
  ADD KEY `idx_tipo` (`tipoPr`),
  ADD KEY `idx_prp` (`prProdutt`);

--
-- Indici per le tabelle `storicoproduzione`
--
ALTER TABLE `storicoproduzione`
  ADD PRIMARY KEY (`IDproduzione`),
  ADD KEY `idx_dip` (`IDdip`),
  ADD KEY `idx_pr` (`IDprodotto`);

--
-- Indici per le tabelle `tipo_prodottos`
--
ALTER TABLE `tipo_prodottos`
  ADD PRIMARY KEY (`IDprodotto`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pivacli` (`pIvaCliente`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `inventarios`
--
ALTER TABLE `inventarios`
  MODIFY `settoreDeposito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT per la tabella `ordine`
--
ALTER TABLE `ordine`
  MODIFY `IDordine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT per la tabella `storicoproduzione`
--
ALTER TABLE `storicoproduzione`
  MODIFY `IDproduzione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `dipendente`
--
ALTER TABLE `dipendente`
  ADD CONSTRAINT `dipendente_ibfk_1` FOREIGN KEY (`prodottoAttuale`) REFERENCES `tipo_prodottos` (`IDprodotto`);

--
-- Limiti per la tabella `inventarios`
--
ALTER TABLE `inventarios`
  ADD CONSTRAINT `inventarios_ibfk_1` FOREIGN KEY (`tipoProd`) REFERENCES `tipo_prodottos` (`IDprodotto`);

--
-- Limiti per la tabella `ordine`
--
ALTER TABLE `ordine`
  ADD CONSTRAINT `ordine_ibfk_1` FOREIGN KEY (`nDeposito`) REFERENCES `inventarios` (`settoreDeposito`),
  ADD CONSTRAINT `ordine_ibfk_2` FOREIGN KEY (`IDcliente`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `ordine_ibfk_3` FOREIGN KEY (`IDmagazz`) REFERENCES `dipendente` (`CF`);

--
-- Limiti per la tabella `prodotto`
--
ALTER TABLE `prodotto`
  ADD CONSTRAINT `prodotto_ibfk_1` FOREIGN KEY (`tipoPr`) REFERENCES `tipo_prodottos` (`IDprodotto`),
  ADD CONSTRAINT `prodotto_ibfk_2` FOREIGN KEY (`prProdutt`) REFERENCES `storicoproduzione` (`IDproduzione`);

--
-- Limiti per la tabella `storicoproduzione`
--
ALTER TABLE `storicoproduzione`
  ADD CONSTRAINT `storicoproduzione_ibfk_1` FOREIGN KEY (`IDdip`) REFERENCES `dipendente` (`CF`),
  ADD CONSTRAINT `storicoproduzione_ibfk_2` FOREIGN KEY (`IDprodotto`) REFERENCES `tipo_prodottos` (`IDprodotto`);

--
-- Limiti per la tabella `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`pIvaCliente`) REFERENCES `clientes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
