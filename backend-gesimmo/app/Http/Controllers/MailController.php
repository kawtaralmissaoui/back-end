<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail()
    {
        $details=[
            'title'=>'Tiltle',
            'body'=>'body',
        ];

        Mail::to("almissaoui.kawtar@gmail.com")->send(new TestMail($details));
        return "envoye";
    }
}
