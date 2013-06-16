<div class="b-product">

    <div class="b-product-wrapper">
        {if isset($product.details) && $product.details}
        <div class="b-product-parts">
            <h3>Детали</h3>
            {foreach from=$product.details item=item}
                <a class="b-product-parts-item">
                    <div class="b-product-parts-item-photo" style="background-image: url(/{$item.photo_m})"></div>
                    <div class="b-product-parts-item-iname">{$item.iname}</div>
                </a>
            {/foreach}
        </div>
        {/if}
        <div class="b-product-poster">
            <img class="b-product-poster-photo" src="/{$product.photo_b}" alt=""/>
            <div class="b-product-poster-info">
                <div class="b-product-poster-info-iname">{$product.iname}</div>
                <div class="b-product-poster-info-idesc">{$product.idesc}</div>
                <div class="b-product-photos">
                    {foreach from=$product.photos item=item}
                        <div class="b-product-photos-item" style="background-image: url(/{$item.photo_m})"></div>
                    {/foreach}
                </div>
            </div>
        </div>
    </div>
    <div class="b-product-info">
        <div class="b-product-info-colors">
            <h3>Цвет</h3>
            <a class="b-product-info-colors-item coral" href=""></a>
            <a class="b-product-info-colors-item gold" href=""></a>
            <a class="b-product-info-colors-item green" href=""></a>
            <a class="b-product-info-colors-item purple" href=""></a>
        </div>
        <div class="b-product-info-specification">
            <div class="b-product-info-materials">
                <h3>Материалы</h3>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy</p>
            </div>
            <div class="b-product-info-sizes">
                <h3>Размеры</h3>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy</p>
            </div>
        </div>
        <div class="b-product-info-details">
            <h1>Название модели сумки</h1>
            <div class="b-product-info-details-idesc">
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
                <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.Epsum factorial non deposit quid pro quo hic escorol.</p>
            </div>
            <a class="b-button xxl" href="">
                ДОБАВИТЬ В КОРЗИНУ
            </a>
        </div>
    </div>
</div>