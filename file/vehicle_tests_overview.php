<!--Include Header-->
<?php  

    $path = $_SERVER['DOCUMENT_ROOT'];
    $header = $path . "/includes/header.php";
    include ($header);

    $nav = $path . "/includes/nav.php";
    include ($nav);

    //require_once($path . "/includes/output_functions.php");  

    $aktion = "show";
    if (!empty($_REQUEST['page_aktion'])) { $aktion = $_REQUEST['page_aktion']; }

    $posted = FALSE;
    if (!empty($_REQUEST['posted_'])) { $posted = TRUE; }

    $id_users = 0;
    if (isset($_REQUEST['id_users'])) { $id_users = $_REQUEST['id_users']; }

    //$SESSION->Session_User_Shop_Systems($_SESSION['id_users'], $_SESSION['supervisor']);
  // print_r($SESSION->GLOBAL_ARRAY_SHOP_SYSTEMS);
  // print_r($SESSION->Session_GetArrayShopSystems());
  // echo $UTIL->SQL_Variablelist_From_Array("S.id_shop_system", $SESSION->Session_GetArrayShopSystems(), "id_shop_system");
  // echo $UTIL->XML_Variablelist_From_Array("S.id_shop_system", $SESSION->Session_GetArrayShopSystems(), "id_shop_system", "&");


?>

