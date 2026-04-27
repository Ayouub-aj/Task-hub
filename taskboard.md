# 📝 Task-Hub — Laravel Task Manager
**SCRUM Board:** 27/04/2026 → 01/05/2026 | **Sprint Deadline:** Vendredi 01/05 – 17:00

---

## 📋 Legend

| Label | Meaning |
|-------|---------|
| `ARCH` | Architecture / Setup |
| `DOCKER` | Docker / Infrastructure |
| `AUTH` | Authentication |
| `TASK` | Task Management |
| `FILTER` | Filtering |
| `QA` | Code Quality / Security |
| `DEBUG` | Debugging Tools |
| `DOC` | Documentation / Livrables |
| `BONUS` | Bonus Feature |

---

## 🏃 Sprint 1 — Infrastructure & Setup
**Objectif:** Docker environment up, Laravel initialized, database ready, debugging tools installed
**Durée:** Jour 1 — Lundi 27/04

| Done | # | Task | Label | Priority | Time | Detailed Implementation & Files |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| [ ] | T-01 | Initialize GitHub repo + branches | `ARCH` | High | 0.3h | **Action:**<br>- Create branches: `feature/auth`, `feature/task-crud`, `feature/filters`<br>- `.gitignore`: ignore `vendor/`, `.env`, `node_modules/`<br>- `README.md`: initial skeleton |
| [ ] | T-02 | Install Laravel via Sail into cloned repo | `DOCKER` | High | 1h | **Action:**<br>- `composer create-project laravel/laravel task-hub-temp`<br>- Copy files into cloned repo, restore `README.md` and `LICENSE`<br>- `composer require laravel/sail --dev`<br>- `php artisan sail:install` → choose **mysql** |
| [ ] | T-03 | Start Docker + verify environment | `DOCKER` | High | 0.5h | **Action:**<br>- `./vendor/bin/sail up -d`<br>- Verify `http://localhost` → Laravel welcome page<br>- Add alias: `alias sail='./vendor/bin/sail'` |
| [ ] | T-04 | Configure `.env` (DB via Sail) | `ARCH` | High | 0.3h | **Files to Edit:**<br>- `.env`: `DB_HOST=mysql`, `DB_DATABASE=task_hub`, `DB_USERNAME=sail`, `DB_PASSWORD=password`<br>- `APP_NAME=Task-Hub`, `APP_URL=http://localhost` |
| [ ] | T-05 | Install Tailwind CSS (v4) | `ARCH` | High | 0.5h | **Action:**<br>- `sail npm install`<br>- `sail npm install -D @tailwindcss/vite`<br>- Update `vite.config.js` with `@tailwindcss/vite` plugin<br>- `resources/css/app.css`: `@import 'tailwindcss';`<br>- `sail npm run dev` |
| [ ] | T-06 | Migration — Table `categories` | `ARCH` | High | 0.5h | **Files to Create:**<br>- `sail artisan make:migration create_categories_table`<br>- Columns: `id`, `name`, `timestamps` |
| [ ] | T-07 | Migration — Table `tasks` | `ARCH` | High | 1h | **Files to Create:**<br>- `sail artisan make:migration create_tasks_table`<br>- Columns: `id`, `title`, `description` (nullable), `status` (enum: to_do/in_progress/completed, default: to_do), `priority` (enum: low/medium/high), `due_date` (nullable date), `category_id` (FK), `user_id` (FK), `timestamps` |
| [ ] | T-08 | Models `Task` + `Category` + relationships | `ARCH` | High | 1h | **Files to Create:**<br>- `sail artisan make:model Task`<br>- `sail artisan make:model Category`<br>- `Task`: `$fillable`, `belongsTo(User::class)`, `belongsTo(Category::class)`<br>- `Category`: `$fillable = ['name']`, `hasMany(Task::class)`<br>- `User`: add `hasMany(Task::class)` |
| [ ] | T-09 | Seeders | `ARCH` | High | 1.5h | **Files to Create:**<br>- `CategorySeeder`: 4 categories (Work, Personal, Dev, Urgent)<br>- `UserSeeder`: 2 test accounts with `Hash::make('password')`<br>- `TaskSeeder`: 8 tasks mix of all statuses across users<br>- `sail artisan migrate:fresh --seed` must pass ✅ |
| [ ] | T-10 | Install Laravel Debugbar | `DEBUG` | High | 0.5h | **Action:**<br>- `sail composer require barryvdh/laravel-debugbar --dev`<br>- Verify it appears in `http://localhost`<br>- Confirm SQL panel is visible |
| [ ] | T-11 | Install Laravel Telescope | `DEBUG` | High | 0.5h | **Action:**<br>- `sail composer require laravel/telescope --dev`<br>- `sail artisan telescope:install`<br>- `sail artisan migrate`<br>- Verify `http://localhost/telescope` is accessible |

