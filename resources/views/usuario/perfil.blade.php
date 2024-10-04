@extends('usuario.layouts.perfil')

@section('titulo','Mi perfil')

@section('header')
    <h2>MI PERFIL</h2>
@endsection

@section('contenido')
    <form method="POST" id="form_guardar_datos_persona">
        @csrf
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="input_nombres" class="form-label">Nombres*</label>
                    <input type="text" class="form-control" id="input_nombres" name="input_nombres" placeholder="Nombres" value="{{ $persona->nombres ?? '' }}">
                    <span class="nsb-error" id="span_input_nombres_error"></span>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="input_apellidos" class="form-label">Apellidos*</label>
                    <input type="text" class="form-control" id="input_apellidos" name="input_apellidos" placeholder="Apellidos" value="{{ $persona->apellidos ?? '' }}">
                    <span class="nsb-error" id="span_input_apellidos_error"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label for="input_direccion" class="form-label">Dirección*</label>
                    <input type="text" class="form-control" id="input_direccion" name="input_direccion" placeholder="Dirección" value="{{ $persona->direccion ?? '' }}">
                    <span class="nsb-error" id="span_input_direccion_error"></span>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label for="input_celular" class="form-label">Celular*</label>
                    <div class="input-group">
                        <span class="input-group-text">+57</span>
                        <input type="text" class="form-control" id="input_celular" data-type="number" name="input_celular" placeholder="Celular" value="{{ $persona->celular ?? '' }}">
                    </div>
                    <span class="nsb-error" id="span_input_celular_error"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label for="select_departamento" class="form-label">Departamento*</label>
                    <select id="select_departamento" class="form-select" name="select_departamento">
                        <option value="">Selecciona el Departamento</option>
                        @foreach($departamentos as $departamento)
                            <option value="{{ $departamento->id }}"
                                    @if(isset($persona) && $persona->id_departamento == $departamento->id)
                                        selected
                                @endif
                            >
                                {{ $departamento->departamento }}
                            </option>
                        @endforeach
                    </select>
                    <span class="nsb-error" id="span_select_departamento_error"></span>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label for="select_municipio" class="form-label">Municipio*</label>
                    <select id="select_municipio" class="form-select" name="select_municipio" @if (isset($persona)) data-municipio-seleccionado="{{ $persona->id_municipio }}" @endif>
                        <option value="">Selecciona el Municipio</option>
                    </select>
                    <span class="nsb-error" id="span_select_municipio_error"></span>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-3 col-12">
                <div class="mb-3">
                    <label for="input_codigo_postal" class="form-label">Código Postal*</label>
                    <input type="text" class="form-control" id="input_codigo_postal" data-type="number" name="input_codigo_postal" placeholder="Código Postal" value="{{ $persona->codigo_postal ?? '' }}">
                </div>
                <span class="nsb-error" id="span_input_codigo_postal_error" ></span>
            </div>
            <div class="col-md col-12">
                <div class="mb-3">
                    <label for="input_referencias" class="form-label">Referencias</label>
                    <input type="text" class="form-control" id="input_referencias" name="input_referencias" placeholder="Apartamento, suite, unidad, piso, etc. (opcional)" value="{{ $persona->referencias ?? '' }}">
                </div>
                <span class="nsb-error" id="span_input_referencias_error"></span>
            </div>
        </div>
        <div class="text-center my-3">
            <button type="button" id="button_guardar" class="btn nsb-btn nsb-btn-guardar-datos-persona">GUARDAR</button>
        </div>

    </form>
    <script src="{{asset('js/usuario/perfil.js')}}"></script>
@endsection
