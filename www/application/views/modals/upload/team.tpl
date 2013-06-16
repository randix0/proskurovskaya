{if $files}
<form id="saveTeam" method="post" action="/ajax/saveTeam">
    {counter start=0 assign=i}
    {foreach from=$files item=file}
        <div class="mB20px">
            <div style="background: url(/{$file.path}) 50% 50% no-repeat; background-size: cover; height: 200px;"></div>
            <input type="hidden" name="item[{$i}][store_name]" value="{$file.store_name}" />
            <input type="hidden" name="item[{$i}][type]" value="{$file.type}" />
            <input type="hidden" name="item[{$i}][ext]" value="{$file.ext}" />
            <input type="hidden" name="item[{$i}][path]" value="{$file.path}" />
            <input type="hidden" name="item[{$i}][idea_id]" value="{$file.idea_id}" />
            <div class="in-text mB25px"><input type="text" disabled="disabled" value="{$file.name}"></div>

            <h4 class="b-section-h4">First name</h4>
            <div class="in-text mB25px"><input type="text" name="item[{$i}][first_name]" placeholder="Тарас"></div>
            <h4 class="b-section-h4">Last name</h4>
            <div class="in-text mB25px"><input type="text" name="item[{$i}][last_name]" placeholder="Шевченко"></div>
            <h4 class="b-section-h4">Role in project</h4>
            <div class="in-text mB25px"><input type="text" name="item[{$i}][role]" placeholder="Программист"></div>
            <hr>
        </div>
        {counter}
    {/foreach}
    <a class="button" onclick="Team.save();">Добавить</a>
</form>

<script type="text/javascript">
    var parent = this;
    Team = {
        save: function(){
            $.ajax({
                url: '/ajax/saveTeam',
                type: 'POST',
                data: $('#saveTeam').serialize(),
                dataType: 'json',
                success: function(data){
                    if (data.status == 'success'){
                        if (data.html)
                            $('#idea_team').append(data.html);
                        Window.close('win-upload');
                    } else {
                        console.log('Idea.save: error!');
                    }
                }
            });
        }
    };
</script>
{/if}