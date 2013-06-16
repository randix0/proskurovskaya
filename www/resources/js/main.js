Ajax = {
    callback: null,
    save: function(el){
        var ajax_form = $(el).attr('data-form'),
            ajax_url = $(ajax_form).attr('action'),
            ajax_data = $(ajax_form).serialize();
        if (!ajax_data) {
            $(el).addClass('btn-danger');
            return false;
        }
        $.ajax({
            url: ajax_url,
            type: 'POST',
            data: ajax_data,
            dataType: 'json',
            beforeSend: function(){
                $('#upload_loader').show();
            },
            success: function(data){
                $('#upload_loader').hide();
                if (data.status == 'success'){
                    //console.log('Photo.save: success!');
                    $(el).addClass('btn-success');

                    if (Ajax.callback)
                        Ajax.callback(data);
                } else {
                    $(el).addClass('btn-danger');
                    //console.log('Photo.save: error!');
                    Window.load(SITE_URI+'modal/alertError/'+data.error,'win-alertError','');
                }
            }
        });
    }
};

Upload = {
    action: null,
    holder : null,
    tests : {
        filereader: null,
        dnd: null,
        formdata: null,
        progress: null
    },
    support : {
        filereader: null,
        formdata: null,
        progress: null
    },
    acceptedTypes : {
        'image/png': true,
        'image/jpeg': true,
        'image/gif': true
        /*
        'application/pdf' : true,
        'application/msword' : true,
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' : true
        */
    },
    progress : null,
    fileupload : null,
    callback : null,
    previewfile: function(file) {
        if (Upload.tests.filereader === true && Upload.acceptedTypes[file.type] === true) {
            var reader = new FileReader();
            reader.onload = function (event) {
                var image = new Image();
                image.src = event.target.result;
                image.width = 250; // a fake resize
                Upload.holder.appendChild(image);
            };

            reader.readAsDataURL(file);
        }  else {
            Upload.holder.innerHTML += '<p>Uploaded ' + file.name + ' ' + (file.size ? (file.size/1024|0) + 'K' : '');
            console.log(file);
        }
    },
    readfiles: function(files) {
        var formData = Upload.tests.formdata ? new FormData() : null;
        for (var i = 0; i < files.length; i++) {
            if (Upload.tests.formdata) formData.append('userfile[]', files[i]);
            if (!Upload.callback)Upload.previewfile(files[i]);
        }

        // now post a new XHR request
        if (Upload.tests.formdata) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', Upload.action);
            xhr.onload = function() {
                Upload.progress.value = Upload.progress.innerHTML = 100;

                //console.log(data.file_name);
                if (Upload.callback) {
                    data = JSON.parse(xhr.responseText);
                    Upload.callback(data);
                }
            };

            if (Upload.tests.progress) {
                xhr.upload.onprogress = function (event) {
                    if (event.lengthComputable) {
                        var complete = (event.loaded / event.total * 100 | 0);
                        Upload.progress.value = Upload.progress.innerHTML = complete;
                    }
                }
            }

            xhr.send(formData);
        }
    },
    init: function(item_id, upload_type){
        Upload.action = '/ajax/uploadFile/' + upload_type+ '/' + item_id;
        Upload.holder = document.getElementById('holder');
        Upload.support.filereader = document.getElementById('filereader');
        Upload.support.formdata = document.getElementById('formdata');
        Upload.support.progress = document.getElementById('progress');

        Upload.tests.filereader = typeof FileReader != 'undefined';
        Upload.tests.dnd = 'draggable' in document.createElement('span');
        Upload.tests.formdata = !!window.FormData;
        Upload.tests.progress = "upload" in new XMLHttpRequest;
        Upload.progress = document.getElementById('uploadprogress');
        Upload.fileupload = document.getElementById('upload');



        "filereader formdata progress".split(' ').forEach(function (api) {
            if (Upload.tests[api] === false) {
                Upload.support[api].className = 'fail';
            } else {
                // FFS. I could have done el.hidden = true, but IE doesn't support
                // hidden, so I tried to create a polyfill that would extend the
                // Element.prototype, but then IE10 doesn't even give me access
                // to the Element object. Brilliant.
                Upload.support[api].className = 'hidden';
            }
        });

        if (Upload.tests.dnd) {
            Upload.holder.ondragover = function () { this.className = 'hover'; return false; };
            Upload.holder.ondragend = function () { this.className = ''; return false; };
            Upload.holder.ondrop = function (e) {
                this.className = '';
                e.preventDefault();
                Upload.readfiles(e.dataTransfer.files);
            }
        } else {
            Upload.fileupload.className = 'hidden';
        }
        Upload.fileupload.querySelector('#input_userfile').onchange = function () {
            Upload.readfiles(this.files);
        };
    }
};

Cookie = {
    get: function(name) {
        var cookie = " " + document.cookie;
        var search = " " + name + "=";
        var setStr = null;
        var offset = 0;
        var end = 0;
        if (cookie.length > 0) {
            offset = cookie.indexOf(search);
            if (offset != -1) {
                offset += search.length;
                end = cookie.indexOf(";", offset);
                if (end == -1) {
                    end = cookie.length;
                }
                setStr = unescape(cookie.substring(offset, end));
            }
        }
        return (setStr);
    },
    set: function(name, value, expires, path, domain, secure) {
        document.cookie = name + "=" + escape(value) + ((expires) ? "; expires=" + expires : "") + ((path) ? "; path=" + path : "") + ((domain) ? "; domain=" + domain : "") + ((secure) ? "; secure" : "");
    }
}