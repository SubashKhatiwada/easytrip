<!-- <?php
var_dump($seat_map);

?> -->

@extends('layouts.app')
@section('css')
    <script src="{{ asset('js/app.js') }}"></script>

    <script type="text/javascript" src="{{asset('client-seat-resource/js/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('client-seat-resource/css/jquery.seat-charts.css')}}">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">

    <script src="{{asset('client-seat-resource/js/jquery.seat-charts.js')}}"></script>
    <!-- here countdown(minutes) is used to start countdown of <minutes> -->
    <script src="{{asset('client-seat-resource/js/time-countdown.js')}}"></script>

    <style>
        .navbar-brand{
            height: 20px;;
        }
    </style>
@endsection


@section('content')
<div class="wraper"><!--Start of container wraper div-->
    <div class="container">
        <div id="seat-map"><!--Start of seat-map div-->
            <div class="front-indicator">Choose Your Seat</div>
        </div><!--End of seat-map div-->

        <div class="booking-details"><!--Start of booking-details div-->

            <h2>Booking Details</h2>
            <h3><b style="color:red">Time Left: <span id="timer">3:00</span> </b></h3>

            <form role="form" class="form" id="booking_form" action="{{route('booking')}}" method="post"
                  onload="validateData()">
            {{csrf_field()}}
            
                <h3> Selected Seats :<input type=number id="counter" name="counter" value="0"
                                            style="border:0px solid;width:30px;" readonly></input></h3>

                <select class="select form-control" style="display:block;font-size:12px" id="selected-seats"
                        name="seat[]" multiple readonly></select>

                Total: <b>Rs. <input type=number id="total" name="total" style="border:0px solid" readonly></b>
                <button class="btn btn-info proceed-button" id="proceed-button" type="submit" name="book" value="book">
                    Procced &raquo;
                </button>
            </form>
            <div id="output"></div>
            <div id="legend"></div>
        </div><!--End of booking-details div-->
    </div><!--End of wrapper div-->
</div><!--End of wrapper div-->
@endsection

@section('ajax')

    <script type="text/javascript">
        var firstSeatLabel = 1;
        $(document).ready(function () {
            var $cart = $('#selected-seats');
            var $counter = $('#counter');
            var $total = $('#total');
            var $seatPatternstring = "{{$seat_map}}";
            // var $seatPattern = $seat_map;
            console.log($seatPatternstring);
            var $seatPattern = $seatPatternstring.split(',');
            console.log($seatPattern);
            // var $seatPattern = [
            //     'hh_hh',
            //     'hh_hh',
            //     'hh_hh',
            //     'hh_hh',
            //     'll_ll',
            //     'hh_hh',
            //     'hh_hh',
            //     'hh_hh',
            //     'hh_hh',
            //     'lllll',
            // ];
            var sc = $('#seat-map').seatCharts({
                map: $seatPattern,

                /*
                 * There are two type of seats according theirs price: 1)high cost seats 2) low cost seats
                 * Lets suppose  h denotes "high cost seat" and l denotes "low cost seat". Here _ represents there is not any seat
                 */
                seats: {
                    h: {
                        price: 400,
                        classes: 'high-cost-seat', //custom CSS class for high cost seat
                        category: ''
                    },
                    l: {
                        price: 350,
                        classes: 'low-cost-seat', //custom CSS class low cost seat
                        category: ''
                    }
                },
                naming: {
                    top: false,
                    getLabel: function (character, row, column) {
                        return firstSeatLabel++;
                    },
                },
                legend: {
                    node: $('#legend'),
                    items: [
                        ['', 'selected', 'Selected Seat'],
                        ['', 'available', 'Available Seat'],
                        ['', 'unavailable', 'Already Booked']
                    ]
                },
                click: function () {
                    if (this.status() == 'available') {
                        //let's create a new <li> which we'll add to the cart items
                        $('<option selected>' + this.data().category + ' Seat no. ' + this.settings.label + ': <b> Rs. ' + this.data().price + '</b></option>')
                            .attr('id', 'cart-item-' + this.settings.id)
                            .attr('value', this.settings.id + "|" + this.settings.data.price)
                            .data('seatId', this.settings.id)
                            .appendTo($cart);
                        console.log(this.settings.id);


                        $counter.text(sc.find('selected').length + 1)
                            .attr('value', sc.find('selected').length + 1);

                        $total.text(recalculateTotal(sc) + this.data().price)
                            .attr('value', recalculateTotal(sc) + this.data().price);

                        return 'selected';

                    } else if (this.status() == 'selected') {
                        //update the counter
                        $counter.text(sc.find('selected').length - 1).attr('value', this.settings.id);
                        //and total
                        $total.text(recalculateTotal(sc) - this.data().price);

                        //remove the item from our cart
                        $('#cart-item-' + this.settings.id).remove();

                        //seat has been vacated
                        return 'available';
                    } else if (this.status() == 'unavailable') {
                        //seat has been already booked
                        return 'unavailable';
                    } else {
                        return this.style();
                    }
                }
            });

         


            //this will handle "[cancel]" link clicks
            $('#selected-seats').on('click', '.cancel-cart-item', function () {
                //let's just trigger Click event on the appropriate seat, so we don't have to repeat the logic here
                sc.get($(this).parents('li:first').data('seatId')).click();
            });

            //let's pretend some seats have already been booked
            /*
             * sc.get([]) is used to show the seat is unavailable
             * for exampe sc.get(['1_2']).status('unavailable') defines first row's second col seat is already booked.
             */


            var temp = 0;
            setInterval(function () {
                var $unavailableSeat;
                var unavailableSeatArray = [];


                $.ajax({
                    type: 'get',
                    url: '/fetchseat',
                    success: function (response) {
                        $.get('/fetchseat', function ($unavailableSeat) {
                           
                            $unavailableSeat = $unavailableSeat.substring(0, $unavailableSeat.length - 1);
                            console.log($unavailableSeat);
                            unavailableSeatArray = $unavailableSeat.split(',');
                            console.log(unavailableSeatArray);

                            if (unavailableSeatArray.length >= temp) {
                                $.each(unavailableSeatArray, function (index, seatId) {
                                    //find seat by id and set its status to unavailable
                                    sc.status(seatId, 'unavailable');
                                    temp = unavailableSeatArray.length;
                                });
                            } else {
                                sc.find('unavailable').status('available');
                                $.each(unavailableSeatArray, function (index, seatId) {
                                    //find seat by id and set its status to unavailable
                                    sc.status(seatId, 'unavailable');
                                });
                            }


                        });
                    }
                });
            }, 1000);


        });


        function recalculateTotal(sc) {
            var total = 0;

            //basically find every selected seat and sum its price
            sc.find('selected').each(function () {
                total += this.data().price;
            });

            return total;
        }
    </script>
@endsection