<!-- Верхнее меню навигации приложения -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <!-- Ссылка на главную страницу -->
        <a class="navbar-brand" href="<?php echo URLSITE; ?>">Inicio</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Основные пункты меню -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="?c=clientes" id="ClientesDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">Clientes</a>
                    <ul class="dropdown-menu" aria-labelledby="clientesDropdown">
                        <!-- Переход к списку клиентов -->
                        <li><a class="dropdown-item" href="<?php echo URLSITE . '?c=clientes'; ?>">Clientes...</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <!-- Переход к списку счетов (можно фильтровать по клиенту) -->
                        <li><a class="dropdown-item" href="<?php echo URLSITE . '?c=clientes&m=facturas'; ?>">
                                Facturas...</a></li>
                        <!-- Переход к списку артикулов -->
                        <li><a class="dropdown-item" href="<?php echo URLSITE . '?c=articulos'; ?>">
                                Articulos...</a></li>
                    </ul>
                </li>
            </ul>
            <span class="navbar-text">
                <!-- Ссылка на страницу помощи -->
                <a class="nav-item nav-link active" href="<?php echo URLSITE . '?c=ayuda'; ?>"> Ayuda</a>
            </span>
        </div>
    </div>
</nav>