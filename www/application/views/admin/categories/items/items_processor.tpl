{if isset($categories) && $categories}
    {foreach from=$categories item=item}
        <tr>
            <td>{$item.id}</td>
            <td>{$item.uri}</td>
            <td>{$item.iname}</td>
            <td>{$item.idesc}</td>
        </tr>
    {/foreach}
{/if}