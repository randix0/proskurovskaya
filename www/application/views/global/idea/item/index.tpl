<section class="b-section b-section-idea">
    {if $idea.is_can_edit}
        <div class="b-section-header layout w976px">
            <div class="b-section-header-iname">Управление идеей</div>
            <a class="" href="{$SITE_URL}idea/edit/{$idea.id}">edit</a>
        </div>
    {/if}
    <div class="b-section-wrap layout w976px b-idea">
        <aside class="b-section-aside">
            <h3 class="b-section-h3">Qr-код:</h3>
            <img class="b-idea-qr" src="{$idea.qr_code}" />
            {if $idea.attachments || $idea.is_can_edit}
                <h3 class="b-section-h3">{if $idea.is_author}твоя {/if}листовка:</h3>
                <div id="idea_attachments" class="">
                    {include file="global/idea/attachments/index.tpl" attachments=$idea.attachments}
                </div>
                {if $idea.is_can_edit}
                    <div class="left w210px mR10px">
                        <div class="b-idea-putFile">
                            <div class="b-idea-putFile-desc">Upload files</div>
                            <a class="b-idea-putFile-choose" onclick="Window.load('/modal/upload/attachments/{$idea.id}','win-upload','');">Choose</a>
                        </div>
                    </div>
                {/if}
            {/if}

            {if $idea.team || $idea.is_can_edit}
                <h3 class="b-section-h3">Команда:</h3>
                <div id="idea_team" class="overhide">
                    {include file="global/idea/team/index.tpl" team=$idea.team}
                </div>
                {if $idea.is_can_edit}
                    <a class="b-idea-addPerson" onclick="Window.load('/modal/upload/team/{$idea.id}','win-upload','');">Добавить участника</a>
                {/if}
            {/if}
            <h3 class="b-section-h3">Расскажи всем:</h3>
            <div class="b-idea-share">
                <a class="b-idea-share-btn email right" href=""></a>
                <div class="b-idea-share-soc">
                    <a class="b-idea-share-btn fb mB20px left" href=""></a>
                    <a class="b-idea-share-btn vk mB20px left" href=""></a>
                    <a class="b-idea-share-btn tw mB20px left" href=""></a>
                </div>
            </div>
        </aside>
        <div class="b-section-body b-section-body__withAside">
            {if $idea.is_author && !$idea.is_sample}
                <h3 class="b-section-h3">Твоя идея:</h3>
                <div class="b-idea-notice">
                    <a class="close" href=""></a>
                    <div class="b-idea-notice-content p37pxi">
                        ТОЛЬКО ОТ ТЕБЯ ЗАВИСИТ УСПЕХ ТВОЕЙ ИДЕИИ!<br/>
                        ИСПОЛЬЗУЙ ВСЕ СРЕДСТВА ДЛЯ ЕЕ ПРОДВИЖЕНИЯ!
                    </div>
                </div>
            {elseif $idea.is_sample}
                <div class="b-idea-notice">
                    <a class="close" href=""></a>
                    <div class="b-idea-notice-content p37pxi">
                        It is sample
                    </div>
                </div>
            {/if}
            <div class="b-idea-item">
                <div class="b-idea-item-iname">{$idea.iname}</div>
                <iframe width="644" height="483" src="http://www.youtube.com/embed/{$idea.youtube_code}" frameborder="0" allowfullscreen></iframe>
                <div class="b-idea-item-stripe">
                    <div class="b-idea-item-rating right">Судьи: <div class="b-idea-item-ratingStars s{$idea.rating_stars}"></div></div>
                    Поддержало: {$idea.rating}
                </div>
                <div class="b-idea-item-idesc">
                    {$idea.idesc|truncate:255}
                </div>

                <div class="mB20px">
                    <a class="b-showMore" href="">Показать больше</a>
                </div>

                {if $idea.comments_count < 10}
                <div class="b-idea-notice">
                    <a class="close" href=""></a>
                    <div class="b-idea-notice-content">
                        ТОЛЬКО ИДЕИ С МИНИМУМ 10 КОММЕНТАРИЕВ<br>
                        БУДУТ ОЦЕНЕНЫ МЕНТОРАМИ
                    </div>
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
    </div>
</section>