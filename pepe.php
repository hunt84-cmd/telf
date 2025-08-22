<?php
/**
 * Archivo pepe.php - Muestra la hora del sistema
 * Creado en la rama "pepa"
 */

// Configurar zona horaria (opcional)
date_default_timezone_set('America/Havana'); // Para Cuba

// Obtener la hora actual
$hora_actual = date('H:i:s');
$fecha_actual = date('d/m/Y');
$dia_semana = date('l'); // Día de la semana en inglés
$dia_semana_es = '';

// Traducir el día de la semana al español
switch($dia_semana) {
    case 'Monday':
        $dia_semana_es = 'Lunes';
        break;
    case 'Tuesday':
        $dia_semana_es = 'Martes';
        break;
    case 'Wednesday':
        $dia_semana_es = 'Miércoles';
        break;
    case 'Thursday':
        $dia_semana_es = 'Jueves';
        break;
    case 'Friday':
        $dia_semana_es = 'Viernes';
        break;
    case 'Saturday':
        $dia_semana_es = 'Sábado';
        break;
    case 'Sunday':
        $dia_semana_es = 'Domingo';
        break;
}

// Obtener timestamp Unix
$timestamp = time();

// Obtener información adicional
$hora_12 = date('h:i:s A'); // Formato 12 horas con AM/PM
$hora_utc = gmdate('H:i:s'); // Hora UTC
$dia_anio = date('z'); // Día del año (0-365)
$semana_anio = date('W'); // Semana del año

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hora del Sistema - pepe.php</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 600px;
            width: 100%;
        }
        .hora-principal {
            font-size: 4em;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        .fecha {
            font-size: 1.5em;
            color: #666;
            margin: 15px 0;
        }
        .info-adicional {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .info-item {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .info-label {
            font-weight: bold;
            color: #555;
        }
        .info-value {
            color: #007bff;
            font-family: 'Courier New', monospace;
        }
        .footer {
            margin-top: 30px;
            color: #999;
            font-size: 0.9em;
        }
        .rama-info {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #2196f3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🕐 Hora del Sistema</h1>
        
        <div class="rama-info">
            <strong>🌿 Rama:</strong> pepa<br>
            <strong>📁 Archivo:</strong> pepe.php<br>
            <strong>📅 Creado:</strong> <?php echo date('d/m/Y H:i:s'); ?>
        </div>
        
        <div class="hora-principal">
            <?php echo $hora_actual; ?>
        </div>
        
        <div class="fecha">
            <?php echo $dia_semana_es . ', ' . $fecha_actual; ?>
        </div>
        
        <div class="info-adicional">
            <h3>📊 Información Detallada</h3>
            
            <div class="info-item">
                <span class="info-label">Hora (24h):</span>
                <span class="info-value"><?php echo $hora_actual; ?></span>
            </div>
            
            <div class="info-item">
                <span class="info-label">Hora (12h):</span>
                <span class="info-value"><?php echo $hora_12; ?></span>
            </div>
            
            <div class="info-item">
                <span class="info-label">Fecha:</span>
                <span class="info-value"><?php echo $fecha_actual; ?></span>
            </div>
            
            <div class="info-item">
                <span class="info-label">Día de la semana:</span>
                <span class="info-value"><?php echo $dia_semana_es; ?></span>
            </div>
            
            <div class="info-item">
                <span class="info-label">Día del año:</span>
                <span class="info-value"><?php echo $dia_anio; ?></span>
            </div>
            
            <div class="info-item">
                <span class="info-label">Semana del año:</span>
                <span class="info-value"><?php echo $semana_anio; ?></span>
            </div>
            
            <div class="info-item">
                <span class="info-label">Hora UTC:</span>
                <span class="info-value"><?php echo $hora_utc; ?></span>
            </div>
            
            <div class="info-item">
                <span class="info-label">Timestamp Unix:</span>
                <span class="info-value"><?php echo $timestamp; ?></span>
            </div>
        </div>
        
        <div class="footer">
            <p>🔄 Esta página se actualiza cada vez que se recarga</p>
            <p>⚡ Creado con PHP en la rama "pepa"</p>
        </div>
    </div>
    
    <script>
        // Actualizar la hora cada segundo
        setInterval(function() {
            location.reload();
        }, 1000);
    </script>
</body>
</html>