<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>grundriss24.de - farbige Grundrisse, m&ouml;blierte Grundrisse, optimierte Grundrisse, gestaltete Grundrisse, attraktive Grundrisse</title>
        <meta name="description" content="Der Service für Immobilienmakler: Wir verwandeln Ihre Vorlagen in verkaufsfördernde und attraktive Grundrisse." />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="language" content="de" />
        <meta name="robots" content="index,follow" />
        <meta name="audience" content="alle" />
        <meta name="page-topic" content="Dienstleistungen" />
        <meta name="revisit-after" content="5 days" />

        <link rel="stylesheet" type="text/css" href="css/styles.css" media="screen, print" />

<script type="text/javascript">
            <!--
            function showLoader() {
                document.getElementById('loader').style.display = 'block';
            }
           
            -->
        </script>

        <!--Lightbox-->
        <?php $gb_root_dir = $url."/greybox/"; ?>
        <script type="text/javascript">
            <!--
            function closeWindow()
            {
                window.close();
                window.opener.location.replace('Auftraege');
            }

            
            function fnWindowOpen(strFilename, intWidth, intHeight)
            {
                if (!window.WinLageplan)
                {
                    WinLageplan = window.open(strFilename,'WinLageplanX','width='+ intWidth +',height='+ intHeight+',toolbar=no,menubar=no,location=no,scrollbars=yes,resizable=yes');
                }
                else
                {
                    if (!WinLageplan.closed)
                    {
                        WinLageplan.location.href = strFilename

                        WinLageplan.focus();
                    }
                    else
                    {
                        WinLageplan = window.open(strFilename,'WinLageplanX','width='+ intWidth +',height='+ intHeight+',toolbar=no,menubar=no,location=no,scrollbars=yes,resizable=yes');
                    }
                }
            }

             <?php echo "var GB_ROOT_DIR = '$gb_root_dir'" ?>;
            -->
        </script>
        <script type="text/javascript" src="greybox/AJS.js"></script>
        <script type="text/javascript" src="greybox/AJS_fx.js"></script>
        <script type="text/javascript" src="greybox/gb_scripts.js"></script>
        <link href="greybox/gb_styles.css" rel="stylesheet" type="text/css" />
 <!--Lightbox Ende-->

 

        

        <?php if($action == 'design') { ?>
        <style type="text/css">
            #content_left {
                background: #827D78;
            }
            #border_top {
                background: url(images/border_top_grau.jpg) no-repeat;
            }

            #border_bottom {
                background: url(images/border_bottom_grau.jpg) no-repeat;
            }
            #left_col {
                background: url(images/bg_borders_grau.jpg) repeat-y;
            }
            #login_box {
                background: #827D78;
            }
            #login_box .inner_login_box {
                background: #c0c0c0 url(images/login_borders_grau.jpg) repeat-y;
            }
            .login_border_top {
                background: url(images/login_border_top_grau.jpg) no-repeat;
            }
            .login_border_bottom {
                background: url(images/login_border_bottom_grau.jpg) no-repeat;
            }
        </style>
        <?php } ?>
    </head>
    <!--<body <?php if($_SESSION['fapo'] == 'Fax' || $_SESSION['fapo'] == 'Post') {echo 'onload="javascript: window.open("datei.htm","Fenster1","width=310,height=400,left=0,top=0");"';} ?>>-->
    <body onload='javascript: window.open("view/deckblatt.php?a=<?php echo $auftrag->getAuftragsnummer() ?>","Fenster1","width=700,height=700,left=200,top=200");'
        <?php echo $_SESSION['fapo']; ?>
        <div id="whole_site_wrapper">
            <div id="nav_wrapper">
                <div id="nav_bar1">
                    <div id="mainnavi">
                        <a href="<?php echo $url ?>/Startseite">HOME</a>
                        <a href="<?php echo $url ?>/Registrieren">REGISTRIEREN</a>
                        <a href="<?php echo $url ?>/Design">DESIGN</a>
                        <a id="nav_2zeiler" href="<?php echo $url ?>/FAQ">FRAGEN + ANTWORTEN</a>
                        <a href="<?php echo $url ?>/Kontakt">KONTAKT</a>
                    </div>
                </div>
                <div id="nav_bar2">
                    <div id="logo"><a href="<?php echo $url ?>/Startseite" id="logo_link"></a></div>
                </div>
            </div>
            <div id="border_top"></div>
            <div id="left_col">
                <div id="bg_box">
                    <div id="border_left"></div>
                    <div id="content_left">
                        <?php if ($action == 'anmelden') { ?>
                        <?php } else { ?>
                            <?php if($_SESSION['logged_in_userid']) { ?>
                        <div id="login_box">
                                    <?php
                                    if ($action != 'registrieren') {
                                        require_once 'view/user_menu.tpl.php';
                                    } ?>
                        </div>
                            <?php } else { ?>
                        <div id="login_box" <?php if ($action == 'registrieren') {echo 'style="height:200px;"'; }?>>

                                    <?php
                                    if ($action != 'registrieren') {
                                        require_once 'view/login_box.tpl.php';
                                    }
                                    ?>
                        </div>
                            <?php } ?><?php } ?>


                        <?php require 'view/'. $action .'.tpl.php' ?>

                    </div>
                    <?php if($action == 'startseite') { ?>
                    <img style="float: left;position: absolute;bottom:-16px;left:10px;" src="images/stifte_bg.gif" alt="" name="" />
                    <?php } ?>
                </div>
            </div>
            <div id="border_bottom"></div>
            <div id="right_col">
                <div class="add_box">
                    <p>Werbepartner</p>
                    <a href="http://www.multiphone.de"><img src="images/banner_multiphone.jpg" alt="multiphone Telefonservice"/></a>
                </div>
                <div class="add_box">
                    
                    <p>Werbepartner</p>
                    <a href="http://www.vakufixx.de"><img src="images/banner_vakufixx.jpg" alt="VAKUFIXX Objektwerbung"/></a>
                </div>
            </div>
        </div>
        <div id="footer"><a class="footer_links" href="Impressum">Impressum</a></div>

<?php unset($_SESSION['hinweis']) ?>
    </body>
</html>

                