<?php

namespace App\Http\Controllers\Usermanagement;

use Illuminate\Http\Request;
//use App\DataTables\Logs\AuditLogsDataTable;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Notification;

use Illuminate\Support\Facades\Hash;
use Image;
use Carbon\Carbon;
use DataTables;
use DB;

class UserNotification extends Controller
{


  public function index()
  {
    $notif = Notification::where('user_id',auth()->user()->id)->where('status',0)->orderBy('created_at', 'DESC')->get();
    $notif = array_map(function($a){ $a = (array)$a; $a['time'] = Carbon::parse($a['created_at'])->diffForHumans(); return $a; }, $notif->toArray());

    return response()->json($notif,200);
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
    $notif = Notification::find($id);
    $notif->status = 1;
    $notif->save();
  }


}
