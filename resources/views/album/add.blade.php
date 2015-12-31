@extends('layouts.master')

@section('title', 'Compañia Disquera')


@section('content')
    <div ng-controller="AlbumCtrl">
        {{ Form::open(array('url' => 'foo/bar')) }}
        {{ Form::model($user, array('route' => array('album.create'))) }}
        {{ Form::close() }}
    </div>
@endsection