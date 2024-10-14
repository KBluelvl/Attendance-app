@extends('canvas')
@section('title', 'Présences')
@section('titleh1', 'Liste des étudiants')

@section('content')
    <h2>Liste des étudiants</h2>
    <form method="POST" action="{{ route('presence.submit', ['courseId' => $courseId]) }}">
        @csrf
        <input type="hidden" name="courseId" value="{{ $courseId }}"> <!-- Course ID récupéré de l'URL -->

        <table>
            <thead>
                <tr>
                    <th>Matricule</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Présence</th>
                </tr>
            </thead>
            <tbody>
                @foreach($presences as $presence)
                    <tr>
                        <td>{{ $presence['matricule'] }}</td>
                        <td>{{ $presence['name'] }}</td>
                        <td>{{ $presence['surname'] }}</td>
                        <td>
                            <input type="checkbox" name="students[]" value="{{ $presence['matricule'] }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit">Envoyer</button>
    </form>
@endsection
