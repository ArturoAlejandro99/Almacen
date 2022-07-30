<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="home">
            <img src={{ asset('images/logotipo.png') }} width="30" height="43" class="d-inline-block align-center" alt="">
            <b> MINABI </b>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
               {{-- @can('catalogos')   --}} 
                <li class="nav-item dropdown {{ request()->routeIs('employee.*', 'coilType.*', 'provider.*') ? 'active' : ''}}">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Catálogos
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        @can('provider.index')
                        <a class="dropdown-item {{ request()->routeIs('provider.*') ? 'active' : ''}}" href="{{ route('provider.index') }}">
                            Proveedores
                        </a> 
                        @endcan
                        @can('employee.index')
                        <a class="dropdown-item {{ request()->routeIs('employee.*') ? 'active' : ''}}" href="{{ route('employee.index') }}">
                            Empleados
                        </a> 
                        @endcan
                        @can('coilType.index')
                        <a class="dropdown-item {{ request()->routeIs('coilType.*') ? 'active' : ''}}" href="{{ route('coilType.index') }}">
                            Medidas de Bobina
                        </a>
                        @endcan
                        @can('user.index')
                        <a class="dropdown-item {{ request()->routeIs('user.*') ? 'active' : ''}}" href="{{ route('user.index') }}">
                            Usuarios
                        </a> 
                        @endcan
                        @can('rol.index')
                        <a class="dropdown-item {{ request()->routeIs('rol.*') ? 'active' : ''}}" href="{{ route('rol.index') }}">
                            Roles
                        </a> 
                        @endcan
                    </div>
                </li>              
                {{--@endcan--}}
                <li class="nav-item dropdown {{ request()->routeIs('whiteCoil.*', 'whiteRibbon.*', 'whiteCoilProduct.*') ? 'active' : ''}}">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Cinta Blanca
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        @can('whiteCoil.index')
                        <a class="dropdown-item {{ request()->routeIs('whiteCoil.*') ? 'active' : ''}}" href="{{ route('whiteCoil.index') }}">
                            Bobina
                        </a>
                        @endcan
                        @can('whiteCoilProduct.index')
                        <a class="dropdown-item {{ request()->routeIs('whiteCoilProduct.*') ? 'active' : ''}}" href="{{ route('whiteCoilProduct.index') }}">
                            Rollos
                        </a>
                        @endcan 
                    </div>
                </li>  
                @can('coil.index')
                <a class="nav-item nav-link {{ request()->routeIs('coil.index', 'coil.create', 'coil.show', 'coil.edit') ? 'active' : ''}}" href="{{ route('coil.index') }}">
                    Bobinas
                </a>
                @endcan
                @can('coilProduct.index')
                <a class="nav-item nav-link {{ request()->routeIs('coilProduct.*') ? 'active' : ''}}" href="{{ route('coilProduct.index') }}">
                    Rollos
                </a>
                @endcan
                @can('ribbonProduct.index', Model::class)
                <a class="nav-item nav-link {{ request()->routeIs('bag.index', 'bag.create', 'bag.show', 'bag.edit', 'ribbonProduct.*') ? 'active' : ''}}" href="{{ route('ribbonProduct.index') }}">
                    Bolsas
                </a>
                @endcan
                <li class="nav-item dropdown {{ request()->routeIs('coil.reporteria', 'ribbon.reporteria', 'bag.reporteria', 'coil.produccion', 'destroy.reporte') ? 'active' : ''}}">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Reportes
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        @can('coil.reporteria')
                        <a class="dropdown-item {{ request()->routeIs('coil.reporteria') ? 'active' : ''}}" href="{{ route('coil.reporteria') }}">
                            Almacen de Bobinas
                        </a>  
                        @endcan
                        @can('ribbon.reporteria')
                        <a class="dropdown-item {{ request()->routeIs('ribbon.reporteria') ? 'active' : ''}}" href="{{ route('ribbon.reporteria') }}">
                            Almacen de Rollos
                        </a>
                        @endcan
                        @can('bag.reporteria')
                        <a class="dropdown-item {{ request()->routeIs('bag.reporteria') ? 'active' : ''}}" href="{{ route('bag.reporteria') }}">
                            Almacen de Bolsas
                        </a>    
                        @endcan
                        @can('coil.produccion')
                        <a class="dropdown-item {{ request()->routeIs('coil.produccion') ? 'active' : ''}}" href="{{ route('coil.produccion') }}">
                            Produccion
                        </a>  
                        @endcan                        
                        <a class="dropdown-item {{ request()->routeIs('destroy.reporte') ? 'active' : ''}}" href="{{ route('destroy.reporte') }}">
                            Registros Eliminados
                        </a>  
                    </div>
                </li>
            </div>
            <form action="{{asset('logout')}}" method="POST" class="ml-lg-auto text-md-left navbar-nav">
                @csrf
                <a href="#" class="nav-item nav-link" onclick="this.closest('form').submit()">Cerrar sesion</a>
            </form>      
        </div>
    </nav>
</header>    