<?php
//Include Common Files @1-01907A99
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "Reg_dat_fam.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsEditableGriddat_fam { //dat_fam Class @2-555AA2C1

//Variables @2-0AADA924

    // Public variables
    public $ComponentType = "EditableGrid";
    public $ComponentName;
    public $HTMLFormAction;
    public $PressedButton;
    public $Errors;
    public $ErrorBlock;
    public $FormSubmitted;
    public $FormParameters;
    public $FormState;
    public $FormEnctype;
    public $CachedColumns;
    public $TotalRows;
    public $UpdatedRows;
    public $EmptyRows;
    public $Visible;
    public $RowsErrors;
    public $ds;
    public $DataSource;
    public $PageSize;
    public $IsEmpty;
    public $SorterName = "";
    public $SorterDirection = "";
    public $PageNumber;
    public $ControlsVisible = array();

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";

    public $InsertAllowed = false;
    public $UpdateAllowed = false;
    public $DeleteAllowed = false;
    public $ReadAllowed   = false;
    public $EditMode;
    public $ValidatingControls;
    public $Controls;
    public $ControlsErrors;
    public $RowNumber;
    public $Attributes;

    // Class variables
//End Variables

//Class_Initialize Event @2-137BFC33
    function clsEditableGriddat_fam($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid dat_fam/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "dat_fam";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["id_datf"][0] = "id_datf";
        $this->DataSource = new clsdat_famDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 100;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: EditableGrid " . $this->ComponentName . "<BR>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->EmptyRows = 30;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if(!$this->Visible) return;

        $CCSForm = CCGetFromGet("ccsForm", "");
        $this->FormEnctype = "application/x-www-form-urlencoded";
        $this->FormSubmitted = ($CCSForm == $this->ComponentName);
        if($this->FormSubmitted) {
            $this->FormState = CCGetFromPost("FormState", "");
            $this->SetFormState($this->FormState);
        } else {
            $this->FormState = "";
        }
        $Method = $this->FormSubmitted ? ccsPost : ccsGet;

        $this->id_func = new clsControl(ccsTextBox, "id_func", "Id Func", ccsInteger, "", NULL, $this);
        $this->id_func->Required = true;
        $this->type_p = new clsControl(ccsListBox, "type_p", "Type P", ccsText, "", NULL, $this);
        $this->type_p->DSType = dsTable;
        $this->type_p->DataSource = new clsDBmadnes();
        $this->type_p->ds = & $this->type_p->DataSource;
        $this->type_p->DataSource->SQL = "SELECT * \n" .
"FROM tipo_parentesco {SQL_Where} {SQL_OrderBy}";
        list($this->type_p->BoundColumn, $this->type_p->TextColumn, $this->type_p->DBFormat) = array("descrip", "descrip", "");
        $this->name = new clsControl(ccsTextBox, "name", "Name", ccsText, "", NULL, $this);
        $this->l_name1 = new clsControl(ccsTextBox, "l_name1", "L Name1", ccsText, "", NULL, $this);
        $this->l_name2 = new clsControl(ccsTextBox, "l_name2", "L Name2", ccsText, "", NULL, $this);
        $this->sex = new clsControl(ccsRadioButton, "sex", "Sex", ccsText, "", NULL, $this);
        $this->sex->DSType = dsTable;
        $this->sex->DataSource = new clsDBmadnes();
        $this->sex->ds = & $this->sex->DataSource;
        $this->sex->DataSource->SQL = "SELECT * \n" .
"FROM sexo {SQL_Where} {SQL_OrderBy}";
        list($this->sex->BoundColumn, $this->sex->TextColumn, $this->sex->DBFormat) = array("descripcion", "descripcion", "");
        $this->born_date = new clsControl(ccsTextBox, "born_date", "Born Date", ccsDate, array("ShortDate"), NULL, $this);
        $this->pb_nat = new clsControl(ccsTextBox, "pb_nat", "Pb Nat", ccsText, "", NULL, $this);
        $this->tn_doc = new clsControl(ccsTextBox, "tn_doc", "Tn Doc", ccsText, "", NULL, $this);
        $this->CheckBox_Delete_Panel = new clsPanel("CheckBox_Delete_Panel", $this);
        $this->CheckBox_Delete = new clsControl(ccsCheckBox, "CheckBox_Delete", "CheckBox_Delete", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), NULL, $this);
        $this->CheckBox_Delete->CheckedValue = true;
        $this->CheckBox_Delete->UncheckedValue = false;
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
        $this->Cancel = new clsButton("Cancel", $Method, $this);
        $this->RowStyleAttribute = new clsControl(ccsLabel, "RowStyleAttribute", "RowStyleAttribute", ccsText, "", NULL, $this);
        $this->RowStyleAttribute->HTML = true;
        $this->RowNameAttribute = new clsControl(ccsLabel, "RowNameAttribute", "RowNameAttribute", ccsText, "", NULL, $this);
        $this->RowIDAttribute = new clsControl(ccsLabel, "RowIDAttribute", "RowIDAttribute", ccsText, "", NULL, $this);
        $this->AddedRow = new clsControl(ccsLabel, "AddedRow", "AddedRow", ccsText, "", NULL, $this);
        $this->CheckBox_Delete_Panel->AddComponent("CheckBox_Delete", $this->CheckBox_Delete);
    }
