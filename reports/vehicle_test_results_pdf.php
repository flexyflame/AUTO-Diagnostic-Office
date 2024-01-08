<?php
//============================================================+
// Include the main TCPDF library (search for installation path).
require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/tcpdf/tcpdf.php");
// //
//Create Session
$SESSION = new ClassSession();
$UTIL = new ClassUtil($SESSION);

if (!isset($_SESSION)) { 
    session_start();
}
$_SESSION['error_type'] = '';

$post_parameters = "";
$test_id = 0;
if (!empty($_REQUEST['test_id'])) $test_id = $_REQUEST['test_id'];
$post_parameters .= "&test_id=" . $test_id;
//
$xml = REST_POST("/api/xml/v1/vehicle_tests_list.php", $post_parameters,null, false, false);

$xml_obj = simplexml_load_string($xml);
if ($xml_obj == NULL) {
    die('No results available!');
} else {
    $objVehicle_Tests = $xml_obj->vehicle_tests_list->vehicle_tests;
}

//Get shop details for header
$xml_shop = REST_POST("/api/xml/v1/shop_systems_list.php", "&id_shop_system=" . $objVehicle_Tests->id_shop_system, null, false, false);
$xml_shop_obj = simplexml_load_string($xml_shop);
if ($xml_shop_obj == NULL) {
    die('No shop detail available!');
} else {
    $objShop_Systems = $xml_shop_obj->shop_systems_list->shop_systems;
}

//Get id_var_mappings_list
$xml_shop = REST_POST("/api/xml/v1/id_var_mappings_list.php", "&type=10001&id=" . $test_id, null, false, false);
$xml_shop_obj = simplexml_load_string($xml_shop);
if ($xml_shop_obj == NULL) {
    die('No var_mappings_list detail available!');
} else {
    $objVar_Mappings_List = $xml_shop_obj->id_var_mappings_list->id_var_mappings;
}

//echo 'RESULT:: ' . Get_Var_Mappings_Value($objVar_Mappings_List, 'axle_2_parking_brake_force_diff1');

function Get_Var_Mappings_Value($obj=null, $variable = ''){
   if (!empty($obj)) {
      foreach ($obj as $id_var_mappings) {
         //echo $id_var_mappings->variable . '::' . $id_var_mappings->value . '<br>';
         if ($id_var_mappings->variable == $variable) {
            return $id_var_mappings->value;
         }
      }
   }
   return '';
}
// print_r($objVar_Mappings_List);
// echo $objVar_Mappings_List->variable;
//die();

// echo $objShop_Systems->shop_name;
// die($objVehicle_Tests->vehicle);

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
/*DKB***/
$HEADER_TITLE = '';
$HEADER_STRING = '';

$HEADER_TITLE = 'AUTO Diagnostic Office';
$HEADER_STRING = 'www.derrickbasoah.com';

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($HEADER_TITLE);
$pdf->SetTitle('International Postal Service');
$pdf->SetSubject('Products');
$pdf->SetKeywords('Angebot, PDF, Postal, Shipment, offer, Products, Produkt');


// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $HEADER_TITLE, $HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 9);

// add a page
$pdf->AddPage();
//$pdf->writeHTML($post_parameters, true, false, true, false, '');

// Set Shop hearder content to print
$html = '<div>
            <table>
               <tr>
                  <td width="30%" align="left">
                     <span style="font-size: large;"><strong style="color: brown;">AUTO</strong> Diagnostic Office</span><br>
                     <span style="font-size: smaller;"><strong>Generated by:</strong> ' . $_SESSION['fullname'] . '</span><br>
                     <span style="font-size: smaller;"><strong>Date: </strong>' . substr(date("d.m.Y H:i:s"), 0, 16)  . '</span><br><br>
                     <span style="font-size: large; text-decoration: underline;"><strong>Test Report No.:</strong> ' . $objVehicle_Tests->test_id . '</span><br>
                  </td>
                  <td width="30%" align="left">
                     <img src="/images/auto_logo.png"  width="120">
                  </td>';
$html .= '        <td width="40%" align="left">
                     <span style="color: #dedede;"><strong>' . $objShop_Systems->shop_name . ' (' . $objShop_Systems->shop_code . ')</strong></span><br>
                     <span>' . $objShop_Systems->display_address . '</span><br>
                     <span>' . $objShop_Systems->display_text . '</span><br>
                  </td>
               </tr>
            </table>
         </div>';

