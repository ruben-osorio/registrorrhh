<?php
//BindEvents Method @1-3D436027
function BindEvents()
{
    global $des_hab_temp;
    global $CCSEvents;
    $des_hab_temp->p7->CCSEvents["BeforeShow"] = "des_hab_temp_p7_BeforeShow";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

//des_hab_temp_p7_BeforeShow @93-12DBC1F8
function des_hab_temp_p7_BeforeShow(& $sender)
{
    $des_hab_temp_p7_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $des_hab_temp; //Compatibility
//End des_hab_temp_p7_BeforeShow

//Custom Code @99-2A29BDB7
// -------------------------
    // Write your own code here.
    $des_hab_temp->p7->SetValue("1");
// -------------------------
//End Custom Code

//Close des_hab_temp_p7_BeforeShow @93-8C08DB7D
    return $des_hab_temp_p7_BeforeShow;
}
//End Close des_hab_temp_p7_BeforeShow

//Page_BeforeShow @1-19A080F3
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $regdat_lab_c; //Compatibility
//End Page_BeforeShow

//Custom Code @98-2A29BDB7
// -------------------------
    // Write your own code here.
    
     $con=mysqli_connect("localhost","registroRRHH","Registro4880!","registroRRHH");
  if (mysqli_connect_errno())
  {
  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

	$db = new clsDBmadnes();
	$id_funcr = CCGetFromGet("id_func");
    $SQL = "SELECT p7 from des_hab_temp WHERE id_func = " . $id_funcr ;
    $db->query($SQL);
    $Result = $db->next_record();
    if ($Result) 
    {
		$evaluacion_planes->titulo->Value = $db->f("titulo");
		$flag = $db->f("p7");
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
