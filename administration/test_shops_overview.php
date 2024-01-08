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


?>

<article>
    <div class="main-page">
        <div class="container-fluid">
            <div class="row">
                 <div class="small-12 medium-8 large-10 columns" style="border-bottom: 1px solid #4c9cb4; margin: 0px -10px 0px 10px;">
                    <h2 class="title" style="margin: 5px 0 0 0;">Manage Test Shops</h2>
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
                                <div class="small-2 medium-2 large-2 columns">
                                    <label for="text_id_shop_system_filter" class="left inline">Test Shop ID:</label>
                                    <input name="text_id_shop_system_filter" type="text" id="text_id_shop_system_filter" placeholder="Test Shop ID" oninput="Filter_Reload();" />
                                </div>
                               
                                <div class="small-7 medium-7 large-7 columns">
                                    <label for="text_shop_name_filter" class="left inline">Shop Name:</label>
                                    <input name="text_shop_name_filter" type="text" id="text_shop_name_filter" placeholder="Shop Name" oninput="Filter_Reload();"/>
                                </div>
                                <div class="small-3 medium-3 large-3 columns">
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

                    <a class="button small btn-Table" title="Add Record" onclick="Open_Shop_System_Reveal();"><i class="fas fa-plus-square" aria-hidden="true"></i></a>
                </div>

                <div class="large-12 small-centered columns" style="padding: 0px;">
                    <table class="responsive-card-table  table-expand hover" id="myTable">  
                        <thead>
                            <th width="5%">ID</th>
                            <th width="55%">Shop Name</th>
                            <th width="15%">Shop Code</th>
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
    <div class="reveal large" id="reveal_shop_systems_edit" name="reveal_shop_systems_edit" data-reveal data-close-on-click="false" style="padding: 1rem; border: 2px solid #607D8B; border-radius: 15px;">
        <fieldset style="padding: 0; border: 0;">

            <div class="mobile-nav-bar title-bar" style="background-color: #567a92; margin-bottom: 15px; padding: 5px 10px;">
                <div class="title-bar-left">
                    <button class="menu-icon" type="button"></button>
                </div>
                <div class="title-bar-center">
                    <span id="reveal_shop_systems_header_text">Create New Test Shop</span>
                </div>
                <div class="title-bar-right">
                    <button class="menu-icon" type="button"></button>
                </div>
            </div>

            <div id="callout_liste_reveal_shop_systems"></div>

            <form id="form_reveal_shop_systems" name="form_reveal_shop_systems" style="margin: 0px; box-shadow: unset;">
                <div class="row">
                    <div class="small-12 medium-12 large-12 columns">
                        <div class="row">
                            <div class="small-12 medium-2 large-2 columns">
                               <label for="text_id_shop_system" class="left inline">Test Shop ID:</label>
                               <input name="text_id_shop_system" type="text" id="text_id_shop_system" placeholder="ID" value="" readonly />
                            </div>
                            <div class="small-12 medium-6 large-6 columns">
                               <label for="text_shop_name" class="left inline">Name</label>
                               <input name="text_shop_name" type="text" id="text_shop_name" placeholder="Shop Name" value="" />
                            </div>
                            <div class="small-6 medium-2 large-2 columns">
                               <label for="text_shop_code" class="left inline">Shop Code:</label>
                               <input name="text_shop_code" type="text" id="text_shop_code" placeholder="Shop Code" value=""/>
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
                            <div class="small-12 medium-6 large-6 columns">
                               <label for="text_display_address" class="left inline">Display Address:</label>
                               <textarea rows="4" name="text_display_address" id="text_display_address" class="control-input" style="min-height: 50px; resize: none;" data-element-index="19" placeholder="Display Address"></textarea>
                            </div> 
                            <div class="small-12 medium-6 large-6 columns">
                               <label for="text_display_text" class="left inline">Display Text:</label>
                               <textarea rows="4" name="text_display_text" id="text_display_text" class="control-input" style="min-height: 50px; resize: none;" data-element-index="19" placeholder="Display Text"></textarea>
                            </div>
                        </div>    

                        <div class="row" style="margin: 0;">
                            <div class="small-12 medium-4 large-4 columns">
                                <fieldset style="border: 1px solid #e6e6e6; border-radius: 10px; margin-bottom: 10px; padding: 5px 15px; background: aliceblue; color: #607D8B; min-height: 230px;">
                                    <legend><i>Photo Upload: </i></legend>
                                    <div class="row">
                                        <div class="small-12 medium-12 large-12 columns" style="border-left: 1px solid #e9e9e9;">
                                            <div class="responsive-picture team-picture">
                                                <?php
                                                    if (!empty($image_content)) {
                                                        echo '<div style="height: 150px; padding-bottom: 10px; text-align: center;"><img class="img_photo" id="img_photo" alt="User Picture" style="border-radius: 10px; height: 100%;" src="data:image/jpeg;base64,' . base64_encode($image_content) . '"  /></div>' ;
                                                    } else {
                                                        echo '<div style="height: 150px; padding-bottom: 10px; text-align: center;"><img class="img_photo" id="img_photo" alt="User Picture" style="border-radius: 10px; height: 100%;" src="/images/undefined.png"  /></div>' ;
                                                    }
                                                ?>
                                                <div style="text-align: center; text-align: center; font-weight: 600; color: brown;"><span id="id_users_show" name="id_users_show"></span></div>
                                            </div>
                                        </div>

                                        <div class="small-12 medium-12 large-12 columns" style="display: inline-flex;">
                                            <input id="inputFileToLoad" type="file" onchange="encodeImageFileAsURL();" />             
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="small-12 medium-8 large-8 columns">
                                <fieldset style="border: 1px solid #e6e6e6; border-radius: 10px; margin-bottom: 10px; padding: 5px 15px; background: aliceblue; color: #607D8B; min-height: 230px;">
                                    <legend><i>Service: <span style="font-size: small;">Select the services Test Shop provides</span></i></legend>

                                    <div class="row" style="margin-bottom: 5px;">
                                        <div class="small-12 medium-6 large-6 columns">
                                            <label style="font-size: medium; font-weight: 500;"><input type="checkbox" id="flag_visual_defects" data-element-index="20" value="0" onclick="Checkbox_value_change(this)">Visual Defects</label>
                                        </div>
                                        <div class="small-12 medium-6 large-6 columns">
                                            <label style="font-size: medium; font-weight: 500;"><input type="checkbox" id="flag_brakes" data-element-index="21" value="0" onclick="Checkbox_value_change(this)">Brakes</label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-bottom: 5px;">
                                        <div class="small-12 medium-6 large-6 columns">
                                            <label style="font-size: medium; font-weight: 500;"><input type="checkbox" id="flag_extrapolation" data-element-index="21" value="0" onclick="Checkbox_value_change(this)">Extrapolation</label>
                                        </div>
                                        <div class="small-12 medium-6 large-6 columns">
                                            <label style="font-size: medium; font-weight: 500;"><input type="checkbox" id="flag_alignment" data-element-index="20" value="0" onclick="Checkbox_value_change(this)">Alignment</label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-bottom: 5px;">
                                       <div class="small-12 medium-6 large-6 columns">
                                            <label style="font-size: medium; font-weight: 500;"><input type="checkbox" id="flag_suspension_side_slip" data-element-index="20" value="0" onclick="Checkbox_value_change(this)">Suspension / Side Slip</label>
                                        </div>
                                        <div class="small-12 medium-6 large-6 columns">
                                            <label style="font-size: medium; font-weight: 500;"><input type="checkbox" id="flag_headlight" data-element-index="20" value="0" onclick="Checkbox_value_change(this)">Headlight</label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-bottom: 5px;">
                                       <div class="small-12 medium-6 large-6 columns">
                                            <label style="font-size: medium; font-weight: 500;"><input type="checkbox" id="flag_emission" data-element-index="21" value="0" onclick="Checkbox_value_change(this)">Emission</label>
                                        </div>
                                        <div class="small-12 medium-6 large-6 columns">
                                            <label style="font-size: medium; font-weight: 500;"><input type="checkbox" id="flag_vulcanize" data-element-index="20" value="0" onclick="Checkbox_value_change(this)">Vulcanize</label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 medium-2 large-2 columns"></div>
                    <div class="small-12 medium-8 large-8 columns">
                        <div class="button-group-option" data-grouptype="OR" style="margin: 5px 0px; padding: 0px;">
                            <a class="button alert radius" style="padding: 10px;" id="btn_abbrechen" name="btn_abbrechen" onclick="Close_Shop_System_Reveal();">Cancel</a>
                            <a class="button warning radius" style="padding: 10px;" id="btn_speichern" name="btn_speichern" onclick="Helper_Shop_Systems_Edit();" data-element-index="10">Save</a>
                        </div>
                    </div>
                    <div class="small-12 medium-2 large-2 columns"></div>
                </div>
            </form>
        </fieldset>
    </div>

   <!-------Hidden controls--------->
   <div class="hidden-controls">
      <input type="hidden" id="id_shop_system_hidden" value="0" />
   </div>

