<?php
// TODO: delete in productive environment
error_reporting(E_ALL);

// require_once 'cl_customizing';
// require_once 'cl_invoice.php';


class invoicepdf extends FPDF {

	private $invoice_data 			= array();
	private $order_data      		= array();
	private $order_positions 		= array();
	private $customer_data 			= array();
	private $shipping_address       = array();
	private $billing_address 		= array();
	private $business_customizing   = array();
	private $currency;
	
	private $twArrSpaltenbreiten      = array();
	private $twArrSpaltenkoepfe       = array();


	/**
	 * construktor
	 * @return
	 */
	public function __construct($invoice_id) {

		// constructor of library fpdf to create a new pdf document in A4 format with portrait alignment
		parent::__construct('P', 'mm', 'A4'); 
		
		$invoice = new invoice($invoice_id);
		$this->invoice_data = $invoice->getInvoiceData();
		$this->order_data = $invoice->getInvoiceData();
		$this->order_positions = $invoice->getOrderPositions();
		$this->customer_data = $invoice->getCustomerData();
		$this->shipping_address = $invoice->getShippingAddress();
		$this->billing_address = $invoice->getBillingAddress();
		
		
		// create customizing object to read additional information for invoice
		$customizing = new customizing();
		$this->business_customizing = $customizing->getBusinessRelatedEntries();
		
		// create currency object
		$this->currency = new currency($this->invoice_data['currency_id']);
		
		// settings for PDF
		$this->SetDisplayMode( 100 );         // wie gro� wird Seite angezeigt(in %)
		$this->SetAutoPageBreak(true, 50);    // 50mm von unten erfolgt ein Seitenumbruch
		$this->AliasNbPages();                // Anzahl der Seiten berechnen ({nb}-sache)

		// create new page in document
		$this->AddPage();                     // PDF starten (ruft auch Header() und Footer() auf

		// additional objects
		$this->twShowRechnungspositionen();   // Tabelle mit allen Rechnungspositionen
		$this->twShowLetzteSeite();           // nur auf der letzten Seite
	}



