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

