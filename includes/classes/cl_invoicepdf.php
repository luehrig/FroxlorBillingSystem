<?php
// TODO: delete in productive environment
error_reporting(E_ALL);

class invoicepdf extends FPDF {

	private $invoice_data 			= array();
	private $order_data      		= array();
	private $order_positions 		= array();
	private $customer_data 			= array();
	private $shipping_address       = array();
	private $billing_address 		= array();
	private $business_customizing   = array();
	private $currency;
	
	private $twArrColumnWidth      = array();
	private $twArrColumnHeaders       = array();


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
		$this->SetDisplayMode( 100 );         // set size for display
		$this->SetAutoPageBreak(true, 50);    // page break will occurre after 50mm
		$this->AliasNbPages();                // calculate number of pages ({nb}-sache)

		// create new page in document
		$this->AddPage();                    
		
		// additional objects
		$this->twShowInvoicePosition();  
		$this->twShowFinalPage();          
	}



	/*
	 * create header for document
	 */
	public function Header() {
		// every page gets:
		if ($this->page > 0) {
			// colors and font for general document
			$this->SetFont('Arial','B','12');     // Schrift
			$this->SetTextColor(000, 000, 102);   // Schriftfarbe
			$this->SetFillColor(210);             // F�llungsfarbe (Hintergrund)
			$this->SetDrawColor(000);   			// Rahmenfarbe
			$this->SetLineWidth(0.4);             // Rahmenst�rke

			// background for invoice
			$this->SetFillColor(239);
			$this->SetLineWidth(0.5);
			$this->twRoundCornerArea(22, 10, 179, 277, 4, 'DF');



			// font setup for company name
			$this->SetTextColor(123);
			$this->SetFont('Arial','B','16');
			$this->SetXY(50, 23);                     // xy linksoben der (folgenden)Cell
			$this->Cell(10, 6, $this->business_customizing['business_company_name'], 0, 1, 'L');
			$this->SetFont('Arial','B','10');
			$this->SetXY(55, 30);
			$this->Cell(20, 4, $this->business_customizing['business_company_street'], 0, 1, 'L');
			$this->SetXY(55, 34);
			$this->Cell(20, 4, $this->business_customizing['business_company_post_code'] .' '. $this->business_customizing['business_company_city'], 0, 1, 'L');

			$this->SetTextColor(000, 000, 102);

			// small linie after company name
			$this->SetDrawColor(72,149,206);
			$this->SetFillColor(72,149,206);
			$this->twRoundCornerArea(50, 39, 90, 1, 0.2, 'DF');

			// box with logo
			$this->Image(PATH_IMAGES .'/logos/logo_invoice.png',149, 24);

			// page numbers
			$this->SetFont('Arial','','8');
			$this->SetXY(149, 50);
			$this->AliasNbPages();       // erstmal Anzahl der Seiten berechnen
			$this->Cell(38, 4, 'Seite '.$this->PageNo().' von {nb}', 0, 1, 'C');

			// markers for wrinkles
			$this->SetFillColor(255);
			$this->SetXY(8, 107);
			$this->Cell(6, 0, '', 1, 1, 'C');
			$this->SetXY(8, 150);
			$this->Cell(6, 0, '', 1, 1, 'C');
			$this->SetFillColor(210);

			// roundbox for billing terms or hint for next page
			$this->SetFillColor(247);
			$this->SetDrawColor(000);
			$this->SetLineWidth(0.1);
			$this->twRoundCornerArea(24, 249, 114, 20, 2, 'DF');

			// round box for calculated sums
			$this->SetTextColor(000);
			$this->SetFillColor(255);
			$this->SetDrawColor(72,149,206);
			$this->SetLineWidth(0.5);
			$this->twRoundCornerArea(140, 249, 51, 20, 2, 'DF');
			$this->SetDrawColor(000);

			$this->SetY(59);   // if multi page document
		}

		// only for first page
		if ($this->page == 1) {

			// box for customer address
			$this->SetFont('Arial','B','12');
			$this->SetTextColor(000);
			$this->SetFillColor(255);
			$this->SetLineWidth(0.1);
			$this->twRoundCornerArea(25, 52, 75, 36, 2, 'DF');
			$this->SetXY(30, 55);
			$this->Cell(71, 6, utf8_decode($this->customer_data['first_name']) .' '. utf8_decode($this->customer_data['last_name']), 0, 1, '');
			$this->SetXY(30, 63);
			$this->Cell(71, 6, utf8_decode($this->billing_address['street']). ' '. utf8_decode($this->billing_address['street_number']), 0, 1, '');
			$this->SetXY(30, 73);
			$this->Cell(71, 6, utf8_decode($this->billing_address['post_code']), 0, 1, '');
			$this->SetXY(45, 73);
			$this->Cell(71, 6, utf8_decode($this->billing_address['city']), 0, 1, '');
			$this->SetXY(30, 80);
			$this->Cell(71, 6, utf8_decode($this->billing_address['country']), 0, 1, '');
			$this->SetFillColor(210);
			$this->SetTextColor(72,149,206);

			// header data for invoice
			// invoice number
			$this->SetFont('Arial','','10');
			$this->SetXY(110, 73);
			$this->Cell(49, 4, TABLE_HEADING_INVOICE_INVOICE_NUMBER, 0, 1, 'R');
			$this->SetFont('Arial','B','12');
			$this->SetXY(160, 73);
			$this->Cell(26, 4, utf8_decode($this->invoice_data['invoice_number']), 0, 1, '');
			//customer number
			$this->SetFont('Arial','','10');
			$this->SetXY(110, 79);
			$this->Cell(49, 4, TABLE_HEADING_CUSTOMER_CUSTOMER_NUMBER, 0, 1, 'R');
			$this->SetFont('Arial','B','12');
			$this->SetXY(160, 79);
			$this->Cell(26, 4, utf8_decode($this->customer_data['customer_number']), 0, 1, '');
			// invoice date
			$this->SetFont('Arial','','10');
			$this->SetXY(110, 85);
			$this->Cell(49, 4, TABLE_HEADING_INVOICE_ISSUE_DATE, 0, 1, 'R');
			$this->SetFont('Arial','B','12');
			$this->SetXY(160, 85);
			$this->Cell(26, 4, mysql_date2german($this->invoice_data['issue_date']), 0, 1, '');

			$this->SetFont('Arial','B','12');

			// line after customer address
				 
			// header text 'invoice'
			$this->SetFont('Arial','B','22');
			$this->SetXY(34, 94);
			$this->Cell(146, 8, INVOICE_LABEL_INVOICE, 0, 1, 'C');
			$this->SetFont('Arial','B','12');

			// round box with invoice positions (because first page includes contact information)
			$this->SetFillColor(255);
			$this->SetLineWidth(0.3);
			$this->twRoundCornerArea(25, 104, 165, 142, 2, 'DF');
		}

		// for all pages (excepted first page)
		if ($this->page > 1) {
			// round box (starts with second page
			$this->SetFillColor(255);
			$this->SetLineWidth(0.1);
			$this->twRoundCornerArea(25, 56, 165, 191, 2, 'DF');
		}
	} // end Header()


	public function Footer() {
		// round boxes bottom (with address and bank details)
		$this->SetFillColor(247);
		$this->SetTextColor(72,149,206);
		$this->SetLineWidth(0.1);
		$this->twRoundCornerArea(24, 271, 167, 14, 2.4, 'DF');
		$this->SetFont('Arial','I','8');
		// address
		$this->SetXY(35, 272);
		$this->Cell(36, 3, utf8_decode($this->business_customizing['business_company_name']), 0, 1, '');
		$this->SetXY(35, 275);
		$this->Cell(36, 3, utf8_decode($this->business_customizing['business_company_street']), 0, 1, '');
		$this->SetXY(35, 278);
		$this->Cell(36, 3, utf8_decode($this->business_customizing['business_company_post_code']) .' '. utf8_decode($this->business_customizing['business_company_city']), 0, 1, '');
		$this->SetXY(35, 281);
		$this->Cell(36, 3, utf8_decode($this->business_customizing['business_company_country']), 0, 1, '');
		// communication
		$this->SetXY(90, 272);
		$this->Cell(36, 3, 'Tel:    '. utf8_decode($this->business_customizing['business_company_tel']), 0, 1, '');
		$this->SetXY(90, 275);
		$this->Cell(36, 3, 'Fax:   '. utf8_decode($this->business_customizing['business_company_fax']), 0, 1, '');
		$this->SetXY(90, 278);
		$this->Cell(36, 3, 'Mail: '. utf8_decode($this->business_customizing['business_company_email']), 0, 1, '');
		$this->SetXY(90, 281);
		$this->Cell(36, 3, 'Web: '. utf8_decode($this->business_customizing['business_company_webpage']), 0, 1, '');
		// bank
		$this->SetXY(144, 272);
		$this->Cell(24, 3, INVOICE_BANK_CONTACT, 0, 1, 'R');
		$this->SetXY(168, 272);
		$this->Cell(36, 3, utf8_decode($this->business_customizing['business_payment_bank_name']), 0, 1, '');
		$this->SetXY(168, 275);
		$this->Cell(36, 3, utf8_decode($this->business_customizing['business_payment_bank_account']), 0, 1, '');
		$this->SetXY(168, 278);
		$this->Cell(36, 3, utf8_decode($this->business_customizing['business_payment_bank_code']), 0, 1, '');
		$this->SetXY(168, 281);
		$this->Cell(36, 3, utf8_decode($this->business_customizing['business_payment_tax_id_number']), 0, 1, '');
	} // end Footer()



	/* tw Funktionen private -------------------------------------------------- */

	/**
	 * display table with all invoice positions
	 */
	private function twShowInvoicePosition() {

		// set column width and title for column headers
		$this->twSetColumnWidth(array(8, 99, 14, 20, 20));
		$this->twSetColumnHeaders(array(INVOICE_LABEL_POSITION, LABEL_PRODUCT_DESCRIPTION, LABEL_PRODUCT_QUANTITY, LABEL_PRODUCT_PRICE .' '. iconv('UTF-8', 'windows-1252', $this->currency->getCurrencySign()), INVOICE_LABEL_TOTAL));

		// table headers (only with cells)
		$this->SetFillColor(244);
		$this->SetTextColor(000);
		$this->SetLineWidth(0.3);
		$this->SetFont('Arial', 'B', '12');
		$this->SetXY(27, 106);
		for ($i=0; $i<count($this->twArrColumnHeaders); $i++) {
			$this->Cell($this->twArrColumnWidth[$i], 7, $this->twArrColumnHeaders[$i], 1, 0, 'C', 1);
		}
		$this->ln();

		// table rows (including multi-cell)
		$this->SetFillColor(224, 235, 255);
		$this->SetFont('Arial', '', 10);
		$this->SetXY(27, 113);
		$i = 0;
		foreach ($this->order_positions as $pos) {
			$i++;
			$this->twShowRowWithMultiCell(array(
					$i,
					utf8_decode($pos['product_title']) .' - '. utf8_decode($pos['product_description']),
					sprintf("%9.2f", $pos['quantity']),
					sprintf("%9.2f", $pos['price']),
					sprintf("%9.2f", $pos['amount'])
			));
			$this->SetX(27);  // start on the left hand-side
		}
		$this->Cell(array_sum($this->twArrColumnWidth), 0, '', 'T');  // set table line at bottom
	}



	/**
	 * is only used if multiple pages are used
	 */
	private function twShowFinalPage() {
		$content = new content($this->business_customizing['business_payment_payment_terms']);
		
		// terms for billing
		$this->SetFont('Arial','I','9');
		$this->SetXY(26, 251);
		$this->SetAutoPageBreak(true, 10);    // set auto PageBreak
		$this->MultiCell(110, 3.2, $content->getText(), 0, 'L', 0);

		// invoice amounts
		// gross amount
		$this->SetFont('Arial','','10');
		$this->SetXY(141, 251);
		$this->Cell(24, 5, INVOICE_NET_AMOUNT .':', 0, 1, 'R');
		$this->SetXY(169, 251);
		$this->Cell(21, 5, sprintf("%9.2f", $this->invoice_data['invoice_sum_net']) ." ". iconv('UTF-8', 'windows-1252', $this->currency->getCurrencySign()), 0, 1, 'R');
		// tax
		$this->SetFont('Arial','','10');
		$this->SetXY(141, 257);
		$this->Cell(24, 5, '+'. $this->invoice_data['tax_rate'] .'% '. INVOICE_TAX_RATE .':', 0, 1, 'R');
		$this->SetXY(169, 257);
		$strWegenKlammer = sprintf("%9.2f", $this->invoice_data['invoice_sum_tax']). " ". iconv('UTF-8', 'windows-1252', $this->currency->getCurrencySign());
		$this->Cell(21, 5, $strWegenKlammer, 0, 1, 'R');
		// total amount
		$this->SetFont('Arial','B','12');
		$this->SetXY(141, 263);
		$strWegenKlammer = INVOICE_INVOICE_AMOUNT .':'. sprintf("%9.2f", $this->invoice_data['invoice_sum_gross']). " ". iconv('UTF-8', 'windows-1252', $this->currency->getCurrencySign());
		$this->Cell(49, 5, $strWegenKlammer, 0, 1, 'R');

		$this->SetFont('Arial','B','12');
		$this->SetTextColor(000, 000, 102);
	}




	/* twRoundCornerArea START ------------------------------------------------- */
	private function twRoundCornerArea($x, $y, $w, $h, $r, $style='') {
		$twRund = 4/3 * (sqrt(2) - 1);
		$k      = $this->k;
		$hp     = $this->h;
		$this->_out(sprintf('%.2f %.2f m',($x + $r) * $k, ($hp - $y) * $k));
		// top right
		$xc = $x + $w - $r ;
		$yc = $y + $r;
		$this->_out(sprintf('%.2f %.2f l', $xc * $k, ($hp - $y) * $k)); // Line
		$this->twRoundCorner($xc + $r*$twRund, $yc - $r, $xc + $r, $yc - $r*$twRund, $xc + $r, $yc); // Kurve
		// bottom right
		$xc = $x + $w - $r ;
		$yc = $y + $h - $r;
		$this->_out(sprintf('%.2f %.2f l',($x + $w) * $k, ($hp - $yc) * $k));  // Line
		$this->twRoundCorner($xc + $r, $yc + $r*$twRund, $xc + $r*$twRund, $yc + $r, $xc, $yc + $r); // Kurve
		// bottom left
		$xc = $x + $r ;
		$yc = $y + $h - $r;
		$this->_out(sprintf('%.2f %.2f l',$xc * $k, ($hp - ($y + $h)) * $k));  // Line
		$this->twRoundCorner($xc - $r*$twRund, $yc + $r, $xc - $r, $yc + $r*$twRund, $xc - $r, $yc); // Kurve
		// top left
		$xc = $x + $r ;
		$yc = $y + $r;
		$this->_out(sprintf('%.2f %.2f l',($x) * $k, ($hp - $yc) * $k));  // Line
		$this->twRoundCorner($xc - $r, $yc - $r*$twRund, $xc - $r*$twRund, $yc - $r, $xc, $yc - $r); // Kurve

		if     ($style == 'F') $op = 'f';
		elseif ($style == 'FD' or $style == 'DF') $op = 'B';
		else   {$op = 'S';
		}
		$this->_out($op);
	}

	private function twRoundCorner($x1, $y1, $x2, $y2, $x3, $y3) {
		// cubic corner for rectangle
		$h = $this->h;
		$this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ',
				$x1*$this->k,
				($h-$y1)*$this->k,
				$x2*$this->k,
				($h-$y2)*$this->k,
				$x3*$this->k,
				($h-$y3)*$this->k));
	}
	/* twRoundCornerArea END --------------------------------------------------- */



	/* twMultiCellTable START -------------------------------------------- */
	private function twSetColumnWidth($arrColumnWidth) {
		$this->twArrColumnWidth=$arrColumnWidth;
	}

	private function twSetColumnHeaders($arrColumnHeaders) {
		$this->twArrColumnHeaders=$arrColumnHeaders;
	}

	private function twShowRowWithMultiCell($arrColumns) {
		$anzSpalten    = count($arrColumns);
		$number_of_columns     = 0;   // ... �ndert sich
		$rowheight   = 5;   // hier die Zeilenh�he setzen!
		$heightTotal   = 0;   // ... �ndert sich
		$columnwidth = 0;   // ... �ndert sich

		for($i=0; $i<$anzSpalten; $i++) {
			$number_of_columns = max($number_of_columns, $this->twHoleAnzahlZeilen($this->twArrColumnWidth[$i], $arrColumns[$i]));
		}

		$heightTotal = $rowheight * $number_of_columns;   // totel height for rows
		$this->twCheckPageBreak($heightTotal);  // PageBreak if neccessary
		// draw cells of one row
		for($i=0; $i<$anzSpalten; $i++) {
			$columnwidth = $this->twArrColumnWidth[$i];  // get column width
			$x             = $this->GetX();              // get current x position aktuelle
			$y             = $this->GetY();              // get current y position

			// draw broder and content
			$this->Rect($x, $y, $columnwidth, $heightTotal);
			if ($i == 1) {
				$this->MultiCell($columnwidth, $rowheight, $arrColumns[$i], 0, 'L');
			} else {
				$this->MultiCell($columnwidth, $rowheight, $arrColumns[$i], 0, 'R');
			}
			$this->SetXY($x+$columnwidth, $y);  // set position right hand-side from multi-cell
		}
		$this->Ln($heightTotal);                
	}

	private function twCheckPageBreak($height) {
		// create new page if neccessary and append hint on next page 
		if($this->GetY()+$height>$this->PageBreakTrigger) {
			// hint on next page
			$this->SetXY(26, 251);
			$text01 = INVOICE_CONTINUANCE;
			$this->SetAutoPageBreak(false);       // PageBreak out
			$this->MultiCell(110, 3.2, $text01, 0, 'C', 0);
			$this->SetAutoPageBreak(true, 50);    // PageBreak in
			// new page
			$this->AddPage($this->CurOrientation);
			$this->SetX(27);
		}
	}

	private function twHoleAnzahlZeilen($width, $txt) {
		// calculate number of multi-cell rows with given width ($width)
		$cw = &$this->CurrentFont['cw'];
		if ($width == 0) {
			$width=$this->w-$this->rMargin-$this->x;
		}
		$wmax = ($width-2*$this->cMargin)*1000/$this->FontSize;
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
	/* twMultiCellTable END --------------------------------------------- */



}
?>