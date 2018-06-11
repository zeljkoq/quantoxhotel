@extends('layouts.app')

@section('content')

    <div id="content" class="row">
        <div class="col-md-12">
            <form class="form-horizontal">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="partyName" placeholder="Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Date</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="partyDate" placeholder="Date">
                    </div>
                </div>
                <div class="form-group">
                    <label for="partyDuration" class="col-sm-2 control-label">Duration (h)</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="partyDuration" placeholder="Duration">
                    </div>
                </div>
                <div class="form-group">
                    <label for="partyCapacity" class="col-sm-2 control-label">Capacity</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="partyCapacity" placeholder="Capacity">
                    </div>
                </div>
                <div class="form-group">
                    <label for="partyDescription" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="partyDescription" placeholder="Description">
                    </div>
                </div>
                <div class="form-group">
                    <label for="partyTags" class="col-sm-2 control-label">Tags</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="partyTags" placeholder="Tags">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-default">Save</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $.ajax({
                type: "GET",
                url: '{{route('get.party.user')}}',
                headers: {
                    "Accept" : "application/json",
                    "Content-Type" : "application/json",
                },
                success: function (response) {
                    // console.log(response);
                    if(!response)
                    {
                        window.location = '{{route('home.index')}}';
                    }
                }
            });
        });
    </script>
@endsection