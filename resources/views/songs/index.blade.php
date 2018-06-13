@extends('layouts.app')

@section('content')

    <div id="allSongs" class="pt-5">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add song</div>
                <div class="panel-body">
                    <div class="form-group">
                        <form class="form-inline">
                            <div class="form-group">
                                <input type="text" name="artist" id="artist" class="form-control" placeholder="Artist">
                            </div>
                            <div class="form-group">
                                <input type="text" name="track" id="track" class="form-control" placeholder="Track">
                            </div>
                            <div class="form-group">
                                <input type="text" name="link" id="link" class="form-control" placeholder="Link">
                            </div>
                            <div class="form-group">
                                <input type="text" name="duration" id="duration" class="form-control"
                                       placeholder="Duration (min)">
                            </div>
                            <input style="display: none;" type="text" value="" name="songId" id="songId"
                                   class="form-control">
                            <div id="controls" class="btn-group" role="group" aria-label="...">
                                <button class="btn btn-primary" type="button" id="addSong">Add song</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Songs</div>
                <div class="panel-body">
                    <div id="emptySongs" class="table-responsive">
                        <table class="table table-striped">
                            <thead style="background-color: #ddd; font-weight: bold;">
                            <tr>
                                <td>Artist</td>
                                <td>Track</td>
                                <td>Link</td>
                                <td>Duration</td>
                                <td>Updated by</td>
                                <td></td>
                                <td></td>

                            </tr>
                            </thead>
                            <tbody id="songsList">

                            </tbody>

                        </table>
                    </div>
                    <div id="pagination">

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function getIndexData() {
            $.ajax({
                url: "{{route('song.get.user.data')}}",
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem('token'),
                },
                success: function (songs) {
                    if (!songs) {
                        window.location = '{{route('home.index')}}';
                    }
                    var html = '';
                    for (i = 0; i < songs.data.length; i++) {
                        if (songs.data[i].admin === '1') {
                            html += '<tr id="' + songs.data[i].id + '">' +
                                '<td hidden class="songId">' + songs.data[i].id + '</td>' +
                                '<td id="art">' + songs.data[i].artist + '</td>' +
                                '<td id="trck">' + songs.data[i].track + '</td>' +
                                '<td><a id="lnk" target="_blank" href="' + songs.data[i].link + '">' + songs.data[i].link + '</a></td>' +
                                '<td id="drt">' + songs.data[i].duration + '</td>' +
                                '<td><small><b>' + songs.data[i].updated_by + '</b></small><br><small>' + songs.data[i].updated_at + '</small></td>' +
                                '<td><button id="editSong" class="btn btn-warning"><i class="fas fa-edit"></i></button></td>' +
                                '<td><button id="deleteSong" class="btn btn-danger" href=""><i class="fas fa-trash-alt"></i></button></td>' +
                                '</tr>';
                        }
                        else {
                            html += '<tr id="' + songs.data[i].id + '">' +
                                '<td hidden class="songId">' + songs.data[i].id + '</td>' +
                                '<td id="art">' + songs.data[i].artist + '</td>' +
                                '<td id="trck">' + songs.data[i].track + '</td>' +
                                '<td><a id="lnk" target="_blank" href="' + songs.data[i].link + '">' + songs.data[i].link + '</a></td>' +
                                '<td id="drt">' + songs.data[i].duration + '</td>' +
                                '<td><small><b>' + songs.data[i].updated_by + '</b></small><br><small>' + songs.data[i].updated_at + '</small></td>' +
                                '</tr>';
                        }
                    }

                    var pagination = '';
                    pagination += '<nav aria-label="Page navigation example">' +
                        '<ul class="pagination">' +
                        '<li class="page-item"><a class="page-link" href="' + songs.links.prev + '">Previous</a></li>' +
                        '<li class="page-item"><a class="page-link" href="' + songs.links.next + '">Next</a></li>' +
                        '</ul>' +
                        '</nav>';
                    $('#songsList').html(html);
                    $('#pagination').html(pagination);
                },

            });
        }

        $(document).ready(function () {
            getIndexData();
        });

        $('body').on('click', '#addSong', function () {
            var artist = $('#artist').val();
            var track = $('#track').val();
            var link = $('#link').val();
            var duration = $('#duration').val();

            $.ajax({
                type: "post",
                url: '{{route('song.store')}}',
                data: ({duration: duration, artist: artist, track: track, link: link}),
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem('token'),
                },
                success: function (response) {
                    $('#artist').val('');
                    $('#track').val('');
                    $('#link').val('');
                    $('#duration').val('');
                    html = '';
                    html += '<tr id="' + response.data.id + '">' +
                        '<td hidden class="songId">' + response.data.id + '</td>' +
                        '<td id="art">' + response.data.artist + '</td>' +
                        '<td id="trck">' + response.data.track + '</td>' +
                        '<td><a id="lnk" target="_blank" href="' + response.data.link + '">' + response.data.link + '</a></td>' +
                        '<td id="drt">' + response.data.duration + '</td>' +
                        '<td><small><b>' + response.data.updated_by + '</b></small><br><small>' + response.data.updated_at + '</small></td>' +
                        '<td><button id="editSong" class="btn btn-warning"><i class="fas fa-edit"></i></button></td>' +
                        '<td><button id="deleteSong" class="btn btn-danger" href=""><i class="fas fa-trash-alt"></i></button></td>' +
                        '</tr>';
                    $('#songsList').prepend(html);
                },
                error: function (errors) {
                    var errArtist = errors.responseJSON.errors.artist;
                    var errTrack = errors.responseJSON.errors.track;
                    var errLink = errors.responseJSON.errors.link;
                    var errDuration = errors.responseJSON.errors.duration;

                    if (typeof errArtist !== 'undefined') {
                        for (a = 0; a < errArtist.length; a++) {
                            setMessage('error', errArtist[a]);
                        }
                    }

                    if (typeof errTrack !== 'undefined') {
                        for (t = 0; t < errTrack.length; t++) {
                            setMessage('error', errTrack[t]);
                        }
                    }


                    if (typeof errLink !== 'undefined') {
                        for (l = 0; l < errLink.length; l++) {
                            setMessage('error', errLink[l]);
                        }
                    }


                    if (typeof errDuration !== 'undefined') {
                        for (d = 0; d < errDuration.length; d++) {
                            setMessage('error', errDuration[d]);
                        }
                    }

                }
            });
        });

        $('body').on('click', '#deleteSong', function () {
            var $row = $(this).closest("tr");
            var songId = $row.find(".songId").html();
            if (confirm('Are you sure you want to delete this song?')) {
                $.ajax({
                    type: "DELETE",
                    url: '{{\Illuminate\Support\Facades\URL::to('/')}}/api/v1/songs/' + songId,
                    data: $(this).serialize(),
                    contentType: "application/json",
                    headers: {
                        "Authorization": "Bearer " + localStorage.getItem('token'),
                    },
                    success: function (response) {
                        setMessage('success', 'Song has been deleted.');
                        $('#'+songId).css('display', 'none');
                    }
                });
            }
        });

        $('body').on('click', '#editSong', function () {
            var $row = $(this).closest("tr");
            var songId = $row.find(".songId").html();
            $('#addSong').html('Update song');
            $('#artist').val($row.find("#art").html());
            $('#songId').val(songId);
            $('#track').val($row.find("#trck").html());
            $('#link').val($row.find('#lnk').attr('href'));
            $('#duration').val($row.find("#drt").html());
            $('#addSong').attr('id', 'updateSong');
            if($('#cancel').length){
                $('#cancel').remove();
            }
            $('#controls').append('<button class="btn btn-warning" type="button" id="cancel">Cancel</button>')
        });

        $('body').on('click', '#cancel', function () {
            $('#artist').val('');
            $('#track').val('');
            $('#link').val('');
            $('#duration').val('');
            $('#songId').val(songId);
            $('#updateSong').html('Add song');
            $('#updateSong').attr('id', 'addSong');
            $('#cancel').remove();
        });

        $('body').on('click', '#updateSong', function () {
            var artist = $('#artist').val();
            var track = $('#track').val();
            var link = $('#link').val();
            var duration = $('#duration').val();
            var songId = $('#songId').val();
            $.ajax({
                type: "PUT",
                url: '{{\Illuminate\Support\Facades\URL::to('/')}}/api/v1/songs/' + songId,
                data: ({duration: duration, artist: artist, track: track, link: link}),
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem('token'),
                },
                success: function (response) {
                    $('#artist').val('');
                    $('#track').val('');
                    $('#link').val('');
                    $('#duration').val('');
                    $('#updateSong').attr('id', 'addSong');
                    $('#addSong').html('Add song');
                    if($('#cancel').length){
                        $('#cancel').remove();
                    }
                    $('#' + response.data.id).hide();


                    var html = '';
                    html += '<tr id="' + response.data.id + '">' +
                        '<td hidden class="songId">' + response.data.id + '</td>' +
                        '<td id="art">' + response.data.artist + '</td>' +
                        '<td id="trck">' + response.data.track + '</td>' +
                        '<td><a id="lnk" target="_blank" href="' + response.data.link + '">' + response.data.link + '</a></td>' +
                        '<td id="drt">' + response.data.duration + '</td>' +
                        '<td><small><b>' + response.data.updated_by + '</b></small><br><small>' + response.data.updated_at + '</small></td>' +
                        '<td><button id="editSong" class="btn btn-warning"><i class="fas fa-edit"></i></button></td>' +
                        '<td><button id="deleteSong" class="btn btn-danger" href=""><i class="fas fa-trash-alt"></i></button></td>' +
                        '</tr>';

                    $('#songsList').append(html);

                    setMessage('success', 'Song has been updated');
                },
                error: function (response) {
                    var errArtist = response.responseJSON.errors.artist;
                    var errTrack = response.responseJSON.errors.track;
                    var errLink = response.responseJSON.errors.link;
                    var errDuration = response.responseJSON.errors.duration;

                    if (typeof errArtist !== 'undefined') {
                        for (a = 0; a < errArtist.length; a++) {
                            setMessage('error', errArtist[a]);
                        }
                    }

                    if (typeof errTrack !== 'undefined') {
                        for (t = 0; t < errTrack.length; t++) {
                            setMessage('error', errTrack[t]);
                        }
                    }


                    if (typeof errLink !== 'undefined') {
                        for (l = 0; l < errLink.length; l++) {
                            setMessage('error', errLink[l]);
                        }
                    }

                    if (typeof errDuration !== 'undefined') {
                        for (d = 0; d < errDuration.length; d++) {
                            setMessage('error', errDuration[d]);
                        }
                    }
                }
            });
        });

        $(window).on('hashchange', function () {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    getPosts(page);
                }
            }
        });
        $(document).ready(function () {
            $(document).on('click', '#pagination a', function (e) {
                getPosts($(this).attr('href').split('page=')[1]);
                e.preventDefault();
            });
        });

        function getPosts(page) {
            $.ajax({
                url: '/api/v1/songs/?page=' + page,
                dataType: 'json',
            }).done(function (songs) {
                var html = '';
                for (i = 0; i < songs.data.length; i++) {
                    if (songs.data[i].admin === '1') {
                        html += '<tr>' +
                            '<td hidden class="songId">' + songs.data[i].id + '</td>' +
                            '<td id="art">' + songs.data[i].artist + '</td>' +
                            '<td id="trck">' + songs.data[i].track + '</td>' +
                            '<td><a id="lnk" target="_blank" href="' + songs.data[i].link + '">' + songs.data[i].link + '</a></td>' +
                            '<td id="trck">' + songs.data[i].track + '</td>' +
                            '<td><button id="editSong" class="btn btn-warning"><i class="fas fa-edit"></i></button></td>' +
                            '<td><button id="deleteSong" class="btn btn-danger" href=""><i class="fas fa-trash-alt"></i></button></td>' +
                            '</tr>';
                    }
                    else {
                        html += '<tr>' +
                            '<td hidden class="songId">' + songs.data[i].id + '</td>' +
                            '<td id="art">' + songs.data[i].artist + '</td>' +
                            '<td id="trck">' + songs.data[i].track + '</td>' +
                            '<td id="lnk"><a id="atr" target="_blank" href="' + songs.data[i].link + '">' + songs.data[i].link + '</a></td>' +
                            '<td id="trck">' + songs.data[i].track + '</td>' +
                            '</tr>';
                    }
                }
                $('#songsList').html(html);
                location.hash = page;
            }).fail(function () {
                alert('Posts could not be loaded.');
            });
        }
    </script>
@endsection
