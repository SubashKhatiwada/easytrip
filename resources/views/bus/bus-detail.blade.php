@extends('adminlayouts.admin-layouts')
@section('ajax')
	<script>
        {{-- ajax Form Add Bus--}}
$(document).on('click', '.create-modal', function () {
            $('#create').modal('show');
            $('.form-horizontal').show();
            $('.modal-title').text('Add Bus');
        });
        $("#add").click(function () {
            $.ajax({
                type: 'POST',
                url: 'addbus',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'bus_number': $('input[name=bus_number]').val(),
                    'bus_name': $('input[name=bus_name]').val(),
                    'bus_type': $('input[name=bus_type]').val(),
                    // 'number_of_seats': $('input[name=number_of_seats]').val()
					'number_of_seats': $('#number_of_seats').val()

					
                },
                success: function (data) {
                    console.log(data);
                    if ((data.errors)) {
                        $('.error1').removeClass('hidden');
						$('.error1').text(data.errors.bus_name);
						$('.error2').removeClass('hidden');
                        $('.error2').text(data.errors.bus_number);
						$('.error3').removeClass('hidden');
                        $('.error3').text(data.errors.bus_type);
						$('.error4').removeClass('hidden');
                        $('.error4').text(data.errors.number_of_seats);
                    } else {
                        $('.error').remove();
                        $('#table').append("<tr class='post'>" +
                            "<td>" + data.tbl_bus_details_id + "</td>" +
                            "<td>" + data.bus_number + "</td>" +
                            "<td>" + data.bus_type + "</td>" +
                            "<td>" + data.bus_name + "</td>" +
                            "<td>" + data.number_of_seats + "</td>" +
                            "<td>" + data.created_at + "</td>" +
                            "<td><button class='show-modal btn btn-info btn-sm' data-bus_number='" + data.bus_number +
                            "' data-tbl_bus_details_id='" + data.tbl_bus_details_id +

                            "' data-bus_type='" + data.bus_type +

                            "'data-bus_name='" + data.bus_name +
                            "' data-number_of_seats='" + data.number_of_seats + "'>" +
                            "<span class='fa fa-eye'></span>" +
                            "</button> " +
                            "<button class='edit-modal btn btn-warning btn-sm' data-bus_number='" + data.bus_number +
                            "' data-tbl_bus_details_id='" + data.tbl_bus_details_id +

                            "' data-bus_type='" + data.bus_type +
                            "' data-bus_name='" + data.bus_name +
                            "' data-number_of_seats='" + data.number_of_seats + "'>" +
                            "<span class='glyphicon glyphicon-pencil'></span>" +
                            "</button>" +
                            " <button class='delete-modal btn btn-danger btn-sm' data-bus_number='" + data.bus_number +
                            "' data-tbl_bus_details_id='" + data.tbl_bus_details_id +

                            "' data-bus_type='" + data.bus_type +
                            "' data-bus_name='" + data.bus_name +
                            "' data-number_of_seats='" + data.number_of_seats +
                            "'><span class='glyphicon glyphicon-trash'></span></button></td>" +
                            "</tr>");
                        $('#create').modal('hide');
                        location.reload();

                    }
                },
            });
            $('#bus_number').val('');
            $('#bus_type').val('');
            $('#bus_name').val('');
            $('#number_of_seats').val('');
        });

        // function Edit POST
        $(document).on('click', '.edit-modal', function () {
            $('#footer_action_button').text(" Update Bus");
            $('#footer_action_button').addClass('glyphicon-check');
            $('#footer_action_button').removeClass('glyphicon-trash');
            $('.actionBtn').addClass('btn-success');
            $('.actionBtn').removeClass('btn-danger');
            $('.actionBtn').addClass('edit');
            $('.modal-title').text('Bus Edit');
            $('.deleteContent').hide();
            $('.form-horizontal').show();
            $('#bno').val($(this).data('tbl_bus_details_id'));
            $('#bnumber').val($(this).data('bus_number'));
            $('#bmo').val($(this).data('bus_type'));
            $('#bname').val($(this).data('bus_name'));
            $('#nos').val($(this).data('number_of_seats'));
            $('#myModal').modal('show');
        });

        $('.modal-footer').on('click', '.edit', function () {
            $.ajax({
                type: 'POST',
                url: 'editBus',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'tbl_bus_details_id': $('#bno').val(),
                    'bus_number': $('#bnumber').val(),

                    'bus_type': $('#bmo').val(),
                    'bus_name': $('#bname').val(),
                    'number_of_seats': $('#nos').val()
                },
                success: function (data) {
                    console.log(data);
                    $('.post' + data.tbl_bus_details_id).replaceWith(" " +
                        "<tr class='post" + data.tbl_bus_details_id + "'>" +
                        "<td>" + data.tbl_bus_details_id + "</td>" +
                        "<td>" + data.bus_number + "</td>" +

                        "<td>" + data.bus_type + "</td>" +
                        "<td>" + data.bus_name + "</td>" +
                        "<td>" + data.number_of_seats + "</td>" +
                        "<td>" + data.created_at + "</td>" +
                        "<td><button class='show-modal btn btn-info btn-sm' data-tbl_bus_details_id='"
                        + data.tbl_bus_details_id +
                        "' data-bus_number='" + data.bus_number +

                        "' data-bus_type='" + data.bus_type +
                        "'data-bus_name='" + data.bus_name +
                        "' data-number_of_seats='" + data.number_of_seats + "'>" +
                        "<span class='fa fa-eye'></span>" +
                        "</button> <button class='edit-modal btn btn-warning btn-sm' data-tbl_bus_details_id='" + data.tbl_bus_details_id +
                        "' data-bus_number='" + data.bus_number +

                        "' data-bus_type='" + data.bus_type +
                        "' data-bus_name='" + data.bus_name +
                        "' data-number_of_seats='" + data.number_of_seats + "'>" +
                        "<span class='glyphicon glyphicon-pencil'></span>" +
                        "</button> <button class='delete-modal btn btn-danger btn-sm' data-tbl_bus_details_id='" + data.tbl_bus_details_id +
                        "' data-bus_number='" + data.bus_number +

                        "' data-bus_type='" + data.bus_type +
                        "' data-bus_name='" + data.bus_name +
                        "' data-number_of_seats='" + data.number_of_seats + "'>" +
                        "<span class='glyphicon glyphicon-trash'></span></button></td>" +
                        "</tr>");
                }
            });
        });

        // form Delete function
        $(document).on('click', '.delete-modal', function () {
            $('#footer_action_button').text(" Delete");
            $('#footer_action_button').removeClass('glyphicon-check');
            $('#footer_action_button').addClass('glyphicon-trash');
            $('.actionBtn').removeClass('btn-success');
            $('.actionBtn').addClass('btn-danger');
            $('.actionBtn').addClass('delete');
            $('.modal-title').text('Delete Bus');
            $('.tbl_bus_details_id').text($(this).data('tbl_bus_details_id'));
            $('.deleteContent').show();
            $('.form-horizontal').hide();
            $('.title').html($(this).data('bus_type'));
            $('#myModal').modal('show');
        });

        $('.modal-footer').on('click', '.delete', function () {
            $.ajax({
                type: 'POST',
                url: 'deleteBus',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'tbl_bus_details_id': $('.tbl_bus_details_id').text(),
                },
                success: function (data) {
                    $('.post' + $('.tbl_bus_details_id').text()).remove();
                    location.reload();
                }
            });
        });

        // Show function
        $(document).on('click', '.show-modal', function () {
            $('#show').modal('show');
            $('#i').text($(this).data('bus_number'));
            $('#ti').text($(this).data('bus_type'));
            $('#ni').text($(this).data('bus_name'));
            $('#by').text($(this).data('number_of_seats'));
            $('.modal-title').text('Show Bus');
        });

	</script>
	@endsection

