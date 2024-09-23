<?php

namespace App\Http\Controllers\Usermanagement;

use Illuminate\Http\Request;
//use App\DataTables\Logs\AuditLogsDataTable;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\File;
use Image;

use DataTables;
use DB;

class UserController extends Controller
{

    private function imageUpload($request, $id)
    {
        // Ensure the request has a file
        if (!$request->hasFile('avatar')) {
            return response()->json(['error' => 'No image file found in the request.'], 400);
        }

        $image = $request->file('avatar');

        // Ensure the file is valid
        if (!$image->isValid()) {
            return response()->json(['error' => 'Uploaded image is not valid.'], 400);
        }

        $extension = $image->getClientOriginalExtension();
        $name = $id . '_image.' . $extension;

        $mainPath = public_path('assets/avatar/');
        $path199x112 = public_path('assets/avatar/199x112/');
        $path550x313 = public_path('assets/avatar/550x313/');

        // Ensure directories exist
        $directories = [$mainPath, $path199x112, $path550x313];

        foreach ($directories as $directory) {
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }
        }

        // Save the main image
        Image::make($image)->save($mainPath . $name);

        // Resize and save images
        $mainImage = $mainPath . $name;

        $img199x112 = Image::make($mainImage)->resize(199, 112, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img199x112->save($path199x112 . $name);

        $img550x313 = Image::make($mainImage)->resize(550, 313, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img550x313->save($path550x313 . $name);

        return $name;
    }




  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function bulkdelete(Request $request){
    if (isset($request->list) && $request->list != '') {
      $list = explode(',', $request->list);

      User::whereIn('id', $list)->delete();
    }
  }


  public function datatableapi(Request $request)
  {

    // print_test($request->role_filter);
    $model = User::query();
    if (isset($request->role_filter) && $request->role_filter != '') {
      $model->whereRelation('roles', 'name',  $request->role_filter);
    }
    if (isset($request->email_verify) && $request->email_verify != '') {
      if ($request->email_verify == 'Verifyed') {
        $model->whereNotNull('email_verified_at');
      } else {
        $model->whereNull('email_verified_at');
      }
    }



    return DataTables::of($model)
      ->setRowId(function ($user) {
        return $user->id;
      })
      // ->setRowClass(function ($user) {
      //     return $user->id % 2 == 0 ? 'alert-success' : 'alert-warning';
      // })
      // ->setRowAttr([
      //   'align' => 'center',
      // ])
      ->setRowData([
        'data-id' => function (User $user) {
          return 'row-' . $user->id;
        },
        'data-first_name' => function ($user) {
          return 'row-' . $user->first_name;
        },
      ])
      ->addColumn('role', function (User $user) {

        $roles = '';
        foreach ($user->roles as $role) {
          $roles .= '<div class="badge badge-light-success fw-bolder">' . $role->name . '</div>';
        }
        return $roles;
      })
      ->editColumn('created_at', function (User $user) {
        return $user->created_at->isoFormat('MMM Do YY');
      })

      ->editColumn('updated_at', function (User $user) {
        return $user->updated_at->diffForHumans();
      })
      ->addColumn('checkbox',  function ($row) {
        return ' <div class="form-check form-check-sm form-check-custom form-check-solid">
    <input class="form-check-input" type="checkbox" value="' . $row->id . '" />
  </div>';
      })
      ->addColumn('two_step',  function ($row) {
        if ($row->email_verified_at != null) {
          return '<div class="badge badge-light-success fw-bolder">Verified</div>';
        } else {
          return '<div class="badge badge-light-warning fw-bolder">Non-verified</div>';
        }
      })
      ->editColumn('action', function ($row) {

        return view('pages.user-management.users.action', ['row' => $row]);
      })
      ->editColumn('first_name', function ($row) {

        return view('pages.user-management.users.name', ['row' => $row]);
      })

      ->rawColumns(['checkbox', 'action', 'two_step', 'role'])
      ->make(true);
  }

  public function index()
  {

    $roles = Role::get();

    return view('pages.user-management.users.dtlist', ['roles' => $roles]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   *
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $user = User::find($id);
    $user->delete();
    return redirect()->back();
  }

  public function store(User $user, Request $request)
  {
    // dd($request->hasFile('avatar'));
    //print_r($request->all());

    $user = new User();
    $user->password = Hash::make($request->password);
    $user->email = $request->email;
    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;

    $user->save();

    //  $user->update(['image'=>'asdtyest']);
    $user->syncRoles($request->get('role'));

    if ($request->hasFile('avatar')) {
      $image = $this->imageupload($request, $user->id);
      $u = User::find($user->id);
      $u->image = $image;
      $u->save();
    }

    //  $role = Role::create(['name' => $request->get('name')]);
    // $role->syncPermissions($request->get('permission'));
    //  Permission::create($request->only('name'));
    return redirect()->back();
  }

  public function update(Request $request, $id)
  {
    // dd($request->all());
    $user = User::find($id);
    $user->email = $request->email;
    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;


    if ($request->password != null){
         $user->password = Hash::make($request->password);
    }

    $user->save();
    //  $user->update(['image'=>'asdtyest']);
    $user->syncRoles($request->get('role'));

    if ($request->hasFile('avatar')) {
      $image = $this->imageupload($request, $user->id);
      $u = User::find($id);
      $u->image = $image;
      $u->save();
    }


    return redirect()->back();
  }

  public function view(Request $request, $id)
  {
    $data['role'] = Role::find($id);
    $data['rolePermissions'] = $data['role']->permissions->pluck('name')->toArray();
    $data['permissions'] = Permission::orderBy('name')->get();

    return view('pages.user-management.roles.view', ['data' => $data]);
  }

  public function edit(Request $request, $id)
  {
    $role = Role::find($id);
    $role->name = $request->get('name');
    $role->save();
    $role->syncPermissions($request->get('permission'));

    //  Permission::create($request->only('name'));
    return redirect()->back();
  }

  public function show($id)
  {
    $user = User::find($id);
    $roleslist = Role::get();
    $roles = $user->roles->pluck('name')->toArray();
    return view('pages.user-management.users.view', ['user' => $user, 'roles' => $roles, 'roleslist' => $roleslist]);
  }
}
