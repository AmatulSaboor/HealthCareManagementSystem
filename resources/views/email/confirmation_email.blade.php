<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Dear {{$patient->name}}</p>
    <p>You have booked an appointment with us. Details are given below:</p>
    <p> <b> For : </b> {{$appointment->doctorUser->doctorDetail->specialization->name}}</p>
    <p> <b> Doctor: </b> {{$appointment->doctorUser->name}}</p>
    <p> <b> Date: </b> {{$appointment->appointment_date}}</p>
    <p> <b> Time: </b> {{$appointment->appointment_time}}</p>
    <p>Please reach on time</p>
    <p>Regards,</p>
    <p>Admin</p>
</body>
</html>