<?php
session_start();

// Verificar se todas as etapas anteriores foram concluídas
if (!isset($_SESSION['etapa1']) || !isset($_SESSION['etapa2']) || !isset($_SESSION['etapa3'])) {
    header('Location: etapa1.php');
    exit;
}

// Processar confirmação final
if ($_POST && isset($_POST['confirmar_inscricao'])) {
    // Aqui você salvaria os dados no banco de dados
    // Por enquanto, vamos apenas simular o sucesso
    
    // Gerar número de protocolo
    $protocolo = 'FIB' . date('Y') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    $_SESSION['protocolo'] = $protocolo;
    
    // Limpar dados da sessão (opcional)
    // unset($_SESSION['etapa1'], $_SESSION['etapa2'], $_SESSION['etapa3']);
    
    $inscricao_confirmada = true;
} else {
    $inscricao_confirmada = false;
}

$page_title = "Etapa 4: Confirmação - FIB";

// Mapear valores para exibição
$cursos = [
    'administracao' => 'Administração',
    'ciencias_contabeis' => 'Ciências Contábeis',
    'direito' => 'Direito',
    'enfermagem' => 'Enfermagem',
    'engenharia_civil' => 'Engenharia Civil',
    'engenharia_computacao' => 'Engenharia de Computação',
    'medicina' => 'Medicina',
    'odontologia' => 'Odontologia',
    'psicologia' => 'Psicologia',
    'sistemas_informacao' => 'Sistemas de Informação'
];

$turnos = [
    'manha' => 'Manhã (07:00 - 12:00)',
    'tarde' => 'Tarde (13:00 - 18:00)',
    'noite' => 'Noite (19:00 - 23:00)'
];

$modalidades = [
    'presencial' => 'Presencial',
    'ead' => 'EAD (Ensino a Distância)',
    'hibrido' => 'Híbrido (Presencial + EAD)'
];

$formas_pagamento = [
    'cartao_credito' => 'Cartão de Crédito',
    'boleto' => 'Boleto Bancário',
    'pix' => 'PIX'
];

