<H1> BPKB ONLINE SERVICE TESTER </H1>

<form action="<?php echo site_url("test/exectest"); ?>" target="blank" method="post">
  <p>Webservice URL : <br /> 
  <input type="text" name="url" size="100" value="http://localhost/bpkbonline/index.php/rocknroll"> <br /> 
    Method Name : <br />
  <input type="text" name="method" value="bpkb_login"> <br />
    Input Parameter (put your json input parameter here) : <br /> 
  <textarea name="param" cols="70" rows="20" lines="50" >{
   "LoginInfo":{
      "LoginName":"3PILAR",
      "Salt":"1234556678",
      "AuthHash":"1ab75effd36c5a90ae0f86ae4fbe9dd7"
   },
   "Param":{
      "v_user_name":"upie",
      "v_password":"upie",
      "v_id_alat":"PMJ001"
   }
}</textarea>
  <br />
  Format Data : <br />
  <select name="format" id="format">
    <option value="xml" selected="selected">XML</option>
    <option value="text">Plain Text</option>
  </select>
  <br />
  <input type="submit" name="button" id="button" value="Submit" />
  </p>
</form>