@section('content')
	<div class="container">
	<div class="row">
		<div class="table table-responsive">
			<table class="table table-bordered" id="table">
				<tr>
					<th>Bus Id</th>

					<th width="150px">Bus No</th>
					<th>Bus Name</th>
					<th>Bus Type</th>
					<th>No Of Seats</th>
					<th>Create At</th>
					<th class="text-center" width="150px">
						<a href="#" class="create-modal btn btn-success btn-sm">
							<i class="glyphicon glyphicon-plus"></i>
						</a>
					</th>
				</tr>
				{{ csrf_field() }}
				@foreach ($post as $value)
					<tr class="post{{$value->tbl_bus_details_id}}">
						<td>{{$value->tbl_bus_details_id}}</td>
						<td>{{$value->bus_number}}</td>
						<td>{{ $value->bus_type }}</td>
						<td>{{ $value->bus_name }}</td>
						<td>{{ $value->number_of_seats }}</td>
						<td>{{ $value->created_at }}</td>
						<td>
							<a href="#" class="show-modal btn btn-info btn-sm" data-tbl_bus_details_id="{{$value->tbl_bus_details_id}}" data-bus_number="{{$value->bus_number}}" data-bus_type="{{$value->bus_type}}" data-bus_name="{{$value->bus_name}}" data-number_of_seats="{{$value->number_of_seats}}">
								<i class="fa fa-eye"></i>
							</a>
							<a href="#" class="edit-modal btn btn-warning btn-sm" data-tbl_bus_details_id="{{$value->tbl_bus_details_id}}" data-bus_number="{{$value->bus_number}}" data-bus_type="{{$value->bus_type}}" data-bus_name="{{$value->bus_name}}" data-number_of_seats="{{$value->number_of_seats}}">
								<i class="glyphicon glyphicon-pencil"></i>
							</a>
							<a href="#" class="delete-modal btn btn-danger btn-sm" data-tbl_bus_details_id="{{$value->tbl_bus_details_id}}" data-bus_number="{{$value->bus_number}}" data-bus_type="{{$value->bus_type}}" data-bus_name="{{$value->bus_name}}" data-number_of_seats="{{$value->number_of_seats}}">
								<i class="glyphicon glyphicon-trash"></i>
							</a>
						</td>
					</tr>
				@endforeach
			</table>
		</div>
		{{$post->links()}}
	</div>
	{{-- Modal Form Create Bus --}}
	<div id="create" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" role="form" style="margin-left: 20px; margin-right: 20px;">
						<div class="form-group row add">
							<div class="col-sm-10">
								<input type="text" class="form-control" id="tbl_bus_details_id" name="tbl_bus_details_id" required hidden>
							</div>
						</div>
						<div class="form-group">
								<span class="error1 text-left text text-danger hidden"></span><br>

							<label class="control-label" for="bus_number">Bus Number :</label>
								<input type="text" class="form-control" id="bus_number" name="bus_number"
									   required>
						</div>
						<div class="form-group">
								<span class="error2 text-left text text-danger hidden"></span><br>

							<label class="control-label" for="body">Bus Type :</label>
								<input type="text" class="form-control" id="bus_type" name="bus_type"
									   required>
						</div>
						<div class="form-group">
								<span class="error3 text-left text text-danger hidden"></span><br>

							<label class="control-label" for="body">Bus Name :</label>
								<input type="text" class="form-control" id="bus_name" name="bus_name"
									   required>
						</div>
						<div class="form-group">
								<span class="error4 text-left text text-danger hidden"></span><br>
							<label class="control-label" for="body">No Of Seats:</label>
								{{-- <input type="text" class="form-control" id="number_of_seats" name="number_of_seats"
									   required> --}}
									   <select name="number_of_seats" id="number_of_seats" class="form-control">
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
					</form>
				</div>
				<div class="modal-footer">
					<button class="btn btn-warning" type="submit" id="add">
						<span class="glyphicon glyphicon-plus"></span>Add Bus
					</button>
					<button class="btn btn-warning" type="button" data-dismiss="modal">
						<span class="glyphicon glyphicon-remobe"></span>Close
					</button>
				</div>
			</div>
		</div>
	</div></div>
	{{-- Modal Form Show POST --}}
	<div id="show" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="">Bus Number :</label>
						<b id="i"/>
					</div>
					<div class="form-group">
						<label for="">Bus Type :</label>
						<b id="ti"/>
					</div>
					<div class="form-group">
						<label for="">Bus Name :</label>
						<b id="ni"/>
					</div>
					<div class="form-group">
						<label for="">No Of Seats :</label>
						<b id="by"/>
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- Modal Form Edit and Delete Bus --}}
	<div id="myModal"class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" role="modal" style="margin-left: 20px; margin-right: 20px;">
						<div class="form-group">
								<input type="text" class="form-control" id="bno" hidden>
						</div>
						<div class="form-group">
							<label class="control-label"for="bus_number">Bus Number</label>
								<input type="text" class="form-control" id="bnumber" >
						</div>
						<div class="form-group">
							<label class="control-label"for="bus_type">Bus Type</label>
								<input type="text" class="form-control" id="bmo">
						</div>
						<div class="form-group">
							<label class="control-label"for="bus_name">Bus Name</label>
								<input type="text" class="form-control" id="bname">
						</div>
						<div class="form-group">
							<label class="control-label"for="number_of_seats">No of Seats</label>
								<input type="text" class="form-control" id="nos">
						</div>
					</form>
					{{-- Form Delete Bus --}}
					<div class="deleteContent">
						Are You sure want to delete <span class="bus_type"></span>?
						<span class="hidden tbl_bus_details_id"></span>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn actionBtn" data-dismiss="modal">
						<span id="footer_action_button" class="glyphicon"></span>
					</button>
					<button type="button" class="btn btn-warning" data-dismiss="modal">
						<span class="glyphicon glyphicon"></span>close
					</button>
				</div>
			</div>
		</div>
	</div>
	</div>

@endsection