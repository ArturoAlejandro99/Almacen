@extends('layouts.plantilla')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="mt-5"><img src="@yield('imgUrl')" class="iconoTitle"> @yield('namePage') </h1>
        </div>
    </div>
    @yield('nuevo')
    
<!-- Filtrado -->
    @yield('filtrado')
    
<!-- tabla -->
    <div class="row">
        <div class="col-lg-12 table-responsive-md table-responsive-sm">
            <table class="table table-striped my-4" >
                <thead class="bg-info">
                <!--info de cada tabla-->
                    @yield('table')
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-center" id="paginacion">
            @yield('paginacion')
        </div>
    </div>
</div>
@endsection