# 🛒 E-commerce PHP - Sistema de Gestão

Sistema completo de e-commerce desenvolvido em PHP, contando com um painel de administração estruturado e uma área dedicada ao usuário final. O projeto inclui desde a modelagem do banco de dados até a lógica de carrinho de compras.

## 🚀 Funcionalidades
- **Painel Administrativo (`/admin`):**
  - Sistema de login e controle de sessão seguro.
  - Gestão completa (CRUD) de Categorias e Produtos.
- **Área do Usuário (`/user`):**
  - Vitrine de produtos e integração com Carrinho de Compras (`carrinho.php`).
- **Banco de Dados Relacional:**
  - Scripts `.sql` para criação da estrutura inicial (`sistema.sql`), adição de categorias (`add_category_schema.sql`) e criação do usuário administrador (`create_admin_user.sql`).

## 🛠️ Tecnologias Utilizadas
- **PHP** (Lógica de backend, controle de sessões e roteamento)
- **SQL** (Modelagem e manipulação do banco de dados)
- **HTML/CSS** (Estruturação visual)

## 📂 Estrutura do Projeto

```text
/admin                   # Lógica do painel de controle (Login, Categorias, Produtos)
/user                    # Interface do cliente e Carrinho de compras
header.php               # Componente visual superior
footer.php               # Componente visual inferior
sistema.sql              # Dump principal da estrutura do banco
add_category_schema.sql  # Script de atualização da tabela de categorias
create_admin_user.sql    # Script de inserção do admin padrão
