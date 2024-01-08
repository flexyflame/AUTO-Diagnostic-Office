<?php	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/Spreadsheet/Excel/Writer.php");

	function Student_Export_XLS($student_array) {
		ob_clean();

        $dbconn = DB_Connect_Direct();                
        if ($dbconn != false) {
			$objOfferHeader = NULL;
			$objAngebotPos = NULL;
			$objBedingungen = NULL;
			$Gesamt_Preis_Distribution = 0;
			$Gesamt_Anzahl_Distribution = 0;
			$Gesamt_Preis_Handling = 0;
			$Gesamt_Anzahl_Handling = 0;
			
			
			//
			// Ausgabe in Excel Datei
			//
			$filename = "TEsT_" . date('Y_m_d_H_i').".xls";
			
			$workbook = new Spreadsheet_Excel_Writer(); 
			$workbook->setVersion(8);
			
			$format_bold = $workbook->addFormat();
			$format_border = $workbook->addFormat();
			$format_underline = $workbook->addFormat();
			
			$format_border_header = $workbook->addFormat(array('Border' => 1, 'BorderColor' => 'black', 'Size' => 10, 'Align' => 'left', 'Bold' => 1, 'Underline' => 0, 'Color' => 'black', 'Pattern' => 1, 'FgColor' => 'white'));
			
			$format_border1_left = $workbook->addFormat(array('Border' => 1, 'BorderColor' => 'black', 'Size' => 10, 'Align' => 'left', 'Bold' => 0, 'Underline' => 0, 'Color' => 'black', 'Pattern' => 1, 'FgColor' => 'white'));
			
			$format_border1_right = $workbook->addFormat(array('Border' => 1, 'BorderColor' => 'black', 'Size' => 11, 'Align' => 'right', 'Bold' => 0, 'Underline' => 0, 'Color' => 'black', 'Pattern' => 1, 'FgColor' => 'white'));
			
			$format_bold->setBold();
			$format_border->setBorder(1); // Set and add border width
			$format_border->setBorderColor('black'); // set and add color to border
			$format_underline->setUnderline(1); // 1 = single underline / 2 = double underline
			
			$worksheet1 = $workbook->addWorksheet("Media Group Offer");						
			$worksheet1->setInputEncoding('utf-8');
			// $worksheet2 =& $workbook->addWorksheet("Tabelle 2");
			// $worksheet3 =& $workbook->addWorksheet("Tabelle 3");
			
			$ws1_x = 0; // Zeilen
			$ws1_y = 0; // Spalten
			
			//
			// Logo
			//
			//$worksheet1->insertBitmap($ws1_x, $ws1_y + 6, $_SERVER['DOCUMENT_ROOT'] . "/siteimg/mediagroup_logo.bmp", 0, 0, 0.8, 0.8);
			
			//
			// Handling-Produkte ausgeben
			//
			if (!empty($student_array)) {
				$worksheet1->write($ws1_x, $ws1_y, "Handling:", $workbook->addFormat(array('Size' => 11, 'Align' => 'left', 'Bold' => 1, 'Underline' => 1, 'Color' => 'black', 'Pattern' => 1, 'FgColor' => 'white'))); 
				$ws1_x++;
				$ws1_x++;
				
				$worksheet1->write($ws1_x, $ws1_y, "Description", $format_border_header);
				$worksheet1->write($ws1_x, $ws1_y + 1, "Qty", $format_border_header);
				$worksheet1->write($ws1_x, $ws1_y + 2, "Units", $format_border_header);
				$worksheet1->write($ws1_x, $ws1_y + 3, "Detail", $format_border_header);
				$worksheet1->write($ws1_x, $ws1_y + 4, "Total Price", $format_border_header);						
				
				// foreach ($xml_obj->angebot_positions_liste->angebot_position as $angebot_pos) {
				foreach ($student_array as $angebot_pos) {
						$ws1_x++;
						$worksheet1->write($ws1_x, $ws1_y, $angebot_pos->id, $format_border1_left);
						$worksheet1->write($ws1_x, $ws1_y + 1, $angebot_pos->lastname, $format_border1_right);
						$worksheet1->write($ws1_x, $ws1_y + 2, $angebot_pos->firstname, $format_border1_left);
						$worksheet1->write($ws1_x, $ws1_y + 3, $angebot_pos->nationality, $format_border1_left);
						$worksheet1->write($ws1_x, $ws1_y + 4, $angebot_pos->room, $format_border1_right);
					
				} // end foreach ($objAngebotPos as $angebot_pos);
				
				$ws1_x++;
				$ws1_x++;
				$ws1_x++;
			} // end if (!empty($objAngebotPos));


			
			$workbook->send($filename); 
			$workbook->close(); 
        }

         exit();
	}

	
	
?>