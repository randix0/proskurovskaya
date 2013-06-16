{foreach from=$ideas item=item}
<div class="b-ideas-item">
    <a class="b-ideas-item-img" href="{$SITE_URL}idea/{$item.id}" style="background-image: url({$item.youtube_img});">
        <div class="b-ideas-item-play"></div>
    </a>
    <a class="b-ideas-item-iname" href="{$SITE_URL}idea/{$item.id}">{$item.iname}</a>
    <time class="b-ideas-item-time">{$item.add_date|actionTime}</time>
    <a class="b-ideas-item-vote" href="{$SITE_URL}idea/edit/{$item.id}">{l}Редагувати{/l}</a>

    <div class="b-ideas-item-info">
        <div class="b-ideas-item-rating-users">Рейтинг: {$item.rating}</div>
        <div class="b-ideas-item-comments-count">Коментарі: {$item.comments_count}</div>
        <div class="b-ideas-item-rating">Судьи: <a class="b-ideas-item-ratingStars s{$item.rating_stars}" title="{$item.rating_judges} votes"></a></div>
    </div>
</div>
{/foreach}