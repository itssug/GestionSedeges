<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Botón sidebar -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- Contenido derecho -->
    <ul class="navbar-nav ml-auto">
        <!-- Dropdown de Usuario - Versión funcional -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/img/user-default.png') }}" class="img-circle elevation-2" width="30" alt="Usuario">
                    <span class="ml-2">Usuario Admin</span>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownUser">
                <div class="dropdown-header text-center">
                    <img src="{{ asset('assets/img/user-default.png') }}" class="img-circle" width="60" alt="Usuario">
                    <p class="mb-0 mt-2">Usuario Admin</p>
                    <small class="text-muted">Administrador</small>
                </div>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user mr-2"></i> Mi Perfil
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cog mr-2"></i> Configuración
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-list mr-2"></i> Actividad
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                </a>
            </div>
        </li>
    </ul>
</nav>