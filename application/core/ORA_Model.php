<?php
class ORA_Model extends CI_Model {
	function ORA_Model () {
		parent::__construct();
	}


	public Function readCursor($storedProcedure, $binds) {

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
                $stid = oci_parse($conn, 'begin :cursor := ' . $storedProcedure . '; end;');
                foreach ($binds as $variable)
                    oci_bind_by_name($stid, $variable["parameter"], $variable["value"], strlen($variable["value"]));

                // Create the cursor and bind it
                $p_cursor = oci_new_cursor($conn);
                oci_bind_by_name($stid, ':cursor', $p_cursor, -1, OCI_B_CURSOR);

                // Execute the Statement and fetch the data
                oci_execute($stid);
                oci_execute($p_cursor, OCI_DEFAULT);
                oci_fetch_all($p_cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
                
                // Return the data
                return $data;
            }
      }

      function call_function($sql) {

        // echo "did i called ";
            $conn = $this->db->conn_id;
            if($conn){
                $stdin = oci_parse($conn, $sql);
                // foreach($param as $vars) : 
                //     oci_bind_by_name($stid,$vars['parameter'],$vars['value']);
                // endforeach;
                oci_execute($stdin);
                $row = oci_fetch_array($stdin, OCI_ASSOC);
                // show_array($row);
                return $row;
            }
            else {
                return array("MSG"=>"error");
            }
      }


}

?>