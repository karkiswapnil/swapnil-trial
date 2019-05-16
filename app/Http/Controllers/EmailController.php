<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect,Response,DB,Config;
use App\Mail\MailNotify;
use App\User;
use Mail;

class EmailController extends Controller
{
    public function send(Request $request){

        $user = auth()->user();
        $to=$request->input('to');
        $subject = $request->input('subject');
        Mail::to($to)->send(new MailNotify($subject));
        
        return 'Email was sent';
        
    }
    public function notify(Request $request){

        //List ID from .env
        $listId = env('MAILCHIMP_LIST_ID');

        //Mailchimp instantiation with Key
        $mailchimp = new \Mailchimp(env('MAILCHIMP_KEY'));

        //Create a Campaign $mailchimp->campaigns->create($type, $options, $content)
        $campaign = $mailchimp->campaigns->create('regular', [
            'list_id' => $listId,
            'subject' => 'New Article from Scotch',
            'from_email' => 'pub@gmail.com',
            'from_name' => 'Scotch Pub',
            'to_name' => 'Scotch Subscriber'

        ], [
            'html' => $request->input('content'),
            'text' => strip_tags($request->input('content'))
        ]);

        //Send campaign
        $mailchimp->campaigns->send($campaign['id']);

        return response()->json(['status' => 'Success']);
    }
}
