@extends('layouts.master')

@section('title', 'Compañia Disquera')


@section('content')
    <h2>Álbum</h2>
    <div class="alert" ng-show="flash.get().length">
        <uib-alert type="success" close="closeAlert($index)">[[flash.get()]]</uib-alert>
    </div>
    <div ng-view></div>
@endsection