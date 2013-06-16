<div data-id="{$idea.id}" data-status="{if isset($class) && $class}{$class}{/if}" class="p-idea {if isset($class) && $class}{$class}{/if}">
    <div class="b-idea-item-iname">{$idea.iname}</div>

    <a class="b-idea-item-video" onclick="U4ua.ideas.move(this);" style="background-image: url({$idea.youtube_img});">
        <div class="play"></div>
    </a>

    <div class="b-idea-item-more">
        <iframe width="644" height="483" src="http://www.youtube.com/embed/{$idea.youtube_code}" frameborder="0" allowfullscreen></iframe>
        <div class="b-idea-item-stripe">
            <a class="b-idea-share-mini" onclick="{if !$idea.is_sample && !$idea.is_deleted}U4ua.idea.vote({$idea.id});{/if}">Поддержи</a>
            <div class="b-idea-item-rating right">Судьи: <div class="b-idea-item-ratingStars s{$idea.rating_stars}"></div></div>
            Поддержало: {$idea.rating}
        </div>
        <div class="b-idea-item-idesc">{$idea.idesc}</div>

        {if $idea.attachments}
            <div class="b-comments-header">Дополнения</div>
            <div id="idea_attachments" class="overhide">
                {include file="global/idea/attachments/index.tpl" attachments=$idea.attachments}
            </div>
        {/if}



        {if $idea.team || $idea.is_can_edit}
            <div class="b-comments-header">Команда</div>
            <div class="b-idea-team">
                {include file="global/idea/team/index.tpl" team=$idea.team}
            </div>
        {/if}

        <div class="b-comments">
            <div class="b-comments-header">Комментарии (<span id="comments-number" class="b-comments-number">{$idea.comments_count}</span>)</div>
            {if $idea.comments_count > 3}
                <a class="b-comments-more" onclick="$('#comments_hidden').show(); $(this).hide();">Show all {$idea.comments_count} comments</a>
            {/if}
            <div class="b-comments-body" id="idea_comments">
                {if $idea.comments_count && $idea.comments}
                    {include file="global/idea/comments/index.tpl" comments = $idea.comments limit = 3}
                {/if}
            </div>
            <div class="b-comments-footer">
                {if $LOGGED}
                    <div class="mB20px">
                        <form method="post" id="ajaxSaveComment">
                            <h4 class="b-section-h4">Add comment</h4>
                            <input type="hidden" name="item[idea_id]" value="{$idea.id}">
                            <div class="in-textarea mB10px"><textarea name="item[idesc]"></textarea></div>
                            <div class="tRight">
                                <a class="button" onclick="Comment.add();">Add</a>
                            </div>
                        </form>
                        <script type="text/javascript">
                            Comment = {
                                count: -1,
                                add: function(){
                                    $.ajax({
                                        url: '/ajax/saveComment',
                                        type: 'POST',
                                        data: $('#ajaxSaveComment').serialize(),
                                        dataType: 'json',
                                        success: function(data){
                                            if (data.status == 'success' && data.html){
                                                $('#idea_comments').append(data.html);
                                                if (Comment.count < 0) {
                                                    Comment.count = parseInt($('#comments-number').html());
                                                }
                                                Comment.count++;
                                                $('#comments-number').html(Comment.count);
                                                $('#ajaxSaveComment textarea').val('');
                                            } else {
                                                console.log('Idea.save: error!');
                                            }
                                        }
                                    });
                                }
                            };
                        </script>
                    </div>
                {else}
                    <div class="mB20px">
                        You need to <a onclick="Window.load('/modal/login','win-login','');">{l}увійти{/l}</a> to post comments
                    </div>
                {/if}
            </div>
        </div>
    </div>
</div>