<?php
//BindEvents Method @1-E6331B20
function BindEvents()
{
    global $funcionario;
    global $CCSEvents;
    $funcionario->Button_Update1->CCSEvents["OnClick"] = "funcionario_Button_Update1_OnClick";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

//funcionario_Button_Update1_OnClick @47-40F8E1CF
function funcionario_Button_Update1_OnClick(& $sender)
{
    $funcionario_Button_Update1_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $funcionario; //Compatibility
//End funcionario_Button_Update1_OnClick

//Custom Code @48-2A29BDB7
// -------------------------
    // Write your own code here.
    $funcionario->on_off->SetValue("1");
    
    $con=mysqli_connect("172.16.0.60","registro","Roacorp","registrorrhh");
// Check connection
  if (mysqli_connect_errno())
  {
  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
	//mysqli_query($con,"INSERT INTO Persons (FirstName, LastName, Age)VALUES ('Glenn', 'Quagmire',33)");
	$id_funcr = CCGetFromGet("id_func");
	mysqli_query($con,"UPDATE des_hab_temp SET p1=1 WHERE id_func='$id_funcr'");
	mysqli_close($con);
// -------------------------
//End Custom Code

//Close funcionario_Button_Update1_OnClick @47-40909CE8
    return $funcionario_Button_Update1_OnClick;
}
//End Close funcionario_Button_Update1_OnClick

//Page_BeforeShow @1-7D022E85
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Regfull_p1; //Compatibility
//End Page_BeforeShow

//Custom Code @49-2A29BDB7
// -------------------------
    // Write your own code here.
    $con=mysqli_connect("172.16.0.60","registro","Roacorp","registrorrhh");
// Check connection
  if (mysqli_connect_errno())
  {
  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
	//mysqli_query($con,"INSERT INTO Persons (FirstName, LastName, Age)VALUES ('Glenn', 'Quagmire',33)");
	/*$id_funcr = CCGetFromGet("id_func");
	$result = mysqli_query($con,"SELECT p1 from des_hab_temp WHERE id_func='$id_funcr'");
	
	while ($row = mysql_fetch_assoc($result)) {
    	$flag = $row['p1'];    
	}
	mysqli_close($con);
	*/ 
	$db = new clsDBmadnes();
	$id_funcr = CCGetFromGet("id_func");
    $SQL = "SELECT p1 from des_hab_temp WHERE id_func = " . $id_funcr ;
    $db->query($SQL);
    $Result = $db->next_record();
    if ($Result) 
    {
		$evaluacion_planes->titulo->Value = $db->f("titulo");
		$flag = $db->f("p1");
    }
    $db->close();
	
	if ( $flag == 1 )
	{
		global  $Redirect;
		$Redirect = "exito.php";

	}
	
	
// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow


?>
