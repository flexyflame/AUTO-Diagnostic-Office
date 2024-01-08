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

    $id_customer = '';
    if (isset($_REQUEST['id_customer'])) { $id_customer = $_REQUEST['id_customer']; }

?>

<article>
    <div class="main-page">
        <div class="container-fluid">
            <div class="row">
                 <div class="small-12 medium-8 large-10 columns" style="border-bottom: 1px solid #4c9cb4; margin: 0px -10px 0px 10px;">
                    <h2 class="title" style="margin: 5px 0 0 0;">Manage Customers</h2>
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
                                <div class="small-6 medium-2 large-2 columns">
                                    <label for="text_id_customer_filter" class="left inline">Customer ID:</label>
                                    <input name="text_id_customer_filter" type="text" id="text_id_customer_filter" placeholder="Customer ID" oninput="Filter_Reload();" value="<?php echo $id_customer; ?>" />
                                </div>

                                <div class="small-12 medium-5 large-5 columns">
                                    <label for="text_company_filter" class="left inline">Company Name:</label>
                                    <input name="text_company_filter" type="text" id="text_company_filter" placeholder="Company Name" oninput="Filter_Reload();"/>
                                </div>

                                <div class="small-6 medium-2 large-2 columns">
                                    <label for="select_industry_filter" class="left inline">Industry:</label>
                                    <?php
                                        $industry_selektiert = '';
                                        if (isset($select_industry)) {
                                            $industry_selektiert = $select_industry;
                                        }
                                        $select_id = "select_industry_filter";
                                        $select_name = "select_industry_filter";
                                        $select_size = 1;
                                        $select_extra_code = 'onchange="Filter_Reload();"';
                                        $db_conn_opt = false;
                                        $arr_option_values = array(0 => '');
                                        echo $UTIL->SELECT_Industry($industry_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
                                    ?>
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

                                <div class="small-3 medium-6 large-2 columns">
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

                    <a class="button small btn-Table" title="Add Record" onclick="Open_Customer_Reveal();"><i class="fas fa-plus-square" aria-hidden="true"></i></a>
                </div>

                <div class="large-12 small-centered columns" style="padding: 0px;">
                    <table class="responsive-card-table  table-expand hover" id="myTable">  
                        <thead>
                            <th width="5%">ID</th>
                            <th width="40%">Company Name</th>
                            <th width="10%">Industry</th>
                            <th width="20%">Contact Person</th>
                            <th width="10%" style="text-align: center;">Active</th>
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
    <div class="reveal large" id="reveal_customer_edit" name="reveal_customer_edit" data-reveal data-close-on-click="false" style="padding: 1rem; border: 2px solid #607D8B; border-radius: 15px;">
        <fieldset style="padding: 0; border: 0;">

            <div class="mobile-nav-bar title-bar" style="background-color: #567a92; margin-bottom: 15px; padding: 5px 10px;">
                <div class="title-bar-left">
                    <button class="menu-icon" type="button"></button>
                </div>
                <div class="title-bar-center">
                    <span id="reveal_customer_header_text">Create Customer</span>
                </div>
                <div class="title-bar-right">
                    <button class="menu-icon" type="button"></button>
                </div>
            </div>

            <div id="callout_liste_reveal_customer"></div>

            <form id="form_reveal_customer" name="form_reveal_customer" style="margin: 0px; box-shadow: unset;">

                <div class="row">
                    <div class="small-12 medium-12 large-12 columns">
                        <div class="row">
                            <div class="small-4 medium-2 large-2 columns">
                                <label for="text_id_customer" class="left inline">Customer ID:</label>
                                <input name="text_id_customer" type="text" id="text_id_customer" placeholder="ID" value="" readonly />
                            </div>
                            <div class="small-8 medium-6 large-6 columns">
                                <label for="text_company_name" class="left inline">Company Name</label>
                                <input name="text_company_name" type="text" id="text_company_name" placeholder="Company Name" value="" />
                            </div>
                            <div class="small-6 medium-2 large-2 columns">
                                <label for="select_industry" class="left inline">Industry:</label>
                                <?php
                                    $industry_selektiert = '';
                                    $select_id = "select_industry";
                                    $select_name = "select_industry";
                                    $select_size = 1;
                                    $select_extra_code = '';
                                    $db_conn_opt = false;
                                    $arr_option_values = array(0 => '');
                                    echo $UTIL->SELECT_Industry($industry_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
                                ?>
                            </div>
                            <div class="small-6 medium-2 large-2 columns">
                                <label for="select_flag_active" class="left inline">Status</label>
                                <select id="select_flag_active" name="select_flag_active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="row"> 
                           <div class="small-12 medium-12 large-4 columns">
                               <label for="text_address" class="left inline">Address:</label>
                               <input name="text_address" type="text" id="text_address" placeholder="Address" value=""/>
                            </div>
                            <div class="small-12 medium-6 large-4 columns">
                               <label for="text_address_street_1" class="left inline">Address Line 1:</label>
                               <input name="text_address_street_1" type="text" id="text_address_street_1" placeholder="Address Line 1" value="" />
                            </div>
                            <div class="small-12 medium-6 large-4 columns">
                               <label for="text_address_street_2" class="left inline">Address Line 2:</label>
                               <input name="text_address_street_2" type="text" id="text_address_street_2" placeholder="Address Line 2" value="" />
                            </div>
                        </div> 

                        <div class="row">
                            <div class="small-4 medium-2 large-2 columns">
                               <label for="text_address_zip" class="left inline">ZIP:</label>
                               <input name="text_address_zip" type="text" id="text_address_zip" placeholder="ZIP" value="" />
                            </div>
                            <div class="small-4 medium-3 large-3 columns">
                               <label for="text_address_city" class="left inline">City:</label>
                               <input name="text_address_city" type="text" id="text_address_city" placeholder="City" value="" />
                            </div>
                            <div class="small-4 medium-3 large-3 columns">
                               <label for="text_address_state" class="left inline">State:</label>
                               <input name="text_address_state" type="text" id="text_address_state" placeholder="State" value="" />
                            </div>

                            <div class="small-12 medium-4 large-4 columns">
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
                                    echo $UTIL->SELECT_Shop_System($id_shop_system_selektiert, $show_all, $show_customer, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
                                ?>
                            </div>
                        </div>

                         <div class="row">
                            <div class="small-12 medium-6 large-6 columns">
                               <label for="text_address_country" class="left inline">Country:</label>
                               <input name="text_address_country" type="text" id="text_address_country" placeholder="Country" value="" />
                            </div>
                            <div class="small-12 medium-6 large-6 columns">
                               <label for="text_phone" class="left inline">Phone:</label>
                               <input name="text_phone" type="text" id="text_phone" placeholder="Phone" value="" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="small-12 medium-6 large-6 columns">
                               <label for="text_email" class="left inline">Email:</label>
                               <input name="text_email" type="text" id="text_email" placeholder="Email" value="" />
                            </div>
                            <div class="small-12 medium-6 large-6 columns">
                               <label for="text_website" class="left inline">Website:</label>
                               <input name="text_website" type="text" id="text_website" placeholder="Website" value="" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="small-12 medium-6 large-6 columns">
                               <label for="text_contact_person" class="left inline">Contact Person:</label>
                               <input name="text_contact_person" type="text" id="text_contact_person" placeholder="Contact Person" value="" />
                            </div>
                            <div class="small-12 medium-6 large-6 columns">
                                <label for="select_sales_rep" class="left inline">Sales Rep.:</label>
                                <?php
                                    $sales_rep_selektiert = '';
                                    $select_id = "select_sales_rep";
                                    $select_name = "select_sales_rep";
                                    $select_size = 1;
                                    $select_extra_code = '';
                                    $db_conn_opt = false;
                                    $arr_option_values = array(0 => '');
                                    echo $UTIL->SELECT_Industry($sales_rep_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
                                ?>
                            </div>
                        </div> 

                         <div class="row">
                            <div class="small-12 medium-12 large-12 columns">
                               <label for="text_background_info" class="left inline">Background Info:</label>
                               <input name="text_background_info" type="text" id="text_background_info" placeholder="Background Info" value="" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 medium-2 large-2 columns"></div>
                    <div class="small-12 medium-8 large-8 columns">
                        <div class="button-group-option" data-grouptype="OR" style="margin: 5px 0px; padding: 0px;">
                            <a class="button alert radius" style="padding: 10px;" id="btn_abbrechen" name="btn_abbrechen" onclick="Close_Customer_Reveal();">Cancel</a>
                            <a class="button warning radius" style="padding: 10px;" id="btn_speichern" name="btn_speichern" onclick="Helper_customer_Edit();" data-element-index="10">Save</a>
                        </div>
                    </div>
                    <div class="small-12 medium-2 large-2 columns"></div>
                </div>
            </form>
        </fieldset>
    </div>

   <!-------Hidden controls--------->
   <div class="hidden-controls">
      <input type="hidden" id="id_customer_hidden" value="0" />
   </div>

</article>

<!--Include Nav_Footer and Footer-->
<?php 
    $path = $_SERVER['DOCUMENT_ROOT'] ;
    include ($path . "/includes/nav_footer.php");
    include ($path . "/includes/footer.php");
?>


<script type="text/javascript">
    var select_industry_filter = document.getElementById("select_industry_filter");
    var select_id_customer_filter = document.getElementById("select_id_customer_filter");
    var text_id_customer_filter = document.getElementById("text_id_customer_filter");
    var text_company_filter = document.getElementById("text_company_filter");
    var select_status_filter = document.getElementById("select_status_filter");
    var select_id_shop_system_filter = document.getElementById("select_id_shop_system_filter");

    //Reveal controls
    var reveal_customer_header_text = document.getElementById("reveal_customer_header_text");
    var id_customer_hidden = document.getElementById("id_customer_hidden");
    var callout_liste_reveal_customer = document.getElementById("callout_liste_reveal_customer");

    var rEVEAL_text_id_customer = document.getElementById("text_id_customer");
    var rEVEAL_text_company_name = document.getElementById("text_company_name");
    var rEVEAL_select_industry = document.getElementById("select_industry");
    var rEVEAL_select_flag_active = document.getElementById("select_flag_active");
    var rEVEAL_text_address = document.getElementById("text_address");
    var rEVEAL_text_address_street_1 = document.getElementById("text_address_street_1");

    var rEVEAL_text_address_street_2 = document.getElementById("text_address_street_2");
    var rEVEAL_text_address_zip = document.getElementById("text_address_zip");
    var rEVEAL_text_address_city = document.getElementById("text_address_city");
    var rEVEAL_text_address_state = document.getElementById("text_address_state");
    var rEVEAL_text_address_country = document.getElementById("text_address_country");
    var rEVEAL_text_phone = document.getElementById("text_phone");
    var rEVEAL_text_email = document.getElementById("text_email");
    var rEVEAL_text_website = document.getElementById("text_website");
    var rEVEAL_text_contact_person = document.getElementById("text_contact_person");
    var rEVEAL_select_sales_rep = document.getElementById("select_sales_rep");
    var rEVEAL_text_background_info = document.getElementById("text_background_info");
    var rEVEAL_select_id_shop_system = document.getElementById("select_id_shop_system");
   
    var myTable_limit = document.getElementById("myTable_limit");
    var myTable_offset = document.getElementById("myTable_offset");

    <?php 
        echo "var arr_id_shop_system = '" . $UTIL->XML_Variablelist_From_Array("id_shop_system", $SESSION->Session_GetArrayShopSystems(), "id_shop_system", "&") . "';";  
    ?>
    console.log(arr_id_shop_system);

    addLoadEvent(REST_customer_list(0, myTable_offset.value, myTable_limit.value));

    $("#reveal_customer_edit").on("open.zf.reveal", function () {
        console.log("reveal_customer_edit: open.zf.reveal");

        $("#form_reveal_customer")[0].reset();

        callout_liste_reveal_customer.innerHTML = "";

        if (id_customer_hidden.value != 0) {
            reveal_customer_header_text.innerText = "Edit Customer (" + id_customer_hidden.value + ")";

            REST_customer_load(id_customer_hidden.value)

        } else {
            reveal_customer_header_text.innerText = "Create New Customer";
        }

    });

    function Close_Customer_Reveal() {
        console.log('Close_Customer_Reveal()');

        $('#reveal_customer_edit').foundation('close');
    } //end Close_Customer_Reveal();

    function Open_Customer_Reveal (var_id_customer = 0) {
        console.log('Open_Customer_Reveal('+var_id_customer+')');

        id_customer_hidden.value = var_id_customer;

        $('#reveal_customer_edit').foundation('open');

        return;
    } //end Open_Customer_Reveal();

    function Filter_Reload() {
        REST_customer_list(0, 0, myTable_limit.value);
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
            li.innerHTML = '<a class="class_spinner_id" onclick="REST_customer_list(' + query_total + ', ' + ((current_page - 1) * query_limit) + ', ' + query_limit + ');">&laquo;</a>';
            ul_pagenav.appendChild(li);
        }

        // Seitenanzeige aufbauen
        if (show_num_pages < num_pages) { // mehr Seiten als "Anzahl-Seiten" vorhanden
            if (current_page > show_num_pages_half) {
                // Seite 1 ...
                li = document.createElement('li');
                li.className = 'arrow';
                li.innerHTML = '<a class="class_spinner_id" onclick="REST_customer_list(' + query_total + ', ' + (0 * query_limit) + ', ' + query_limit + ');">1</a>';
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
                    li.innerHTML = '<a class="class_spinner_id" onclick="REST_customer_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
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
                    li.innerHTML = '<a class="class_spinner_id" onclick="REST_customer_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
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
                    li.innerHTML = '<a class="class_spinner_id" onclick="REST_customer_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
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
                li.innerHTML = '<a class="class_spinner_id" onclick="REST_customer_list(' + query_total + ', ' + ((num_pages - 1) * query_limit) + ', ' + query_limit + ');">' + num_pages + '</a>';         
                ul_pagenav.appendChild(li);

            } // end if (current_page < (num_pages - show_num_pages_half) );

        } else { // weniger als 7 Seiten
     
            for (i = 0; i < num_pages; i++) {
                li = document.createElement('li');
                if (i == current_page) {
                    li.className = 'current';
                } else {
                    i.className = '';
                }
                li.innerHTML = '<a class="class_spinner_id" onclick="REST_customer_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
                ul_pagenav.appendChild(li);
            } // end for (i);
        } // end if (show_num_pages > num_pages);
     
        if (current_page < (num_pages - 1)) {
            li = document.createElement('li');
            li.className = 'arrow';
            li.innerHTML = '<a class="class_spinner_id" onclick="REST_customer_list(' + query_total + ', ' + ((current_page + 1) * query_limit) + ', ' + query_limit + ');">' + '&raquo;' + '</a>';      
            ul_pagenav.appendChild(li);     
        } // end if (current_page > 0)

        return;
    } // end PageNav();

    function REST_customer_list(query_total, query_offset, query_limit) {
        console.log('REST_customer_list()');

        //Keep query_offset and query_limit for refresh
        myTable_offset.value = query_offset;
        myTable_limit.value = query_limit;

        //Prepare Table Filter
        var zFilter_Param = '&id_customer=' + text_id_customer_filter.value + '&company=' + text_company_filter.value + '&industry=' + select_industry_filter.value;
        zFilter_Param += '&flag_active=' + select_status_filter.value;

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
                //alert(xmlhttp.responseXML);
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

                var nodeCustomer_List = xmlhttp.responseXML.getElementsByTagName("customer_list");
                // alert(nodeCustomer_List[0].childNodes.length);
                for (var i = 0; i < nodeCustomer_List[0].childNodes.length; i++) {
                    // alert("NodeName: " + nodeCustomer_List[0].childNodes[i].nodeName + " | NodeType:" + nodeCustomer_List[0].childNodes[i].nodeType); 
                    if (nodeCustomer_List[0].childNodes[i].nodeType == 1) {
                        var nodeCustomer = nodeCustomer_List[0].childNodes[i];
                        // alert(nodeCustomer.childNodes.length);

                        var xml_id_customer = 0,
                        xml_Company = '',
                        xml_Industry = '',

                        xml_Address = '',
                        xml_Address_Street_1 = '',
                        xml_Address_Street_2 = '',
                        xml_Address_City = '',
                        xml_Address_State = '',
                        xml_Address_Zip = '',
                        xml_Address_Country = '',
                        xml_Phone = '',
                        xml_Email = '',
                        xml_Website = '',

                        xml_Background_Info = '',
                        xml_Sales_Rep = '',
                        xml_Date_of_Initial_Customer = 0,
                        xml_Contact_person = '',
                        xml_flag_active = 0;
                        var xml_id_shop_system = 0;
                        var xml_shop_name = "";

                        for (var j = 0; j < nodeCustomer.childNodes.length; j++) {
                            if (nodeCustomer.childNodes[j].nodeType == 1) {
                                // alert("NodeName: " + nodeCustomer.childNodes[j].nodeName + " | NodeType:" + nodeCustomer.childNodes[j].nodeType + " | NodeValue: " +  nodeCustomer.childNodes[j].childNodes[0].nodeValue); 
                                if (nodeCustomer.childNodes[j].nodeName === 'id_customer') xml_id_customer = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Company') xml_Company = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Industry') xml_Industry = nodeCustomer.childNodes[j].childNodes[0].nodeValue;

                                if (nodeCustomer.childNodes[j].nodeName === 'Address') xml_Address = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Address_Street_1') xml_Address_Street_1 = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Address_Street_2') xml_Address_Street_2 = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Address_City') xml_Address_City = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Address_State') xml_Address_State = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Address_Zip') xml_Address_Zip = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Address_Country') xml_Address_Country = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Phone') xml_Phone = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Email') xml_Email = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Website') xml_Website = nodeCustomer.childNodes[j].childNodes[0].nodeValue;

                                if (nodeCustomer.childNodes[j].nodeName === 'Background_Info') xml_Background_Info = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Sales_Rep') xml_Sales_Rep = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Date_of_Initial_Customer') xml_Date_of_Initial_Customer = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Contact_person') xml_Contact_person = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'flag_active') xml_flag_active = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'id_shop_system') xml_id_shop_system = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'shop_name') xml_shop_name = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                
                            } // nodeType = ELEMENT_NODE
                        } // end for (j);
                        //alert (xml_id_shop_system + " :: " + xml_id_customer + " :: " + xml_shop_name + " :: " + xml_shop_type + " :: " + xml_shop_id);
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
                        td[0].setAttribute('data-label', 'Customer ID:');

                        td[0].innerHTML = '';

                        td[0].innerHTML += '<div><span style="font-weight: 600; color: crimson;">' + xml_id_customer + '</span></div>';

                        //---------------------------------------------------------------------//

                        td[1] = document.createElement('td');
                        td[1].setAttribute('bgcolor', bgcolor_row);
                        td[1].setAttribute('valign', 'top');
                        td[1].setAttribute('data-label', 'Company Name');

                        td[1].innerHTML = '';
                        td[1].innerHTML += '<div><span style="font-weight: 600; color: #004465;">' + utf8Decode(xml_Company) + '</span></div>';

                        //---------------------------------------------------------------------//

                        td[2] = document.createElement('td');
                        td[2].setAttribute('bgcolor', bgcolor_row);
                        td[2].setAttribute('valign', 'top');
                        td[2].setAttribute('data-label', 'Industry');

                        td[2].innerHTML = '';
                        td[2].innerHTML += '<div><strong>' + xml_Industry + '</strong></div>';

                        //---------------------------------------------------------------------//

                        td[3] = document.createElement('td');
                        td[3].setAttribute('bgcolor', bgcolor_row);
                        td[3].setAttribute('valign', 'top');
                        td[3].setAttribute('data-label', 'Contact Person');

                        td[3].innerHTML = '';
                        td[3].innerHTML += '<div>' + utf8Decode(xml_Contact_person) + '</div>';

                        //---------------------------------------------------------------------//

                        td[3] = document.createElement('td');
                        td[3].setAttribute('bgcolor', bgcolor_row);
                        td[3].setAttribute('valign', 'top');
                        td[3].setAttribute('data-label', 'Test Shop');

                        td[3].innerHTML = '';
                        td[3].innerHTML += '<div>' + xml_id_shop_system + ' - ' + utf8Decode(xml_shop_name) + '</div>';

                        //---------------------------------------------------------------------//

                        td[4] = document.createElement('td');
                        td[4].setAttribute('bgcolor', bgcolor_row);
                        td[4].setAttribute('valign', 'top');
                        td[4].setAttribute('data-label', 'Status');

                        td[4].innerHTML = '';
                        td[4].innerHTML += '<p style="margin: 1px 0; color: #1779ba; text-align: center;"><span>' + ((xml_flag_active == 1) ? '<?php echo $UTIL->IMG_Activated(15, 15); ?>' : '<?php echo $UTIL->IMG_Deactivated(15, 15); ?>') + '</span></p>';

                        //---------------------------------------------------------------------//

                        td[5] = document.createElement('td');
                        td[5].setAttribute('bgcolor', bgcolor_row);
                        td[5].setAttribute('valign', 'top');
                        td[5].setAttribute('data-label', '***');

                        innerHTML = '';
                        innerHTML += '<div style="text-align: right;">';
                        innerHTML += ' <a class="table-btn" onclick="Open_Customer_Reveal(' + xml_id_customer + ')"><i class="fa fa-edit action-controls" title="Edit Record"></i></a>';
                        innerHTML += ' <a class="table-btn" style="border: 1px solid #ffae00; color: #ffae00;" onclick="REST_customer_Delete (' + xml_id_customer + ')"><i class="fa fa-trash action-controls" title="Delete Record"></i></a>';
                        innerHTML += ' <a class="table-btn" onclick="Toggle_Detail(this, ' + xml_id_customer + ');" ><i class="fas fa-chevron-down" title="Show Detail"></i></a>';
                        innerHTML += '</div>';
                        td[5].innerHTML = innerHTML;

                        //---------------------------------------------------------------------//   

                        var tr_labels = document.createElement('tr');
                        tbody_Overview.appendChild(tr_labels);
                        tr_labels.className = 'table-expand-row-content';
                        tr_labels.setAttribute('style', 'border: 2px solid #788A8F;');
                        tr_labels.id = 'label_content_' + xml_id_customer;


                        var td_labels = document.createElement('td');
                        tr_labels.appendChild(td_labels);
                        tr_labels.setAttribute('style', 'padding: 0;');
                        td_labels.className = 'table-expand-row-nested';
                        td_labels.setAttribute('colspan', '10');

                        var innerHTML = '';
                        //---------------------------------------------------------------------//

                        innerHTML += '<div class="row">';
                        innerHTML += '    <div class="small-12 medium-6 large-6 columns">';
                        innerHTML += '      <p style="margin-bottom: 5px; font-size: 0.875rem; font-weight: 600; color: #004465;">Address:</p>';

                        innerHTML += '      <p style="padding-left: 10px; margin: 0;"><span>' + utf8Decode(xml_Address) + '</span></p>';
                        innerHTML += '      <p style="padding-left: 10px; margin: 0;"><span>' + utf8Decode(xml_Address_Street_1) + '</span></p>';
                        innerHTML += '      <p style="padding-left: 10px; margin: 0;"><span>' + utf8Decode(xml_Address_Street_2) + '</span></p>';
                        innerHTML += '      <p style="padding-left: 10px; margin: 0;"><span>' + utf8Decode(xml_Address_City) + ' ' + utf8Decode(xml_Address_Zip) + '</span></p>';
                        innerHTML += '      <p style="padding-left: 10px; margin: 0;"><span>' + utf8Decode(xml_Address_Country) + '</span></p>';
                        innerHTML += '      <p style="padding-left: 10px; margin: 0;"><span>' + utf8Decode(xml_Phone) + '</span></p>';
                        innerHTML += '      <p style="padding-left: 10px; margin: 0;"><span>' + utf8Decode(xml_Email) + ' ' + utf8Decode(xml_Website) + '</span></p>';
                        innerHTML += '    </div>';
                        innerHTML += '    <div class="small-12 medium-6 large-6 columns">';
                        innerHTML += '      <p style="margin-bottom: 0px; font-size: 0.875rem; font-weight: 600; color: #004465;">Details:</p>';

                        innerHTML += '      <p style="padding-left: 10px; margin: 0;"><b>Date: </b><span>' + utf8Decode(xml_Date_of_Initial_Customer) + '</span><b style="margin-left:4em;">Sales Rep.: </b><span>' + utf8Decode(xml_Sales_Rep) + '</span></p>';
                        innerHTML += '      <p style="padding-left: 10px; margin: 0;"><b>Background_Info: </b><br><span>' + utf8Decode(xml_Background_Info) + '</span></p>';
                        innerHTML += '    </div>';
                        innerHTML += '</div>';

                        td_labels.innerHTML = innerHTML;
                        //---------------------------------------------------------------------//

                        tr.appendChild(td[0]);
                        tr.appendChild(td[1]);
                        tr.appendChild(td[2]);
                        tr.appendChild(td[3]);
                        tr.appendChild(td[4]);
                        tr.appendChild(td[5]);

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

        xmlhttp.open("POST", encodeURI("/api/xml/v1/customer_list.php?"), true);
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
    } // end REST_customer_list();

    function REST_customer_load(var_id_customer) {
        console.log('REST_customer_load()');

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

                var nodeCustomer_List = xmlhttp.responseXML.getElementsByTagName("customer_list");
                // alert(nodeCustomer_List[0].childNodes.length);
                for (var i = 0; i < nodeCustomer_List[0].childNodes.length; i++) {
                    // alert('NodeName: ' + nodeCustomer_List[0].childNodes[i].nodeName + ' | NodeType:' + nodeCustomer_List[0].childNodes[i].nodeType);
                    if (nodeCustomer_List[0].childNodes[i].nodeType == 1) {
                        var nodeCustomer = nodeCustomer_List[0].childNodes[i];
                        // alert(nodeCustomer.childNodes.length);

                        var xml_id_customer = 0,
                        xml_Company = '',
                        xml_Industry = '',

                        xml_Address = '',
                        xml_Address_Street_1 = '',
                        xml_Address_Street_2 = '',
                        xml_Address_City = '',
                        xml_Address_State = '',
                        xml_Address_Zip = '',
                        xml_Address_Country = '',
                        xml_Phone = '',
                        xml_Email = '',
                        xml_Website = '',

                        xml_Background_Info = '',
                        xml_Sales_Rep = '',
                        xml_Date_of_Initial_Customer = 0,
                        xml_Contact_person = '',
                        xml_flag_active = 0;


                        for (var j = 0; j < nodeCustomer.childNodes.length; j++) {
                            if (nodeCustomer.childNodes[j].nodeType == 1) {
                                // alert("NodeName: " + nodeCustomer.childNodes[j].nodeName + " | NodeType:" + nodeCustomer.childNodes[j].nodeType + " | NodeValue: " +  nodeCustomer.childNodes[j].childNodes[0].nodeValue); 
                                if (nodeCustomer.childNodes[j].nodeName === 'id_customer') xml_id_customer = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Company') xml_Company = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Industry') xml_Industry = nodeCustomer.childNodes[j].childNodes[0].nodeValue;

                                if (nodeCustomer.childNodes[j].nodeName === 'Address') xml_Address = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Address_Street_1') xml_Address_Street_1 = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Address_Street_2') xml_Address_Street_2 = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Address_City') xml_Address_City = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Address_State') xml_Address_State = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Address_Zip') xml_Address_Zip = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Address_Country') xml_Address_Country = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Phone') xml_Phone = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Email') xml_Email = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Website') xml_Website = nodeCustomer.childNodes[j].childNodes[0].nodeValue;

                                if (nodeCustomer.childNodes[j].nodeName === 'Background_Info') xml_Background_Info = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Sales_Rep') xml_Sales_Rep = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Date_of_Initial_Customer') xml_Date_of_Initial_Customer = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'Contact_person') xml_Contact_person = nodeCustomer.childNodes[j].childNodes[0].nodeValue;
                                if (nodeCustomer.childNodes[j].nodeName === 'flag_active') xml_flag_active = nodeCustomer.childNodes[j].childNodes[0].nodeValue;

                            } // nodeType = ELEMENT_NODE
                        } // end for (j);
                        //alert (xml_id_shop_system + " :: " + xml_id_customer + " :: " + xml_shop_name + " :: " + xml_shop_type + " :: " + xml_shop_id);
                        //
                        id_customer_hidden.value = xml_id_customer;
                        //
                        rEVEAL_text_id_customer.value = xml_id_customer;
                        rEVEAL_text_company_name.value = utf8Decode(xml_Company);
                        SELECT_Option(rEVEAL_select_industry, xml_Industry);
                        SELECT_Option(rEVEAL_select_flag_active, xml_flag_active);

                        rEVEAL_text_address.value = utf8Decode(xml_Address);
                        rEVEAL_text_address_street_1.value = utf8Decode(xml_Address_Street_1);
                        rEVEAL_text_address_street_2.value = utf8Decode(xml_Address_Street_2);
                        rEVEAL_text_address_zip.value = utf8Decode(xml_Address_Zip);
                        rEVEAL_text_address_city.value = utf8Decode(xml_Address_City);
                        rEVEAL_text_address_state.value = utf8Decode(xml_Address_State);
                        rEVEAL_text_address_country.value = utf8Decode(xml_Address_Country);
                        rEVEAL_text_phone.value = utf8Decode(xml_Phone);
                        rEVEAL_text_email.value = utf8Decode(xml_Email);
                        rEVEAL_text_website.value = utf8Decode(xml_Website);
                        rEVEAL_text_contact_person.value = utf8Decode(xml_Contact_person);
                        SELECT_Option(rEVEAL_select_sales_rep, xml_flag_active);

                        rEVEAL_text_background_info.value = utf8Decode(xml_Background_Info);
                        //
                    } // end if (node_Liste);
                } // end for (i);

                //SpinnerStop(false);
            } // end if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
        } // end onreadystatechange
        xmlhttp.ontimeout = function() {
            SpinnerStop(false);
        }

        xmlhttp.open("POST", encodeURI("/api/xml/v1/customer_list.php?"), true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.timeout = 120000; // time in milliseconds
        //
        post_parameters = GetAPIAccess();
        post_parameters += "&id_customer=" + var_id_customer;

        // alert(post_parameters);
        console.log(post_parameters);
        //  
        xmlhttp.send(post_parameters);

        return;
    } // end REST_customer_load();

    function Helper_customer_Edit() {
        console.log("Helper_customer_Edit()");

        var fehler = false;

        //
        // Form Eingaben validieren (Hard errors!)
        //
        if (rEVEAL_text_company_name.value == "") {
            Callout_Meldung(callout_liste_reveal_customer, CALLOUT_ALERT, '<a href="#" onClick="Helper_customer_Focus(rEVEAL_text_company_name);">Company name empty.</a>', true, 30000);
            fehler = true;
        }

        if (rEVEAL_select_id_shop_system.value == '0') {
           Callout_Meldung(callout_liste_reveal_customer, CALLOUT_ALERT, '<a href="#" onClick="Helper_customer_Focus(rEVEAL_select_id_shop_system);">Select Test Shop.</a>', true, 30000);
           fehler = true;
        }

        // if (m_hausnr_auftrag_bearbeiten.value == "") {
        //    Callout_Meldung(callout_liste_reveal_customer, CALLOUT_ALERT, '<a href="#" onClick="Helper_customer_Focus(m_hausnr_auftrag_bearbeiten);">Hausnr. nicht angegeben.</a>', true, 30000);
        //    fehler = true;
        // }

        // if (m_strasse_auftrag_bearbeiten.value == "") {
        //    Callout_Meldung(callout_liste_reveal_customer, CALLOUT_ALERT, '<a href="#" onClick="Helper_customer_Focus(m_strasse_auftrag_bearbeiten);">Strasse nicht angegeben.</a>', true, 30000);
        //    fehler = true;
        // }

        if (fehler == false) {
            // Save customer
            REST_customer_Save();
        }

        return;
    } // end Helper_customer_Edit();

    function Helper_customer_Focus(elem_focus) {
        console.log("Helper_customer_Focus()");

        if (elem_focus != null) elem_focus.focus();
    } // end Helper_customer_Focus();

    function REST_customer_Delete(var_id_customer) {
        console.log("REST_customer_Delete()");

        //Validate Adressbuch data 
        if (var_id_customer != "0") {
            if (confirm("Do you really want to delete record " + var_id_customer + "?") == false) return;
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

                var node_Liste = xmlhttp.responseXML.getElementsByTagName("customer");
                // alert(node_Liste[0].childNodes.length);
                var xml_id_customer = 0;

                for (var i = 0; i < node_Liste[0].childNodes.length; i++) {
                   // alert('NodeName: ' + node_Liste[0].childNodes[i].nodeName + ' | NodeType:' + node_Liste[0].childNodes[i].nodeType);
                   if (node_Liste[0].childNodes[i].nodeType == 1) {
                      if (node_Liste[0].childNodes[i].nodeName === "id_customer") xml_id_customer = node_Liste[0].childNodes[i].childNodes[0].nodeValue;
                   } // end if (nodeType == 1);
                } // end for (i);

                //alert(xml_id_customer);

                if (parseInt(xml_id_customer) > -1) { 

                    // Liste neu laden
                    REST_customer_list(0, myTable_offset.value, myTable_limit.value);
                } else {
                    //Callout_Meldung(callout_liste_reveal_customer, CALLOUT_ALERT, "Error saving!", true, 20000);
                }

            } // end if (xmlhttp.readyState === 4 && xmlhttp.status === ABC);
        }; // end onreadystatechange();

        var post_parameters = GetAPIAccess();

        post_parameters += "&id_customer=" + var_id_customer;
        post_parameters += "&action=delete";//delete or update
        //

        xmlhttp.open("POST", encodeURI("/api/xml/v1/customer_create_update.php?"), true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.timeout = 120000; // time in milliseconds
        //
        // alert(post_parameters);
        console.log("/api/xml/v1/customer_create_update.php?" + post_parameters);
        //  
        xmlhttp.send(post_parameters);

        return;
    } // end REST_customer_Delete();

    function REST_customer_Save() {
        console.log("REST_customer_Save()");

        //Validate Adressbuch data 
        if (id_customer_hidden.value != "0") {
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
            Callout_Meldung(callout_liste_reveal_customer, CALLOUT_ALERT, "Save: Network connection timed out!", true, 0);
        };

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                var str = xmlhttp.responseText;
                // alert(str);
                console.log(xmlhttp.responseXML);

                var node_Liste = xmlhttp.responseXML.getElementsByTagName("customer");
                // alert(node_Liste[0].childNodes.length);
                var xml_id_customer = 0;

                for (var i = 0; i < node_Liste[0].childNodes.length; i++) {
                   // alert('NodeName: ' + node_Liste[0].childNodes[i].nodeName + ' | NodeType:' + node_Liste[0].childNodes[i].nodeType);
                   if (node_Liste[0].childNodes[i].nodeType == 1) {
                      if (node_Liste[0].childNodes[i].nodeName === "id_customer") xml_id_customer = node_Liste[0].childNodes[i].childNodes[0].nodeValue;
                   } // end if (nodeType == 1);
                } // end for (i);

                //alert(xml_id_customer);

                if (parseInt(xml_id_customer) > -1) { 

                    id_customer_hidden.value = parseInt(xml_id_customer);

                    // Liste neu laden
                    REST_customer_list(0, myTable_offset.value, myTable_limit.value);
                    Close_Customer_Reveal();

                } else {
                    Callout_Meldung(callout_liste_reveal_customer, CALLOUT_ALERT, "Error saving!", true, 20000);
                }

            } // end if (xmlhttp.readyState === 4 && xmlhttp.status === ABC);
        }; // end onreadystatechange();

        var post_parameters = GetAPIAccess();

        if (id_customer_hidden.value == 0) {
            post_parameters += "&id_customer=" + id_customer_hidden.value; //Create
        } else {
            post_parameters += "&id_customer=" + id_customer_hidden.value; //Update
        }
        //

        if (id_customer_hidden != null) post_parameters += '&id_customer=' + id_customer_hidden.value;
        if (rEVEAL_text_company_name != null) post_parameters += '&Company=' + rEVEAL_text_company_name.value;
        if (rEVEAL_select_industry != null) post_parameters += '&Industry=' + rEVEAL_select_industry.value;

        if (rEVEAL_text_address != null) post_parameters += '&Address=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_address.value);
        if (rEVEAL_text_address_street_1 != null) post_parameters += '&Address_Street_1=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_address_street_1.value);
        if (rEVEAL_text_address_street_2 != null) post_parameters += '&Address_Street_2=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_address_street_2.value);
        if (rEVEAL_text_address_city != null) post_parameters += '&Address_City=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_address_city.value);
        if (rEVEAL_text_address_state != null) post_parameters += '&Address_State=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_address_state.value);
        if (rEVEAL_text_address_zip != null) post_parameters += '&Address_Zip=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_address_zip.value);
        if (rEVEAL_text_address_country != null) post_parameters += "&Address_Country=" + Helper_encodeURIComponentWithAmp(rEVEAL_text_address_country.value);
        if (rEVEAL_text_phone != null) post_parameters += "&Phone=" + Helper_encodeURIComponentWithAmp(rEVEAL_text_phone.value);
        if (rEVEAL_text_email != null) post_parameters += "&Email=" + Helper_encodeURIComponentWithAmp(rEVEAL_text_email.value);
        if (rEVEAL_text_website != null) post_parameters += "&Website=" + Helper_encodeURIComponentWithAmp(rEVEAL_text_website.value);

        if (rEVEAL_text_background_info != null) post_parameters += '&Background_Info=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_background_info.value);
        if (rEVEAL_select_sales_rep != null) post_parameters += '&Sales_Rep=' + rEVEAL_select_sales_rep.value;
        if (rEVEAL_text_contact_person != null) post_parameters += '&Contact_person=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_contact_person.value);

        if (rEVEAL_select_flag_active != null) post_parameters += "&flag_active=" + rEVEAL_select_flag_active.value;
        if (rEVEAL_select_id_shop_system != null) post_parameters += '&id_shop_system=' + rEVEAL_select_id_shop_system.value;

        xmlhttp.open("POST", encodeURI("/api/xml/v1/customer_create_update.php?"), true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.timeout = 120000; // time in milliseconds
        //
        // alert(post_parameters);
        console.log("/api/xml/v1/customer_create_update.php?" + post_parameters);
        //  
        xmlhttp.send(post_parameters);

        return;
    } // end REST_customer_Save();

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