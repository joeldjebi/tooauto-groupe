Nouveau message reçu depuis le site TOOAUTO GROUP ({{ strtoupper($visitorLocale) }}).

Nom : {{ $details['name'] }}
Téléphone : {{ $details['phone'] }}
E-mail : {{ $details['email'] }}
Profil : {{ __('site.contact.profiles.'.$details['profile'], [], 'fr') }}

Message :
{{ $details['message'] }}