**Sprint 1 — Definition of Done:**
- [ ] `sail up -d` starts all services without error
- [ ] `http://localhost` shows Laravel + Tailwind working
- [ ] `sail artisan migrate:fresh --seed` runs cleanly
- [ ] Debugbar visible on every page in dev
- [ ] `/telescope` accessible and showing requests

---

## 🏃 Sprint 2 — Authentication (US1, US2)
**Objectif:** Registration, login and logout fully functional
**Durée:** Jour 2 matin — Mardi 28/04
**Branch:** `feature/auth`

| Done | # | Task | Label | Priority | Time | Detailed Implementation & Files |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| [ ] | T-12 | Install Laravel Breeze (Blade) | `AUTH` | High | 0.5h | **Action:**<br>- `sail composer require laravel/breeze --dev`<br>- `sail artisan breeze:install blade`<br>- `sail npm run dev`<br>- `sail artisan migrate` |
| [ ] | T-13 | `US1` — Registration page | `AUTH` | High | 1h | **Files to Verify/Edit:**<br>- `resources/views/auth/register.blade.php`: name, email, password fields, `@csrf`, `@error` messages<br>- `RegisteredUserController@store`: validation + redirect to dashboard<br>**Route:** `GET/POST /register` → `register` |
| [ ] | T-14 | `US2` — Login / Logout | `AUTH` | High | 1h | **Files to Verify/Edit:**<br>- `resources/views/auth/login.blade.php`: email, password, `@csrf`<br>- `AuthenticatedSessionController@store`: `Auth::attempt()` + redirect<br>- `AuthenticatedSessionController@destroy`: `Auth::logout()` + redirect `/`<br>**Routes:** `GET/POST /login`, `POST /logout` |
| [ ] | T-15 | Main layout `layouts/app.blade.php` | `AUTH` | High | 1.5h | **Files to Create/Edit:**<br>- `resources/views/layouts/app.blade.php`: navbar, `@yield('content')`, Vite assets<br>- Navbar: `@auth` → Dashboard + Logout \| `@guest` → Login + Register<br>- Flash message display: `session('success')` |
| [ ] | T-16 | Protect all routes with `auth` middleware | `AUTH` | High | 0.5h | **Files to Edit:**<br>- `routes/web.php`: all task routes under `Route::middleware('auth')->group(...)`<br>- Test direct access to `/tasks/create` without login → redirect `/login` |

**Sprint 2 — Definition of Done:**
- [ ] Registration creates a new user and redirects to dashboard
- [ ] Login with seeded credentials works
- [ ] Logout redirects to `/login`
- [ ] Direct access to `/tasks` without login → redirect `/login`
- [ ] `@auth`/`@guest` in layout shows correct links

---

## 🏃 Sprint 3 — Task CRUD (US3, US4, US5, US6, US7)
**Objectif:** Full task management — list, create, edit, delete, quick status change
**Durée:** Jour 2 après-midi + Jour 3 — Mardi 28/04 → Mercredi 29/04
**Branch:** `feature/task-crud`

