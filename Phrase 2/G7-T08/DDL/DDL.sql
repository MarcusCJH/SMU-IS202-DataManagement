/* DM PROJECT PHASE 2 : DDL */

/*Creating Schema*/
CREATE SCHEMA `G7T08` ;
USE `G7T08`;

/*Creating Tables*/
/*Service Table*/
CREATE TABLE SERVICE
(
	ServiceNumber char(8) NOT NULL,
    StartTime char(4) NOT NULL,
    EndTime char(4) NOT NULL,
    Frequency char(5) NOT NULL,
    constraint ServiceNumber_PK primary key (ServiceNumber)
);

/*Week_Period Table*/
CREATE Table Week_Period
(
	PeriodName varchar(15) NOT NULL,
    Remark varchar(50) NOT NULL,
    CONSTRAINT Week_Period_PK primary key (PeriodName)
);

/*Service_Search Table*/
CREATE Table Service_Search
(
	ServiceNumber char(8) NOT NULL,
    PeriodName varchar(15) NOT NULL,
    count int NOT NULL,
    CONSTRAINT Service_Search_PK primary key (ServiceNumber,PeriodName),
    CONSTRAINT Service_Search_FK1 foreign key (ServiceNumber) references Service(ServiceNumber),
    CONSTRAINT Service_Search_FK2 foreign key(PeriodName) references Week_Period(PeriodName)
);

/*BUS_STOP Table*/
CREATE Table Bus_Stop
(
	StopNumber char(8) NOT NULL,
    LocationDesc varchar(50) NOT NULL,
    Address varchar(50) NOT NULL,
    CONSTRAINT Bus_Stop_PK primary key(StopNumber)
);

/*Stop_Search*/
CREATE Table Stop_Search
(
	StopNumber char(8) NOT NULL,
    PeriodName varchar(15) NOT NULL,
    Count int NOT NULL,
    Constraint Stop_Search_PK primary key(StopNumber,PeriodName),
    Constraint Stop_Search_FK1 foreign key(StopNumber) references Bus_Stop(StopNumber),
    Constraint Stop_Search_FK2 foreign key(PeriodName) references Week_Period(PeriodName)
);


/*Route Table*/
CREATE Table Route
(
	ServiceNumber char(8) NOT NULL,
    RouteNumber int NOT NULL,
    Remark varchar(70) NOT NULL,
    StartBusStop char(8) NOT NULL,
    EndBusStop char(8) NOT NULL,
    Constraint Route_PK primary key(ServiceNumber,RouteNumber),
    Constraint Route_FK1 foreign key(ServiceNumber) references service(ServiceNumber),
    Constraint Route_FK2 foreign key(StartBusStop) references Bus_Stop(StopNumber),
    Constraint Route_FK3 foreign key(EndBusStop) references Bus_Stop(StopNumber)

);



/*Bus_Route Table*/
CREATE Table Bus_Route
(
	ServiceNumber char(8) not NULL,
    RouteNumber int NOT NULL,
    StopNumber char(8) NOT NULL,
    StopOrder int NOT NULL,
    Constraint Bus_Route_PK primary key (ServiceNumber, RouteNumber, StopNumber,StopOrder),
    Constraint Bus_RouteFK1 foreign key(ServiceNumber,RouteNumber) References route(ServiceNumber,RouteNumber),
    Constraint Bus_RouteFK2 foreign key(StopNumber) References Bus_Stop(StopNumber)
);

/*Terminus Table*/
CREATE Table Terminus
(
	StopNumber char(8) NOT NULL,
    LostFoundNumber char(8) NOT NULL,
    StarHour char(4) NOT NULL,
    EndHour char(4) NOT NULL,
    Constraint Terminus_PK primary key (StopNumber),
    Constraint Terminus_FK foreign key (StopNumber) references BUS_STOP(StopNumber)
);

/*Non_Terminus Table*/
CREATE Table Non_Terminus
(
	StopNumber char(8) NOT NULL,
    Epaper_Installed tinyint(1) NOT NULL,
    Install_Date date,
    Model_Number varchar(20),
    Constraint Non_Terminus_PK primary key(StopNumber),
    Constraint Non_TerminusFK foreign key(StopNumber) references Bus_Stop(StopNumber)
);

