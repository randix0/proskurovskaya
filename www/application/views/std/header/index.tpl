<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>PROSKUROVSKAЯ</title>
    <meta name="description" content="">
    <link rel="icon" type="image/png" href="/fav.png">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <link rel="stylesheet" href="{$RESOURCES_URL}css/normalize.css">
    <link rel="stylesheet" href="{$RESOURCES_URL}css/helpers.css">
    <link rel="stylesheet" href="{$RESOURCES_URL}css/main.css">
    <link rel="stylesheet" href="{$RESOURCES_URL}css/proskurovskaya.css">
    <link rel="stylesheet" href="{$RESOURCES_URL}css/window.css">

    <script src="{$RESOURCES_URL}js/vendor/modernizr-2.6.2.min.js"></script>
    <script src="{$RESOURCES_URL}js/vendor/jquery-1.8.3.min.js"></script>
    <script src="{$RESOURCES_URL}js/plugins.js"></script>
    <script src="{$RESOURCES_URL}js/main.js"></script>
    <script src="{$RESOURCES_URL}js/window.js"></script>
    <script src="{$RESOURCES_URL}js/modernizr-transitions.js"></script>
    <script src="{$RESOURCES_URL}js/jquery.masonry.min.js"></script>

</head>
<body>

<div id="dimmer" class="dimmer" style="display: none;"></div>
<div id="modal_layer_wrap" class="modal_layer_wrap" style="display: none;">
    <div id="modal_layer" class="modal_layer"></div>
</div>

<div class="b-layout">
    <header class="b-header">
        <a class="b-topLogo" href="/"></a>
    </header>

    <div class="b-wrapper">
        <aside class="b-aside b-aside__left">
            <a class="b-asideLodo" href="/"></a>
            <nav class="b-asideNav">
                <a class="b-asideNav-item" href="/about">About</a>
                <a class="b-asideNav-item" href="/campaign">Campaign</a>
                <a class="b-asideNav-item" href="/lookbook">Lookbook</a>
                <a class="b-asideNav-item" href="/news">News</a>
                <a class="b-asideNav-item" href="/private-order">Private order</a>
                <a class="b-asideNav-item" href="/contacts">Contacts</a>
            </nav>

        </aside>
        <aside class="b-aside b-aside__right">
            <nav class="b-etcNav">
                <span class="b-etcNav-item">
                    <a class="b-btn-cart">
                        <span class="t">Bag</span>
                        <span class="i">230</span>
                    </a>
                </span>
                <a class="b-etcNav-item" onclick="Window.load('/modal/login','win-login','');">Register</a>
                <a class="b-etcNav-item" href="">FAQ</a>
            </nav>
        </aside>

        <section class="b-section">
            {if isset($collections) && $collections}
            <nav class="b-subNav b-subNav__collections">
                <span class="b-subNav-caption">Collections</span>
                {foreach from=$collections item=item}
                    <a class="b-subNav-item {if isset($current_collection) && $current_collection.id == $item.id}active{/if}" href="/collections/{$item.uri}/">{$item.iname}</a>
                {/foreach}
            </nav>
            {/if}
            {if isset($categories) && $categories}
            <nav class="b-subNav b-subNav__categories">
                <span class="b-subNav-caption">Categories</span>
                {foreach from=$categories item=item}
                    <a class="b-subNav-item {if isset($current_category) && $current_category.id == $item.id}active{/if}" href="/categories/{$item.uri}/">{$item.iname}</a>
                {/foreach}
            </nav>
            {/if}