<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Dear {{$patient->name}}</p>
    <p>We are sorry to inform you that your appointment on {{$appointment_date}} with Dr. {{$doctor_name}} at {{$appointment_time}} has been cancelled by our admin.
        Please contact admin for more details  </p>
    <p>Please feel free to contact us for any query</p>
    <p>Regards,</p>
    <p>Admin</p>
</body>
</html>