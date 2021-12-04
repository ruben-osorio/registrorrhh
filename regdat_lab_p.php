<?php
//Include Common Files @1-6F92102B
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "regdat_lab_p.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordsoc_secu { //soc_secu Class @2-AD7C29B2

//Variables @2-9E315808

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

//Class_Initialize Event @2-829A5280
    function clsRecordsoc_secu($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record soc_secu/Error";
        $this->DataSource = new clssoc_secuDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "soc_secu";
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
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->id_func = new clsControl(ccsTextBox, "id_func", "Id Func", ccsInteger, "", CCGetRequestParam("id_func", $Method, NULL), $this);
            $this->id_func->Required = true;
            $this->id_per = new clsControl(ccsTextBox, "id_per", "Id Per", ccsInteger, "", CCGetRequestParam("id_per", $Method, NULL), $this);
            $this->id_per->Required = true;
            $this->name_sec = new clsControl(ccsTextBox, "name_sec", "Name Sec", ccsText, "", CCGetRequestParam("name_sec", $Method, NULL), $this);
            $this->num_reg = new clsControl(ccsTextBox, "num_reg", "Num Reg", ccsText, "", CCGetRequestParam("num_reg", $Method, NULL), $this);
            $this->type_sec = new clsControl(ccsRadioButton, "type_sec", "Type Sec", ccsText, "", CCGetRequestParam("type_sec", $Method, NULL), $this);
            $this->type_sec->DSType = dsListOfValues;
            $this->type_sec->Values = array(array("TITULAR", "TITULAR"), array("BENEFICIARIO", "BENEFICIARIO"));
        }
    }
//End Class_Initialize Event

//Initialize Method @2-227E801F
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_per"] = CCGetFromGet("id_per", NULL);
        $this->DataSource->Parameters["urlid_func"] = CCGetFromGet("id_func", NULL);
    }
//End Initialize Method

