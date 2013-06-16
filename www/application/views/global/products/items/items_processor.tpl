{if isset($products) && $products}
    {foreach from=$products item=item}
        <a class="b-products-item" href="/products/{$item.uri}" style="background-image: url(/{$item.photo_m})">
            <div class="b-products-item-info">
                <div class="b-products-item-iname">{$item.iname}</div>
                <div class="b-products-item-price">{$item.price} &#36;</div>
            </div>
        </a>
    {/foreach}
{/if}