<section class="b-section b-section-partners">
    <div class="b-section-header layout w976px">
        <div class="b-section-header-iname">Video</div>
    {if isset($USER_DATA) && $USER_DATA && isset($USER_DATA.access_level) && $USER_DATA.access_level > 50}
        <a class="" href="{$SITE_URL}video/add">Add</a>
    {/if}
    </div>
    <div class="b-section-body layout w1010px b-videos">
        {include file="global/video/items/index.tpl" videos=$videos}
    </div>

</section>

<script type="text/javascript">
    $(document).ready(function(){
        $('.b-videos').masonry({
            itemSelector: '.b-videos-item',
            singleMode: true,
            isResizable: false
            //isAnimated: !Modernizr.csstransitions
        });
    });
</script>