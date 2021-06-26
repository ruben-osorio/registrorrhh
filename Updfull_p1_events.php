<?php
//BindEvents Method @1-E1AB6B63
function BindEvents()
{
    global $funcionario;
    $funcionario->date_born->CCSEvents["BeforeShow"] = "funcionario_date_born_BeforeShow";
}
//End BindEvents Method

//funcionario_date_born_BeforeShow @35-44F23464
function funcionario_date_born_BeforeShow(& $sender)
{
    $funcionario_date_born_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $funcionario; //Compatibility
//End funcionario_date_born_BeforeShow

//Close funcionario_date_born_BeforeShow @35-D7746A81
    return $funcionario_date_born_BeforeShow;
}
//End Close funcionario_date_born_BeforeShow


?>
