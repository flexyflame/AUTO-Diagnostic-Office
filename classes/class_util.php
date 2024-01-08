<?php

ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);

class ClassUtil {

	public $SESSION = NULL;

	function __construct($SESSION) {
		// parent::__construct(); // ClassBenutzerrechte Constructor aufrufen		
		$this->SESSION = $SESSION;

		// constructor
   	}

   	function __destruct() {
		// destructor
   	}

   	public function table_bg_color_odd() {
		$color = '#eaedef ';
		return $color;
	}
		
	public function table_bg_color_even() {
		$color = '#FFFFFF';
		return $color;
	}

	public function IMG_Activated($height = 32, $width = 32) {
		return '<img src="/images/activated.png" alt="" height="' . $height . '" width="' . $width . 'px">';
	}
	
	
	public function IMG_Deactivated($height = 32, $width = 32) {
		return '<img src="/images/deactivated.png" alt="" height="' . $height . '" width="' . $width . 'px">';
	}

	function SELECT_Industry($industry_selektiert = 'AUTO', $arr_option_values = NULL, $select_id = "select_industry", $select_name = "select_industry", $select_size = 1, $select_extra_code = "") {

		$ret = '';
		$ret .= '<select id="' . $select_id . '" name="' . $select_name . '" type="select" size="' . $select_size . '" ' . $select_extra_code . '>';

		if ($arr_option_values != NULL) {
			if (count($arr_option_values) > 0) {
				foreach ($arr_option_values as $key => $value) {
					$ret .= '<option value="' . $key . '">' . $value . '</option>';
				} // end foreach();
			} // end if (count)
		} // end if ($arr_option_values != NULL);

		($industry_selektiert == 'PRIVATE') ? $TYPE_PRIVATE_select = 'selected' : $TYPE_PRIVATE_select = '';
		($industry_selektiert == 'AUTO') ? $TYPE_AUTO_select = 'selected' : $TYPE_AUTO_select = '';
		// ($industry_selektiert == SHOP_TYPE_CSV_IMPORT) ? $TYPE_CSV_IMPORT_select = 'selected' : $TYPE_CSV_IMPORT_select = '';
		// ($industry_selektiert == SHOP_TYPE_SHOPIFY) ? $TYPE_SHOPIFY_select = 'selected' : $TYPE_SHOPIFY_select = '';
		// ($industry_selektiert == SHOP_TYPE_BILLBEE) ? $TYPE_BILLBEE_select = 'selected' : $TYPE_BILLBEE_select = '';
		// ($industry_selektiert == SHOP_TYPE_AMAZON) ? $TYPE_AMAZON_select = 'selected' : $TYPE_AMAZON_select = '';
		// ($industry_selektiert == SHOP_TYPE_WOOCOMMERCE) ? $TYPE_WOOCOMMERCE_select = 'selected' : $TYPE_WOOCOMMERCE_select = '';

		$ret .= '<option value="PRIVATE" ' . $TYPE_PRIVATE_select . '>PRIVATE</option>';
		$ret .= '<option value="AUTO" ' . $TYPE_AUTO_select . '>AUTO</option>';
		// $ret .= '<option value="' . SHOP_TYPE_CSV_IMPORT . '" ' . $TYPE_CSV_IMPORT_select . '>CSV IMPORT</option>';
		// $ret .= '<option value="' . SHOP_TYPE_SHOPIFY . '" ' . $TYPE_SHOPIFY_select . '>SHOPIFY</option>';
		// $ret .= '<option value="' . SHOP_TYPE_BILLBEE . '" ' . $TYPE_BILLBEE_select . '>BILLBEE</option>';
		// $ret .= '<option value="' . SHOP_TYPE_AMAZON . '" ' . $TYPE_AMAZON_select . '>AMAZON</option>';
		// $ret .= '<option value="' . SHOP_TYPE_WOOCOMMERCE . '" ' . $TYPE_WOOCOMMERCE_select . '>WOOCOMMERCE</option>';

		$ret .= '</select>';

		return $ret;
	} // end SELECT_Industry();

