-- Table structure for table `bus`


CREATE TABLE IF NOT EXISTS `bus` (
  `busNo` varchar(10) NOT NULL COMMENT 'Bus Number',
  `busModel` varchar(15) NOT NULL COMMENT 'Bus Model',
  `numberOfSeat` int(2) NOT NULL COMMENT 'Number Of Seat',
  PRIMARY KEY (`busNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This Master Table is store Bus Data';

-- Table structure for table `journey_for_bus`


CREATE TABLE IF NOT EXISTS `journey_for_bus` (
  `journey_for_bus_No` int(3) NOT NULL AUTO_INCREMENT,
  `busNo` varchar(10) NOT NULL,
  `journeyNo` varchar(10) NOT NULL,
  PRIMARY KEY (`journey_for_bus_No`),
  KEY `busNo` (`busNo`),
  KEY `journeyNo` (`journeyNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;




-- Table structure for table `entrypoint_for_journey`

CREATE TABLE IF NOT EXISTS `entrypoint_for_journey` (
  `entryPoint_for_journeyNo` int(3) NOT NULL AUTO_INCREMENT COMMENT 'this is primary key',
  `journeyNo` varchar(10) NOT NULL COMMENT 'Bus Route Number',
  `entryPointNo` int(2) NOT NULL COMMENT 'Bus Entry Point Number',
  PRIMARY KEY (`entryPoint_for_journeyNo`),
  KEY `entryPointNo` (`entryPointNo`),
  KEY `journeyNo` (`journeyNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='This Transaction Table is assing Entry Point for Bus Route' AUTO_INCREMENT=79 ;


-- Table structure for table `entry_point`


CREATE TABLE IF NOT EXISTS `entry_point` (
  `entryPointNo` int(2) NOT NULL AUTO_INCREMENT COMMENT 'Bus Entry Point No',
  `entryPoint` varchar(15) NOT NULL COMMENT 'Bus Entry Point Name',
  PRIMARY KEY (`entryPointNo`),
  KEY `entryPoint` (`entryPoint`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='This Master Table is store Entry Point for bus Route' AUTO_INCREMENT=20 ;


-- Table structure for table `journey`


CREATE TABLE IF NOT EXISTS `journey` (
  `journeyNo` varchar(10) NOT NULL,
  `routeNo` varchar(5) NOT NULL COMMENT 'Bus Route Number',
  `journeyFrom` varchar(10) NOT NULL COMMENT 'Bus Route Start Point',
  `journeyTo` varchar(10) NOT NULL COMMENT 'Bus Route End Point',
  `departureTime` time NOT NULL COMMENT 'Bus Departure Time',
  `arrivalTime` time NOT NULL COMMENT 'Bus Arrival Time',
  `price` float NOT NULL COMMENT 'Bus Ticket Price',
  PRIMARY KEY (`journeyNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This Master Table is store Bus Route Data';




-- Table structure for table `available_seat`


CREATE TABLE IF NOT EXISTS `available_seat` (
  `seatNo` int(2) NOT NULL COMMENT 'Bus Seat Number',
  `busNo` varchar(10) NOT NULL COMMENT 'SLTB Bus Number',
  `journeyNo` varchar(10) NOT NULL,
  `status` varchar(2) NOT NULL COMMENT 'Seat Status',
  `date` date NOT NULL COMMENT 'Status Date',
  `time` time NOT NULL,
  PRIMARY KEY (`seatNo`,`busNo`,`journeyNo`,`date`),
  KEY `seatNo` (`seatNo`,`busNo`),
  KEY `busNo` (`busNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This Transaction Table is current Stauts a Bus Seat';


-- Table structure for table `booker`


CREATE TABLE IF NOT EXISTS `booker` (
  `bookerNICNo` varchar(10) NOT NULL COMMENT 'Bus Booker NIC Number',
  `bookerName` varchar(20) NOT NULL COMMENT 'Booker Short Name',
  `bookerMNo` varchar(10) NOT NULL COMMENT 'Booker Mobile Number',
  PRIMARY KEY (`bookerNICNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This Master Table is store Bus Booker Data';


-- Table structure for table `booking`


CREATE TABLE IF NOT EXISTS `booking` (
  `bookingID` varchar(25) NOT NULL COMMENT 'Bus Ticket Number',
  `bookerNICNo` varchar(10) NOT NULL COMMENT 'Bus Booker NIC Number',
  `busNo` varchar(10) NOT NULL COMMENT 'Bus Number',
  `journeyNo` varchar(10) NOT NULL,
  `no_of_seat` int(2) NOT NULL,
  `entryPointNo` int(2) NOT NULL,
  `ammount` float NOT NULL COMMENT 'Total Amount of Bus ticket',
  `date` date NOT NULL COMMENT 'Ticket receive Date',
  `payment_status` varchar(2) NOT NULL DEFAULT 'P',
  `s_bookin_time` time NOT NULL,
  PRIMARY KEY (`bookingID`),
  KEY `bookerNICNo` (`bookerNICNo`,`busNo`),
  KEY `bookerNICNo_2` (`bookerNICNo`),
  KEY `busNo` (`busNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This Transaction Table is store Receive booking invoice';



-- Table structure for table `manual_booking`


CREATE TABLE IF NOT EXISTS `manual_booking` (
  `manualBookingNo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'this is primary key',
  `userName` varchar(10) NOT NULL COMMENT 'System User Name',
  `bookingID` varchar(20) NOT NULL,
  `date` date NOT NULL COMMENT 'ManualBooking Date',
  PRIMARY KEY (`manualBookingNo`),
  KEY `userName` (`userName`,`bookingID`),
  KEY `bookerNICNo` (`bookingID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='This Transaction Table is store who is manual booking Booker' AUTO_INCREMENT=18 ;


-- Table structure for table `receive_ticke`


CREATE TABLE IF NOT EXISTS `receive_ticke` (
  `ticketNo` varchar(25) NOT NULL,
  `passengerName` varchar(25) NOT NULL COMMENT 'Passenger Name',
  `seatNo` int(2) NOT NULL COMMENT 'Bus Seat Number',
  `gender` varchar(1) NOT NULL COMMENT 'Passenger Gender',
  `bookingID` varchar(25) NOT NULL,
  PRIMARY KEY (`ticketNo`),
  KEY `bookerNICNo` (`passengerName`),
  KEY `seatNo` (`seatNo`),
  KEY `ticketNo` (`ticketNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This Transaction Table is store booking data';


-- Table structure for table `seat`

CREATE TABLE IF NOT EXISTS `seat` (
  `seatNo` int(2) NOT NULL AUTO_INCREMENT COMMENT 'Bus Seat Number',
  PRIMARY KEY (`seatNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='This Master Table is store Bus Seat Number' AUTO_INCREMENT=50 ;




-- Constraints for table `available_seat`

ALTER TABLE `available_seat`
  ADD CONSTRAINT `available_seat_ibfk_1` FOREIGN KEY (`seatNo`) REFERENCES `seat` (`seatNo`),
  ADD CONSTRAINT `available_seat_ibfk_2` FOREIGN KEY (`busNo`) REFERENCES `bus` (`busNo`);



-- Constraints for table `entrypoint_for_journey`

ALTER TABLE `entrypoint_for_journey`
  ADD CONSTRAINT `entrypoint_for_journey_ibfk_2` FOREIGN KEY (`entryPointNo`) REFERENCES `entry_point` (`entryPointNo`),
  ADD CONSTRAINT `entrypoint_for_journey_ibfk_3` FOREIGN KEY (`journeyNo`) REFERENCES `journey` (`journeyNo`);


-- Constraints for table `journey_for_bus`

ALTER TABLE `journey_for_bus`
  ADD CONSTRAINT `journey_for_bus_ibfk_1` FOREIGN KEY (`busNo`) REFERENCES `bus` (`busNo`),
  ADD CONSTRAINT `journey_for_bus_ibfk_2` FOREIGN KEY (`journeyNo`) REFERENCES `journey` (`journeyNo`);


-- Constraints for table `manual_booking`

ALTER TABLE `manual_booking`
  ADD CONSTRAINT `manual_booking_ibfk_1` FOREIGN KEY (`userName`) REFERENCES `system_user` (`userName`);


-- Constraints for table `receive_ticke`

ALTER TABLE `receive_ticke`
  ADD CONSTRAINT `receive_ticke_ibfk_2` FOREIGN KEY (`seatNo`) REFERENCES `seat` (`seatNo`);

DELIMITER $$

-- Events

CREATE DEFINER=`root`@`localhost` EVENT `expires_booking_seat_delete` ON SCHEDULE EVERY 60 SECOND STARTS '2018-01-01 17:20:00' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM available_seat WHERE (NOW()>addtime(time,'00:11:00') AND status="P")$$

CREATE DEFINER=`root`@`localhost` EVENT `expires_booking_ticke_delete` ON SCHEDULE EVERY 60 SECOND STARTS '2018-01-01 17:20:20' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM booking WHERE (NOW()>s_bookin_time AND payment_status="P")$$

DELIMITER ;
