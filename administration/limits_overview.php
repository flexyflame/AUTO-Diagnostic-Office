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

    $limits_id = 0;
    if (isset($_REQUEST['limits_id'])) { $limits_id = $_REQUEST['limits_id']; }

//SELECT `limits_id`, `name`, `limit_values`, id_shop_system `vehicle_class_id`, `SideSlipValueMax`, `WheelDampingLeftMin`, `WheelDampingRightMin`, `WheelDampingDifferenceMax`, `BrakeForceDiffServiceBrakeMax`, `BrakeForceDiffParkingBrakeMax`, `GasRPMMin`, `GasRPMMax`, `GasCO`, `GasHC`, `DieselOpacityAvg`, `ApplyBrakeEvaluation`, `ApplySuspensionEvaluation`, `ApplySideSlipEvaluation`, `ApplyEmissionEvaluation`, `ApplyHeadlightEvaluation`

?>

<article>
    <div class="main-page">
        <div class="container-fluid">
            <div class="row">
                 <div class="small-12 medium-8 large-10 columns" style="border-bottom: 1px solid #4c9cb4; margin: 0px -10px 0px 10px;">
                    <h2 class="title" style="margin: 5px 0 0 0;">Manage Test Limits</h2>
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
                                <div class="small-3 medium-2 large-2 columns">
                                    <label for="text_limits_id_filter" class="left inline">Limit ID:</label>
                                    <input name="text_limits_id_filter" type="text" id="text_limits_id_filter" placeholder="Limit ID" oninput="Filter_Reload();" />
                                </div>

                                <div class="small-9 medium-10 large-10 columns">
                                    <label for="text_name_filter" class="left inline">Name:</label>
                                    <input name="text_name_filter" type="text" id="text_name_filter" placeholder="Name" oninput="Filter_Reload();"/>
                                </div>
                            </div> 

                            <div class="row">
                                <div class="small-12 medium-5 large-5 columns">
                                    <label for="select_id_shop_system_filter" class="left inline">Test Shop:</label>
                                    <?php
                                        $id_shop_system_selektiert = 0;
                                        if (isset($select_id_shop_system)) {
                                            $id_shop_system_selektiert = $select_id_shop_system;
                                        }
                                        $show_all = false; //Include inactive
                                        $show_customer = true;
                                        $select_id = "select_id_shop_system_filter";
                                        $select_name = "select_id_shop_system_filter";
                                        $select_size = 1;
                                        $select_extra_code = 'onchange="Filter_Reload();"';
                                        $db_conn_opt = false;
                                        $arr_option_values = array(0 => '');
                                        echo $UTIL->SELECT_Shop_System($id_shop_system_selektiert, $show_all, $show_customer, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
                                    ?>
                                </div>

                                <div class="small-8 medium-5 large-5 columns">
                                    <label for="select_vehicle_class_id_filter" class="left inline">Vehicle Class:</label>
                                    <?php
                                        $vehicle_class_id_selektiert = 0;
                                        if (isset($select_vehicle_class_id)) {
                                            $vehicle_class_id_selektiert = $select_vehicle_class_id_filter;
                                        }
                                        $show_all = false; //Include inactive
                                        $show_contact_person = true;
                                        $select_id = "select_vehicle_class_id_filter";
                                        $select_name = "select_vehicle_class_id_filter";
                                        $select_size = 1;
                                        $select_extra_code = 'onchange="Filter_Reload();"';
                                        $db_conn_opt = false;
                                        $arr_option_values = array(0 => '');
                                        echo $UTIL->SELECT_Vehicle_Class($vehicle_class_id_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
                                    ?>
                                </div>
                               
                               
                                <div class="small-4 medium-2 large-2 columns">
                                    <label for="select_status_filter" class="left inline">Status</label>
                                    <select id="select_status_filter" name="select_status_filter" onchange="Filter_Reload();">
                                        <option value="-1">Any</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                  </li>
                </ul>
            </div>
        </div> 

        <!-- content rows -->
        <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" style="overflow: auto;" id="form_users_overview" name="form_users_overview" method="post">
            <div class="row" style="padding-top:5px">   

                <div class="small-12 medium-4 large-4 columns limit-cover cell">
                    <div style="display: inline-flex; color: blue;" id="myTable_length">
                        <label style="display: inline-flex;">
                            <span style="padding: 9px 5px 0px 0px; color: #00ced1;;">Show </span> 
                            <select name="myTable_limit" id="myTable_limit" aria-controls="myTable">
                                <option value="3">3</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select> 
                            <span style="padding: 9px 5px 0px 5px; color: #00ced1;"> entries</span> 
                            <input type="hidden" name="myTable_offset" id="myTable_offset" value="0" />
                        </label>
                    </div>
                </div>

                <div class="small-12 medium-5 large-5 columns search-cover cell">
                    <div id="myTable_filter" class="dataTables_filter">
                        <label style="display: flex;">
                            <span style="padding: 9px 5px 0px 0px; color: #00ced1;">Search: </span> 
                            <input type="search" style="font-size: inherit; margin: 0px;" placeholder="" aria-controls="myTable">
                        </label>
                    </div>
                </div>

                <div class="small-12 medium-3 large-3 columns buttons-cover">
                    <a class="button small btn-Table success" title="Save as CSV" href="/output_files.php?page_aktion=csv" onclick="SpinnerBlock();"><i class="fas fa-file" aria-hidden="true"></i></a>
                    <a class="button small btn-Table success" title="Save as Excel" href="/output_files.php?page_aktion=excel" onclick="SpinnerBlock();"><i class="fas fa-file-excel" aria-hidden="true"></i></a>
                    <a class="button small btn-Table success" title="Save PDF" href="/gen_pdf.php?page_aktion=pdf" target="_blank" onclick="SpinnerBlock();"><i class="fas fa-file-pdf" aria-hidden="true"></i></a>
                    <a class="button small btn-Table success" title="Print" href="/gen_pdf.php?page_aktion=print" target="_blank" onclick="SpinnerBlock();"><i class="fas fa-print" aria-hidden="true"></i></a>

                    <a class="button small btn-Table" title="Add Record" onclick="Open_Limits_Reveal();"><i class="fas fa-plus-square" aria-hidden="true"></i></a>
                </div>

                <div class="large-12 small-centered columns" style="padding: 0px;">
                    <table class="responsive-card-table  table-expand hover" id="myTable">  
                        <thead>
                            <th width="5%">ID</th>
                            <th width="40%">Limit Name</th>
                            <th width="20%">Vehicle Class</th>
                            <th width="20%">Test Shop</th>
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

    <!--Users Edit Reveal-->
    <div class="reveal large" id="reveal_limits_edit" name="reveal_limits_edit" data-reveal data-close-on-click="false" style="padding: 1rem; border: 2px solid #607D8B; border-radius: 15px;">
        <fieldset style="padding: 0; border: 0;">

            <div class="mobile-nav-bar title-bar" style="background-color: #567a92; margin-bottom: 15px; padding: 5px 10px;">
                <div class="title-bar-left">
                    <button class="menu-icon" type="button"></button>
                </div>
                <div class="title-bar-center">
                    <span id="reveal_limits_header_text">Create New Test Limit</span>
                </div>
                <div class="title-bar-right">
                    <button class="menu-icon" type="button"></button>
                </div>
            </div>

            <div id="callout_liste_reveal_limits"></div>

            <form id="form_reveal_limits" name="form_reveal_limits" style="margin: 0px; box-shadow: unset;">
                <div class="row">
                    <div class="small-12 medium-12 large-12 columns">
                        <div class="row">
                            <div class="small-4 medium-1 large-1 columns hide">
                               <label for="text_limits_id" class="left inline">Limits ID:</label>
                               <input name="text_limits_id" type="text" id="text_limits_id" placeholder="ID" value="" readonly />
                            </div>
                            <div class="small-8 medium-10 large-4 columns">
                               <label for="text_name" class="left inline">Name</label>
                               <input name="text_name" type="text" id="text_name" placeholder="Name" value="" />
                            </div>

                            <div class="small-12 medium-6 large-2 columns">
                                <label for="select_vehicle_class_id" class="left inline">Vehicle Class:</label>
                                <?php
                                    $vehicle_class_id_selektiert = 0;
                                    $show_all = false; //Include inactive
                                    $show_contact_person = true;
                                    $select_id = "select_vehicle_class_id";
                                    $select_name = "select_vehicle_class_id";
                                    $select_size = 1;
                                    $select_extra_code = 'onchange="Filter_Reload();"';
                                    $db_conn_opt = false;
                                    $arr_option_values = array(0 => '');
                                    echo $UTIL->SELECT_Vehicle_Class($vehicle_class_id_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
                                ?>
                            </div>

                            <div class="small-12 medium-6 large-4 columns">
                                <label for="select_id_shop_system" class="left inline">Test Shop:</label>
                                <?php
                                    $id_shop_system_selektiert = 0;
                                    $show_all = false; //Include inactive
                                    $show_customer = true;
                                    $select_id = "select_id_shop_system";
                                    $select_name = "select_id_shop_system";
                                    $select_size = 1;
                                    $select_extra_code = 'onchange=""';
                                    $db_conn_opt = false;
                                    $arr_option_values = array(0 => '');
                                    echo $UTIL->SELECT_Shop_System($id_shop_system_selektiert, $show_all, $show_customer, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
                                ?>
                            </div> 

                            <div class="small-4 medium-2 large-2 columns">
                               <label for="text_AxleAmount" class="left inline">Axle Amount:</label>
                               <input name="text_AxleAmount" type="number" id="text_AxleAmount" value="2" />
                            </div>
                        </div> 

                        <div class="row"> 
                            <div class="small-6 medium-3 large-3 columns">
                               <label for="text_SideSlipValueMax" class="left inline">Side Slip Value Max:</label>
                               <input name="text_SideSlipValueMax" type="text" id="text_SideSlipValueMax" value=""/>
                            </div>
                            <div class="small-6 medium-3 large-3 columns">
                               <label for="text_WheelDampingDifferenceMax" class="left inline">Wheel Damping Difference Max:</label>
                               <input name="text_WheelDampingDifferenceMax" type="text" id="text_WheelDampingDifferenceMax" value=""/>
                            </div>
    
                            <div class="small-6 medium-3 large-3 columns">
                               <label for="text_WheelDampingLeftMin" class="left inline">Wheel Damping Left Min:</label>
                               <input name="text_WheelDampingLeftMin" type="text" id="text_WheelDampingLeftMin" value=""/>
                            </div>
                             <div class="small-6 medium-3 large-3 columns">
                               <label for="text_WheelDampingRightMin" class="left inline">Wheel Damping Right Min:</label>
                               <input name="text_WheelDampingRightMin" type="text" id="text_WheelDampingRightMin" value=""/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="small-6 medium-3 large-3 columns">
                               <label for="text_GasRPMMin" class="left inline">Gas RPM Min:</label>
                               <input name="text_GasRPMMin" type="text" id="text_GasRPMMin" value=""/>
                            </div>
                            <div class="small-6 medium-3 large-3 columns">
                               <label for="text_GasRPMMax" class="left inline">Gas RPM Max:</label>
                               <input name="text_GasRPMMax" type="text" id="text_GasRPMMax" value=""/>
                            </div>

                            <div class="small-6 medium-3 large-3 columns">
                               <label for="text_ApplySideSlipEvaluation" class="left inline">Apply SideSlip Evaluation:</label>
                               <input name="text_ApplySideSlipEvaluation" type="text" id="text_ApplySideSlipEvaluation" value=""/>
                            </div>
                            <div class="small-6 medium-3 large-3 columns">
                               <label for="text_ApplyEmissionEvaluation" class="left inline">Apply Emission Evaluation:</label>
                               <input name="text_ApplyEmissionEvaluation" type="text" id="text_ApplyEmissionEvaluation" value=""/>
                            </div>
                        </div> 

                        <div class="row">
                            <div class="small-6 medium-3 large-3 columns">
                               <label for="text_GasCO" class="left inline">Gas CO:</label>
                               <input name="text_GasCO" type="text" id="text_GasCO" value=""/>
                            </div>
                            <div class="small-6 medium-3 large-3 columns">
                               <label for="text_GasHC" class="left inline">Gas HC:</label>
                               <input name="text_GasHC" type="text" id="text_GasHC" value=""/>
                            </div>

                            <div class="small-6 medium-3 large-3 columns">
                               <label for="text_ApplyBrakeEvaluation" class="left inline">Apply Brake Evaluation:</label>
                               <input name="text_ApplyBrakeEvaluation" type="text" id="text_ApplyBrakeEvaluation" value=""/>
                            </div>

                            <div class="small-6 medium-3 large-3 columns">
                               <label for="text_ApplySuspensionEvaluation" class="left inline">Apply Suspension Evaluation:</label>
                               <input name="text_ApplySuspensionEvaluation" type="text" id="text_ApplySuspensionEvaluation" value=""/>
                            </div> 
                        </div>   

                        <div class="row">
                            <div class="small-6 medium-4 large-4 columns">
                               <label for="text_BrakeForceDiffServiceBrakeMax" class="left inline">Brake Force Diff Service Brake Max:</label>
                               <input name="text_BrakeForceDiffServiceBrakeMax" type="text" id="text_BrakeForceDiffServiceBrakeMax" value=""/>
                            </div>
                            <div class="small-6 medium-4 large-4 columns">
                               <label for="text_BrakeForceDiffParkingBrakeMax" class="left inline">Brake Force Diff Parking Brake Max:</label>
                               <input name="text_BrakeForceDiffParkingBrakeMax" type="text" id="text_BrakeForceDiffParkingBrakeMax" value=""/>
                            </div>

                            <div class="small-6 medium-4 large-4 columns">
                               <label for="text_ApplyHeadlightEvaluation" class="left inline">Apply Headlight Evaluation:</label>
                               <input name="text_ApplyHeadlightEvaluation" type="text" id="text_ApplyHeadlightEvaluation" value=""/>
                            </div>

                            <div class="small-6 medium-3 large-3 columns">
                               <label for="text_DieselOpacityAvg" class="left inline">Diesel Opacity Avg:</label>
                               <input name="text_DieselOpacityAvg" type="text" id="text_DieselOpacityAvg" value=""/>
                            </div>


                        </div>   
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 medium-2 large-2 columns"></div>
                    <div class="small-12 medium-8 large-8 columns">
                        <div class="button-group-option" data-grouptype="OR" style="margin: 5px 0px; padding: 0px;">
                            <a class="button alert radius" style="padding: 10px;" id="btn_abbrechen" name="btn_abbrechen" onclick="Close_Limits_Reveal();">Cancel</a>
                            <a class="button warning radius" style="padding: 10px;" id="btn_speichern" name="btn_speichern" onclick="Helper_Limits_Edit();">Save</a>
                        </div>
                    </div>
                    <div class="small-12 medium-2 large-2 columns"></div>
                </div>
            </form>
        </fieldset>
    </div>

   <!-------Hidden controls--------->
   <div class="hidden-controls">
      <input type="hidden" id="limits_id_hidden" value="0" />
   </div>

</article>

<!--Include Nav_Footer and Footer-->
<?php 
    $path = $_SERVER['DOCUMENT_ROOT'] ;
    include ($path . "/includes/nav_footer.php");
    include ($path . "/includes/footer.php");
?>


<script type="text/javascript">
    var select_id_shop_system_filter = document.getElementById("select_id_shop_system_filter");
    var text_limits_id_filter = document.getElementById("text_limits_id_filter");
    var text_name_filter = document.getElementById("text_name_filter");
    var select_status_filter = document.getElementById("select_status_filter");

    //Reveal controls
    var reveal_limits_header_text = document.getElementById("reveal_limits_header_text");
    var limits_id_hidden = document.getElementById("limits_id_hidden");
    var callout_liste_reveal_limits = document.getElementById("callout_liste_reveal_limits");

                   

    var rEVEAL_text_limits_id = document.getElementById("text_limits_id");
    var rEVEAL_text_name = document.getElementById("text_name");
    var rEVEAL_select_vehicle_class_id = document.getElementById("select_vehicle_class_id");
    var rEVEAL_select_id_shop_system = document.getElementById("select_id_shop_system");
    var rEVEAL_text_AxleAmount = document.getElementById("text_AxleAmount");
    
    var rEVEAL_text_SideSlipValueMax = document.getElementById("text_SideSlipValueMax");
    var rEVEAL_text_DieselOpacityAvg = document.getElementById("text_DieselOpacityAvg");
    var rEVEAL_text_WheelDampingLeftMin = document.getElementById("text_WheelDampingLeftMin");
    var rEVEAL_text_WheelDampingRightMin = document.getElementById("text_WheelDampingRightMin");
    var rEVEAL_text_WheelDampingDifferenceMax = document.getElementById("text_WheelDampingDifferenceMax");

    var rEVEAL_text_GasRPMMin = document.getElementById("text_GasRPMMin");
    var rEVEAL_text_GasRPMMax = document.getElementById("text_GasRPMMax");
    var rEVEAL_text_ApplySideSlipEvaluation = document.getElementById("text_ApplySideSlipEvaluation");
    var rEVEAL_text_ApplyEmissionEvaluation = document.getElementById("text_ApplyEmissionEvaluation");
    var rEVEAL_text_GasCO = document.getElementById("text_GasCO");
    var rEVEAL_text_GasHC = document.getElementById("text_GasHC");
    var rEVEAL_text_ApplyBrakeEvaluation = document.getElementById("text_ApplyBrakeEvaluation");
    var rEVEAL_text_ApplySuspensionEvaluation = document.getElementById("text_ApplySuspensionEvaluation");
    var rEVEAL_text_BrakeForceDiffServiceBrakeMax = document.getElementById("text_BrakeForceDiffServiceBrakeMax");
    var rEVEAL_text_BrakeForceDiffParkingBrakeMax = document.getElementById("text_BrakeForceDiffParkingBrakeMax");
    var rEVEAL_text_ApplyHeadlightEvaluation = document.getElementById("text_ApplyHeadlightEvaluation");
    //             
   
    var myTable_limit = document.getElementById("myTable_limit");
    var myTable_offset = document.getElementById("myTable_offset");

    addLoadEvent(REST_Limits_list(0, myTable_offset.value, myTable_limit.value));

    $("#reveal_limits_edit").on("open.zf.reveal", function () {
        console.log("reveal_limits_edit: open.zf.reveal");

        $("#form_reveal_limits")[0].reset();

        callout_liste_reveal_limits.innerHTML = "";

        if (limits_id_hidden.value != 0) {
            reveal_limits_header_text.innerText = "Edit Test Shop (" + limits_id_hidden.value + ")";

            REST_Limits_load(limits_id_hidden.value)

        } else {
            reveal_limits_header_text.innerText = "Create New Test Shop";
        }

    });

    function Close_Limits_Reveal() {
        console.log('Close_Limits_Reveal()');

        $('#reveal_limits_edit').foundation('close');
    } //end Close_Limits_Reveal();

    function Open_Limits_Reveal (var_limits_id = 0) {
        console.log('Open_Limits_Reveal('+var_limits_id+')');

        limits_id_hidden.value = var_limits_id;

        $('#reveal_limits_edit').foundation('open');

        return;
    } //end Open_Limits_Reveal();

    function Filter_Reload() {
        REST_Limits_list(0, 0, myTable_limit.value);
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
         li.innerHTML = '<a class="class_spinner_id" onclick="REST_Limits_list(' + query_total + ', ' + ((current_page - 1) * query_limit) + ', ' + query_limit + ');">&laquo;</a>';
         ul_pagenav.appendChild(li);
        }

        // Seitenanzeige aufbauen
        if (show_num_pages < num_pages) { // mehr Seiten als "Anzahl-Seiten" vorhanden
            if (current_page > show_num_pages_half) {
                // Seite 1 ...
                li = document.createElement('li');
                li.className = 'arrow';
                li.innerHTML = '<a class="class_spinner_id" onclick="REST_Limits_list(' + query_total + ', ' + (0 * query_limit) + ', ' + query_limit + ');">1</a>';
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
                 li.innerHTML = '<a class="class_spinner_id" onclick="REST_Limits_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
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
                 li.innerHTML = '<a class="class_spinner_id" onclick="REST_Limits_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
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
                 li.innerHTML = '<a class="class_spinner_id" onclick="REST_Limits_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
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
             li.innerHTML = '<a class="class_spinner_id" onclick="REST_Limits_list(' + query_total + ', ' + ((num_pages - 1) * query_limit) + ', ' + query_limit + ');">' + num_pages + '</a>';         
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
             li.innerHTML = '<a class="class_spinner_id" onclick="REST_Limits_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
             ul_pagenav.appendChild(li);
            } // end for (i);
            } // end if (show_num_pages > num_pages);

            if (current_page < (num_pages - 1)) {
            li = document.createElement('li');
            li.className = 'arrow';
            li.innerHTML = '<a class="class_spinner_id" onclick="REST_Limits_list(' + query_total + ', ' + ((current_page + 1) * query_limit) + ', ' + query_limit + ');">' + '&raquo;' + '</a>';      
            ul_pagenav.appendChild(li);     
        } // end if (current_page > 0)

        return;
    } // end PageNav();

    function REST_Limits_list(query_total, query_offset, query_limit) {
        console.log('REST_Limits_list()');

        //Keep query_offset and query_limit for refresh
        myTable_offset.value = query_offset;
        myTable_limit.value = query_limit;

        //Prepare Table Filter
        var zFilter_Param = '&limits_id=' + text_limits_id_filter.value + '&id_shop_system=' + select_id_shop_system_filter.value + '&vehicle_class_id=' + select_vehicle_class_id_filter.value + '&name=' + text_name_filter.value;
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

            var nodeLimits_List = xmlhttp.responseXML.getElementsByTagName("limits_list");
            // alert(nodeLimits_List[0].childNodes.length);
            for (var i = 0; i < nodeLimits_List[0].childNodes.length; i++) {
                // alert("NodeName: " + nodeLimits_List[0].childNodes[i].nodeName + " | NodeType:" + nodeLimits_List[0].childNodes[i].nodeType); 
                if (nodeLimits_List[0].childNodes[i].nodeType == 1) {
                    var nodeLimits = nodeLimits_List[0].childNodes[i];
                    // alert(nodeLimits.childNodes.length);

                    var xml_limits_id = 0,
                    xml_name = '',
                    xml_limit_values = '',
                    xml_id_shop_system = 0,
                    xml_shop_name = '',
                    xml_vehicle_class_id = 0,
                    xml_vehicle_class_name = '',
                    xml_AxleAmount = 0,
                    
                    xml_SideSlipValueMax = '',
                    xml_WheelDampingLeftMin = '',
                    xml_WheelDampingRightMin = '',
                    xml_WheelDampingDifferenceMax = '',
                    xml_BrakeForceDiffServiceBrakeMax = '',
                    xml_BrakeForceDiffParkingBrakeMax = '',
                    xml_GasRPMMin = '',
                    xml_GasRPMMax = '',

                    xml_GasCO = '',
                    xml_GasHC = '',
                    xml_DieselOpacityAvg = '',
                    xml_ApplyBrakeEvaluation = '',
                    xml_ApplySuspensionEvaluation = '',
                    xml_ApplySideSlipEvaluation = '',
                    xml_ApplyEmissionEvaluation = '',
                    xml_ApplyHeadlightEvaluation = '';

                    for (var j = 0; j < nodeLimits.childNodes.length; j++) {
                        if (nodeLimits.childNodes[j].nodeType == 1) {
                            // alert("NodeName: " + nodeLimits.childNodes[j].nodeName + " | NodeType:" + nodeLimits.childNodes[j].nodeType + " | NodeValue: " +  nodeLimits.childNodes[j].childNodes[0].nodeValue); 
                            if (nodeLimits.childNodes[j].nodeName === 'limits_id') xml_limits_id = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                            if (nodeLimits.childNodes[j].nodeName === 'name') xml_name = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                            if (nodeLimits.childNodes[j].nodeName === 'limit_values') xml_limit_values = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                            if (nodeLimits.childNodes[j].nodeName === 'id_shop_system') xml_id_shop_system = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                            if (nodeLimits.childNodes[j].nodeName === 'shop_name') xml_shop_name = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                            if (nodeLimits.childNodes[j].nodeName === 'vehicle_class_id') xml_vehicle_class_id = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                            if (nodeLimits.childNodes[j].nodeName === 'vehicle_class_name') xml_vehicle_class_name = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                            if (nodeLimits.childNodes[j].nodeName === 'AxleAmount') xml_AxleAmount = nodeLimits.childNodes[j].childNodes[0].nodeValue;

                            if (nodeLimits.childNodes[j].nodeName === 'SideSlipValueMax') xml_SideSlipValueMax = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                            if (nodeLimits.childNodes[j].nodeName === 'WheelDampingLeftMin') xml_WheelDampingLeftMin = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                            if (nodeLimits.childNodes[j].nodeName === 'WheelDampingRightMin') xml_WheelDampingRightMin = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                            if (nodeLimits.childNodes[j].nodeName === 'WheelDampingDifferenceMax') xml_WheelDampingDifferenceMax = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                            if (nodeLimits.childNodes[j].nodeName === 'BrakeForceDiffServiceBrakeMax') xml_BrakeForceDiffServiceBrakeMax = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                            if (nodeLimits.childNodes[j].nodeName === 'BrakeForceDiffParkingBrakeMax') xml_BrakeForceDiffParkingBrakeMax = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                            if (nodeLimits.childNodes[j].nodeName === 'GasRPMMin') xml_GasRPMMin = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                            if (nodeLimits.childNodes[j].nodeName === 'GasRPMMax') xml_GasRPMMax = nodeLimits.childNodes[j].childNodes[0].nodeValue;

                            if (nodeLimits.childNodes[j].nodeName === 'GasCO') xml_GasCO = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                            if (nodeLimits.childNodes[j].nodeName === 'GasHC') xml_GasHC = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                            if (nodeLimits.childNodes[j].nodeName === 'DieselOpacityAvg') xml_DieselOpacityAvg = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                            if (nodeLimits.childNodes[j].nodeName === 'ApplyBrakeEvaluation') xml_ApplyBrakeEvaluation= nodeLimits.childNodes[j].childNodes[0].nodeValue;
                            if (nodeLimits.childNodes[j].nodeName === 'ApplySuspensionEvaluation') xml_ApplySuspensionEvaluation = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                            if (nodeLimits.childNodes[j].nodeName === 'ApplySideSlipEvaluation') xml_ApplySideSlipEvaluation = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                            if (nodeLimits.childNodes[j].nodeName === 'ApplyEmissionEvaluation') xml_ApplyEmissionEvaluation = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                            if (nodeLimits.childNodes[j].nodeName === 'ApplyHeadlightEvaluation') xml_ApplyHeadlightEvaluation= nodeLimits.childNodes[j].childNodes[0].nodeValue;

                        } // nodeType = ELEMENT_NODE
                    } // end for (j);
                  //alert (xml_limits_id + " :: " + xml_id_shop_system + " :: " + xml_name + " :: " + xml_shop_name);
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
                     td[0].setAttribute('data-label', 'ID:');

                     td[0].innerHTML = '';

                     td[0].innerHTML += '<div><span style="font-weight: 600; color: crimson;">' + xml_limits_id + '</span></div>';

                     //---------------------------------------------------------------------//

                     td[1] = document.createElement('td');
                     td[1].setAttribute('bgcolor', bgcolor_row);
                     td[1].setAttribute('valign', 'top');
                     td[1].setAttribute('data-label', 'Name');

                     td[1].innerHTML = '';
                     td[1].innerHTML += '<div style="color: #004465;"><strong>' + utf8Decode(xml_name) + '</strong></div>';

                     //--------------------------------------------------//

                     td[2] = document.createElement('td');
                     td[2].setAttribute('bgcolor', bgcolor_row);
                     td[2].setAttribute('valign', 'top');
                     td[2].setAttribute('data-label', 'Vehicle Class');

                     td[2].innerHTML = '';
                     if (xml_vehicle_class_name == "") {
                        td[2].innerHTML += '<div><strong>' + xml_vehicle_class_id + '</strong></div>';
                     } else {
                        td[2].innerHTML += '<div><strong>' + xml_vehicle_class_id + '</strong> - ' + utf8Decode(xml_vehicle_class_name) + '</div>';
                     }

                     

                     //---------------------------------------------------------------------//

                     td[3] = document.createElement('td');
                     td[3].setAttribute('bgcolor', bgcolor_row);
                     td[3].setAttribute('valign', 'top');
                     td[3].setAttribute('data-label', 'Test Shop');

                     td[3].innerHTML = '';
                     if (xml_shop_name == "") {
                        td[3].innerHTML += '<div><strong>' + xml_id_shop_system + '</strong></div>';
                     } else {
                        td[3].innerHTML += '<div><strong>' + xml_id_shop_system + '</strong> - ' + utf8Decode(xml_shop_name) + '</div>';
                     }

                     //---------------------------------------------------------------------//

                     td[4] = document.createElement('td');
                     td[4].setAttribute('bgcolor', bgcolor_row);
                     td[4].setAttribute('valign', 'top');
                     td[4].setAttribute('data-label', '***');

                     innerHTML = '';
                     innerHTML += '<div>';
                     innerHTML += ' <a class="table-btn" onclick="Open_Limits_Reveal(' + xml_limits_id + ')"><i class="fa fa-edit action-controls" title="Edit Record"></i></a>';
                     innerHTML += ' <a class="table-btn" style="border: 1px solid #ffae00; color: #ffae00;" onclick="REST_Limits_Delete (' + xml_limits_id + ')"><i class="fa fa-trash action-controls" title="Delete Record"></i></a>';
                     innerHTML += ' <a class="table-btn" onclick="Toggle_Detail(this, ' + xml_limits_id + ');" ><i class="fas fa-chevron-down" title="Show Detail"></i></a>';
                     innerHTML += '</div>';
                     td[4].innerHTML = innerHTML;

                     //---------------------------------------------------------------------//   

                     var tr_labels = document.createElement('tr');
                     tbody_Overview.appendChild(tr_labels);
                     tr_labels.className = 'table-expand-row-content';
                     tr_labels.setAttribute('style', 'border: 2px solid #788A8F;');
                     tr_labels.id = 'label_content_' + xml_limits_id;


                     var td_labels = document.createElement('td');
                     tr_labels.appendChild(td_labels);
                     tr_labels.setAttribute('style', 'padding: 0;');
                     td_labels.className = 'table-expand-row-nested';
                     td_labels.setAttribute('colspan', '10');

                     var innerHTML = '';
                     //---------------------------------------------------------------------//
                    
                    innerHTML += '<div class="row">';
                    innerHTML += '    <div class="small-12 medium-6 large-6 columns">';
                    innerHTML += '      <p style="margin-bottom: 5px; font-size: 0.875rem; font-weight: 600; color: #004465;">Display Address:</p>';

                    innerHTML += '      <p style="padding-left: 10px; margin: 0;"><span></span></p>';

                    innerHTML += '    </div>';
                    innerHTML += '    <div class="small-12 medium-6 large-6 columns">';
                    innerHTML += '      <p style="margin-bottom: 0px; font-size: 0.875rem; font-weight: 600; color: #004465;">Display Text:</p>';
                    innerHTML += '      <p style="padding-left: 10px; margin: 0;"><span></span></p>';
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

     xmlhttp.open("POST", encodeURI("/api/xml/v1/limits_list.php?"), true);
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
   } // end REST_Limits_list();

    function REST_Limits_load(var_limits_id) {
        console.log('REST_Limits_load()');

        //SpinnerStart(false);

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

                var nodeLimits_List = xmlhttp.responseXML.getElementsByTagName("limits_list");
                // alert(nodeLimits_List[0].childNodes.length);
                for (var i = 0; i < nodeLimits_List[0].childNodes.length; i++) {
                    // alert('NodeName: ' + nodeLimits_List[0].childNodes[i].nodeName + ' | NodeType:' + nodeLimits_List[0].childNodes[i].nodeType);
                    if (nodeLimits_List[0].childNodes[i].nodeType == 1) {
                        var nodeLimits = nodeLimits_List[0].childNodes[i];
                        // alert(nodeLimits.childNodes.length);

                        var xml_limits_id = 0,
                        xml_name = '',
                        xml_limit_values = '',
                        xml_id_shop_system = 0,
                        xml_shop_name = '',
                        xml_vehicle_class_id = 0,
                        xml_vehicle_class_name = '',
                        xml_AxleAmount = 0,
                        
                        xml_SideSlipValueMax = '',
                        xml_WheelDampingLeftMin = '',
                        xml_WheelDampingRightMin = '',
                        xml_WheelDampingDifferenceMax = '',
                        xml_BrakeForceDiffServiceBrakeMax = '',
                        xml_BrakeForceDiffParkingBrakeMax = '',
                        xml_GasRPMMin = '',
                        xml_GasRPMMax = '',

                        xml_GasCO = '',
                        xml_GasHC = '',
                        xml_DieselOpacityAvg = '',
                        xml_ApplyBrakeEvaluation = '',
                        xml_ApplySuspensionEvaluation = '',
                        xml_ApplySideSlipEvaluation = '',
                        xml_ApplyEmissionEvaluation = '',
                        xml_ApplyHeadlightEvaluation = '';

                        for (var j = 0; j < nodeLimits.childNodes.length; j++) {
                            if (nodeLimits.childNodes[j].nodeType == 1) {
                                // alert("NodeName: " + nodeLimits.childNodes[j].nodeName + " | NodeType:" + nodeLimits.childNodes[j].nodeType + " | NodeValue: " +  nodeLimits.childNodes[j].childNodes[0].nodeValue); 
                                if (nodeLimits.childNodes[j].nodeName === 'limits_id') xml_limits_id = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                                if (nodeLimits.childNodes[j].nodeName === 'name') xml_name = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                                if (nodeLimits.childNodes[j].nodeName === 'limit_values') xml_limit_values = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                                if (nodeLimits.childNodes[j].nodeName === 'id_shop_system') xml_id_shop_system = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                                if (nodeLimits.childNodes[j].nodeName === 'shop_name') xml_shop_name = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                                if (nodeLimits.childNodes[j].nodeName === 'vehicle_class_id') xml_vehicle_class_id = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                                if (nodeLimits.childNodes[j].nodeName === 'vehicle_class_name') xml_vehicle_class_name = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                                if (nodeLimits.childNodes[j].nodeName === 'AxleAmount') xml_AxleAmount = nodeLimits.childNodes[j].childNodes[0].nodeValue;

                                if (nodeLimits.childNodes[j].nodeName === 'SideSlipValueMax') xml_SideSlipValueMax = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                                if (nodeLimits.childNodes[j].nodeName === 'WheelDampingLeftMin') xml_WheelDampingLeftMin = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                                if (nodeLimits.childNodes[j].nodeName === 'WheelDampingRightMin') xml_WheelDampingRightMin = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                                if (nodeLimits.childNodes[j].nodeName === 'WheelDampingDifferenceMax') xml_WheelDampingDifferenceMax = nodeLimits.childNodes[j].childNodes[0].nodeValue;

                                if (nodeLimits.childNodes[j].nodeName === 'BrakeForceDiffServiceBrakeMax') xml_BrakeForceDiffServiceBrakeMax = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                                if (nodeLimits.childNodes[j].nodeName === 'BrakeForceDiffParkingBrakeMax') xml_BrakeForceDiffParkingBrakeMax = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                                if (nodeLimits.childNodes[j].nodeName === 'GasRPMMin') xml_GasRPMMin = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                                if (nodeLimits.childNodes[j].nodeName === 'GasRPMMax') xml_GasRPMMax = nodeLimits.childNodes[j].childNodes[0].nodeValue;

                                if (nodeLimits.childNodes[j].nodeName === 'GasCO') xml_GasCO = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                                if (nodeLimits.childNodes[j].nodeName === 'GasHC') xml_GasHC = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                                if (nodeLimits.childNodes[j].nodeName === 'DieselOpacityAvg') xml_DieselOpacityAvg = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                                if (nodeLimits.childNodes[j].nodeName === 'ApplyBrakeEvaluation') xml_ApplyBrakeEvaluation= nodeLimits.childNodes[j].childNodes[0].nodeValue;
                                if (nodeLimits.childNodes[j].nodeName === 'ApplySuspensionEvaluation') xml_ApplySuspensionEvaluation = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                                if (nodeLimits.childNodes[j].nodeName === 'ApplySideSlipEvaluation') xml_ApplySideSlipEvaluation = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                                if (nodeLimits.childNodes[j].nodeName === 'ApplyEmissionEvaluation') xml_ApplyEmissionEvaluation = nodeLimits.childNodes[j].childNodes[0].nodeValue;
                                if (nodeLimits.childNodes[j].nodeName === 'ApplyHeadlightEvaluation') xml_ApplyHeadlightEvaluation= nodeLimits.childNodes[j].childNodes[0].nodeValue;

                            } // nodeType = ELEMENT_NODE
                        } // end for (j);
                        //alert (xml_limits_id + " :: " + xml_id_shop_system + " :: " + xml_name + " :: " + xml_shop_name);
                        //

                        //Reveal controls
                        limits_id_hidden.value = xml_limits_id;
                        rEVEAL_text_limits_id.value = xml_limits_id;
                        rEVEAL_text_name.value = utf8Decode(xml_name);
                        rEVEAL_select_vehicle_class_id.value = xml_vehicle_class_id;
                        rEVEAL_select_id_shop_system.value = xml_id_shop_system;
                        rEVEAL_text_AxleAmount.value = xml_AxleAmount;

                        rEVEAL_text_SideSlipValueMax.value = utf8Decode(xml_SideSlipValueMax);
                        rEVEAL_text_DieselOpacityAvg.value = utf8Decode(xml_DieselOpacityAvg);
                        rEVEAL_text_WheelDampingLeftMin.value = utf8Decode(xml_WheelDampingLeftMin);
                        rEVEAL_text_WheelDampingRightMin.value = utf8Decode(xml_WheelDampingRightMin);
                        rEVEAL_text_WheelDampingDifferenceMax.value = utf8Decode(xml_WheelDampingDifferenceMax);

                        rEVEAL_text_GasRPMMin.value = utf8Decode(xml_GasRPMMin);
                        rEVEAL_text_GasRPMMax.value = utf8Decode(xml_GasRPMMax);
                        rEVEAL_text_ApplySideSlipEvaluation.value = utf8Decode(xml_ApplySideSlipEvaluation);
                        rEVEAL_text_ApplyEmissionEvaluation.value = utf8Decode(xml_ApplyEmissionEvaluation);
                        rEVEAL_text_GasCO.value = utf8Decode(xml_GasCO);
                        rEVEAL_text_GasHC.value = utf8Decode(xml_GasHC);

                        rEVEAL_text_ApplyBrakeEvaluation.value = utf8Decode(xml_ApplyBrakeEvaluation);
                        rEVEAL_text_ApplySuspensionEvaluation.value = utf8Decode(xml_ApplySuspensionEvaluation);
                        rEVEAL_text_BrakeForceDiffServiceBrakeMax.value = utf8Decode(xml_BrakeForceDiffServiceBrakeMax);
                        rEVEAL_text_BrakeForceDiffParkingBrakeMax.value = utf8Decode(xml_BrakeForceDiffParkingBrakeMax);
                        rEVEAL_text_ApplyHeadlightEvaluation.value = utf8Decode(xml_ApplyHeadlightEvaluation);
                        //
                    } // end if (node_Liste);
                } // end for (i);

                //SpinnerStop(false);
            } // end if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
        } // end onreadystatechange
        xmlhttp.ontimeout = function() {
            SpinnerStop(false);
        }

        xmlhttp.open("POST", encodeURI("/api/xml/v1/limits_list.php?"), true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.timeout = 120000; // time in milliseconds
        //
        post_parameters = GetAPIAccess();
        post_parameters += "&limits_id=" + var_limits_id;

        // alert(post_parameters);
        console.log(post_parameters);
        //  
        xmlhttp.send(post_parameters);

        return;
    } // end REST_Limits_load();

    function Helper_Limits_Edit() {
      console.log("Helper_Limits_Edit()");

      var fehler = false;

      //
      // Form Eingaben validieren (Hard errors!)
      //
      if (rEVEAL_text_name.value == "") {
         Callout_Meldung(callout_liste_reveal_limits, CALLOUT_ALERT, '<a href="#" onClick="Helper_Limits_Focus(text_name);">Shop name empty.</a>', true, 30000);
         fehler = true;
      }

      if (rEVEAL_select_vehicle_class_id.value == 0) {
         Callout_Meldung(callout_liste_reveal_limits, CALLOUT_ALERT, '<a href="#" onClick="Helper_Limits_Focus(rEVEAL_select_vehicle_class_id);">Select Vehicle class.</a>', true, 30000);
         fehler = true;
      }

      if (rEVEAL_select_id_shop_system.value == 0) {
         Callout_Meldung(callout_liste_reveal_limits, CALLOUT_ALERT, '<a href="#" onClick="Helper_Limits_Focus(rEVEAL_select_id_shop_system);">Select Test Shop.</a>', true, 30000);
         fehler = true;
      }

      // if (m_strasse_auftrag_bearbeiten.value == "") {
      //    Callout_Meldung(callout_liste_reveal_limits, CALLOUT_ALERT, '<a href="#" onClick="Helper_Limits_Focus(m_strasse_auftrag_bearbeiten);">Strasse nicht angegeben.</a>', true, 30000);
      //    fehler = true;
      // }

      if (fehler == false) {
         // Auftrag erstellen / speichern
         REST_Limits_Save(limits_id_hidden.value);
      }

      return;
    } // end Helper_Limits_Edit();

    function Helper_Limits_Focus(elem_focus) {
      console.log("Helper_Limits_Focus()");

      if (elem_focus != null) elem_focus.focus();
    } // end Helper_Limits_Focus();

    function REST_Limits_Delete(var_limits_id) {
        console.log("REST_Limits_Delete()");

        //Validate Adressbuch data 
        if (var_limits_id != "0") {
            if (confirm("Do you really want to delete record " + var_limits_id + "?") == false) return;
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

                var node_Liste = xmlhttp.responseXML.getElementsByTagName("limits");
                // alert(node_Liste[0].childNodes.length);
                var xml_limits_id = 0;

                for (var i = 0; i < node_Liste[0].childNodes.length; i++) {
                   // alert('NodeName: ' + node_Liste[0].childNodes[i].nodeName + ' | NodeType:' + node_Liste[0].childNodes[i].nodeType);
                   if (node_Liste[0].childNodes[i].nodeType == 1) {
                      if (node_Liste[0].childNodes[i].nodeName === "limits_id") xml_limits_id = node_Liste[0].childNodes[i].childNodes[0].nodeValue;
                   } // end if (nodeType == 1);
                } // end for (i);

                //alert(xml_id_shop_system);

                if (parseInt(xml_limits_id) > -1) { 

                    // Liste neu laden
                    REST_Limits_list(0, myTable_offset.value, myTable_limit.value);
                } else {
                    //Callout_Meldung(callout_liste_reveal_customer, CALLOUT_ALERT, "Error saving!", true, 20000);
                }

            } // end if (xmlhttp.readyState === 4 && xmlhttp.status === ABC);
        }; // end onreadystatechange();

        var post_parameters = GetAPIAccess();

        post_parameters += "&limits_id=" + var_limits_id;
        post_parameters += "&action=delete";//delete or update
        //

        xmlhttp.open("POST", encodeURI("/api/xml/v1/limits_create_update.php?"), true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.timeout = 120000; // time in milliseconds
        //
        // alert(post_parameters);
        console.log("/api/xml/v1/limits_create_update.php?" + post_parameters);
        //  
        xmlhttp.send(post_parameters);

        return;
    } // end REST_Limits_Delete();

    function REST_Limits_Save() {
        console.log("REST_Limits_Save()");

        //Validate Adressbuch data 
        if (limits_id_hidden.value != "0") {
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
            Callout_Meldung(callout_liste_reveal_limits, CALLOUT_ALERT, "Save: Network connection timed out!", true, 0);
        };

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                var str = xmlhttp.responseText;
                // alert(str);
                console.log(xmlhttp.responseXML);

                var node_Liste = xmlhttp.responseXML.getElementsByTagName("limits");
                // alert(node_Liste[0].childNodes.length);
                var xml_limits_id = 0;

                for (var i = 0; i < node_Liste[0].childNodes.length; i++) {
                   // alert('NodeName: ' + node_Liste[0].childNodes[i].nodeName + ' | NodeType:' + node_Liste[0].childNodes[i].nodeType);
                   if (node_Liste[0].childNodes[i].nodeType == 1) {
                      if (node_Liste[0].childNodes[i].nodeName === "limits_id") xml_limits_id = node_Liste[0].childNodes[i].childNodes[0].nodeValue;
                      // if (node_Liste[0].childNodes[i].nodeName === 'fehlercode') xml_fehlercode = node_Liste[0].childNodes[i].childNodes[0].nodeValue;
                   } // end if (nodeType == 1);
                } // end for (i);

                //alert(xml_limits_id);

                if (parseInt(xml_limits_id) > -1) {

                   limits_id_hidden.value = parseInt(xml_limits_id);

                   // Liste neu laden
                   REST_Limits_list(0, myTable_offset.value, myTable_limit.value);
                   Close_Limits_Reveal();

                } else {
                   Callout_Meldung(callout_liste_reveal_limits, CALLOUT_ALERT, "Error saving!", true, 20000);
                }

            } // end if (xmlhttp.readyState === 4 && xmlhttp.status === ABC);
        }; // end onreadystatechange();

        var post_parameters = GetAPIAccess();

        if (limits_id_hidden.value == 0) {
            post_parameters += "&limits_id=" + limits_id_hidden.value; //Create
        } else {
            post_parameters += "&limits_id=" + limits_id_hidden.value; //Update
        }
        //    
        //SELECT `limits_id`, `name`, `limit_values`, id_shop_system `vehicle_class_id`, `SideSlipValueMax`, `WheelDampingLeftMin`, `WheelDampingRightMin`, `WheelDampingDifferenceMax`, `BrakeForceDiffServiceBrakeMax`, `BrakeForceDiffParkingBrakeMax`, `GasRPMMin`, `GasRPMMax`, `GasCO`, `GasHC`, `DieselOpacityAvg`, `ApplyBrakeEvaluation`, `ApplySuspensionEvaluation`, `ApplySideSlipEvaluation`, `ApplyEmissionEvaluation`, `ApplyHeadlightEvaluation`

        if (rEVEAL_text_name != null) post_parameters += '&name=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_name.value);
        if (rEVEAL_select_vehicle_class_id != null) post_parameters += '&vehicle_class_id=' + rEVEAL_select_vehicle_class_id.value;
        if (rEVEAL_select_id_shop_system != null) post_parameters += '&id_shop_system=' + rEVEAL_select_id_shop_system.value;
        if (rEVEAL_text_AxleAmount!= null) post_parameters += '&AxleAmount=' + rEVEAL_text_AxleAmount.value;

        if (rEVEAL_text_SideSlipValueMax != null) post_parameters += '&SideSlipValueMax=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_SideSlipValueMax.value);
        if (rEVEAL_text_DieselOpacityAvg != null) post_parameters += '&DieselOpacityAvg=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_DieselOpacityAvg.value);
        if (rEVEAL_text_WheelDampingLeftMin != null) post_parameters += '&WheelDampingLeftMin=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_WheelDampingLeftMin.value);
        if (rEVEAL_text_WheelDampingRightMin != null) post_parameters += '&WheelDampingRightMin=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_WheelDampingRightMin.value);
        if (rEVEAL_text_WheelDampingDifferenceMax != null) post_parameters += '&WheelDampingDifferenceMax=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_WheelDampingDifferenceMax.value);

        if (rEVEAL_text_GasRPMMin != null) post_parameters += '&GasRPMMin=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_GasRPMMin.value);
        if (rEVEAL_text_GasRPMMax != null) post_parameters += '&GasRPMMax=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_GasRPMMax.value);
        if (rEVEAL_text_ApplySideSlipEvaluation != null) post_parameters += '&ApplySideSlipEvaluation=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_ApplySideSlipEvaluation.value);
        if (rEVEAL_text_ApplyEmissionEvaluation != null) post_parameters += '&ApplyEmissionEvaluation=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_ApplyEmissionEvaluation.value);
        if (rEVEAL_text_GasCO != null) post_parameters += '&GasCO=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_GasCO.value);
        if (rEVEAL_text_GasHC != null) post_parameters += '&GasHC=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_GasHC.value);
        if (rEVEAL_text_ApplyBrakeEvaluation != null) post_parameters += '&ApplyBrakeEvaluation=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_ApplyBrakeEvaluation.value);
        if (rEVEAL_text_ApplySuspensionEvaluation != null) post_parameters += '&ApplySuspensionEvaluation=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_ApplySuspensionEvaluation.value);
        if (rEVEAL_text_BrakeForceDiffServiceBrakeMax != null) post_parameters += '&BrakeForceDiffServiceBrakeMax=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_BrakeForceDiffServiceBrakeMax.value);
        if (rEVEAL_text_BrakeForceDiffParkingBrakeMax != null) post_parameters += '&BrakeForceDiffParkingBrakeMax=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_BrakeForceDiffParkingBrakeMax.value);
        if (rEVEAL_text_ApplyHeadlightEvaluation != null) post_parameters += '&ApplyHeadlightEvaluation=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_ApplyHeadlightEvaluation.value);

        xmlhttp.open("POST", encodeURI("/api/xml/v1/limits_create_update.php?"), true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.timeout = 120000; // time in milliseconds
        //
        // alert(post_parameters);
        console.log("/api/xml/v1/limits_create_update.php?" + post_parameters);
        //  
        xmlhttp.send(post_parameters);

        return;
    } // end REST_Limits_Save();

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