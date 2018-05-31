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
                url: '{{ route('song.edit.data', $song_id) }}',
                contentType: "application/json",
                success: function(data) {
                    // console.log(data);
                    // data = JSON.parse(data).model;
                    $('#artist').val(data.song.artist);
                    $('#track').val(data.song.track);
                    $('#link').val(data.song.link);
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
            $.ajax({
                type: "post",
                url: '{{route('song.update', $song_id)}}',
                data: ({artist: artist, track: track, link: link}),
                success: function(response) {

                }
            });
        });
    </script>
@endsection
