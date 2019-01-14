/* DM PROJECT PHASE 2 : DML */

#Question (i)
SELECT r.ServiceNumber as `Service Number`, r.RouteNumber as `Route Number`, r.StartBusStop as `First Stop`, bs1.LocationDesc as `First Stop Description`, r.EndBusStop as `Last Stop` ,bs2.LocationDesc as `Last Stop Description`
From Route r
INNER JOIN Bus_Stop bs1 On (bs1.StopNumber = r.StartBusStop)
INNER JOIN Bus_Stop bs2 ON (bs2.StopNumber = r.EndBusStop);

#Question (ii)
SELECT bs.StopNumber as `Stop code`, bs.LocationDesc as `Location Description`, bs.Address as `Address`, IF(t.StopNumber IS NULL,'No','Yes') as 'Terminus?',COUNT(distinct br.stopNumber, br.ServiceNumber,br.RouteNumber) as `Number of routes served`
FROM BUS_STOP bs
LEFT JOIN terminus t ON (bs.StopNumber = t.StopNumber)
INNER JOIN bus_route br ON(bs.StopNumber = br.StopNumber)
group by br.StopNumber
ORDER BY `Number of routes served` desc, `Stop code` asc;

#Question (iii)
SELECT D.DriverName as `Driver Name`, D.LicenseNumber as `License Number` , D.DateCertified as `Date Certified`, T.BusPlate as `Bus Plate`, T.ServiceNumber as `Service Number`, T.RouteNumber as `Route Number`
	FROM Driver D 
    LEFT OUTER JOIN Trip T ON (T.Driver = D.StaffID)
    AND T.TripDate = '2016-09-21'
    AND T.TripTime BETWEEN '09:30:00' AND '12:30:00'
    AND T.Cancelled = 0
    Order By `Driver Name` asc, `Bus Plate`asc;
    
#Question (iV)
SELECT br1.serviceNumber as `Service Number`,br1.routenumber as `Route Number`,s.Frequency as `Frequency in minutes`,count(br1.stopNumber) as `Number of Stopsit serves`, 
	(
		SELECT if(COUNT(distinct brs.ServiceNumber,brs.RouteNumber) = 1, 'Loop', 'Bi-directional') 
        FROM BUS_ROUTE brs 
        WHERE br1.servicenumber=brs.servicenumber 
        GROUP BY brs.serviceNumber
	) as `Type`
FROM bus_route br1
INNER JOIN service s on (s.ServiceNumber = br1.servicenumber)
GROUP BY br1.servicenumber,br1.routenumber
ORDER BY `Type` asc, `Service Number` asc, `Route Number` asc;

#Question (V)
SELECT R.ServiceNumber AS `Service Number`, R.RouteNumber AS `Route Number`, R.Remark AS `Remark`, COUNT(Cancelled) AS `Total Cancelled Trips`
	FROM Route R 
    INNER JOIN Trip T ON R.ServiceNumber = T.ServiceNumber AND R.RouteNumber =T.RouteNumber AND T.Cancelled = 1
    GROUP BY R.ServiceNumber, R.RouteNumber
	HAVING count(T.Cancelled) =
    (
		SELECT max(CancelledTrip)
		FROM
		(
			SELECT count(cancelled) AS `CancelledTrip`
			FROM trip
			WHERE cancelled = 1
			GROUP BY ServiceNumber , RouteNumber
		) AS TripCancelledTable
	);