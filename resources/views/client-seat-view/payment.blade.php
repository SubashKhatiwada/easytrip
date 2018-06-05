<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/booking.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title></title>
</head>
<body>
<div class="container message-wrapper">
    <?php
    if (isset($_POST['submit'])){
        //connect to $databaseName
        $servername = "localhost:3306";
        $username = "root";
        $password = "";
        $databaseName ="test1";
        $entry_table ="tbl_seat_info";

        // Create connection
        $mysqli = NEW MySQLi($servername, $username, $password, $databaseName);
        // echo "database connection start";

        $seatID = $_POST['seatNumber'];
        $passengerName = $_POST['passengerName'];
        $passengerGender = $_POST['passengerGender'];
        $passengerAge = $_POST['passengerAge'];
        $seatPrice = $_POST['seatPrice'];
        $tripID = $_POST['tripID'];
        $guardianFlag =$_POST['flag'];
        $nationalIDCardNumber = $_POST['nationalIDCardNumber'];
        $tempSuccess = array();
        $tempCount = 0;

        foreach ($seatID as $key => $value) {

            // echo $mysqli->real_escape_string($guardianFlag[$key]);
            if($guardianFlag[$key] == 1 ){
                $query = "SELECT tbl_seat_info_id FROM tbl_seat_info WHERE seat_id = '" . $mysqli->real_escape_string($seatID[$key]) . "' AND trip_id='$tripID' LIMIT 1;";
                $resultSet = $mysqli->query($query);

                if($resultSet->num_rows == 0){
                    $guardianID = "g-" . $mysqli->real_escape_string($nationalIDCardNumber[$key]);
                    $query = "INSERT INTO tbl_seat_info(seat_id,trip_id,passenger_name,nationalIDCardNumber,passenger_gender,passenger_age,seat_price,reserved_by)
                VALUES('"
                        . $mysqli->real_escape_string($value) .
                        "','$tripID','"
                        . $mysqli->real_escape_string($passengerName[$key]) .
                        "','"
                        . "$guardianID" .
                        "','"
                        . $mysqli->real_escape_string($passengerGender[$key]) .
                        "','"
                        . $mysqli->real_escape_string($passengerAge[$key]) .
                        "','"
                        . $mysqli->real_escape_string($seatPrice[$key]) .
                        "','Subash');
                ";
                    // print_r($query);
                    $insert = $mysqli->query($query);
                    $message= "succssfully booked:"."$value";
                    array_push($tempSuccess,$value);
                    $tempCount++;
                }else{
                    $message = 'Seat <b>'.$value. '</b> is already booked!!!';
                    // echo "<h1>$message</h1>";
                }
            }else{
                $query = "SELECT tbl_seat_info_id FROM tbl_seat_info WHERE seat_id = '" . $mysqli->real_escape_string($seatID[$key]) . "' AND trip_id='$tripID' LIMIT 1;";
                $resultSet = $mysqli->query($query);

                if($resultSet->num_rows == 0){
                    $query = "SELECT tbl_seat_info_id FROM tbl_seat_info WHERE nationalIDCardNumber = '" . $mysqli->real_escape_string($nationalIDCardNumber[$key]) . "' AND trip_id='$tripID' LIMIT 1;";
                    $resultSet = $mysqli->query($query);

                    if ($resultSet->num_rows == 0) {
                        //Insert to database
                        $query = "INSERT INTO tbl_seat_info(seat_id,trip_id,passenger_name,nationalIDCardNumber,passenger_gender,passenger_age,seat_price,reserved_by)
                  VALUES('"
                            . $mysqli->real_escape_string($value) .
                            "','$tripID','"
                            . $mysqli->real_escape_string($passengerName[$key]) .
                            "','"
                            . $mysqli->real_escape_string($nationalIDCardNumber[$key]) .
                            "','"
                            . $mysqli->real_escape_string($passengerGender[$key]) .
                            "','"
                            . $mysqli->real_escape_string($passengerAge[$key]) .
                            "','"
                            . $mysqli->real_escape_string($seatPrice[$key]) .
                            "','Subash');
                  ";

                        $insert = $mysqli->query($query);
                        $message= "succssfully booked:"."$value";
                        array_push($tempSuccess,$value);
                        $tempCount++;
                    }else {
                        $message = 'You canot book seat with same tbl_seat_info_id: <b>'.$nationalIDCardNumber[$key].'</b>';
                        // echo "<h1>$message</h1>";
                    }
                }else{
                    $message = 'Seat <b>'.$value.'</b> is already booked!!!';
                    // echo "<h1>$message</h1>";
                }
            }
            echo '<div class="wraper"><div class="message-container"><div class="row"><div class="col-md-12 alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert">&times;</button>'."$message".'</div></div></div></div>';
        }
        if($tempCount == sizeof($seatID)){
            $message="<h1 style='color:green'>success!!!</h1>";

        }else{
            $message="<h1 style='color:red;'>cannot able to book</h1>";
            foreach ($tempSuccess as $key => $value) {
                // echo "$value";
                $query = "DELETE FROM tbl_seat_info WHERE seat_id='$value';";
                $delete = $mysqli->query($query);
            }
        }
        echo '<div class="wraper"><div class="message-container"><div class="row"><div class="col-md-12 alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert">&times;</button>'."$message".'</div></div></div></div>';
        $mysqli->close();
    }
    ?>
</div>
<script type="text/javascript">
    $(".message-container").attr("style","margin: 20px auto -24px; width: 60%;").fadeOut(50000);
</script>
</body>
</html>
