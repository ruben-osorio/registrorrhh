<?php
//Include Common Files @1-ECF0296B
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "regdat_fccon.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordfin_con { //fin_con Class @2-F0461C9F

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

//Class_Initialize Event @2-FE1E342E
    function clsRecordfin_con($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record fin_con/Error";
        $this->DataSource = new clsfin_conDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "fin_con";
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
            $this->source_fin = new clsControl(ccsListBox, "source_fin", "Source Fin", ccsText, "", CCGetRequestParam("source_fin", $Method, NULL), $this);
            $this->source_fin->DSType = dsListOfValues;
            $this->source_fin->Values = array(array("TGN", "TGN"), array("CANASTA", "CANASTA"), array("UNICEF", "UNICEF"), array("ASDI", "ASDI"), array("COSUDE", "COSUDE"), array("TGN 252", "TGN 252"), array("TGN 258", "TGN 258"), array("BID", "BID"), array("DINAMARCA", "DINAMARCA"));
        }
    }
//End Class_Initialize Event

//Initialize Method @2-07EA002B
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_con"] = CCGetFromGet("id_con", NULL);
    }
//End Initialize Method

//Validate Method @2-EF53D82E
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->id_con->Validate() && $Validation);
        $Validation = ($this->source_fin->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->id_con->Errors->Count() == 0);
        $Validation =  $Validation && ($this->source_fin->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-06349086
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->id_con->Errors->Count());
        $errors = ($errors || $this->source_fin->Errors->Count());
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

