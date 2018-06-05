
{{-- <!DOCTYPE html> --}}
{{-- <html lang="en" dir="ltr"> --}}
{{-- <head> --}}
    {{-- <meta charset="utf-8"> --}}
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}

    @extends('adminlayouts.admin-layouts')

    @section('css')
    {{-- <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"> --}}
    <link rel="stylesheet" href="{{asset('admin-seat-resource/css/jquery.seat-charts.css')}}">
    <link rel="stylesheet" href="{{asset('admin-seat-resource/css/admin-custome-seat-module.css')}}">
   <style>
       .navbar-brand{
	height: 20px;
}
   </style>
    @endsection

{{-- </head> --}}
{{-- <body> --}}
@section('content')

<div class="wraper">
        <div class="container">
    
            <div class="row">
                <div class="message">
                    <div class="flash-message col-lg-12">
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
                </div>
            </div>
    
            <div class="row">
    
                <div class="col-md-5 col-sm-6" id="arrange-bus-seat">
                        <h2>Arrange Bus Seat</h2>

                    <form method="post" action="{{route('add.bus.seat.layout')}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="busNumber">Bus Number</label>
                            <select name="bus_id" class="form-control" tbl_admin_bus_seat_details_id="bus-number">
                                <option value="">Bus Number</option>
                                @foreach($bus_number as $bus_number)
                                <option value="{{$bus_number->tbl_bus_details_id}}">
                                    {{$bus_number->bus_name}}({{$bus_number->bus_number}})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="numberOfSeats">Number of Seats</label>
                            <select class="form-control" id="dropdownTotalSeat">
                                <option value="" selected disabled hidden>Select total number of seats</option>
                                <option value="17">17</option>
                                <option value="21">21</option>
                                <option value="25">25</option>
                                <option value="29">29</option>
                                <option value="33">33</option>
                                <option value="37">37</option>
                                <option value="41">41</option>
                                <option value="45">45</option>
                                <option value="49">49</option>
                                <option value="53">53</option>
                                <option value="57">57</option>
                                <option value="61">61</option>
                            </select>
                        </div>
                        <div class="form-group checkbox">
                            <label><input type="checkbox" id="checkSeatMappingProcess" name="check"
                                          value="manually-seat-mapping"/> want to manual seat plan</label>
                        </div>
    
                        <div class="form-group">
                            <label for="manual-seat-pattern-label">Seat Pattern</label>
                            <textarea class="form-control" rows="5" id="textareaManualSeatPlan" disabled></textarea>
                        </div>
    
                        <!-- what goes on clicking form submit button -->
                        <input type="hidden" name="seatMap" id="seatMap">
                        <input type="hidden" name="totalSeat" id="totalSeat">
    
                        <button type="button" id="preview_btn" class="btn btn-danger" value="preview">Preview</button>
                        <button type="reset" id="clear_btn" class="btn btn-default" value="reset">Clear</button>
                        <br><br>
                        <button type="submit" class="submit-btn btn btn-primary" name="submit_data" value="submit_data">
                            Submit
                        </button>
                    </form>
                </div>
                <div class="col-md-5 col-sm-6" id="bus-seat-preview">
                    <h2> Bus Seat Preview</h2>
                    <div id="seat-map"><!--Start of seat-map div-->
    
                    </div><!--End of seat-map div-->
                </div>
            </div>
        </div><!--End of container div-->
    </div><!--End of wraper div-->
@endsection

@section('seat')

<script type="text/javascript" src="{{asset('admin-seat-resource/js/jquery.min.js')}}"></script>
<script src="{{asset('admin-seat-resource/js/jquery.seat-charts.js')}}"></script>
@endsection


@section('ajax')
<script>
        var firstSeatLabel = 1;
        var totalSeat;
        var inputSeatMap;
        $(document).ready(function () {
    
            //Adding placeholder on textarea
            var placeholder1 = "hh_hh,\nhh_hh,\nhhhhh";
            $('#textareaManualSeatPlan').attr('placeholder', placeholder1);
    
            // Action performing on clicking checkbox
            $('#checkSeatMappingProcess').click(function () {
                if ($(this).is(':checked')) {
                    $('#dropdownTotalSeat').prop('disabled', true);
                    $('#textareaManualSeatPlan').removeAttr("disabled");
    
                } else {
                    $('#dropdownTotalSeat').prop('disabled', false);
                    $('#textareaManualSeatPlan').prop('disabled', true);
                    console.log(totalSeat);
                }
            });
    
            //Cheking input is comming from Dropdown or from textarea
            if ($('#dropdownTotalSeat').is(':not(:disabled)')) {
                $('#dropdownTotalSeat').change(function () {
                    // $(document).on('#dropdownTotalSeat', 'change', function() {
                    // $('.seatCharts-row').detach();
    
                    var totalSeat = $('#dropdownTotalSeat').val();
                    console.log(totalSeat);
                    var seatWithoutLastRow = totalSeat - 5;
                    // console.log("Number of Seat Without Last Row: " + $seatWithoutLastRow);
                    var rows = 4;
                    var cols = seatWithoutLastRow / rows;
                    inputSeatMap = "";
                    if (seatWithoutLastRow >= 0) {
                        for (var i = 0; i < cols; i++) {
                            inputSeatMap += "hh_hh,";
                        }
                        inputSeatMap += "hhhhh";
                        // console.log(inputSeatMap);
                    }
                    $("#seatMap").val(inputSeatMap);
                });
            }
    
            // Action on clicking Preview Button
            // Starting of preview_btn
            $('#preview_btn').on('click', function () {
                // $(document).on('#preview_btn', 'click', function() {
                $('#seat-map').html('').removeAttr("class").removeAttr("tabindex").removeAttr("aria-activedescendant");
                if ($('#textareaManualSeatPlan').is(':not(:disabled)')) {
                    inputSeatMap = $('#textareaManualSeatPlan').val();
                    $("#seatMap").val(inputSeatMap);
                }
    
                var seatPattern = [];
                seatPattern = inputSeatMap.split(',');
                console.log(seatPattern);
    
                displaySeat(seatPattern);
                // console.log(seatPattern);
            });
            // End of Preview
    
            $(".message").fadeOut(10000);
    
            // $(".submit-btn").click(function(){
            //   var message="0";
            //   message ="<?php  ?>";
            //   if(message=="Success"||message=="Updated") {
            //     $(".message").html("");
            //     $(".message").addClass("class","alert alert-success fade in").append(' ').fadeOut(7000);
            //   }
            // });
    
        });
    
        function displaySeat(sp) {
            // console.log(sp);
            var sc = $('#seat-map').seatCharts({
                map: sp,
                naming: {
                    top: false,
                    getLabel: function (character, row, column) {
                        return firstSeatLabel++;
                    },
                },
            });
        }
    
        $("#clear_btn").click(function () {
            location.reload();
        });
    
    </script>
@endsection
