<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title><?php echo SITE_TITLE; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo SITE_DESC; ?>">
        <meta name="author" content="">
        <!-- Le styles -->
        <link href="template/css/bootstrap.min.css" rel="stylesheet">
        <link href="template/css/dashboard.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script src="template/js/jquery-1.11.1.min.js"></script>
        <script src="template/js/bootstrap.min.js"></script>
        <script src="template/js/docs.min.js"></script>
        <script type="text/javascript" lang="JavaScript">
            $(function() {
                $("a.needAlertConfirm").click(function() {
                    if (confirm("Realmente desea " + $(this).attr('alert-text'))) {
                        return true;
                    } else {
                        return false;
                    }
                })
            });
        </script>

    </head>

    <body>

        <?php if (isset($_SESSION['user_session']) && $_SESSION['user_session'] == 'ok') { ?>
            <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"><?= SITE_NAME; ?></a>
                    </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <?php //$this->_pre($this->deployMainMenu());?>
                            <?php
                            $mainMenu = json_decode($this->deployMainMenu(), true);
                            if (is_array($mainMenu)) {


                                foreach ($mainMenu AS $menu => $path) {
                                    ?>
                                    <li <?php
                                    if ($this->vista == "?" . $path) {
                                        echo 'class="active"';
                                    }
                                    ?>><a href="?<?= $path ?>"><?= $menu ?></a></li>
                                        <?php
                                    }
                                }
                                ?>
                                    <li><a href="?action=logout"> <span class="label label-warning"> Cerrar Sesi&oacute;n</span></a></li>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-3 col-md-2 sidebar">
                        <ul class="nav nav-sidebar">

                            <?php
                            $sidemenu = $this->deploySideMenu();
                            if ($sidemenu && is_array($sidemenu)) {
                                foreach ($sidemenu AS $item) {
                                    ?>
                                    <li <?php
                        if ("action=" . $_GET['action'] == $item["path"]) {
                            echo 'class="active"';
                        }
                        ?>>
                                        <a href="?v=<?= $this->vista ?>&<?= $item["path"] ?>">
                                    <?= $item["name"] ?></a>
                                    </li>
            <?php
        }
    }
    ?>                           
                        </ul>

                    </div>
                    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <?= $this->getContentView() ?>
                    </div>
                </div>
            </div>
<?php } else { ?>
            <style>
                body {
                    padding-top: 40px;
                    padding-bottom: 40px;
                    background-color: #eee;
                }

                .form-signin {
                    max-width: 330px;
                    padding: 15px;
                    margin: 0 auto;
                }
                .form-signin .form-signin-heading,
                .form-signin .checkbox {
                    margin-bottom: 10px;
                }
                .form-signin .checkbox {
                    font-weight: normal;
                }
                .form-signin .form-control {
                    position: relative;
                    height: auto;
                    -webkit-box-sizing: border-box;
                    -moz-box-sizing: border-box;
                    box-sizing: border-box;
                    padding: 10px;
                    font-size: 16px;
                }
                .form-signin .form-control:focus {
                    z-index: 2;
                }
                .form-signin input[type="email"] {
                    margin-bottom: -1px;
                    border-bottom-right-radius: 0;
                    border-bottom-left-radius: 0;
                }
                .form-signin input[type="password"] {
                    margin-bottom: 10px;
                    border-top-left-radius: 0;
                    border-top-right-radius: 0;
                }
            </style>
            <div class="container">
                <form action="?action=login" class="form-signin" method="post" role="form">
                    <h2 class="form-signin-heading">Por favor registrate</h2>
                    <input type="text" name="login" class="form-control" placeholder="Usuario" required autofocus>
                    <input type="password" name="pass" class="form-control" placeholder="Clave" required>
                    <label class="checkbox">                        
                    </label>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Acceder</button>

                    <?php
                    $alerts = $this->activesMsgs();
                    if ($alerts) {
                        echo "<hr />" . $alerts;
                    }
                    ?>
                </form>

            </div>
<?php } ?>
    </body>
</html>
