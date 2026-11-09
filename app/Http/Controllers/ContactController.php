<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMessage;
use App\Support\Localized;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Forward a contact request to the TOOAUTO GROUP inbox.
     */
    public function store(ContactRequest $request): RedirectResponse
    {
        /** @var array{name: string, phone: string, email: string, profile: string, message: string} $details */
        $details = $request->safe()->only(['name', 'phone', 'email', 'profile', 'message']);

        Mail::to(config('site.contact.email'))->send(new ContactMessage($details, app()->getLocale()));

        return redirect()
            ->to(Localized::route('home').'#contact')
            ->with('contact_sent', true);
    }
}
