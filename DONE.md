## Podsumowanie projektu

Projekt został ukończony bez większych problemów.
Zdecydowałem się jednak na użycie Laravel 12 zamiast 11, ponieważ jest to nowsza wersja frameworka i warto korzystać z najnowszych rozwiązań, choć cały kod bez problemu działa także na Laravelu 11 i migracja między wersjami jest prosta do wykonania.

Do realizacji projektu wykorzystałem Filament PHP, który przypadł mi do gustu i świetnie sprawdza się w tego typu zadaniach, przyspieszając pracę i oferując dobrze wykonane komponenty.
Jednak Filament stanowi problem, mogę przepisać projekt na czysty Laravel z Blade.

Mam kilka pomysłów na to, jak rozbudować projekt i wprowadzić poprawić.
Aktualna wersja spełnia wymagania, ale może być bardziej zoptymalizowana i rozbudowana.

---

## Kluczowe funkcjonalności

### Filtrowanie zadań

Filtrowanie zostało zaimplementowane w metodzie `table` w `TaskResource`. Obsługiwane są filtry:

- **Priorytet**: Low / Medium / High  
- **Status**: To Do / In Progress / Done

### Scope użytkownika

W modelu `Task` został utworzony scope `onlyUser`, który zapewnia, że każdy użytkownik widzi tylko swoje zadania.  
Dodatkowo przy tworzeniu/zapisywaniu zadania automatycznie przypisywany jest `user_id` zalogowanego użytkownika.

Nie zastosowałem global scope, aby uniknąć nieprzewidywalnych zachowań np. w artisan commands.

### Walidacja

Walidacja pól formularza odbywa się w metodzie `form()` w `TaskResource` i działa poprawnie zgodnie z wymaganiami.

### Obsługa użytkowników

Rejestracja i logowanie działają w oparciu o panel użytkownika skonfigurowany w `AppPanelProvider`.

---

## Historia zmian zadań

Zmiany w zadaniach są zapisywane do tabeli `task_history` przy użyciu eventu `updating` modelu `Task`. Dane zapisywane są w formacie JSON.

W tabeli zadań znajduje się **akcja**, która przekierowuje do strony z historią danego zadania. Logika znajduje się w:

- `app/Filament/Resources/TaskResource/Pages/TaskHistory`
- Widok: `resources/views/filament/resources/task-resource/pages/task-history.blade.php`

Obecnie widok historii jest prosty, ale łatwo można go rozbudować.

---

## Publiczne udostępnianie zadań

Udostępnianie zadań bez autoryzacji zostało zrealizowane jako **akcja** w `TaskResource`. Po kliknięciu generowany jest publiczny URL ważny przez 30 minut. Trasa chroniona jest przez middleware `signed` i zdefiniowana w `routes/web.php`.

---

## Powiadomienia e-mail

Wysyłanie przypomnień e-mail na dzień przed terminem wykonania zadania zostało zaimplementowane jako komenda:

- `SendTaskDueReminders` – sprawdza zadania z datą na jutro i wysyła maile.

---

## Docker

Wszystkie pliki Dockera znajdują się w katalogu `docker/`.

Dodatkowo do pliku `docker-compose.yml` został dodany **Mailpit**, umożliwiający podgląd wysyłanych maili.
