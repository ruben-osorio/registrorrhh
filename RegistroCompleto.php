<?
require_once("security.php");
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$id_func=$_SESSION['id_func'];
$rs1=$db->query("SELECT id_per FROM ".TABLE22." WHERE id_func = '$id_func'");
$r1=$db->fetch_array($rs1);


//datos funcionario
$rs2=$db->query("
	SELECT * FROM ".TABLE2." 
	WHERE id_func='$id_func'
	");
$rex=$db->fetch_array($rs2);



$id_per=$r1[id_per];	
//echo $r1[id_per];	
if(!$rs1)
{exit;
}
//echo "verdad";
?>

<!-- DIV CONTENEDOR -->
<link href="data/css/paradiv.css" rel="stylesheet" type="text/css">
<div style=" overflow:hidden">


<!-- cuadro para SSRP 1 -->
<div class="fadee" style=" margin-left:0 px;  padding-left: 0px; width: 25%; float:left "> 
<div   style="background: #fafafa ; border: 1px solid #ddd;border-radius: 4px;color: #444;padding: 0px; text-align:center;">
<div style="background:#e84c3d; border-top-left-radius:3px; border-top-right-radius:3px;">
<br>
</div>
<table style=" width:100%; " >
    <tr>
      <td style="padding:10px 2px 2px 2px;"> <a href="Regfull_p1.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 1, 'width=1200,height=1000,scrollbars=yes'); return false;"> <img src="data/images/num1.png"></a></td>
    </tr>
    
     <tr>
       <td> <a href="Regfull_p1.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 1, 'width=1200,height=1000,scrollbars=yes'); return false;"><h5 style="color: #606060;">REGISTRO DE DATOS PERSONALES EDUCACIONALES <br><br> </h5> </a> </td>
      </tr>
</table>
</div>
</div>
<!-- fin cuadro para SSRP 1 -->


<!-- cuadro para SSRP 2 -->
<div class="fadee" style="margin: 0;  padding-left: 10px; width: 25%; float:left "> 
<div  style="background: #fafafa ; border: 1px solid #ddd;border-radius: 4px;color: #444;padding: 0px; text-align:center;">

<div style="background:#9dc02e; border-top-left-radius:3px; border-top-right-radius:3px;">
<br>
</div>

<table style=" width:100%;" >
    <tr>
      <td style="padding:10px 2px 2px 2px;"> <a href="Reg_dat_fam.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 2, 'width=1200,height=1000,scrollbars=yes'); return false;"> <img src="data/images/num2.png"></a></td>
    </tr>
    
    
     <tr>
       <td><a href="Reg_dat_fam.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 2, 'width=1200,height=1000,scrollbars=yes'); return false;"> <h5 style="color: #606060;">REGISTRO DE DATOS<br>
FAMILIARES <br><br>   
       </h5>  </a>   </td>
      </tr>
      
</table>
</div>
</div>
<!-- fin cuadro para SSRP 2 -->


<!-- cuadro para SSRP 3 -->
<div class="fadee" style="margin: 0;  padding-left: 10px; width: 25%; float:left "> 
<div  style="background: #fafafa ; border: 1px solid #ddd;border-radius: 4px;color: #444;padding: 0px; text-align:center;">

<div style="background:#3598db; border-top-left-radius:3px; border-top-right-radius:3px;">
<br>
</div>

<table style=" width:100%;" >
    <tr>
      <td style="padding:10px 2px 2px 2px;"> <a href="Reg_dat_ac.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 3, 'width=1200,height=1000,scrollbars=yes'); return false;"><img src="data/images/num3.png"></a></td>
    </tr>
    
   
     <tr>
       <td><a href="Reg_dat_ac.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 3, 'width=1200,height=1000,scrollbars=yes'); return false;"> <h5 style="color: #606060;">REGISTRO DE DATOS<br>
ACADÉMICOS <br><br>  
       </h5> </a>    </td>
      </tr>
      
</table>
</div>
</div>
<!-- fin cuadro para SSRP 3 -->

<!-- cuadro para SSRP 4 -->
<div class="fadee" style="margin: 0;  padding-left: 10px; width: 25%; float:left "> 
<div  style="background: #fafafa ; border: 1px solid #ddd;border-radius: 4px;color: #444;padding: 0px; text-align:center;">

<div style="background:#fec240; border-top-left-radius:3px; border-top-right-radius:3px;">
<br>
</div>

<table style=" width:100%;" >
    <tr>
      <td style="padding:10px 2px 2px 2px;"> <a href="Regdat_idi.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 4, 'width=1200,height=1000,scrollbars=yes'); return false;"><img src="data/images/num4.png"></a></td>
    </tr>
    
        <tr>
       <td><a href="Regdat_idi.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 4, 'width=1200,height=1000,scrollbars=yes'); return false;"> <h5 style="color: #606060;">IDIOMAS CONOCIMIENTO<br>
        DOC. UNIVERSITARIA  <br><br>  
       </h5>  </a>   </td>
      </tr>
      
</table>
</div>
</div>
<!-- fin cuadro para SSRP 4 -->

<!-- cuadro para SSRP 5 -->
<div class="fadee" style=" margin-top:10px; padding-left: 0px; width: 25%; float:left; "> 
<div  style="background: #fafafa ; border: 1px solid #ddd;border-radius: 4px;color: #444;padding: 0px; text-align:center;">

<div style="background:#8d958a; border-top-left-radius:3px; border-top-right-radius:3px;">
<br>
</div>

<table style=" width:100%;" >
    <tr>
      <td style="padding:10px 2px 2px 2px;"> <a href="Reg_exp_lab.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 5, 'width=1200,height=1000,scrollbars=yes'); return false;"><img src="data/images/num5.png"></a></td>
    </tr>
    
    
     <tr>
       <td><a href="Reg_exp_lab.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 5, 'width=1200,height=1000,scrollbars=yes'); return false;"> <h5 style="color: #606060;">EXPERIENCIA<br>
        FUERA DEL GAMEA <br><br>   
       </h5>    </a> </td>
      </tr>
      
</table>
</div>
</div>
<!-- fin cuadro para SSRP 5 -->

<!-- cuadro para SSRP 6 -->
<div class="fadee" style=" margin-top:10PX;  padding-left: 10px; width: 25%; float:left "> 
<div  style="background: #fafafa ; border: 1px solid #ddd;border-radius: 4px;color: #444;padding: 0px; text-align:center;">

<div style="background:#297d7d; border-top-left-radius:3px; border-top-right-radius:3px;">
<br>
</div>

<table style=" width:100%;" >
    <tr>
      <td style="padding:10px 2px 2px 2px;"> <a href="Reg_cap_per.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 6, 'width=1200,height=1000,scrollbars=yes'); return false;"> <img src="data/images/num6.png"></a></td>
    </tr>
    
 
     <tr>
       <td><a href="Reg_cap_per.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 6, 'width=1200,height=1000,scrollbars=yes'); return false;"> <h5 style="color: #606060;">CAPACITACIÓN<br><br><br>
  
       </h5> </a>    </td>
      </tr>
      
</table>
</div>
</div>
<!-- fin cuadro para SSRP 6-->

<!-- cuadro para SSRP 7 -->
<div class="fadee" style=" margin-top:10PX;  padding-left: 10px; width: 25%; float:left "> 
<div  style="background: #fafafa ; border: 1px solid #ddd;border-radius: 4px;color: #444;padding: 0px; text-align:center;">

<div style="background:#e68f0c; border-top-left-radius:3px; border-top-right-radius:3px;">
<br>
</div>

<table style=" width:100%;" >
    <tr>
      <td style="padding:10px 2px 2px 2px;"> <a href="reg_mov_per.php<?
        echo "?id_func=".$_SESSION['id_func']."&id_per=".$id_per;?>" target="_blank" onclick="window.open(this.href, 7, 'width=1200,height=1000,scrollbars=yes'); return false;"> <img src="data/images/num7.png"></a></td>
    </tr>
    
    
     <tr>
       <td>  <a href="reg_mov_per.php<?
        echo "?id_func=".$_SESSION['id_func']."&id_per=".$id_per;?>" target="_blank" onclick="window.open(this.href, 7, 'width=1200,height=1000,scrollbars=yes'); return false;"><h5 style="color: #606060;">MOVILIDAD<br><br><br>
       </h5> </a>    </td>
      </tr>
      
</table>
</div>
</div>
<!-- fin cuadro para SSRP 7-->

<!-- cuadro para SSRP 8 -->
<div class="fadee" style=" margin-top:10PX;  padding-left: 10px; width: 25%; float:left "> 
<div  style="background: #fafafa ; border: 1px solid #ddd;border-radius: 4px;color: #444;padding: 0px; text-align:center;">

<div style="background:#f2594b; border-top-left-radius:3px; border-top-right-radius:3px;">
<br>
</div>

<table style=" width:100%;" >
    <tr>
      <td style="padding:10px 2px 2px 2px;"> <a href="fotografia.php<?
          echo "?id_func=".$_SESSION['id_func']."&id_per=".$id_per;?>" target="_blank" onclick="window.open(this.href, 7, 'width=1200,height=1000,scrollbars=yes'); return false;"> <img src="data/images/num8.png"></a></td>
    </tr>
    
    
     <tr>
       <td><a href="fotografia.php<?
          echo "?id_func=".$_SESSION['id_func']."&id_per=".$id_per;?>" target="_blank" onclick="window.open(this.href, 7, 'width=1200,height=1000,scrollbars=yes'); return false;">  <h5 style="color: #606060;">FOTOGRAFIA<br><br><br>
       </h5> </a>    </td>
      </tr>
      
</table>
</div>
</div>
<!-- fin cuadro para SSRP 8-->

<!-- cuadro para SSRP 9 -->
<div class="fadee" style=" margin-top:10px; padding-left: 0px; width: 25%; float:left; "> 
<div  style="background: #fafafa ; border: 1px solid #ddd;border-radius: 4px;color: #444;padding: 0px; text-align:center;">

<div style="background:#789129; border-top-left-radius:3px; border-top-right-radius:3px;">
<br>
</div>

<table style=" width:100%;" >
    <tr>
      <td style="padding:10px 2px 2px 2px;"> <a href="regdat_lab_p.php<?
echo "?id_func=".$_SESSION['id_func']."&id_per=".$id_per;?>" target="_blank" onclick="window.open(this.href, 7, 'width=1200,height=1000,scrollbars=yes'); return false;"><img src="data/images/num9.png"></a></td>
    </tr>
    
    
     <tr>
       <td><a href="regdat_lab_p.php<?
echo "?id_func=".$_SESSION['id_func']."&id_per=".$id_per;?>" target="_blank" onclick="window.open(this.href, 7, 'width=1200,height=1000,scrollbars=yes'); return false;"> <h5 style="color: #606060;">DATOS LABORALES<br>
       ANTIGUEDAD <br>
       CUENTA BANCARIA <br>
       DOCUMENTOS<br>
       DECLARACIONES<br>
       CARGO ACTUAL   
       </h5>  </a>   </td>
      </tr>
      
</table>
</div>
</div>
<!-- fin cuadro para SSRP 9 -->

<!-- cuadro para SSRP IMPRESION-->
<div class="fadee" style=" margin-top:7PX;  padding-left: 7px; padding-right:5px; width: 25%; float:left "> 
<div >
<?php

          if ( $rex[foto] !='' )
          {
              echo  "<a href=reporteper.php?id_func=".$_SESSION['id_func']."&id_per=".$id_per .
                  " target='_blank' onclick='window.open(this.href, 10, 'width=1200,height=1000,scrollbars=yes'); return false;'><img src='data/images/menu/11.png'/></a>";

          }
          else {

              echo "<a href='#'><img id = 'img' src='data/images/menu/11.png' /></a>";

                 }


        ?>
</div>
</div>
<!-- fin cuadro para SSRP IMPRESION-->
<!-- FIN DIV CONTENEDOR --></div>

</br>
<table width="912" height="30" border="0" align="center">
     <tr>
      <td colspan="6" ><strong>SERVIDOR TGN</strong> DESCARGAR <strong><a href="tutorial/FORM_INCOMPATIBILIDAD_GESTION_2018.xls" target="new">FORMULARIO DE INCOMPATIBILIDAD</a></strong><a href="tutorial/FORM_INCOMPATIBILIDAD_GESTION_2018.xls"></a></td>
    </tr>
</table>


<script type="text/javascript">
    $( "#img" ).click(function() {
        alert( "Para imprimir, debe completar el paso 9, subir su FOTOGRAFIA digital" );
    });
</script>