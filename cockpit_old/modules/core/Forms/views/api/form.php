<script>

    setTimeout(function(){

        if (!window.FormData) return;

        var form       = document.getElementById("{{ $options['id'] }}"),
            msgsuccess = form.getElementsByClassName("form-message-success").item(0),
            msgfail    = form.getElementsByClassName("form-message-fail").item(0),
            success = function(){
                if(msgsuccess) {
                    msgsuccess.style.display = 'block';
                } else {
                    alert("@lang('Form submission was successfull.')");
                }

                for(var i=0, max=form.elements.length;i<max;i++) form.elements[i].disabled = false;
            },
            fail = function(){
                if(msgfail) {
                    msgfail.style.display = 'block';
                } else {
                    alert("@lang('Form submission failed.')");
                }
            };

        if(msgsuccess) msgsuccess.style.display = "none";
        if(msgfail)    msgfail.style.display = "none";

        form.addEventListener("submit", function(e) {

            e.preventDefault();

            if(msgsuccess) msgsuccess.style.display = "none";
            if(msgfail)    msgfail.style.display = "none";

            var xhr = new XMLHttpRequest(), data = new FormData(form);

            xhr.onload = function(){

                if (this.status == 200 && this.responseText!='false') {
                    success();
                    form.reset();
                } else {
                    fail();
                }
            };

            for(var i=0, max=form.elements.length;i<max;i++) form.elements[i].disabled = true;

            xhr.open('POST', "@route('/api/forms/submit/'.$name)", true);
            xhr.send(data);

        }, false);

    }, 100);

</script>

<form id="{{ $options["id"] }}" name="{{ $name }}" class="{{ $options["class"] }}" action="@route('/api/forms/submit/'.$name)" method="post" onsubmit="return false;">
<input type="hidden" name="__csrf" value="{{ $options["csrf"] }}">
@if(isset($options["mailsubject"])):
<input type="hidden" name="__mailsubject" value="{{ $options["mailsubject"] }}">
@endif