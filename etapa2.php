<?php
session_start();

// Verificar se a etapa 1 foi concluída
if (!isset($_SESSION['etapa1'])) {
    header('Location: etapa1.php');
    exit;
}

// Processar formulário se foi enviado
if ($_POST) {
    $errors = [];
    
    // Validação dos campos obrigatórios
    if (empty($_POST['curso'])) {
        $errors[] = "Curso é obrigatório";
    }
    
    if (empty($_POST['turno'])) {
        $errors[] = "Turno é obrigatório";
    }
    
    if (empty($_POST['modalidade'])) {
        $errors[] = "Modalidade é obrigatória";
    }
    
    if (empty($_POST['semestre_ingresso'])) {
        $errors[] = "Semestre de ingresso é obrigatório";
    }
    
    // Se não há erros, salvar na sessão e redirecionar
    if (empty($errors)) {
        $_SESSION['etapa2'] = $_POST;
        header('Location: etapa3.php');
        exit;
    }
}

$page_title = "Etapa 2: Escolha do Curso - FIB";

// Cursos disponíveis
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
        
        .course-card {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .course-card:hover {
            border-color: var(--primary-purple);
            transform: translateY(-2px);
        }
        
        .course-card.selected {
            border-color: var(--primary-purple);
            background-color: rgba(111, 66, 193, 0.1);
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
                <div class="step active">2</div>
                <div class="step-line"></div>
                <div class="step inactive">3</div>
                <div class="step-line"></div>
                <div class="step inactive">4</div>
            </div>
            <div class="text-center">
                <h3 class="text-purple fw-bold">Etapa 2: Escolha do Curso</h3>
                <p class="text-muted">Selecione o curso, turno e modalidade</p>
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

                    <form method="POST" id="formEtapa2">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Curso Desejado *</label>
                            <select class="form-select" id="curso" name="curso" required>
                                <option value="">Selecione um curso</option>
                                <?php foreach ($cursos as $key => $nome): ?>
                                    <option value="<?php echo $key; ?>" 
                                            <?php echo (isset($_POST['curso']) && $_POST['curso'] == $key) ? 'selected' : ''; ?>>
                                        <?php echo $nome; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Turno *</label>
                                <div class="mt-2">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="turno" id="turno_manha" value="manha" 
                                               <?php echo (isset($_POST['turno']) && $_POST['turno'] == 'manha') ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="turno_manha">
                                            <i class="fas fa-sun text-warning me-2"></i>Manhã (07:00 - 12:00)
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="turno" id="turno_tarde" value="tarde"
                                               <?php echo (isset($_POST['turno']) && $_POST['turno'] == 'tarde') ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="turno_tarde">
                                            <i class="fas fa-cloud-sun text-info me-2"></i>Tarde (13:00 - 18:00)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="turno" id="turno_noite" value="noite"
                                               <?php echo (isset($_POST['turno']) && $_POST['turno'] == 'noite') ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="turno_noite">
                                            <i class="fas fa-moon text-primary me-2"></i>Noite (19:00 - 23:00)
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Modalidade *</label>
                                <div class="mt-2">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="modalidade" id="modalidade_presencial" value="presencial"
                                               <?php echo (isset($_POST['modalidade']) && $_POST['modalidade'] == 'presencial') ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="modalidade_presencial">
                                            <i class="fas fa-university text-purple me-2"></i>Presencial
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="modalidade" id="modalidade_ead" value="ead"
                                               <?php echo (isset($_POST['modalidade']) && $_POST['modalidade'] == 'ead') ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="modalidade_ead">
                                            <i class="fas fa-laptop text-success me-2"></i>EAD (Ensino a Distância)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="modalidade" id="modalidade_hibrido" value="hibrido"
                                               <?php echo (isset($_POST['modalidade']) && $_POST['modalidade'] == 'hibrido') ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="modalidade_hibrido">
                                            <i class="fas fa-blender text-info me-2"></i>Híbrido (Presencial + EAD)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="semestre_ingresso" class="form-label fw-bold">Semestre de Ingresso *</label>
                                <select class="form-select" id="semestre_ingresso" name="semestre_ingresso" required>
                                    <option value="">Selecione</option>
                                    <option value="2024-1" <?php echo (isset($_POST['semestre_ingresso']) && $_POST['semestre_ingresso'] == '2024-1') ? 'selected' : ''; ?>>2024/1</option>
                                    <option value="2024-2" <?php echo (isset($_POST['semestre_ingresso']) && $_POST['semestre_ingresso'] == '2024-2') ? 'selected' : ''; ?>>2024/2</option>
                                    <option value="2025-1" <?php echo (isset($_POST['semestre_ingresso']) && $_POST['semestre_ingresso'] == '2025-1') ? 'selected' : ''; ?>>2025/1</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="campus" class="form-label fw-bold">Campus de Preferência</label>
                                <select class="form-select" id="campus" name="campus">
                                    <option value="">Selecione</option>
                                    <option value="bauru" <?php echo (isset($_POST['campus']) && $_POST['campus'] == 'bauru') ? 'selected' : ''; ?>>Bauru - Campus Principal</option>
                                    <option value="lins" <?php echo (isset($_POST['campus']) && $_POST['campus'] == 'lins') ? 'selected' : ''; ?>>Lins - Unidade Avançada</option>
                                    <option value="jau" <?php echo (isset($_POST['campus']) && $_POST['campus'] == 'jau') ? 'selected' : ''; ?>>Jaú - Unidade Avançada</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="observacoes" class="form-label fw-bold">Observações ou Necessidades Especiais</label>
                            <textarea class="form-control" id="observacoes" name="observacoes" rows="3" 
                                      placeholder="Descreva qualquer necessidade especial ou observação importante..."><?php echo isset($_POST['observacoes']) ? htmlspecialchars($_POST['observacoes']) : ''; ?></textarea>
                        </div>

                        <div class="text-center mt-4">
                            <a href="etapa1.php" class="btn btn-outline-secondary me-3">
                                <i class="fas fa-arrow-left me-2"></i>Etapa Anterior
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
        // Validação adicional para turno baseado no curso
        document.getElementById('curso').addEventListener('change', function() {
            const curso = this.value;
            const turnoInputs = document.querySelectorAll('input[name="turno"]');
            
            // Alguns cursos podem ter restrições de turno
            if (curso === 'medicina') {
                // Medicina geralmente é integral
                document.getElementById('turno_manha').disabled = false;
                document.getElementById('turno_tarde').disabled = true;
                document.getElementById('turno_noite').disabled = true;
            } else {
                // Habilitar todos os turnos para outros cursos
                turnoInputs.forEach(input => {
                    input.disabled = false;
                });
            }
        });

        // Validação de modalidade baseada no curso
        document.getElementById('curso').addEventListener('change', function() {
            const curso = this.value;
            const modalidadeInputs = document.querySelectorAll('input[name="modalidade"]');
            
            // Cursos práticos podem ter restrições de modalidade
            if (curso === 'medicina' || curso === 'odontologia' || curso === 'enfermagem') {
                document.getElementById('modalidade_presencial').disabled = false;
                document.getElementById('modalidade_ead').disabled = true;
                document.getElementById('modalidade_hibrido').disabled = false;
            } else {
                // Habilitar todas as modalidades para outros cursos
                modalidadeInputs.forEach(input => {
                    input.disabled = false;
                });
            }
        });
    </script>
</body>
</html>

