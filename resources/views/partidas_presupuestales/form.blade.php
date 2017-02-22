<div class="form-group @if($errors->first('partida_presupuestal')) has-error @endif">
    {!! Form::label('partida_presupuestal', 'Partida Presupuestal') !!}
    {!! Form::text('partida_presupuestal', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('partida_presupuestal') }}</small>
</div>

<div class="form-group @if($errors->first('concepto')) has-error @endif">
    {!! Form::label('concepto', 'Concepto') !!}
    {!! Form::text('concepto', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('concepto') }}</small>
</div>


<button type="submit" class="btn btn-primary">{{$submitButtonText}}</button>