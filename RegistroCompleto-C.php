<?
require_once("security.php");
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$id_func=$_SESSION['id_func'];
$rs=$db->query("SELECT id_con FROM ".TABLE30." WHERE id_func = '$id_func'");
$r1=$db->fetch_array($rs);
$id_con=$r1[id_con];	
/*echo $r1[id_con];
echo "llega";	*/
if(!$rs)
{
	exit;
}
//echo "verdad";
?>

<table width="auto" height="auto" border="0" align="center">
  <tr>
    <td width="180" height="102"><a href="Regfull_p1.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" 
onclick="window.open(this.href, 1, 'width=1200,height=900,scrollbars=yes'); return false;"><img src="data/images/menu/1.png"/></a></td>
    <td width="180"><a href="Reg_dat_fam.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 2, 'width=1200,height=900,scrollbars=yes'); return false;"><img src="data/images/menu/2.png" /></a></td>
    <td width="180"><a href="Reg_dat_ac.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 3, 'width=1200,height=900,scrollbars=yes'); return false;"><img src="data/images/menu/3.png"/></a></td>
    <td width="180"><a href="Regdat_idi.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 4, 'width=1200,height=900,scrollbars=yes'); return false;"><img src="data/images/menu/4.png"/></a></td>
    
  </tr>
  <tr>
    <td height="108"><a href="Reg_exp_lab.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 5, 'width=1200,height=900,scrollbars=yes'); return false;"><img src="data/images/menu/5.png"/></a></td>
    <td><a href="Reg_cap_per.php<?
echo "?id_func=".$_SESSION['id_func'];?>" target="_blank" onclick="window.open(this.href, 6, 'width=1200,height=900,scrollbars=yes'); return false;"><img src="data/images/menu/6.png"/></a></td>
    <td><a href="regdat_lab_c.php<?
echo "?id_func=".$_SESSION['id_func']."&id_con=".$id_con;?>" target="_blank" onclick="window.open(this.href, 7, 'width=1200,height=900,scrollbars=yes'); return false;"><img src="data/images/menu/7c.png"/></a></td>
    <td><a href="regdat_fccon.php<?
echo "?id_func=".$_SESSION['id_func']."&id_con=".$id_con;?>" target="_blank" onclick="window.open(this.href, 8, 'width=1200,height=900,scrollbars=yes'); return false;"><img src="data/images/menu/8c.png"/></a></td>
    
  </tr>
  <tr>
    <td height="108">
	 	<a href="fotografia.php<?
echo "?id_func=".$_SESSION['id_func']."&id_con=".$id_con;?>" target="_blank" onclick="window.open(this.href, 9, 'width=1200,height=900,scrollbars=yes'); return false;"><img src="data/images/menu/9c.png"/></a> 
	 </td>
    <td>
		<a href="reportecon.php<?
echo "?id_func=".$_SESSION['id_func']."&id_con=".$id_con;?>" target="_blank" onclick="window.open(this.href, 10, 'width=1200,height=900,scrollbars=yes'); return false;"><img src="data/images/menu/10.png"/></a>  
	</td>
    <td></td>
    <td></td>
    
  </tr>
  <tr>
    <td colspan="6" ><strong>PERSONAL EVENTUAL</strong></td>
  </tr>
</table>
