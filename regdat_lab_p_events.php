<?php
//BindEvents Method @1-2EB068EE
function BindEvents()
{
    global $old_cas;
    global $permanente_docs;
    global $ult_decl;
    global $char_per;
    $old_cas->date_start->CCSEvents["BeforeShow"] = "old_cas_date_start_BeforeShow";
    $old_cas->date_cas->CCSEvents["BeforeShow"] = "old_cas_date_cas_BeforeShow";
    $old_cas->CCSEvents["AfterInsert"] = "old_cas_AfterInsert";
    $old_cas->CCSEvents["AfterUpdate"] = "old_cas_AfterUpdate";
    $permanente_docs->date_cad_ci->CCSEvents["BeforeShow"] = "permanente_docs_date_cad_ci_BeforeShow";
    $ult_decl->date_dbr->CCSEvents["BeforeShow"] = "ult_decl_date_dbr_BeforeShow";
    $ult_decl->date_di->CCSEvents["BeforeShow"] = "ult_decl_date_di_BeforeShow";
    $char_per->date_des->CCSEvents["BeforeShow"] = "char_per_date_des_BeforeShow";
}
//End BindEvents Method

//old_cas_date_start_BeforeShow @26-3026D56F
function old_cas_date_start_BeforeShow(& $sender)
{
    $old_cas_date_start_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $old_cas; //Compatibility
//End old_cas_date_start_BeforeShow

//Close old_cas_date_start_BeforeShow @26-8373C149
    return $old_cas_date_start_BeforeShow;
}
//End Close old_cas_date_start_BeforeShow

//old_cas_date_cas_BeforeShow @28-3E7D4F16
function old_cas_date_cas_BeforeShow(& $sender)
{
    $old_cas_date_cas_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $old_cas; //Compatibility
//End old_cas_date_cas_BeforeShow

//Close old_cas_date_cas_BeforeShow @28-D0EEB54B
    return $old_cas_date_cas_BeforeShow;
}
//End Close old_cas_date_cas_BeforeShow

//old_cas_AfterInsert @18-EF451CDD
function old_cas_AfterInsert(& $sender)
{
    $old_cas_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $old_cas; //Compatibility
//End old_cas_AfterInsert

//Custom Code @110-2A29BDB7
// -------------------------
    // Write your own code here.
    
      $con=mysqli_connect("localhost","root","","ssrp");

	  if (mysqli_connect_errno())
	  {
	  	echo "Failed to connect to MySQL SSRP: " . mysqli_connect_error();
	  }
	
	 $id_funcr = CCGetFromGet("id_func");
	 $id_per = CCGetFromGet("id_per"); 
	 $date_start = $old_cas->date_start->GetText();
	 $date_cas = $old_cas->date_cas->GetText();
	 $year_rat = $old_cas->year_rat->GetValue();
	 $month_rat = $old_cas->month_rat->GetValue();
	 $day_rat = $old_cas->day_rat->GetValue();
	 
	
	$SQLQ =  "INSERT INTO old_cas (id_func, id_per, date_start,  date_cas, year_rat, month_rat, day_rat) VALUES ('$id_funcr ', '$id_per', '$date_start', '$date_cas', '$year_rat', '$month_rat', '$day_rat' )";
	
	//echo "Consulta = " . $SQLQ;
	mysqli_query($con, $SQLQ);
	mysqli_close($con);
    
// -------------------------
//End Custom Code

//Close old_cas_AfterInsert @18-0760D8DB
    return $old_cas_AfterInsert;
}
//End Close old_cas_AfterInsert

//old_cas_AfterUpdate @18-E603DCCC
function old_cas_AfterUpdate(& $sender)
{
    $old_cas_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $old_cas; //Compatibility
//End old_cas_AfterUpdate

//Custom Code @112-2A29BDB7
// -------------------------
    // Write your own code here.
    
      $con=mysqli_connect("localhost","root","","ssrp");

	  if (mysqli_connect_errno())
	  {
	  	echo "Failed to connect to MySQL SSRP: " . mysqli_connect_error();
	  }
	
	 $id_funcr = CCGetFromGet("id_func");
	 $id_per = CCGetFromGet("id_per"); 
	 $date_start = $old_cas->date_start->GetText();
	 $date_cas = $old_cas->date_cas->GetText();
	 $year_rat = $old_cas->year_rat->GetValue();
	 $month_rat = $old_cas->month_rat->GetValue();
	 $day_rat = $old_cas->day_rat->GetValue();
	 
	
	$SQLQ = "UPDATE old_cas SET date_start='$date_start', date_cas = '$date_cas', year_rat = '$year_rat', month_rat = '$month_rat', day_rat = '$day_rat'  WHERE id_func='$id_funcr' and id_per='$id_per' " ;
	
	
	//echo "Consulta = " . $SQLQ;
	mysqli_query($con, $SQLQ);
	mysqli_close($con);
	
// -------------------------
//End Custom Code

//Close old_cas_AfterUpdate @18-C8491954
    return $old_cas_AfterUpdate;
}
//End Close old_cas_AfterUpdate

//permanente_docs_date_cad_ci_BeforeShow @58-CAC6E7FF
function permanente_docs_date_cad_ci_BeforeShow(& $sender)
{
    $permanente_docs_date_cad_ci_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $permanente_docs; //Compatibility
//End permanente_docs_date_cad_ci_BeforeShow

//Close permanente_docs_date_cad_ci_BeforeShow @58-8FCA9D0D
    return $permanente_docs_date_cad_ci_BeforeShow;
}
//End Close permanente_docs_date_cad_ci_BeforeShow

//ult_decl_date_dbr_BeforeShow @69-229458E5
function ult_decl_date_dbr_BeforeShow(& $sender)
{
    $ult_decl_date_dbr_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $ult_decl; //Compatibility
//End ult_decl_date_dbr_BeforeShow

//Close ult_decl_date_dbr_BeforeShow @69-80E747EA
    return $ult_decl_date_dbr_BeforeShow;
}
//End Close ult_decl_date_dbr_BeforeShow

//ult_decl_date_di_BeforeShow @71-D7A72A87
function ult_decl_date_di_BeforeShow(& $sender)
{
    $ult_decl_date_di_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $ult_decl; //Compatibility
//End ult_decl_date_di_BeforeShow

//Close ult_decl_date_di_BeforeShow @71-4120FFF6
    return $ult_decl_date_di_BeforeShow;
}
//End Close ult_decl_date_di_BeforeShow

//char_per_date_des_BeforeShow @103-5628111B
function char_per_date_des_BeforeShow(& $sender)
{
    $char_per_date_des_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $char_per; //Compatibility
//End char_per_date_des_BeforeShow

//Close char_per_date_des_BeforeShow @103-9D56A6AE
    return $char_per_date_des_BeforeShow;
}
//End Close char_per_date_des_BeforeShow


?>
