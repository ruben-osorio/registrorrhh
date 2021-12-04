<?php
//Include Common Files @1-C4E4150B
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "RegMovilidad.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordchar_per { //char_per Class @2-0FEEEAC6

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

//Class_Initialize Event @2-AE46DD95
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
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->dir_g = new clsControl(ccsListBox, "dir_g", "Dir G", ccsText, "", CCGetRequestParam("dir_g", $Method, NULL), $this);
            $this->dir_g->DSType = dsTable;
            $this->dir_g->DataSource = new clsDBmadnes();
            $this->dir_g->ds = & $this->dir_g->DataSource;
            $this->dir_g->DataSource->SQL = "SELECT desc_dg, id_dg \n" .
"FROM direccion_gral {SQL_Where} {SQL_OrderBy}";
            list($this->dir_g->BoundColumn, $this->dir_g->TextColumn, $this->dir_g->DBFormat) = array("desc_dg", "desc_dg", "");
            $this->unit = new clsControl(ccsListBox, "unit", "Unit", ccsText, "", CCGetRequestParam("unit", $Method, NULL), $this);
            $this->unit->DSType = dsTable;
            $this->unit->DataSource = new clsDBmadnes();
            $this->unit->ds = & $this->unit->DataSource;
            $this->unit->DataSource->SQL = "SELECT desc_uni, id_dg \n" .
"FROM unidad {SQL_Where} {SQL_OrderBy}";
            list($this->unit->BoundColumn, $this->unit->TextColumn, $this->unit->DBFormat) = array("desc_uni", "desc_uni", "");
            $this->area = new clsControl(ccsListBox, "area", "Area", ccsText, "", CCGetRequestParam("area", $Method, NULL), $this);
            $this->area->DSType = dsTable;
            $this->area->DataSource = new clsDBmadnes();
            $this->area->ds = & $this->area->DataSource;
            $this->area->DataSource->SQL = "SELECT desc_area, id_dg \n" .
