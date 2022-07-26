@component('mail::message')


<h1>Notification de création de compte sur Charnoy</h1>

@component('mail::panel')

    Bonjour , <br>
    Voici vos informations de connexion pour accéder à notre plateforme qui est accessible à tout moment. <br>
    <strong>Adresse e-mail:</strong> {{$email}}<br>
    <strong>Mot de passe:</strong> {{$password}}<br>
    
@endcomponent

@component('mail::button', ['url' => route('login'), 'color' => 'success'])
    Cliquez ici pour vous connectez
@endcomponent


Merci l'équipe, {{ config('app.name') }}
@endcomponent
