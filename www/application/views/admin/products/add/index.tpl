<div class="span3">
    <div class="well">
        <div class="">
            <div>Add date</div>
            <input type="text" disabled="disabled" class="input-block-level" id="input" placeholder="" value="">
        </div>

    </div><!--/.well -->
</div><!--/span-->

<div class="span9">
    <h1>Add product</h1>
    <hr>

    <form id="ajaxSaveProduct" class="form-horizontal" action="/ajax/saveProduct">
        <input type="hidden" name="id" value="{$product.id}" />
        {*<input type="hidden" id="file_store_name" name="file[store_name]" value="" />*}
        <input type="hidden" id="file_upload_path" name="file[upload_path]" value="" />
        <div class="control-group">
            <label class="control-label">Category</label>
            <div class="controls">
                <select name="item[category_id]">
                    {if isset($categories) && $categories}
                        {foreach from=$categories item=item}
                            <option {if $product.category_id == $item.id}selected="selected"{/if} value="{$item.id}">{$item.iname}</option>
                        {/foreach}
                    {/if}
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Collection</label>
            <div class="controls">
                <select name="item[collection_id]">
                    {if isset($collections) && $collections}
                        {foreach from=$collections item=item}
                            <option {if $product.collection_id == $item.id}selected="selected"{/if} value="{$item.id}">{$item.iname}</option>
                        {/foreach}
                    {/if}
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">URL-segment</label>
            <div class="controls">
                <input type="text" name="item[uri]" value="{$product.uri}" class="input-block-level"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Title</label>
            <div class="controls">
                <input type="text" name="item[iname]" value="{$product.iname}" class="input-block-level"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Description</label>
            <div class="controls">
                <textarea name="item[idesc]" class="input-block-level">{$product.idesc}</textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Price</label>
            <div class="controls">
                <input type="text" name="item[price]" value="{$product.price}" class="input-block-level"/>
            </div>
        </div>

        {*
        {if $product && isset($product.details) && $product.details}
        <div class="control-group">
            <label class="control-label">Edit Details</label>
            <div class="controls">
                {foreach from=$product.details item=item}
                    <div>
                        {$item.iname}
                        <a onclick="deleteDetail({$product.id},{$item.id});" class="btn btn-danger">delete</a>
                    </div>
                {/foreach}
            </div>
        </div>
        {/if}
        *}

        <div class="control-group">
            <label class="control-label">Delete</label>
            <div class="controls">
                <select name="item[is_deleted]">
                    <option value="0">active</option>
                    <option {if $product.is_deleted}selected="selected"{/if} value="1">deleted</option>
                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Details</label>
            <div class="controls">
                {if isset($details) && $details}
                    {foreach from=$details item=item}
                        {if !$product || !isset($product.details_ids) || !in_array($item.id,$product.details_ids)}
                        <div>
                            <label>
                                <span class="inlineBlock mR10">
                                    <input type="checkbox" name="item[details][]" value="{$item.id}">
                                </span>
                                {$item.iname}
                            </label>
                        </div>
                        {else}
                            <div>
                                {$item.iname}
                                <a onclick="Product.del(this);" data-target="products_details" data-item_id="{$item.id}" data-product_id="{$product.id}" class="btn btn-danger">delete</a>
                            </div>
                        {/if}
                    {/foreach}
                {/if}
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Photo</label>
            <div class="controls">
                <div id="product_photos">
                    {if isset($product.photos) && $product.photos}
                        {foreach from=$product.photos item=item}
                            <div id="product_photos_{$item.id}">
                                <img src="/{$item.photo_s}" alt=""/>
                                <div>{$item.iname}</div>
                                <div>{$item.idesc}</div>
                            </div>
                            <a onclick="Product.del(this);" data-target="products_photos" data-item_id="{$item.id}" data-product_id="{$product.id}" class="btn btn-danger">delete</a>
                        {/foreach}
                    {/if}
                </div>
                <a id="file_preview" class="btn btn-info" onclick="Window.load('/modal/upload/products/-1/1','win-upload','');">Load</a>
            </div>
        </div>

        <div class="control-group">
            <div class="controls">
                <a class="btn btn-large" data-form="#ajaxSaveProduct" data-action="/ajax/saveProduct" onclick="Ajax.save(this);">{l}SAVE{/l}</a>
            </div>
        </div>


    </form>
    <hr>

    <script type="text/javascript">
        {literal}

        Product = {
            del: function(el){
                //alert('target='+target+'target_id='+target_id+'product_id='+product_id);
                var target = $(el).attr('data-target'),
                    item_id = $(el).attr('data-item_id'),
                    product_id = $(el).attr('data-product_id');
                ajax_url = '/ajax/del/'+target;
                $.ajax({
                    url: ajax_url,
                    type: 'POST',
                    data: 'item[item_id]='+item_id+'&item[product_id]='+product_id,
                    dataType: 'json',
                    beforeSend: function(){
                    },
                    success: function(data){
                        if (data.status == 'success'){
                            $(el).addClass('btn-success');

                        } else {
                            $(el).addClass('btn-danger');
                            Window.load(SITE_URI+'modal/alertError/'+data.error,'win-alertError','');
                        }
                    }
                });
            }
        };

        {/literal}
    </script>