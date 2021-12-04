<?php
//BindEvents Method @1-3EDE54F5
function BindEvents()
{
    global $dat_fam;
    $dat_fam->CCSEvents["BeforeShow"] = "dat_fam_BeforeShow";
    $dat_fam->CCSEvents["BeforeShowRow"] = "dat_fam_BeforeShowRow";
    $dat_fam->ds->CCSEvents["BeforeExecuteDelete"] = "dat_fam_ds_BeforeExecuteDelete";
}
//End BindEvents Method
$RowNumber = 0;
$FirstEmptyRow = false;
//dat_fam_BeforeShow @2-9C80E07E
function dat_fam_BeforeShow(& $sender)
{
    $dat_fam_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $dat_fam; //Compatibility
//End dat_fam_BeforeShow

//Custom Code @21-2A29BDB7
// -------------------------
    // Write your own code here.
// -------------------------
//End Custom Code

//Close dat_fam_BeforeShow @2-80144AA8
    return $dat_fam_BeforeShow;
}
//End Close dat_fam_BeforeShow

//dat_fam_BeforeShowRow @2-0702E742
function dat_fam_BeforeShowRow(& $sender)
{
    $dat_fam_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $dat_fam; //Compatibility
//End dat_fam_BeforeShowRow

//Custom Code @22-2A29BDB7
// -------------------------
    // Write your own code here.
     global $dat_fam;	
	global $RowNumber,$FirstEmptyRow;
  
  $RowNumber++;
  $dat_fam->RowIDAttribute->SetValue($RowNumber);
	
  $dat_fam->AddedRow->SetValue("false");
  
  if (($RowNumber <= $dat_fam->PageSize) && ($RowNumber <= $dat_fam->ds->RecordsCount)) {
    $dat_fam->RowNameAttribute->SetValue("FillRow");
    
  } else {
	$dat_fam->RowNameAttribute->SetValue("EmptyRow");
	$dat_fam->RowStyleAttribute->SetValue("style=\"display:none;\"");
    $dat_fam->AddedRow->SetValue("true");
    
	if (!$FirstEmptyRow) {
        $dat_fam->RowStyleAttribute->SetValue("");
		$FirstEmptyRow = true;
		
	}

	if ($dat_fam->RowsErrors[$RowNumber]) {
	    $dat_fam->RowStyleAttribute->SetValue("");
 	}
  }	 	
// -------------------------
//End Custom Code

//Close dat_fam_BeforeShowRow @2-15ECB0FC
    return $dat_fam_BeforeShowRow;
}
//End Close dat_fam_BeforeShowRow

//dat_fam_ds_BeforeExecuteDelete @2-7E2844E9
function dat_fam_ds_BeforeExecuteDelete(& $sender)
{
    $dat_fam_ds_BeforeExecuteDelete = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $dat_fam; //Compatibility
//End dat_fam_ds_BeforeExecuteDelete

//Custom Code @23-2A29BDB7
// -------------------------
    // Write your own code here.
     global $dat_fam;

  //Create a new database connection object
  $NewConn = new clsDBmadnes();
  
  //Get the where parameters
  $id_datf = $dat_fam->ds->Where;
  if (strlen($id_datf) > 0) {
    //Update the employees table
    $NewConn->query("UPDATE dat_fam SET id_datf = NULL WHERE " . $id_datf );
  }

  //Close and destroy the database connection object
  $NewConn->close();
// -------------------------
//End Custom Code

//Close dat_fam_ds_BeforeExecuteDelete @2-1B7FB5B2
    return $dat_fam_ds_BeforeExecuteDelete;
}
//End Close dat_fam_ds_BeforeExecuteDelete


?>
