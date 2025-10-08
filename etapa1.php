<?php
session_start();

// Processar formulário se foi enviado
if ($_POST) {
    $errors = [];
    
    // Validação dos campos obrigatórios
    if (empty($_POST['nome'])) {
        $errors[] = "Nome completo é obrigatório";
    }
    
    if (empty($_POST['cpf'])) {
        $errors[] = "CPF é obrigatório";
    } elseif (!preg_match('/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', $_POST['cpf'])) {
        $errors[] = "CPF deve estar no formato 000.000.000-00";
    }
    
    if (empty($_POST['rg'])) {
        $errors[] = "RG é obrigatório";
    }
    
    if (empty($_POST['data_nascimento'])) {
        $errors[] = "Data de nascimento é obrigatória";
    }
    
    if (empty($_POST['email'])) {
        $errors[] = "E-mail é obrigatório";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "E-mail deve ter um formato válido";
    }
    
    if (empty($_POST['telefone'])) {
        $errors[] = "Telefone é obrigatório";
    }
    
    if (empty($_POST['endereco'])) {
        $errors[] = "Endereço é obrigatório";
    }
    
    if (empty($_POST['cidade'])) {
        $errors[] = "Cidade é obrigatória";
    }
    
    if (empty($_POST['cep'])) {
        $errors[] = "CEP é obrigatório";
    }
    
    // Se não há erros, salvar na sessão e redirecionar
    if (empty($errors)) {
        $_SESSION['etapa1'] = $_POST;
        header('Location: etapa2.php');
        exit;
    }
}

$page_title = "Etapa 1: Cadastro do Aluno - FIB";
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
        
        .step.inactive {
            background-color: #e9ecef;
            color: #6c757d;
        }
        
        .step-line {
            width: 50px;
            height: 2px;
            background-color: #e9ecef;
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
        
        .form-control:focus {
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
        }
        
        .alert-custom {
            border-radius: 10px;
            border: none;
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
                <div class="step active">1</div>
                <div class="step-line"></div>
                <div class="step inactive">2</div>
                <div class="step-line"></div>
                <div class="step inactive">3</div>
                <div class="step-line"></div>
                <div class="step inactive">4</div>
            </div>
            <div class="text-center">
                <h3 class="text-purple fw-bold">Etapa 1: Cadastro do Aluno</h3>
                <p class="text-muted">Preencha seus dados pessoais</p>
            </div>
        </div>
    </div>

    <!-- Formulário -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
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

                    <form method="POST" id="formEtapa1">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="nome" class="form-label">Nome Completo *</label>
                                <input type="text" class="form-control" id="nome" name="nome" 
                                       value="<?php echo isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : ''; ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cpf" class="form-label">CPF *</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" 
                                       placeholder="000.000.000-00" maxlength="14"
                                       value="<?php echo isset($_POST['cpf']) ? htmlspecialchars($_POST['cpf']) : ''; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="rg" class="form-label">RG *</label>
                                <input type="text" class="form-control" id="rg" name="rg" 
                                       value="<?php echo isset($_POST['rg']) ? htmlspecialchars($_POST['rg']) : ''; ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="data_nascimento" class="form-label">Data de Nascimento *</label>
                                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" 
                                       value="<?php echo isset($_POST['data_nascimento']) ? htmlspecialchars($_POST['data_nascimento']) : ''; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sexo" class="form-label">Sexo</label>
                                <select class="form-control" id="sexo" name="sexo">
                                    <option value="">Selecione</option>
                                    <option value="M" <?php echo (isset($_POST['sexo']) && $_POST['sexo'] == 'M') ? 'selected' : ''; ?>>Masculino</option>
                                    <option value="F" <?php echo (isset($_POST['sexo']) && $_POST['sexo'] == 'F') ? 'selected' : ''; ?>>Feminino</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">E-mail *</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label">Telefone *</label>
                                <input type="tel" class="form-control" id="telefone" name="telefone" 
                                       placeholder="(00) 00000-0000"
                                       value="<?php echo isset($_POST['telefone']) ? htmlspecialchars($_POST['telefone']) : ''; ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="endereco" class="form-label">Endereço *</label>
                                <input type="text" class="form-control" id="endereco" name="endereco" 
                                       value="<?php echo isset($_POST['endereco']) ? htmlspecialchars($_POST['endereco']) : ''; ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="numero" class="form-label">Número</label>
                                <input type="text" class="form-control" id="numero" name="numero" 
                                       value="<?php echo isset($_POST['numero']) ? htmlspecialchars($_POST['numero']) : ''; ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cidade" class="form-label">Cidade *</label>
                                <input type="text" class="form-control" id="cidade" name="cidade" 
                                       value="<?php echo isset($_POST['cidade']) ? htmlspecialchars($_POST['cidade']) : ''; ?>" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-control" id="estado" name="estado">
                                    <option value="">Selecione</option>
                                    <option value="SP" <?php echo (isset($_POST['estado']) && $_POST['estado'] == 'SP') ? 'selected' : ''; ?>>São Paulo</option>
                                    <option value="RJ" <?php echo (isset($_POST['estado']) && $_POST['estado'] == 'RJ') ? 'selected' : ''; ?>>Rio de Janeiro</option>
                                    <option value="MG" <?php echo (isset($_POST['estado']) && $_POST['estado'] == 'MG') ? 'selected' : ''; ?>>Minas Gerais</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="cep" class="form-label">CEP *</label>
                                <input type="text" class="form-control" id="cep" name="cep" 
                                       placeholder="00000-000" maxlength="9"
                                       value="<?php echo isset($_POST['cep']) ? htmlspecialchars($_POST['cep']) : ''; ?>" required>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="index.php" class="btn btn-outline-secondary me-3">
                                <i class="fas fa-arrow-left me-2"></i>Voltar
                            </a>
                            <button type="submit" class="btn btn-purple">
                                Próxima Etapa <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Máscara para CPF
        document.getElementById('cpf').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = value;
        });

        // Máscara para telefone
        document.getElementById('telefone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{5})(\d)/, '$1-$2');
            e.target.value = value;
        });

        // Máscara para CEP
        document.getElementById('cep').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{5})(\d)/, '$1-$2');
            e.target.value = value;
        });
    </script>
</body>
</html>