$planos_pagamento = [
    'anual' => 'Anual (15% desconto) - R$ 722,50/mês',
    'semestral' => 'Semestral (8% desconto) - R$ 782,00/mês',
    'mensal' => 'Mensal - R$ 850,00/mês'
];
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
            background-color: var(--light-gray);
            color: #333;
        }
        
        .bg-purple {
            background-color: var(--primary-purple);
        }
        
        .text-purple {
            color: var(--primary-purple);
        }
        
        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .progress-container {
            background: white;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .step-indicator {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin: 0 10px;
            position: relative;
        }
        
        .step.active {
            background-color: var(--primary-purple);
            color: white;
        }
        
        .step.completed {
            background-color: #28a745;
            color: white;
        }
        
        .step-line {
            width: 50px;
            height: 2px;
            background-color: #28a745;
        }
        
        .form-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(111, 66, 193, 0.1);
            padding: 40px;
            margin: 30px 0;
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
        
        .summary-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(111, 66, 193, 0.1);
            padding: 30px;
            margin-bottom: 20px;
        }
        
        .summary-section {
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        
        .summary-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .success-container {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border-radius: 15px;
            padding: 50px;
            text-align: center;
            margin: 30px 0;
        }
        
        .protocol-card {
            background: white;
            color: var(--primary-purple);
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        
        .print-button {
            background-color: white;
            color: var(--primary-purple);
            border: 2px solid white;
        }
        
        .print-button:hover {
            background-color: var(--light-gray);
            color: var(--primary-purple);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-purple">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="fas fa-graduation-cap me-2"></i>
                FIB - Sistema de Inscrição
            </a>
        </div>
    </nav>

    <?php if (!$inscricao_confirmada): ?>
    <!-- Progress Indicator -->
    <div class="progress-container">
        <div class="container">
            <div class="step-indicator">
                <div class="step completed">1</div>
                <div class="step-line"></div>
                <div class="step completed">2</div>
                <div class="step-line"></div>
                <div class="step completed">3</div>
                <div class="step-line"></div>
                <div class="step active">4</div>
            </div>
            <div class="text-center">
                <h3 class="text-purple fw-bold">Etapa 4: Confirmação</h3>
                <p class="text-muted">Revise seus dados e confirme a inscrição</p>
            </div>
        </div>
    </div>

    <!-- Resumo da Inscrição -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Dados Pessoais -->
                <div class="summary-card">
                    <div class="summary-section">
                        <h5 class="text-purple fw-bold mb-3"><i class="fas fa-user me-2"></i>Dados Pessoais</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nome:</strong> <?php echo htmlspecialchars($_SESSION['etapa1']['nome']); ?></p>
                                <p><strong>CPF:</strong> <?php echo htmlspecialchars($_SESSION['etapa1']['cpf']); ?></p>
                                <p><strong>RG:</strong> <?php echo htmlspecialchars($_SESSION['etapa1']['rg']); ?></p>
                                <p><strong>Data de Nascimento:</strong> <?php echo date('d/m/Y', strtotime($_SESSION['etapa1']['data_nascimento'])); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>E-mail:</strong> <?php echo htmlspecialchars($_SESSION['etapa1']['email']); ?></p>
                                <p><strong>Telefone:</strong> <?php echo htmlspecialchars($_SESSION['etapa1']['telefone']); ?></p>
                                <p><strong>Cidade:</strong> <?php echo htmlspecialchars($_SESSION['etapa1']['cidade']); ?></p>
                                <p><strong>CEP:</strong> <?php echo htmlspecialchars($_SESSION['etapa1']['cep']); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Dados do Curso -->
                    <div class="summary-section">
                        <h5 class="text-purple fw-bold mb-3"><i class="fas fa-graduation-cap me-2"></i>Dados do Curso</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Curso:</strong> <?php echo $cursos[$_SESSION['etapa2']['curso']]; ?></p>
                                <p><strong>Turno:</strong> <?php echo $turnos[$_SESSION['etapa2']['turno']]; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Modalidade:</strong> <?php echo $modalidades[$_SESSION['etapa2']['modalidade']]; ?></p>
                                <p><strong>Semestre:</strong> <?php echo htmlspecialchars($_SESSION['etapa2']['semestre_ingresso']); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Dados de Pagamento -->
                    <div class="summary-section">
                        <h5 class="text-purple fw-bold mb-3"><i class="fas fa-credit-card me-2"></i>Dados de Pagamento</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Plano:</strong> <?php echo $planos_pagamento[$_SESSION['etapa3']['plano_pagamento']]; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Forma de Pagamento:</strong> <?php echo $formas_pagamento[$_SESSION['etapa3']['forma_pagamento']]; ?></p>
                            </div>
                        </div>
                        
                        <?php if ($_SESSION['etapa3']['forma_pagamento'] == 'cartao_credito'): ?>
                        <div class="mt-3">
                            <p><strong>Cartão:</strong> **** **** **** <?php echo substr($_SESSION['etapa3']['numero_cartao'], -4); ?></p>
                            <p><strong>Titular:</strong> <?php echo htmlspecialchars($_SESSION['etapa3']['nome_titular']); ?></p>
                        </div>
                        <?php elseif ($_SESSION['etapa3']['forma_pagamento'] == 'boleto'): ?>
                        <div class="mt-3">
                            <p><strong>Vencimento:</strong> Todo dia <?php echo $_SESSION['etapa3']['vencimento_boleto']; ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Confirmação -->
                <div class="form-container text-center">
                    <h4 class="text-purple fw-bold mb-4">Confirmar Inscrição</h4>
                    <p class="mb-4">Ao confirmar, você concorda com os termos e condições da instituição e autoriza o processamento dos seus dados pessoais conforme nossa política de privacidade.</p>
                    
                    <form method="POST">
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="aceito_termos" required>
                            <label class="form-check-label" for="aceito_termos">
                                Eu li e aceito os <a href="#" class="text-purple">termos e condições</a> e a <a href="#" class="text-purple">política de privacidade</a>
                            </label>
                        </div>
                        
                        <div class="d-flex justify-content-center gap-3">
                            <a href="etapa3.php" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Etapa Anterior
                            </a>
                            <button type="submit" name="confirmar_inscricao" class="btn btn-purple btn-lg">
                                <i class="fas fa-check me-2"></i>Confirmar Inscrição
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php else: ?>
    <!-- Confirmação de Sucesso -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="success-container">
                    <i class="fas fa-check-circle fa-5x mb-4"></i>
                    <h2 class="fw-bold mb-3">Inscrição Confirmada com Sucesso!</h2>
                    <p class="lead mb-4">Parabéns! Sua inscrição foi processada e você receberá um e-mail de confirmação em breve.</p>
                    
                    <div class="protocol-card">
                        <h4 class="fw-bold">Número do Protocolo</h4>
                        <h2 class="text-purple fw-bold"><?php echo $_SESSION['protocolo']; ?></h2>
                        <p class="mb-0">Guarde este número para acompanhar sua inscrição</p>
                    </div>
                    
                    <div class="mt-4">
                        <button onclick="window.print()" class="btn print-button me-3">
                            <i class="fas fa-print me-2"></i>Imprimir Comprovante
                        </button>
                        <a href="index.php" class="btn print-button">
                            <i class="fas fa-home me-2"></i>Voltar ao Início
                        </a>
                    </div>
                </div>

                <!-- Próximos Passos -->
                <div class="summary-card">
                    <h5 class="text-purple fw-bold mb-3"><i class="fas fa-list-check me-2"></i>Próximos Passos</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-purple text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px; font-size: 14px;">1</div>
                                <div>
                                    <h6 class="mb-1">Confirmação por E-mail</h6>
                                    <p class="text-muted mb-0">Você receberá um e-mail com os detalhes da sua inscrição em até 24 horas.</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-purple text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px; font-size: 14px;">2</div>
                                <div>
                                    <h6 class="mb-1">Documentação</h6>
                                    <p class="text-muted mb-0">Prepare os documentos necessários para a matrícula.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-purple text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px; font-size: 14px;">3</div>
                                <div>
                                    <h6 class="mb-1">Pagamento</h6>
                                    <p class="text-muted mb-0">Realize o primeiro pagamento conforme a modalidade escolhida.</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-purple text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px; font-size: 14px;">4</div>
                                <div>
                                    <h6 class="mb-1">Matrícula</h6>
                                    <p class="text-muted mb-0">Compareça à secretaria para finalizar sua matrícula.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

