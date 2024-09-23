<?php

namespace App\Http\Controllers\Usermanagement;

use Illuminate\Http\Request;
//use App\DataTables\Logs\AuditLogsDataTable;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\TransactionSignature;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Image;
use Carbon\Carbon;
use DataTables;
use DB;

class EwalletController extends Controller
{
    
  public $merchant_id = 12976;
  public $merchant_name = 'Test';
  public $security_key = "pay08m0GlxBZYtvA8uXS";
  public $secret_word = 'TES0';



  function __construct()
  {
    $user = User::where('id',get_admin()->id)->first();
     
   $this->merchant_id      =  $user->get_setting('merchant_id','');   
   $this->merchant_name    =  $user->get_setting('merchant_name','');     
   $this->security_key     =  $user->get_setting('security_key','');    
   $this->secret_word      =  $user->get_setting('secret_word','');   
  }



    private function curl_request($url, $data_string)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'application/json; charset=utf-8    '
        ));
        curl_setopt($ch, CURLOPT_USERAGENT, 'WooCommerce-WordPress PayFast Plugin');
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }



   private function payfast_payment_token($totalAmount, $basketId)
   {

        $tokeurl = sprintf(
            "?MERCHANT_ID=%s&SECURED_KEY=%s&TXNAMT=%s&BASKET_ID=%s",
            $this->merchant_id,
            $this->security_key,
            $totalAmount,
            $basketId
        );

        return $this->get_apps_auth_token($tokeurl);
    }

    private function get_apps_auth_token($urlParams)
    {

        $token_url = "https://ipguat.apps.net.pk/Ecommerce/api/Transaction/GetAccessToken" . $urlParams;

        $data = array();
        $jsonpayload = json_encode($data);
        $response = $this->curl_request($token_url, $jsonpayload);
        $response_decode = json_decode($response);

        if (isset($response_decode->ACCESS_TOKEN)) {
            return $response_decode->ACCESS_TOKEN;
        }
        return null;
    }



      private function generateResponseKey($basketid, $txnamt, $errorCode)
    {
        $secretWord = $this->secret_word;
        $merchant_id = $this->merchant_id;
        $recvdHash = sprintf("%s%s%s%s%s", $merchant_id, $basketid, $secretWord, $txnamt, $errorCode);
        return md5( $recvdHash);
    }














  public function index()
  {
    
    return view('pages.user-management.ewallet.main',['merchant_id'=>$this->merchant_id,'merchant_name'=>$this->merchant_name]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   *
   * @return \Illuminate\Http\Response
   */
  // public function destroy($id)
  // {
  //   $notif = Notification::find($id);
  //   $notif->status = 1;
  //   $notif->save();
  // }


  public function store(Request $request)
  {
    $response=[];
    // $token = $this->payfast_payment_token($request->amount,1);

    // if ($token) {
    //   $response['token']=$token;
    //   $response['amount']=$request->amount;
    // }

$order = TransactionSignature::get()->last();
$order =  (int)$order->id + 1;

    $signatureRaw = sprintf(
            "%s:%s:%s:%s",
            $this->merchant_id,
            $this->security_key,
            $request->amount,
            $order
        );


    $signature = hash('sha256', $signatureRaw);

    $order_id = auth()->user()->trans_signature()->create([
             "amount" => $request->amount,
            "trans_type" => "topup_balance",
            "signature" => $signature,
    ]);
 
    $response['signature'] = $signature;

    $response['successUrl'] = url('/')."/e-walletverify?signature=" . $signature . "&order_id=" . $order;

    $response['order_id'] = $order;

    $token = $this->payfast_payment_token($request->amount,$order);

    if ($token) {
      $response['token']=$token;
      $response['amount']=$request->amount;
    }


    return response()->json(['response'=>$response],200);

  }


  public function verify(Request $request){
    

    $basketid = isset($request->basket_id) ? $request->basket_id : '';
   $apps_status_msg = isset($request->err_msg) ? $request->err_msg : '';
   $signature = isset($request->signature) ? $request->signature : '';
   $response_key = isset($request->Response_Key) ? trim($request->Response_Key) : '';
   $apps_statuscode = isset( $request->err_code) ?  $request->err_code : '';




//     $data = json_encode($request->all());
// $order_id = auth()->user()->trans_signature()->create([
//              "amount" => 999,
//             "trans_type" => "topup_balance",
//             "signature" => $data,
//     ]);


     $order = TransactionSignature::where('signature',$signature)->first();

//print_r($order);
       


       $hashKey = $this->generateResponseKey($order->id, $order->amount, $apps_statuscode);
// echo strtolower($hashKey).'<br>';
// echo strtolower($response_key);

// print_r($response_key);
//        dd($hashKey);


       if (isset($order->id) && $response_key != '' && $order->expired == NULL && strcmp(strtolower($hashKey), strtolower($response_key)) === 0) {
          //print_r($order);
          $order->expired = now();
          $order->save();
        $order->user->add_balance($order->amount, 'E-Wallet Topup');
        return redirect()->route('e-wallet.index')->with(['success'=>'Payment Successfully Deposited']);
       } else {
           return redirect()->route('e-wallet.index')->with(['error'=>'Payment Verify Failed']);
       }



  }




}



