---
applyTo: '**'
---

PT. TABLELINK DIGITAL INOVASI
Ruko Arcade, MG Office Tower 6th floor. Jl. Pantai Indah Utara 2 Blok 3 MA & 3 MB, 
Kapuk Muara, Kec. Penjaringan, Jakarta Utara, Jakarta 14460
Below is a technical documentation / project specification written in English, based 
strictly on your requirements. This can be used as a README.md or Technical Test 
Documentation.
Tablelink Technical Test Documentation
1. Overview
This project is a Laravel 12 web application that implements user authentication, 
authorization, and management, following REST API standards, MVC architecture, and 
Dockerized deployment.
The application supports two roles:
• Admin
• User
Admins have access to dashboards and user management features, while normal users can 
only access a basic dashboard.
2. Technology Stack
• Backend Framework: Laravel 12
• Database: MySQL (via Docker)
• Authentication: Laravel Authentication (session-based or token-based)
• Authorization: Role-based access control (Admin, User)
• Charts: Chart.js (based on provided Gist references)
• Containerization: Docker & Docker Compose
• Testing: PHPUnit (Unit Tests)
• Architecture: MVC (Model-View-Controller)
• API Standard: RESTful API
3. User Data Model
User Table Fields
Field Name Type Description
name string User full name
email string Unique user email
password string Hashed password
created_at timestamp Record creation time
PT. TABLELINK DIGITAL INOVASI
Ruko Arcade, MG Office Tower 6th floor. Jl. Pantai Indah Utara 2 Blok 3 MA & 3 MB, 
Kapuk Muara, Kec. Penjaringan, Jakarta Utara, Jakarta 14460
Field Name Type Description
updated_at timestamp Record update time
last_login timestamp Last successful login
deleted_at timestamp Soft delete timestamp
Notes
• email must be unique
• deleted_at is used for soft deletes
• Passwords are stored using Laravel hashing
4. Authentication & Authorization
4.1 Registration
• Users can register using email and password
• Email must be unique
• Default role assigned: User
4.2 Authentication
• Both Admin and User can log in
• On successful login:
– last_login is updated
4.3 Authorization
• User
– Redirected to an empty dashboard
• Admin
– Access to:
• Dashboard with charts
• User management features
Authorization is enforced using:
• Middleware
• Policies or Gates
5. User Management (Admin Only)
5.1 Read Users
• Endpoint returns paginated user data
• Pagination: 10 users per page
PT. TABLELINK DIGITAL INOVASI
Ruko Arcade, MG Office Tower 6th floor. Jl. Pantai Indah Utara 2 Blok 3 MA & 3 MB, 
Kapuk Muara, Kec. Penjaringan, Jakarta Utara, Jakarta 14460
• Soft-deleted users are excluded by default
5.2 Update User
• Admin can update user data
• Email validation:
– Must be unique
– Current user’s email is excluded from uniqueness check
5.3 Delete User
• Admin-only access
• Uses soft delete
• Sets deleted_at timestamp instead of permanently removing data
6. Dashboard (Admin)
The Admin Dashboard displays the following charts:
6.1 Line Chart
• Source reference: 
https://gist.github.com/rachmanlatif/323bd55b284774bf98e11225ce2374e1
6.2 Vertical Bar Chart
• Source reference: 
https://gist.github.com/rachmanlatif/51277a2070e6cd240bf471d9aead29d7
6.3 Pie Chart
• Source reference: 
https://gist.github.com/rachmanlatif/ad0290b004c1bfa9ded5f872f680fea8
Notes
• Charts are modularized into reusable view components
• Data is provided via REST API endpoints
6. Flight Infomation (Admin)
The Flight Information page collects flight ticket information from Tiket.com based on specific 
search criteria:
Notes
• Target: https://www.tiket.com
• Search Criteria:
– Search for one-way flight tickets.
– Depature city: Jakarta (CGK)
PT. TABLELINK DIGITAL INOVASI
Ruko Arcade, MG Office Tower 6th floor. Jl. Pantai Indah Utara 2 Blok 3 MA & 3 MB, 
Kapuk Muara, Kec. Penjaringan, Jakarta Utara, Jakarta 14460
– Destination city: Bali (DPS)
– Departure time: Before 5:00 PM (17:00 local time)
– Flight type: Economy class
– Trip type: One-way
• Data to Collect:
– Airline name
– Flight number
– Departure time
– Price
– Departure airport
– Arrival airport
• Output Requirement:
– Data is provided via REST API endpoints.
– At Flight Information page, make as data-table.
7. Project Structure (MVC Best Practices)
Best Practices Applied
• Request validation separated using Form Request
• Business logic kept inside services or controllers
• Views split into reusable components
• Clean separation between API and UI logic
8. Dockerization
Dockerized Components
• Laravel Application
• Database (MySQL / PostgreSQL)
• Web Server (Nginx)
Docker Compose
• Single docker-compose.yml file
• Environment variables managed via .env
• One command setup:
docker-compose up -d
9. Testing
Unit Tests
• Each major function has corresponding unit tests:
PT. TABLELINK DIGITAL INOVASI
Ruko Arcade, MG Office Tower 6th floor. Jl. Pantai Indah Utara 2 Blok 3 MA & 3 MB, 
Kapuk Muara, Kec. Penjaringan, Jakarta Utara, Jakarta 14460
– Authentication
– Authorization
– User CRUD
– Dashboard data generation
Testing Tools
• PHPUnit
• Laravel testing utilities
Run Tests
php artisan test
10. Security Considerations
• Password hashing using Laravel Hash
• Role-based middleware
• Soft delete to prevent accidental data loss
• Validation on all incoming requests

