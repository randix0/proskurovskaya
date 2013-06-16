{if isset($products) && $products}
    {foreach from=$products item=item}
        <tr>
            <td>{$item.id}</td>
            <td>
                <a href="/admin/products/edit/{$item.id}"><img src="/{$item.photo_s}"/></a>
            </td>
            <td>
                <a href="/admin/products/edit/{$item.id}">{$item.iname}</a>
            </td>
            <td>{$item.idesc}</td>
        </tr>
    {/foreach}
{/if}