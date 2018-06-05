@extends('adminlayouts.admin-layouts')


@section('ajax')
    <script>
        $(document).on('click', '.create-modal', function () {
            $('#create').modal('show');
            $('.modal-title').text('Add Route');
        });
        $("#add").click(function () {
            $.ajax({
                type: 'POST',
                url: 'route',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'bus_name': $('#bus_name').val(),
                    'route_id': $('input[name=route_id]').val(),
                    'route_name': $('input[name=route_name]').val(),
                    'source': $('input[name=source]').val(),
                    'destination': $('input[name=destination]').val(),
                    'boardingpoints': $('#boardingpoints').val(),

                    'fare': $('input[name=fare]').val()
                },
                success: function (data) {
                    console.log(data);
                    if ((data.errors)) {
                        console.log(errors);
                        $('.error').removeClass('hidden');
                        $('.error').text(data.errors.bus_name);
                        $('.error').removeClass('hidden');
                        $('.error').text(data.errors.route_id);
                        $('.error').removeClass('hidden');
                        $('.error').text(data.errors.route_name);
                        $('.error').removeClass('hidden');
                        $('.error').text(data.errors.source);
                        $('.error').removeClass('hidden');
                        $('.error').text(data.errors.destination);
                        $('.error').removeClass('hidden');
                        $('.error').text(data.errors.fare);
                    } else {
                        $('.error').remove();
                        $('#table').append("<tr class='routes'>" +
                            "<td>" + data.route_id + "</td>" +
                            "<td>" + data.route_name + "</td>" +
                            "<td>" + data.bus_name + "</td>" +
                            "<td>" + data.bus_number + "</td>" +
                            "<td>" + data.source + "</td>" +
                            "<td>" + data.destination + "</td>" +
                            "<td>" + data.fare + "</td>" +
                            "<td><button class='show-modal btn btn-info btn-sm' " +
                            "data-route_id='" + data.route_id +
                            "' data-route_name='" + data.route_name +
                            "' data-bus_name='" + data.tbl_bus_details_id +
                            "'data-bus_number='" + data.bus_number +
                            "'data-source='" + data.source +
                            "'data-destination='" + data.destination +
                            "'data-boardingpoints='" + data.boardingpoints +

                            "' data-fare='" + data.fare +
                            "'>" +
                            "<span class='fa fa-eye'></span>" +
                            "</button> " +
                            "<button class='edit-modal btn btn-warning btn-sm' " +
                            "data-route_id='" + data.route_id +
                            "' data-route_name='" + data.route_name +
                            "' data-bus_name='" + data.tbl_bus_details_id +
                            "'data-bus_number='" + data.bus_number +
                            "'data-source='" + data.source +
                            "'data-destination='" + data.destination +
                            "'data-boardingpoints='" + data.boardingpoints +

                            "' data-fare='" + data.fare +
                            "'>" +
                            "<span class='glyphicon glyphicon-pencil'></span>" +
                            "</button>" +
                            " <button class='delete-modal btn btn-danger btn-sm'" +
                            "data-route_id='" + data.route_id +
                            "' data-route_name='" + data.route_name +
                            "' data-bus_name='" + data.tbl_bus_details_id +
                            "'data-bus_number='" + data.bus_number +
                            "'data-source='" + data.source +
                            "'data-destination='" + data.destination +
                            "'data-boardingpoints='" + data.boardingpoints +

                            "' data-fare='" + data.fare +
                            "'><span class='glyphicon glyphicon-trash'></span></button></td>" +
                            "</tr>");
//                        location.reload();
                        $('#create').modal('hide');
                        location.reload();

                    }
                },
            });
            $('#bus_name').val('');
            $('#route_id').val('');
            $('#route_name').val('');
            $('#source').val('');
            $('#destination').val('');
            $('#fare').val('');


        });


        $(document).on('click', '.edit-modal', function () {
            $('#update').modal('show');
            $('.modal-title').text('Update Route');

            /*
             populating data to the bootstrap modal for updating
             */
            $('#u_tbl_route_details_id').val($(this).data('id'));
            $('#u_bus_name').val($(this).data('bus_name')).attr('selected', true);
            $('#u_route_id').val($(this).data('route_id'));
            $('#u_route_name').val($(this).data('route_name'));
            $('#u_source').val($(this).data('source'));
            $('#u_destination').val($(this).data('destination'));
            $('#u_boardingpoints').val($(this).data('boardingpoints')).attr('selected', 'true');
            $('#u_fare').val($(this).data('fare'));


            $('#update').click(function () {
                $.ajax({
                    type: 'POST',
                    url: 'routeupdate',
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'tbl_route_details_id': $('input[name=u_tbl_route_details_id]').val(),
                        'bus_name': $('#u_bus_name').val(),
                        'route_id': $('input[name=u_route_id]').val(),
                        'route_name': $('input[name=u_route_name]').val(),
                        'source': $('input[name=u_source]').val(),
                        'destination': $('input[name=u_destination]').val(),
                        'boardingpoints': $('#u_boardingpoints').val(),
                        'fare': $('input[name=u_fare]').val()
                    },
                    success: function (data) {
                        console.log(data);
                    }
                });

            });
        });




    </script>