$pdf->writeHTML($html, true, false, true, false, '');

// Set Shop hearder content to print
$html = '<div style="border: 1px solid #4c9cb4;">
            <table>
               <tr>
                  <td width="30%" align="left">
                     <span><strong>Plate No:</strong> ' . $objVehicle_Tests->plate . '</span><br>
                     <span><strong>VIN:</strong> ' . $objVehicle_Tests->VehicleIdentificationNumber . '</span><br>
                     <span><strong>Vehicle Type:</strong> ' . $objVehicle_Tests->Vehicle_Class . '</span><br>
                     <span><strong>Vehicle Colour:</strong> ' . $objVehicle_Tests->Vehicle_Colour . '</span><br>
                     <span><strong>No. of Axles:</strong> ' . $objVehicle_Tests->AxleAmount . '</span><br>
                  </td>

                  <td width="30%" align="left">
                     <span><strong>Vehicle:</strong> ' . $objVehicle_Tests->vehicle . '</span><br>
                     <span><strong>Cubic Capacity:</strong> ' . $objVehicle_Tests->CubicCapacity . '</span><br>
                     <span><strong>Vehicle Make:</strong> ' . $objVehicle_Tests->Vehicle_Make . '</span><br>
                     <span><strong>Vehicle Model:</strong> ' . $objVehicle_Tests->Vehicle_Model . '</span><br>
                  </td>';

$html .= '        <td width="40%" align="left" style="border-left: 1px solid #4c9cb4;">
                     <span>' . $objVehicle_Tests->customer_company . '</span><br>
                     <span>' . $objVehicle_Tests->customer_Address . '</span><br>
                     <span>' . $objVehicle_Tests->customer_Address_Street_1 . ' ' . $objVehicle_Tests->customer_Address_Street_2 . '</span><br>
                     <span>' . $objVehicle_Tests->customer_Address_Zip . ' ' . $objVehicle_Tests->customer_Address_City . '</span><br>
                     <span>' . $objVehicle_Tests->customer_Address_Country . '</span><br>
                     <span>' . $objVehicle_Tests->customer_Phone . '</span><br>
                     <span>' . $objVehicle_Tests->customer_Email . '</span><br>
                  </td>
               </tr>
            </table>
         </div>';

$pdf->writeHTML($html, true, false, true, false, '');

