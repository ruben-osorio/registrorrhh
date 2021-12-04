<?
require_once("security.php");
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$id_func=$_GET[id_func];
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
    <td colspan="6" ><strong>SERVIDOR TGN</strong></td>
</tr>
  <tr>
    <td width="180" height="102"><a href="Updfull_p1.php<?
echo "?id_func=".$id_func;?>" target="_blank" onClick="window.open(this.href, 1, 'width=1200,height=1000,scrollbars=yes'); return false;"><img src="data/images/menu/1.png"/></a></td>
    <td width="180"><a href="ModificaDatFam.php<?
echo "?id_func=".$id_func;?>" target="_blank" onClick="window.open(this.href, 2, 'width=1200,height=1000,scrollbars=yes'); return false;"><img src="data/images/menu/2.png" /></a></td>
    <td width="180"><a href="ModificaDatAc.php<?
echo "?id_func=".$id_func;?>" target="_blank" onClick="window.open(this.href, 3, 'width=1200,height=1000,scrollbars=yes'); return false;"><img src="data/images/menu/3.png"/></a></td>
    <td width="180"><a href="Upddat_idi.php<?
echo "?id_func=".$id_func;?>" target="_blank" onClick="window.open(this.href, 4, 'width=1200,height=1000,scrollbars=yes'); return false;"><img src="data/images/menu/4.png"/></a></td>
    <td width="170"><a href="ModificaExpLab.php<?
echo "?id_func=".$id_func;?>" target="_blank" onClick="window.open(this.href, 5, 'width=1200,height=1000,scrollbars=yes'); return false;"><img src="data/images/menu/5.png"/></a></td>
  </tr>
  <tr>
    <td height="108"><a href="ModificaCapPer.php<?
echo "?id_func=".$id_func;?>" target="_blank" onClick="window.open(this.href, 6, 'width=1200,height=1000,scrollbars=yes'); return false;"><img src="data/images/menu/6.png"/></a></td>
    <td><a href="ModificaRegdatLabP.php<?
echo "?id_func=".$id_func."&id_per=".$id_per;?>" target="_blank" onClick="window.open(this.href, 7, 'width=1200,height=1000,scrollbars=yes'); return false;"><img src="data/images/menu/7.png"/></a></td>
    <td><a href="ModificaFinCat.php<?
echo "?id_func=".$id_func."&id_per=".$id_per;?>" target="_blank" onClick="window.open(this.href, 8, 'width=1000,height=700,scrollbars=yes,scrollbars=yes'); return false;"><img src="data/images/menu/8.png"/></a></td>
    <td><a href="ModificaRegMovPer.php<?
echo "?id_func=".$id_func."&id_per=".$id_per;?>" target="_blank" onClick="window.open(this.href, 9, 'width=1200,height=1000,scrollbars=yes,scrollbars=yes'); return false;"><img src="data/images/menu/9.png"/></a></td>
    <td><a href="reporteper.php<?
echo "?id_func=".$id_func."&id_per=".$id_per;?>" target="_blank" onClick="window.open(this.href, 10, 'width=1200,height=1000, scrollbars=yes'); return false;"><img src="data/images/menu/10.png"/></a></td>
  </tr>    
</table>
