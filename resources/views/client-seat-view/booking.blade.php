<?php
$output = NULL;
if (isset($_POST['book'])) {
    $counter = $_POST["counter"];
    // echo "$counter";
    $total = $_POST["total"];
    $trip_id = $_POST["trip_id"];
    // print_r("No of seat you booked: $counter <br>");
    // print_r("Total Booking Price: $total <br><br>");

    // $customer_id = $_SESSION["id"];
    // $bus_id = $_GET['id'];

    $seat = (isset($_POST['seat']) ? $_POST['seat']:array());
    // print_r($seat);
    $seatID = array();
    $seatPrice = array();
    $i=1;
    if (is_array($seat)) {
        foreach ($seat as $c){
            $ar = explode('|',$c);
            // print_r("Seat id: $ar[0]");
            $seatID[] = $ar[0];
            $seatPrice[] = $ar[1];
        }
        $seatListJSON = json_encode($seatID);

        $seatPriceListJSON = json_encode($seatPrice);
    }
}
?>
        <!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{asset('client-seat-resource/css/booking.css')}}">
  <script type="text/javascript" src="{{asset('client-seat-resource/js/jquery.min.js')}}"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <title></title>
</head>
<body>
<div class="wrapper">
  <div class="container">
    <div class="row ">

      <div class="col-md-8 center">
        <form role="form" class="form" id="#knowYourCustomerForm" action="{{route('payment')}}"  method="post">
          {{csrf_field()}}
          <div class="form-header" id="passengerFormHeader"><h2 style="text-align:center;"><label for="formHeader" >Add Passenger Details</label></h2></div>
          <input type="hidden" name="session" value="">
          <div id="passengersForm">
          </div>


          <div class=" form-group" id="reservationInfoPanel" style="padding-top:30px;">
            <div class="panel panel-default" id="reservationDetails" >
              <div class="panel-heading">
                <div class="panel-title">
                  <b><span class="panel-title-text">Reservation Information</span></b>
                </div>
              </div>
              <div class="panel-body">
                <label for="customerID">Customer ID : &nbsp;</label>
                <input type="text" name="customerID"  style="border: none;" value="cus-000096" readonly><br>

                <label for="busNumber">Bus Number : &nbsp;</label>
                <input type="text" name="busNumber"  style="border: none;" value="NA-1-PA-7777" readonly><br>

                <input type="hidden" name="tripID"  style="border: none;" value="<?php echo $trip_id?>" readonly>

                <label for="selectedSeat"> No of seat selectd : &nbsp;</label>
                <input type="number" name="seatCount"  style="border: none;" value="<?php echo $counter?>" readonly><br>

              <!-- <label for="reservationDate">Reserved Date</label>
                        <input type="text" name="date" value="<?php date_default_timezone_set("Asia/Kathmandu"); echo date("Y-m-d h:i:sa"); ?>" style="border: none;" readonly><br> -->

                <!-- <label for="seatIDs">Seat IDs : &nbsp;</label> -->
                <input type="hidden" name="seatIDs"  style="border: none;" value="<?php print_r($seatListJSON); ?>" readonly>

                <label for="totalAmount">Total Amount : &nbsp;</label>
                <input type="number" name="totalSeat"  style="border: none;" value="<?php echo $total?>" readonly><br>

              </div>
            </div>
          </div>

          <div class="form-group form-group-padding-none">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="agreeTermAndCondition" value="agree">
              <label class="form-check-label" for="agreeTermAndCondition">I agree to the <i>Terms and Conditions and Privacy Policy</i></label>
            </div>
          </div>

          <div class="form-group form-group-padding-none" id="btnGroup">
            <button class="btn btn-danger" id="submit-button" type="submit" name="submit" value="submit" disabled="disabled">Procced to pay</button>
            <input type="reset" class="btn btn-default" value="reset">
          </div>
        </form>

      </div>

    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        //varibles
        var numberOfSelectedSeat = <?php echo $counter ?>;
        var primaryPassengerForm ='<div class="pForm"> <div class="form-group"> <h3><label for="passengerType">Primary Passenger</label>&nbsp;<label id="passengerIndex"></h3> </label> </div> <div class="form-group"> <label for="seatNumber">Seat</label> <input type="text" class="form-control" name="seatNumber[]" readonly> <input type="hidden" name="seatPrice[]" readonly> </div> <div class="form-group"> <label for="passengerName">Name</label> <input type="text" class="form-control" name="passengerName[]" id="primaryPassengerName" > </div> '
        primaryPassengerForm+='<div class="form-group"> <label for="nationalIDCardNumber">National ID Card Number</label> <input type="text" class="form-control" name="nationalIDCardNumber[]" > </div> <div class="form-group"> <div class="form-check"> <input type="checkbox" class="form-check-input" id="bellow16"> <label class="form-check-label" for="bellow16" style="font-weight:normal; color:green;">I am below 16.</label><input type="hidden" class="guardianFlag" name="flag[]" value="0"> </div> </div>'
        primaryPassengerForm+='<div class="form-group"> <label for="passengerGender">Gender</label><br> <label class="radio-inline"> <input type="radio" class="primaryPassengerGender" value="Male" checked >Male </label> <label class="radio-inline"> <input type="radio" class="primaryPassengerGender" value="Female">Female </label> </div> <div class="form-group"> <label for="passengerAge">Age</label> <input type="number" class="form-control" name="passengerAge[]" id="primaryPassengerAge"> </div></div>'

        var coPassengerForm ='<div class="pForm"> <div class="form-group"> <h3><label for="passengerType">Co-Passenger</label>&nbsp;<label id="passengerIndex"></label></h3> </div> <div class="form-group"> <label for="seatNumber">Seat</label> <input type="text" class="form-control" name="seatNumber[]" readonly><input type="hidden" name="seatPrice[]" readonly> </div> <div class="form-group"> <label for="passengerName">Name</label> <input type="text" class="form-control" name="passengerName[]" id="coPassengerName" > </div>'

        coPassengerForm +='<div class="form-group"> <label for="nationalIDCardNumber" id="nationalIDCardNumberLabel">National ID Card Number</label> <input type="text" class="form-control" name="nationalIDCardNumber[]" > </div> <div class="form-group"> <div class="form-check"> <input type="checkbox" class="form-check-input" id="bellow16"> <label class="form-check-label" for="bellow16" style="font-weight:normal; color:green;">I am below 16.</label> <input type="hidden" class="guardianFlag" name="flag[]" value="0"></div> </div><div class="form-group"> <label for="passengerGender">Gender</label><br> <label class="radio-inline"> <input type="radio" class="coPassengerGender" value="Male" checked>Male </label> <label class="radio-inline"> <input type="radio" class="coPassengerGender" value="Female">Female </label> </div> '

        coPassengerForm+='<div class="form-group"> <label for="passengerAge">Age</label> <input type="number" class="form-control" name="passengerAge[]" id="primaryPassengerAge"></div></div>'


        // coPassengerForm += '<div class="form-group"><label for="passengerAge">Age</label> <input type="number" class="form-control" name="passengerAge[]" id="coPassengerAge"> </div>'


        var seatID =<?php echo $seatListJSON ?> ;
        // console.log(seatID);
        var seatPrice =<?php echo $seatPriceListJSON ?> ;
        // console.log(seatPrice);
        var passengerCounter = 0;
        console.log(numberOfSelectedSeat);

        //add forms equal to number of seat selected
        if (numberOfSelectedSeat==0) {
            alert("At least one seat must be selected");
        }
        else{
            do{
                if (passengerCounter==0) {
                    $('#passengersForm').append(primaryPassengerForm);
                    $('.primaryPassengerGender').attr('name','passengerGender['+ passengerCounter +']');
                }else {
                    $('#passengersForm').append(coPassengerForm);
                    // $('.coPassengerGender').attr('name','passengerGender['+ passengerCounter +']');
                }
                passengerCounter++;
            }while(numberOfSelectedSeat != passengerCounter);

            var i=0;
            $("#passengersForm > div").each(function(index){
                $(this).attr('id', 'passenger-'+i);
                // if(i!=0){
                //   $(this).css('padding-top','30px');
                // }
                i++;
            });

            //For displaying passenger index
            $("h3 > label[id^='passengerIndex']").each(function(index){
                index++;
                $(this).text(" " + index);
            });

            //displaying seat id in each  seat textfield
            $("input[name^='seatNumber']").each(function(index){
                $(this).attr('value',seatID[index]);
            });

            $("input[name^='seatPrice']").each(function(index){
                $(this).attr('value',seatPrice[index]).attr("required", "true");
            });

            $("input[name^='passengerName']").each(function(index){
                index++;
                $(this).attr("id","passengerName-"+index).attr("autocomplete","name").attr("required", "true");
            });

            $(".form-group:has(input[name^='nationalIDCardNumber'])").each(function(index) {
                $(this).attr("id", "nationalid-"+index );
                $(this).children('label').attr('class','nationalIDCardNumberLabel').siblings('input').attr("autocomplete","cc-number").attr("required", "true");
            });

            $('div.pForm>.form-group>.form-check>input[type=checkbox]').each(function(index) {
                $(this).attr("id","bellow16-"+ index);
                $(this).siblings('.form-check-label').attr("for","bellow16-"+ index);
            });

            //for Radio button unique name
            $("input[class^='coPassengerGender']").each(function(index){
                index++;
                var x = index/2;
                $(this).attr("name","passengerGender["+ x.toFixed(0) +"]").attr("required", "true");;
            });

            $("input[name^='passengerAge']").each(function(index){
                $(this).attr("id","passengerAge-"+index).attr("required", "true");;
            });

            //Action onchange checkbox
            $('div.form-group>.form-check>input[type=checkbox]').change(function() {
                if($(this).is(':checked')) {
                    //Warnig on ID field
                    $(this).parent(".form-check").parent(".form-group").siblings(".form-group:has(input[name^='nationalIDCardNumber'])").children(".form-control")
                        .addClass("inputWarning").attr("style","border: 1px solid #f00;");

                    $(this).parent(".form-check").parent(".form-group").siblings(".form-group:has(label.nationalIDCardNumberLabel)").children("label").attr("style","color:red").addClass("changeLabel").text("Provide Guardian National Identification Number!!");

                    $(this).siblings("input[name^='flag']").val("1");

                }else{
                    $(this).parent(".form-check").parent(".form-group").siblings(".form-group:has(input[name^='nationalIDCardNumber'])").children(".form-control")
                        .removeClass("inputWarning")
                        .attr("style","border: 1px solid #ccc;");

                    $(this).parent(".form-check").parent(".form-group").siblings(".form-group:has(label.nationalIDCardNumberLabel)").children("label").attr("style","color:black").removeClass("changeLabel").text("National ID Card Number");

                    $(this).siblings("input[name^='flag']").val("0");
                }
            });


            $('#agreeTermAndCondition').change(function() {
                if($(this).is(':checked')) {
                    $("#submit-button").removeAttr("disabled");
                }else {
                    console.log("Agree unchecked");
                    $("#submit-button").attr("disabled","disabled");
                }
            });

        }//end of else statement
    });
</script>

</body>
</html>