if ($objVehicle_Tests->flag_brakes == 1) {
   $html = '<div>
         <h3>Brake Tester</h3>

         <div style="border-bottom: 1px dashed #607D8B;">
            <table cellpadding="2">
               <tr>
                  <th width="30%"><b><i style="color: #8A8A8B">Axle 1 Brake Result:</i></b></th>
                  <th width="10%"><b>Brake</b></th>
                  <th width="10%"><b>Force</b></th>
                  <th width="10%"><b>Brake Sum (%)</b></th>
                  <th width="10%"><b>Brake Diff (%)</b></th>
                  <th width="20%"><b>Limits<br><i style="color: #8A8A8B; font-size: small;">Brake force difference</i></b></th>
                  <th width="10%"><b>Result</b></th> 
               </tr>

               <tr>
                  <td><i style="color: #8A8A8B; font-size: small;">Total Weight: </i>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_1_total_weight") . ' Kg<br><i style="color: #8A8A8B; font-size: small;">Service Brake: </i>' .  ((Get_Var_Mappings_Value($objVar_Mappings_List, "axle_1_service_brake") == 1) ? $UTIL->IMG_Activated(7, 7) : $UTIL->IMG_Deactivated(7, 7)) .'</td>

                  <td><i style="color: #8A8A8B; font-size: small;">Left:</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_1_service_brake_force_left") . '</td>
                  <td><i style="color: #8A8A8B; font-size: small;">Right:</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_1_service_brake_force_right") . '</td>

                  <td><i style="color: #8A8A8B; font-size: small;">---</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_1_service_brake_force_sum") . '</td>
                  <td><i style="color: #8A8A8B; font-size: small;">---</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_1_service_brake_force_diff") . '</td>
                 
                  <td><i style="color: #8A8A8B; font-size: small;">Service brake &gt; 25&#37; <br>defective</i></td>
                  <td><br><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_1_service_brake_result") . '</td>
               </tr>
            </table>
         </div>

         <div style="border-bottom: 1px dashed #607D8B;">
            <table cellpadding="2">
               <tr>
                  <th width="30%"><b><i style="color: #8A8A8B">Axle 2 Brake Result:</i></b></th>
                  <th width="10%"></th>
                  <th width="10%"></th>
                  <th width="10%"></th>
                  <th width="10%"></th>
                  <th width="20%"><b><br><br><i style="color: #8A8A8B; font-size: small;">Declaration</i></b></th>
                  <th width="10%"></th> 
               </tr>

               <tr>
                  <td><i style="color: #8A8A8B; font-size: small;">Total Weight: </i>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_2_total_weight") . ' Kg<br><i style="color: #8A8A8B; font-size: small;">Parking Brake: </i>' .  ((Get_Var_Mappings_Value($objVar_Mappings_List, "axle_2_parking_brake") == 1) ? $UTIL->IMG_Activated(7, 7) : $UTIL->IMG_Deactivated(7, 7)) .'</td>

                  <td><i style="color: #8A8A8B; font-size: small;">Left:</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_2_parking_brake_force_left") . '</td>
                  <td><i style="color: #8A8A8B; font-size: small;">Right:</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_2_parking_brake_force_right") . '</td>

                  <td><i style="color: #8A8A8B; font-size: small;">---</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_2_parking_brake_force_sum") . '</td>
                  <td><i style="color: #8A8A8B; font-size: small;">---</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_2_parking_brake_force_diff") . '</td>
                 
                  <td><i style="color: #8A8A8B; font-size: small;">Parking brake &gt; 25&#37; <br>defective</i></td>
                  <td><br><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_2_parking_brake_result") . '</td>
               </tr>

               <tr>
                  <td><br><br><i style="color: #8A8A8B; font-size: small;">Service Brake: </i>' .  ((Get_Var_Mappings_Value($objVar_Mappings_List, "axle_2_service_brake") == 1) ? $UTIL->IMG_Activated(7, 7) : $UTIL->IMG_Deactivated(7, 7)) .'</td>

                  <td><i style="color: #8A8A8B; font-size: small;">Left:</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_2_service_brake_force_left") . '</td>
                  <td><i style="color: #8A8A8B; font-size: small;">Right:</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_2_service_brake_force_right") . '</td>

                  <td><i style="color: #8A8A8B; font-size: small;">---</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_2_service_brake_force_sum") . '</td>
                  <td><i style="color: #8A8A8B; font-size: small;">---</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_2_service_brake_force_diff") . '</td>
                 
                  <td><i style="color: #8A8A8B; font-size: small;">Service brake &gt; 25&#37; <br>defective</i></td>
                  <td><br><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_2_service_brake_result") . '</td>
               </tr>

            </table>
         </div>
      </div>';

   $pdf->writeHTML($html, true, false, true, false, '');
}

if ($objVehicle_Tests->flag_suspension_side_slip == 1) {
   $html = '<div>
         <h3>Shock Absorber</h3>

         <div style="border-bottom: 1px dashed #ececec;">
            <table cellpadding="2">
               <tr>
                  <th width="30%"><b><i style="color: #8A8A8B">Result:</i></b></th>
                  <th width="10%"></th>
                  <th width="10%"></th>
                  <th width="20%"><b><i style="color: #8A8A8B;">--- : ---</i></b></th>
                  <th width="15%"><b><i style="color: #8A8A8B;">Amplitude:</i></b></th>
                  <th width="15%"></th>
               </tr>

               <tr>
                  <td><i style="color: #8A8A8B;">Axel 1: </i></td>

                  <td><i style="color: #8A8A8B; font-size: small;">Left:</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_1_suspension_damping_left") . '%</td>
                  <td><i style="color: #8A8A8B; font-size: small;">Right:</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_1_suspension_damping_right") . '%</td>

                  <td><i style="color: #8A8A8B; font-size: small;">Difference:</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_1_suspension_diff") . '%</td>

                  <td><i style="color: #8A8A8B; font-size: small;">Left:</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_1_suspension_amplitude_left") . ' mm</td>
                  <td><i style="color: #8A8A8B; font-size: small;">Right:</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_1_suspension_amplitude_right") . ' mm</td>
               </tr>

               <tr>
                  <td><i style="color: #8A8A8B;">Axel 2: </i></td>

                  <td><i style="color: #8A8A8B; font-size: small;">Left:</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_2_suspension_damping_left") . '%</td>
                  <td><i style="color: #8A8A8B; font-size: small;">Right:</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_2_suspension_damping_right") . '%</td>

                  <td><i style="color: #8A8A8B; font-size: small;">Difference:</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_2_suspension_diff") . '%</td>

                  <td><i style="color: #8A8A8B; font-size: small;">Left:</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_2_suspension_amplitude_left") . ' mm</td>
                  <td><i style="color: #8A8A8B; font-size: small;">Right:</i><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_2_suspension_amplitude_right") . ' mm</td>
               </tr>
            </table>
         </div>

         <div style="border-bottom: 1px dashed #607D8B;">
            <table cellpadding="2">
               <tr>
                  <th width="50%"><b>Side Slip</b></th>
                  <th width="50%"><b><i style="color: #8A8A8B;">Result:</i></b></th>
               </tr>

               <tr>
                  <td><i style="color: #8A8A8B;">Axel 1: </i></td>
                  <td>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_1_side_slip") . ' mm/m</td>
               </tr>

               <tr>
                  <td><i style="color: #8A8A8B;">Axel 2: </i></td>
                  <td>' . Get_Var_Mappings_Value($objVar_Mappings_List, "axle_2_side_slip") . ' mm/m</td>
               </tr>
            </table>
         </div>

      </div>';

   $pdf->writeHTML($html, true, false, true, false, '');
}

