<h2>¡Hola {{ $cita->cliente->nombre }}!</h2>

<p>Te recordamos que tienes una cita programada en <b>OdontoDent</b>.</p>

<ul>
    <li><strong>Especialidad:</strong> {{ $cita->especialidad->nombre }}</li>
    <li><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($cita->inicio)->format('d/m/Y') }}</li>
    <li><strong>Hora:</strong> {{ \Carbon\Carbon::parse($cita->inicio)->format('H:i') }}</li>
</ul>

<p>Por favor, asegúrate de llegar 10 minutos antes.</p>

<p>Gracias,<br>Equipo de OdontoDent</p>