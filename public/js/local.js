function setMessage(type, data) {

    if (type === 'error') {
        type = 'danger';
    }

    $('#messages').addClass('messages alert alert-' + type);
    $('#messages').append(data + '<br>');
    if (data !== null) {
        window.setTimeout(function () {
            $('#messages').empty();
            $('#messages').removeClass('messages');
            $('#messages').removeClass('alert');
            $('#messages').removeClass('alert-' + type);
        }, 6000);
    }
}

function setModalMessage(field, type, data) {

    if (type === 'error') {
        type = 'danger';
    }
    $('#' + field).addClass('alert alert-' + type);
    $('#' + field).append(data + '<br>');
    if (data !== null) {
        window.setTimeout(function () {
            $('#' + field).empty();
            $('#' + field).removeClass('alert');
            $('#' + field).removeClass('alert-' + type);
        }, 6000);
    }
}

function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
