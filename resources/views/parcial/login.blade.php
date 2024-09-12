<main class="container">
    <div class="row justify-content-center my-5">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Regístrate / Iniciar sesión</h3>
                    <form method="post" action="/rginsc" id="form_rginsc">
                        @csrf
                        <label for="input_correo">Correo electrónico:</label>
                        <input type="text" class="form-control mb-3" id="input_correo" name="input_correo">
                        <label for="input_clave">Contraseña:</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="input_clave" name="input_clave">
                            <span class="input-group-text btn btn-light" id="span_ver_clave" title="Mostrar Contraseña"><i
                                    class="fas fa-eye"></i></span>
                        </div>
                        <div>
                            <small>
                                <a href="/recuperar_cuenta">¿Contraseña olvidada?</a>
                            </small>
                        </div>
                        <div class="text-center mt-3">
                            <span id="span_error" style="color:red;text-align:center">
                            </span>
                        </div>
                        <button type="submit" class="btn nsb-btn nsb-btn-primario mt-4" id="button_continuar"
                                style="width:100%">CONTINUAR
                        </button>
                    </form>
                    <hr>
                    {{--                    <button type="button" class="btn nsb-btn my-4" style="width: 100%;border:1px solid #e2e2e2"><i--}}
                    {{--                            class="fab fa-google"></i> Continuar con Google--}}
                    {{--                    </button>--}}
                </div>
            </div>
        </div>
    </div>
</main>
