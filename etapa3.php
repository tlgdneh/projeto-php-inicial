<?php
session_start();

// Verificar se as etapas anteriores foram concluídas
if (!isset($_SESSION['etapa1']) || !isset($_SESSION['etapa2'])) {
    header('Location: etapa1.php');
    exit;
}

// Processar formulário se foi enviado
if ($_POST) {
    $errors = [];
    
    // Validação dos campos obrigatórios
    if (empty($_POST['forma_pagamento'])) {
        $errors[] = "Forma de pagamento é obrigatória";
    }
    
    if (empty($_POST['plano_pagamento'])) {
        $errors[] = "Plano de pagamento é obrigatório";
    }
    
    // Validações específicas por forma de pagamento
    if (isset($_POST['forma_pagamento'])) {
        if ($_POST['forma_pagamento'] == 'cartao_credito') {
            if (empty($_POST['numero_cartao'])) {
                $errors[] = "Número do cartão é obrigatório";
            }
            if (empty($_POST['nome_titular'])) {
                $errors[] = "Nome do titular é obrigatório";
            }
            if (empty($_POST['validade_cartao'])) {
                $errors[] = "Validade do cartão é obrigatória";
            }
            if (empty($_POST['cvv'])) {
                $errors[] = "CVV é obrigatório";
            }
        }
        
        if ($_POST['forma_pagamento'] == 'boleto') {
            if (empty($_POST['vencimento_boleto'])) {
                $errors[] = "Data de vencimento do boleto é obrigatória";
            }
        }
    }
    
    // Se não há erros, salvar na sessão e redirecionar
    if (empty($errors)) {
        $_SESSION['etapa3'] = $_POST;
        header('Location: etapa4.php');
        exit;
    }
}

