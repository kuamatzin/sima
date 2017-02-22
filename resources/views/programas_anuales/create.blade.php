@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Crear programa anual</div>
                <div class="panel-body">
                    {!! Form::open(['url' => 'programa_anual']) !!}
                        @include('programas_anuales.form', ['submitButtonText' => 'Crear Programa Anual'])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection