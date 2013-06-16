{if $files}
<form id="saveAttachments" method="post" action="/ajax/saveAttachments">
    {counter start=0 assign=i}
    {foreach from=$files item=file}
        <div class="b-file {if $file.ext}{$file.ext}{/if} mB20px">
            <input type="hidden" name="item[{$i}][store_name]" value="{$file.store_name}" />
            <input type="hidden" name="item[{$i}][type]" value="{$file.type}" />
            <input type="hidden" name="item[{$i}][ext]" value="{$file.ext}" />
            <input type="hidden" name="item[{$i}][path]" value="{$file.path}" />
            <input type="hidden" name="item[{$i}][idea_id]" value="{$file.idea_id}" />
            <div class="in-text mB25px"><input type="text" disabled="disabled" value="{$file.name}"></div>

            <h4 class="b-section-h4">Описание файла</h4>
            <div class="in-text mB25px"><input type="text" name="item[{$i}][iname]" placeholder="Бизнес-план проекта" value="{$file.name}"></div>
            <hr>
        </div>
        {counter}
    {/foreach}
    <a class="button" onclick="Attachment.save();">Добавить</a>
</form>

<script type="text/javascript">
    var parent = this;
    Attachment = {
        save: function(){
            $.ajax({
                url: '/ajax/saveAttachments',
                type: 'POST',
                data: $('#saveAttachments').serialize(),
                dataType: 'json',
                success: function(data){
                    if (data.status == 'success'){
                        if (data.html)
                        $('#idea_attachments').append(data.html);
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