<?php
//Include Common Files @1-573A06BF
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "reg_mov_per.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridold_movc { //old_movc class @2-2ADA1A03

//Variables @2-6E51DF5A

    // Public variables
    public $ComponentType = "Grid";
    public $ComponentName;
    public $Visible;
    public $Errors;
    public $ErrorBlock;
    public $ds;
    public $DataSource;
    public $PageSize;
    public $IsEmpty;
    public $ForceIteration = false;
    public $HasRecord = false;
    public $SorterName = "";
    public $SorterDirection = "";
    public $PageNumber;
    public $RowNumber;
    public $ControlsVisible = array();

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";
    public $Attributes;

    // Grid Controls
    public $StaticControls;
    public $RowControls;
//End Variables

//Class_Initialize Event @2-FA212150
    function clsGridold_movc($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "old_movc";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid old_movc";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsold_movcDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 5;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<BR>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->id_old_mov = new clsControl(ccsLink, "id_old_mov", "id_old_mov", ccsInteger, "", CCGetRequestParam("id_old_mov", ccsGet, NULL), $this);
        $this->id_old_mov->Page = "reg_mov_per.php";
        $this->id_con = new clsControl(ccsLabel, "id_con", "id_con", ccsInteger, "", CCGetRequestParam("id_con", ccsGet, NULL), $this);
        $this->charge = new clsControl(ccsLabel, "charge", "charge", ccsText, "", CCGetRequestParam("charge", ccsGet, NULL), $this);
        $this->rea_chan = new clsControl(ccsLabel, "rea_chan", "rea_chan", ccsText, "", CCGetRequestParam("rea_chan", ccsGet, NULL), $this);
        $this->num_res = new clsControl(ccsLabel, "num_res", "num_res", ccsText, "", CCGetRequestParam("num_res", ccsGet, NULL), $this);
        $this->old_movc_Insert = new clsControl(ccsLink, "old_movc_Insert", "old_movc_Insert", ccsText, "", CCGetRequestParam("old_movc_Insert", ccsGet, NULL), $this);
        $this->old_movc_Insert->Parameters = CCGetQueryString("QueryString", array("id_old_mov", "ccsForm"));
        $this->old_movc_Insert->Page = "reg_mov_per.php";
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @2-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @2-6CD42786
    function Show()
    {
        $Tpl = & CCGetTemplate($this);
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlid_per"] = CCGetFromGet("id_per", NULL);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $this->DataSource->Prepare();
        $this->DataSource->Open();
        $this->HasRecord = $this->DataSource->has_next_record();
        $this->IsEmpty = ! $this->HasRecord;
        $this->Attributes->Show();

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) return;

        $GridBlock = "Grid " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $GridBlock;


        if (!$this->IsEmpty) {
            $this->ControlsVisible["id_old_mov"] = $this->id_old_mov->Visible;
            $this->ControlsVisible["id_con"] = $this->id_con->Visible;
            $this->ControlsVisible["charge"] = $this->charge->Visible;
            $this->ControlsVisible["rea_chan"] = $this->rea_chan->Visible;
            $this->ControlsVisible["num_res"] = $this->num_res->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->id_old_mov->SetValue($this->DataSource->id_old_mov->GetValue());
                $this->id_old_mov->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->id_old_mov->Parameters = CCAddParam($this->id_old_mov->Parameters, "id_old_mov", $this->DataSource->f("id_old_mov"));
                $this->id_con->SetValue($this->DataSource->id_con->GetValue());
                $this->charge->SetValue($this->DataSource->charge->GetValue());
                $this->rea_chan->SetValue($this->DataSource->rea_chan->GetValue());
                $this->num_res->SetValue($this->DataSource->num_res->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->id_old_mov->Show();
                $this->id_con->Show();
                $this->charge->Show();
                $this->rea_chan->Show();
                $this->num_res->Show();
                $Tpl->block_path = $ParentPath . "/" . $GridBlock;
                $Tpl->parse("Row", true);
            }
        }
        else { // Show NoRecords block if no records are found
            $this->Attributes->Show();
            $Tpl->parse("NoRecords", false);
        }

        $errors = $this->GetErrors();
        if(strlen($errors))
        {
            $Tpl->replaceblock("", $errors);
            $Tpl->block_path = $ParentPath;
            return;
        }
        $this->Navigator->PageNumber = $this->DataSource->AbsolutePage;
        $this->Navigator->PageSize = $this->PageSize;
        if ($this->DataSource->RecordsCount == "CCS not counted")
            $this->Navigator->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
        else
            $this->Navigator->TotalPages = $this->DataSource->PageCount();
        if (($this->Navigator->TotalPages <= 1 && $this->Navigator->PageNumber == 1) || $this->Navigator->PageSize == "") {
            $this->Navigator->Visible = false;
        }
        $this->old_movc_Insert->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @2-D1902093
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->id_old_mov->Errors->ToString());
        $errors = ComposeStrings($errors, $this->id_con->Errors->ToString());
        $errors = ComposeStrings($errors, $this->charge->Errors->ToString());
        $errors = ComposeStrings($errors, $this->rea_chan->Errors->ToString());
        $errors = ComposeStrings($errors, $this->num_res->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End old_movc Class @2-FCB6E20C

class clsold_movcDataSource extends clsDBmadnes {  //old_movcDataSource Class @2-FDB53798

//DataSource Variables @2-BE27FB7B
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $id_old_mov;
    public $id_con;
    public $charge;
    public $rea_chan;
    public $num_res;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-773A0E35
    function clsold_movcDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid old_movc";
        $this->Initialize();
        $this->id_old_mov = new clsField("id_old_mov", ccsInteger, "");
        
        $this->id_con = new clsField("id_con", ccsInteger, "");
        
        $this->charge = new clsField("charge", ccsText, "");
        
        $this->rea_chan = new clsField("rea_chan", ccsText, "");
        
        $this->num_res = new clsField("num_res", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-35646351
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_per", ccsInteger, "", "", $this->Parameters["urlid_per"], xxxxx, false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_per", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-F1C89541
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM old_mov";
        $this->SQL = "SELECT *, id_old_mov \n\n" .
        "FROM old_mov {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-90E05ED9
    function SetValues()
    {
        $this->id_old_mov->SetDBValue(trim($this->f("id_old_mov")));
        $this->id_con->SetDBValue(trim($this->f("id_con")));
        $this->charge->SetDBValue($this->f("charge"));
        $this->rea_chan->SetDBValue($this->f("rea_chan"));
        $this->num_res->SetDBValue($this->f("num_res"));
    }
//End SetValues Method

} //End old_movcDataSource Class @2-FCB6E20C

class clsRecordold_movc1 { //old_movc1 Class @17-385B19A0

//Variables @17-9E315808

    // Public variables
    public $ComponentType = "Record";
    public $ComponentName;
    public $Parent;
    public $HTMLFormAction;
    public $PressedButton;
    public $Errors;
    public $ErrorBlock;
    public $FormSubmitted;
    public $FormEnctype;
    public $Visible;
    public $IsEmpty;

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";

    public $InsertAllowed = false;
    public $UpdateAllowed = false;
    public $DeleteAllowed = false;
    public $ReadAllowed   = false;
    public $EditMode      = false;
    public $ds;
    public $DataSource;
    public $ValidatingControls;
    public $Controls;
    public $Attributes;

    // Class variables
//End Variables

//Class_Initialize Event @17-5EFB664D
    function clsRecordold_movc1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record old_movc1/Error";
        $this->DataSource = new clsold_movc1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "old_movc1";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->Button_Delete = new clsButton("Button_Delete", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->id_per = new clsControl(ccsTextBox, "id_per", "Id Con", ccsInteger, "", CCGetRequestParam("id_per", $Method, NULL), $this);
            $this->id_per->Required = true;
            $this->charge = new clsControl(ccsTextBox, "charge", "Charge", ccsText, "", CCGetRequestParam("charge", $Method, NULL), $this);
            $this->charge->Required = true;
            $this->rea_chan = new clsControl(ccsListBox, "rea_chan", "Rea Chan", ccsText, "", CCGetRequestParam("rea_chan", $Method, NULL), $this);
            $this->rea_chan->DSType = dsTable;
            $this->rea_chan->DataSource = new clsDBmadnes();
            $this->rea_chan->ds = & $this->rea_chan->DataSource;
            $this->rea_chan->DataSource->SQL = "SELECT *, id_motivo \n" .
"FROM motivo_cambio {SQL_Where} {SQL_OrderBy}";
            list($this->rea_chan->BoundColumn, $this->rea_chan->TextColumn, $this->rea_chan->DBFormat) = array("desc_motivo", "desc_motivo", "");
            $this->rea_chan->Required = true;
            $this->num_res = new clsControl(ccsTextBox, "num_res", "Num Res", ccsText, "", CCGetRequestParam("num_res", $Method, NULL), $this);
            $this->num_res->Required = true;
            $this->gral_dir = new clsControl(ccsListBox, "gral_dir", "Gral Dir", ccsText, "", CCGetRequestParam("gral_dir", $Method, NULL), $this);
            $this->gral_dir->DSType = dsTable;
            $this->gral_dir->DataSource = new clsDBmadnes();
            $this->gral_dir->ds = & $this->gral_dir->DataSource;
            $this->gral_dir->DataSource->SQL = "SELECT * \n" .
"FROM direccion_gral {SQL_Where} {SQL_OrderBy}";
            list($this->gral_dir->BoundColumn, $this->gral_dir->TextColumn, $this->gral_dir->DBFormat) = array("desc_dg", "desc_dg", "");
            $this->gral_dir->Required = true;
            $this->unit = new clsControl(ccsListBox, "unit", "Unit", ccsText, "", CCGetRequestParam("unit", $Method, NULL), $this);
            $this->unit->DSType = dsTable;
            $this->unit->DataSource = new clsDBmadnes();
            $this->unit->ds = & $this->unit->DataSource;
            $this->unit->DataSource->SQL = "SELECT * \n" .
"FROM unidad {SQL_Where} {SQL_OrderBy}";
            list($this->unit->BoundColumn, $this->unit->TextColumn, $this->unit->DBFormat) = array("desc_uni", "desc_uni", "");
            $this->unit->Required = true;
            $this->area = new clsControl(ccsListBox, "area", "Area", ccsText, "", CCGetRequestParam("area", $Method, NULL), $this);
            $this->area->DSType = dsTable;
            $this->area->DataSource = new clsDBmadnes();
            $this->area->ds = & $this->area->DataSource;
            $this->area->DataSource->SQL = "SELECT * \n" .
"FROM area {SQL_Where} {SQL_OrderBy}";
            list($this->area->BoundColumn, $this->area->TextColumn, $this->area->DBFormat) = array("desc_area", "desc_area", "");
            $this->area->Required = true;
            $this->date_start = new clsControl(ccsTextBox, "date_start", "Date Start", ccsDate, array("ShortDate"), CCGetRequestParam("date_start", $Method, NULL), $this);
            $this->date_start->Required = true;
            $this->date_end = new clsControl(ccsTextBox, "date_end", "Date End", ccsDate, array("ShortDate"), CCGetRequestParam("date_end", $Method, NULL), $this);
            $this->date_end->Required = true;
        }
    }
//End Class_Initialize Event

//Initialize Method @17-90F09B1E
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_old_mov"] = CCGetFromGet("id_old_mov", NULL);
    }
//End Initialize Method

//Validate Method @17-B6DD0C21
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->id_per->Validate() && $Validation);
        $Validation = ($this->charge->Validate() && $Validation);
        $Validation = ($this->rea_chan->Validate() && $Validation);
        $Validation = ($this->num_res->Validate() && $Validation);
        $Validation = ($this->gral_dir->Validate() && $Validation);
        $Validation = ($this->unit->Validate() && $Validation);
        $Validation = ($this->area->Validate() && $Validation);
        $Validation = ($this->date_start->Validate() && $Validation);
        $Validation = ($this->date_end->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->id_per->Errors->Count() == 0);
        $Validation =  $Validation && ($this->charge->Errors->Count() == 0);
        $Validation =  $Validation && ($this->rea_chan->Errors->Count() == 0);
        $Validation =  $Validation && ($this->num_res->Errors->Count() == 0);
        $Validation =  $Validation && ($this->gral_dir->Errors->Count() == 0);
        $Validation =  $Validation && ($this->unit->Errors->Count() == 0);
        $Validation =  $Validation && ($this->area->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_start->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_end->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @17-AC37687E
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->id_per->Errors->Count());
        $errors = ($errors || $this->charge->Errors->Count());
        $errors = ($errors || $this->rea_chan->Errors->Count());
        $errors = ($errors || $this->num_res->Errors->Count());
        $errors = ($errors || $this->gral_dir->Errors->Count());
        $errors = ($errors || $this->unit->Errors->Count());
        $errors = ($errors || $this->area->Errors->Count());
        $errors = ($errors || $this->date_start->Errors->Count());
        $errors = ($errors || $this->date_end->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @17-288F0419
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->DataSource->Prepare();
        if(!$this->FormSubmitted) {
            $this->EditMode = $this->DataSource->AllParametersSet;
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            } else if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button_Delete->Pressed) {
                $this->PressedButton = "Button_Delete";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Delete") {
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Cancel") {
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update") {
                if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update) || !$this->UpdateRow()) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//InsertRow Method @17-19234231
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->id_per->SetValue($this->id_per->GetValue(true));
        $this->DataSource->charge->SetValue($this->charge->GetValue(true));
        $this->DataSource->rea_chan->SetValue($this->rea_chan->GetValue(true));
        $this->DataSource->num_res->SetValue($this->num_res->GetValue(true));
        $this->DataSource->gral_dir->SetValue($this->gral_dir->GetValue(true));
        $this->DataSource->unit->SetValue($this->unit->GetValue(true));
        $this->DataSource->area->SetValue($this->area->GetValue(true));
        $this->DataSource->date_start->SetValue($this->date_start->GetValue(true));
        $this->DataSource->date_end->SetValue($this->date_end->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @17-D031A015
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->id_per->SetValue($this->id_per->GetValue(true));
        $this->DataSource->charge->SetValue($this->charge->GetValue(true));
        $this->DataSource->rea_chan->SetValue($this->rea_chan->GetValue(true));
        $this->DataSource->num_res->SetValue($this->num_res->GetValue(true));
        $this->DataSource->gral_dir->SetValue($this->gral_dir->GetValue(true));
        $this->DataSource->unit->SetValue($this->unit->GetValue(true));
        $this->DataSource->area->SetValue($this->area->GetValue(true));
        $this->DataSource->date_start->SetValue($this->date_start->GetValue(true));
        $this->DataSource->date_end->SetValue($this->date_end->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @17-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @17-2B4F42CF
    function Show()
    {
        global $CCSUseAmp;
        $Tpl = & CCGetTemplate($this);
        global $FileName;
        global $CCSLocales;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->rea_chan->Prepare();
        $this->gral_dir->Prepare();
        $this->unit->Prepare();
        $this->area->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if($this->EditMode) {
            if($this->DataSource->Errors->Count()){
                $this->Errors->AddErrors($this->DataSource->Errors);
                $this->DataSource->Errors->clear();
            }
            $this->DataSource->Open();
            if($this->DataSource->Errors->Count() == 0 && $this->DataSource->next_record()) {
                $this->DataSource->SetValues();
                if(!$this->FormSubmitted){
                    $this->id_per->SetValue($this->DataSource->id_per->GetValue());
                    $this->charge->SetValue($this->DataSource->charge->GetValue());
                    $this->rea_chan->SetValue($this->DataSource->rea_chan->GetValue());
                    $this->num_res->SetValue($this->DataSource->num_res->GetValue());
                    $this->gral_dir->SetValue($this->DataSource->gral_dir->GetValue());
                    $this->unit->SetValue($this->DataSource->unit->GetValue());
                    $this->area->SetValue($this->DataSource->area->GetValue());
                    $this->date_start->SetValue($this->DataSource->date_start->GetValue());
                    $this->date_end->SetValue($this->DataSource->date_end->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->id_per->Errors->ToString());
            $Error = ComposeStrings($Error, $this->charge->Errors->ToString());
            $Error = ComposeStrings($Error, $this->rea_chan->Errors->ToString());
            $Error = ComposeStrings($Error, $this->num_res->Errors->ToString());
            $Error = ComposeStrings($Error, $this->gral_dir->Errors->ToString());
            $Error = ComposeStrings($Error, $this->unit->Errors->ToString());
            $Error = ComposeStrings($Error, $this->area->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_start->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_end->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);
        $this->Button_Insert->Visible = !$this->EditMode && $this->InsertAllowed;
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;
        $this->Button_Delete->Visible = $this->EditMode && $this->DeleteAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Delete->Show();
        $this->Button_Cancel->Show();
        $this->id_per->Show();
        $this->charge->Show();
        $this->rea_chan->Show();
        $this->num_res->Show();
        $this->gral_dir->Show();
        $this->unit->Show();
        $this->area->Show();
        $this->date_start->Show();
        $this->date_end->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End old_movc1 Class @17-FCB6E20C

class clsold_movc1DataSource extends clsDBmadnes {  //old_movc1DataSource Class @17-2B3F5448

//DataSource Variables @17-0EDA92EE
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $DeleteParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $id_per;
    public $charge;
    public $rea_chan;
    public $num_res;
    public $gral_dir;
    public $unit;
    public $area;
    public $date_start;
    public $date_end;
//End DataSource Variables

//DataSourceClass_Initialize Event @17-94D38F20
    function clsold_movc1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record old_movc1/Error";
        $this->Initialize();
        $this->id_per = new clsField("id_per", ccsInteger, "");
        
        $this->charge = new clsField("charge", ccsText, "");
        
        $this->rea_chan = new clsField("rea_chan", ccsText, "");
        
        $this->num_res = new clsField("num_res", ccsText, "");
        
        $this->gral_dir = new clsField("gral_dir", ccsText, "");
        
        $this->unit = new clsField("unit", ccsText, "");
        
        $this->area = new clsField("area", ccsText, "");
        
        $this->date_start = new clsField("date_start", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->date_end = new clsField("date_end", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        

        $this->InsertFields["id_per"] = array("Name" => "id_per", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["charge"] = array("Name" => "charge", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["rea_chan"] = array("Name" => "rea_chan", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["num_res"] = array("Name" => "num_res", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["gral_dir"] = array("Name" => "gral_dir", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["unit"] = array("Name" => "unit", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["area"] = array("Name" => "area", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["date_start"] = array("Name" => "date_start", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["date_end"] = array("Name" => "date_end", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_per"] = array("Name" => "id_per", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["charge"] = array("Name" => "charge", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["rea_chan"] = array("Name" => "rea_chan", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["num_res"] = array("Name" => "num_res", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["gral_dir"] = array("Name" => "gral_dir", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["unit"] = array("Name" => "unit", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["area"] = array("Name" => "area", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_start"] = array("Name" => "date_start", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_end"] = array("Name" => "date_end", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @17-98F38026
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_old_mov", ccsInteger, "", "", $this->Parameters["urlid_old_mov"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_old_mov", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @17-0AE2F316
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT *, id_old_mov \n\n" .
        "FROM old_mov {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @17-A44F9674
    function SetValues()
    {
        $this->id_per->SetDBValue(trim($this->f("id_per")));
        $this->charge->SetDBValue($this->f("charge"));
        $this->rea_chan->SetDBValue($this->f("rea_chan"));
        $this->num_res->SetDBValue($this->f("num_res"));
        $this->gral_dir->SetDBValue($this->f("gral_dir"));
        $this->unit->SetDBValue($this->f("unit"));
        $this->area->SetDBValue($this->f("area"));
        $this->date_start->SetDBValue(trim($this->f("date_start")));
        $this->date_end->SetDBValue(trim($this->f("date_end")));
    }
//End SetValues Method

//Insert Method @17-7F3E1025
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["id_per"]["Value"] = $this->id_per->GetDBValue(true);
        $this->InsertFields["charge"]["Value"] = $this->charge->GetDBValue(true);
        $this->InsertFields["rea_chan"]["Value"] = $this->rea_chan->GetDBValue(true);
        $this->InsertFields["num_res"]["Value"] = $this->num_res->GetDBValue(true);
        $this->InsertFields["gral_dir"]["Value"] = $this->gral_dir->GetDBValue(true);
        $this->InsertFields["unit"]["Value"] = $this->unit->GetDBValue(true);
        $this->InsertFields["area"]["Value"] = $this->area->GetDBValue(true);
        $this->InsertFields["date_start"]["Value"] = $this->date_start->GetDBValue(true);
        $this->InsertFields["date_end"]["Value"] = $this->date_end->GetDBValue(true);
        $this->SQL = CCBuildInsert("old_mov", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @17-E72F23DD
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["id_per"]["Value"] = $this->id_per->GetDBValue(true);
        $this->UpdateFields["charge"]["Value"] = $this->charge->GetDBValue(true);
        $this->UpdateFields["rea_chan"]["Value"] = $this->rea_chan->GetDBValue(true);
        $this->UpdateFields["num_res"]["Value"] = $this->num_res->GetDBValue(true);
        $this->UpdateFields["gral_dir"]["Value"] = $this->gral_dir->GetDBValue(true);
        $this->UpdateFields["unit"]["Value"] = $this->unit->GetDBValue(true);
        $this->UpdateFields["area"]["Value"] = $this->area->GetDBValue(true);
        $this->UpdateFields["date_start"]["Value"] = $this->date_start->GetDBValue(true);
        $this->UpdateFields["date_end"]["Value"] = $this->date_end->GetDBValue(true);
        $this->SQL = CCBuildUpdate("old_mov", $this->UpdateFields, $this);
        $this->SQL .= strlen($this->Where) ? " WHERE " . $this->Where : $this->Where;
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

//Delete Method @17-AB511F52
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM old_mov";
        $this->SQL = CCBuildSQL($this->SQL, $this->Where, "");
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
    }
//End Delete Method

} //End old_movc1DataSource Class @17-FCB6E20C

//Initialize Page @1-0F7B5659
// Variables
$FileName = "";
$Redirect = "";
$Tpl = "";
$TemplateFileName = "";
$BlockToParse = "";
$ComponentName = "";
$Attributes = "";

// Events;
$CCSEvents = "";
$CCSEventResult = "";
$TemplateSource = "";

$FileName = FileName;
$Redirect = "";
$TemplateFileName = "reg_mov_perr.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-470532E6
$DBmadnes = new clsDBmadnes();
$MainPage->Connections["madnes"] = & $DBmadnes;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$old_movc = new clsGridold_movc("", $MainPage);
$old_movc1 = new clsRecordold_movc1("", $MainPage);
$MainPage->old_movc = & $old_movc;
$MainPage->old_movc1 = & $old_movc1;
$old_movc->Initialize();
$old_movc1->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize", $MainPage);

if ($Charset) {
    header("Content-Type: " . $ContentType . "; charset=" . $Charset);
} else {
    header("Content-Type: " . $ContentType);
}
//End Initialize Objects

//Initialize HTML Template @1-28F2FDD6
$CCSEventResult = CCGetEvent($CCSEvents, "OnInitializeView", $MainPage);
$Tpl = new clsTemplate($FileEncoding, $TemplateEncoding);
if (strlen($TemplateSource)) {
    $Tpl->LoadTemplateFromStr($TemplateSource, $BlockToParse, "UTF-8");
} else {
    $Tpl->LoadTemplate(PathToCurrentPage . $TemplateFileName, $BlockToParse, "UTF-8");
}
$Tpl->SetVar("CCS_PathToRoot", $PathToRoot);
$Tpl->block_path = "/$BlockToParse";
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow", $MainPage);
$Attributes->SetValue("pathToRoot", "");
$Attributes->Show();
//End Initialize HTML Template

//Execute Components @1-2B609710
$old_movc1->Operation();
//End Execute Components

//Go to destination page @1-8D87080D
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmadnes->close();
    header("Location: " . $Redirect);
    unset($old_movc);
    unset($old_movc1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-7088B843
$old_movc->Show();
$old_movc1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-872F374E
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmadnes->close();
unset($old_movc);
unset($old_movc1);
unset($Tpl);
//End Unload Page


?>
