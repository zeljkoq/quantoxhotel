@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    Edit song
                    <small class="float-right"><i class="fas fa-arrow-circle-left fa-2x"></i></small>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        {{--<form action="/updatesong/{{$song->id}}" method="POST">--}}
                        <div class="form-row">
                            <div class="col-4">
                                <input type="text" id="artist" name="artist" class="form-control" placeholder="" value="">
                            </div>
                            <div class="col">
                                <input type="text" id="track" name="track" class="form-control" placeholder="" value="">
                            </div>
                            <div class="col">
                                <input type="text" id="link" name="link" class="form-control" placeholder="" value="">
                            </div>
                            <div class="col">
                                <input type="text" id="duration" name="duration" class="form-control" placeholder="" value="">
                            </div>
                            <button class="btn btn-primary" type="button" id="updateSong">Update</button>
                        </div>
                        {{--</form>--}}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        function getSongData()
        {
            $.ajax({
                type: "GET",
                url: '{{ route('song.edit.data', $song_id) }}',

                success: function(data) {
                    if (!data)
                    {
                        window.location.replace('/');
                    }
                    $('#artist').val(data.song.artist);
                    $('#track').val(data.song.track);
                    $('#link').val(data.song.link);
                    $('#duration').val(data.song.duration);
                }
            });
        }

        $(document).ready(function () {
            getSongData();
        });

        $('#updateSong').click(function() {
            var artist = $('#artist').val();
            var track = $('#track').val();
            var link = $('#link').val();
            var duration = $('#duration').val();

            $.ajax({
                type: "post",
                url: '{{route('song.update', $song_id)}}',
                data: ({duration: duration, artist: artist, track: track, link: link}),
                headers: {
                    "Authorization" : "Bearer " + localStorage.getItem('token'),
                },
                success: function(response) {

                }
            });
        });
    </script>
@endsection