	function SELECT_Customer ($id_customer_selektiert = -1, $show_all = false, $show_contact_person = false, $arr_option_values = NULL, $select_id = "select_id_customer", $select_name = "select_id_customer", $select_size = 1, $select_extra_code = "", $db_conn_opt = false) {
		
		$ret = '';
		$ret .= '<select id="' . $select_id . '" name="' . $select_name . '" type="select" size="' . $select_size . '" ' . $select_extra_code . '>';
		
		// Optionale DB-Verbindung aufbauen?
		$db_conn = false;
		if ($db_conn_opt != false) {
			$db_conn = $dbconn_opt;
		} else {
			$dbconn = DB_Connect_Direct();
		}
		
		if ($arr_option_values != NULL) {
			if (count($arr_option_values) > 0) {
				foreach ($arr_option_values as $key => $value) {
					if ($id_customer_selektiert != -1) {
						if ($key == $id_customer_selektiert) {
							$ret .= '<option value="' . $key . '" selected="selected">' . $value . '</option>';
						} else {
							$ret .= '<option value="' . $key . '">' . $value . '</option>';
						}	
					} else {
						$ret .= '<option value="' . $key . '">' . $value . '</option>';
					} // end if
				} // end foreach();
			} // end if (count)
		} // end if ($arr_option_values != NULL);
		
		if ($dbconn != false) {

			$query = "SELECT C.id_customer, C.Company, C.Industry, C.Address, C.Address_Street_1, C.Address_Street_2, C.Address_City, C.Address_State, C.Address_Zip, C.Address_Country, ";
			$query .= "C.Phone, C.Email, C.Website, C.Background_Info, C.Sales_Rep, C.Date_of_Initial_Customer, C.Contact_person, C.flag_active FROM customer AS C ";
		    if ($show_all == false) $query .= "WHERE C.flag_active = 1 ";
			$query .= "ORDER BY C.Company ASC";

			$contact_person = "";

			$result = DB_Query($dbconn, $query);
			while ($obj = DB_FetchObject($result)) {
				
				if ($show_contact_person == true) {
					if (!empty($obj->Contact_person)) $contact_person = ' (' . $obj->Contact_person . ')';
				}
		
				if ($id_customer_selektiert != -1) {
					if ($obj->id_customer == $id_customer_selektiert) {
						$ret .= '<option value="' . $obj->id_customer . '" Contact_person="' . $obj->Contact_person . '" selected="selected">' . $obj->Company . $contact_person . '</option>';
					} else {
						$ret .= '<option value="' . $obj->id_customer . '" Contact_person="' . $obj->Contact_person . '">' . $obj->Company . $contact_person . '</option>';
					}
				} else {
					$ret .= '<option value="' . $obj->id_customer . '" Contact_person="' . $obj->Contact_person . '">' . $obj->Company . $contact_person . '</option>';
				} // end if
			} // end while ($obj = DB_FetchObject($result));
			DB_FreeResult($result);

			if ($db_conn_opt == false) {
				DB_Close($dbconn);
			} // end if ($db_conn_opt == false);
		} // end if ($dbconn != false);
		
		$ret .= '</select>';
		
		return $ret;
	}

