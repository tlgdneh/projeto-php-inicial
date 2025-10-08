Sistema de Inscrição Online para Instituição de Ensino

Este é um projeto de demonstração de um sistema de inscrição online multi-etapas, desenvolvido em PHP. O sistema guia o usuário através de um formulário de 4 passos para se inscrever em um curso, utilizando sessões PHP para persistir os dados entre as etapas.




✨ Funcionalidades

•
Formulário Multi-Etapas: O processo de inscrição é dividido em 4 fases claras e objetivas.

•
Validação de Dados: Validação em tempo real (no lado do servidor) para garantir que os dados inseridos em cada etapa sejam válidos.

•
Persistência com Sessões: Os dados do usuário são armazenados de forma segura em sessões PHP, permitindo a navegação entre as etapas sem perda de informação.

•
Design Responsivo: Interface construída com Bootstrap 5, garantindo uma boa experiência em desktops e dispositivos móveis.

•
Página de Confirmação: Antes de finalizar, o usuário pode revisar todos os dados inseridos.

•
Simulação de Processo Real: O sistema simula a geração de um número de protocolo ao final da inscrição.

🚀 Como Executar o Projeto

Para executar este projeto localmente, você precisará de um ambiente de servidor web com suporte a PHP, como XAMPP, WAMP ou MAMP.

1.
Clone o Repositório

2.
Mova a Pasta do Projeto

3.
Inicie o Servidor

4.
Acesse no Navegador

📋 Fluxo do Sistema

O sistema é composto por uma página inicial e quatro etapas principais:

Arquivo
Descrição
index.php
Página Inicial: Apresenta o sistema, descreve as etapas e serve como ponto de partida para a inscrição.
etapa1.php
Dados Pessoais: Coleta informações básicas do candidato, como nome, CPF, RG, e informações de contato.
etapa2.php
Escolha do Curso: Permite ao usuário selecionar o curso desejado, o turno e a modalidade de ensino.
etapa3.php
Pagamento: Simula a escolha da forma e do plano de pagamento da matrícula.
etapa4.php
Confirmação e Finalização: Exibe um resumo de todos os dados para revisão e, após a confirmação, gera um número de protocolo, finalizando o processo.


🛠️ Tecnologias Utilizadas

•
Backend: PHP

•
Frontend: HTML5, CSS3

•
Frameworks e Bibliotecas:

•
Bootstrap 5: Para a estrutura e o estilo da interface.

•
Font Awesome: Para os ícones.



📝 Observações Importantes

•
Projeto de Demonstração: Este sistema é um protótipo e não deve ser usado em um ambiente de produção sem modificações.

•
Sem Banco de Dados: Os dados da inscrição são armazenados temporariamente em sessões PHP e não são persistidos em um banco de dados. A etapa de confirmação apenas simula o sucesso da operação.

•
Segurança: As validações de pagamento e outras lógicas de negócio são simplificadas para fins de demonstração.