| Done | # | Task | Label | Priority | Time | Detailed Implementation & Files |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| [ ] | T-17 | `US3` — Task list (my tasks only) | `TASK` | High | 2h | **Files to Create:**<br>- `sail artisan make:controller TaskController --resource`<br>- `TaskController@index`: `auth()->user()->tasks()->with('category')->get()`<br>- `resources/views/tasks/index.blade.php`: title, category, status badge, due date (red if past), created_at, action buttons<br>**Route:** `GET /tasks` → `tasks.index` |
| [ ] | T-18 | `US4` — Create a task | `TASK` | High | 2h | **Files to Create/Edit:**<br>- `TaskController@create`: pass categories to view<br>- `TaskController@store`: `$request->validate([...])`, `Task::create([..., 'user_id' => auth()->id()])`<br>- `resources/views/tasks/create.blade.php`: title, description, category select, priority select, due_date, `@csrf`<br>**Routes:** `GET /tasks/create` → `tasks.create`, `POST /tasks` → `tasks.store` |
| [ ] | T-19 | `US5` — Edit a task | `TASK` | High | 2h | **Files to Create/Edit:**<br>- `TaskController@edit`: `findOrFail($id)` + ownership check `if ($task->user_id !== auth()->id()) abort(403)`<br>- `TaskController@update`: validate + `$task->update([...])`<br>- `resources/views/tasks/edit.blade.php`: pre-filled form, `@method('PUT')`, `@csrf`<br>**Routes:** `GET /tasks/{task}/edit` → `tasks.edit`, `PUT /tasks/{task}` → `tasks.update` |
| [ ] | T-20 | `US6` — Delete a task | `TASK` | High | 1.5h | **Files to Edit:**<br>- `TaskController@destroy`: ownership check + `$task->delete()` + redirect with flash<br>- `tasks/index.blade.php`: delete form with `@method('DELETE')`, `@csrf`, `onclick="return confirm('Are you sure?')"` <br>**Route:** `DELETE /tasks/{task}` → `tasks.destroy` |
| [ ] | T-21 | `US7` — Quick status change | `TASK` | High | 1.5h | **Files to Create/Edit:**<br>- Add `TaskController@updateStatus`: ownership check + cycle status (to_do → in_progress → completed)<br>- `tasks/index.blade.php`: small form button per task with `@method('PATCH')`, `@csrf`<br>**Route:** `PATCH /tasks/{task}/status` → `tasks.status` |
| [ ] | T-22 | Ownership check on all mutating actions | `QA` | High | 0.5h | **Files to Audit:**<br>- `TaskController@edit`, `@update`, `@destroy`, `@updateStatus`<br>- All must have: `if ($task->user_id !== auth()->id()) abort(403)`<br>- Test: log in as user B and try to edit user A's task → 403 |
| [ ] | T-23 | Verify named routes | `ARCH` | High | 0.3h | **Action:**<br>- `sail artisan route:list`<br>- All task routes named: `tasks.index`, `tasks.create`, `tasks.store`, `tasks.edit`, `tasks.update`, `tasks.destroy`, `tasks.status` |

**Sprint 3 — Definition of Done:**
- [ ] Logged-in user sees ONLY their own tasks
- [ ] Create task with all fields works
- [ ] Edit task (own only) works — 403 on other's tasks
- [ ] Delete with confirmation works
- [ ] Quick status button cycles correctly from list
- [ ] `sail artisan route:list` shows all named routes under `auth` middleware

---

## 🏃 Sprint 4 — Filtering (US8, US9)
**Objectif:** Filter tasks by status and category
**Durée:** Jour 4 matin — Jeudi 30/04
**Branch:** `feature/filters`

| Done | # | Task | Label | Priority | Time | Detailed Implementation & Files |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| [ ] | T-24 | `US8` — Filter by status | `FILTER` | High | 1.5h | **Files to Edit:**<br>- `TaskController@index`: `$query->when($request->status, fn($q, $s) => $q->where('status', $s))`<br>- `tasks/index.blade.php`: filter buttons/tabs for To Do / In Progress / Completed, highlight active<br>**Route:** `GET /tasks?status=to_do` → `tasks.index` |
| [ ] | T-25 | `US9` — Filter by category | `FILTER` | High | 1.5h | **Files to Edit:**<br>- `TaskController@index`: `$query->when($request->category_id, fn($q, $c) => $q->where('category_id', $c))`<br>- `tasks/index.blade.php`: category dropdown filter, preserve status filter in URL<br>**Route:** `GET /tasks?category_id=2` → `tasks.index` |
| [ ] | T-26 | Combined filters (status + category) | `FILTER` | Medium | 1h | **Files to Edit:**<br>- Ensure both filters can be applied simultaneously<br>- `GET /tasks?status=in_progress&category_id=3` returns correct results<br>- Active filter state visible in UI |

