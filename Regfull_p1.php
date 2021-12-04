<?php
//Include Common Files @1-36F02801
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "Regfull_p1.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordfuncionario { //funcionario Class @2-BE3EDF20

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

//Class_Initialize Event @2-61C88DEA
    function clsRecordfuncionario($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record funcionario/Error";
        $this->DataSource = new clsfuncionarioDataSource($this);
        $this->ds = & $this->DataSource;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "funcionario";
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
            $this->name = new clsControl(ccsLabel, "name", "Name", ccsText, "", CCGetRequestParam("name", $Method, NULL), $this);
            $this->l_name1 = new clsControl(ccsLabel, "l_name1", "L Name1", ccsText, "", CCGetRequestParam("l_name1", $Method, NULL), $this);
            $this->l_name2 = new clsControl(ccsLabel, "l_name2", "L Name2", ccsText, "", CCGetRequestParam("l_name2", $Method, NULL), $this);
            $this->l_name_es = new clsControl(ccsTextBox, "l_name_es", "L Name Es", ccsText, "", CCGetRequestParam("l_name_es", $Method, NULL), $this);
            $this->nati = new clsControl(ccsTextBox, "nati", "Nati", ccsText, "", CCGetRequestParam("nati", $Method, NULL), $this);
            $this->ci = new clsControl(ccsLabel, "ci", "ci", ccsText, "", CCGetRequestParam("ci", $Method, NULL), $this);
            $this->date_born = new clsControl(ccsTextBox, "date_born", "FECHA DE NACIMIENTO", ccsDate, array("ShortDate"), CCGetRequestParam("date_born", $Method, NULL), $this);
            $this->expe = new clsControl(ccsListBox, "expe", "Expe", ccsText, "", CCGetRequestParam("expe", $Method, NULL), $this);
            $this->expe->DSType = dsTable;
            $this->expe->DataSource = new clsDBmadnes();
            $this->expe->ds = & $this->expe->DataSource;
            $this->expe->DataSource->SQL = "SELECT * \n" .
"FROM expedido {SQL_Where} {SQL_OrderBy}";
            list($this->expe->BoundColumn, $this->expe->TextColumn, $this->expe->DBFormat) = array("desctable", "descripcion", "");
            $this->afp = new clsControl(ccsRadioButton, "afp", "Afp", ccsText, "", CCGetRequestParam("afp", $Method, NULL), $this);
            $this->afp->DSType = dsTable;
            $this->afp->DataSource = new clsDBmadnes();
            $this->afp->ds = & $this->afp->DataSource;
            $this->afp->DataSource->SQL = "SELECT * \n" .
"FROM fondo_pensiones {SQL_Where} {SQL_OrderBy}";
            list($this->afp->BoundColumn, $this->afp->TextColumn, $this->afp->DBFormat) = array("descripcion", "descripcion", "");
            $this->afp->HTML = true;
            $this->nua = new clsControl(ccsTextBox, "nua", "Nua", ccsText, "", CCGetRequestParam("nua", $Method, NULL), $this);
            $this->c_status = new clsControl(ccsRadioButton, "c_status", "C Status", ccsText, "", CCGetRequestParam("c_status", $Method, NULL), $this);
            $this->c_status->DSType = dsTable;
            $this->c_status->DataSource = new clsDBmadnes();
            $this->c_status->ds = & $this->c_status->DataSource;
            $this->c_status->DataSource->SQL = "SELECT * \n" .
"FROM estado_civil {SQL_Where} {SQL_OrderBy}";
            list($this->c_status->BoundColumn, $this->c_status->TextColumn, $this->c_status->DBFormat) = array("descripcion", "descripcion", "");
            $this->c_status->HTML = true;
            $this->sex = new clsControl(ccsRadioButton, "sex", "Sex", ccsText, "", CCGetRequestParam("sex", $Method, NULL), $this);
            $this->sex->DSType = dsTable;
            $this->sex->DataSource = new clsDBmadnes();
            $this->sex->ds = & $this->sex->DataSource;
            $this->sex->DataSource->SQL = "SELECT * \n" .
"FROM sexo {SQL_Where} {SQL_OrderBy}";
            list($this->sex->BoundColumn, $this->sex->TextColumn, $this->sex->DBFormat) = array("descripcion", "descripcion", "");
            $this->sex->HTML = true;
            $this->g_blood = new clsControl(ccsTextBox, "g_blood", "G Blood", ccsText, "", CCGetRequestParam("g_blood", $Method, NULL), $this);
            $this->p_email = new clsControl(ccsTextBox, "p_email", "P Email", ccsText, "", CCGetRequestParam("p_email", $Method, NULL), $this);
            $this->job_email = new clsControl(ccsTextBox, "job_email", "Job Email", ccsText, "", CCGetRequestParam("job_email", $Method, NULL), $this);
            $this->adress = new clsControl(ccsTextArea, "adress", "Adress", ccsText, "", CCGetRequestParam("adress", $Method, NULL), $this);
            $this->place_res = new clsControl(ccsTextBox, "place_res", "Place Res", ccsText, "", CCGetRequestParam("place_res", $Method, NULL), $this);
            $this->phone_num = new clsControl(ccsTextBox, "phone_num", "Phone Num", ccsText, "", CCGetRequestParam("phone_num", $Method, NULL), $this);
            $this->cel_num = new clsControl(ccsTextBox, "cel_num", "Cel Num", ccsText, "", CCGetRequestParam("cel_num", $Method, NULL), $this);
            $this->phone_job = new clsControl(ccsTextBox, "phone_job", "Phone Job", ccsText, "", CCGetRequestParam("phone_job", $Method, NULL), $this);
            $this->p1_born = new clsControl(ccsTextBox, "p1_born", "P1 Born", ccsText, "", CCGetRequestParam("p1_born", $Method, NULL), $this);
            $this->p2_born = new clsControl(ccsTextBox, "p2_born", "P2 Born", ccsText, "", CCGetRequestParam("p2_born", $Method, NULL), $this);
            $this->p3_born = new clsControl(ccsTextBox, "p3_born", "P3 Born", ccsText, "", CCGetRequestParam("p3_born", $Method, NULL), $this);
            $this->lic_driv = new clsControl(ccsTextBox, "lic_driv", "Lic Driv", ccsText, "", CCGetRequestParam("lic_driv", $Method, NULL), $this);
            $this->type_lic = new clsControl(ccsRadioButton, "type_lic", "Type Lic", ccsText, "", CCGetRequestParam("type_lic", $Method, NULL), $this);
            $this->type_lic->DSType = dsTable;
            $this->type_lic->DataSource = new clsDBmadnes();
            $this->type_lic->ds = & $this->type_lic->DataSource;
            $this->type_lic->DataSource->SQL = "SELECT * \n" .
"FROM categoria_lc {SQL_Where} {SQL_OrderBy}";
            list($this->type_lic->BoundColumn, $this->type_lic->TextColumn, $this->type_lic->DBFormat) = array("descripcion", "descripcion", "");
            $this->type_lic->HTML = true;
            $this->prof = new clsControl(ccsTextBox, "prof", "Prof", ccsText, "", CCGetRequestParam("prof", $Method, NULL), $this);
            $this->col_prof = new clsControl(ccsTextBox, "col_prof", "Col Prof", ccsText, "", CCGetRequestParam("col_prof", $Method, NULL), $this);
            $this->num_prof = new clsControl(ccsTextBox, "num_prof", "Num Prof", ccsText, "", CCGetRequestParam("num_prof", $Method, NULL), $this);
            $this->nit = new clsControl(ccsTextBox, "nit", "Nit", ccsText, "", CCGetRequestParam("nit", $Method, NULL), $this);
            $this->on_off = new clsControl(ccsTextBox, "on_off", "On Off", ccsInteger, "", CCGetRequestParam("on_off", $Method, NULL), $this);
            $this->last_gra = new clsControl(ccsTextBox, "last_gra", "Last Gra", ccsText, "", CCGetRequestParam("last_gra", $Method, NULL), $this);
            $this->cole = new clsControl(ccsTextBox, "cole", "Cole", ccsText, "", CCGetRequestParam("cole", $Method, NULL), $this);
            $this->ciudad_de = new clsControl(ccsTextBox, "ciudad_de", "Ciudad De", ccsText, "", CCGetRequestParam("ciudad_de", $Method, NULL), $this);
            $this->anyo_de = new clsControl(ccsTextBox, "anyo_de", "Anyo De", ccsText, "", CCGetRequestParam("anyo_de", $Method, NULL), $this);
            $this->title = new clsControl(ccsRadioButton, "title", "Title", ccsInteger, "", CCGetRequestParam("title", $Method, NULL), $this);
            $this->title->DSType = dsListOfValues;
            $this->title->Values = array(array("0", "NO"), array("1", "SI"));
            $this->Button_Update1 = new clsButton("Button_Update1", $Method, $this);
            $this->nro_libreta = new clsControl(ccsTextBox, "nro_libreta", "nro_libreta", ccsText, "", CCGetRequestParam("nro_libreta", $Method, NULL), $this);
            $this->matricula = new clsControl(ccsTextBox, "matricula", "matricula", ccsText, "", CCGetRequestParam("matricula", $Method, NULL), $this);
            $this->anyo = new clsControl(ccsTextBox, "anyo", "anyo", ccsText, "", CCGetRequestParam("anyo", $Method, NULL), $this);
            $this->tipo_servicio = new clsControl(ccsListBox, "tipo_servicio", "tipo_servicio", ccsText, "", CCGetRequestParam("tipo_servicio", $Method, NULL), $this);
            $this->tipo_servicio->DSType = dsTable;
            $this->tipo_servicio->DataSource = new clsDBmadnes();
            $this->tipo_servicio->ds = & $this->tipo_servicio->DataSource;
            $this->tipo_servicio->DataSource->SQL = "SELECT * \n" .
"FROM tipo_libreta {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_servicio->BoundColumn, $this->tipo_servicio->TextColumn, $this->tipo_servicio->DBFormat) = array("desc_tipo_libreta", "desc_tipo_libreta", "");
            $this->Nro_ref1 = new clsControl(ccsTextBox, "Nro_ref1", "Nro_ref1", ccsText, "", CCGetRequestParam("Nro_ref1", $Method, NULL), $this);
            $this->Nro_ref2 = new clsControl(ccsTextBox, "Nro_ref2", "Nro_ref2", ccsText, "", CCGetRequestParam("Nro_ref2", $Method, NULL), $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->on_off->Value) && !strlen($this->on_off->Value) && $this->on_off->Value !== false)
                    $this->on_off->SetText(0);
            }
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

