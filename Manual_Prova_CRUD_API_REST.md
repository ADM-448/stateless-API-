# 📘 Manual de Sobrevivência: CRUD API REST Stateless (Aluno + Professor)

> **Modelo:** Backend Laravel (API) separado do Frontend (HTML + JS puro). Sem login, sem Sanctum, sem CSS. Esqueleto puro para decorar e aplicar rápido na prova.

---

## 🗂️ Estrutura de Pastas do Projeto

```
projeto/
├── BACK/          ← Laravel (API REST)
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   ├── AlunoController.php
│   │   │   └── ProfessorController.php
│   │   └── Models/
│   │       ├── Aluno.php
│   │       └── Professor.php
│   ├── database/migrations/
│   │   ├── xxxx_create_alunos_table.php
│   │   └── xxxx_create_professors_table.php
│   └── routes/
│       └── api.php
│
└── FRONT/         ← HTML + JS puro
    ├── index.html         ← Lista Alunos
    ├── form.html          ← Formulário Aluno (criar/editar)
    ├── professores.html   ← Lista Professores
    └── form_prof.html     ← Formulário Professor (criar/editar)
```

---

## PARTE 1: O BACKEND (LARAVEL API)

### Passo 1: Gerar os Kits Completos

No terminal, dentro da pasta `BACK/`, rode **um comando por model**:

```bash
php artisan make:model Aluno -mcr
php artisan make:model Professor -mcr
```

> O flag `-mcr` gera automaticamente: **M**igration + **C**ontroller (Resource) + **M**odel.

---

### Passo 2: Migrations (Banco de Dados)

#### `database/migrations/xxxx_create_alunos_table.php`
```php
public function up()
{
    Schema::create('alunos', function (Blueprint $table) {
        $table->id();
        $table->string('nome');
        $table->string('email');
        $table->integer('idade');
        $table->timestamps();
    });
}
```

#### `database/migrations/xxxx_create_professors_table.php`
```php
public function up()
{
    Schema::create('professors', function (Blueprint $table) {
        $table->id();
        $table->string('nome');
        $table->string('turma');
        $table->boolean('legal')->default(0); // 0 = Sim, 1 = Não
        $table->timestamps();
    });
}
```

Rode no terminal para criar as tabelas:
```bash
php artisan migrate
```

---

### Passo 3: Models (Fillable)

#### `app/Models/Aluno.php`
```php
class Aluno extends Model
{
    protected $fillable = ['nome', 'email', 'idade'];
}
```

#### `app/Models/Professor.php`
```php
class Professor extends Model
{
    protected $fillable = ['nome', 'turma', 'legal'];
}
```

---

### Passo 4: Rotas da API

#### `routes/api.php`
```php
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\ProfessorController;

// 1 linha = 5 rotas CRUD automáticas para cada recurso
Route::apiResource('alunos', AlunoController::class);
Route::apiResource('professores', ProfessorController::class);
```

> **Rotas geradas automaticamente pelo `apiResource`:**
>
> | Método | URL | Ação |
> |--------|-----|------|
> | GET | `/api/alunos` | index (listar todos) |
> | POST | `/api/alunos` | store (criar) |
> | GET | `/api/alunos/{id}` | show (buscar um) |
> | PUT | `/api/alunos/{id}` | update (editar) |
> | DELETE | `/api/alunos/{id}` | destroy (deletar) |
>
> *(O mesmo vale para `/api/professores`)*

---

### Passo 5: Controllers

#### `app/Http/Controllers/AlunoController.php`
```php
namespace App\Http\Controllers;
use App\Models\Aluno;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    // 1. LISTAR TODOS (GET /api/alunos)
    public function index()
    {
        return response()->json(Aluno::all());
    }

    // 2. CRIAR NOVO (POST /api/alunos)
    public function store(Request $request)
    {
        $aluno = Aluno::create($request->all());
        return response()->json(['mensagem' => 'Aluno criado!', 'aluno' => $aluno], 201);
    }

    // 3. BUSCAR UM (GET /api/alunos/{id})
    public function show(string $id)
    {
        $aluno = Aluno::find($id);
        if (!$aluno) return response()->json(['erro' => 'Não encontrado'], 404);
        return response()->json($aluno);
    }

    // 4. ATUALIZAR (PUT /api/alunos/{id})
    public function update(Request $request, string $id)
    {
        $aluno = Aluno::find($id);
        if (!$aluno) return response()->json(['erro' => 'Não encontrado'], 404);
        $aluno->update($request->all());
        return response()->json(['mensagem' => 'Aluno atualizado!', 'aluno' => $aluno]);
    }

    // 5. DELETAR (DELETE /api/alunos/{id})
    public function destroy(string $id)
    {
        $aluno = Aluno::find($id);
        if (!$aluno) return response()->json(['erro' => 'Não encontrado'], 404);
        $aluno->delete();
        return response()->json(['mensagem' => 'Aluno deletado!']);
    }
}
```

