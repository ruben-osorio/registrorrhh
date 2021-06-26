<?php

include_once("db_connect.php");
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Viewport metatags -->
<meta name="HandheldFriendly" content="true" />
<meta name="MobileOptimized" content="320" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<!-- iOS webapp metatags -->
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<!-- iOS webapp icons -->
<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
<link rel="apple-touch-icon" sizes="72x72" href="touch-icon-ipad.png" />
<link rel="apple-touch-icon" sizes="114x114" href="touch-icon-retina.png" />

<!-- CSS Reset -->
<link rel="stylesheet" type="text/css" href="css/reset.css" media="screen" />
<!--  Fluid Grid System -->
<link rel="stylesheet" type="text/css" href="css/fluid.css" media="screen" />
<!-- Theme Stylesheet -->
<link rel="stylesheet" type="text/css" href="css/dandelion.theme.css" media="screen" />
<!--  Main Stylesheet -->
<link rel="stylesheet" type="text/css" href="css/dandelion.css" media="screen" />
<!-- Demo Stylesheet -->
<link rel="stylesheet" type="text/css" href="css/demo.css" media="screen" />

<!-- jQuery JavaScript File -->
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>

<!-- jQuery-UI JavaScript Files -->
<script type="text/javascript" src="jui/js/jquery-ui-1.8.20.min.js"></script>
<script type="text/javascript" src="jui/js/jquery.ui.timepicker.min.js"></script>
<script type="text/javascript" src="jui/js/jquery.ui.touch-punch.min.js"></script>
<link rel="stylesheet" type="text/css" href="jui/css/jquery.ui.all.css" media="screen" />

<!-- Plugin Files -->

<!-- FileInput Plugin -->
<script type="text/javascript" src="js/jquery.fileinput.js"></script>
<!-- Placeholder Plugin -->
<script type="text/javascript" src="js/jquery.placeholder.js"></script>
<!-- Mousewheel Plugin -->
<script type="text/javascript" src="js/jquery.mousewheel.min.js"></script>
<!-- Scrollbar Plugin -->
<script type="text/javascript" src="js/jquery.tinyscrollbar.min.js"></script>
<!-- Tooltips Plugin -->
<script type="text/javascript" src="plugins/tipsy/jquery.tipsy-min.js"></script>
<link rel="stylesheet" href="plugins/tipsy/tipsy.css" />
<!-- Spinner Plugin -->
<script type="text/javascript" src="jui/js/jquery.ui.spinner.min.js"></script>
<!-- DataTables Plugin -->
<script type="text/javascript" src="plugins/datatables/jquery.dataTables.min.js"></script>
<!-- Validation Plugin -->
<script type="text/javascript" src="plugins/validate/jquery.validate.min.js"></script>

<!-- Chosen Plugin -->
<script type="text/javascript" src="plugins/chosen/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="plugins/chosen/chosen.css" media="screen" />
<style type="text/css">
    body,td,th {
        font-family: "Helvetica Neue", Arial, Helvetica, sans-serif;
    }

    fotografiac
    {
        margin-right:auto;
    }
</style>

<!-- Demo JavaScript Files -->
<script type="text/javascript" src="js/demo/demo.validation.js"></script>

<!-- Core JavaScript Files -->
<script type="text/javascript" src="js/core/dandelion.core.js"></script>

<!-- Customizer JavaScript File (remove if not needed) -->
<script type="text/javascript" src="js/core/dandelion.customizer.js"></script>

<!-- Demo JavaScript Files -->
<script type="text/javascript" src="plugins/elastic/jquery.elastic.min.js"></script>
<script type="text/javascript" src="js/demo/demo.form.js"></script>




<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="dist_files/jquery.imgareaselect.js" type="text/javascript"></script>
<script src="dist_files/jquery.form.js"></script>
<link rel="stylesheet" href="dist_files/imgareaselect.css">
<script src="functionsFoto.js"></script>

