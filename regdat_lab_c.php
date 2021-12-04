<?php
//Include Common Files @1-D26022F1
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "regdat_lab_c.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordcta_banc { //cta_banc Class @2-71505876

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

//Class_Initialize Event @2-54E7EE2C
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
            $this->id_func = new clsControl(ccsTextBox, "id_func", "Id Func", ccsInteger, "", CCGetRequestParam("id_func", $Method, NULL), $this);
            $this->bank = new clsControl(ccsTextBox, "bank", "Bank", ccsText, "", CCGetRequestParam("bank", $Method, NULL), $this);
            $this->type_ac = new clsControl(ccsListBox, "type_ac", "Type Ac", ccsText, "", CCGetRequestParam("type_ac", $Method, NULL), $this);
            $this->type_ac->DSType = dsListOfValues;
            $this->type_ac->Values = array(array("CTA. CTE.", "CTA. CTE."), array("CAJA AHORRO", "CAJA AHORRO"));
            $this->num_ac = new clsControl(ccsTextBox, "num_ac", "Num Ac", ccsText, "", CCGetRequestParam("num_ac", $Method, NULL), $this);
            $this->dist_ac = new clsControl(ccsTextBox, "dist_ac", "Dist Ac", ccsText, "", CCGetRequestParam("dist_ac", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @2-BCDB0946
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_func"] = CCGetFromGet("id_func", NULL);
    }
//End Initialize Method

//Validate Method @2-AD601E05
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

//CheckErrors Method @2-FB6069BB
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

//Operation Method @2-E955BD63
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
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->Validate()) {
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

//InsertRow Method @2-735FA739
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

//UpdateRow Method @2-87297F52
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

//Show Method @2-396E3FE0
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

} //End cta_banc Class @2-FCB6E20C

class clscta_bancDataSource extends clsDBmadnes {  //cta_bancDataSource Class @2-4687C0B2

//DataSource Variables @2-EFED0965
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

//DataSourceClass_Initialize Event @2-580D0C94
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

//Prepare Method @2-21BA8987
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

//Open Method @2-845455DB
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT *, id_cta_banc \n\n" .
        "FROM cta_banc {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-F054C015
    function SetValues()
    {
        $this->id_func->SetDBValue(trim($this->f("id_func")));
        $this->bank->SetDBValue($this->f("bank"));
        $this->type_ac->SetDBValue($this->f("type_ac"));
        $this->num_ac->SetDBValue($this->f("num_ac"));
        $this->dist_ac->SetDBValue($this->f("dist_ac"));
    }
//End SetValues Method

//Insert Method @2-93C4D5EA
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

//Update Method @2-18B02579
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

} //End cta_bancDataSource Class @2-FCB6E20C

class clsRecordconsultor_docs { //consultor_docs Class @12-1BB43BF4

//Variables @12-9E315808

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

//Class_Initialize Event @12-D40FD3EB
    function clsRecordconsultor_docs($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record consultor_docs/Error";
        $this->DataSource = new clsconsultor_docsDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "consultor_docs";
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
            $this->id_con = new clsControl(ccsTextBox, "id_con", "Id Con", ccsInteger, "", CCGetRequestParam("id_con", $Method, NULL), $this);
            $this->id_con->Required = true;
            $this->cv = new clsControl(ccsRadioButton, "cv", "Cv", ccsText, "", CCGetRequestParam("cv", $Method, NULL), $this);
            $this->cv->DSType = dsListOfValues;
            $this->cv->Values = array(array("NO", "NO"), array("SI", "SI"));
            $this->ci = new clsControl(ccsRadioButton, "ci", "Ci", ccsText, "", CCGetRequestParam("ci", $Method, NULL), $this);
            $this->ci->DSType = dsListOfValues;
            $this->ci->Values = array(array("NO", "NO"), array("SI", "SI"));
            $this->date_cad_ci = new clsControl(ccsTextBox, "date_cad_ci", "Date Cad Ci", ccsDate, array("ShortDate"), CCGetRequestParam("date_cad_ci", $Method, NULL), $this);
            $this->cn = new clsControl(ccsRadioButton, "cn", "Cn", ccsText, "", CCGetRequestParam("cn", $Method, NULL), $this);
            $this->cn->DSType = dsListOfValues;
            $this->cn->Values = array(array("NO", "NO"), array("SI", "SI"));
            $this->cm = new clsControl(ccsRadioButton, "cm", "Cm", ccsText, "", CCGetRequestParam("cm", $Method, NULL), $this);
            $this->cm->DSType = dsListOfValues;
            $this->cm->Values = array(array("NO", "NO"), array("SI", "SI"));
        }
    }