use tailwindcss v4.0.17 css style

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.4.1
- laravel/framework (LARAVEL) - v12
- laravel/prompts (PROMPTS) - v0
- laravel/mcp (MCP) - v0
- laravel/pint (PINT) - v1
- laravel/sail (SAIL) - v1
- pestphp/pest (PEST) - v4
- phpunit/phpunit (PHPUNIT) - v12
- tailwindcss (TAILWINDCSS) - v4

## Skills Activation

This project has domain-specific skills available. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

- `pest-testing` — Tests applications using the Pest 4 PHP framework. Activates when writing tests, creating unit or feature tests, adding assertions, testing Livewire components, browser testing, debugging test failures, working with datasets or mocking; or when the user mentions test, spec, TDD, expects, assertion, coverage, or needs to verify functionality works.
- `tailwindcss-development` — Styles applications using Tailwind CSS v4 utilities. Activates when adding styles, restyling components, working with gradients, spacing, layout, flex, grid, responsive design, dark mode, colors, typography, or borders; or when the user mentions CSS, styling, classes, Tailwind, restyle, hero section, cards, buttons, or any visual/UI changes.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

- Laravel Boost is an MCP server that comes with powerful tools designed specifically for this application. Use them.

## Artisan

- Use the `list-artisan-commands` tool when you need to call an Artisan command to double-check the available parameters.

## URLs

- Whenever you share a project URL with the user, you should use the `get-absolute-url` tool to ensure you're using the correct scheme, domain/IP, and port.

## Tinker / Debugging

- You should use the `tinker` tool when you need to execute PHP to debug code or query Eloquent models directly.
- Use the `database-query` tool when you only need to read from the database.

## Reading Browser Logs With the `browser-logs` Tool

- You can read browser logs, errors, and exceptions using the `browser-logs` tool from Boost.
- Only recent browser logs will be useful - ignore old logs.

## Searching Documentation (Critically Important)

- Boost comes with a powerful `search-docs` tool you should use before trying other approaches when working with Laravel or Laravel ecosystem packages. This tool automatically passes a list of installed packages and their versions to the remote Boost API, so it returns only version-specific documentation for the user's circumstance. You should pass an array of packages to filter on if you know you need docs for particular packages.
- Search the documentation before making code changes to ensure we are taking the correct approach.
- Use multiple, broad, simple, topic-based queries at once. For example: `['rate limiting', 'routing rate limiting', 'routing']`. The most relevant results will be returned first.
- Do not add package names to queries; package information is already shared. For example, use `test resource table`, not `filament 4 test resource table`.

### Available Search Syntax

1. Simple Word Searches with auto-stemming - query=authentication - finds 'authenticate' and 'auth'.
2. Multiple Words (AND Logic) - query=rate limit - finds knowledge containing both "rate" AND "limit".
3. Quoted Phrases (Exact Position) - query="infinite scroll" - words must be adjacent and in that order.
4. Mixed Queries - query=middleware "rate limit" - "middleware" AND exact phrase "rate limit".
5. Multiple Queries - queries=["authentication", "middleware"] - ANY of these terms.

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.