<article>
   <div class="main-page">
      <div class="container-fluid">
         <div class="row">
            <div class="small-12 medium-8 large-10 columns" style="border-bottom: 1px solid #4c9cb4; margin: 0px -10px 0px 10px;">
               <h2 class="title" style="margin: 5px 0 0 0;">Manage Vehicle Tests</h2>
            </div>
         </div> 
      </div>

      <div class="container-fluid">
         <div style="margin-top: 5px;">
            <ul class="accordion" data-accordion data-allow-all-closed="true" style="margin: 10px 25px">
               <li class="accordion-item" data-accordion-item>
                  <!-- Accordion tab title -->
                  <a href="#" class="accordion-title filter-button">Advance Filter</a>
                  <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                  <div class="accordion-content" data-tab-content style="padding: 5px;">
                     <div class="filter-cover">
                        <div class="row">
                           <div class="small-12 medium-2 large-2 columns">
                              <label for="text_test_id_filter" class="left inline">Test ID:</label>
                              <input name="text_test_id_filter" type="text" id="text_test_id_filter" placeholder="Test ID" oninput="Filter_Reload();" />
                           </div>

                           <div class="small-12 medium-5 large-5 columns">
                              <label for="text_vehicle_filter" class="left inline">Vehicle:</label>
                              <input name="text_vehicle_filter" type="text" id="text_vehicle_filter" placeholder="Vehicle Name" oninput="Filter_Reload();"/>
                           </div>

                           <div class="small-12 medium-5 large-5 columns">
                              <label for="select_id_customer_filter" class="left inline">Customer:</label>
                              <?php
                                 $id_customer_selektiert = 0;
                                 if (isset($select_id_customer)) {
                                 $id_customer_selektiert = $select_id_customer;
                                 }
                                 $show_all = false; //Include inactive
                                 $show_contact_person = true;
                                 $select_id = "select_id_customer_filter";
                                 $select_name = "select_id_customer_filter";
                                 $select_size = 1;
                                 $select_extra_code = 'class="select-searchable" onchange="Filter_Reload();"';
                                 $db_conn_opt = false;
                                 $arr_option_values = array(0 => '- Select customer -');
                                 echo $UTIL->SELECT_Customer($id_customer_selektiert, $show_all, $show_contact_person, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
                              ?>
                           </div>
                        </div> 

                        <div class="row">
                           <div class="small-6 medium-2 large-2 columns">
                              <label for="text_plate_filter" class="left inline">Vehicle Plate:</label>
                              <input name="text_plate_filter" type="text" id="text_plate_filter" placeholder="Vehicle Plate" oninput="Filter_Reload();" />
                           </div>

                           <div class="small-6 medium-3 large-3 columns">
                              <label for="select_id_shop_system_filter" class="left inline">Test Shop:</label>
                              <?php
                                 $id_shop_system_selektiert = 0;
                                 $show_all = false; //Include inactive
                                 $show_customer = false;
                                 $select_id = "select_id_shop_system_filter";
                                 $select_name = "select_id_shop_system_filter";
                                 $select_size = 1;
                                 $select_extra_code = 'onchange="Filter_Reload();"';
                                 $db_conn_opt = false;
                                 $arr_option_values = array(0 => '- Select Test Shop -');
                                 echo $UTIL->SELECT_Shop_System($id_shop_system_selektiert, $show_all, $show_customer, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
                              ?>
                           </div>

                           <div class="small-6 medium-3 large-3 columns">
                              <label for="select_status_filter" class="left inline">Status</label>
                              <select id="select_status_filter" name="select_status_filter" onchange="Filter_Reload();">
                                 <option value="-1">Any</option>
                                 <option value="0">In Progress</option>
                                 <option value="1">Compleated</option> 
                                 <option value="2">Archived</option> 
                              </select>
                           </div>

                           <div class="small-6 medium-3 large-3 columns">
                              <label for="select_status_filter" class="left inline">Report Option:</label>
                              <div style="display: inline-flex; margin-top: 5px;">
                                 <input type="radio" id="opt_general" name="radio_option_filter" checked value="opt_general_data" style="margin-bottom: 5px;">  
                                 <label for="opt_general">General</label><br>
                                 <input type="radio" id="opt_detail" name="radio_option_filter" value="opt_detail_data" style="margin-bottom: 5px;">
                                 <label for="opt_detail">Detail</label><br>
                              </div>
                              
                           </div>

                           <div class="small-6 medium-1 large-1 columns" style="padding: 0px;">
                              <a class="button" onclick="Filter_Reload();" style="width: 100%; margin-top: 12px; margin-bottom: 0;">Filter</a>
                           </div>

                        </div> 
                     </div>
                  </div>
               </li>
            </ul>
         </div>
      </div> 

      <style type="text/css">
         .select2.select2-container {
            width: 100%!important;
         }

         .select2-selection.select2-selection--single {
             height: 31px;
             border: 1px solid #cacaca;
             border-radius: 3px;
             background-color: #fefefe;
             -webkit-box-shadow: inset 0 1px 2px rgba(10,10,10,.1);
             box-shadow: inset 0 1px 2px rgba(10,10,10,.1);
             font-size: smaller;
         }

         .select2-results {
            font-size: smaller;
         }
      </style>

      <!-- content rows -->
      <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" style="overflow: auto;" id="form_vehicle_tests_overview" name="form_vehicle_tests_overview" method="post">
         <div class="row" style="padding-top:5px">   

            <div class="small-12 medium-4 large-4 columns limit-cover cell">
               <div style="display: inline-flex; color: blue;" id="myTable_length">
                  <label style="display: inline-flex;">
                     <span style="padding: 5px 5px 0px 0px; color: #00ced1;;">Show </span> 
                     <select name="myTable_limit" id="myTable_limit" aria-controls="myTable" onchange="Filter_Reload();">
                        <option value="3">3</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                     </select> 
                     <span style="padding: 5px 5px 0px 5px; color: #00ced1;"> entries</span> 
                     <input type="hidden" name="myTable_offset" id="myTable_offset" value="0" />
                  </label>
               </div>
            </div>

            <div class="small-12 medium-3 large-3 columns search-cover cell">
            </div>

            <div class="small-12 medium-5 large-5 columns buttons-cover">
               <a class="button small btn-Table success" title="Save as Excel" onclick="Vehicle_Tests_Export('xls')"><i class="fas fa-file-excel" aria-hidden="true"></i> Print Excel</a>
               <a class="button small btn-Table alert" title="Save PDF" onclick="Vehicle_Tests_Export('pdf')"><i class="fas fa-file-pdf" aria-hidden="true"></i> Print PDF</a>
               <!-- <a class="button small btn-Table success" title="Print" href="/gen_pdf.php?page_aktion=print" target="_blank" onclick="SpinnerBlock();"><i class="fas fa-print" aria-hidden="true"></i></a> -->
               <a class="button small btn-Table" title="Add Record" onclick="Open_Vehicle_Tests_Reveal();"><i class="fas fa-plus-square" aria-hidden="true"></i> New Vehicle Test</a>
            </div>

            <div class="large-12 small-centered columns" style="padding: 0px;">
               <table class="responsive-card-table  table-expand hover" id="myTable">  
                  <thead>
                     <th width="5%">ID</th>
                     <th width="20%">Vehicle</th>
                     <th width="15%">Plate</th>
                     <th width="25%">Customer</th>
                     <th width="10%">Date</th>
                     <th width="10%" style="text-align: center;">Status</th>
                     <th width="15%" style="text-align: center;">***</th>
                  </thead>
                  <tbody id="tbody_Overview">

                  </tbody>
               </table>
            </div>

            <div class="small-12 medium-12 large-12 columns limit-cover cell">
               <div class="row">
                  <div class="small-12 medium-6 large-6 columns">
                     <div id="pagenav_info"></div>
                  </div>
                  <div class="small-12 medium-6 large-6 columns">
                     <div id="pagenav" role="status" aria-live="polite"></div>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>

   <!--Vehicle Tests Reveal-->
   <div class="reveal large" id="reveal_vehicle_tests_edit" name="reveal_vehicle_tests_edit" data-reveal data-close-on-click="false" style="padding: 1rem; border: 2px solid #607D8B; border-radius: 15px;">
      <fieldset style="padding: 0; border: 0;">

         <div class="mobile-nav-bar title-bar" style="background-color: #567a92; margin-bottom: 15px; padding: 5px 10px;">
            <div class="title-bar-left">
               <button class="menu-icon" type="button"></button>
            </div>
            <div class="title-bar-center">
               <span id="reveal_vehicle_tests_header_text">Create New Test</span>
            </div>
            <div class="title-bar-right">
               <a class="button hollow alert" onclick="Close_Vehicle_Tests_Reveal();" style="padding: 0; font-size: x-large; border: 0; margin: 0;" title="Close"><i class="far fa-times-circle"></i></a>
            </div>
         </div>

         <div id="callout_liste_reveal_vehicle_tests"></div>

         <form id="form_reveal_vehicle_tests" name="form_reveal_vehicle_tests" style="margin: 0px; box-shadow: unset;">
            <p id="i_date" style="margin-bottom: 0; font-size: small; font-style: italic; margin-top: -15px; text-align: center; color: darkcyan;">(13.10.2023)</p>

            <div class="row">
               <div class="small-12 medium-12 large-12 columns">
                  <div class="row">
                     <div class="small-2 medium-1 large-1 columns hide">
                        <label for="text_test_id" class="left inline">Test ID:</label>
                        <input name="text_test_id" type="text" id="text_test_id" placeholder="ID" value="" readonly />
                     </div>
                     <div class="small-12 medium-2 large-2 columns">
                        <label for="select_limit_class_id" class="left inline">Vehicle Class:</label>
                        <?php
                        $vehicle_class_selektiert = 0;
                        $select_id = "select_limit_class_id";
                        $select_name = "select_limit_class_id";
                        $select_size = 1;
                        $select_extra_code = 'onchange="Select_limit_class_id_onChange(this)"';
                        $db_conn_opt = false;
                        $arr_option_values = null;//array(0 => '');
                        echo $UTIL->SELECT_Vehicle_Class_Limits($vehicle_class_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
                        ?>
                     </div>
                     <!-- <div class="small-12 medium-6 large-6 columns">
                        <label for="text_vehicle" class="left inline">Vehicle:</label>
                        <input name="text_vehicle" type="text" id="text_vehicle" placeholder="eg. Toyota" value="" />
                     </div> -->
                     <div class="small-12 medium-6 large-6 columns">
                        <label for="select_vehicle_producer" class="left inline">Vehicle:</label>
                        <?php
                           $vehicle_producer_selektiert = -1;
                           $show_all = false; //Include inactive
                           $show_contact_person = true;
                           $select_id = "select_vehicle_producer";
                           $select_name = "select_vehicle_producer";
                           $select_size = 1;
                           $select_extra_code = 'class="select-searchable-tag"';
                           $db_conn_opt = false;
                           $arr_option_values = array(0 => '- Select vehicle -');
                           echo $UTIL->SELECT_Vehicle_Producer($vehicle_producer_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
                        ?>
                     </div>

                     <div class="small-6 medium-2 large-2 columns">
                        <label for="text_plate" class="left inline">Plate:</label>
                        <input class="uc-text" name="text_plate" type="text" id="text_plate" placeholder="eg. AS 1234 23" value="" />
                     </div>
                     <div class="small-6 medium-2 large-2 columns">
                        <label for="select_status" class="left inline">Status:</label>
                        <select id="select_status" name="select_status">
                           <option value="0">In Progress</option>
                           <option value="1">Compleated</option> 
                           <option value="2">Archived</option> 
                        </select>
                     </div>
                  </div> 

                  <div class="row"> 
                     <div class="small-12 medium-5 large-5 columns">
                        <label for="select_id_customer" class="left inline">Customer:</label>
                        <?php
                           $id_customer_selektiert = 0;
                           $show_all = false; //Include inactive
                           $show_contact_person = false;
                           $select_id = "select_id_customer";
                           $select_name = "select_id_customer";
                           $select_size = 1;
                           $select_extra_code = 'class="select-searchable-tag"';
                           $db_conn_opt = false;
                           $arr_option_values = array(0 => '');
                           echo $UTIL->SELECT_Customer($id_customer_selektiert, $show_all, $show_contact_person, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
                        ?>
                     </div>
                     <div class="small-12 medium-5 large-5 columns">
                        <label for="select_id_shop_system" class="left inline">Test Shop:</label>
                        <?php
                           $id_shop_system_selektiert = 0;
                           $show_all = false; //Include inactive
                           $show_customer = true;
                           $select_id = "select_id_shop_system";
                           $select_name = "select_id_shop_system";
                           $select_size = 1;
                           $select_extra_code = '';
                           $db_conn_opt = false;
                           $arr_option_values = null;//array(0 => '');
                           echo $UTIL->SELECT_Shop_System($id_shop_system_selektiert, $show_all, $show_contact_person, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
                        ?>
                     </div>

                     <div class="small-4 medium-2 large-2 columns">
                        <label for="text_ReceiptId" class="left inline">Receipt Id:</label>
                        <input class="uc-text" name="text_ReceiptId" type="text" id="text_ReceiptId" placeholder="eg. R00451"/>
                     </div> 
                  </div>

                  <div class="row">
                     <div class="small-6 medium-2 large-2 columns">
                        <label for="text_AxleAmount" class="left inline">No. of Axles:</label>
                        <input name="text_AxleAmount" type="number" id="text_AxleAmount"/>
                     </div>
                     <div class="small-6 medium-2 large-2 columns">
                        <label for="text_CubicCapacity" class="left inline">Cubic Capacity:</label>
                        <input name="text_CubicCapacity" type="text" id="text_CubicCapacity" placeholder="eg. 2400" onkeypress="return onlyNumberKey(event)"/>
                     </div>
                     <div class="small-12 medium-4 large-4 columns">
                        <label for="text_VehicleIdentificationNumber" class="left inline">VIN:</label>
                        <input class="uc-text" name="text_VehicleIdentificationNumber" type="text" id="text_VehicleIdentificationNumber" maxlength="17" placeholder="1HGBH41XXXXXXXXXX" value=""/>
                     </div>

                     <div class="small-6 medium-2 large-2 columns">
                        <label for="text_ProductionYear" class="left inline">Production Year:</label>
                        <input name="text_ProductionYear" type="number" id="text_ProductionYear" maxlength="4" placeholder="eg. 2014"/>
                     </div>
                     <div class="small-6 medium-2 large-2 columns">
                        <label for="text_FirstUse" class="left inline">First Use:</label>
                        <input name="text_FirstUse" type="number" id="text_FirstUse" placeholder="eg. 2015"/>
                     </div>
                  </div> 

                  <div class="row">
                     
                     <div class="small-6 medium-2 large-2 columns">
                        <label for="text_TotalWeight" class="left inline">Total Weight (kg):</label>
                        <input name="text_TotalWeight" type="number" id="text_TotalWeight" placeholder="eg. 2780 kg"/>
                     </div>
                     <div class="small-6 medium-2 large-2 columns">
                        <label for="text_TotalMeasuredWeight" class="left inline">Measured Weight:</label>
                        <input name="text_TotalMeasuredWeight" type="number" id="text_TotalMeasuredWeight" placeholder="eg. 2980 kg"/>
                     </div>
                     <div class="small-6 medium-2 large-2 columns">
                        <label for="text_LastInspection" class="left inline">Last Inspection:</label>
                        <input class="filter-control-text data-time" type="text" id="text_LastInspection" name="text_LastInspection">            
                     </div>
                     <div class="small-6 medium-2 large-2 columns">
                        <label for="text_Vehicle_Make" class="left inline">Vehicle Make:</label>
                        <input name="text_Vehicle_Make" type="text" id="text_Vehicle_Make" placeholder="Vehicle Make" value=""/>
                     </div>
                     <div class="small-6 medium-2 large-2 columns">
                        <label for="text_Vehicle_Model" class="left inline">Vehicle Model:</label>
                        <input name="text_Vehicle_Model" type="text" id="text_Vehicle_Model" placeholder="Vehicle Model" value=""/>
                     </div>
                     <div class="small-6 medium-2 large-2 columns">
                        <label for="text_Vehicle_Colour" class="left inline">Vehicle Colour:</label>
                        <input name="text_Vehicle_Colour" type="text" id="text_Vehicle_Colour" placeholder="Vehicle Colour" value=""/>
                     </div>
                  </div> 

                  <div class="row">
                     <div class="small-12 medium-4 large-4 columns">
                        <label for="text_Vehicle_Purpose" class="left inline">Vehicle Result:</label>
                        <textarea rows="2" name="text_Vehicle_Purpose" id="text_Vehicle_Purpose" class="control-input" style="min-height: 50px; resize: none;" data-element-index="19" placeholder="Vehicle Result"></textarea>
                     </div> 
                     <div class="small-12 medium-4 large-4 columns">
                        <label for="text_test_result" class="left inline">Test Result:</label>
                        <textarea rows="2" name="text_test_result" id="text_test_result" class="control-input" style="min-height: 50px; resize: none;" data-element-index="19" placeholder="Test Result"></textarea>
                     </div> 
                     <div class="small-12 medium-4 large-4 columns">
                        <label for="text_TestPurpose" class="left inline">Test Purpose:</label>
                        <textarea rows="2" name="text_TestPurpose" id="text_TestPurpose" class="control-input" style="min-height: 50px; resize: none;" data-element-index="19" placeholder="Test Purpose"></textarea>
                     </div>
                  </div>   

                  <div class="row" style="margin: 0;">
                     <div class="small-12 medium-12 large-12 columns" style="padding: 0;">
                        <fieldset style="border: 1px solid #e6e6e6; border-radius: 10px; margin-bottom: 10px; padding: 5px 15px; background: aliceblue;">
                           <legend style="margin-bottom: 0; font-size: medium;">Select services to provide on vehicle:</legend>

                           <div class="row" style="margin-bottom: 5px;">
                              
                              <div class="small-12 medium-4 large-4 columns">
                                 <label style="font-weight: 500;"><input type="checkbox" id="flag_brakes" data-element-index="21" value="0" onclick="Checkbox_value_change(this); Service_Type_Switch(this.id);" style="margin-bottom: 0;">Brakes</label>
                              </div>
                              <div class="small-12 medium-4 large-4 columns">
                                 <label style="font-weight: 500;"><input type="checkbox" id="flag_suspension_side_slip" data-element-index="20" value="0" onclick="Checkbox_value_change(this); Service_Type_Switch(this.id);" style="margin-bottom: 0;">Suspension / Side Slip</label>
                              </div>
                              <div class="small-12 medium-4 large-4 columns">
                                 <label style="font-weight: 500;"><input type="checkbox" id="flag_headlight" data-element-index="20" value="0" onclick="Checkbox_value_change(this); Service_Type_Switch(this.id);" style="margin-bottom: 0;">Headlight</label>
                              </div>
                           </div>

                           <div class="row" style="margin-bottom: 5px;">
                              <div class="small-12 medium-4 large-4 columns">
                                 <label style="font-weight: 500;"><input type="checkbox" id="flag_alignment" data-element-index="20" value="0" onclick="Checkbox_value_change(this); Service_Type_Switch(this.id);" style="margin-bottom: 0;">Alignment</label>
                              </div>
                              <div class="small-12 medium-4 large-4 columns">
                                 <label style="font-weight: 500;"><input type="checkbox" id="flag_vulcanize" data-element-index="20" value="0" onclick="Checkbox_value_change(this); Service_Type_Switch(this.id);" style="margin-bottom: 0;">Vulcanize</label>
                              </div>
                              <div class="small-12 medium-4 large-4 columns">
                                 <label style="font-weight: 500;"><input type="checkbox" id="flag_visual_defects" data-element-index="20" value="0" disabled onclick="Checkbox_value_change(this); Service_Type_Switch(this.id);" style="margin-bottom: 0;">Visual Defects</label>
                              </div>
                           </div>

                           <div class="row hide" style="margin-bottom: 5px;">
                              <div class="small-12 medium-4 large-4 columns">
                                 <label style="font-weight: 500;"><input type="checkbox" id="flag_emission" data-element-index="21" value="0" onclick="Checkbox_value_change(this); Service_Type_Switch(this.id);" style="margin-bottom: 0;">Emission</label>
                              </div>
                              <div class="small-12 medium-4 large-4 columns">
                                 <label style="font-weight: 500;"><input type="checkbox" id="flag_extrapolation" data-element-index="21" value="0" onclick="Checkbox_value_change(this); Service_Type_Switch(this.id);" style="margin-bottom: 0;">Extrapolation</label>
                              </div>
                           </div>
                        </fieldset>
                     </div> 
                  </div>

                  <div class="control-group row" id="items_fieldset" style="margin-top: 10px; border-top: 1px dashed #1779ba; padding-top: 5px;">
                     <div class="small-12 medium-12 large-12 columns">
                        
                        <div class="row" id="flag_brakes_items_fieldset" style="background-color: aliceblue; padding: 5px; border-radius: 10px; margin-top: 10px;"></div>
                        <div class="row" id="flag_suspension_side_slip_items_fieldset" style="background-color: #ffe9e9; padding: 5px; border-radius: 10px; margin-top: 10px;"></div>
                        <div class="row" id="flag_headlight_items_fieldset" style="background-color: lightpink; padding: 5px; border-radius: 10px; margin-top: 10px;"></div>

                        <div class="row" id="flag_alignment_items_fieldset" style="background-color: lightyellow; padding: 5px; border-radius: 10px; margin-top: 10px;"></div>
                        <div class="row" id="flag_vulcanize_items_fieldset" style="background-color: lightgreen; padding: 5px; border-radius: 10px; margin-top: 10px;"></div>
                        <div class="row" id="flag_visual_defects_items_fieldset" style="background-color: beige; padding: 5px; border-radius: 10px; margin-top: 10px;"></div>

                        <div class="row hide" id="flag_emission_items_fieldset"></div>
                        <div class="row hide" id="flag_extrapolation_items_fieldset"></div>

                        
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="small-12 medium-2 large-2 columns"></div>
               <div class="small-12 medium-8 large-8 columns">
                  <div class="button-group-option" data-grouptype="OR" style="margin: 5px 0px; padding: 0px;">
                     <a class="button alert radius" style="padding: 10px;" id="btn_abbrechen" name="btn_abbrechen" onclick="Close_Vehicle_Tests_Reveal();">Cancel</a>
                     <a class="button warning radius" style="padding: 10px;" id="btn_speichern" name="btn_speichern" onclick="Helper_Vehicle_Tests_Edit();" data-element-index="10">Save</a>
                  </div>
               </div>
               <div class="small-12 medium-2 large-2 columns"></div>
            </div>
         </form>
      </fieldset>
   </div>

   <!-------Hidden controls--------->
   <div class="hidden-controls">
      <input type="hidden" id="test_id_hidden" value="0" />
   </div>
</article>

<!--Include Nav_Footer and Footer-->
<?php 
   $path = $_SERVER['DOCUMENT_ROOT'] ;
   include ($path . "/includes/nav_footer.php");
   include ($path . "/includes/footer.php");
?>


<script type="text/javascript">
   var select_id_customer_filter = document.getElementById("select_id_customer_filter");
   var text_test_id_filter = document.getElementById("text_test_id_filter");
   var text_vehicle_filter = document.getElementById("text_vehicle_filter");
   var select_status_filter = document.getElementById("select_status_filter");
   var text_plate_filter = document.getElementById("text_plate_filter");
   var select_id_shop_system_filter = document.getElementById("select_id_shop_system_filter");

   //Reveal controls
   var reveal_vehicle_tests_header_text = document.getElementById("reveal_vehicle_tests_header_text");
   var test_id_hidden = document.getElementById("test_id_hidden");
   var callout_liste_reveal_vehicle_tests = document.getElementById("callout_liste_reveal_vehicle_tests");

   var i_date = document.getElementById('i_date');

   //text_test_id text_vehicle text_plate select_id_customer select_id_shop_system select_status
   var rEVEAL_text_test_id = document.getElementById("text_test_id");
   var rEVEAL_select_vehicle_producer = document.getElementById("select_vehicle_producer");

   var rEVEAL_text_plate = document.getElementById("text_plate");
   var rEVEAL_select_id_customer = document.getElementById("select_id_customer");
   var rEVEAL_select_id_shop_system = document.getElementById("select_id_shop_system");
   var rEVEAL_select_status = document.getElementById("select_status");

   //text_AxleAmount text_CubicCapacity text_VehicleIdentificationNumber text_ProductionYear text_FirstUse text_TotalWeight text_TotalMeasuredWeight text_LastInspection 
   var rEVEAL_text_AxleAmount = document.getElementById("text_AxleAmount");
   var rEVEAL_text_CubicCapacity = document.getElementById("text_CubicCapacity");
   var rEVEAL_text_VehicleIdentificationNumber = document.getElementById("text_VehicleIdentificationNumber");
   var rEVEAL_text_ProductionYear = document.getElementById("text_ProductionYear");
   var rEVEAL_text_FirstUse = document.getElementById("text_FirstUse");
   var rEVEAL_text_TotalWeight = document.getElementById("text_TotalWeight");
   var rEVEAL_text_TotalMeasuredWeight = document.getElementById("text_TotalMeasuredWeight");
   var rEVEAL_text_LastInspection = document.getElementById("text_LastInspection");

   //text_ReceiptId select_limit_class_id text_Vehicle_Make text_Vehicle_Colour text_Vehicle_Model text_Vehicle_Purpose text_test_result text_TestPurpose 
   var rEVEAL_text_ReceiptId = document.getElementById("text_ReceiptId");
   var rEVEAL_select_limit_class_id = document.getElementById("select_limit_class_id");
   var rEVEAL_text_Vehicle_Make = document.getElementById("text_Vehicle_Make");
   var rEVEAL_text_Vehicle_Colour = document.getElementById("text_Vehicle_Colour");
   var rEVEAL_text_Vehicle_Model = document.getElementById("text_Vehicle_Model");
   var rEVEAL_text_Vehicle_Purpose = document.getElementById("text_Vehicle_Purpose");
   var rEVEAL_text_test_result = document.getElementById("text_test_result");
   var rEVEAL_text_TestPurpose = document.getElementById("text_TestPurpose");

   //flag_visual_defects flag_brakes flag_extrapolation flag_alignment flag_suspension_side_slip flag_headlight flag_emission flag_vulcanize
   var rEVEAL_flag_visual_defects = document.getElementById("flag_visual_defects");
   var rEVEAL_flag_brakes = document.getElementById("flag_brakes");
   var rEVEAL_flag_extrapolation = document.getElementById("flag_extrapolation");
   var rEVEAL_flag_alignment = document.getElementById("flag_alignment");
   var rEVEAL_flag_suspension_side_slip = document.getElementById("flag_suspension_side_slip");
   var rEVEAL_flag_headlight = document.getElementById("flag_headlight");
   var rEVEAL_flag_emission = document.getElementById("flag_emission");
   var rEVEAL_flag_vulcanize = document.getElementById("flag_vulcanize");
   // 
   var flag_visual_defects_items_fieldset = document.getElementById('flag_visual_defects_items_fieldset');
   var flag_brakes_items_fieldset = document.getElementById('flag_brakes_items_fieldset');
   var flag_extrapolation_items_fieldset = document.getElementById('flag_extrapolation_items_fieldset');
   var flag_suspension_side_slip_items_fieldset = document.getElementById('flag_suspension_side_slip_items_fieldset');
   var flag_headlight_items_fieldset = document.getElementById('flag_headlight_items_fieldset');
   var flag_emission_items_fieldset = document.getElementById('flag_emission_items_fieldset');
   var flag_alignment_items_fieldset = document.getElementById('flag_alignment_items_fieldset');
   var flag_vulcanize_items_fieldset = document.getElementById('flag_vulcanize_items_fieldset');       

   var myTable_limit = document.getElementById("myTable_limit");
   var myTable_offset = document.getElementById("myTable_offset");

   <?php 
      echo "var arr_id_shop_system = '" . $UTIL->XML_Variablelist_From_Array("id_shop_system", $SESSION->Session_GetArrayShopSystems(), "id_shop_system", "&") . "'";  
   ?>

   console.log(arr_id_shop_system);

   addLoadEvent(REST_Vehicle_Tests_list(0, myTable_offset.value, myTable_limit.value));

   $("#reveal_vehicle_tests_edit").on("open.zf.reveal", function () {
      console.log("reveal_vehicle_tests_edit: open.zf.reveal");

      $("#form_reveal_vehicle_tests")[0].reset();
      //
      SELECT_Option(rEVEAL_select_vehicle_producer, 0);
      SELECT_Option(rEVEAL_select_id_customer, 0);
      CHECK_Option(rEVEAL_flag_visual_defects, 0);
      CHECK_Option(rEVEAL_flag_brakes, 0);
      CHECK_Option(rEVEAL_flag_extrapolation, 0);
      CHECK_Option(rEVEAL_flag_alignment, 0);
      CHECK_Option(rEVEAL_flag_suspension_side_slip, 0);
      CHECK_Option(rEVEAL_flag_headlight, 0);
      CHECK_Option(rEVEAL_flag_emission, 0);
      CHECK_Option(rEVEAL_flag_vulcanize, 0);
      //
      i_date.innerText = Timestamp_Format_UTC(Math.floor(Date.now() / 1000)).slice(0, -7);
      Select_limit_class_id_onChange(rEVEAL_select_limit_class_id);
      callout_liste_reveal_vehicle_tests.innerHTML = "";
      //
      flag_visual_defects_items_fieldset.innerHTML = '';
      flag_brakes_items_fieldset.innerHTML = '';
      flag_extrapolation_items_fieldset.innerHTML = '';
      flag_suspension_side_slip_items_fieldset.innerHTML = '';
      flag_headlight_items_fieldset.innerHTML = '';
      flag_emission_items_fieldset.innerHTML = '';
      flag_alignment_items_fieldset.innerHTML = '';
      flag_vulcanize_items_fieldset.innerHTML = '';

      if (test_id_hidden.value != 0) {
         reveal_vehicle_tests_header_text.innerText = "Edit Test Shop (" + test_id_hidden.value + ")";

         REST_Vehicle_Test_load(test_id_hidden.value)

      } else {
         reveal_vehicle_tests_header_text.innerText = "Create New Test Shop";
      }

   });

   $('.data-time').fdatepicker({
      initialDate: '<?php echo date('d.m.Y') ?>',
      language: 'de',
      weekStart: 1,
      format: 'dd.mm.yyyy',
      disableDblClickSelection: true,
      leftArrow:'<<',
      rightArrow:'>>',
      closeIcon:'X',
      closeButton: true
   });

   function calcSum_Percentage(x, y, fixed = 2) {
      x = (+x) * -1;
      y = (+y) * -1;
      const percent = (x / y) * 100;
      if(!isNaN(percent)){
         console.log('CCCCC',percent);
         return Number(percent.toFixed(fixed));
      }else{
         return 0.00;
      }
   }

   function calcDiff_Percentage(a, b, fixed = 2) {
      a = (+a) * -1;
      b = (+b) * -1;
      const percent = 100 * Math.abs( ( a - b ) / ( (a+b)/2 ) );
      if(!isNaN(percent)){
         return Number(percent.toFixed(fixed));
      }else{
         return 0.00;
      }
   }

   function Axle_1_service_brake_force_cal() {
      console.log('Axle_1_service_brake_force_cal');

      var axle_1_service_brake_force_left = document.getElementById('axle_1_service_brake_force_left'); 
      var axle_1_service_brake_force_right = document.getElementById('axle_1_service_brake_force_right'); 
      var axle_1_service_brake_force_sum = document.getElementById('axle_1_service_brake_force_sum'); 
      var axle_1_service_brake_force_diff = document.getElementById('axle_1_service_brake_force_diff'); 
      //
      axle_1_service_brake_force_sum.value = calcSum_Percentage(axle_1_service_brake_force_left.value, axle_1_service_brake_force_right.value);
      axle_1_service_brake_force_diff.value = calcDiff_Percentage(axle_1_service_brake_force_left.value, axle_1_service_brake_force_right.value);
         
      return;
   }//end Axle_1_service_brake_force_cal();

   function Axle_2_service_brake_force_cal() {
      console.log('Axle_2_service_brake_force_cal');

      var axle_2_service_brake_force_left = document.getElementById('axle_2_service_brake_force_left'); 
      var axle_2_service_brake_force_right = document.getElementById('axle_2_service_brake_force_right'); 
      var axle_2_service_brake_force_sum = document.getElementById('axle_2_service_brake_force_sum'); 
      var axle_2_service_brake_force_diff = document.getElementById('axle_2_service_brake_force_diff'); 

      axle_2_service_brake_force_sum.value = calcSum_Percentage(axle_2_service_brake_force_left.value, axle_2_service_brake_force_right.value);
      axle_2_service_brake_force_diff.value = calcDiff_Percentage(axle_2_service_brake_force_left.value, axle_2_service_brake_force_right.value);

      return;
   }//end Axle_2_service_brake_force_cal();

   function Axle_2_parking_brake_force_cal() {
      console.log('Axle_2_parking_brake_force_cal');

      var axle_2_parking_brake_force_left = document.getElementById('axle_2_parking_brake_force_left'); 
      var axle_2_parking_brake_force_right = document.getElementById('axle_2_parking_brake_force_right'); 
      var axle_2_parking_brake_force_sum = document.getElementById('axle_2_parking_brake_force_sum'); 
      var axle_2_parking_brake_force_diff = document.getElementById('axle_2_parking_brake_force_diff'); 

      axle_2_parking_brake_force_sum.value = calcSum_Percentage(axle_2_parking_brake_force_left.value, axle_2_parking_brake_force_right.value);
      axle_2_parking_brake_force_diff.value = calcDiff_Percentage(axle_2_parking_brake_force_left.value, axle_2_parking_brake_force_right.value);

      return;
   }//end Axle_2_parking_brake_force_cal();

   function Service_Type_Switch(var_service_type, var_test_id = 0) {
      console.log('Service_Type_Switch(Service Type::' + var_service_type + ' Test ID::' + var_test_id + ')');

      var service_type = document.getElementById(var_service_type);

      //Clear items_fieldset
      switch (service_type.id) {
         case 'flag_visual_defects':
            flag_visual_defects_items_fieldset.innerHTML = '';
            if (service_type.value == 1) {
               Build_flag_visual_defects(var_test_id);
            }
            break;
         case 'flag_brakes':
            flag_brakes_items_fieldset.innerHTML = '';
            if (service_type.value == 1) {
               Build_flag_brakes(var_test_id);
            }
            break;
         case 'flag_extrapolation':
            flag_extrapolation_items_fieldset.innerHTML = '';
            if (service_type.value == 1) {
               Build_flag_extrapolation(var_test_id);
            }
            break;
         case 'flag_suspension_side_slip':
            flag_suspension_side_slip_items_fieldset.innerHTML = '';
            if (service_type.value == 1) {
               Build_flag_suspension_side_slip(var_test_id);
            }
            break;
         case 'flag_headlight':
            flag_headlight_items_fieldset.innerHTML = '';
            if (service_type.value == 1) {
               Build_flag_headlight(var_test_id);
            }
            break;
         case 'flag_emission':
            flag_emission_items_fieldset.innerHTML = '';
            if (service_type.value == 1) {
               Build_flag_emission(var_test_id);
            }
            break;
         case 'flag_alignment':
            flag_alignment_items_fieldset.innerHTML = '';
            if (service_type.value == 1) {
               Build_flag_alignment(var_test_id);
            }
            
            break;
         case 'flag_vulcanize':
            flag_vulcanize_items_fieldset.innerHTML = '';
            if (service_type.value == 1) {
               Build_flag_vulcanize(var_test_id);
            }
            break;
      }

      return;
   } // end Service_Type_Switch(ctr); 

   function Build_flag_visual_defects(var_test_id = 0) {
      console.log('Build_flag_visual_defects()');

      var innerHTML = '';
      innerHTML += '<div class="small-12 medium-10 large-10 columns">';
      innerHTML += '  <label for="store_url" class="input-control-label show-for-small-only">Store URL:</label>';
      innerHTML += '  <input required type="text" id="store_url" class="input-control-text item_field" id_var_mapping="0" placeholder="eg. https://storename.com" />';
      innerHTML += '</div>';

      innerHTML += '<div class="small-12 medium-10 large-10 columns">';
      innerHTML += '  <label for="store_url" class="input-control-label show-for-small-only">Store Key:</label>';
      innerHTML += '  <input required type="text" id="store_key" class="input-control-text item_field" id_var_mapping="0" placeholder="eg. ktv4n9rgrj0evjuy2t6p2xlb1f8u5pmy" />';
      innerHTML += '</div>';

      innerHTML += '<div class="small-2 medium-2 large-2 columns hide-for-small-only"></div>';
      innerHTML += '<div class="small-12 medium-10 large-10 columns" >';
      innerHTML += ' <div class="input-control-check-cover" style="margin-top: 0;">';
      innerHTML += '    <div class="row" style="margin-top: 5px;">';
      innerHTML += '       <div class="small-12 medium-12 large-12 columns">';
      innerHTML += '          <label style="font-weight: 600;">';
      innerHTML += '             <input type="checkbox" class="item_field" id="flag_bestandsaktualisierung" data-element-index="22" value="0" onclick="Checkbox_value_change(this)">Aktualisierung des Shop-Systembestands';
      innerHTML += '          </label>';
      innerHTML += '       </div>';
      innerHTML += '    </div>';
      innerHTML += ' </div>';
      innerHTML += '</div>';
      //
      flag_visual_defects_items_fieldset.innerHTML = innerHTML;
      //
      //Build Item_Fieldsfrom Var_Mapping
      if (var_test_id !== 0) Item_Fields_Var_Mapping_Load(var_test_id);
   } // end Build_flag_visual_defects();

   function Build_flag_brakes(var_test_id = 0) {
      console.log('Build_flag_brakes()');

      var innerHTML = '';
      innerHTML += '<div class="small-12 medium-12 large-12 columns">';
      innerHTML += ' <div class="row">';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <p style="font-weight: 600;">Brake Tester</p>';
      innerHTML += '       <span>Axle 1 Brake Result:</span>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <p style="font-weight: 600;">Brake Force</p>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-1 medium-1 large-1 columns" style="padding-right: 0px;">';
      innerHTML += '       <p style="font-weight: 600;">Brake Sum (%)</p>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-1 medium-1 large-1 columns" style="padding-right: 0px;">';
      innerHTML += '       <p style="font-weight: 600;">Brake Diff (%)</p>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <p style="font-weight: 600; margin-bottom: 0px;">Limits</p>';
      innerHTML += '       <p style="font-weight: 600; margin-bottom: 0px; font-size: x-small;">Brake force difference</p>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-1 medium-1 large-1 columns">';
      innerHTML += '       <p style="font-weight: 600;">Result</p>';
      innerHTML += '    </div>';
      innerHTML += ' </div>';

      innerHTML += ' <div class="row">';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <label for="axle_1_total_weight" class="left inline">Total Weight (Kg):</label>';
      innerHTML += '       <input type="number" id="axle_1_total_weight" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 1800 kg" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-5 medium-5 large-5 columns">';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-4 medium-4 large-4 columns">';
      innerHTML += '       <p style="margin-bottom: 0px; font-size: x-small">Service brake &#62; 25% </p>';
      innerHTML += '       <p style="margin-bottom: 0px; font-size: x-small">defective</p>';
      innerHTML += '    </div>';
      innerHTML += ' </div>';

      innerHTML += ' <div class="row">';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <label style="font-weight: 600; margin-top: 20px;">';
      innerHTML += '          <input type="checkbox" class="item_field" id_var_mapping="0" id="axle_1_service_brake" value="1" style="margin-bottom: 5px;" checked onclick="Checkbox_value_change(this)"> Service Brake';
      innerHTML += '       </label>';
      innerHTML += '    </div>';

      innerHTML += '    <div class="small-3 medium-3 large-3 columns">'; 
      innerHTML += '       <div class="row">';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="axle_1_brake_force_left" class="left inline">Left:</label>';
      innerHTML += '             <input type="number" id="axle_1_service_brake_force_left" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 6.04 kN" onkeydown="Axle_1_service_brake_force_cal();"/>';
      innerHTML += '          </div>';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="axle_1_brake_force_right" class="left inline">Right:</label>';
      innerHTML += '             <input type="number" id="axle_1_service_brake_force_right" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 5.15 kN" onkeydown="Axle_1_service_brake_force_cal();"/>';
      innerHTML += '          </div>';
      innerHTML += '       </div>';
      innerHTML += '    </div>';

      innerHTML += '    <div class="small-1 medium-1 large-1 columns" style="padding-right: 0px;">';
      innerHTML += '       <label for="axle_1_service_brake_force_sum" class="left inline" style="text-align: center;">---</label>';
      innerHTML += '       <input type="number" id="axle_1_service_brake_force_sum" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="0.00" readonly/>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-1 medium-1 large-1 columns" style="padding-right: 0px;">';
      innerHTML += '       <label for="axle_1_service_brake_force_diff" class="left inline" style="text-align: center;">---</label>';
      innerHTML += '       <input type="number" id="axle_1_service_brake_force_diff" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="0.00" readonly/>';
      innerHTML += '    </div>';

      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '    </div>';

      innerHTML += '    <div class="small-1 medium-1 large-1 columns" style="padding-right: 0;">';
      innerHTML += '       <select id="axle_1_service_brake_result" class="item_field" id_var_mapping="0" style="margin-bottom: 0px; margin-top: 15px;">';
      innerHTML += '          <option value="Pass">Pass</option>';
      innerHTML += '          <option value="Fail">Fail</option>';
      innerHTML += '       </select>';
      innerHTML += '    </div>';
      innerHTML += ' </div>';

      innerHTML += ' <div class="row" style="border-top: 1px dashed #FF5722; margin-top: 15px;">';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <span>Axle 2 Brake Result:</span>';
      innerHTML += '       <label for="axle_2_total_weight" class="left inline">Total Weight (Kg):</label>';
      innerHTML += '       <input type="number" id="axle_2_total_weight" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 1800 kg" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '    </div>';
      innerHTML += ' </div>';

      innerHTML += ' <div class="row">';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <label style="font-weight: 600; margin-top: 20px;">';
      innerHTML += '          <input type="checkbox" class="item_field" id_var_mapping="0" id="axle_2_parking_brake" value="1" style="margin-bottom: 5px;" checked onclick="Checkbox_value_change(this)"> Parking Brake';
      innerHTML += '       </label>';
      innerHTML += '    </div>';

      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <div class="row">';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="axle_2_parking_brake_force_left" class="left inline">Left:</label>';
      innerHTML += '             <input type="number" id="axle_2_parking_brake_force_left" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 6.04 kN" onkeydown="Axle_2_parking_brake_force_cal();"/>';
      innerHTML += '          </div>';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="axle_2_parking_brake_force_right" class="left inline">Right:</label>';
      innerHTML += '             <input type="number" id="axle_2_parking_brake_force_right" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 5.15 kN" onkeydown="Axle_2_parking_brake_force_cal();"/>';
      innerHTML += '          </div>';
      innerHTML += '       </div>';
      innerHTML += '    </div>';

      innerHTML += '    <div class="small-1 medium-1 large-1 columns" style="padding-right: 0px;">';
      innerHTML += '       <label for="axle_2_parking_brake_force_sum" class="left inline" style="text-align: center;">---</label>';
      innerHTML += '       <input type="number" id="axle_2_parking_brake_force_sum" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="0.00" readonly/>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-1 medium-1 large-1 columns" style="padding-right: 0px;">';
      innerHTML += '       <label for="axle_2_parking_brake_force_diff" class="left inline" style="text-align: center;">---</label>';
      innerHTML += '       <input type="number" id="axle_2_parking_brake_force_diff" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="0.00" readonly/>';
      innerHTML += '    </div>';

      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <p style="margin-bottom: 0px; font-size: x-small; font-weight: 600">Declaration</p>';
      innerHTML += '       <p style="margin-bottom: 0px; font-size: x-small">Parking brake &#62; 25% </p>';
      innerHTML += '       <p style="margin-bottom: 0px; font-size: x-small">defective</p>';
      innerHTML += '    </div>';

      innerHTML += '    <div class="small-1 medium-1 large-1 columns" style="padding-right: 0;">';
      innerHTML += '       <select id="axle_2_parking_brake_result" class="item_field" id_var_mapping="0" style="margin-bottom: 0px; margin-top: 15px;">';
      innerHTML += '          <option value="Pass">Pass</option>';
      innerHTML += '          <option value="Fail">Fail</option>';
      innerHTML += '       </select>';
      innerHTML += '    </div>';
      innerHTML += ' </div>';

      innerHTML += ' <div class="row">';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <label style="font-weight: 600; margin-top: 20px;">';
      innerHTML += '          <input type="checkbox" class="item_field" id_var_mapping="0" id="axle_2_service_brake" value="1" style="margin-bottom: 5px;" checked onclick="Checkbox_value_change(this)"> Service Brake';
      innerHTML += '       </label>';
      innerHTML += '    </div>';

      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <div class="row">';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="axle_2_service_force_left" class="left inline">Left:</label>';
      innerHTML += '             <input type="number" id="axle_2_service_brake_force_left" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 6.04 kN" onkeydown="Axle_2_service_brake_force_cal();"/>';
      innerHTML += '          </div>';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="axle_2_service_force_right" class="left inline">Right:</label>';
      innerHTML += '             <input type="number" id="axle_2_service_brake_force_right" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 5.15 kN" onkeydown="Axle_2_service_brake_force_cal();"/>';
      innerHTML += '          </div>';
      innerHTML += '       </div>';
      innerHTML += '    </div>';

      innerHTML += '    <div class="small-1 medium-1 large-1 columns" style="padding-right: 0px;">';
      innerHTML += '       <label for="axle_2_service_brake_force_sum" class="left inline" style="text-align: center;">---</label>';
      innerHTML += '       <input type="number" id="axle_2_service_brake_force_sum" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 0.00" readonly/>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-1 medium-1 large-1 columns" style="padding-right: 0px;">';
      innerHTML += '       <label for="axle_2_service_brake_force_diff" class="left inline" style="text-align: center;">---</label>';
      innerHTML += '       <input type="number" id="axle_2_service_brake_force_diff" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="0.00" readonly/>';
      innerHTML += '    </div>';

      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <p style="margin-bottom: 0px; font-size: x-small">Service brake &#62; 25% </p>';
      innerHTML += '       <p style="margin-bottom: 0px; font-size: x-small">defective</p>';
      innerHTML += '    </div>';

      innerHTML += '    <div class="small-1 medium-1 large-1 columns" style="padding-right: 0;">';
      innerHTML += '       <select id="axle_2_service_brake_result" class="item_field" id_var_mapping="0" style="margin-bottom: 0px; margin-top: 15px;">';
      innerHTML += '          <option value="Pass">Pass</option>';
      innerHTML += '          <option value="Fail">Fail</option>';
      innerHTML += '       </select>';
      innerHTML += '    </div>';
      innerHTML += ' </div>';

      innerHTML += '</div>';
      //
      flag_brakes_items_fieldset.innerHTML = innerHTML;
      //
      //Build Item_Fieldsfrom Var_Mapping
      if (var_test_id !== 0) Item_Fields_Var_Mapping_Load(var_test_id);
   } // end Build_flag_brakes();

   function Build_flag_suspension_side_slip(var_test_id = 0) {
      console.log('Build_flag_suspension_side_slip()');

      var innerHTML = '';
      innerHTML += '<div class="small-12 medium-12 large-12 columns">';
      //Axel 1
      innerHTML += ' <div class="row" style="margin-bottom: 10px;">';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <p style="font-weight: 600;">Shock Absorber</p>';
      innerHTML += '       <label style="font-weight: 600;">Axle 1:</label>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <p style="text-decoration: underline;">Result(%):</p>';
      innerHTML += '       <div class="row">';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="axle_1_suspension_damping_left" class="left inline">Left:</label>';
      innerHTML += '             <input type="text" id="axle_1_suspension_damping_left" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 10 %" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="axle_1_suspension_damping_right" class="left inline">Right:</label>';
      innerHTML += '             <input type="text" id="axle_1_suspension_damping_right" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 10 %" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '       </div>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <p> --- : --- </p>';
      innerHTML += '       <label for="axle_1_suspension_diff" class="left inline">Difference:</label>';
      innerHTML += '       <input type="text" id="axle_1_suspension_diff" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 10 %" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <p style="text-decoration: underline;">Amplitude(mm):</p>';
      innerHTML += '       <div class="row">';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="axle_1_suspension_amplitude_left" class="left inline">Left:</label>';
      innerHTML += '             <input type="text" id="axle_1_suspension_amplitude_left" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 10mm" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="axle_1_suspension_amplitude_right" class="left inline">Right:</label>';
      innerHTML += '             <input type="text" id="axle_1_suspension_amplitude_right" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 10mm" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '       </div>';
      innerHTML += '    </div>';
      innerHTML += ' </div>';

      //Axel 2
      innerHTML += ' <div class="row" style="margin-bottom: 10px;">';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <label style="font-weight: 600;">Axle 2:</label>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <div class="row">';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="axle_2_suspension_damping_left" class="left inline">Left:</label>';
      innerHTML += '             <input type="text" id="axle_2_suspension_damping_left" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 10 %" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="axle_2_suspension_damping_right" class="left inline">Right:</label>';
      innerHTML += '             <input type="text" id="axle_2_suspension_damping_right" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 10 %" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '       </div>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <label for="axle_2_suspension_diff" class="left inline">Difference:</label>';
      innerHTML += '       <input type="text" id="axle_2_suspension_diff" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 10 %" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <div class="row">';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="axle_2_suspension_amplitude_left" class="left inline">Left:</label>';
      innerHTML += '             <input type="text" id="axle_2_suspension_amplitude_left" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 10mm" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="axle_2_suspension_amplitude_right" class="left inline">Right:</label>';
      innerHTML += '             <input type="text" id="axle_2_suspension_amplitude_right" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 10mm" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '       </div>';
      innerHTML += '    </div>';
      innerHTML += ' </div>';

      innerHTML += '</div>';

      innerHTML += '<div class="small-12 medium-12 large-12 columns" style="margin-top: 20px; border-top: 1px dashed #c60f13;">';
      innerHTML += ' <div class="row" style="margin-bottom: 10px;">';
      innerHTML += '    <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '       <p style="font-weight: 600;">Side Slip</p>';
      innerHTML += '       <label style="font-weight: 600;">Axle 1:</label>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '       <p style="text-decoration: underline;">Result:</p>';
      innerHTML += '       <input type="text" id="axle_1_side_slip" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 100 mm/m" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '    </div>';
      innerHTML += ' </div>';

      innerHTML += ' <div class="row"  style="margin-bottom: 10px;">';
      innerHTML += '    <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '       <label style="font-weight: 600;">Axle 2:</label>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '       <input type="text" id="axle_2_side_slip" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 120 mm/m" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '    </div>';
      innerHTML += ' </div>';
      innerHTML += '</div>';
      //
      flag_suspension_side_slip_items_fieldset.innerHTML = innerHTML;
      //
      //Build Item_Fieldsfrom Var_Mapping
      if (var_test_id !== 0) Item_Fields_Var_Mapping_Load(var_test_id);
   } // end Build_flag_suspension_side_slip();

   function Build_flag_headlight(var_test_id = 0) {
      console.log('Build_flag_headlight()');

      var innerHTML = '';
      innerHTML += '<div class="small-12 medium-12 large-12 columns">';
      //Headlight Intencity
      innerHTML += ' <div class="row" style="margin-bottom: 10px;">';
      innerHTML += '    <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '       <p style="font-weight: 600; margin-bottom: 0px;">Headlight Tester</p>';
      innerHTML += '       <label style="font-weight: 600;">Intencity:</label>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <div class="row">';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <p style="text-decoration: underline; margin-bottom: 0px;">Left:</p>';
      innerHTML += '             <input type="text" id="headlight_intencity_left" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 8" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <p style="text-decoration: underline; margin-bottom: 0px;">Result:</p>';
      innerHTML += '             <input type="text" id="headlight_intencity_result_left" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" readonly placeholder="eg. Not Good"/>';
      innerHTML += '          </div>';
      innerHTML += '       </div>';
      innerHTML += '    </div>';

      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <div class="row">';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <p style="text-decoration: underline; margin-bottom: 0px;">Right:</p>';
      innerHTML += '             <input type="text" id="headlight_intencity_right" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 2" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <p style="text-decoration: underline; margin-bottom: 0px;">Result:</p>';
      innerHTML += '             <input type="text" id="headlight_intencity_result_right" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" readonly placeholder="eg. Good"/>';
      innerHTML += '          </div>';
      innerHTML += '       </div>';
      innerHTML += '    </div>';
      innerHTML += ' </div>';
      
      //Low Beam Intencity
      innerHTML += ' <div class="row" style="margin-bottom: 10px;">';
      innerHTML += '    <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '       <p style="font-weight: 600; margin-bottom: 0px;">Low Beam</p>';
      innerHTML += '       <label style="font-weight: 600;">Intencity:</label>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns" style="margin-top: 20px;">';
      innerHTML += '       <div class="row">';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <input type="text" id="low_beam_intencity_left" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 9" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <input type="text" id="low_beam_intencity_result_left" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" readonly placeholder="eg. Not Good"/>';
      innerHTML += '          </div>';
      innerHTML += '       </div>';
      innerHTML += '    </div>';

      innerHTML += '    <div class="small-3 medium-3 large-3 columns" style="margin-top: 20px;">';
      innerHTML += '       <div class="row">';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <input type="text" id="low_beam_intencity_right" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 1" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <input type="text" id="low_beam_intencity_result_right" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" readonly placeholder="eg. Good"/>';
      innerHTML += '          </div>';
      innerHTML += '       </div>';
      innerHTML += '    </div>';
      innerHTML += ' </div>';

      //Fog Beam Intencity
      innerHTML += ' <div class="row" style="margin-bottom: 10px;">';
      innerHTML += '    <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '       <p style="font-weight: 600; margin-bottom: 0px;">Fog Beam</p>';
      innerHTML += '       <label style="font-weight: 600;">Intencity:</label>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns" style="margin-top: 20px;">';
      innerHTML += '       <div class="row">';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <input type="text" id="fog_beam_intencity_left" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 7" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <input type="text" id="fog_beam_intencity_result_left" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" readonly placeholder="eg. Not Good"/>';
      innerHTML += '          </div>';
      innerHTML += '       </div>';
      innerHTML += '    </div>';

      innerHTML += '    <div class="small-3 medium-3 large-3 columns" style="margin-top: 20px;">';
      innerHTML += '       <div class="row">';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <input type="text" id="fog_beam_intencity_right" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 3" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <input type="text" id="fog_beam_intencity_result_right" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" readonly placeholder="eg. Good"/>';
      innerHTML += '          </div>';
      innerHTML += '       </div>';
      innerHTML += '    </div>';
      innerHTML += ' </div>';

      innerHTML += '</div>';
      //
      flag_headlight_items_fieldset.innerHTML = innerHTML;
      //
      //Build Item_Fieldsfrom Var_Mapping
      if (var_test_id !== 0) Item_Fields_Var_Mapping_Load(var_test_id);
   } // end Build_flag_headlight();

   function Build_flag_alignment(var_test_id = 0) {
      console.log('Build_flag_alignment()');

      var innerHTML = '';
      innerHTML += '<div class="small-12 medium-12 large-12 columns">';
      //Front Camber
      innerHTML += ' <div class="row" style="margin-bottom: 10px;">';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <p style="font-weight: 600;">Alignment</p>';
      innerHTML += '       <label style="font-weight: 600; margin-top: 40px;">Camber:</label>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-5 medium-5 large-5 columns">';
      innerHTML += '       <p style="text-decoration: underline;">-- Front --:</p>';
      innerHTML += '       <div class="row">';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="camber_front_left" class="left inline">Left:</label>';
      innerHTML += '             <input type="text" id="camber_front_left" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 0.01°" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="camber_front_right" class="left inline">Right:</label>';
      innerHTML += '             <input type="text" id="camber_front_right" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 0.31°" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '       </div>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-4 medium-4 large-4 columns">';
      innerHTML += '    </div>';
      innerHTML += ' </div>';

      //Front caster
      innerHTML += ' <div class="row" style="margin-bottom: 10px;">';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <label style="font-weight: 600; margin-top: 25px;">Caster:</label>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-5 medium-5 large-5 columns">';
      innerHTML += '       <div class="row">';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="caster_front_left" class="left inline">Left:</label>';
      innerHTML += '             <input type="text" id="caster_front_left" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 0.01°" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="caster_front_right" class="left inline">Right:</label>';
      innerHTML += '             <input type="text" id="caster_front_right" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 0.31°" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '       </div>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-4 medium-4 large-4 columns">';
      innerHTML += '    </div>';
      innerHTML += ' </div>';

      //Front Toe
      innerHTML += ' <div class="row" style="margin-bottom: 10px;">';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <label style="font-weight: 600; margin-top: 25px;">Toe:</label>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-5 medium-5 large-5 columns">';
      innerHTML += '       <div class="row">';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="toe_front_left" class="left inline">Left:</label>';
      innerHTML += '             <input type="text" id="toe_front_left" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 0.01°" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="toe_front_right" class="left inline">Right:</label>';
      innerHTML += '             <input type="text" id="toe_front_right" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 0.31°" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '       </div>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-2 medium-2 large-2 columns">';
      innerHTML += '       <label for="front_total_toe" class="left inline">Total Toe:</label>';
      innerHTML += '       <input type="text" id="front_total_toe" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 0.31°" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-2 medium-2 large-2 columns">';
      innerHTML += '       <label for="front_steer_ahead" class="left inline">Steer Ahead:</label>';
      innerHTML += '       <input type="text" id="front_steer_ahead" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 0.31°" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '    </div>';
      innerHTML += ' </div>';
      //--------------------------//
      //Rear Camber
      innerHTML += ' <div class="row" style="margin-bottom: 10px; border-top: 1px dashed #c60f13;">';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <label style="font-weight: 600; margin-top: 65px;">Camber:</label>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-5 medium-5 large-5 columns">';
      innerHTML += '       <p style="text-decoration: underline;">-- Rear --:</p>';
      innerHTML += '       <div class="row">';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="camber_rear_left" class="left inline">Left:</label>';
      innerHTML += '             <input type="text" id="camber_rear_left" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 0.01°" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="camber_rear_right" class="left inline">Right:</label>';
      innerHTML += '             <input type="text" id="camber_rear_right" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 0.31°" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '       </div>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-4 medium-4 large-4 columns">';
      innerHTML += '    </div>';
      innerHTML += ' </div>';

      //Rear caster
      innerHTML += ' <div class="row" style="margin-bottom: 10px;">';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <label style="font-weight: 600; margin-top: 25px;">Caster:</label>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-5 medium-5 large-5 columns">';
      innerHTML += '       <div class="row">';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="caster_rear_left" class="left inline">Left:</label>';
      innerHTML += '             <input type="text" id="caster_rear_left" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 0.01°" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="caster_rear_right" class="left inline">Right:</label>';
      innerHTML += '             <input type="text" id="caster_rear_right" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 0.31°" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '       </div>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-4 medium-4 large-4 columns">';
      innerHTML += '    </div>';
      innerHTML += ' </div>';

      //Rear Toe
      innerHTML += ' <div class="row" style="margin-bottom: 10px;">';
      innerHTML += '    <div class="small-3 medium-3 large-3 columns">';
      innerHTML += '       <label style="font-weight: 600; margin-top: 25px;">Toe:</label>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-5 medium-5 large-5 columns">';
      innerHTML += '       <div class="row">';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="toe_rear_left" class="left inline">Left:</label>';
      innerHTML += '             <input type="text" id="toe_rear_left" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 0.01°" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '          <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '             <label for="toe_rear_right" class="left inline">Right:</label>';
      innerHTML += '             <input type="text" id="toe_rear_right" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 0.31°" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '          </div>';
      innerHTML += '       </div>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-2 medium-2 large-2 columns">';
      innerHTML += '       <label for="rear_total_toe" class="left inline">Total Toe:</label>';
      innerHTML += '       <input type="text" id="rear_total_toe" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 0.31°" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '    </div>';
      innerHTML += '    <div class="small-2 medium-2 large-2 columns">';
      innerHTML += '       <label for="rear_thrust_angle" class="left inline">Thrust Angle:</label>';
      innerHTML += '       <input type="text" id="rear_thrust_angle" class="item_field" id_var_mapping="0" style="margin-bottom: 0px;" placeholder="eg. 0.31°" onkeypress="return onlyNumberKey(event)"/>';
      innerHTML += '    </div>';
      innerHTML += ' </div>';
   
      innerHTML += '</div>';
      //
      flag_alignment_items_fieldset.innerHTML = innerHTML;
      //
      //Build Item_Fieldsfrom Var_Mapping
      if (var_test_id !== 0) Item_Fields_Var_Mapping_Load(var_test_id);
   } // end Build_flag_alignment();

   function Build_flag_vulcanize(var_test_id = 0) {
      console.log('Build_flag_vulcanize()');

      var innerHTML = '';
      innerHTML += '<div class="small-12 medium-12 large-12 columns">';
      //
      innerHTML += ' <div class="row" style="margin-bottom: 10px;">';
      innerHTML += '    <div class="small-12 medium-12 large-12 columns">';
      innerHTML += '       <p style="font-weight: 600;">Vulcanize (Tires Checks & Repairs)</p>';
      innerHTML += '    </div>';

      innerHTML += '    <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '       <label for="vulcanize_front_left" class="left inline">-- Front Left --:</label>';
      innerHTML += '       <select id="vulcanize_front_left" name="vulcanize_front_left" class="item_field" id_var_mapping="0">';
      innerHTML += '          <option value="Unchecked">Unchecked</option>';
      innerHTML += '          <option value="Checked">Checked</option> ';
      innerHTML += '          <option value="Pumped">Pumped</option> ';
      innerHTML += '          <option value="Repaired">Repaired</option> ';
      innerHTML += '          <option value="Replaced with NEW tire">Replaced with NEW tire</option> ';
      innerHTML += '          <option value="Replaced with USED tire">Replaced with USED tire</option> ';
      innerHTML += '       </select>';
      innerHTML += '    </div>';

      innerHTML += '    <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '       <label for="vulcanize_front_right" class="left inline">-- Front Right --:</label>';
      innerHTML += '       <select id="vulcanize_front_right" name="vulcanize_front_right" class="item_field" id_var_mapping="0">';
      innerHTML += '          <option value="Unchecked">Unchecked</option>';
      innerHTML += '          <option value="Checked">Checked</option> ';
      innerHTML += '          <option value="Pumped">Pumped</option> ';
      innerHTML += '          <option value="Repaired">Repaired</option> ';
      innerHTML += '          <option value="Replaced with NEW tire">Replaced with NEW tire</option> ';
      innerHTML += '          <option value="Replaced with USED tire">Replaced with USED tire</option> ';
      innerHTML += '       </select>';
      innerHTML += '    </div>';

      innerHTML += '    <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '       <label for="vulcanize_back_left" class="left inline">-- Back Left --:</label>';
      innerHTML += '       <select id="vulcanize_back_left" name="vulcanize_back_left" class="item_field" id_var_mapping="0">';
      innerHTML += '          <option value="Unchecked">Unchecked</option>';
      innerHTML += '          <option value="Checked">Checked</option> ';
      innerHTML += '          <option value="Pumped">Pumped</option> ';
      innerHTML += '          <option value="Repaired">Repaired</option> ';
      innerHTML += '          <option value="Replaced with NEW tire">Replaced with NEW tire</option> ';
      innerHTML += '          <option value="Replaced with USED tire">Replaced with USED tire</option> ';
      innerHTML += '       </select>';
      innerHTML += '    </div>';

      innerHTML += '    <div class="small-6 medium-6 large-6 columns">';
      innerHTML += '       <label for="vulcanize_back_right" class="left inline">-- Back Right --:</label>';
      innerHTML += '       <select id="vulcanize_back_right" name="vulcanize_back_right" class="item_field" id_var_mapping="0">';
      innerHTML += '          <option value="Unchecked">Unchecked</option>';
      innerHTML += '          <option value="Checked">Checked</option> ';
      innerHTML += '          <option value="Pumped">Pumped</option> ';
      innerHTML += '          <option value="Repaired">Repaired</option> ';
      innerHTML += '          <option value="Replaced with NEW tire">Replaced with NEW tire</option> ';
      innerHTML += '          <option value="Replaced with USED tire">Replaced with USED tire</option> ';
      innerHTML += '       </select>';
      innerHTML += '    </div>';
      innerHTML += ' </div>';

      innerHTML += '</div>';
      //
      flag_vulcanize_items_fieldset.innerHTML = innerHTML;
      //
      //Build Item_Fieldsfrom Var_Mapping
      if (var_test_id !== 0) Item_Fields_Var_Mapping_Load(var_test_id);
   } // end Build_flag_vulcanize();

   function encodeImageFileAsURL() {
     console.log('encodeImageFileAsURL()');

     var fileTypes = ['jpg', 'jpeg', 'png', 'gif'];  //acceptable file types
     var filesSelected = document.getElementById("inputFileToLoad").files;
     var isSizeSuccess = false;

     if (filesSelected.length > 0) {

         var fileToLoad = filesSelected[0];

         var extension = fileToLoad.name.split('.').pop().toLowerCase(),  //file extension from input file
         isExtensionSuccess = fileTypes.indexOf(extension) > -1;  //is extension in acceptable types
         //isSizeSuccess = fileTypes.size <= 500000;  //is size in acceptable types

         if (fileTypes.size < 500001) {
             isSizeSuccess = true;
         } else {
             isSizeSuccess = false;
             alert(fileToLoad.size + ' :: ' + isSizeSuccess);
         }  

         if (isExtensionSuccess) { //Extension OK
             if (isExtensionSuccess == true) { //Size OK

                 var fileReader = new FileReader();
                 fileReader.onload = function(fileLoadedEvent) {
                     var srcData = fileLoadedEvent.target.result; // <--- data: base64

                     var img_photo = document.getElementById("img_photo");
                     img_photo.src = srcData;
                     //alert("Converted Base64 version is " + img_photo.src);
                     //console.log("Converted Base64 version is " + img_photo.src);
                 }
                 fileReader.readAsDataURL(fileToLoad);

             } else { //Size NOT OK
                 //warning
                 alert('Sorry, your file is too large.  (Max: 50kb)');
             }

         } else {//Extension NOT OK
             //warning
             //alert('Sorry, your file is too large.  (Max: 50kb)');
             alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');

         }
     }
   }

   function Close_Vehicle_Tests_Reveal() {
     console.log('Close_Vehicle_Tests_Reveal()');

     $('#reveal_vehicle_tests_edit').foundation('close');
   } //end Close_Vehicle_Tests_Reveal();

   function Open_Vehicle_Tests_Reveal (var_test_id = 0) {
      console.log('Open_Vehicle_Tests_Reveal('+var_test_id+')');

      test_id_hidden.value = var_test_id;

      $('#reveal_vehicle_tests_edit').foundation('open');

      return;
   } //end Open_Vehicle_Tests_Reveal();

   function Filter_Reload() {
     REST_Vehicle_Tests_list(0, 0, myTable_limit.value);
   }

   function PageNav(show_num_pages, query_total, query_offset, query_limit) {  
     //alert(query_total + " " + query_offset + " " + query_limit);
     var div_pagenav = document.getElementById("pagenav");
     var div_pagenav_info = document.getElementById("pagenav_info");

     var innerHTML = '<p style="color: #2ba6cb;"><strong>Total Records:</strong> '+query_total+' entries</p>';
     div_pagenav_info.innerHTML=innerHTML; 

     if (div_pagenav == null) return;

     // Hilfsberechnungen
     var show_num_pages_half = Math.floor(show_num_pages / 2); // Hilfsberechnung für halbe Seitenzahlenanzeige
     var num_pages = Math.ceil(query_total / query_limit); // Anzahl aktueller Seiten
     var current_page = Math.floor(query_offset / query_limit); // aktuelle Seiten-Nr.  
     //
     // Vorherigen Content entfernen
     div_pagenav.innerHTML = '';

     var div_row_pagenav = document.createElement('div');    
     div_row_pagenav.className = 'row';
      
     var div_col_pagenav = document.createElement('div');
     div_col_pagenav.className = 'small-12 medium-12 large-12 columns';

     var li = null;
     var ul_pagenav = document.createElement('ul');
     ul_pagenav.className = 'pagination text-center';

     div_col_pagenav.appendChild(ul_pagenav);
     div_row_pagenav.appendChild(div_col_pagenav);
     div_pagenav.appendChild(div_row_pagenav);

     // Pfeil nach links anzeigen, wenn Datensatz > 1
     if (current_page > 0) {
      li = document.createElement('li');
      li.className = 'arrow';
      li.innerHTML = '<a class="class_spinner_id" onclick="REST_Vehicle_Tests_list(' + query_total + ', ' + ((current_page - 1) * query_limit) + ', ' + query_limit + ');">&laquo;</a>';
      ul_pagenav.appendChild(li);
     }

     // Seitenanzeige aufbauen
     if (show_num_pages < num_pages) { // mehr Seiten als "Anzahl-Seiten" vorhanden
         if (current_page > show_num_pages_half) {
             // Seite 1 ...
             li = document.createElement('li');
             li.className = 'arrow';
             li.innerHTML = '<a class="class_spinner_id" onclick="REST_Vehicle_Tests_list(' + query_total + ', ' + (0 * query_limit) + ', ' + query_limit + ');">1</a>';
             ul_pagenav.appendChild(li);

             li = document.createElement('li');
             li.className = 'unavailable';
             li.innerHTML = '<a>&hellip;</a>';
             ul_pagenav.appendChild(li);
         } // end if (current_page > show_num_pages_half);
      
      
         if (current_page <= show_num_pages_half) { // Seite 1..7
          for (i = 0; i < show_num_pages; i++) {
              li = document.createElement('li');
              if (i == current_page) {
                  li.className = 'current';
              } else {
                  li.className = '';
              }
              li.innerHTML = '<a class="class_spinner_id" onclick="REST_Vehicle_Tests_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
              ul_pagenav.appendChild(li);
          } // end for (i);
          
         } else if (current_page >= ((num_pages - 1) - show_num_pages_half)) { // Seite (n-1) - 7 bis (n-1)
          for (i = (num_pages - show_num_pages); i < num_pages; i++) {
              li = document.createElement('li');
              if (i == current_page) {
                  li.className = 'current';
              } else {
                  li.className = '';
              }
              li.innerHTML = '<a class="class_spinner_id" onclick="REST_Vehicle_Tests_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
              ul_pagenav.appendChild(li);
          } // end for (i);
          
         } else { // zwischen min und max Seiten
              
          for (i = (current_page - show_num_pages_half); i <= (current_page + show_num_pages_half); i++) {
              li = document.createElement('li');
              if (i == current_page) {
                  li.className = 'current';
              } else {
                  li.className = '';
              }
              li.innerHTML = '<a class="class_spinner_id" onclick="REST_Vehicle_Tests_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
              ul_pagenav.appendChild(li);
          } // end for (i);   
         }

         if (current_page < ((num_pages - 1) - show_num_pages_half) ) {
          // ... Seite n-1
          li = document.createElement('li');
          li.className = 'unavailable';
          li.innerHTML = '<a>&hellip;</a>';
          ul_pagenav.appendChild(li);             
          
          li = document.createElement('li');
          li.className = 'arrow';
          li.innerHTML = '<a class="class_spinner_id" onclick="REST_Vehicle_Tests_list(' + query_total + ', ' + ((num_pages - 1) * query_limit) + ', ' + query_limit + ');">' + num_pages + '</a>';         
          ul_pagenav.appendChild(li);

         } // end if (current_page < (num_pages - show_num_pages_half) );

         } else { // weniger als 7 Seiten

         for (i = 0; i < num_pages; i++) {
          li = document.createElement('li');
          if (i == current_page) {
              li.className = 'current';
          } else {
              li.className = '';
          }
          li.innerHTML = '<a class="class_spinner_id" onclick="REST_Vehicle_Tests_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
          ul_pagenav.appendChild(li);
         } // end for (i);
         } // end if (show_num_pages > num_pages);

         if (current_page < (num_pages - 1)) {
         li = document.createElement('li');
         li.className = 'arrow';
         li.innerHTML = '<a class="class_spinner_id" onclick="REST_Vehicle_Tests_list(' + query_total + ', ' + ((current_page + 1) * query_limit) + ', ' + query_limit + ');">' + '&raquo;' + '</a>';      
         ul_pagenav.appendChild(li);     
     } // end if (current_page > 0)

     return;
   } // end PageNav();

   function Vehicle_Tests_Export(val_format = "pdf") {
      console.log('Vehicle_Tests_Export(' + val_format + ')');

      var var_option_filter = $("input[type='radio'][name='radio_option_filter']:checked").val();
      //
      var zFilter_Param = '&test_id=' + text_test_id_filter.value + '&id_customer=' + select_id_customer_filter.value + '&vehicle=' + text_vehicle_filter.value;
      zFilter_Param += '&status=' + select_status_filter.value + '&plate=' + text_plate_filter.value;

      if (select_id_shop_system_filter.value != '0') {
         zFilter_Param += '&id_shop_system[0]=' + select_id_shop_system_filter.value;
      } else {
         zFilter_Param += '&' +arr_id_shop_system;
      }
      //
      var href = '#';
      //
      switch (val_format) {
         case "pdf":
            href = "/reports/vehicle_test_overview_pdf.php?option_filter=" + var_option_filter + zFilter_Param;
            break;
         case "xls":
            //href = "<?php echo "/dashboard/sendungsdaten_export_csv_xls.php?zoom"; ?>".replace("zoom", "output=xls&order_info_check=" + order_info_check.value + "&option_filter=" + var_option_filter + "&id_benutzer=" + m_SHOPSYS_id_benutzer.value + "&id_sprache=" + g_id_sprache + post_parameters);
            break;
      }
      console.log(href);
      //
      window.open(href, "_blank");
      return;
   } //Vehicle_Tests_Export();

   function Print_Test_Result(var_test_id) {
      console.log('Print_Test_Result('+var_test_id+')');

      if ((var_test_id == 0) || (var_test_id == '')) return;
      //
      var zFilter_Param = '&test_id=' + var_test_id;
      //
      var href = "/reports/vehicle_test_results_pdf.php?test=test" + zFilter_Param;
      //
      console.log(href);
      //
      window.open(href, "_blank");
      return;
   }//end Print_Test_Result()_;

   function REST_Vehicle_Tests_list(query_total, query_offset, query_limit) {
      console.log('REST_Vehicle_Tests_list()');

      //Keep query_offset and query_limit for refresh
      myTable_offset.value = query_offset;
      myTable_limit.value = query_limit;

      //Prepare Table Filter
      var zFilter_Param = '&test_id=' + text_test_id_filter.value + '&id_customer=' + select_id_customer_filter.value + '&vehicle=' + text_vehicle_filter.value;
      zFilter_Param += '&status=' + select_status_filter.value + '&plate=' + text_plate_filter.value;

      if (select_id_shop_system_filter.value != '0') {
         zFilter_Param += '&id_shop_system[0]=' + select_id_shop_system_filter.value;
      } else {
         zFilter_Param += '&' +arr_id_shop_system;
      }
      
      //

      var tbody_Overview = document.getElementById("tbody_Overview");

      //SpinnerStart(false);

      var xmlhttp;
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
         xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
         xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange = function() {
         if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            // var str = xmlhttp.responseText;
            // alert(str);
            // alert(xmlhttp.responseXML);
            console.log(xmlhttp.responseXML);
            if (xmlhttp.responseXML == null) { console.log('No data found!'); return; }

            tbody_Overview.innerHTML = '';

            var i_bgcolor = 0;

            var node_query_count = xmlhttp.responseXML.getElementsByTagName("query_count");
            var node_query_offset = xmlhttp.responseXML.getElementsByTagName("query_offset");
            var node_query_limit = xmlhttp.responseXML.getElementsByTagName("query_limit");
            var xml_query_count = node_query_count[0].childNodes[0].nodeValue;
            var xml_query_offset = node_query_offset[0].childNodes[0].nodeValue;
            var xml_query_limit = node_query_limit[0].childNodes[0].nodeValue;

            PageNav(7, xml_query_count, xml_query_offset, xml_query_limit); // (show_num_pages, query_total, query_offset, query_limit)

            var nodeVehicle_Tests_List = xmlhttp.responseXML.getElementsByTagName("vehicle_tests_list");
            // alert(nodeVehicle_Tests_List[0].childNodes.length);
            for (var i = 0; i < nodeVehicle_Tests_List[0].childNodes.length; i++) {
               // alert("NodeName: " + nodeVehicle_Tests_List[0].childNodes[i].nodeName + " | NodeType:" + nodeVehicle_Tests_List[0].childNodes[i].nodeType); 
               if (nodeVehicle_Tests_List[0].childNodes[i].nodeType == 1) {
                  var nodeVehicle_Tests = nodeVehicle_Tests_List[0].childNodes[i];
                  // alert(nodeVehicle_Tests.childNodes.length);

                  var xml_test_id = 0;
                  var xml_plate = "";
                  var xml_vehicle = "";
                  var xml_id_customer = 0;
                  var xml_customer_company = "";
                  var xml_id_shop_system = 0;
                  var xml_shop_name = "";
                  var xml_date = 0;

                  var xml_id_users_created_by = 0;
                  var xml_test_result = "";
                  var xml_AxleAmount = "";
                  var xml_CubicCapacity = "";
                  var xml_ProductionYear = "";
                  var xml_FirstUse = "";
                  var xml_VehicleIdentificationNumber = "";
                  var xml_TotalWeight = "";
                  var xml_TotalMeasuredWeight = "";
                  var xml_LastInspection = 0;
                  var xml_ReceiptId = "";
                  var xml_TestPurpose = "";

                  var xml_Vehicle_Make = "";
                  var xml_Vehicle_Class = "";
                  var xml_Vehicle_Class_ID = 0;
                  var xml_Vehicle_Colour = "";
                  var xml_Vehicle_Model = "";
                  var xml_Vehicle_Purpose = "";
                  var xml_status = 0;

                  for (var j = 0; j < nodeVehicle_Tests.childNodes.length; j++) {
                     if (nodeVehicle_Tests.childNodes[j].nodeType == 1) {
                        // alert("NodeName: " + nodeVehicle_Tests.childNodes[j].nodeName + " | NodeType:" + nodeVehicle_Tests.childNodes[j].nodeType + " | NodeValue: " +  nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue); 

                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'test_id') xml_test_id = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'plate') xml_plate = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'vehicle') xml_vehicle = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'id_customer') xml_id_customer = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'customer_company') xml_customer_company = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'id_shop_system') xml_id_shop_system = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'shop_name') xml_shop_name = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'date') xml_date = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;

                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'id_users_created_by') xml_id_users_created_by = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'test_result') xml_test_result = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'AxleAmount') xml_AxleAmount = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'CubicCapacity') xml_CubicCapacity = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'ProductionYear') xml_ProductionYear = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'FirstUse') xml_FirstUse = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'VehicleIdentificationNumber') xml_VehicleIdentificationNumber = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'TotalWeight') xml_TotalWeight = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'TotalMeasuredWeight') xml_TotalMeasuredWeight = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'LastInspection') xml_LastInspection = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'ReceiptId') xml_ReceiptId = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'TestPurpose') xml_TestPurpose = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;

                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'Vehicle_Make') xml_Vehicle_Make = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'Vehicle_Class') xml_Vehicle_Class = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'Vehicle_Class_ID') xml_Vehicle_Class_ID = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'Vehicle_Colour') xml_Vehicle_Colour = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'Vehicle_Model') xml_Vehicle_Model = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'Vehicle_Purpose') xml_Vehicle_Purpose = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;

                        if (nodeVehicle_Tests.childNodes[j].nodeName === 'status') xml_status = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                     } // nodeType = ELEMENT_NODE
                  } // end for (j);
                  //alert (xml_id_shop_system + " :: " + xml_id_customer + " :: " + xml_shop_name + " :: " + xml_shop_code);
                  //
                  bgcolor_row = '';
                  if ((i_bgcolor % 2) == 0) {
                     bgcolor_row = '<?php echo $UTIL->table_bg_color_even(); ?>';
                  } else {
                     bgcolor_row = '<?php echo $UTIL->table_bg_color_odd(); ?>';
                  }

                  var tr = document.createElement('tr');
                  tbody_Overview.appendChild(tr);
                  var td = [];

                  //---------------------------------------------------------------------//

                  td[0] = document.createElement('td');
                  td[0].setAttribute('bgcolor', bgcolor_row);
                  td[0].setAttribute('valign', 'top');
                  td[0].setAttribute('data-label', 'Test ID:');

                  td[0].innerHTML = '';

                  td[0].innerHTML += '<div><span style="font-weight: 600; color: crimson;">' + xml_test_id + '</span></div>';

                  //---------------------------------------------------------------------//

                  td[1] = document.createElement('td');
                  td[1].setAttribute('bgcolor', bgcolor_row);
                  td[1].setAttribute('valign', 'top');
                  td[1].setAttribute('data-label', 'Vehicle');

                  td[1].innerHTML = '';
                  td[1].innerHTML += '<div style="color: #004465;"><strong>' + utf8Decode(xml_vehicle) + '</strong></div>';
                 
                  //---------------------------------------------------------------------//

                  td[2] = document.createElement('td');
                  td[2].setAttribute('bgcolor', bgcolor_row);
                  td[2].setAttribute('valign', 'top');
                  td[2].setAttribute('data-label', 'Plate');

                  td[2].innerHTML = '';
                  td[2].innerHTML += '<div><strong>' + utf8Decode(xml_plate) + '</strong></div>';
             
                  //---------------------------------------------------------------------//

                  td[3] = document.createElement('td');
                  td[3].setAttribute('bgcolor', bgcolor_row);
                  td[3].setAttribute('valign', 'top');
                  td[3].setAttribute('data-label', 'Customer');

                  td[3].innerHTML = '';
                  if (xml_customer_company == "") {
                     td[3].innerHTML += '<div><strong>' + xml_id_customer + '</strong></div>';
                  } else {
                     td[3].innerHTML += '<div><strong>' + xml_id_customer + '</strong> - ' + utf8Decode(xml_customer_company) + '</div>';
                  }

                  //---------------------------------------------------------------------//

                  td[4] = document.createElement('td');
                  td[4].setAttribute('bgcolor', bgcolor_row);
                  td[4].setAttribute('valign', 'top');
                  td[4].setAttribute('data-label', 'Date');

                  td[4].innerHTML = '';
                  td[4].innerHTML += '<div><strong>' + Timestamp_Format_UTC(xml_date).slice(0, -7) + '</strong></div>';

                  //---------------------------------------------------------------------//


                  td[5] = document.createElement('td');
                  td[5].setAttribute('bgcolor', bgcolor_row);
                  td[5].setAttribute('valign', 'top');
                  td[5].setAttribute('data-label', 'Status');

                  innerHTML = '';
                  innerHTML += '<div>';
                  if (xml_status == 1) {
                     innerHTML += '<strong style="color: green;">Completed</strong>';
                  } else if (xml_status == 2) {
                     innerHTML += '<strong style="color: #9E9E9E;">Archived</strong>';
                  } else {
                     innerHTML += '<strong style="color: #8a2be2;">In Progress</strong>';
                  }
                  innerHTML += '</div>';
                  td[5].innerHTML += innerHTML;
                  // td[5].innerHTML += '<p style="margin: 1px 0; color: #1779ba; text-align: center;"><span>' + ((xml_status == 1) ? '<?php echo $UTIL->IMG_Activated(15, 15); ?>' : '<?php echo $UTIL->IMG_Deactivated(15, 15); ?>') + '</span></p>';

                  //---------------------------------------------------------------------//

                  td[6] = document.createElement('td');
                  td[6].setAttribute('bgcolor', bgcolor_row);
                  td[6].setAttribute('valign', 'top');
                  td[6].setAttribute('data-label', '***');

                  innerHTML = '';
                  innerHTML += '<div>';
                  innerHTML += ' <a class="table-btn" onclick="Open_Vehicle_Tests_Reveal(' + xml_test_id + ')"><i class="fa fa-edit action-controls" title="Edit Record"></i></a>';
                  innerHTML += ' <a class="table-btn" style="border: 1px solid #ffae00; color: #ffae00;" onclick="REST_Vehicle_Tests_Delete (' + xml_test_id + ')"><i class="fa fa-trash action-controls" title="Delete Record"></i></a>';
                  innerHTML += ' <a class="table-btn" style="border: 1px solid red; color: red;" onclick="Print_Test_Result(' + xml_test_id + ')"><i class="fa fa-file-pdf action-controls" title="Print Result"></i></a>';
                  innerHTML += ' <a class="table-btn" onclick="Toggle_Detail(this, ' + xml_test_id + ');" ><i class="fas fa-chevron-down" title="Show Detail"></i></a>';
                  innerHTML += '</div>';
                  td[6].innerHTML = innerHTML;

                  //---------------------------------------------------------------------//   

                  var tr_labels = document.createElement('tr');
                  tbody_Overview.appendChild(tr_labels);
                  tr_labels.className = 'table-expand-row-content';
                  tr_labels.setAttribute('style', 'border: 2px solid #788A8F;');
                  tr_labels.id = 'label_content_' + xml_test_id;


                  var td_labels = document.createElement('td');
                  tr_labels.appendChild(td_labels);
                  tr_labels.setAttribute('style', 'padding: 0;');
                  td_labels.className = 'table-expand-row-nested';
                  td_labels.setAttribute('colspan', '10');

                  var innerHTML = '';
                  //---------------------------------------------------------------------//
                 
                 innerHTML += '<div class="row">';
                 innerHTML += '    <div class="small-12 medium-6 large-6 columns">';
                 innerHTML += '      <p style="margin-bottom: 5px; font-size: 0.875rem; font-weight: 600; color: #004465;">Shop:</p>';

                 innerHTML += '      <p style="padding-left: 10px; margin: 0;"><strong>' + xml_id_shop_system + '</strong> - ' + utf8Decode(xml_shop_name) + '</span></p>';

                 innerHTML += '    </div>';
                 innerHTML += '    <div class="small-12 medium-6 large-6 columns">';
                 innerHTML += '      <p style="margin-bottom: 0px; font-size: 0.875rem; font-weight: 600; color: #004465;">Test Result:</p>';
                 innerHTML += '      <p style="padding-left: 10px; margin: 0;"><span>' + utf8Decode(xml_test_result) + '</span></p>';
                 innerHTML += '    </div>';
                 innerHTML += '</div>';

                  td_labels.innerHTML = innerHTML;
                  //td_labels.appendChild(sendungsdaten_Liste_ul);


                  //---------------------------------------------------------------------//

                  tr.appendChild(td[0]);
                  tr.appendChild(td[1]);
                  tr.appendChild(td[2]);
                  tr.appendChild(td[3]);
                  tr.appendChild(td[4]);
                  tr.appendChild(td[5]);
                  tr.appendChild(td[6]);

                  //---------------------------------------------------------------------//

                  i_bgcolor++;
               } // nodeType = ELEMENT_NODE

            } // end for (i);

            //SpinnerStop(false);
         } // end if
      } // end onreadystatechange
      xmlhttp.ontimeout = function() {
         //SpinnerStop(false);
      }

      xmlhttp.open("POST", encodeURI("/api/xml/v1/vehicle_tests_list.php?"), true);
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.timeout = 120000; // time in milliseconds

      post_parameters = GetAPIAccess();
      post_parameters += zFilter_Param; 

      post_parameters += "&query_offset=" + query_offset;
      post_parameters += "&query_limit=" + query_limit;

      //alert(post_parameters);
      console.log(post_parameters);
      //  
      xmlhttp.send(post_parameters);

      return;
   } // end REST_Vehicle_Tests_list();

   function REST_Vehicle_Test_load(var_test_id = 0) {
     console.log('REST_Vehicle_Test_load('+var_test_id+')');

     //SpinnerStart(false);
     //alert(var_test_id);

     var xmlhttp;
     if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
         xmlhttp = new XMLHttpRequest();
     } else { // code for IE6, IE5
         xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
     }
     xmlhttp.onreadystatechange = function() {
         if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            //var str = xmlhttp.responseText;
            //alert(str);
            //alert(xmlhttp.responseXML);
            console.log(xmlhttp.responseXML);
            if (xmlhttp.responseXML == null) { console.log('No data found!'); return; }

             var nodeVehicle_Tests_List = xmlhttp.responseXML.getElementsByTagName("vehicle_tests_list");
             // alert(nodeVehicle_Tests_List[0].childNodes.length);
             for (var i = 0; i < nodeVehicle_Tests_List[0].childNodes.length; i++) {
                 // alert('NodeName: ' + nodeVehicle_Tests_List[0].childNodes[i].nodeName + ' | NodeType:' + nodeVehicle_Tests_List[0].childNodes[i].nodeType);
                 if (nodeVehicle_Tests_List[0].childNodes[i].nodeType == 1) {
                     var nodeVehicle_Tests = nodeVehicle_Tests_List[0].childNodes[i];
                     // alert(nodeVehicle_Tests.childNodes.length);

                     var xml_test_id = 0;
                     var xml_plate = "";
                     var xml_vehicle = "";
                     var xml_id_customer = 0;
                     var xml_customer_company = "";
                     var xml_id_shop_system = 0;
                     var xml_shop_name = "";
                     var xml_date = 0;

                     var xml_id_users_created_by = 0;
                     var xml_test_result = "";
                     var xml_AxleAmount = "";
                     var xml_CubicCapacity = "";
                     var xml_ProductionYear = "";
                     var xml_FirstUse = "";
                     var xml_VehicleIdentificationNumber = "";
                     var xml_TotalWeight = "";
                     var xml_TotalMeasuredWeight = "";
                     var xml_LastInspection = 0;
                     var xml_ReceiptId = "";
                     var xml_TestPurpose = "";

                     var xml_Vehicle_Make = "";
                     var xml_Vehicle_Class = "";
                     var xml_Vehicle_Class_ID = 0;
                     var xml_Vehicle_Colour = "";
                     var xml_Vehicle_Model = "";
                     var xml_Vehicle_Purpose = "";
                     var xml_status = 0;

                     var xml_flag_visual_defects = 0,
                     xml_flag_brakes = 0,
                     xml_flag_extrapolation = 0,
                     xml_flag_suspension_side_slip = 0,
                     xml_flag_headlight = 0,
                     xml_flag_emission = 0,
                     xml_flag_alignment = 0,
                     xml_flag_vulcanize = 0;



                     for (var j = 0; j < nodeVehicle_Tests.childNodes.length; j++) {
                        if (nodeVehicle_Tests.childNodes[j].nodeType == 1) {
                           // alert("NodeName: " + nodeVehicle_Tests.childNodes[j].nodeName + " | NodeType:" + nodeVehicle_Tests.childNodes[j].nodeType + " | NodeValue: " +  nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue); 
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'test_id') xml_test_id = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'plate') xml_plate = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'vehicle') xml_vehicle = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'id_customer') xml_id_customer = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'customer_company') xml_customer_company = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'id_shop_system') xml_id_shop_system = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'shop_name') xml_shop_name = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'date') xml_date = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;

                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'id_users_created_by') xml_id_users_created_by = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'test_result') xml_test_result = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'AxleAmount') xml_AxleAmount = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'CubicCapacity') xml_CubicCapacity = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'ProductionYear') xml_ProductionYear = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'FirstUse') xml_FirstUse = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'VehicleIdentificationNumber') xml_VehicleIdentificationNumber = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'TotalWeight') xml_TotalWeight = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'TotalMeasuredWeight') xml_TotalMeasuredWeight = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'LastInspection') xml_LastInspection = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'ReceiptId') xml_ReceiptId = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'TestPurpose') xml_TestPurpose = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;

                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'Vehicle_Make') xml_Vehicle_Make = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'Vehicle_Class') xml_Vehicle_Class = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'Vehicle_Class_ID') xml_Vehicle_Class_ID = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'Vehicle_Colour') xml_Vehicle_Colour = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'Vehicle_Model') xml_Vehicle_Model = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'Vehicle_Purpose') xml_Vehicle_Purpose = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;

                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'status') xml_status = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;

                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'flag_visual_defects') xml_flag_visual_defects = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'flag_brakes') xml_flag_brakes = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'flag_extrapolation') xml_flag_extrapolation = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'flag_suspension_side_slip') xml_flag_suspension_side_slip = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'flag_headlight') xml_flag_headlight = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'flag_emission') xml_flag_emission = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'flag_alignment') xml_flag_alignment = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;
                           if (nodeVehicle_Tests.childNodes[j].nodeName === 'flag_vulcanize') xml_flag_vulcanize = nodeVehicle_Tests.childNodes[j].childNodes[0].nodeValue;

                        } // nodeType = ELEMENT_NODE
                     } // end for (j);
                     //alert (xml_test_id + " :: " + xml_vehicle + " :: " + xml_customer_company + " :: " + xml_shop_name);
                     //

                     //Reveal controls
                     test_id_hidden.value = xml_test_id;

                     //text_test_id text_vehicle text_plate select_id_customer select_id_shop_system select_status
                     i_date.innerText = Timestamp_Format_UTC(xml_date).slice(0, -7);
                     rEVEAL_text_test_id.value = xml_test_id;
                     SELECT_Option(rEVEAL_select_vehicle_producer, xml_vehicle);
                     rEVEAL_text_plate.value = xml_plate;
                     SELECT_Option(rEVEAL_select_id_customer, xml_id_customer);
                     SELECT_Option(rEVEAL_select_id_shop_system, xml_id_shop_system);
                     SELECT_Option(rEVEAL_select_status, xml_status);

                     //text_AxleAmount text_CubicCapacity text_VehicleIdentificationNumber text_ProductionYear text_FirstUse text_TotalWeight text_TotalMeasuredWeight text_LastInspection 
                     rEVEAL_text_AxleAmount.value = xml_AxleAmount;
                     rEVEAL_text_CubicCapacity.value = xml_CubicCapacity;
                     rEVEAL_text_VehicleIdentificationNumber.value = xml_VehicleIdentificationNumber;
                     rEVEAL_text_ProductionYear.value = xml_ProductionYear;
                     rEVEAL_text_FirstUse.value = xml_FirstUse;
                     rEVEAL_text_TotalWeight.value = xml_TotalWeight;
                     rEVEAL_text_TotalMeasuredWeight.value = xml_TotalMeasuredWeight;
                     //var date = new Date(xml_LastInspection, );
                     rEVEAL_text_LastInspection.value = Timestamp_Format_UTC(xml_LastInspection).slice(0, -7);

                     //text_ReceiptId select_limit_class_id text_Vehicle_Make text_Vehicle_Colour text_Vehicle_Model text_Vehicle_Purpose text_test_result text_TestPurpose 
                     rEVEAL_text_ReceiptId.value = xml_ReceiptId;
                     SELECT_Option(rEVEAL_select_limit_class_id, xml_Vehicle_Class_ID);
                     rEVEAL_text_Vehicle_Make.value = xml_Vehicle_Make;
                     rEVEAL_text_Vehicle_Colour.value = xml_Vehicle_Colour;
                     rEVEAL_text_Vehicle_Model.value = xml_Vehicle_Model;
                     rEVEAL_text_Vehicle_Purpose.value = xml_Vehicle_Purpose;
                     rEVEAL_text_test_result.value = xml_test_result;
                     rEVEAL_text_TestPurpose.value = xml_TestPurpose;

                     //flag_visual_defects flag_brakes flag_extrapolation flag_alignment flag_suspension_side_slip flag_headlight flag_emission flag_vulcanize
                     CHECK_Option(rEVEAL_flag_visual_defects, parseInt(xml_flag_visual_defects, 10));
                     CHECK_Option(rEVEAL_flag_brakes, parseInt(xml_flag_brakes, 10));
                     CHECK_Option(rEVEAL_flag_extrapolation, parseInt(xml_flag_extrapolation, 10));
                     CHECK_Option(rEVEAL_flag_alignment, parseInt(xml_flag_alignment, 10));
                     CHECK_Option(rEVEAL_flag_suspension_side_slip, parseInt(xml_flag_suspension_side_slip, 10));
                     CHECK_Option(rEVEAL_flag_headlight, parseInt(xml_flag_headlight, 10));
                     CHECK_Option(rEVEAL_flag_emission, parseInt(xml_flag_emission, 10));
                     CHECK_Option(rEVEAL_flag_vulcanize, parseInt(xml_flag_vulcanize, 10));
                     //
                     // Dialog: Build Services
                     
                     if (xml_flag_visual_defects == 1) Service_Type_Switch('flag_visual_defects', xml_test_id);
                     if (xml_flag_brakes == 1) Service_Type_Switch('flag_brakes', xml_test_id);
                     if (xml_flag_extrapolation == 1) Service_Type_Switch('flag_extrapolation', xml_test_id);
                     if (xml_flag_alignment == 1) Service_Type_Switch('flag_alignment', xml_test_id);
                     if (xml_flag_suspension_side_slip == 1) Service_Type_Switch('flag_suspension_side_slip', xml_test_id);
                     if (xml_flag_headlight == 1) Service_Type_Switch('flag_headlight', xml_test_id);
                     if (xml_flag_emission == 1) Service_Type_Switch('flag_emission', xml_test_id);
                     if (xml_flag_vulcanize == 1) Service_Type_Switch('flag_vulcanize', xml_test_id);
                 } // end if (node_Liste);
             } // end for (i);

             //SpinnerStop(false);
         } // end if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
     } // end onreadystatechange
     xmlhttp.ontimeout = function() {
         SpinnerStop(false);
     }

     xmlhttp.open("POST", encodeURI("/api/xml/v1/vehicle_tests_list.php?"), true);
     xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
     xmlhttp.timeout = 120000; // time in milliseconds
     //
     post_parameters = GetAPIAccess();
     post_parameters += "&test_id=" + var_test_id;

     // alert(post_parameters);
     console.log(post_parameters);
     //  
     xmlhttp.send(post_parameters);

     return;
   } // end REST_Vehicle_Test_load();

   function Helper_Vehicle_Tests_Edit() {
      console.log("Helper_Vehicle_Tests_Edit()");

      var fehler = false;

      //
      // Form Eingaben validieren (Hard errors!)
      //
      if (rEVEAL_select_limit_class_id.value == 0) {
         Callout_Meldung(callout_liste_reveal_vehicle_tests, CALLOUT_ALERT, '<a href="#" onClick="Helper_Vehicle_Tests_Focus(rEVEAL_select_limit_class_id);">Vehicle Class empty.</a>', true, 30000);
         fehler = true;
      }

      if (rEVEAL_select_vehicle_producer.value == 0) {
         Callout_Meldung(callout_liste_reveal_vehicle_tests, CALLOUT_ALERT, '<a href="#" onClick="Helper_Vehicle_Tests_Focus(rEVEAL_select_vehicle_producer);">Vehicle empty.</a>', true, 30000);
         fehler = true;
      }

      if (rEVEAL_select_id_shop_system.value == 0) {
         Callout_Meldung(callout_liste_reveal_vehicle_tests, CALLOUT_ALERT, '<a href="#" onClick="Helper_Vehicle_Tests_Focus(rEVEAL_select_id_shop_system);">Shop name empty.</a>', true, 30000);
         fehler = true;
      }

      if (rEVEAL_text_plate.value == '') {
         Callout_Meldung(callout_liste_reveal_vehicle_tests, CALLOUT_ALERT, '<a href="#" onClick="Helper_Vehicle_Tests_Focus(rEVEAL_text_plate);">Plate empty.</a>', true, 30000);
         fehler = true;
      }

      if ((rEVEAL_select_id_customer.value == 0) || (rEVEAL_select_id_customer.value == '')) {
         Callout_Meldung(callout_liste_reveal_vehicle_tests, CALLOUT_ALERT, '<a href="#" onClick="Helper_Vehicle_Tests_Focus(rEVEAL_select_id_customer);">Customer empty.</a>', true, 30000);
         fehler = true;
      }

      if (fehler == false) {
         // Auftrag erstellen / speichern
         REST_Vehicle_Tests_Save(test_id_hidden.value);
      }

      return;
   } // end Helper_Vehicle_Tests_Edit();

   function Helper_Vehicle_Tests_Focus(elem_focus) {
   console.log("Helper_Vehicle_Tests_Focus()");

   if (elem_focus != null) elem_focus.focus();
   } // end Helper_Vehicle_Tests_Focus();

   function REST_Vehicle_Tests_Delete(var_test_id) {
     console.log("REST_Vehicle_Tests_Delete()");

     //Validate Adressbuch data 
     if ((var_test_id != "0") && (var_test_id != "")) {
         if (confirm("Do you really want to delete record " + var_test_id + "?") == false) return;
     } else {
         return;
     }

     var xmlhttp;
     if (window.XMLHttpRequest) {
         // code for IE7+, Firefox, Chrome, Opera, Safari
         xmlhttp = new XMLHttpRequest();
     } else {
         // code for IE6, IE5
         xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
     }

     xmlhttp.ontimeout = function() {
         Callout_Meldung(callout_liste_reveal_customer, CALLOUT_ALERT, "Save: Network connection timed out!", true, 0);
     };

     xmlhttp.onreadystatechange = function() {
         if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
             var str = xmlhttp.responseText;
             // alert(str);
             console.log(xmlhttp.responseXML);

             var node_Liste = xmlhttp.responseXML.getElementsByTagName("vehicle_tests");
             // alert(node_Liste[0].childNodes.length);
             var xml_test_id = 0;

             for (var i = 0; i < node_Liste[0].childNodes.length; i++) {
                // alert('NodeName: ' + node_Liste[0].childNodes[i].nodeName + ' | NodeType:' + node_Liste[0].childNodes[i].nodeType);
                if (node_Liste[0].childNodes[i].nodeType == 1) {
                   if (node_Liste[0].childNodes[i].nodeName === "test_id") xml_test_id = node_Liste[0].childNodes[i].childNodes[0].nodeValue;
                } // end if (nodeType == 1);
             } // end for (i);

             //alert(xml_id_customer);

             if (parseInt(xml_test_id) > -1) { 

                 // Liste neu laden
                 REST_Vehicle_Tests_list(0, myTable_offset.value, myTable_limit.value);
             } else {
                 //Callout_Meldung(callout_liste_reveal_customer, CALLOUT_ALERT, "Error saving!", true, 20000);
             }

         } // end if (xmlhttp.readyState === 4 && xmlhttp.status === ABC);
     }; // end onreadystatechange();

     var post_parameters = GetAPIAccess();

     post_parameters += "&test_id=" + var_test_id;
     post_parameters += "&action=delete";//delete or update
     //
     console.log("/api/xml/v1/vehicle_tests_create_update.php?" + post_parameters);
     //
     xmlhttp.open("POST", encodeURI("/api/xml/v1/vehicle_tests_create_update.php?"), true);
     xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
     xmlhttp.timeout = 120000; // time in milliseconds
     //  
     xmlhttp.send(post_parameters);

     return;
   } // end REST_Vehicle_Tests_Delete();

   function REST_Vehicle_Tests_Save() {
      console.log("REST_Vehicle_Tests_Save()");

      //Validate Adressbuch data 
      if (test_id_hidden.value != "0") {
         if (confirm("Do you want to save changes?") == false) return;
      }

      var xmlhttp;
      if (window.XMLHttpRequest) {
         // code for IE7+, Firefox, Chrome, Opera, Safari
         xmlhttp = new XMLHttpRequest();
      } else {
         // code for IE6, IE5
         xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }

      xmlhttp.ontimeout = function() {
         Callout_Meldung(callout_liste_reveal_vehicle_tests, CALLOUT_ALERT, "Save: Network connection timed out!", true, 0);
      };

      xmlhttp.onreadystatechange = function() {
         if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var str = xmlhttp.responseText;
            // alert(str);
            console.log(xmlhttp.responseXML);

            var node_Liste = xmlhttp.responseXML.getElementsByTagName("vehicle_tests");
            // alert(node_Liste[0].childNodes.length);
            var xml_test_id = 0;

            for (var i = 0; i < node_Liste[0].childNodes.length; i++) {
               // alert('NodeName: ' + node_Liste[0].childNodes[i].nodeName + ' | NodeType:' + node_Liste[0].childNodes[i].nodeType);
               if (node_Liste[0].childNodes[i].nodeType == 1) {
                  if (node_Liste[0].childNodes[i].nodeName === "test_id") xml_test_id = node_Liste[0].childNodes[i].childNodes[0].nodeValue;
                  // if (node_Liste[0].childNodes[i].nodeName === 'fehlercode') xml_fehlercode = node_Liste[0].childNodes[i].childNodes[0].nodeValue;
               } // end if (nodeType == 1);
            } // end for (i);

            //alert(xml_test_id);

            if (parseInt(xml_test_id) > -1) {
               test_id_hidden.value = parseInt(xml_test_id);

               //Insert in to 
               const item_field_collection = document.getElementsByClassName("item_field");
               for (let i = 0; i < item_field_collection.length; i++) {
                  console.log(item_field_collection[i].id, item_field_collection[i].value);

                  var var_id_var_mapping = item_field_collection[i].getAttribute('id_var_mapping');
                  var item_field_value = item_field_collection[i].value;
                  addLoadEvent(Item_Fields_Var_Mapping_Create(var_id_var_mapping, xml_test_id, item_field_collection[i].id, item_field_value));
               }

               // Liste neu laden
               REST_Vehicle_Tests_list(0, myTable_offset.value, myTable_limit.value);
               Close_Vehicle_Tests_Reveal();

            } else {
               Callout_Meldung(callout_liste_reveal_vehicle_tests, CALLOUT_ALERT, "Error saving!", true, 20000);
            }

         } // end if (xmlhttp.readyState === 4 && xmlhttp.status === ABC);
      }; // end onreadystatechange();

      var post_parameters = GetAPIAccess();

      if (test_id_hidden.value == 0) {
         post_parameters += "&test_id=" + test_id_hidden.value; //Create
      } else {
         post_parameters += "&test_id=" + test_id_hidden.value; //Update
         post_parameters += "&action=update";//delete or update
      }
      //

      //text_test_id text_vehicle text_plate select_id_customer select_id_shop_system select_status
      if (rEVEAL_select_vehicle_producer.value != '') post_parameters += '&vehicle=' + rEVEAL_select_vehicle_producer.value;
      if (rEVEAL_text_plate.value != '') post_parameters += '&plate=' + rEVEAL_text_plate.value;
      if (rEVEAL_select_id_customer.value != '') post_parameters += '&id_customer=' + rEVEAL_select_id_customer.value;
      if (rEVEAL_select_id_shop_system != null) post_parameters += '&id_shop_system=' + rEVEAL_select_id_shop_system.value;
      if (rEVEAL_select_status != null) post_parameters += "&status=" + rEVEAL_select_status.value;

      //text_AxleAmount text_CubicCapacity text_VehicleIdentificationNumber text_ProductionYear text_FirstUse text_TotalWeight text_TotalMeasuredWeight text_LastInspection 
      if ((rEVEAL_text_AxleAmount != null) && (rEVEAL_text_AxleAmount.value != '')) post_parameters += '&AxleAmount=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_AxleAmount.value);
      if (rEVEAL_text_CubicCapacity != null) post_parameters += '&CubicCapacity=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_CubicCapacity.value);
      if (rEVEAL_text_VehicleIdentificationNumber != null) post_parameters += '&VehicleIdentificationNumber=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_VehicleIdentificationNumber.value);
      if (rEVEAL_text_ProductionYear != null) post_parameters += '&ProductionYear=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_ProductionYear.value);
      if (rEVEAL_text_FirstUse != null) post_parameters += '&FirstUse=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_FirstUse.value);
      if (rEVEAL_text_TotalWeight != null) post_parameters += '&TotalWeight=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_TotalWeight.value);
      if (rEVEAL_text_TotalMeasuredWeight != null) post_parameters += '&TotalMeasuredWeight=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_TotalMeasuredWeight.value);

      var var_ts_LastInspection = Get_Timestamp2(rEVEAL_text_LastInspection.value, 0, 0, 0);
      if ((var_ts_LastInspection != null) && (var_ts_LastInspection != '')) post_parameters += '&LastInspection=' + var_ts_LastInspection;

      //text_ReceiptId select_limit_class_id text_Vehicle_Make text_Vehicle_Colour text_Vehicle_Model text_Vehicle_Purpose text_test_result text_TestPurpose 
      if (rEVEAL_text_ReceiptId != null) post_parameters += '&ReceiptId=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_ReceiptId.value);
      if (rEVEAL_select_limit_class_id != null) post_parameters += '&Vehicle_Class_ID=' + Helper_encodeURIComponentWithAmp(rEVEAL_select_limit_class_id.value);
      if (rEVEAL_text_Vehicle_Make != null) post_parameters += '&Vehicle_Make=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_Vehicle_Make.value);
      if (rEVEAL_text_Vehicle_Colour != null) post_parameters += '&Vehicle_Colour=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_Vehicle_Colour.value);
      if (rEVEAL_text_Vehicle_Model != null) post_parameters += '&Vehicle_Model=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_Vehicle_Model.value);
      if (rEVEAL_text_Vehicle_Purpose != null) post_parameters += '&Vehicle_Purpose=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_Vehicle_Purpose.value);
      if (rEVEAL_text_test_result != null) post_parameters += '&test_result=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_test_result.value);
      if (rEVEAL_text_TestPurpose != null) post_parameters += '&TestPurpose=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_TestPurpose.value);

      //flag_visual_defects flag_brakes flag_extrapolation flag_alignment flag_suspension_side_slip flag_headlight flag_emission flag_vulcanize
      if (rEVEAL_flag_visual_defects != null) post_parameters += '&flag_visual_defects=' + rEVEAL_flag_visual_defects.value;
      if (rEVEAL_flag_brakes != null) post_parameters += '&flag_brakes=' + rEVEAL_flag_brakes.value;
      if (rEVEAL_flag_extrapolation != null) post_parameters += '&flag_extrapolation=' + rEVEAL_flag_extrapolation.value;
      if (rEVEAL_flag_suspension_side_slip != null) post_parameters += '&flag_suspension_side_slip=' + rEVEAL_flag_suspension_side_slip.value;
      if (rEVEAL_flag_headlight != null) post_parameters += '&flag_headlight=' + rEVEAL_flag_headlight.value;
      if (rEVEAL_flag_emission != null) post_parameters += '&flag_emission=' + rEVEAL_flag_emission.value;
      if (rEVEAL_flag_alignment != null) post_parameters += '&flag_alignment=' + rEVEAL_flag_alignment.value;
      if (rEVEAL_flag_vulcanize != null) post_parameters += '&flag_vulcanize=' + rEVEAL_flag_vulcanize.value;

      // alert(post_parameters);
      console.log("/api/xml/v1/vehicle_tests_create_update.php?" + post_parameters);
      //
      xmlhttp.open("POST", encodeURI("/api/xml/v1/vehicle_tests_create_update.php?"), true);
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.timeout = 120000; // time in milliseconds
      xmlhttp.send(post_parameters);

      return;
   } // end REST_Vehicle_Tests_Save();

   function Item_Fields_Var_Mapping_Create(var_id_var_mapping, var_test_id, var_variable, var_value) {
      console.log('Item_Fields_Var_Mapping_Create(' + var_variable + ')');

      var xmlhttp;
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
         xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
         xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
      }

      xmlhttp.ontimeout = function() {
         Callout_Meldung(callout_liste_reveal_vehicle_tests, CALLOUT_ALERT, "Var_Mapping Save: Network connection timed out!", true, 0);
      }

      xmlhttp.onreadystatechange = function() {
         if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var str = xmlhttp.responseText;
            // alert(str);
            console.log(xmlhttp.responseXML);

            var node_Liste = xmlhttp.responseXML.getElementsByTagName('id_var_mappings');
            // alert(node_Liste[0].childNodes.length);
            var xml_id_var_mapping = 0;

            for (var i = 0; i < node_Liste[0].childNodes.length; i++) {
               // alert('NodeName: ' + node_Liste[0].childNodes[i].nodeName + ' | NodeType:' + node_Liste[0].childNodes[i].nodeType);

               if (node_Liste[0].childNodes[i].nodeType == 1) {
                  if (node_Liste[0].childNodes[i].nodeName === 'id_var_mapping') xml_id_var_mapping = node_Liste[0].childNodes[i].childNodes[0].nodeValue;
               } // end if (nodeType == 1);
            } // end for (i);

            if (parseInt(xml_id_var_mapping) > 0) {

            } else {
               Callout_Meldung(m_callout_shop_config, CALLOUT_ALERT, getBeschriftung_JS(1345, g_LANG_ISO3, "Fehler beim Speichern des Shop Systeme!"), true, 20000);
            }

         } // end if (xmlhttp.readyState === 4 && xmlhttp.status === ABC);
      } // end onreadystatechange();

      var post_parameters = GetAPIAccess();

      post_parameters += '&id_var_mapping=' + var_id_var_mapping;
      post_parameters += '&id=' + var_test_id;
      post_parameters += "&type=" + 10001;
      post_parameters += '&aktiv=1';

      post_parameters += '&variable=' + var_variable;
      post_parameters += '&value=' + var_value;

      xmlhttp.open("POST", encodeURI("/api/xml/v1/id_var_mappings_create_update.php?"), true);
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.timeout = 120000; // time in milliseconds
      //
      // alert(post_parameters);
      console.log("/api/xml/v1/id_var_mappings_create_update.php?" + post_parameters);
      xmlhttp.send(post_parameters);
      return;
   } // end Item_Fields_Var_Mapping_Create();

   function Item_Fields_Var_Mapping_Load(var_test_id) {
      console.log('Item_Fields_Var_Mapping_Load(' + var_test_id + ')');

      var xmlhttp;
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
         xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
         xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange = function() {
         if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var str = xmlhttp.responseText;
            //alert(str);
            // alert(xmlhttp.responseXML);
            console.log(xmlhttp.responseXML);

            if (xmlhttp.responseXML == null) {
               alert('Invalid output!')
               return;
            }

            var nodeVar_Mappings_List = xmlhttp.responseXML.getElementsByTagName("id_var_mappings_list");
            //alert(nodeVar_Mappings_List[0].childNodes.length);

            for (var i = 0; i < nodeVar_Mappings_List[0].childNodes.length; i++) {
               // alert("NodeName: " + nodeVar_Mappings_List[0].childNodes[i].nodeName + " | NodeType:" + nodeVar_Mappings_List[0].childNodes[i].nodeType); 
               if (nodeVar_Mappings_List[0].childNodes[i].nodeType == 1) {
                  var nodeVar_Mapping = nodeVar_Mappings_List[0].childNodes[i];
                  // alert(nodeVar_Mapping.childNodes.length);

                  var xml_id_var_mapping = '';
                  var xml_type = '';
                  var xml_id = '';
                  var xml_variable = '';
                  var xml_value = '';
                  var xml_aktiv = '';
                  var xml_ts_angelegt = '';
                  var xml_ts_aenderung = '';

                  for (var j = 0; j < nodeVar_Mapping.childNodes.length; j++) {
                     if (nodeVar_Mapping.childNodes[j].nodeType == 1) {
                        if (nodeVar_Mapping.childNodes[j].nodeName === 'id_var_mapping') xml_id_var_mapping = nodeVar_Mapping.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVar_Mapping.childNodes[j].nodeName === 'type') xml_type = nodeVar_Mapping.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVar_Mapping.childNodes[j].nodeName === 'id') xml_id = nodeVar_Mapping.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVar_Mapping.childNodes[j].nodeName === 'variable') xml_variable = nodeVar_Mapping.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVar_Mapping.childNodes[j].nodeName === 'value') xml_value = nodeVar_Mapping.childNodes[j].childNodes[0].nodeValue;
                        if (nodeVar_Mapping.childNodes[j].nodeName === 'aktiv') xml_aktiv = nodeVar_Mapping.childNodes[j].childNodes[0].nodeValue;
                     } // nodeType = ELEMENT_NODE
                  } // end for (j);

                  console.log("Type::" + xml_type + " id_::" + xml_id + " variable::" + xml_variable + " value:: " + xml_value);
                  var variable_element = document.getElementById(xml_variable);

                  //console.log(variable_element);
                  if (typeof(variable_element) != 'undefined' && variable_element != null) {
                     //console.log(variable_element.nodeName, variable_element.type);

                     if ((variable_element.nodeName == 'INPUT') && ((variable_element.type == 'text') || (variable_element.type == 'number'))) {
                        variable_element.value = xml_value;
                        variable_element.setAttribute('id_var_mapping', xml_id_var_mapping);

                     } else if ((variable_element.nodeName == 'INPUT') && (variable_element.type == 'checkbox')) {

                        if (xml_value == '1') {
                           variable_element.value = 1;
                           variable_element.checked = true;
                        } else {
                           variable_element.value = 0;
                           variable_element.checked = false;
                        }
                        variable_element.setAttribute('id_var_mapping', xml_id_var_mapping);

                     } else if (variable_element.nodeName == "SELECT") {

                        variable_element.setAttribute('id_var_mapping', xml_id_var_mapping);
                        $("#" + variable_element.id + " option[value='" + xml_value + "']").prop("selected", true);
                        $("#" + variable_element.id).trigger("change");
                     }
                     //
                     //variable_element.setAttribute('id_var_mapping', xml_id_var_mapping);
                  }

               } // nodeType = ELEMENT_NODE
            } // end for (i);

         } // end if
      } // end onreadystatechange

      var post_parameters = GetAPIAccess();

      post_parameters += "&type=" + 10001;

      if ((var_test_id != null) && (var_test_id != 0)) {
         post_parameters += "&id=" + var_test_id;
         //alert(var_test_id);
      } else {
         return;
      }

      xmlhttp.open("POST", encodeURI("/api/xml/v1/id_var_mappings_list.php?"), true);
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.timeout = 120000; // time in milliseconds
      //
      // alert(post_parameters);
      console.log("/api/xml/v1/id_var_mappings_list.php?" + post_parameters);
      xmlhttp.send(post_parameters);
      return;
   } // end Item_Fields_Var_Mapping_Load();

   function Select_limit_class_id_onChange(elem) {
      console.log('Select_limit_class_id_onChange()');

      if ((elem[elem.selectedIndex].getAttribute('AxleAmount') != '') && (elem[elem.selectedIndex].getAttribute('AxleAmount') != 0)) {
         rEVEAL_text_AxleAmount.value = elem[elem.selectedIndex].getAttribute('AxleAmount');
      } 
   }// Select_limit_class_id_onChange...

   function onlyNumberKey(evt) {
      // Only ASCII character in that range allowed
      var ASCIICode = (evt.which) ? evt.which : evt.keyCode
      if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
          return false;
      return true;
   }

   var forceInputUppercase = function(e) {
      let el = e.target;
      let start = el.selectionStart;
      let end = el.selectionEnd;
      el.value = el.value.toUpperCase();
      el.setSelectionRange(start, end);
   };

   document.querySelectorAll(".uc-text").forEach(function(current) {
      current.addEventListener("keyup", forceInputUppercase);
   });

   function Toggle_Detail(elem, var_id) {
   console.log('Toggle_Detail()');

   var label_content = document.getElementById('label_content_' + var_id)
   label_content.classList.toggle('show');

   if (window.getComputedStyle(label_content).display !== "none") {
      elem.querySelector('i').classList.remove('fa-chevron-down');
      elem.querySelector('i').classList.add('fa-chevron-up');
   } else {
      elem.querySelector('i').classList.remove('fa-chevron-up');
      elem.querySelector('i').classList.add('fa-chevron-down');
   }

   //event.preventDefault();
   } //end Toggle_Detail()

</script>