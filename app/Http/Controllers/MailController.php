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
            $m->from(env('MAIL_USERNAME'), 'MSPVN Portal');            
            $m->to('danglebaokhanh.msp@outlook.com');
            $m->to('v-tribt@microsoft.com');
            $m->cc('viethung.msp@outlook.com');
            $m->cc('minhduc.msp@outlook.com');            
            $Date = date("Y-m-d");
            $Content = "[DreamSpark Web][".$Date."] ".$Count." students => WAITING for Code'";
            $m->subject($Content);
        });       
    }

    public function sendReject($ID)
    {
        if ($ID != 'MinhDucDepTrai') 
            return redirect('https://msp-vietnam.azurewebsites.net')->send();

        $Azure = new CustomAzure();
        $Query = "Status eq 'Reject Link' or Status eq 'Reject'";
        $Result = $Azure->queryEntities(env('AZURE_MAIN_TABLE'), $Query);  

        foreach ($Result as $Element) {
            Mail::send('EMAILS.Reject', ['Data' => $Element], function ($m) use ($Element){
                $m->from(env('MAIL_USERNAME'), 'MSPVN Portal');
                $m->replyTo('danglebaokhanh.msp@outlook.com', 'Mr. Bao Khanh');
                $m->to($Element['Email'], $Element['Fullname']);                
                $Date = date("Y-m-d");
                $Content = "[MSPVN Portal][DreamSpark Code][".$Date."] Invalid information";
                $m->subject($Content);
            });       

            if ($Element['Status'] == 'Reject')
            {
                $result = $Azure->tableClient->getEntity(env('AZURE_MAIN_TABLE'), "Students", $Element['RowKey']);
                $entity = $result->getEntity();
                $entity->setPropertyValue('Status', "Sent Reject");
                $Azure->tableClient->updateEntity(env('AZURE_MAIN_TABLE'), $entity);
            }
        }        
    }
}
