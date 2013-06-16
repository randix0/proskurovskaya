<section class="b-section b-section-judges">
    <div class="b-section-header layout w976px">
        <div class="b-section-header-iname">судьи</div>
        {if isset($USER_DATA) && $USER_DATA && isset($USER_DATA.access_level) && $USER_DATA.access_level > 50}
            <a class="" href="{$SITE_URL}judge/add">Add</a>
        {/if}
    </div>
    <div class="b-section-body layout w1010px b-judges">
        {include file="global/judge/items/index.tpl" judges=$judges}
    </div>

</section>

<script type="text/javascript">
    $(document).ready(function(){
        $('.b-judges').masonry({
            itemSelector: '.b-judges-item',
            singleMode: true,
            isResizable: false
            //isAnimated: !Modernizr.csstransitions
        });
    });
</script>