if ($objVehicle_Tests->flag_headlight == 1) {
   $html = '<div>
         <h3>light Tester</h3>

         <div style="border-bottom: 1px dashed #ececec;">
            <table cellpadding="2">
               <tr>
                  <th width="40%"></th>
                  <th width="15%"><b><i style="color: #8A8A8B">Left:</i></b></th>
                  <th width="15%"><b><i style="color: #8A8A8B">Result:</i></b></th>
                  <th width="15%"><b><i style="color: #8A8A8B">Right:</i></b></th>
                  <th width="15%"><b><i style="color: #8A8A8B">Result:</i></b></th>
               </tr>

               <tr>
                  <td><i style="color: #8A8A8B;">Headlight Tester Intencity: </i></td>

                  <td><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "headlight_intencity_left") . '%</td>
                  <td><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "headlight_intencity_result_left") . '</td>

                  <td><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "headlight_intencity_right") . '%</td>
                  <td><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "headlight_intencity_result_right") . '</td>
               </tr>

               <tr>
                  <td><i style="color: #8A8A8B;">Low Beam Intencity: </i></td>

                  <td><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "low_beam_intencity_left") . '%</td>
                  <td><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "low_beam_intencity_result_left") . '</td>

                  <td><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "low_beam_intencity_right") . '%</td>
                  <td><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "low_beam_intencity_result_right") . '</td>
               </tr>

               <tr>
                  <td><i style="color: #8A8A8B;">Fog Beam Intencity: </i></td>

                  <td><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "fog_beam_intencity_left") . '%</td>
                  <td><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "fog_beam_intencity_result_left") . '</td>

                  <td><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "fog_beam_intencity_right") . '%</td>
                  <td><br>' . Get_Var_Mappings_Value($objVar_Mappings_List, "fog_beam_intencity_result_right") . '</td>
               </tr>

            
            </table>
         </div>

      </div>';

   $pdf->writeHTML($html, true, false, true, false, '');
}



   // if (!empty($objProdukt)) {
   //    foreach ($objProdukt as $Produkt) {
   //       ((++$iRowColor % 2) == 0) ? $table_bg_color = $UTIL->table_bg_color_odd() : $table_bg_color = $UTIL->table_bg_color_even();

   //       $html .= '<tr bgcolor="' . $table_bg_color . '">
   //                   <td>' . utf8_decode($Produkt->titel) . '</td>
   //                   <td>' . $Produkt->artikelnr . '</td>
   //                   <td>' . helper_decimal_seperator_from_browser_lang($Produkt->wert_ek, 3) . '<br><i style="color: #8A8A8B">' . helper_decimal_seperator_from_browser_lang($Produkt->wert_vk, 3) . '</i></td>
   //                   <td>' . sprintf("%0.0f", $Produkt->mwst) . '</td>
   //                   <td>' . helper_decimal_seperator_from_browser_lang($Produkt->laenge_mm, 0) . ' x ' . helper_decimal_seperator_from_browser_lang($Produkt->breite_mm, 0) . ' x ' . helper_decimal_seperator_from_browser_lang($Produkt->hoehe_mm, 0) . '<br><i style="color: #8A8A8B">' . helper_decimal_seperator_from_browser_lang($Produkt->gewicht_g, 0) . '</i></td> 
   //                   <td>' . $Produkt->lagerbestand . '</td>
   //                </tr>';

   //    } // end foreach ($objProdukt as $Produkt);
   // }// end if (!empty($objProdukt));






