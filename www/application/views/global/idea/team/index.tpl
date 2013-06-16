{if $team}
    {foreach from=$team item=item}
        <div class="b-idea-team-item">
            <div class="b-idea-team-item-avatar" style="background-image: url(/{$item.avatar_s});"></div>
            <div class="b-idea-team-item-iname">{$item.first_name} {$item.last_name}</div>
            <div class="b-idea-team-item-idesc">{$item.role}</div>
        </div>
    {/foreach}
{/if}