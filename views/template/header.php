<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Zadanie č.4 | Michal Čech</title>

    <!-- Bootstrap -->
    <link href="<?php echo route("vendor/twbs/bootstrap/dist/css/bootstrap.min.css") ?>" rel="stylesheet">
    <link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" rel="stylesheet">

    <link href="<?php echo route("assets/style.css") ?>" rel="stylesheet">

    <link rel='shortcut icon' type='image/x-icon' href='<?php echo route("favicon.ico") ?>'/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo route("vendor/twbs/bootstrap/dist/js/bootstrap.min.js") ?>"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.js"></script>
    <script type="text/javascript" src="<?php echo route("assets/global.js") ?>"></script>
    <script type="text/javascript">
        MyApp.base_url = "<?php echo Config::get('app.base_url'); ?>"
    </script>

</head>
<body>
<header>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php route('/') ?>">Portal</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">

                <ul class="nav navbar-nav navbar-right">
                    <?php if ($menu_items = Config::get("menu.items", null)): ?>
                        <?php foreach ($menu_items as $item): ?>
                            <li>
                                <a href="<?php echo route($item['route']) ?>"><?php echo $item['title']?></a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <li><a></a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
</header>
<article>
    <div class="container">