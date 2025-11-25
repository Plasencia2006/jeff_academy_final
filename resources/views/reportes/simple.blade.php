<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $titulo }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            color: #333;
        }
        .header { 
            text-align: center; 
            margin-bottom: 20px; 
            border-bottom: 2px solid #2c3e50; 
            padding-bottom: 15px;
        }
        .header h1 { 
            color: #2c3e50; 
            margin: 0; 
            font-size: 24px;
        }
        .info { 
            margin-bottom: 20px; 
            display: flex;
            justify-content: space-between;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px;
            font-size: 12px;
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left; 
        }
        th { 
            background-color: #f8f9fa; 
            font-weight: bold;
            color: #2c3e50;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .footer { 
            margin-top: 30px; 
            text-align: center; 
            font-size: 10px; 
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $titulo }}</h1>
        <p><strong>Sistema de Gestión Deportiva</strong></p>
    </div>

    <div class="info">
        <p><strong>Fecha de generación:</strong> {{ $fecha }}</p>
        <p><strong>Total de registros:</strong> {{ $total }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre/Jugador</th>
                <th>Información</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datos as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>
                    {{-- Para inscripciones, mostrar el nombre del jugador --}}
                    @if(isset($item->jugador))
                        {{ $item->jugador->name ?? 'N/A' }}
                    @elseif(isset($item->name))
                        {{ $item->name }}
                    @elseif(isset($item->titulo))
                        {{ $item->titulo }}
                    @elseif(isset($item->nombre))
                        {{ $item->nombre }}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    {{-- Para inscripciones, mostrar disciplina y entrenador --}}
                    @if(isset($item->disciplina))
                        <strong>Disciplina:</strong> {{ $item->disciplina }}<br>
                        <strong>Categoría:</strong> {{ $item->categoria }}<br>
                        @if(isset($item->entrenador))
                            <strong>Entrenador:</strong> {{ $item->entrenador->name ?? 'Sin asignar' }}
                        @endif
                    @elseif(isset($item->email))
                        {{ $item->email }}
                    @elseif(isset($item->contenido))
                        {{ Str::limit(strip_tags($item->contenido), 50) }}
                    @elseif(isset($item->descripcion))
                        {{ Str::limit($item->descripcion, 50) }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if(isset($item->fecha))
                        {{ \Carbon\Carbon::parse($item->fecha)->format('d/m/Y') }}
                    @elseif(isset($item->created_at))
                        {{ $item->created_at->format('d/m/Y') }}
                    @elseif(isset($item->fecha_publicacion))
                        {{ $item->fecha_publicacion->format('d/m/Y') }}
                    @else
                        {{ now()->format('d/m/Y') }}
                    @endif
                </td>
                <td>
                    @if(isset($item->estado))
                        {{ ucfirst($item->estado) }}
                    @elseif(isset($item->activo))
                        {{ $item->activo ? 'Activo' : 'Inactivo' }}
                    @else
                        Activo
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Generado automáticamente por el Sistema de Gestión Deportiva</p>
        <p>© {{ date('Y') }} - Todos los derechos reservados</p>
    </div>
</body>
</html>