//End Class_Initialize Event

//Initialize Method @12-07EA002B
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_con"] = CCGetFromGet("id_con", NULL);
    }
//End Initialize Method

//Validate Method @12-384EF91B
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->id_con->Validate() && $Validation);
        $Validation = ($this->cv->Validate() && $Validation);
        $Validation = ($this->ci->Validate() && $Validation);
        $Validation = ($this->date_cad_ci->Validate() && $Validation);
        $Validation = ($this->cn->Validate() && $Validation);
        $Validation = ($this->cm->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->id_con->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cv->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ci->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_cad_ci->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cn->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cm->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @12-0C997DC1
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->id_con->Errors->Count());
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

//Operation Method @12-0BF2B389
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

//InsertRow Method @12-DEDC54D6
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->id_con->SetValue($this->id_con->GetValue(true));
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

//UpdateRow Method @12-ACE596BF
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->id_con->SetValue($this->id_con->GetValue(true));
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

//Show Method @12-D47A6D4D
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
                    $this->id_con->SetValue($this->DataSource->id_con->GetValue());
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
            $Error = ComposeStrings($Error, $this->id_con->Errors->ToString());
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
        $this->id_con->Show();
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

} //End consultor_docs Class @12-FCB6E20C

class clsconsultor_docsDataSource extends clsDBmadnes {  //consultor_docsDataSource Class @12-A3D697D7

//DataSource Variables @12-F986E325
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
    public $id_con;
    public $cv;
    public $ci;
    public $date_cad_ci;
    public $cn;
    public $cm;
//End DataSource Variables

//DataSourceClass_Initialize Event @12-088718BE
    function clsconsultor_docsDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record consultor_docs/Error";
        $this->Initialize();
        $this->id_con = new clsField("id_con", ccsInteger, "");
        
        $this->cv = new clsField("cv", ccsText, "");
        
        $this->ci = new clsField("ci", ccsText, "");
        
