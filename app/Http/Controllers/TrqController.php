<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Orderrrc;
use App\Models\Setting;
use DataTables;
use Carbon\Carbon;
use DB;

include app_path('Http/Controllers/TrqTrait.php');

use trqVendor;



class TrqController extends Controller
{


    public function trq_get_token()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://trqui.b2clogin.com/trqui.onmicrosoft.com/B2C_1_ROPC_Auth/oauth2/v2.0/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            "grant_type=password&client_id=23c5476a-4276-4d30-baf0-4d21b06b4a05&scope=openid  offline_access https://trqui.onmicrosoft.com/1655a760-49d5-410d-8dca-4b9015d2b649/access.full&username=autooutlet@login.trqautoparts.com&password=kO44^j1vY52Ojvpd&response_type=token id_token");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded'
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }



    public function trq_get_orders($token)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api1.trqautoparts.com/api/v3/orders?size=100');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'authorization: Bearer '.$token,
            'ocp-apim-subscription-key: 2799e2449a7549c69eaab21fffec451f'
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }






    public function index()
    {
      $users = array();

    //   $t = new trqVendor();
    //   dd($t);


      return view('pages.vendors.trq',['users'=>$users]);
    }


    public function trq_tracking()
    {
            $dir = '/home/apoconsole/app.apoconsole.com/cron/Tracking/';
                foreach(glob($dir.'*.csv') as $v){
                    unlink($v);
                }


                $files = scandir("/home/apoconsole/apoconsole.com/trqinventoryfeed/Tracking");
                // dd($files);
                $mostRecent = array(
                    'time' => 0,
                    'file' => null
                );


                foreach ($files as $file) {
                    // get the last modified time for the file
                    if (!is_dir("/home/apoconsole/apoconsole.com/trqinventoryfeed/Tracking/".$file)){
                        $time = filemtime("/home/apoconsole/apoconsole.com/trqinventoryfeed/Tracking/".$file);


                        if ($time > $mostRecent['time']) {
                            // this file is the most recent so far
                            $mostRecent['time'] = $time;
                            $mostRecent['file'] = $file;
                        }
                    }
                }


                if ($mostRecent['file']){

                            $sourceFileTracking = "/home/apoconsole/apoconsole.com/trqinventoryfeed/Tracking/" . $mostRecent['file'];
                            $destinationFileTracking = "/home/apoconsole/app.apoconsole.com/cron/Tracking/" . $mostRecent['file'];

                            // Copy the file
                            copy($sourceFileTracking, $destinationFileTracking);

                            // Get the original file's modification time
                            $originalFileTimeTracking = filemtime($sourceFileTracking);

                            // Set the modified time of the new file to match the original file
                            touch($destinationFileTracking, $originalFileTimeTracking);

                            // Assign the filename to $trq_file (assuming you want to keep track of it)
                            $trq_file = $mostRecent['file'];
                }
    }

    public function trq_orders(Request $request)
    {


      // dd($request->search['value']);

       if (isset($request->search) && $request->search != ''){
         $search =   $request->search;
       } else {
          $search = NULL;
       }


        $t = new trqVendor();
        $res = json_decode($t->get_orders($request->start/$request->length,$request->length,$search),true);


        $response =[];
        $response['input']=$request->all();
        $response['data']=[];
        $response['draw']=$request->draw;
        $response['recordsFiltered']=0;
        $response['recordsTotal']=0;



        if (isset($res['_embedded']['orders'])){
            foreach($res['_embedded']['orders'] as $order){
                $order['_date'] = explode('T',$order['orderDate'])[0];
                $order['status'] = '<span class="badge badge-light-danger fs-8 fw-bolder">'.$order['status'].'</span>';
                $order['action'] = ' <a href="#"
            onclick="detail(\''.$order['id'].'\')"
            data-bs-toggle="modal" data-bs-target="#kt_modal_detail_coupon"
            class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm me-1">
            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
            <span class="svg-icon svg-icon-3">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="442.04px" height="442.04px" viewBox="0 0 442.04 442.04" style="enable-background:new 0 0 442.04 442.04;"
	 xml:space="preserve">
<g>
	<g>
		<path d="M221.02,341.304c-49.708,0-103.206-19.44-154.71-56.22C27.808,257.59,4.044,230.351,3.051,229.203
			c-4.068-4.697-4.068-11.669,0-16.367c0.993-1.146,24.756-28.387,63.259-55.881c51.505-36.777,105.003-56.219,154.71-56.219
			c49.708,0,103.207,19.441,154.71,56.219c38.502,27.494,62.266,54.734,63.259,55.881c4.068,4.697,4.068,11.669,0,16.367
			c-0.993,1.146-24.756,28.387-63.259,55.881C324.227,321.863,270.729,341.304,221.02,341.304z M29.638,221.021
			c9.61,9.799,27.747,27.03,51.694,44.071c32.83,23.361,83.714,51.212,139.688,51.212s106.859-27.851,139.688-51.212
			c23.944-17.038,42.082-34.271,51.694-44.071c-9.609-9.799-27.747-27.03-51.694-44.071
			c-32.829-23.362-83.714-51.212-139.688-51.212s-106.858,27.85-139.688,51.212C57.388,193.988,39.25,211.219,29.638,221.021z"/>
	</g>
	<g>
		<path d="M221.02,298.521c-42.734,0-77.5-34.767-77.5-77.5c0-42.733,34.766-77.5,77.5-77.5c18.794,0,36.924,6.814,51.048,19.188
			c5.193,4.549,5.715,12.446,1.166,17.639c-4.549,5.193-12.447,5.714-17.639,1.166c-9.564-8.379-21.844-12.993-34.576-12.993
			c-28.949,0-52.5,23.552-52.5,52.5s23.551,52.5,52.5,52.5c28.95,0,52.5-23.552,52.5-52.5c0-6.903,5.597-12.5,12.5-12.5
			s12.5,5.597,12.5,12.5C298.521,263.754,263.754,298.521,221.02,298.521z"/>	</g>	<g>		<path d="M221.02,246.021c-13.785,0-25-11.215-25-25s11.215-25,25-25c13.786,0,25,11.215,25,25S234.806,246.021,221.02,246.021z"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>            </span>        </a>

			<a href="#" class="btn btn-light btn-active-light-danger btn-sm" data-kt-menu-trigger="click"
    data-kt-menu-placement="bottom-end">Actions

    <span class="svg-icon svg-icon-5 m-0">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path
                d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                fill="black" />
        </svg>
    </span>
</a>
			<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-danger fw-bold fs-7 w-125px py-4"
    data-kt-menu="true">
    <div  onclick="rma(\''.$order['id'].'\')" class="menu-item px-3" data-bs-toggle="modal" data-bs-target="#trqrma" >
        <a href="#"  class="menu-link px-3">RMA</a>
    </div>
    <div  onclick="refund(\''.$order['id'].'\')" class="menu-item px-3" data-bs-toggle="modal" data-bs-target="#trqrefund" >
        <a href="#" class="menu-link px-3" >Refund</a>
    </div>
      <div  onclick="cancel(\''.$order['id'].'\')" class="menu-item px-3" data-bs-toggle="modal" data-bs-target="#trqcancel" >
        <a href="#" class="menu-link px-3" >Cancel</a>
    </div>
</div>';

                $response['data'][]=$order;
            }

        }



        if (isset($res['page']['totalElements'])){
            $response['recordsFiltered']=$res['page']['totalElements'];
            $response['recordsTotal']=$res['page']['totalElements'];
        }



         return response()->json($response);





    }


    public function show(Request $request)
    {

        $request->po_number = str_replace('#','%23',$request->po_number);

        $t = new trqVendor();
        $res = $t->get_order($request->po_number);



        if (isset(json_decode($res,true)['items'][0]['trackingNumbers'] ) ){
           return response()->json(['tracking'=>json_decode($res,true)['items'][0]['trackingNumbers']],200);
        } else {
           return response()->json(['tracking'=>''],400);
        }


    }

    public function trqOperation(Request $request)
    {
        $operation = $request->operation;
        // dd($operation);
        $t = new trqVendor();
        $items = [];
        foreach($request->items as $i) {
            $items[] = ['sku' => explode(',', $i)[0], 'quantity' => explode(',', $i)[1]];
        }

        $data = [
            'returnReasonCode' => $request->reason,
            'uniqueId' => $request->uniqueId,
            'items' => $items,
        ];

        $id = $request->id;

        $url = 'https://api1.trqautoparts.com/api/v3/orders/' . $id . '/' . $operation;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'authorization: Bearer ' . $t->token,
            'ocp-apim-subscription-key: 2799e2449a7549c69eaab21fffec451f'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $fieldToUpdate = '';
        switch ($operation) {
            case 'rma':
                $fieldToUpdate = 'rma';
                break;
            case 'replacement':
                $fieldToUpdate = 'replacement';
                break;
            case 'return':
                $fieldToUpdate = 'return';
                break;
            default:
                return response()->json(['error' => 'Invalid operation'], 400);
        }

        Orderrrc::updateOrCreate([
            'order_id' => $id,
        ], [
            $fieldToUpdate => $response,
        ]);

        return $response;
    }




    // public function trqrma(Request $request){

