{if $idea}
    <div class="p-idea {if isset($class) && $class}{$class}{/if}">
        <div class="b-idea-item-iname">{$idea.iname}</div>
        <a class="b-idea-item-video" style="background-image: url({$idea.youtube_img});" href="">
            <div class="play"></div>
        </a>
    </div>
{/if}