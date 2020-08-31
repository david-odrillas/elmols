<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use App\Product;
class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function testGuestNoAccess()
    {
     $this->get('/products')
         ->assertRedirect('login');
    }
    public function testSuperAdminAccess()
    {
     $role = Role::create(['name' => 'super-admin']);
     $user = factory(User::class)->create();
     $user->assignRole($role);
     $this->actingAs($user);
     $this->get('/products')
         ->assertOk();
    }
    public function testUserPermissionNoAccess()
    {
     $role = Role::create(['name' => 'partner']);
     $user = factory(User::class)->create();
     $user->assignRole($role);
     $this->actingAs($user);
     $this->get('/products')
         ->assertForbidden();
    }
    public function testUserPermissionAccess()
    {
     $permission = Permission::create(['name' => 'products.index']);
     $role = Role::create(['name' => 'admin'])
       ->givePermissionTo($permission);
     $user = factory(User::class)->create();
     $user->assignRole($role);
     $this->actingAs($user);
     $this->get('/products')
      ->assertOk();
    }
    public function testListEmpty()
    {
      $permission = Permission::create(['name' => 'products.index']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo($permission);
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/products')
       ->assertSee('No hay Productos registrados');
    }
    public function testListNoEmpty()
    {
      Product::create(['name' => 'maiz']);
      Product::create(['name' => 'trigo']);
      $permission = Permission::create(['name' => 'products.index']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo($permission);
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/products')
       ->assertSee('MAIZ', 'TRIGO');
    }
    /*
    * Ver la opcion de Eliminar, Solo si tiene los permisos
    */
    public function testDeletePermissionDontSee()
    {
      Permission::create(['name' => 'products.index']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo(Permission::all());
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/products')->assertDontSee('delete-row');
    }
    public function testSoftDelete()
    {
      $product = Product::create(['name' => 'maiz']);
      Permission::create(['name' => 'products.index']);
      Permission::create(['name' => 'products.destroy']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo(Permission::all());
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/products')
          ->assertSee('MAIZ');
      $this->get('/products')->assertSee('delete-row');
      $this->delete("products/{$product->id}")
          ->assertRedirect('products');
      $this->assertSoftDeleted($product);
    }
    /*
    * Ver Eliminados
    */
    public function testSoftDeleteGuestNoAccess()
    {
      $this->get('/products/deletes')
        ->assertRedirect('login');
    }
    public function testSoftDeletePermissionNoAccess()
    {
      Role::create(['name' => 'admin']);
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/products/deletes')
          ->assertForbidden();
    }
    public function testListEmptySoftDelete()
    {
      Permission::create(['name' => 'products.index']);
      Permission::create(['name' => 'products.destroy']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo(Permission::all());
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/products/deletes')
          ->assertSee('No hay Productos Activos');
    }
    public function testListSoftDelete()
    {
      $product = Product::create(['name' => 'maiz']);
      Permission::create(['name' => 'products.index']);
      Permission::create(['name' => 'products.destroy']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo(Permission::all());
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/products')
          ->assertSee('MAIZ');
      $this->delete("products/{$product->id}")
          ->assertRedirect('products');
      $this->assertSoftDeleted($product);
      $this->get('/products/deletes')
          ->assertSee('MAIZ');
    }
    /**
    *   Crear
    */
    public function testCreateGuestNoAccess()
    {
      $this->get('/products/create')
        ->assertRedirect('login');
    }
    public function testCreatePermissionNoAccess()
    {
      Permission::create(['name' => 'products.index']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo(Permission::all());
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/products')->assertDontSee('Agregar Producto');
      $this->get('/products/create')
          ->assertForbidden();
    }
    public function testCreate()
    {
      Permission::create(['name' => 'products.index']);
      Permission::create(['name' => 'products.create']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo(Permission::all());
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/products')->assertSee('Agregar Producto');
      $this->get('/products/create')->assertSee('Crear Producto');
      $this->post('/products',['name' =>'maiz'])->assertRedirect('products');
      $this->assertDatabaseHas('products', ['name' => 'MAIZ']);
    }
    /*
    * Update
    */
    public function testEditGuestNoAccess()
    {
      $this->get('/products/1/edit')
        ->assertRedirect('login');
    }
    public function testEditPermissionNoAccess()
    {
      $product = Product::create(['name' => 'maiz']);
      Permission::create(['name' => 'products.index']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo(Permission::all());
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/products')->assertDontSee('Editar');
      $this->get('/products/1/edit')
        ->assertForbidden();
    }
    public function testEdit()
    {
      $product = Product::create(['name' => 'maiz']);
      Permission::create(['name' => 'products.index']);
      Permission::create(['name' => 'products.edit']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo(Permission::all());
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get("/products/{$product->id}/edit")->assertSee('Modificar Producto');
      $this->put("/products/{$product->id}",['name' =>'trigo'])->assertRedirect('products');
      $this->assertDatabaseHas('products', ['name' => 'TRIGO']);
    }
    public function testRestore()
    {
      $product = product::create(['name' => 'maiz']);
      Permission::create(['name' => 'products.index']);
      Permission::create(['name' => 'products.destroy']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo(Permission::all());
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      //ver Marca creada
      $this->get('/products')
          ->assertSee('MAIZ');
      $this->delete("products/{$product->id}")
          ->assertRedirect('products');
      $this->assertSoftDeleted($product);
      //retore
      $this->get('/products/deletes')
          ->assertSee('MAIZ');
      $this->put("/products/{$product->id}/restore")->assertRedirect('products');
      $this->get('/products')
          ->assertSee('MAIZ');
    }
    public function testSearch()
    {
      $product = product::create(['name' => 'maiz']);
      $permission = Permission::create(['name' => 'products.index']);
      Role::create(['name' => 'admin'])
        ->givePermissionTo($permission);
      $user = factory(User::class)->create();
      $user->assignRole('admin');
      $this->actingAs($user);
      $this->get('/products?name=m')->assertSee('MAIZ');
    }
}
