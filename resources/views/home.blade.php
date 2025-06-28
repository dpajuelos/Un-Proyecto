<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - HPP Consultoría Minera</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #2c3e50;
      --secondary: #34495e;
      --accent: #3498db;
      --gold: #f1c40f;
      --text-light: #ecf0f1;
      --text-dark: #2c3e50;
      --success: #2ecc71;
      --warning: #e67e22;
      --danger: #e74c3c;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: #f5f7fa;
      color: var(--text-dark);
    }

    .dashboard {
      display: grid;
      grid-template-columns: 250px 1fr;
      min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
      background-color: var(--primary);
      color: var(--text-light);
      padding: 20px 0;
      box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    }

    .logo {
      text-align: center;
      padding: 0 20px 20px;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .logo h2 {
      font-size: 22px;
      margin-top: 10px;
    }

    .nav-menu {
      margin-top: 30px;
    }

    .nav-item {
      padding: 12px 20px;
      display: flex;
      align-items: center;
      cursor: pointer;
      transition: all 0.3s;
    }

    .nav-item:hover, .nav-item.active {
      background-color: rgba(255,255,255,0.1);
      border-left: 4px solid var(--accent);
    }

    .nav-item i {
      margin-right: 10px;
      width: 20px;
      text-align: center;
    }

    /* Submenu styles */
    .sidebar-menu {
      list-style: none;
      padding: 0;
      width: 100%;
    }
    
    .sidebar-menu li a {
      display: flex;
      align-items: center;
      padding: 12px 20px;
      color: var(--text-light);
      text-decoration: none;
      transition: all 0.3s;
    }
    
    .sidebar-menu li a:hover, .sidebar-menu li a.active {
      background-color: rgba(255,255,255,0.1);
      border-left: 4px solid var(--accent);
    }
    
    .sidebar-menu li a i {
      margin-right: 10px;
      width: 20px;
      text-align: center;
    }
    
    .sidebar-submenu {
      list-style: none;
      padding-left: 20px;
      display: none;
      background-color: rgba(0,0,0,0.1);
    }
    
    .sidebar-submenu li a {
      padding: 10px 15px;
      font-size: 14px;
    }
    
    .sidebar-submenu li a i {
      font-size: 12px;
    }
    
    .menu-toggle {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .menu-toggle .fa-chevron-down {
      transition: transform 0.3s;
      font-size: 12px;
    }
    
    .menu-toggle.active .fa-chevron-down {
      transform: rotate(180deg);
    }

    /* Main Content */
    .main-content {
      padding: 20px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .page-title {
      color: var(--primary);
      font-size: 28px;
    }

    .user-info {
      display: flex;
      align-items: center;
    }

    .user-info img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 10px;
    }

    /* Stats Cards */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      margin-bottom: 30px;
    }

    .stat-card {
      background: white;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.05);
      display: flex;
      justify-content: space-between;
      transition: transform 0.3s;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 12px rgba(0,0,0,0.1);
    }

    .stat-info h3 {
      font-size: 14px;
      color: #7f8c8d;
      margin-bottom: 5px;
    }

    .stat-info h2 {
      font-size: 24px;
      color: var(--text-dark);
    }

    .stat-icon {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
    }

    .projects {
      background-color: rgba(52, 152, 219, 0.1);
      color: var(--accent);
    }

    .clients {
      background-color: rgba(241, 196, 15, 0.1);
      color: var(--gold);
    }

    .revenue {
      background-color: rgba(46, 204, 113, 0.1);
      color: var(--success);
    }

    .tasks {
      background-color: rgba(231, 76, 60, 0.1);
      color: var(--danger);
    }

    /* Main Grid */
    .main-grid {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 20px;
    }

    /* Projects Section */
    .projects-section {
      background: white;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .section-title {
      font-size: 20px;
      color: var(--primary);
    }

    .view-all {
      color: var(--accent);
      cursor: pointer;
      font-size: 14px;
    }

    .project-card {
      display: flex;
      margin-bottom: 15px;
      padding-bottom: 15px;
      border-bottom: 1px solid #eee;
    }

    .project-card:last-child {
      border-bottom: none;
      margin-bottom: 0;
      padding-bottom: 0;
    }

    .project-icon {
      width: 40px;
      height: 40px;
      border-radius: 8px;
      background-color: rgba(52, 152, 219, 0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--accent);
      margin-right: 15px;
      flex-shrink: 0;
    }

    .project-info h4 {
      font-size: 16px;
      margin-bottom: 5px;
    }

    .project-info p {
      font-size: 14px;
      color: #7f8c8d;
      margin-bottom: 5px;
    }

    .project-status {
      display: inline-block;
      padding: 3px 8px;
      border-radius: 4px;
      font-size: 12px;
      font-weight: 500;
    }

    .status-in-progress {
      background-color: rgba(241, 196, 15, 0.1);
      color: var(--gold);
    }

    .status-completed {
      background-color: rgba(46, 204, 113, 0.1);
      color: var(--success);
    }

    .status-pending {
      background-color: rgba(231, 76, 60, 0.1);
      color: var(--danger);
    }

    /* Services Section */
    .services-section {
      background: white;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    .service-item {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
      padding: 10px;
      border-radius: 6px;
      transition: all 0.3s;
      cursor: pointer;
    }

    .service-item:hover {
      background-color: #f8f9fa;
    }

    .service-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: rgba(52, 152, 219, 0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--accent);
      margin-right: 15px;
      flex-shrink: 0;
    }

    .service-info h4 {
      font-size: 15px;
      margin-bottom: 3px;
    }

    .service-info p {
      font-size: 13px;
      color: #7f8c8d;
    }

    /* Recent Activity */
    .activity-section {
      margin-top: 20px;
      background: white;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    .activity-item {
      display: flex;
      margin-bottom: 15px;
    }

    .activity-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
      color: var(--primary);
      font-weight: bold;
    }

    .activity-info h4 {
      font-size: 14px;
      margin-bottom: 5px;
    }

    .activity-info p {
      font-size: 13px;
      color: #7f8c8d;
    }

    .activity-time {
      font-size: 12px;
      color: #bdc3c7;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .main-grid {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 768px) {
      .dashboard {
        grid-template-columns: 1fr;
      }
      
      .sidebar {
        display: none;
      }
      
      .stats-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <div class="dashboard">
    <!-- Sidebar -->
    <div class="sidebar">
      <div class="sidebar-logo" style="text-align:center; margin-bottom:30px;">
        <img src="{{ asset('img/hpp.png') }}" alt="Logo HPP" style="width:100px; height:auto; display:block; margin:0 auto 10px;">
        <span style="font-size:20px; font-weight:bold; color:#fff;">HPP</span>
      </div>
      
      <ul class="sidebar-menu">
        <li><a href="{{ url('/home') }}" class="active"><i class="fas fa-home"></i> Inicio</a></li>
        <li>
          <a href="#" class="menu-toggle">
            <i class="fas fa-building me-2"></i> Institucional
            <i class="fas fa-chevron-down ms-auto"></i>
          </a>
          <ul class="sidebar-submenu">
            <li>
              <a href="{{ route('organigrama.pdf') }}">
                <i class="fas fa-sitemap me-2"></i> Organigrama (PDF)
              </a>
            </li>
            <li>
              <a href="{{ route('institucional.misionvision') }}">
                <i class="fas fa-scroll me-2"></i> Misión y Visión
              </a>
            </li>
            <li>
              <a href="{{ route('institucional.historia') }}">
                <i class="fas fa-book me-2"></i> Historia
              </a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#" class="menu-toggle"><i class="fas fa-briefcase"></i> Servicios <i class="fas fa-chevron-down ms-auto"></i></a>
          <ul class="sidebar-submenu">
            <li><a href="#"><i class="fas fa-search"></i> Servicios Centrales</a></li>
            <li><a href="#"><i class="fas fa-mountain"></i> Especialidades Mineras</a></li>
            <li><a href="#"><i class="fas fa-graduation-cap"></i> Capacitación</a></li>
          </ul>
        </li>
        <li>
          <a href="#" class="menu-toggle">
            <i class="fas fa-briefcase me-2"></i> Servicios en Línea
            <i class="fas fa-chevron-down ms-auto"></i>
          </a>
          <ul class="sidebar-submenu">
            <li>
              <a href="{{ route('citas.index') }}" class="load-content" data-url="{{ route('citas.index') }}">
                <i class="fas fa-calendar-check me-2"></i> Solicitar Consulta Minera Virtual
              </a>
            </li>
            <li>
              <a href="{{ route('mineras.index') }}">
                <i class="fas fa-search-location me-2"></i> Consulta de Minera
              </a>
            </li>
            <li>
              <a href="{{ route('trabajadores.index') }}">
                <i class="fas fa-users me-2"></i> Consulta de trabajadores
              </a>
            </li>
            <li>
              <a href="{{ route('mineras.index') }}">
                <i class="fas fa-file-alt me-2"></i> Informes de Análisis
              </a>
            </li>
            <li>
              <a href="{{ route('portal.cliente') }}">
                <i class="fas fa-user-shield me-2"></i> Portal del Cliente
              </a>
            </li>
            <li>
              <a href="{{ route('historial.index') }}">
                <i class="fas fa-history"></i> Historial de Consultas
              </a>
            </li>
          </ul>
        </li>
        <li>
          <a href="/logout" class="btn btn-danger w-100" style="display:flex; align-items:center; justify-content:center; background:#e74c3c; color:#fff; padding:12px 0; border-radius:5px; text-decoration:none;">
              <i class="fas fa-sign-out-alt me-2"></i> <span style="margin-left:8px;">Salir</span>
          </a>
        </li>
      </ul>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
      <header class="header">
        <h1 class="page-title">Dashboard</h1>
        <div class="user-info">
          <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Usuario">
          <span>Ing. Carlos Pérez</span>
        </div>
      </header>
      
      {{-- Agrega esto dentro de .main-content, después del header --}}
      <div id="dynamic-content"></div>
      
      <!-- Stats Cards -->
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-info">
            <h3>Proyectos Activos</h3>
            <h2>12</h2>
          </div>
          <div class="stat-icon projects">
            <i class="fas fa-project-diagram"></i>
          </div>
        </div>
        
        <div class="stat-card">
          <div class="stat-info">
            <h3>Clientes</h3>
            <h2>24</h2>
          </div>
          <div class="stat-icon clients">
            <i class="fas fa-users"></i>
          </div>
        </div>
        
        <div class="stat-card">
          <div class="stat-info">
            <h3>Ingresos (2023)</h3>
            <h2>$2.4M</h2>
          </div>
          <div class="stat-icon revenue">
            <i class="fas fa-dollar-sign"></i>
          </div>
        </div>
        
        <div class="stat-card">
          <div class="stat-info">
            <h3>Tareas Pendientes</h3>
            <h2>7</h2>
          </div>
          <div class="stat-icon tasks">
            <i class="fas fa-tasks"></i>
          </div>
        </div>
      </div>
      
      <!-- Main Grid -->
      <div class="main-grid">
        <!-- Projects Section -->
        <div class="projects-section">
          <div class="section-header">
            <h2 class="section-title">Proyectos Recientes</h2>
            <span class="view-all">Ver todos</span>
          </div>
          
          <div class="project-card">
            <div class="project-icon">
              <i class="fas fa-search"></i>
            </div>
            <div class="project-info">
              <h4>Evaluación Mina San José</h4>
              <p>Evaluación técnica y económica de recursos minerales</p>
              <span class="project-status status-in-progress">En Progreso</span>
            </div>
          </div>
          
          <div class="project-card">
            <div class="project-icon">
              <i class="fas fa-chart-line"></i>
            </div>
            <div class="project-info">
              <h4>Planificación Minera Cerro Verde</h4>
              <p>Diseño de plan de minado a 5 años</p>
              <span class="project-status status-completed">Completado</span>
            </div>
          </div>
          
          <div class="project-card">
            <div class="project-icon">
              <i class="fas fa-cogs"></i>
            </div>
            <div class="project-info">
              <h4>Optimización Procesos Antamina</h4>
              <p>Mejora de eficiencia en planta de procesamiento</p>
              <span class="project-status status-in-progress">En Progreso</span>
            </div>
          </div>
          
          <div class="project-card">
            <div class="project-icon">
              <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="project-info">
              <h4>Due Diligence Minera Las Bambas</h4>
              <p>Evaluación técnica para proceso de compra</p>
              <span class="project-status status-pending">Pendiente</span>
            </div>
          </div>
        </div>
        
        <!-- Services Section -->
        <div class="services-section">
          <div class="section-header">
            <h2 class="section-title">Nuestros Servicios</h2>
          </div>
          
          <div class="service-item">
            <div class="service-icon">
              <i class="fas fa-search"></i>
            </div>
            <div class="service-info">
              <h4>Evaluación de Yacimientos</h4>
              <p>Análisis técnico y económico de recursos minerales</p>
            </div>
          </div>
          
          <div class="service-item">
            <div class="service-icon">
              <i class="fas fa-chart-line"></i>
            </div>
            <div class="service-info">
              <h4>Planificación Minera</h4>
              <p>Diseño de planes de minado optimizados</p>
            </div>
          </div>
          
          <div class="service-item">
            <div class="service-icon">
              <i class="fas fa-cogs"></i>
            </div>
            <div class="service-info">
              <h4>Optimización de Procesos</h4>
              <p>Mejora continua en procesos de extracción</p>
            </div>
          </div>
          
          <div class="service-item">
            <div class="service-icon">
              <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="service-info">
              <h4>Due Diligence Técnico</h4>
              <p>Evaluación integral de activos mineros</p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Recent Activity -->
      <div class="activity-section">
        <div class="section-header">
          <h2 class="section-title">Actividad Reciente</h2>
        </div>
        
        <div class="activity-item">
          <div class="activity-avatar">JP</div>
          <div class="activity-info">
            <h4>Juan Pérez actualizó el informe de evaluación</h4>
            <p>Informe Mina San José v2.1</p>
            <div class="activity-time">Hace 2 horas</div>
          </div>
        </div>
        
        <div class="activity-item">
          <div class="activity-avatar">MG</div>
          <div class="activity-info">
            <h4>María Gómez completó el análisis de muestras</h4>
            <p>45 muestras procesadas</p>
            <div class="activity-time">Hace 5 horas</div>
          </div>
        </div>
        
        <div class="activity-item">
          <div class="activity-avatar">CL</div>
          <div class="activity-info">
            <h4>Carlos López agregó nuevos datos al proyecto</h4>
            <p>Planificación Cerro Verde</p>
            <div class="activity-time">Ayer, 15:30</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // JavaScript para manejar el toggle de los submenús
    document.querySelectorAll('.menu-toggle').forEach(toggle => {
      toggle.addEventListener('click', function(e) {
        e.preventDefault();
        const submenu = this.nextElementSibling;
        this.classList.toggle('active');
        if (submenu.style.display === 'block') {
          submenu.style.display = 'none';
        } else {
          submenu.style.display = 'block';
        }
      });
    });
  </script>
</body>
</html>