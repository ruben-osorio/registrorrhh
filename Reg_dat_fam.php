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

class clsGriddat_fam { //dat_fam class @2-E2F5616C

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

//Class_Initialize Event @2-3B875C1A
    function clsGriddat_fam($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "dat_fam";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid dat_fam";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsdat_famDataSource($this);
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

        $this->id_datf = new clsControl(ccsLink, "id_datf", "id_datf", ccsInteger, "", CCGetRequestParam("id_datf", ccsGet, NULL), $this);
        $this->id_datf->Page = "";
        $this->type_p = new clsControl(ccsLabel, "type_p", "type_p", ccsText, "", CCGetRequestParam("type_p", ccsGet, NULL), $this);
        $this->name = new clsControl(ccsLabel, "name", "name", ccsText, "", CCGetRequestParam("name", ccsGet, NULL), $this);
        $this->l_name1 = new clsControl(ccsLabel, "l_name1", "l_name1", ccsText, "", CCGetRequestParam("l_name1", ccsGet, NULL), $this);
        $this->l_name2 = new clsControl(ccsLabel, "l_name2", "l_name2", ccsText, "", CCGetRequestParam("l_name2", ccsGet, NULL), $this);
        $this->sex = new clsControl(ccsLabel, "sex", "sex", ccsText, "", CCGetRequestParam("sex", ccsGet, NULL), $this);
        $this->born_date = new clsControl(ccsLabel, "born_date", "born_date", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("born_date", ccsGet, NULL), $this);
        $this->pb_nat = new clsControl(ccsLabel, "pb_nat", "pb_nat", ccsText, "", CCGetRequestParam("pb_nat", ccsGet, NULL), $this);
        $this->tn_doc = new clsControl(ccsLabel, "tn_doc", "tn_doc", ccsText, "", CCGetRequestParam("tn_doc", ccsGet, NULL), $this);
        $this->dat_fam_Insert = new clsControl(ccsLink, "dat_fam_Insert", "dat_fam_Insert", ccsText, "", CCGetRequestParam("dat_fam_Insert", ccsGet, NULL), $this);
        $this->dat_fam_Insert->Parameters = CCGetQueryString("QueryString", array("id_datf", "ccsForm"));
        $this->dat_fam_Insert->Page = "Reg_dat_fam.php";
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

//Show Method @2-C960FDF5
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
            $this->ControlsVisible["id_datf"] = $this->id_datf->Visible;
            $this->ControlsVisible["type_p"] = $this->type_p->Visible;
            $this->ControlsVisible["name"] = $this->name->Visible;
            $this->ControlsVisible["l_name1"] = $this->l_name1->Visible;
            $this->ControlsVisible["l_name2"] = $this->l_name2->Visible;
            $this->ControlsVisible["sex"] = $this->sex->Visible;
            $this->ControlsVisible["born_date"] = $this->born_date->Visible;
            $this->ControlsVisible["pb_nat"] = $this->pb_nat->Visible;
            $this->ControlsVisible["tn_doc"] = $this->tn_doc->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->id_datf->SetValue($this->DataSource->id_datf->GetValue());
                $this->id_datf->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->id_datf->Parameters = CCAddParam($this->id_datf->Parameters, "id_datf", $this->DataSource->f("id_datf"));
                $this->type_p->SetValue($this->DataSource->type_p->GetValue());
                $this->name->SetValue($this->DataSource->name->GetValue());
                $this->l_name1->SetValue($this->DataSource->l_name1->GetValue());
                $this->l_name2->SetValue($this->DataSource->l_name2->GetValue());
                $this->sex->SetValue($this->DataSource->sex->GetValue());
                $this->born_date->SetValue($this->DataSource->born_date->GetValue());
                $this->pb_nat->SetValue($this->DataSource->pb_nat->GetValue());
                $this->tn_doc->SetValue($this->DataSource->tn_doc->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->id_datf->Show();
                $this->type_p->Show();
                $this->name->Show();
                $this->l_name1->Show();
                $this->l_name2->Show();
                $this->sex->Show();
                $this->born_date->Show();
                $this->pb_nat->Show();
                $this->tn_doc->Show();
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
        $this->dat_fam_Insert->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @2-23060D11
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->id_datf->Errors->ToString());
        $errors = ComposeStrings($errors, $this->type_p->Errors->ToString());
        $errors = ComposeStrings($errors, $this->name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->l_name1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->l_name2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->sex->Errors->ToString());
        $errors = ComposeStrings($errors, $this->born_date->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pb_nat->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tn_doc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End dat_fam Class @2-FCB6E20C

class clsdat_famDataSource extends clsDBmadnes {  //dat_famDataSource Class @2-5CEB3720

//DataSource Variables @2-216A5180
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $id_datf;
    public $type_p;
    public $name;
    public $l_name1;
    public $l_name2;
    public $sex;
    public $born_date;
    public $pb_nat;
    public $tn_doc;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-49444487
    function clsdat_famDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid dat_fam";
        $this->Initialize();
        $this->id_datf = new clsField("id_datf", ccsInteger, "");
        
        $this->type_p = new clsField("type_p", ccsText, "");
        
        $this->name = new clsField("name", ccsText, "");
        
        $this->l_name1 = new clsField("l_name1", ccsText, "");
        
        $this->l_name2 = new clsField("l_name2", ccsText, "");
        
        $this->sex = new clsField("sex", ccsText, "");
        
        $this->born_date = new clsField("born_date", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->pb_nat = new clsField("pb_nat", ccsText, "");
        
        $this->tn_doc = new clsField("tn_doc", ccsText, "");
        

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

//Prepare Method @2-AB60C611
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

//Open Method @2-812646AC
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM dat_fam";
        $this->SQL = "SELECT id_datf, type_p, name, l_name1, l_name2, sex, born_date, pb_nat, tn_doc \n\n" .
        "FROM dat_fam {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-6062B7C0
    function SetValues()
    {
        $this->id_datf->SetDBValue(trim($this->f("id_datf")));
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

} //End dat_famDataSource Class @2-FCB6E20C

class clsRecorddat_fam1 { //dat_fam1 Class @24-6BC79ED6

//Variables @24-9E315808

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

//Class_Initialize Event @24-09F64EA1
    function clsRecorddat_fam1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record dat_fam1/Error";
        $this->DataSource = new clsdat_fam1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "dat_fam1";
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
            $this->type_p = new clsControl(ccsListBox, "type_p", "Type P", ccsText, "", CCGetRequestParam("type_p", $Method, NULL), $this);
            $this->type_p->DSType = dsTable;
            $this->type_p->DataSource = new clsDBmadnes();
            $this->type_p->ds = & $this->type_p->DataSource;
            $this->type_p->DataSource->SQL = "SELECT * \n" .
"FROM tipo_parentesco {SQL_Where} {SQL_OrderBy}";
            list($this->type_p->BoundColumn, $this->type_p->TextColumn, $this->type_p->DBFormat) = array("descrip", "descrip", "");
            $this->name = new clsControl(ccsTextBox, "name", "Name", ccsText, "", CCGetRequestParam("name", $Method, NULL), $this);
            $this->l_name1 = new clsControl(ccsTextBox, "l_name1", "L Name1", ccsText, "", CCGetRequestParam("l_name1", $Method, NULL), $this);
            $this->l_name2 = new clsControl(ccsTextBox, "l_name2", "L Name2", ccsText, "", CCGetRequestParam("l_name2", $Method, NULL), $this);
            $this->sex = new clsControl(ccsRadioButton, "sex", "Sex", ccsText, "", CCGetRequestParam("sex", $Method, NULL), $this);
            $this->sex->DSType = dsTable;
            $this->sex->DataSource = new clsDBmadnes();
            $this->sex->ds = & $this->sex->DataSource;
            $this->sex->DataSource->SQL = "SELECT * \n" .
"FROM sexo {SQL_Where} {SQL_OrderBy}";
            list($this->sex->BoundColumn, $this->sex->TextColumn, $this->sex->DBFormat) = array("descripcion", "descripcion", "");
            $this->born_date = new clsControl(ccsTextBox, "born_date", "Born Date", ccsDate, array("ShortDate"), CCGetRequestParam("born_date", $Method, NULL), $this);
            $this->pb_nat = new clsControl(ccsTextBox, "pb_nat", "Pb Nat", ccsText, "", CCGetRequestParam("pb_nat", $Method, NULL), $this);
            $this->tn_doc = new clsControl(ccsTextBox, "tn_doc", "Tn Doc", ccsText, "", CCGetRequestParam("tn_doc", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @24-0D10F640
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid_datf"] = CCGetFromGet("id_datf", NULL);
    }
//End Initialize Method

//Validate Method @24-4736BC2B
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->id_func->Validate() && $Validation);
        $Validation = ($this->type_p->Validate() && $Validation);
        $Validation = ($this->name->Validate() && $Validation);
        $Validation = ($this->l_name1->Validate() && $Validation);
        $Validation = ($this->l_name2->Validate() && $Validation);
        $Validation = ($this->sex->Validate() && $Validation);
        $Validation = ($this->born_date->Validate() && $Validation);
        $Validation = ($this->pb_nat->Validate() && $Validation);
        $Validation = ($this->tn_doc->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->id_func->Errors->Count() == 0);
        $Validation =  $Validation && ($this->type_p->Errors->Count() == 0);
        $Validation =  $Validation && ($this->name->Errors->Count() == 0);
        $Validation =  $Validation && ($this->l_name1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->l_name2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->sex->Errors->Count() == 0);
        $Validation =  $Validation && ($this->born_date->Errors->Count() == 0);
        $Validation =  $Validation && ($this->pb_nat->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tn_doc->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @24-57BAC45F
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->id_func->Errors->Count());
        $errors = ($errors || $this->type_p->Errors->Count());
        $errors = ($errors || $this->name->Errors->Count());
        $errors = ($errors || $this->l_name1->Errors->Count());
        $errors = ($errors || $this->l_name2->Errors->Count());
        $errors = ($errors || $this->sex->Errors->Count());
        $errors = ($errors || $this->born_date->Errors->Count());
        $errors = ($errors || $this->pb_nat->Errors->Count());
        $errors = ($errors || $this->tn_doc->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @24-288F0419
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

//InsertRow Method @24-42B53F5F
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
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
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @24-CFF9B903
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
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
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @24-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @24-FE52048B
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

        $this->type_p->Prepare();
        $this->sex->Prepare();

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
                    $this->type_p->SetValue($this->DataSource->type_p->GetValue());
                    $this->name->SetValue($this->DataSource->name->GetValue());
                    $this->l_name1->SetValue($this->DataSource->l_name1->GetValue());
                    $this->l_name2->SetValue($this->DataSource->l_name2->GetValue());
                    $this->sex->SetValue($this->DataSource->sex->GetValue());
                    $this->born_date->SetValue($this->DataSource->born_date->GetValue());
                    $this->pb_nat->SetValue($this->DataSource->pb_nat->GetValue());
                    $this->tn_doc->SetValue($this->DataSource->tn_doc->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->id_func->Errors->ToString());
            $Error = ComposeStrings($Error, $this->type_p->Errors->ToString());
            $Error = ComposeStrings($Error, $this->name->Errors->ToString());
            $Error = ComposeStrings($Error, $this->l_name1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->l_name2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->sex->Errors->ToString());
            $Error = ComposeStrings($Error, $this->born_date->Errors->ToString());
            $Error = ComposeStrings($Error, $this->pb_nat->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tn_doc->Errors->ToString());
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
        $this->type_p->Show();
        $this->name->Show();
        $this->l_name1->Show();
        $this->l_name2->Show();
        $this->sex->Show();
        $this->born_date->Show();
        $this->pb_nat->Show();
        $this->tn_doc->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End dat_fam1 Class @24-FCB6E20C

class clsdat_fam1DataSource extends clsDBmadnes {  //dat_fam1DataSource Class @24-EE2431F6

//DataSource Variables @24-4B5B3C54
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
    public $type_p;
    public $name;
    public $l_name1;
    public $l_name2;
    public $sex;
    public $born_date;
    public $pb_nat;
    public $tn_doc;
//End DataSource Variables

//DataSourceClass_Initialize Event @24-6AE3E3F7
    function clsdat_fam1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record dat_fam1/Error";
        $this->Initialize();
        $this->id_func = new clsField("id_func", ccsInteger, "");
        
        $this->type_p = new clsField("type_p", ccsText, "");
        
        $this->name = new clsField("name", ccsText, "");
        
        $this->l_name1 = new clsField("l_name1", ccsText, "");
        
        $this->l_name2 = new clsField("l_name2", ccsText, "");
        
        $this->sex = new clsField("sex", ccsText, "");
        
        $this->born_date = new clsField("born_date", ccsDate, array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn", ":", "ss"));
        
        $this->pb_nat = new clsField("pb_nat", ccsText, "");
        
        $this->tn_doc = new clsField("tn_doc", ccsText, "");
        

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

//Prepare Method @24-4E306C4F
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid_datf", ccsInteger, "", "", $this->Parameters["urlid_datf"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_datf", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @24-2E545E63
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM dat_fam {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @24-2AE34B5B
    function SetValues()
    {
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

//Insert Method @24-88791A25
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

//Update Method @24-854CC48B
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
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
    }
//End Update Method

//Delete Method @24-D92D9F3F
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM dat_fam";
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

} //End dat_fam1DataSource Class @24-FCB6E20C

//Initialize Page @1-769C56C0
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
$TemplateFileName = "Reg_dat_famr.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-C3BE113C
$DBmadnes = new clsDBmadnes();
$MainPage->Connections["madnes"] = & $DBmadnes;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$dat_fam = new clsGriddat_fam("", $MainPage);
$dat_fam1 = new clsRecorddat_fam1("", $MainPage);
$MainPage->dat_fam = & $dat_fam;
$MainPage->dat_fam1 = & $dat_fam1;
$dat_fam->Initialize();
$dat_fam1->Initialize();

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

//Execute Components @1-AC9950B3
$dat_fam1->Operation();
//End Execute Components

//Go to destination page @1-3ADD368C
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmadnes->close();
    header("Location: " . $Redirect);
    unset($dat_fam);
    unset($dat_fam1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-45196AA4
$dat_fam->Show();
$dat_fam1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><fon" . "t face=\"Arial\">" . "<small>&#71;&#" . "101;&#110;&#10" . "1;&#114;a&#116;e" . "d <!-- SCC --" . ">w&#105;th <!-" . "- SCC -->&#67" . ";&#111;&#100;" . "eCha&#114;ge <!" . "-- SCC -->St&#11" . "7;d&#105;o.<" . "/small></fon" . "t></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><fon" . "t face=\"Arial\">" . "<small>&#71;&#" . "101;&#110;&#10" . "1;&#114;a&#116;e" . "d <!-- SCC --" . ">w&#105;th <!-" . "- SCC -->&#67" . ";&#111;&#100;" . "eCha&#114;ge <!" . "-- SCC -->St&#11" . "7;d&#105;o.<" . "/small></fon" . "t></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><fon" . "t face=\"Arial\">" . "<small>&#71;&#" . "101;&#110;&#10" . "1;&#114;a&#116;e" . "d <!-- SCC --" . ">w&#105;th <!-" . "- SCC -->&#67" . ";&#111;&#100;" . "eCha&#114;ge <!" . "-- SCC -->St&#11" . "7;d&#105;o.<" . "/small></fon" . "t></center>";
}
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-46C4F6C8
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmadnes->close();
unset($dat_fam);
unset($dat_fam1);
unset($Tpl);
//End Unload Page


?>