/*Bus Table*/
CREATE Table Bus
(
	PlateNumber char(8) NOT NULL,
    Model varchar(8) NOT NULL,
    Capacity int NOT NULL,
    AcquiredDate date not NULL,
    Constraint Bus_PK primary key (PlateNumber)
);

/*Driver Table*/
CREATE Table Driver
(
	StaffID int NOT NULL,
    NRIC char(9) NOT NULL,
    DriverName varchar(30) NOT NULL,
    LicenseNumber int NOT NULL,
    DateCertified date NOT NULL,
    Constraint Driver_PK primary key(StaffID)
);

/*Driver_OffDays Table*/
CREATE Table Driver_OffDays
(
	StaffID int NOT NULL,
    OffDay int NOT NULL,
    Constraint Driver_OffDays_PK primary key(StaffID, OffDay),
    Constraint Driver_OffDay_FK foreign key(staffID) references Driver(StaffID)
);

/*Trip Table*/
CREATE Table Trip
(	
	TripID int NOT NULL,
    TripDate date NOT NULL,
    TripTime time NOT NULL,
    ServiceNumber char(8) NOT NULL,
    RouteNumber int NOT NULL,
    BusPlate char(8) NOT NULL,
    Driver int NOT NULL,
    Cancelled tinyint(1) NOT NULL,
    Constraint Trip_PK primary key (TripID),
    Constraint Trip_FK1 foreign key(ServiceNumber,RouteNumber) References route(ServiceNumber,RouteNumber),
    Constraint Trip_FK2 foreign key (BusPlate) references BUS(plateNumber),
    Constraint Trip_FK3 foreign key (Driver) references Driver(StaffID)
);


/*Bus_Location Table*/
CREATE table Bus_Location
(
	TripID int NOT NULL,
    LocationTimeStamp datetime NOT NULL,
    StopNumber char(8) NOT NULL,
    LocationX decimal(12,4) NOT NULL,
    LocationY decimal(12,4) NOT NULL,
    ArrivalMins int NOT NULL,
    Constraint Bus_Location_PK primary key(TripID, LocationTimeStamp),
    Constraint Bus_Location_FK1 foreign key(TripID) references trip(TripID),
    Constraint Bus_Location_FK2 foreign key(StopNumber) references bus_stop(StopNumber)
);

/*LOAD DATA*/
LOAD DATA INFILE 'D:/G7T08/data/services.txt' INTO TABLE service FIELDS TERMINATED BY ',' LINES TERMINATED BY '\r\n' IGNORE 1 LINES;
LOAD DATA INFILE 'D:/G7T08/data/week-period.txt' INTO TABLE week_period FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\r\n' IGNORE 1 LINES;
LOAD DATA INFILE 'D:/G7T08/data/service-search.txt' INTO TABLE service_search FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\r\n' IGNORE 1 LINES;
LOAD DATA INFILE 'D:/G7T08/data/bus-stops.txt' INTO TABLE bus_stop FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\r\n' IGNORE 1 LINES;
LOAD DATA INFILE 'D:/G7T08/data/stop-search.txt' INTO TABLE stop_search FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\r\n' IGNORE 1 LINES;
LOAD DATA INFILE 'D:/G7T08/data/route.txt' INTO TABLE route FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\r\n' IGNORE 1 LINES;
LOAD DATA INFILE 'D:/G7T08/data/bus-route.txt' INTO TABLE Bus_Route FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\r\n' IGNORE 1 LINES;
LOAD DATA INFILE 'D:/G7T08/data/terminus.txt' INTO TABLE terminus FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\r\n' IGNORE 1 LINES;
LOAD DATA INFILE 'D:/G7T08/data/non-terminus.txt' INTO TABLE non_terminus FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\r\n' IGNORE 1 LINES;
LOAD DATA INFILE 'D:/G7T08/data/bus.txt' INTO TABLE BUS FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\r\n' IGNORE 1 LINES;
LOAD DATA INFILE 'D:/G7T08/data/driver.txt' INTO TABLE DRIVER FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\r\n' IGNORE 1 LINES;
LOAD DATA INFILE 'D:/G7T08/data/driver-offdays.txt' INTO TABLE driver_offdays FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\r\n' IGNORE 1 LINES;
LOAD DATA INFILE 'D:/G7T08/data/trip.txt' INTO TABLE TRIP FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\n' IGNORE 1 LINES (TripID,ServiceNumber, RouteNumber,TripDate,TripTime,BusPlate,driver,Cancelled);