//         $t = new trqVendor();
//         $items = [];
//         foreach($request->items as $i){
//           $items[] = ['sku'=>explode(',',$i)[0],'quantity'=>explode(',',$i)[1]];
//         }

//         $data = array (
//   'returnReasonCode' => $request->reason,
//   'uniqueId' => $request->uniqueId,
//   'items' => $items,
//     );


//         $id = $request->id;



//         $ch = curl_init();
//         curl_setopt($ch, CURLOPT_URL, 'https://api1.trqautoparts.com/api/v3/orders/'.$id.'/rma');
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//         curl_setopt($ch, CURLOPT_POST, 1);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
//         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//             'Content-Type: application/json',
//             'authorization: Bearer '.$t->token,
//             'ocp-apim-subscription-key: 2799e2449a7549c69eaab21fffec451f'
//         ));
//         $response = curl_exec($ch);
//         curl_close($ch);

//         Orderrrc::updateOrCreate([
//     'order_id'   => $id,
// ],[
//     'rma'     =>  $response,
// ]);

//          return $response;




    // }


//     public function trqreplacement(Request $request){
//         $t = new trqVendor();
//         $items = [];
//         foreach($request->items as $i){
//           $items[] = ['sku'=>explode(',',$i)[0],'quantity'=>explode(',',$i)[1]];
//         }

