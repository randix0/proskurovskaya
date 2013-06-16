<div class="span3">
    <div class="well sidebar-nav">
        <ul class="nav nav-list">
            <li class="nav-header">Меню</li>
            <li class="active"><a href="{$SITE_URI}admin/products/">Изделия</a></li>
            <li><a href="{$SITE_URI}admin/categories/">Категории</a></li>
            <li><a href="{$SITE_URI}admin/collections/">Коллекции</a></li>
        </ul>
    </div><!--/.well -->
</div><!--/span-->
<div class="span9">
    <h1>
        Изделия
        <a class="btn btn-info" href="/admin/products/add">Add</a>
    </h1>
    <hr>

    <div class="">
        <table class="table table-bordered" style="width: 600px;">
            <tr class="info">
                <td>id</td>
                <td>thumb</td>
                <td>title</td>
                <td>description</td>
            </tr>
            {include file="admin/products/items/items_processor.tpl"}
        </table>
    </div>
</div><!--/span-->

