-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 15. Jul 2012 um 21:26
-- Server Version: 5.5.16
-- PHP-Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `froxlor_billing`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_active_backend_user`
--

CREATE TABLE IF NOT EXISTS `tbl_active_backend_user` (
  `backend_user_id` int(11) NOT NULL,
  `session_id` char(32) NOT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `expiration_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`backend_user_id`),
  KEY `fk_active_backend_user_backend_user_id` (`backend_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `tbl_active_backend_user`
--

INSERT INTO `tbl_active_backend_user` (`backend_user_id`, `session_id`, `start_date`, `expiration_date`) VALUES
(1, '7pod5fubt73j03qojprbvmba24', '2012-07-15 19:10:09', '2012-07-15 19:52:07');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_active_customer`
--

CREATE TABLE IF NOT EXISTS `tbl_active_customer` (
  `customer_id` int(11) NOT NULL,
  `session_id` char(32) NOT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `expiration_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`customer_id`),
  KEY `fk_active_customer_customer_id` (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_backend_user`
--

CREATE TABLE IF NOT EXISTS `tbl_backend_user` (
  `backend_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`backend_user_id`),
  UNIQUE KEY `backend_user_id_UNIQUE` (`backend_user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `tbl_backend_user`
--

INSERT INTO `tbl_backend_user` (`backend_user_id`, `first_name`, `last_name`, `password`, `email`) VALUES
(1, 'Admin', 'Admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin@projektplatz.eu');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_content`
--

CREATE TABLE IF NOT EXISTS `tbl_content` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `text` mediumtext,
  PRIMARY KEY (`content_id`,`language_id`),
  KEY `fk_content_language_id` (`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `tbl_content`
--

INSERT INTO `tbl_content` (`content_id`, `language_id`, `title`, `text`) VALUES
(1, 1, 'Impressum', '&lt;p&gt;\n	Angaben gem&amp;auml;&amp;szlig; &amp;sect; 5 TMG:&lt;br /&gt;\n	&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;\n	Max Mustermann&lt;br /&gt;\n	Froxcloud&lt;br /&gt;\n	Musterstra&amp;szlig;e 111&lt;br /&gt;\n	90210 Musterstadt&lt;/p&gt;\n&lt;p&gt;\n	&amp;nbsp;&lt;/p&gt;\n&lt;h3&gt;\n	Kontakt:&lt;/h3&gt;\n&lt;table&gt;\n	&lt;tbody&gt;\n		&lt;tr&gt;\n			&lt;td&gt;\n				&lt;p&gt;\n					Telefon:&lt;/p&gt;\n			&lt;/td&gt;\n			&lt;td&gt;\n				&lt;p&gt;\n					+49 (0) 123 44 55 66&lt;/p&gt;\n			&lt;/td&gt;\n		&lt;/tr&gt;\n		&lt;tr&gt;\n			&lt;td&gt;\n				&lt;p&gt;\n					Telefax:&lt;/p&gt;\n			&lt;/td&gt;\n			&lt;td&gt;\n				&lt;p&gt;\n					+49 (0) 123 44 55 99&lt;/p&gt;\n			&lt;/td&gt;\n		&lt;/tr&gt;\n		&lt;tr&gt;\n			&lt;td&gt;\n				&lt;p&gt;\n					E-Mail:&lt;/p&gt;\n			&lt;/td&gt;\n			&lt;td&gt;\n				&lt;p&gt;\n					info@projektplatz.eu&lt;/p&gt;\n			&lt;/td&gt;\n		&lt;/tr&gt;\n	&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;h3&gt;\n	Umsatzsteuer-ID:&lt;/h3&gt;\n&lt;p&gt;\n	Umsatzsteuer-Identifikationsnummer gem&amp;auml;&amp;szlig; &amp;sect;27 a Umsatzsteuergesetz:&lt;/p&gt;\n'),
(1, 2, 'imprint', 'This will be the imprint'),
(2, 1, 'Startseite', '<p> Herzlich Willkommen auf Froxcloud!</p><p> Wir freuen Sie hier als Besucher begrüßen zu dürfen und hoffen, dass Sie bald auch Kunde von uns sind.</p><p> &nbsp;</p><p> Froxcloud ist eine Musterfirma, welche virtuelle Webserverkapazitäten auf Basis der Server Management Software Froxlor anbietet.</p><p> &nbsp;</p><p> Viel Spaß beim weiteren Durchstöbern der Seiten.</p><p> &nbsp;</p><p> Ihr Froxcloud Team!</p>'),
(2, 2, 'home', '<p> Welcome to Froxcloud!</p><p>Froxcloud is a demo enterprise that sell virtual webspace on a Froxlor based infrastructure.</p><p> &nbsp;</p><p>Best regards,</p><p> &nbsp;</p><p> The Froxcloud Team</p>'),
(3, 1, 'Allgemeine Geschäftsbedingungen', '&lt;div align=&quot;center&quot;&gt;\n	&lt;b&gt;Allgemeine Gesch&amp;auml;ftsbedingungen (AGB)&lt;/b&gt;&lt;/div&gt;\n&lt;p&gt;\n	&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;\n	&lt;strong&gt;&amp;sect;1 Geltung gegen&amp;uuml;ber Unternehmern und Begriffsdefinitionen&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;\n	(1) Die nachfolgenden Allgemeinen Gesch&amp;auml;ftbedingungen gelten f&amp;uuml;r alle Lieferungen zwischen uns und einem Verbraucher in ihrer zum Zeitpunkt der Bestellung g&amp;uuml;ltigen Fassung.&lt;br /&gt;\n	&lt;br /&gt;\n	(2) &amp;bdquo;Verbraucher&amp;ldquo; in Sinne dieser Gesch&amp;auml;ftsbedingungen ist jede nat&amp;uuml;rliche Person, die ein Rechtsgesch&amp;auml;ft zu einem Zwecke abschlie&amp;szlig;t, der weder ihrer gewerblichen noch ihrer selbst&amp;auml;ndigen beruflichen T&amp;auml;tigkeit zugerechnet werden kann.&lt;/p&gt;\n&lt;p&gt;\n	&lt;strong&gt;&amp;sect;2 Zustandekommen eines Vertrages, Speicherung des Vertragstextes&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;\n	(1) Die folgenden Regelungen &amp;uuml;ber den Vertragsabschluss gelten f&amp;uuml;r Bestellungen &amp;uuml;ber unseren Internetshop http://www.beispielshop-online.de .&lt;br /&gt;\n	&lt;br /&gt;\n	&lt;strong&gt;(2) Im Falle des Vertragsschlusses kommt der Vertrag mit&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;\n	&lt;br /&gt;\n	&lt;strong&gt;Froxlor Online-Shop&lt;br /&gt;\n	Klaus Muster&lt;br /&gt;\n	Beispielstrasse 42&lt;br /&gt;\n	D-98765 Musterstadt&lt;br /&gt;\n	Registernummer 12131415&lt;br /&gt;\n	Registergericht Amtsgericht Musterstadt&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;\n	&lt;strong&gt;zustande.&lt;/strong&gt;&lt;br /&gt;\n	&lt;br /&gt;\n	(3) Die Pr&amp;auml;sentation der Waren in unserem Internetshop stellen kein rechtlich bindendes Vertragsangebot unsererseits dar, sondern sind nur eine unverbindliche Aufforderungen an den Verbraucher, Waren zu bestellen. Mit der Bestellung der gew&amp;uuml;nschten Ware gibt der Verbraucher ein f&amp;uuml;r ihn verbindliches Angebot auf Abschluss eines Kaufvertrages ab.&lt;br /&gt;\n	(4) Bei Eingang einer Bestellung in unserem Internetshop gelten folgende Regelungen: Der Verbraucher gibt ein bindendes Vertragsangebot ab, indem er die in unserem Internetshop vorgesehene Bestellprozedur erfolgreich durchl&amp;auml;uft.&lt;br /&gt;\n	&lt;br /&gt;\n	Die Bestellung erfolgt in folgenden Schritten:&lt;/p&gt;\n&lt;p&gt;\n	1) Auswahl der gew&amp;uuml;nschten Ware&lt;br /&gt;\n	2) Best&amp;auml;tigen durch Anklicken der Buttons &amp;bdquo;Bestellen&amp;ldquo;&lt;br /&gt;\n	3) Pr&amp;uuml;fung der Angaben im Warenkorb&lt;br /&gt;\n	4) Bet&amp;auml;tigung des Buttons &amp;bdquo;zur Kasse&amp;ldquo;&lt;br /&gt;\n	5) Anmeldung im Internetshop nach Registrierung und Eingabe der Anmelderangaben (E-Mail-Adresse und Passwort).&lt;br /&gt;\n	6) Nochmalige Pr&amp;uuml;fung bzw. Berichtigung der jeweiligen eingegebenen Daten.&lt;br /&gt;\n	7) Verbindliche Absendung der Bestellung.&lt;/p&gt;\n&lt;p&gt;\n	Der Verbraucher kann vor dem verbindlichen Absenden der Bestellung durch Bet&amp;auml;tigen der in dem von ihm verwendeten Internet-Browser enthaltenen &amp;bdquo;Zur&amp;uuml;ck&amp;ldquo;-Taste nach Kontrolle seiner Angaben wieder zu der Internetseite gelangen, auf der die Angaben des Kunden erfasst werden und Eingabefehler berichtigen bzw. durch Schlie&amp;szlig;en des Internetbrowsers den Bestellvorgang abbrechen. Wir best&amp;auml;tigen den Eingang der Bestellung unmittelbar durch eine automatisch generierte E-Mail (&amp;bdquo;Auftragsbest&amp;auml;tigung&amp;ldquo;). Mit dieser nehmen wir Ihr Angebot an.&lt;br /&gt;\n	&lt;br /&gt;\n	(5) Speicherung des Vertragstextes bei Bestellungen &amp;uuml;ber unseren Internetshop : Wir senden Ihnen die Bestelldaten und unsere AGB per E-Mail zu. Die AGB k&amp;ouml;nnen Sie jederzeit auch unter http://www.beispielshop-online.de/agb.html einsehen. Ihre Bestelldaten sind aus Sicherheitsgr&amp;uuml;nden nicht mehr &amp;uuml;ber das Internet zug&amp;auml;nglich.&lt;/p&gt;\n&lt;p&gt;\n	&lt;strong&gt;&amp;sect;3 Preise, Versandkosten, Zahlung, F&amp;auml;lligkeit&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;\n	(1) Die angegebenen Preise enthalten die gesetzliche Umsatzsteuer und sonstige Preisbestandteile. Hinzu kommen etwaige Versandkosten.&lt;br /&gt;\n	&lt;br /&gt;\n	(2) Der Verbraucher hat die M&amp;ouml;glichkeit der Zahlung per Vorkasse, Kreditkarte( Visa ) .&lt;br /&gt;\n	&lt;br /&gt;\n	(3) Hat der Verbraucher die Zahlung per Vorkasse gew&amp;auml;hlt, so verpflichtet er sich, den Kaufpreis unverz&amp;uuml;glich nach Vertragsschluss zu zahlen.&lt;/p&gt;\n&lt;p&gt;\n	&lt;strong&gt;&amp;sect;4 Lieferung&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;\n	(1) Sofern wir dies in der Produktbeschreibung nicht deutlich anders angegeben haben, sind alle von uns angebotenen Artikel sofort versandfertig.&lt;br /&gt;\n	&lt;br /&gt;\n	(2) Hat der Verbraucher die Zahlung per Vorkasse gew&amp;auml;hlt, so versenden wir die Ware nicht vor Zahlungseingang.&lt;/p&gt;\n&lt;p&gt;\n	&lt;strong&gt;&amp;sect;5 Eigentumsvorbehalt&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;\n	Wir behalten uns das Eigentum an der Ware bis zur vollst&amp;auml;ndigen Bezahlung des Kaufpreises vor.&lt;br /&gt;\n	&lt;br /&gt;\n	****************************************************************************************************&lt;/p&gt;\n&lt;p&gt;\n	&lt;strong&gt;&amp;sect;6 Widerrufsrecht&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;\n	&lt;strong&gt;Widerrufsbelehrung&lt;br /&gt;\n	&lt;br /&gt;\n	Widerrufsrecht&lt;br /&gt;\n	&lt;br /&gt;\n	Sie k&amp;ouml;nnen Ihre Vertragserkl&amp;auml;rung innerhalb von 14 Tagen ohne Angabe von Gr&amp;uuml;nden in Textform (z. B. Brief, Fax, E-Mail) oder &amp;ndash; wenn Ihnen die Sache vor Fristablauf &amp;uuml;berlassen wird &amp;ndash; auch durch R&amp;uuml;cksendung der Sache widerrufen. Die Frist beginnt nach Erhalt dieser Belehrung in Textform, jedoch nicht vor Eingang der Ware beim Empf&amp;auml;nger (bei der wiederkehrenden Lieferung gleichartiger Waren nicht vor Eingang der ersten Teillieferung) und auch nicht vor Erf&amp;uuml;llung unserer Informationspflichten gem&amp;auml;&amp;szlig; Artikel 246 &amp;sect; 2 in Verbindung mit &amp;sect; 1 Abs. 1 und 2 EGBGB sowie unserer Pflichten gem&amp;auml;&amp;szlig; &amp;sect; 312g Abs. 1 Satz 1 BGB in Verbindung mit Artikel 246 &amp;sect; 3 EGBGB. Zur Wahrung der Widerrufsfrist gen&amp;uuml;gt die rechtzeitige Absendung des Widerrufs oder der Sache.&lt;br /&gt;\n	&lt;br /&gt;\n	Der Widerruf ist zu richten an:&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;\n	&lt;strong&gt;Froxlor Online-Shop&lt;br /&gt;\n	Klaus Muster&lt;br /&gt;\n	Beispielstrasse 42&lt;br /&gt;\n	D-98765 Musterstadt&lt;br /&gt;\n	E-Mail shop@beispielshop.com&lt;br /&gt;\n	Telefax 05123 45678910&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;\n	&lt;br /&gt;\n	&lt;strong&gt;Widerrufsfolgen&lt;br /&gt;\n	&lt;br /&gt;\n	Im Falle eines wirksamen Widerrufs sind die beiderseits empfangenen Leistungen zur&amp;uuml;ckzugew&amp;auml;hren und ggf. gezogene Nutzungen (z. B. Zinsen) herauszugeben. K&amp;ouml;nnen Sie uns die empfangene Leistung sowie Nutzungen (z. B. Gebrauchsvorteile) nicht oder teilweise nicht oder nur in verschlechtertem Zustand zur&amp;uuml;ckgew&amp;auml;hren beziehungsweise herausgeben, m&amp;uuml;ssen Sie uns insoweit Wertersatz leisten. F&amp;uuml;r die Verschlechterung der Sache und f&amp;uuml;r gezogene Nutzungen m&amp;uuml;ssen Sie Wertersatz nur leisten, soweit die Nutzungen oder die Verschlechterung auf einen Umgang mit der Sache zur&amp;uuml;ckzuf&amp;uuml;hren ist, der &amp;uuml;ber die Pr&amp;uuml;fung der Eigenschaften und der Funktionsweise hinausgeht. Unter &amp;bdquo;Pr&amp;uuml;fung der Eigenschaften und der Funktionsweise&amp;ldquo; versteht man das Testen und Ausprobieren der jeweiligen Ware, wie es etwa im Ladengesch&amp;auml;ft m&amp;ouml;glich und &amp;uuml;blich ist.&lt;br /&gt;\n	Paketversandf&amp;auml;hige Sachen sind auf unsere Gefahr zur&amp;uuml;ckzusenden. Sie haben die regelm&amp;auml;&amp;szlig;igen Kosten der R&amp;uuml;cksendung zu tragen, wenn die gelieferte Ware der bestellten entspricht und wenn der Preis der zur&amp;uuml;ckzusendenden Sache einen Betrag von 40 Euro nicht &amp;uuml;bersteigt oder wenn Sie bei einem h&amp;ouml;heren Preis der Sache zum Zeitpunkt des Widerrufs noch nicht die Gegenleistung oder eine vertraglich vereinbarte Teilzahlung erbracht haben. Anderenfalls ist die R&amp;uuml;cksendung f&amp;uuml;r Sie kostenfrei. Nicht paketversandf&amp;auml;hige Sachen werden bei Ihnen abgeholt. Verpflichtungen zur Erstattung von Zahlungen m&amp;uuml;ssen innerhalb von 30 Tagen erf&amp;uuml;llt werden. Die Frist beginnt f&amp;uuml;r Sie mit der Absendung Ihrer Widerrufserkl&amp;auml;rung oder der Sache, f&amp;uuml;r uns mit deren Empfang.&lt;br /&gt;\n	&lt;br /&gt;\n	Ende der Widerrufsbelehrung&lt;/strong&gt;&lt;br /&gt;\n	&lt;br /&gt;\n	****************************************************************************************************&lt;/p&gt;\n&lt;p&gt;\n	&lt;strong&gt;&amp;sect;7 Vertragliche Regelung bez&amp;uuml;glich der R&amp;uuml;cksendekosten bei Widerruf&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;\n	Sollten Sie von Ihrem Widerrufsrecht Gebrauch machen, so gilt im Einklang mit &amp;sect; 357 Abs. 2 BGB, folgende Vereinbarung, nach der Sie die regelm&amp;auml;&amp;szlig;igen Kosten der R&amp;uuml;cksendung zu tragen haben, wenn die gelieferte Ware der bestellten entspricht und wenn der Preis der zur&amp;uuml;ckzusendenden Sache einen Betrag von 40 Euro nicht &amp;uuml;bersteigt oder wenn Sie bei einem h&amp;ouml;heren Preis der Sache zum Zeitpunkt des Widerrufs noch nicht die Gegenleistung oder eine vertraglich vereinbarte Teilzahlung erbracht haben.&lt;br /&gt;\n	Anderenfalls ist die R&amp;uuml;cksendung f&amp;uuml;r Sie kostenfrei.&lt;/p&gt;\n&lt;p&gt;\n	&lt;strong&gt;&amp;sect;8 Verhaltenskodex&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;\n	Wir haben uns den Verhaltenskodizes der folgenden Einrichtungen unterworfen:&lt;/p&gt;\n&lt;p style=&quot;margin-left:15.0pt;&quot;&gt;\n	Euro-Label Germany&lt;br /&gt;\n	EHI-EuroHandelsinstitut GmbH&lt;br /&gt;\n	Spichernstra&amp;szlig;e 55&lt;br /&gt;\n	50672 K&amp;ouml;ln&lt;/p&gt;\n&lt;p&gt;\n	Den Euro-Label Verhaltenskodex k&amp;ouml;nnen Sie durch Anklicken des auf unserer Webseite angebrachten Euro-Label-Siegels oder unter http://www.euro-label.com abrufen.&lt;br /&gt;\n	&lt;br /&gt;\n	und&lt;/p&gt;\n&lt;p style=&quot;margin-left:15.0pt;&quot;&gt;\n	Trusted Shops GmbH&lt;br /&gt;\n	Colonius Carr&amp;eacute;&lt;br /&gt;\n	Subbelrather Stra&amp;szlig;e 15c&lt;br /&gt;\n	50823 K&amp;ouml;ln&lt;/p&gt;\n&lt;p&gt;\n	Den Trusted Shops Verhaltenskodex k&amp;ouml;nnen Sie durch Anklicken des auf unserer Webseite angebrachten Trusted-Shops-Siegels oder unter www.trustedshops.de abrufen.&lt;/p&gt;\n&lt;p&gt;\n	&lt;strong&gt;&amp;sect;9 Vertragsprache&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;\n	Als Vertragssprache steht ausschlie&amp;szlig;lich Deutsch zur Verf&amp;uuml;gung.&lt;br /&gt;\n	&lt;br /&gt;\n	****************************************************************************************************&lt;/p&gt;\n&lt;p&gt;\n	&lt;strong&gt;&amp;sect;10 Kundendienst&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;\n	&lt;strong&gt;Unser Kundendienst f&amp;uuml;r Fragen, Reklamationen und Beanstandungen steht Ihnen werktags von 9:00 Uhr bis 17:30 Uhr unter&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;margin-left:15.0pt;&quot;&gt;\n	&lt;strong&gt;Telefon: 05123 45678911&lt;br /&gt;\n	Telefax: 05123 45678912&lt;br /&gt;\n	E-Mail: service@beispielshop.de&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;\n	&lt;strong&gt;zur Verf&amp;uuml;gung.&lt;/strong&gt;&lt;br /&gt;\n	&lt;br /&gt;\n	****************************************************************************************************&lt;/p&gt;\n&lt;p&gt;\n	Stand der AGB Jul.2012&lt;/p&gt;\n&lt;p&gt;\n	&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;\n	&amp;nbsp;&lt;/p&gt;\n'),
(4, 1, 'Zahlbedingungen', 'Die Rechnung ist zahlbar innerhalb von 14 Tagen nach Erhalt der Rechnung.'),
(4, 2, 'terms', 'Invoice payable within 14 days of receipt of the invoice.'),
(6, 1, 'Hilfe', '&lt;h3&gt;\n	FAQ&lt;/h3&gt;\n&lt;ol&gt;\n	&lt;li&gt;\n		Was ist Froxcloud?\n		&lt;ul&gt;\n			&lt;li&gt;\n				Froxcloud erm&amp;ouml;glicht Ihnen das Betreiben ihrer eigenen Webpr&amp;auml;senz im weltweiten Internet. Und das zuverl&amp;auml;ssig, schnell und zu einem unschlagbaren Preis. Dabei bieten wir Ihnen Zugriff auf unser Netzwerk von Webservern und gew&amp;auml;hrleisten damit eine optimale Lastverteilung unserer Kunden. Gleichzeitig k&amp;ouml;nnen wir somit unsere vorhandenen Kapazit&amp;auml;ten gleichm&amp;auml;&amp;szlig;iger auslasten, was Ihnen durch einen geringeren j&amp;auml;hrlichen Preis zu Gute kommt.&lt;/li&gt;\n		&lt;/ul&gt;\n	&lt;/li&gt;\n	&lt;li&gt;\n		Kann jeder Kunde werden? Wenn ja, wie?\n		&lt;ul&gt;\n			&lt;li&gt;\n				Ja jeder kann Kunde bei Froxcloud werden. W&amp;auml;hlen Sie den Men&amp;uuml;punkt &amp;bdquo;Kundenbereich&amp;ldquo; - Es &amp;ouml;ffnet sich ein Popup-Fenster zum Login. Klicken Sie den Link &amp;bdquo;Registrieren&amp;ldquo; im unteren Bereich des Fensters. Es &amp;ouml;ffnet sich nun ein Registrierungsformular. F&amp;uuml;llen Sie hier bitte alle mit * gekennzeichneten Felder aus. Alle anderen Felder sind optional. Beachten Sie jedoch: Je mehr Kontaktdaten Sie angeben, desto besser k&amp;ouml;nnen wir Sie bei Fragen zu Ihrer Bestellung erreichen und desto schneller steht Ihnen Ihr Produkt zur Verf&amp;uuml;gung. W&amp;auml;hlen Sie nach dem Ausf&amp;uuml;llen des Formulars &amp;bdquo;Registrierung abschlie&amp;szlig;en&amp;ldquo;. Danach sind Sie registrierter Kunde bei Froxcloud und Sie k&amp;ouml;nnen in nur wenigen Schritten Produkte Ihrer Wahl bestellen.&lt;/li&gt;\n		&lt;/ul&gt;\n	&lt;/li&gt;\n	&lt;li&gt;\n		Gibt es Einschr&amp;auml;nkungen mit meinem Froxcloud Produkt gegen&amp;uuml;ber Mitbewerbern?\n		&lt;ul&gt;\n			&lt;li&gt;\n				Nein! Sie erhalten volle Kontrolle &amp;uuml;ber den von Ihnen gemieteten Speicherplatz. Au&amp;szlig;erdem k&amp;ouml;nnen Sie eigene E-Mail Postf&amp;auml;cher einrichten, so dass beispielsweise jedes Familienmitglied eine eigene E-Mail Adresse erh&amp;auml;lt.&lt;/li&gt;\n		&lt;/ul&gt;\n	&lt;/li&gt;\n	&lt;li&gt;\n		Was ist wenn ich mein Passwort vergessen habe?\n		&lt;ul&gt;\n			&lt;li&gt;\n				Wenn Sie Ihr Passwort vergessen haben, teilen Sie es uns &amp;uuml;ber das Kontaktformular mit. Wir helfen Ihnen gerne weiter.&lt;/li&gt;\n		&lt;/ul&gt;\n	&lt;/li&gt;\n	&lt;li&gt;\n		Kann ich meine Daten irgendwo &amp;auml;ndern?\n		&lt;ul&gt;\n			&lt;li&gt;\n				Ja, w&amp;auml;hlen Sie im Kundenbereiche unter &amp;bdquo;Meine Daten&amp;ldquo; im unteren Bereich &amp;bdquo;Meine Daten bearbeiten&amp;ldquo;.&lt;/li&gt;\n		&lt;/ul&gt;\n	&lt;/li&gt;\n	&lt;li&gt;\n		Wie kann ich meinen Vertrag k&amp;uuml;ndigen?\n		&lt;ul&gt;\n			&lt;li&gt;\n				Im Kundenbereich bei der Produkt&amp;uuml;bersicht k&amp;ouml;nnen Sie ganz einfach ihren Vertrag zum Ablaufdatum ihres bestehenden Vertrages k&amp;uuml;ndigen.&lt;/li&gt;\n		&lt;/ul&gt;\n	&lt;/li&gt;\n&lt;/ol&gt;\n&lt;p&gt;\n	&lt;strong&gt;Ihre Frage ist nicht dabei?&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;\n	&lt;strong&gt;Teilen Sie sie uns &amp;uuml;ber das Kontaktformular mit, wir helfen Ihnen gerne weiter!&lt;/strong&gt;&lt;/p&gt;\n'),
(6, 2, 'help', '&lt;h3&gt;\n	FAQ&lt;/h3&gt;\n&lt;ol&gt;\n	&lt;li&gt;\n		What is Froxcloud?\n		&lt;ul&gt;\n			&lt;li&gt;\n				With Froxcloud you can operate an own website in a reliably and fast way for an unbeatable price. We provide access to our network of webservers and guarantee an optimum load distribution.&lt;/li&gt;\n		&lt;/ul&gt;\n	&lt;/li&gt;\n	&lt;li&gt;\n		Can everybody become a Froxcloud customer? If so, how?\n		&lt;ul&gt;\n			&lt;li&gt;\n				Yes, everybody can become a customer. For registration choose &amp;ldquo;customer center&amp;rdquo; in the main menu. A popup will be opened. Now click on link &amp;ldquo;register&amp;rdquo;. Fill in the form and confirm your registration. After that you are a registered Froxcloud customer and can buy products in a few simple steps.&lt;/li&gt;\n		&lt;/ul&gt;\n	&lt;/li&gt;\n	&lt;li&gt;\n		Are there any limitations with my Froxcloud product to competitors?\n		&lt;ul&gt;\n			&lt;li&gt;\n				No! Froxcloud gives you full control over your rented memory space. Furthermore you can implement own email inboxes so that, for example, each family member get their own email address.&lt;/li&gt;\n		&lt;/ul&gt;\n	&lt;/li&gt;\n	&lt;li&gt;\n		What to do if I forget my password?\n		&lt;ul&gt;\n			&lt;li&gt;\n				Please contact us by using the contact form. We will reset your password and inform you via email.&lt;/li&gt;\n		&lt;/ul&gt;\n	&lt;/li&gt;\n	&lt;li&gt;\n		Can I change my personal data anywhere?\n		&lt;ul&gt;\n			&lt;li&gt;\n				Yes, please choose &amp;quot;My Data&amp;quot; in the customer center. Then choose &amp;quot;Edit my Data&amp;quot; at the bottom of this page.&lt;/li&gt;\n		&lt;/ul&gt;\n	&lt;/li&gt;\n	&lt;li&gt;\n		Can I terminate my contract?\n		&lt;ul&gt;\n			&lt;li&gt;\n				You can simply terminate your contract to expiration date in the product overview in the customer center.&lt;/li&gt;\n		&lt;/ul&gt;\n	&lt;/li&gt;\n&lt;/ol&gt;\n&lt;p&gt;\n	&lt;strong&gt;This questions didn&amp;acute;t help you?&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;\n	&lt;strong&gt;Please communicate your question to us by using the contact form. We are happy to provide further assistance.&lt;/strong&gt;&lt;/p&gt;\n');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_contract`
--

CREATE TABLE IF NOT EXISTS `tbl_contract` (
  `contract_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_position_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `expiration_date` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `contract_periode` tinyint(4) NOT NULL,
  PRIMARY KEY (`contract_id`),
  UNIQUE KEY `contract_id_UNIQUE` (`contract_id`),
  KEY `fk_contract_customer_id` (`customer_id`),
  KEY `fk_contract_order_id` (`order_id`),
  KEY `fk_contract_invoice_id` (`invoice_id`),
  KEY `fk_contract_order_position_id` (`order_position_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_country`
--

CREATE TABLE IF NOT EXISTS `tbl_country` (
  `country_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `iso_code` char(2) NOT NULL,
  `country_name` varchar(100) NOT NULL,
  PRIMARY KEY (`country_id`,`language_id`),
  KEY `fk_country_language_id` (`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `tbl_country`
--

INSERT INTO `tbl_country` (`country_id`, `language_id`, `iso_code`, `country_name`) VALUES
(1, 1, 'DE', 'Deutschland'),
(1, 2, 'DE', 'Germany'),
(2, 1, 'AT', 'Österreich'),
(2, 2, 'AT', 'Austria'),
(3, 1, 'CH', 'Schweiz'),
(3, 2, 'CH', 'Switzerland');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_currency`
--

CREATE TABLE IF NOT EXISTS `tbl_currency` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) NOT NULL,
  `code` char(3) NOT NULL,
  `symbol` varchar(12) NOT NULL,
  `decimal_point` char(1) NOT NULL,
  `thousands_point` char(1) NOT NULL,
  `decimal_places` char(1) NOT NULL,
  PRIMARY KEY (`currency_id`),
  UNIQUE KEY `currency_id_UNIQUE` (`currency_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `tbl_currency`
--

INSERT INTO `tbl_currency` (`currency_id`, `title`, `code`, `symbol`, `decimal_point`, `thousands_point`, `decimal_places`) VALUES
(1, 'Euro', 'EUR', '€', ',', '.', '2'),
(2, 'US Dollar', 'USD', '$', '.', '.', '2');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_customer`
--

CREATE TABLE IF NOT EXISTS `tbl_customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `gender` char(1) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `shipping_address` int(11) NOT NULL,
  `billing_address` int(11) NOT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `registered_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password` varchar(40) NOT NULL,
  `customer_number` char(10) DEFAULT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `customer_id_UNIQUE` (`customer_id`),
  KEY `fk_customer_shipping_address` (`shipping_address`),
  KEY `fk_customer_billing_address` (`billing_address`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `tbl_customer`
--

INSERT INTO `tbl_customer` (`customer_id`, `gender`, `title`, `first_name`, `last_name`, `company`, `shipping_address`, `billing_address`, `telephone`, `fax`, `email`, `registered_on`, `password`, `customer_number`) VALUES
(1, 'm', '', 'Max', 'Lührig', '', 1, 1, '', '', 'max.luehrig@bymaxe.de', '2012-07-15 19:02:48', '32c06449e8ec191c4f647c61babfbfe84c67b84f', 'K-1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_customer_address`
--

CREATE TABLE IF NOT EXISTS `tbl_customer_address` (
  `customer_address_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  `street_number` varchar(5) NOT NULL,
  `post_code` varchar(10) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country_code` int(11) NOT NULL,
  PRIMARY KEY (`customer_address_id`),
  UNIQUE KEY `customer_address_id_UNIQUE` (`customer_address_id`),
  KEY `fk_customer_address_country_id` (`country_code`),
  KEY `fk_customer_address_customer_id` (`customer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `tbl_customer_address`
--

INSERT INTO `tbl_customer_address` (`customer_address_id`, `customer_id`, `street`, `street_number`, `post_code`, `city`, `country_code`) VALUES
(1, 1, 'Lorscher Platz', '5', '69181', 'Leimen', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_customizing`
--

CREATE TABLE IF NOT EXISTS `tbl_customizing` (
  `key` varchar(100) NOT NULL,
  `language_id` int(11) DEFAULT NULL,
  `value` varchar(255) NOT NULL,
  KEY `fk_customizing_language_id` (`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `tbl_customizing`
--

INSERT INTO `tbl_customizing` (`key`, `language_id`, `value`) VALUES
('site_title', 1, 'Froxlorcloud'),
('site_title', 2, 'Froxlorcloud'),
('default_language', NULL, '1'),
('min_password_length', NULL, '8'),
('sys_gender_male', NULL, 'm'),
('sys_gender_female', NULL, 'f'),
('sys_customer_prefix', NULL, 'K'),
('sys_invoice_prefix', NULL, 'R'),
('business_standard_invoice_status', NULL, '1'),
('business_standard_order_status', NULL, '1'),
('business_standard_payment_periode', NULL, '14'),
('business_company_name', NULL, 'Froxlor Hosting Company'),
('business_company_president', NULL, 'Max Mustermann'),
('business_payment_bank_account', NULL, '12345678'),
('business_payment_bank_code', NULL, '09871100'),
('business_payment_swift_code', NULL, 'DE0111111111'),
('business_company_street', NULL, 'Mustergasse 1a'),
('business_company_founder_year', NULL, '2012'),
('business_company_city', NULL, 'Musterstadt'),
('business_company_post_code', NULL, '12345'),
('business_company_tel', NULL, '49 123 456789'),
('business_company_fax', NULL, '49 123 09876543'),
('sys_product_attribute_discspace', NULL, '1'),
('business_froxlor_client_prefix', NULL, 'FBS'),
('business_payment_bank_name', NULL, 'Hausbank'),
('business_payment_tax_id_number', NULL, '0987654321'),
('business_company_email', NULL, 'info@projektplatz.eu'),
('business_company_webpage', NULL, 'http://projektplatz.eu'),
('business_company_country', NULL, 'Germany'),
('business_company_billing_sender', NULL, 'billing@projektplatz.eu'),
('business_payment_payment_terms', NULL, '4'),
('business_payment_default_tax', NULL, '2'),
('business_payment_default_currency', NULL, '1'),
('sys_page_home', NULL, '2'),
('sys_page_imprint', NULL, '1'),
('sys_page_sitemap', NULL, '5'),
('sys_page_help', NULL, '6');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_invoice`
--

CREATE TABLE IF NOT EXISTS `tbl_invoice` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `issue_date` date NOT NULL,
  `payment_date` date NOT NULL,
  `payed_on` date DEFAULT NULL,
  `invoice_number` varchar(7) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `invoice_status` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `tax_id` int(11) NOT NULL,
  PRIMARY KEY (`invoice_id`),
  UNIQUE KEY `invoice_number_UNIQUE` (`invoice_id`),
  KEY `fk_invoice_customer_id` (`customer_id`),
  KEY `fk_invoice_order_id` (`order_id`),
  KEY `fk_invoice_invoice_status_id` (`invoice_status`),
  KEY `fk_invoice_currency_id` (`currency_id`),
  KEY `fk_invoice_tax_id` (`tax_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_invoice_status`
--

CREATE TABLE IF NOT EXISTS `tbl_invoice_status` (
  `invoice_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`invoice_status_id`,`language_id`),
  KEY `fk_invoice_status_language_id` (`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `tbl_invoice_status`
--

INSERT INTO `tbl_invoice_status` (`invoice_status_id`, `language_id`, `description`) VALUES
(1, 1, 'offen'),
(1, 2, 'pending'),
(2, 1, 'bezahlt'),
(2, 2, 'payed');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_language`
--

CREATE TABLE IF NOT EXISTS `tbl_language` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_name` varchar(50) NOT NULL,
  `iso_code` char(5) NOT NULL,
  PRIMARY KEY (`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `tbl_language`
--

INSERT INTO `tbl_language` (`language_id`, `language_name`, `iso_code`) VALUES
(1, 'Deutsch', 'de-de'),
(2, 'English', 'en-us');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_notice`
--

CREATE TABLE IF NOT EXISTS `tbl_notice` (
  `notice_id` int(11) NOT NULL AUTO_INCREMENT,
  `contract_id` int(11) NOT NULL,
  `termination_date` date NOT NULL,
  PRIMARY KEY (`notice_id`),
  KEY `fk_notice_contract_id` (`contract_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_order`
--

CREATE TABLE IF NOT EXISTS `tbl_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `order_status` int(11) NOT NULL,
  `customer_shipping_address` int(11) NOT NULL,
  `customer_billing_address` int(11) NOT NULL,
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_id_UNIQUE` (`order_id`),
  KEY `fk_order_customer_id` (`customer_id`),
  KEY `fk_order_order_status_id` (`order_status`),
  KEY `fk_order_shipping_address` (`customer_shipping_address`),
  KEY `fk_order_billing_address` (`customer_billing_address`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_order_position`
--

CREATE TABLE IF NOT EXISTS `tbl_order_position` (
  `order_position_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`order_position_id`),
  UNIQUE KEY `order_position_id_UNIQUE` (`order_position_id`),
  KEY `fk_order_position_product_id` (`product_id`),
  KEY `fk_order_position_order_id` (`order_id`),
  KEY `fk_order_position_order_position_detail_id` (`order_position_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_order_position_detail`
--

CREATE TABLE IF NOT EXISTS `tbl_order_position_detail` (
  `order_position_id` int(11) NOT NULL,
  `server_id` int(11) NOT NULL,
  `froxlor_customer_id` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`order_position_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_order_status`
--

CREATE TABLE IF NOT EXISTS `tbl_order_status` (
  `order_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`order_status_id`,`language_id`),
  KEY `fk_order_status_language_id` (`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `tbl_order_status`
--

INSERT INTO `tbl_order_status` (`order_status_id`, `language_id`, `description`) VALUES
(1, 1, 'offen'),
(1, 2, 'pending'),
(2, 1, 'abgeschlossen'),
(2, 2, 'completed');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_product`
--

CREATE TABLE IF NOT EXISTS `tbl_product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `contract_periode` tinyint(4) NOT NULL,
  `description` mediumtext,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`,`language_id`),
  KEY `fk_product_language_id` (`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `tbl_product`
--

INSERT INTO `tbl_product` (`product_id`, `language_id`, `title`, `contract_periode`, `description`, `quantity`, `price`, `active`) VALUES
(1, 1, 'Frox Small', 12, 'Ideal für den Einsteiger', 100, 10, 1),
(2, 1, 'Frox Medium', 6, 'Ideal für ein kleines Unternehmen', 50, 24.99, 1),
(3, 1, 'Frox Big', 3, 'Für das erfolgreiche Großunternehmen.', 20, 140.69, 1),
(1, 2, 'Frox Small', 12, 'Entry Level Product for private use.', 100, 10, 1),
(2, 2, 'Frox Medium', 6, 'For small and medium companies.', 50, 24.99, 1),
(3, 2, 'Frox Big', 3, 'Top-class product for large companies.', 20, 140.69, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_product_attribute`
--

CREATE TABLE IF NOT EXISTS `tbl_product_attribute` (
  `product_attribute_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`product_attribute_id`,`language_id`),
  KEY `fk_product_attribute_language_id` (`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `tbl_product_attribute`
--

INSERT INTO `tbl_product_attribute` (`product_attribute_id`, `language_id`, `description`) VALUES
(1, 1, 'Speicherplatz'),
(1, 2, 'Disk Space'),
(2, 1, 'E-Mail Postfächer'),
(2, 2, 'eMail Inboxes'),
(3, 1, 'Inklusivvolumen'),
(3, 2, 'Traffic');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_product_info`
--

CREATE TABLE IF NOT EXISTS `tbl_product_info` (
  `product_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`product_id`,`attribute_id`),
  KEY `fk_product_info_product_id` (`product_id`),
  KEY `fk_product_info_attribute_id` (`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `tbl_product_info`
--

INSERT INTO `tbl_product_info` (`product_id`, `attribute_id`, `value`) VALUES
(1, 1, '250'),
(1, 2, '5'),
(2, 1, '1000'),
(2, 2, '50'),
(3, 1, '4000'),
(3, 2, '500');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_reminder`
--

CREATE TABLE IF NOT EXISTS `tbl_reminder` (
  `reminder_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `reminder_type` int(11) NOT NULL,
  PRIMARY KEY (`reminder_id`),
  UNIQUE KEY `reminder_id_UNIQUE` (`reminder_id`),
  KEY `fk_reminder_customer_id` (`customer_id`),
  KEY `fk_reminder_order_id` (`order_id`),
  KEY `fk_reminder_reminder_type_id` (`reminder_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_reminder_type`
--

CREATE TABLE IF NOT EXISTS `tbl_reminder_type` (
  `reminder_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`reminder_type_id`,`language_id`),
  KEY `fk_reminder_type_language_id` (`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `tbl_reminder_type`
--

INSERT INTO `tbl_reminder_type` (`reminder_type_id`, `language_id`, `title`) VALUES
(1, 1, 'Erste Mahnung'),
(1, 2, 'first reminder'),
(2, 1, 'Zweite Mahnung'),
(2, 2, 'second reminder');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_server`
--

CREATE TABLE IF NOT EXISTS `tbl_server` (
  `server_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `mngmnt_ui` varchar(45) DEFAULT NULL,
  `ipv4` varchar(15) DEFAULT NULL,
  `ipv6` varchar(40) DEFAULT NULL,
  `froxlor_username` varchar(50) NOT NULL,
  `froxlor_password` varchar(40) NOT NULL,
  `froxlor_db` varchar(50) NOT NULL,
  `froxlor_db_host` varchar(255) DEFAULT NULL,
  `total_space` double DEFAULT NULL,
  `free_space` double DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`server_id`),
  UNIQUE KEY `server_id_UNIQUE` (`server_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `tbl_server`
--

INSERT INTO `tbl_server` (`server_id`, `name`, `mngmnt_ui`, `ipv4`, `ipv6`, `froxlor_username`, `froxlor_password`, `froxlor_db`, `froxlor_db_host`, `total_space`, `free_space`, `active`) VALUES
(1, 'Testserver001', '192.168.1.1/froxlor', '192.168.1.1', NULL, 'root', 'dc76e9f0c0006e8f919e0c515c66dbba3982f785', 'froxlor', '192.168.1.1', 100000, 99000, 1),
(2, 'Testserver002', '192.168.1.2/froxlor', '1921.68.1.2', NULL, 'root', 'dc76e9f0c0006e8f919e0c515c66dbba3982f785', 'froxlor', '192.168.1.2', 500000, 420000, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_shopping_cart`
--

CREATE TABLE IF NOT EXISTS `tbl_shopping_cart` (
  `session_id` char(32) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`session_id`,`product_id`),
  KEY `fk_shopping_cart_product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `tbl_shopping_cart`
--

INSERT INTO `tbl_shopping_cart` (`session_id`, `product_id`, `quantity`) VALUES
('7pod5fubt73j03qojprbvmba24', 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_tax`
--

CREATE TABLE IF NOT EXISTS `tbl_tax` (
  `tax_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_rate` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`tax_id`),
  UNIQUE KEY `tax_id_UNIQUE` (`tax_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `tbl_tax`
--

INSERT INTO `tbl_tax` (`tax_id`, `tax_rate`) VALUES
(1, 0),
(2, 19);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