//         $data = array (
//   'returnReasonCode' => $request->reason,
//   'uniqueId' => $request->uniqueId,
//   'items' => $items,
//     );


//         $id = $request->id;



//         $ch = curl_init();
//         curl_setopt($ch, CURLOPT_URL, 'https://api1.trqautoparts.com/api/v3/orders/'.$id.'/replacement');
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//         curl_setopt($ch, CURLOPT_POST, 1);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
//         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//             'Content-Type: application/json',
//             'authorization: Bearer '.$t->token,
//             'ocp-apim-subscription-key: 2799e2449a7549c69eaab21fffec451f'
//         ));
//         $response = curl_exec($ch);
//         curl_close($ch);

//         Orderrrc::updateOrCreate([
//     'order_id'   => $id,
// ],[
//     'replacement'     =>  $response,
// ]);

//          return $response;




//     }


//     public function trqrefund(Request $request){

//          $t = new trqVendor();
//         $items = [];
//         foreach($request->items as $i){
//           $items[] = ['sku'=>explode(',',$i)[0],'quantity'=>explode(',',$i)[1]];
//         }

//         $data = array (
//   'returnReasonCode' => $request->reason,
//   'uniqueId' => $request->uniqueId,
//   'items' => $items,
//     );


//         $id = $request->id;



//         $ch = curl_init();
//         curl_setopt($ch, CURLOPT_URL, 'https://api1.trqautoparts.com/api/v3/orders/'.$id.'/return');
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//         curl_setopt($ch, CURLOPT_POST, 1);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
//         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//             'Content-Type: application/json',
//             'authorization: Bearer '.$t->token,
//             'ocp-apim-subscription-key: 2799e2449a7549c69eaab21fffec451f'
//         ));
//         $response = curl_exec($ch);
//         curl_close($ch);

//         Orderrrc::updateOrCreate([
//     'order_id'   => $id,
// ],[
//     'refund'     =>  $response,
// ]);

//          return $response;



//     }


    public function trqcancel(Request $request){
            $t = new trqVendor();
        $items = [];


        $data = array (
  'returnReasonCode' => $request->reason
    );


        $id = $request->id;



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api1.trqautoparts.com/api/v3/orders/'.$id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'authorization: Bearer '.$t->token,
            'ocp-apim-subscription-key: 2799e2449a7549c69eaab21fffec451f'
        ));
        $response = curl_exec($ch);
        curl_close($ch);

        Orderrrc::updateOrCreate([
    'order_id'   => $id,
],[
    'cancel'     =>  $response,
]);

         return $response;


    }






    public function vendor_check_stock(Request $request){
        $t = new trqVendor();

        $trq =  DB::table('trq')->where('PartNumber', 'like', '%' . $request->sku . '%')->pluck('brand_abbr')->toArray();


        if (isset($trq[0])){
           $brand = $trq[0];
        } else {
          $brand = '';
        }

        $data = '[{"sku": "'.$request->sku.'","brandId": "'.$brand.'"}]';




        $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, 'https://api1.trqautoparts.com/api/v3/parts/stock');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'authorization: Bearer '.$t->token,
            'ocp-apim-subscription-key: 2799e2449a7549c69eaab21fffec451f'
        ));
        $response = curl_exec($ch);
        curl_close($ch);


        return response()->json(['data'=>json_decode($response)],200);


    }



    public function  trq_settings_get(Request $request){
     return view('pages.trq.setting.main');
    }




    public function  trq_settings_save(Request $request){
         $request->validate([
            'trq_email' => 'required',
            'trq_password' => 'required',
             ]);

        \App\Models\Setting::set('trq_email',$request->trq_email);
        \App\Models\Setting::set('trq_password',$request->trq_password);



      return redirect()->back()->with(['success'=>'Setting Saved!']);
    }










}
