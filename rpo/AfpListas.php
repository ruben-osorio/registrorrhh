<?
require_once("security.php");
require ("config.inc.php");
require ("database.class.php");
include ("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

if (isset($_POST[to_excel]))
{
	echo "excel";
}
if (isset($_POST[submit]))
{
	switch($_POST[source])
	{
		case '1':									
			$query="select * from ".TABLE2.", ".TABLE22." ,".TABLE15."
			where ".TABLE2.".id_func=".TABLE22.".id_func
			and ".TABLE22.".status='1' 
			and ".TABLE15.".id_per=".TABLE22.".id_per 
			and ".TABLE15.".source_fin LIKE 'TGN'
			order by ".TABLE2.".l_name1, ".TABLE2.".l_name2 asc
			";						
			$fun="TGN";
		break;

		case '2':			
			$query="select * from ".TABLE2.",".TABLE30.",".TABLE17."  
			where ".TABLE2.".id_func=".TABLE30.".id_func 
			and ".TABLE30.".status='1' 
			and ".TABLE17.".id_con=".TABLE30.".id_con 
			and ".TABLE17.".source_fin LIKE 'CANASTA'
			order by ".TABLE17.".id_fin_con desc limit 1";		
			$fun="CANASTA";
		break;

		case '3':
			$query="select * from ".TABLE2.",".TABLE30.",".TABLE17."  
			where ".TABLE2.".id_func=".TABLE30.".id_func 
			and ".TABLE30.".status='1' 
			and ".TABLE17.".id_con=".TABLE30.".id_con 
			and ".TABLE17.".source_fin LIKE 'TGN-252'
			order by ".TABLE17.".id_fin_con desc limit 1";
			$fun="TGN-252";
		break;

		case '4':
			$query="select * from ".TABLE2.",".TABLE30.",".TABLE17."  
			where ".TABLE2.".id_func=".TABLE30.".id_func 
			and ".TABLE30.".status='1' 
			and ".TABLE17.".id_con=".TABLE30.".id_con 
			and ".TABLE17.".source_fin LIKE 'UNICEF'
			order by ".TABLE17.".id_fin_con desc limit 1";
			$fun="UNICEF";
		break;

		case '5':
			$query="select * from ".TABLE2.",".TABLE30.",".TABLE17."  
			where ".TABLE2.".id_func=".TABLE30.".id_func 
			and ".TABLE30.".status='1' 
			and ".TABLE17.".id_con=".TABLE30.".id_con 
			and ".TABLE17.".source_fin LIKE 'COSUDE'
			order by ".TABLE17.".id_fin_con desc limit 1";
			$fun="COSUDE";
		break;

		case '6':
			$query="select * from ".TABLE2.",".TABLE30.",".TABLE17."  
			where ".TABLE2.".id_func=".TABLE30.".id_func 
			and ".TABLE30.".status='1' 
			and ".TABLE17.".id_con=".TABLE30.".id_con 
			and ".TABLE17.".source_fin LIKE 'ASDI'
			order by ".TABLE17.".id_fin_con desc limit 1";
			$fun="ASDI";
		break;	
	}
}	
?>
<fieldset>
<legend>Obtener Listado de Funcionarios y AFP</legend>
<form name="form1" method="post" action="" class="form">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <td width="66%"><div align="right">Ver Lista de Funcionarios y NUA/CUA fuente:</div></td>
      <td width="11%"><label for="source"></label>
        <div align="left">
          <select name="source" id="source">
<option value="1">TGN</option>
            <option value="2">CANASTA</option>
            <option value="3">TGN-252</option>
            <option value="4">UNICEF</option>
            <option value="5">COSUDE</option>
            <option value="6">ASDI</option>
          </select>
        </div></td>
      <td width="23%"><div align="left">
        <input type="submit" name="submit" id="submit" value="Ver" class="submit">
      </div></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
      </tr>
  </table>
</form>
</fieldset>
<?
if (isset($query))
{
	echo '<fieldset>
	<legend>Nómina Funcionarios '.$fun.'</legend>
	<div style="padding: 5px; "><form id="form1" name="form1" method="post" action="" class="form">

  <input type="submit" name="to_excel" id="save" class="submit" value="Exportar a Excel" />

</form></div>
	
	<div class="table-wrap"><div class="table">	
	<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr class="even">    
    <th>Ap.Paterno</th>	
    <th>Ap.Materno</th>
	<th >Nombre(s)</th>
	<th >AFP</th>
	<th >NUA/CUA</th>
</tr>';
	$rs=$db->query($query);
	while ($r=$db->fetch_array($rs) )
	{
		echo ' <tr>   
			<td>'.$r[l_name1].'</td>
			<td>'.$r[l_name2].'</td>
		 	<td>'.$r[name].'</td>
		  	<td>'.$r[afp].'</td>
		  	<td>'.$r[nua].'
		</td>';	  	
	}
}
?>