#### `app/Http/Controllers/ProfessorController.php`
```php
namespace App\Http\Controllers;
use App\Models\Professor;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    // 1. LISTAR TODOS (GET /api/professores)
    public function index()
    {
        return response()->json(Professor::all());
    }

    // 2. CRIAR NOVO (POST /api/professores)
    public function store(Request $request)
    {
        $professor = Professor::create($request->all());
        return response()->json(['mensagem' => 'Professor criado!', 'professor' => $professor], 201);
    }

    // 3. BUSCAR UM (GET /api/professores/{id})
    public function show(string $id)
    {
        $professor = Professor::find($id);
        if (!$professor) return response()->json(['erro' => 'Não encontrado'], 404);
        return response()->json($professor);
    }

    // 4. ATUALIZAR (PUT /api/professores/{id})
    public function update(Request $request, string $id)
    {
        $professor = Professor::find($id);
        if (!$professor) return response()->json(['erro' => 'Não encontrado'], 404);
        $professor->update($request->all());
        return response()->json(['mensagem' => 'Professor atualizado!', 'professor' => $professor]);
    }

    // 5. DELETAR (DELETE /api/professores/{id})
    public function destroy(string $id)
    {
        $professor = Professor::find($id);
        if (!$professor) return response()->json(['erro' => 'Não encontrado'], 404);
        $professor->delete();
        return response()->json(['mensagem' => 'Professor deletado!']);
    }
}
```

Suba o servidor Laravel:
```bash
php artisan serve
```
> A API estará disponível em `http://localhost:8000`

---

## PARTE 2: O FRONTEND (HTML + JS PURO)

Crie uma pasta separada chamada `FRONT/` com os arquivos abaixo.

> **Regra de ouro do `form.html`:** ele serve para criar E editar.
> A página recebe `?id=` na URL quando vem do botão Editar.
> Se tiver `id` → busca os dados e usa PUT. Se não tiver → usa POST.

---

### 📄 `index.html` — Lista e Deleta Alunos

```html
<!DOCTYPE html>
<html lang="pt-br">
<body>
    <h1>Lista de Alunos</h1>
    <a href="form.html">Criar</a> | <a href="professores.html">Professores</a>
    <ul id="lista"></ul>

    <script>
        const API = 'http://localhost:8000/api/alunos';

        async function carregar() {
            const lista = await (await fetch(API)).json();
            const ul = document.getElementById('lista');
            ul.innerHTML = '';
            lista.forEach(a => {
                const li = document.createElement('li');
                li.innerHTML = `${a.nome} - ${a.email} - ${a.idade} anos
                    <button onclick="deletar(${a.id})">Apagar</button>
                    <a href="form.html?id=${a.id}"><button>Editar</button></a>`;
                ul.appendChild(li);
            });
        }

        async function deletar(id) {
            await fetch(API + '/' + id, { method: 'DELETE' });
            carregar();
        }

        carregar();
    </script>
</body>
</html>
```

---

### 📄 `form.html` — Criar e Editar Aluno

```html
<!DOCTYPE html>
<html lang="pt-br">
<body>
    <h1>Aluno</h1>
    <input type="text"   id="nome"  placeholder="Nome"><br><br>
    <input type="email"  id="email" placeholder="E-mail"><br><br>
    <input type="number" id="idade" placeholder="Idade"><br><br>
    <button onclick="salvar()">Salvar</button>
    <a href="index.html">Voltar</a>

    <script>
        const API = 'http://localhost:8000/api/alunos';
        const id  = new URLSearchParams(window.location.search).get('id');

        if (id) {
            fetch(API + '/' + id).then(r => r.json()).then(a => {
                document.getElementById('nome').value  = a.nome;
                document.getElementById('email').value = a.email;
                document.getElementById('idade').value = a.idade;
            });
        }

        async function salvar() {
            await fetch(id ? API + '/' + id : API, {
                method:  id ? 'PUT' : 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    nome:  document.getElementById('nome').value,
                    email: document.getElementById('email').value,
                    idade: document.getElementById('idade').value,
                })
            });
            window.location.href = 'index.html';
        }
    </script>
</body>
</html>
```

