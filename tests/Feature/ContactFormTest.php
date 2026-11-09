<?php

use App\Mail\ContactMessage;
use Illuminate\Support\Facades\Mail;

function validContactPayload(array $overrides = []): array
{
    return array_merge([
        'name' => 'Awa Koné',
        'phone' => '+225 07 00 00 00 00',
        'email' => 'awa@example.com',
        'profile' => 'organisation',
        'message' => 'Nous souhaitons équiper notre flotte de 40 véhicules.',
    ], $overrides);
}

it('sends the message to the company inbox and confirms', function () {
    Mail::fake();

    $this->post('/contact', validContactPayload())
        ->assertRedirect(url('/').'#contact')
        ->assertSessionHas('contact_sent', true);

    Mail::assertSent(ContactMessage::class, function (ContactMessage $mail): bool {
        return $mail->hasTo(config('site.contact.email'))
            && $mail->hasReplyTo('awa@example.com')
            && $mail->details['profile'] === 'organisation';
    });

    $this->get('/')->assertSee('Merci, votre message est bien parti.');
});

it('redirects English visitors back to the English page', function () {
    Mail::fake();

    $this->post('/en/contact', validContactPayload())->assertRedirect(url('/en').'#contact');
});

it('rejects invalid submissions', function (array $overrides, string $field) {
    Mail::fake();

    $this->from('/')
        ->post('/contact', validContactPayload($overrides))
        ->assertSessionHasErrors($field);

    Mail::assertNothingSent();
})->with([
    'missing name' => [['name' => ''], 'name'],
    'invalid email' => [['email' => 'not-an-email'], 'email'],
    'invalid phone' => [['phone' => 'abc'], 'phone'],
    'unknown profile' => [['profile' => 'hacker'], 'profile'],
    'short message' => [['message' => 'Salut'], 'message'],
]);

it('silently blocks bots that fill the honeypot', function () {
    Mail::fake();

    $this->from('/')
        ->post('/contact', validContactPayload(['website' => 'http://spam.test']))
        ->assertSessionHasErrors('website');

    Mail::assertNothingSent();
});

it('renders the email in French with the visitor details', function () {
    $mail = new ContactMessage(validContactPayload(), 'en');

    $mail->assertSeeInText('Awa Koné');
    $mail->assertSeeInText('Entreprise ou institution');
    $mail->assertSeeInText('(EN)');
});
