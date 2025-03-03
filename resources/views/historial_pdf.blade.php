<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Usuarios y Registros</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h1,
        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <h1>Informe de Usuarios y Registros</h1>

    <h2>Usuario: {{ $usuario->name }} ({{ $usuario->email }})</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha Entrada</th>
                <th>Hora Entrada</th>
                <th>Fecha Salida</th>
                <th>Hora Salida</th>
                <th>Horas Trabajadas</th>
            </tr>
        </thead>
        <tbody>
            @php $totalHoras = 0; @endphp
            @foreach ($registros as $registro)
                @php
                    $horasTrabajadas = $registro->horas_trabajadas;
                    $totalHoras += $horasTrabajadas;
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($registro->entry_time)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($registro->entry_time)->format('H:i') }}</td>
                    <td>{{ $registro->departure_time ? \Carbon\Carbon::parse($registro->departure_time)->format('d/m/Y') : '---' }}</td>
                    <td>{{ $registro->departure_time ? \Carbon\Carbon::parse($registro->departure_time)->format('H:i') : '---' }}</td>
                    <td>{{ floor($horasTrabajadas) }}h {{ round(($horasTrabajadas - floor($horasTrabajadas)) * 60) }}min</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p class="total">
        Total de Horas Trabajadas: 
        {{ floor($totalHoras) }}h {{ round(($totalHoras - floor($totalHoras)) * 60) }}min
    </p>
</body>
</html>
