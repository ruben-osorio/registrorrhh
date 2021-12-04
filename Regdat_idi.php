<?php
//Include Common Files @1-AA7400D1
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "Regdat_idi.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordlang_func { //lang_func Class @2-FE2D75B5

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

//Class_Initialize Event @2-2BB1E045
    function clsRecordlang_func($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record lang_func/Error";
        $this->DataSource = new clslang_funcDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "lang_func";
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
            $this->descp = new clsControl(ccsTextBox, "descp", "Descp", ccsText, "", CCGetRequestParam("descp", $Method, NULL), $this);
            $this->read_l = new clsControl(ccsListBox, "read_l", "Read L", ccsText, "", CCGetRequestParam("read_l", $Method, NULL), $this);
            $this->read_l->DSType = dsTable;
            $this->read_l->DataSource = new clsDBmadnes();
            $this->read_l->ds = & $this->read_l->DataSource;
            $this->read_l->DataSource->SQL = "SELECT * \n" .
"FROM nivel_lang {SQL_Where} {SQL_OrderBy}";
            list($this->read_l->BoundColumn, $this->read_l->TextColumn, $this->read_l->DBFormat) = array("desc_nLang", "desc_nLang", "");
            $this->speak_l = new clsControl(ccsListBox, "speak_l", "Speak L", ccsText, "", CCGetRequestParam("speak_l", $Method, NULL), $this);
            $this->speak_l->DSType = dsTable;
            $this->speak_l->DataSource = new clsDBmadnes();
            $this->speak_l->ds = & $this->speak_l->DataSource;
            $this->speak_l->DataSource->SQL = "SELECT * \n" .
"FROM nivel_lang {SQL_Where} {SQL_OrderBy}";
            list($this->speak_l->BoundColumn, $this->speak_l->TextColumn, $this->speak_l->DBFormat) = array("desc_nLang", "desc_nLang", "");
            $this->write_l = new clsControl(ccsListBox, "write_l", "Write L", ccsText, "", CCGetRequestParam("write_l", $Method, NULL), $this);
            $this->write_l->DSType = dsTable;
            $this->write_l->DataSource = new clsDBmadnes();
            $this->write_l->ds = & $this->write_l->DataSource;
            $this->write_l->DataSource->SQL = "SELECT * \n" .
"FROM nivel_lang {SQL_Where} {SQL_OrderBy}";
            list($this->write_l->BoundColumn, $this->write_l->TextColumn, $this->write_l->DBFormat) = array("desc_nLang", "desc_nLang", "");
            $this->descp1 = new clsControl(ccsTextBox, "descp1", "Descp1", ccsText, "", CCGetRequestParam("descp1", $Method, NULL), $this);
            $this->read_l1 = new clsControl(ccsListBox, "read_l1", "Read L1", ccsText, "", CCGetRequestParam("read_l1", $Method, NULL), $this);
            $this->read_l1->DSType = dsTable;
            $this->read_l1->DataSource = new clsDBmadnes();
            $this->read_l1->ds = & $this->read_l1->DataSource;
            $this->read_l1->DataSource->SQL = "SELECT * \n" .
"FROM nivel_lang {SQL_Where} {SQL_OrderBy}";
            list($this->read_l1->BoundColumn, $this->read_l1->TextColumn, $this->read_l1->DBFormat) = array("desc_nLang", "desc_nLang", "");
            $this->speak_l1 = new clsControl(ccsListBox, "speak_l1", "Speak L1", ccsText, "", CCGetRequestParam("speak_l1", $Method, NULL), $this);
            $this->speak_l1->DSType = dsTable;
            $this->speak_l1->DataSource = new clsDBmadnes();
            $this->speak_l1->ds = & $this->speak_l1->DataSource;
            $this->speak_l1->DataSource->SQL = "SELECT * \n" .
"FROM nivel_lang {SQL_Where} {SQL_OrderBy}";
            list($this->speak_l1->BoundColumn, $this->speak_l1->TextColumn, $this->speak_l1->DBFormat) = array("desc_nLang", "desc_nLang", "");
            $this->write_l1 = new clsControl(ccsListBox, "write_l1", "Write L1", ccsText, "", CCGetRequestParam("write_l1", $Method, NULL), $this);
            $this->write_l1->DSType = dsTable;
            $this->write_l1->DataSource = new clsDBmadnes();
            $this->write_l1->ds = & $this->write_l1->DataSource;
            $this->write_l1->DataSource->SQL = "SELECT * \n" .
"FROM nivel_lang {SQL_Where} {SQL_OrderBy}";
            list($this->write_l1->BoundColumn, $this->write_l1->TextColumn, $this->write_l1->DBFormat) = array("desc_nLang", "desc_nLang", "");
            $this->descp2 = new clsControl(ccsTextBox, "descp2", "Descp2", ccsText, "", CCGetRequestParam("descp2", $Method, NULL), $this);
            $this->read_l2 = new clsControl(ccsListBox, "read_l2", "Read L2", ccsText, "", CCGetRequestParam("read_l2", $Method, NULL), $this);
            $this->read_l2->DSType = dsTable;
            $this->read_l2->DataSource = new clsDBmadnes();
            $this->read_l2->ds = & $this->read_l2->DataSource;
            $this->read_l2->DataSource->SQL = "SELECT * \n" .
"FROM nivel_lang {SQL_Where} {SQL_OrderBy}";
            list($this->read_l2->BoundColumn, $this->read_l2->TextColumn, $this->read_l2->DBFormat) = array("desc_nLang", "desc_nLang", "");
            $this->speak_l2 = new clsControl(ccsListBox, "speak_l2", "Speak L2", ccsText, "", CCGetRequestParam("speak_l2", $Method, NULL), $this);
            $this->speak_l2->DSType = dsTable;
            $this->speak_l2->DataSource = new clsDBmadnes();
            $this->speak_l2->ds = & $this->speak_l2->DataSource;
            $this->speak_l2->DataSource->SQL = "SELECT * \n" .
"FROM nivel_lang {SQL_Where} {SQL_OrderBy}";
            list($this->speak_l2->BoundColumn, $this->speak_l2->TextColumn, $this->speak_l2->DBFormat) = array("desc_nLang", "desc_nLang", "");
            $this->write_l2 = new clsControl(ccsListBox, "write_l2", "Write L2", ccsText, "", CCGetRequestParam("write_l2", $Method, NULL), $this);
            $this->write_l2->DSType = dsTable;
            $this->write_l2->DataSource = new clsDBmadnes();
            $this->write_l2->ds = & $this->write_l2->DataSource;
            $this->write_l2->DataSource->SQL = "SELECT * \n" .
"FROM nivel_lang {SQL_Where} {SQL_OrderBy}";
            list($this->write_l2->BoundColumn, $this->write_l2->TextColumn, $this->write_l2->DBFormat) = array("desc_nLang", "desc_nLang", "");
            $this->descp3 = new clsControl(ccsTextBox, "descp3", "Descp3", ccsText, "", CCGetRequestParam("descp3", $Method, NULL), $this);
            $this->read_l3 = new clsControl(ccsListBox, "read_l3", "Read L3", ccsText, "", CCGetRequestParam("read_l3", $Method, NULL), $this);
            $this->read_l3->DSType = dsTable;
            $this->read_l3->DataSource = new clsDBmadnes();
            $this->read_l3->ds = & $this->read_l3->DataSource;
            $this->read_l3->DataSource->SQL = "SELECT * \n" .
"FROM nivel_lang {SQL_Where} {SQL_OrderBy}";
            list($this->read_l3->BoundColumn, $this->read_l3->TextColumn, $this->read_l3->DBFormat) = array("desc_nLang", "desc_nLang", "");
            $this->speak_l3 = new clsControl(ccsListBox, "speak_l3", "Speak L3", ccsText, "", CCGetRequestParam("speak_l3", $Method, NULL), $this);
            $this->speak_l3->DSType = dsTable;
            $this->speak_l3->DataSource = new clsDBmadnes();
            $this->speak_l3->ds = & $this->speak_l3->DataSource;
            $this->speak_l3->DataSource->SQL = "SELECT * \n" .
"FROM nivel_lang {SQL_Where} {SQL_OrderBy}";
            list($this->speak_l3->BoundColumn, $this->speak_l3->TextColumn, $this->speak_l3->DBFormat) = array("desc_nLang", "desc_nLang", "");
            $this->write_l3 = new clsControl(ccsListBox, "write_l3", "Write L3", ccsText, "", CCGetRequestParam("write_l3", $Method, NULL), $this);
            $this->write_l3->DSType = dsTable;
            $this->write_l3->DataSource = new clsDBmadnes();
            $this->write_l3->ds = & $this->write_l3->DataSource;
            $this->write_l3->DataSource->SQL = "SELECT * \n" .
"FROM nivel_lang {SQL_Where} {SQL_OrderBy}";
            list($this->write_l3->BoundColumn, $this->write_l3->TextColumn, $this->write_l3->DBFormat) = array("desc_nLang", "desc_nLang", "");
            $this->descp4 = new clsControl(ccsTextBox, "descp4", "Descp4", ccsText, "", CCGetRequestParam("descp4", $Method, NULL), $this);
            $this->read_l4 = new clsControl(ccsListBox, "read_l4", "Read L4", ccsText, "", CCGetRequestParam("read_l4", $Method, NULL), $this);
            $this->read_l4->DSType = dsTable;
            $this->read_l4->DataSource = new clsDBmadnes();
            $this->read_l4->ds = & $this->read_l4->DataSource;
            $this->read_l4->DataSource->SQL = "SELECT * \n" .
"FROM nivel_lang {SQL_Where} {SQL_OrderBy}";
            list($this->read_l4->BoundColumn, $this->read_l4->TextColumn, $this->read_l4->DBFormat) = array("desc_nLang", "desc_nLang", "");
            $this->speak_l4 = new clsControl(ccsListBox, "speak_l4", "Speak L4", ccsText, "", CCGetRequestParam("speak_l4", $Method, NULL), $this);
            $this->speak_l4->DSType = dsTable;
            $this->speak_l4->DataSource = new clsDBmadnes();
            $this->speak_l4->ds = & $this->speak_l4->DataSource;
            $this->speak_l4->DataSource->SQL = "SELECT * \n" .
"FROM nivel_lang {SQL_Where} {SQL_OrderBy}";
            list($this->speak_l4->BoundColumn, $this->speak_l4->TextColumn, $this->speak_l4->DBFormat) = array("desc_nLang", "desc_nLang", "");
            $this->write_l4 = new clsControl(ccsListBox, "write_l4", "Write L4", ccsText, "", CCGetRequestParam("write_l4", $Method, NULL), $this);
            $this->write_l4->DSType = dsTable;
            $this->write_l4->DataSource = new clsDBmadnes();
            $this->write_l4->ds = & $this->write_l4->DataSource;
            $this->write_l4->DataSource->SQL = "SELECT * \n" .
"FROM nivel_lang {SQL_Where} {SQL_OrderBy}";
            list($this->write_l4->BoundColumn, $this->write_l4->TextColumn, $this->write_l4->DBFormat) = array("desc_nLang", "desc_nLang", "");
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

//Validate Method @2-702DBE0B
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->id_func->Validate() && $Validation);
        $Validation = ($this->descp->Validate() && $Validation);
        $Validation = ($this->read_l->Validate() && $Validation);
        $Validation = ($this->speak_l->Validate() && $Validation);
        $Validation = ($this->write_l->Validate() && $Validation);
        $Validation = ($this->descp1->Validate() && $Validation);
        $Validation = ($this->read_l1->Validate() && $Validation);
        $Validation = ($this->speak_l1->Validate() && $Validation);
        $Validation = ($this->write_l1->Validate() && $Validation);
        $Validation = ($this->descp2->Validate() && $Validation);
        $Validation = ($this->read_l2->Validate() && $Validation);
        $Validation = ($this->speak_l2->Validate() && $Validation);
        $Validation = ($this->write_l2->Validate() && $Validation);
        $Validation = ($this->descp3->Validate() && $Validation);
        $Validation = ($this->read_l3->Validate() && $Validation);
        $Validation = ($this->speak_l3->Validate() && $Validation);
        $Validation = ($this->write_l3->Validate() && $Validation);
        $Validation = ($this->descp4->Validate() && $Validation);
        $Validation = ($this->read_l4->Validate() && $Validation);
        $Validation = ($this->speak_l4->Validate() && $Validation);
        $Validation = ($this->write_l4->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->id_func->Errors->Count() == 0);
        $Validation =  $Validation && ($this->descp->Errors->Count() == 0);
        $Validation =  $Validation && ($this->read_l->Errors->Count() == 0);
        $Validation =  $Validation && ($this->speak_l->Errors->Count() == 0);
        $Validation =  $Validation && ($this->write_l->Errors->Count() == 0);
        $Validation =  $Validation && ($this->descp1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->read_l1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->speak_l1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->write_l1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->descp2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->read_l2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->speak_l2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->write_l2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->descp3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->read_l3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->speak_l3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->write_l3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->descp4->Errors->Count() == 0);
        $Validation =  $Validation && ($this->read_l4->Errors->Count() == 0);
        $Validation =  $Validation && ($this->speak_l4->Errors->Count() == 0);
        $Validation =  $Validation && ($this->write_l4->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-8970A06A
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->id_func->Errors->Count());
        $errors = ($errors || $this->descp->Errors->Count());
        $errors = ($errors || $this->read_l->Errors->Count());
        $errors = ($errors || $this->speak_l->Errors->Count());
        $errors = ($errors || $this->write_l->Errors->Count());
        $errors = ($errors || $this->descp1->Errors->Count());
        $errors = ($errors || $this->read_l1->Errors->Count());
        $errors = ($errors || $this->speak_l1->Errors->Count());
        $errors = ($errors || $this->write_l1->Errors->Count());
        $errors = ($errors || $this->descp2->Errors->Count());
        $errors = ($errors || $this->read_l2->Errors->Count());
        $errors = ($errors || $this->speak_l2->Errors->Count());
        $errors = ($errors || $this->write_l2->Errors->Count());
        $errors = ($errors || $this->descp3->Errors->Count());
        $errors = ($errors || $this->read_l3->Errors->Count());
        $errors = ($errors || $this->speak_l3->Errors->Count());
        $errors = ($errors || $this->write_l3->Errors->Count());
        $errors = ($errors || $this->descp4->Errors->Count());
        $errors = ($errors || $this->read_l4->Errors->Count());
        $errors = ($errors || $this->speak_l4->Errors->Count());
        $errors = ($errors || $this->write_l4->Errors->Count());
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

