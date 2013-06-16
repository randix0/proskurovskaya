{if $judges}
    {foreach from=$judges item=item}
        <div class="b-judges-item">
            <a class="b-judges-item-video" style="{if $item.avatar_s}background-image: url(/{$item.avatar_m});{/if}" href="{$SITE_URL}judge/{$item.id}">
                {if $item.youtube_code}
                    <div class="play"></div>
                {/if}
            </a>
            <div class="b-judges-item-desc">
                <div class="b-judges-item-iname">{$item.first_name} {$item.last_name}</div>
                {if $item.company_iname || $item.role}
                    <span class="b-judges-item-position">
                        {if $item.company_iname}<span class="company">{$item.company_iname}</span>, {/if}{$item.role}
                    </span>
                {/if}
                <div class="b-judges-item-idesc">{$item.idesc}</div>
            </div>
            {if isset($USER_DATA) && $USER_DATA && isset($USER_DATA.access_level) && $USER_DATA.access_level > 50}
                <div class="tCenter mB20px">
                    <a href="/judge/edit/{$item.id}">edit</a>
                </div>
            {/if}
        </div>
    {/foreach}
{/if}