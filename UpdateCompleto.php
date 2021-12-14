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


<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

    <link rel="icon" type="image/png" href="assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="assets/img/favicon-32x32.png" sizes="32x32">

    <title>Altair Admin v2.9.1</title>

    <!-- additional styles for plugins -->
        <!-- weather icons -->
        <link rel="stylesheet" href="bower_components/weather-icons/css/weather-icons.min.css" media="all">
        <!-- metrics graphics (charts) -->
        <link rel="stylesheet" href="bower_components/metrics-graphics/dist/metricsgraphics.css">
        <!-- chartist -->
        <link rel="stylesheet" href="bower_components/chartist/dist/chartist.min.css">
    
    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

    <!-- flag icons -->
    <link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">

    <!-- style switcher -->
    <link rel="stylesheet" href="assets/css/style_switcher.min.css" media="all">
    
    <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.min.css" media="all">

    <!-- themes -->
    <link rel="stylesheet" href="assets/css/themes/themes_combined.min.css" media="all">

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
        <link rel="stylesheet" href="assets/css/ie.css" media="all">
    <![endif]-->  
</head>
<body class=" sidebar_main_open sidebar_main_swipe">
    <!-- main header -->
    <div id="page_content_inner">


        <!-- circular charts -->
        <!--LO QUE ESTA ABAJO ES EL MARGEN-->
        <h4 class="heading_a uk-margin-bottom"><strong>Funcionarios</strong></h4>
        <hr style="border:solid 2px #9b9c76;">

        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card">
                <div class="uk-overflow-container">

                <!--DA EL FORMATO A LOS RECUADROS-->      
                <div class="uk-grid uk-grid-width-small-1-2 uk-grid-width-large-1-3 uk-grid-width-xlarge-1-5 uk-text-center " id="dashboard_sortable_cards"data-uk-grid-margin>

                    <!--Tomar en cuenta desde aqui : SON LOS RECUADROS-->
                    <div>
                        <br>
                        <div class="md-card md-card-hover md-card-overlay">
                        <a href="Regfull_p1.php<?
                                echo "?id_func=".$id_func;?>" 
                                target="_blank" 
                                onClick="window.open(this.href, 1, 'width=1200,height=1000,scrollbars=yes'); 
                                return false;">
                                <h2>
                                 <font color="#3fa5b5">
                                    <strong>Paso 1</strong>
                                 </font>
                                </h2>
                                
                            <div class="md-card-content">
                                <div class="epc_chart" data-percent="100" data-bar-color="#03a9f4">
                                    <span class="epc_chart_icon">
                                            
                                        <i class="uk-icon-user uk-icon-large"></i>
                                            
                                    </span>    
                                </div>
                            </div>   
                        </a>
                            <div class="md-card-overlay-content">
                                <div class="uk-clearfix md-card-overlay-header">
                                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                                    <a href="Regfull_p1.php<?
                                        echo "?id_func=".$id_func;?>" 
                                        target="_blank" 
                                        onClick="window.open(this.href, 1, 'width=1200,height=1000,scrollbars=yes'); 
                                        return false;">
                                        <h3>
                                            <strong>Registro De Datos Personales Educacionales</strong>
                                        </h3> 
                                    </a>  
                                </div>
                                <div class="uk-clearfix md-card-overlay-header">
                                <h3>
                                <strong>Datos Personales</strong><br>
                                    - Carnet de identidad<br>
                                    - Nacionalidad<br>
                                    - Departamento nacimiento...............
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>


                    <div>
                        <br>
                        <div class="md-card md-card-hover md-card-overlay">
                        <a href="Reg_dat_fam.php<?
                                echo "?id_func=".$id_func;?>" 
                                target="_blank" 
                                onClick="window.open(this.href, 2, 'width=1200,height=1000,scrollbars=yes'); 
                                return false;">
                                <h2>
                                 <font color="#089a5b">
                                    <strong>Paso 2</strong>
                                 </font>
                                </h2>
                            <div class="md-card-content">
                                <div class="epc_chart" data-percent="100" data-bar-color="#009688">
                                    <span class="epc_chart_icon">
                                        
                                        <i class="uk-icon-group uk-icon-large"></i>

                                    </span>
                                </div>
                            </div>
                        </a>    
                            <div class="md-card-overlay-content">
                                <div class="uk-clearfix md-card-overlay-header">
                                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                                    <a href="Reg_dat_fam.php<?
                                        echo "?id_func=".$id_func;?>" 
                                        target="_blank" 
                                        onClick="window.open(this.href, 2, 'width=1200,height=1000,scrollbars=yes'); 
                                        return false;">
                                        <h3>
                                            <strong>Registro De Datos Familiares</strong>
                                        </h3>
                                    </a>    
                                </div>
                                <div class="uk-clearfix md-card-overlay-header">
                                <h3>
                                <strong>Lista De familiares Registrados</strong><br>
                                    - Acciones...............................<br>
                                <strong>Datos De Familiares</strong><br>
                                    - Seleccionar parentesco..........
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>


                    <div>
                        <br>
                        <div class="md-card md-card-hover md-card-overlay">
                        <a href="Reg_dat_ac.php<?
                                    echo "?id_func=".$id_func;?>" 
                                    target="_blank" 
                                    onClick="window.open(this.href, 3, 'width=1200,height=1000,scrollbars=yes'); 
                                    return false;">
                                    <h2>
                                      <font color="#116b8c">
                                        <strong>Paso 3</strong>
                                      </font>
                                    </h2>     
                            <div class="md-card-content">
                                <div class="epc_chart" data-percent="100" data-bar-color="#607d8b">
                                    <span class="epc_chart_icon">
                                        
                                        <i class="uk-icon-institution  uk-icon-large"></i>
                                        
                                    </span>    
                                </div>
                            </div> 
                        </a>  

                            <div class="md-card-overlay-content">
                                <div class="uk-clearfix md-card-overlay-header">
                                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                                    <a href="Reg_dat_ac.php<?
                                        echo "?id_func=".$id_func;?>" 
                                        target="_blank" 
                                        onClick="window.open(this.href, 3, 'width=1200,height=1000,scrollbars=yes'); 
                                        return false;">
                                        <h3>
                                            <strong>Registro De Datos Academicos</strong>
                                        </h3>
                                    </a>   
                                </div>
                                <div class="uk-clearfix md-card-overlay-header">
                                <h3>
                                <strong>Listado</strong><br>
                                    - Acciones...............................<br>
                                <strong>Datos Academicos</strong><br>
                                    - Nivel.....................................
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>


                    <div>
                        <br>
                        <div class="md-card md-card-hover md-card-overlay">
                        <a href="Regdat_idi.php<?
                            echo "?id_func=".$id_func;?>" 
                            target="_blank" 
                            onClick="window.open(this.href, 4, 'width=1200,height=1000,scrollbars=yes'); 
                            return false;">
                            <h2>
                                <font color="#9f1602">
                                    <strong>Paso 4</strong>
                                </font>
                            </h2>  
                            <div class="md-card-content">
                                <div class="epc_chart" data-percent="100" data-bar-color="#a52a2a">
                                    <span class="epc_chart_icon">
                                        
                                        <i class="uk-icon-language  uk-icon-large"></i>
                                        
                                    </span>    
                                </div>
                            </div>
                        </a>       

                            <div class="md-card-overlay-content">
                                <div class="uk-clearfix md-card-overlay-header">
                                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                                    <a href="Regdat_idi.php<?
                                        echo "?id_func=".$id_func;?>" 
                                        target="_blank" 
                                        onClick="window.open(this.href, 4, 'width=1200,height=1000,scrollbars=yes'); 
                                        return false;">
                                        <h3>
                                            <strong>Idiomas Conocimiento Doc. Universitaria</strong>
                                        </h3>
                                    </a>       
                                </div>
                                <div class="uk-clearfix md-card-overlay-header">
                                <h3>
                                <strong>Idiomas</strong><br>
                                    - Descripción..............................<br>
                                <strong>Otros Conocimientos</strong><br>
                                    - Descripción..............................
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>


                    <div>
                        <br>
                        <div class="md-card md-card-hover md-card-overlay">
                        <a href="Reg_exp_lab.php<?
                                echo "?id_func=".$id_func;?>" 
                                target="_blank" 
                                onClick="window.open(this.href, 5, 'width=1200,height=1000,scrollbars=yes'); 
                                return false;">
                                <h2>
                                   <font color="#0a41ad">
                                     <strong>Paso 5</strong>
                                   </font>
                                </h2>
                            <div class="md-card-content">
                                <div class="epc_chart" data-percent="100" data-bar-color="#191970">
                                    <span class="epc_chart_icon">
                                        
                                        <i class="uk-icon-folder-open  uk-icon-large"></i>
                                        
                                    </span>    
                                </div>
                            </div>
                        </a>    

                            <div class="md-card-overlay-content">
                                <div class="uk-clearfix md-card-overlay-header">
                                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                                    <a href="Reg_exp_lab.php<?
                                        echo "?id_func=".$id_func;?>" 
                                        target="_blank" 
                                        onClick="window.open(this.href, 5, 'width=1200,height=1000,scrollbars=yes'); 
                                        return false;">
                                        <h3>
                                           <strong>Experiencia Fuera Del GAMEA</strong>
                                        </h3>   
                                    </a>   
                                </div>
                                <div class="uk-clearfix md-card-overlay-header">
                                <h3>
                                <strong>Experiencia Laboral</strong><br>
                                    - Acciones................................<br>
                                <strong>Datos Academicos</strong><br>
                                    - Nombre de la institución..............
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>


                    <div>
                        <br>
                        <div class="md-card md-card-hover md-card-overlay">
                        <a href="Reg_cap_per.php<?
                                echo "?id_func=".$id_func;?>" 
                                target="_blank" 
                                onClick="window.open(this.href, 6, 'width=1200,height=1000,scrollbars=yes'); 
                                return false;">
                                <h2>
                                   <font color="#d3ca17">
                                     <strong>Paso 6</strong>
                                   </font>
                                </h2>
                            <div class="md-card-content">
                                <div class="epc_chart" data-percent="100" data-bar-color="#daa520">
                                    <span class="epc_chart_icon">
                                        
                                        <i class="uk-icon-graduation-cap  uk-icon-large"></i>
                                        
                                    </span>    
                                </div>
                            </div>
                        </a>       

                            <div class="md-card-overlay-content">
                                <div class="uk-clearfix md-card-overlay-header">
                                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                                    <a href="Reg_cap_per.php<?
                                        echo "?id_func=".$id_func;?>" 
                                        target="_blank" 
                                        onClick="window.open(this.href, 6, 'width=1200,height=1000,scrollbars=yes'); 
                                        return false;">                                    
                                        <h3>
                                            <strong>Capacitación</strong>
                                        </h3>   
                                    </a>    
                                </div>
                                <div class="uk-clearfix md-card-overlay-header">
                                <h3>
                                <strong>Capacitación</strong><br>
                                    - Acciones................................<br>
                                <strong>Registro de eventos de Capacitación</strong><br>
                                    - Nombre del evento.....................
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>


                    <div>
                        <br>
                        <div class="md-card md-card-hover md-card-overlay">
                        <a href="reg_mov_per.php<?
                                echo "?id_func=".$id_func."&id_per=".$id_per;?>" 
                                target="_blank" 
                                onClick="window.open(this.href, 9, 'width=1200,height=1000,scrollbars=yes,scrollbars=yes'); 
                                return false;">
                                <h2>
                                   <font color="#85a532">
                                     <strong>Paso 7</strong>
                                   </font>
                                </h2>
                            <div class="md-card-content">
                                <div class="epc_chart" data-percent="100" data-bar-color="#808000">
                                    <span class="epc_chart_icon">
                                        
                                        <i class="uk-icon-random  uk-icon-large"></i>
                                        
                                    </span>    
                                </div>
                            </div>
                        </a>       

                            <div class="md-card-overlay-content">
                                <div class="uk-clearfix md-card-overlay-header">
                                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                                    <a href="reg_mov_per.php<?
                                        echo "?id_func=".$id_func."&id_per=".$id_per;?>" 
                                        target="_blank" 
                                        onClick="window.open(this.href, 9, 'width=1200,height=1000,scrollbars=yes,scrollbars=yes'); 
                                        return false;">
                                        <h3>
                                            <strong>Movilidad</strong>
                                        </h3>  
                                    </a> 
                                </div>
                                <div class="uk-clearfix md-card-overlay-header">
                                <h3>
                                <strong>Listado de movilidad</strong><br>
                                    - Acciones..............................<br>
                                <strong>Registro de movilidades de puestos</strong><br>
                                    - Cargo en la institución.....................
                                </h3>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>


                    <div>
                        <br>
                        <div class="md-card md-card-hover md-card-overlay">
                        <a href="ModificaFinCat.php<?
                                echo "?id_func=".$id_func."&id_per=".$id_per;?>" 
                                target="_blank" 
                                onClick="window.open(this.href, 8, 'width=1000,height=700,scrollbars=yes,scrollbars=yes'); 
                                return false;">
                                <h2>
                                   <font color="#f2930a">
                                     <strong>Paso 8</strong>
                                   </font>
                                </h2>
                            <div class="md-card-content">
                                <div class="epc_chart" data-percent="100" data-bar-color="#ff8c00">
                                    <span class="epc_chart_icon">
                                        
                                        <i class="uk-icon-check-square  uk-icon-large"></i>
                                        
                                    </span>    
                                </div>
                            </div>
                        </a>       

                            <div class="md-card-overlay-content">
                                <div class="uk-clearfix md-card-overlay-header">
                                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                                    <a href="ModificaFinCat.php<?
                                        echo "?id_func=".$id_func."&id_per=".$id_per;?>" 
                                        target="_blank" 
                                        onClick="window.open(this.href, 8, 'width=1000,height=700,scrollbars=yes,scrollbars=yes'); 
                                        return false;">
                                        <h3>
                                            <strong>Categoría y Evaluación</strong>
                                        </h3>
                                    </a>       
                                </div>
                                <div class="uk-clearfix md-card-overlay-header">
                                <h3>
                                <strong>Categoría</strong><br>
                                    - Categoría..............................<br>
                                <strong>Evaluación</strong><br>
                                    - Fecha de evaluación.....................
                                </h3>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>


                    <div>
                        <br>
                        <div class="md-card md-card-hover md-card-overlay">
                        <a href="ModificaRegdatLabP.php<?
                                    echo "?id_func=".$id_func."&id_per=".$id_per;?>" 
                                    target="_blank" 
                                    onClick="window.open(this.href, 7, 'width=1200,height=1000,scrollbars=yes'); 
                                    return false;">
                                    <h2>
                                        <font color="#453489">
                                           <strong>Paso 9</strong>
                                        </font>
                                    </h2>
                            <div class="md-card-content">
                                <div class="epc_chart" data-percent="100" data-bar-color="#483d8b">
                                    <span class="epc_chart_icon">
                                        
                                        <i class="uk-icon-edit  uk-icon-large"></i>
                                        
                                    </span>    
                                </div>
                            </div>
                        </a>   

                            <div class="md-card-overlay-content">
                                <div class="uk-clearfix md-card-overlay-header">
                                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                                    <a href="ModificaRegdatLabP.php<?
                                        echo "?id_func=".$id_func."&id_per=".$id_per;?>" 
                                        target="_blank" 
                                        onClick="window.open(this.href, 7, 'width=1200,height=1000,scrollbars=yes'); 
                                        return false;">
                                        <h3>
                                            <strong>Datos Laborales</strong>
                                        </h3>
                                    </a>   
                                </div>
                                <div class="uk-clearfix md-card-overlay-header">
                                <h3>
                                <strong>Datos Laborales</strong><br>
                                <strong>Datos De Antiguedad</strong><br>
                                <strong>Documentación Entregada</strong><br>
                                <strong>Datos Del Cargo Actual Que Desempeña</strong>
                                </h3>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>


                    <div>
                        <br>
                        <div class="md-card md-card-hover md-card-overlay">
                        <a href="reporteper.php<?
                                echo "?id_func=".$id_func."&id_per=".$id_per;?>" 
                                target="_blank" 
                                onClick="window.open(this.href, 10, 'width=1200,height=1000, scrollbars=yes'); 
                                return false;">
                                <h2>
                                    <font color="#1e7415">
                                        <strong>Impresión</strong>
                                    </font>
                                </h2>
                            <div class="md-card-content">
                                <div class="epc_chart" data-percent="100" data-bar-color="#2e8b57">
                                    <span class="epc_chart_icon">
                                        
                                        <i class="uk-icon-file  uk-icon-large"></i>
                                        
                                    </span>    
                                </div>
                            </div>
                        </a>       

                            <div class="md-card-overlay-content">
                                <div class="uk-clearfix md-card-overlay-header">
                                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                                    <a href="reporteper.php<?
                                        echo "?id_func=".$id_func."&id_per=".$id_per;?>" 
                                        target="_blank" 
                                        onClick="window.open(this.href, 10, 'width=1200,height=1000, scrollbars=yes'); 
                                        return false;">
                                        <h3>
                                            <strong>Reporte Para Impresión</strong>
                                        </h3>   
                                    </a>    
                                </div>
                                <div class="uk-clearfix md-card-overlay-header">
                                <h3>
                                    Se imprimira la ficha personal
                                </h3>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                    <!--tomar en cuenta hasta aqui : son los RECUADROS-->
                
                </div>    



                </div>
            </div>
        </div>    





 
 

    <!-- common functions -->
    <script src="assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <script src="assets/js/altair_admin_common.min.js"></script>

    <!-- page specific plugins -->
        <!-- d3 -->
        <script src="bower_components/d3/d3.min.js"></script>
        <!-- metrics graphics (charts) -->
        <script src="bower_components/metrics-graphics/dist/metricsgraphics.min.js"></script>
        <!-- chartist (charts) -->
        <script src="bower_components/chartist/dist/chartist.min.js"></script>
        <!-- maplace (google maps) -->
        
        <script src="bower_components/maplace-js/dist/maplace.min.js"></script>
        <!-- peity (small charts) -->
        <script src="bower_components/peity/jquery.peity.min.js"></script>
        <!-- easy-pie-chart (circular statistics) -->
        <script src="bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
        <!-- countUp -->
        <script src="bower_components/countUp.js/dist/countUp.min.js"></script>
        <!-- handlebars.js -->
        <script src="bower_components/handlebars/handlebars.min.js"></script>
        <script src="assets/js/custom/handlebars_helpers.min.js"></script>
        <!-- CLNDR -->
        <script src="bower_components/clndr/clndr.min.js"></script>

        <!--  dashbord functions -->
        <script src="assets/js/pages/dashboard.min.js"></script>
</body>
</html>
