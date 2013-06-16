{if $videos}
    {foreach from=$videos item=item}
    <div class="b-videos-item">
        <a class="b-videos-item-img" href="{$SITE_URL}video/{$item.id}" style="background-image: url({$item.youtube_img});">
            <div class="b-videos-item-play"></div>
        </a>
        <a class="b-videos-item-iname" href="{$SITE_URL}video/{$item.id}">{$item.iname}</a>
        <time class="b-videos-item-time">{$item.add_date|actionTime}</time>
    </div>
    {/foreach}
{/if}