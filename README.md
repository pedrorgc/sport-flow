# 🏅 SportFlow | Sistema de Gestão Esportiva

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)

> Projeto desenvolvido para a disciplina de Programação Web.

O **SportFlow** é uma plataforma web "White Label" desenvolvida para centralizar e modernizar a gestão esportiva municipal. O sistema permite o controle de atletas, organização de eventos com estatísticas e a reserva de espaços esportivos, tudo em uma interface ágil e responsiva.

---

## 🚀 Funcionalidades (MVP)

### 👥 Módulo de Atletas
* Cadastro e gestão de atletas vinculados a diferentes modalidades esportivas.
* Filtros rápidos por modalidade e categoria (ex: Sub-15, Adulto).

### 🏆 Módulo de Eventos e Competições
* Criação de campeonatos esportivos.
* Inscrição de atletas em eventos com validação de duplicidade (um atleta não pode ser inscrito duas vezes no mesmo evento).
* Lançamento de resultados (posição, tempo ou pontuação).
* Geração automática de pódio e classificação.

### 🏟️ Módulo de Espaços (Reservas)
* Cadastro de infraestrutura esportiva (ginásios, quadras, campos).
* Sistema de agendamento de espaços com **validação de conflito de horários** (impede reservas simultâneas no mesmo local).

### 📊 Dashboard e Relatórios
* Painel administrativo com estatísticas gerais do município (total de atletas, eventos ativos, etc.).

---

## 🛠️ Tecnologias Utilizadas

A arquitetura do projeto segue o padrão **MVC (Model-View-Controller)**.

* **Backend:** PHP 8.x com [Laravel 11.x](https://laravel.com/)
* **Frontend:** Blade Templates, HTML5, CSS3, [Bootstrap 5](https://getbootstrap.com/)
* **Banco de Dados:** MySQL
* **Autenticação:** Laravel Breeze

---

## ⚙️ Pré-requisitos

Antes de começar, certifique-se de ter as seguintes ferramentas instaladas na sua máquina:
* [PHP >= 8.2](https://www.php.net/)
* [Composer](https://getcomposer.org/)
* [Node.js e NPM](https://nodejs.org/) (para compilar os assets do Bootstrap)
* Servidor MySQL (XAMPP, WAMP, Docker ou equivalente)

---

## 💻 Como Rodar o Projeto Localmente

Siga os passos abaixo para clonar e executar o SportFlow no seu ambiente de desenvolvimento:

**1. Clone o repositório:**
```bash
git clone [https://github.com/SEU_USUARIO/sportflow.git](https://github.com/SEU_USUARIO/sportflow.git)
cd sportflow
```

**2. Instale as dependências do PHP:**
```bash
composer install
```

**3. Instale as dependências do Node (Frontend):**
```bash
npm install
```

**4. Configure o ambiente:**
* Crie uma cópia do arquivo .env.example e renomeie para .env.
```bash
cp .env.example .env
```

* No arquivo .env, configure as credenciais do seu banco de dados local:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sportflow_db
DB_USERNAME=root
DB_PASSWORD=
```

**5. Gere a chave da aplicação:**
```bash
php artisan key:generate
```

**6. Execute as Migrations (Criação das tabelas no banco):**
```bash
php artisan migrate
```

**7. Compile os assets do front-end:**
```bash
npm run build
```

**8. Inicie o servidor local:**
```bash
php artisan serve
```