	/*
	 * create header for document
	 */
	public function Header() {
		// every page gets:
		if ($this->page > 0) {
			// Farben und Schrift allgemein
			$this->SetFont('Arial','B','12');     // Schrift
			$this->SetTextColor(000, 000, 102);   // Schriftfarbe
			$this->SetFillColor(210);             // F�llungsfarbe (Hintergrund)
			$this->SetDrawColor(000, 000, 102);   // Rahmenfarbe
			$this->SetLineWidth(0.4);             // Rahmenst�rke

			// Hintergrundfarbe und -rahmen des Dokumentes
			$this->SetFillColor(239);
			$this->SetLineWidth(0.6);
			$this->twRundeckbereich(22, 10, 179, 277, 4, 'DF');

			// Linie oben horizontal
			$this->SetFillColor(210);
			$this->SetLineWidth(0.4);
			$this->twRundeckbereich(25, 16, 173, 2, 0.8, 'DF');  // (x, y, breite, h�he, radius, style(D=rahmen F=f�llung)
			 
			// Linie rechts vertikal
			$this->twRundeckbereich(193, 13, 2, 270, 0.8, 'DF');
			$this->SetFont('Arial','B','12');

			// Schrift Firmenbezeichnung
			$this->SetTextColor(180);
			$this->SetFont('Arial','B','16');
			$this->SetXY(25, 23);                     // xy linksoben der (folgenden)Cell
			$this->Cell(124, 6, $this->business_customizing['business_company_name'], 0, 1, 'C');
			$this->SetFont('Arial','B','8');
			$this->SetXY(25, 30);
			$this->Cell(116, 4, $this->business_customizing['business_company_street'], 0, 1, 'R');
			$this->SetXY(25, 34);
			$this->Cell(119, 4, $this->business_customizing['business_company_post_code'] .' '. $this->business_customizing['business_company_city'], 0, 1, 'R');
			$this->SetFont('Arial','B','12');
			$this->SetTextColor(000, 000, 102);

			// kleine Linie unter Firmenbezeichnung
			//$pdf->twRundeckbereich(113, 39, 31, 1, 0.4, 'DF');

			// Box mit Logo
			$this->twRundeckbereich(149, 24, 38, 24, 3, 'DF');
			$this->Image(PATH_IMAGES .'/logos/logo_invoice.png',151, 26);

			//Seitenzahl (zB Seite 1 von 3)
			$this->SetFont('Arial','','8');
			$this->SetXY(149, 50);
			$this->AliasNbPages();       // erstmal Anzahl der Seiten berechnen
			$this->Cell(38, 4, 'Seite '.$this->PageNo().' von {nb}', 0, 1, 'C');

			// Faltzeichen (links, 1/3 und 1/2 der Seite)
			$this->SetFillColor(255);
			$this->SetXY(8, 107);
			$this->Cell(6, 0, '', 1, 1, 'C');
			$this->SetXY(8, 150);
			$this->Cell(6, 0, '', 1, 1, 'C');
			$this->SetFillColor(210);

			// RundBox (wenns letzte Seite ist->Zahlungsbedingungen, sonst Hinweis auf Folgeseite
			$this->SetFillColor(247);
			$this->SetDrawColor(000, 000, 102);
			$this->twRundeckbereich(24, 249, 114, 20, 2, 'DF');

			// RundBox zur Ausgabe der berechneten Zahlbetr�ge
			$this->SetTextColor(000);
			$this->SetFillColor(255);
			$this->SetLineWidth(0.8);
			$this->twRundeckbereich(140, 249, 51, 20, 2, 'DF');

			$this->SetY(59);   // wenn mehrseitiges Dokument
		}

		// NUR f�r die erste Seite gilt:
		if ($this->page == 1) {
			// eigener Absender (kleine Schrift �ber der (Kunden-)Adresse)
			$this->SetFont('Times','','7');
			$this->SetXY(26, 48);
			$this->Cell(73, 3, $this->business_customizing['business_company_street'], 0, 1, '');
			$this->SetFont('Arial','B','12');

			// Box f�r (Kunden-)Adresse
			$this->SetTextColor(000);
			$this->SetFillColor(255);
			$this->twRundeckbereich(25, 52, 75, 36, 2, 'DF');
			$this->SetXY(27, 53);
			$this->Cell(71, 6, utf8_decode($this->customer_data['first_name']) .' '. utf8_decode($this->customer_data['last_name']), 0, 1, '');
			$this->SetXY(27, 60);
			$this->Cell(71, 6, $this->billing_address['street']. ' '. $this->billing_address['street_number'], 0, 1, '');
			$this->SetXY(27, 67);
			$this->Cell(71, 6, $this->billing_address['post_code'], 0, 1, '');
			$this->SetXY(27, 74);
			$this->Cell(71, 6, $this->billing_address['city'], 0, 1, '');
			$this->SetXY(27, 81);
			$this->Cell(71, 6, $this->billing_address['country'], 0, 1, '');
			$this->SetFillColor(210);
			$this->SetTextColor(000, 000, 102);

			// Rechnungsnummer, Kundennummer, Datum
			//Rechnungsnummer
			$this->SetFont('Arial','','10');
			$this->SetXY(110, 73);
			$this->Cell(49, 4, 'Rechnungsnummer', 0, 1, 'R');
			$this->SetFont('Arial','B','12');
			$this->SetXY(160, 73);
			$this->Cell(26, 4, $this->invoice_data['invoice_number'], 0, 1, '');
			//Kundennummer
			$this->SetFont('Arial','','10');
			$this->SetXY(110, 79);
			$this->Cell(49, 4, 'Kundennummer', 0, 1, 'R');
			$this->SetFont('Arial','B','12');
			$this->SetXY(160, 79);
			$this->Cell(26, 4, $this->customer_data['customer_number'], 0, 1, '');
			//Datum
			$this->SetFont('Arial','','10');
			$this->SetXY(110, 85);
			$this->Cell(49, 4, 'Datum', 0, 1, 'R');
			$this->SetFont('Arial','B','12');
			$this->SetXY(160, 85);
			$this->Cell(26, 4, $this->invoice_data['issue_date'], 0, 1, '');

			$this->SetFont('Arial','B','12');

			// Linie unter (Kunden-)Adresse
			//$this->twRundeckbereich(30, 91, 155, 1, 0.4, 'DF');
			 
			// das Wort Rechnung
			$this->SetFont('Arial','B','20');
			$this->SetXY(34, 94);
			$this->Cell(146, 8, 'Rechnung', 0, 1, 'C');
			$this->SetFont('Arial','B','12');

			// RundBox der Rechnungspositionen (auf erster Seite weiter unten wegen Adressfeld)
			$this->SetFillColor(255);
			$this->twRundeckbereich(25, 104, 165, 142, 2, 'DF');
		}

		// f�r ALLE Seiten AUSSER die erste Seite:
		if ($this->page > 1) {
			// die RundBox (ab der zweiten Seite weiter oben)
			$this->SetFillColor(255);
			$this->twRundeckbereich(25, 56, 165, 191, 2, 'DF');
		}
	} // ENDE Header()