	function SELECT_Shop_System($id_shop_system_selektiert = -1, $show_all = false, $show_customer = false, $arr_option_values = NULL, $select_id = "select_id_shop_system", $select_name = "select_id_shop_system", $select_size = 1, $select_extra_code = "", $db_conn_opt = false) {

		$ret = '';
		$ret .= '<select id="' . $select_id . '" name="' . $select_name . '" type="select" size="' . $select_size . '" ' . $select_extra_code . '>';

		// Optionale DB-Verbindung aufbauen?
		$db_conn = false;
		if ($db_conn_opt != false) {
			$db_conn = $dbconn_opt;
		} else {
			$dbconn = DB_Connect_Direct();
		}
			
		if ($arr_option_values != NULL) {
			if (count($arr_option_values) > 0) {
				foreach ($arr_option_values as $key => $value) {
					if ($id_shop_system_selektiert != -1) {
						if ($key == $id_shop_system_selektiert) {
							$ret .= '<option value="' . $key . '" selected="selected">' . $value . '</option>';
						} else {
							$ret .= '<option value="' . $key . '">' . $value . '</option>';
						}
					} else {
						$ret .= '<option value="' . $key . '">' . $value . '</option>';
					} // end if
				} // end foreach();
			} // end if (count)
		} // end if ($arr_option_values != NULL);

		if ($dbconn != false) {

			$query = "SELECT S.id_shop_system, S.shop_name, S.shop_code, S.flag_visual_defects, S.flag_brakes, S.flag_extrapolation, S.flag_suspension_side_slip, S.flag_headlight, S.flag_emission, S.flag_alignment, S.flag_vulcanize, S.display_address, S.display_text, S.flag_active FROM shop_systems AS S ";

			$query .= "WHERE 1 = 1 ";
			if ($show_all == false) $query .= "AND S.flag_active = 1 ";

			if (empty($this->SESSION->Session_GetArrayShopSystems())) {
				$query .= "AND S.id_shop_system = 0 ";
			} else {
				$query .= "AND " . $this->SQL_Variablelist_From_Array("S.id_shop_system", $this->SESSION->Session_GetArrayShopSystems(), "id_shop_system") . " ";
			}

			$query .= "ORDER BY S.shop_name ASC";
			//echo $query;

			$cutomer_name = "";

			$result = DB_Query($dbconn, $query);
			if (DB_NumRows($result) == 1) $ret = '<select id="' . $select_id . '" name="' . $select_name . '" type="select" size="' . $select_size . '" ' . $select_extra_code . '>';
			//	
			while ($obj = DB_FetchObject($result)) {

				if ($show_customer == true) {
					if (!empty($obj->Company)) $cutomer_name = ' (' . $obj->Company . ')';
				}

				if ($id_shop_system_selektiert != -1) {
					if ($obj->id_shop_system == $id_shop_system_selektiert) {
						$ret .= '<option shop_code="' . $obj->shop_code . '" flag_visual_defects="' . $obj->flag_visual_defects . '" flag_brakes="' . $obj->flag_brakes . '" flag_extrapolation="' . $obj->flag_extrapolation . '" flag_suspension_side_slip="' . $obj->flag_suspension_side_slip . '" flag_headlight="' . $obj->flag_headlight . '" flag_emission="' . $obj->flag_emission . '" flag_alignment="' . $obj->flag_alignment . '" flag_vulcanize="' . $obj->flag_vulcanize . '" display_address="' . $obj->display_address . '" display_text="' . $obj->display_text . '" flag_active="' . $obj->flag_active  . '" value="' . $obj->id_shop_system . '" selected="selected">' . $obj->shop_name . $cutomer_name . '</option>';
					} else {
						$ret .= '<option shop_code="' . $obj->shop_code . '" flag_visual_defects="' . $obj->flag_visual_defects . '" flag_brakes="' . $obj->flag_brakes . '" flag_extrapolation="' . $obj->flag_extrapolation . '" flag_suspension_side_slip="' . $obj->flag_suspension_side_slip . '" flag_headlight="' . $obj->flag_headlight . '" flag_emission="' . $obj->flag_emission . '" flag_alignment="' . $obj->flag_alignment . '" flag_vulcanize="' . $obj->flag_vulcanize . '" display_address="' . $obj->display_address . '" display_text="' . $obj->display_text . '" flag_active="' . $obj->flag_active  . '" value="' . $obj->id_shop_system . '">' . $obj->shop_name . $cutomer_name . '</option>';
					}
				} else {
					$ret .= '<option shop_code="' . $obj->shop_code . '" flag_visual_defects="' . $obj->flag_visual_defects . '" flag_brakes="' . $obj->flag_brakes . '" flag_extrapolation="' . $obj->flag_extrapolation . '" flag_suspension_side_slip="' . $obj->flag_suspension_side_slip . '" flag_headlight="' . $obj->flag_headlight . '" flag_emission="' . $obj->flag_emission . '" flag_alignment="' . $obj->flag_alignment . '" flag_vulcanize="' . $obj->flag_vulcanize . '" display_address="' . $obj->display_address . '" display_text="' . $obj->display_text . '" flag_active="' . $obj->flag_active  . '" value="' . $obj->id_shop_system . '">' . $obj->shop_name . $cutomer_name . '</option>';
				} // end if
			} // end while ($obj = DB_FetchObject($result));
			DB_FreeResult($result);

			if ($db_conn_opt == false) {
				DB_Close($dbconn);
			} // end if ($db_conn_opt == false);
		} // end if ($dbconn != false);

		$ret .= '</select>';

		return $ret;
	} // end SELECT_Shop_System();

