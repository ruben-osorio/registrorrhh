<?php
//BindEvents Method @1-652F9117
function BindEvents()
{
    global $char_per;
    $char_per->date_end->CCSEvents["BeforeShow"] = "char_per_date_end_BeforeShow";
}
//End BindEvents Method

//char_per_date_end_BeforeShow @14-B014AFCA
function char_per_date_end_BeforeShow(& $sender)
{
    $char_per_date_end_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $char_per; //Compatibility
//End char_per_date_end_BeforeShow

//Close char_per_date_end_BeforeShow @14-EEB5076D
    return $char_per_date_end_BeforeShow;
}
//End Close char_per_date_end_BeforeShow


?>
