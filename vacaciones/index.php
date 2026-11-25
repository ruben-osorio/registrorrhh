<?php
//Include Common Files @1-AF8F3DDB
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "busqueda_vacaciones.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridpermanente_funcionario { //permanente_funcionario class @2-F0B6BBDD

//Variables @2-6A53CA23

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

    public $CCSEvents = array();
    public $CCSEventResult;

    public $RelativePath = "";
    public $Attributes;

    // Grid Controls
    public $StaticControls;
    public $RowControls;
    public $Sorter_l_name1;
    public $Sorter_l_name2;
    public $Sorter_name;
//End Variables

//Class_Initialize Event @2-37009A90
    function __construct($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "permanente_funcionario";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid permanente_funcionario";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clspermanente_funcionarioDataSource($this);
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
        $this->SorterName = CCGetParam("permanente_funcionarioOrder", "");
        $this->SorterDirection = CCGetParam("permanente_funcionarioDir", "");

        $this->l_name1 = new clsControl(ccsLabel, "l_name1", "l_name1", ccsText, "", CCGetRequestParam("l_name1", ccsGet, NULL), $this);
        $this->l_name2 = new clsControl(ccsLabel, "l_name2", "l_name2", ccsText, "", CCGetRequestParam("l_name2", ccsGet, NULL), $this);
        $this->name = new clsControl(ccsLabel, "name", "name", ccsText, "", CCGetRequestParam("name", ccsGet, NULL), $this);
        $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
        $this->ImageLink1->Page = "RepIndivFormVacN.php";
        $this->Sorter_l_name1 = new clsSorter($this->ComponentName, "Sorter_l_name1", $FileName, $this);
        $this->Sorter_l_name2 = new clsSorter($this->ComponentName, "Sorter_l_name2", $FileName, $this);
        $this->Sorter_name = new clsSorter($this->ComponentName, "Sorter_name", $FileName, $this);
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

//Show Method @2-1A330C3C
    function Show()
    {
        $Tpl = & CCGetTemplate($this);
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_name"] = CCGetFromGet("s_name", NULL);
        $this->DataSource->Parameters["urls_l_name1"] = CCGetFromGet("s_l_name1", NULL);
        $this->DataSource->Parameters["urls_l_name2"] = CCGetFromGet("s_l_name2", NULL);

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
            $this->ControlsVisible["l_name1"] = $this->l_name1->Visible;
            $this->ControlsVisible["l_name2"] = $this->l_name2->Visible;
            $this->ControlsVisible["name"] = $this->name->Visible;
            $this->ControlsVisible["ImageLink1"] = $this->ImageLink1->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->l_name1->SetValue($this->DataSource->l_name1->GetValue());
                $this->l_name2->SetValue($this->DataSource->l_name2->GetValue());
                $this->name->SetValue($this->DataSource->name->GetValue());
                $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "id", $this->DataSource->f("funcionario_id_func"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->l_name1->Show();
                $this->l_name2->Show();
                $this->name->Show();
                $this->ImageLink1->Show();
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
        $this->Sorter_l_name1->Show();
        $this->Sorter_l_name2->Show();
        $this->Sorter_name->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @2-77BCD194
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->l_name1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->l_name2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method


	// Alias del constructor estilo PHP 4
	function clsGridpermanente_funcionario() { return call_user_func_array(array($this, '__construct'), func_get_args()); }
} //End permanente_funcionario Class @2-FCB6E20C

class clspermanente_funcionarioDataSource extends clsDBmadnes {  //permanente_funcionarioDataSource Class @2-F2754083

//DataSource Variables @2-5E78EBB2
    public $Parent = "";
    public $CCSEvents = array();
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $l_name1;
    public $l_name2;
    public $name;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-359D07AB
    function __construct(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid permanente_funcionario";
        $this->Initialize();
        $this->l_name1 = new clsField("l_name1", ccsText, "");
        
        $this->l_name2 = new clsField("l_name2", ccsText, "");
        
        $this->name = new clsField("name", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-A76AB638
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_l_name1" => array("l_name1", ""), 
            "Sorter_l_name2" => array("l_name2", ""), 
            "Sorter_name" => array("name", "")));
    }
//End SetOrder Method

//Prepare Method @2-EC46E46B
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_name", ccsText, "", "", $this->Parameters["urls_name"], "", false);
        $this->wp->AddParameter("2", "urls_l_name1", ccsText, "", "", $this->Parameters["urls_l_name1"], "", false);
        $this->wp->AddParameter("3", "urls_l_name2", ccsText, "", "", $this->Parameters["urls_l_name2"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "funcionario.name", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "funcionario.l_name1", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "funcionario.l_name2", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]);
    }
//End Prepare Method

//Open Method @2-F971E721
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM funcionario INNER JOIN permanente ON\n\n" .
        "funcionario.id_func = permanente.id_func";
        $this->SQL = "SELECT name, l_name1, l_name2, status, funcionario.id_func AS funcionario_id_func \n\n" .
        "FROM funcionario INNER JOIN permanente ON\n\n" .
        "funcionario.id_func = permanente.id_func {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-A6AEA784
    function SetValues()
    {
        $this->l_name1->SetDBValue($this->f("l_name1"));
        $this->l_name2->SetDBValue($this->f("l_name2"));
        $this->name->SetDBValue($this->f("name"));
    }
//End SetValues Method


	// Alias del constructor estilo PHP 4
	function clspermanente_funcionarioDataSource() { return call_user_func_array(array($this, '__construct'), func_get_args()); }
} //End permanente_funcionarioDataSource Class @2-FCB6E20C

