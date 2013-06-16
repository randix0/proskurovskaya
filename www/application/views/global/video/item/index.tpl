<section class="b-section b-section-idea">
    <div class="b-section-header layout w976px">
        <div class="b-section-header-iname">Video</div>
    {if $LOGGED && $USER_DATA.access_level > 50}
        <a class="" href="{$SITE_URL}video/edit/{$video.id}">edit</a>
    {/if}
    </div>
    <div class="b-section-wrap layout w976px b-idea">
        <aside class="b-section-aside">

        </aside>
        <div class="b-section-body b-section-body__withAside">

            <div class="b-idea-item">
                <div class="b-idea-item-iname">{$video.iname}</div>
            {if $video.youtube_code}
                <iframe width="644" height="483" src="http://www.youtube.com/embed/{$video.youtube_code}" frameborder="0" allowfullscreen></iframe>
                {elseif $video.avatar_b}
                <img src="/{$video.avatar_b}" alt="">
            {/if}
                <div class="b-idea-item-idesc">
                {$video.idesc|truncate:255}
                </div>

                <div class="mB20px">
                    <a class="b-showMore" href="">Показать больше</a>
                </div>
            </div>
        </div>
    </div>
</section>