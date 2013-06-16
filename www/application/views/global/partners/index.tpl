<section class="b-section b-section-partners">
    <div class="b-section-header layout w976px">
        <div class="b-section-header-iname">Партнеры</div>
        {if isset($USER_DATA) && $USER_DATA && isset($USER_DATA.access_level) && $USER_DATA.access_level > 50}
            <a class="" href="{$SITE_URL}partner/add">Add</a>
        {/if}
    </div>
    <div class="b-section-body layout w1010px b-partners">
        {include file="global/partner/items/index.tpl" partners=$partners}
    </div>

</section>

<script type="text/javascript">
    $(document).ready(function(){
        $('.b-partners').masonry({
            itemSelector: '.b-partners-item',
            singleMode: true,
            isResizable: false
            //isAnimated: !Modernizr.csstransitions
        });
    });
</script>