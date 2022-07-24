@component('mail::message')


<h1>Compte créé sur AllDocsOnline</h1>

@component('mail::panel')  
   
    On compte vous a été créé sur la plateforme <strong>AllDocsOnline</strong> : <strong></strong> <br>
    {{$person->username}}
            
@endcomponent


{{-- @component('mail::button', ['url' => route('participants.show.confirm.form',$participant->id), 'color' => 'success'])
    Cliquez ici pour confirmer votre participation 
@endcomponent

@component('mail::button', ['url' => route('participants.show.refused.form',$participant->id), 'color' => 'error'])
    Cliquez ici pour refuser de participer à l'évènement 
@endcomponent --}}

Merci l'équipe, {{ config('app.name') }}
@endcomponent