---

### 📄 `professores.html` — Lista e Deleta Professores

```html
<!DOCTYPE html>
<html lang="pt-br">
<body>
    <h1>Lista de Professores</h1>
    <a href="form_prof.html">Criar</a> | <a href="index.html">Alunos</a>
    <ul id="lista"></ul>

    <script>
        const API = 'http://localhost:8000/api/professores';

        async function carregar() {
            const lista = await (await fetch(API)).json();
            const ul = document.getElementById('lista');
            ul.innerHTML = '';
            lista.forEach(p => {
                const li = document.createElement('li');
                li.innerHTML = `${p.nome} - Turma: ${p.turma} - Legal: ${p.legal == 0 ? 'Sim' : 'Não'}
                    <button onclick="deletar(${p.id})">Apagar</button>
                    <a href="form_prof.html?id=${p.id}"><button>Editar</button></a>`;
                ul.appendChild(li);
            });
        }

        async function deletar(id) {
            await fetch(API + '/' + id, { method: 'DELETE' });
            carregar();
        }

        carregar();
    </script>
</body>
</html>
```

---

### 📄 `form_prof.html` — Criar e Editar Professor

```html
<!DOCTYPE html>
<html lang="pt-br">
<body>
    <h1>Professor</h1>
    <input type="text" id="nome"  placeholder="Nome"><br><br>
    <input type="text" id="turma" placeholder="Turma"><br><br>
    <select id="legal">
        <option value="0">Sim</option>
        <option value="1">Não</option>
    </select><br><br>
    <button onclick="salvar()">Salvar</button>
    <a href="professores.html">Voltar</a>

    <script>
        const API = 'http://localhost:8000/api/professores';
        const id  = new URLSearchParams(window.location.search).get('id');

        if (id) {
            fetch(API + '/' + id).then(r => r.json()).then(p => {
                document.getElementById('nome').value  = p.nome;
                document.getElementById('turma').value = p.turma;
                document.getElementById('legal').value = p.legal;
            });
        }

        async function salvar() {
            await fetch(id ? API + '/' + id : API, {
                method:  id ? 'PUT' : 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    nome:  document.getElementById('nome').value,
                    turma: document.getElementById('turma').value,
                    legal: document.getElementById('legal').value,
                })
            });
            window.location.href = 'professores.html';
        }
    </script>
</body>
</html>
```

---

### 📄 `form.html` — Criar e Editar Aluno

```html
<!DOCTYPE html>
<html lang="pt-br">
<body>
    <h1 id="titulo">Novo Aluno</h1>

    <input type="text" id="nome" placeholder="Nome"><br><br>
    <input type="email" id="email" placeholder="E-mail"><br><br>
    <input type="number" id="idade" placeholder="Idade"><br><br>
    <button onclick="salvar()">Salvar</button>
    <br><br>
    <a href="index.html">Voltar para Lista</a>

    <script>
        const URL_API = 'http://localhost:8000/api/alunos';

        // Pega o ?id= da URL (se vier da edição)
        const params = new URLSearchParams(window.location.search);
        const id = params.get('id');

        // Se veio com ID, carrega os dados para edição
        if (id) {
            document.getElementById('titulo').innerText = 'Editar Aluno';
            fetch(URL_API + '/' + id)
                .then(r => r.json())
                .then(aluno => {
                    document.getElementById('nome').value = aluno.nome;
                    document.getElementById('email').value = aluno.email;
                    document.getElementById('idade').value = aluno.idade;
                });
        }

        // SALVAR: POST (criar) ou PUT (editar)
        async function salvar() {
            const dados = {
                nome: document.getElementById('nome').value,
                email: document.getElementById('email').value,
                idade: document.getElementById('idade').value,
            };

            const metodo = id ? 'PUT' : 'POST';
            const url    = id ? URL_API + '/' + id : URL_API;

            const resposta = await fetch(url, {
                method: metodo,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            if (resposta.status === 200 || resposta.status === 201) {
                alert('Salvo com sucesso!');
                window.location.href = 'index.html';
            } else {
                alert('Erro ao salvar.');
            }
        }
    </script>
</body>
</html>
```

---

### 📄 `professores.html` — Lista e Deleta Professores

