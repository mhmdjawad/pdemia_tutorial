

class SYS{
    static login(that){
        let email = $(that).parents("form").find("input[name='email']").val();
        let password = $(that).parents("form").find("input[name='password']").val();
        let fd = new FormData();
        fd.append("key","login/submitlogin");
        fd.append("email",email);
        fd.append("password",password);
        this.xhr(fd, $(that).attr("to") );
    }
    static xhr(_data,OutContainer,_success){
        let _url = SELF_DIR;
        let cfg = {
            url: _url,
            data: _data,
            method:"POST",
            cache: false,
            contentType: false,
            processData: false,
        };
        cfg.xhr = function(){
            var xhr = new window.XMLHttpRequest();
            //Upload progress
            xhr.upload.addEventListener("progress", function(evt){
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    //Do something with upload progress
                    //console.log(percentComplete);
                    percentComplete = percentComplete * 100;
                    percentComplete = parseInt(percentComplete);
                    if(OutContainer != null){
                        document.getElementById(OutContainer).innerHTML = "Uploading ..." + percentComplete + " % " ;
                    }
                }
            }, false);
            //Download progress
            xhr.addEventListener("progress", function(evt){
            if (evt.lengthComputable) {
                var percentComplete = evt.loaded / evt.total;
                //Do something with download progress
                //console.log(percentComplete);
                percentComplete = percentComplete * 100;
                percentComplete = parseInt(percentComplete);
                if(OutContainer != null){
                    document.getElementById(OutContainer).innerHTML = "Downloading ..." + percentComplete + " % " ;
                }
            }
            }, false);
            return xhr;
        };
        cfg.success = function (resp) {
            try{
                if (_success) _success(resp,OutContainer);
                else $(`#${OutContainer}`).html(resp);
            }
            catch(error){
                console.log(error);
                if(OutContainer != null){
                    $("#"+OutContainer).html(error);
                }
            }
        }
        $.ajax(cfg);
    }
}