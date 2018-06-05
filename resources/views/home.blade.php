@extends('layouts.app')
@section('css')
    <link href="{{asset('css/datetimepicker.min.css')}}" rel="stylesheet">
@endsection
@section('moment')
    <script src="{{asset('js/moment.js')}}"></script>
@endsection
@section('datetimepickerjs')
    <script src="{{asset('js/datetimepicker.min.js')}}"></script>
@endsection
@section('js')
    <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
@endsection

@section('customjs')
    <script src="{{('js/customscript.js')}}"></script>
@endsection
@section('content')

    <div class="wrapper" style="padding-top: 40px;padding-bottom: 100px;">
        <div class="container ">
            <div class="row ">
                {{--<div class="content">--}}

                    <div class="search-area col-md-12 col-lg-12 col-sm-12 col-md-offset-1 col-lg-offset-1">
                        <form action="{{route('search.bus')}}" method="post" id="#searchForm">
                            {{csrf_field()}}
                            <div class="form-group search-area-control col-md-3 col-lg-3 col-sm-12">
                                <label for="source">SOURCE</label>

                                <select name="source" id="source" class="form-control ui fluid dropdown">
                                    <option value="">Enter Source City</option>
                                    @foreach($cityname as $source)
                                        @if($source->source!=$source->destination)
                                            <option value="{{$source->source}}">{{$source->source}}</option>
                                            <option value="{{$source->destination}}">{{$source->destination}}</option>
                                        @else
                                            <option value="{{$source->source}}">{{$source->source}}</option>

                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group search-area-control col-md-3 col-lg-3 col-sm-12">
                                <label for="destination">DESTINATION</label>
                                <select name="destination" id="destination" class="form-control ui fluid dropdown">
                                    <option value="">Enter Your Destination</option>
                                    @foreach($cityname as $cname)
                                        @if($cname->source!=$cname->destination)
                                            <option value="{{$cname->source}}">{{$cname->source}}</option>
                                            <option value="{{$cname->destination}}">{{$cname->destination}}</option>
                                        @else
                                            <option value="{{$cname->destination}}">{{$cname->destination}}</option>

                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group search-area-control col-md-3 col-lg-3 col-sm-12">
                                <label for="onward-date">ONWARD DATE</label>
                                <input type="text" id="datepick1" name="onward_date" class="form-control"
                                       placeholder="Enter Date">
                            </div>
                            <div class="form-group search-area-control col-md-2 col-lg-2 col-sm-12" id="dateRange">
                                <label for="dateRange">In Between DATE</label>
                                <input type="text" id="datepick111" name="dateRange" class="form-control"
                                       placeholder="Enter Date">
                            </div>


                            <div class="form-group search-area-control col-md-2 col-sm-12 col-lg-2 search-area-btn">
                                <button type="submit" class="btn btn-danger" id="normalSearch">Search Buses</button>
                            </div>
                        </form>

                    </div>
                    {{--<div class=" extended-search-btn col-lg-offset-4 col-md-offset-4">--}}
                        {{--<button class="btn btn-danger btn-lg" id="extendedSearch">Extended Search</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>

    <div class="clear-fix"></div>

    {{--start of footer--}}

    <footer class="my-footer">
        <div class="container-fluid mycontainer">
            <div class="row">
                <div class="contact text-center">
                    <span style="font-size: 25px;font-weight: 700">contact</span>
                </div>
            </div>
            <div class="row  text-center">
                <div class="developer-contact col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class="developer-name">Bibek Gupta</div>
                    <br>
                    <br>

                    <div class="developer-contact-detail">
                        <i class="fa fa-envelope-open-o">&nbsp;&nbsp;guptabibek166@gmail.com</i>
                    </div>
                    <br>
                    <div class="developer-contact-detail">
                        <i class="fa fa-mobile-phone">&nbsp;&nbsp;9845910191</i>
                    </div>
                    <br>
                    <div class="developer-contact-detail">
                        <i class="fa fa-facebook-official">&nbsp;&nbsp;guptabibek9</i>
                    </div>
                    <br>
                    <div class="developer-contact-detail">
                        <i class="fa fa-instagram">&nbsp;&nbsp;guptabibek</i>
                    </div>

                </div>
                <div class="developer-contact col-md-3 col-lg-3 col-sm-12 col-xs-12 ">
                    <div class="developer-name">Nabin Chaudhary</div>
                    <br>
                    <br>

                    <div class="developer-contact-detail">
                        <i class="fa fa-envelope-open-o">&nbsp;&nbsp;nabinchaudhary82@gmail.com</i>
                    </div>
                    <br>
                    <div class="developer-contact-detail">
                        <i class="fa fa-mobile-phone">&nbsp;&nbsp;9845185257</i>
                    </div>
                    <br>
                    <div class="developer-contact-detail">
                        <i class="fa fa-facebook-official">&nbsp;&nbsp;chaudharynabin</i>
                    </div>
                    <br>
                    <div class="developer-contact-detail">
                        <i class="fa fa-instagram">&nbsp;&nbsp;nabin@c</i>
                    </div>

                </div>
                <div class="developer-contact col-md-3 col-lg-3 col-sm-12 col-xs-12 ">
                    <div class="developer-name">Sachina Rai</div>
                    <br>
                    <br>

                    <div class="developer-contact-detail">
                        <i class="fa fa-envelope-open-o">&nbsp;&nbsp;sachinarai2052@gmail.com</i>
                    </div>
                    <br>
                    <div class="developer-contact-detail">
                        <i class="fa fa-mobile-phone">&nbsp;&nbsp;9845619598</i>
                    </div>
                    <br>
                    <div class="developer-contact-detail">
                        <i class="fa fa-facebook-official">&nbsp;&nbsp;sachina_rai</i>
                    </div>
                    <br>
                    <div class="developer-contact-detail">
                        <i class="fa fa-instagram">&nbsp;&nbsp;sachina7</i>
                    </div>

                </div>
                <div class="developer-contact col-md-3 col-lg-3 col-sm-12 col-xs-12 ">
                    <div class="developer-name">Subash Khatiwada</div>
                    <br>
                    <br>

                    <div class="developer-contact-detail">
                        <i class="fa fa-envelope-open-o">&nbsp;&nbsp;itsmesubash1997@gmail.com</i>
                    </div>
                    <br>
                    <div class="developer-contact-detail">
                        <i class="fa fa-mobile-phone">&nbsp;&nbsp;9845847320</i>
                    </div>
                    <br>
                    <div class="developer-contact-detail">
                        <i class="fa fa-facebook-official">&nbsp;&nbsp;suwaas</i>
                    </div>
                    <br>
                    <div class="developer-contact-detail">
                        <i class="fa fa-instagram">&nbsp;&nbsp;sarakar</i>
                    </div>

                </div>
            </div>
            <div class="row" style="margin-top: 30px;">
                <div class="footer-content text-center" >
                    <div class="footer-header">
                        <span style="font-size: 25px;font-weight: 700">Developed By:</span>
                        <br><br>
                        <span class="developer">BNSS Invoation</span><br>
                        <span> <i class="fa fa-location-arrow">&nbsp;&nbsp;Hetauda-5,Makwanpur</i></span><br>
                        <span><i class="fa fa-envelope ">&nbsp;&nbsp;groupa@gmail.com</i></span><br>
                        <span>All Rights Reserved</span><br>
                        <span><i class="fa fa-copyright">&nbsp;&nbsp;2018</i></span>

                    </div>
                </div>
            </div>
        </div>
    </footer>
    {{--end of footer--}}



@endsection



@section('appjs')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
@section('ajax')
    <script>
        $(document).ready(function(){
            $('#dateRange').hide();
            $('#extendedSearch').click(function () {
                $('#extendedSearch').hide();
                $('#dateRange').show();
//                $('#searchForm').attr("action","http://project.com/extendedSearch");
                $('#normalSearch').text('Extended Search');
            })
        });
    </script>
    @endsection