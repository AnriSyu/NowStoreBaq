<div id="sidebar_categoria" class="nsb-sidebar-categoria">
    <div class="nsb-sidebar-categoria-titulo">
        <h4 class="text-center">CATEGORÍAS</h4>
    </div>
    <ul class="nav flex-column">
        @foreach($categorias as $categoria)
            @php
                $categoriaSlug = Str::slug($categoria->categoria, '-');
                $href = '';
                if($categoria->categoria !== 'Tendencias'):
                    $href = $categoria->url_externo ?: url('catalogo/' . $categoriaSlug);
                endif;
            @endphp
            @if($categoria->categoria !== "Tendencias")  {{-- Cambia esta línea --}}
            <li class="nav-item nsb-item-sub-categoria" data-subcategoria="{{$categoria->categoria}}">
                <a class="nav-link nsb-item-a-categoria" @if($href!=='') href="{{$href}}" @endif style="cursor:pointer">{{$categoria->categoria}}</a>
            </li>
            @endif
        @endforeach
    </ul>
</div>
<div id="overlay_sidebar" class="nsb-overlay-categoria"></div>
{{--@foreach($categorias as $categoria)--}}
{{--    @if($categoria->subcategorias->isNotEmpty())--}}
{{--        <div class="nsb-sub-sidebar" id="{{$categoria->categoria}}">--}}
{{--            <div class="row">--}}
{{--                @foreach($categoria->subcategorias as $subcategoria)--}}
{{--                    @php--}}
{{--                        $categoriaSlug = Str::slug($categoria->categoria, '-');--}}
{{--                        $subcategoriaSlug = Str::slug($subcategoria->sub_categoria, '-');--}}
{{--                        $href = $subcategoria->url_externo ?: url('catalogo/' . $categoriaSlug . '/' . $subcategoriaSlug);--}}
{{--                    @endphp--}}
{{--                    @if($subcategoria->url_externo !== "")--}}
{{--                    <div class="col-lg-4">--}}
{{--                        <a class="nav-link nsb-item-a-subcategoria" href="{{$href}}">{{$subcategoria->sub_categoria}}</a>--}}
{{--                    </div>--}}
{{--                    @endif--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}
{{--@endforeach--}}

<script>
    let menuCerrado = true
    $(document).on("click","#a_menu_categoria",function(){
        if(menuCerrado === true) {
            $("#sidebar_categoria").css("width","300px")
            $("#overlay_sidebar").addClass("nsb-overlay-categoria-activo")
            menuCerrado = false
        }else{
            $("#sidebar_categoria").css("width","0")
            $("#overlay_sidebar").removeClass("nsb-overlay-categoria-activo")
            menuCerrado = true
        }
    })
    $("#overlay_sidebar").on("click",function(){
        $("#sidebar_categoria").css("width","0")
        $(".nsb-sub-sidebar").css("width","0")
        $("#overlay_sidebar").removeClass("nsb-overlay-categoria-activo")
        menuCerrado = true
    })
    // $(".nsb-item-sub-categoria").on("mouseenter",function(){
    //     const idSubcategoria = $(this).data("subcategoria")
    //     $("#"+idSubcategoria).css("width","500px")
    // }).on("mouseleave",function(){
    //     const idSubcategoria = $(this).data("subcategoria")
    //     $("#"+idSubcategoria).css("width","0")
    //     setTimeout(function() {
    //         if (!$("#"+idSubcategoria).is(":hover")) {
    //             $("#"+idSubcategoria).css("width","0")
    //         }
    //     }, 100)
    // })
    // $(".nsb-sub-sidebar").on("mouseenter", function() {
    //     const id = $(this).attr('id')
    //     $("#"+id).css("width","500px")
    // })
    $("#li_tendencias").on("click",function(){
        //crear un sidebar o no sé, mostrar las subcategorias que tiene tendencias
    })

</script>
