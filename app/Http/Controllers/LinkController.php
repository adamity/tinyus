<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Link;
use Carbon\Carbon;

class LinkController extends Controller
{
    // Next task : 
    // - Task Scheduling : Delete unused link after 30 days starting form updated date
    public function encoder(Request $request)
    {
        // Request original URL from form
        $this->validate($request, ['origin_link' => 'required']);
        $origin_link = $request->input('origin_link');

        // Remove all illegal characters from a URL
        $origin_link = filter_var($origin_link, FILTER_SANITIZE_URL);
        // Validate URL
        if(filter_var($origin_link,FILTER_VALIDATE_URL)!==false)
        {
            // Store valid URL into database & get the ID
            $link = new Link;
            $link->origin_link = $origin_link;
            $link->save();
            $id = $link->id;

            // Convert the ID(base 10) into hash(base 62) form & store into database
            $map = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $hash = '';
            do {
                $hash = $map[$id % 62].$hash;
                $id = intval($id / 62);
            } while($id);
            $link->hash = $hash;
            $link->save();

            // Return URL_base(tinyus.test/)+base62 into web page
            $shorten_link = 'tinyus.test/'.$hash;
            return view('page.index')->with('shorten_link',$shorten_link);
        }
        else
        {
            return redirect('/')->with('error','Unable to shorten that link. It is not a valid url.');
        }
    }

    public function decoder($hash)
    {
        // Search the hash(base 62) in the database that match with base 62 from tinyurl
        $link = Link::where('hash', '=', $hash)->first();
        if($link != null)
        {
            // Update updated_at & expired_at attribute
            $updated = Carbon::now()->toDateTimeString();
            $expired = date('Y-m-d', strtotime($updated. ' +30 days'));
            $link->updated_at = $updated;
            $link->expired_at = $expired;
            $link->save();

            // Get the original URL & redirect to the original URL page
            $origin_link = $link->origin_link;
            return redirect()->to($origin_link);
        }
        else
        {
            // If hash not found, throw error message
            return redirect('/')->with('error','This is a 404 error, which means you have clicked on a bad link or entered an invalid URL.');
        }
    }
}
