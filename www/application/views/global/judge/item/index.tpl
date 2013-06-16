<section class="b-section b-section-idea">
    <div class="b-section-header layout w976px">
        <div class="b-section-header-iname">Judge</div>
        {if $LOGGED && $USER_DATA.access_level > 50}
            <a class="" href="{$SITE_URL}judge/edit/{$judge.id}">edit</a>
        {/if}
    </div>
    <div class="b-section-wrap layout w976px b-idea">
        <aside class="b-section-aside">
            <h3 class="b-section-h3">Company:</h3>
            <div class="mB20px">{$judge.company_iname}</div>
            <h3 class="b-section-h3">Role:</h3>
            <div class="mB20px">{$judge.role}</div>
            <h3 class="b-section-h3">Site:</h3>
            <div class="mB20px"><a target="_blank" href="{$judge.company_url}">{$judge.company_url}</a></div>
        </aside>
        <div class="b-section-body b-section-body__withAside">

            <div class="b-idea-item">
                <div class="b-idea-item-iname">{$judge.first_name} {$judge.last_name}</div>
            {if $judge.youtube_code}
                <iframe width="644" height="483" src="http://www.youtube.com/embed/{$judge.youtube_code}" frameborder="0" allowfullscreen></iframe>
            {elseif $judge.avatar_b}
                <img src="/{$judge.avatar_b}" alt="">
            {/if}
                <div class="b-idea-item-idesc">
                {$judge.idesc|truncate:255}
                </div>

                <div class="mB20px">
                    <a class="b-showMore" href="">Показать больше</a>
                </div>
            </div>
        </div>
    </div>
</section>