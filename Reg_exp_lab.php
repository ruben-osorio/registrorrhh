<?php
//Include Common Files @1-9E0BB8DC
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "Reg_exp_lab.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridexp_lab { //exp_lab class @2-AFAD0652

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

//Class_Initialize Event @2-5A9B90D3
    function clsGridexp_lab($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "exp_lab";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid exp_lab";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsexp_labDataSource($this);
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

        $this->id_exp_lab = new clsControl(ccsLink, "id_exp_lab", "id_exp_lab", ccsInteger, "", CCGetRequestParam("id_exp_lab", ccsGet, NULL), $this);
        $this->id_exp_lab->Page = "";
        $this->id_func = new clsControl(ccsLabel, "id_func", "id_func", ccsInteger, "", CCGetRequestParam("id_func", ccsGet, NULL), $this);
        $this->name_inst = new clsControl(ccsLabel, "name_inst", "name_inst", ccsText, "", CCGetRequestParam("name_inst", ccsGet, NULL), $this);
        $this->type_inst = new clsControl(ccsLabel, "type_inst", "type_inst", ccsText, "", CCGetRequestParam("type_inst", ccsGet, NULL), $this);
        $this->form_ent = new clsControl(ccsLabel, "form_ent", "form_ent", ccsText, "", CCGetRequestParam("form_ent", ccsGet, NULL), $this);
        $this->charge = new clsControl(ccsLabel, "charge", "charge", ccsText, "", CCGetRequestParam("charge", ccsGet, NULL), $this);
        $this->date_start = new clsControl(ccsLabel, "date_start", "date_start", ccsDate, array("ShortDate"), CCGetRequestParam("date_start", ccsGet, NULL), $this);
        $this->date_end = new clsControl(ccsLabel, "date_end", "date_end", ccsDate, array("ShortDate"), CCGetRequestParam("date_end", ccsGet, NULL), $this);
        $this->exp_lab_Insert = new clsControl(ccsLink, "exp_lab_Insert", "exp_lab_Insert", ccsText, "", CCGetRequestParam("exp_lab_Insert", ccsGet, NULL), $this);
        $this->exp_lab_Insert->Parameters = CCGetQueryString("QueryString", array("id_exp_lab", "ccsForm"));
        $this->exp_lab_Insert->Page = "Reg_exp_lab.php";
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

//Show Method @2-BCE0B76B
    function Show()
    {
        $Tpl = & CCGetTemplate($this);
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
            $this->ControlsVisible["id_exp_lab"] = $this->id_exp_lab->Visible;
            $this->ControlsVisible["id_func"] = $this->id_func->Visible;
            $this->ControlsVisible["name_inst"] = $this->name_inst->Visible;
            $this->ControlsVisible["type_inst"] = $this->type_inst->Visible;
            $this->ControlsVisible["form_ent"] = $this->form_ent->Visible;
            $this->ControlsVisible["charge"] = $this->charge->Visible;
            $this->ControlsVisible["date_start"] = $this->date_start->Visible;
            $this->ControlsVisible["date_end"] = $this->date_end->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->id_exp_lab->SetValue($this->DataSource->id_exp_lab->GetValue());
                $this->id_exp_lab->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->id_exp_lab->Parameters = CCAddParam($this->id_exp_lab->Parameters, "id_exp_lab", $this->DataSource->f("id_exp_lab"));
                $this->id_func->SetValue($this->DataSource->id_func->GetValue());
                $this->name_inst->SetValue($this->DataSource->name_inst->GetValue());
                $this->type_inst->SetValue($this->DataSource->type_inst->GetValue());
                $this->form_ent->SetValue($this->DataSource->form_ent->GetValue());
                $this->charge->SetValue($this->DataSource->charge->GetValue());
                $this->date_start->SetValue($this->DataSource->date_start->GetValue());
                $this->date_end->SetValue($this->DataSource->date_end->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->id_exp_lab->Show();
                $this->id_func->Show();
                $this->name_inst->Show();
                $this->type_inst->Show();
                $this->form_ent->Show();
                $this->charge->Show();
                $this->date_start->Show();
                $this->date_end->Show();
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
        $this->exp_lab_Insert->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @2-BB165EC9
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->id_exp_lab->Errors->ToString());
        $errors = ComposeStrings($errors, $this->id_func->Errors->ToString());
        $errors = ComposeStrings($errors, $this->name_inst->Errors->ToString());
        $errors = ComposeStrings($errors, $this->type_inst->Errors->ToString());
        $errors = ComposeStrings($errors, $this->form_ent->Errors->ToString());
        $errors = ComposeStrings($errors, $this->charge->Errors->ToString());
        $errors = ComposeStrings($errors, $this->date_start->Errors->ToString());
        $errors = ComposeStrings($errors, $this->date_end->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End exp_lab Class @2-FCB6E20C

class clsexp_labDataSource extends clsDBmadnes {  //exp_labDataSource Class @2-4736DB93

//DataSource Variables @2-2BCB619A
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $id_exp_lab;
    public $id_func;
    public $name_inst;
    public $type_inst;
    public $form_ent;
    public $charge;
    public $date_start;
    public $date_end;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-51B03016
    function clsexp_labDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid exp_lab";
        $this->Initialize();
        $this->id_exp_lab = new clsField("id_exp_lab", ccsInteger, "");
        
        $this->id_func = new clsField("id_func", ccsInteger, "");
        
        $this->name_inst = new clsField("name_inst", ccsText, "");
        
        $this->type_inst = new clsField("type_inst", ccsText, "");
        
        $this->form_ent = new clsField("form_ent", ccsText, "");
        
        $this->charge = new clsField("charge", ccsText, "");
        
        $this->date_start = new clsField("date_start", ccsDate, array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn", ":", "ss"));
        
        $this->date_end = new clsField("date_end", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        

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

//Prepare Method @2-DDC85469
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_func", ccsInteger, "", "", $this->Parameters["urlid_func"], XXXXXX, false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_func", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-6FBA9012
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM exp_lab";
        $this->SQL = "SELECT id_exp_lab, id_func, name_inst, type_inst, form_ent, charge, date_start, date_end \n\n" .
        "FROM exp_lab {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-5E9CEF52
    function SetValues()
    {
        $this->id_exp_lab->SetDBValue(trim($this->f("id_exp_lab")));
        $this->id_func->SetDBValue(trim($this->f("id_func")));
        $this->name_inst->SetDBValue($this->f("name_inst"));
        $this->type_inst->SetDBValue($this->f("type_inst"));
        $this->form_ent->SetDBValue($this->f("form_ent"));
        $this->charge->SetDBValue($this->f("charge"));
        $this->date_start->SetDBValue(trim($this->f("date_start")));
        $this->date_end->SetDBValue(trim($this->f("date_end")));
    }
//End SetValues Method

} //End exp_labDataSource Class @2-FCB6E20C

class clsRecordexp_lab1 { //exp_lab1 Class @23-AAEBDB1A

//Variables @23-9E315808

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

//Class_Initialize Event @23-65CF1F51
    function clsRecordexp_lab1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record exp_lab1/Error";
        $this->DataSource = new clsexp_lab1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "exp_lab1";
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
            $this->name_inst = new clsControl(ccsTextBox, "name_inst", "Name Inst", ccsText, "", CCGetRequestParam("name_inst", $Method, NULL), $this);
            $this->type_inst = new clsControl(ccsRadioButton, "type_inst", "Type Inst", ccsText, "", CCGetRequestParam("type_inst", $Method, NULL), $this);
            $this->type_inst->DSType = dsListOfValues;
            $this->type_inst->Values = array(array("PRIVADA", "PRIVADA"), array("PUBLICA", "PUBLICA"));
            $this->form_ent = new clsControl(ccsTextBox, "form_ent", "Form Ent", ccsText, "", CCGetRequestParam("form_ent", $Method, NULL), $this);
            $this->date_ent = new clsControl(ccsTextBox, "date_ent", "Date Ent", ccsDate, array("ShortDate"), CCGetRequestParam("date_ent", $Method, NULL), $this);
            $this->place_lab = new clsControl(ccsTextBox, "place_lab", "Place Lab", ccsText, "", CCGetRequestParam("place_lab", $Method, NULL), $this);
            $this->charge = new clsControl(ccsTextBox, "charge", "Charge", ccsText, "", CCGetRequestParam("charge", $Method, NULL), $this);
            $this->rea_cha = new clsControl(ccsTextBox, "rea_cha", "Rea Cha", ccsText, "", CCGetRequestParam("rea_cha", $Method, NULL), $this);
            $this->date_start = new clsControl(ccsTextBox, "date_start", "Date Start", ccsDate, array("ShortDate"), CCGetRequestParam("date_start", $Method, NULL), $this);
            $this->date_end = new clsControl(ccsTextBox, "date_end", "Date End", ccsDate, array("ShortDate"), CCGetRequestParam("date_end", $Method, NULL), $this);
            $this->date_ret = new clsControl(ccsTextBox, "date_ret", "Date Ret", ccsDate, array("ShortDate"), CCGetRequestParam("date_ret", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @23-31A78387
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_exp_lab"] = CCGetFromGet("id_exp_lab", NULL);
    }
//End Initialize Method

//Validate Method @23-90651C2C
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->id_func->Validate() && $Validation);
        $Validation = ($this->name_inst->Validate() && $Validation);
        $Validation = ($this->type_inst->Validate() && $Validation);
        $Validation = ($this->form_ent->Validate() && $Validation);
        $Validation = ($this->date_ent->Validate() && $Validation);
        $Validation = ($this->place_lab->Validate() && $Validation);
        $Validation = ($this->charge->Validate() && $Validation);
        $Validation = ($this->rea_cha->Validate() && $Validation);
        $Validation = ($this->date_start->Validate() && $Validation);
        $Validation = ($this->date_end->Validate() && $Validation);
        $Validation = ($this->date_ret->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->id_func->Errors->Count() == 0);
        $Validation =  $Validation && ($this->name_inst->Errors->Count() == 0);
        $Validation =  $Validation && ($this->type_inst->Errors->Count() == 0);
        $Validation =  $Validation && ($this->form_ent->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_ent->Errors->Count() == 0);
        $Validation =  $Validation && ($this->place_lab->Errors->Count() == 0);
        $Validation =  $Validation && ($this->charge->Errors->Count() == 0);
        $Validation =  $Validation && ($this->rea_cha->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_start->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_end->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_ret->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @23-9B95A770
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->id_func->Errors->Count());
        $errors = ($errors || $this->name_inst->Errors->Count());
        $errors = ($errors || $this->type_inst->Errors->Count());
        $errors = ($errors || $this->form_ent->Errors->Count());
        $errors = ($errors || $this->date_ent->Errors->Count());
        $errors = ($errors || $this->place_lab->Errors->Count());
        $errors = ($errors || $this->charge->Errors->Count());
        $errors = ($errors || $this->rea_cha->Errors->Count());
        $errors = ($errors || $this->date_start->Errors->Count());
        $errors = ($errors || $this->date_end->Errors->Count());
        $errors = ($errors || $this->date_ret->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @23-288F0419
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

//InsertRow Method @23-114A21DE
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->name_inst->SetValue($this->name_inst->GetValue(true));
        $this->DataSource->type_inst->SetValue($this->type_inst->GetValue(true));
        $this->DataSource->form_ent->SetValue($this->form_ent->GetValue(true));
        $this->DataSource->date_ent->SetValue($this->date_ent->GetValue(true));
        $this->DataSource->place_lab->SetValue($this->place_lab->GetValue(true));
        $this->DataSource->charge->SetValue($this->charge->GetValue(true));
        $this->DataSource->rea_cha->SetValue($this->rea_cha->GetValue(true));
        $this->DataSource->date_start->SetValue($this->date_start->GetValue(true));
        $this->DataSource->date_end->SetValue($this->date_end->GetValue(true));
        $this->DataSource->date_ret->SetValue($this->date_ret->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @23-36A90405
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->name_inst->SetValue($this->name_inst->GetValue(true));
        $this->DataSource->type_inst->SetValue($this->type_inst->GetValue(true));
        $this->DataSource->form_ent->SetValue($this->form_ent->GetValue(true));
        $this->DataSource->date_ent->SetValue($this->date_ent->GetValue(true));
        $this->DataSource->place_lab->SetValue($this->place_lab->GetValue(true));
        $this->DataSource->charge->SetValue($this->charge->GetValue(true));
        $this->DataSource->rea_cha->SetValue($this->rea_cha->GetValue(true));
        $this->DataSource->date_start->SetValue($this->date_start->GetValue(true));
        $this->DataSource->date_end->SetValue($this->date_end->GetValue(true));
        $this->DataSource->date_ret->SetValue($this->date_ret->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @23-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @23-C79BF692
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

        $this->type_inst->Prepare();

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
                    $this->name_inst->SetValue($this->DataSource->name_inst->GetValue());
                    $this->type_inst->SetValue($this->DataSource->type_inst->GetValue());
                    $this->form_ent->SetValue($this->DataSource->form_ent->GetValue());
                    $this->date_ent->SetValue($this->DataSource->date_ent->GetValue());
                    $this->place_lab->SetValue($this->DataSource->place_lab->GetValue());
                    $this->charge->SetValue($this->DataSource->charge->GetValue());
                    $this->rea_cha->SetValue($this->DataSource->rea_cha->GetValue());
                    $this->date_start->SetValue($this->DataSource->date_start->GetValue());
                    $this->date_end->SetValue($this->DataSource->date_end->GetValue());
                    $this->date_ret->SetValue($this->DataSource->date_ret->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->id_func->Errors->ToString());
            $Error = ComposeStrings($Error, $this->name_inst->Errors->ToString());
            $Error = ComposeStrings($Error, $this->type_inst->Errors->ToString());
            $Error = ComposeStrings($Error, $this->form_ent->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_ent->Errors->ToString());
            $Error = ComposeStrings($Error, $this->place_lab->Errors->ToString());
            $Error = ComposeStrings($Error, $this->charge->Errors->ToString());
            $Error = ComposeStrings($Error, $this->rea_cha->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_start->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_end->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_ret->Errors->ToString());
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
        $this->name_inst->Show();
        $this->type_inst->Show();
        $this->form_ent->Show();
        $this->date_ent->Show();
        $this->place_lab->Show();
        $this->charge->Show();
        $this->rea_cha->Show();
        $this->date_start->Show();
        $this->date_end->Show();
        $this->date_ret->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End exp_lab1 Class @23-FCB6E20C

class clsexp_lab1DataSource extends clsDBmadnes {  //exp_lab1DataSource Class @23-BC570E2C

//DataSource Variables @23-52A82CD5
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
    public $name_inst;
    public $type_inst;
    public $form_ent;
    public $date_ent;
    public $place_lab;
    public $charge;
    public $rea_cha;
    public $date_start;
    public $date_end;
    public $date_ret;
//End DataSource Variables

//DataSourceClass_Initialize Event @23-B2F31F6B
    function clsexp_lab1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record exp_lab1/Error";
        $this->Initialize();
        $this->id_func = new clsField("id_func", ccsInteger, "");
        
        $this->name_inst = new clsField("name_inst", ccsText, "");
        
        $this->type_inst = new clsField("type_inst", ccsText, "");
        
        $this->form_ent = new clsField("form_ent", ccsText, "");
        
        $this->date_ent = new clsField("date_ent", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->place_lab = new clsField("place_lab", ccsText, "");
        
        $this->charge = new clsField("charge", ccsText, "");
        
        $this->rea_cha = new clsField("rea_cha", ccsText, "");
        
        $this->date_start = new clsField("date_start", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->date_end = new clsField("date_end", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->date_ret = new clsField("date_ret", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        

        $this->InsertFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["name_inst"] = array("Name" => "name_inst", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["type_inst"] = array("Name" => "type_inst", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["form_ent"] = array("Name" => "form_ent", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["date_ent"] = array("Name" => "date_ent", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["place_lab"] = array("Name" => "place_lab", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["charge"] = array("Name" => "charge", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["rea_cha"] = array("Name" => "rea_cha", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["date_start"] = array("Name" => "date_start", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["date_end"] = array("Name" => "date_end", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["date_ret"] = array("Name" => "date_ret", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["name_inst"] = array("Name" => "name_inst", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["type_inst"] = array("Name" => "type_inst", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["form_ent"] = array("Name" => "form_ent", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_ent"] = array("Name" => "date_ent", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["place_lab"] = array("Name" => "place_lab", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["charge"] = array("Name" => "charge", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["rea_cha"] = array("Name" => "rea_cha", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_start"] = array("Name" => "date_start", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_end"] = array("Name" => "date_end", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_ret"] = array("Name" => "date_ret", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @23-226DD6CB
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_exp_lab", ccsInteger, "", "", $this->Parameters["urlid_exp_lab"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_exp_lab", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @23-A0C4A326
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM exp_lab {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @23-0387214B
    function SetValues()
    {
        $this->id_func->SetDBValue(trim($this->f("id_func")));
        $this->name_inst->SetDBValue($this->f("name_inst"));
        $this->type_inst->SetDBValue($this->f("type_inst"));
        $this->form_ent->SetDBValue($this->f("form_ent"));
        $this->date_ent->SetDBValue(trim($this->f("date_ent")));
        $this->place_lab->SetDBValue($this->f("place_lab"));
        $this->charge->SetDBValue($this->f("charge"));
        $this->rea_cha->SetDBValue($this->f("rea_cha"));
        $this->date_start->SetDBValue(trim($this->f("date_start")));
        $this->date_end->SetDBValue(trim($this->f("date_end")));
        $this->date_ret->SetDBValue(trim($this->f("date_ret")));
    }
//End SetValues Method

//Insert Method @23-CDCF45EE
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->InsertFields["name_inst"]["Value"] = $this->name_inst->GetDBValue(true);
        $this->InsertFields["type_inst"]["Value"] = $this->type_inst->GetDBValue(true);
        $this->InsertFields["form_ent"]["Value"] = $this->form_ent->GetDBValue(true);
        $this->InsertFields["date_ent"]["Value"] = $this->date_ent->GetDBValue(true);
        $this->InsertFields["place_lab"]["Value"] = $this->place_lab->GetDBValue(true);
        $this->InsertFields["charge"]["Value"] = $this->charge->GetDBValue(true);
        $this->InsertFields["rea_cha"]["Value"] = $this->rea_cha->GetDBValue(true);
        $this->InsertFields["date_start"]["Value"] = $this->date_start->GetDBValue(true);
        $this->InsertFields["date_end"]["Value"] = $this->date_end->GetDBValue(true);
        $this->InsertFields["date_ret"]["Value"] = $this->date_ret->GetDBValue(true);
        $this->SQL = CCBuildInsert("exp_lab", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @23-2490D7CE
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->UpdateFields["name_inst"]["Value"] = $this->name_inst->GetDBValue(true);
        $this->UpdateFields["type_inst"]["Value"] = $this->type_inst->GetDBValue(true);
        $this->UpdateFields["form_ent"]["Value"] = $this->form_ent->GetDBValue(true);
        $this->UpdateFields["date_ent"]["Value"] = $this->date_ent->GetDBValue(true);
        $this->UpdateFields["place_lab"]["Value"] = $this->place_lab->GetDBValue(true);
        $this->UpdateFields["charge"]["Value"] = $this->charge->GetDBValue(true);
        $this->UpdateFields["rea_cha"]["Value"] = $this->rea_cha->GetDBValue(true);
        $this->UpdateFields["date_start"]["Value"] = $this->date_start->GetDBValue(true);
        $this->UpdateFields["date_end"]["Value"] = $this->date_end->GetDBValue(true);
        $this->UpdateFields["date_ret"]["Value"] = $this->date_ret->GetDBValue(true);
        $this->SQL = CCBuildUpdate("exp_lab", $this->UpdateFields, $this);
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

//Delete Method @23-990D64DA
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM exp_lab";
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

} //End exp_lab1DataSource Class @23-FCB6E20C

//Initialize Page @1-EF9CB7F7
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
$TemplateFileName = "Reg_exp_labr.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-A5B50ED6
$DBmadnes = new clsDBmadnes();
$MainPage->Connections["madnes"] = & $DBmadnes;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$exp_lab = new clsGridexp_lab("", $MainPage);
$exp_lab1 = new clsRecordexp_lab1("", $MainPage);
$MainPage->exp_lab = & $exp_lab;
$MainPage->exp_lab1 = & $exp_lab1;
$exp_lab->Initialize();
$exp_lab1->Initialize();

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

//Execute Components @1-98FFE59B
$exp_lab1->Operation();
//End Execute Components

//Go to destination page @1-11C36765
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmadnes->close();
    header("Location: " . $Redirect);
    unset($exp_lab);
    unset($exp_lab1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-24EAE328
$exp_lab->Show();
$exp_lab1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);

if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($HSAOA4A7J7D7A,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($HSAOA4A7J7D7A,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($HSAOA4A7J7D7A,"");
}
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-14F60B15
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmadnes->close();
unset($exp_lab);
unset($exp_lab1);
unset($Tpl);
//End Unload Page


?>
