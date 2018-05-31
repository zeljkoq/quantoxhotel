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

function makePagination(links){
    var html = '';
    html += '<a onclick=getPaginate("'+links.first+'")>first</a>&nbsp&nbsp&nbsp';
    if(links.prev) {
        html += '<a onclick=getPaginate("' + links.prev + '")>prev</a>&nbsp&nbsp&nbsp';
    }
    if(links.next) {
        html += '<a onclick=getPaginate("' + links.next + '")>next</a>&nbsp&nbsp&nbsp';
    }
    html += '<a onclick=getPaginate("'+links.last+'")>last</a>';
    return html;
}