<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Mail;
use App\Classes\CustomAzure;

class MailController extends Controller
{
    //
    public function sendInProgress($ID)
    {
    	if ($ID != 'MinhDucDepTrai') 
    		return redirect('https://msp-vietnam.azurewebsites.net')->send();

    	$Azure = new CustomAzure();
    	$Query = "Status eq 'In Progress'";
    	$Result = $Azure->queryEntities(env('AZURE_MAIN_TABLE'), $Query);
    	$Count = count($Result);

    	Mail::send('EMAILS.InProgress', ['Data' => $Result], function ($m) use ($Count) {
            $m->from(env('MAIL_USERNAME'), 'MSPVN Auto Sender');
            $m->to('danglebaokhanh.msp@outlook.com');
            $m->to('v-tribt@microsoft.com');
            $m->cc('viethung.msp@outlook.com');
            $m->cc('minhduc.msp@outlook.com');
            $m->cc(env('MAIL_USERNAME'));
            $Date = date("Y-m-d");
            $Content = "[DreamSpark Web][".$Date."] ".$Count." students are WAITING for Code'";
            $m->subject($Content);
        });       
    }

    public function sendReject()
    {

    }
}