//
// $iRowColor = 0; $table_bg_color = ""; $status_str = "";
// //
// //  opt_stock_data opt_detail_data opt_barcode
// if ($option_filter == 'opt_general_data') {  
//     $html =  '<h3>Vehicle Test Overview: <em style="font-size: smaller; color: #CACACF;">General</em></h3>';
//     $html .= '<div>
//                     <table cellpadding="2" style="border-bottom: 2px solid #607D8B;">
//                         <tr>';
//     $html .= '          <th width="5%" style="border-bottom: 1px solid #607D8B;" align="left"><b>ID</b></th>
//                             <th width="25%" style="border-bottom: 1px solid #607D8B;" align="left"><b><span>Vehicle</span><br>Plate</b></th> 
//                             <th width="35%" style="border-bottom: 1px solid #607D8B;" align="left"><b>Customer</b></th>
//                             <th width="20%" style="border-bottom: 1px solid #607D8B;" align="left"><b>Date<br>Operator</b></th>
//                             <th width="15%" style="border-bottom: 1px solid #607D8B;" align="left"><b>Status</b></th>
//                         </tr>';
//     if (!empty($objVehicle_Tests)) {
//         foreach ($objVehicle_Tests as $Vehicle_Tests) {
//             ((++$iRowColor % 2) == 0) ? $table_bg_color = $UTIL->table_bg_color_odd() : $table_bg_color = $UTIL->table_bg_color_even();

//             $html .= '<tr bgcolor="' . $table_bg_color . '">
//                         <td>' . $Vehicle_Tests->test_id . '</td>
//                         <td>' . utf8_decode($Vehicle_Tests->vehicle) . '<br><span style="color: #8A8A8B;">' . utf8_decode($Vehicle_Tests->plate) . '</span></td>
//                         <td>' . utf8_decode($Vehicle_Tests->customer_company) . ' ( ' . $Vehicle_Tests->id_customer . ' )</td>
//                         <td>' . date('d-m-Y', intval($Vehicle_Tests->date)) . '<br><span style="color: #8A8A8B;">' . DB_UserFullName($Vehicle_Tests->id_users_created_by) . '</span></td>
//                         <td><b>' . Get_Status($Vehicle_Tests->status) . '</b></td>
//                     </tr>';

//             $html .= '<tr bgcolor="' . $table_bg_color . '">
//                         <td colspan="5" style="border-top: 1px dashed #607D8B; font-size: small;">';
//                             $html .= '<p style="font-style: italic; margin-bottom: 0px;">services to provide on vehicle:</p>';
                        
//                             if ($Vehicle_Tests->flag_brakes == 1) $html .= '<span>'. $UTIL->IMG_Activated(5, 5) .' Brakes </span>';
//                             if ($Vehicle_Tests->flag_suspension_side_slip == 1) $html .= '<span>'. $UTIL->IMG_Activated(5, 5) .' Suspension / Side Slip </span>';
//                             if ($Vehicle_Tests->flag_headlight == 1) $html .= '<span>'. $UTIL->IMG_Activated(5, 5) .' Headlight </span>';
//                             if ($Vehicle_Tests->flag_alignment == 1) $html .= '<span>'. $UTIL->IMG_Activated(5, 5) .' Alignment </span>';
//                             if ($Vehicle_Tests->flag_vulcanize == 1) $html .= '<span>'. $UTIL->IMG_Activated(5, 5) .' Vulcanize </span>';
//                             if ($Vehicle_Tests->flag_visual_defects == 1) $html .= '<span>'. $UTIL->IMG_Activated(5, 5) .' Visual Defects </span>';
//             $html .= '  </td>
//                     </tr>';

//         } // end foreach ($objVehicle_Tests as $Vehicle_Tests);
//     }// end if (!empty($objVehicle_Tests));

// }

//     $html .= '  </table>
//                 </div>
//                 <p style="font-size: 10rem;"><strong>No. of Records: </strong>' . $records_cnt . '</p>
//                 <br><br><br>';



// $pdf->writeHTML($html, true, false, true, false, '');
// // add a page
// //$pdf->AddPage();

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// reset pointer to the last page
$pdf->lastPage();


// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Vehicle_Test_Overview.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>