@endsection


@section('content')
    <div class="row">
        <div class="table table-responsive">
            <table class="table table-bordered" id="table">
                <tr>
                    <th>Route Id</th>

                    <th width="150px">Route Name</th>
                    <th>Bus Name</th>
                    <th>Bus Number</th>

                    <th>Source</th>
                    <th>Destination</th>
                    <th>Fare</th>
                    <th class="text-center" width="150px">
                        <button class="create-modal btn btn-success btn-sm">
                            <i class="glyphicon glyphicon-plus"></i>
                        </button>
                    </th>
                </tr>
                {{ csrf_field() }}

                @foreach ($route as $routes)
                    <tr class="route{{$routes->route_id}}">
                        <td>{{ $routes->route_id }}</td>
                        <td>{{$routes->route_name}}</td>
                        <td>{{$routes->bus_name}}</td>
                        <td>{{$routes->bus_number}}</td>
                        <td>{{ $routes->source  }}</td>
                        <td>{{ $routes->destination }}</td>
                        <td>{{ $routes->fare }}</td>
                        <td>
                            <a href="#" class="show-modal btn btn-info btn-sm"
                               data-id="{{$routes->tbl_route_details_id}}"
                               data-route_id="{{$routes->route_id}}"
                               data-route_name="{{$routes->route_name}}"
                               data-bus_name="{{$routes->tbl_bus_details_id}}"
                               data-bus_number="{{$routes->bus_number}}"
                               data-source="{{$routes->source}}"
                               data-destination="{{$routes->destination}}"
                               data-fare="{{$routes->fare}}">

                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="#" class="edit-modal btn btn-warning btn-sm"
                               data-id="{{$routes->tbl_route_details_id}}"

                               data-route_id="{{$routes->route_id}}"
                               data-route_name="{{$routes->route_name}}"
                               data-bus_name="{{$routes->tbl_bus_details_id}}"
                               data-bus_number="{{$routes->bus_number}}"
                               data-source="{{$routes->source}}"
                               data-destination="{{$routes->destination}}"
                               data-fare="{{$routes->fare}}">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </a>
                            <a href="#" class="delete-modal btn btn-danger btn-sm"
                               data-id="{{$routes->tbl_route_details_id}}"

                               data-route_id="{{$routes->route_id}}"
                               data-route_name="{{$routes->route_name}}"
                               data-bus_name="{{$routes->tbl_bus_details_id}}"
                               data-bus_number="{{$routes->bus_number}}"
                               data-source="{{$routes->source}}"
                               data-destination="{{$routes->destination}}"
                               data-fare="{{$routes->fare}}">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>










    {{-- Modal Form Create Route --}}
    <div id="create" class="modal fade" tabindex=-1 role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <div class="form-group row add">
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="tbl_route_details_id"
                                       name="tbl_route_details_id" required hidden>
                                <p class="error text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="busname">Bus Name</label>
                            <select name="bus_name" id="bus_name" class="form-control">
                                <option value="">Bus Name</option>
                                @foreach($source as $busname)
                                    <option value="{{$busname->tbl_bus_details_id}}">{{$busname->bus_name}}
                                        ({{$busname->bus_number}})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="route_id">Route ID :</label>
                            <input type="text" class="form-control" id="route_id" name="route_id"
                                   required>
                            <p class="error text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="route_name">Route Name :</label>
                            <input type="text" class="form-control" id="route_name" name="route_name"
                                   required>
                            <p class="error text-center alert alert-danger hidden"></p>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="source">Source</label>
                            <input type="text" id="source" name="source" class="form-control">
                            <p class="error text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="destination">Destination</label>
                            <input type="text" id="destination" name="destination" class="form-control">
                            <p class="error text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                            <label for="boardingpoints">BoardingPoints</label>
                            <select name="boardingpoints" id="boardingpoints" class="form-control ui fluid dropdown"
                                    multiple>
                                <option value="">BoardingPoints</option>
                                @foreach($boardingpoints as $bdp)
                                    <option value="{{$bdp->boarding_points_name}}">{{$bdp->boarding_points_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="fare">Fare</label>
                            <input type="text" class="form-control" id="fare" name="fare"
                                   required>
                            <p class="error text-center alert alert-danger hidden"></p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning" id="add">
                        <span class="glyphicon glyphicon-plus"></span>Add Route
                    </button>
                    <button class=" btn btn-warning" type="button" data-dismiss="modal">
                        <span class="glyphicon glyphicon-remobe"></span>Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Form update Route --}}
    <div id="update" class="modal fade" tabindex=-1 role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <div class="form-group row add">
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="u_tbl_route_details_id"
                                       name="u_tbl_route_details_id" required disabled hidden>
                                <p class="error text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="busname">Bus Name</label>
                            <select name="u_bus_name" id="u_bus_name" class="form-control">
                                <option value="">Bus Name</option>
                                @foreach($source as $busname)
                                    <option value="{{$busname->tbl_bus_details_id}}">{{$busname->bus_name}}
                                        ({{$busname->bus_number}})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="route_id">Route ID :</label>
                            <input type="text" class="form-control" id="u_route_id" name="u_route_id"
                                   required>
                            <p class="error text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="route_name">Route Name :</label>
                            <input type="text" class="form-control" id="u_route_name" name="u_route_name"
                                   required>
                            <p class="error text-center alert alert-danger hidden"></p>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="source">Source</label>
                            <input type="text" id="u_source" name="u_source" class="form-control">
                            <p class="error text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="destination">Destination</label>
                            <input type="text" id="u_destination" name="u_destination" class="form-control">
                            <p class="error text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                            <label for="boardingpoints">BoardingPoints</label>
                            <select name="u_boardingpoints" id="u_boardingpoints" class="form-control ui fluid dropdown"
                                    multiple>
                                <option value="">BoardingPoints</option>
                                @foreach($boardingpoints as $bdp)
                                    <option value="{{$bdp->boarding_points_name}}">{{$bdp->boarding_points_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="fare">Fare</label>
                            <input type="text" class="form-control" id="u_fare" name="u_fare"
                                   required>
                            <p class="error text-center alert alert-danger hidden"></p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning" id="update">
                        <span class="glyphicon glyphicon-plus"></span>update Route
                    </button>
                    <button class=" btn btn-warning" type="button" data-dismiss="modal">
                        <span class="glyphicon glyphicon-remobe"></span>Close
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection












































































































