<!-- Main Wrapper. Set this to 'fixed' for fixed layout and 'fluid' for fluid layout' -->
<div id="da-wrapper" class="fluid">

    <!-- Header -->
    <div id="da-header">

        <div id="da-header-top">

            <!-- Container -->
            <div class="da-container clearfix">

                <!-- Logo Container. All images put here will be vertically centere -->
                <div id="da-logo-wrap">
                    <div id="da-logo">
                        <div id="da-logo-img"><a href="dashboard.html"><img src="images/logo.png" alt="Dandelion Admin" width="280" height="90" /></a></div>
                    </div>
                </div>

                <!-- Header Toolbar Menu -->
                <!-- Header Toolbar Menu -->
                <div id="da-header-toolbar" class="clearfix">
                    <div id="da-user-profile">

                        <div id="da-user-info"><span class="da-user-title">Ministerio de Desarrollo Productivo</span>
                        </div>

                    </div>

                </div>

            </div>
        </div>

        <div id="da-header-bottom">
            <!-- Container -->
            <div class="da-container clearfix">



                <!-- Breadcrumbs -->
                <div id="da-breadcrumb">
                    <ul>
                        <li><a href="dashboard.html"><img src="images/icons/black/16/home.png" alt="Home" />Inicio</a></li>

                        <li class="active"><span>Fotografia para la ficha</span></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <!-- Content -->
    <div id="da-content">

        <!-- Container -->
        <div class="da-container clearfix">

            <!-- Sidebar -->
            <div id="da-sidebar-separator"></div>

            <!-- Main Content Wrapper -->


            <!-- Content Area -->
            <div id="da-content-area">
                <div class="grid_4">
                    <div class="da-panel">
                        <div class="da-panel-content">
                            <div class="grid_4">
                                <div class="da-panel">
                                    <div class="da-panel-header"> <span class="da-panel-title"> <img src="images/icons/color/accept.png" alt="" />
                	              <h2> FOTOGRAFIA DE FICHA</h2>

              	              </span> </div><br />

                                    <div class="da-panel-content">

                                        <!--ROA t1 -->
                                        <div class="grid_4">
                                            <div class="da-panel collapsible scrollable">
                                                <div class="da-panel-header"> <span class="da-panel-title"> <img src="images/icons/black/16/list.png" alt="" /> <a name="roa0" id="roa0"></a>Seleccionar imagen</span> </div>
                                                <div class="da-panel-content">







                                                        <h2>Seleccione una imagen en formato JPG, PNG o GIF</h2>

                                                        <div class="fotografiac">
                                                            <?php
                                                            include_once("db_connect.php");

                                                            //	if($post['id'])
                                                            //	{
                                                            $idfunc = $_GET['id_func'];

                                                            $imagen = "images/tmp/default.jpg";

                                                            $sql_get = "SELECT foto, ci FROM funcionario WHERE id_func = ". $idfunc ;
                                                            $resultset = mysqli_query($conn, $sql_get) or die("database error:". mysqli_error($conn));
                                                            if(mysqli_num_rows($resultset))
                                                            {
                                                                //$sql_update = "UPDATE funcionario set foto ='".mysqli_escape_string($conn,$post['image_name'])."' WHERE id_func = '".mysqli_escape_string($conn, $post['id'])."'";

                                                                //		$sql_update = "UPDATE funcionario set foto ='".mysqli_escape_string($conn,$post['image_name'])."' WHERE id_func = 3";
                                                                $dato = mysqli_fetch_array($resultset);

                                                                if ( $dato['foto'] =='' )
                                                                {
                                                                    $imagen = "images//tmp//default.jpg";
                                                                    $action = "save";
                                                                }
                                                                else {
                                                                    $imagen = "images//tmp//" . $dato['foto'];
                                                                    $action = "otro";
                                                                }

                                                                $ci = $dato['ci'];

                                                            }
                                                            //	}
                                                            echo "<img class='img-circle' id='profile_picture' height='128' data-src='" . $imagen . "'  data-holder-rendered='true' style='width: 140px; height: 140px;' src='" . $imagen . "'/>";
                                                            ?>


                                                            <br><br>
                                                            <a type="button" class="btn btn-primary" id="change-profile-pic">Agregar fotografia</a>
                                                        </div>
                                                        <div id="profile_pic_modal" class="modal fade">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        <h3>Agregar o editar fotografia</h3>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form id="cropimage" method="post" enctype="multipart/form-data" action="change_pic.php">
                                                                            <strong>Subir imagen (Dibuje un cuadro en la imagen):</strong> <br><br>
                                                                            <?php

                                                                            echo "<input type='hidden' name='id_func' value='" . $idfunc . "' id='id_func' />";
                                                                            echo "<input type='hidden' name='ci' value='" . $ci . "' id='ci' />";
                                                                            ?>
                                                                            <input type="file" name="profile-pic" id="profile-pic" />
                                                                            <input type="hidden" name="hdn-profile-id" id="hdn-profile-id" value="1" />
                                                                            <input type="hidden" name="hdn-x1-axis" id="hdn-x1-axis" value="" />
                                                                            <input type="hidden" name="hdn-y1-axis" id="hdn-y1-axis" value="" />
                                                                            <input type="hidden" name="hdn-x2-axis" value="" id="hdn-x2-axis" />
                                                                            <input type="hidden" name="hdn-y2-axis" value="" id="hdn-y2-axis" />
                                                                            <input type="hidden" name="hdn-thumb-width" id="hdn-thumb-width" value="" />
                                                                            <input type="hidden" name="hdn-thumb-height" id="hdn-thumb-height" value="" />
                                                                            <input type="hidden" name="action" value="" id="action" />
                                                                            <input type="hidden" name="image_name" value="" id="image_name" />

                                                                            <div id='preview-profile-pic'></div>
                                                                            <div id="thumbs" style="padding:5px; width:400p"></div>


                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                                        <button type="button" id="save_crop" class="btn btn-primary">Cortar y guardar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>



                                                    <div class="insert-post-ads1" style="margin-top:20px;">

                                                    </div>









                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div id="da-footer">
        <div class="da-container clearfix">
            <p>&nbsp;</p>
            <img src="images/logo_mini.jpg" alt="Ministerio de Educación " />
        </div>
    </div>
</div>


</body>