	public function Footer() {
		// RundBox unten (mit Adress-, Bankangaben usw.)
		$this->SetFillColor(247);
		$this->SetLineWidth(0.4);
		$this->twRundeckbereich(24, 271, 167, 14, 2.4, 'DF');
		$this->SetFont('Times','I','8');
		$this->SetTextColor(000, 000, 102);
		// Adresse
		$this->SetXY(35, 272);
		$this->Cell(36, 3, $this->business_customizing['business_company_name'], 0, 1, '');
		$this->SetXY(35, 275);
		$this->Cell(36, 3, $this->business_customizing['business_company_street'], 0, 1, '');
		$this->SetXY(35, 278);
		$this->Cell(36, 3, $this->business_customizing['business_company_post_code'] .' '. $this->business_customizing['business_company_city'], 0, 1, '');
		$this->SetXY(35, 281);
		$this->Cell(36, 3, $this->business_customizing['business_company_country'], 0, 1, '');
		//Tel, Fax, Mail, Web
		$this->SetXY(71, 272);
		$this->Cell(36, 3, 'Tel:    '. $this->business_customizing['business_company_tel'], 0, 1, '');
		$this->SetXY(71, 275);
		$this->Cell(36, 3, 'Fax:   '. $this->business_customizing['business_company_fax'], 0, 1, '');
		$this->SetXY(71, 278);
		$this->Cell(36, 3, 'Mail: '. $this->business_customizing['business_company_email'], 0, 1, '');
		$this->SetXY(71, 281);
		$this->Cell(36, 3, 'Web: '. $this->business_customizing['business_company_webpage'], 0, 1, '');
		// Bank
		$this->SetXY(124, 272);
		$this->Cell(24, 3, 'Bankverbindung:', 0, 1, 'R');
		$this->SetXY(148, 272);
		$this->Cell(36, 3, $this->business_customizing['business_payment_bank_name'], 0, 1, '');
		$this->SetXY(148, 275);
		$this->Cell(36, 3, $this->business_customizing['business_payment_bank_account'], 0, 1, '');
		$this->SetXY(148, 278);
		$this->Cell(36, 3, $this->business_customizing['business_payment_bank_code'], 0, 1, '');
		$this->SetXY(148, 281);
		$this->Cell(36, 3, $this->business_customizing['business_payment_tax_id_number'], 0, 1, '');
	} // ENDE Footer()



	/* tw Funktionen private -------------------------------------------------- */

	/**
	 * Zeigt eine Tabelle mit den Rechnungspositionen an.
	 * ben�tigt 'twTabelleMitMultiCell'
	 */
	private function twShowRechnungspositionen() {

		// Spaltenbreiten und Beschriftung der Spaltenk�pfe festlegen
		$this->twSetSpaltenbreiten(array(8, 99, 14, 20, 20));
		$this->twSetSpaltenkoepfe(array('Pos', 'Text', 'Menge', 'Preis', 'Gesamt'));

		// Tabellenk�pfe (nur mit Cell)
		$this->SetFillColor(244);
		$this->SetTextColor(000);
		$this->SetLineWidth(.3);
		$this->SetFont('Arial', 'B', '12');
		$this->SetXY(27, 106);
		for ($i=0; $i<count($this->twArrSpaltenkoepfe); $i++) {
			$this->Cell($this->twArrSpaltenbreiten[$i], 7, $this->twArrSpaltenkoepfe[$i], 1, 0, 'C', 1);
		}
		$this->ln();

		// Tabellenzeilen (mit MultiCell)
		$this->SetFillColor(224, 235, 255);
		$this->SetFont('Arial', '', 10);
		$this->SetXY(27, 113);
		$i = 0;
		foreach ($this->order_positions as $pos) {
			$i++;
			$this->twShowZeileMitMultiCell(array(
					$i,
					$pos['product_description'] .' - '. $pos['product_description'],
					sprintf("%9.2f", $pos['quantity']),
					sprintf("%9.2f", $pos['price']),
					sprintf("%9.2f", $pos['amount'])
			));
			$this->SetX(27);  // sonst gehts immer ganz links los...
		}
		$this->Cell(array_sum($this->twArrSpaltenbreiten), 0, '', 'T');  //Tabellenlinie unten
	}



