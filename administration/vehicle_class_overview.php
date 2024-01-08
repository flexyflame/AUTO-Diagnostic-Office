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

    $vehicle_class_id = 0;
    if (isset($_REQUEST['vehicle_class_id'])) { $vehicle_class_id = $_REQUEST['vehicle_class_id']; }

?>

<article>
    <div class="main-page" style="min-height: 660px; border: 1px solid #4c9cb4; border-radius: 10px; margin-bottom: 10px; max-width: 1260px;">
        <div class="container-fluid">
            <div class="row">
                 <div class="small-12 medium-8 large-10 columns" style="border-bottom: 1px solid #4c9cb4; margin: 0px -10px 0px 10px;">
                    <h2 class="title" style="margin: 5px 0 0 0;">Manage Vehicle Class</h2>
                </div>
                
            </div> 
        </div>

        <div class="container-fluid">
            <div style="margin-top: 5px;">
                <ul class="accordion" data-accordion data-allow-all-closed="true" style="margin: 10px 25px">
                  <li class="accordion-item" data-accordion-item>
                    <!-- Accordion tab title -->
                    <a href="#" class="accordion-title" style="padding: 15px 20px;">Advance Filter</a>
                    <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                    <div class="accordion-content" data-tab-content style="padding: 5px;">
                        <div class="filter-cover">
                            <div class="row">
                                <div class="small-12 medium-4 large-4 columns">
                                    <label for="text_vehicle_class_id_filter" class="left inline">Vehicle Class ID:</label>
                                    <input name="text_vehicle_class_id_filter" type="text" id="text_vehicle_class_id_filter" placeholder="Vehicle Class ID" oninput="Filter_Reload();" />
                                </div>

                                <div class="small-12 medium-4 large-4 columns">
                                    <label for="text_name_filter" class="left inline">Name:</label>
                                    <input name="text_name_filter" type="text" id="text_name_filter" placeholder="Name" oninput="Filter_Reload();"/>
                                </div>
                            </div>
                        </div>
                    </div>
                  </li>
                </ul>
            </div>
        </div>

        <!-- content rows -->
        <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" style="overflow: auto;" id="form_vehicle_class_overview" name="form_vehicle_class_overview" method="post">
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

                    <a class="button small btn-Table" title="Add Record" onclick="Open_Vehicle_Class_Reveal();"><i class="fas fa-plus-square" aria-hidden="true"></i></a>
                </div>

                <div class="large-12 small-centered columns" style="padding: 0px;">
                    <table class="responsive-card-table  table-expand hover" id="myTable">  
                        <thead>
                            <th width="10%">ID</th>
                            <th width="75%">Name</th>
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

    <!--Vehicle_Class Edit Reveal-->
    <div class="reveal large" id="reveal_vehicle_class_edit" name="reveal_vehicle_class_edit" data-reveal data-close-on-click="false" style="padding: 1rem; border: 2px solid #607D8B; border-radius: 15px;">
        <fieldset style="padding: 0; border: 0;">

            <div class="mobile-nav-bar title-bar" style="background-color: #567a92; margin-bottom: 15px; padding: 5px 10px;">
                <div class="title-bar-left">
                    <button class="menu-icon" type="button"></button>
                </div>
                <div class="title-bar-center">
                    <span id="reveal_vehicle_class_header_text">Create New User</span>
                </div>
                <div class="title-bar-right">
                    <button class="menu-icon" type="button"></button>
                </div>
            </div>

            <div id="callout_liste_reveal_vehicle_class"></div>


            <form id="form_reveal_vehicle_class" name="form_reveal_vehicle_class" style="margin: 0px; box-shadow: unset;">
                <div class="row">
                    <div class="small-12 medium-12 large-12 columns">
                        <div class="row">
                            <div class="small-4 medium-2 large-2 columns">
                                <label for="text_vehicle_class_id" class="left inline">Vehicle Class ID:</label>
                                <input name="text_vehicle_class_id" type="text" id="text_vehicle_class_id" placeholder="Vehicle Class ID" value="" readonly />
                            </div>
                            <div class="small-8 medium-10 large-10 columns">
                                <label for="text_name" class="left inline">Name:</label>
                                <input name="text_name" type="text" id="text_name" placeholder="Name" value="" />
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="small-12 medium-2 large-2 columns"></div>
                    <div class="small-12 medium-8 large-8 columns" style="border-top: dashed 1px #165366;">
                        <div class="button-group-option" data-grouptype="OR" style="margin: 5px 0px; padding: 0px;">
                            <a class="button alert radius" style="padding: 10px;" id="btn_abbrechen" name="btn_abbrechen" onclick="Close_Vehicle_Class_Reveal();">Cancel</a>
                            <a class="button warning radius" style="padding: 10px;" id="btn_speichern" name="btn_speichern" onclick="Helper_Vehicle_Class_Edit();" data-element-index="10">Save</a>
                        </div>
                    </div>
                    <div class="small-12 medium-2 large-2 columns"></div>
                </div>
            </form>
        </fieldset>
    </div>

    <!-------Hidden controls--------->
   <div class="hidden-controls">
      <input type="hidden" id="vehicle_class_id_hidden" value="0" />
   </div>