```html
<!DOCTYPE html>
<html lang="pt-br">
<body>
    <h1>Lista de Professores</h1>
    <a href="form_prof.html">Criar Novo Professor</a> |
    <a href="index.html">Ver Alunos</a>

    <ul id="lista">
        <li>Carregando...</li>
    </ul>

    <script>
        const URL_API = 'http://localhost:8000/api/professores';

        // LISTAR (GET)
        async function carregarProfessores() {
            try {
                const resposta = await fetch(URL_API);
                const professores = await resposta.json();

                const ul = document.getElementById('lista');
                ul.innerHTML = '';

                professores.forEach(professor => {
                    const li = document.createElement('li');
                    li.innerHTML = `
                        ${professor.nome} - Turma: ${professor.turma} - Legal: ${professor.legal == 0 ? 'Sim' : 'Não'}
                        <button onclick="deletarProfessor(${professor.id})">Apagar</button>
                        <a href="form_prof.html?id=${professor.id}"><button>Editar</button></a>
                    `;
                    ul.appendChild(li);
                });
            } catch (error) {
                document.getElementById('lista').innerHTML = '<li>Erro ao conectar na API</li>';
            }
        }

        // DELETAR (DELETE)
        async function deletarProfessor(id) {
            await fetch(URL_API + '/' + id, { method: 'DELETE' });
            alert('Professor deletado!');
            carregarProfessores();
        }

        carregarProfessores();
    </script>
</body>
</html>
```

---

### 📄 `form_prof.html` — Criar e Editar Professor

```html
<!DOCTYPE html>
<html lang="pt-br">
<body>
    <h1 id="titulo">Novo Professor</h1>

    <input type="text" id="nome" placeholder="Nome"><br><br>
    <input type="text" id="turma" placeholder="Turma"><br><br>
    <label>Legal?</label>
    <select id="legal">
        <option value="0">Sim</option>
        <option value="1">Não</option>
    </select><br><br>
    <button onclick="salvar()">Salvar</button>
    <br><br>
    <a href="professores.html">Voltar para Lista</a>

    <script>
        const URL_API = 'http://localhost:8000/api/professores';

        const params = new URLSearchParams(window.location.search);
        const id = params.get('id');

        if (id) {
            document.getElementById('titulo').innerText = 'Editar Professor';
            fetch(URL_API + '/' + id)
                .then(r => r.json())
                .then(prof => {
                    document.getElementById('nome').value  = prof.nome;
                    document.getElementById('turma').value = prof.turma;
                    document.getElementById('legal').value = prof.legal;
                });
        }

        async function salvar() {
            const dados = {
                nome:  document.getElementById('nome').value,
                turma: document.getElementById('turma').value,
                legal: document.getElementById('legal').value,
            };

            const metodo = id ? 'PUT' : 'POST';
            const url    = id ? URL_API + '/' + id : URL_API;

            const resposta = await fetch(url, {
                method: metodo,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            if (resposta.status === 200 || resposta.status === 201) {
                alert('Salvo com sucesso!');
                window.location.href = 'professores.html';
            } else {
                alert('Erro ao salvar.');
            }
        }
    </script>
</body>
</html>
```

---

## 🧠 Tabela Resumo: O que cada coisa faz

| Arquivo | Responsabilidade |
|---------|-----------------|
| `Migration` | Define as colunas da tabela no banco |
| `Model` | Define quais campos podem ser salvos (`$fillable`) |
| `api.php` | Registra as rotas da API (`apiResource`) |
| `Controller` | Lógica de cada ação (listar, criar, editar, deletar) |
| `index.html` | Faz GET + DELETE via `fetch()` |
| `form.html` | Faz POST (criar) ou PUT (editar) via `fetch()` |

---

## ⚡ Checklist Rápido para a Prova

```
[ ] php artisan make:model NomeModel -mcr
[ ] Preencher a Migration com as colunas
[ ] php artisan migrate
[ ] Preencher o $fillable no Model
[ ] Registrar Route::apiResource no api.php
[ ] Preencher os 5 métodos no Controller (sempre retornar JSON)
[ ] Criar index.html com fetch GET e DELETE
[ ] Criar form.html com fetch POST e PUT (detectar ?id= na URL)
```

---

## 🐛 Dica: Resolver CORS (Erro de acesso entre front e back)

Se o navegador bloquear o `fetch()` com erro de CORS, abra `bootstrap/app.php` no Laravel e adicione:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->validateCsrfTokens(except: [
        'api/*',
    ]);
})
```

> No Laravel 11, o CORS já vem liberado de fábrica para rotas `/api/*`. Se ainda assim travar, rode:
> ```bash
> php artisan config:publish cors
> ```