**Sprint 4 — Definition of Done:**
- [ ] Filter by status returns only tasks with that status
- [ ] Filter by category returns only tasks from that category
- [ ] Both filters work simultaneously
- [ ] Filtering only applies to the logged-in user's tasks

---

## 🏃 Sprint 5 — Bonus Features
**Objectif:** Implement bonus features for extra credit
**Durée:** Jour 4 après-midi — Jeudi 30/04

| Done | # | Task | Label | Priority | Time | Detailed Implementation & Files |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| [ ] | T-27 | Bonus — Task counter dashboard | `BONUS` | Low | 1h | **Files to Edit:**<br>- `TaskController@index`: pass counts `['to_do' => ..., 'in_progress' => ..., 'completed' => ...]`<br>- `tasks/index.blade.php`: display summary cards at the top (e.g. "3 To Do · 2 In Progress · 5 Completed") |
| [ ] | T-28 | Bonus — Due date highlight in red | `BONUS` | Low | 0.5h | **Files to Edit:**<br>- `tasks/index.blade.php`: `@if($task->due_date && $task->due_date->isPast()) class="text-red-600" @endif`<br>- Make sure `due_date` is cast to `date` in the `Task` model: `'due_date' => 'date'` |
| [ ] | T-29 | Bonus — Pagination | `BONUS` | Low | 0.5h | **Files to Edit:**<br>- `TaskController@index`: replace `->get()` with `->paginate(8)`<br>- `tasks/index.blade.php`: add `{{ $tasks->withQueryString()->links() }}` below table |

---

## 🏃 Sprint 6 — QA, Debugging & Livrables
**Objectif:** Security audit, debugging session prep, README, MCD/MLD, commits check
**Durée:** Jour 5 — Vendredi 01/05

| Done | # | Task | Label | Priority | Time | Detailed Implementation & Files |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| [ ] | T-30 | Audit `$request->validate()` on all forms | `QA` | High | 1h | **Files to Audit:**<br>- `TaskController@store` + `@update`: `title\|required\|max:255`, `description\|nullable`, `status\|required\|in:to_do,in_progress,completed`, `category_id\|required\|exists:categories,id`, `due_date\|nullable\|date`<br>- All auth forms already validated via Breeze |
| [ ] | T-31 | Audit `@csrf` on all forms | `QA` | High | 0.3h | **Action:**<br>- Check `@csrf` in: create task, edit task, delete task, quick status change<br>- Check `@method('PUT')` in edit, `@method('DELETE')` in delete, `@method('PATCH')` in status |
| [ ] | T-32 | Audit `$fillable` on all models | `QA` | High | 0.3h | **Files to Check:**<br>- `Task::$fillable`: all columns except `id` and `timestamps`<br>- `Category::$fillable`: `['name']`<br>- `User::$fillable`: already set by Breeze |
| [ ] | T-33 | Debugbar — Detect N+1 on tasks list | `DEBUG` | High | 1h | **Action:**<br>- Open `/tasks` and check SQL panel in Debugbar<br>- If N+1 detected (many queries for category): fix with `->with('category')`<br>- Confirm query count drops to 2 after fix |
| [ ] | T-34 | Telescope — Trace a full HTTP request | `DEBUG` | High | 1h | **Action:**<br>- Create a task via the form<br>- Open `/telescope` → Requests tab<br>- Find the `POST /tasks` request<br>- Read: payload received, SQL queries executed, any exceptions<br>- Be able to explain the full path: form → route → middleware → controller → DB → response |
| [ ] | T-35 | Full visitor + user flow test | `QA` | High | 0.5h | **Scenarios:**<br>- Access `/tasks` without login → redirect `/login` ✅<br>- Login as User A → create task → edit → quick status → delete ✅<br>- Login as User B → try to edit User A's task → 403 ✅<br>- Filters work correctly per user ✅ |
| [ ] | T-36 | MCD & MLD | `DOC` | High | 1h | **Deadline: Monday 28/04 before 15:00**<br>- MCD: entities (User, Task, Category), attributes, relationships with cardinalities<br>- MLD: tables, primary keys, foreign keys<br>- Must match migrations exactly |
| [ ] | T-37 | `README.md` complete | `DOC` | High | 1h | **Sections:**<br>- Project description<br>- Prerequisites: Docker, Docker Compose<br>- Install: `git clone` → `cp .env.example .env` → `sail up -d` → `sail artisan migrate:fresh --seed`<br>- Test credentials (email + password)<br>- Named routes table<br>- Architecture overview |
| [ ] | T-38 | Git audit — commits & branches | `DOC` | High | 0.3h | **Action:**<br>- Verify ≥ 15 commits with explicit messages<br>- Verify daily commits every worked day<br>- Branches `feature/auth`, `feature/task-crud`, `feature/filters` visible in history<br>- Sample commit messages: `Add Task migration and model`, `Implement status filter`, `Add ownership check before task update` |

