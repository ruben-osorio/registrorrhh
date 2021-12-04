<?php
//Include Common Files @1-F276AE99
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "Reg_dat_ac.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGriddat_aca { //dat_aca class @2-D013C2B7

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

//Class_Initialize Event @2-EEE3B4A4
    function clsGriddat_aca($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "dat_aca";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid dat_aca";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsdat_acaDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 15;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<BR>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->id_dat = new clsControl(ccsLink, "id_dat", "id_dat", ccsInteger, "", CCGetRequestParam("id_dat", ccsGet, NULL), $this);
        $this->id_dat->Page = "";
        $this->level = new clsControl(ccsLabel, "level", "level", ccsText, "", CCGetRequestParam("level", ccsGet, NULL), $this);
        $this->date_start = new clsControl(ccsLabel, "date_start", "date_start", ccsDate, array("ShortDate"), CCGetRequestParam("date_start", ccsGet, NULL), $this);
        $this->date_end = new clsControl(ccsLabel, "date_end", "date_end", ccsDate, array("ShortDate"), CCGetRequestParam("date_end", ccsGet, NULL), $this);
        $this->career_esp = new clsControl(ccsLabel, "career_esp", "career_esp", ccsText, "", CCGetRequestParam("career_esp", ccsGet, NULL), $this);
        $this->name_inst = new clsControl(ccsLabel, "name_inst", "name_inst", ccsText, "", CCGetRequestParam("name_inst", ccsGet, NULL), $this);
        $this->city = new clsControl(ccsLabel, "city", "city", ccsText, "", CCGetRequestParam("city", ccsGet, NULL), $this);
        $this->dat_aca_Insert = new clsControl(ccsLink, "dat_aca_Insert", "dat_aca_Insert", ccsText, "", CCGetRequestParam("dat_aca_Insert", ccsGet, NULL), $this);
        $this->dat_aca_Insert->Parameters = CCGetQueryString("QueryString", array("id_dat", "ccsForm"));
        $this->dat_aca_Insert->Page = "Reg_dat_ac.php";
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

//Show Method @2-243D3FF1
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
            $this->ControlsVisible["id_dat"] = $this->id_dat->Visible;
            $this->ControlsVisible["level"] = $this->level->Visible;
            $this->ControlsVisible["date_start"] = $this->date_start->Visible;
            $this->ControlsVisible["date_end"] = $this->date_end->Visible;
            $this->ControlsVisible["career_esp"] = $this->career_esp->Visible;
            $this->ControlsVisible["name_inst"] = $this->name_inst->Visible;
            $this->ControlsVisible["city"] = $this->city->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->id_dat->SetValue($this->DataSource->id_dat->GetValue());
                $this->id_dat->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->id_dat->Parameters = CCAddParam($this->id_dat->Parameters, "id_dat", $this->DataSource->f("id_dat"));
                $this->level->SetValue($this->DataSource->level->GetValue());
                $this->date_start->SetValue($this->DataSource->date_start->GetValue());
                $this->date_end->SetValue($this->DataSource->date_end->GetValue());
                $this->career_esp->SetValue($this->DataSource->career_esp->GetValue());
                $this->name_inst->SetValue($this->DataSource->name_inst->GetValue());
                $this->city->SetValue($this->DataSource->city->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->id_dat->Show();
                $this->level->Show();
                $this->date_start->Show();
                $this->date_end->Show();
                $this->career_esp->Show();
                $this->name_inst->Show();
                $this->city->Show();
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
        $this->dat_aca_Insert->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @2-B2C55E7C
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->id_dat->Errors->ToString());
        $errors = ComposeStrings($errors, $this->level->Errors->ToString());
        $errors = ComposeStrings($errors, $this->date_start->Errors->ToString());
        $errors = ComposeStrings($errors, $this->date_end->Errors->ToString());
        $errors = ComposeStrings($errors, $this->career_esp->Errors->ToString());
        $errors = ComposeStrings($errors, $this->name_inst->Errors->ToString());
        $errors = ComposeStrings($errors, $this->city->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End dat_aca Class @2-FCB6E20C

class clsdat_acaDataSource extends clsDBmadnes {  //dat_acaDataSource Class @2-30446636

//DataSource Variables @2-3F93F149
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $id_dat;
    public $level;
    public $date_start;
    public $date_end;
    public $career_esp;
    public $name_inst;
    public $city;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-423C76FB
    function clsdat_acaDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid dat_aca";
        $this->Initialize();
        $this->id_dat = new clsField("id_dat", ccsInteger, "");
        
        $this->level = new clsField("level", ccsText, "");
        
        $this->date_start = new clsField("date_start", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->date_end = new clsField("date_end", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->career_esp = new clsField("career_esp", ccsText, "");
        
        $this->name_inst = new clsField("name_inst", ccsText, "");
        
        $this->city = new clsField("city", ccsText, "");
        

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

//Prepare Method @2-74B144EB
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_func", ccsInteger, "", "", $this->Parameters["urlid_func"], XXXXX, false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_func", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-BFC31E51
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM dat_aca";
        $this->SQL = "SELECT id_dat, level, date_start, date_end, career_esp, name_inst, city \n\n" .
        "FROM dat_aca {SQL_Where} {SQL_OrderBy}";
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

//SetValues Method @2-E44DE010
    function SetValues()
    {
        $this->id_dat->SetDBValue(trim($this->f("id_dat")));
        $this->level->SetDBValue($this->f("level"));
        $this->date_start->SetDBValue(trim($this->f("date_start")));
        $this->date_end->SetDBValue(trim($this->f("date_end")));
        $this->career_esp->SetDBValue($this->f("career_esp"));
        $this->name_inst->SetDBValue($this->f("name_inst"));
        $this->city->SetDBValue($this->f("city"));
    }
//End SetValues Method

} //End dat_acaDataSource Class @2-FCB6E20C

class clsRecorddat_aca1 { //dat_aca1 Class @20-7AF47329

//Variables @20-9E315808

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

//Class_Initialize Event @20-31F0A629
    function clsRecorddat_aca1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record dat_aca1/Error";
        $this->DataSource = new clsdat_aca1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "dat_aca1";
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
            $this->id_func = new clsControl(ccsTextBox, "id_func", "Campo ID funcionario contactese con la unidad de RRHH", ccsInteger, "", CCGetRequestParam("id_func", $Method, NULL), $this);
            $this->id_func->Required = true;
            $this->level = new clsControl(ccsListBox, "level", "Nivel", ccsText, "", CCGetRequestParam("level", $Method, NULL), $this);
            $this->level->DSType = dsTable;
            $this->level->DataSource = new clsDBmadnes();
            $this->level->ds = & $this->level->DataSource;
            $this->level->DataSource->SQL = "SELECT * \n" .
"FROM nivel {SQL_Where} Order by orden";
            list($this->level->BoundColumn, $this->level->TextColumn, $this->level->DBFormat) = array("descrip_nivel", "descrip_nivel", "");
            $this->level->Required = true;
            $this->date_start = new clsControl(ccsTextBox, "date_start", "Fecha de Inicio", ccsDate, array("ShortDate"), CCGetRequestParam("date_start", $Method, NULL), $this);
            $this->date_start->Required = true;
            $this->date_end = new clsControl(ccsTextBox, "date_end", "Fecha Conclusión", ccsDate, array("ShortDate"), CCGetRequestParam("date_end", $Method, NULL), $this);
            $this->date_end->Required = true;
            $this->career_esp = new clsControl(ccsTextBox, "career_esp", "Carrera Especialización", ccsText, "", CCGetRequestParam("career_esp", $Method, NULL), $this);
            $this->career_esp->Required = true;
            $this->name_inst = new clsControl(ccsTextBox, "name_inst", "Nombre Institución", ccsText, "", CCGetRequestParam("name_inst", $Method, NULL), $this);
            $this->name_inst->Required = true;
            $this->city = new clsControl(ccsTextBox, "city", "Ciudad", ccsText, "", CCGetRequestParam("city", $Method, NULL), $this);
            $this->city->Required = true;
            $this->country = new clsControl(ccsTextBox, "country", "País", ccsText, "", CCGetRequestParam("country", $Method, NULL), $this);
            $this->country->Required = true;
            $this->acad_title = new clsControl(ccsRadioButton, "acad_title", "Título Academico", ccsInteger, "", CCGetRequestParam("acad_title", $Method, NULL), $this);
            $this->acad_title->DSType = dsListOfValues;
            $this->acad_title->Values = array(array("0", "NO"), array("1", "SI"));
            $this->acad_title->Required = true;
            $this->revala = new clsControl(ccsRadioButton, "revala", "Revala", ccsInteger, "", CCGetRequestParam("revala", $Method, NULL), $this);
            $this->revala->DSType = dsListOfValues;
            $this->revala->Values = array(array("0", "NO"), array("1", "SI"));
            $this->inst_revala = new clsControl(ccsTextBox, "inst_revala", "Inst Revala", ccsText, "", CCGetRequestParam("inst_revala", $Method, NULL), $this);
            $this->date_exp_a = new clsControl(ccsTextBox, "date_exp_a", "Date Exp A", ccsDate, array("ShortDate"), CCGetRequestParam("date_exp_a", $Method, NULL), $this);
            $this->num_tit_a = new clsControl(ccsTextBox, "num_tit_a", "Num Tit A", ccsText, "", CCGetRequestParam("num_tit_a", $Method, NULL), $this);
            $this->prov_nat_title = new clsControl(ccsRadioButton, "prov_nat_title", "Prov Nat Title", ccsInteger, "", CCGetRequestParam("prov_nat_title", $Method, NULL), $this);
            $this->prov_nat_title->DSType = dsListOfValues;
            $this->prov_nat_title->Values = array(array("0", "NO"), array("1", "SI"));
            $this->revalp = new clsControl(ccsRadioButton, "revalp", "Revalp", ccsInteger, "", CCGetRequestParam("revalp", $Method, NULL), $this);
            $this->revalp->DSType = dsListOfValues;
            $this->revalp->Values = array(array("0", "NO"), array("1", "SI"));
            $this->inst_revalp = new clsControl(ccsTextBox, "inst_revalp", "Inst Revalp", ccsText, "", CCGetRequestParam("inst_revalp", $Method, NULL), $this);
            $this->date_exp_p = new clsControl(ccsTextBox, "date_exp_p", "Date Exp P", ccsDate, array("ShortDate"), CCGetRequestParam("date_exp_p", $Method, NULL), $this);
            $this->num_tit_p = new clsControl(ccsTextBox, "num_tit_p", "Num Tit P", ccsText, "", CCGetRequestParam("num_tit_p", $Method, NULL), $this);
            $this->end = new clsControl(ccsRadioButton, "end", "Concluida", ccsText, "", CCGetRequestParam("end", $Method, NULL), $this);
            $this->end->DSType = dsListOfValues;
            $this->end->Values = array(array("0", "NO"), array("1", "SI"));
            $this->end->HTML = true;
            if(!$this->FormSubmitted) {
                if(!is_array($this->country->Value) && !strlen($this->country->Value) && $this->country->Value !== false)
                    $this->country->SetText(BOLIVIA);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @20-EE6474F0
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_dat"] = CCGetFromGet("id_dat", NULL);
    }
//End Initialize Method

//Validate Method @20-594C76B0
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->id_func->Validate() && $Validation);
        $Validation = ($this->level->Validate() && $Validation);
        $Validation = ($this->date_start->Validate() && $Validation);
        $Validation = ($this->date_end->Validate() && $Validation);
        $Validation = ($this->career_esp->Validate() && $Validation);
        $Validation = ($this->name_inst->Validate() && $Validation);
        $Validation = ($this->city->Validate() && $Validation);
        $Validation = ($this->country->Validate() && $Validation);
        $Validation = ($this->acad_title->Validate() && $Validation);
        $Validation = ($this->revala->Validate() && $Validation);
        $Validation = ($this->inst_revala->Validate() && $Validation);
        $Validation = ($this->date_exp_a->Validate() && $Validation);
        $Validation = ($this->num_tit_a->Validate() && $Validation);
        $Validation = ($this->prov_nat_title->Validate() && $Validation);
        $Validation = ($this->revalp->Validate() && $Validation);
        $Validation = ($this->inst_revalp->Validate() && $Validation);
        $Validation = ($this->date_exp_p->Validate() && $Validation);
        $Validation = ($this->num_tit_p->Validate() && $Validation);
        $Validation = ($this->end->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->id_func->Errors->Count() == 0);
        $Validation =  $Validation && ($this->level->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_start->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_end->Errors->Count() == 0);
        $Validation =  $Validation && ($this->career_esp->Errors->Count() == 0);
        $Validation =  $Validation && ($this->name_inst->Errors->Count() == 0);
        $Validation =  $Validation && ($this->city->Errors->Count() == 0);
        $Validation =  $Validation && ($this->country->Errors->Count() == 0);
        $Validation =  $Validation && ($this->acad_title->Errors->Count() == 0);
        $Validation =  $Validation && ($this->revala->Errors->Count() == 0);
        $Validation =  $Validation && ($this->inst_revala->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_exp_a->Errors->Count() == 0);
        $Validation =  $Validation && ($this->num_tit_a->Errors->Count() == 0);
        $Validation =  $Validation && ($this->prov_nat_title->Errors->Count() == 0);
        $Validation =  $Validation && ($this->revalp->Errors->Count() == 0);
        $Validation =  $Validation && ($this->inst_revalp->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_exp_p->Errors->Count() == 0);
        $Validation =  $Validation && ($this->num_tit_p->Errors->Count() == 0);
        $Validation =  $Validation && ($this->end->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @20-A355FDA7
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->id_func->Errors->Count());
        $errors = ($errors || $this->level->Errors->Count());
        $errors = ($errors || $this->date_start->Errors->Count());
        $errors = ($errors || $this->date_end->Errors->Count());
        $errors = ($errors || $this->career_esp->Errors->Count());
        $errors = ($errors || $this->name_inst->Errors->Count());
        $errors = ($errors || $this->city->Errors->Count());
        $errors = ($errors || $this->country->Errors->Count());
        $errors = ($errors || $this->acad_title->Errors->Count());
        $errors = ($errors || $this->revala->Errors->Count());
        $errors = ($errors || $this->inst_revala->Errors->Count());
        $errors = ($errors || $this->date_exp_a->Errors->Count());
        $errors = ($errors || $this->num_tit_a->Errors->Count());
        $errors = ($errors || $this->prov_nat_title->Errors->Count());
        $errors = ($errors || $this->revalp->Errors->Count());
        $errors = ($errors || $this->inst_revalp->Errors->Count());
        $errors = ($errors || $this->date_exp_p->Errors->Count());
        $errors = ($errors || $this->num_tit_p->Errors->Count());
        $errors = ($errors || $this->end->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @20-288F0419
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

//InsertRow Method @20-4A6D833E
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->level->SetValue($this->level->GetValue(true));
        $this->DataSource->date_start->SetValue($this->date_start->GetValue(true));
        $this->DataSource->date_end->SetValue($this->date_end->GetValue(true));
        $this->DataSource->career_esp->SetValue($this->career_esp->GetValue(true));
        $this->DataSource->name_inst->SetValue($this->name_inst->GetValue(true));
        $this->DataSource->city->SetValue($this->city->GetValue(true));
        $this->DataSource->country->SetValue($this->country->GetValue(true));
        $this->DataSource->acad_title->SetValue($this->acad_title->GetValue(true));
        $this->DataSource->revala->SetValue($this->revala->GetValue(true));
        $this->DataSource->inst_revala->SetValue($this->inst_revala->GetValue(true));
        $this->DataSource->date_exp_a->SetValue($this->date_exp_a->GetValue(true));
        $this->DataSource->num_tit_a->SetValue($this->num_tit_a->GetValue(true));
        $this->DataSource->prov_nat_title->SetValue($this->prov_nat_title->GetValue(true));
        $this->DataSource->revalp->SetValue($this->revalp->GetValue(true));
        $this->DataSource->inst_revalp->SetValue($this->inst_revalp->GetValue(true));
        $this->DataSource->date_exp_p->SetValue($this->date_exp_p->GetValue(true));
        $this->DataSource->num_tit_p->SetValue($this->num_tit_p->GetValue(true));
        $this->DataSource->end->SetValue($this->end->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @20-454E727F
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->level->SetValue($this->level->GetValue(true));
        $this->DataSource->date_start->SetValue($this->date_start->GetValue(true));
        $this->DataSource->date_end->SetValue($this->date_end->GetValue(true));
        $this->DataSource->career_esp->SetValue($this->career_esp->GetValue(true));
        $this->DataSource->name_inst->SetValue($this->name_inst->GetValue(true));
        $this->DataSource->city->SetValue($this->city->GetValue(true));
        $this->DataSource->country->SetValue($this->country->GetValue(true));
        $this->DataSource->acad_title->SetValue($this->acad_title->GetValue(true));
        $this->DataSource->revala->SetValue($this->revala->GetValue(true));
        $this->DataSource->inst_revala->SetValue($this->inst_revala->GetValue(true));
        $this->DataSource->date_exp_a->SetValue($this->date_exp_a->GetValue(true));
        $this->DataSource->num_tit_a->SetValue($this->num_tit_a->GetValue(true));
        $this->DataSource->prov_nat_title->SetValue($this->prov_nat_title->GetValue(true));
        $this->DataSource->revalp->SetValue($this->revalp->GetValue(true));
        $this->DataSource->inst_revalp->SetValue($this->inst_revalp->GetValue(true));
        $this->DataSource->date_exp_p->SetValue($this->date_exp_p->GetValue(true));
        $this->DataSource->num_tit_p->SetValue($this->num_tit_p->GetValue(true));
        $this->DataSource->end->SetValue($this->end->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @20-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @20-55EF5E02
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

        $this->level->Prepare();
        $this->acad_title->Prepare();
        $this->revala->Prepare();
        $this->prov_nat_title->Prepare();
        $this->revalp->Prepare();
        $this->end->Prepare();

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
                    $this->level->SetValue($this->DataSource->level->GetValue());
                    $this->date_start->SetValue($this->DataSource->date_start->GetValue());
                    $this->date_end->SetValue($this->DataSource->date_end->GetValue());
                    $this->career_esp->SetValue($this->DataSource->career_esp->GetValue());
                    $this->name_inst->SetValue($this->DataSource->name_inst->GetValue());
                    $this->city->SetValue($this->DataSource->city->GetValue());
                    $this->country->SetValue($this->DataSource->country->GetValue());
                    $this->acad_title->SetValue($this->DataSource->acad_title->GetValue());
                    $this->revala->SetValue($this->DataSource->revala->GetValue());
                    $this->inst_revala->SetValue($this->DataSource->inst_revala->GetValue());
                    $this->date_exp_a->SetValue($this->DataSource->date_exp_a->GetValue());
                    $this->num_tit_a->SetValue($this->DataSource->num_tit_a->GetValue());
                    $this->prov_nat_title->SetValue($this->DataSource->prov_nat_title->GetValue());
                    $this->revalp->SetValue($this->DataSource->revalp->GetValue());
                    $this->inst_revalp->SetValue($this->DataSource->inst_revalp->GetValue());
                    $this->date_exp_p->SetValue($this->DataSource->date_exp_p->GetValue());
                    $this->num_tit_p->SetValue($this->DataSource->num_tit_p->GetValue());
                    $this->end->SetValue($this->DataSource->end->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->id_func->Errors->ToString());
            $Error = ComposeStrings($Error, $this->level->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_start->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_end->Errors->ToString());
            $Error = ComposeStrings($Error, $this->career_esp->Errors->ToString());
            $Error = ComposeStrings($Error, $this->name_inst->Errors->ToString());
            $Error = ComposeStrings($Error, $this->city->Errors->ToString());
            $Error = ComposeStrings($Error, $this->country->Errors->ToString());
            $Error = ComposeStrings($Error, $this->acad_title->Errors->ToString());
            $Error = ComposeStrings($Error, $this->revala->Errors->ToString());
            $Error = ComposeStrings($Error, $this->inst_revala->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_exp_a->Errors->ToString());
            $Error = ComposeStrings($Error, $this->num_tit_a->Errors->ToString());
            $Error = ComposeStrings($Error, $this->prov_nat_title->Errors->ToString());
            $Error = ComposeStrings($Error, $this->revalp->Errors->ToString());
            $Error = ComposeStrings($Error, $this->inst_revalp->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_exp_p->Errors->ToString());
            $Error = ComposeStrings($Error, $this->num_tit_p->Errors->ToString());
            $Error = ComposeStrings($Error, $this->end->Errors->ToString());
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
        $this->level->Show();
        $this->date_start->Show();
        $this->date_end->Show();
        $this->career_esp->Show();
        $this->name_inst->Show();
        $this->city->Show();
        $this->country->Show();
        $this->acad_title->Show();
        $this->revala->Show();
        $this->inst_revala->Show();
        $this->date_exp_a->Show();
        $this->num_tit_a->Show();
        $this->prov_nat_title->Show();
        $this->revalp->Show();
        $this->inst_revalp->Show();
        $this->date_exp_p->Show();
        $this->num_tit_p->Show();
        $this->end->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End dat_aca1 Class @20-FCB6E20C

class clsdat_aca1DataSource extends clsDBmadnes {  //dat_aca1DataSource Class @20-1A9C2BF6

//DataSource Variables @20-53FC6FF9
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
    public $level;
    public $date_start;
    public $date_end;
    public $career_esp;
    public $name_inst;
    public $city;
    public $country;
    public $acad_title;
    public $revala;
    public $inst_revala;
    public $date_exp_a;
    public $num_tit_a;
    public $prov_nat_title;
    public $revalp;
    public $inst_revalp;
    public $date_exp_p;
    public $num_tit_p;
    public $end;
//End DataSource Variables

//DataSourceClass_Initialize Event @20-23EE5A10
    function clsdat_aca1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record dat_aca1/Error";
        $this->Initialize();
        $this->id_func = new clsField("id_func", ccsInteger, "");
        
        $this->level = new clsField("level", ccsText, "");
        
        $this->date_start = new clsField("date_start", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->date_end = new clsField("date_end", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->career_esp = new clsField("career_esp", ccsText, "");
        
        $this->name_inst = new clsField("name_inst", ccsText, "");
        
        $this->city = new clsField("city", ccsText, "");
        
        $this->country = new clsField("country", ccsText, "");
        
        $this->acad_title = new clsField("acad_title", ccsInteger, "");
        
        $this->revala = new clsField("revala", ccsInteger, "");
        
        $this->inst_revala = new clsField("inst_revala", ccsText, "");
        
        $this->date_exp_a = new clsField("date_exp_a", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->num_tit_a = new clsField("num_tit_a", ccsText, "");
        
        $this->prov_nat_title = new clsField("prov_nat_title", ccsInteger, "");
        
        $this->revalp = new clsField("revalp", ccsInteger, "");
        
        $this->inst_revalp = new clsField("inst_revalp", ccsText, "");
        
        $this->date_exp_p = new clsField("date_exp_p", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->num_tit_p = new clsField("num_tit_p", ccsText, "");
        
        $this->end = new clsField("end", ccsText, "");
        

        $this->InsertFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["level"] = array("Name" => "level", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["date_start"] = array("Name" => "date_start", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["date_end"] = array("Name" => "date_end", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["career_esp"] = array("Name" => "career_esp", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["name_inst"] = array("Name" => "name_inst", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["city"] = array("Name" => "city", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["country"] = array("Name" => "country", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["acad_title"] = array("Name" => "acad_title", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["revala"] = array("Name" => "revala", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["inst_revala"] = array("Name" => "inst_revala", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["date_exp_a"] = array("Name" => "date_exp_a", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["num_tit_a"] = array("Name" => "num_tit_a", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["prov_nat_title"] = array("Name" => "prov_nat_title", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["revalp"] = array("Name" => "revalp", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["inst_revalp"] = array("Name" => "inst_revalp", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["date_exp_p"] = array("Name" => "date_exp_p", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["num_tit_p"] = array("Name" => "num_tit_p", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["end"] = array("Name" => "end", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["level"] = array("Name" => "level", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_start"] = array("Name" => "date_start", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_end"] = array("Name" => "date_end", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["career_esp"] = array("Name" => "career_esp", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["name_inst"] = array("Name" => "name_inst", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["city"] = array("Name" => "city", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["country"] = array("Name" => "country", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["acad_title"] = array("Name" => "acad_title", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["revala"] = array("Name" => "revala", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["inst_revala"] = array("Name" => "inst_revala", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_exp_a"] = array("Name" => "date_exp_a", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["num_tit_a"] = array("Name" => "num_tit_a", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["prov_nat_title"] = array("Name" => "prov_nat_title", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["revalp"] = array("Name" => "revalp", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["inst_revalp"] = array("Name" => "inst_revalp", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_exp_p"] = array("Name" => "date_exp_p", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["num_tit_p"] = array("Name" => "num_tit_p", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["end"] = array("Name" => "end", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @20-787D5F09
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_dat", ccsInteger, "", "", $this->Parameters["urlid_dat"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_dat", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @20-C52076DC
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM dat_aca {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @20-8FC7EBFB
    function SetValues()
    {
        $this->id_func->SetDBValue(trim($this->f("id_func")));
        $this->level->SetDBValue($this->f("level"));
        $this->date_start->SetDBValue(trim($this->f("date_start")));
        $this->date_end->SetDBValue(trim($this->f("date_end")));
        $this->career_esp->SetDBValue($this->f("career_esp"));
        $this->name_inst->SetDBValue($this->f("name_inst"));
        $this->city->SetDBValue($this->f("city"));
        $this->country->SetDBValue($this->f("country"));
        $this->acad_title->SetDBValue(trim($this->f("acad_title")));
        $this->revala->SetDBValue(trim($this->f("revala")));
        $this->inst_revala->SetDBValue($this->f("inst_revala"));
        $this->date_exp_a->SetDBValue(trim($this->f("date_exp_a")));
        $this->num_tit_a->SetDBValue($this->f("num_tit_a"));
        $this->prov_nat_title->SetDBValue(trim($this->f("prov_nat_title")));
        $this->revalp->SetDBValue(trim($this->f("revalp")));
        $this->inst_revalp->SetDBValue($this->f("inst_revalp"));
        $this->date_exp_p->SetDBValue(trim($this->f("date_exp_p")));
        $this->num_tit_p->SetDBValue($this->f("num_tit_p"));
        $this->end->SetDBValue($this->f("end"));
    }
//End SetValues Method

//Insert Method @20-EA1FF966
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->InsertFields["level"]["Value"] = $this->level->GetDBValue(true);
        $this->InsertFields["date_start"]["Value"] = $this->date_start->GetDBValue(true);
        $this->InsertFields["date_end"]["Value"] = $this->date_end->GetDBValue(true);
        $this->InsertFields["career_esp"]["Value"] = $this->career_esp->GetDBValue(true);
        $this->InsertFields["name_inst"]["Value"] = $this->name_inst->GetDBValue(true);
        $this->InsertFields["city"]["Value"] = $this->city->GetDBValue(true);
        $this->InsertFields["country"]["Value"] = $this->country->GetDBValue(true);
        $this->InsertFields["acad_title"]["Value"] = $this->acad_title->GetDBValue(true);
        $this->InsertFields["revala"]["Value"] = $this->revala->GetDBValue(true);
        $this->InsertFields["inst_revala"]["Value"] = $this->inst_revala->GetDBValue(true);
        $this->InsertFields["date_exp_a"]["Value"] = $this->date_exp_a->GetDBValue(true);
        $this->InsertFields["num_tit_a"]["Value"] = $this->num_tit_a->GetDBValue(true);
        $this->InsertFields["prov_nat_title"]["Value"] = $this->prov_nat_title->GetDBValue(true);
        $this->InsertFields["revalp"]["Value"] = $this->revalp->GetDBValue(true);
        $this->InsertFields["inst_revalp"]["Value"] = $this->inst_revalp->GetDBValue(true);
        $this->InsertFields["date_exp_p"]["Value"] = $this->date_exp_p->GetDBValue(true);
        $this->InsertFields["num_tit_p"]["Value"] = $this->num_tit_p->GetDBValue(true);
        $this->InsertFields["end"]["Value"] = $this->end->GetDBValue(true);
        $this->SQL = CCBuildInsert("dat_aca", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @20-790EFEE2
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->UpdateFields["level"]["Value"] = $this->level->GetDBValue(true);
        $this->UpdateFields["date_start"]["Value"] = $this->date_start->GetDBValue(true);
        $this->UpdateFields["date_end"]["Value"] = $this->date_end->GetDBValue(true);
        $this->UpdateFields["career_esp"]["Value"] = $this->career_esp->GetDBValue(true);
        $this->UpdateFields["name_inst"]["Value"] = $this->name_inst->GetDBValue(true);
        $this->UpdateFields["city"]["Value"] = $this->city->GetDBValue(true);
        $this->UpdateFields["country"]["Value"] = $this->country->GetDBValue(true);
        $this->UpdateFields["acad_title"]["Value"] = $this->acad_title->GetDBValue(true);
        $this->UpdateFields["revala"]["Value"] = $this->revala->GetDBValue(true);
        $this->UpdateFields["inst_revala"]["Value"] = $this->inst_revala->GetDBValue(true);
        $this->UpdateFields["date_exp_a"]["Value"] = $this->date_exp_a->GetDBValue(true);
        $this->UpdateFields["num_tit_a"]["Value"] = $this->num_tit_a->GetDBValue(true);
        $this->UpdateFields["prov_nat_title"]["Value"] = $this->prov_nat_title->GetDBValue(true);
        $this->UpdateFields["revalp"]["Value"] = $this->revalp->GetDBValue(true);
        $this->UpdateFields["inst_revalp"]["Value"] = $this->inst_revalp->GetDBValue(true);
        $this->UpdateFields["date_exp_p"]["Value"] = $this->date_exp_p->GetDBValue(true);
        $this->UpdateFields["num_tit_p"]["Value"] = $this->num_tit_p->GetDBValue(true);
        $this->UpdateFields["end"]["Value"] = $this->end->GetDBValue(true);
        $this->SQL = CCBuildUpdate("dat_aca", $this->UpdateFields, $this);
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

//Delete Method @20-9FAE0571
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM dat_aca";
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

} //End dat_aca1DataSource Class @20-FCB6E20C

//Initialize Page @1-882F5D3A
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
$TemplateFileName = "Reg_dat_acr.html";
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

//Initialize Objects @1-79D68341
$DBmadnes = new clsDBmadnes();
$MainPage->Connections["madnes"] = & $DBmadnes;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$dat_aca = new clsGriddat_aca("", $MainPage);
$dat_aca1 = new clsRecorddat_aca1("", $MainPage);
$MainPage->dat_aca = & $dat_aca;
$MainPage->dat_aca1 = & $dat_aca1;
$dat_aca->Initialize();
$dat_aca1->Initialize();
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

//Execute Components @1-3EA919D8
$dat_aca1->Operation();
//End Execute Components

//Go to destination page @1-884F84CA
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmadnes->close();
    header("Location: " . $Redirect);
    unset($dat_aca);
    unset($dat_aca1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-60B0F3DA
$dat_aca->Show();
$dat_aca1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-D40007B9
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmadnes->close();
unset($dat_aca);
unset($dat_aca1);
unset($Tpl);
//End Unload Page


?>
