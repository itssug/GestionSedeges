<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Logo -->
    <div class="brand-link">
        <img src="{{ asset('assets/img/1.png') }}" alt="Logo" class="brand-image" style="opacity: .8">
        <span class="titulo font-weight-light">ISKAY</span>
        <img src="{{ asset('assets/img/2.png') }}" alt="Logo" class="brand-image2" style="opacity: .8">
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Ítem Inicio -->
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Inicio</p>
                    </a>
                </li>

                <!-- Roles -->
                <li class="nav-item">
                    <a href="../../../../views/admin/super-admin/roles/index.php" class="nav-link">
                        <i class="nav-icon fas fa-address-book"></i>
                        <p>Roles</p>
                    </a>
                </li>

                <!-- Hotel (Grupo desplegable) -->
                <li class="nav-item">
                    <div class="nav-link">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>
                            Hotel
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </div>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Habitaciones</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Reserva en Local</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Reservas Pendientes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Solicitar Reserva</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Promociones (Grupo desplegable) -->
                <li class="nav-item">
                    <div class="nav-link">
                        <i class="nav-icon fas fa-cube"></i>
                        <p>
                            Promociones
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </div>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Todas las Promociones</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Hotel</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Restaurante</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Restaurante (Grupo desplegable) -->
                <li class="nav-item">
                    <div class="nav-link">
                        <i class="nav-icon fas fa-utensils"></i>
                        <p>
                            Restaurante
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </div>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Reserva en Local</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Reservas Pendientes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Menú Fijo</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Menú Semanal</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Reservas -->
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-calendar"></i>
                        <p>Reservas</p>
                    </a>
                </li>

                <!-- Publicaciones -->
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-square" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                            <path d="M5.795 12.456A.5.5 0 0 1 5.5 12V4a.5.5 0 0 1 .832-.374l4.5 4a.5.5 0 0 1 0 .748l-4.5 4a.5.5 0 0 1-.537.082"/>
                        </svg>
                        </i>
                        <p>Publicaciones</p>
                    </a>
                </li>

                <!-- Reportes (Grupo desplegable) -->
                <li class="nav-item">
                    <div class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Reportes
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </div>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Usuarios</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Menu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Reservas del Hotel</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Reservas del Rest</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>

                <!-- Reseñas -->
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-star-half-alt"></i>
                        <p>Reseñas</p>
                    </a>
                </li>

                <!-- Nosotros (Grupo desplegable) -->
                <li class="nav-item">
                    <div class="nav-link">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <p>
                            Nosotros
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </div>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Información General</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Redes Sociales</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>