//InsertRow Method @2-35BA2A69
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->id_con->SetValue($this->id_con->GetValue(true));
        $this->DataSource->source_fin->SetValue($this->source_fin->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @2-F9552D2E
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->id_con->SetValue($this->id_con->GetValue(true));
        $this->DataSource->source_fin->SetValue($this->source_fin->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @2-B9AA30B8
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

        $this->source_fin->Prepare();

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
                    $this->source_fin->SetValue($this->DataSource->source_fin->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->id_con->Errors->ToString());
            $Error = ComposeStrings($Error, $this->source_fin->Errors->ToString());
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
        $this->source_fin->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End fin_con Class @2-FCB6E20C

class clsfin_conDataSource extends clsDBmadnes {  //fin_conDataSource Class @2-61710386

//DataSource Variables @2-10D8F7E7
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
    public $source_fin;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-BD28DB64
    function clsfin_conDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record fin_con/Error";
        $this->Initialize();
        $this->id_con = new clsField("id_con", ccsInteger, "");
        
        $this->source_fin = new clsField("source_fin", ccsText, "");
        

        $this->InsertFields["id_con"] = array("Name" => "id_con", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["source_fin"] = array("Name" => "source_fin", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_con"] = array("Name" => "id_con", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["source_fin"] = array("Name" => "source_fin", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-01F1F733
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_con", ccsInteger, "", "", $this->Parameters["urlid_con"], xxxxx, false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_con", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-3CBE85E6
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT *, id_fin_con \n\n" .
        "FROM fin_con {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-707C12D8
    function SetValues()
    {
        $this->id_con->SetDBValue(trim($this->f("id_con")));
        $this->source_fin->SetDBValue($this->f("source_fin"));
    }
//End SetValues Method

//Insert Method @2-AFA0BADA
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["id_con"]["Value"] = $this->id_con->GetDBValue(true);
        $this->InsertFields["source_fin"]["Value"] = $this->source_fin->GetDBValue(true);
        $this->SQL = CCBuildInsert("fin_con", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-16917A9C
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["id_con"]["Value"] = $this->id_con->GetDBValue(true);
        $this->UpdateFields["source_fin"]["Value"] = $this->source_fin->GetDBValue(true);
        $this->SQL = CCBuildUpdate("fin_con", $this->UpdateFields, $this);
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

} //End fin_conDataSource Class @2-FCB6E20C

class clsRecordcat_con { //cat_con Class @10-29047D61

//Variables @10-9E315808

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

//Class_Initialize Event @10-E2BAC95A
    function clsRecordcat_con($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record cat_con/Error";
        $this->DataSource = new clscat_conDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "cat_con";
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
            $this->cat = new clsControl(ccsRadioButton, "cat", "Cat", ccsText, "", CCGetRequestParam("cat", $Method, NULL), $this);
            $this->cat->DSType = dsTable;
            $this->cat->DataSource = new clsDBmadnes();
            $this->cat->ds = & $this->cat->DataSource;
            $this->cat->DataSource->SQL = "SELECT * \n" .
"FROM categoria_emp {SQL_Where} {SQL_OrderBy}";
            list($this->cat->BoundColumn, $this->cat->TextColumn, $this->cat->DBFormat) = array("desc_emp", "desc_emp", "");
            $this->level = new clsControl(ccsRadioButton, "level", "Level", ccsText, "", CCGetRequestParam("level", $Method, NULL), $this);
            $this->level->DSType = dsTable;
            $this->level->DataSource = new clsDBmadnes();
            $this->level->ds = & $this->level->DataSource;
            $this->level->DataSource->SQL = "SELECT * \n" .
"FROM nivel_puesto {SQL_Where} {SQL_OrderBy}";
            list($this->level->BoundColumn, $this->level->TextColumn, $this->level->DBFormat) = array("desc_nivelpuesto", "desc_nivelpuesto", "");
            $this->post_car = new clsControl(ccsRadioButton, "post_car", "Post Car", ccsText, "", CCGetRequestParam("post_car", $Method, NULL), $this);
            $this->post_car->DSType = dsListOfValues;
            $this->post_car->Values = array(array("SI", "SI"), array("NO", "NO"));
            $this->mod_ent = new clsControl(ccsRadioButton, "mod_ent", "Mod Ent", ccsText, "", CCGetRequestParam("mod_ent", $Method, NULL), $this);
            $this->mod_ent->DSType = dsTable;
            $this->mod_ent->DataSource = new clsDBmadnes();
            $this->mod_ent->ds = & $this->mod_ent->DataSource;
            $this->mod_ent->DataSource->SQL = "SELECT * \n" .
"FROM modalidad_ingreso {SQL_Where} {SQL_OrderBy}";
            list($this->mod_ent->BoundColumn, $this->mod_ent->TextColumn, $this->mod_ent->DBFormat) = array("desc_modaidad", "desc_modaidad", "");
            $this->form_rec = new clsControl(ccsRadioButton, "form_rec", "Form Rec", ccsText, "", CCGetRequestParam("form_rec", $Method, NULL), $this);
            $this->form_rec->DSType = dsTable;
            $this->form_rec->DataSource = new clsDBmadnes();
            $this->form_rec->ds = & $this->form_rec->DataSource;
            $this->form_rec->DataSource->SQL = "SELECT * \n" .
"FROM forma_reclut {SQL_Where} {SQL_OrderBy}";
            list($this->form_rec->BoundColumn, $this->form_rec->TextColumn, $this->form_rec->DBFormat) = array("desc_formarecl", "desc_formarecl", "");
            $this->jornal = new clsControl(ccsRadioButton, "jornal", "Jornal", ccsText, "", CCGetRequestParam("jornal", $Method, NULL), $this);
            $this->jornal->DSType = dsTable;
            $this->jornal->DataSource = new clsDBmadnes();
            $this->jornal->ds = & $this->jornal->DataSource;
            $this->jornal->DataSource->SQL = "SELECT * \n" .
"FROM jornal {SQL_Where} {SQL_OrderBy}";
            list($this->jornal->BoundColumn, $this->jornal->TextColumn, $this->jornal->DBFormat) = array("desc_jornal", "desc_jornal", "");
            $this->sal_base = new clsControl(ccsTextBox, "sal_base", "Sal Base", ccsInteger, "", CCGetRequestParam("sal_base", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @10-07EA002B
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_con"] = CCGetFromGet("id_con", NULL);
    }
//End Initialize Method

//Validate Method @10-A025109C
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->id_con->Validate() && $Validation);
        $Validation = ($this->cat->Validate() && $Validation);
        $Validation = ($this->level->Validate() && $Validation);
        $Validation = ($this->post_car->Validate() && $Validation);
        $Validation = ($this->mod_ent->Validate() && $Validation);
        $Validation = ($this->form_rec->Validate() && $Validation);
        $Validation = ($this->jornal->Validate() && $Validation);
        $Validation = ($this->sal_base->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->id_con->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cat->Errors->Count() == 0);
        $Validation =  $Validation && ($this->level->Errors->Count() == 0);
        $Validation =  $Validation && ($this->post_car->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mod_ent->Errors->Count() == 0);
        $Validation =  $Validation && ($this->form_rec->Errors->Count() == 0);
        $Validation =  $Validation && ($this->jornal->Errors->Count() == 0);
        $Validation =  $Validation && ($this->sal_base->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @10-F17A188B
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->id_con->Errors->Count());
        $errors = ($errors || $this->cat->Errors->Count());
        $errors = ($errors || $this->level->Errors->Count());
        $errors = ($errors || $this->post_car->Errors->Count());
        $errors = ($errors || $this->mod_ent->Errors->Count());
        $errors = ($errors || $this->form_rec->Errors->Count());
        $errors = ($errors || $this->jornal->Errors->Count());
        $errors = ($errors || $this->sal_base->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @10-0BF2B389
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

//InsertRow Method @10-4C5223A3
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->id_con->SetValue($this->id_con->GetValue(true));
        $this->DataSource->cat->SetValue($this->cat->GetValue(true));
        $this->DataSource->level->SetValue($this->level->GetValue(true));
        $this->DataSource->post_car->SetValue($this->post_car->GetValue(true));
        $this->DataSource->mod_ent->SetValue($this->mod_ent->GetValue(true));
        $this->DataSource->form_rec->SetValue($this->form_rec->GetValue(true));
        $this->DataSource->jornal->SetValue($this->jornal->GetValue(true));
        $this->DataSource->sal_base->SetValue($this->sal_base->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @10-29811344
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->id_con->SetValue($this->id_con->GetValue(true));
        $this->DataSource->cat->SetValue($this->cat->GetValue(true));
        $this->DataSource->level->SetValue($this->level->GetValue(true));
        $this->DataSource->post_car->SetValue($this->post_car->GetValue(true));
        $this->DataSource->mod_ent->SetValue($this->mod_ent->GetValue(true));
        $this->DataSource->form_rec->SetValue($this->form_rec->GetValue(true));
        $this->DataSource->jornal->SetValue($this->jornal->GetValue(true));
        $this->DataSource->sal_base->SetValue($this->sal_base->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @10-E8C47393
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

        $this->cat->Prepare();
        $this->level->Prepare();
        $this->post_car->Prepare();
        $this->mod_ent->Prepare();
        $this->form_rec->Prepare();
        $this->jornal->Prepare();

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
                    $this->cat->SetValue($this->DataSource->cat->GetValue());
                    $this->level->SetValue($this->DataSource->level->GetValue());
                    $this->post_car->SetValue($this->DataSource->post_car->GetValue());
                    $this->mod_ent->SetValue($this->DataSource->mod_ent->GetValue());
                    $this->form_rec->SetValue($this->DataSource->form_rec->GetValue());
                    $this->jornal->SetValue($this->DataSource->jornal->GetValue());
                    $this->sal_base->SetValue($this->DataSource->sal_base->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->id_con->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cat->Errors->ToString());
            $Error = ComposeStrings($Error, $this->level->Errors->ToString());
            $Error = ComposeStrings($Error, $this->post_car->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mod_ent->Errors->ToString());
            $Error = ComposeStrings($Error, $this->form_rec->Errors->ToString());
            $Error = ComposeStrings($Error, $this->jornal->Errors->ToString());
            $Error = ComposeStrings($Error, $this->sal_base->Errors->ToString());
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
        $this->cat->Show();
        $this->level->Show();
        $this->post_car->Show();
        $this->mod_ent->Show();
        $this->form_rec->Show();
        $this->jornal->Show();
        $this->sal_base->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End cat_con Class @10-FCB6E20C

class clscat_conDataSource extends clsDBmadnes {  //cat_conDataSource Class @10-95C51ABF

//DataSource Variables @10-714ECE90
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
    public $cat;
    public $level;
    public $post_car;
    public $mod_ent;
    public $form_rec;
    public $jornal;
    public $sal_base;
//End DataSource Variables

//DataSourceClass_Initialize Event @10-3A2CE920
    function clscat_conDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record cat_con/Error";
        $this->Initialize();
        $this->id_con = new clsField("id_con", ccsInteger, "");
        
        $this->cat = new clsField("cat", ccsText, "");
        
        $this->level = new clsField("level", ccsText, "");
        
        $this->post_car = new clsField("post_car", ccsText, "");
        
        $this->mod_ent = new clsField("mod_ent", ccsText, "");
        
        $this->form_rec = new clsField("form_rec", ccsText, "");
        
        $this->jornal = new clsField("jornal", ccsText, "");
        
        $this->sal_base = new clsField("sal_base", ccsInteger, "");
        

        $this->InsertFields["id_con"] = array("Name" => "id_con", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["cat"] = array("Name" => "cat", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["level"] = array("Name" => "level", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["post_car"] = array("Name" => "post_car", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["mod_ent"] = array("Name" => "mod_ent", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["form_rec"] = array("Name" => "form_rec", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["jornal"] = array("Name" => "jornal", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["sal_base"] = array("Name" => "sal_base", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_con"] = array("Name" => "id_con", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["cat"] = array("Name" => "cat", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["level"] = array("Name" => "level", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["post_car"] = array("Name" => "post_car", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["mod_ent"] = array("Name" => "mod_ent", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["form_rec"] = array("Name" => "form_rec", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["jornal"] = array("Name" => "jornal", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["sal_base"] = array("Name" => "sal_base", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @10-6CFB0BA0
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

//Open Method @10-25F0F98D
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT *, id_cat_con \n\n" .
        "FROM cat_con {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @10-A355DD7E
    function SetValues()
    {
        $this->id_con->SetDBValue(trim($this->f("id_con")));
        $this->cat->SetDBValue($this->f("cat"));
        $this->level->SetDBValue($this->f("level"));
        $this->post_car->SetDBValue($this->f("post_car"));
        $this->mod_ent->SetDBValue($this->f("mod_ent"));
        $this->form_rec->SetDBValue($this->f("form_rec"));
        $this->jornal->SetDBValue($this->f("jornal"));
        $this->sal_base->SetDBValue(trim($this->f("sal_base")));
    }
//End SetValues Method

//Insert Method @10-D390BFB7
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["id_con"]["Value"] = $this->id_con->GetDBValue(true);
        $this->InsertFields["cat"]["Value"] = $this->cat->GetDBValue(true);
        $this->InsertFields["level"]["Value"] = $this->level->GetDBValue(true);
        $this->InsertFields["post_car"]["Value"] = $this->post_car->GetDBValue(true);
        $this->InsertFields["mod_ent"]["Value"] = $this->mod_ent->GetDBValue(true);
        $this->InsertFields["form_rec"]["Value"] = $this->form_rec->GetDBValue(true);
        $this->InsertFields["jornal"]["Value"] = $this->jornal->GetDBValue(true);
        $this->InsertFields["sal_base"]["Value"] = $this->sal_base->GetDBValue(true);
        $this->SQL = CCBuildInsert("cat_con", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @10-F04E8242
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["id_con"]["Value"] = $this->id_con->GetDBValue(true);
        $this->UpdateFields["cat"]["Value"] = $this->cat->GetDBValue(true);
        $this->UpdateFields["level"]["Value"] = $this->level->GetDBValue(true);
        $this->UpdateFields["post_car"]["Value"] = $this->post_car->GetDBValue(true);
        $this->UpdateFields["mod_ent"]["Value"] = $this->mod_ent->GetDBValue(true);
        $this->UpdateFields["form_rec"]["Value"] = $this->form_rec->GetDBValue(true);
        $this->UpdateFields["jornal"]["Value"] = $this->jornal->GetDBValue(true);
        $this->UpdateFields["sal_base"]["Value"] = $this->sal_base->GetDBValue(true);
        $this->SQL = CCBuildUpdate("cat_con", $this->UpdateFields, $this);
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

} //End cat_conDataSource Class @10-FCB6E20C

class clsRecordeval_con { //eval_con Class @37-8555F344

//Variables @37-9E315808

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

//Class_Initialize Event @37-CCEB3080
    function clsRecordeval_con($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record eval_con/Error";
        $this->DataSource = new clseval_conDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "eval_con";
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
            $this->date_eval = new clsControl(ccsTextBox, "date_eval", "Date Eval", ccsDate, array("ShortDate"), CCGetRequestParam("date_eval", $Method, NULL), $this);
            $this->res_eval = new clsControl(ccsListBox, "res_eval", "Res Eval", ccsText, "", CCGetRequestParam("res_eval", $Method, NULL), $this);
            $this->res_eval->DSType = dsTable;
            $this->res_eval->DataSource = new clsDBmadnes();
            $this->res_eval->ds = & $this->res_eval->DataSource;
            $this->res_eval->DataSource->SQL = "SELECT * \n" .
"FROM resultado {SQL_Where} {SQL_OrderBy}";
            list($this->res_eval->BoundColumn, $this->res_eval->TextColumn, $this->res_eval->DBFormat) = array("desc_resultado", "desc_resultado", "");
            $this->cons_eval = new clsControl(ccsListBox, "cons_eval", "Cons Eval", ccsText, "", CCGetRequestParam("cons_eval", $Method, NULL), $this);
            $this->cons_eval->DSType = dsTable;
            $this->cons_eval->DataSource = new clsDBmadnes();
            $this->cons_eval->ds = & $this->cons_eval->DataSource;
            $this->cons_eval->DataSource->SQL = "SELECT * \n" .
"FROM consecuencia_evaluacion {SQL_Where} {SQL_OrderBy}";
            list($this->cons_eval->BoundColumn, $this->cons_eval->TextColumn, $this->cons_eval->DBFormat) = array("desc_ceval", "desc_ceval", "");
            $this->resp_eval = new clsControl(ccsTextBox, "resp_eval", "Resp Eval", ccsText, "", CCGetRequestParam("resp_eval", $Method, NULL), $this);
            $this->type_resp = new clsControl(ccsListBox, "type_resp", "Type Resp", ccsText, "", CCGetRequestParam("type_resp", $Method, NULL), $this);
            $this->type_resp->DSType = dsTable;
            $this->type_resp->DataSource = new clsDBmadnes();
            $this->type_resp->ds = & $this->type_resp->DataSource;
            $this->type_resp->DataSource->SQL = "SELECT * \n" .
"FROM tipo_responsable {SQL_Where} {SQL_OrderBy}";
            list($this->type_resp->BoundColumn, $this->type_resp->TextColumn, $this->type_resp->DBFormat) = array("desc_tiporesp", "desc_tiporesp", "");
        }
    }
//End Class_Initialize Event

//Initialize Method @37-07EA002B
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_con"] = CCGetFromGet("id_con", NULL);
    }
//End Initialize Method

//Validate Method @37-325BD53B
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->id_con->Validate() && $Validation);
        $Validation = ($this->date_eval->Validate() && $Validation);
        $Validation = ($this->res_eval->Validate() && $Validation);
        $Validation = ($this->cons_eval->Validate() && $Validation);
        $Validation = ($this->resp_eval->Validate() && $Validation);
        $Validation = ($this->type_resp->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->id_con->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_eval->Errors->Count() == 0);
        $Validation =  $Validation && ($this->res_eval->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cons_eval->Errors->Count() == 0);
        $Validation =  $Validation && ($this->resp_eval->Errors->Count() == 0);
        $Validation =  $Validation && ($this->type_resp->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @37-A8DFC074
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->id_con->Errors->Count());
        $errors = ($errors || $this->date_eval->Errors->Count());
        $errors = ($errors || $this->res_eval->Errors->Count());
        $errors = ($errors || $this->cons_eval->Errors->Count());
        $errors = ($errors || $this->resp_eval->Errors->Count());
        $errors = ($errors || $this->type_resp->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @37-0BF2B389
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

//InsertRow Method @37-A6C6578C
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->id_con->SetValue($this->id_con->GetValue(true));
        $this->DataSource->date_eval->SetValue($this->date_eval->GetValue(true));
        $this->DataSource->res_eval->SetValue($this->res_eval->GetValue(true));
        $this->DataSource->cons_eval->SetValue($this->cons_eval->GetValue(true));
        $this->DataSource->resp_eval->SetValue($this->resp_eval->GetValue(true));
        $this->DataSource->type_resp->SetValue($this->type_resp->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @37-D211BDDF
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->id_con->SetValue($this->id_con->GetValue(true));
        $this->DataSource->date_eval->SetValue($this->date_eval->GetValue(true));
        $this->DataSource->res_eval->SetValue($this->res_eval->GetValue(true));
        $this->DataSource->cons_eval->SetValue($this->cons_eval->GetValue(true));
        $this->DataSource->resp_eval->SetValue($this->resp_eval->GetValue(true));
        $this->DataSource->type_resp->SetValue($this->type_resp->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @37-DCA4B5E3
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

        $this->res_eval->Prepare();
        $this->cons_eval->Prepare();
        $this->type_resp->Prepare();

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
                    $this->date_eval->SetValue($this->DataSource->date_eval->GetValue());
                    $this->res_eval->SetValue($this->DataSource->res_eval->GetValue());
                    $this->cons_eval->SetValue($this->DataSource->cons_eval->GetValue());
                    $this->resp_eval->SetValue($this->DataSource->resp_eval->GetValue());
                    $this->type_resp->SetValue($this->DataSource->type_resp->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->id_con->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_eval->Errors->ToString());
            $Error = ComposeStrings($Error, $this->res_eval->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cons_eval->Errors->ToString());
            $Error = ComposeStrings($Error, $this->resp_eval->Errors->ToString());
            $Error = ComposeStrings($Error, $this->type_resp->Errors->ToString());
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
        $this->date_eval->Show();
        $this->res_eval->Show();
        $this->cons_eval->Show();
        $this->resp_eval->Show();
        $this->type_resp->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End eval_con Class @37-FCB6E20C

class clseval_conDataSource extends clsDBmadnes {  //eval_conDataSource Class @37-F3CF0C3A

//DataSource Variables @37-9CB4F765
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
    public $date_eval;
    public $res_eval;
    public $cons_eval;
    public $resp_eval;
    public $type_resp;
//End DataSource Variables

//DataSourceClass_Initialize Event @37-11439B02
    function clseval_conDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record eval_con/Error";
        $this->Initialize();
        $this->id_con = new clsField("id_con", ccsInteger, "");
        
        $this->date_eval = new clsField("date_eval", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->res_eval = new clsField("res_eval", ccsText, "");
        
        $this->cons_eval = new clsField("cons_eval", ccsText, "");
        
        $this->resp_eval = new clsField("resp_eval", ccsText, "");
        
        $this->type_resp = new clsField("type_resp", ccsText, "");
        

        $this->InsertFields["id_con"] = array("Name" => "id_con", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["date_eval"] = array("Name" => "date_eval", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["res_eval"] = array("Name" => "res_eval", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["cons_eval"] = array("Name" => "cons_eval", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["resp_eval"] = array("Name" => "resp_eval", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["type_resp"] = array("Name" => "type_resp", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_con"] = array("Name" => "id_con", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_eval"] = array("Name" => "date_eval", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["res_eval"] = array("Name" => "res_eval", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["cons_eval"] = array("Name" => "cons_eval", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["resp_eval"] = array("Name" => "resp_eval", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["type_resp"] = array("Name" => "type_resp", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @37-6CFB0BA0
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

//Open Method @37-65BD85E7
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT *, id_eval_con \n\n" .
        "FROM eval_con {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @37-CAA85D08
    function SetValues()
    {
        $this->id_con->SetDBValue(trim($this->f("id_con")));
        $this->date_eval->SetDBValue(trim($this->f("date_eval")));
        $this->res_eval->SetDBValue($this->f("res_eval"));
        $this->cons_eval->SetDBValue($this->f("cons_eval"));
        $this->resp_eval->SetDBValue($this->f("resp_eval"));
        $this->type_resp->SetDBValue($this->f("type_resp"));
    }
//End SetValues Method

//Insert Method @37-97E65920
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["id_con"]["Value"] = $this->id_con->GetDBValue(true);
        $this->InsertFields["date_eval"]["Value"] = $this->date_eval->GetDBValue(true);
        $this->InsertFields["res_eval"]["Value"] = $this->res_eval->GetDBValue(true);
        $this->InsertFields["cons_eval"]["Value"] = $this->cons_eval->GetDBValue(true);
        $this->InsertFields["resp_eval"]["Value"] = $this->resp_eval->GetDBValue(true);
        $this->InsertFields["type_resp"]["Value"] = $this->type_resp->GetDBValue(true);
        $this->SQL = CCBuildInsert("eval_con", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @37-8D95A202
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["id_con"]["Value"] = $this->id_con->GetDBValue(true);
        $this->UpdateFields["date_eval"]["Value"] = $this->date_eval->GetDBValue(true);
        $this->UpdateFields["res_eval"]["Value"] = $this->res_eval->GetDBValue(true);
        $this->UpdateFields["cons_eval"]["Value"] = $this->cons_eval->GetDBValue(true);
        $this->UpdateFields["resp_eval"]["Value"] = $this->resp_eval->GetDBValue(true);
        $this->UpdateFields["type_resp"]["Value"] = $this->type_resp->GetDBValue(true);
        $this->SQL = CCBuildUpdate("eval_con", $this->UpdateFields, $this);
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

} //End eval_conDataSource Class @37-FCB6E20C

//Initialize Page @1-993B0415
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
$TemplateFileName = "regdat_fcconr.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-E92C9B4C
$DBmadnes = new clsDBmadnes();
$MainPage->Connections["madnes"] = & $DBmadnes;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$fin_con = new clsRecordfin_con("", $MainPage);
$cat_con = new clsRecordcat_con("", $MainPage);
$eval_con = new clsRecordeval_con("", $MainPage);
$MainPage->fin_con = & $fin_con;
$MainPage->cat_con = & $cat_con;
$MainPage->eval_con = & $eval_con;
$fin_con->Initialize();
$cat_con->Initialize();
$eval_con->Initialize();

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

//Execute Components @1-0533C0A5
$eval_con->Operation();
$cat_con->Operation();
$fin_con->Operation();
//End Execute Components

//Go to destination page @1-616E51B3
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmadnes->close();
    header("Location: " . $Redirect);
    unset($fin_con);
    unset($cat_con);
    unset($eval_con);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-3B0F0C3D
$fin_con->Show();
$cat_con->Show();
$eval_con->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-DA717B12
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmadnes->close();
unset($fin_con);
unset($cat_con);
unset($eval_con);
unset($Tpl);
//End Unload Page


?>
