<?php

it('serves the home page in French without a prefix', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('<html lang="fr"', false)
        ->assertSee('Un seul groupe,')
        ->assertSee('hreflang="en" href="'.url('/en').'"', false);
});

it('serves the home page in English under /en', function () {
    $this->get('/en')
        ->assertOk()
        ->assertSee('<html lang="en"', false)
        ->assertSee('One group,')
        ->assertSee('hreflang="fr" href="'.url('/').'"', false);
});

it('formats prices for each locale', function (string $url, string $price) {
    $this->get($url)->assertOk()->assertSee($price);
})->with([
    'french' => ['/', "9\u{202F}999"],
    'english' => ['/en', '9,999'],
]);

it('lists all seven directions', function () {
    $response = $this->get('/');

    foreach (['TOOAUTO PRO', 'TOOAUTO SERVICES', 'TOOAUTO FORMATION', 'TOOAUTO PIÈCES', 'TOOAUTO MÉDIA', 'TOOAUTO TECHNOLOGIES'] as $direction) {
        $response->assertSee($direction);
    }
});

it('shows a coming soon state while store links are not configured', function () {
    config(['site.stores.google_play' => null, 'site.stores.app_store' => null]);

    $this->get('/')->assertSee('Bientôt disponible');
});