## Constructors

- Use PHP 8 constructor property promotion in `__construct()`.
    - <code-snippet>public function __construct(public GitHub $github) { }</code-snippet>
- Do not allow empty `__construct()` methods with zero parameters unless the constructor is private.

## Type Declarations

- Always use explicit return type declarations for methods and functions.
- Use appropriate PHP type hints for method parameters.

<code-snippet name="Explicit Return Types and Method Params" lang="php">
protected function isAccessible(User $user, ?string $path = null): bool
{
    ...
}
</code-snippet>

## Enums

- Typically, keys in an Enum should be TitleCase. For example: `FavoritePerson`, `BestLake`, `Monthly`.

## Comments

- Prefer PHPDoc blocks over inline comments. Never use comments within the code itself unless the logic is exceptionally complex.

## PHPDoc Blocks

- Add useful array shape type definitions when appropriate.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using the `list-artisan-commands` tool.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

## Database

- Always use proper Eloquent relationship methods with return type hints. Prefer relationship methods over raw queries or manual joins.
- Use Eloquent models and relationships before suggesting raw database queries.
- Avoid `DB::`; prefer `Model::query()`. Generate code that leverages Laravel's ORM capabilities rather than bypassing them.
- Generate code that prevents N+1 query problems by using eager loading.
- Use Laravel's query builder for very complex database operations.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `list-artisan-commands` to check the available options to `php artisan make:model`.

### APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## Controllers & Validation

- Always create Form Request classes for validation rather than inline validation in controllers. Include both validation rules and custom error messages.
- Check sibling Form Requests to see if the application uses array or string based validation rules.

## Authentication & Authorization

- Use Laravel's built-in authentication and authorization features (gates, policies, Sanctum, etc.).

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Queues

- Use queued jobs for time-consuming operations with the `ShouldQueue` interface.

## Configuration

- Use environment variables only in configuration files - never use the `env()` function directly outside of config files. Always use `config('app.name')`, not `env('APP_NAME')`.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== laravel/v12 rules ===

# Laravel 12

- CRITICAL: ALWAYS use `search-docs` tool for version-specific Laravel documentation and updated code examples.
- Since Laravel 11, Laravel has a new streamlined file structure which this project uses.

## Laravel 12 Structure

- In Laravel 12, middleware are no longer registered in `app/Http/Kernel.php`.
- Middleware are configured declaratively in `bootstrap/app.php` using `Application::configure()->withMiddleware()`.
- `bootstrap/app.php` is the file to register middleware, exceptions, and routing files.
- `bootstrap/providers.php` contains application specific service providers.
- The `app\Console\Kernel.php` file no longer exists; use `bootstrap/app.php` or `routes/console.php` for console configuration.
- Console commands in `app/Console/Commands/` are automatically available and do not require manual registration.

## Database

- When modifying a column, the migration must include all of the attributes that were previously defined on the column. Otherwise, they will be dropped and lost.
- Laravel 12 allows limiting eagerly loaded records natively, without external packages: `$query->latest()->limit(10);`.

### Models

- Casts can and likely should be set in a `casts()` method on a model rather than the `$casts` property. Follow existing conventions from other models.

=== pint/core rules ===

# Laravel Pint Code Formatter

- You must run `vendor/bin/pint --dirty` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test`, simply run `vendor/bin/pint` to fix any formatting issues.

=== pest/core rules ===

## Pest

- This project uses Pest for testing. Create tests: `php artisan make:test --pest {name}`.
- Run tests: `php artisan test --compact` or filter: `php artisan test --compact --filter=testName`.
- Do NOT delete tests without approval.
- CRITICAL: ALWAYS use `search-docs` tool for version-specific Pest documentation and updated code examples.
- IMPORTANT: Activate `pest-testing` every time you're working with a Pest or testing-related task.

=== tailwindcss/core rules ===

# Tailwind CSS

- Always use existing Tailwind conventions; check project patterns before adding new ones.
- IMPORTANT: Always use `search-docs` tool for version-specific Tailwind CSS documentation and updated code examples. Never rely on training data.
- IMPORTANT: Activate `tailwindcss-development` every time you're working with a Tailwind CSS or styling-related task.
</laravel-boost-guidelines>
