<?php
session_start();
$page_title = "Sistema de Inscrição - FIB";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-purple: #6f42c1;
            --dark-purple: #5a2d91;
            --light-purple: #8a63d2;
            --white: #ffffff;
            --light-gray: #f8f9fa;
            --dark-gray: #212529;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--white);
            color: #333;
        }
        
        .bg-purple {
            background-color: var(--primary-purple);
        }
        
        .bg-dark-purple {
            background-color: var(--dark-purple);
        }
        
        .text-purple {
            color: var(--primary-purple);
        }
        
        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-purple), var(--dark-purple));
            color: white;
            padding: 100px 0;
            margin-bottom: 50px;
        }
        
        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background-color: var(--primary-purple);
        }
        
        .card-custom {
            transition: transform 0.3s;
            border: none;
            box-shadow: 0 5px 15px rgba(111, 66, 193, 0.1);
            border-radius: 15px;
        }
        
        .card-custom:hover {
            transform: translateY(-5px);
        }
        
        .btn-purple {
            background-color: var(--primary-purple);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            transition: all 0.3s;
            font-weight: 600;
        }
        
        .btn-purple:hover {
            background-color: var(--dark-purple);
            color: white;
            transform: translateY(-2px);
        }
        
        .step-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(111, 66, 193, 0.1);
            margin-bottom: 30px;
            transition: all 0.3s;
        }
        
        .step-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(111, 66, 193, 0.2);
        }
        
        .step-number {
            background: linear-gradient(135deg, var(--primary-purple), var(--light-purple));
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            margin: 0 auto 20px;
        }
        
        footer {
            background-color: var(--dark-gray);
            color: white;
            padding: 50px 0 20px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-purple">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-graduation-cap me-2"></i>
                FIB - Sistema de Inscrição
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contato</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Sistema de Inscrição Online</h1>
            <p class="lead mb-4">Faculdades Integradas de Bauru - FIB</p>
            <p class="fs-5 mb-5">Realize sua inscrição de forma rápida e segura em apenas 4 etapas</p>
            <a href="etapa1.php" class="btn btn-purple btn-lg">
                <i class="fas fa-play me-2"></i>Iniciar Inscrição
            </a>
        </div>
    </div>

    <!-- Como Funciona -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title text-center text-purple fw-bold">Como Funciona</h2>
            <div class="row mt-5">
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <h4 class="text-purple fw-bold">Cadastro do Aluno</h4>
                        <p>Preencha seus dados pessoais básicos para iniciar o processo de inscrição.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <h4 class="text-purple fw-bold">Escolha do Curso</h4>
                        <p>Selecione o curso desejado, turno e modalidade de ensino.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <h4 class="text-purple fw-bold">Pagamento</h4>
                        <p>Escolha a forma de pagamento e modalidade que melhor se adequa ao seu perfil.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="step-card">
                        <div class="step-number">4</div>
                        <h4 class="text-purple fw-bold">Confirmação</h4>
                        <p>Revise todos os dados e confirme sua inscrição no curso escolhido.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Informações Importantes -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card card-custom">
                        <div class="card-header bg-purple text-white text-center">
                            <h3 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informações Importantes</h3>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="text-purple"><i class="fas fa-check-circle me-2"></i>Requisitos</h5>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-arrow-right text-purple me-2"></i>Ensino médio completo</li>
                                        <li><i class="fas fa-arrow-right text-purple me-2"></i>Documentos pessoais</li>
                                        <li><i class="fas fa-arrow-right text-purple me-2"></i>Comprovante de residência</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="text-purple"><i class="fas fa-clock me-2"></i>Prazos</h5>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-arrow-right text-purple me-2"></i>Inscrições até 17/09</li>
                                        <li><i class="fas fa-arrow-right text-purple me-2"></i>Resultado em 48h</li>
                                        <li><i class="fas fa-arrow-right text-purple me-2"></i>Matrícula imediata</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5">
        <div class="container text-center">
            <h2 class="text-purple fw-bold mb-4">Pronto para começar?</h2>
            <p class="lead mb-4">Sua jornada acadêmica começa aqui. Faça sua inscrição agora!</p>
            <a href="etapa1.php" class="btn btn-purple btn-lg">
                <i class="fas fa-rocket me-2"></i>Começar Inscrição
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5><i class="fas fa-graduation-cap me-2"></i>FIB</h5>
                    <p>Faculdades Integradas de Bauru - Compromisso com a excelência em educação.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Contato</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i>Bauru - SP</p>
                    <p><i class="fas fa-phone me-2"></i>(14) 1234-5678</p>
                    <p><i class="fas fa-envelope me-2"></i>contato@fib.edu.br</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Redes Sociais</h5>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin-in fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4 bg-light">
            <div class="text-center">
                <p class="mb-0">&copy; 2023 FIB - Faculdades Integradas de Bauru. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