"FROM area {SQL_Where} {SQL_OrderBy}";
            list($this->area->BoundColumn, $this->area->TextColumn, $this->area->DBFormat) = array("desc_area", "desc_area", "");
            $this->boss_is = new clsControl(ccsTextBox, "boss_is", "Boss Is", ccsText, "", CCGetRequestParam("boss_is", $Method, NULL), $this);
            $this->boss_ij = new clsControl(ccsTextBox, "boss_ij", "Boss Ij", ccsText, "", CCGetRequestParam("boss_ij", $Method, NULL), $this);
            $this->charge = new clsControl(ccsTextBox, "charge", "Charge", ccsText, "", CCGetRequestParam("charge", $Method, NULL), $this);
            $this->date_des = new clsControl(ccsTextBox, "date_des", "date_des", ccsDate, array("ShortDate"), CCGetRequestParam("date_des", $Method, NULL), $this);
            $this->date_end = new clsControl(ccsTextBox, "date_end", "Date End", ccsDate, array("ShortDate"), CCGetRequestParam("date_end", $Method, NULL), $this);
            $this->num_memo = new clsControl(ccsTextBox, "num_memo", "Num Memo", ccsText, "", CCGetRequestParam("num_memo", $Method, NULL), $this);
            $this->fecha_des_ini = new clsControl(ccsTextBox, "fecha_des_ini", "fecha_des_ini", ccsDate, array("ShortDate"), CCGetRequestParam("fecha_des_ini", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @2-F469EFC8
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_char_per"] = CCGetFromGet("id_char_per", NULL);
    }
//End Initialize Method

//Validate Method @2-0987C520
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->dir_g->Validate() && $Validation);
        $Validation = ($this->unit->Validate() && $Validation);
        $Validation = ($this->area->Validate() && $Validation);
        $Validation = ($this->boss_is->Validate() && $Validation);
        $Validation = ($this->boss_ij->Validate() && $Validation);
        $Validation = ($this->charge->Validate() && $Validation);
        $Validation = ($this->date_des->Validate() && $Validation);
        $Validation = ($this->date_end->Validate() && $Validation);
        $Validation = ($this->num_memo->Validate() && $Validation);
        $Validation = ($this->fecha_des_ini->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->dir_g->Errors->Count() == 0);
        $Validation =  $Validation && ($this->unit->Errors->Count() == 0);
        $Validation =  $Validation && ($this->area->Errors->Count() == 0);
        $Validation =  $Validation && ($this->boss_is->Errors->Count() == 0);
        $Validation =  $Validation && ($this->boss_ij->Errors->Count() == 0);
        $Validation =  $Validation && ($this->charge->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_des->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_end->Errors->Count() == 0);
        $Validation =  $Validation && ($this->num_memo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->fecha_des_ini->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-3231E9C7
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->dir_g->Errors->Count());
        $errors = ($errors || $this->unit->Errors->Count());
        $errors = ($errors || $this->area->Errors->Count());
        $errors = ($errors || $this->boss_is->Errors->Count());
        $errors = ($errors || $this->boss_ij->Errors->Count());
        $errors = ($errors || $this->charge->Errors->Count());
        $errors = ($errors || $this->date_des->Errors->Count());
        $errors = ($errors || $this->date_end->Errors->Count());
        $errors = ($errors || $this->num_memo->Errors->Count());
        $errors = ($errors || $this->fecha_des_ini->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @2-5B06BA55
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

//UpdateRow Method @2-D199F12A
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->dir_g->SetValue($this->dir_g->GetValue(true));
        $this->DataSource->unit->SetValue($this->unit->GetValue(true));
        $this->DataSource->area->SetValue($this->area->GetValue(true));
        $this->DataSource->boss_is->SetValue($this->boss_is->GetValue(true));
        $this->DataSource->boss_ij->SetValue($this->boss_ij->GetValue(true));
        $this->DataSource->charge->SetValue($this->charge->GetValue(true));
        $this->DataSource->date_des->SetValue($this->date_des->GetValue(true));
        $this->DataSource->date_end->SetValue($this->date_end->GetValue(true));
        $this->DataSource->num_memo->SetValue($this->num_memo->GetValue(true));
        $this->DataSource->fecha_des_ini->SetValue($this->fecha_des_ini->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @2-055EF71C
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
                    $this->dir_g->SetValue($this->DataSource->dir_g->GetValue());
                    $this->unit->SetValue($this->DataSource->unit->GetValue());
                    $this->area->SetValue($this->DataSource->area->GetValue());
                    $this->boss_is->SetValue($this->DataSource->boss_is->GetValue());
                    $this->boss_ij->SetValue($this->DataSource->boss_ij->GetValue());
                    $this->charge->SetValue($this->DataSource->charge->GetValue());
                    $this->date_des->SetValue($this->DataSource->date_des->GetValue());
                    $this->date_end->SetValue($this->DataSource->date_end->GetValue());
                    $this->num_memo->SetValue($this->DataSource->num_memo->GetValue());
                    $this->fecha_des_ini->SetValue($this->DataSource->fecha_des_ini->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->dir_g->Errors->ToString());
            $Error = ComposeStrings($Error, $this->unit->Errors->ToString());
            $Error = ComposeStrings($Error, $this->area->Errors->ToString());
            $Error = ComposeStrings($Error, $this->boss_is->Errors->ToString());
            $Error = ComposeStrings($Error, $this->boss_ij->Errors->ToString());
            $Error = ComposeStrings($Error, $this->charge->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_des->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_end->Errors->ToString());
            $Error = ComposeStrings($Error, $this->num_memo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->fecha_des_ini->Errors->ToString());
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
        $this->dir_g->Show();
        $this->unit->Show();
        $this->area->Show();
        $this->boss_is->Show();
        $this->boss_ij->Show();
        $this->charge->Show();
        $this->date_des->Show();
        $this->date_end->Show();
        $this->num_memo->Show();
        $this->fecha_des_ini->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End char_per Class @2-FCB6E20C

class clschar_perDataSource extends clsDBmadnes {  //char_perDataSource Class @2-195B79CD

//DataSource Variables @2-90439BC1
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
    public $dir_g;
    public $unit;
    public $area;
    public $boss_is;
    public $boss_ij;
    public $charge;
    public $date_des;
    public $date_end;
    public $num_memo;
    public $fecha_des_ini;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-FC6D3C24
    function clschar_perDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record char_per/Error";
        $this->Initialize();
        $this->dir_g = new clsField("dir_g", ccsText, "");
        
        $this->unit = new clsField("unit", ccsText, "");
        
        $this->area = new clsField("area", ccsText, "");
        
        $this->boss_is = new clsField("boss_is", ccsText, "");
        
        $this->boss_ij = new clsField("boss_ij", ccsText, "");
        
        $this->charge = new clsField("charge", ccsText, "");
        
        $this->date_des = new clsField("date_des", ccsDate, $this->DateFormat);
        
        $this->date_end = new clsField("date_end", ccsDate, array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn", ":", "ss"));
        
        $this->num_memo = new clsField("num_memo", ccsText, "");
        
        $this->fecha_des_ini = new clsField("fecha_des_ini", ccsDate, array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn", ":", "ss"));
        

        $this->UpdateFields["dir_g"] = array("Name" => "dir_g", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["unit"] = array("Name" => "unit", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["area"] = array("Name" => "area", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["boss_is"] = array("Name" => "boss_is", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["boss_ij"] = array("Name" => "boss_ij", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["charge"] = array("Name" => "charge", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_des"] = array("Name" => "date_des", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_end"] = array("Name" => "date_end", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["num_memo"] = array("Name" => "num_memo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_des_ini"] = array("Name" => "date_des_ini", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-0DDE4330
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_char_per", ccsInteger, "", "", $this->Parameters["urlid_char_per"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_char_per", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-1A25EC5D
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM char_per {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-880C339E
    function SetValues()
    {
        $this->dir_g->SetDBValue($this->f("dir_g"));
        $this->unit->SetDBValue($this->f("unit"));
        $this->area->SetDBValue($this->f("area"));
        $this->boss_is->SetDBValue($this->f("boss_is"));
        $this->boss_ij->SetDBValue($this->f("boss_ij"));
        $this->charge->SetDBValue($this->f("charge"));
        $this->date_des->SetDBValue(trim($this->f("date_des")));
        $this->date_end->SetDBValue(trim($this->f("date_end")));
        $this->num_memo->SetDBValue($this->f("num_memo"));
        $this->fecha_des_ini->SetDBValue(trim($this->f("date_des_ini")));
    }
//End SetValues Method

//Update Method @2-8E6B081D
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["dir_g"]["Value"] = $this->dir_g->GetDBValue(true);
        $this->UpdateFields["unit"]["Value"] = $this->unit->GetDBValue(true);
        $this->UpdateFields["area"]["Value"] = $this->area->GetDBValue(true);
        $this->UpdateFields["boss_is"]["Value"] = $this->boss_is->GetDBValue(true);
        $this->UpdateFields["boss_ij"]["Value"] = $this->boss_ij->GetDBValue(true);
        $this->UpdateFields["charge"]["Value"] = $this->charge->GetDBValue(true);
        $this->UpdateFields["date_des"]["Value"] = $this->date_des->GetDBValue(true);
        $this->UpdateFields["date_end"]["Value"] = $this->date_end->GetDBValue(true);
        $this->UpdateFields["num_memo"]["Value"] = $this->num_memo->GetDBValue(true);
        $this->UpdateFields["date_des_ini"]["Value"] = $this->fecha_des_ini->GetDBValue(true);
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

} //End char_perDataSource Class @2-FCB6E20C

//funcionario ReportGroup class @26-992CD3B2
class clsReportGroupfuncionario {
    public $GroupType;
    public $mode; //1 - open, 2 - close
    public $name, $_nameAttributes;
    public $l_name1, $_l_name1Attributes;
    public $l_name2, $_l_name2Attributes;
    public $l_name_es, $_l_name_esAttributes;
    public $Attributes;
    public $ReportTotalIndex = 0;
    public $PageTotalIndex;
    public $PageNumber;
    public $RowNumber;
    public $Parent;

    function clsReportGroupfuncionario(& $parent) {
        $this->Parent = & $parent;
        $this->Attributes = $this->Parent->Attributes->GetAsArray();
    }
    function SetControls($PrevGroup = "") {
        $this->name = $this->Parent->name->Value;
        $this->l_name1 = $this->Parent->l_name1->Value;
        $this->l_name2 = $this->Parent->l_name2->Value;
        $this->l_name_es = $this->Parent->l_name_es->Value;
    }

    function SetTotalControls($mode = "", $PrevGroup = "") {
        $this->_nameAttributes = $this->Parent->name->Attributes->GetAsArray();
        $this->_l_name1Attributes = $this->Parent->l_name1->Attributes->GetAsArray();
        $this->_l_name2Attributes = $this->Parent->l_name2->Attributes->GetAsArray();
        $this->_l_name_esAttributes = $this->Parent->l_name_es->Attributes->GetAsArray();
    }
    function SyncWithHeader(& $Header) {
        $this->name = $Header->name;
        $Header->_nameAttributes = $this->_nameAttributes;
        $this->Parent->name->Value = $Header->name;
        $this->Parent->name->Attributes->RestoreFromArray($Header->_nameAttributes);
        $this->l_name1 = $Header->l_name1;
        $Header->_l_name1Attributes = $this->_l_name1Attributes;
        $this->Parent->l_name1->Value = $Header->l_name1;
        $this->Parent->l_name1->Attributes->RestoreFromArray($Header->_l_name1Attributes);
        $this->l_name2 = $Header->l_name2;
        $Header->_l_name2Attributes = $this->_l_name2Attributes;
        $this->Parent->l_name2->Value = $Header->l_name2;
        $this->Parent->l_name2->Attributes->RestoreFromArray($Header->_l_name2Attributes);
        $this->l_name_es = $Header->l_name_es;
        $Header->_l_name_esAttributes = $this->_l_name_esAttributes;
        $this->Parent->l_name_es->Value = $Header->l_name_es;
        $this->Parent->l_name_es->Attributes->RestoreFromArray($Header->_l_name_esAttributes);
    }
    function ChangeTotalControls() {
    }
}
//End funcionario ReportGroup class

//funcionario GroupsCollection class @26-A0BDFB99
class clsGroupsCollectionfuncionario {
    public $Groups;
    public $mPageCurrentHeaderIndex;
    public $PageSize;
    public $TotalPages = 0;
    public $TotalRows = 0;
    public $CurrentPageSize = 0;
    public $Pages;
    public $Parent;
    public $LastDetailIndex;

    function clsGroupsCollectionfuncionario(& $parent) {
        $this->Parent = & $parent;
        $this->Groups = array();
        $this->Pages  = array();
        $this->mReportTotalIndex = 0;
        $this->mPageTotalIndex = 1;
    }

    function & InitGroup() {
        $group = new clsReportGroupfuncionario($this->Parent);
        $group->RowNumber = $this->TotalRows + 1;
        $group->PageNumber = $this->TotalPages;
        $group->PageTotalIndex = $this->mPageCurrentHeaderIndex;
        return $group;
    }

    function RestoreValues() {
        $this->Parent->name->Value = $this->Parent->name->initialValue;
        $this->Parent->l_name1->Value = $this->Parent->l_name1->initialValue;
        $this->Parent->l_name2->Value = $this->Parent->l_name2->initialValue;
        $this->Parent->l_name_es->Value = $this->Parent->l_name_es->initialValue;
    }

    function OpenPage() {
        $this->TotalPages++;
        $Group = & $this->InitGroup();
        $this->Parent->Page_Header->CCSEventResult = CCGetEvent($this->Parent->Page_Header->CCSEvents, "OnInitialize", $this->Parent->Page_Header);
        if ($this->Parent->Page_Header->Visible)
            $this->CurrentPageSize = $this->CurrentPageSize + $this->Parent->Page_Header->Height;
        $Group->SetTotalControls("GetNextValue");
        $this->Parent->Page_Header->CCSEventResult = CCGetEvent($this->Parent->Page_Header->CCSEvents, "OnCalculate", $this->Parent->Page_Header);
        $Group->SetControls();
        $Group->Mode = 1;
        $Group->GroupType = "Page";
        $Group->PageTotalIndex = count($this->Groups);
        $this->mPageCurrentHeaderIndex = count($this->Groups);
        $this->Groups[] =  & $Group;
        $this->Pages[] =  count($this->Groups) == 2 ? 0 : count($this->Groups) - 1;
    }

    function OpenGroup($groupName) {
        $Group = "";
        $OpenFlag = false;
        if ($groupName == "Report") {
            $Group = & $this->InitGroup(true);
            $this->Parent->Report_Header->CCSEventResult = CCGetEvent($this->Parent->Report_Header->CCSEvents, "OnInitialize", $this->Parent->Report_Header);
            if ($this->Parent->Report_Header->Visible) 
                $this->CurrentPageSize = $this->CurrentPageSize + $this->Parent->Report_Header->Height;
                $Group->SetTotalControls("GetNextValue");
            $this->Parent->Report_Header->CCSEventResult = CCGetEvent($this->Parent->Report_Header->CCSEvents, "OnCalculate", $this->Parent->Report_Header);
            $Group->SetControls();
            $Group->Mode = 1;
            $Group->GroupType = "Report";
            $this->Groups[] = & $Group;
            $this->OpenPage();
        }
    }

    function ClosePage() {
        $Group = & $this->InitGroup();
        $this->Parent->Page_Footer->CCSEventResult = CCGetEvent($this->Parent->Page_Footer->CCSEvents, "OnInitialize", $this->Parent->Page_Footer);
        $Group->SetTotalControls("GetPrevValue");
        $Group->SyncWithHeader($this->Groups[$this->mPageCurrentHeaderIndex]);
        $this->Parent->Page_Footer->CCSEventResult = CCGetEvent($this->Parent->Page_Footer->CCSEvents, "OnCalculate", $this->Parent->Page_Footer);
        $Group->SetControls();
        $this->RestoreValues();
        $this->CurrentPageSize = 0;
        $Group->Mode = 2;
        $Group->GroupType = "Page";
        $this->Groups[] = & $Group;
    }

    function CloseGroup($groupName)
    {
        $Group = "";
        if ($groupName == "Report") {
            $Group = & $this->InitGroup(true);
            $this->Parent->Report_Footer->CCSEventResult = CCGetEvent($this->Parent->Report_Footer->CCSEvents, "OnInitialize", $this->Parent->Report_Footer);
            if ($this->Parent->Page_Footer->Visible) 
                $OverSize = $this->Parent->Report_Footer->Height + $this->Parent->Page_Footer->Height;
            else
                $OverSize = $this->Parent->Report_Footer->Height;
            if (($this->PageSize > 0) and $this->Parent->Report_Footer->Visible and ($this->CurrentPageSize + $OverSize > $this->PageSize)) {
                $this->ClosePage();
                $this->OpenPage();
            }
            $Group->SetTotalControls("GetPrevValue");
            $Group->SyncWithHeader($this->Groups[0]);
            if ($this->Parent->Report_Footer->Visible)
                $this->CurrentPageSize = $this->CurrentPageSize + $this->Parent->Report_Footer->Height;
            $this->Parent->Report_Footer->CCSEventResult = CCGetEvent($this->Parent->Report_Footer->CCSEvents, "OnCalculate", $this->Parent->Report_Footer);
            $Group->SetControls();
            $this->RestoreValues();
            $Group->Mode = 2;
            $Group->GroupType = "Report";
            $this->Groups[] = & $Group;
            $this->ClosePage();
            return;
        }
    }

    function AddItem()
    {
        $Group = & $this->InitGroup(true);
        $this->Parent->Detail->CCSEventResult = CCGetEvent($this->Parent->Detail->CCSEvents, "OnInitialize", $this->Parent->Detail);
        if ($this->Parent->Page_Footer->Visible) 
            $OverSize = $this->Parent->Detail->Height + $this->Parent->Page_Footer->Height;
        else
            $OverSize = $this->Parent->Detail->Height;
        if (($this->PageSize > 0) and $this->Parent->Detail->Visible and ($this->CurrentPageSize + $OverSize > $this->PageSize)) {
            $this->ClosePage();
            $this->OpenPage();
        }
        $this->TotalRows++;
        if ($this->LastDetailIndex)
            $PrevGroup = & $this->Groups[$this->LastDetailIndex];
        else
            $PrevGroup = "";
        $Group->SetTotalControls("", $PrevGroup);
        if ($this->Parent->Detail->Visible)
            $this->CurrentPageSize = $this->CurrentPageSize + $this->Parent->Detail->Height;
        $this->Parent->Detail->CCSEventResult = CCGetEvent($this->Parent->Detail->CCSEvents, "OnCalculate", $this->Parent->Detail);
        $Group->SetControls($PrevGroup);
        $this->LastDetailIndex = count($this->Groups);
        $this->Groups[] = & $Group;
    }
}
//End funcionario GroupsCollection class

class clsReportfuncionario { //funcionario Class @26-C5D6F396

//funcionario Variables @26-944D286E

    public $ComponentType = "Report";
    public $PageSize;
    public $ComponentName;
    public $Visible;
    public $Errors;
    public $CCSEvents = array();
    public $CCSEventResult;
    public $RelativePath = "";
    public $ViewMode = "Web";
    public $TemplateBlock;
    public $PageNumber;
    public $RowNumber;
    public $TotalRows;
    public $TotalPages;
    public $ControlsVisible = array();
    public $IsEmpty;
    public $Attributes;
    public $DetailBlock, $Detail;
    public $Report_FooterBlock, $Report_Footer;
    public $Report_HeaderBlock, $Report_Header;
    public $Page_FooterBlock, $Page_Footer;
    public $Page_HeaderBlock, $Page_Header;
    public $SorterName, $SorterDirection;

    public $ds;
    public $DataSource;
    public $UseClientPaging = false;

    //Report Controls
    public $StaticControls, $RowControls, $Report_FooterControls, $Report_HeaderControls;
    public $Page_FooterControls, $Page_HeaderControls;
//End funcionario Variables

//Class_Initialize Event @26-D3E841E4
    function clsReportfuncionario($RelativePath = "", & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "funcionario";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->Detail = new clsSection($this);
        $MinPageSize = 0;
        $MaxSectionSize = 0;
        $this->Detail->Height = 1;
        $MaxSectionSize = max($MaxSectionSize, $this->Detail->Height);
        $this->Detail->Visible = false;
        $this->Report_Footer = new clsSection($this);
        $this->Report_Header = new clsSection($this);
        $this->Page_Footer = new clsSection($this);
        $this->Page_Header = new clsSection($this);
        $this->Page_Header->Height = 1;
        $MinPageSize += $this->Page_Header->Height;
        $this->Errors = new clsErrors();
        $this->DataSource = new clsfuncionarioDataSource($this);
        $this->ds = & $this->DataSource;
        $PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(is_numeric($PageSize) && $PageSize > 0) {
            $this->PageSize = $PageSize;
        } else {
            if (!is_numeric($PageSize) || $PageSize < 0)
                $this->PageSize = 10;
             else if ($PageSize == "0")
                $this->PageSize = 100;
             else 
                $this->PageSize = min(100, $PageSize);
        }
        $MinPageSize += $MaxSectionSize;
        if ($this->PageSize && $MinPageSize && $this->PageSize < $MinPageSize)
            $this->PageSize = $MinPageSize;
        $this->PageNumber = $this->ViewMode == "Print" ? 1 : intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0 ) {
            $this->PageNumber = 1;
        }

        $this->name = new clsControl(ccsReportLabel, "name", "name", ccsText, "", "", $this);
        $this->l_name1 = new clsControl(ccsReportLabel, "l_name1", "l_name1", ccsText, "", "", $this);
        $this->l_name2 = new clsControl(ccsReportLabel, "l_name2", "l_name2", ccsText, "", "", $this);
        $this->l_name_es = new clsControl(ccsReportLabel, "l_name_es", "l_name_es", ccsText, "", "", $this);
        $this->NoRecords = new clsPanel("NoRecords", $this);
    }
//End Class_Initialize Event

//Initialize Method @26-6C59EE65
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = $this->PageSize;
        $this->DataSource->AbsolutePage = $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//CheckErrors Method @26-E3E5801A
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->name->Errors->Count());
        $errors = ($errors || $this->l_name1->Errors->Count());
        $errors = ($errors || $this->l_name2->Errors->Count());
        $errors = ($errors || $this->l_name_es->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//GetErrors Method @26-88EC88F5
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->l_name1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->l_name2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->l_name_es->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

//Show Method @26-EDD962BD
    function Show()
    {
        $Tpl = CCGetTemplate($this);
        global $CCSLocales;
        if(!$this->Visible) return;

        $ShownRecords = 0;

        $this->DataSource->Parameters["urlid_func"] = CCGetFromGet("id_func", NULL);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $this->DataSource->Prepare();
        $this->DataSource->Open();

        $Groups = new clsGroupsCollectionfuncionario($this);
        $Groups->PageSize = $this->PageSize > 0 ? $this->PageSize : 0;

        $is_next_record = $this->DataSource->next_record();
        $this->IsEmpty = ! $is_next_record;
        while($is_next_record) {
            $this->DataSource->SetValues();
            $this->name->SetValue($this->DataSource->name->GetValue());
            $this->l_name1->SetValue($this->DataSource->l_name1->GetValue());
            $this->l_name2->SetValue($this->DataSource->l_name2->GetValue());
            $this->l_name_es->SetValue($this->DataSource->l_name_es->GetValue());
            if (count($Groups->Groups) == 0) $Groups->OpenGroup("Report");
            $Groups->AddItem();
            $is_next_record = $this->DataSource->next_record();
        }
        if (!count($Groups->Groups)) 
            $Groups->OpenGroup("Report");
        else
            $this->NoRecords->Visible = false;
        $Groups->CloseGroup("Report");
        $this->TotalPages = $Groups->TotalPages;
        $this->TotalRows = $Groups->TotalRows;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) return;

        $this->Attributes->Show();
        $ReportBlock = "Report " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $ReportBlock;

        if($this->CheckErrors()) {
            $Tpl->replaceblock("", $this->GetErrors());
            $Tpl->block_path = $ParentPath;
            return;
        } else {
            $items = & $Groups->Groups;
            $i = $Groups->Pages[min($this->PageNumber, $Groups->TotalPages) - 1];
            $this->ControlsVisible["name"] = $this->name->Visible;
            $this->ControlsVisible["l_name1"] = $this->l_name1->Visible;
            $this->ControlsVisible["l_name2"] = $this->l_name2->Visible;
            $this->ControlsVisible["l_name_es"] = $this->l_name_es->Visible;
            do {
                $this->Attributes->RestoreFromArray($items[$i]->Attributes);
                $this->RowNumber = $items[$i]->RowNumber;
                switch ($items[$i]->GroupType) {
                    Case "":
                        $Tpl->block_path = $ParentPath . "/" . $ReportBlock . "/Section Detail";
                        $this->name->SetValue($items[$i]->name);
                        $this->name->Attributes->RestoreFromArray($items[$i]->_nameAttributes);
                        $this->l_name1->SetValue($items[$i]->l_name1);
                        $this->l_name1->Attributes->RestoreFromArray($items[$i]->_l_name1Attributes);
                        $this->l_name2->SetValue($items[$i]->l_name2);
                        $this->l_name2->Attributes->RestoreFromArray($items[$i]->_l_name2Attributes);
                        $this->l_name_es->SetValue($items[$i]->l_name_es);
                        $this->l_name_es->Attributes->RestoreFromArray($items[$i]->_l_name_esAttributes);
                        $this->Detail->CCSEventResult = CCGetEvent($this->Detail->CCSEvents, "BeforeShow", $this->Detail);
                        $this->Attributes->Show();
                        $this->name->Show();
                        $this->l_name1->Show();
                        $this->l_name2->Show();
                        $this->l_name_es->Show();
                        $Tpl->block_path = $ParentPath . "/" . $ReportBlock;
                        if ($this->Detail->Visible)
                            $Tpl->parseto("Section Detail", true, "Section Detail");
                        break;
                    case "Report":
                        if ($items[$i]->Mode == 1) {
                            $this->Report_Header->CCSEventResult = CCGetEvent($this->Report_Header->CCSEvents, "BeforeShow", $this->Report_Header);
                            if ($this->Report_Header->Visible) {
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock . "/Section Report_Header";
                                $this->Attributes->Show();
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock;
                                $Tpl->parseto("Section Report_Header", true, "Section Detail");
                            }
                        }
                        if ($items[$i]->Mode == 2) {
                            $this->Report_Footer->CCSEventResult = CCGetEvent($this->Report_Footer->CCSEvents, "BeforeShow", $this->Report_Footer);
                            if ($this->Report_Footer->Visible) {
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock . "/Section Report_Footer";
                                $this->NoRecords->Show();
                                $this->Attributes->Show();
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock;
                                $Tpl->parseto("Section Report_Footer", true, "Section Detail");
                            }
                        }
                        break;
                    case "Page":
                        if ($items[$i]->Mode == 1) {
                            $this->Page_Header->CCSEventResult = CCGetEvent($this->Page_Header->CCSEvents, "BeforeShow", $this->Page_Header);
                            if ($this->Page_Header->Visible) {
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock . "/Section Page_Header";
                                $this->Attributes->Show();
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock;
                                $Tpl->parseto("Section Page_Header", true, "Section Detail");
                            }
                        }
                        if ($items[$i]->Mode == 2 && !$this->UseClientPaging || $items[$i]->Mode == 1 && $this->UseClientPaging) {
                            $this->Page_Footer->CCSEventResult = CCGetEvent($this->Page_Footer->CCSEvents, "BeforeShow", $this->Page_Footer);
                            if ($this->Page_Footer->Visible) {
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock . "/Section Page_Footer";
                                $this->Attributes->Show();
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock;
                                $Tpl->parseto("Section Page_Footer", true, "Section Detail");
                            }
                        }
                        break;
                }
                $i++;
            } while ($i < count($items) && ($this->ViewMode == "Print" ||  !($i > 1 && $items[$i]->GroupType == 'Page' && $items[$i]->Mode == 1)));
            $Tpl->block_path = $ParentPath;
            $Tpl->parse($ReportBlock);
            $this->DataSource->close();
        }

    }
//End Show Method

} //End funcionario Class @26-FCB6E20C

class clsfuncionarioDataSource extends clsDBmadnes {  //funcionarioDataSource Class @26-5680E709

//DataSource Variables @26-BAD37969
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $wp;


    // Datasource fields
    public $name;
    public $l_name1;
    public $l_name2;
    public $l_name_es;
//End DataSource Variables

//DataSourceClass_Initialize Event @26-9CCB4233
    function clsfuncionarioDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Report funcionario";
        $this->Initialize();
        $this->name = new clsField("name", ccsText, "");
        
        $this->l_name1 = new clsField("l_name1", ccsText, "");
        
        $this->l_name2 = new clsField("l_name2", ccsText, "");
        
        $this->l_name_es = new clsField("l_name_es", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @26-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @26-AB60C611
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_func", ccsInteger, "", "", $this->Parameters["urlid_func"], xxx, false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_func", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @26-BBCC2A34
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT name, l_name1, l_name2, l_name_es, id_func \n\n" .
        "FROM funcionario {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @26-6CCD540A
    function SetValues()
    {
        $this->name->SetDBValue($this->f("name"));
        $this->l_name1->SetDBValue($this->f("l_name1"));
        $this->l_name2->SetDBValue($this->f("l_name2"));
        $this->l_name_es->SetDBValue($this->f("l_name_es"));
    }
//End SetValues Method

} //End funcionarioDataSource Class @26-FCB6E20C

//Initialize Page @1-172EC84D
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
$TemplateFileName = "RegMovilidad.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "./";
$PathToRootOpt = "";
$Scripts = "|js/jquery/jquery.js|js/jquery/event-manager.js|js/jquery/selectors.js|js/jquery/ui/jquery.ui.core.js|js/jquery/ui/jquery.ui.widget.js|js/jquery/ui/jquery.ui.datepicker.js|js/jquery/datepicker/ccs-date-timepicker.js|";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Include events file @1-40EBF75C
include_once("./RegMovilidad_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-1C58974D
$DBmadnes = new clsDBmadnes();
$MainPage->Connections["madnes"] = & $DBmadnes;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$char_per = new clsRecordchar_per("", $MainPage);
$funcionario = new clsReportfuncionario("", $MainPage);
$MainPage->char_per = & $char_per;
$MainPage->funcionario = & $funcionario;
$char_per->Initialize();
$funcionario->Initialize();
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

//Execute Components @1-1A0F59BA
$char_per->Operation();
//End Execute Components

//Go to destination page @1-376B9936
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmadnes->close();
    header("Location: " . $Redirect);
    unset($char_per);
    unset($funcionario);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-2CD2D6BD
$char_per->Show();
$funcionario->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-6A7AD32D
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmadnes->close();
unset($char_per);
unset($funcionario);
unset($Tpl);
//End Unload Page


?>
