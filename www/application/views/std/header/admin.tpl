<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{l}ADMIN_PANEL{/l}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="{$RESOURCES_URL}js/vendor/jquery-1.8.3.min.js"></script>
    <script src="{$RESOURCES_URL}js/jquery.masonry.min.js"></script>

    <!-- Le styles -->
    <link href="{$RESOURCES_URL}css/bootstrap/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="{$RESOURCES_URL}css/window.css">
    <style type="text/css">
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }

        @media (max-width: 980px) {
            /* Enable use of floated navbar text */
            .navbar-text.pull-right {
                float: none;
                padding-left: 5px;
                padding-right: 5px;
            }
        }
    </style>
    <link rel="stylesheet" href="{$RESOURCES_URL}css/helpers.css">
    <link href="{$RESOURCES_URL}admin/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="{$RESOURCES_URL}admin/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <script>
        var vk_app_id = '{$VK_APP_ID}',
            fb_app_id = '{$FB_APP_ID}',
            gl_app_id = '{$GL_APP_ID}',
            BASE_URL = '{$BASE_URL}',
            SITE_URL = '{$SITE_URL}',
            SITE_URI = '{$SITE_URI}',
            LOGGED = {if $LOGGED}{$LOGGED}{else}0{/if};
    </script>
    <script src="{$RESOURCES_URL}js/main.js"></script>
    <script src="{$RESOURCES_URL}js/auth.js"></script>
    <script src="{$RESOURCES_URL}js/window.js"></script>
</head>

<body>

<div id="dimmer" class="dimmer" style="display: none;"></div>
<div id="modal_layer_wrap" class="modal_layer_wrap" style="display: none;">
    <div id="modal_layer" class="modal_layer"></div>
</div>

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="brand" href="{$SITE_URI}admin/">Панель управления</a>
            <div class="nav-collapse collapse">
                <p class="navbar-text pull-right">
                    Вы вошли как <a class="navbar-link">{$USER_DATA.first_name} {$USER_DATA.last_name}</a>
                </p>
                <ul class="nav">
                    <li class="{if isset($__PAGE) && $__PAGE == 'main'}active{/if}"><a href="{$SITE_URI}/"><i class="icon-home icon-white"></i> На сайт</a></li>
                    <li class="{if isset($__PAGE) && $__PAGE == 'main'}active{/if}"><a href="{$SITE_URI}admin/"><i class="icon-home icon-white"></i> Главная</a></li>
                    <li class="{if isset($__PAGE) && $__PAGE == 'products'}active{/if}"><a href="{$SITE_URI}admin/products/"><i class="icon-home icon-white"></i> Изделия</a></li>
                    {*<li class="{if isset($__PAGE) && $__PAGE == 'photos'}active{/if}"><a href="{$SITE_URI}admin/photos"><i class="icon-camera icon-white"></i> Фотографии</a></li>*}
                    <li class="{if isset($__PAGE) && $__PAGE == 'users'}active{/if}"><a href="{$SITE_URI}admin/users"><i class="icon-user icon-white"></i> Пользователи</a></li>
                    <li class="{if isset($__PAGE) && $__PAGE == 'settings'}active{/if}"><a href="{$SITE_URI}admin/settings"><i class="icon-wrench icon-white"></i> Настройки</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row-fluid">