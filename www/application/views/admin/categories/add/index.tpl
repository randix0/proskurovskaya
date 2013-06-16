<div class="span3">
    <div class="well">
        <div class="">
            <div>Add date</div>
            <input type="text" disabled="disabled" class="input-block-level" id="input" placeholder="" value="">
        </div>

    </div><!--/.well -->
</div><!--/span-->

<div class="span9">
    <h1>Add category</h1>
    <hr>

    <form id="ajaxSaveCategory" class="form-horizontal" action="/ajax/saveCategory">
        <input type="hidden" name="id" value="0" />
        <div class="control-group">
            <label class="control-label">URL-segment</label>
            <div class="controls">
                <input type="text" name="item[uri]" class="input-block-level"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Title</label>
            <div class="controls">
                <input type="text" name="item[iname]" class="input-block-level"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Description</label>
            <div class="controls">
                <textarea name="item[idesc]" class="input-block-level"></textarea>
            </div>
        </div>

        <div class="control-group">
            <div class="controls">
                <a class="btn btn-large" data-form="#ajaxSaveCategory" data-action="/ajax/saveCategory" onclick="Ajax.save(this);">{l}SAVE{/l}</a>
            </div>
        </div>


    </form>
    <hr>