	/**
	 * Wird bei mehreren Seiten nur auf der letzten Seite angezeigtzeigt.
	 * Zeigt Zahlungsbedingungen und Zahlbetrag (im Footer) an.
	 */
	private function twShowLetzteSeite() {
		// Zahlungsbedingungen
		$this->SetFont('Times','I','9');
		$this->SetXY(26, 251);
		$this->SetAutoPageBreak(true, 10);    // Seitenumbruch weiter runter
		$this->MultiCell(110, 3.2, $this->business_customizing['business_payment_payment_terms'], 0, 'L', 0);

		// Zahlbetr�ge
		//Endbetrag (brutto)
		$this->SetFont('Arial','','10');
		$this->SetXY(141, 251);
		$this->Cell(24, 5, 'Nettobetrag:', 0, 1, 'R');
		$this->SetXY(169, 251);
		$this->Cell(21, 5, sprintf("%9.2f �", $this->invoice_data['invoice_sum_net']), 0, 1, 'R');
		//Steuer
		$this->SetFont('Arial','','10');
		$this->SetXY(141, 257);
		$this->Cell(24, 5, '+'. $this->invoice_data['tax_rate'] .'% MwSt:', 0, 1, 'R');
		$this->SetXY(169, 257);
		$strWegenKlammer = sprintf("%9.2f", $this->invoice_data['invoice_sum_tax']). " �";
		$this->Cell(21, 5, $strWegenKlammer, 0, 1, 'R');
		//Endbetrag
		$this->SetFont('Arial','B','12');
		$this->SetXY(141, 263);
		$strWegenKlammer = "Zahlbetrag:". sprintf("%9.2f", $this->invoice_data['invoice_sum_gross']). " �";
		$this->Cell(49, 5, $strWegenKlammer, 0, 1, 'R');

		$this->SetFont('Arial','B','12');
		$this->SetTextColor(000, 000, 102);
	}




	/* twRundeckbereich START ------------------------------------------------- */
	private function twRundeckbereich($x, $y, $w, $h, $r, $style='') {
		$twRund = 4/3 * (sqrt(2) - 1);
		$k      = $this->k;
		$hp     = $this->h;
		$this->_out(sprintf('%.2f %.2f m',($x + $r) * $k, ($hp - $y) * $k));
		// rechts oben
		$xc = $x + $w - $r ;
		$yc = $y + $r;
		$this->_out(sprintf('%.2f %.2f l', $xc * $k, ($hp - $y) * $k)); // Line
		$this->twRundeck($xc + $r*$twRund, $yc - $r, $xc + $r, $yc - $r*$twRund, $xc + $r, $yc); // Kurve
		// rechts unten
		$xc = $x + $w - $r ;
		$yc = $y + $h - $r;
		$this->_out(sprintf('%.2f %.2f l',($x + $w) * $k, ($hp - $yc) * $k));  // Line
		$this->twRundeck($xc + $r, $yc + $r*$twRund, $xc + $r*$twRund, $yc + $r, $xc, $yc + $r); // Kurve
		// links unten
		$xc = $x + $r ;
		$yc = $y + $h - $r;
		$this->_out(sprintf('%.2f %.2f l',$xc * $k, ($hp - ($y + $h)) * $k));  // Line
		$this->twRundeck($xc - $r*$twRund, $yc + $r, $xc - $r, $yc + $r*$twRund, $xc - $r, $yc); // Kurve
		// links oben
		$xc = $x + $r ;
		$yc = $y + $r;
		$this->_out(sprintf('%.2f %.2f l',($x) * $k, ($hp - $yc) * $k));  // Line
		$this->twRundeck($xc - $r, $yc - $r*$twRund, $xc - $r*$twRund, $yc - $r, $xc, $yc - $r); // Kurve

		if     ($style == 'F') $op = 'f';
		elseif ($style == 'FD' or $style == 'DF') $op = 'B';
		else   {$op = 'S';
		}
		$this->_out($op);
	}

