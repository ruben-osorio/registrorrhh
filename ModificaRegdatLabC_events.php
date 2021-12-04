<?php
//BindEvents Method @1-8AB1D8CB
function BindEvents()
{
    global $ult_decl;
    global $consultor_docs;
    global $char_con;
    global $contrato;
    $ult_decl->date_di->CCSEvents["BeforeShow"] = "ult_decl_date_di_BeforeShow";
    $consultor_docs->date_cad_ci->CCSEvents["BeforeShow"] = "consultor_docs_date_cad_ci_BeforeShow";
    $char_con->date_des->CCSEvents["BeforeShow"] = "char_con_date_des_BeforeShow";
    $char_con->date_end->CCSEvents["BeforeShow"] = "char_con_date_end_BeforeShow";
    $contrato->date_ent->CCSEvents["BeforeShow"] = "contrato_date_ent_BeforeShow";
    $contrato->date_end->CCSEvents["BeforeShow"] = "contrato_date_end_BeforeShow";
}
//End BindEvents Method

//ult_decl_date_di_BeforeShow @38-D7A72A87
function ult_decl_date_di_BeforeShow(& $sender)
{
    $ult_decl_date_di_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $ult_decl; //Compatibility
//End ult_decl_date_di_BeforeShow

//Close ult_decl_date_di_BeforeShow @38-4120FFF6
    return $ult_decl_date_di_BeforeShow;
}
//End Close ult_decl_date_di_BeforeShow

//consultor_docs_date_cad_ci_BeforeShow @48-853B24D9
function consultor_docs_date_cad_ci_BeforeShow(& $sender)
{
    $consultor_docs_date_cad_ci_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $consultor_docs; //Compatibility
//End consultor_docs_date_cad_ci_BeforeShow

//Close consultor_docs_date_cad_ci_BeforeShow @48-EDDC1B23
    return $consultor_docs_date_cad_ci_BeforeShow;
}
//End Close consultor_docs_date_cad_ci_BeforeShow

//char_con_date_des_BeforeShow @67-DC022ACF
function char_con_date_des_BeforeShow(& $sender)
{
    $char_con_date_des_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $char_con; //Compatibility
//End char_con_date_des_BeforeShow

//Close char_con_date_des_BeforeShow @67-FA0DA3DB
    return $char_con_date_des_BeforeShow;
}
//End Close char_con_date_des_BeforeShow

//char_con_date_end_BeforeShow @69-3A3E941E
function char_con_date_end_BeforeShow(& $sender)
{
    $char_con_date_end_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $char_con; //Compatibility
//End char_con_date_end_BeforeShow

//Close char_con_date_end_BeforeShow @69-89EE0218
    return $char_con_date_end_BeforeShow;
}
//End Close char_con_date_end_BeforeShow

//contrato_date_ent_BeforeShow @78-96515273
function contrato_date_ent_BeforeShow(& $sender)
{
    $contrato_date_ent_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $contrato; //Compatibility
//End contrato_date_ent_BeforeShow

//Close contrato_date_ent_BeforeShow @78-41DDFAD3
    return $contrato_date_ent_BeforeShow;
}
//End Close contrato_date_ent_BeforeShow

//contrato_date_end_BeforeShow @80-613E5863
function contrato_date_end_BeforeShow(& $sender)
{
    $contrato_date_end_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $contrato; //Compatibility
//End contrato_date_end_BeforeShow

//Close contrato_date_end_BeforeShow @80-276FC6BF
    return $contrato_date_end_BeforeShow;
}
//End Close contrato_date_end_BeforeShow


?>
