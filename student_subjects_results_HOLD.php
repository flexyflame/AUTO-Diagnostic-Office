<?php  
    $path = $_SERVER['DOCUMENT_ROOT'] ;
    $path .= "/includes/header.php";
    include ($path);
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/app-dashboard-header.php");

    //Page PHP -- Start--
    if (!isset($SESSION)) {
        die("SESSION Class not defined!");  
    }

    $page_titel = "Student Subjects Results Entry";

    $query_result_array = array();

    $aktion = "show";
    if (!empty($_REQUEST['page_aktion'])) { $aktion = $_REQUEST['page_aktion']; }

    $posted = FALSE;
    if (!empty($_REQUEST['posted_'])) { $posted = TRUE; }

    //echo $posted;

    $id_student = "";
    if (isset($_REQUEST['text_id_student'])) { $id_student = $_REQUEST['text_id_student']; }

    $select_subjectcode = "";
    if (isset($_REQUEST['select_subjectcode'])) { $select_subjectcode = $_REQUEST['select_subjectcode']; }

    $select_grade = "";
    if (isset($_REQUEST['select_grade'])) { $select_grade = $_REQUEST['select_grade']; }

    $text_room = "";
    if (isset($_REQUEST['text_room'])) { $text_room = $_REQUEST['text_room']; }

    $select_term = "";
    if (isset($_REQUEST['select_term'])) { $select_term = $_REQUEST['select_term']; }

    $select_sex = "";
    if (isset($_REQUEST['select_sex'])) { $select_sex = $_REQUEST['select_sex']; }

        $query_where_temp = " WHERE (1=1) ";

        if (!empty($id_student)) { $query_where_temp .= " AND (SS.id='" . $id_student . "') "; }
        if (!empty($select_subjectcode)) { $query_where_temp .= " AND (SS.subjectcode='" . $select_subjectcode . "') "; }
        if (!empty($select_grade)) { $query_where_temp .= " AND (SS.Grade='" . $select_grade . "') "; }
        if (!empty($text_room)) { $query_where_temp .= " AND (SS.Room='" . $text_room . "') "; }
        if (!empty($select_term)) { $query_where_temp .= " AND (SS.term='" . $select_term . "') "; } else { $query_where_temp .= " AND (SS.term='xx?!$$') "; }
        if (!empty($select_sex)) { $query_where_temp .= " AND (SS.sex=" . $select_sex . ") "; }
   
 
    if (strcmp($aktion, "show") == 0) {
        // Call Data
        $query_total = 0;
        $dbconn = DB_Connect_Direct();
        $query = "SELECT * FROM vwstudentsubjects AS SS " . $query_where_temp;
        $query .= "ORDER BY subjectcode ASC;";

        echo $query;

        $result = DB_Query($dbconn, $query);
        if ($result != false) {
            //
            $query_total = DB_NumRows($result); 

            while ($obj = DB_FetchObject($result)) { //Build Array from result
                $query_result_array[] = $obj;
            } // end while ($obj = DB_FetchObject($result));
                    
            $error_type = 'call_data_success';
            DB_FreeResult($result);
          
        } else { 
            $error_type = 'call_data_fail';
            print("Editing of subjects details failed");
        } // end if ($result != false);0     
        DB_Close($dbconn);
    }

?>

