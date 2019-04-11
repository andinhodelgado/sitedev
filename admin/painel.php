<?php
ob_start();
session_start();
require('../_app/Config.inc.php');
$getexe = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);
define('FPDF_FONTPATH', '/pdf/font/');
require '/pdf/fpdf.php';

if (empty($_SESSION['userlogin'])):
    unset($_SESSION['userlogin']);
    header('Location: index.php');
else:
    $user = $_SESSION['userlogin'];
endif;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Usina Santa Fé S.A.</title>
        <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/boot.css?v=1" />
        <link rel="stylesheet" href="css/stylemain.css?v=1" />
        <link rel="stylesheet" media="screen and (min-width: 0px) and (max-width: 1023px)" href="css/style1.css?v=1"/>
        <link rel="stylesheet" media="screen and (min-width: 1024px) and (max-width: 1279px)" href="css/style2.css?v=1"/>
        <link rel="stylesheet" media="screen and (min-width: 1280px) and (max-width: 1359px)" href="css/style3.css?v=1"/>
        <link rel="stylesheet" media="screen and (min-width: 1360px) and (max-width: 1599px)" href="css/style4.css?v=1"/>
        <link rel="stylesheet" media="screen and (min-width: 1600px) and (max-width: 1919px)" href="css/style5.css?v=1"/>
        <link rel="stylesheet" media="screen and (min-width: 1920px)" href="css/style6.css?v=1"/>
        <link rel="shortcut icon" href="icons/icone.ico"/>
        <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">

    </head>
    <body>
        <header class="main_header">
            <div >
                <a href="../index.php">
                    <div class="area_logo">
                        <img src="icons/logo.png" />
                        <h1 >Usina Santa Fé S.A.</h1>
                        <div class="clear"></div>
                    </div>
                </a>
                <nav class="main-nav">
                    <ul class="menu">
                        <li class="menu_item"><a href="painel.php" title="">Dashboard</a></li>
                        <li class="menu_item"><a href="#" title="CADASTRADOS">Cadastrados</a>
                            <ul class="sub_menu_item">

                                <?php
                                if ($user['NIVEL'] == 'ADMINISTRADOR') {
                                    ?>
                                    <li ><a href="painel.php?exe=documentos/index" title="">Documentos</a></li>
                                    <li ><a href="painel.php?exe=noticias/index" title="">Notícias</a></li>
                                    <li ><a href="painel.php?exe=vagas/index" title="">Vagas de Emprego</a></li>
                                    <li ><a href="painel.php?exe=politicasrh/index" title="">Políticas de RH</a></li>
                                    <?php
                                } elseif ($user['NIVEL'] == 'FINANCEIRO') {
                                    ?>
                                    <li ><a href="painel.php?exe=documentos/index" title="">Documentos</a></li> 
                                    <?php
                                } elseif ($user['NIVEL'] == 'CONTRATAÇÃO') {
                                    ?>
                                    <li ><a href="painel.php?exe=vagas/index" title="">Vagas de Emprego</a></li>
                                    <?php
                                } elseif ($user['NIVEL'] == 'NOTÍCIA') {
                                    ?>
                                    <li ><a href="painel.php?exe=noticias/index" title="">Notícias</a></li>
									<li ><a href="painel.php?exe=vagas/index" title="">Vagas de Emprego</a></li>
                                    <?php
                                } elseif ($user['NIVEL'] == 'ADM. POL. DE RH') {
                                    ?>
                                    <li ><a href="painel.php?exe=politicasrh/index" title="">Políticas de RH</a></li>
                                    <?php
                                }
                                ?>

                            </ul>
                        </li>
                        <li class="menu_item"><a href="painel.php?exe=usuario/index" title="USUÁRIOS">Usuários</a>
                        <li class="menu_item"><a href="#" title="USUÁRIOS">Relatórios</a>
                            <ul class="sub_menu_item">

                                <?php
                                if ($user['NIVEL'] == 'ADMINISTRADOR') {
                                    ?>
                                    <li ><a href="painel.php?exe=relatorio/rel_usuario" title="">Usuários</a></li>
                                    <li ><a href="painel.php?exe=relatorio/rel_log_doc" title="">Log - Documentos</a></li>
                                    <?php
                                } elseif ($user['NIVEL'] == 'FINANCEIRO') {
                                    ?>
                                    <li ><a href="painel.php?exe=relatorio/rel_log_doc" title="">Log - Documentos</a></li>
                                    <?php
                                }
                                ?>

                            </ul>
                        </li>
                        <li class="menu_item"><a href="../index.php" title="SAIR">Sair</a>
                    </ul>
                </nav>
                <!--<div class="clear"></div>-->
            </div>
        </header>
        <main class="main">
            <?php
            if (!empty($getexe)):
                $includepatch = __DIR__ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . strip_tags(trim($getexe) . '.php');
            else:
                $includepatch = __DIR__ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'home.php';
            endif;

            if (file_exists($includepatch)):
                require_once($includepatch);
            else:
                echo "<div class=\"content notfound\">";
                WSErro("<b>Erro ao incluir tela:</b> Erro ao incluir o controller {$includepatch}!", WS_ERROR);
                echo "</div>";
            endif;
            ?>
        </main>
    </body>
    <script src="jsc/tiny_mce.js"></script>
    <script>
//<![CDATA[
        tinyMCE.init({
            mode: "specific_textareas",
            editor_selector: "tinyMCE",
            theme: "advanced",
            theme_advanced_toolbar_location: "top",
            theme_advanced_toolbar_align: "left",
            theme_advanced_resizing: "true",
            theme_advanced_resize_horizontal: "true",
            theme_advanced_buttons1:
                    "bold, italic, underline, separator, " +
                    "justifyleft, justifycenter, justifyright, indent, outdent, separator, " +
                    "bullist, numlist, separator, link, unlink, separator, undo, redo",
            theme_advanced_buttons2: "",
            theme_advanced_buttons3: ""
        });
//]]> 
    </script>
    <script src="_cdn/jquery.js?v=1"></script>
    <script src="_cdn/script.js?v=3"></script>
    <script src="_cdn/highcharts.js"></script>
    <script src="_cdn/modules/exporting.js"></script>
</html>
<?php
ob_end_flush();
//            theme_advanced_buttons1:
//                    "bold, italic, underline, separator, " +
//                    "justifyleft, justifycenter, justifyright, indent, outdent, separator, " +
//                    "bullist, numlist, separator, link, unlink, separator, undo, redo",
