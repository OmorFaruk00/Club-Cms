<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RolePermissionController extends Controller
{
  public function rolePermission(){
    $roles  = Role::select('id','name')->get();
    $permissions =  $this->get_permissions();
    return view('setting.role-permission',compact('roles','permissions'));
  }

  public function specialPermission(){
    $users  = User::select('id','name')->get();
    $permissions =  $this->get_permissions();
    return view('setting.special-permission', compact('users','permissions'));
  }
  public function role($id)
  {
        $role = Role::find($id);

       return [
        'id' => $role->id,
        'role_name' => $role->name,
        'permissions' => json_decode($role->permissions),
        'role_slug' => $role->slug,
    ];
    
      return response()->json(NULL, 404);
  }
  public function user($id)
  {
        $user = User::find($id);

       return [
        'id' => $user->id,
        'role_name' => $user->name,
        'permissions' => json_decode($user->permissions),
    ];
    
      return response()->json(NULL, 404);
  }
  public function assign_role_module_store(Request $request)
  {
      $this->validate(
          $request,
          [
              'role_id' => 'required|exists:roles,id',
          ],
          [
              'role_id.required' => 'Role name is required.',
              'role_id.exists' => 'Role name does not exists.',
          ]
      );

      $check = true;
      $all_routes = $this->fullRouteNames();
       $permissions = $request->input('permissions');

      if (empty($permissions)) {
          $role_array = [
              'permissions' => NULL,
          ];
      } else {
            $check = $this->checkPermissionArray($all_routes, $permissions);
          $role_array = [
              'permissions' => json_encode($permissions),
          ];
      }



      if ($check) {
          $id = $request->input('role_id');
           $replicate = Role::find($id);
         $role = $replicate->replicate();
          $role->deleted_by = $request->auth->id ?? 0;
          $role->push();
          $role->delete();

          $role = Role::where('id', $id);


            $permission_array = $this->modular_permission($role, $role_array['permissions']);


          $role->update($permission_array);

          if (!empty($role)) {
              return response()->json($role, 200);
          }

          return response()->json(['error' => 'Update Failed.'], 400);
      }

      return response()->json(['error' => 'Invalid permissions.'], 400);
  }

  public function assign_special_permission_store(Request $request)
    {
        $this->validate(
            $request,
            [
                'user_id' => 'required|exists:users,id',
            ],
            [
                'user_id.required' => 'user name is required.',
                'user_id.exists' => 'user name does not exists.',
            ]
        );

        $check = true;
        $all_routes = $this->fullRouteNames();

        $user_id = $request->input('user_id');
        $permissions = $request->input('permissions');


        $role_array = [
            'permissions' => json_encode($permissions),
        ];
        if (empty($permissions)) {
            $role_array = [
                'permissions' => NULL,
            ];
        } else {
            $check = $this->checkPermissionArray($all_routes, $permissions);
        }

        /**
         *   TASKS
         *   =====
         *   check all of item in  $request->input('permissions')  in getAllRouteNameAsArray()
         */

        if ($check) {
            $user = User::where('id', $user_id);

            $permission_array = $this->modular_permission($user,  $role_array['permissions']);

            $user->update($permission_array);

            if (!empty($user)) {
                return response()->json($user, 200);
            }
            return response()->json(['error' => 'Update Failed.'], 400);
        }
        return response()->json(['error' => 'Invalid permissions.'], 400);
    }


  public function get_permissions()
  {
      try {
          $routes = $this->getAllRouteNameAsArray();
          foreach ($routes as $key => $route) {
              $explode = explode(".", $route);
              if (isset($explode[1]) && !empty($explode[1]))
                  if (isset($explode[2]) && !empty($explode[2])) {
                      $data[$explode[0]][] = $explode[1] . '.' . $explode[2];
                  } else {
                      $data[$explode[0]][] = $explode[1];
                  }
          }
          if (!empty($data)) {
              return response()->json($data, 200);
          }
      } catch (\Exception $exception) {
          Log::alert($exception);
      }

      return response()->json(NULL, 404);
  }

 public function getAllRouteNameAsArray()
    {

    $routes = Route::getRoutes();

    $routeNames = collect($routes)->map(function ($route) {
        return $route->getName();
    })->filter()->toArray();

   return $routeNames;
   }

   public function checkPermissionArray($routes_array, $permissions_array )
   {
       $count = count($permissions_array);
       foreach ($permissions_array as $key => $value) {
           if (in_array($value, $routes_array)) {
               $count = ($count - 1);
           }
       }
       return ($count == 0) ? true : false;
   }
   private function fullRouteNames(): array
   {
       $data = [];
       $routes = $this->getAllRouteNameAsArray();
       foreach ($routes as $key => $route) {
           $explode = explode(".", $route);
           if (isset($explode[1]) && !empty($explode[1]))
               if (isset($explode[2]) && !empty($explode[2])) {
                   $data[] = $explode[0] . '.' . $explode[1] . '.' . $explode[2];
               } else {
                   $data[] = $explode[0] . '.' . $explode[1];
               }
       }

       return $data;
   }

   private function modular_permission($model,  $new_permission_array = null): array
   {
        $old_permissions = json_decode($model->value('permissions'));
       $non_module_permissions = [];

       if ($old_permissions) {
           foreach ($old_permissions as $key => $old_permission) {
               $permission_modules = explode('.', $old_permission);

               if ($permission_modules[0] != 'cdc' && $permission_modules[0] != 'rrc' && $permission_modules[0] != 'yec' && $permission_modules[0] != 'setting' && $permission_modules[0] != 'event' && $permission_modules[0] != 'slider' && $permission_modules[0] != 'news_activities') {
                   array_push($non_module_permissions, $old_permission);
               }
           }
       }


       if (!empty($non_module_permissions)) {
           if ($new_permission_array) {
               $permission_arrays = array_merge(json_decode($new_permission_array), $non_module_permissions);

               $permission_array = [
                   'permissions' => json_encode($permission_arrays)
               ];
           } else {
               $permission_array = [
                   'permissions' => json_encode($non_module_permissions)
               ];
           }
       } else {
           $permission_array = [
               'permissions' => $new_permission_array
           ];
       }


       return $permission_array;
   }



}
