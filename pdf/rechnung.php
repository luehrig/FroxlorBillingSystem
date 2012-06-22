<?php
/*>====O-------------------------------------------------O====>\
|                    ##### t w p d f #####                     |
|      Copyright (c) by progtw (Thomas Weise), 2005-2007       |
|                     http://www.progtw.de                     |
| Dieses Programm ist freie Software. Sie k�nnen es unter den  |
| Bedingungen der GNU General Public License 3 (wie von der    |
| Free Software Foundation herausgegeben) weitergeben und/oder |
| modifizieren.                                                |
| Eine Kopie der Lizenzbedingungen finden Sie in lizenz.txt.   |                                                 |
\<====O-------------------------------------------------O====<*/



/* ACHTUNG: darf kein einziges Leerzeichen vor phpstart sein, wegen header !!! */
session_start();
error_reporting(E_ALL);

// FPDF-Zeugs und die spezielle TwPdf-Klasse includen
define("FPDF_FONTPATH","fpdf17/font/");
include_once('fpdf17/fpdf.php');
include_once("twpdf/cl_invoicepdf.php");



// die Rechnungspositionen
$arrPos = array();
$arrPos[0]['text']        = "Ihr Text zu dieser Position...\nHier ist jetzt in diesem Beispiel nur ein wenig F�lltext enthalten, um die gesamte Rechnung optisch darzustellen.\nbla\nbla\nblub";
$arrPos[0]['menge']       = 1;
$arrPos[0]['einzelpreis'] = 20.00;
$arrPos[0]['gesamtpreis'] = $arrPos[0]['menge'] * $arrPos[0]['einzelpreis'];

$arrPos[1]['text']        = "Ihr Text zu dieser Position...\nHier ist jetzt in diesem Beispiel nur ein wenig F�lltext enthalten, um die gesamte Rechnung optisch darzustellen.\nbla\nbla\nblub";
$arrPos[1]['menge']       = 3;
$arrPos[1]['einzelpreis'] = 10.33;
$arrPos[1]['gesamtpreis'] = $arrPos[1]['menge'] * $arrPos[1]['einzelpreis'];

$arrPos[2]['text']        = "Ihr Text zu dieser Position...\nHier ist jetzt in diesem Beispiel nur ein wenig F�lltext enthalten, um die gesamte Rechnung optisch darzustellen.\nbla\nbla\nblub";
$arrPos[2]['menge']       = 8;
$arrPos[2]['einzelpreis'] = 3.63;
$arrPos[2]['gesamtpreis'] = $arrPos[2]['menge'] * $arrPos[2]['einzelpreis'];

$arrPos[3]['text']        = "Ihr Text zu dieser Position...\nHier ist jetzt in diesem Beispiel nur ein wenig F�lltext enthalten, um die gesamte Rechnung optisch darzustellen.\nbla\nbla\nblub";
$arrPos[3]['menge']       = 10;
$arrPos[3]['einzelpreis'] = 25.00;
$arrPos[3]['gesamtpreis'] = $arrPos[3]['menge'] * $arrPos[3]['einzelpreis'];

$arrPos[4]['text']        = "Ihr Text zu dieser Position...\nHier ist jetzt in diesem Beispiel nur ein wenig F�lltext enthalten, um die gesamte Rechnung optisch darzustellen.\nbla\nbla\nblub";
$arrPos[4]['menge']       = 1;
$arrPos[4]['einzelpreis'] = 250.00;
$arrPos[4]['gesamtpreis'] = $arrPos[4]['menge'] * $arrPos[4]['einzelpreis'];



// Kunden- und Firmendaten, Zahlungsbedingungen
$arrDat = array();
$arrDat['rechnungsnummer']       = "111111";
$arrDat['kundennummer']          = "222222";
$arrDat['rechnungsdatum']        = "29.04.2009";

$arrDat['kundeAnschriftZeile01'] = "Max Mustermann";
$arrDat['kundeAnschriftZeile02'] = "Schlossallee 7";
$arrDat['kundeAnschriftZeile03'] = "12345 Toomtown";
$arrDat['kundeAnschriftZeile04'] = "";
$arrDat['kundeAnschriftZeile05'] = "";

$arrDat['firmaNameZeile01']      = "Ihr Firmenname";
$arrDat['firmaNameZeile02']      = "Ihr Firmenname Zeile02";
$arrDat['firmaNameZeile03']      = "Ihr Firmenname Zeile03";
$arrDat['firmaNameZeile04']      = "";
$arrDat['firmaNameZeile05']      = "";
$arrDat['firmaAnschriftZeile01'] = "Ihre Firma";
$arrDat['firmaAnschriftZeile02'] = "Ihre Stra�e 33";
$arrDat['firmaAnschriftZeile03'] = "12345 Ihr Ort";
$arrDat['firmaAnschriftZeile04'] = "";
$arrDat['firmaAnschriftZeile05'] = "";
$arrDat['firmaAnschrift']        = "Ihre Firma, Strs�e 8, 98765 Irgendwo";
$arrDat['firmaTelefon']          = "12345 67890";
$arrDat['firmaFax']              = "12345 67891";
$arrDat['firmaEmail']            = "blabla@ihrefirma.de";
$arrDat['firmaWeb']              = "http://ihrefirma.de";
$arrDat['firmaBankName']         = "Blablabank Irgendwo";
$arrDat['firmaBankKtonr']        = "11111111";
$arrDat['firmaBankBlz']          = "22222222";
$arrDat['firmaUstidnr']          = "DE333333333";
$arrDat['zahlungsbedingungen']   = "Zahlung innerhalb ... Tage nach Rechnungseingang. Bitte �berweisen Sie den Endbetrag an unten stehende Bankverbindung. Tragen Sie als Verwendungszweck die Rechnungsnummer ein.\nEinwendungen gegen in Rechnung gestellte Dienstleistungen sind innerhalb von ... Tagen nach Erhalt der Rechnung schriftlich zu erheben.";



// Berechnungen (mit exclusive MwSt.)
$brutto = $steuer = $netto = 0.0;
foreach ($arrPos as $pos) {
	$netto += $pos['gesamtpreis'];
}
$steuer = $netto * 0.19;
$brutto = $netto * 1.19;

$arrDat['rechnungsbetragNetto']  = $netto;
$arrDat['rechnungsbetragSteuer'] = $steuer;
$arrDat['rechnungsbetragBrutto'] = $brutto;



// alles in die Session rein
$_SESSION['twArrRechnungsdaten']      = $arrDat;
$_SESSION['twArrRechnungspositionen'] = $arrPos;



// pdf erzeugen
$twpdf = new TwPdfRechnung(); 

// pdf ausgeben (im Browser oder in Datei schreiben)
$twpdf->Output();   // Ausgabe (wenn in Datei schreiben, dateiname in Klammer)

// ACHTUNG: in der aufgerufenen Klasse darf kein Leerzeichen hinter phpende sein!!!
?>