	private function twRundeck($x1, $y1, $x2, $y2, $x3, $y3) {
		// Cubic B�zier Kurve (f�r Rechteck mit Runden Ecken)
		$h = $this->h;
		$this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ',
				$x1*$this->k,
				($h-$y1)*$this->k,
				$x2*$this->k,
				($h-$y2)*$this->k,
				$x3*$this->k,
				($h-$y3)*$this->k));
	}
	/* twRundeckbereich END --------------------------------------------------- */






	/* twTabelleMitMultiCell START -------------------------------------------- */
	/// Tabelle mit MultiCell (siehe: www.fpdf.de/downloads/addons/3/)
	/// private $twArrSpaltenbreiten; (...oben schon deklariert)
	/// private $twArrSpaltenkoepfe;  (...oben schon deklariert)

	private function twSetSpaltenbreiten($arrSpaltenbreiten) {
		$this->twArrSpaltenbreiten=$arrSpaltenbreiten;
	}

	private function twSetSpaltenkoepfe($arrSpaltenkoepfe) {
		$this->twArrSpaltenkoepfe=$arrSpaltenkoepfe;
	}

	private function twShowZeileMitMultiCell($arrSpalten) {
		$anzSpalten    = count($arrSpalten);
		$anzZeilen     = 0;   // ... �ndert sich
		$zeilenhoehe   = 5;   // hier die Zeilenh�he setzen!
		$hoeheGesamt   = 0;   // ... �ndert sich
		$spaltenbreite = 0;   // ... �ndert sich

		for($i=0; $i<$anzSpalten; $i++) {
			$anzZeilen = max($anzZeilen, $this->twHoleAnzahlZeilen($this->twArrSpaltenbreiten[$i], $arrSpalten[$i]));
		}

		$hoeheGesamt = $zeilenhoehe * $anzZeilen;   // f�r Gesamth�he aller Zeilen
		$this->twCheckSeitenumbruch($hoeheGesamt);  // Seitenumbruch, falls n�tig
		//zeichnet die Zellen einer Zeile
		for($i=0; $i<$anzSpalten; $i++) {
			$spaltenbreite = $this->twArrSpaltenbreiten[$i];  // Spaltenbreite holen
			$x             = $this->GetX();                   // aktuelle Position holen (x)
			$y             = $this->GetY();                   // aktuelle Position holen (y)

			// den Rahmen und die Inhalte zeichnen
			$this->Rect($x, $y, $spaltenbreite, $hoeheGesamt);
			if ($i == 1) {
				$this->MultiCell($spaltenbreite, $zeilenhoehe, $arrSpalten[$i], 0, 'L');
			} else {
				$this->MultiCell($spaltenbreite, $zeilenhoehe, $arrSpalten[$i], 0, 'R');
			}
			$this->SetXY($x+$spaltenbreite, $y);  // Position (rechts von MultiCell) setzen
		}
		$this->Ln($hoeheGesamt);                //n�chste Zeile
	}

	private function twCheckSeitenumbruch($hoehe) {
		// bei Bedarf eine neue Seite erzeugen und Hinweis auf Folgeseite
		if($this->GetY()+$hoehe>$this->PageBreakTrigger) {
			// Hinweis auf Folgeseite
			$this->SetXY(26, 251);
			$text01 = "Fortsetzung der Rechnung auf der n�chsten Seite";
			$this->SetAutoPageBreak(false);       // Seitenumbruch kurz raus
			$this->MultiCell(110, 3.2, $text01, 0, 'C', 0);
			$this->SetAutoPageBreak(true, 50);    // Seitenumbruch wieder rein
			// neue Seite
			$this->AddPage($this->CurOrientation);
			$this->SetX(27);
		}
	}

	private function twHoleAnzahlZeilen($breite, $txt) {
		// berechnet die Anzahl der Zeilen der MultiCell bei einer Breite ($breite)
		$cw = &$this->CurrentFont['cw'];
		if ($breite == 0) {
			$breite=$this->w-$this->rMargin-$this->x;
		}
		$wmax = ($breite-2*$this->cMargin)*1000/$this->FontSize;
		$s = str_replace("\r", '', $txt);
		$nb = strlen($s);
		if ($nb>0 && $s[$nb-1]=="\n") {
			$nb--;
		}
		$sep = -1;
		$i = 0;
		$j = 0;
		$l = 0;
		$nl = 1;
		while ($i<$nb) {
			$c = $s[$i];
			if ($c == "\n")
			{
				$i++;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
				continue;
			}
			if ($c == ' ') {
				$sep = $i;
			}
			$l += $cw[$c];
			if ($l > $wmax)
			{
				if ($sep == -1)
				{
					if ($i == $j) {
						$i++;
					}
				}
				else {
					$i = $sep+1;
				}
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
			}
			else {
				$i++;
			}
		}
		return $nl;
	}
	/* twTabelleMitMultiCell END --------------------------------------------- */



} // ENDE der Klasse PDF
?>