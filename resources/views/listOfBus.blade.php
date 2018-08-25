{{--@if(count($search_result)>0)--}}

{{--@foreach($search_result as $sr)--}}
{{--{{$sr->bus_name}}--}}
{{--{{$sr->source}}--}}
{{--{{$sr->destination}}--}}
{{--{{$sr->trip_id}}--}}
{{--@endforeach--}}
{{--@else--}}
{{--{{'hello this is not working'}}--}}

{{--@endif--}}


@extends('layouts.app')
@section('title','test')


@section('content')
    <div class="container">
        <div class="row">
            <div class=" table table-responsive">
                <table class="table table-stripped">
                    <thead class="bg-info">

                    <tr>
                        <th>Bus Name</th>
                        <th>Bus Number</th>
                        <th>Source</th>
                        <th>Destination</th>
                        <th>Available no of seat</th>
                        <th>Trip Id</th>
                        <th>Action</th>
                    </tr>
                    </thead>


                    @if(count($search_result)>0)
                        @foreach($search_result as $sr)
                            <tr>
                                <td>
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$sr->tbl_bus_details_id}}" aria-expanded="false" aria-controls="collapseOne{{$sr->tbl_bus_details_id}}"> {{$sr->bus_name}} </a>
                                    <div id="collapseOne{{$sr->tbl_bus_details_id}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. 
                                            Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                        </div>
                                    </div>
                                </td>

                                <td>{{$sr->bus_number}}</td>
                                <td> {{$sr->source}}</td>
                                <td>{{$sr->destination}}</td>
                                <td>100</td>
                                <td>{{$sr->trip_id}}</td>
                                <td><a href="{{ route('client.seat',$sr->trip_id)}}"><button class="btn btn-primary">Book Now</button></a></td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" style="text-align: center"><h1>OOPs!!!No Result Found</h1></td>
                        </tr>
                    @endif
                </table>


            </div>
        </div>
    </div>
@endsection


@section('appjs')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
@section('ajax')
    <script>
        $('.collapse').collapse();
    </script>
    @endsection
