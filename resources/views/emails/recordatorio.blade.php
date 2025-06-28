{{-- <h2>¡Hola {{ $cita->cliente->nombre }}!</h2>

<p>Te recordamos que tienes una cita programada en <b>OdontoDent</b>.</p>

<ul>
    <li><strong>Especialidad:</strong> {{ $cita->especialidad->nombre }}</li>
    <li><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($cita->inicio)->format('d/m/Y') }}</li>
    <li><strong>Hora:</strong> {{ \Carbon\Carbon::parse($cita->inicio)->format('H:i') }}</li>
</ul>

<p>Por favor, asegúrate de llegar 10 minutos antes.</p>

<p>Gracias,<br>Equipo de OdontoDent</p> --}}

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recordatorio de Cita</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 5px 5px;
        }
        .cita-info {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #3498db;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
        .btn {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🦷 Clínica Dental OdontoDent</h1>
        <h2>Recordatorio de Cita</h2>
    </div>
    
    <div class="content">
        <p>Estimado/a <strong>{{ $cita->cliente->nombre ?? 'Paciente' }}</strong>,</p>
        
        <p>Le recordamos que tiene una cita programada en nuestra clínica dental:</p>
        
        <div class="cita-info">
            <h3>📅 Detalles de su Cita:</h3>
            <p><strong>Fecha y Hora:</strong> {{ \Carbon\Carbon::parse($cita->inicio)->format('d/m/Y H:i') }}</p>
            <p><strong>Especialidad:</strong> {{ $cita->especialidad->nombre }}</p>
            <p><strong>Con el Doctor:</strong> {{ $cita->doctor->name }}</p>
            {{-- <p><strong>Paciente:</strong> {{ $cita->cliente->nombre ?? 'Paciente' }}</p> --}}
        </div>
        
        <p><strong>Recomendaciones importantes:</strong></p>
        <ul>
            <li>Llegue 15 minutos antes de su cita</li>
            <li>Traiga su documento de identidad</li>
            <li>Si tiene algún examen médico reciente, por favor tráigalo</li>
            <li>En caso de no poder asistir, comuníquese con nosotros con 24 horas de anticipación</li>
        </ul>
        
        <p>Si necesita reprogramar o cancelar su cita, por favor contáctenos lo antes posible.</p>
        
        <p>¡Esperamos verle pronto!</p>
        
        <p>Atentamente,<br>
        <strong>Equipo de Clínica Dental OdontoDent</strong></p>
    </div>
    
    <div class="footer">
        <p>📞 Teléfono: {{$ajustes->telefono}} | 📧 Email: clinicadental@odontodent.com</p>
        <p>📍 Dirección: {{ $ajustes->direccion ?? 'Dirección no disponible' }}</p>
    </div>
</body>
</html>