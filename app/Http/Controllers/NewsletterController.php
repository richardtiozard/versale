<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsletter;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request...
        $this->validate($request, [
            'newsletter.email' => 'required|email:rfc,dns'
        ]);

        $newsletter = new Newsletter;
        $newsletter->email = $request->newsletter["email"];
        $newsletter->save();

        return $newsletter;
    }

}
