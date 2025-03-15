        <!-- App navbar starts -->
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <div class="offcanvas offcanvas-end" id="MobileMenu">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title semibold">Navegação</h5>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="offcanvas">
                            <i class="icon-clear"></i>
                        </button>
                    </div>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown <?=$active === 'dashboard' ? 'active-link': ''?>">
                            <a class="nav-link dropdown-toggle" href="/dashboard" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="icon-stacked_line_chart"></i> Dashboards
                            </a>
                            <ul class="dropdown-menu">
                                <!-- <li>
                                    <a class="dropdown-item current-page" href="/dashboard/analytics">
                                        <span>Analytics</span>
                                    </a>
                                </li> -->
                                <li>
                                    <a class="dropdown-item current-page" href="/dashboard">
                                        <span>Facilidades</span>
                                    </a>
                                </li>
                            </ul>
                        </li>   
                        <li class="nav-item dropdown <?=$active === 'site' ? 'active-link': ''?>">
                            <a class="nav-link dropdown-toggle" href="/dashboard" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="icon-now_widgets"></i> Site
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item current-page" href="/admin/slides">
                                        <span>Slide</span>
                                    </a>
                                </li>                                
                                <li>
                                    <a class="dropdown-item current-page" href="/admin/paginas">
                                        <span>Pagina</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item current-page" href="/admin/linhas">
                                        <span>Linha do Tempo</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item current-page" href="/admin/documentos">
                                        <span>Documentos</span>
                                    </a>
                                </li>
                            </ul>
                        </li>                     
                        <li class="nav-item dropdown <?=$active === 'cadastro' ? 'active-link': ''?>">
                            <a class="nav-link dropdown-toggle" href="/dashboard" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="icon-package"></i> Cadastro
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item current-page" href="/admin/sectors">
                                        <span>Setores</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item current-page" href="/admin/partners">
                                        <span>Parceiros</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item current-page" href="/admin/colaborators">
                                        <span>Colaboradores</span>
                                    </a>
                                </li>
                            </ul>
                        </li>  
                        <li class="nav-item">
                            <a class="nav-link text-warning" href="/logout">Sair</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- App Navbar ends -->