        $this->date_cad_ci = new clsField("date_cad_ci", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->cn = new clsField("cn", ccsText, "");
        
        $this->cm = new clsField("cm", ccsText, "");
        

        $this->InsertFields["id_con"] = array("Name" => "id_con", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["cv"] = array("Name" => "cv", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["ci"] = array("Name" => "ci", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["date_cad_ci"] = array("Name" => "date_cad_ci", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["cn"] = array("Name" => "cn", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["cm"] = array("Name" => "cm", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_con"] = array("Name" => "id_con", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["cv"] = array("Name" => "cv", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["ci"] = array("Name" => "ci", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_cad_ci"] = array("Name" => "date_cad_ci", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["cn"] = array("Name" => "cn", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["cm"] = array("Name" => "cm", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @12-6CFB0BA0
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_con", ccsInteger, "", "", $this->Parameters["urlid_con"], xxxxxx, false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_con", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @12-31CEC1A2
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT *, id_cons_docs \n\n" .
        "FROM consultor_docs {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @12-197B7FAB
    function SetValues()
    {
        $this->id_con->SetDBValue(trim($this->f("id_con")));
        $this->cv->SetDBValue($this->f("cv"));
        $this->ci->SetDBValue($this->f("ci"));
        $this->date_cad_ci->SetDBValue(trim($this->f("date_cad_ci")));
        $this->cn->SetDBValue($this->f("cn"));
        $this->cm->SetDBValue($this->f("cm"));
    }
//End SetValues Method

//Insert Method @12-D0674F29
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["id_con"]["Value"] = $this->id_con->GetDBValue(true);
        $this->InsertFields["cv"]["Value"] = $this->cv->GetDBValue(true);
        $this->InsertFields["ci"]["Value"] = $this->ci->GetDBValue(true);
        $this->InsertFields["date_cad_ci"]["Value"] = $this->date_cad_ci->GetDBValue(true);
        $this->InsertFields["cn"]["Value"] = $this->cn->GetDBValue(true);
        $this->InsertFields["cm"]["Value"] = $this->cm->GetDBValue(true);
        $this->SQL = CCBuildInsert("consultor_docs", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @12-C4B3B981
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["id_con"]["Value"] = $this->id_con->GetDBValue(true);
        $this->UpdateFields["cv"]["Value"] = $this->cv->GetDBValue(true);
        $this->UpdateFields["ci"]["Value"] = $this->ci->GetDBValue(true);
        $this->UpdateFields["date_cad_ci"]["Value"] = $this->date_cad_ci->GetDBValue(true);
        $this->UpdateFields["cn"]["Value"] = $this->cn->GetDBValue(true);
        $this->UpdateFields["cm"]["Value"] = $this->cm->GetDBValue(true);
        $this->SQL = CCBuildUpdate("consultor_docs", $this->UpdateFields, $this);
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

} //End consultor_docsDataSource Class @12-FCB6E20C

class clsRecordult_decl { //ult_decl Class @33-BB501711

//Variables @33-9E315808

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

//Class_Initialize Event @33-80B6F4CC
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
            $this->id_func = new clsControl(ccsTextBox, "id_func", "Id Func", ccsInteger, "", CCGetRequestParam("id_func", $Method, NULL), $this);
            $this->id_func->Required = true;
            $this->date_di = new clsControl(ccsTextBox, "date_di", "Date Di", ccsDate, array("ShortDate"), CCGetRequestParam("date_di", $Method, NULL), $this);
            $this->date_di->Required = true;
        }
    }
//End Class_Initialize Event

//Initialize Method @33-BCDB0946
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_func"] = CCGetFromGet("id_func", NULL);
    }
//End Initialize Method

//Validate Method @33-AF41B7B7
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->id_func->Validate() && $Validation);
        $Validation = ($this->date_di->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->id_func->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_di->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @33-55540AC9
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->id_func->Errors->Count());
        $errors = ($errors || $this->date_di->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @33-E955BD63
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
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->Validate()) {
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

//InsertRow Method @33-253CDA91
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->date_di->SetValue($this->date_di->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @33-B15669DE
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->date_di->SetValue($this->date_di->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @33-B1B64ABD
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
                    $this->date_di->SetValue($this->DataSource->date_di->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->id_func->Errors->ToString());
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
        $this->id_func->Show();
        $this->date_di->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End ult_decl Class @33-FCB6E20C

class clsult_declDataSource extends clsDBmadnes {  //ult_declDataSource Class @33-01D0F3B8

//DataSource Variables @33-E042E003
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
    public $date_di;
//End DataSource Variables

//DataSourceClass_Initialize Event @33-0E2B4F2E
    function clsult_declDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record ult_decl/Error";
        $this->Initialize();
        $this->id_func = new clsField("id_func", ccsInteger, "");
        
        $this->date_di = new clsField("date_di", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        

        $this->InsertFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["date_di"] = array("Name" => "date_di", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_di"] = array("Name" => "date_di", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @33-21BA8987
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

//Open Method @33-4AAB7298
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT *, id_ult_decl \n\n" .
        "FROM ult_decl {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @33-85197F22
    function SetValues()
    {
        $this->id_func->SetDBValue(trim($this->f("id_func")));
        $this->date_di->SetDBValue(trim($this->f("date_di")));
    }
//End SetValues Method

//Insert Method @33-FE7A86CF
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->InsertFields["date_di"]["Value"] = $this->date_di->GetDBValue(true);
        $this->SQL = CCBuildInsert("ult_decl", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @33-0CB8C9E3
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
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

} //End ult_declDataSource Class @33-FCB6E20C

class clsRecordchar_con { //char_con Class @45-A6A2CA3C

//Variables @45-9E315808

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

//Class_Initialize Event @45-430FBB83
    function clsRecordchar_con($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record char_con/Error";
        $this->DataSource = new clschar_conDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "char_con";
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
            $this->id_con = new clsControl(ccsTextBox, "id_con", "Id Con", ccsInteger, "", CCGetRequestParam("id_con", $Method, NULL), $this);
            $this->id_con->Required = true;
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
            $this->date_end = new clsControl(ccsTextBox, "date_end", "Date End", ccsDate, array("ShortDate"), CCGetRequestParam("date_end", $Method, NULL), $this);
            $this->num_res_con = new clsControl(ccsTextBox, "num_res_con", "Num Res Con", ccsText, "", CCGetRequestParam("num_res_con", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @45-07EA002B
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_con"] = CCGetFromGet("id_con", NULL);
    }
//End Initialize Method

//Validate Method @45-E56A5D58
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->id_con->Validate() && $Validation);
        $Validation = ($this->dir_g->Validate() && $Validation);
        $Validation = ($this->unit->Validate() && $Validation);
        $Validation = ($this->area->Validate() && $Validation);
        $Validation = ($this->boss_is->Validate() && $Validation);
        $Validation = ($this->boss_ij->Validate() && $Validation);
        $Validation = ($this->charge->Validate() && $Validation);
        $Validation = ($this->date_des->Validate() && $Validation);
        $Validation = ($this->date_end->Validate() && $Validation);
        $Validation = ($this->num_res_con->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->id_con->Errors->Count() == 0);
        $Validation =  $Validation && ($this->dir_g->Errors->Count() == 0);
        $Validation =  $Validation && ($this->unit->Errors->Count() == 0);
        $Validation =  $Validation && ($this->area->Errors->Count() == 0);
        $Validation =  $Validation && ($this->boss_is->Errors->Count() == 0);
        $Validation =  $Validation && ($this->boss_ij->Errors->Count() == 0);
        $Validation =  $Validation && ($this->charge->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_des->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_end->Errors->Count() == 0);
        $Validation =  $Validation && ($this->num_res_con->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @45-CA21C954
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->id_con->Errors->Count());
        $errors = ($errors || $this->dir_g->Errors->Count());
        $errors = ($errors || $this->unit->Errors->Count());
        $errors = ($errors || $this->area->Errors->Count());
        $errors = ($errors || $this->boss_is->Errors->Count());
        $errors = ($errors || $this->boss_ij->Errors->Count());
        $errors = ($errors || $this->charge->Errors->Count());
        $errors = ($errors || $this->date_des->Errors->Count());
        $errors = ($errors || $this->date_end->Errors->Count());
        $errors = ($errors || $this->num_res_con->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @45-0BF2B389
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

//InsertRow Method @45-25BC078D
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->id_con->SetValue($this->id_con->GetValue(true));
        $this->DataSource->dir_g->SetValue($this->dir_g->GetValue(true));
        $this->DataSource->unit->SetValue($this->unit->GetValue(true));
        $this->DataSource->area->SetValue($this->area->GetValue(true));
        $this->DataSource->boss_is->SetValue($this->boss_is->GetValue(true));
        $this->DataSource->boss_ij->SetValue($this->boss_ij->GetValue(true));
        $this->DataSource->charge->SetValue($this->charge->GetValue(true));
        $this->DataSource->date_des->SetValue($this->date_des->GetValue(true));
        $this->DataSource->date_end->SetValue($this->date_end->GetValue(true));
        $this->DataSource->num_res_con->SetValue($this->num_res_con->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @45-80EF83BD
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->id_con->SetValue($this->id_con->GetValue(true));
        $this->DataSource->dir_g->SetValue($this->dir_g->GetValue(true));
        $this->DataSource->unit->SetValue($this->unit->GetValue(true));
        $this->DataSource->area->SetValue($this->area->GetValue(true));
        $this->DataSource->boss_is->SetValue($this->boss_is->GetValue(true));
        $this->DataSource->boss_ij->SetValue($this->boss_ij->GetValue(true));
        $this->DataSource->charge->SetValue($this->charge->GetValue(true));
        $this->DataSource->date_des->SetValue($this->date_des->GetValue(true));
        $this->DataSource->date_end->SetValue($this->date_end->GetValue(true));
        $this->DataSource->num_res_con->SetValue($this->num_res_con->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @45-F7CF5774
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
                    $this->id_con->SetValue($this->DataSource->id_con->GetValue());
                    $this->dir_g->SetValue($this->DataSource->dir_g->GetValue());
                    $this->unit->SetValue($this->DataSource->unit->GetValue());
                    $this->area->SetValue($this->DataSource->area->GetValue());
                    $this->boss_is->SetValue($this->DataSource->boss_is->GetValue());
                    $this->boss_ij->SetValue($this->DataSource->boss_ij->GetValue());
                    $this->charge->SetValue($this->DataSource->charge->GetValue());
                    $this->date_des->SetValue($this->DataSource->date_des->GetValue());
                    $this->date_end->SetValue($this->DataSource->date_end->GetValue());
                    $this->num_res_con->SetValue($this->DataSource->num_res_con->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->id_con->Errors->ToString());
            $Error = ComposeStrings($Error, $this->dir_g->Errors->ToString());
            $Error = ComposeStrings($Error, $this->unit->Errors->ToString());
            $Error = ComposeStrings($Error, $this->area->Errors->ToString());
            $Error = ComposeStrings($Error, $this->boss_is->Errors->ToString());
            $Error = ComposeStrings($Error, $this->boss_ij->Errors->ToString());
            $Error = ComposeStrings($Error, $this->charge->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_des->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_end->Errors->ToString());
            $Error = ComposeStrings($Error, $this->num_res_con->Errors->ToString());
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
        $this->id_con->Show();
        $this->dir_g->Show();
        $this->unit->Show();
        $this->area->Show();
        $this->boss_is->Show();
        $this->boss_ij->Show();
        $this->charge->Show();
        $this->date_des->Show();
        $this->date_end->Show();
        $this->num_res_con->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End char_con Class @45-FCB6E20C

class clschar_conDataSource extends clsDBmadnes {  //char_conDataSource Class @45-1EF42692

//DataSource Variables @45-3EAA26FC
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
    public $id_con;
    public $dir_g;
    public $unit;
    public $area;
    public $boss_is;
    public $boss_ij;
    public $charge;
    public $date_des;
    public $date_end;
    public $num_res_con;
//End DataSource Variables

//DataSourceClass_Initialize Event @45-F17FFEFA
    function clschar_conDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record char_con/Error";
        $this->Initialize();
        $this->id_con = new clsField("id_con", ccsInteger, "");
        
        $this->dir_g = new clsField("dir_g", ccsText, "");
        
        $this->unit = new clsField("unit", ccsText, "");
        
        $this->area = new clsField("area", ccsText, "");
        
        $this->boss_is = new clsField("boss_is", ccsText, "");
        
        $this->boss_ij = new clsField("boss_ij", ccsText, "");
        
        $this->charge = new clsField("charge", ccsText, "");
        
        $this->date_des = new clsField("date_des", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->date_end = new clsField("date_end", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->num_res_con = new clsField("num_res_con", ccsText, "");
        

        $this->InsertFields["id_con"] = array("Name" => "id_con", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["dir_g"] = array("Name" => "dir_g", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["unit"] = array("Name" => "unit", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["area"] = array("Name" => "area", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["boss_is"] = array("Name" => "boss_is", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["boss_ij"] = array("Name" => "boss_ij", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["charge"] = array("Name" => "charge", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["date_des"] = array("Name" => "date_des", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["date_end"] = array("Name" => "date_end", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["num_res_con"] = array("Name" => "num_res_con", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_con"] = array("Name" => "id_con", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["dir_g"] = array("Name" => "dir_g", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["unit"] = array("Name" => "unit", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["area"] = array("Name" => "area", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["boss_is"] = array("Name" => "boss_is", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["boss_ij"] = array("Name" => "boss_ij", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["charge"] = array("Name" => "charge", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_des"] = array("Name" => "date_des", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_end"] = array("Name" => "date_end", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["num_res_con"] = array("Name" => "num_res_con", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @45-6CFB0BA0
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_con", ccsInteger, "", "", $this->Parameters["urlid_con"], xxxxxx, false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_con", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @45-B86675D3
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT *, id_char_con \n\n" .
        "FROM char_con {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @45-08B139B5
    function SetValues()
    {
        $this->id_con->SetDBValue(trim($this->f("id_con")));
        $this->dir_g->SetDBValue($this->f("dir_g"));
        $this->unit->SetDBValue($this->f("unit"));
        $this->area->SetDBValue($this->f("area"));
        $this->boss_is->SetDBValue($this->f("boss_is"));
        $this->boss_ij->SetDBValue($this->f("boss_ij"));
        $this->charge->SetDBValue($this->f("charge"));
        $this->date_des->SetDBValue(trim($this->f("date_des")));
        $this->date_end->SetDBValue(trim($this->f("date_end")));
        $this->num_res_con->SetDBValue($this->f("num_res_con"));
    }
//End SetValues Method

//Insert Method @45-BEFBCBC2
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["id_con"]["Value"] = $this->id_con->GetDBValue(true);
        $this->InsertFields["dir_g"]["Value"] = $this->dir_g->GetDBValue(true);
        $this->InsertFields["unit"]["Value"] = $this->unit->GetDBValue(true);
        $this->InsertFields["area"]["Value"] = $this->area->GetDBValue(true);
        $this->InsertFields["boss_is"]["Value"] = $this->boss_is->GetDBValue(true);
        $this->InsertFields["boss_ij"]["Value"] = $this->boss_ij->GetDBValue(true);
        $this->InsertFields["charge"]["Value"] = $this->charge->GetDBValue(true);
        $this->InsertFields["date_des"]["Value"] = $this->date_des->GetDBValue(true);
        $this->InsertFields["date_end"]["Value"] = $this->date_end->GetDBValue(true);
        $this->InsertFields["num_res_con"]["Value"] = $this->num_res_con->GetDBValue(true);
        $this->SQL = CCBuildInsert("char_con", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @45-A5F85202
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["id_con"]["Value"] = $this->id_con->GetDBValue(true);
        $this->UpdateFields["dir_g"]["Value"] = $this->dir_g->GetDBValue(true);
        $this->UpdateFields["unit"]["Value"] = $this->unit->GetDBValue(true);
        $this->UpdateFields["area"]["Value"] = $this->area->GetDBValue(true);
        $this->UpdateFields["boss_is"]["Value"] = $this->boss_is->GetDBValue(true);
        $this->UpdateFields["boss_ij"]["Value"] = $this->boss_ij->GetDBValue(true);
        $this->UpdateFields["charge"]["Value"] = $this->charge->GetDBValue(true);
        $this->UpdateFields["date_des"]["Value"] = $this->date_des->GetDBValue(true);
        $this->UpdateFields["date_end"]["Value"] = $this->date_end->GetDBValue(true);
        $this->UpdateFields["num_res_con"]["Value"] = $this->num_res_con->GetDBValue(true);
        $this->SQL = CCBuildUpdate("char_con", $this->UpdateFields, $this);
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

} //End char_conDataSource Class @45-FCB6E20C

class clsRecordcontrato { //contrato Class @70-16460E3F

//Variables @70-9E315808

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

//Class_Initialize Event @70-AAF35F6A
    function clsRecordcontrato($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record contrato/Error";
        $this->DataSource = new clscontratoDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "contrato";
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
            $this->date_ent = new clsControl(ccsTextBox, "date_ent", "Date Ent", ccsDate, array("ShortDate"), CCGetRequestParam("date_ent", $Method, NULL), $this);
            $this->date_end = new clsControl(ccsTextBox, "date_end", "Date End", ccsDate, array("ShortDate"), CCGetRequestParam("date_end", $Method, NULL), $this);
            $this->status = new clsControl(ccsTextBox, "status", "Status", ccsInteger, "", CCGetRequestParam("status", $Method, NULL), $this);
            $this->name_con = new clsControl(ccsTextBox, "name_con", "Name Con", ccsText, "", CCGetRequestParam("name_con", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @70-1C84DA17
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_con"] = CCGetFromGet("id_con", NULL);
        $this->DataSource->Parameters["urlid_func"] = CCGetFromGet("id_func", NULL);
    }
//End Initialize Method

//Validate Method @70-4BC3D3CE
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->id_func->Validate() && $Validation);
        $Validation = ($this->date_ent->Validate() && $Validation);
        $Validation = ($this->date_end->Validate() && $Validation);
        $Validation = ($this->status->Validate() && $Validation);
        $Validation = ($this->name_con->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->id_func->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_ent->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_end->Errors->Count() == 0);
        $Validation =  $Validation && ($this->status->Errors->Count() == 0);
        $Validation =  $Validation && ($this->name_con->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @70-E8B0E09B
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->id_func->Errors->Count());
        $errors = ($errors || $this->date_ent->Errors->Count());
        $errors = ($errors || $this->date_end->Errors->Count());
        $errors = ($errors || $this->status->Errors->Count());
        $errors = ($errors || $this->name_con->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @70-0BF2B389
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

//InsertRow Method @70-371D3559
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->date_ent->SetValue($this->date_ent->GetValue(true));
        $this->DataSource->date_end->SetValue($this->date_end->GetValue(true));
        $this->DataSource->status->SetValue($this->status->GetValue(true));
        $this->DataSource->name_con->SetValue($this->name_con->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @70-97A799AB
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->date_ent->SetValue($this->date_ent->GetValue(true));
        $this->DataSource->date_end->SetValue($this->date_end->GetValue(true));
        $this->DataSource->status->SetValue($this->status->GetValue(true));
        $this->DataSource->name_con->SetValue($this->name_con->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @70-5E50D40F
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
                    $this->date_ent->SetValue($this->DataSource->date_ent->GetValue());
                    $this->date_end->SetValue($this->DataSource->date_end->GetValue());
                    $this->status->SetValue($this->DataSource->status->GetValue());
                    $this->name_con->SetValue($this->DataSource->name_con->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->id_func->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_ent->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_end->Errors->ToString());
            $Error = ComposeStrings($Error, $this->status->Errors->ToString());
            $Error = ComposeStrings($Error, $this->name_con->Errors->ToString());
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
        $this->date_ent->Show();
        $this->date_end->Show();
        $this->status->Show();
        $this->name_con->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End contrato Class @70-FCB6E20C

class clscontratoDataSource extends clsDBmadnes {  //contratoDataSource Class @70-37B360C4

//DataSource Variables @70-228BA7D7
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
    public $date_ent;
    public $date_end;
    public $status;
    public $name_con;
//End DataSource Variables

//DataSourceClass_Initialize Event @70-308C6CB1
    function clscontratoDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record contrato/Error";
        $this->Initialize();
        $this->id_func = new clsField("id_func", ccsInteger, "");
        
        $this->date_ent = new clsField("date_ent", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->date_end = new clsField("date_end", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->status = new clsField("status", ccsInteger, "");
        
        $this->name_con = new clsField("name_con", ccsText, "");
        

        $this->InsertFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["date_ent"] = array("Name" => "date_ent", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["date_end"] = array("Name" => "date_end", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["status"] = array("Name" => "status", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["name_con"] = array("Name" => "name_con", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_ent"] = array("Name" => "date_ent", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_end"] = array("Name" => "date_end", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["status"] = array("Name" => "status", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["name_con"] = array("Name" => "name_con", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @70-BC8B3DD0
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_con", ccsInteger, "", "", $this->Parameters["urlid_con"], "", false);
        $this->wp->AddParameter("2", "urlid_func", ccsInteger, "", "", $this->Parameters["urlid_func"], xxxxxx, false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_con", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "id_func", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @70-BEFA9329
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT *, id_con \n\n" .
        "FROM contrato {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @70-0AE01CF8
    function SetValues()
    {
        $this->id_func->SetDBValue(trim($this->f("id_func")));
        $this->date_ent->SetDBValue(trim($this->f("date_ent")));
        $this->date_end->SetDBValue(trim($this->f("date_end")));
        $this->status->SetDBValue(trim($this->f("status")));
        $this->name_con->SetDBValue($this->f("name_con"));
    }
//End SetValues Method

//Insert Method @70-C8A0CC3A
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->InsertFields["date_ent"]["Value"] = $this->date_ent->GetDBValue(true);
        $this->InsertFields["date_end"]["Value"] = $this->date_end->GetDBValue(true);
        $this->InsertFields["status"]["Value"] = $this->status->GetDBValue(true);
        $this->InsertFields["name_con"]["Value"] = $this->name_con->GetDBValue(true);
        $this->SQL = CCBuildInsert("contrato", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @70-4D1A3DF9
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->UpdateFields["date_ent"]["Value"] = $this->date_ent->GetDBValue(true);
        $this->UpdateFields["date_end"]["Value"] = $this->date_end->GetDBValue(true);
        $this->UpdateFields["status"]["Value"] = $this->status->GetDBValue(true);
        $this->UpdateFields["name_con"]["Value"] = $this->name_con->GetDBValue(true);
        $this->SQL = CCBuildUpdate("contrato", $this->UpdateFields, $this);
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

} //End contratoDataSource Class @70-FCB6E20C

class clsRecorddes_hab_temp { //des_hab_temp Class @88-8B2BA786

//Variables @88-9E315808

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

//Class_Initialize Event @88-B5901A69
    function clsRecorddes_hab_temp($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record des_hab_temp/Error";
        $this->DataSource = new clsdes_hab_tempDataSource($this);
        $this->ds = & $this->DataSource;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "des_hab_temp";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->p7 = new clsControl(ccsTextBox, "p7", "P7", ccsInteger, "", CCGetRequestParam("p7", $Method, NULL), $this);
            $this->p7->Required = true;
            if(!$this->FormSubmitted) {
                if(!is_array($this->p7->Value) && !strlen($this->p7->Value) && $this->p7->Value !== false)
                    $this->p7->SetText(1);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @88-BCDB0946
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_func"] = CCGetFromGet("id_func", NULL);
    }
//End Initialize Method

//Validate Method @88-BD94CC72
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->p7->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->p7->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @88-154AB945
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->p7->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @88-5B06BA55
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
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Cancel";
            if($this->Button_Update->Pressed) {
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
            if($this->PressedButton == "Button_Update") {
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

//UpdateRow Method @88-3B855313
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->p7->SetValue($this->p7->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @88-CBEA678B
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
                    $this->p7->SetValue($this->DataSource->p7->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->p7->Errors->ToString());
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
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Update->Show();
        $this->Button_Cancel->Show();
        $this->p7->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End des_hab_temp Class @88-FCB6E20C

class clsdes_hab_tempDataSource extends clsDBmadnes {  //des_hab_tempDataSource Class @88-13C74130

//DataSource Variables @88-9FC5C9A1
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $UpdateFields = array();

    // Datasource fields
    public $p7;
//End DataSource Variables

//DataSourceClass_Initialize Event @88-4103F662
    function clsdes_hab_tempDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record des_hab_temp/Error";
        $this->Initialize();
        $this->p7 = new clsField("p7", ccsInteger, "");
        

        $this->UpdateFields["p7"] = array("Name" => "p7", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @88-7F6F9F59
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_func", ccsInteger, "", "", $this->Parameters["urlid_func"], xxxxx, false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_func", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @88-6DB98E07
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT *, id_des_hab_temp \n\n" .
        "FROM des_hab_temp {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @88-102D3DF7
    function SetValues()
    {
        $this->p7->SetDBValue(trim($this->f("p7")));
    }
//End SetValues Method

//Update Method @88-AD2D612E
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["p7"]["Value"] = $this->p7->GetDBValue(true);
        $this->SQL = CCBuildUpdate("des_hab_temp", $this->UpdateFields, $this);
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

} //End des_hab_tempDataSource Class @88-FCB6E20C

//Initialize Page @1-09CD1F9B
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
$TemplateFileName = "regdat_lab_cr.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Include events file @1-FD805CD7
include_once("./regdat_lab_c_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-605ABA34
$DBmadnes = new clsDBmadnes();
$MainPage->Connections["madnes"] = & $DBmadnes;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$cta_banc = new clsRecordcta_banc("", $MainPage);
$consultor_docs = new clsRecordconsultor_docs("", $MainPage);
$ult_decl = new clsRecordult_decl("", $MainPage);
$char_con = new clsRecordchar_con("", $MainPage);
$contrato = new clsRecordcontrato("", $MainPage);
$des_hab_temp = new clsRecorddes_hab_temp("", $MainPage);
$MainPage->cta_banc = & $cta_banc;
$MainPage->consultor_docs = & $consultor_docs;
$MainPage->ult_decl = & $ult_decl;
$MainPage->char_con = & $char_con;
$MainPage->contrato = & $contrato;
$MainPage->des_hab_temp = & $des_hab_temp;
$cta_banc->Initialize();
$consultor_docs->Initialize();
$ult_decl->Initialize();
$char_con->Initialize();
$contrato->Initialize();
$des_hab_temp->Initialize();

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

//Execute Components @1-06CF9376
$des_hab_temp->Operation();
$contrato->Operation();
$char_con->Operation();
$ult_decl->Operation();
$consultor_docs->Operation();
$cta_banc->Operation();
//End Execute Components

//Go to destination page @1-2CD7DA66
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmadnes->close();
    header("Location: " . $Redirect);
    unset($cta_banc);
    unset($consultor_docs);
    unset($ult_decl);
    unset($char_con);
    unset($contrato);
    unset($des_hab_temp);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-4EC5D0B5
$cta_banc->Show();
$consultor_docs->Show();
$ult_decl->Show();
$char_con->Show();
$contrato->Show();
$des_hab_temp->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-71A2C4CF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmadnes->close();
unset($cta_banc);
unset($consultor_docs);
unset($ult_decl);
unset($char_con);
unset($contrato);
unset($des_hab_temp);
unset($Tpl);
//End Unload Page


?>
