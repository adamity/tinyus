<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Link;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class LinkController extends Controller
{
    // Next task : 
    // - Task Scheduling : Delete unused link after 30 days starting form updated date
    public function encoder(Request $request)
    {
        $this->validate($request, ['origin_link' => 'required']);
        $origin_link = $request->input('origin_link');

        // Remove all illegal characters from a URL
        $origin_link = filter_var($origin_link, FILTER_SANITIZE_URL);

        // Validate URL
        if (filter_var($origin_link, FILTER_VALIDATE_URL)) {
            $link = Link::where('origin_link', '=', $origin_link)->first();

            if (!$link) {
                $link = new Link;
                $link->origin_link = $origin_link;
                $link->hash = $this->generate_uuid();
            }

            $link->expired_at = $this->renew_expired();
            $link->save();

            $shorten_link = "tinyus.zulkiflizin.com/$link->hash";
            return view('index')->with('shorten_link', $shorten_link);
        } else {
            return redirect('/')->with('error', 'Unable to shorten that link. It is not a valid url.');
        }
    }

    public function decoder($hash)
    {
        $link = Link::where('hash', '=', $hash)->first();
        if ($link) {
            // Update updated_at & expired_at attribute
            $updated = Carbon::now()->toDateTimeString();
            $link->updated_at = $updated;
            $link->expired_at = $this->renew_expired();
            $link->save();

            // Get the original URL & redirect to the original URL page
            $origin_link = $link->origin_link;
            return redirect()->to($origin_link);
        } else {
            // If hash not found, throw error message
            return redirect('/')->with('error', 'This is a 404 error, which means you have clicked on a bad link or entered an invalid URL.');
        }
    }

    private function generate_uuid()
    {
        $uuid = Uuid::uuid4();
        $short_uuid = substr($uuid->toString(), 0, 8);

        $is_exist = Link::where('hash', '=', $short_uuid)->first();
        if (!$is_exist) return $short_uuid;

        return $this->generate_uuid();
    }

    private function renew_expired()
    {
        $date = Carbon::now()->toDateTimeString();
        $expired = date('Y-m-d', strtotime($date . ' +30 days'));

        return $expired;
    }
}