//Validate Method @2-60C5A867
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->id_func->Validate() && $Validation);
        $Validation = ($this->id_per->Validate() && $Validation);
        $Validation = ($this->name_sec->Validate() && $Validation);
        $Validation = ($this->num_reg->Validate() && $Validation);
        $Validation = ($this->type_sec->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->id_func->Errors->Count() == 0);
        $Validation =  $Validation && ($this->id_per->Errors->Count() == 0);
        $Validation =  $Validation && ($this->name_sec->Errors->Count() == 0);
        $Validation =  $Validation && ($this->num_reg->Errors->Count() == 0);
        $Validation =  $Validation && ($this->type_sec->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-538BA291
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->id_func->Errors->Count());
        $errors = ($errors || $this->id_per->Errors->Count());
        $errors = ($errors || $this->name_sec->Errors->Count());
        $errors = ($errors || $this->num_reg->Errors->Count());
        $errors = ($errors || $this->type_sec->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @2-0BF2B389
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
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
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

//InsertRow Method @2-F8B047E9
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->id_per->SetValue($this->id_per->GetValue(true));
        $this->DataSource->name_sec->SetValue($this->name_sec->GetValue(true));
        $this->DataSource->num_reg->SetValue($this->num_reg->GetValue(true));
        $this->DataSource->type_sec->SetValue($this->type_sec->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @2-7AA884BB
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->id_per->SetValue($this->id_per->GetValue(true));
        $this->DataSource->name_sec->SetValue($this->name_sec->GetValue(true));
        $this->DataSource->num_reg->SetValue($this->num_reg->GetValue(true));
        $this->DataSource->type_sec->SetValue($this->type_sec->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @2-F2F8148F
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

        $this->type_sec->Prepare();

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
                    $this->id_per->SetValue($this->DataSource->id_per->GetValue());
                    $this->name_sec->SetValue($this->DataSource->name_sec->GetValue());
                    $this->num_reg->SetValue($this->DataSource->num_reg->GetValue());
                    $this->type_sec->SetValue($this->DataSource->type_sec->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->id_func->Errors->ToString());
            $Error = ComposeStrings($Error, $this->id_per->Errors->ToString());
            $Error = ComposeStrings($Error, $this->name_sec->Errors->ToString());
            $Error = ComposeStrings($Error, $this->num_reg->Errors->ToString());
            $Error = ComposeStrings($Error, $this->type_sec->Errors->ToString());
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

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Cancel->Show();
        $this->id_func->Show();
        $this->id_per->Show();
        $this->name_sec->Show();
        $this->num_reg->Show();
        $this->type_sec->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End soc_secu Class @2-FCB6E20C

class clssoc_secuDataSource extends clsDBmadnes {  //soc_secuDataSource Class @2-B0ADEF16

//DataSource Variables @2-AED41EE6
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $id_func;
    public $id_per;
    public $name_sec;
    public $num_reg;
    public $type_sec;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-6DB46DA8
    function clssoc_secuDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record soc_secu/Error";
        $this->Initialize();
        $this->id_func = new clsField("id_func", ccsInteger, "");
        
        $this->id_per = new clsField("id_per", ccsInteger, "");
        
        $this->name_sec = new clsField("name_sec", ccsText, "");
        
        $this->num_reg = new clsField("num_reg", ccsText, "");
        
        $this->type_sec = new clsField("type_sec", ccsText, "");
        

        $this->InsertFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["id_per"] = array("Name" => "id_per", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["name_sec"] = array("Name" => "name_sec", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["num_reg"] = array("Name" => "num_reg", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["type_sec"] = array("Name" => "type_sec", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_per"] = array("Name" => "id_per", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["name_sec"] = array("Name" => "name_sec", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["num_reg"] = array("Name" => "num_reg", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["type_sec"] = array("Name" => "type_sec", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-C462AF3D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_per", ccsInteger, "", "", $this->Parameters["urlid_per"], XXXX, false);
        $this->wp->AddParameter("2", "urlid_func", ccsInteger, "", "", $this->Parameters["urlid_func"], XXXXXX, false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_per", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "id_func", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @2-2319B6A8
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM soc_secu {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-1382F35F
    function SetValues()
    {
        $this->id_func->SetDBValue(trim($this->f("id_func")));
        $this->id_per->SetDBValue(trim($this->f("id_per")));
        $this->name_sec->SetDBValue($this->f("name_sec"));
        $this->num_reg->SetDBValue($this->f("num_reg"));
        $this->type_sec->SetDBValue($this->f("type_sec"));
    }
//End SetValues Method

//Insert Method @2-7A963CE2
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->InsertFields["id_per"]["Value"] = $this->id_per->GetDBValue(true);
        $this->InsertFields["name_sec"]["Value"] = $this->name_sec->GetDBValue(true);
        $this->InsertFields["num_reg"]["Value"] = $this->num_reg->GetDBValue(true);
        $this->InsertFields["type_sec"]["Value"] = $this->type_sec->GetDBValue(true);
        $this->SQL = CCBuildInsert("soc_secu", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-0337E43B
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->UpdateFields["id_per"]["Value"] = $this->id_per->GetDBValue(true);
        $this->UpdateFields["name_sec"]["Value"] = $this->name_sec->GetDBValue(true);
        $this->UpdateFields["num_reg"]["Value"] = $this->num_reg->GetDBValue(true);
        $this->UpdateFields["type_sec"]["Value"] = $this->type_sec->GetDBValue(true);
        $this->SQL = CCBuildUpdate("soc_secu", $this->UpdateFields, $this);
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

} //End soc_secuDataSource Class @2-FCB6E20C

class clsRecordold_cas { //old_cas Class @18-E9584A63

//Variables @18-9E315808

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

//Class_Initialize Event @18-917358A6
    function clsRecordold_cas($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record old_cas/Error";
        $this->DataSource = new clsold_casDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "old_cas";
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
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->id_func = new clsControl(ccsTextBox, "id_func", "Id Func", ccsInteger, "", CCGetRequestParam("id_func", $Method, NULL), $this);
            $this->id_func->Required = true;
            $this->id_per = new clsControl(ccsTextBox, "id_per", "Id Per", ccsInteger, "", CCGetRequestParam("id_per", $Method, NULL), $this);
            $this->id_per->Required = true;
            $this->date_start = new clsControl(ccsTextBox, "date_start", "Date Start", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("date_start", $Method, NULL), $this);
            $this->date_cas = new clsControl(ccsTextBox, "date_cas", "Date Cas", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("date_cas", $Method, NULL), $this);
            $this->year_rat = new clsControl(ccsTextBox, "year_rat", "Year Rat", ccsInteger, "", CCGetRequestParam("year_rat", $Method, NULL), $this);
            $this->month_rat = new clsControl(ccsTextBox, "month_rat", "Month Rat", ccsInteger, "", CCGetRequestParam("month_rat", $Method, NULL), $this);
            $this->day_rat = new clsControl(ccsTextBox, "day_rat", "Day Rat", ccsInteger, "", CCGetRequestParam("day_rat", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @18-BFFB90AD
    function Initialize()
    {

        if(!$this->Visible)
            return;
	
        $this->DataSource->Parameters["urlid_per"] = CCGetFromGet("id_per", NULL);
    }
//End Initialize Method

//Validate Method @18-7FCE9836
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->id_func->Validate() && $Validation);
        $Validation = ($this->id_per->Validate() && $Validation);
        $Validation = ($this->date_start->Validate() && $Validation);
        $Validation = ($this->date_cas->Validate() && $Validation);
        $Validation = ($this->year_rat->Validate() && $Validation);
        $Validation = ($this->month_rat->Validate() && $Validation);
        $Validation = ($this->day_rat->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->id_func->Errors->Count() == 0);
        $Validation =  $Validation && ($this->id_per->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_start->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_cas->Errors->Count() == 0);
        $Validation =  $Validation && ($this->year_rat->Errors->Count() == 0);
        $Validation =  $Validation && ($this->month_rat->Errors->Count() == 0);
        $Validation =  $Validation && ($this->day_rat->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @18-931EB8BF
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->id_func->Errors->Count());
        $errors = ($errors || $this->id_per->Errors->Count());
        $errors = ($errors || $this->date_start->Errors->Count());
        $errors = ($errors || $this->date_cas->Errors->Count());
        $errors = ($errors || $this->year_rat->Errors->Count());
        $errors = ($errors || $this->month_rat->Errors->Count());
        $errors = ($errors || $this->day_rat->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @18-0BF2B389
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
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
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

//InsertRow Method @18-46A04CFC
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->id_per->SetValue($this->id_per->GetValue(true));
        $this->DataSource->date_start->SetValue($this->date_start->GetValue(true));
        $this->DataSource->date_cas->SetValue($this->date_cas->GetValue(true));
        $this->DataSource->year_rat->SetValue($this->year_rat->GetValue(true));
        $this->DataSource->month_rat->SetValue($this->month_rat->GetValue(true));
        $this->DataSource->day_rat->SetValue($this->day_rat->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @18-4ED7F202
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->id_per->SetValue($this->id_per->GetValue(true));
        $this->DataSource->date_start->SetValue($this->date_start->GetValue(true));
        $this->DataSource->date_cas->SetValue($this->date_cas->GetValue(true));
        $this->DataSource->year_rat->SetValue($this->year_rat->GetValue(true));
        $this->DataSource->month_rat->SetValue($this->month_rat->GetValue(true));
        $this->DataSource->day_rat->SetValue($this->day_rat->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @18-7C185C21
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
                    $this->id_per->SetValue($this->DataSource->id_per->GetValue());
                    $this->date_start->SetValue($this->DataSource->date_start->GetValue());
                    $this->date_cas->SetValue($this->DataSource->date_cas->GetValue());
                    $this->year_rat->SetValue($this->DataSource->year_rat->GetValue());
                    $this->month_rat->SetValue($this->DataSource->month_rat->GetValue());
                    $this->day_rat->SetValue($this->DataSource->day_rat->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->id_func->Errors->ToString());
            $Error = ComposeStrings($Error, $this->id_per->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_start->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_cas->Errors->ToString());
            $Error = ComposeStrings($Error, $this->year_rat->Errors->ToString());
            $Error = ComposeStrings($Error, $this->month_rat->Errors->ToString());
            $Error = ComposeStrings($Error, $this->day_rat->Errors->ToString());
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

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Cancel->Show();
        $this->id_func->Show();
        $this->id_per->Show();
        $this->date_start->Show();
        $this->date_cas->Show();
        $this->year_rat->Show();
        $this->month_rat->Show();
        $this->day_rat->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End old_cas Class @18-FCB6E20C

class clsold_casDataSource extends clsDBmadnes {  //old_casDataSource Class @18-A1D4768F

//DataSource Variables @18-122649F2
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $id_func;
    public $id_per;
    public $date_start;
    public $date_cas;
    public $year_rat;
    public $month_rat;
    public $day_rat;
//End DataSource Variables

//DataSourceClass_Initialize Event @18-FA340034
    function clsold_casDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record old_cas/Error";
        $this->Initialize();
        $this->id_func = new clsField("id_func", ccsInteger, "");
        
        $this->id_per = new clsField("id_per", ccsInteger, "");
        
        $this->date_start = new clsField("date_start", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->date_cas = new clsField("date_cas", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->year_rat = new clsField("year_rat", ccsInteger, "");
        
        $this->month_rat = new clsField("month_rat", ccsInteger, "");
        
        $this->day_rat = new clsField("day_rat", ccsInteger, "");
        

        $this->InsertFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["id_per"] = array("Name" => "id_per", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["date_start"] = array("Name" => "date_start", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["date_cas"] = array("Name" => "date_cas", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["year_rat"] = array("Name" => "year_rat", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["month_rat"] = array("Name" => "month_rat", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["day_rat"] = array("Name" => "day_rat", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_per"] = array("Name" => "id_per", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_start"] = array("Name" => "date_start", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_cas"] = array("Name" => "date_cas", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["year_rat"] = array("Name" => "year_rat", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["month_rat"] = array("Name" => "month_rat", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["day_rat"] = array("Name" => "day_rat", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @18-2519CBBC
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_per", ccsInteger, "", "", $this->Parameters["urlid_per"], XX, false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_per", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @18-0A621903
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM old_cas {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @18-77DAC0A2
    function SetValues()
    {
        $this->id_func->SetDBValue(trim($this->f("id_func")));
        $this->id_per->SetDBValue(trim($this->f("id_per")));
        $this->date_start->SetDBValue(trim($this->f("date_start")));
        $this->date_cas->SetDBValue(trim($this->f("date_cas")));
        $this->year_rat->SetDBValue(trim($this->f("year_rat")));
        $this->month_rat->SetDBValue(trim($this->f("month_rat")));
        $this->day_rat->SetDBValue(trim($this->f("day_rat")));
    }
//End SetValues Method

//Insert Method @18-2E1C9BBB
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->InsertFields["id_per"]["Value"] = $this->id_per->GetDBValue(true);
        $this->InsertFields["date_start"]["Value"] = $this->date_start->GetDBValue(true);
        $this->InsertFields["date_cas"]["Value"] = $this->date_cas->GetDBValue(true);
        $this->InsertFields["year_rat"]["Value"] = $this->year_rat->GetDBValue(true);
        $this->InsertFields["month_rat"]["Value"] = $this->month_rat->GetDBValue(true);
        $this->InsertFields["day_rat"]["Value"] = $this->day_rat->GetDBValue(true);
        $this->SQL = CCBuildInsert("old_cas", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @18-EFFEEBDC
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->UpdateFields["id_per"]["Value"] = $this->id_per->GetDBValue(true);
        $this->UpdateFields["date_start"]["Value"] = $this->date_start->GetDBValue(true);
        $this->UpdateFields["date_cas"]["Value"] = $this->date_cas->GetDBValue(true);
        $this->UpdateFields["year_rat"]["Value"] = $this->year_rat->GetDBValue(true);
        $this->UpdateFields["month_rat"]["Value"] = $this->month_rat->GetDBValue(true);
        $this->UpdateFields["day_rat"]["Value"] = $this->day_rat->GetDBValue(true);
        $this->SQL = CCBuildUpdate("old_cas", $this->UpdateFields, $this);
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

} //End old_casDataSource Class @18-FCB6E20C

class clsRecordcta_banc { //cta_banc Class @38-71505876

//Variables @38-9E315808

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

//Class_Initialize Event @38-84EB8031
    function clsRecordcta_banc($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record cta_banc/Error";
        $this->DataSource = new clscta_bancDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "cta_banc";
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
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->id_func = new clsControl(ccsTextBox, "id_func", "Id Func", ccsInteger, "", CCGetRequestParam("id_func", $Method, NULL), $this);
            $this->id_func->Required = true;
            $this->bank = new clsControl(ccsTextBox, "bank", "Bank", ccsText, "", CCGetRequestParam("bank", $Method, NULL), $this);
            $this->type_ac = new clsControl(ccsRadioButton, "type_ac", "Type Ac", ccsText, "", CCGetRequestParam("type_ac", $Method, NULL), $this);
            $this->type_ac->DSType = dsListOfValues;
            $this->type_ac->Values = array(array("CTA. CTE.", "CTA. CTE."), array("CAJA AHORRO", "CAJA AHORRO"));
            $this->num_ac = new clsControl(ccsTextBox, "num_ac", "Num Ac", ccsText, "", CCGetRequestParam("num_ac", $Method, NULL), $this);
            $this->dist_ac = new clsControl(ccsTextBox, "dist_ac", "Dist Ac", ccsText, "", CCGetRequestParam("dist_ac", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @38-BCDB0946
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_func"] = CCGetFromGet("id_func", NULL);
    }
//End Initialize Method

//Validate Method @38-AD601E05
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->id_func->Validate() && $Validation);
        $Validation = ($this->bank->Validate() && $Validation);
        $Validation = ($this->type_ac->Validate() && $Validation);
        $Validation = ($this->num_ac->Validate() && $Validation);
        $Validation = ($this->dist_ac->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->id_func->Errors->Count() == 0);
        $Validation =  $Validation && ($this->bank->Errors->Count() == 0);
        $Validation =  $Validation && ($this->type_ac->Errors->Count() == 0);
        $Validation =  $Validation && ($this->num_ac->Errors->Count() == 0);
        $Validation =  $Validation && ($this->dist_ac->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @38-FB6069BB
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->id_func->Errors->Count());
        $errors = ($errors || $this->bank->Errors->Count());
        $errors = ($errors || $this->type_ac->Errors->Count());
        $errors = ($errors || $this->num_ac->Errors->Count());
        $errors = ($errors || $this->dist_ac->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @38-0BF2B389
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
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
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

//InsertRow Method @38-735FA739
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->bank->SetValue($this->bank->GetValue(true));
        $this->DataSource->type_ac->SetValue($this->type_ac->GetValue(true));
        $this->DataSource->num_ac->SetValue($this->num_ac->GetValue(true));
        $this->DataSource->dist_ac->SetValue($this->dist_ac->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @38-87297F52
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->bank->SetValue($this->bank->GetValue(true));
        $this->DataSource->type_ac->SetValue($this->type_ac->GetValue(true));
        $this->DataSource->num_ac->SetValue($this->num_ac->GetValue(true));
        $this->DataSource->dist_ac->SetValue($this->dist_ac->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @38-0BE38E2C
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

        $this->type_ac->Prepare();

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
                    $this->bank->SetValue($this->DataSource->bank->GetValue());
                    $this->type_ac->SetValue($this->DataSource->type_ac->GetValue());
                    $this->num_ac->SetValue($this->DataSource->num_ac->GetValue());
                    $this->dist_ac->SetValue($this->DataSource->dist_ac->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->id_func->Errors->ToString());
            $Error = ComposeStrings($Error, $this->bank->Errors->ToString());
            $Error = ComposeStrings($Error, $this->type_ac->Errors->ToString());
            $Error = ComposeStrings($Error, $this->num_ac->Errors->ToString());
            $Error = ComposeStrings($Error, $this->dist_ac->Errors->ToString());
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

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Cancel->Show();
        $this->id_func->Show();
        $this->bank->Show();
        $this->type_ac->Show();
        $this->num_ac->Show();
        $this->dist_ac->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End cta_banc Class @38-FCB6E20C

class clscta_bancDataSource extends clsDBmadnes {  //cta_bancDataSource Class @38-4687C0B2

//DataSource Variables @38-EFED0965
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $id_func;
    public $bank;
    public $type_ac;
    public $num_ac;
    public $dist_ac;
//End DataSource Variables

//DataSourceClass_Initialize Event @38-580D0C94
    function clscta_bancDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record cta_banc/Error";
        $this->Initialize();
        $this->id_func = new clsField("id_func", ccsInteger, "");
        
        $this->bank = new clsField("bank", ccsText, "");
        
        $this->type_ac = new clsField("type_ac", ccsText, "");
        
        $this->num_ac = new clsField("num_ac", ccsText, "");
        
        $this->dist_ac = new clsField("dist_ac", ccsText, "");
        

        $this->InsertFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["bank"] = array("Name" => "bank", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["type_ac"] = array("Name" => "type_ac", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["num_ac"] = array("Name" => "num_ac", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["dist_ac"] = array("Name" => "dist_ac", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["bank"] = array("Name" => "bank", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["type_ac"] = array("Name" => "type_ac", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["num_ac"] = array("Name" => "num_ac", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["dist_ac"] = array("Name" => "dist_ac", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @38-21BA8987
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_func", ccsInteger, "", "", $this->Parameters["urlid_func"], xxxx, false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_func", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @38-BC938416
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM cta_banc {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @38-F054C015
    function SetValues()
    {
        $this->id_func->SetDBValue(trim($this->f("id_func")));
        $this->bank->SetDBValue($this->f("bank"));
        $this->type_ac->SetDBValue($this->f("type_ac"));
        $this->num_ac->SetDBValue($this->f("num_ac"));
        $this->dist_ac->SetDBValue($this->f("dist_ac"));
    }
//End SetValues Method

//Insert Method @38-93C4D5EA
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->InsertFields["bank"]["Value"] = $this->bank->GetDBValue(true);
        $this->InsertFields["type_ac"]["Value"] = $this->type_ac->GetDBValue(true);
        $this->InsertFields["num_ac"]["Value"] = $this->num_ac->GetDBValue(true);
        $this->InsertFields["dist_ac"]["Value"] = $this->dist_ac->GetDBValue(true);
        $this->SQL = CCBuildInsert("cta_banc", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @38-18B02579
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->UpdateFields["bank"]["Value"] = $this->bank->GetDBValue(true);
        $this->UpdateFields["type_ac"]["Value"] = $this->type_ac->GetDBValue(true);
        $this->UpdateFields["num_ac"]["Value"] = $this->num_ac->GetDBValue(true);
        $this->UpdateFields["dist_ac"]["Value"] = $this->dist_ac->GetDBValue(true);
        $this->SQL = CCBuildUpdate("cta_banc", $this->UpdateFields, $this);
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

} //End cta_bancDataSource Class @38-FCB6E20C

class clsRecordpermanente_docs { //permanente_docs Class @49-C00507A5

//Variables @49-9E315808

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

//Class_Initialize Event @49-90C5BD6B
    function clsRecordpermanente_docs($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record permanente_docs/Error";
        $this->DataSource = new clspermanente_docsDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "permanente_docs";
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
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->id_per = new clsControl(ccsTextBox, "id_per", "Id Per", ccsInteger, "", CCGetRequestParam("id_per", $Method, NULL), $this);
            $this->id_per->Required = true;
            $this->cv = new clsControl(ccsRadioButton, "cv", "Cv", ccsInteger, "", CCGetRequestParam("cv", $Method, NULL), $this);
            $this->cv->DSType = dsListOfValues;
            $this->cv->Values = array(array("0", "NO"), array("1", "SI"));
            $this->ci = new clsControl(ccsRadioButton, "ci", "Fotocopia Certificado de Nacimiento", ccsInteger, "", CCGetRequestParam("ci", $Method, NULL), $this);
            $this->ci->DSType = dsListOfValues;
            $this->ci->Values = array(array("0", "NO"), array("1", "SI"));
            $this->date_cad_ci = new clsControl(ccsTextBox, "date_cad_ci", "Date Cad Ci", ccsDate, array("ShortDate"), CCGetRequestParam("date_cad_ci", $Method, NULL), $this);
            $this->cn = new clsControl(ccsRadioButton, "cn", "Cn", ccsInteger, "", CCGetRequestParam("cn", $Method, NULL), $this);
            $this->cn->DSType = dsListOfValues;
            $this->cn->Values = array(array("0", "NO"), array("1", "SI"));
            $this->cm = new clsControl(ccsRadioButton, "cm", "Cm", ccsInteger, "", CCGetRequestParam("cm", $Method, NULL), $this);
            $this->cm->DSType = dsListOfValues;
            $this->cm->Values = array(array("0", "NO"), array("1", "SI"));
            if(!$this->FormSubmitted) {
                if(!is_array($this->ci->Value) && !strlen($this->ci->Value) && $this->ci->Value !== false)
                    $this->ci->SetText(0);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @49-BFFB90AD
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_per"] = CCGetFromGet("id_per", NULL);
    }
//End Initialize Method

//Validate Method @49-385FE1F2
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->id_per->Validate() && $Validation);
        $Validation = ($this->cv->Validate() && $Validation);
        $Validation = ($this->ci->Validate() && $Validation);
        $Validation = ($this->date_cad_ci->Validate() && $Validation);
        $Validation = ($this->cn->Validate() && $Validation);
        $Validation = ($this->cm->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->id_per->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cv->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ci->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_cad_ci->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cn->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cm->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @49-90D0B28B
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->id_per->Errors->Count());
        $errors = ($errors || $this->cv->Errors->Count());
        $errors = ($errors || $this->ci->Errors->Count());
        $errors = ($errors || $this->date_cad_ci->Errors->Count());
        $errors = ($errors || $this->cn->Errors->Count());
        $errors = ($errors || $this->cm->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @49-0BF2B389
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
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
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

//InsertRow Method @49-64330D83
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->id_per->SetValue($this->id_per->GetValue(true));
        $this->DataSource->cv->SetValue($this->cv->GetValue(true));
        $this->DataSource->ci->SetValue($this->ci->GetValue(true));
        $this->DataSource->date_cad_ci->SetValue($this->date_cad_ci->GetValue(true));
        $this->DataSource->cn->SetValue($this->cn->GetValue(true));
        $this->DataSource->cm->SetValue($this->cm->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @49-160ACFEA
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->id_per->SetValue($this->id_per->GetValue(true));
        $this->DataSource->cv->SetValue($this->cv->GetValue(true));
        $this->DataSource->ci->SetValue($this->ci->GetValue(true));
        $this->DataSource->date_cad_ci->SetValue($this->date_cad_ci->GetValue(true));
        $this->DataSource->cn->SetValue($this->cn->GetValue(true));
        $this->DataSource->cm->SetValue($this->cm->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @49-8FA255AD
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

        $this->cv->Prepare();
        $this->ci->Prepare();
        $this->cn->Prepare();
        $this->cm->Prepare();

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
                    $this->cv->SetValue($this->DataSource->cv->GetValue());
                    $this->ci->SetValue($this->DataSource->ci->GetValue());
                    $this->date_cad_ci->SetValue($this->DataSource->date_cad_ci->GetValue());
                    $this->cn->SetValue($this->DataSource->cn->GetValue());
                    $this->cm->SetValue($this->DataSource->cm->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->id_per->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cv->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ci->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_cad_ci->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cn->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cm->Errors->ToString());
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

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Cancel->Show();
        $this->id_per->Show();
        $this->cv->Show();
        $this->ci->Show();
        $this->date_cad_ci->Show();
        $this->cn->Show();
        $this->cm->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End permanente_docs Class @49-FCB6E20C

class clspermanente_docsDataSource extends clsDBmadnes {  //permanente_docsDataSource Class @49-7FA77E51

//DataSource Variables @49-C120A993
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $id_per;
    public $cv;
    public $ci;
    public $date_cad_ci;
    public $cn;
    public $cm;
//End DataSource Variables

//DataSourceClass_Initialize Event @49-F39441ED
    function clspermanente_docsDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record permanente_docs/Error";
        $this->Initialize();
        $this->id_per = new clsField("id_per", ccsInteger, "");
        
        $this->cv = new clsField("cv", ccsInteger, "");
        
        $this->ci = new clsField("ci", ccsInteger, "");
        
        $this->date_cad_ci = new clsField("date_cad_ci", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->cn = new clsField("cn", ccsInteger, "");
        
        $this->cm = new clsField("cm", ccsInteger, "");
        

        $this->InsertFields["id_per"] = array("Name" => "id_per", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["cv"] = array("Name" => "cv", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["ci"] = array("Name" => "ci", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["date_cad_ci"] = array("Name" => "date_cad_ci", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["cn"] = array("Name" => "cn", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["cm"] = array("Name" => "cm", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_per"] = array("Name" => "id_per", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["cv"] = array("Name" => "cv", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["ci"] = array("Name" => "ci", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_cad_ci"] = array("Name" => "date_cad_ci", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["cn"] = array("Name" => "cn", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["cm"] = array("Name" => "cm", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @49-FF693578
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_per", ccsInteger, "", "", $this->Parameters["urlid_per"], xxxxx, false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_per", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @49-20D9B688
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM permanente_docs {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @49-ABF6BDA7
    function SetValues()
    {
        $this->id_per->SetDBValue(trim($this->f("id_per")));
        $this->cv->SetDBValue(trim($this->f("cv")));
        $this->ci->SetDBValue(trim($this->f("ci")));
        $this->date_cad_ci->SetDBValue(trim($this->f("date_cad_ci")));
        $this->cn->SetDBValue(trim($this->f("cn")));
        $this->cm->SetDBValue(trim($this->f("cm")));
    }
//End SetValues Method

//Insert Method @49-01D5ACC4
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["id_per"]["Value"] = $this->id_per->GetDBValue(true);
        $this->InsertFields["cv"]["Value"] = $this->cv->GetDBValue(true);
        $this->InsertFields["ci"]["Value"] = $this->ci->GetDBValue(true);
        $this->InsertFields["date_cad_ci"]["Value"] = $this->date_cad_ci->GetDBValue(true);
        $this->InsertFields["cn"]["Value"] = $this->cn->GetDBValue(true);
        $this->InsertFields["cm"]["Value"] = $this->cm->GetDBValue(true);
        $this->SQL = CCBuildInsert("permanente_docs", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @49-53B2B746
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["id_per"]["Value"] = $this->id_per->GetDBValue(true);
        $this->UpdateFields["cv"]["Value"] = $this->cv->GetDBValue(true);
        $this->UpdateFields["ci"]["Value"] = $this->ci->GetDBValue(true);
        $this->UpdateFields["date_cad_ci"]["Value"] = $this->date_cad_ci->GetDBValue(true);
        $this->UpdateFields["cn"]["Value"] = $this->cn->GetDBValue(true);
        $this->UpdateFields["cm"]["Value"] = $this->cm->GetDBValue(true);
        $this->SQL = CCBuildUpdate("permanente_docs", $this->UpdateFields, $this);
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

} //End permanente_docsDataSource Class @49-FCB6E20C

class clsRecordult_decl { //ult_decl Class @62-BB501711

//Variables @62-9E315808

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

//Class_Initialize Event @62-82AA2401
    function clsRecordult_decl($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record ult_decl/Error";
        $this->DataSource = new clsult_declDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "ult_decl";
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
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->id_func = new clsControl(ccsTextBox, "id_func", "Id Func", ccsInteger, "", CCGetRequestParam("id_func", $Method, NULL), $this);
            $this->id_func->Required = true;
            $this->date_dbr = new clsControl(ccsTextBox, "date_dbr", "Date Dbr", ccsDate, array("ShortDate"), CCGetRequestParam("date_dbr", $Method, NULL), $this);
            $this->date_di = new clsControl(ccsTextBox, "date_di", "Declaración Jurada de Incompatibilidad", ccsDate, array("ShortDate"), CCGetRequestParam("date_di", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @62-BCDB0946
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_func"] = CCGetFromGet("id_func", NULL);
    }
//End Initialize Method

//Validate Method @62-E636C416
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->id_func->Validate() && $Validation);
        $Validation = ($this->date_dbr->Validate() && $Validation);
        $Validation = ($this->date_di->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->id_func->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_dbr->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_di->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @62-F94E34CA
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->id_func->Errors->Count());
        $errors = ($errors || $this->date_dbr->Errors->Count());
        $errors = ($errors || $this->date_di->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @62-0BF2B389
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
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
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

//InsertRow Method @62-51CCB176
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->date_dbr->SetValue($this->date_dbr->GetValue(true));
        $this->DataSource->date_di->SetValue($this->date_di->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @62-26620019
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->date_dbr->SetValue($this->date_dbr->GetValue(true));
        $this->DataSource->date_di->SetValue($this->date_di->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @62-550AF3F1
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
                    $this->date_dbr->SetValue($this->DataSource->date_dbr->GetValue());
                    $this->date_di->SetValue($this->DataSource->date_di->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->id_func->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_dbr->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_di->Errors->ToString());
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

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Cancel->Show();
        $this->id_func->Show();
        $this->date_dbr->Show();
        $this->date_di->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End ult_decl Class @62-FCB6E20C

class clsult_declDataSource extends clsDBmadnes {  //ult_declDataSource Class @62-01D0F3B8

//DataSource Variables @62-29D6ECB2
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $id_func;
    public $date_dbr;
    public $date_di;
//End DataSource Variables

//DataSourceClass_Initialize Event @62-69FE0EC6
    function clsult_declDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record ult_decl/Error";
        $this->Initialize();
        $this->id_func = new clsField("id_func", ccsInteger, "");
        
        $this->date_dbr = new clsField("date_dbr", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->date_di = new clsField("date_di", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        

        $this->InsertFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["date_dbr"] = array("Name" => "date_dbr", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["date_di"] = array("Name" => "date_di", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_dbr"] = array("Name" => "date_dbr", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_di"] = array("Name" => "date_di", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @62-2A5559FF
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_func", ccsInteger, "", "", $this->Parameters["urlid_func"], xxx, false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_func", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @62-895ABAB4
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM ult_decl {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @62-2BAE4D7F
    function SetValues()
    {
        $this->id_func->SetDBValue(trim($this->f("id_func")));
        $this->date_dbr->SetDBValue(trim($this->f("date_dbr")));
        $this->date_di->SetDBValue(trim($this->f("date_di")));
    }
//End SetValues Method

//Insert Method @62-345BDE8B
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->InsertFields["date_dbr"]["Value"] = $this->date_dbr->GetDBValue(true);
        $this->InsertFields["date_di"]["Value"] = $this->date_di->GetDBValue(true);
        $this->SQL = CCBuildInsert("ult_decl", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @62-42D47F50
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->UpdateFields["date_dbr"]["Value"] = $this->date_dbr->GetDBValue(true);
        $this->UpdateFields["date_di"]["Value"] = $this->date_di->GetDBValue(true);
        $this->SQL = CCBuildUpdate("ult_decl", $this->UpdateFields, $this);
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

} //End ult_declDataSource Class @62-FCB6E20C

class clsRecordchar_per { //char_per Class @87-0FEEEAC6

//Variables @87-9E315808

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

//Class_Initialize Event @87-CD5D81CD
    function clsRecordchar_per($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record char_per/Error";
        $this->DataSource = new clschar_perDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "char_per";
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
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->id_per = new clsControl(ccsTextBox, "id_per", "Id Per", ccsInteger, "", CCGetRequestParam("id_per", $Method, NULL), $this);
            $this->id_per->Required = true;
            $this->dir_g = new clsControl(ccsListBox, "dir_g", "Dir G", ccsText, "", CCGetRequestParam("dir_g", $Method, NULL), $this);
            $this->dir_g->DSType = dsTable;
            $this->dir_g->DataSource = new clsDBmadnes();
            $this->dir_g->ds = & $this->dir_g->DataSource;
            $this->dir_g->DataSource->SQL = "SELECT * \n" .
"FROM direccion_gral {SQL_Where} {SQL_OrderBy}";
            list($this->dir_g->BoundColumn, $this->dir_g->TextColumn, $this->dir_g->DBFormat) = array("desc_dg", "desc_dg", "");
            $this->unit = new clsControl(ccsListBox, "unit", "Unit", ccsText, "", CCGetRequestParam("unit", $Method, NULL), $this);
            $this->unit->DSType = dsTable;
            $this->unit->DataSource = new clsDBmadnes();
            $this->unit->ds = & $this->unit->DataSource;
            $this->unit->DataSource->SQL = "SELECT * \n" .
"FROM unidad {SQL_Where} {SQL_OrderBy}";
            list($this->unit->BoundColumn, $this->unit->TextColumn, $this->unit->DBFormat) = array("desc_uni", "desc_uni", "");
            $this->area = new clsControl(ccsListBox, "area", "Area", ccsText, "", CCGetRequestParam("area", $Method, NULL), $this);
            $this->area->DSType = dsTable;
            $this->area->DataSource = new clsDBmadnes();
            $this->area->ds = & $this->area->DataSource;
            $this->area->DataSource->SQL = "SELECT * \n" .
"FROM area {SQL_Where} {SQL_OrderBy}";
            list($this->area->BoundColumn, $this->area->TextColumn, $this->area->DBFormat) = array("desc_area", "desc_area", "");
            $this->boss_is = new clsControl(ccsTextBox, "boss_is", "Boss Is", ccsText, "", CCGetRequestParam("boss_is", $Method, NULL), $this);
            $this->boss_ij = new clsControl(ccsTextBox, "boss_ij", "Boss Ij", ccsText, "", CCGetRequestParam("boss_ij", $Method, NULL), $this);
            $this->charge = new clsControl(ccsTextArea, "charge", "Charge", ccsText, "", CCGetRequestParam("charge", $Method, NULL), $this);
            $this->date_des = new clsControl(ccsTextBox, "date_des", "Date Des", ccsDate, array("ShortDate"), CCGetRequestParam("date_des", $Method, NULL), $this);
            $this->num_memo = new clsControl(ccsTextBox, "num_memo", "Num Memo", ccsText, "", CCGetRequestParam("num_memo", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @87-BFFB90AD
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_per"] = CCGetFromGet("id_per", NULL);
    }
//End Initialize Method

//Validate Method @87-BDEDFC13
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->id_per->Validate() && $Validation);
        $Validation = ($this->dir_g->Validate() && $Validation);
        $Validation = ($this->unit->Validate() && $Validation);
        $Validation = ($this->area->Validate() && $Validation);
        $Validation = ($this->boss_is->Validate() && $Validation);
        $Validation = ($this->boss_ij->Validate() && $Validation);
        $Validation = ($this->charge->Validate() && $Validation);
        $Validation = ($this->date_des->Validate() && $Validation);
        $Validation = ($this->num_memo->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->id_per->Errors->Count() == 0);
        $Validation =  $Validation && ($this->dir_g->Errors->Count() == 0);
        $Validation =  $Validation && ($this->unit->Errors->Count() == 0);
        $Validation =  $Validation && ($this->area->Errors->Count() == 0);
        $Validation =  $Validation && ($this->boss_is->Errors->Count() == 0);
        $Validation =  $Validation && ($this->boss_ij->Errors->Count() == 0);
        $Validation =  $Validation && ($this->charge->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_des->Errors->Count() == 0);
        $Validation =  $Validation && ($this->num_memo->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @87-2B2BA4D6
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->id_per->Errors->Count());
        $errors = ($errors || $this->dir_g->Errors->Count());
        $errors = ($errors || $this->unit->Errors->Count());
        $errors = ($errors || $this->area->Errors->Count());
        $errors = ($errors || $this->boss_is->Errors->Count());
        $errors = ($errors || $this->boss_ij->Errors->Count());
        $errors = ($errors || $this->charge->Errors->Count());
        $errors = ($errors || $this->date_des->Errors->Count());
        $errors = ($errors || $this->num_memo->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @87-0BF2B389
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
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
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

//InsertRow Method @87-C36EAE2C
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->id_per->SetValue($this->id_per->GetValue(true));
        $this->DataSource->dir_g->SetValue($this->dir_g->GetValue(true));
        $this->DataSource->unit->SetValue($this->unit->GetValue(true));
        $this->DataSource->area->SetValue($this->area->GetValue(true));
        $this->DataSource->boss_is->SetValue($this->boss_is->GetValue(true));
        $this->DataSource->boss_ij->SetValue($this->boss_ij->GetValue(true));
        $this->DataSource->charge->SetValue($this->charge->GetValue(true));
        $this->DataSource->date_des->SetValue($this->date_des->GetValue(true));
        $this->DataSource->num_memo->SetValue($this->num_memo->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @87-4E222870
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->id_per->SetValue($this->id_per->GetValue(true));
        $this->DataSource->dir_g->SetValue($this->dir_g->GetValue(true));
        $this->DataSource->unit->SetValue($this->unit->GetValue(true));
        $this->DataSource->area->SetValue($this->area->GetValue(true));
        $this->DataSource->boss_is->SetValue($this->boss_is->GetValue(true));
        $this->DataSource->boss_ij->SetValue($this->boss_ij->GetValue(true));
        $this->DataSource->charge->SetValue($this->charge->GetValue(true));
        $this->DataSource->date_des->SetValue($this->date_des->GetValue(true));
        $this->DataSource->num_memo->SetValue($this->num_memo->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @87-A8EB4DB7
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

        $this->dir_g->Prepare();
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
                    $this->dir_g->SetValue($this->DataSource->dir_g->GetValue());
                    $this->unit->SetValue($this->DataSource->unit->GetValue());
                    $this->area->SetValue($this->DataSource->area->GetValue());
                    $this->boss_is->SetValue($this->DataSource->boss_is->GetValue());
                    $this->boss_ij->SetValue($this->DataSource->boss_ij->GetValue());
                    $this->charge->SetValue($this->DataSource->charge->GetValue());
                    $this->date_des->SetValue($this->DataSource->date_des->GetValue());
                    $this->num_memo->SetValue($this->DataSource->num_memo->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->id_per->Errors->ToString());
            $Error = ComposeStrings($Error, $this->dir_g->Errors->ToString());
            $Error = ComposeStrings($Error, $this->unit->Errors->ToString());
            $Error = ComposeStrings($Error, $this->area->Errors->ToString());
            $Error = ComposeStrings($Error, $this->boss_is->Errors->ToString());
            $Error = ComposeStrings($Error, $this->boss_ij->Errors->ToString());
            $Error = ComposeStrings($Error, $this->charge->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_des->Errors->ToString());
            $Error = ComposeStrings($Error, $this->num_memo->Errors->ToString());
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

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Cancel->Show();
        $this->id_per->Show();
        $this->dir_g->Show();
        $this->unit->Show();
        $this->area->Show();
        $this->boss_is->Show();
        $this->boss_ij->Show();
        $this->charge->Show();
        $this->date_des->Show();
        $this->num_memo->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End char_per Class @87-FCB6E20C

class clschar_perDataSource extends clsDBmadnes {  //char_perDataSource Class @87-195B79CD

//DataSource Variables @87-42541F27
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $id_per;
    public $dir_g;
    public $unit;
    public $area;
    public $boss_is;
    public $boss_ij;
    public $charge;
    public $date_des;
    public $num_memo;
//End DataSource Variables

//DataSourceClass_Initialize Event @87-B258FC99
    function clschar_perDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record char_per/Error";
        $this->Initialize();
        $this->id_per = new clsField("id_per", ccsInteger, "");
        
        $this->dir_g = new clsField("dir_g", ccsText, "");
        
        $this->unit = new clsField("unit", ccsText, "");
        
        $this->area = new clsField("area", ccsText, "");
        
        $this->boss_is = new clsField("boss_is", ccsText, "");
        
        $this->boss_ij = new clsField("boss_ij", ccsText, "");
        
        $this->charge = new clsField("charge", ccsText, "");
        
        $this->date_des = new clsField("date_des", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->num_memo = new clsField("num_memo", ccsText, "");
        

        $this->InsertFields["id_per"] = array("Name" => "id_per", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["dir_g"] = array("Name" => "dir_g", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["unit"] = array("Name" => "unit", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["area"] = array("Name" => "area", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["boss_is"] = array("Name" => "boss_is", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["boss_ij"] = array("Name" => "boss_ij", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["charge"] = array("Name" => "charge", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["date_des"] = array("Name" => "date_des", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["num_memo"] = array("Name" => "num_memo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_per"] = array("Name" => "id_per", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["dir_g"] = array("Name" => "dir_g", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["unit"] = array("Name" => "unit", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["area"] = array("Name" => "area", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["boss_is"] = array("Name" => "boss_is", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["boss_ij"] = array("Name" => "boss_ij", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["charge"] = array("Name" => "charge", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_des"] = array("Name" => "date_des", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["num_memo"] = array("Name" => "num_memo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @87-09223E87
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_per", ccsInteger, "", "", $this->Parameters["urlid_per"], xxxxxxxx, false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_per", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @87-4F87F204
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM char_per {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @87-50FC010F
    function SetValues()
    {
        $this->id_per->SetDBValue(trim($this->f("id_per")));
        $this->dir_g->SetDBValue($this->f("dir_g"));
        $this->unit->SetDBValue($this->f("unit"));
        $this->area->SetDBValue($this->f("area"));
        $this->boss_is->SetDBValue($this->f("boss_is"));
        $this->boss_ij->SetDBValue($this->f("boss_ij"));
        $this->charge->SetDBValue($this->f("charge"));
        $this->date_des->SetDBValue(trim($this->f("date_des")));
        $this->num_memo->SetDBValue($this->f("num_memo"));
    }
//End SetValues Method

//Insert Method @87-4A06B1FE
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["id_per"]["Value"] = $this->id_per->GetDBValue(true);
        $this->InsertFields["dir_g"]["Value"] = $this->dir_g->GetDBValue(true);
        $this->InsertFields["unit"]["Value"] = $this->unit->GetDBValue(true);
        $this->InsertFields["area"]["Value"] = $this->area->GetDBValue(true);
        $this->InsertFields["boss_is"]["Value"] = $this->boss_is->GetDBValue(true);
        $this->InsertFields["boss_ij"]["Value"] = $this->boss_ij->GetDBValue(true);
        $this->InsertFields["charge"]["Value"] = $this->charge->GetDBValue(true);
        $this->InsertFields["date_des"]["Value"] = $this->date_des->GetDBValue(true);
        $this->InsertFields["num_memo"]["Value"] = $this->num_memo->GetDBValue(true);
        $this->SQL = CCBuildInsert("char_per", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @87-C3B8B1F4
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["id_per"]["Value"] = $this->id_per->GetDBValue(true);
        $this->UpdateFields["dir_g"]["Value"] = $this->dir_g->GetDBValue(true);
        $this->UpdateFields["unit"]["Value"] = $this->unit->GetDBValue(true);
        $this->UpdateFields["area"]["Value"] = $this->area->GetDBValue(true);
        $this->UpdateFields["boss_is"]["Value"] = $this->boss_is->GetDBValue(true);
        $this->UpdateFields["boss_ij"]["Value"] = $this->boss_ij->GetDBValue(true);
        $this->UpdateFields["charge"]["Value"] = $this->charge->GetDBValue(true);
        $this->UpdateFields["date_des"]["Value"] = $this->date_des->GetDBValue(true);
        $this->UpdateFields["num_memo"]["Value"] = $this->num_memo->GetDBValue(true);
        $this->SQL = CCBuildUpdate("char_per", $this->UpdateFields, $this);
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

} //End char_perDataSource Class @87-FCB6E20C

//Initialize Page @1-62784D2C
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
$TemplateFileName = "regdat_lab_pr3.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "./";
$PathToRootOpt = "";
$Scripts = "|js/jquery/jquery.js|js/jquery/event-manager.js|js/jquery/selectors.js|js/jquery/ui/jquery.ui.core.js|js/jquery/ui/jquery.ui.widget.js|js/jquery/ui/jquery.ui.datepicker.js|js/jquery/datepicker/ccs-date-timepicker.js|";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Include events file @1-A89FA9E1
include_once("./regdat_lab_p_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-5D6646DA
$DBmadnes = new clsDBmadnes();
$MainPage->Connections["madnes"] = & $DBmadnes;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$soc_secu = new clsRecordsoc_secu("", $MainPage);
$old_cas = new clsRecordold_cas("", $MainPage);
$cta_banc = new clsRecordcta_banc("", $MainPage);
$permanente_docs = new clsRecordpermanente_docs("", $MainPage);
$ult_decl = new clsRecordult_decl("", $MainPage);
$char_per = new clsRecordchar_per("", $MainPage);
$MainPage->soc_secu = & $soc_secu;
$MainPage->old_cas = & $old_cas;
$MainPage->cta_banc = & $cta_banc;
$MainPage->permanente_docs = & $permanente_docs;
$MainPage->ult_decl = & $ult_decl;
$MainPage->char_per = & $char_per;
$soc_secu->Initialize();
$old_cas->Initialize();
$cta_banc->Initialize();
$permanente_docs->Initialize();
$ult_decl->Initialize();
$char_per->Initialize();
$ScriptIncludes = "";
$SList = explode("|", $Scripts);
foreach ($SList as $Script) {
    if ($Script != "") $ScriptIncludes = $ScriptIncludes . "<script src=\"" . $PathToRoot . $Script . "\" type=\"text/javascript\"></script>\n";
}
$Attributes->SetValue("scriptIncludes", $ScriptIncludes);

BindEvents();

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

//Execute Components @1-20CCF470
$char_per->Operation();
$ult_decl->Operation();
$permanente_docs->Operation();
$cta_banc->Operation();
$old_cas->Operation();
$soc_secu->Operation();
//End Execute Components

//Go to destination page @1-B64A3741
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmadnes->close();
    header("Location: " . $Redirect);
    unset($soc_secu);
    unset($old_cas);
    unset($cta_banc);
    unset($permanente_docs);
    unset($ult_decl);
    unset($char_per);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-5AEC204B
$soc_secu->Show();
$old_cas->Show();
$cta_banc->Show();
$permanente_docs->Show();
$ult_decl->Show();
$char_per->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-969E8DDA
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmadnes->close();
unset($soc_secu);
unset($old_cas);
unset($cta_banc);
unset($permanente_docs);
unset($ult_decl);
unset($char_per);
unset($Tpl);
//End Unload Page


?>
