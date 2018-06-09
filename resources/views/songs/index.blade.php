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
                            <input type="text" name="duration" id="duration" class="form-control" placeholder="Duration">
                        </div>
                        <button class="btn btn-primary" type="button" id="addSong">Add</button>
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
                    console.log(songs);
                    if (!songs)
                    {
                        window.location.replace('/');
                    }
                    var html = '';
                    for (i = 0; i < songs.data.length; i++) {
                        if (songs.data[i].admin === '1') {
                            html += '<tr>' +
                                '<td hidden class="songId">' + songs.data[i].id + '</td>' +
                                '<td id="art">' + songs.data[i].artist + '</td>' +
                                '<td id="trck">' + songs.data[i].track + '</td>' +
                                '<td id="lnk"><a id="atr" target="_blank" href="' + songs.data[i].link + '">' + songs.data[i].link + '</a></td>' +
                                '<td id="drt">' + songs.data[i].duration + '</td>' +
                                '<td><a href="' + songs.data[i].edit + '" class="btn btn-light"><i class="fas fa-edit"></i></a></td>' +
                                '<td><button id="deleteSong" class="btn btn-danger" href=""><i class="fas fa-trash-alt"></i></button></td>' +
                                '</tr>';
                        }
                        else if (songs.data[i].admin === '2') {
                            html += '<tr>' +
                                '<td hidden class="songId">' + songs.data[i].id + '</td>' +
                                '<td id="art">' + songs.data[i].artist + '</td>' +
                                '<td id="trck">' + songs.data[i].track + '</td>' +
                                '<td id="lnk"><a id="atr" target="_blank" href="' + songs.data[i].link + '">' + songs.data[i].link + '</a></td>' +
                                '<td id="trck">' + songs.data[i].track + '</td>' +
                                '<td><a href="' + songs.data[i].edit + '" class="btn btn-light"><i class="fas fa-edit"></i></a></td>' +
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

                    var pagination = '';
                    pagination += '<nav aria-label="Page navigation example">' +
                        '<ul class="pagination">' +
                        '<li class="page-item"><a class="page-link" href="' + songs.links.prev + '">Previous</a></li>' +
                        '<li class="page-item"><a class="page-link" href="' + songs.links.next + '">Next</a></li>' +
                        '</ul>' +
                        '</nav>';
                    $('#songsList').html(html);
                    $('#pagination').html(pagination);
                }
            });
        }

        $(document).ready(function () {
            getIndexData();
        });

        $('#addSong').click(function () {
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
                    console.log(response);
                    $('#artist').val('');
                    $('#track').val('');
                    $('#link').val('');
                    $('#duration').val('');
                    html = '';
                    html += '<tr>' +
                        '<td hidden class="songId">' + response.data.id + '</td>' +
                        '<td id="art">' + response.data.artist + '</td>' +
                        '<td id="trck">' + response.data.track + '</td>' +
                        '<td id="lnk"><a id="atr" target="_blank" href="' + response.data.link + '">' + response.data.link + '</a></td>' +
                        '<td id="drt">' + response.data.duration + '</td>' +
                        '<td><a href="' + response.data.edit + '" class="btn btn-light"><i class="fas fa-edit"></i></a></td>' +
                        '<td><button id="deleteSong" class="btn btn-danger" href=""><i class="fas fa-trash-alt"></i></button></td>' +
                        '</tr>';
                    $('#songsList').prepend(html);


                },
                error: function (errors) {

                    var errorData = errors.responseJSON.errors;
                    console.log(errorData);
                }
            });
        });

        $('body').on('click', '#deleteSong', function () {
            var $row = $(this).closest("tr");
            var songId = $row.find(".songId").html();

            $.ajax({
                type: "GET",
                url: '{{\Illuminate\Support\Facades\URL::to('/')}}/api/song/delete/' + songId,
                data: $(this).serialize(),
                contentType: "application/json",
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem('token'),
                },
                success: function (response) {
                    console.log(response);
                    // response = JSON.stringify(response);
                    console.log(response);
                    $('td:contains("' + response.data.id + '")').parent().css("display", "none");
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
                url: '/api/song/---------------?page=' + page,
                dataType: 'json',
            }).done(function (songs) {
                var html = '';
                for (i = 0; i < songs.data.length; i++) {
                    if (songs.data[i].admin === '1') {
                        html += '<tr>' +
                            '<td hidden class="songId">' + songs.data[i].id + '</td>' +
                            '<td id="art">' + songs.data[i].artist + '</td>' +
                            '<td id="trck">' + songs.data[i].track + '</td>' +
                            '<td id="lnk"><a id="atr" target="_blank" href="' + songs.data[i].link + '">' + songs.data[i].link + '</a></td>' +
                            '<td id="trck">' + songs.data[i].track + '</td>' +
                            '<td><a href="' + songs.data[i].edit + '" class="btn btn-light"><i class="fas fa-edit"></i></a></td>' +
                            '<td><button id="deleteSong" class="btn btn-danger" href=""><i class="fas fa-trash-alt"></i></button></td>' +
                            '</tr>';
                    }
                    else if (songs.data[i].admin === '2') {
                        html += '<tr>' +
                            '<td hidden class="songId">' + songs.data[i].id + '</td>' +
                            '<td id="art">' + songs.data[i].artist + '</td>' +
                            '<td id="trck">' + songs.data[i].track + '</td>' +
                            '<td id="lnk"><a id="atr" target="_blank" href="' + songs.data[i].link + '">' + songs.data[i].link + '</a></td>' +
                            '<td id="trck">' + songs.data[i].track + '</td>' +
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
