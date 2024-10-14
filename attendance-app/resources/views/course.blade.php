@extends('canvas')
@section('title','Courses')
@section('titleh1','Tous les cours')

@section('content')
    <table>
        <thead>
            <tr>
                <th>Label</th>
                <th>Group</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
                <tr>
                    <td>{{ $course['label'] }}</td>
                    <td>{{ $course['group_id'] }}</td>
                    <td>
                        <a href="{{ route('presence.index', ['courseId' => $course['id']]) }}">
                            Voir la présence
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
