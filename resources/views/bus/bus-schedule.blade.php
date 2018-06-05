@extends('adminlayouts.admin-layouts')
@section('css')
    <link href="{{asset('css/datetimepicker.min.css')}}" rel="stylesheet">
@endsection



@section('moment')
    <script src="{{asset('js/moment.js')}}"></script>
@endsection
@section('datetimepickerjs')
    <script src="{{asset('js/datetimepicker.min.js')}}"></script>
@endsection


@section('content')

    <div class="row">
        {{--tabbed pane for easy navigation--}}

        <ul class="nav nav-tabs col-lg-offset-2" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="add-schedule-tab" data-toggle="tab" href="#add-schedule" role="tab"
                   aria-controls="add-schedule" aria-selected="true"><h4 class="text text-success">ADD SCHEDULE</h4></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="view-schedule-tab" data-toggle="tab" href="#view-schedule" role="tab"
                   aria-controls="view-schedule" aria-selected="false"><h4 class="text text-success">VIEW SCHEDULE</h4>
                </a>
            </li>

        </ul>

        <div class="tab-content" style="margin-top: 30px;">
            <div class="tab-pane active" id="add-schedule" role="tabpanel" aria-labelledby="add-schedule-tab">
                <div class="header col-lg-offset-2">
                    <h1 class="text text-primary">BUS TRIP SCHEDULE</h1>
                </div>
                <div class="flash-message col-lg-8 col-lg-offset-2 col-md-offset-2">
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))

                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#"
                                                                                                     class="close"
                                                                                                     data-dismiss="alert"
                                                                                                     aria-label="close">&times;</a>
                            </p>
                        @endif
                    @endforeach
                </div> <!-- end .flash-message -->
                <div class="bus-trip-schedule col-lg-offset-2">
                    <form method="post" action="{{route('schedule.add')}}">
                        {{csrf_field()}}
                        <div class="form-group col-lg-6">
                            <span class="error text text-danger">{{ $errors->first('trip_id') }}</span><br>

                            <label for="trip-id">Trip ID</label>
                            <input type="text" name="trip_id" id="trip_id" class="form-control">

                        </div>
                        <div class="form-group col-lg-6">
                            <span class="error text text-danger">{{ $errors->first('route_name') }}</span><br>

                            <label for="route_name">Route Name</label>
                            <select name="route_name" id="route_name" class="fluid ui dropdown form-control">
                                <option value="">Route Name</option>
                                @foreach($route_details as $route_name)
                                    <option value="{{$route_name->route_name}}">{{$route_name->route_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <span class="error text text-danger">{{ $errors->first('bus_name') }}</span><br>

                            <label for="bus_name">Bus Name</label>
                            <select name="bus_name" id="bus_name" class=" ui dropdown form-control">
                                <option value="">Bus Name</option>
                                @foreach($route_details as $bus_name)
                                    <option value="{{$bus_name->tbl_bus_details_id}}">{{$bus_name->bus_name}}&nbsp;&nbsp;({{$bus_name->bus_number}}
                                        )
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <span class="error text text-danger">{{ $errors->first('source') }}</span><br>

                            <label for="source">Source</label>
                            <select name="source" id="source" class=" ui dropdown form-control">
                                <option value="">Source</option>
                                @foreach($route_details as $source)
                                    <option value="{{$source->source}}">{{$source->source}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <span class="error text text-danger">{{ $errors->first('arrival_time') }}</span><br>

                            <label for="arrival-time">Arrival Time</label>
                            <input type="text" id="timepick1" name="arrival_time" class="form-control"
                                   placeholder="Enter Arrival Time">
                        </div>
                        <div class="form-group col-lg-6">
                            <span class="error text text-danger">{{ $errors->first('destination') }}</span><br>

                            <label for="destination">Destination</label>
                            <select name="destination" id="destination" class=" ui dropdown form-control">
                                <option value="">Destination</option>
                                @foreach($route_details as $destination)
                                    <option value="{{$destination->destination}}">{{$destination->destination}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group col-lg-6">
                            <span class="error text text-danger">{{ $errors->first('departure_time') }}</span><br>

                            <label for="departure-time">Departure Time</label>
                            <input type="text" id="timepick2" name="departure_time" class="form-control"
                                   placeholder="Enter Departure Time">
                        </div>

                        <div class="form-group col-lg-6">
                            <span class="error text text-danger">{{ $errors->first('onward_date') }}</span><br>

                            <label for="onward-date">ONWARD DATE</label>
                            <input type="text" id="datepick1" name="onward_date" class="form-control"
                                   placeholder="Enter Date">
                        </div>


                        <div class="form-group ">
                            <button type="submit" class="btn btn-success"
                                    style="margin-top: 25px;margin-left: 20px;">Save
                            </button>

                        </div>
                    </form>

                </div>

            </div>
            <div class="tab-pane" id="view-schedule" role="tabpanel" aria-labelledby="view-schedule-tab">
                <div class="view-schedule col-lg-offset-2">


                    <div class="view-schedule-table table table-responsive">
                        <table class="table table-bordered" id="schedule-table">
                            <thead class="bg-info">
                            <tr>
                                <th>Trip NO</th>
                                <th>Bus No</th>
                                <th>Route Name</th>
                                <th>Source</th>
                                <th>Destination</th>
                                <th>Onward Date</th>
                                <th>Arrival Time</th>
                                <th>Departure Time</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            @foreach($route as $schedule)
                                <tr>
                                    <td>{{$schedule->trip_id}}</td>
                                    <td>{{$schedule->bus_number}}</td>
                                    <td>{{$schedule->route_name}}</td>
                                    <td>{{$schedule->source}}</td>
                                    <td>{{$schedule->destination}}</td>
                                    <td>{{$schedule->onward_date}}</td>
                                    <td>{{$schedule->arrival_time}}</td>
                                    <td>{{$schedule->departure_time}}</td>
                                    <td>


                                        <a href="#">
                                            <button type="button" class="btn btn-success btn-xs viewschedule"
                                                    data-toggle="modal" id=" {{$schedule->tbl_bus_trip_schedule_id}}">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </button>
                                        </a>
                                        <a href="#">
                                            <button class="btn btn-danger btn-xs deleteschedule" data-id="{{$schedule->tbl_bus_trip_schedule_id}}" data-toggle="modal"
                                                    id="{{$schedule->tbl_bus_trip_schedule_id}}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>





    <!-- Modal -->
    <div class="modal fade" id="viewSchedule" tabindex="-1" role="dialog" aria-labelledby="viewScheduleTitle"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewScheduleTitle">UPDATE SCHEDULE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#">
                        {{csrf_field()}}
                        <input type="text" name="tr_id" id="tr_id" class="form-control" hidden>

                        <div class="form-group col-lg-6">
                            <span class="error1 text text-danger hidden"></span><br>

                            <label for="trip-id">Trip ID</label>
                            <input type="text" name="t_id" id="t_id" class="form-control">

                        </div>
                        <div class="form-group col-lg-6">
                            <span class="error2 text text-danger hidden"></span><br>

                            <label for="route_name">Route Name</label>
                            <select name="r_name" id="r_name" class="fluid ui dropdown form-control">
                                <option value="">Route Name</option>
                                @foreach($route_details as $route_name)
                                    <option value="{{$route_name->route_name}}">{{$route_name->route_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <span class="error3 text text-danger hidden"></span><br>

                            <label for="bus_name">Bus Name</label>
                            <select name="b_name" id="b_name" class=" ui dropdown form-control">
                                <option value="">Bus Name</option>
                                @foreach($route_details as $bus_name)
                                    <option value="{{$bus_name->tbl_bus_details_id}}">{{$bus_name->bus_name}}&nbsp;&nbsp;({{$bus_name->bus_number}}
                                        )
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <span class="error4 text text-danger hidden"></span><br>

                            <label for="source">Source</label>
                            <select name="b_source" id="b_source" class=" ui dropdown form-control">
                                <option value="">Source</option>
                                @foreach($route_details as $source)
                                    <option value="{{$source->source}}">{{$source->source}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <span class="error5 text text-danger hidden"></span><br>

                            <label for="arrival-time">Arrival Time</label>
                            <input type="text" id="timepick12" name="b_arrival_time" class="form-control"
                                   placeholder="Enter Arrival Time">
                        </div>
                        <div class="form-group col-lg-6">
                            <span class="error6 text text-danger hidden"></span><br>

                            <label for="destination">Destination</label>
                            <select name="b_destination" id="b_destination" class=" ui dropdown form-control">
                                <option value="">Destination</option>
                                @foreach($route_details as $destination)
                                    <option value="{{$destination->destination}}">{{$destination->destination}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group col-lg-6">
                            <span class="error7 text text-danger hidden">{{ $errors->first('departure_time') }}</span><br>

                            <label for="departure-time">Departure Time</label>
                            <input type="text" id="timepick22" name="b_departure_time" class="form-control"
                                   placeholder="Enter Departure Time">
                        </div>

                        <div class="form-group col-lg-6">
                            <span class="error8 text text-danger hidden">{{ $errors->first('onward_date') }}</span><br>

                            <label for="onward-date">ONWARD DATE</label>
                            <input type="text" id="datepick11" name="b_onward_date" class="form-control"
                                   placeholder="Enter Date">
                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update-schedule">Save changes</button>
                </div>
            </div>
        </div>
    </div>





    <div class="modal fade" id="deleteSchedule" tabindex="-1" role="dialog" aria-labelledby="deleteScheduleTitle"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="deleteScheduleTitle">UPDATE SCHEDULE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span class="text text-danger">  Are You Sure You Want To Delete?</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>


                    <button type="button" class="btn btn-danger" id="deleteschedulebtn">Delete</button>

                </div>
            </div>
        </div>
    </div>


    {{--end of tabbed pane--}}

@endsection

@section('ajax')
    <script>

        $('#home-tab').tab('show');
        $(function () {
            $('#myTab li:first-child a').tab('show')
        })


        //    fetching data from the database and populating it to the bootstrap modal for updating

        $(document).ready(function () {
            $('.viewschedule').click(function () {
                var id = $(this).attr("id");
                $.ajax({
                    url: "/view-schedule",
                    type: "post",
                    data: {
                        '_token': $('input[name=_token]').val(),

                        'tbl_bus_trip_schedule_id': id

                    },
                    success: function (data) {
                        console.log(data);
                        JSON.stringify(data); //to string
                        $('#tr_id').val(data[0].tbl_bus_trip_schedule_id);
                        $('#t_id').val(data[0].trip_id);
                        $('#r_name').val(data[0].route_name);
                        $('#b_name').val(data[0].bus_name);
                        $('#b_source').val(data[0].source);
                        $('#b_destination').val(data[0].destination);

                        $('#viewSchedule').modal("show");

                    }

                });
            });

        });

        $(document).ready(function () {
            $('#update-schedule').click(function () {
                $.ajax({
                    url: "updateschedule",
                    type: "post",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'tbl_bus_trip_schedule_id': $('input[name=tr_id]').val(),
                        't_id': $('input[name=t_id]').val(),
                        'b_name': $('#b_name').val(),
                        'r_name': $('#r_name').val(),
                        'b_source': $('#b_source').val(),
                        'b_destination': $('#b_destination').val(),
                        'b_onward_date': $('input[name=b_onward_date]').val(),
                        'b_arrival_time': $('input[name=b_arrival_time]').val(),
                        'b_departure_time': $('input[name=b_departure_time]').val()

                    },
                    success: function (data) {
                          if((data.errors)){
                              console.log(data.errors);
                                $('.error1').removeClass('hidden');
                                $('.error1').text(data.errors.t_id);
                                $('.error2').removeClass('hidden');
                                $('.error2').text(data.errors.r_name);
                                $('.error3').removeClass('hidden');
                                $('.error3').text(data.errors.b_name);
                                $('.error4').removeClass('hidden');
                                $('.error4').text(data.errors.b_source);
                                $('.error6').removeClass('hidden');
                                $('.error6').text(data.errors.b_destination);
                                $('.error8').removeClass('hidden');
                                $('.error8').text(data.errors.b_onward_date);
                                $('.error5').removeClass('hidden');
                                $('.error5').text(data.errors.b_arrival_time);
                                $('.error7').removeClass('hidden');
                                $('.error7').text(data.errors.b_departure_time);
                          }else{
                                        
                            $('#viewSchedule').modal('hide');
                            $('#add-schedule-tab').removeClass("active");
                            $('#view-schedule-tab').addClass("active");
                            location.reload();
                          }
                         
                    }
                })

            })
        });

        $('.deleteschedule').on('click',function () {
            $('#deleteSchedule').modal('show');
            var id=$(this).data('id');
            $('#deleteschedulebtn').click(function () {
                $.ajax({
                    type:'post',
                    url:'deleteschedule',
                    data:{
                        '_token': $('input[name=_token]').val(),
                        'tbl_bus_schedule_id':id



            },
                    success:function (data) {
                        location.reload();
                    }


            })
            });
        });
    </script>
@endsection