<div class="main-page" style="min-height: 660px; border: 1px solid #4c9cb4; border-radius: 10px; margin-bottom: 10px; max-width: 1260px;">
    <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" style="overflow: auto;" id="form_student_subjects" name="form_student_subjects" method="post">

        <div class="container-fluid">
            <div class="row">
                <div class="small-12 medium-6 large-6 columns">
                    <h4 class="title" style="margin-bottom: 0px;"><?php echo $page_titel; ?></h4>
                    <i>Enter Test & Exam Results, Assign Teachers and Update Comments...</i>
                </div>

                <div class="small-12 medium-6 large-6 columns" style="display: inline-flex; text-align: right;">
                    <div class="switch small hollow button primary" style="display: inline-table; padding: 5px 2px; width: 30%; margin: 15px 5px 5px;">
                        <input class="switch-input" id="cum100Switch" type="checkbox" value="FALSE" onclick="cum100Click();">
                        <label class="switch-paddle" for="cum100Switch" style="float: left;"></label>
                        <label style="color: #2ba6cb;">100% Test ON</label>
                    </div>

                    <div class="switch small hollow button primary" style="display: inline-table; padding: 5px 2px; width: 30%; margin: 15px 5px 5px;">
                        <input class="switch-input" id="exam100Switch" type="checkbox" value="FALSE" onclick="exam100Click();">
                        <label class="switch-paddle" for="exam100Switch" style="float: left;"></label>
                        <label style="color: #2ba6cb;">100% Exam ON</label>
                    </div>

                    <div style="width: 30%; margin: 15px 5px 5px;">
                        <button class="hollow button success" id="btn_LoadTermTest" style="margin-bottom: 0px;">Load Term Test</button>
                    </div>
                </div>
            </div>   
            <hr style="margin: 0px 30px 10px 25px; border-bottom: 1px solid #4c9cb4; max-width: initial;">   
        </div>

        <div class="row">
            <div class="small-4 medium-2 large-2 columns">
                <label for="select_term" class="left inline">School Term:</label>
                <?php
                    $open_academic = false;
                    $open_finance = false;

                    $term_selektiert = 0;
                    if (isset($select_term)) {
                        $term_selektiert = $select_term;
                    }
                    $select_id = "select_term";
                    $select_name = "select_term";
                    $select_size = 1;
                    $select_extra_code = '';
                    $db_conn_opt = false;
                    $arr_option_values = array('' => '');
                    echo $UTIL->SELECT_term($term_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt, $open_academic, $open_finance);
                ?>
            </div>

            <div class="small-4 medium-2 large-2 columns">
                <label for="select_subjectcode" class="left inline">Subject:</label>
                <?php
                    $subjectcode_selektiert = -1;
                    if (isset($select_subjectcode)) {
                        $subjectcode_selektiert = $select_subjectcode;
                    }
                    $select_id = "select_subjectcode";
                    $select_name = "select_subjectcode";
                    $select_size = 1;
                    $select_extra_code = '';
                    $arr_option_values = array('' => '');
                    echo $UTIL->SELECT_SubjectCode($subjectcode_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
                ?>
            </div>

            <div class="small-4 medium-2 large-2 columns">
                <label for="select_grade" class="left inline">Class:</label>
                <?php
                    $grade_selektiert = -1;
                    if (isset($select_grade)) {
                        $grade_selektiert = $select_grade;
                    }
                    $select_id = "select_grade";
                    $select_name = "select_grade";
                    $select_size = 1;
                    $select_extra_code = '';
                    $db_conn_opt = false;
                    $arr_option_values = array('' => '');
                    echo $UTIL->SELECT_Grade($grade_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
                ?>
            </div>

            <div class="small-4 medium-1 large-1 columns">
                <label for="text_room" class="left inline">Room:</label>
                <input name="text_room" type="text" id="text_room" placeholder="Room" value="<?php echo isset($text_room) ? $text_room : ''; ?>" />
            </div>

            <div class="small-4 medium-1 large-1 columns">
                <label for="select_sex" class="left inline">Sex:</label>
                <?php
                    $sex_selektiert = 0;
                    if (isset($select_sex)) {
                        $sex_selektiert = $select_sex;
                    }
                    $select_id = "select_sex";
                    $select_name = "select_sex";
                    $select_size = 1;
                    $select_extra_code = '';
                    $arr_option_values = array('' => 'Any');
                    echo $UTIL->SELECT_Sex($sex_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
                ?>
            </div>

            <div class="small-4 medium-2 large-2 columns">
                <label for="text_id_student" class="left inline">Student ID:</label>
                <input name="text_id_student" type="text" id="text_id_student" placeholder="Student ID" value="<?php echo isset($id_student) ? $id_student : ''; ?>" />
            </div>

            <div class="small-4 medium-2 large-2 columns" style="display: grid;">
                <button class="hollow button success" id="btn_GetStudent" type="submit"  style="margin: 19px 5px;">Get Students</button>

                <input name="page" type="hidden" id="page" value="student_subjects_results" />
                <input name="id_student" type="hidden" id="id_student" value="<?php if (isset($id_student)) echo $id_student; ?>" />
                <input name="page_aktion" type="hidden" id="page_aktion" value="show" />
                <input name="posted" type="hidden" id="posted" value="yes" />
            </div>
        </div>

        <div class="row" style="padding-top:5px">        
            <div class="large-12 small-centered columns" style="height: 500px; overflow: auto; background: #e6e6e6; padding-right: 0px; padding-left: 0px;">
                <table class="responsive-card-table  table-expand hover">  
                    <thead style="background: #cbe4ff;">
                        <th class="sub-table-th" width="8%"><span style="color: #607D8B;">ID.</span><br>Test %</th>
                        <th class="sub-table-th" width="10%"><span style="color: #607D8B;">Last Name</span><br><div><span class="cum100" style="display: none;">Test 100%</span></div></th>
                        <th class="sub-table-th" width="10%"><span style="color: #607D8B;">First Name</span><br>Test Mark</th>
                        <th class="sub-table-th" width="10%"><span style="color: #607D8B;">Other Name</span><br>Exam %</th>
                        <th class="sub-table-th" width="10%"><span style="color: #607D8B;">Code</span><br><span class="exam100" style="display: none;">Exam 100%</span></th>
                        <th class="sub-table-th" width="15%"><span style="color: #607D8B;">Description</span><br>Exam Mark</th>
                        <th class="sub-table-th" width="7%" style="color: #222;"><br>Pro-Rate</th>
                        <th class="sub-table-th" width="5%" style="color: #222;"><br>Total</th>
                        <th class="sub-table-th" width="5%" style="color: #222;"><br>Assess</th>
                        <th class="sub-table-th" width="5%" style="color: #222;"><br>Rank</th>
                        <th class="sub-table-th" width="5%" style="color: #222;"><br>Grade</th>
                        <th class="sub-table-th" width="5%" style="color: #222;"><br>Comment</th>
                        <th class="sub-table-th" width="5%" style="color: #222;"><br>Teacher</th>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($query_result_array as $obj) {
                                echo "<tr>";

                                echo "  <td valign=\"top\"data-label=\"ID:\">";
                                echo "     <div>";
                                echo "          <span style=\"color: crimson; font-weight: 700;\" id=\"id_" . $obj->id . "\">" . $obj->id . "</span>";
                                echo "     </div>";   
                                echo "     <div>";
                                echo "          <span id=\"val_test_" . $obj->id . "\">" . $obj->test . "</span"; 
                                echo "     </div>"; 
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Last Name:\">"; 
                                echo "     <div>";
                                echo "          <span style=\"color: #607D8B; \">" . $obj->lastname . "</span>";
                                echo "     </div>";   
                                echo "     <div class=\"cum100\" style=\"display: none;\">";
                                echo "          <input type=\"number\" class=\"input_result_entry\" id=\"text_cum100_" . $obj->id . "\" oninput=\"cum100_onInput('" . $obj->id . "');\" tabindex=\"\" min=\"0\" max=\"100\" value=\"" . $obj->cum100 . "\" />";
                                echo "     </div>"; 
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"First Name:\">";
                                echo "     <div>";
                                echo "          <span style=\"color: #607D8B; \">" . $obj->firstname . "</span>";
                                echo "     </div>";   
                                echo "     <div>";
                                echo "          <input type=\"number\" class=\"input_result_entry text_testresult\" id=\"text_testresult_" . $obj->id . "\" oninput=\"testresult_onInput('" . $obj->id . "');\"tabindex=\"\" min=\"0\" max=\"" . $obj->test . "\" value=\"" . $obj->Testresult . "\" />";
                                echo "     </div>"; 
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Other Name:\">"; 
                                echo "     <div>";
                                echo "          <span style=\"color: #607D8B; \">" . $obj->othername . "</span>";
                                echo "     </div>";   
                                echo "     <div>";
                                echo "          <span id=\"val_exam_" . $obj->id . "\">" . $obj->exam . "</span"; 
                                echo "     </div>"; 
                                echo "  </td>";
                                
                                echo "  <td valign=\"top\"data-label=\"Code:\">"; 
                                echo "     <div>";
                                echo "          <span style=\"color: #607D8B; \" id=\"subjectcode_" . $obj->id . "\"  gradeset=\"" . $obj->gradeset . "\">" . $obj->subjectcode . "</span>";
                                echo "     </div>";   
                                echo "     <div class=\"exam100\" style=\"display: none;\">";
                                echo "          <input type=\"number\" class=\"input_result_entry\" id=\"text_exam100_" . $obj->id . "\" oninput=\"exam100_onInput('" . $obj->id . "');\" tabindex=\"\" min=\"0\" max=\"100\" value=\"" . $obj->exam100 . "\" />";
                                echo "     </div>"; 
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Description:\">"; 
                                echo "     <div>";
                                echo "          <span style=\"color: 607D8B; \">" . DB_Subject_Description($obj->subjectcode) . "</span>";
                                echo "     </div>";   
                                echo "     <div>";
                                echo "          <input type=\"number\" class=\"input_result_entry text_examresult\" id=\"text_examresult_" . $obj->id . "\" oninput=\"examresult_onInput('" . $obj->id . "');\" tabindex=\"\" min=\"0\" max=\"" . $obj->exam . "\" value=\"" . $obj->examresult . "\" />";
                                echo "     </div>"; 
                                echo "  </td>";
                            

                                echo "  <td valign=\"top\"data-label=\"Pro-Rate:\" style=\"color: #222;\">";                             
                                echo "     <br>";

                                echo "        <div id=\"prorate_" . $obj->id . "\" name=\"prorate_" . $obj->id . "\" value=\"" . $obj->prorate . "\" >";
                                echo "               <div style=\"text-align: center;\">";
                                                        if ($obj->prorate == 1) {
                                                            echo $UTIL->IMG_Activated(20, 20);
                                                        } else {
                                                            echo $UTIL->IMG_Deactivated(20, 20);
                                                        }
                                echo "                </div>";
                                echo "        </div>";                         
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Total:\" style=\"color: #222;\">"; 
                                echo "     <br>";
                                echo "     <div>";
                                echo "          <input type=\"number\" class=\"input_result_entry text_totalmark\" id=\"text_totalmark_" . $obj->id . "\"  value=\"" . $obj->totalmark . "\" disabled />";
                                echo "     </div>";                            
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Assess:\" style=\"color: #222;\">"; 
                                echo "     <br>";
                                echo "     <div>";
                                echo            $obj->assesement; 
                                echo "     </div>";                         
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Rank:\" style=\"color: #222;\">";    
                                echo "     <br>";
                                echo "     <div>";
                                echo            $obj->rank; 
                                echo "     </div>";                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Grade:\" style=\"color: #222;\">";   
                                echo "     <br>";
                                echo "     <div>";
                                echo            $obj->examgrade; 
                                echo "     </div>";                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Comment:\" style=\"color: #222;\">";   
                                echo "     <br>";
                                echo "     <div>";
                                echo            $obj->Comments; 
                                echo "     </div>";                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Teacher:\" style=\"color: #222;\">";  
                                echo "     <div>";
                                echo "  <a class=\"button hollow\" onclick=\"update_data('" . $obj->id . "')\">Save</a>";
                                //echo            $obj->Teacher; 
                                echo "     </div>";                           
                                echo "  </td>";

                                echo "</tr>";
                            } // end foreach ($query_result_array as $obj);
                        ?>                
                    </tbody>
                </table>
            </div>
        </div>
        <?php
            if ($query_total > 0) {
                echo "  <div class=\"row\" style=\"padding: 10px 0px;\">";
                echo "    <div class=\"small-12 medium-12 large-12 columns\" style=\"background-color: lightblue;\">";
                echo "        <p style=\"margin-bottom: 0px\">Number of Subjects: <strong>" . $query_total . "</strong></p>";
                echo "          <a onclick=\"subject_ranking('" . $obj->id . "')\">Subject Ranking</a>";
                echo "    </div>";
                echo "  </div>";
            }
        ?> 

    </form>
</div>


<script type="text/javascript">

    // When the page is loaded run function
    window.onload = onLoadFunctions(); 

    function onLoadFunctions() {
        console.log('onLoadFunctions()');

        //Get Student Subjects
        //getStudentSubjectsResults(); 

    }

    function getStudentSubjectsResults() {
        console.log('getStudentSubjectsResults()');

        var var_id_student = document.getElementById("text_id_student").value;
        var var_subjectcode = document.getElementById("select_subjectcode")[document.getElementById("select_subjectcode").selectedIndex].value;
        var var_grade = document.getElementById("select_grade")[document.getElementById("select_grade").selectedIndex].value;
        var var_room = document.getElementById("text_room").value;
        var var_term = document.getElementById("select_term")[document.getElementById("select_term").selectedIndex].value;
        var var_sex = document.getElementById("select_sex")[document.getElementById("select_sex").selectedIndex].value;

        //alert(var_subjectcode);

        //alert(var_subjectcode + ' : ' + var_term)
        var xhttp;
            /*if (var_term == "") {
                document.getElementById("subjects_results").innerHTML = "";
                return;
            }*/
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var str = xhttp.responseText;
              //alert(str);
             //alert(xhttp.responseText);
             //console.log(xhttp.responseText);
            document.getElementById("subjects_results").innerHTML = xhttp.responseText;
        }
      };

      $post_parameters = "test=test";

        if (var_id_student !== null && var_id_student !== "") {
            $post_parameters += "&id_student=" + var_id_student;
        }
        if (var_subjectcode !== null && var_subjectcode !== "") {
            $post_parameters += "&subjectcode=" + var_subjectcode;
            //alert(var_subjectcode);
        }
        if (var_grade !== null && var_grade !== "") {
            $post_parameters += "&grade=" + var_grade;
        }
        if (var_room !== null && var_room !== "") {
            $post_parameters += "&room=" + var_room;
        }
        if (var_term !== null && var_term !== "") {
            $post_parameters += "&term=" + var_term;
        }
        if (var_sex !== null && var_sex !== "") {
            $post_parameters += "&sex=" + var_sex;
        }

        //alert($post_parameters);
        xhttp.open("GET", "/get_student_subjects_results.php?" + $post_parameters, true);
        xhttp.send();
    }// end showParentDetail()


    function  Apply_Using_Onchange() {
        console.log('Apply_Using_Onchange()');

        var select_apply_using = document.getElementById("select_apply_using");
        var subject_set = document.getElementById("subject_set_cover");
        var subject = document.getElementById("subject_cover");

        //alert(select_apply_using.value);

        if (select_apply_using.value == 0) {
            subject_set.classList.remove("hide");
            subject.classList.add("hide");
        } else {
            subject_set.classList.add("hide");
            subject.classList.remove("hide");
        }
      
    } //end Apply_Using_Onchange() {


    function Overwrite_Onclick() {

        var overwrite = document.getElementById("checked_overwrite");
        var overwrite_with_data = document.getElementById("checked_overwrite_with_data");

        if (overwrite.checked) {
            overwrite.value = 1;
            overwrite_with_data.value = 0;
            overwrite_with_data.removeAttribute("disabled");
        }  else {
            overwrite.value = 0;
            overwrite_with_data.value = 0;
            overwrite_with_data.checked=false;
            overwrite_with_data.setAttribute("disabled", true);
        }
    }

    function Overwrite_with_data_Onclick() {

        var overwrite_with_data = document.getElementById("checked_overwrite_with_data");

        if (overwrite_with_data.checked) {
            overwrite_with_data.value = 1;
        }  else {
            overwrite_with_data.value = 0;
        }
    }

    function cum100Click() {
        console.log('cum100Click()');

        var y = document.getElementsByClassName("cum100");
        var x = document.getElementsByClassName("text_testresult");

        currentvalue = document.getElementById('cum100Switch').value;
        if(currentvalue == "FALSE"){
            document.getElementById("cum100Switch").value="TRUE";

            var i;
            for (i = 0; i < y.length; i++) { y[i].style.display = "unset"; }

            var j;
            for (j = 0; j < x.length; j++) { x[j].disabled = true; }
        }else{
            document.getElementById("cum100Switch").value="FALSE";

            var i;
            for (i = 0; i < y.length; i++) { y[i].style.display = "none"; }

            var j;
            for (j = 0; j < x.length; j++) { x[j].disabled = false; }
        }
    }

    function cum100_onInput(var_id) {
        console.log('cum100_onInput()');

        var exam = Number.parseFloat(document.getElementById("val_exam_" + var_id).innerHTML.replace('.',','));
        var prorate = document.getElementById("prorate_" + var_id).getAttribute("value");
        var examresult = Number.parseFloat(document.getElementById("text_examresult_" + var_id).value);
        var total = document.getElementById("text_totalmark_" + var_id);

        var testresult = document.getElementById("text_testresult_" + var_id);
        var cum100 = Number.parseFloat(document.getElementById("text_cum100_" + var_id).value);
        var test = Number.parseFloat(document.getElementById("val_test_" + var_id).innerHTML.replace('.',','));

        //alert(test + " : " + Number.parseFloat(testresult.value) + " : " + cum100);

        testresult.value = (cum100 * test) / 100;

        //Calculate Totalmark
        if (prorate == 1) {
            total.value = (examresult * 100) / exam;
        } else {
            total.value = Number.parseFloat(testresult.value) + examresult;
        } 
    }

    function exam100_onInput(var_id) {
        console.log('exam100_onInput()');

        var prorate = document.getElementById("prorate_" + var_id).getAttribute("value");
        var testresult = Number.parseFloat(document.getElementById("text_testresult_" + var_id).value);
        var total = document.getElementById("text_totalmark_" + var_id);

        var examresult = document.getElementById("text_examresult_" + var_id);
        var exam100 = Number.parseFloat(document.getElementById("text_exam100_" + var_id).value);
        var exam = Number.parseFloat(document.getElementById("val_exam_" + var_id).innerHTML.replace('.',','));

        //alert(exam + " : " + Number.parseFloat(examresult.value) + " : " + exam100);

        examresult.value = (exam100 * exam) / 100;

        //Calculate Totalmark
        if (prorate == 1) {
            total.value = (Number.parseFloat(examresult.value) * 100) / exam;
        } else {
            total.value = Number.parseFloat(examresult.value) + testresult;
        } 
    }

     function testresult_onInput(var_id) {
        console.log('testresult_onInput()');

        var exam = Number.parseFloat(document.getElementById("val_exam_" + var_id).innerHTML.replace('.',','));
        var prorate = document.getElementById("prorate_" + var_id).getAttribute("value");
        var examresult = Number.parseFloat(document.getElementById("text_examresult_" + var_id).value);
        var total = document.getElementById("text_totalmark_" + var_id);

        var testresult = document.getElementById("text_testresult_" + var_id);
        //var cum100 = Number.parseFloat(document.getElementById("text_cum100_" + var_id).value);
        var test = Number.parseFloat(document.getElementById("val_test_" + var_id).innerHTML.replace('.',','));

        //alert(test + " : " + Number.parseFloat(testresult.value) + " : " + cum100);

        //testresult.value = (cum100 * test) / 100;

        //Calculate Totalmark
        if (prorate == 1) {
            total.value = (examresult * 100) / exam;
        } else {
            total.value = Number.parseFloat(testresult.value) + examresult;
        }
    }

    function examresult_onInput(var_id) {
        console.log('examresult_onInput()');

        var prorate = document.getElementById("prorate_" + var_id).getAttribute("value");
        var testresult = Number.parseFloat(document.getElementById("text_testresult_" + var_id).value);
        var total = document.getElementById("text_totalmark_" + var_id);

        var examresult = document.getElementById("text_examresult_" + var_id);
        //var exam100 = Number.parseFloat(document.getElementById("text_exam100_" + var_id).value);
        var exam = Number.parseFloat(document.getElementById("val_exam_" + var_id).innerHTML.replace('.',','));

        //alert(exam + " : " + Number.parseFloat(examresult.value) + " : " + exam100);

        //examresult.value = (exam100 * exam) / 100;

        //Calculate Totalmark
        if (prorate == 1) {
            total.value = (Number.parseFloat(examresult.value) * 100) / exam;
        } else {
            total.value = Number.parseFloat(examresult.value) + testresult;
        } 
    }

    function exam100Click() {
        console.log('exam100Click()');

        var y = document.getElementsByClassName("exam100");
        var x = document.getElementsByClassName("text_examresult");

        currentvalue = document.getElementById('exam100Switch').value;
        if(currentvalue == "FALSE"){
            document.getElementById("exam100Switch").value="TRUE";

            var i;
            for (i = 0; i < y.length; i++) { y[i].style.display = "unset"; }

            var j;
            for (j = 0; j < x.length; j++) { x[j].disabled = true; }
        }else{
            document.getElementById("exam100Switch").value="FALSE";

            var i;
            for (i = 0; i < y.length; i++) { y[i].style.display = "none"; }

            var j;
            for (j = 0; j < x.length; j++) { x[j].disabled = false; }
        }
    }


    function update_data(val_id) {
       console.log('update_data()');

        var var_id = document.getElementById("id_" + val_id).innerHTML;
        var subjectcode = document.getElementById("subjectcode_" + val_id);
        var var_subjectcode = subjectcode.innerHTML;
        var var_gradeset = subjectcode.getAttribute("gradeset");
        var var_grade = document.getElementById("select_grade")[document.getElementById("select_grade").selectedIndex].value;
        var var_room = document.getElementById("text_room").value;
        var var_term = document.getElementById("select_term")[document.getElementById("select_term").selectedIndex].value;


        var var_testresult = document.getElementById('text_testresult_' + val_id).value;
        var var_examresult = document.getElementById("text_examresult_" + val_id).value;
        var var_cum100 = document.getElementById("text_cum100_" + val_id).value;
        var var_exam100 = document.getElementById("text_exam100_" + val_id).value;
        var var_prorate = document.getElementById("prorate_" + val_id).getAttribute("value");
        var var_totalmark = document.getElementById("text_totalmark_" + val_id).value;

        //alert(var_subjectcode + ' : ' + var_term)
        var xhttp;
            /*if (var_term == "") {
                document.getElementById("subjects_results").innerHTML = "";
                return;
            }*/
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var str = xhttp.responseText;
              //alert(str);
             alert(xhttp.responseText);
             //console.log(xhttp.responseText);
            //document.getElementById("subjects_results").innerHTML = xhttp.responseText;
        }
      };

      $post_parameters = "test=test";

        if (var_id !== null && var_id !== "") {
            $post_parameters += "&id=" + var_id;
        }
        if (var_subjectcode !== null && var_subjectcode !== "") {
            $post_parameters += "&subjectcode=" + var_subjectcode;
        }
        if (var_gradeset !== null && var_gradeset !== "") {
            $post_parameters += "&gradeset=" + var_gradeset;
        }
        if (var_grade !== null && var_grade !== "") {
            $post_parameters += "&grade=" + var_grade;
        }
        if (var_room !== null && var_room !== "") {
            $post_parameters += "&room=" + var_room;
        }
        if (var_term !== null && var_term !== "") {
            $post_parameters += "&term=" + var_term;
        }


        if (var_testresult !== null && var_testresult !== "") { $post_parameters += "&testresult=" + var_testresult; }
        if (var_examresult !== null && var_examresult !== "") { $post_parameters += "&examresult=" + var_examresult; }
        if (var_cum100 !== null && var_cum100 !== "") { $post_parameters += "&cum100=" + var_cum100; }
        if (var_exam100 !== null && var_exam100 !== "") { $post_parameters += "&exam100=" + var_exam100; }
        if (var_prorate !== null && var_prorate !== "") { $post_parameters += "&prorate=" + var_prorate; }
        if (var_totalmark !== null && var_totalmark !== "") { $post_parameters += "&totalmark=" + var_totalmark; }

        //alert($post_parameters);
        xhttp.open("GET", "/rest/update_student_subject_result.php?" + $post_parameters, true);
        xhttp.send();


    } // end update_data()


    function subject_ranking(val_id) {
       console.log('subject_ranking()');

        var var_id = document.getElementById("text_id_student").value;
        var var_subjectcode = document.getElementById("subjectcode_" + val_id).innerHTML;
        var var_grade = document.getElementById("select_grade")[document.getElementById("select_grade").selectedIndex].value;
        var var_room = document.getElementById("text_room").value;
        var var_term = document.getElementById("select_term")[document.getElementById("select_term").selectedIndex].value;

        //alert(var_subjectcode + ' : ' + var_term)
        var xhttp;
            /*if (var_term == "") {
                document.getElementById("subjects_results").innerHTML = "";
                return;
            }*/
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var str = xhttp.responseText;
              //alert(str);
             alert(xhttp.responseText);
             //console.log(xhttp.responseText);
            //document.getElementById("subjects_results").innerHTML = xhttp.responseText;
        }
      };

      $post_parameters = "test=test";

        if (var_id !== null && var_id !== "") {
            $post_parameters += "&id=" + var_id;
        }
        if (var_subjectcode !== null && var_subjectcode !== "") {
            $post_parameters += "&subjectcode=" + var_subjectcode;
            //alert(var_subjectcode);
        }
        if (var_grade !== null && var_grade !== "") {
            $post_parameters += "&grade=" + var_grade;
        }
        if (var_room !== null && var_room !== "") {
            $post_parameters += "&room=" + var_room;
        }
        if (var_term !== null && var_term !== "") {
            $post_parameters += "&term=" + var_term;
        }

        //alert($post_parameters);
        xhttp.open("GET", "/rest/subject_ranking.php?" + $post_parameters, true);
        xhttp.send();


    } // end subject_ranking()


</script>


<!--Include Footer-->
  <?php 

    $path = $_SERVER['DOCUMENT_ROOT'] ;
    $path .= "/includes/footer.php";
    include ($path);
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/app-dashboard-footer.php");
  ?>