<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles con firstOrCreate
        $role1 = Role::firstOrCreate(['name' => 'admin']);
        $role2 = Role::firstOrCreate(['name' => 'manager']);
        /*
         Responsabilidades:
         - Gestión de inventarios y productos.
         - Supervisión de pedidos y envíos.
         - Gestión del personal y horarios.
         - Generación de reportes operativos.
         - Puede no tener acceso a configuraciones críticas del sistema.
         */
        $role3 = Role::firstOrCreate(['name' => 'sales_clerk']); // empleados de venta
        /*
         Responsabilidades:
         - Atención al cliente en el punto de venta.
         - Procesamiento de pedidos y pagos.
         - Registro de devoluciones o cambios.
         - Actualización de información básica de inventarios (por ejemplo, productos agotados).
         */
        $role4 = Role::firstOrCreate(['name' => 'accounting']); // contador
        $role5 = Role::firstOrCreate(['name' => 'marketing']);  // marketing

        // Crear permisos con firstOrCreate
        $permission1 = Permission::firstOrCreate(['name' => 'admin.orders.index', 'guard_name' => 'web']);
        $permission2 = Permission::firstOrCreate(['name' => 'user.orders.index', 'guard_name' => 'web']);
        $permission21 = Permission::firstOrCreate(['name' => 'gestion-usuarios.index', 'guard_name' => 'web']);

        // Asignar permisos a roles
        $role1->givePermissionTo([$permission1, $permission21]);
        $role2->givePermissionTo([$permission1, $permission21]);
        $role3->givePermissionTo($permission1);
        $role4->givePermissionTo($permission2);
        $role5->givePermissionTo($permission2);


        $role = Role::firstOrCreate(['name' => 'admin']);

        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'], // Correo único para identificar al usuario
            [
                'name' => 'Admin', // Nombre del usuario
                'password' => bcrypt('password'), // Asegúrate de usar bcrypt para la contraseña
            ]
        );

        if (!$user->hasRole('admin')) {
            $user->assignRole($role);
        }

        echo "Usuario admin creado con éxito.";
    }
}
