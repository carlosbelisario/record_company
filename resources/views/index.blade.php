@extends('layouts.master')

@section('title', 'Compañia Disquera')

@section('header')
    <div class="page-header" style="text-align: center">
        <h1>Compañia Discográfica</h1>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="well well-sm" style="text-align: center;">
                <h3>Albums</h3>
                <br />
                <a href="{{ URL::route('app') }}#/album">
                    <img src="{{ URL::asset('assets/images/album.jpg') }}" style="width:200px; height:200px;" />
                </a>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="well well-sm" style="text-align: center;">
                <h3>Artistas</h3>
                <br />
                <a href="{{ URL::route('app') }}#/artistas">
                    <img src="{{ URL::asset('assets/images/artistas.jpg') }}" style="width:200px; height:200px;" />
                </a>
            </div>
        </div>
    </div>
@endsection