<?php
//Include Common Files @1-D425BF72
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "Reg_cap_per.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridcapacitacion { //capacitacion class @2-534A6BBD

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

//Class_Initialize Event @2-93F414F1
    function clsGridcapacitacion($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "capacitacion";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid capacitacion";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clscapacitacionDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<BR>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->id_cap = new clsControl(ccsLink, "id_cap", "id_cap", ccsInteger, "", CCGetRequestParam("id_cap", ccsGet, NULL), $this);
        $this->id_cap->Page = "";
        $this->name_event = new clsControl(ccsLabel, "name_event", "name_event", ccsText, "", CCGetRequestParam("name_event", ccsGet, NULL), $this);
        $this->date_start = new clsControl(ccsLabel, "date_start", "date_start", ccsText, "", CCGetRequestParam("date_start", ccsGet, NULL), $this);
        $this->date_end = new clsControl(ccsLabel, "date_end", "date_end", ccsText, "", CCGetRequestParam("date_end", ccsGet, NULL), $this);
        $this->type_cap = new clsControl(ccsLabel, "type_cap", "type_cap", ccsText, "", CCGetRequestParam("type_cap", ccsGet, NULL), $this);
        $this->num_hrs = new clsControl(ccsLabel, "num_hrs", "num_hrs", ccsInteger, "", CCGetRequestParam("num_hrs", ccsGet, NULL), $this);
        $this->capacitacion_Insert = new clsControl(ccsLink, "capacitacion_Insert", "capacitacion_Insert", ccsText, "", CCGetRequestParam("capacitacion_Insert", ccsGet, NULL), $this);
        $this->capacitacion_Insert->Parameters = CCGetQueryString("QueryString", array("id_cap", "ccsForm"));
        $this->capacitacion_Insert->Page = "Reg_cap_per.php";
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

//Show Method @2-FFA0538B
    function Show()
    {
        $Tpl = CCGetTemplate($this);
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlid_func"] = CCGetFromGet("id_func", NULL);

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
            $this->ControlsVisible["id_cap"] = $this->id_cap->Visible;
            $this->ControlsVisible["name_event"] = $this->name_event->Visible;
            $this->ControlsVisible["date_start"] = $this->date_start->Visible;
            $this->ControlsVisible["date_end"] = $this->date_end->Visible;
            $this->ControlsVisible["type_cap"] = $this->type_cap->Visible;
            $this->ControlsVisible["num_hrs"] = $this->num_hrs->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->id_cap->SetValue($this->DataSource->id_cap->GetValue());
                $this->id_cap->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->id_cap->Parameters = CCAddParam($this->id_cap->Parameters, "id_cap", $this->DataSource->f("id_cap"));
                $this->name_event->SetValue($this->DataSource->name_event->GetValue());
                $this->date_start->SetValue($this->DataSource->date_start->GetValue());
                $this->date_end->SetValue($this->DataSource->date_end->GetValue());
                $this->type_cap->SetValue($this->DataSource->type_cap->GetValue());
                $this->num_hrs->SetValue($this->DataSource->num_hrs->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->id_cap->Show();
                $this->name_event->Show();
                $this->date_start->Show();
                $this->date_end->Show();
                $this->type_cap->Show();
                $this->num_hrs->Show();
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
        $this->capacitacion_Insert->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @2-CA367AFF
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->id_cap->Errors->ToString());
        $errors = ComposeStrings($errors, $this->name_event->Errors->ToString());
        $errors = ComposeStrings($errors, $this->date_start->Errors->ToString());
        $errors = ComposeStrings($errors, $this->date_end->Errors->ToString());
        $errors = ComposeStrings($errors, $this->type_cap->Errors->ToString());
        $errors = ComposeStrings($errors, $this->num_hrs->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End capacitacion Class @2-FCB6E20C

class clscapacitacionDataSource extends clsDBmadnes {  //capacitacionDataSource Class @2-E45E3632

//DataSource Variables @2-BF7EE52E
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $id_cap;
    public $name_event;
    public $date_start;
    public $date_end;
    public $type_cap;
    public $num_hrs;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-C060C34A
    function clscapacitacionDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid capacitacion";
        $this->Initialize();
        $this->id_cap = new clsField("id_cap", ccsInteger, "");
        
        $this->name_event = new clsField("name_event", ccsText, "");
        
        $this->date_start = new clsField("date_start", ccsText, "");
        
        $this->date_end = new clsField("date_end", ccsText, "");
        
        $this->type_cap = new clsField("type_cap", ccsText, "");
        
        $this->num_hrs = new clsField("num_hrs", ccsInteger, "");
        

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

//Prepare Method @2-9462635D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_func", ccsInteger, "", "", $this->Parameters["urlid_func"], xxxxxx, false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_func", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-3EE0CA58
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM capacitacion";
        $this->SQL = "SELECT id_cap, name_event, date_start, date_end, type_cap, num_hrs \n\n" .
        "FROM capacitacion {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-D0A4B0CF
    function SetValues()
    {
        $this->id_cap->SetDBValue(trim($this->f("id_cap")));
        $this->name_event->SetDBValue($this->f("name_event"));
        $this->date_start->SetDBValue($this->f("date_start"));
        $this->date_end->SetDBValue($this->f("date_end"));
        $this->type_cap->SetDBValue($this->f("type_cap"));
        $this->num_hrs->SetDBValue(trim($this->f("num_hrs")));
    }
//End SetValues Method

} //End capacitacionDataSource Class @2-FCB6E20C

class clsRecordcapacitacion1 { //capacitacion1 Class @21-D5C7B927

//Variables @21-9E315808

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

//Class_Initialize Event @21-4A383482
    function clsRecordcapacitacion1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record capacitacion1/Error";
        $this->DataSource = new clscapacitacion1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "capacitacion1";
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
            $this->id_func = new clsControl(ccsTextBox, "id_func", "Id Func", ccsInteger, "", CCGetRequestParam("id_func", $Method, NULL), $this);
            $this->id_func->Required = true;
            $this->name_event = new clsControl(ccsTextBox, "name_event", "Name Event", ccsText, "", CCGetRequestParam("name_event", $Method, NULL), $this);
            $this->type_cap = new clsControl(ccsRadioButton, "type_cap", "Type Cap", ccsText, "", CCGetRequestParam("type_cap", $Method, NULL), $this);
            $this->type_cap->DSType = dsListOfValues;
            $this->type_cap->Values = array(array("EXTERNA", "EXTERNA"));
            $this->date_start = new clsControl(ccsTextBox, "date_start", "Date Start", ccsText, "", CCGetRequestParam("date_start", $Method, NULL), $this);
            $this->date_end = new clsControl(ccsTextBox, "date_end", "Date End", ccsText, "", CCGetRequestParam("date_end", $Method, NULL), $this);
            $this->name_inst = new clsControl(ccsTextBox, "name_inst", "Name Inst", ccsText, "", CCGetRequestParam("name_inst", $Method, NULL), $this);
            $this->place = new clsControl(ccsTextBox, "place", "Place", ccsText, "", CCGetRequestParam("place", $Method, NULL), $this);
            $this->num_hrs = new clsControl(ccsTextBox, "num_hrs", "Num Hrs", ccsInteger, "", CCGetRequestParam("num_hrs", $Method, NULL), $this);
            $this->num_dias = new clsControl(ccsTextBox, "num_dias", "num_dias", ccsInteger, "", CCGetRequestParam("num_dias", $Method, NULL), $this);
            $this->num_meses = new clsControl(ccsTextBox, "num_meses", "num_meses", ccsInteger, "", CCGetRequestParam("num_meses", $Method, NULL), $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->type_cap->Value) && !strlen($this->type_cap->Value) && $this->type_cap->Value !== false)
                    $this->type_cap->SetText(EXTERNA);
                if(!is_array($this->num_hrs->Value) && !strlen($this->num_hrs->Value) && $this->num_hrs->Value !== false)
                    $this->num_hrs->SetText(0);
                if(!is_array($this->num_dias->Value) && !strlen($this->num_dias->Value) && $this->num_dias->Value !== false)
                    $this->num_dias->SetText(0);
                if(!is_array($this->num_meses->Value) && !strlen($this->num_meses->Value) && $this->num_meses->Value !== false)
                    $this->num_meses->SetText(0);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @21-4B941372
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_cap"] = CCGetFromGet("id_cap", NULL);
    }
//End Initialize Method

//Validate Method @21-EA47F32C
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->id_func->Validate() && $Validation);
        $Validation = ($this->name_event->Validate() && $Validation);
        $Validation = ($this->type_cap->Validate() && $Validation);
        $Validation = ($this->date_start->Validate() && $Validation);
        $Validation = ($this->date_end->Validate() && $Validation);
        $Validation = ($this->name_inst->Validate() && $Validation);
        $Validation = ($this->place->Validate() && $Validation);
        $Validation = ($this->num_hrs->Validate() && $Validation);
        $Validation = ($this->num_dias->Validate() && $Validation);
        $Validation = ($this->num_meses->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->id_func->Errors->Count() == 0);
        $Validation =  $Validation && ($this->name_event->Errors->Count() == 0);
        $Validation =  $Validation && ($this->type_cap->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_start->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_end->Errors->Count() == 0);
        $Validation =  $Validation && ($this->name_inst->Errors->Count() == 0);
        $Validation =  $Validation && ($this->place->Errors->Count() == 0);
        $Validation =  $Validation && ($this->num_hrs->Errors->Count() == 0);
        $Validation =  $Validation && ($this->num_dias->Errors->Count() == 0);
        $Validation =  $Validation && ($this->num_meses->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @21-5E256BC6
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->id_func->Errors->Count());
        $errors = ($errors || $this->name_event->Errors->Count());
        $errors = ($errors || $this->type_cap->Errors->Count());
        $errors = ($errors || $this->date_start->Errors->Count());
        $errors = ($errors || $this->date_end->Errors->Count());
        $errors = ($errors || $this->name_inst->Errors->Count());
        $errors = ($errors || $this->place->Errors->Count());
        $errors = ($errors || $this->num_hrs->Errors->Count());
        $errors = ($errors || $this->num_dias->Errors->Count());
        $errors = ($errors || $this->num_meses->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @21-288F0419
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

//InsertRow Method @21-82DDD027
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->name_event->SetValue($this->name_event->GetValue(true));
        $this->DataSource->type_cap->SetValue($this->type_cap->GetValue(true));
        $this->DataSource->date_start->SetValue($this->date_start->GetValue(true));
        $this->DataSource->date_end->SetValue($this->date_end->GetValue(true));
        $this->DataSource->name_inst->SetValue($this->name_inst->GetValue(true));
        $this->DataSource->place->SetValue($this->place->GetValue(true));
        $this->DataSource->num_hrs->SetValue($this->num_hrs->GetValue(true));
        $this->DataSource->num_dias->SetValue($this->num_dias->GetValue(true));
        $this->DataSource->num_meses->SetValue($this->num_meses->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @21-C88D70D6
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->name_event->SetValue($this->name_event->GetValue(true));
        $this->DataSource->type_cap->SetValue($this->type_cap->GetValue(true));
        $this->DataSource->date_start->SetValue($this->date_start->GetValue(true));
        $this->DataSource->date_end->SetValue($this->date_end->GetValue(true));
        $this->DataSource->name_inst->SetValue($this->name_inst->GetValue(true));
        $this->DataSource->place->SetValue($this->place->GetValue(true));
        $this->DataSource->num_hrs->SetValue($this->num_hrs->GetValue(true));
        $this->DataSource->num_dias->SetValue($this->num_dias->GetValue(true));
        $this->DataSource->num_meses->SetValue($this->num_meses->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @21-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @21-63FC09A0
    function Show()
    {
        global $CCSUseAmp;
        $Tpl = CCGetTemplate($this);
        global $FileName;
        global $CCSLocales;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->type_cap->Prepare();

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
                    $this->id_func->SetValue($this->DataSource->id_func->GetValue());
                    $this->name_event->SetValue($this->DataSource->name_event->GetValue());
                    $this->type_cap->SetValue($this->DataSource->type_cap->GetValue());
                    $this->date_start->SetValue($this->DataSource->date_start->GetValue());
                    $this->date_end->SetValue($this->DataSource->date_end->GetValue());
                    $this->name_inst->SetValue($this->DataSource->name_inst->GetValue());
                    $this->place->SetValue($this->DataSource->place->GetValue());
                    $this->num_hrs->SetValue($this->DataSource->num_hrs->GetValue());
                    $this->num_dias->SetValue($this->DataSource->num_dias->GetValue());
                    $this->num_meses->SetValue($this->DataSource->num_meses->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->id_func->Errors->ToString());
            $Error = ComposeStrings($Error, $this->name_event->Errors->ToString());
            $Error = ComposeStrings($Error, $this->type_cap->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_start->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_end->Errors->ToString());
            $Error = ComposeStrings($Error, $this->name_inst->Errors->ToString());
            $Error = ComposeStrings($Error, $this->place->Errors->ToString());
            $Error = ComposeStrings($Error, $this->num_hrs->Errors->ToString());
            $Error = ComposeStrings($Error, $this->num_dias->Errors->ToString());
            $Error = ComposeStrings($Error, $this->num_meses->Errors->ToString());
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
        $this->id_func->Show();
        $this->name_event->Show();
        $this->type_cap->Show();
        $this->date_start->Show();
        $this->date_end->Show();
        $this->name_inst->Show();
        $this->place->Show();
        $this->num_hrs->Show();
        $this->num_dias->Show();
        $this->num_meses->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End capacitacion1 Class @21-FCB6E20C

class clscapacitacion1DataSource extends clsDBmadnes {  //capacitacion1DataSource Class @21-1D25F5BF

//DataSource Variables @21-CB234D52
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
    public $id_func;
    public $name_event;
    public $type_cap;
    public $date_start;
    public $date_end;
    public $name_inst;
    public $place;
    public $num_hrs;
    public $num_dias;
    public $num_meses;
//End DataSource Variables

//DataSourceClass_Initialize Event @21-9D109641
    function clscapacitacion1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record capacitacion1/Error";
        $this->Initialize();
        $this->id_func = new clsField("id_func", ccsInteger, "");
        
        $this->name_event = new clsField("name_event", ccsText, "");
        
        $this->type_cap = new clsField("type_cap", ccsText, "");
        
        $this->date_start = new clsField("date_start", ccsText, "");
        
        $this->date_end = new clsField("date_end", ccsText, "");
        
        $this->name_inst = new clsField("name_inst", ccsText, "");
        
        $this->place = new clsField("place", ccsText, "");
        
        $this->num_hrs = new clsField("num_hrs", ccsInteger, "");
        
        $this->num_dias = new clsField("num_dias", ccsInteger, "");
        
        $this->num_meses = new clsField("num_meses", ccsInteger, "");
        

        $this->InsertFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["name_event"] = array("Name" => "name_event", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["type_cap"] = array("Name" => "type_cap", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["date_start"] = array("Name" => "date_start", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["date_end"] = array("Name" => "date_end", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["name_inst"] = array("Name" => "name_inst", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["place"] = array("Name" => "place", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["num_hrs"] = array("Name" => "num_hrs", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["num_dias"] = array("Name" => "num_dias", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["num_meses"] = array("Name" => "num_meses", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["name_event"] = array("Name" => "name_event", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["type_cap"] = array("Name" => "type_cap", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_start"] = array("Name" => "date_start", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_end"] = array("Name" => "date_end", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["name_inst"] = array("Name" => "name_inst", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["place"] = array("Name" => "place", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["num_hrs"] = array("Name" => "num_hrs", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["num_dias"] = array("Name" => "num_dias", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["num_meses"] = array("Name" => "num_meses", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @21-5AFD58B4
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_cap", ccsInteger, "", "", $this->Parameters["urlid_cap"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_cap", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @21-632DF4A0
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM capacitacion {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @21-6843F69E
    function SetValues()
    {
        $this->id_func->SetDBValue(trim($this->f("id_func")));
        $this->name_event->SetDBValue($this->f("name_event"));
        $this->type_cap->SetDBValue($this->f("type_cap"));
        $this->date_start->SetDBValue($this->f("date_start"));
        $this->date_end->SetDBValue($this->f("date_end"));
        $this->name_inst->SetDBValue($this->f("name_inst"));
        $this->place->SetDBValue($this->f("place"));
        $this->num_hrs->SetDBValue(trim($this->f("num_hrs")));
        $this->num_dias->SetDBValue(trim($this->f("num_dias")));
        $this->num_meses->SetDBValue(trim($this->f("num_meses")));
    }
//End SetValues Method

//Insert Method @21-96222ACC
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->InsertFields["name_event"]["Value"] = $this->name_event->GetDBValue(true);
        $this->InsertFields["type_cap"]["Value"] = $this->type_cap->GetDBValue(true);
        $this->InsertFields["date_start"]["Value"] = $this->date_start->GetDBValue(true);
        $this->InsertFields["date_end"]["Value"] = $this->date_end->GetDBValue(true);
        $this->InsertFields["name_inst"]["Value"] = $this->name_inst->GetDBValue(true);
        $this->InsertFields["place"]["Value"] = $this->place->GetDBValue(true);
        $this->InsertFields["num_hrs"]["Value"] = $this->num_hrs->GetDBValue(true);
        $this->InsertFields["num_dias"]["Value"] = $this->num_dias->GetDBValue(true);
        $this->InsertFields["num_meses"]["Value"] = $this->num_meses->GetDBValue(true);
        $this->SQL = CCBuildInsert("capacitacion", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @21-B57D228C
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->UpdateFields["name_event"]["Value"] = $this->name_event->GetDBValue(true);
        $this->UpdateFields["type_cap"]["Value"] = $this->type_cap->GetDBValue(true);
        $this->UpdateFields["date_start"]["Value"] = $this->date_start->GetDBValue(true);
        $this->UpdateFields["date_end"]["Value"] = $this->date_end->GetDBValue(true);
        $this->UpdateFields["name_inst"]["Value"] = $this->name_inst->GetDBValue(true);
        $this->UpdateFields["place"]["Value"] = $this->place->GetDBValue(true);
        $this->UpdateFields["num_hrs"]["Value"] = $this->num_hrs->GetDBValue(true);
        $this->UpdateFields["num_dias"]["Value"] = $this->num_dias->GetDBValue(true);
        $this->UpdateFields["num_meses"]["Value"] = $this->num_meses->GetDBValue(true);
        $this->SQL = CCBuildUpdate("capacitacion", $this->UpdateFields, $this);
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

//Delete Method @21-9D977129
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM capacitacion";
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

} //End capacitacion1DataSource Class @21-FCB6E20C

//Initialize Page @1-1B4FCAA3
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
$TemplateFileName = "Reg_cap_perr.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "./";
$PathToRootOpt = "";
$Scripts = "|js/jquery/jquery.js|js/jquery/event-manager.js|js/jquery/selectors.js|";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-3381D702
$DBmadnes = new clsDBmadnes();
$MainPage->Connections["madnes"] = & $DBmadnes;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$capacitacion = new clsGridcapacitacion("", $MainPage);
$capacitacion1 = new clsRecordcapacitacion1("", $MainPage);
$MainPage->capacitacion = & $capacitacion;
$MainPage->capacitacion1 = & $capacitacion1;
$capacitacion->Initialize();
$capacitacion1->Initialize();
$ScriptIncludes = "";
$SList = explode("|", $Scripts);
foreach ($SList as $Script) {
    if ($Script != "") $ScriptIncludes = $ScriptIncludes . "<script src=\"" . $PathToRoot . $Script . "\" type=\"text/javascript\"></script>\n";
}
$Attributes->SetValue("scriptIncludes", $ScriptIncludes);

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

//Execute Components @1-A2786DC8
$capacitacion1->Operation();
//End Execute Components

//Go to destination page @1-6C90C1FA
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmadnes->close();
    header("Location: " . $Redirect);
    unset($capacitacion);
    unset($capacitacion1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-D4C27508
$capacitacion->Show();
$capacitacion1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-F714F443
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmadnes->close();
unset($capacitacion);
unset($capacitacion1);
unset($Tpl);
//End Unload Page


?>