	function SELECT_Vehicle_Class($vehicle_class_selektiert = -1, $arr_option_values = NULL, $select_id = "select_vehicle_class", $select_name = "select_vehicle_class", $select_size = 1, $select_extra_code = "", $db_conn_opt = false) {
		
		$ret = '';
		$ret .= '<select id="' . $select_id . '" name="' . $select_name . '" type="select" size="' . $select_size . '" ' . $select_extra_code . '>';
		
		// Optionale DB-Verbindung aufbauen?
		$db_conn = false;
		if ($db_conn_opt != false) {
			$db_conn = $dbconn_opt;
		} else {
			$dbconn = DB_Connect_Direct();
		}
		
		if ($arr_option_values != NULL) {
			if (count($arr_option_values) > 0) {
				foreach ($arr_option_values as $key => $value) {
					if ($vehicle_class_selektiert != -1) {
						if ($key == $vehicle_class_selektiert) {
							$ret .= '<option value="' . $key . '" selected="selected">' . $value . '</option>';
						} else {
							$ret .= '<option value="' . $key . '">' . $value . '</option>';
						}	
					} else {
						$ret .= '<option value="' . $key . '">' . $value . '</option>';
					} // end if
				} // end foreach();
			} // end if (count)
		} // end if ($arr_option_values != NULL);
		
		if ($dbconn != false) {
			
			$query = "SELECT V.vehicle_class_id, V.name FROM vehicle_class AS V ORDER BY V.name ASC;";
			
			$result = DB_Query($dbconn, $query);
			while ($obj = DB_FetchObject($result)) {
				if ($vehicle_class_selektiert != -1) {
					if ($obj->vehicle_class_id == $vehicle_class_selektiert) {
						$ret .= '<option value="' . $obj->vehicle_class_id . '" selected="selected">' . $obj->name . '</option>';
					} else {
						$ret .= '<option value="' . $obj->vehicle_class_id . '">' . $obj->name . '</option>';
					}
				} else {
					$ret .= '<option value="' . $obj->vehicle_class_id . '">' . $obj->name . '</option>';
				} // end if
			} // end while ($obj = DB_FetchObject($result));
			DB_FreeResult($result);

			if ($db_conn_opt == false) {
				DB_Close($dbconn);
			} // end if ($db_conn_opt == false);
		} // end if ($dbconn != false);
		
		$ret .= '</select>';
		
		return $ret;
	} // end SELECT_Vehicle_Class();

	function SELECT_Vehicle_Producer($vehicle_producer_selektiert = -1, $arr_option_values = NULL, $select_id = "select_vehicle_producer", $select_name = "select_vehicle_producer", $select_size = 1, $select_extra_code = "", $db_conn_opt = false) {
		
		$ret = '';
		$ret .= '<select id="' . $select_id . '" name="' . $select_name . '" type="select" size="' . $select_size . '" ' . $select_extra_code . '>';
		
		// Optionale DB-Verbindung aufbauen?
		$db_conn = false;
		if ($db_conn_opt != false) {
			$db_conn = $dbconn_opt;
		} else {
			$dbconn = DB_Connect_Direct();
		}
		
		if ($arr_option_values != NULL) {
			if (count($arr_option_values) > 0) {
				foreach ($arr_option_values as $key => $value) {
					if ($vehicle_producer_selektiert != -1) {
						if ($key == $vehicle_producer_selektiert) {
							$ret .= '<option value="' . $key . '" selected="selected">' . $value . '</option>';
						} else {
							$ret .= '<option value="' . $key . '">' . $value . '</option>';
						}	
					} else {
						$ret .= '<option value="' . $key . '">' . $value . '</option>';
					} // end if
				} // end foreach();
			} // end if (count)
		} // end if ($arr_option_values != NULL);
		
		if ($dbconn != false) {
			
			$query = "SELECT V.producer FROM vehicle_producer AS V ORDER BY V.producer ASC;";
			
			$result = DB_Query($dbconn, $query);
			while ($obj = DB_FetchObject($result)) {
				if ($vehicle_producer_selektiert != -1) {
					if ($obj->producer == $vehicle_producer_selektiert) {
						$ret .= '<option value="' . $obj->producer . '" selected="selected">' . $obj->producer . '</option>';
					} else {
						$ret .= '<option value="' . $obj->producer . '">' . $obj->producer . '</option>';
					}
				} else {
					$ret .= '<option value="' . $obj->producer . '">' . $obj->producer . '</option>';
				} // end if
			} // end while ($obj = DB_FetchObject($result));
			DB_FreeResult($result);

			if ($db_conn_opt == false) {
				DB_Close($dbconn);
			} // end if ($db_conn_opt == false);
		} // end if ($dbconn != false);
		
		$ret .= '</select>';
		
		return $ret;
	} // end SELECT_Vehicle_Class();

