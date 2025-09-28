@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Panel de Control')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Bienvenido</h3>
        </div>
        <div class="card-body">
            Miau miau
        </div>
    </div>
@endsection

@push('js')
    <script>
        console.log('Scripts adicionales aquí');
    </script>
@endpush