</article>

<!--Include Nav_Footer and Footer-->
<?php 
    $path = $_SERVER['DOCUMENT_ROOT'] ;
    include ($path . "/includes/nav_footer.php");
    include ($path . "/includes/footer.php");
?>


<script type="text/javascript">
    var text_id_shop_system_filter = document.getElementById("text_id_shop_system_filter");
    var text_shop_name_filter = document.getElementById("text_shop_name_filter");
    var select_status_filter = document.getElementById("select_status_filter");

    //Reveal controls
    var reveal_shop_systems_header_text = document.getElementById("reveal_shop_systems_header_text");
    var id_shop_system_hidden = document.getElementById("id_shop_system_hidden");
    var callout_liste_reveal_shop_systems = document.getElementById("callout_liste_reveal_shop_systems");

    var rEVEAL_text_id_shop_system = document.getElementById("text_id_shop_system");
    var rEVEAL_text_shop_name = document.getElementById("text_shop_name");
    var rEVEAL_text_shop_code = document.getElementById("text_shop_code");
    var rEVEAL_select_flag_active = document.getElementById("select_flag_active");
    
    var rEVEAL_flag_visual_defects = document.getElementById("flag_visual_defects");
    var rEVEAL_flag_brakes = document.getElementById("flag_brakes");
    var rEVEAL_flag_extrapolation = document.getElementById("flag_extrapolation");
    var rEVEAL_flag_alignment = document.getElementById("flag_alignment");

    var rEVEAL_flag_suspension_side_slip = document.getElementById("flag_suspension_side_slip");
    var rEVEAL_flag_headlight = document.getElementById("flag_headlight");
    var rEVEAL_flag_emission = document.getElementById("flag_emission");
    var rEVEAL_flag_vulcanize = document.getElementById("flag_vulcanize");

    var rEVEAL_text_display_address = document.getElementById("text_display_address");
    var rEVEAL_text_display_text = document.getElementById("text_display_text");
    //             
   
    var myTable_limit = document.getElementById("myTable_limit");
    var myTable_offset = document.getElementById("myTable_offset");

    addLoadEvent(REST_Shop_Systems_list(0, myTable_offset.value, myTable_limit.value));

    $("#reveal_shop_systems_edit").on("open.zf.reveal", function () {
        console.log("reveal_shop_systems_edit: open.zf.reveal");

        $("#form_reveal_shop_systems")[0].reset();

        callout_liste_reveal_shop_systems.innerHTML = "";

        if (id_shop_system_hidden.value != 0) {
            reveal_shop_systems_header_text.innerText = "Edit Test Shop (" + id_shop_system_hidden.value + ")";

            REST_Shop_Systems_load(id_shop_system_hidden.value)

        } else {
            reveal_shop_systems_header_text.innerText = "Create New Test Shop";
        }

    });

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

    function Close_Shop_System_Reveal() {
        console.log('Close_Shop_System_Reveal()');

        $('#reveal_shop_systems_edit').foundation('close');
    } //end Close_Shop_System_Reveal();

    function Open_Shop_System_Reveal (var_id_shop_system = 0) {
        console.log('Open_Shop_System_Reveal('+var_id_shop_system+')');

        id_shop_system_hidden.value = var_id_shop_system;

        $('#reveal_shop_systems_edit').foundation('open');

        return;
    } //end Open_Shop_System_Reveal();

    function Filter_Reload() {
        REST_Shop_Systems_list(0, 0, myTable_limit.value);
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
         li.innerHTML = '<a class="class_spinner_id" onclick="REST_Shop_Systems_list(' + query_total + ', ' + ((current_page - 1) * query_limit) + ', ' + query_limit + ');">&laquo;</a>';
         ul_pagenav.appendChild(li);
        }

        // Seitenanzeige aufbauen
        if (show_num_pages < num_pages) { // mehr Seiten als "Anzahl-Seiten" vorhanden
            if (current_page > show_num_pages_half) {
                // Seite 1 ...
                li = document.createElement('li');
                li.className = 'arrow';
                li.innerHTML = '<a class="class_spinner_id" onclick="REST_Shop_Systems_list(' + query_total + ', ' + (0 * query_limit) + ', ' + query_limit + ');">1</a>';
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
                 li.innerHTML = '<a class="class_spinner_id" onclick="REST_Shop_Systems_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
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
                 li.innerHTML = '<a class="class_spinner_id" onclick="REST_Shop_Systems_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
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
                 li.innerHTML = '<a class="class_spinner_id" onclick="REST_Shop_Systems_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
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
             li.innerHTML = '<a class="class_spinner_id" onclick="REST_Shop_Systems_list(' + query_total + ', ' + ((num_pages - 1) * query_limit) + ', ' + query_limit + ');">' + num_pages + '</a>';         
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
             li.innerHTML = '<a class="class_spinner_id" onclick="REST_Shop_Systems_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
             ul_pagenav.appendChild(li);
            } // end for (i);
            } // end if (show_num_pages > num_pages);

            if (current_page < (num_pages - 1)) {
            li = document.createElement('li');
            li.className = 'arrow';
            li.innerHTML = '<a class="class_spinner_id" onclick="REST_Shop_Systems_list(' + query_total + ', ' + ((current_page + 1) * query_limit) + ', ' + query_limit + ');">' + '&raquo;' + '</a>';      
            ul_pagenav.appendChild(li);     
        } // end if (current_page > 0)

        return;
    } // end PageNav();

    function REST_Shop_Systems_list(query_total, query_offset, query_limit) {
        console.log('REST_Shop_Systems_list()');

        //Keep query_offset and query_limit for refresh
        myTable_offset.value = query_offset;
        myTable_limit.value = query_limit;

        //Prepare Table Filter
        var zFilter_Param = '&id_shop_system=' + text_id_shop_system_filter.value + '&shop_name=' + text_shop_name_filter.value;
        zFilter_Param += '&flag_active=' + select_status_filter.value;
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

            var nodeShop_Systems_List = xmlhttp.responseXML.getElementsByTagName("shop_systems_list");
            // alert(nodeShop_Systems_List[0].childNodes.length);
            for (var i = 0; i < nodeShop_Systems_List[0].childNodes.length; i++) {
                // alert("NodeName: " + nodeShop_Systems_List[0].childNodes[i].nodeName + " | NodeType:" + nodeShop_Systems_List[0].childNodes[i].nodeType); 
                if (nodeShop_Systems_List[0].childNodes[i].nodeType == 1) {
                    var nodeShop_Systems = nodeShop_Systems_List[0].childNodes[i];
                    // alert(nodeShop_Systems.childNodes.length);

                    var xml_id_shop_system = 0,
                    xml_shop_name = '',
                    xml_shop_code = '',

                    xml_flag_visual_defects = 0,
                    xml_flag_brakes = 0,
                    xml_flag_extrapolation = 0,
                    xml_flag_suspension_side_slip = 0,
                    xml_flag_headlight = 0,
                    xml_flag_emission = 0,
                    xml_flag_alignment = 0,
                    xml_flag_vulcanize = 0,

                    xml_logo = '',
                    xml_display_address = '',
                    xml_display_text = '',
                    xml_flag_active = 0;

                    for (var j = 0; j < nodeShop_Systems.childNodes.length; j++) {
                        if (nodeShop_Systems.childNodes[j].nodeType == 1) {
                            // alert("NodeName: " + nodeShop_Systems.childNodes[j].nodeName + " | NodeType:" + nodeShop_Systems.childNodes[j].nodeType + " | NodeValue: " +  nodeShop_Systems.childNodes[j].childNodes[0].nodeValue); 
                            if (nodeShop_Systems.childNodes[j].nodeName === 'id_shop_system') xml_id_shop_system = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'shop_name') xml_shop_name = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'shop_code') xml_shop_code = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;

                            if (nodeShop_Systems.childNodes[j].nodeName === 'flag_visual_defects') xml_flag_visual_defects = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'flag_brakes') xml_flag_brakes = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'flag_extrapolation') xml_flag_extrapolation = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'flag_suspension_side_slip') xml_flag_suspension_side_slip = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'flag_headlight') xml_flag_headlight = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'flag_emission') xml_flag_emission = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'flag_alignment') xml_flag_alignment = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'flag_vulcanize') xml_flag_vulcanize = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;

                            if (nodeShop_Systems.childNodes[j].nodeName === 'logo') xml_logo = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'display_address') xml_display_address = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'display_text') xml_display_text = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'flag_active') xml_flag_active= nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;

                        } // nodeType = ELEMENT_NODE
                    } // end for (j);
                  //alert (xml_id_shop_system + " :: " + xml_shop_name + " :: " + xml_shop_code);
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
                     td[0].setAttribute('data-label', 'Shop ID:');

                     td[0].innerHTML = '';

                     td[0].innerHTML += '<div><span style="font-weight: 600; color: crimson;">' + xml_id_shop_system + '</span></div>';

                     //---------------------------------------------------------------------//

                     td[1] = document.createElement('td');
                     td[1].setAttribute('bgcolor', bgcolor_row);
                     td[1].setAttribute('valign', 'top');
                     td[1].setAttribute('data-label', 'Name');

                     td[1].innerHTML = '';
                     if (xml_shop_code == "") {
                        td[1].innerHTML += '<div style="color: #004465;"><strong>' + utf8Decode(xml_shop_name) + '</strong></div>';
                     } else {
                        td[1].innerHTML += '<div style="color: #004465;"><strong>' + utf8Decode(xml_shop_name) + '</strong> (' + utf8Decode(xml_shop_code )+ ')</div>';
                     }
                
                     //---------------------------------------------------------------------//

                     td[3] = document.createElement('td');
                     td[3].setAttribute('bgcolor', bgcolor_row);
                     td[3].setAttribute('valign', 'top');
                     td[3].setAttribute('data-label', 'Shop Code');

                     td[3].innerHTML = '';
                     td[3].innerHTML += '<div><strong>' + xml_shop_code + '</strong></div>';
                    

                     //---------------------------------------------------------------------//

                     td[4] = document.createElement('td');
                     td[4].setAttribute('bgcolor', bgcolor_row);
                     td[4].setAttribute('valign', 'top');
                     td[4].setAttribute('data-label', 'Active');

                     td[4].innerHTML = '';
                     td[4].innerHTML += '<p style="margin: 1px 0; color: #1779ba; text-align: center;"><span>' + ((xml_flag_active == 1) ? '<?php echo $UTIL->IMG_Activated(15, 15); ?>' : '<?php echo $UTIL->IMG_Deactivated(15, 15); ?>') + '</span></p>';

                     //---------------------------------------------------------------------//

                     td[5] = document.createElement('td');
                     td[5].setAttribute('bgcolor', bgcolor_row);
                     td[5].setAttribute('valign', 'top');
                     td[5].setAttribute('data-label', '***');

                     innerHTML = '';
                     innerHTML += '<div>';
                     innerHTML += ' <a class="table-btn" onclick="Open_Shop_System_Reveal(' + xml_id_shop_system + ')"><i class="fa fa-edit action-controls" title="Edit Record"></i></a>';
                     innerHTML += ' <a class="table-btn" style="border: 1px solid #ffae00; color: #ffae00;" onclick="REST_Shop_Systems_Delete (' + xml_id_shop_system + ')"><i class="fa fa-trash action-controls" title="Delete Record"></i></a>';
                     innerHTML += ' <a class="table-btn" onclick="Toggle_Detail(this, ' + xml_id_shop_system + ');" ><i class="fas fa-chevron-down" title="Show Detail"></i></a>';
                     innerHTML += '</div>';
                     td[5].innerHTML = innerHTML;

                     //---------------------------------------------------------------------//   

                     var tr_labels = document.createElement('tr');
                     tbody_Overview.appendChild(tr_labels);
                     tr_labels.className = 'table-expand-row-content';
                     tr_labels.setAttribute('style', 'border: 2px solid #788A8F;');
                     tr_labels.id = 'label_content_' + xml_id_shop_system;


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

                    innerHTML += '      <p style="padding-left: 10px; margin: 0;"><span>' + utf8Decode(xml_display_address) + '</span></p>';

                    innerHTML += '    </div>';
                    innerHTML += '    <div class="small-12 medium-6 large-6 columns">';
                    innerHTML += '      <p style="margin-bottom: 0px; font-size: 0.875rem; font-weight: 600; color: #004465;">Display Text:</p>';
                    innerHTML += '      <p style="padding-left: 10px; margin: 0;"><span>' + utf8Decode(xml_display_text) + '</span></p>';
                    innerHTML += '    </div>';
                    innerHTML += '</div>';

                     td_labels.innerHTML = innerHTML;
                     //td_labels.appendChild(sendungsdaten_Liste_ul);


                     //---------------------------------------------------------------------//

                     tr.appendChild(td[0]);
                     tr.appendChild(td[1]);
                     //tr.appendChild(td[2]);
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

     xmlhttp.open("POST", encodeURI("/api/xml/v1/shop_systems_list.php?"), true);
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
   } // end REST_Shop_Systems_list();

   function REST_Shop_Systems_load(var_id_shop_system) {
        console.log('REST_Shop_Systems_load()');

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

                var nodeShop_Systems_List = xmlhttp.responseXML.getElementsByTagName("shop_systems_list");
                // alert(nodeShop_Systems_List[0].childNodes.length);
                for (var i = 0; i < nodeShop_Systems_List[0].childNodes.length; i++) {
                    // alert('NodeName: ' + nodeShop_Systems_List[0].childNodes[i].nodeName + ' | NodeType:' + nodeShop_Systems_List[0].childNodes[i].nodeType);
                    if (nodeShop_Systems_List[0].childNodes[i].nodeType == 1) {
                        var nodeShop_Systems = nodeShop_Systems_List[0].childNodes[i];
                        // alert(nodeShop_Systems.childNodes.length);

                        var xml_id_shop_system = 0,
                        xml_shop_name = '',
                        xml_shop_code = '',

                        xml_flag_visual_defects = 0,
                        xml_flag_brakes = 0,
                        xml_flag_extrapolation = 0,
                        xml_flag_suspension_side_slip = 0,
                        xml_flag_headlight = 0,
                        xml_flag_emission = 0,
                        xml_flag_alignment = 0,
                        xml_flag_vulcanize = 0,

                        xml_logo = '',
                        xml_display_address = '',
                        xml_display_text = '',
                        xml_flag_active = 0;



                        for (var j = 0; j < nodeShop_Systems.childNodes.length; j++) {
                            if (nodeShop_Systems.childNodes[j].nodeType == 1) {
                                // alert("NodeName: " + nodeShop_Systems.childNodes[j].nodeName + " | NodeType:" + nodeShop_Systems.childNodes[j].nodeType + " | NodeValue: " +  nodeShop_Systems.childNodes[j].childNodes[0].nodeValue); 
                                if (nodeShop_Systems.childNodes[j].nodeName === 'id_shop_system') xml_id_shop_system = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                                if (nodeShop_Systems.childNodes[j].nodeName === 'shop_name') xml_shop_name = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                                if (nodeShop_Systems.childNodes[j].nodeName === 'shop_code') xml_shop_code = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;

                                if (nodeShop_Systems.childNodes[j].nodeName === 'flag_visual_defects') xml_flag_visual_defects = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                                if (nodeShop_Systems.childNodes[j].nodeName === 'flag_brakes') xml_flag_brakes = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                                if (nodeShop_Systems.childNodes[j].nodeName === 'flag_extrapolation') xml_flag_extrapolation = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                                if (nodeShop_Systems.childNodes[j].nodeName === 'flag_suspension_side_slip') xml_flag_suspension_side_slip = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                                if (nodeShop_Systems.childNodes[j].nodeName === 'flag_headlight') xml_flag_headlight = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                                if (nodeShop_Systems.childNodes[j].nodeName === 'flag_emission') xml_flag_emission = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                                if (nodeShop_Systems.childNodes[j].nodeName === 'flag_alignment') xml_flag_alignment = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                                if (nodeShop_Systems.childNodes[j].nodeName === 'flag_vulcanize') xml_flag_vulcanize = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;

                                if (nodeShop_Systems.childNodes[j].nodeName === 'logo') xml_logo = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                                if (nodeShop_Systems.childNodes[j].nodeName === 'display_address') xml_display_address = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                                if (nodeShop_Systems.childNodes[j].nodeName === 'display_text') xml_display_text = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                                if (nodeShop_Systems.childNodes[j].nodeName === 'flag_active') xml_flag_active= nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;

                           } // nodeType = ELEMENT_NODE
                        } // end for (j);
                        //alert (xml_id_shop_system + " :: "  + xml_shop_name + " :: " + xml_shop_code);
                        //

                        //Reveal controls
                        id_shop_system_hidden.value = xml_id_shop_system;
                        rEVEAL_text_id_shop_system.value = xml_id_shop_system;
                        rEVEAL_text_shop_name.value = utf8Decode(xml_shop_name);
                        rEVEAL_text_shop_code.value = utf8Decode(xml_shop_code);
                        SELECT_Option(rEVEAL_select_flag_active, xml_flag_active);

                        rEVEAL_flag_visual_defects.checked = parseInt(xml_flag_visual_defects, 10);
                        rEVEAL_flag_visual_defects.value = parseInt(xml_flag_visual_defects, 10);

                        rEVEAL_flag_brakes.checked = parseInt(xml_flag_brakes, 10);
                        rEVEAL_flag_brakes.value = parseInt(xml_flag_brakes, 10);

                        rEVEAL_flag_extrapolation.checked = parseInt(xml_flag_extrapolation, 10);
                        rEVEAL_flag_extrapolation.value = parseInt(xml_flag_extrapolation, 10);

                        rEVEAL_flag_suspension_side_slip.checked = parseInt(xml_flag_suspension_side_slip, 10);
                        rEVEAL_flag_suspension_side_slip.value = parseInt(xml_flag_suspension_side_slip, 10);

                        rEVEAL_flag_headlight.checked = parseInt(xml_flag_headlight, 10);
                        rEVEAL_flag_headlight.value = parseInt(xml_flag_headlight, 10);

                        rEVEAL_flag_emission.checked = parseInt(xml_flag_emission, 10);
                        rEVEAL_flag_emission.value = parseInt(xml_flag_emission, 10);

                        rEVEAL_flag_alignment.checked = parseInt(xml_flag_alignment, 10);
                        rEVEAL_flag_alignment.value = parseInt(xml_flag_alignment, 10);

                        rEVEAL_flag_vulcanize.checked = parseInt(xml_flag_vulcanize, 10);
                        rEVEAL_flag_vulcanize.value = parseInt(xml_flag_vulcanize, 10);

                        rEVEAL_text_display_address.value = utf8Decode(xml_display_address);
                        rEVEAL_text_display_text.value = utf8Decode(xml_display_text);
                        //
                    } // end if (node_Liste);
                } // end for (i);

                //SpinnerStop(false);
            } // end if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
        } // end onreadystatechange
        xmlhttp.ontimeout = function() {
            SpinnerStop(false);
        }

        xmlhttp.open("POST", encodeURI("/api/xml/v1/shop_systems_list.php?"), true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.timeout = 120000; // time in milliseconds
        //
        post_parameters = GetAPIAccess();
        post_parameters += "&id_shop_system=" + var_id_shop_system;

        // alert(post_parameters);
        console.log(post_parameters);
        //  
        xmlhttp.send(post_parameters);

        return;
    } // end REST_Shop_Systems_load();

   function Helper_Shop_Systems_Edit() {
      console.log("Helper_Shop_Systems_Edit()");

      var fehler = false;

      //
      // Form Eingaben validieren (Hard errors!)
      //
      if (rEVEAL_text_shop_name.value == "") {
         Callout_Meldung(callout_liste_reveal_shop_systems, CALLOUT_ALERT, '<a href="#" onClick="Helper_Shop_Systems_Focus(text_shop_name);">Shop name empty.</a>', true, 30000);
         fehler = true;
      }

      // if (m_name_auftrag_bearbeiten.value == "") {
      //    Callout_Meldung(callout_liste_reveal_shop_systems, CALLOUT_ALERT, '<a href="#" onClick="Helper_Shop_Systems_Focus(m_name_auftrag_bearbeiten);">Name nicht angegeben.</a>', true, 30000);
      //    fehler = true;
      // }

      // if (m_hausnr_auftrag_bearbeiten.value == "") {
      //    Callout_Meldung(callout_liste_reveal_shop_systems, CALLOUT_ALERT, '<a href="#" onClick="Helper_Shop_Systems_Focus(m_hausnr_auftrag_bearbeiten);">Hausnr. nicht angegeben.</a>', true, 30000);
      //    fehler = true;
      // }

      // if (m_strasse_auftrag_bearbeiten.value == "") {
      //    Callout_Meldung(callout_liste_reveal_shop_systems, CALLOUT_ALERT, '<a href="#" onClick="Helper_Shop_Systems_Focus(m_strasse_auftrag_bearbeiten);">Strasse nicht angegeben.</a>', true, 30000);
      //    fehler = true;
      // }

      if (fehler == false) {
         // Auftrag erstellen / speichern
         REST_Shop_Systems_Save(id_shop_system_hidden.value);
      }

      return;
   } // end Helper_Shop_Systems_Edit();

   function Helper_Shop_Systems_Focus(elem_focus) {
      console.log("Helper_Shop_Systems_Focus()");

      if (elem_focus != null) elem_focus.focus();
   } // end Helper_Shop_Systems_Focus();

   function REST_Shop_Systems_Delete(var_id_shop_system) {
        console.log("REST_Shop_Systems_Delete()");

        //Validate Adressbuch data 
        if (var_id_shop_system != "0") {
            if (confirm("Do you really want to delete record " + var_id_shop_system + "?") == false) return;
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

                var node_Liste = xmlhttp.responseXML.getElementsByTagName("shop_systems");
                // alert(node_Liste[0].childNodes.length);
                var xml_id_shop_system = 0;

                for (var i = 0; i < node_Liste[0].childNodes.length; i++) {
                   // alert('NodeName: ' + node_Liste[0].childNodes[i].nodeName + ' | NodeType:' + node_Liste[0].childNodes[i].nodeType);
                   if (node_Liste[0].childNodes[i].nodeType == 1) {
                      if (node_Liste[0].childNodes[i].nodeName === "id_shop_system") xml_id_shop_system = node_Liste[0].childNodes[i].childNodes[0].nodeValue;
                   } // end if (nodeType == 1);
                } // end for (i);

                if (parseInt(xml_id_shop_system) > -1) { 

                    // Liste neu laden
                    REST_Shop_Systems_list(0, myTable_offset.value, myTable_limit.value);
                } else {
                    //Callout_Meldung(callout_liste_reveal_customer, CALLOUT_ALERT, "Error saving!", true, 20000);
                }

            } // end if (xmlhttp.readyState === 4 && xmlhttp.status === ABC);
        }; // end onreadystatechange();

        var post_parameters = GetAPIAccess();

        post_parameters += "&id_shop_system=" + var_id_shop_system;
        post_parameters += "&action=delete";//delete or update
        //

        xmlhttp.open("POST", encodeURI("/api/xml/v1/shop_systems_create_update.php?"), true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.timeout = 120000; // time in milliseconds
        //
        // alert(post_parameters);
        console.log("/api/xml/v1/shop_systems_create_update.php?" + post_parameters);
        //  
        xmlhttp.send(post_parameters);

        return;
    } // end REST_Shop_Systems_Delete();

   function REST_Shop_Systems_Save() {
      console.log("REST_Shop_Systems_Save()");

      //Validate Adressbuch data 
      if (id_shop_system_hidden.value != "0") {
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
         Callout_Meldung(callout_liste_reveal_shop_systems, CALLOUT_ALERT, "Save: Network connection timed out!", true, 0);
      };

      xmlhttp.onreadystatechange = function() {
         if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var str = xmlhttp.responseText;
            // alert(str);
            console.log(xmlhttp.responseXML);

            var node_Liste = xmlhttp.responseXML.getElementsByTagName("shop_systems");
            // alert(node_Liste[0].childNodes.length);
            var xml_id_shop_system = 0;

            for (var i = 0; i < node_Liste[0].childNodes.length; i++) {
               // alert('NodeName: ' + node_Liste[0].childNodes[i].nodeName + ' | NodeType:' + node_Liste[0].childNodes[i].nodeType);
               if (node_Liste[0].childNodes[i].nodeType == 1) {
                  if (node_Liste[0].childNodes[i].nodeName === "id_shop_system") xml_id_shop_system = node_Liste[0].childNodes[i].childNodes[0].nodeValue;
                  // if (node_Liste[0].childNodes[i].nodeName === 'fehlercode') xml_fehlercode = node_Liste[0].childNodes[i].childNodes[0].nodeValue;
               } // end if (nodeType == 1);
            } // end for (i);

            //alert(xml_id_shop_system);

            if (parseInt(xml_id_shop_system) > -1) {

               id_shop_system_hidden.value = parseInt(xml_id_shop_system);

               // Liste neu laden
               REST_Shop_Systems_list(0, myTable_offset.value, myTable_limit.value);
               Close_Shop_System_Reveal();

            } else {
               Callout_Meldung(callout_liste_reveal_shop_systems, CALLOUT_ALERT, "Error saving!", true, 20000);
            }

         } // end if (xmlhttp.readyState === 4 && xmlhttp.status === ABC);
      }; // end onreadystatechange();

      var post_parameters = GetAPIAccess();

      if (id_shop_system_hidden.value == 0) {
         post_parameters += "&id_shop_system=" + id_shop_system_hidden.value; //Create
      } else {
         post_parameters += "&id_shop_system=" + id_shop_system_hidden.value; //Update
      }
      //

      if (id_shop_system_hidden != null) post_parameters += '&id_shop_system=' + id_shop_system_hidden.value;
      if (rEVEAL_text_shop_name != null) post_parameters += '&shop_name=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_shop_name.value);
      if (rEVEAL_text_shop_code != null) post_parameters += '&shop_code=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_shop_code.value);

      if (rEVEAL_flag_visual_defects != null) post_parameters += '&flag_visual_defects=' + rEVEAL_flag_visual_defects.value;
      if (rEVEAL_flag_brakes != null) post_parameters += '&flag_brakes=' + rEVEAL_flag_brakes.value;
      if (rEVEAL_flag_extrapolation != null) post_parameters += '&flag_extrapolation=' + rEVEAL_flag_extrapolation.value;
      if (rEVEAL_flag_suspension_side_slip != null) post_parameters += '&flag_suspension_side_slip=' + rEVEAL_flag_suspension_side_slip.value;
      if (rEVEAL_flag_headlight != null) post_parameters += '&flag_headlight=' + rEVEAL_flag_headlight.value;
      if (rEVEAL_flag_emission != null) post_parameters += '&flag_emission=' + rEVEAL_flag_emission.value;
      if (rEVEAL_flag_alignment != null) post_parameters += '&flag_alignment=' + rEVEAL_flag_alignment.value;
      if (rEVEAL_flag_vulcanize != null) post_parameters += '&flag_vulcanize=' + rEVEAL_flag_vulcanize.value;

      if (rEVEAL_text_display_address != null) post_parameters += '&display_address=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_display_address.value);
      if (rEVEAL_text_display_text != null) post_parameters += '&display_text=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_display_text.value);
      if (rEVEAL_select_flag_active != null) post_parameters += "&flag_active=" + rEVEAL_select_flag_active.value;
     

      xmlhttp.open("POST", encodeURI("/api/xml/v1/shop_systems_create_update.php?"), true);
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.timeout = 120000; // time in milliseconds
      //
      // alert(post_parameters);
      console.log("/api/xml/v1/shop_systems_create_update.php?" + post_parameters);
      //  
      xmlhttp.send(post_parameters);

      return;
   } // end REST_Shop_Systems_Save();

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