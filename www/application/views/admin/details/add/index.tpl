<div class="span3">
    <div class="well">
        <div class="">
            <div>Add date</div>
            <input type="text" disabled="disabled" class="input-block-level" id="input" placeholder="" value="">
        </div>

    </div><!--/.well -->
</div><!--/span-->

<div class="span9">
    <h1>Add detail</h1>
    <hr>

    <form id="ajaxSaveDetail" class="form-horizontal" action="/ajax/saveDetail">
        <input type="hidden" name="id" value="0" />
        {*<input type="hidden" id="file_store_name" name="file[store_name]" value="" />*}
        <input type="hidden" id="file_upload_path" name="file[upload_path]" value="" />
        <div class="control-group">
            <label class="control-label">Photo</label>
            <div class="controls">
                <div id="details_photos"></div>
                <a id="file_preview" class="btn btn-info" onclick="Window.load('/modal/upload/details/-1/0','win-upload','');">Load</a>
            </div>
        </div>
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
                <a class="btn btn-large" data-form="#ajaxSaveDetail" data-action="/ajax/saveDetail" onclick="Ajax.save(this);">{l}SAVE{/l}</a>
            </div>
        </div>


    </form>
    <hr>
