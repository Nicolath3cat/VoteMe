{{-- simple mail laravel  --}}
@extends('layouts.mail')


@section('title')
<style type="text/css">
.im {
color: #000000 !important;
}
</style>
@endsection
@section('body')
    Ciao!<br>
    Questa mail ti guiderà nella fase di votazione.
    <br>
    Codice voto in proprio: <input type="text" value={{ $codiceProprio }} readonly>
    <br>
    @if(count($codiciDelega))
        Codice voti in delega:
        @foreach($codiciDelega as $Codice)
            <input type="text" value={{ $Codice }} readonly>
        @endforeach
    @endif
    <br>
    Ogni codice equivale ad un voto, può essere usato una volta sola, che si voglia esprimere un voto valido, nullo o un'astensione.
    Votare è semplice:
    <ol>
        <li>Entra in <a href="{{ env("APP_URL") }}"> questo sito  </a></li>
        <li> Scegli le opzioni che preferisci </li>
        <li> Premi il pulsante "Vota" </li>
        <li> Inserisci il codice di voto</li>
    </ol>
    <br>
    Se possiedi dei voti in delega questa procedura deve essere eseguita per ogni codice di voto a te assegnato.
    Ricorda che il voto è segreto, in nessun modo saremo in grado di associare il codice di voto alle preferenze epresse.
    Al fine di garantire la completa anonimità del voto, è importante che per l'astensione si utilizzi comunque il proprio codice di voto, esprimento 0 preferenze nella fase di scelta.

@endsection


