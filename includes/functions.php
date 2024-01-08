<?php	


	// Define all classes  !
	require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/class_rest.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/class_rest_daten.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/class_session.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/class_util.php");

	//Define Global variables
	define('SHOP_TYPE_GENERAL', 100);
	define('SHOP_TYPE_CSV_IMPORT', 200);
	define('SHOP_TYPE_SHOPIFY', 300);
	define('SHOP_TYPE_BILLBEE', 400);
	define('SHOP_TYPE_AMAZON', 500);
	define('SHOP_TYPE_WOOCOMMERCE', 600);

	//Define functions below!
	function Get_Status ($val) {
		switch ($val) {
			case 0:
				return "In Progress";
			case 1:
				return "Compleated";
			case 2:
				return "Archived";
			default:
				return "***";
		}
	}

	function DB_UserFullName($pkey) {
		$rueckgabe = "";
		
		$dbconn = DB_Connect_Direct();
		if ($dbconn != false) {
			$query = "SELECT Name, FirstName FROM users WHERE id_users='" . $pkey . "';";
			$result = DB_Query($dbconn, $query);
			if ($result != false) {
				if (DB_NumRows($result) > 0) {
					$object = DB_FetchObject($result);
					$rueckgabe = $object->FirstName . ' ' . $object->Name;
					DB_FreeResult($result);
				}
			}
			DB_Close($dbconn);
		}
		return $rueckgabe;
	} // end DB_PGTopic_Description();

	function DB_PGTopic_Description($topic) {
		$rueckgabe = "";
		
		$dbconn = DB_Connect_Direct();
		if ($dbconn != false) {
			$query = "SELECT description FROM pgtopic WHERE topic='" . $topic . "';";
			$result = DB_Query($dbconn, $query);
			if ($result != false) {
				if (DB_NumRows($result) > 0) {
					$object = DB_FetchObject($result);
					$rueckgabe = $object->description;
					DB_FreeResult($result);
				}
			}
			DB_Close($dbconn);
		}
		return $rueckgabe;
	} // end DB_PGTopic_Description();

	function DB_Grade_name($grade) {
		$rueckgabe = "";
		
		$dbconn = DB_Connect_Direct();
		if ($dbconn != false) {
			$query = "SELECT Name FROM grade WHERE grade='" . $grade . "';";
			$result = DB_Query($dbconn, $query);
			if ($result != false) {
				if (DB_NumRows($result) > 0) {
					$object = DB_FetchObject($result);
					$rueckgabe = $object->Name;
					DB_FreeResult($result);
				}
			}
			DB_Close($dbconn);
		}
		return $rueckgabe;
	} // end DB_PGTopic_Description();

	function DB_Subject_Gradeset_description($gradeset) {
		$rueckgabe = "";
		
		$dbconn = DB_Connect_Direct();
		if ($dbconn != false) {
			$query = "SELECT description FROM subjectgradeset WHERE gradeset='" . $gradeset . "';";
			$result = DB_Query($dbconn, $query);
			if ($result != false) {
				if (DB_NumRows($result) > 0) {
					$object = DB_FetchObject($result);
					$rueckgabe = $object->description;
					DB_FreeResult($result);
				}
			}
			DB_Close($dbconn);
		}
		return $rueckgabe;
	} // end DB_PGTopic_Description();

	function DB_GetGrade($gradeset, $subjectcode, $totalmark = -1) {
		
		$val_gradeset = "";
		$dbconn = DB_Connect_Direct();

		// get gradeset
		if (!empty($gradeset)) {
			$val_gradeset = $gradeset;
		} else {
			if ($dbconn != false) {
				$query = "SELECT gradeset FROM subjects WHERE pkey = '" . $subjectcode . "';";
				$result = DB_Query($dbconn, $query);
				if ($result != false) {
					if (DB_NumRows($result) > 0) {
						$object = DB_FetchObject($result);
						$val_gradeset = $object->gradeset;
						DB_FreeResult($result);
					}
				}
			}
		}


		$val_grade = "N/A";
		$val_gradevalue = "";
		if ($dbconn != false) {
			$query = "SELECT grade, gradevalue, Comments FROM subjectgrade WHERE gradeset='" . $val_gradeset . "' AND (" . $totalmark . " BETWEEN lowscore AND highscore);";
			$result = DB_Query($dbconn, $query);
			if ($result != false) {
				if (DB_NumRows($result) > 0) {
					$object = DB_FetchObject($result);
					$val_grade = $object->grade;
					$val_gradevalue = $object->gradevalue;
					$val_comments = $object->Comments;
					DB_FreeResult($result);
				}
			}
			DB_Close($dbconn);
		}

		return $val_grade.";".$val_gradevalue.";".$val_comments;
	} // end DB_GetGrade();

	function Page_Nav($page, $action_default, $show_num_pages, $query_total, $query_limit, $query_offset) {
		global $SESSION;
		
		$show_num_pages_half = floor($show_num_pages / 2); // Hilfsberechnung für halbe Seitenzahlenanzeige
		$pages = ceil($query_total / $query_limit); // Anzahl aktueller Seiten
		$current_page = floor($query_offset / $query_limit); // aktuelle Seiten-Nr.	
		
		echo '<div class="row">';
		echo '  <div class="large-12 columns">';
		echo '    <ul class="pagination text-center">';
		
		// Pfeile nach links, anzeigen, wenn Datensatz > 1
		if ($current_page > 0) {
			echo '<li class="arrow">';
			echo '<a class="class_spinner_id" href="' . $SESSION->Generate_Link($page, $action_default . "&query_offset=0") . '">&laquo;</a>';
			echo '</li>';
		} // end if ($current_page > 0)			
				
		// Seitenanzeige aufbauen
		if ($show_num_pages < $pages) { // mehr als 7 Seiten
			if ($current_page > $show_num_pages_half) {
				// Seite 1 ...
				echo '<li class="arrow">';
				echo '<a class="class_spinner_id" href="' . $SESSION->Generate_Link($page, $action_default . "&query_offset=0") . '">1</a>';
				echo '</li>';
				echo '<li class="unavailable"><a href="">&hellip;</a></li>';
			} // end if ($current_page > $show_num_pages_half);
				
			if ($current_page <= $show_num_pages_half) { // Seite 1..7
				for ($i = 0; $i < $show_num_pages; $i++) {
					if ($i == $current_page) {
						echo '      <li class="current">';
					} else {
						echo '      <li>';
					}
					echo '<a class="class_spinner_id" href="' . $SESSION->Generate_Link($page, $action_default . "&query_offset=" . ($i * $query_limit)) . '">' . ($i + 1) . '</a>';
					echo '</li>';			
				} // end for ($i);
			} else if ($current_page >= (($pages - 1) - $show_num_pages_half)) { // Seite (n-1) - 7 bis (n-1)
				for ($i = ($pages - $show_num_pages); $i < $pages; $i++) {
					if ($i == $current_page) {
						echo '      <li class="current">';
					} else {
						echo '      <li>';
					}
					echo '<a class="class_spinner_id" href="' . $SESSION->Generate_Link($page, $action_default . "&query_offset=" . ($i * $query_limit)) . '">' . ($i + 1) . '</a>';
					echo '</li>';			
				} // end for ($i);
			} else { // zwischen min und max Seiten
			
				for ($i = ($current_page - $show_num_pages_half); $i <= ($current_page + $show_num_pages_half); $i++) {
					if ($i == $current_page) {
						echo '      <li class="current">';
					} else {
						echo '      <li>';
					}
					echo '<a class="class_spinner_id" href="' . $SESSION->Generate_Link($page, $action_default . "&query_offset=" . ($i * $query_limit)) . '">' . ($i + 1) . '</a>';
					echo '</li>';			
				} // end for ($i);	
			} // end if
			
			if ($current_page < (($pages - 1) - $show_num_pages_half) ) {
				// ... Seite n-1			
				echo '<li class="unavailable"><a href="">&hellip;</a></li>';
				echo '<li class="arrow">';
				echo '<a class="class_spinner_id" href="' . $SESSION->Generate_Link($page, $action_default . "&query_offset=" . (($pages - 1) * $query_limit)) . '">' . $pages . '</a>';
				echo '</li>';
			} // end if ($current_page < ($pages - $show_num_pages_half) );
			
		} else { // weniger als 7 Seiten
			for ($i = 0; $i < $pages; $i++) {
				if ($i == $current_page) {
					echo '      <li class="current">';
				} else {
					echo '      <li>';
				}
				echo '<a class="class_spinner_id" href="' . $SESSION->Generate_Link($page, $action_default . "&query_offset=" . ($i * $query_limit)) . '">' . ($i + 1) . '</a>';
				echo '</li>';			
			} // end for ($i);
		} // end if ($show_num_pages > $pages);
		

		if ($current_page < ($pages - 1)) {
			echo '<li class="arrow">';
			echo '<a class="class_spinner_id" href="' . $SESSION->Generate_Link($page, $action_default . "&query_offset=" . (($pages - 1) * $query_limit)) . '">&raquo;</a>';
			echo '</li>';
		} // end if ($current_page > 0)
		
		echo '    </ul>';
		echo '  </div>';
		echo '</div>';
	} // end function

	function GetSequence($zkey='') {
		if ($zkey == '') {
			return -1;
		}

		$zkey=strtoupper($zkey);

		$dbconn = DB_Connect_Direct();                
        if ($dbconn != false) {

          
            $query = "SELECT * FROM genkey AS S WHERE S.FIELDID = '" . $zkey . "';";
            
            $result = DB_Query($dbconn, $query);
            if ($result != false) {
            	if (DB_NumRows($result) > 0) {
            		$obj = DB_FetchObject($result);
					//run sequence_format() with get_nxt_sequence(zkey)
					$ret = get_nxt_sequence($zkey, $obj);
					DB_FreeResult($result);
					DB_Close($dbconn);
            		return $ret;

					
            	} else {
            		//Create GenKey 
            		$query =  "INSERT INTO genkey (FIELDID, LASTUSED) VALUES ('" . $zkey . "', 1);";
            		$result = DB_Query($dbconn, $query);
            		if ($result != false) {
            			//run sequence_format(1)
            			DB_FreeResult($result);
						DB_Close($dbconn);
            			return 1;

            		} else {
            			//run sequence_format() with get_nxt_sequence(zkey)
            			$ret = get_nxt_sequence($zkey, $obj);
            			return $ret;
            		}
            	}
                
            }

        }
	}

	function get_nxt_sequence($zkey, $obj) {
		// update record and retreive next sequence no
		$zkeyno = $obj->LASTUSED;
		$zkeyno ++;
		//echo $zkeyno;

		$dbconn = DB_Connect_Direct();                
        if ($dbconn != false) {

			$query =  "UPDATE genkey SET LASTUSED = " . $zkeyno . " WHERE FIELDID = '" . $zkey . "';";
			$result = DB_Query($dbconn, $query);
			if ($result != false) {
				//run sequence_format(1)
				DB_Close($dbconn);
				return $zkeyno;
				
			} else {
				return -1;
			}
		}
	}

	/*function Sequence_Format($zseq, $obj) {

		$zlen  = $obj->return_length;
		$zprefix_char  = $obj->prefix_character;
		$zprlen = strlen(str_replace(' ', '', $zprefix_char));
		$zfmt  = "";
		//Determine the desired type
		if ($obj->return_type == 1) {
			if ($obj->prefix_zero == 1) {
				$zfmt = "0";
			}

			if ($obj->return_length > 0) {
				$zfmt = $zfmt . ($obj->return_length - $zprlen);
			}

		}

		IF GENKEY.return_type=1 THEN	// string
			IF GENKEY.prefix_zero THEN
				zfmt="0"
			END
			//
			IF GENKEY.return_length>0 THEN
				zfmt=zfmt+NoSpace(NumToString(GENKEY.return_length-zprlen,"d"))+"d"
			END
			//
			RESULT zprefix_char+NumToString(zseq, zfmt)
		ELSE
			RESULT zseq		// numeric
		END

	}*/

	function REST_POST($post_uri, $post_vars, ClassRESTDaten $class_rest_daten = NULL, $DEV_MODE = false, $RETURN_URI_ONLY = false) {
		//libxml_use_internal_errors(true);
		//libxml_clear_errors();
	
		$post_host = "https://auto.germangoodz.com";
		if ($DEV_MODE == true) {
			$post_host = "https://auto.germangoodz.com";
		} else {
			$post_host = "https://auto.germangoodz.com";
		}
		
		$rest_user = "api_user=ad_0000101&api_key=DB007SS012021DKBCCTVDQZYGH1JHN8";

		$rest_daten = "";
		if ($class_rest_daten != NULL) {
			$rest_daten .= "rest_daten_id_user=" . $class_rest_daten->id_user;
			$rest_daten .= "&rest_daten_ip=" . $class_rest_daten->ip;
		}
		
		if (substr($post_uri, 0, 1) != '/') {
			$post_host .= '/';
		}
		
		$uri_komplett = $post_host . $post_uri . "?" . $rest_user . "&" . $rest_daten . "&" . $post_vars;
		//print_r($uri_komplett);
		// die($uri_komplett);		
		if ($RETURN_URI_ONLY == true) {
			return $uri_komplett;
		}
		
		$REST = new ClassREST();
		
		$xml = $REST->curl_get_request($post_host . $post_uri, $rest_user . "&" . $rest_daten . "&" . $post_vars, NULL);

		return $xml;
	} // end REST_POST();
	
	
	
?>