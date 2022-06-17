<!-- View stored in resources/views/greeting.blade.php -->
<link href="{{ asset('/css/trips.css') }}" rel="stylesheet">

<html>
    <body>
        @foreach ($trips as $tripIndex =>$trip)
            <h1>{{ $trip->id .' : ' .$trip->name }}</h1>
                
                <h2>Bus Driver Name : {{ $trip->buses[0]->driver_name }}</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>City Name</th>
                            @foreach( range(1, 12) as $i)
                                <th>Seat {{ $i+$tripIndex*12 }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trip->cities as $city)
                            <tr>
                                <td>{{ $city->id }}</td>
                                <td>{{ $city->name }}</td>
                                @foreach( range(1, 12) as $i)
                                    <td>
                                        @if(isset($bookingArray[$i+$tripIndex*12][$city->id]))
                                            <span class="badge badge-danger">Booked</span>
                                        @else
                                            <span class="badge badge-success">Available</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
   
        @endforeach
    </body>
</html>