$page_title = "Etapa 3: Pagamento e Modalidade - FIB";
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
        
        .step.inactive {
            background-color: #e9ecef;
            color: #6c757d;
        }
        
        .step-line {
            width: 50px;
            height: 2px;
            background-color: #e9ecef;
        }
        
        .step-line.completed {
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
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
        }
        
        .alert-custom {
            border-radius: 10px;
            border: none;
        }
        
        .payment-card {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .payment-card:hover {
            border-color: var(--primary-purple);
            transform: translateY(-2px);
        }
        
        .payment-card.selected {
            border-color: var(--primary-purple);
            background-color: rgba(111, 66, 193, 0.1);
        }
        
        .payment-details {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background-color: var(--light-gray);
            border-radius: 10px;
        }
        
        .payment-details.active {
            display: block;
        }
        
        .price-card {
            background: linear-gradient(135deg, var(--primary-purple), var(--dark-purple));
            color: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
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

    <!-- Progress Indicator -->
    <div class="progress-container">
        <div class="container">
            <div class="step-indicator">
                <div class="step completed">1</div>
                <div class="step-line completed"></div>
                <div class="step completed">2</div>
                <div class="step-line completed"></div>
                <div class="step active">3</div>
                <div class="step-line"></div>
                <div class="step inactive">4</div>
            </div>
            <div class="text-center">
                <h3 class="text-purple fw-bold">Etapa 3: Pagamento e Modalidade</h3>
                <p class="text-muted">Escolha a forma de pagamento e plano</p>
            </div>
        </div>
    </div>

    <!-- Formulário -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Resumo do Curso -->
                <div class="price-card">
                    <h4><i class="fas fa-graduation-cap me-2"></i>Resumo da Inscrição</h4>
                    <hr class="bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Aluno:</strong> <?php echo htmlspecialchars($_SESSION['etapa1']['nome']); ?></p>
                            <p><strong>Curso:</strong> <?php echo htmlspecialchars($_SESSION['etapa2']['curso']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Turno:</strong> <?php echo ucfirst($_SESSION['etapa2']['turno']); ?></p>
                            <p><strong>Modalidade:</strong> <?php echo ucfirst($_SESSION['etapa2']['modalidade']); ?></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h2><i class="fas fa-tag me-2"></i>Valor da Mensalidade: R$ 850,00</h2>
                    </div>
                </div>

                <div class="form-container">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger alert-custom">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i>Corrija os seguintes erros:</h6>
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" id="formEtapa3">
                        <!-- Plano de Pagamento -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Plano de Pagamento *</label>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="payment-card" onclick="selectPlan('anual')">
                                        <input type="radio" name="plano_pagamento" value="anual" id="plano_anual" 
                                               <?php echo (isset($_POST['plano_pagamento']) && $_POST['plano_pagamento'] == 'anual') ? 'checked' : ''; ?> required>
                                        <label for="plano_anual" class="form-check-label w-100">
                                            <div class="text-center">
                                                <i class="fas fa-calendar-alt fa-2x text-purple mb-2"></i>
                                                <h6>Anual</h6>
                                                <p class="text-muted mb-0">15% de desconto</p>
                                                <strong class="text-success">R$ 722,50/mês</strong>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="payment-card" onclick="selectPlan('semestral')">
                                        <input type="radio" name="plano_pagamento" value="semestral" id="plano_semestral"
                                               <?php echo (isset($_POST['plano_pagamento']) && $_POST['plano_pagamento'] == 'semestral') ? 'checked' : ''; ?> required>
                                        <label for="plano_semestral" class="form-check-label w-100">
                                            <div class="text-center">
                                                <i class="fas fa-calendar fa-2x text-purple mb-2"></i>
                                                <h6>Semestral</h6>
                                                <p class="text-muted mb-0">8% de desconto</p>
                                                <strong class="text-info">R$ 782,00/mês</strong>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="payment-card" onclick="selectPlan('mensal')">
                                        <input type="radio" name="plano_pagamento" value="mensal" id="plano_mensal"
                                               <?php echo (isset($_POST['plano_pagamento']) && $_POST['plano_pagamento'] == 'mensal') ? 'checked' : ''; ?> required>
                                        <label for="plano_mensal" class="form-check-label w-100">
                                            <div class="text-center">
                                                <i class="fas fa-calendar-day fa-2x text-purple mb-2"></i>
                                                <h6>Mensal</h6>
                                                <p class="text-muted mb-0">Valor integral</p>
                                                <strong>R$ 850,00/mês</strong>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Forma de Pagamento -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Forma de Pagamento *</label>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="payment-card" onclick="selectPayment('cartao_credito')">
                                        <input type="radio" name="forma_pagamento" value="cartao_credito" id="cartao_credito"
                                               <?php echo (isset($_POST['forma_pagamento']) && $_POST['forma_pagamento'] == 'cartao_credito') ? 'checked' : ''; ?> required>
                                        <label for="cartao_credito" class="form-check-label w-100">
                                            <div class="text-center">
                                                <i class="fas fa-credit-card fa-2x text-purple mb-2"></i>
                                                <h6>Cartão de Crédito</h6>
                                                <p class="text-muted mb-0">Parcelamento disponível</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="payment-card" onclick="selectPayment('boleto')">
                                        <input type="radio" name="forma_pagamento" value="boleto" id="boleto"
                                               <?php echo (isset($_POST['forma_pagamento']) && $_POST['forma_pagamento'] == 'boleto') ? 'checked' : ''; ?> required>
                                        <label for="boleto" class="form-check-label w-100">
                                            <div class="text-center">
                                                <i class="fas fa-barcode fa-2x text-purple mb-2"></i>
                                                <h6>Boleto Bancário</h6>
                                                <p class="text-muted mb-0">Vencimento flexível</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="payment-card" onclick="selectPayment('pix')">
                                        <input type="radio" name="forma_pagamento" value="pix" id="pix"
                                               <?php echo (isset($_POST['forma_pagamento']) && $_POST['forma_pagamento'] == 'pix') ? 'checked' : ''; ?> required>
                                        <label for="pix" class="form-check-label w-100">
                                            <div class="text-center">
                                                <i class="fas fa-qrcode fa-2x text-purple mb-2"></i>
                                                <h6>PIX</h6>
                                                <p class="text-muted mb-0">Pagamento instantâneo</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detalhes do Cartão de Crédito -->
                        <div id="cartao_details" class="payment-details">
                            <h5 class="text-purple mb-3"><i class="fas fa-credit-card me-2"></i>Dados do Cartão</h5>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="numero_cartao" class="form-label">Número do Cartão</label>
                                    <input type="text" class="form-control" id="numero_cartao" name="numero_cartao" 
                                           placeholder="0000 0000 0000 0000" maxlength="19"
                                           value="<?php echo isset($_POST['numero_cartao']) ? htmlspecialchars($_POST['numero_cartao']) : ''; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nome_titular" class="form-label">Nome do Titular</label>
                                    <input type="text" class="form-control" id="nome_titular" name="nome_titular" 
                                           value="<?php echo isset($_POST['nome_titular']) ? htmlspecialchars($_POST['nome_titular']) : ''; ?>">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="validade_cartao" class="form-label">Validade</label>
                                    <input type="text" class="form-control" id="validade_cartao" name="validade_cartao" 
                                           placeholder="MM/AA" maxlength="5"
                                           value="<?php echo isset($_POST['validade_cartao']) ? htmlspecialchars($_POST['validade_cartao']) : ''; ?>">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <input type="text" class="form-control" id="cvv" name="cvv" 
                                           placeholder="000" maxlength="4"
                                           value="<?php echo isset($_POST['cvv']) ? htmlspecialchars($_POST['cvv']) : ''; ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Detalhes do Boleto -->
                        <div id="boleto_details" class="payment-details">
                            <h5 class="text-purple mb-3"><i class="fas fa-barcode me-2"></i>Configuração do Boleto</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="vencimento_boleto" class="form-label">Data de Vencimento Preferida</label>
                                    <select class="form-select" id="vencimento_boleto" name="vencimento_boleto">
                                        <option value="">Selecione</option>
                                        <option value="05" <?php echo (isset($_POST['vencimento_boleto']) && $_POST['vencimento_boleto'] == '05') ? 'selected' : ''; ?>>Todo dia 05</option>
                                        <option value="10" <?php echo (isset($_POST['vencimento_boleto']) && $_POST['vencimento_boleto'] == '10') ? 'selected' : ''; ?>>Todo dia 10</option>
                                        <option value="15" <?php echo (isset($_POST['vencimento_boleto']) && $_POST['vencimento_boleto'] == '15') ? 'selected' : ''; ?>>Todo dia 15</option>
                                        <option value="20" <?php echo (isset($_POST['vencimento_boleto']) && $_POST['vencimento_boleto'] == '20') ? 'selected' : ''; ?>>Todo dia 20</option>
                                        <option value="25" <?php echo (isset($_POST['vencimento_boleto']) && $_POST['vencimento_boleto'] == '25') ? 'selected' : ''; ?>>Todo dia 25</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Detalhes do PIX -->
                        <div id="pix_details" class="payment-details">
                            <h5 class="text-purple mb-3"><i class="fas fa-qrcode me-2"></i>Pagamento via PIX</h5>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                O código PIX será gerado após a confirmação da inscrição. O pagamento deve ser realizado em até 24 horas.
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="etapa2.php" class="btn btn-outline-secondary me-3">
                                <i class="fas fa-arrow-left me-2"></i>Etapa Anterior
                            </a>
                            <button type="submit" class="btn btn-purple">
                                Finalizar Inscrição <i class="fas fa-check ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function selectPlan(plan) {
            document.getElementById('plano_' + plan).checked = true;
            
            // Remove selected class from all cards
            document.querySelectorAll('.payment-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            // Add selected class to clicked card
            event.currentTarget.classList.add('selected');
        }

        function selectPayment(payment) {
            document.getElementById(payment).checked = true;
            
            // Hide all payment details
            document.querySelectorAll('.payment-details').forEach(detail => {
                detail.classList.remove('active');
            });
            
            // Show selected payment details
            if (document.getElementById(payment + '_details')) {
                document.getElementById(payment + '_details').classList.add('active');
            }
            
            // Remove selected class from all cards
            document.querySelectorAll('.payment-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            // Add selected class to clicked card
            event.currentTarget.classList.add('selected');
        }

        // Máscara para número do cartão
        document.getElementById('numero_cartao').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{4})(\d)/, '$1 $2');
            value = value.replace(/(\d{4}) (\d{4})(\d)/, '$1 $2 $3');
            value = value.replace(/(\d{4}) (\d{4}) (\d{4})(\d)/, '$1 $2 $3 $4');
            e.target.value = value;
        });

        // Máscara para validade do cartão
        document.getElementById('validade_cartao').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{2})(\d)/, '$1/$2');
            e.target.value = value;
        });

        // Inicializar com valores já selecionados
        document.addEventListener('DOMContentLoaded', function() {
            const selectedPayment = document.querySelector('input[name="forma_pagamento"]:checked');
            if (selectedPayment) {
                selectPayment(selectedPayment.value);
            }
        });
    </script>
</body>
</html>