//InsertRow Method @2-1A7A4D13
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->descp->SetValue($this->descp->GetValue(true));
        $this->DataSource->read_l->SetValue($this->read_l->GetValue(true));
        $this->DataSource->speak_l->SetValue($this->speak_l->GetValue(true));
        $this->DataSource->write_l->SetValue($this->write_l->GetValue(true));
        $this->DataSource->descp1->SetValue($this->descp1->GetValue(true));
        $this->DataSource->read_l1->SetValue($this->read_l1->GetValue(true));
        $this->DataSource->speak_l1->SetValue($this->speak_l1->GetValue(true));
        $this->DataSource->write_l1->SetValue($this->write_l1->GetValue(true));
        $this->DataSource->descp2->SetValue($this->descp2->GetValue(true));
        $this->DataSource->read_l2->SetValue($this->read_l2->GetValue(true));
        $this->DataSource->speak_l2->SetValue($this->speak_l2->GetValue(true));
        $this->DataSource->write_l2->SetValue($this->write_l2->GetValue(true));
        $this->DataSource->descp3->SetValue($this->descp3->GetValue(true));
        $this->DataSource->read_l3->SetValue($this->read_l3->GetValue(true));
        $this->DataSource->speak_l3->SetValue($this->speak_l3->GetValue(true));
        $this->DataSource->write_l3->SetValue($this->write_l3->GetValue(true));
        $this->DataSource->descp4->SetValue($this->descp4->GetValue(true));
        $this->DataSource->read_l4->SetValue($this->read_l4->GetValue(true));
        $this->DataSource->speak_l4->SetValue($this->speak_l4->GetValue(true));
        $this->DataSource->write_l4->SetValue($this->write_l4->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @2-C2D3FC8D
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->descp->SetValue($this->descp->GetValue(true));
        $this->DataSource->read_l->SetValue($this->read_l->GetValue(true));
        $this->DataSource->speak_l->SetValue($this->speak_l->GetValue(true));
        $this->DataSource->write_l->SetValue($this->write_l->GetValue(true));
        $this->DataSource->descp1->SetValue($this->descp1->GetValue(true));
        $this->DataSource->read_l1->SetValue($this->read_l1->GetValue(true));
        $this->DataSource->speak_l1->SetValue($this->speak_l1->GetValue(true));
        $this->DataSource->write_l1->SetValue($this->write_l1->GetValue(true));
        $this->DataSource->descp2->SetValue($this->descp2->GetValue(true));
        $this->DataSource->read_l2->SetValue($this->read_l2->GetValue(true));
        $this->DataSource->speak_l2->SetValue($this->speak_l2->GetValue(true));
        $this->DataSource->write_l2->SetValue($this->write_l2->GetValue(true));
        $this->DataSource->descp3->SetValue($this->descp3->GetValue(true));
        $this->DataSource->read_l3->SetValue($this->read_l3->GetValue(true));
        $this->DataSource->speak_l3->SetValue($this->speak_l3->GetValue(true));
        $this->DataSource->write_l3->SetValue($this->write_l3->GetValue(true));
        $this->DataSource->descp4->SetValue($this->descp4->GetValue(true));
        $this->DataSource->read_l4->SetValue($this->read_l4->GetValue(true));
        $this->DataSource->speak_l4->SetValue($this->speak_l4->GetValue(true));
        $this->DataSource->write_l4->SetValue($this->write_l4->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @2-512B385B
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

        $this->read_l->Prepare();
        $this->speak_l->Prepare();
        $this->write_l->Prepare();
        $this->read_l1->Prepare();
        $this->speak_l1->Prepare();
        $this->write_l1->Prepare();
        $this->read_l2->Prepare();
        $this->speak_l2->Prepare();
        $this->write_l2->Prepare();
        $this->read_l3->Prepare();
        $this->speak_l3->Prepare();
        $this->write_l3->Prepare();
        $this->read_l4->Prepare();
        $this->speak_l4->Prepare();
        $this->write_l4->Prepare();

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
                    $this->descp->SetValue($this->DataSource->descp->GetValue());
                    $this->read_l->SetValue($this->DataSource->read_l->GetValue());
                    $this->speak_l->SetValue($this->DataSource->speak_l->GetValue());
                    $this->write_l->SetValue($this->DataSource->write_l->GetValue());
                    $this->descp1->SetValue($this->DataSource->descp1->GetValue());
                    $this->read_l1->SetValue($this->DataSource->read_l1->GetValue());
                    $this->speak_l1->SetValue($this->DataSource->speak_l1->GetValue());
                    $this->write_l1->SetValue($this->DataSource->write_l1->GetValue());
                    $this->descp2->SetValue($this->DataSource->descp2->GetValue());
                    $this->read_l2->SetValue($this->DataSource->read_l2->GetValue());
                    $this->speak_l2->SetValue($this->DataSource->speak_l2->GetValue());
                    $this->write_l2->SetValue($this->DataSource->write_l2->GetValue());
                    $this->descp3->SetValue($this->DataSource->descp3->GetValue());
                    $this->read_l3->SetValue($this->DataSource->read_l3->GetValue());
                    $this->speak_l3->SetValue($this->DataSource->speak_l3->GetValue());
                    $this->write_l3->SetValue($this->DataSource->write_l3->GetValue());
                    $this->descp4->SetValue($this->DataSource->descp4->GetValue());
                    $this->read_l4->SetValue($this->DataSource->read_l4->GetValue());
                    $this->speak_l4->SetValue($this->DataSource->speak_l4->GetValue());
                    $this->write_l4->SetValue($this->DataSource->write_l4->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->id_func->Errors->ToString());
            $Error = ComposeStrings($Error, $this->descp->Errors->ToString());
            $Error = ComposeStrings($Error, $this->read_l->Errors->ToString());
            $Error = ComposeStrings($Error, $this->speak_l->Errors->ToString());
            $Error = ComposeStrings($Error, $this->write_l->Errors->ToString());
            $Error = ComposeStrings($Error, $this->descp1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->read_l1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->speak_l1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->write_l1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->descp2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->read_l2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->speak_l2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->write_l2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->descp3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->read_l3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->speak_l3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->write_l3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->descp4->Errors->ToString());
            $Error = ComposeStrings($Error, $this->read_l4->Errors->ToString());
            $Error = ComposeStrings($Error, $this->speak_l4->Errors->ToString());
            $Error = ComposeStrings($Error, $this->write_l4->Errors->ToString());
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
        $this->descp->Show();
        $this->read_l->Show();
        $this->speak_l->Show();
        $this->write_l->Show();
        $this->descp1->Show();
        $this->read_l1->Show();
        $this->speak_l1->Show();
        $this->write_l1->Show();
        $this->descp2->Show();
        $this->read_l2->Show();
        $this->speak_l2->Show();
        $this->write_l2->Show();
        $this->descp3->Show();
        $this->read_l3->Show();
        $this->speak_l3->Show();
        $this->write_l3->Show();
        $this->descp4->Show();
        $this->read_l4->Show();
        $this->speak_l4->Show();
        $this->write_l4->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End lang_func Class @2-FCB6E20C

class clslang_funcDataSource extends clsDBmadnes {  //lang_funcDataSource Class @2-29D45B36

//DataSource Variables @2-F3F0FFA5
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
    public $descp;
    public $read_l;
    public $speak_l;
    public $write_l;
    public $descp1;
    public $read_l1;
    public $speak_l1;
    public $write_l1;
    public $descp2;
    public $read_l2;
    public $speak_l2;
    public $write_l2;
    public $descp3;
    public $read_l3;
    public $speak_l3;
    public $write_l3;
    public $descp4;
    public $read_l4;
    public $speak_l4;
    public $write_l4;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-B1147FF2
    function clslang_funcDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record lang_func/Error";
        $this->Initialize();
        $this->id_func = new clsField("id_func", ccsInteger, "");
        
        $this->descp = new clsField("descp", ccsText, "");
        
        $this->read_l = new clsField("read_l", ccsText, "");
        
        $this->speak_l = new clsField("speak_l", ccsText, "");
        
        $this->write_l = new clsField("write_l", ccsText, "");
        
        $this->descp1 = new clsField("descp1", ccsText, "");
        
        $this->read_l1 = new clsField("read_l1", ccsText, "");
        
        $this->speak_l1 = new clsField("speak_l1", ccsText, "");
        
        $this->write_l1 = new clsField("write_l1", ccsText, "");
        
        $this->descp2 = new clsField("descp2", ccsText, "");
        
        $this->read_l2 = new clsField("read_l2", ccsText, "");
        
        $this->speak_l2 = new clsField("speak_l2", ccsText, "");
        
        $this->write_l2 = new clsField("write_l2", ccsText, "");
        
        $this->descp3 = new clsField("descp3", ccsText, "");
        
        $this->read_l3 = new clsField("read_l3", ccsText, "");
        
        $this->speak_l3 = new clsField("speak_l3", ccsText, "");
        
        $this->write_l3 = new clsField("write_l3", ccsText, "");
        
        $this->descp4 = new clsField("descp4", ccsText, "");
        
        $this->read_l4 = new clsField("read_l4", ccsText, "");
        
        $this->speak_l4 = new clsField("speak_l4", ccsText, "");
        
        $this->write_l4 = new clsField("write_l4", ccsText, "");
        

        $this->InsertFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["descp"] = array("Name" => "descp", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["read_l"] = array("Name" => "read_l", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["speak_l"] = array("Name" => "speak_l", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["write_l"] = array("Name" => "write_l", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["descp1"] = array("Name" => "descp1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["read_l1"] = array("Name" => "read_l1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["speak_l1"] = array("Name" => "speak_l1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["write_l1"] = array("Name" => "write_l1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["descp2"] = array("Name" => "descp2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["read_l2"] = array("Name" => "read_l2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["speak_l2"] = array("Name" => "speak_l2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["write_l2"] = array("Name" => "write_l2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["descp3"] = array("Name" => "descp3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["read_l3"] = array("Name" => "read_l3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["speak_l3"] = array("Name" => "speak_l3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["write_l3"] = array("Name" => "write_l3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["descp4"] = array("Name" => "descp4", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["read_l4"] = array("Name" => "read_l4", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["speak_l4"] = array("Name" => "speak_l4", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["write_l4"] = array("Name" => "write_l4", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["descp"] = array("Name" => "descp", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["read_l"] = array("Name" => "read_l", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["speak_l"] = array("Name" => "speak_l", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["write_l"] = array("Name" => "write_l", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["descp1"] = array("Name" => "descp1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["read_l1"] = array("Name" => "read_l1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["speak_l1"] = array("Name" => "speak_l1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["write_l1"] = array("Name" => "write_l1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["descp2"] = array("Name" => "descp2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["read_l2"] = array("Name" => "read_l2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["speak_l2"] = array("Name" => "speak_l2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["write_l2"] = array("Name" => "write_l2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["descp3"] = array("Name" => "descp3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["read_l3"] = array("Name" => "read_l3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["speak_l3"] = array("Name" => "speak_l3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["write_l3"] = array("Name" => "write_l3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["descp4"] = array("Name" => "descp4", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["read_l4"] = array("Name" => "read_l4", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["speak_l4"] = array("Name" => "speak_l4", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["write_l4"] = array("Name" => "write_l4", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-1E5AB59C
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_func", ccsInteger, "", "", $this->Parameters["urlid_func"], xxxxxx, false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_func", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-F3719E73
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT *, id_lang \n\n" .
        "FROM lang_func {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-CAF6E121
    function SetValues()
    {
        $this->id_func->SetDBValue(trim($this->f("id_func")));
        $this->descp->SetDBValue($this->f("descp"));
        $this->read_l->SetDBValue($this->f("read_l"));
        $this->speak_l->SetDBValue($this->f("speak_l"));
        $this->write_l->SetDBValue($this->f("write_l"));
        $this->descp1->SetDBValue($this->f("descp1"));
        $this->read_l1->SetDBValue($this->f("read_l1"));
        $this->speak_l1->SetDBValue($this->f("speak_l1"));
        $this->write_l1->SetDBValue($this->f("write_l1"));
        $this->descp2->SetDBValue($this->f("descp2"));
        $this->read_l2->SetDBValue($this->f("read_l2"));
        $this->speak_l2->SetDBValue($this->f("speak_l2"));
        $this->write_l2->SetDBValue($this->f("write_l2"));
        $this->descp3->SetDBValue($this->f("descp3"));
        $this->read_l3->SetDBValue($this->f("read_l3"));
        $this->speak_l3->SetDBValue($this->f("speak_l3"));
        $this->write_l3->SetDBValue($this->f("write_l3"));
        $this->descp4->SetDBValue($this->f("descp4"));
        $this->read_l4->SetDBValue($this->f("read_l4"));
        $this->speak_l4->SetDBValue($this->f("speak_l4"));
        $this->write_l4->SetDBValue($this->f("write_l4"));
    }
//End SetValues Method

//Insert Method @2-59EEE96D
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->InsertFields["descp"]["Value"] = $this->descp->GetDBValue(true);
        $this->InsertFields["read_l"]["Value"] = $this->read_l->GetDBValue(true);
        $this->InsertFields["speak_l"]["Value"] = $this->speak_l->GetDBValue(true);
        $this->InsertFields["write_l"]["Value"] = $this->write_l->GetDBValue(true);
        $this->InsertFields["descp1"]["Value"] = $this->descp1->GetDBValue(true);
        $this->InsertFields["read_l1"]["Value"] = $this->read_l1->GetDBValue(true);
        $this->InsertFields["speak_l1"]["Value"] = $this->speak_l1->GetDBValue(true);
        $this->InsertFields["write_l1"]["Value"] = $this->write_l1->GetDBValue(true);
        $this->InsertFields["descp2"]["Value"] = $this->descp2->GetDBValue(true);
        $this->InsertFields["read_l2"]["Value"] = $this->read_l2->GetDBValue(true);
        $this->InsertFields["speak_l2"]["Value"] = $this->speak_l2->GetDBValue(true);
        $this->InsertFields["write_l2"]["Value"] = $this->write_l2->GetDBValue(true);
        $this->InsertFields["descp3"]["Value"] = $this->descp3->GetDBValue(true);
        $this->InsertFields["read_l3"]["Value"] = $this->read_l3->GetDBValue(true);
        $this->InsertFields["speak_l3"]["Value"] = $this->speak_l3->GetDBValue(true);
        $this->InsertFields["write_l3"]["Value"] = $this->write_l3->GetDBValue(true);
        $this->InsertFields["descp4"]["Value"] = $this->descp4->GetDBValue(true);
        $this->InsertFields["read_l4"]["Value"] = $this->read_l4->GetDBValue(true);
        $this->InsertFields["speak_l4"]["Value"] = $this->speak_l4->GetDBValue(true);
        $this->InsertFields["write_l4"]["Value"] = $this->write_l4->GetDBValue(true);
        $this->SQL = CCBuildInsert("lang_func", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-41AB4CC8
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->UpdateFields["descp"]["Value"] = $this->descp->GetDBValue(true);
        $this->UpdateFields["read_l"]["Value"] = $this->read_l->GetDBValue(true);
        $this->UpdateFields["speak_l"]["Value"] = $this->speak_l->GetDBValue(true);
        $this->UpdateFields["write_l"]["Value"] = $this->write_l->GetDBValue(true);
        $this->UpdateFields["descp1"]["Value"] = $this->descp1->GetDBValue(true);
        $this->UpdateFields["read_l1"]["Value"] = $this->read_l1->GetDBValue(true);
        $this->UpdateFields["speak_l1"]["Value"] = $this->speak_l1->GetDBValue(true);
        $this->UpdateFields["write_l1"]["Value"] = $this->write_l1->GetDBValue(true);
        $this->UpdateFields["descp2"]["Value"] = $this->descp2->GetDBValue(true);
        $this->UpdateFields["read_l2"]["Value"] = $this->read_l2->GetDBValue(true);
        $this->UpdateFields["speak_l2"]["Value"] = $this->speak_l2->GetDBValue(true);
        $this->UpdateFields["write_l2"]["Value"] = $this->write_l2->GetDBValue(true);
        $this->UpdateFields["descp3"]["Value"] = $this->descp3->GetDBValue(true);
        $this->UpdateFields["read_l3"]["Value"] = $this->read_l3->GetDBValue(true);
        $this->UpdateFields["speak_l3"]["Value"] = $this->speak_l3->GetDBValue(true);
        $this->UpdateFields["write_l3"]["Value"] = $this->write_l3->GetDBValue(true);
        $this->UpdateFields["descp4"]["Value"] = $this->descp4->GetDBValue(true);
        $this->UpdateFields["read_l4"]["Value"] = $this->read_l4->GetDBValue(true);
        $this->UpdateFields["speak_l4"]["Value"] = $this->speak_l4->GetDBValue(true);
        $this->UpdateFields["write_l4"]["Value"] = $this->write_l4->GetDBValue(true);
        $this->SQL = CCBuildUpdate("lang_func", $this->UpdateFields, $this);
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

} //End lang_funcDataSource Class @2-FCB6E20C

class clsRecordot_con { //ot_con Class @34-375505BA

//Variables @34-9E315808

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

//Class_Initialize Event @34-10B32D6C
    function clsRecordot_con($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record ot_con/Error";
        $this->DataSource = new clsot_conDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "ot_con";
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
            $this->desc_o = new clsControl(ccsTextBox, "desc_o", "Desc O", ccsText, "", CCGetRequestParam("desc_o", $Method, NULL), $this);
            $this->level = new clsControl(ccsListBox, "level", "Level", ccsText, "", CCGetRequestParam("level", $Method, NULL), $this);
            $this->level->DSType = dsTable;
            $this->level->DataSource = new clsDBmadnes();
            $this->level->ds = & $this->level->DataSource;
            $this->level->DataSource->SQL = "SELECT * \n" .
"FROM nivel_lang {SQL_Where} {SQL_OrderBy}";
            list($this->level->BoundColumn, $this->level->TextColumn, $this->level->DBFormat) = array("desc_nLang", "desc_nLang", "");
            $this->desc_o1 = new clsControl(ccsTextBox, "desc_o1", "Desc O1", ccsText, "", CCGetRequestParam("desc_o1", $Method, NULL), $this);
            $this->level1 = new clsControl(ccsListBox, "level1", "Level1", ccsText, "", CCGetRequestParam("level1", $Method, NULL), $this);
            $this->level1->DSType = dsTable;
            $this->level1->DataSource = new clsDBmadnes();
            $this->level1->ds = & $this->level1->DataSource;
            $this->level1->DataSource->SQL = "SELECT * \n" .
"FROM nivel_lang {SQL_Where} {SQL_OrderBy}";
            list($this->level1->BoundColumn, $this->level1->TextColumn, $this->level1->DBFormat) = array("desc_nLang", "desc_nLang", "");
            $this->desc_o2 = new clsControl(ccsTextBox, "desc_o2", "Desc O2", ccsText, "", CCGetRequestParam("desc_o2", $Method, NULL), $this);
            $this->level2 = new clsControl(ccsListBox, "level2", "Level2", ccsText, "", CCGetRequestParam("level2", $Method, NULL), $this);
            $this->level2->DSType = dsTable;
            $this->level2->DataSource = new clsDBmadnes();
            $this->level2->ds = & $this->level2->DataSource;
            $this->level2->DataSource->SQL = "SELECT * \n" .
"FROM nivel_lang {SQL_Where} {SQL_OrderBy}";
            list($this->level2->BoundColumn, $this->level2->TextColumn, $this->level2->DBFormat) = array("desc_nLang", "desc_nLang", "");
            $this->desc_o3 = new clsControl(ccsTextBox, "desc_o3", "Desc O3", ccsText, "", CCGetRequestParam("desc_o3", $Method, NULL), $this);
            $this->level3 = new clsControl(ccsListBox, "level3", "Level3", ccsText, "", CCGetRequestParam("level3", $Method, NULL), $this);
            $this->level3->DSType = dsTable;
            $this->level3->DataSource = new clsDBmadnes();
            $this->level3->ds = & $this->level3->DataSource;
            $this->level3->DataSource->SQL = "SELECT * \n" .
"FROM nivel_lang {SQL_Where} {SQL_OrderBy}";
            list($this->level3->BoundColumn, $this->level3->TextColumn, $this->level3->DBFormat) = array("desc_nLang", "desc_nLang", "");
            $this->desc_o4 = new clsControl(ccsTextBox, "desc_o4", "Desc O4", ccsText, "", CCGetRequestParam("desc_o4", $Method, NULL), $this);
            $this->level4 = new clsControl(ccsListBox, "level4", "Level4", ccsText, "", CCGetRequestParam("level4", $Method, NULL), $this);
            $this->level4->DSType = dsTable;
            $this->level4->DataSource = new clsDBmadnes();
            $this->level4->ds = & $this->level4->DataSource;
            $this->level4->DataSource->SQL = "SELECT * \n" .
"FROM nivel_lang {SQL_Where} {SQL_OrderBy}";
            list($this->level4->BoundColumn, $this->level4->TextColumn, $this->level4->DBFormat) = array("desc_nLang", "desc_nLang", "");
        }
    }
//End Class_Initialize Event

//Initialize Method @34-BCDB0946
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_func"] = CCGetFromGet("id_func", NULL);
    }
//End Initialize Method

//Validate Method @34-E4B7B448
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->id_func->Validate() && $Validation);
        $Validation = ($this->desc_o->Validate() && $Validation);
        $Validation = ($this->level->Validate() && $Validation);
        $Validation = ($this->desc_o1->Validate() && $Validation);
        $Validation = ($this->level1->Validate() && $Validation);
        $Validation = ($this->desc_o2->Validate() && $Validation);
        $Validation = ($this->level2->Validate() && $Validation);
        $Validation = ($this->desc_o3->Validate() && $Validation);
        $Validation = ($this->level3->Validate() && $Validation);
        $Validation = ($this->desc_o4->Validate() && $Validation);
        $Validation = ($this->level4->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->id_func->Errors->Count() == 0);
        $Validation =  $Validation && ($this->desc_o->Errors->Count() == 0);
        $Validation =  $Validation && ($this->level->Errors->Count() == 0);
        $Validation =  $Validation && ($this->desc_o1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->level1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->desc_o2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->level2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->desc_o3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->level3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->desc_o4->Errors->Count() == 0);
        $Validation =  $Validation && ($this->level4->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @34-7ABA16DA
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->id_func->Errors->Count());
        $errors = ($errors || $this->desc_o->Errors->Count());
        $errors = ($errors || $this->level->Errors->Count());
        $errors = ($errors || $this->desc_o1->Errors->Count());
        $errors = ($errors || $this->level1->Errors->Count());
        $errors = ($errors || $this->desc_o2->Errors->Count());
        $errors = ($errors || $this->level2->Errors->Count());
        $errors = ($errors || $this->desc_o3->Errors->Count());
        $errors = ($errors || $this->level3->Errors->Count());
        $errors = ($errors || $this->desc_o4->Errors->Count());
        $errors = ($errors || $this->level4->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @34-0BF2B389
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

//InsertRow Method @34-9ED34000
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->desc_o->SetValue($this->desc_o->GetValue(true));
        $this->DataSource->level->SetValue($this->level->GetValue(true));
        $this->DataSource->desc_o1->SetValue($this->desc_o1->GetValue(true));
        $this->DataSource->level1->SetValue($this->level1->GetValue(true));
        $this->DataSource->desc_o2->SetValue($this->desc_o2->GetValue(true));
        $this->DataSource->level2->SetValue($this->level2->GetValue(true));
        $this->DataSource->desc_o3->SetValue($this->desc_o3->GetValue(true));
        $this->DataSource->level3->SetValue($this->level3->GetValue(true));
        $this->DataSource->desc_o4->SetValue($this->desc_o4->GetValue(true));
        $this->DataSource->level4->SetValue($this->level4->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @34-482C24D5
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->desc_o->SetValue($this->desc_o->GetValue(true));
        $this->DataSource->level->SetValue($this->level->GetValue(true));
        $this->DataSource->desc_o1->SetValue($this->desc_o1->GetValue(true));
        $this->DataSource->level1->SetValue($this->level1->GetValue(true));
        $this->DataSource->desc_o2->SetValue($this->desc_o2->GetValue(true));
        $this->DataSource->level2->SetValue($this->level2->GetValue(true));
        $this->DataSource->desc_o3->SetValue($this->desc_o3->GetValue(true));
        $this->DataSource->level3->SetValue($this->level3->GetValue(true));
        $this->DataSource->desc_o4->SetValue($this->desc_o4->GetValue(true));
        $this->DataSource->level4->SetValue($this->level4->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @34-FBD019D7
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

        $this->level->Prepare();
        $this->level1->Prepare();
        $this->level2->Prepare();
        $this->level3->Prepare();
        $this->level4->Prepare();

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
                    $this->desc_o->SetValue($this->DataSource->desc_o->GetValue());
                    $this->level->SetValue($this->DataSource->level->GetValue());
                    $this->desc_o1->SetValue($this->DataSource->desc_o1->GetValue());
                    $this->level1->SetValue($this->DataSource->level1->GetValue());
                    $this->desc_o2->SetValue($this->DataSource->desc_o2->GetValue());
                    $this->level2->SetValue($this->DataSource->level2->GetValue());
                    $this->desc_o3->SetValue($this->DataSource->desc_o3->GetValue());
                    $this->level3->SetValue($this->DataSource->level3->GetValue());
                    $this->desc_o4->SetValue($this->DataSource->desc_o4->GetValue());
                    $this->level4->SetValue($this->DataSource->level4->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->id_func->Errors->ToString());
            $Error = ComposeStrings($Error, $this->desc_o->Errors->ToString());
            $Error = ComposeStrings($Error, $this->level->Errors->ToString());
            $Error = ComposeStrings($Error, $this->desc_o1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->level1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->desc_o2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->level2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->desc_o3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->level3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->desc_o4->Errors->ToString());
            $Error = ComposeStrings($Error, $this->level4->Errors->ToString());
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
        $this->desc_o->Show();
        $this->level->Show();
        $this->desc_o1->Show();
        $this->level1->Show();
        $this->desc_o2->Show();
        $this->level2->Show();
        $this->desc_o3->Show();
        $this->level3->Show();
        $this->desc_o4->Show();
        $this->level4->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End ot_con Class @34-FCB6E20C

class clsot_conDataSource extends clsDBmadnes {  //ot_conDataSource Class @34-EB6AFBA5

//DataSource Variables @34-F355CA63
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
    public $desc_o;
    public $level;
    public $desc_o1;
    public $level1;
    public $desc_o2;
    public $level2;
    public $desc_o3;
    public $level3;
    public $desc_o4;
    public $level4;
//End DataSource Variables

//DataSourceClass_Initialize Event @34-6CF216CC
    function clsot_conDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record ot_con/Error";
        $this->Initialize();
        $this->id_func = new clsField("id_func", ccsInteger, "");
        
        $this->desc_o = new clsField("desc_o", ccsText, "");
        
        $this->level = new clsField("level", ccsText, "");
        
        $this->desc_o1 = new clsField("desc_o1", ccsText, "");
        
        $this->level1 = new clsField("level1", ccsText, "");
        
        $this->desc_o2 = new clsField("desc_o2", ccsText, "");
        
        $this->level2 = new clsField("level2", ccsText, "");
        
        $this->desc_o3 = new clsField("desc_o3", ccsText, "");
        
        $this->level3 = new clsField("level3", ccsText, "");
        
        $this->desc_o4 = new clsField("desc_o4", ccsText, "");
        
        $this->level4 = new clsField("level4", ccsText, "");
        

        $this->InsertFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["desc_o"] = array("Name" => "desc_o", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["level"] = array("Name" => "level", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["desc_o1"] = array("Name" => "desc_o1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["level1"] = array("Name" => "level1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["desc_o2"] = array("Name" => "desc_o2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["level2"] = array("Name" => "level2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["desc_o3"] = array("Name" => "desc_o3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["level3"] = array("Name" => "level3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["desc_o4"] = array("Name" => "desc_o4", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["level4"] = array("Name" => "level4", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["desc_o"] = array("Name" => "desc_o", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["level"] = array("Name" => "level", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["desc_o1"] = array("Name" => "desc_o1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["level1"] = array("Name" => "level1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["desc_o2"] = array("Name" => "desc_o2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["level2"] = array("Name" => "level2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["desc_o3"] = array("Name" => "desc_o3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["level3"] = array("Name" => "level3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["desc_o4"] = array("Name" => "desc_o4", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["level4"] = array("Name" => "level4", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @34-1E5AB59C
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_func", ccsInteger, "", "", $this->Parameters["urlid_func"], xxxxxx, false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_func", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @34-159E677E
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT *, id_ot_con \n\n" .
        "FROM ot_con {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @34-D312E6FE
    function SetValues()
    {
        $this->id_func->SetDBValue(trim($this->f("id_func")));
        $this->desc_o->SetDBValue($this->f("desc_o"));
        $this->level->SetDBValue($this->f("level"));
        $this->desc_o1->SetDBValue($this->f("desc_o1"));
        $this->level1->SetDBValue($this->f("level1"));
        $this->desc_o2->SetDBValue($this->f("desc_o2"));
        $this->level2->SetDBValue($this->f("level2"));
        $this->desc_o3->SetDBValue($this->f("desc_o3"));
        $this->level3->SetDBValue($this->f("level3"));
        $this->desc_o4->SetDBValue($this->f("desc_o4"));
        $this->level4->SetDBValue($this->f("level4"));
    }
//End SetValues Method

//Insert Method @34-03432619
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->InsertFields["desc_o"]["Value"] = $this->desc_o->GetDBValue(true);
        $this->InsertFields["level"]["Value"] = $this->level->GetDBValue(true);
        $this->InsertFields["desc_o1"]["Value"] = $this->desc_o1->GetDBValue(true);
        $this->InsertFields["level1"]["Value"] = $this->level1->GetDBValue(true);
        $this->InsertFields["desc_o2"]["Value"] = $this->desc_o2->GetDBValue(true);
        $this->InsertFields["level2"]["Value"] = $this->level2->GetDBValue(true);
        $this->InsertFields["desc_o3"]["Value"] = $this->desc_o3->GetDBValue(true);
        $this->InsertFields["level3"]["Value"] = $this->level3->GetDBValue(true);
        $this->InsertFields["desc_o4"]["Value"] = $this->desc_o4->GetDBValue(true);
        $this->InsertFields["level4"]["Value"] = $this->level4->GetDBValue(true);
        $this->SQL = CCBuildInsert("ot_con", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @34-809B7A81
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->UpdateFields["desc_o"]["Value"] = $this->desc_o->GetDBValue(true);
        $this->UpdateFields["level"]["Value"] = $this->level->GetDBValue(true);
        $this->UpdateFields["desc_o1"]["Value"] = $this->desc_o1->GetDBValue(true);
        $this->UpdateFields["level1"]["Value"] = $this->level1->GetDBValue(true);
        $this->UpdateFields["desc_o2"]["Value"] = $this->desc_o2->GetDBValue(true);
        $this->UpdateFields["level2"]["Value"] = $this->level2->GetDBValue(true);
        $this->UpdateFields["desc_o3"]["Value"] = $this->desc_o3->GetDBValue(true);
        $this->UpdateFields["level3"]["Value"] = $this->level3->GetDBValue(true);
        $this->UpdateFields["desc_o4"]["Value"] = $this->desc_o4->GetDBValue(true);
        $this->UpdateFields["level4"]["Value"] = $this->level4->GetDBValue(true);
        $this->SQL = CCBuildUpdate("ot_con", $this->UpdateFields, $this);
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

} //End ot_conDataSource Class @34-FCB6E20C

class clsRecorddoc_uni { //doc_uni Class @60-56DCC9B5

//Variables @60-9E315808

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

//Class_Initialize Event @60-3D2FED7A
    function clsRecorddoc_uni($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record doc_uni/Error";
        $this->DataSource = new clsdoc_uniDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "doc_uni";
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
            $this->univ = new clsControl(ccsTextBox, "univ", "Univ", ccsText, "", CCGetRequestParam("univ", $Method, NULL), $this);
            $this->asign = new clsControl(ccsTextBox, "asign", "Asign", ccsText, "", CCGetRequestParam("asign", $Method, NULL), $this);
            $this->career = new clsControl(ccsTextBox, "career", "Career", ccsText, "", CCGetRequestParam("career", $Method, NULL), $this);
            $this->date_start = new clsControl(ccsTextBox, "date_start", "Date Start", ccsDate, array("ShortDate"), CCGetRequestParam("date_start", $Method, NULL), $this);
            $this->date_end = new clsControl(ccsTextBox, "date_end", "Date End", ccsDate, array("ShortDate"), CCGetRequestParam("date_end", $Method, NULL), $this);
            $this->univ1 = new clsControl(ccsTextBox, "univ1", "Univ1", ccsText, "", CCGetRequestParam("univ1", $Method, NULL), $this);
            $this->asign1 = new clsControl(ccsTextBox, "asign1", "Asign1", ccsText, "", CCGetRequestParam("asign1", $Method, NULL), $this);
            $this->career1 = new clsControl(ccsTextBox, "career1", "Career1", ccsText, "", CCGetRequestParam("career1", $Method, NULL), $this);
            $this->date_start1 = new clsControl(ccsTextBox, "date_start1", "Date Start1", ccsDate, array("ShortDate"), CCGetRequestParam("date_start1", $Method, NULL), $this);
            $this->date_end1 = new clsControl(ccsTextBox, "date_end1", "Date End1", ccsDate, array("ShortDate"), CCGetRequestParam("date_end1", $Method, NULL), $this);
            $this->univ2 = new clsControl(ccsTextBox, "univ2", "Univ2", ccsText, "", CCGetRequestParam("univ2", $Method, NULL), $this);
            $this->asign2 = new clsControl(ccsTextBox, "asign2", "Asign2", ccsText, "", CCGetRequestParam("asign2", $Method, NULL), $this);
            $this->career2 = new clsControl(ccsTextBox, "career2", "Career2", ccsText, "", CCGetRequestParam("career2", $Method, NULL), $this);
            $this->date_start2 = new clsControl(ccsTextBox, "date_start2", "Date Start2", ccsDate, array("ShortDate"), CCGetRequestParam("date_start2", $Method, NULL), $this);
            $this->date_end2 = new clsControl(ccsTextBox, "date_end2", "Date End2", ccsDate, array("ShortDate"), CCGetRequestParam("date_end2", $Method, NULL), $this);
            $this->univ3 = new clsControl(ccsTextBox, "univ3", "Univ3", ccsText, "", CCGetRequestParam("univ3", $Method, NULL), $this);
            $this->asign3 = new clsControl(ccsTextBox, "asign3", "Asign3", ccsText, "", CCGetRequestParam("asign3", $Method, NULL), $this);
            $this->career3 = new clsControl(ccsTextBox, "career3", "Career3", ccsText, "", CCGetRequestParam("career3", $Method, NULL), $this);
            $this->date_start3 = new clsControl(ccsTextBox, "date_start3", "Date Start3", ccsDate, array("ShortDate"), CCGetRequestParam("date_start3", $Method, NULL), $this);
            $this->date_end3 = new clsControl(ccsTextBox, "date_end3", "Date End3", ccsDate, array("ShortDate"), CCGetRequestParam("date_end3", $Method, NULL), $this);
            $this->univ4 = new clsControl(ccsTextBox, "univ4", "Univ4", ccsText, "", CCGetRequestParam("univ4", $Method, NULL), $this);
            $this->asign4 = new clsControl(ccsTextBox, "asign4", "Asign4", ccsText, "", CCGetRequestParam("asign4", $Method, NULL), $this);
            $this->career4 = new clsControl(ccsTextBox, "career4", "Career4", ccsText, "", CCGetRequestParam("career4", $Method, NULL), $this);
            $this->date_start4 = new clsControl(ccsTextBox, "date_start4", "Date Start4", ccsDate, array("ShortDate"), CCGetRequestParam("date_start4", $Method, NULL), $this);
            $this->date_end4 = new clsControl(ccsTextBox, "date_end4", "Date End4", ccsDate, array("ShortDate"), CCGetRequestParam("date_end4", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @60-BCDB0946
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_func"] = CCGetFromGet("id_func", NULL);
    }
//End Initialize Method

//Validate Method @60-5F633110
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->id_func->Validate() && $Validation);
        $Validation = ($this->univ->Validate() && $Validation);
        $Validation = ($this->asign->Validate() && $Validation);
        $Validation = ($this->career->Validate() && $Validation);
        $Validation = ($this->date_start->Validate() && $Validation);
        $Validation = ($this->date_end->Validate() && $Validation);
        $Validation = ($this->univ1->Validate() && $Validation);
        $Validation = ($this->asign1->Validate() && $Validation);
        $Validation = ($this->career1->Validate() && $Validation);
        $Validation = ($this->date_start1->Validate() && $Validation);
        $Validation = ($this->date_end1->Validate() && $Validation);
        $Validation = ($this->univ2->Validate() && $Validation);
        $Validation = ($this->asign2->Validate() && $Validation);
        $Validation = ($this->career2->Validate() && $Validation);
        $Validation = ($this->date_start2->Validate() && $Validation);
        $Validation = ($this->date_end2->Validate() && $Validation);
        $Validation = ($this->univ3->Validate() && $Validation);
        $Validation = ($this->asign3->Validate() && $Validation);
        $Validation = ($this->career3->Validate() && $Validation);
        $Validation = ($this->date_start3->Validate() && $Validation);
        $Validation = ($this->date_end3->Validate() && $Validation);
        $Validation = ($this->univ4->Validate() && $Validation);
        $Validation = ($this->asign4->Validate() && $Validation);
        $Validation = ($this->career4->Validate() && $Validation);
        $Validation = ($this->date_start4->Validate() && $Validation);
        $Validation = ($this->date_end4->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->id_func->Errors->Count() == 0);
        $Validation =  $Validation && ($this->univ->Errors->Count() == 0);
        $Validation =  $Validation && ($this->asign->Errors->Count() == 0);
        $Validation =  $Validation && ($this->career->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_start->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_end->Errors->Count() == 0);
        $Validation =  $Validation && ($this->univ1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->asign1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->career1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_start1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_end1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->univ2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->asign2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->career2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_start2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_end2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->univ3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->asign3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->career3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_start3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_end3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->univ4->Errors->Count() == 0);
        $Validation =  $Validation && ($this->asign4->Errors->Count() == 0);
        $Validation =  $Validation && ($this->career4->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_start4->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_end4->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @60-C948521D
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->id_func->Errors->Count());
        $errors = ($errors || $this->univ->Errors->Count());
        $errors = ($errors || $this->asign->Errors->Count());
        $errors = ($errors || $this->career->Errors->Count());
        $errors = ($errors || $this->date_start->Errors->Count());
        $errors = ($errors || $this->date_end->Errors->Count());
        $errors = ($errors || $this->univ1->Errors->Count());
        $errors = ($errors || $this->asign1->Errors->Count());
        $errors = ($errors || $this->career1->Errors->Count());
        $errors = ($errors || $this->date_start1->Errors->Count());
        $errors = ($errors || $this->date_end1->Errors->Count());
        $errors = ($errors || $this->univ2->Errors->Count());
        $errors = ($errors || $this->asign2->Errors->Count());
        $errors = ($errors || $this->career2->Errors->Count());
        $errors = ($errors || $this->date_start2->Errors->Count());
        $errors = ($errors || $this->date_end2->Errors->Count());
        $errors = ($errors || $this->univ3->Errors->Count());
        $errors = ($errors || $this->asign3->Errors->Count());
        $errors = ($errors || $this->career3->Errors->Count());
        $errors = ($errors || $this->date_start3->Errors->Count());
        $errors = ($errors || $this->date_end3->Errors->Count());
        $errors = ($errors || $this->univ4->Errors->Count());
        $errors = ($errors || $this->asign4->Errors->Count());
        $errors = ($errors || $this->career4->Errors->Count());
        $errors = ($errors || $this->date_start4->Errors->Count());
        $errors = ($errors || $this->date_end4->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @60-0BF2B389
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

//InsertRow Method @60-9D6EFC5F
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->univ->SetValue($this->univ->GetValue(true));
        $this->DataSource->asign->SetValue($this->asign->GetValue(true));
        $this->DataSource->career->SetValue($this->career->GetValue(true));
        $this->DataSource->date_start->SetValue($this->date_start->GetValue(true));
        $this->DataSource->date_end->SetValue($this->date_end->GetValue(true));
        $this->DataSource->univ1->SetValue($this->univ1->GetValue(true));
        $this->DataSource->asign1->SetValue($this->asign1->GetValue(true));
        $this->DataSource->career1->SetValue($this->career1->GetValue(true));
        $this->DataSource->date_start1->SetValue($this->date_start1->GetValue(true));
        $this->DataSource->date_end1->SetValue($this->date_end1->GetValue(true));
        $this->DataSource->univ2->SetValue($this->univ2->GetValue(true));
        $this->DataSource->asign2->SetValue($this->asign2->GetValue(true));
        $this->DataSource->career2->SetValue($this->career2->GetValue(true));
        $this->DataSource->date_start2->SetValue($this->date_start2->GetValue(true));
        $this->DataSource->date_end2->SetValue($this->date_end2->GetValue(true));
        $this->DataSource->univ3->SetValue($this->univ3->GetValue(true));
        $this->DataSource->asign3->SetValue($this->asign3->GetValue(true));
        $this->DataSource->career3->SetValue($this->career3->GetValue(true));
        $this->DataSource->date_start3->SetValue($this->date_start3->GetValue(true));
        $this->DataSource->date_end3->SetValue($this->date_end3->GetValue(true));
        $this->DataSource->univ4->SetValue($this->univ4->GetValue(true));
        $this->DataSource->asign4->SetValue($this->asign4->GetValue(true));
        $this->DataSource->career4->SetValue($this->career4->GetValue(true));
        $this->DataSource->date_start4->SetValue($this->date_start4->GetValue(true));
        $this->DataSource->date_end4->SetValue($this->date_end4->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @60-1366230C
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->id_func->SetValue($this->id_func->GetValue(true));
        $this->DataSource->univ->SetValue($this->univ->GetValue(true));
        $this->DataSource->asign->SetValue($this->asign->GetValue(true));
        $this->DataSource->career->SetValue($this->career->GetValue(true));
        $this->DataSource->date_start->SetValue($this->date_start->GetValue(true));
        $this->DataSource->date_end->SetValue($this->date_end->GetValue(true));
        $this->DataSource->univ1->SetValue($this->univ1->GetValue(true));
        $this->DataSource->asign1->SetValue($this->asign1->GetValue(true));
        $this->DataSource->career1->SetValue($this->career1->GetValue(true));
        $this->DataSource->date_start1->SetValue($this->date_start1->GetValue(true));
        $this->DataSource->date_end1->SetValue($this->date_end1->GetValue(true));
        $this->DataSource->univ2->SetValue($this->univ2->GetValue(true));
        $this->DataSource->asign2->SetValue($this->asign2->GetValue(true));
        $this->DataSource->career2->SetValue($this->career2->GetValue(true));
        $this->DataSource->date_start2->SetValue($this->date_start2->GetValue(true));
        $this->DataSource->date_end2->SetValue($this->date_end2->GetValue(true));
        $this->DataSource->univ3->SetValue($this->univ3->GetValue(true));
        $this->DataSource->asign3->SetValue($this->asign3->GetValue(true));
        $this->DataSource->career3->SetValue($this->career3->GetValue(true));
        $this->DataSource->date_start3->SetValue($this->date_start3->GetValue(true));
        $this->DataSource->date_end3->SetValue($this->date_end3->GetValue(true));
        $this->DataSource->univ4->SetValue($this->univ4->GetValue(true));
        $this->DataSource->asign4->SetValue($this->asign4->GetValue(true));
        $this->DataSource->career4->SetValue($this->career4->GetValue(true));
        $this->DataSource->date_start4->SetValue($this->date_start4->GetValue(true));
        $this->DataSource->date_end4->SetValue($this->date_end4->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @60-C1789E82
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
                    $this->univ->SetValue($this->DataSource->univ->GetValue());
                    $this->asign->SetValue($this->DataSource->asign->GetValue());
                    $this->career->SetValue($this->DataSource->career->GetValue());
                    $this->date_start->SetValue($this->DataSource->date_start->GetValue());
                    $this->date_end->SetValue($this->DataSource->date_end->GetValue());
                    $this->univ1->SetValue($this->DataSource->univ1->GetValue());
                    $this->asign1->SetValue($this->DataSource->asign1->GetValue());
                    $this->career1->SetValue($this->DataSource->career1->GetValue());
                    $this->date_start1->SetValue($this->DataSource->date_start1->GetValue());
                    $this->date_end1->SetValue($this->DataSource->date_end1->GetValue());
                    $this->univ2->SetValue($this->DataSource->univ2->GetValue());
                    $this->asign2->SetValue($this->DataSource->asign2->GetValue());
                    $this->career2->SetValue($this->DataSource->career2->GetValue());
                    $this->date_start2->SetValue($this->DataSource->date_start2->GetValue());
                    $this->date_end2->SetValue($this->DataSource->date_end2->GetValue());
                    $this->univ3->SetValue($this->DataSource->univ3->GetValue());
                    $this->asign3->SetValue($this->DataSource->asign3->GetValue());
                    $this->career3->SetValue($this->DataSource->career3->GetValue());
                    $this->date_start3->SetValue($this->DataSource->date_start3->GetValue());
                    $this->date_end3->SetValue($this->DataSource->date_end3->GetValue());
                    $this->univ4->SetValue($this->DataSource->univ4->GetValue());
                    $this->asign4->SetValue($this->DataSource->asign4->GetValue());
                    $this->career4->SetValue($this->DataSource->career4->GetValue());
                    $this->date_start4->SetValue($this->DataSource->date_start4->GetValue());
                    $this->date_end4->SetValue($this->DataSource->date_end4->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->id_func->Errors->ToString());
            $Error = ComposeStrings($Error, $this->univ->Errors->ToString());
            $Error = ComposeStrings($Error, $this->asign->Errors->ToString());
            $Error = ComposeStrings($Error, $this->career->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_start->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_end->Errors->ToString());
            $Error = ComposeStrings($Error, $this->univ1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->asign1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->career1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_start1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_end1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->univ2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->asign2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->career2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_start2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_end2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->univ3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->asign3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->career3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_start3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_end3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->univ4->Errors->ToString());
            $Error = ComposeStrings($Error, $this->asign4->Errors->ToString());
            $Error = ComposeStrings($Error, $this->career4->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_start4->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_end4->Errors->ToString());
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
        $this->univ->Show();
        $this->asign->Show();
        $this->career->Show();
        $this->date_start->Show();
        $this->date_end->Show();
        $this->univ1->Show();
        $this->asign1->Show();
        $this->career1->Show();
        $this->date_start1->Show();
        $this->date_end1->Show();
        $this->univ2->Show();
        $this->asign2->Show();
        $this->career2->Show();
        $this->date_start2->Show();
        $this->date_end2->Show();
        $this->univ3->Show();
        $this->asign3->Show();
        $this->career3->Show();
        $this->date_start3->Show();
        $this->date_end3->Show();
        $this->univ4->Show();
        $this->asign4->Show();
        $this->career4->Show();
        $this->date_start4->Show();
        $this->date_end4->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End doc_uni Class @60-FCB6E20C

class clsdoc_uniDataSource extends clsDBmadnes {  //doc_uniDataSource Class @60-FA0D74BE

//DataSource Variables @60-FE1D5538
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
    public $univ;
    public $asign;
    public $career;
    public $date_start;
    public $date_end;
    public $univ1;
    public $asign1;
    public $career1;
    public $date_start1;
    public $date_end1;
    public $univ2;
    public $asign2;
    public $career2;
    public $date_start2;
    public $date_end2;
    public $univ3;
    public $asign3;
    public $career3;
    public $date_start3;
    public $date_end3;
    public $univ4;
    public $asign4;
    public $career4;
    public $date_start4;
    public $date_end4;
//End DataSource Variables

//DataSourceClass_Initialize Event @60-2ABCF98E
    function clsdoc_uniDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record doc_uni/Error";
        $this->Initialize();
        $this->id_func = new clsField("id_func", ccsInteger, "");
        
        $this->univ = new clsField("univ", ccsText, "");
        
        $this->asign = new clsField("asign", ccsText, "");
        
        $this->career = new clsField("career", ccsText, "");
        
        $this->date_start = new clsField("date_start", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->date_end = new clsField("date_end", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->univ1 = new clsField("univ1", ccsText, "");
        
        $this->asign1 = new clsField("asign1", ccsText, "");
        
        $this->career1 = new clsField("career1", ccsText, "");
        
        $this->date_start1 = new clsField("date_start1", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->date_end1 = new clsField("date_end1", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->univ2 = new clsField("univ2", ccsText, "");
        
        $this->asign2 = new clsField("asign2", ccsText, "");
        
        $this->career2 = new clsField("career2", ccsText, "");
        
        $this->date_start2 = new clsField("date_start2", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->date_end2 = new clsField("date_end2", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->univ3 = new clsField("univ3", ccsText, "");
        
        $this->asign3 = new clsField("asign3", ccsText, "");
        
        $this->career3 = new clsField("career3", ccsText, "");
        
        $this->date_start3 = new clsField("date_start3", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->date_end3 = new clsField("date_end3", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->univ4 = new clsField("univ4", ccsText, "");
        
        $this->asign4 = new clsField("asign4", ccsText, "");
        
        $this->career4 = new clsField("career4", ccsText, "");
        
        $this->date_start4 = new clsField("date_start4", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->date_end4 = new clsField("date_end4", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        

        $this->InsertFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["univ"] = array("Name" => "univ", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["asign"] = array("Name" => "asign", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["career"] = array("Name" => "career", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["date_start"] = array("Name" => "date_start", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["date_end"] = array("Name" => "date_end", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["univ1"] = array("Name" => "univ1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["asign1"] = array("Name" => "asign1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["career1"] = array("Name" => "career1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["date_start1"] = array("Name" => "date_start1", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["date_end1"] = array("Name" => "date_end1", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["univ2"] = array("Name" => "univ2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["asign2"] = array("Name" => "asign2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["career2"] = array("Name" => "career2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["date_start2"] = array("Name" => "date_start2", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["date_end2"] = array("Name" => "date_end2", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["univ3"] = array("Name" => "univ3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["asign3"] = array("Name" => "asign3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["career3"] = array("Name" => "career3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["date_start3"] = array("Name" => "date_start3", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["date_end3"] = array("Name" => "date_end3", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["univ4"] = array("Name" => "univ4", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["asign4"] = array("Name" => "asign4", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["career4"] = array("Name" => "career4", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["date_start4"] = array("Name" => "date_start4", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["date_end4"] = array("Name" => "date_end4", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["id_func"] = array("Name" => "id_func", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["univ"] = array("Name" => "univ", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["asign"] = array("Name" => "asign", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["career"] = array("Name" => "career", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_start"] = array("Name" => "date_start", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_end"] = array("Name" => "date_end", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["univ1"] = array("Name" => "univ1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["asign1"] = array("Name" => "asign1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["career1"] = array("Name" => "career1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_start1"] = array("Name" => "date_start1", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_end1"] = array("Name" => "date_end1", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["univ2"] = array("Name" => "univ2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["asign2"] = array("Name" => "asign2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["career2"] = array("Name" => "career2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_start2"] = array("Name" => "date_start2", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_end2"] = array("Name" => "date_end2", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["univ3"] = array("Name" => "univ3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["asign3"] = array("Name" => "asign3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["career3"] = array("Name" => "career3", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_start3"] = array("Name" => "date_start3", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_end3"] = array("Name" => "date_end3", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["univ4"] = array("Name" => "univ4", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["asign4"] = array("Name" => "asign4", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["career4"] = array("Name" => "career4", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_start4"] = array("Name" => "date_start4", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_end4"] = array("Name" => "date_end4", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @60-7F6F9F59
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

//Open Method @60-71C68193
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT *, id_doc_uni \n\n" .
        "FROM doc_uni {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @60-46F88E60
    function SetValues()
    {
        $this->id_func->SetDBValue(trim($this->f("id_func")));
        $this->univ->SetDBValue($this->f("univ"));
        $this->asign->SetDBValue($this->f("asign"));
        $this->career->SetDBValue($this->f("career"));
        $this->date_start->SetDBValue(trim($this->f("date_start")));
        $this->date_end->SetDBValue(trim($this->f("date_end")));
        $this->univ1->SetDBValue($this->f("univ1"));
        $this->asign1->SetDBValue($this->f("asign1"));
        $this->career1->SetDBValue($this->f("career1"));
        $this->date_start1->SetDBValue(trim($this->f("date_start1")));
        $this->date_end1->SetDBValue(trim($this->f("date_end1")));
        $this->univ2->SetDBValue($this->f("univ2"));
        $this->asign2->SetDBValue($this->f("asign2"));
        $this->career2->SetDBValue($this->f("career2"));
        $this->date_start2->SetDBValue(trim($this->f("date_start2")));
        $this->date_end2->SetDBValue(trim($this->f("date_end2")));
        $this->univ3->SetDBValue($this->f("univ3"));
        $this->asign3->SetDBValue($this->f("asign3"));
        $this->career3->SetDBValue($this->f("career3"));
        $this->date_start3->SetDBValue(trim($this->f("date_start3")));
        $this->date_end3->SetDBValue(trim($this->f("date_end3")));
        $this->univ4->SetDBValue($this->f("univ4"));
        $this->asign4->SetDBValue($this->f("asign4"));
        $this->career4->SetDBValue($this->f("career4"));
        $this->date_start4->SetDBValue(trim($this->f("date_start4")));
        $this->date_end4->SetDBValue(trim($this->f("date_end4")));
    }
//End SetValues Method

//Insert Method @60-F860EE7C
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->InsertFields["univ"]["Value"] = $this->univ->GetDBValue(true);
        $this->InsertFields["asign"]["Value"] = $this->asign->GetDBValue(true);
        $this->InsertFields["career"]["Value"] = $this->career->GetDBValue(true);
        $this->InsertFields["date_start"]["Value"] = $this->date_start->GetDBValue(true);
        $this->InsertFields["date_end"]["Value"] = $this->date_end->GetDBValue(true);
        $this->InsertFields["univ1"]["Value"] = $this->univ1->GetDBValue(true);
        $this->InsertFields["asign1"]["Value"] = $this->asign1->GetDBValue(true);
        $this->InsertFields["career1"]["Value"] = $this->career1->GetDBValue(true);
        $this->InsertFields["date_start1"]["Value"] = $this->date_start1->GetDBValue(true);
        $this->InsertFields["date_end1"]["Value"] = $this->date_end1->GetDBValue(true);
        $this->InsertFields["univ2"]["Value"] = $this->univ2->GetDBValue(true);
        $this->InsertFields["asign2"]["Value"] = $this->asign2->GetDBValue(true);
        $this->InsertFields["career2"]["Value"] = $this->career2->GetDBValue(true);
        $this->InsertFields["date_start2"]["Value"] = $this->date_start2->GetDBValue(true);
        $this->InsertFields["date_end2"]["Value"] = $this->date_end2->GetDBValue(true);
        $this->InsertFields["univ3"]["Value"] = $this->univ3->GetDBValue(true);
        $this->InsertFields["asign3"]["Value"] = $this->asign3->GetDBValue(true);
        $this->InsertFields["career3"]["Value"] = $this->career3->GetDBValue(true);
        $this->InsertFields["date_start3"]["Value"] = $this->date_start3->GetDBValue(true);
        $this->InsertFields["date_end3"]["Value"] = $this->date_end3->GetDBValue(true);
        $this->InsertFields["univ4"]["Value"] = $this->univ4->GetDBValue(true);
        $this->InsertFields["asign4"]["Value"] = $this->asign4->GetDBValue(true);
        $this->InsertFields["career4"]["Value"] = $this->career4->GetDBValue(true);
        $this->InsertFields["date_start4"]["Value"] = $this->date_start4->GetDBValue(true);
        $this->InsertFields["date_end4"]["Value"] = $this->date_end4->GetDBValue(true);
        $this->SQL = CCBuildInsert("doc_uni", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @60-CE3ADB21
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["id_func"]["Value"] = $this->id_func->GetDBValue(true);
        $this->UpdateFields["univ"]["Value"] = $this->univ->GetDBValue(true);
        $this->UpdateFields["asign"]["Value"] = $this->asign->GetDBValue(true);
        $this->UpdateFields["career"]["Value"] = $this->career->GetDBValue(true);
        $this->UpdateFields["date_start"]["Value"] = $this->date_start->GetDBValue(true);
        $this->UpdateFields["date_end"]["Value"] = $this->date_end->GetDBValue(true);
        $this->UpdateFields["univ1"]["Value"] = $this->univ1->GetDBValue(true);
        $this->UpdateFields["asign1"]["Value"] = $this->asign1->GetDBValue(true);
        $this->UpdateFields["career1"]["Value"] = $this->career1->GetDBValue(true);
        $this->UpdateFields["date_start1"]["Value"] = $this->date_start1->GetDBValue(true);
        $this->UpdateFields["date_end1"]["Value"] = $this->date_end1->GetDBValue(true);
        $this->UpdateFields["univ2"]["Value"] = $this->univ2->GetDBValue(true);
        $this->UpdateFields["asign2"]["Value"] = $this->asign2->GetDBValue(true);
        $this->UpdateFields["career2"]["Value"] = $this->career2->GetDBValue(true);
        $this->UpdateFields["date_start2"]["Value"] = $this->date_start2->GetDBValue(true);
        $this->UpdateFields["date_end2"]["Value"] = $this->date_end2->GetDBValue(true);
        $this->UpdateFields["univ3"]["Value"] = $this->univ3->GetDBValue(true);
        $this->UpdateFields["asign3"]["Value"] = $this->asign3->GetDBValue(true);
        $this->UpdateFields["career3"]["Value"] = $this->career3->GetDBValue(true);
        $this->UpdateFields["date_start3"]["Value"] = $this->date_start3->GetDBValue(true);
        $this->UpdateFields["date_end3"]["Value"] = $this->date_end3->GetDBValue(true);
        $this->UpdateFields["univ4"]["Value"] = $this->univ4->GetDBValue(true);
        $this->UpdateFields["asign4"]["Value"] = $this->asign4->GetDBValue(true);
        $this->UpdateFields["career4"]["Value"] = $this->career4->GetDBValue(true);
        $this->UpdateFields["date_start4"]["Value"] = $this->date_start4->GetDBValue(true);
        $this->UpdateFields["date_end4"]["Value"] = $this->date_end4->GetDBValue(true);
        $this->SQL = CCBuildUpdate("doc_uni", $this->UpdateFields, $this);
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

} //End doc_uniDataSource Class @60-FCB6E20C

//Initialize Page @1-E7078D7C
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
$TemplateFileName = "Regdat_idir.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-91FD142F
$DBmadnes = new clsDBmadnes();
$MainPage->Connections["madnes"] = & $DBmadnes;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$lang_func = new clsRecordlang_func("", $MainPage);
$ot_con = new clsRecordot_con("", $MainPage);
$doc_uni = new clsRecorddoc_uni("", $MainPage);
$MainPage->lang_func = & $lang_func;
$MainPage->ot_con = & $ot_con;
$MainPage->doc_uni = & $doc_uni;
$lang_func->Initialize();
$ot_con->Initialize();
$doc_uni->Initialize();

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

//Execute Components @1-10DA93A8
$doc_uni->Operation();
$ot_con->Operation();
$lang_func->Operation();
//End Execute Components

//Go to destination page @1-5948DB8A
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmadnes->close();
    header("Location: " . $Redirect);
    unset($lang_func);
    unset($ot_con);
    unset($doc_uni);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-C82C437C
$lang_func->Show();
$ot_con->Show();
$doc_uni->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);


$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-993B2133
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmadnes->close();
unset($lang_func);
unset($ot_con);
unset($doc_uni);
unset($Tpl);
//End Unload Page


?>
