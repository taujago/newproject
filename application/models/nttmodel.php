<?php
class nttmodel extends CI_Model {

	function nttmodel(){
		parent::__construct();
	}

	public function readCursor($storedProcedure, $binds) {

        //
        // This function needs two parameters:
        //
        // $storedProcedure - the name of the stored procedure to call a chamar. Ex:
        //  my_schema.my_package.my_proc(:param)
        //  
        // $binds - receives an array of associative arrays with: parameter names,
        // values and sizes
        //
        // WARNING: The first parameter must be consistent with the second one
        
            //$conn = oci_connect('scott', 'tiger', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP ........');
			$conn = $this->db->conn_id;
            if ($conn) {
                
                // Create the statement and bind the variables (parameter, value, size)
                // $curs = oci_new_cursor($conn);
                $stid = oci_parse($conn, "begin  $storedProcedure; end;");
                foreach ($binds as $variable) : 
                    //oci_bind_by_name($stid, $variable["parameter"], $variable["value"], $variable["size"]);
                	oci_bind_by_name($stid, $variable["parameter"],$variable["value"], strlen($variable["value"]));
                endforeach;
                // Create the cursor and bind it
                $p_cursor = oci_new_cursor($conn);
                oci_bind_by_name($stid, ':refc', $p_cursor, -1, OCI_B_CURSOR);

                // Execute the Statement and fetch the data
                oci_execute($stid);
                oci_execute($p_cursor, OCI_DEFAULT);
                oci_fetch_all($p_cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
                
                // Return the data
                return $data;
            }
      }



	function bpkb_detail_mon_live(){
		try {
            $variables[0] = array("parameter" => "p1", "value" => "20140101");
            $variables[1] = array("parameter" => "p2", "value" => "20141030");
            $variables[2] = array("parameter" => "p3", "value" => "0");
            return $this->readCursor("bpkb_detail_mon_live(:p1, :p2, :p3, :refc)", $variables);
        } 
        catch(exception $ex){
          echo "exception ";
          return null;
        }
	}
}


?>