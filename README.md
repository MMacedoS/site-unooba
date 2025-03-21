Visão Geral do Projeto
Este é um sistema de gerenciamento de conteúdo (CMS) para a "UNOOBA" (União dos Ópticos e Optometristas do Estado da Bahia), uma organização para profissionais de óptica e optometria na Bahia.
Arquitetura
O projeto segue uma arquitetura MVC personalizada com:

Models: Localizados em src/Models/ - representam estruturas de dados
Views: Localizados em src/Resources/Views/ - gerenciam a apresentação
Controllers: Localizados em src/Controllers/ - processam entradas do usuário
Repositories: Localizados em src/Repositories/ - lidam com a lógica de acesso aos dados
Interfaces: Localizados em src/Interfaces/ - definem contratos para repositórios

Principais Recursos

Sistema de autenticação de usuários
Painel administrativo
Recursos de gerenciamento de conteúdo:

Gerenciamento de setores
Gerenciamento de parceiros
Gerenciamento de colaboradores
Gerenciamento de slides
Gerenciamento de páginas
Gerenciamento de linha do tempo
Gerenciamento de documentos


Site público com seções para:

Página inicial
Página sobre
Página de diretoria/liderança



Aspectos Técnicos Notáveis

Injeção de Dependência: Implementada através de uma classe Container personalizada
Padrão Repository: Para acesso a dados
Design Baseado em Interfaces: Usa interfaces para melhor desacoplamento
Router Personalizado: Para roteamento de URL
Autenticação: Autenticação personalizada baseada em JWT
Geração de UUID: Para identificação de entidades
Upload de Arquivos: Para imagens e documentos

Frontend

Usa Bootstrap para estilização
Possui templates separados para admin e site público
Inclui JavaScript para elementos interativos
Usa bibliotecas como Dropzone.js para upload de arquivos

Pontos de Entrada

index.php: Ponto de entrada principal que inicializa a aplicação
src/Routers/web.php: Define todas as rotas para a aplicação

Pontos Fortes

Estrutura de código bem organizada
Clara separação de responsabilidades
Uso de interfaces para melhor manutenção
Design modular para fácil extensão
Recursos básicos de segurança implementados
