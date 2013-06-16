{if $prevIdea}
    {include file="global/idea/ajaxItem/item.tpl" idea=$prevIdea class="prev"}
{/if}

{if $nextIdea}
    {include file="global/idea/ajaxItem/item.tpl" idea=$nextIdea class="next"}
{/if}

    {include file="global/idea/ajaxItem/item.tpl" class="active"}