function setMessage(type, data)
{
    if ('message' in data && type != null)
    {
        if (type === 'error')
        {
            type = 'danger';
        }

        // $('#messages').after('<div id="messages" class=""></div>');
        $('#messages').addClass('messages alert alert-'+type);
        $('#messages').text(data.message);
        window.setTimeout(function() {
            $('#messages').empty();
            $('#messages').removeClass('messages alert alert'+type);
        }, 3000);
    }
}


function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function eraseCookie(name) {
    document.cookie = name+'=; Max-Age=-99999999;';
}