</article>

<!--Include Nav_Footer and Footer-->
<?php 
    $path = $_SERVER['DOCUMENT_ROOT'] ;
    include ($path . "/includes/nav_footer.php");
    include ($path . "/includes/footer.php");
?>


<script type="text/javascript">
    
    var text_vehicle_class_id_filter = document.getElementById("text_vehicle_class_id_filter");
    var text_name_filter = document.getElementById("text_name_filter");

    //Reveal controls
    var reveal_vehicle_class_header_text = document.getElementById("reveal_vehicle_class_header_text");
    var vehicle_class_id_hidden = document.getElementById("vehicle_class_id_hidden");
    var callout_liste_reveal_vehicle_class = document.getElementById("callout_liste_reveal_vehicle_class");

    var rEVEAL_text_vehicle_class_id = document.getElementById("text_vehicle_class_id");
    var rEVEAL_text_name = document.getElementById("text_name");
    
    var myTable_limit = document.getElementById("myTable_limit");
    var myTable_offset = document.getElementById("myTable_offset");

    addLoadEvent(REST_Vehicle_Class_list(0, 0, myTable_limit.value));

    $("#reveal_vehicle_class_edit").on("open.zf.reveal", function () {
        console.log("reveal_vehicle_class_edit: open.zf.reveal");

        $("#form_reveal_vehicle_class")[0].reset();

        callout_liste_reveal_vehicle_class.innerHTML = "";

        if (vehicle_class_id_hidden.value != 0) {
            reveal_vehicle_class_header_text.innerText = "Edit Vehicle Class (" + vehicle_class_id_hidden.value + ")";

            REST_Vehicle_Class_load(vehicle_class_id_hidden.value)

        } else {
            reveal_vehicle_class_header_text.innerText = "Create New Vehicle Class";
        }

    });

    function Filter_Reload() {
        REST_Vehicle_Class_list(0, 0, myTable_limit.value);
    }

    function Close_Vehicle_Class_Reveal() {
        console.log('Close_Vehicle_Class_Reveal()');

        $('#reveal_vehicle_class_edit').foundation('close');
    } //end Close_Vehicle_Class_Reveal();

    function Open_Vehicle_Class_Reveal (var_vehicle_class_id = 0) {
        console.log('Open_Vehicle_Class_Reveal('+var_vehicle_class_id+')');

        vehicle_class_id_hidden.value = var_vehicle_class_id;

        $('#reveal_vehicle_class_edit').foundation('open');

        return;
    } //end Open_Vehicle_Class_Reveal();

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
            li.innerHTML = '<a class="class_spinner_id" onclick="REST_Vehicle_Class_list(' + query_total + ', ' + ((current_page - 1) * query_limit) + ', ' + query_limit + ');">&laquo;</a>';
            ul_pagenav.appendChild(li);
        }

        // Seitenanzeige aufbauen
        if (show_num_pages < num_pages) { // mehr Seiten als "Anzahl-Seiten" vorhanden
            if (current_page > show_num_pages_half) {
                // Seite 1 ...
                li = document.createElement('li');
                li.className = 'arrow';
                li.innerHTML = '<a class="class_spinner_id" onclick="REST_Vehicle_Class_list(' + query_total + ', ' + (0 * query_limit) + ', ' + query_limit + ');">1</a>';
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
                    li.innerHTML = '<a class="class_spinner_id" onclick="REST_Vehicle_Class_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
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
                    li.innerHTML = '<a class="class_spinner_id" onclick="REST_Vehicle_Class_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
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
                    li.innerHTML = '<a class="class_spinner_id" onclick="REST_Vehicle_Class_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
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
                li.innerHTML = '<a class="class_spinner_id" onclick="REST_Vehicle_Class_list(' + query_total + ', ' + ((num_pages - 1) * query_limit) + ', ' + query_limit + ');">' + num_pages + '</a>';         
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
                li.innerHTML = '<a class="class_spinner_id" onclick="REST_Vehicle_Class_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
                ul_pagenav.appendChild(li);
            } // end for (i);
        } // end if (show_num_pages > num_pages);
        
        if (current_page < (num_pages - 1)) {
            li = document.createElement('li');
            li.className = 'arrow';
            li.innerHTML = '<a class="class_spinner_id" onclick="REST_Vehicle_Class_list(' + query_total + ', ' + ((current_page + 1) * query_limit) + ', ' + query_limit + ');">' + '&raquo;' + '</a>';      
            ul_pagenav.appendChild(li);     
        } // end if (current_page > 0)

        return;
    } // end PageNav();

    function REST_Vehicle_Class_list(query_total, query_offset, query_limit) {
        console.log('REST_Vehicle_Class_list()');

        //Keep query_offset and query_limit for refresh
        myTable_offset.value = query_offset;
        myTable_limit.value = query_limit;

        //Prepare Table Filter
        var zFilter_Param   = '&vehicle_class_id=' + text_vehicle_class_id_filter.value + '&name=' + text_name_filter.value;
        //alert(zFilter_Param);
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
                if (xmlhttp.responseXML == null) {
                    console.log('No data found!');
                    return;
                }

                tbody_Overview.innerHTML = '';

                var i_bgcolor = 0;

                var node_query_count = xmlhttp.responseXML.getElementsByTagName("query_count");
                var node_query_offset = xmlhttp.responseXML.getElementsByTagName("query_offset");
                var node_query_limit = xmlhttp.responseXML.getElementsByTagName("query_limit");
                var xml_query_count = node_query_count[0].childNodes[0].nodeValue;
                var xml_query_offset = node_query_offset[0].childNodes[0].nodeValue;
                var xml_query_limit = node_query_limit[0].childNodes[0].nodeValue;
                
                PageNav(7, xml_query_count, xml_query_offset, xml_query_limit); // (show_num_pages, query_total, query_offset, query_limit)

                var nodeVehicle_Class_List = xmlhttp.responseXML.getElementsByTagName("vehicle_class_list");
                // alert(nodeVehicle_Class_List[0].childNodes.length);
                for (var i = 0; i < nodeVehicle_Class_List[0].childNodes.length; i++) {
                    // alert("NodeName: " + nodeVehicle_Class_List[0].childNodes[i].nodeName + " | NodeType:" + nodeVehicle_Class_List[0].childNodes[i].nodeType); 
                    if (nodeVehicle_Class_List[0].childNodes[i].nodeType == 1) {
                        var nodeVehicle_Class = nodeVehicle_Class_List[0].childNodes[i];
                        // alert(nodeVehicle_Class.childNodes.length);

                        var xml_vehicle_class_id = 0,
                            xml_name = '';

                        for (var j = 0; j < nodeVehicle_Class.childNodes.length; j++) {
                            if (nodeVehicle_Class.childNodes[j].nodeType == 1) {
                                // alert("NodeName: " + nodeVehicle_Class.childNodes[j].nodeName + " | NodeType:" + nodeVehicle_Class.childNodes[j].nodeType + " | NodeValue: " +  nodeVehicle_Class.childNodes[j].childNodes[0].nodeValue); 
                                if (nodeVehicle_Class.childNodes[j].nodeName === 'vehicle_class_id') xml_vehicle_class_id = nodeVehicle_Class.childNodes[j].childNodes[0].nodeValue;
                                if (nodeVehicle_Class.childNodes[j].nodeName === 'name') xml_name = nodeVehicle_Class.childNodes[j].childNodes[0].nodeValue;

                            } // nodeType = ELEMENT_NODE
                        } // end for (j);
                        //alert (xml_vehicle_class_id + " :: " + xml_name);
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
                        td[0].setAttribute('data-label', 'Vehicle Class ID:');

                        td[0].innerHTML = '';

                        td[0].innerHTML += '<div><span style="font-weight: 600; color: crimson;">' + xml_vehicle_class_id + '</span></div>';

                        //---------------------------------------------------------------------//

                        td[1] = document.createElement('td');
                        td[1].setAttribute('bgcolor', bgcolor_row);
                        td[1].setAttribute('valign', 'top');
                        td[1].setAttribute('data-label', 'Name');

                        td[1].innerHTML = '';
                        td[1].innerHTML += '<div><span style="font-weight: 600; color: #004465;">' + utf8Decode(xml_name) + '</span></div>';

                        //---------------------------------------------------------------------//

                        td[2] = document.createElement('td');
                        td[2].setAttribute('bgcolor', bgcolor_row);
                        td[2].setAttribute('valign', 'top');
                        td[2].setAttribute('data-label', '***');

                        innerHTML = '';
                        innerHTML += '<div style="text-align: right;">';
                        innerHTML += ' <a class="table-btn" onclick="Open_Vehicle_Class_Reveal(' + xml_vehicle_class_id + ')"><i class="fa fa-edit action-controls" title="Edit Record"></i></a>';
                        innerHTML += ' <a class="table-btn" style="border: 1px solid #ffae00; color: #ffae00;" onclick="REST_Vehicle_Class_Delete (' + xml_vehicle_class_id + ')"><i class="fa fa-trash action-controls" title="Delete Record"></i></a>';
                        innerHTML += ' <a class="table-btn" onclick="Toggle_Detail(this, ' + xml_vehicle_class_id + ');" ><i class="fas fa-chevron-down" title="Show Detail"></i></a>';
                        innerHTML += '</div>';
                        td[2].innerHTML = innerHTML;


                        //---------------------------------------------------------------------//   

                        var tr_labels = document.createElement('tr');
                        tbody_Overview.appendChild(tr_labels);
                        tr_labels.className = 'table-expand-row-content';
                        tr_labels.setAttribute('style', 'border: 2px solid #788A8F;');
                        tr_labels.id = 'label_content_' + xml_vehicle_class_id;


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

                        innerHTML += '      <p style="padding-left: 10px; margin: 0;"><span>Test Data</span></p>';
                       
                        innerHTML += '    </div>';
                        innerHTML += '    <div class="small-12 medium-6 large-6 columns">';
                        innerHTML += '      <p style="margin-bottom: 0px; font-size: 0.875rem; font-weight: 600; color: #004465;">Details:</p>';

                        innerHTML += '      <p style="padding-left: 10px; margin: 0;"><b>Date: </b><span>AAAA</span><b style="margin-left:4em;">Sales Rep.: </b><span>CCCCC</span></p>';
                        innerHTML += '      <p style="padding-left: 10px; margin: 0;"><b>Background_Info: </b><br><span>BBBBB</span></p>';
                        innerHTML += '    </div>';
                        innerHTML += '</div>';

                        td_labels.innerHTML = innerHTML;
                        //---------------------------------------------------------------------//

                        tr.appendChild(td[0]);
                        tr.appendChild(td[1]);
                        tr.appendChild(td[2]);

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

        xmlhttp.open("POST", encodeURI("/api/xml/v1/vehicle_class_list.php?"), true);
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
    } // end REST_Vehicle_Class_list();

    function REST_Vehicle_Class_load(var_vehicle_class_id) {
        console.log('REST_Vehicle_Class_load()');

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

                var nodeVehicle_Class_List = xmlhttp.responseXML.getElementsByTagName("vehicle_class_list");
                // alert(nodeVehicle_Class_List[0].childNodes.length);
                for (var i = 0; i < nodeVehicle_Class_List[0].childNodes.length; i++) {
                    // alert("NodeName: " + nodeVehicle_Class_List[0].childNodes[i].nodeName + " | NodeType:" + nodeVehicle_Class_List[0].childNodes[i].nodeType); 
                    if (nodeVehicle_Class_List[0].childNodes[i].nodeType == 1) {
                        var nodeVehicle_Class = nodeVehicle_Class_List[0].childNodes[i];
                        // alert(nodeVehicle_Class.childNodes.length);

                        var xml_vehicle_class_id = 0,
                            xml_name = '';

                        for (var j = 0; j < nodeVehicle_Class.childNodes.length; j++) {
                            if (nodeVehicle_Class.childNodes[j].nodeType == 1) {
                                // alert("NodeName: " + nodeVehicle_Class.childNodes[j].nodeName + " | NodeType:" + nodeVehicle_Class.childNodes[j].nodeType + " | NodeValue: " +  nodeVehicle_Class.childNodes[j].childNodes[0].nodeValue); 
                                if (nodeVehicle_Class.childNodes[j].nodeName === 'vehicle_class_id') xml_vehicle_class_id = nodeVehicle_Class.childNodes[j].childNodes[0].nodeValue;
                                if (nodeVehicle_Class.childNodes[j].nodeName === 'name') xml_name = nodeVehicle_Class.childNodes[j].childNodes[0].nodeValue;

                            } // nodeType = ELEMENT_NODE
                        } // end for (j);
                        //alert (xml_vehicle_class_id + " :: " + login + " :: " + xml_name + " :: " + firstname + " :: " + email);
                        //
                        //Reveal controls
                        vehicle_class_id_hidden.value = xml_vehicle_class_id;
                        rEVEAL_text_vehicle_class_id.value = xml_vehicle_class_id;
                        rEVEAL_text_name.value = utf8Decode(xml_name);
                        //
                    } // end if (node_Liste);
                } // end for (i);

                //SpinnerStop(false);
            } // end if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
        } // end onreadystatechange
        xmlhttp.ontimeout = function() {
            SpinnerStop(false);
        }

        xmlhttp.open("POST", encodeURI("/api/xml/v1/vehicle_class_list.php?"), true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.timeout = 120000; // time in milliseconds
        //
        post_parameters = GetAPIAccess();
        post_parameters += "&vehicle_class_id=" + var_vehicle_class_id;

        // alert(post_parameters);
        console.log(post_parameters);
        //  
        xmlhttp.send(post_parameters);

        return;
    } // end REST_Vehicle_Class_load();

    function REST_Vehicle_Class_Delete(var_vehicle_class_id) {
        console.log("REST_Vehicle_Class_Delete()");

        //Validate Adressbuch data 
        if (var_vehicle_class_id != "0") {
            if (confirm("Do you really want to delete record " + var_vehicle_class_id + "?") == false) return;
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

                var node_Liste = xmlhttp.responseXML.getElementsByTagName("vehicle_class");
                // alert(node_Liste[0].childNodes.length);
                var xml_vehicle_class_id = 0;

                for (var i = 0; i < node_Liste[0].childNodes.length; i++) {
                   // alert('NodeName: ' + node_Liste[0].childNodes[i].nodeName + ' | NodeType:' + node_Liste[0].childNodes[i].nodeType);
                   if (node_Liste[0].childNodes[i].nodeType == 1) {
                      if (node_Liste[0].childNodes[i].nodeName === "vehicle_class_id") xml_vehicle_class_id = node_Liste[0].childNodes[i].childNodes[0].nodeValue;
                   } // end if (nodeType == 1);
                } // end for (i);

                //alert(xml_vehicle_class_id);

                if (parseInt(xml_vehicle_class_id) > -1) { 

                    // Liste neu laden
                    REST_Vehicle_Class_list(0, myTable_offset.value, myTable_limit.value);
                } else {
                    //Callout_Meldung(callout_liste_reveal_customer, CALLOUT_ALERT, "Error saving!", true, 20000);
                }

            } // end if (xmlhttp.readyState === 4 && xmlhttp.status === ABC);
        }; // end onreadystatechange();

        var post_parameters = GetAPIAccess();

        post_parameters += "&vehicle_class_id=" + var_vehicle_class_id;
        post_parameters += "&action=delete";//delete or update
        //

        xmlhttp.open("POST", encodeURI("/api/xml/v1/vehicle_class_create_update.php?"), true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.timeout = 120000; // time in milliseconds
        //
        // alert(post_parameters);
        console.log("/api/xml/v1/vehicle_class_create_update.php?" + post_parameters);
        //  
        xmlhttp.send(post_parameters);

        return;
    } // end REST_Vehicle_Class_Delete();

    function REST_Vehicle_Class_Save() {
      console.log("REST_Vehicle_Class_Save()");

      //Validate Adressbuch data 
      if (vehicle_class_id_hidden.value != "0") {
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
         Callout_Meldung(callout_liste_reveal_vehicle_class, CALLOUT_ALERT, "Save: Network connection timed out!", true, 0);
      };

      xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var str = xmlhttp.responseText;
            // alert(str);
            console.log(xmlhttp.responseXML);

            var node_Liste = xmlhttp.responseXML.getElementsByTagName("vehicle_class");
            // alert(node_Liste[0].childNodes.length);
            var xml_vehicle_class_id = 0;

            for (var i = 0; i < node_Liste[0].childNodes.length; i++) {
                // alert('NodeName: ' + node_Liste[0].childNodes[i].nodeName + ' | NodeType:' + node_Liste[0].childNodes[i].nodeType);
                if (node_Liste[0].childNodes[i].nodeType == 1) {
                  if (node_Liste[0].childNodes[i].nodeName === "vehicle_class_id") xml_vehicle_class_id = node_Liste[0].childNodes[i].childNodes[0].nodeValue;
                  // if (node_Liste[0].childNodes[i].nodeName === 'fehlercode') xml_fehlercode = node_Liste[0].childNodes[i].childNodes[0].nodeValue;
                } // end if (nodeType == 1);
            } // end for (i);

            //alert(xml_vehicle_class_id);

            if (parseInt(xml_vehicle_class_id) > -1) {

               vehicle_class_id_hidden.value = parseInt(xml_vehicle_class_id);

               // Liste neu laden
               REST_Vehicle_Class_list(0, myTable_offset.value, myTable_limit.value);
               Close_Vehicle_Class_Reveal();

            } else {
               Callout_Meldung(callout_liste_reveal_vehicle_class, CALLOUT_ALERT, "Error saving!", true, 20000);
            }

        } // end if (xmlhttp.readyState === 4 && xmlhttp.status === ABC);
      }; // end onreadystatechange();

      var post_parameters = GetAPIAccess();

      if (vehicle_class_id_hidden.value == 0) {
         post_parameters += "&vehicle_class_id=" + vehicle_class_id_hidden.value; //Create
      } else {
         post_parameters += "&vehicle_class_id=" + vehicle_class_id_hidden.value; //Update
      }
      //
      if (rEVEAL_text_name != null) post_parameters += '&Name=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_name.value);

      xmlhttp.open("POST", encodeURI("/api/xml/v1/vehicle_class_create_update.php?"), true);
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.timeout = 120000; // time in milliseconds
      //
      // alert(post_parameters);
      console.log("/api/xml/v1/vehicle_class_create_update.php?" + post_parameters);
      //  
      xmlhttp.send(post_parameters);

      return;
   } // end REST_Vehicle_Class_Save();

    function Helper_Vehicle_Class_Edit() {
        console.log("Helper_Vehicle_Class_Edit()");

        var fehler = false;

        //
        // Form Eingaben validieren (Hard errors!)
        //
        if (rEVEAL_text_name.value == "") {
           Callout_Meldung(callout_liste_reveal_vehicle_class, CALLOUT_ALERT, '<a href="#" onClick="Helper_Vehicle_Class_Focus(rEVEAL_text_name);">Name empty.</a>', true, 30000);
           fehler = true;
        }

        if (fehler == false) {
         // Save user
         REST_Vehicle_Class_Save(vehicle_class_id_hidden.value);
        }

        return;
    } // end Helper_Vehicle_Class_Edit();

    function Helper_Vehicle_Class_Focus(elem_focus) {
      console.log("Helper_Vehicle_Class_Focus()");

      if (elem_focus != null) elem_focus.focus();
   } // end Helper_Vehicle_Class_Focus();

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