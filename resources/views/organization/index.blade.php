@extends('layouts.app')

@section('content')

    <div id="content" class="row">
        <div class="col-md-12">
            <form class="form-horizontal">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="partyName" name="partyName" placeholder="Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Date</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="partyDate" name="partyDate" placeholder="Date">
                    </div>
                </div>
                <div class="form-group">
                    <label for="partyDuration" class="col-sm-2 control-label">Duration (h)</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="partyDuration" name="partyDuration" placeholder="Duration">
                    </div>
                </div>
                <div class="form-group">
                    <label for="partyCapacity" class="col-sm-2 control-label">Capacity</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="partyCapacity" name="partyCapacity" placeholder="Capacity">
                    </div>
                </div>
                <div class="form-group">
                    <label for="partyDescription" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="partyDescription" name="partyDescription" placeholder="Description">
                    </div>
                </div>
                <div class="form-group">
                    <label for="partyTags" class="col-sm-2 control-label">Tags</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="partyTags" name="partyTags" placeholder="Tags">
                    </div>
                </div>
                <div class="form-group">
                    {{--<div class="col-sm-offset-2 col-sm-10">--}}
                        {{--<button type="button" class="btn btn-default" id="addParty">Save</button>--}}
                    {{--</div>--}}
                    <div id="controls" class="btn-group" role="group" aria-label="...">
                        <button class="btn btn-primary" type="button" id="addParty">Add song</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Parties</div>
                <div class="panel-body">
                    <div id="emptySongs" class="table-responsive">
                        <table class="table table-striped">
                            <thead style="background-color: #ddd; font-weight: bold;">
                            <tr>
                                <td>Name</td>
                                <td>Date</td>
                                <td>Duration (h)</td>
                                <td>Capacity</td>
                                <td>Description</td>
                                <td>Tags</td>
                                <td>Updated by</td>
                                <td></td>
                                <td></td>

                            </tr>
                            </thead>
                            <tbody id="partiesList">

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
                url: '{{route('get.party.user')}}',
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem('token'),
                },
                success: function (response) {
                    if (!response) {
                        window.location = '{{route('home.index')}}';
                    }
                    var html = '';
                    for (i = 0; i < response.data.length; i++) {
                            html += '<tr id="' + response.data[i].id + '">' +
                                '<td hidden class="partyId">' + response.data[i].id + '</td>' +
                                '<td id="pName">' + response.data[i].name + '</td>' +
                                '<td id="pDate">' + response.data[i].date + '</td>' +
                                '<td id="pDuration">' + response.data[i].duration + '</td>' +
                                '<td id="pCapacity">' + response.data[i].capacity + '</td>' +
                                '<td id="pDescription">' + response.data[i].description + '</td>' +
                                '<td id="pTags">' + response.data[i].tags + '</td>' +
                                '<td><small><b>' + response.data[i].updated_by + '</b></small><br><small>' + response.data[i].updated_at + '</small></td>' +
                                '<td><button id="editParty" class="btn btn-warning"><i class="fas fa-edit"></i></button></td>' +
                                '<td><button id="deleteSong" class="btn btn-danger" href=""><i class="fas fa-trash-alt"></i></button></td>' +
                                '</tr>';
                    }

                    var pagination = '';
                    pagination += '<nav aria-label="Page navigation example">' +
                        '<ul class="pagination">' +
                        '<li class="page-item"><a class="page-link" href="' + response.links.prev + '">Previous</a></li>' +
                        '<li class="page-item"><a class="page-link" href="' + response.links.next + '">Next</a></li>' +
                        '</ul>' +
                        '</nav>';
                    $('#partiesList').html(html);
                    $('#pagination').html(pagination);
                },

            });
        }

        $(document).ready(function () {
            getIndexData();
        });

        $('body').on('click', '#addParty', function () {
            var name = $('#partyName').val();
            var date = $('#partyDate').val();
            var duration = $('#partyDuration').val();
            var capacity = $('#partyCapacity').val();
            var description = $('#partyDescription').val();
            var tags = $('#partyTags').val();
            $.ajax({
                type: "POST",
                url: '{{route('party.store')}}',
                data: ({partyName: name, partyDate: date, partyDuration: duration, partyCapacity: capacity, partyDescription: description, partyTags: tags}),
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem('token'),
                },
                success: function (response) {
                    $('#partyName').val('');
                    $('#partyId').val('');
                    $('#partyDate').val('');
                    $('#partyDuration').val('');
                    $('#partyCapacity').val('');
                    $('#partyDescription').val('');
                    $('#partyTags').val('');

                    var html = '';
                        html += '<tr id="' + response.data.id + '">' +
                            '<td hidden class="partyId">' + response.data.id + '</td>' +
                            '<td id="pName">' + response.data.name + '</td>' +
                            '<td id="pDate">' + response.data.date + '</td>' +
                            '<td id="pDuration">' + response.data.duration + '</td>' +
                            '<td id="pCapacity">' + response.data.capacity + '</td>' +
                            '<td id="pDescription">' + response.data.description + '</td>' +
                            '<td id="pTags">' + response.data.tags + '</td>' +
                            '<td><small><b>' + response.data.updated_by + '</b></small><br><small>' + response.data.updated_at + '</small></td>' +
                            '<td><button id="editParty" class="btn btn-warning"><i class="fas fa-edit"></i></button></td>' +
                            '<td><button id="deleteSong" class="btn btn-danger" href=""><i class="fas fa-trash-alt"></i></button></td>' +
                            '</tr>';

                    $('#partiesList').prepend(html);
                },
                error: function (response) {
                    var errName = response.responseJSON.errors.partyName;
                    var errDate = response.responseJSON.errors.partyDate;
                    var errDuration = response.responseJSON.errors.partyDuration;
                    var errCapacity = response.responseJSON.errors.partyCapacity;
                    var errDescription = response.responseJSON.errors.partyDescription;
                    var errTags = response.responseJSON.errors.partyTags;

                    if (typeof errName !== 'undefined') {
                        for (a = 0; a < errName.length; a++) {
                            setMessage('error', errName[a]);
                        }
                    }

                    if (typeof errDate !== 'undefined') {
                        for (b = 0; b < errDate.length; b++) {
                            setMessage('error', errDate[b]);
                        }
                    }

                    if (typeof errDuration !== 'undefined') {
                        for (c = 0; c < errDuration.length; c++) {
                            setMessage('error', errDuration[c]);
                        }
                    }

                    if (typeof errCapacity !== 'undefined') {
                        for (d = 0; d < errCapacity.length; d++) {
                            setMessage('error', errCapacity[d]);
                        }
                    }
                    if (typeof errDescription !== 'undefined') {
                        for (e = 0; e < errDescription.length; e++) {
                            setMessage('error', errDescription[e]);
                        }
                    }
                    if (typeof errTags !== 'undefined') {
                        for (f = 0; f < errTags.length; f++) {
                            setMessage('error', errTags[f]);
                        }
                    }
                }
            });
        });
        $('body').on('click', '#editParty', function () {
            var $row = $(this).closest("tr");
            var partyId = $row.find(".partyId").html();
            $('#addParty').html('Update party');

            $('#partyName').val($row.find("#pName").html());
            $('#partyId').val(partyId);
            $('#partyDate').val($row.find("#pDate").html());
            $('#partyDuration').val($row.find("#pDuration").html());
            $('#partyCapacity').val($row.find("#pCapacity").html());
            $('#partyDescription').val($row.find("#pDescription").html());
            $('#partyTags').val($row.find("#pTags").html());


            $('#addParty').attr('id', 'updateParty');
            if($('#cancel').length){
                $('#cancel').remove();
            }
            $('#controls').append('<button class="btn btn-warning" type="button" id="cancel">Cancel</button>')
        });

        $('body').on('click', '#cancel', function () {
            $('#partyName').val('');
            $('#partyId').val('');
            $('#partyDate').val('');
            $('#partyDuration').val('');
            $('#partyCapacity').val('');
            $('#partyDescription').val('');
            $('#partyTags').val('');
            $('#updateParty').html('Add party');
            $('#updateParty').attr('id', 'addParty');
            $('#cancel').remove();
        });
    </script>
@endsection