//Validate Method @2-8B24A7D7
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->l_name_es->Validate() && $Validation);
        $Validation = ($this->nati->Validate() && $Validation);
        $Validation = ($this->date_born->Validate() && $Validation);
        $Validation = ($this->expe->Validate() && $Validation);
        $Validation = ($this->afp->Validate() && $Validation);
        $Validation = ($this->nua->Validate() && $Validation);
        $Validation = ($this->c_status->Validate() && $Validation);
        $Validation = ($this->sex->Validate() && $Validation);
        $Validation = ($this->g_blood->Validate() && $Validation);
        $Validation = ($this->p_email->Validate() && $Validation);
        $Validation = ($this->job_email->Validate() && $Validation);
        $Validation = ($this->adress->Validate() && $Validation);
        $Validation = ($this->place_res->Validate() && $Validation);
        $Validation = ($this->phone_num->Validate() && $Validation);
        $Validation = ($this->cel_num->Validate() && $Validation);
        $Validation = ($this->phone_job->Validate() && $Validation);
        $Validation = ($this->p1_born->Validate() && $Validation);
        $Validation = ($this->p2_born->Validate() && $Validation);
        $Validation = ($this->p3_born->Validate() && $Validation);
        $Validation = ($this->lic_driv->Validate() && $Validation);
        $Validation = ($this->type_lic->Validate() && $Validation);
        $Validation = ($this->prof->Validate() && $Validation);
        $Validation = ($this->col_prof->Validate() && $Validation);
        $Validation = ($this->num_prof->Validate() && $Validation);
        $Validation = ($this->nit->Validate() && $Validation);
        $Validation = ($this->on_off->Validate() && $Validation);
        $Validation = ($this->last_gra->Validate() && $Validation);
        $Validation = ($this->cole->Validate() && $Validation);
        $Validation = ($this->ciudad_de->Validate() && $Validation);
        $Validation = ($this->anyo_de->Validate() && $Validation);
        $Validation = ($this->title->Validate() && $Validation);
        $Validation = ($this->nro_libreta->Validate() && $Validation);
        $Validation = ($this->matricula->Validate() && $Validation);
        $Validation = ($this->anyo->Validate() && $Validation);
        $Validation = ($this->tipo_servicio->Validate() && $Validation);
        $Validation = ($this->Nro_ref1->Validate() && $Validation);
        $Validation = ($this->Nro_ref2->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->l_name_es->Errors->Count() == 0);
        $Validation =  $Validation && ($this->nati->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_born->Errors->Count() == 0);
        $Validation =  $Validation && ($this->expe->Errors->Count() == 0);
        $Validation =  $Validation && ($this->afp->Errors->Count() == 0);
        $Validation =  $Validation && ($this->nua->Errors->Count() == 0);
        $Validation =  $Validation && ($this->c_status->Errors->Count() == 0);
        $Validation =  $Validation && ($this->sex->Errors->Count() == 0);
        $Validation =  $Validation && ($this->g_blood->Errors->Count() == 0);
        $Validation =  $Validation && ($this->p_email->Errors->Count() == 0);
        $Validation =  $Validation && ($this->job_email->Errors->Count() == 0);
        $Validation =  $Validation && ($this->adress->Errors->Count() == 0);
        $Validation =  $Validation && ($this->place_res->Errors->Count() == 0);
        $Validation =  $Validation && ($this->phone_num->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cel_num->Errors->Count() == 0);
        $Validation =  $Validation && ($this->phone_job->Errors->Count() == 0);
        $Validation =  $Validation && ($this->p1_born->Errors->Count() == 0);
        $Validation =  $Validation && ($this->p2_born->Errors->Count() == 0);
        $Validation =  $Validation && ($this->p3_born->Errors->Count() == 0);
        $Validation =  $Validation && ($this->lic_driv->Errors->Count() == 0);
        $Validation =  $Validation && ($this->type_lic->Errors->Count() == 0);
        $Validation =  $Validation && ($this->prof->Errors->Count() == 0);
        $Validation =  $Validation && ($this->col_prof->Errors->Count() == 0);
        $Validation =  $Validation && ($this->num_prof->Errors->Count() == 0);
        $Validation =  $Validation && ($this->nit->Errors->Count() == 0);
        $Validation =  $Validation && ($this->on_off->Errors->Count() == 0);
        $Validation =  $Validation && ($this->last_gra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cole->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ciudad_de->Errors->Count() == 0);
        $Validation =  $Validation && ($this->anyo_de->Errors->Count() == 0);
        $Validation =  $Validation && ($this->title->Errors->Count() == 0);
        $Validation =  $Validation && ($this->nro_libreta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->matricula->Errors->Count() == 0);
        $Validation =  $Validation && ($this->anyo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_servicio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->Nro_ref1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->Nro_ref2->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-C168A21F
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->name->Errors->Count());
        $errors = ($errors || $this->l_name1->Errors->Count());
        $errors = ($errors || $this->l_name2->Errors->Count());
        $errors = ($errors || $this->l_name_es->Errors->Count());
        $errors = ($errors || $this->nati->Errors->Count());
        $errors = ($errors || $this->ci->Errors->Count());
        $errors = ($errors || $this->date_born->Errors->Count());
        $errors = ($errors || $this->expe->Errors->Count());
        $errors = ($errors || $this->afp->Errors->Count());
        $errors = ($errors || $this->nua->Errors->Count());
        $errors = ($errors || $this->c_status->Errors->Count());
        $errors = ($errors || $this->sex->Errors->Count());
        $errors = ($errors || $this->g_blood->Errors->Count());
        $errors = ($errors || $this->p_email->Errors->Count());
        $errors = ($errors || $this->job_email->Errors->Count());
        $errors = ($errors || $this->adress->Errors->Count());
        $errors = ($errors || $this->place_res->Errors->Count());
        $errors = ($errors || $this->phone_num->Errors->Count());
        $errors = ($errors || $this->cel_num->Errors->Count());
        $errors = ($errors || $this->phone_job->Errors->Count());
        $errors = ($errors || $this->p1_born->Errors->Count());
        $errors = ($errors || $this->p2_born->Errors->Count());
        $errors = ($errors || $this->p3_born->Errors->Count());
        $errors = ($errors || $this->lic_driv->Errors->Count());
        $errors = ($errors || $this->type_lic->Errors->Count());
        $errors = ($errors || $this->prof->Errors->Count());
        $errors = ($errors || $this->col_prof->Errors->Count());
        $errors = ($errors || $this->num_prof->Errors->Count());
        $errors = ($errors || $this->nit->Errors->Count());
        $errors = ($errors || $this->on_off->Errors->Count());
        $errors = ($errors || $this->last_gra->Errors->Count());
        $errors = ($errors || $this->cole->Errors->Count());
        $errors = ($errors || $this->ciudad_de->Errors->Count());
        $errors = ($errors || $this->anyo_de->Errors->Count());
        $errors = ($errors || $this->title->Errors->Count());
        $errors = ($errors || $this->nro_libreta->Errors->Count());
        $errors = ($errors || $this->matricula->Errors->Count());
        $errors = ($errors || $this->anyo->Errors->Count());
        $errors = ($errors || $this->tipo_servicio->Errors->Count());
        $errors = ($errors || $this->Nro_ref1->Errors->Count());
        $errors = ($errors || $this->Nro_ref2->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @2-328AFC98
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
            } else if($this->Button_Update1->Pressed) {
                $this->PressedButton = "Button_Update1";
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
            } else if($this->PressedButton == "Button_Update1") {
                $Redirect = "exito.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
                if(!CCGetEvent($this->Button_Update1->CCSEvents, "OnClick", $this->Button_Update1) || !$this->UpdateRow()) {
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

//UpdateRow Method @2-CE5B36D1
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->name->SetValue($this->name->GetValue(true));
        $this->DataSource->l_name1->SetValue($this->l_name1->GetValue(true));
        $this->DataSource->l_name2->SetValue($this->l_name2->GetValue(true));
        $this->DataSource->l_name_es->SetValue($this->l_name_es->GetValue(true));
        $this->DataSource->nati->SetValue($this->nati->GetValue(true));
        $this->DataSource->ci->SetValue($this->ci->GetValue(true));
        $this->DataSource->date_born->SetValue($this->date_born->GetValue(true));
        $this->DataSource->expe->SetValue($this->expe->GetValue(true));
        $this->DataSource->afp->SetValue($this->afp->GetValue(true));
        $this->DataSource->nua->SetValue($this->nua->GetValue(true));
        $this->DataSource->c_status->SetValue($this->c_status->GetValue(true));
        $this->DataSource->sex->SetValue($this->sex->GetValue(true));
        $this->DataSource->g_blood->SetValue($this->g_blood->GetValue(true));
        $this->DataSource->p_email->SetValue($this->p_email->GetValue(true));
        $this->DataSource->job_email->SetValue($this->job_email->GetValue(true));
        $this->DataSource->adress->SetValue($this->adress->GetValue(true));
        $this->DataSource->place_res->SetValue($this->place_res->GetValue(true));
        $this->DataSource->phone_num->SetValue($this->phone_num->GetValue(true));
        $this->DataSource->cel_num->SetValue($this->cel_num->GetValue(true));
        $this->DataSource->phone_job->SetValue($this->phone_job->GetValue(true));
        $this->DataSource->p1_born->SetValue($this->p1_born->GetValue(true));
        $this->DataSource->p2_born->SetValue($this->p2_born->GetValue(true));
        $this->DataSource->p3_born->SetValue($this->p3_born->GetValue(true));
        $this->DataSource->lic_driv->SetValue($this->lic_driv->GetValue(true));
        $this->DataSource->type_lic->SetValue($this->type_lic->GetValue(true));
        $this->DataSource->prof->SetValue($this->prof->GetValue(true));
        $this->DataSource->col_prof->SetValue($this->col_prof->GetValue(true));
        $this->DataSource->num_prof->SetValue($this->num_prof->GetValue(true));
        $this->DataSource->nit->SetValue($this->nit->GetValue(true));
        $this->DataSource->on_off->SetValue($this->on_off->GetValue(true));
        $this->DataSource->last_gra->SetValue($this->last_gra->GetValue(true));
        $this->DataSource->cole->SetValue($this->cole->GetValue(true));
        $this->DataSource->ciudad_de->SetValue($this->ciudad_de->GetValue(true));
        $this->DataSource->anyo_de->SetValue($this->anyo_de->GetValue(true));
        $this->DataSource->title->SetValue($this->title->GetValue(true));
        $this->DataSource->nro_libreta->SetValue($this->nro_libreta->GetValue(true));
        $this->DataSource->matricula->SetValue($this->matricula->GetValue(true));
        $this->DataSource->anyo->SetValue($this->anyo->GetValue(true));
        $this->DataSource->tipo_servicio->SetValue($this->tipo_servicio->GetValue(true));
        $this->DataSource->Nro_ref1->SetValue($this->Nro_ref1->GetValue(true));
        $this->DataSource->Nro_ref2->SetValue($this->Nro_ref2->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @2-9C34B706
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

        $this->expe->Prepare();
        $this->afp->Prepare();
        $this->c_status->Prepare();
        $this->sex->Prepare();
        $this->type_lic->Prepare();
        $this->title->Prepare();
        $this->tipo_servicio->Prepare();

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
                $this->name->SetValue($this->DataSource->name->GetValue());
                $this->l_name1->SetValue($this->DataSource->l_name1->GetValue());
                $this->l_name2->SetValue($this->DataSource->l_name2->GetValue());
                $this->ci->SetValue($this->DataSource->ci->GetValue());
                if(!$this->FormSubmitted){
                    $this->l_name_es->SetValue($this->DataSource->l_name_es->GetValue());
                    $this->nati->SetValue($this->DataSource->nati->GetValue());
                    $this->date_born->SetValue($this->DataSource->date_born->GetValue());
                    $this->expe->SetValue($this->DataSource->expe->GetValue());
                    $this->afp->SetValue($this->DataSource->afp->GetValue());
                    $this->nua->SetValue($this->DataSource->nua->GetValue());
                    $this->c_status->SetValue($this->DataSource->c_status->GetValue());
                    $this->sex->SetValue($this->DataSource->sex->GetValue());
                    $this->g_blood->SetValue($this->DataSource->g_blood->GetValue());
                    $this->p_email->SetValue($this->DataSource->p_email->GetValue());
                    $this->job_email->SetValue($this->DataSource->job_email->GetValue());
                    $this->adress->SetValue($this->DataSource->adress->GetValue());
                    $this->place_res->SetValue($this->DataSource->place_res->GetValue());
                    $this->phone_num->SetValue($this->DataSource->phone_num->GetValue());
                    $this->cel_num->SetValue($this->DataSource->cel_num->GetValue());
                    $this->phone_job->SetValue($this->DataSource->phone_job->GetValue());
                    $this->p1_born->SetValue($this->DataSource->p1_born->GetValue());
                    $this->p2_born->SetValue($this->DataSource->p2_born->GetValue());
                    $this->p3_born->SetValue($this->DataSource->p3_born->GetValue());
                    $this->lic_driv->SetValue($this->DataSource->lic_driv->GetValue());
                    $this->type_lic->SetValue($this->DataSource->type_lic->GetValue());
                    $this->prof->SetValue($this->DataSource->prof->GetValue());
                    $this->col_prof->SetValue($this->DataSource->col_prof->GetValue());
                    $this->num_prof->SetValue($this->DataSource->num_prof->GetValue());
                    $this->nit->SetValue($this->DataSource->nit->GetValue());
                    $this->on_off->SetValue($this->DataSource->on_off->GetValue());
                    $this->last_gra->SetValue($this->DataSource->last_gra->GetValue());
                    $this->cole->SetValue($this->DataSource->cole->GetValue());
                    $this->ciudad_de->SetValue($this->DataSource->ciudad_de->GetValue());
                    $this->anyo_de->SetValue($this->DataSource->anyo_de->GetValue());
                    $this->title->SetValue($this->DataSource->title->GetValue());
                    $this->nro_libreta->SetValue($this->DataSource->nro_libreta->GetValue());
                    $this->matricula->SetValue($this->DataSource->matricula->GetValue());
                    $this->anyo->SetValue($this->DataSource->anyo->GetValue());
                    $this->tipo_servicio->SetValue($this->DataSource->tipo_servicio->GetValue());
                    $this->Nro_ref1->SetValue($this->DataSource->Nro_ref1->GetValue());
                    $this->Nro_ref2->SetValue($this->DataSource->Nro_ref2->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->name->Errors->ToString());
            $Error = ComposeStrings($Error, $this->l_name1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->l_name2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->l_name_es->Errors->ToString());
            $Error = ComposeStrings($Error, $this->nati->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ci->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_born->Errors->ToString());
            $Error = ComposeStrings($Error, $this->expe->Errors->ToString());
            $Error = ComposeStrings($Error, $this->afp->Errors->ToString());
            $Error = ComposeStrings($Error, $this->nua->Errors->ToString());
            $Error = ComposeStrings($Error, $this->c_status->Errors->ToString());
            $Error = ComposeStrings($Error, $this->sex->Errors->ToString());
            $Error = ComposeStrings($Error, $this->g_blood->Errors->ToString());
            $Error = ComposeStrings($Error, $this->p_email->Errors->ToString());
            $Error = ComposeStrings($Error, $this->job_email->Errors->ToString());
            $Error = ComposeStrings($Error, $this->adress->Errors->ToString());
            $Error = ComposeStrings($Error, $this->place_res->Errors->ToString());
            $Error = ComposeStrings($Error, $this->phone_num->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cel_num->Errors->ToString());
            $Error = ComposeStrings($Error, $this->phone_job->Errors->ToString());
            $Error = ComposeStrings($Error, $this->p1_born->Errors->ToString());
            $Error = ComposeStrings($Error, $this->p2_born->Errors->ToString());
            $Error = ComposeStrings($Error, $this->p3_born->Errors->ToString());
            $Error = ComposeStrings($Error, $this->lic_driv->Errors->ToString());
            $Error = ComposeStrings($Error, $this->type_lic->Errors->ToString());
            $Error = ComposeStrings($Error, $this->prof->Errors->ToString());
            $Error = ComposeStrings($Error, $this->col_prof->Errors->ToString());
            $Error = ComposeStrings($Error, $this->num_prof->Errors->ToString());
            $Error = ComposeStrings($Error, $this->nit->Errors->ToString());
            $Error = ComposeStrings($Error, $this->on_off->Errors->ToString());
            $Error = ComposeStrings($Error, $this->last_gra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cole->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ciudad_de->Errors->ToString());
            $Error = ComposeStrings($Error, $this->anyo_de->Errors->ToString());
            $Error = ComposeStrings($Error, $this->title->Errors->ToString());
            $Error = ComposeStrings($Error, $this->nro_libreta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->matricula->Errors->ToString());
            $Error = ComposeStrings($Error, $this->anyo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_servicio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Nro_ref1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Nro_ref2->Errors->ToString());
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
        $this->Button_Update1->Visible = $this->EditMode && $this->UpdateAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Update->Show();
        $this->Button_Cancel->Show();
        $this->name->Show();
        $this->l_name1->Show();
        $this->l_name2->Show();
        $this->l_name_es->Show();
        $this->nati->Show();
        $this->ci->Show();
        $this->date_born->Show();
        $this->expe->Show();
        $this->afp->Show();
        $this->nua->Show();
        $this->c_status->Show();
        $this->sex->Show();
        $this->g_blood->Show();
        $this->p_email->Show();
        $this->job_email->Show();
        $this->adress->Show();
        $this->place_res->Show();
        $this->phone_num->Show();
        $this->cel_num->Show();
        $this->phone_job->Show();
        $this->p1_born->Show();
        $this->p2_born->Show();
        $this->p3_born->Show();
        $this->lic_driv->Show();
        $this->type_lic->Show();
        $this->prof->Show();
        $this->col_prof->Show();
        $this->num_prof->Show();
        $this->nit->Show();
        $this->on_off->Show();
        $this->last_gra->Show();
        $this->cole->Show();
        $this->ciudad_de->Show();
        $this->anyo_de->Show();
        $this->title->Show();
        $this->Button_Update1->Show();
        $this->nro_libreta->Show();
        $this->matricula->Show();
        $this->anyo->Show();
        $this->tipo_servicio->Show();
        $this->Nro_ref1->Show();
        $this->Nro_ref2->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End funcionario Class @2-FCB6E20C

class clsfuncionarioDataSource extends clsDBmadnes {  //funcionarioDataSource Class @2-5680E709

//DataSource Variables @2-748A7246
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
    public $name;
    public $l_name1;
    public $l_name2;
    public $l_name_es;
    public $nati;
    public $ci;
    public $date_born;
    public $expe;
    public $afp;
    public $nua;
    public $c_status;
    public $sex;
    public $g_blood;
    public $p_email;
    public $job_email;
    public $adress;
    public $place_res;
    public $phone_num;
    public $cel_num;
    public $phone_job;
    public $p1_born;
    public $p2_born;
    public $p3_born;
    public $lic_driv;
    public $type_lic;
    public $prof;
    public $col_prof;
    public $num_prof;
    public $nit;
    public $on_off;
    public $last_gra;
    public $cole;
    public $ciudad_de;
    public $anyo_de;
    public $title;
    public $nro_libreta;
    public $matricula;
    public $anyo;
    public $tipo_servicio;
    public $Nro_ref1;
    public $Nro_ref2;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-140397D5
    function clsfuncionarioDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record funcionario/Error";
        $this->Initialize();
        $this->name = new clsField("name", ccsText, "");
        
        $this->l_name1 = new clsField("l_name1", ccsText, "");
        
        $this->l_name2 = new clsField("l_name2", ccsText, "");
        
        $this->l_name_es = new clsField("l_name_es", ccsText, "");
        
        $this->nati = new clsField("nati", ccsText, "");
        
        $this->ci = new clsField("ci", ccsText, "");
        
        $this->date_born = new clsField("date_born", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->expe = new clsField("expe", ccsText, "");
        
        $this->afp = new clsField("afp", ccsText, "");
        
        $this->nua = new clsField("nua", ccsText, "");
        
        $this->c_status = new clsField("c_status", ccsText, "");
        
        $this->sex = new clsField("sex", ccsText, "");
        
        $this->g_blood = new clsField("g_blood", ccsText, "");
        
        $this->p_email = new clsField("p_email", ccsText, "");
        
        $this->job_email = new clsField("job_email", ccsText, "");
        
        $this->adress = new clsField("adress", ccsText, "");
        
        $this->place_res = new clsField("place_res", ccsText, "");
        
        $this->phone_num = new clsField("phone_num", ccsText, "");
        
        $this->cel_num = new clsField("cel_num", ccsText, "");
        
        $this->phone_job = new clsField("phone_job", ccsText, "");
        
        $this->p1_born = new clsField("p1_born", ccsText, "");
        
        $this->p2_born = new clsField("p2_born", ccsText, "");
        
        $this->p3_born = new clsField("p3_born", ccsText, "");
        
        $this->lic_driv = new clsField("lic_driv", ccsText, "");
        
        $this->type_lic = new clsField("type_lic", ccsText, "");
        
        $this->prof = new clsField("prof", ccsText, "");
        
        $this->col_prof = new clsField("col_prof", ccsText, "");
        
        $this->num_prof = new clsField("num_prof", ccsText, "");
        
        $this->nit = new clsField("nit", ccsText, "");
        
        $this->on_off = new clsField("on_off", ccsInteger, "");
        
        $this->last_gra = new clsField("last_gra", ccsText, "");
        
        $this->cole = new clsField("cole", ccsText, "");
        
        $this->ciudad_de = new clsField("ciudad_de", ccsText, "");
        
        $this->anyo_de = new clsField("anyo_de", ccsText, "");
        
        $this->title = new clsField("title", ccsInteger, "");
        
        $this->nro_libreta = new clsField("nro_libreta", ccsText, "");
        
        $this->matricula = new clsField("matricula", ccsText, "");
        
        $this->anyo = new clsField("anyo", ccsText, "");
        
        $this->tipo_servicio = new clsField("tipo_servicio", ccsText, "");
        
        $this->Nro_ref1 = new clsField("Nro_ref1", ccsText, "");
        
        $this->Nro_ref2 = new clsField("Nro_ref2", ccsText, "");
        

        $this->UpdateFields["l_name_es"] = array("Name" => "l_name_es", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["nati"] = array("Name" => "nati", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_born"] = array("Name" => "date_born", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["expe"] = array("Name" => "expe", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["afp"] = array("Name" => "afp", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["nua"] = array("Name" => "nua", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["c_status"] = array("Name" => "c_status", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["sex"] = array("Name" => "sex", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["g_blood"] = array("Name" => "g_blood", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["p_email"] = array("Name" => "p_email", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["job_email"] = array("Name" => "job_email", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["adress"] = array("Name" => "adress", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["place_res"] = array("Name" => "place_res", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["phone_num"] = array("Name" => "phone_num", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["cel_num"] = array("Name" => "cel_num", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["phone_job"] = array("Name" => "phone_job", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["p1_born"] = array("Name" => "p1_born", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["p2_born"] = array("Name" => "p2_born", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["p3_born"] = array("Name" => "p3_born", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["lic_driv"] = array("Name" => "lic_driv", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["type_lic"] = array("Name" => "type_lic", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["prof"] = array("Name" => "prof", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["col_prof"] = array("Name" => "col_prof", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["num_prof"] = array("Name" => "num_prof", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["nit"] = array("Name" => "nit", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["on_off"] = array("Name" => "on_off", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["last_gra"] = array("Name" => "last_gra", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["cole"] = array("Name" => "cole", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["ciudad_de"] = array("Name" => "ciudad_de", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["anyo_de"] = array("Name" => "anyo_de", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["title"] = array("Name" => "title", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["nro_libreta"] = array("Name" => "nro_libreta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["matricula"] = array("Name" => "matricula", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["anyo"] = array("Name" => "anyo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_libreta"] = array("Name" => "tipo_libreta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["nro_referencia1"] = array("Name" => "nro_referencia1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["nro_referencia2"] = array("Name" => "nro_referencia2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
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

//Open Method @2-0DACB983
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM funcionario {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-86DFF485
    function SetValues()
    {
        $this->name->SetDBValue($this->f("name"));
        $this->l_name1->SetDBValue($this->f("l_name1"));
        $this->l_name2->SetDBValue($this->f("l_name2"));
        $this->l_name_es->SetDBValue($this->f("l_name_es"));
        $this->nati->SetDBValue($this->f("nati"));
        $this->ci->SetDBValue($this->f("ci"));
        $this->date_born->SetDBValue(trim($this->f("date_born")));
        $this->expe->SetDBValue($this->f("expe"));
        $this->afp->SetDBValue($this->f("afp"));
        $this->nua->SetDBValue($this->f("nua"));
        $this->c_status->SetDBValue($this->f("c_status"));
        $this->sex->SetDBValue($this->f("sex"));
        $this->g_blood->SetDBValue($this->f("g_blood"));
        $this->p_email->SetDBValue($this->f("p_email"));
        $this->job_email->SetDBValue($this->f("job_email"));
        $this->adress->SetDBValue($this->f("adress"));
        $this->place_res->SetDBValue($this->f("place_res"));
        $this->phone_num->SetDBValue($this->f("phone_num"));
        $this->cel_num->SetDBValue($this->f("cel_num"));
        $this->phone_job->SetDBValue($this->f("phone_job"));
        $this->p1_born->SetDBValue($this->f("p1_born"));
        $this->p2_born->SetDBValue($this->f("p2_born"));
        $this->p3_born->SetDBValue($this->f("p3_born"));
        $this->lic_driv->SetDBValue($this->f("lic_driv"));
        $this->type_lic->SetDBValue($this->f("type_lic"));
        $this->prof->SetDBValue($this->f("prof"));
        $this->col_prof->SetDBValue($this->f("col_prof"));
        $this->num_prof->SetDBValue($this->f("num_prof"));
        $this->nit->SetDBValue($this->f("nit"));
        $this->on_off->SetDBValue(trim($this->f("on_off")));
        $this->last_gra->SetDBValue($this->f("last_gra"));
        $this->cole->SetDBValue($this->f("cole"));
        $this->ciudad_de->SetDBValue($this->f("ciudad_de"));
        $this->anyo_de->SetDBValue($this->f("anyo_de"));
        $this->title->SetDBValue(trim($this->f("title")));
        $this->nro_libreta->SetDBValue($this->f("nro_libreta"));
        $this->matricula->SetDBValue($this->f("matricula"));
        $this->anyo->SetDBValue($this->f("anyo"));
        $this->tipo_servicio->SetDBValue($this->f("tipo_libreta"));
        $this->Nro_ref1->SetDBValue($this->f("nro_referencia1"));
        $this->Nro_ref2->SetDBValue($this->f("nro_referencia2"));
    }
//End SetValues Method

//Update Method @2-5F973A86
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["l_name_es"]["Value"] = $this->l_name_es->GetDBValue(true);
        $this->UpdateFields["nati"]["Value"] = $this->nati->GetDBValue(true);
        $this->UpdateFields["date_born"]["Value"] = $this->date_born->GetDBValue(true);
        $this->UpdateFields["expe"]["Value"] = $this->expe->GetDBValue(true);
        $this->UpdateFields["afp"]["Value"] = $this->afp->GetDBValue(true);
        $this->UpdateFields["nua"]["Value"] = $this->nua->GetDBValue(true);
        $this->UpdateFields["c_status"]["Value"] = $this->c_status->GetDBValue(true);
        $this->UpdateFields["sex"]["Value"] = $this->sex->GetDBValue(true);
        $this->UpdateFields["g_blood"]["Value"] = $this->g_blood->GetDBValue(true);
        $this->UpdateFields["p_email"]["Value"] = $this->p_email->GetDBValue(true);
        $this->UpdateFields["job_email"]["Value"] = $this->job_email->GetDBValue(true);
        $this->UpdateFields["adress"]["Value"] = $this->adress->GetDBValue(true);
        $this->UpdateFields["place_res"]["Value"] = $this->place_res->GetDBValue(true);
        $this->UpdateFields["phone_num"]["Value"] = $this->phone_num->GetDBValue(true);
        $this->UpdateFields["cel_num"]["Value"] = $this->cel_num->GetDBValue(true);
        $this->UpdateFields["phone_job"]["Value"] = $this->phone_job->GetDBValue(true);
        $this->UpdateFields["p1_born"]["Value"] = $this->p1_born->GetDBValue(true);
        $this->UpdateFields["p2_born"]["Value"] = $this->p2_born->GetDBValue(true);
        $this->UpdateFields["p3_born"]["Value"] = $this->p3_born->GetDBValue(true);
        $this->UpdateFields["lic_driv"]["Value"] = $this->lic_driv->GetDBValue(true);
        $this->UpdateFields["type_lic"]["Value"] = $this->type_lic->GetDBValue(true);
        $this->UpdateFields["prof"]["Value"] = $this->prof->GetDBValue(true);
        $this->UpdateFields["col_prof"]["Value"] = $this->col_prof->GetDBValue(true);
        $this->UpdateFields["num_prof"]["Value"] = $this->num_prof->GetDBValue(true);
        $this->UpdateFields["nit"]["Value"] = $this->nit->GetDBValue(true);
        $this->UpdateFields["on_off"]["Value"] = $this->on_off->GetDBValue(true);
        $this->UpdateFields["last_gra"]["Value"] = $this->last_gra->GetDBValue(true);
        $this->UpdateFields["cole"]["Value"] = $this->cole->GetDBValue(true);
        $this->UpdateFields["ciudad_de"]["Value"] = $this->ciudad_de->GetDBValue(true);
        $this->UpdateFields["anyo_de"]["Value"] = $this->anyo_de->GetDBValue(true);
        $this->UpdateFields["title"]["Value"] = $this->title->GetDBValue(true);
        $this->UpdateFields["nro_libreta"]["Value"] = $this->nro_libreta->GetDBValue(true);
        $this->UpdateFields["matricula"]["Value"] = $this->matricula->GetDBValue(true);
        $this->UpdateFields["anyo"]["Value"] = $this->anyo->GetDBValue(true);
        $this->UpdateFields["tipo_libreta"]["Value"] = $this->tipo_servicio->GetDBValue(true);
        $this->UpdateFields["nro_referencia1"]["Value"] = $this->Nro_ref1->GetDBValue(true);
        $this->UpdateFields["nro_referencia2"]["Value"] = $this->Nro_ref2->GetDBValue(true);
        $this->SQL = CCBuildUpdate("funcionario", $this->UpdateFields, $this);
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

} //End funcionarioDataSource Class @2-FCB6E20C

//Initialize Page @1-72CD12E5
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
$TemplateFileName = "Regfull_p1r.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "./";
$PathToRootOpt = "";
$Scripts = "|";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Include events file @1-1BD28463
include_once("./Regfull_p1_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-E7F4146C
$DBmadnes = new clsDBmadnes();
$MainPage->Connections["madnes"] = & $DBmadnes;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$funcionario = new clsRecordfuncionario("", $MainPage);
$MainPage->funcionario = & $funcionario;
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

//Execute Components @1-716EEE2C
$funcionario->Operation();
//End Execute Components

//Go to destination page @1-E2E80D88
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmadnes->close();
    header("Location: " . $Redirect);
    unset($funcionario);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-5650D7E4
$funcionario->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-B360D532
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmadnes->close();
unset($funcionario);
unset($Tpl);
//End Unload Page


?>