	function SELECT_Vehicle_Class_Limits($vehicle_limits_class_selektiert = -1, $arr_option_values = NULL, $select_id = "select_Limits_Class", $select_name = "select_Limits_Class", $select_size = 1, $select_extra_code = "", $db_conn_opt = false) {
		
		$ret = '';
		$ret .= '<select id="' . $select_id . '" name="' . $select_name . '" type="select" size="' . $select_size . '" ' . $select_extra_code . '>';
		
		// Optionale DB-Verbindung aufbauen?
		$db_conn = false;
		if ($db_conn_opt != false) {
			$db_conn = $dbconn_opt;
		} else {
			$dbconn = DB_Connect_Direct();
		}
		
		if ($arr_option_values != NULL) {
			if (count($arr_option_values) > 0) {
				foreach ($arr_option_values as $key => $value) {
					if ($vehicle_limits_class_selektiert != -1) {
						if ($key == $vehicle_limits_class_selektiert) {
							$ret .= '<option value="' . $key . '" selected="selected">' . $value . '</option>';
						} else {
							$ret .= '<option value="' . $key . '">' . $value . '</option>';
						}	
					} else {
						$ret .= '<option value="' . $key . '">' . $value . '</option>';
					} // end if
				} // end foreach();
			} // end if (count)
		} // end if ($arr_option_values != NULL);
		
		if ($dbconn != false) {

			$query = "SELECT C.id_vehicle_class_limits, C.class_name, C.id_shop_system, S.shop_name, C.flag_active, C.break_min, C.break_max, C.shock_absorber_min, C.shock_absorber_max, C.side_slip_min, C.side_slip_max, C.alignment_camber_min, C.alignment_camber_max, C.alignment_caster_min, C.alignment_caster_max, C.alignment_toe_min, C.alignment_toe_max ";

			$query .=  "FROM vehicle_class_limits AS C ";
			$query .=  "LEFT OUTER JOIN shop_systems AS S ON (C.id_shop_system = S.id_shop_system) ";

			if (empty($this->SESSION->Session_GetArrayShopSystems())) {
				//$query .= "AND S.id_shop_system = 0 ";
			} else {
				$query .= "AND " . $this->SQL_Variablelist_From_Array("S.id_shop_system", $this->SESSION->Session_GetArrayShopSystems(), "id_shop_system") . " ";
			}

			$result = DB_Query($dbconn, $query);
			while ($obj = DB_FetchObject($result)) {

				$attr_str = '';
				$attr_str .= 'id_shop_system="'.$obj->id_shop_system.'" ';
				$attr_str .= 'shop_name="'.$obj->shop_name.'" ';
				$attr_str .= 'flag_active="'.$obj->flag_active.'" ';
				$attr_str .= 'break_min="'.$obj->break_min.'" ';
				$attr_str .= 'break_max="'.$obj->break_max.'" ';
				$attr_str .= 'shock_absorber_min="'.$obj->shock_absorber_min.'" ';
				$attr_str .= 'shock_absorber_max="'.$obj->shock_absorber_max.'" ';
				$attr_str .= 'side_slip_min="'.$obj->side_slip_min.'" ';
				$attr_str .= 'side_slip_max="'.$obj->side_slip_max.'" ';
				$attr_str .= 'alignment_camber_min="'.$obj->alignment_camber_min.'" ';
				$attr_str .= 'alignment_camber_max="'.$obj->alignment_camber_max.'" ';
				$attr_str .= 'alignment_caster_min="'.$obj->alignment_caster_min.'" ';
				$attr_str .= 'alignment_caster_max="'.$obj->alignment_caster_max.'" ';
				$attr_str .= 'alignment_toe_min="'.$obj->alignment_toe_min.'" ';
				$attr_str .= 'alignment_toe_max="'.$obj->alignment_toe_max.'" ';

				if ($vehicle_limits_class_selektiert != -1) {
					if ($obj->id_vehicle_class_limits == $vehicle_limits_class_selektiert) {
						$ret .= '<option value="' . $obj->id_vehicle_class_limits . '" ' . $attr_str . ' selected="selected">' . $obj->class_name . '</option>';
					} else {
						$ret .= '<option value="' . $obj->id_vehicle_class_limits . '" ' . $attr_str . '>' . $obj->class_name . '</option>';
					}
				} else {
					$ret .= '<option value="' . $obj->id_vehicle_class_limits . '" ' . $attr_str . '>' . $obj->class_name . '</option>';
				} // end if
			} // end while ($obj = DB_FetchObject($result));
			DB_FreeResult($result);

			if ($db_conn_opt == false) {
				DB_Close($dbconn);
			} // end if ($db_conn_opt == false);
		} // end if ($dbconn != false);
		
		$ret .= '</select>';
		
		return $ret;
	} // end SELECT_Vehicle_Class_Limits();

