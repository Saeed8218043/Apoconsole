<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

class DefaultTemplate extends Mailable
{
    use Queueable, SerializesModels;
    
    
    public $order = '';
   
    public $ccc = '';
    public $subjectt = '';
    
   

    public function __construct($order,$to,$cc,$subject)
    {
        $this->order =  $order;
        
     
        $this->ccc =  $cc;
        $this->subjectt =  $subject;
        
       
    }

    public function build(Request $request)
    {
        
        // $address = 'ranksolumer@gmail.com';
        $address = env('MAIL_FROM_ADDRESS','');
        
        
        

        
        
        
        $subject =  $this->subjectt;
        // $name = 'Jane Doe';
      //  $name = env('APP_NAME','');
        $name = 'genXsupply';

        // $addressto = $request->email;
        
        if ($this->ccc[0] == '' || $this->ccc[1] == ''){
            return $this->view('emails.default')
                    ->from($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                     ->with([ 'order' => $this->order ]);
        }
        
        

        return $this->view('emails.default')
                    ->from($address, $name)
                    ->cc($this->ccc[0], $this->ccc[1])
                    ->bcc($this->ccc[0], $this->ccc[1])
                    ->replyTo($address, $name)
                    ->subject($subject)
                     ->with([ 'order' => $this->order ]);
    }
}