**Sprint 6 — Definition of Done:**
- [ ] All forms have `@csrf` and `$request->validate()`
- [ ] All models have `$fillable`
- [ ] N+1 query fixed and confirmed in Debugbar
- [ ] Can trace a request end-to-end in Telescope
- [ ] User isolation confirmed (403 on other's tasks)
- [ ] README complete with install instructions
- [ ] ≥ 15 commits with clear messages

---

## 📦 Final Deliverables Checklist

| Livrable | Critère | Statut |
|----------|---------|--------|
| GitHub Repo | ≥ 15 commits with explicit messages | ⬜ |
| GitHub Repo | Daily commits every worked day | ⬜ |
| GitHub Repo | 3 feature branches visible in history | ⬜ |
| Jira | All User Stories translated into tickets | ⬜ |
| MCD | Entities, attributes, relationships with cardinalities | ⬜ |
| MLD | Tables, PKs, FKs — matches migrations exactly | ⬜ |
| MCD/MLD | Submitted before Monday 28/04 – 15:00 | ⬜ |
| README.md | Installation instructions with Sail/Docker | ⬜ |
| README.md | Test credentials included | ⬜ |
| Migrations | All tables via migrations (zero manual SQL) | ⬜ |
| Seeder | Categories, test users, sample tasks | ⬜ |
| Debugbar | N+1 identified and fixed | ⬜ |
| Telescope | Can read HTTP request, payload, queries, exceptions | ⬜ |

---

## 🏆 Performance Criteria

### Laravel Architecture (40%)
| Critère | Statut |
|---------|--------|
| Named routes — `sail artisan route:list` shows everything | ⬜ |
| All routes grouped under `auth` middleware | ⬜ |
| Eloquent relationships defined and used in controllers | ⬜ |
| Strict separation: logic in Controllers/Models, display in Blade | ⬜ |
| All tables via Migrations (zero manual SQL) | ⬜ |
| Ownership check before any modification or deletion | ⬜ |

### Features (35%)
| Critère | Statut |
|---------|--------|
| Registration / Login / Logout functional | ⬜ |
| Complete CRUD tasks (create, read, update, delete) | ⬜ |
| Quick status change from list | ⬜ |
| Filter by status functional | ⬜ |
| Filter by category functional | ⬜ |
| A user only sees and touches their own tasks | ⬜ |

### Code Quality (25%)
| Critère | Statut |
|---------|--------|
| `$request->validate()` on all forms | ⬜ |
| `@csrf` present on all forms | ⬜ |
| `$fillable` defined in each model | ⬜ |
| Readable code, naming consistent with Laravel conventions | ⬜ |
| ≥ 15 commits with clear messages | ⬜ |

---

## 🎤 Debugging Session Prep

### What you must be able to do
| Competence | Préparé |
|------------|---------|
| Navigate to `/telescope` and read an HTTP request — payload, SQL queries, exceptions | ⬜ |
| Use Debugbar to count queries on a page and detect a performance issue | ⬜ |
| Trace the full path of a request: form → route → middleware → controller → DB → response | ⬜ |
| Find and fix a bug based solely on what the tools show — no blind code searching | ⬜ |

### Key Requests to Trace
| Request | Préparé |
|---------|---------|
| `POST /tasks` — Create a task (payload, validation, insert query) | ⬜ |
| `GET /tasks` — List with filters (how many queries? N+1?) | ⬜ |
| `PATCH /tasks/{id}/status` — Quick status change (ownership check visible?) | ⬜ |
| `DELETE /tasks/{id}` — Delete (403 test on another user's task) | ⬜ |

---

*Dernière mise à jour : 27/04/2026*