//End Class_Initialize Event

//Initialize Method @2-09EAF4BC
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urlid_func"] = CCGetFromGet("id_func", NULL);
    }
//End Initialize Method

//GetFormParameters Method @2-4E600E38
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["id_func"][$RowNumber] = CCGetFromPost("id_func_" . $RowNumber, NULL);
            $this->FormParameters["type_p"][$RowNumber] = CCGetFromPost("type_p_" . $RowNumber, NULL);
            $this->FormParameters["name"][$RowNumber] = CCGetFromPost("name_" . $RowNumber, NULL);
            $this->FormParameters["l_name1"][$RowNumber] = CCGetFromPost("l_name1_" . $RowNumber, NULL);
            $this->FormParameters["l_name2"][$RowNumber] = CCGetFromPost("l_name2_" . $RowNumber, NULL);
            $this->FormParameters["sex"][$RowNumber] = CCGetFromPost("sex_" . $RowNumber, NULL);
            $this->FormParameters["born_date"][$RowNumber] = CCGetFromPost("born_date_" . $RowNumber, NULL);
            $this->FormParameters["pb_nat"][$RowNumber] = CCGetFromPost("pb_nat_" . $RowNumber, NULL);
            $this->FormParameters["tn_doc"][$RowNumber] = CCGetFromPost("tn_doc_" . $RowNumber, NULL);
            $this->FormParameters["CheckBox_Delete"][$RowNumber] = CCGetFromPost("CheckBox_Delete_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @2-1E9CA2DD
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["id_datf"] = $this->CachedColumns["id_datf"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->id_func->SetText($this->FormParameters["id_func"][$this->RowNumber], $this->RowNumber);
            $this->type_p->SetText($this->FormParameters["type_p"][$this->RowNumber], $this->RowNumber);
            $this->name->SetText($this->FormParameters["name"][$this->RowNumber], $this->RowNumber);
            $this->l_name1->SetText($this->FormParameters["l_name1"][$this->RowNumber], $this->RowNumber);
            $this->l_name2->SetText($this->FormParameters["l_name2"][$this->RowNumber], $this->RowNumber);
            $this->sex->SetText($this->FormParameters["sex"][$this->RowNumber], $this->RowNumber);
            $this->born_date->SetText($this->FormParameters["born_date"][$this->RowNumber], $this->RowNumber);
            $this->pb_nat->SetText($this->FormParameters["pb_nat"][$this->RowNumber], $this->RowNumber);
            $this->tn_doc->SetText($this->FormParameters["tn_doc"][$this->RowNumber], $this->RowNumber);
            $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
            if ($this->UpdatedRows >= $this->RowNumber) {
                if(!$this->CheckBox_Delete->Value)
                    $Validation = ($this->ValidateRow() && $Validation);
            }
            else if($this->CheckInsert())
            {
                $Validation = ($this->ValidateRow() && $Validation);
            }
        }
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//ValidateRow Method @2-A2F6ECEF
    function ValidateRow()
    {
        global $CCSLocales;
        $this->id_func->Validate();
        $this->type_p->Validate();
        $this->name->Validate();
        $this->l_name1->Validate();
        $this->l_name2->Validate();
        $this->sex->Validate();
        $this->born_date->Validate();
        $this->pb_nat->Validate();
        $this->tn_doc->Validate();
        $this->CheckBox_Delete->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->id_func->Errors->ToString());
        $errors = ComposeStrings($errors, $this->type_p->Errors->ToString());
        $errors = ComposeStrings($errors, $this->name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->l_name1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->l_name2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->sex->Errors->ToString());
        $errors = ComposeStrings($errors, $this->born_date->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pb_nat->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tn_doc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->CheckBox_Delete->Errors->ToString());
        $this->id_func->Errors->Clear();
        $this->type_p->Errors->Clear();
        $this->name->Errors->Clear();
        $this->l_name1->Errors->Clear();
        $this->l_name2->Errors->Clear();
        $this->sex->Errors->Clear();
        $this->born_date->Errors->Clear();
        $this->pb_nat->Errors->Clear();
        $this->tn_doc->Errors->Clear();
        $this->CheckBox_Delete->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @2-D1B079AA
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["id_func"][$this->RowNumber]) && count($this->FormParameters["id_func"][$this->RowNumber])) || strlen($this->FormParameters["id_func"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["type_p"][$this->RowNumber]) && count($this->FormParameters["type_p"][$this->RowNumber])) || strlen($this->FormParameters["type_p"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["name"][$this->RowNumber]) && count($this->FormParameters["name"][$this->RowNumber])) || strlen($this->FormParameters["name"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["l_name1"][$this->RowNumber]) && count($this->FormParameters["l_name1"][$this->RowNumber])) || strlen($this->FormParameters["l_name1"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["l_name2"][$this->RowNumber]) && count($this->FormParameters["l_name2"][$this->RowNumber])) || strlen($this->FormParameters["l_name2"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["sex"][$this->RowNumber]) && count($this->FormParameters["sex"][$this->RowNumber])) || strlen($this->FormParameters["sex"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["born_date"][$this->RowNumber]) && count($this->FormParameters["born_date"][$this->RowNumber])) || strlen($this->FormParameters["born_date"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["pb_nat"][$this->RowNumber]) && count($this->FormParameters["pb_nat"][$this->RowNumber])) || strlen($this->FormParameters["pb_nat"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["tn_doc"][$this->RowNumber]) && count($this->FormParameters["tn_doc"][$this->RowNumber])) || strlen($this->FormParameters["tn_doc"][$this->RowNumber]));
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @2-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @2-6B923CC2
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->DataSource->Prepare();
        if(!$this->FormSubmitted)
            return;

        $this->GetFormParameters();
        $this->PressedButton = "Button_Submit";
        if($this->Button_Submit->Pressed) {
            $this->PressedButton = "Button_Submit";
        } else if($this->Cancel->Pressed) {
            $this->PressedButton = "Cancel";
        }

        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Submit") {
            if(!CCGetEvent($this->Button_Submit->CCSEvents, "OnClick", $this->Button_Submit) || !$this->UpdateGrid()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Cancel") {
            if(!CCGetEvent($this->Cancel->CCSEvents, "OnClick", $this->Cancel)) {
                $Redirect = "";
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//UpdateGrid Method @2-03C3199F
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["id_datf"] = $this->CachedColumns["id_datf"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->id_func->SetText($this->FormParameters["id_func"][$this->RowNumber], $this->RowNumber);
            $this->type_p->SetText($this->FormParameters["type_p"][$this->RowNumber], $this->RowNumber);
            $this->name->SetText($this->FormParameters["name"][$this->RowNumber], $this->RowNumber);
            $this->l_name1->SetText($this->FormParameters["l_name1"][$this->RowNumber], $this->RowNumber);
            $this->l_name2->SetText($this->FormParameters["l_name2"][$this->RowNumber], $this->RowNumber);
            $this->sex->SetText($this->FormParameters["sex"][$this->RowNumber], $this->RowNumber);
            $this->born_date->SetText($this->FormParameters["born_date"][$this->RowNumber], $this->RowNumber);
            $this->pb_nat->SetText($this->FormParameters["pb_nat"][$this->RowNumber], $this->RowNumber);
            $this->tn_doc->SetText($this->FormParameters["tn_doc"][$this->RowNumber], $this->RowNumber);
            $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
            if ($this->UpdatedRows >= $this->RowNumber) {
                if($this->CheckBox_Delete->Value) {
                    if($this->DeleteAllowed) { $Validation = ($this->DeleteRow() && $Validation); }
                } else if($this->UpdateAllowed) {
                    $Validation = ($this->UpdateRow() && $Validation);
                }
            }
            else if($this->CheckInsert() && $this->InsertAllowed)
            {
                $Validation = ($Validation && $this->InsertRow());
            }
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterSubmit", $this);
        if ($this->Errors->Count() == 0 && $Validation){
            $this->DataSource->close();
            return true;
        }
        return false;
    }
//End UpdateGrid Method

//InsertRow Method @2-314C56A1
    function InsertRow()
    {
        if(!$this->InsertAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->type_p->SetValue($this->type_p->GetValue(true));
        $this->DataSource->name->SetValue($this->name->GetValue(true));
        $this->DataSource->l_name1->SetValue($this->l_name1->GetValue(true));
        $this->DataSource->l_name2->SetValue($this->l_name2->GetValue(true));
        $this->DataSource->sex->SetValue($this->sex->GetValue(true));
        $this->DataSource->born_date->SetValue($this->born_date->GetValue(true));
        $this->DataSource->pb_nat->SetValue($this->pb_nat->GetValue(true));
        $this->DataSource->tn_doc->SetValue($this->tn_doc->GetValue(true));
        $this->DataSource->RowStyleAttribute->SetValue($this->RowStyleAttribute->GetValue(true));
        $this->DataSource->RowNameAttribute->SetValue($this->RowNameAttribute->GetValue(true));
        $this->DataSource->RowIDAttribute->SetValue($this->RowIDAttribute->GetValue(true));
        $this->DataSource->AddedRow->SetValue($this->AddedRow->GetValue(true));
        $this->DataSource->Insert();
        $errors = "";
        if($this->DataSource->Errors->Count() > 0) {
            $errors = $this->DataSource->Errors->ToString();
            $this->RowsErrors[$this->RowNumber] = $errors;
            $this->DataSource->Errors->Clear();
        }
        return (($this->Errors->Count() == 0) && !strlen($errors));
    }
//End InsertRow Method

//UpdateRow Method @2-BBA998A0
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->type_p->SetValue($this->type_p->GetValue(true));
        $this->DataSource->name->SetValue($this->name->GetValue(true));
        $this->DataSource->l_name1->SetValue($this->l_name1->GetValue(true));
        $this->DataSource->l_name2->SetValue($this->l_name2->GetValue(true));
        $this->DataSource->sex->SetValue($this->sex->GetValue(true));
        $this->DataSource->born_date->SetValue($this->born_date->GetValue(true));
        $this->DataSource->pb_nat->SetValue($this->pb_nat->GetValue(true));
        $this->DataSource->tn_doc->SetValue($this->tn_doc->GetValue(true));
        $this->DataSource->RowStyleAttribute->SetValue($this->RowStyleAttribute->GetValue(true));
        $this->DataSource->RowNameAttribute->SetValue($this->RowNameAttribute->GetValue(true));
        $this->DataSource->RowIDAttribute->SetValue($this->RowIDAttribute->GetValue(true));
        $this->DataSource->AddedRow->SetValue($this->AddedRow->GetValue(true));
        $this->DataSource->Update();
        $errors = "";
        if($this->DataSource->Errors->Count() > 0) {
            $errors = $this->DataSource->Errors->ToString();
            $this->RowsErrors[$this->RowNumber] = $errors;
            $this->DataSource->Errors->Clear();
        }
        return (($this->Errors->Count() == 0) && !strlen($errors));
    }
//End UpdateRow Method

//DeleteRow Method @2-A4A656F6
    function DeleteRow()
    {
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $errors = "";
        if($this->DataSource->Errors->Count() > 0) {
            $errors = $this->DataSource->Errors->ToString();
            $this->RowsErrors[$this->RowNumber] = $errors;
            $this->DataSource->Errors->Clear();
        }
        return (($this->Errors->Count() == 0) && !strlen($errors));
    }
//End DeleteRow Method

//FormScript Method @2-59800DB5
    function FormScript($TotalRows)
    {
        $script = "";
        return $script;
    }
//End FormScript Method

//SetFormState Method @2-55317E68
    function SetFormState($FormState)
    {
        if(strlen($FormState)) {
            $FormState = str_replace("\\\\", "\\" . ord("\\"), $FormState);
            $FormState = str_replace("\\;", "\\" . ord(";"), $FormState);
            $pieces = explode(";", $FormState);
            $this->UpdatedRows = $pieces[0];
            $this->EmptyRows   = $pieces[1];
            $this->TotalRows = $this->UpdatedRows + $this->EmptyRows;
            $RowNumber = 0;
            for($i = 2; $i < sizeof($pieces); $i = $i + 1)  {
                $piece = $pieces[$i + 0];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["id_datf"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["id_datf"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @2-51746D48
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["id_datf"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @2-638D83EC
    function Show()
    {
        $Tpl = & CCGetTemplate($this);
        global $FileName;
        global $CCSLocales;
        global $CCSUseAmp;
        $Error = "";

        if(!$this->Visible) { return; }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->type_p->Prepare();
        $this->sex->Prepare();

        $this->DataSource->open();
        $is_next_record = ($this->ReadAllowed && $this->DataSource->next_record());
        $this->IsEmpty = ! $is_next_record;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) { return; }

        $this->Attributes->Show();
        $this->Button_Submit->Visible = $this->Button_Submit->Visible && ($this->InsertAllowed || $this->UpdateAllowed || $this->DeleteAllowed);
        $ParentPath = $Tpl->block_path;
        $EditableGridPath = $ParentPath . "/EditableGrid " . $this->ComponentName;
        $EditableGridRowPath = $ParentPath . "/EditableGrid " . $this->ComponentName . "/Row";
        $Tpl->block_path = $EditableGridRowPath;
        $this->RowNumber = 0;
        $NonEmptyRows = 0;
        $EmptyRowsLeft = $this->EmptyRows;
        $this->ControlsVisible["id_func"] = $this->id_func->Visible;
        $this->ControlsVisible["type_p"] = $this->type_p->Visible;
        $this->ControlsVisible["name"] = $this->name->Visible;
        $this->ControlsVisible["l_name1"] = $this->l_name1->Visible;
        $this->ControlsVisible["l_name2"] = $this->l_name2->Visible;
        $this->ControlsVisible["sex"] = $this->sex->Visible;
        $this->ControlsVisible["born_date"] = $this->born_date->Visible;
        $this->ControlsVisible["pb_nat"] = $this->pb_nat->Visible;
        $this->ControlsVisible["tn_doc"] = $this->tn_doc->Visible;
        $this->ControlsVisible["CheckBox_Delete_Panel"] = $this->CheckBox_Delete_Panel->Visible;
        $this->ControlsVisible["CheckBox_Delete"] = $this->CheckBox_Delete->Visible;
        $this->ControlsVisible["RowStyleAttribute"] = $this->RowStyleAttribute->Visible;
        $this->ControlsVisible["RowNameAttribute"] = $this->RowNameAttribute->Visible;
        $this->ControlsVisible["RowIDAttribute"] = $this->RowIDAttribute->Visible;
        $this->ControlsVisible["AddedRow"] = $this->AddedRow->Visible;
        if ($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed)) {
            do {
                $this->RowNumber++;
                if($is_next_record) {
                    $NonEmptyRows++;
                    $this->DataSource->SetValues();
                }
                if (!($is_next_record) || !($this->DeleteAllowed)) {
                    $this->CheckBox_Delete->Visible = false;
                    $this->CheckBox_Delete_Panel->Visible = false;
                }
                if (!($this->FormSubmitted) && $is_next_record) {
                    $this->CachedColumns["id_datf"][$this->RowNumber] = $this->DataSource->CachedColumns["id_datf"];
                    $this->CheckBox_Delete->SetValue(false);
                    $this->RowStyleAttribute->SetText("");
                    $this->RowNameAttribute->SetText("");
                    $this->RowIDAttribute->SetText("");
                    $this->AddedRow->SetText("");
                    $this->id_func->SetValue($this->DataSource->id_func->GetValue());
                    $this->type_p->SetValue($this->DataSource->type_p->GetValue());
                    $this->name->SetValue($this->DataSource->name->GetValue());
                    $this->l_name1->SetValue($this->DataSource->l_name1->GetValue());
                    $this->l_name2->SetValue($this->DataSource->l_name2->GetValue());
                    $this->sex->SetValue($this->DataSource->sex->GetValue());
                    $this->born_date->SetValue($this->DataSource->born_date->GetValue());
                    $this->pb_nat->SetValue($this->DataSource->pb_nat->GetValue());
                    $this->tn_doc->SetValue($this->DataSource->tn_doc->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->RowStyleAttribute->SetText("");
                    $this->RowNameAttribute->SetText("");
                    $this->RowIDAttribute->SetText("");
                    $this->AddedRow->SetText("");
                    $this->id_func->SetText($this->FormParameters["id_func"][$this->RowNumber], $this->RowNumber);
                    $this->type_p->SetText($this->FormParameters["type_p"][$this->RowNumber], $this->RowNumber);
                    $this->name->SetText($this->FormParameters["name"][$this->RowNumber], $this->RowNumber);
                    $this->l_name1->SetText($this->FormParameters["l_name1"][$this->RowNumber], $this->RowNumber);
                    $this->l_name2->SetText($this->FormParameters["l_name2"][$this->RowNumber], $this->RowNumber);
                    $this->sex->SetText($this->FormParameters["sex"][$this->RowNumber], $this->RowNumber);
                    $this->born_date->SetText($this->FormParameters["born_date"][$this->RowNumber], $this->RowNumber);
                    $this->pb_nat->SetText($this->FormParameters["pb_nat"][$this->RowNumber], $this->RowNumber);
                    $this->tn_doc->SetText($this->FormParameters["tn_doc"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["id_datf"][$this->RowNumber] = "";
                    $this->id_func->SetText("");
                    $this->type_p->SetText("");
                    $this->name->SetText("");
                    $this->l_name1->SetText("");
                    $this->l_name2->SetText("");
                    $this->sex->SetText("");
                    $this->born_date->SetText("");
                    $this->pb_nat->SetText("");
                    $this->tn_doc->SetText("");
                    $this->RowStyleAttribute->SetText("");
                    $this->RowNameAttribute->SetText("");
                    $this->RowIDAttribute->SetText("");
                    $this->AddedRow->SetText("");
                } else {
                    $this->RowStyleAttribute->SetText("");
                    $this->RowNameAttribute->SetText("");
                    $this->RowIDAttribute->SetText("");
                    $this->AddedRow->SetText("");
                    $this->id_func->SetText($this->FormParameters["id_func"][$this->RowNumber], $this->RowNumber);
                    $this->type_p->SetText($this->FormParameters["type_p"][$this->RowNumber], $this->RowNumber);
                    $this->name->SetText($this->FormParameters["name"][$this->RowNumber], $this->RowNumber);
                    $this->l_name1->SetText($this->FormParameters["l_name1"][$this->RowNumber], $this->RowNumber);
                    $this->l_name2->SetText($this->FormParameters["l_name2"][$this->RowNumber], $this->RowNumber);
                    $this->sex->SetText($this->FormParameters["sex"][$this->RowNumber], $this->RowNumber);
                    $this->born_date->SetText($this->FormParameters["born_date"][$this->RowNumber], $this->RowNumber);
                    $this->pb_nat->SetText($this->FormParameters["pb_nat"][$this->RowNumber], $this->RowNumber);
                    $this->tn_doc->SetText($this->FormParameters["tn_doc"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->id_func->Show($this->RowNumber);
                $this->type_p->Show($this->RowNumber);
                $this->name->Show($this->RowNumber);
                $this->l_name1->Show($this->RowNumber);
                $this->l_name2->Show($this->RowNumber);
                $this->sex->Show($this->RowNumber);
                $this->born_date->Show($this->RowNumber);
                $this->pb_nat->Show($this->RowNumber);
                $this->tn_doc->Show($this->RowNumber);
                $this->CheckBox_Delete_Panel->Show($this->RowNumber);
                $this->RowStyleAttribute->Show($this->RowNumber);
                $this->RowNameAttribute->Show($this->RowNumber);
                $this->RowIDAttribute->Show($this->RowNumber);
                $this->AddedRow->Show($this->RowNumber);
                if (isset($this->RowsErrors[$this->RowNumber]) && ($this->RowsErrors[$this->RowNumber] != "")) {
                    $Tpl->setblockvar("RowError", "");
                    $Tpl->setvar("Error", $this->RowsErrors[$this->RowNumber]);
                    $this->Attributes->Show();
                    $Tpl->parse("RowError", false);
                } else {
                    $Tpl->setblockvar("RowError", "");
                }
                $Tpl->setvar("FormScript", $this->FormScript($this->RowNumber));
                $Tpl->parse();
                if ($is_next_record) {
                    if ($this->FormSubmitted) {
                        $is_next_record = $this->RowNumber < $this->UpdatedRows;
                        if (($this->DataSource->CachedColumns["id_datf"] == $this->CachedColumns["id_datf"][$this->RowNumber])) {
                            if ($this->ReadAllowed) $this->DataSource->next_record();
                        }
                    }else{
                        $is_next_record = ($this->RowNumber < $this->PageSize) &&  $this->ReadAllowed && $this->DataSource->next_record();
                    }
                } else { 
                    $EmptyRowsLeft--;
                }
            } while($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed));
        } else {
            $Tpl->block_path = $EditableGridPath;
            $this->Attributes->Show();
            $Tpl->parse("NoRecords", false);
        }

        $Tpl->block_path = $EditableGridPath;
        $this->Button_Submit->Show();
        $this->Cancel->Show();

        if($this->CheckErrors()) {
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);
        if (!$CCSUseAmp) {
            $Tpl->SetVar("HTMLFormProperties", "method=\"POST\" action=\"" . $this->HTMLFormAction . "\" name=\"" . $this->ComponentName . "\"");
        } else {
            $Tpl->SetVar("HTMLFormProperties", "method=\"post\" action=\"" . str_replace("&", "&amp;", $this->HTMLFormAction) . "\" id=\"" . $this->ComponentName . "\"");
        }
        $Tpl->SetVar("FormState", CCToHTML($this->GetFormState($NonEmptyRows)));
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End dat_fam Class @2-FCB6E20C

class clsdat_famDataSource extends clsDBmadnes {  //dat_famDataSource Class @2-5CEB3720

//DataSource Variables @2-AA35C698
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $DeleteParameters;
    public $CountSQL;
    public $wp;
    public $AllParametersSet;

    public $CachedColumns;
    public $CurrentRow;
    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $id_func;
    public $type_p;
    public $name;
    public $l_name1;
    public $l_name2;
    public $sex;
    public $born_date;
    public $pb_nat;
    public $tn_doc;
    public $CheckBox_Delete;
    public $RowStyleAttribute;
    public $RowNameAttribute;
    public $RowIDAttribute;
    public $AddedRow;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-1DBA72E3
    function clsdat_famDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid dat_fam/Error";
        $this->Initialize();
        $this->id_func = new clsField("id_func", ccsInteger, "");
        
        $this->type_p = new clsField("type_p", ccsText, "");
        
        $this->name = new clsField("name", ccsText, "");
        
        $this->l_name1 = new clsField("l_name1", ccsText, "");
        
        $this->l_name2 = new clsField("l_name2", ccsText, "");
        
        $this->sex = new clsField("sex", ccsText, "");
        
        $this->born_date = new clsField("born_date", ccsDate, $this->DateFormat);
        
        $this->pb_nat = new clsField("pb_nat", ccsText, "");
        
        $this->tn_doc = new clsField("tn_doc", ccsText, "");
        
        $this->CheckBox_Delete = new clsField("CheckBox_Delete", ccsBoolean, $this->BooleanFormat);
        
        $this->RowStyleAttribute = new clsField("RowStyleAttribute", ccsText, "");
        
        $this->RowNameAttribute = new clsField("RowNameAttribute", ccsText, "");
        
        $this->RowIDAttribute = new clsField("RowIDAttribute", ccsText, "");
        
        $this->AddedRow = new clsField("AddedRow", ccsText, "");
        

        $this->InsertFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["type_p"] = array("Name" => "type_p", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["name"] = array("Name" => "name", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["l_name1"] = array("Name" => "l_name1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["l_name2"] = array("Name" => "l_name2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["sex"] = array("Name" => "sex", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["born_date"] = array("Name" => "born_date", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["pb_nat"] = array("Name" => "pb_nat", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tn_doc"] = array("Name" => "tn_doc", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["type_p"] = array("Name" => "type_p", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["name"] = array("Name" => "name", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["l_name1"] = array("Name" => "l_name1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["l_name2"] = array("Name" => "l_name2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["sex"] = array("Name" => "sex", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["born_date"] = array("Name" => "born_date", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["pb_nat"] = array("Name" => "pb_nat", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tn_doc"] = array("Name" => "tn_doc", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
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

//Open Method @2-07F60054
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM dat_fam";
        $this->SQL = "SELECT *, id_datf \n\n" .
        "FROM dat_fam {SQL_Where} {SQL_OrderBy}";
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

//SetValues Method @2-3537A871
    function SetValues()
    {
        $this->CachedColumns["id_datf"] = $this->f("id_datf");
        $this->id_func->SetDBValue(trim($this->f("id_func")));
        $this->type_p->SetDBValue($this->f("type_p"));
        $this->name->SetDBValue($this->f("name"));
        $this->l_name1->SetDBValue($this->f("l_name1"));
        $this->l_name2->SetDBValue($this->f("l_name2"));
        $this->sex->SetDBValue($this->f("sex"));
        $this->born_date->SetDBValue(trim($this->f("born_date")));
        $this->pb_nat->SetDBValue($this->f("pb_nat"));
        $this->tn_doc->SetDBValue($this->f("tn_doc"));
    }
//End SetValues Method

//Insert Method @2-88791A25
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->InsertFields["type_p"]["Value"] = $this->type_p->GetDBValue(true);
        $this->InsertFields["name"]["Value"] = $this->name->GetDBValue(true);
        $this->InsertFields["l_name1"]["Value"] = $this->l_name1->GetDBValue(true);
        $this->InsertFields["l_name2"]["Value"] = $this->l_name2->GetDBValue(true);
        $this->InsertFields["sex"]["Value"] = $this->sex->GetDBValue(true);
        $this->InsertFields["born_date"]["Value"] = $this->born_date->GetDBValue(true);
        $this->InsertFields["pb_nat"]["Value"] = $this->pb_nat->GetDBValue(true);
        $this->InsertFields["tn_doc"]["Value"] = $this->tn_doc->GetDBValue(true);
        $this->SQL = CCBuildInsert("dat_fam", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-5173480B
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "id_datf=" . $this->ToSQL($this->CachedColumns["id_datf"], ccsInteger);
        $this->UpdateFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->UpdateFields["type_p"]["Value"] = $this->type_p->GetDBValue(true);
        $this->UpdateFields["name"]["Value"] = $this->name->GetDBValue(true);
        $this->UpdateFields["l_name1"]["Value"] = $this->l_name1->GetDBValue(true);
        $this->UpdateFields["l_name2"]["Value"] = $this->l_name2->GetDBValue(true);
        $this->UpdateFields["sex"]["Value"] = $this->sex->GetDBValue(true);
        $this->UpdateFields["born_date"]["Value"] = $this->born_date->GetDBValue(true);
        $this->UpdateFields["pb_nat"]["Value"] = $this->pb_nat->GetDBValue(true);
        $this->UpdateFields["tn_doc"]["Value"] = $this->tn_doc->GetDBValue(true);
        $this->SQL = CCBuildUpdate("dat_fam", $this->UpdateFields, $this);
        $this->SQL .= strlen($this->Where) ? " WHERE " . $this->Where : $this->Where;
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
        $this->Where = $SelectWhere;
    }
//End Update Method

//Delete Method @2-D5B975A9
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "id_datf=" . $this->ToSQL($this->CachedColumns["id_datf"], ccsInteger);
        $this->SQL = "DELETE FROM dat_fam";
        $this->SQL = CCBuildSQL($this->SQL, $this->Where, "");
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
        $this->Where = $SelectWhere;
    }
//End Delete Method

} //End dat_famDataSource Class @2-FCB6E20C

//Initialize Page @1-26E79FD9
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
$TemplateFileName = "Reg_dat_fam.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-3724D944
include_once("./Reg_dat_fam_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-5DD983F5
$DBmadnes = new clsDBmadnes();
$MainPage->Connections["madnes"] = & $DBmadnes;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$dat_fam = new clsEditableGriddat_fam("", $MainPage);
$MainPage->dat_fam = & $dat_fam;
$dat_fam->Initialize();

BindEvents();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize", $MainPage);

if ($Charset) {
    header("Content-Type: " . $ContentType . "; charset=" . $Charset);
} else {
    header("Content-Type: " . $ContentType);
}
//End Initialize Objects

//Initialize HTML Template @1-FA3E6D4A
$CCSEventResult = CCGetEvent($CCSEvents, "OnInitializeView", $MainPage);
$Tpl = new clsTemplate($FileEncoding, $TemplateEncoding);
if (strlen($TemplateSource)) {
    $Tpl->LoadTemplateFromStr($TemplateSource, $BlockToParse, "CP1252");
} else {
    $Tpl->LoadTemplate(PathToCurrentPage . $TemplateFileName, $BlockToParse, "CP1252");
}
$Tpl->SetVar("CCS_PathToRoot", $PathToRoot);
$Tpl->block_path = "/$BlockToParse";
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow", $MainPage);
$Attributes->SetValue("pathToRoot", "");
$Attributes->Show();
//End Initialize HTML Template

//Execute Components @1-B3C1446C
$dat_fam->Operation();
//End Execute Components

//Go to destination page @1-FC8F6E9E
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmadnes->close();
    header("Location: " . $Redirect);
    unset($dat_fam);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-475B165A
$dat_fam->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-E30DC538
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmadnes->close();
unset($dat_fam);
unset($Tpl);
//End Unload Page


?>
