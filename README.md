# SGOS — Sistema de Gerenciamento de Ordens de Serviço

Projeto acadêmico desenvolvido para a disciplina de Análise e Desenvolvimento de Sistemas.

## Funcionalidades
- Login e encerramento de sessão.
- Cadastro, consulta, edição e exclusão de clientes.
- Cadastro, consulta, edição e exclusão de serviços.
- Abertura, consulta, edição e exclusão de ordens de serviço.
- Alteração do status das ordens.
- Painel com indicadores de ordens abertas, em andamento e concluídas.
- Cadastro e listagem de usuários.

## Tecnologias
PHP, MySQL, HTML, CSS e JavaScript. Ambiente local recomendado: XAMPP.

## Como executar no XAMPP
1. Instale o XAMPP e inicie Apache e MySQL.
2. Copie os arquivos do repositório para `C:\xampp\htdocs\sgos`.
3. Abra o phpMyAdmin em `http://localhost/phpmyadmin`.
4. Importe `database/sgos.sql` para criar o banco e as tabelas.
5. Confira `config/conexao.php`. No XAMPP padrão, normalmente: servidor `localhost`, banco `sgos`, usuário `root` e senha vazia.
6. Acesse `http://localhost/sgos/login.php`.
7. Cadastre o primeiro usuário pela tela de cadastro de usuários.

## Estrutura
- `assets/css/`: estilos.
- `config/`: conexão com o banco e sessões.
- `clientes/`: gerenciamento de clientes.
- `servicos/`: gerenciamento de serviços.
- `ordens/`: gerenciamento de ordens de serviço.
- `usuarios/`: cadastro e listagem de usuários.
- `database/`: script SQL.

## Observação
Projeto acadêmico. Antes de uso em produção, implemente controles adicionais de autorização, proteção CSRF, validação de entradas e configuração segura das credenciais.