class clsRecordpermanente_funcionario1 { //permanente_funcionario1 Class @22-855816C4

//Variables @22-9E315808

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

    public $CCSEvents = array();
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

//Class_Initialize Event @22-CEA7EAD2
    function __construct($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record permanente_funcionario1/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "permanente_funcionario1";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_name = new clsControl(ccsTextBox, "s_name", "Name", ccsText, "", CCGetRequestParam("s_name", $Method, NULL), $this);
            $this->s_l_name1 = new clsControl(ccsTextBox, "s_l_name1", "L Name1", ccsText, "", CCGetRequestParam("s_l_name1", $Method, NULL), $this);
            $this->s_l_name2 = new clsControl(ccsTextBox, "s_l_name2", "L Name2", ccsText, "", CCGetRequestParam("s_l_name2", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @22-69B2FB15
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_name->Validate() && $Validation);
        $Validation = ($this->s_l_name1->Validate() && $Validation);
        $Validation = ($this->s_l_name2->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_name->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_l_name1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_l_name2->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @22-6C125609
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_name->Errors->Count());
        $errors = ($errors || $this->s_l_name1->Errors->Count());
        $errors = ($errors || $this->s_l_name2->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @22-63EAF7C4
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        if(!$this->FormSubmitted) {
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = "Button_DoSearch";
            if($this->Button_DoSearch->Pressed) {
                $this->PressedButton = "Button_DoSearch";
            }
        }
        $Redirect = "busqueda_vacaciones.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "busqueda_vacaciones.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @22-A98BAEAD
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

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_name->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_l_name1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_l_name2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_DoSearch->Show();
        $this->s_name->Show();
        $this->s_l_name1->Show();
        $this->s_l_name2->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method


	// Alias del constructor estilo PHP 4
	function clsRecordpermanente_funcionario1() { return call_user_func_array(array($this, '__construct'), func_get_args()); }
} //End permanente_funcionario1 Class @22-FCB6E20C

//Initialize Page @1-E869E736
// Variables
$FileName = "";
$Redirect = "";
$Tpl = "";
$TemplateFileName = "";
$BlockToParse = "";
$ComponentName = "";
$Attributes = "";

// Events;
$CCSEvents = array();
$CCSEventResult = "";
$TemplateSource = "";

$FileName = FileName;
$Redirect = "";
$TemplateFileName = "busqueda_vacaciones.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-64C9EB46
$DBmadnes = new clsDBmadnes();
$MainPage->Connections["madnes"] = & $DBmadnes;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$permanente_funcionario = new clsGridpermanente_funcionario("", $MainPage);
$permanente_funcionario1 = new clsRecordpermanente_funcionario1("", $MainPage);
$MainPage->permanente_funcionario = & $permanente_funcionario;
$MainPage->permanente_funcionario1 = & $permanente_funcionario1;
$permanente_funcionario->Initialize();

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

//Execute Components @1-263CE33F
$permanente_funcionario1->Operation();
//End Execute Components

//Go to destination page @1-7BBE1E06
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmadnes->close();
    header("Location: " . $Redirect);
    unset($permanente_funcionario);
    unset($permanente_funcionario1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-5525571B
$permanente_funcionario->Show();
$permanente_funcionario1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-2228B1C0
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmadnes->close();
unset($permanente_funcionario);
unset($permanente_funcionario1);
unset($Tpl);
//End Unload Page


?>
