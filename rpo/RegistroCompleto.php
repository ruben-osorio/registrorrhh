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
$id_per=$r1[id_per];	
//echo $r1[id_per];	
if(!$rs1)
{exit;
}
//echo "verdad";
?>
<table width="912" height="216" border="0" align="center">
  <tr>
    <td width="180" height="102"><a href="Regfull_p1.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 1, 'width=1200,height=1000,scrollbars=yes'); return false;"><img src="data/images/menu/1.png"/></a></td>
    <td width="180"><a href="Reg_dat_fam.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 2, 'width=1200,height=1000,scrollbars=yes'); return false;"><img src="data/images/menu/2.png" /></a></td>
    <td width="180"><a href="Reg_dat_ac.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 3, 'width=1200,height=1000,scrollbars=yes'); return false;"><img src="data/images/menu/3.png"/></a></td>
    <td width="180"><a href="Regdat_idi.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 4, 'width=1200,height=1000,scrollbars=yes'); return false;"><img src="data/images/menu/4.png"/></a></td>
    <td width="170"><a href="Reg_exp_lab.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 5, 'width=1200,height=1000,scrollbars=yes'); return false;"><img src="data/images/menu/5.png"/></a></td>
  </tr>
  <tr>
    <td height="108"><a href="Reg_cap_per.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 6, 'width=1200,height=1000,scrollbars=yes'); return false;"><img src="data/images/menu/6.png"/></a></td>
    <td><a href="regdat_lab-p.php<?
echo "?id_func=".$_SESSION['id_func']."&id_per=".$id_per;?>" target="_blank" onclick="window.open(this.href, 7, 'width=1200,height=1000,scrollbars=yes'); return false;"><img src="data/images/menu/7.png"/></a></td>
    <td><a href="regdat_fcper.php<?
echo "?id_func=".$_SESSION['id_func']."&id_per=".$id_per;?>" target="_blank" onclick="window.open(this.href, 8, 'width=1200,height=1000,scrollbars=yes'); return false;"><img src="data/images/menu/8.png"/></a></td>
    <td><a href="reg_mov_per.php<?
echo "?id_func=".$_SESSION['id_func']."&id_per=".$id_per;?>" target="_blank" onclick="window.open(this.href, 9, 'width=1200,height=1000,scrollbars=yes'); return false;"><img src="data/images/menu/9.png"/></a></td>
    <td><a href="reporteper.php<?
echo "?id_func=".$_SESSION['id_func']."&id_per=".$id_per;?>" target="_blank" onclick="window.open(this.href, 10, 'width=1200,height=1000,scrollbars=yes'); return false;"><img src="data/images/menu/10.png"/></a></td>
  </tr>
    <tr>
      <td colspan="6" ><strong>SERVIDOR TGN</strong> DESCARGAR <strong><a href="tutorial/FORM_INCOMPATIBILIDAD_VIGENTE_2012.xls" target="new">FORMULARIO DE INCOMPATIBILIDAD</a></strong><a href="tutorial/FORM_INCOMPATIBILIDAD_VIGENTE_2012.xls"></a></td>
    </tr>
</table>
<div style="width: 600px; height: 100%; margin: auto; background:#defcb3; color:#000; padding:10px; -webkit-border-radius: 10px;  -moz-border-radius: 10px;  border-radius: 10px; position:relative; margin-top:10px;">
 	<p>Sea <strong>CUIDADOSO</strong> al llenar los datos en cada formulario, ya que estos <strong>NO PODRÁN SER MODIFICADOS</strong></p>
    <p>Los <strong>SIGUIENTES PASOS QUEDARÁN ABIERTOS </strong>aún cuando usted haya <strong>REGISTRADO Y GUARDADO DATOS</strong>.
    <ul>
        <li><strong>REGISTRO DE DATOS FAMILIARES</strong></li>
        <li><strong>REGISTRO DE DATOS ACADEMICOS</strong></li>
        <li><strong>EXPERIENCIA FUERA DEL MINISTERIO </strong></li>
        <li><strong>CAPACITACION </strong></li>
        <li><strong>MOVILIDAD</strong></li>
  </ul></p>          
</div>
