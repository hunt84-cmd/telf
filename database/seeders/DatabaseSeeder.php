<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Emisora;
use App\Models\Persona;
use App\Models\Paquete;
use App\Models\Telefono;
use App\Models\Linea;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuarios primero
        $this->call([
            UserSeeder::class,
        ]);
        
        // Crear emisoras de ejemplo
        $emisoras = [
            [
                'nombre' => 'Radio Ciudad',
                'responsable' => 'Juan Pérez',
            ],
            [
                'nombre' => 'Radio Nacional',
                'responsable' => 'María González',
            ],
            [
                'nombre' => 'Radio Popular',
                'responsable' => 'Carlos Rodríguez',
            ],
        ];

        foreach ($emisoras as $emisoraData) {
            Emisora::create($emisoraData);
        }

        // Crear paquetes de ejemplo
        $paquetes = [
            [
                'nombre' => 'Básico',
                'cantidad_datos' => 2,
                'cantidad_minutos' => 100,
                'cantidad_sms' => 50,
                'precio_costo' => 25.00,
                'descripcion' => 'Paquete básico para uso personal',
            ],
            [
                'nombre' => 'Estándar',
                'cantidad_datos' => 5,
                'cantidad_minutos' => 300,
                'cantidad_sms' => 150,
                'precio_costo' => 45.00,
                'descripcion' => 'Paquete estándar para uso moderado',
            ],
            [
                'nombre' => 'Premium',
                'cantidad_datos' => 10,
                'cantidad_minutos' => 600,
                'cantidad_sms' => 300,
                'precio_costo' => 75.00,
                'descripcion' => 'Paquete premium para uso intensivo',
            ],
            [
                'nombre' => 'Empresarial',
                'cantidad_datos' => 20,
                'cantidad_minutos' => 1000,
                'cantidad_sms' => 500,
                'precio_costo' => 120.00,
                'descripcion' => 'Paquete empresarial para uso profesional',
            ],
        ];

        foreach ($paquetes as $paqueteData) {
            Paquete::create($paqueteData);
        }

        // Crear personas de ejemplo
        $personas = [
            [
                'nombre' => 'Ana',
                'apellidos' => 'Martínez',
                'ci' => '12345678',
                'emisora_id' => 1,
            ],
            [
                'nombre' => 'Luis',
                'apellidos' => 'Fernández',
                'ci' => '23456789',
                'emisora_id' => 1,
            ],
            [
                'nombre' => 'Carmen',
                'apellidos' => 'López',
                'ci' => '34567890',
                'emisora_id' => 2,
            ],
            [
                'nombre' => 'Roberto',
                'apellidos' => 'García',
                'ci' => '45678901',
                'emisora_id' => 2,
            ],
            [
                'nombre' => 'Isabel',
                'apellidos' => 'Hernández',
                'ci' => '56789012',
                'emisora_id' => 3,
            ],
        ];

        foreach ($personas as $personaData) {
            Persona::create($personaData);
        }

        // Crear teléfonos de ejemplo
        $telefonos = [
            [
                'modelo' => 'Samsung Galaxy A54',
                'estado_tecnico' => 'Bueno',
                'observaciones' => 'Teléfono nuevo en caja',
            ],
            [
                'modelo' => 'iPhone 14',
                'estado_tecnico' => 'Bueno',
                'observaciones' => 'Teléfono seminuevo',
            ],
            [
                'modelo' => 'Xiaomi Redmi Note 12',
                'estado_tecnico' => 'Bueno',
                'observaciones' => 'Teléfono usado en buen estado',
            ],
            [
                'modelo' => 'Motorola Moto G84',
                'estado_tecnico' => 'Dañado',
                'observaciones' => 'Pantalla rota, necesita reparación',
            ],
            [
                'modelo' => 'Huawei P30',
                'estado_tecnico' => 'Roto',
                'observaciones' => 'No funciona, para repuestos',
            ],
        ];

        foreach ($telefonos as $telefonoData) {
            Telefono::create($telefonoData);
        }

        // Crear líneas de ejemplo
        $lineas = [
            [
                'numero_telefono' => '+5351234567',
                'pin' => '1234',
                'puk' => '12345678',
                'estado' => 'Activa',
                'paquete_id' => 1,
                'observaciones' => 'Línea nueva activada',
            ],
            [
                'numero_telefono' => '+5352345678',
                'pin' => '2345',
                'puk' => '23456789',
                'estado' => 'Activa',
                'paquete_id' => 2,
                'observaciones' => 'Línea con paquete estándar',
            ],
            [
                'numero_telefono' => '+5353456789',
                'pin' => '3456',
                'puk' => '34567890',
                'estado' => 'Inactiva',
                'observaciones' => 'Línea sin activar',
            ],
            [
                'numero_telefono' => '+5354567890',
                'pin' => '4567',
                'puk' => '45678901',
                'estado' => 'Activa',
                'paquete_id' => 3,
                'observaciones' => 'Línea premium',
            ],
            [
                'numero_telefono' => '+5355678901',
                'pin' => '5678',
                'puk' => '56789012',
                'estado' => 'Suspendida',
                'observaciones' => 'Línea suspendida por falta de pago',
            ],
        ];

        foreach ($lineas as $lineaData) {
            Linea::create($lineaData);
        }

        // Asignar algunos teléfonos y líneas a personas
        $telefono1 = Telefono::find(1);
        $telefono1->update([
            'persona_id' => 1,
            'fecha_asignacion' => now(),
        ]);

        $telefono2 = Telefono::find(2);
        $telefono2->update([
            'persona_id' => 2,
            'fecha_asignacion' => now(),
        ]);

        $linea1 = Linea::find(1);
        $linea1->update([
            'persona_id' => 1,
            'fecha_asignacion' => now(),
        ]);

        $linea2 = Linea::find(2);
        $linea2->update([
            'persona_id' => 2,
            'fecha_asignacion' => now(),
        ]);

        $linea4 = Linea::find(4);
        $linea4->update([
            'persona_id' => 3,
            'fecha_asignacion' => now(),
        ]);

        $this->command->info('Datos de ejemplo creados exitosamente!');
        $this->command->info('Emisoras: ' . Emisora::count());
        $this->command->info('Personas: ' . Persona::count());
        $this->command->info('Paquetes: ' . Paquete::count());
        $this->command->info('Teléfonos: ' . Telefono::count());
        $this->command->info('Líneas: ' . Linea::count());
    }
}
