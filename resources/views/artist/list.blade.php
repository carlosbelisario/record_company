@extends('layouts.master')

@section('title', 'Page Title')

@section('header')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <h2>Artist</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        @foreach ($artists as $artist)
        <tbody>
            <tr>
                <th>{{ $artist->name }}</th>
                <th>
                    <a href="#">edit</a>
                    <a href="#">delete</a>
                </th>
            </tr>
        </thead>
        @endforeach
    </table>
@endsection