	function DB_Check_Customer ($id_customer = 0) {
		$id_customer_cnt = 0;
                            
     	$dbconn = DB_Connect_Direct();                
     	if ($dbconn != false) {
     		$query = "SELECT COUNT(id_customer) AS cnt FROM customer WHERE id_customer = '" . $id_customer . "';";
     		$result = DB_Query($dbconn, $query);
			if ($result != false) {
				if (DB_NumRows($result) > 0) {
					$object = DB_FetchObject($result);
					$id_customer_cnt = $object->cnt;
					DB_FreeResult($result);
				}
			}

     		if ($id_customer_cnt == 0) {
     			// Create Shop Systems Query
				$query  = "INSERT INTO customer (";
				$query .= "Company, Industry, flag_active ) "; 
				$query .= "VALUE ('" . $id_customer . "', 'PRIVATE', 1);";
				//echo $query;
				
				$result = DB_Query($dbconn, $query);
				if ($result != false) {
					$return_qry = "SELECT id_customer FROM customer ORDER BY id_customer DESC LIMIT 1";
					$result_return_qry = DB_Query($dbconn, $return_qry);
					if ($result_return_qry != false) {
						while ($obj_return_qry = DB_FetchObject($result_return_qry)) {
							$id_customer = $obj_return_qry->id_customer;
						}
						DB_FreeResult($obj_return_qry);
					} // end if ($result_return_qry != false);
					//DB_FreeResult($result);
				} 
     		}
			
     	} // end if ($dbconn != false);

     	DB_Close($dbconn);
		return $id_customer;
	}

	function SQL_Variablelist_From_Array($sql_var_name, $arr_var_liste, $arr_var_name) {
		$anzahl = 0;

		$ausgabe = "(";

		foreach ($arr_var_liste as $obj) {
			if ($anzahl > 0) $ausgabe .= " OR ";
			$ausgabe .= "(" . $sql_var_name . "=" . $obj->$arr_var_name . ")";
			$anzahl++;
		} // end foreach();

		$ausgabe .= ")";

		if ($anzahl > 0) return $ausgabe;
		return "";
	} // end SQL_Variablenliste_Von_Array();

	function XML_Variablelist_From_Array($sql_var_name, $arr_var_liste, $arr_var_name, $arr_seperator) {
		$anzahl = 0;

		$ausgabe = "";

		foreach ($arr_var_liste as $obj) {
			if ($anzahl > 0) $ausgabe .= $arr_seperator;
			$ausgabe .= $sql_var_name . "[" . $anzahl . "]=" . $obj->$arr_var_name;
			$anzahl++;
		} // end foreach();

		if ($anzahl > 0) return $ausgabe;
		return "";
	} // end XML_Variablenliste_Von_Array();

}// end ClassUtil
