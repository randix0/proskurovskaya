{if isset($limit) && $limit}
    {counter assign='comments_i' start=$comments|count direction="down"}
    {if $comments|count > $limit}<div id="comments_hidden" style="display: none;">{/if}
{/if}
{foreach from=$comments item=comment}
    {if isset($limit) && $limit && $comments_i == $limit}</div>{/if}

    <div class="b-comments-item">
        <a class="b-comments-item-avatar" href="" style="{if $comment.user_avatar_m}background-image: url(/{$comment.user_avatar_m});{/if}"></a>
        <div class="b-comments-item-wrap">
            <a class="b-comments-item-iname" href="">{$comment.user_full_name}</a>
            <time class="b-comments-item-time">{$comment.add_date|actionTime}</time>
            <div class="b-comments-item-idesc">{$comment.idesc}</div>
        </div>
    </div>
    {if isset($limit) && $limit}{counter}{/if}
{/foreach}