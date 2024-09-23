<?php

namespace App\Http\Controllers\MailBox;

use App\Models\ImporData;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class MailBoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     function __construct(){
        $mailbox = "{mail.apoconsole.com:993/imap/ssl/novalidate-cert}INBOX";
            $username = 'system@apoconsole.com';
            $password = 'system@apoconsole.com';
        $this->inbox = imap_open($mailbox, $username, $password) or die('Cannot connect to email: ' . imap_last_error());
    }
    public function index(Request $request)
    {
        if (isset($request->ajax)){
            
            
            if (isset($request->inbox)){
                
                $emails = imap_search($this->inbox, 'ALL');
                    
                rsort($emails);
                
                $data=[];
                
                foreach($emails as $n => $msg_number) 
                 {
                   $header = imap_headerinfo($this->inbox, $msg_number);
                   $data[]=[
                       'id' => $msg_number, 
                        'date' => $header->date,
                        'subject' => (strlen($header->subject) > 30)? substr($header->subject,0,30).'...': $header->subject,
                        'fromaddress' => ($header->from[0]->mailbox ?? '')."@".($header->from[0]->host ?? ''),
                        'personal' => ($header->from[0]->personal ?? '')
                       ];
                    //  if ($msg_number == 2) dd($header);
                 }
                
                return response()->json($data);
            }
            
            return response()->json([]);
        }
        
    return view('pages.mailbox.index');
    }
    
    public function mailboxdata(Request $request){
        $msg_number = $request->msg_id;
        $header = imap_headerinfo($this->inbox, $msg_number);
        $data=[
                       'id' => $msg_number, 
                        'date' => $header->date,
                        'subject' => (strlen($header->subject) > 30)? substr($header->subject,0,30).'...': $header->subject,
                        'fromaddress' => ($header->from[0]->mailbox ?? '')."@".($header->from[0]->host ?? ''),
                        'personal' => ($header->from[0]->personal ?? ''),
                        'raw' => imap_body($this->inbox, $msg_number),
                        'body' => imap_fetchbody($this->inbox, $msg_number, 1)
                       ];
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function show(cr $cr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function edit(cr $cr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cr $cr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function destroy(cr $cr)
    {
        //
    }

    
}
