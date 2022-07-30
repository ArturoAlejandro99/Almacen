<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Administradores']);
        $role3 = Role::create(['name' => 'Encargado almacén']);

        //permisos de menus desplegables
        /*Permission::create(['name'=>'catalogos'])->assignRole($role1);
        Permission::create(['name'=>'cintaBlanca'])->assignRole($role1);
        Permission::create(['name'=>'reportes'])->assignRole($role1);*/

        Permission::create(['name'=>'rol.index', 'description' => "Listado de roles"])->assignRole($role1);
        Permission::create(['name'=>'rol.edit', 'description' => "Editar rol"])->assignRole($role1);
        Permission::create(['name'=>'rol.create', 'description' => "Crear rol"])->assignRole($role1);
        Permission::create(['name'=>'rol.destroy', 'description' => "Eliminar rol"])->assignRole($role1);

        Permission::create(['name'=>'user.index', 'description' => "Listado de usuarios"])->assignRole($role1);
        Permission::create(['name'=>'user.create', 'description' => "Crear usuario"])->assignRole($role1);
        //Permission::create(['name'=>'user.store'])->assignRole($role1);
        Permission::create(['name'=>'user.edit', 'description' => "Editar usuario"])->assignRole($role1);
        Permission::create(['name'=>'user.destroy', 'description' => "Eliminar usuario"])->assignRole($role1);
        
        /*YA*/Permission::create(['name'=>'coilReel.create', 'description' => "Crear hueso de bobina"])->assignRole($role1);
        /*YA*/Permission::create(['name'=>'coilReel.edit', 'description' => "Editar hueso de bobina"])->assignRole($role1);
        Permission::create(['name'=>'coilReel.destroy', 'description' => "Eliminar hueso de bobina"])->assignRole($role1);

        /*YA*/Permission::create(['name'=>'coil.create', 'description' => "Crear bobina"])->assignRole($role1);
        /*YA*/Permission::create(['name'=>'coil.edit', 'description' => "Editar bobina"])->assignRole($role1);
        /*YA*/Permission::create(['name'=>'coil.index', 'description' => "Listado de bobinas"])->assignRole($role1);
        Permission::create(['name'=>'coil.destroy', 'description' => "Eliminar bobina"])->assignRole($role1);
        /*YA*/Permission::create(['name'=>'coil.terminar', 'description' => "Terminar bobina"])->assignRole($role1);
        Permission::create(['name' => 'coil.reporteria', 'description' => "Reporteria de bobina"])->assignRole($role1);
        Permission::create(['name' => 'coil.produccion', 'description' => "Reporte de producción"])->assignRole($role1);

        /*YA*/Permission::create(['name'=>'ribbon.create', 'description' => "Crear rollo"])->assignRole($role1);
        Permission::create(['name'=>'ribbon.edit', 'description' => "Editar rollo"])->assignRole($role1);
        Permission::create(['name'=>'ribbon.destroy', 'description' => "Eliminar rollo"])->assignRole($role1);
        Permission::create(['name' => 'ribbon.reporteria', 'description' => "Reporteria de rollos"])->assignRole($role1);
        //Permission::create(['name'=>'ribbon.createProduct'])->assignRole($role1);
        //Permission::create(['name'=>'ribbon.show'])->assignRole($role1);

        Permission::create(['name'=>'whiteCoil.create', 'description' => "Crear bobina de cenefa"])->assignRole($role1);
        Permission::create(['name'=>'whiteCoil.edit', 'description' => "Editar bobina de cenefa"])->assignRole($role1);
        Permission::create(['name'=>'whiteCoil.index', 'description' => "Listado de bobinas de cenefa"])->assignRole($role1);
        Permission::create(['name'=>'whiteCoil.destroy', 'description' => "Eliminar bobina de cenefa"])->assignRole($role1);

        
        Permission::create(['name'=>'coilProduct.index', 'description' => "Listado de rollos"])->assignRole($role1);

        Permission::create(['name'=>'whiteCoilProduct.index', 'description' => "Listado de rollos de cenefa"])->assignRole($role1);

        Permission::create(['name'=>'whiteRibbon.create', 'description' => "Crear rollo de cenefa"])->assignRole($role1);
        Permission::create(['name'=>'whiteRibbon.edit', 'description' => "Editar rollo de cenefa"])->assignRole($role1);
        Permission::create(['name'=>'whiteRibbon.destroy', 'description' => "Eliminar rollo de cenefa"])->assignRole($role1);

        /*YA*/Permission::create(['name'=>'wasteRibbon.create', 'description' => "Crear merma de bobina"])->assignRole($role1);
        Permission::create(['name'=>'wasteRibbon.edit', 'description' => "Editar merma de bobina"])->assignRole($role1);
        Permission::create(['name'=>'wasteRibbon.destroy', 'description' => "Eliminar merma de bobina"])->assignRole($role1);

        Permission::create(['name'=>'provider.create', 'description' => "Crear proveedor"])->assignRole($role1);
        Permission::create(['name'=>'provider.edit', 'description' => "Editar proveedor"])->assignRole($role1);
        Permission::create(['name'=>'provider.index', 'description' => "Listado de proveedores"])->assignRole($role1);
        Permission::create(['name'=>'provider.destroy', 'description' => "Eliminar proveedor"])->assignRole($role1);

        Permission::create(['name'=>'bag.create', 'description' => "Crear bolsas"])->assignRole($role1);
        Permission::create(['name'=>'bag.edit', 'description' => "Editar bolsas"])->assignRole($role1);
        Permission::create(['name'=>'bag.destroy', 'description' => "Eliminar bolsas"])->assignRole($role1);
        Permission::create(['name' => 'bag.reporteria', 'description' => "Reporteria de bolsas"])->assignRole($role1);

        Permission::create(['name'=>'wasteBag.create', 'description' => "Crear merma de rollo"])->assignRole($role1);
        Permission::create(['name'=>'wasteBag.edit', 'description' => "Ediat merma de rollo"])->assignRole($role1);
        Permission::create(['name'=>'wasteBag.destroy', 'description' => "Eliminar merma de rollo"])->assignRole($role1);
       // Permission::create(['name'=>'wasteBag.createProduct'])->assignRole($role1);
        //Permission::create(['name'=>'wasteBag.show'])->assignRole($role1);

        Permission::create(['name'=>'ribbonProduct.index', 'description' => "Listado de rollos"])->assignRole($role1);

        //Permission::create(['name'=>'whiteRibbonProduct.create'])->assignRole($role1);
        Permission::create(['name'=>'whiteRibbonProduct.edit', 'description' => "Listado de rollos de cenefa"])->assignRole($role1);
        //Permission::create(['name'=>'whiteRibbonProduct.index'])->assignRole($role1);
       // Permission::create(['name'=>'whiteRibbonProduct.destroy'])->assignRole($role1);
        //Permission::create(['name'=>'whiteRibbonProduct.show'])->assignRole($role1);

        Permission::create(['name'=>'employee.create', 'description' => "Crear empleado"])->assignRole($role1);
        Permission::create(['name'=>'employee.edit', 'description' => "Editar empleado"])->assignRole($role1);
        Permission::create(['name'=>'employee.index', 'description' => "Listado de empleados"])->assignRole($role1);
        Permission::create(['name'=>'employee.destroy', 'description' => "Eliminar empleado"])->assignRole($role1);

        Permission::create(['name'=>'whiteWaste.create', 'description' => "Crear merma de bobina de cenefa blanca"])->assignRole($role1);
        Permission::create(['name'=>'whiteWaste.edit', 'description' => "Editar merma de bobina de cenefa blanca"])->assignRole($role1);
        Permission::create(['name'=>'whiteWaste.destroy', 'description' => "Eliminar merma de bobina de cenefa blanca"])->assignRole($role1);

        Permission::create(['name'=>'ribbonReel.create', 'description' => "Crear hueso de rollo"])->assignRole($role1);
        Permission::create(['name'=>'ribbonReel.edit', 'description' => "Editar hueso de rollo"])->assignRole($role1);
        Permission::create(['name'=>'ribbonReel.destroy', 'description' => "Eliminar hueso de rollo"])->assignRole($role1);
        //Permission::create(['name'=>'ribbonReel.createProduct'])->assignRole($role1);
        //Permission::create(['name'=>'ribbonReel.show'])->assignRole($role1);

        Permission::create(['name'=>'whiteRibbonReel.create', 'description' => "Crear hueso de rollo de cenefa blanca"])->assignRole($role1);
        Permission::create(['name'=>'whiteRibbonReel.edit', 'description' => "Editar hueso de rollo de cenefa blanca"])->assignRole($role1);
        Permission::create(['name'=>'whiteRibbonReel.destroy', 'description' => "Eliminar hueso de rollo de cenefa blanca"])->assignRole($role1);

        Permission::create(['name'=>'whiteWasteRibbon.create', 'description' => "Crear merma de rollo de cenefa blanca"])->assignRole($role1);
        Permission::create(['name'=>'whiteWasteRibbon.edit', 'description' => "Editar merma de rollo de cenefa blanca"])->assignRole($role1);
        Permission::create(['name'=>'whiteWasteRibbon.destroy', 'description' => "Eliminar merma de rollo de cenefa blanca"])->assignRole($role1);

        Permission::create(['name'=>'coilType.create', 'description' => "Crear tipo de bobina"])->assignRole($role1);
        Permission::create(['name'=>'coilType.edit', 'description' => "Editar tipo de bobina"])->assignRole($role1);
        Permission::create(['name'=>'coilType.index', 'description' => "Listar tipos de bobina"])->assignRole($role1);
        Permission::create(['name'=>'coilType.destroy', 'description' => "Eliminar tipos de bobina"])->assignRole($role1);
    }
}
