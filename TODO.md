## Opis zadania

Stwórz aplikację **To-Do list**, która pozwala na dodawanie, edytowanie, przeglądanie i usuwanie zadań (CRUD) oraz wysyła powiadomienia e-mail.

### Wymagania funkcjonalne

1. **CRUD**
   - Pola:
     - **Nazwa zadania** – max 255 znaków, wymagane  
     - **Opis** – opcjonalnie  
     - **Priorytet** – `low` / `medium` / `high`  
     - **Status** – `to-do` / `in progress` / `done`  
     - **Termin wykonania** – data, wymagane  
2. **Przeglądanie zadań**
   - Filtrowanie listy według priorytetu, statusu i terminu.  
3. **Powiadomienia e-mail**
   - Mail 1 dzień przed terminem (Laravel Queues + Scheduler).  
4. **Walidacja**
   - Poprawne sprawdzanie wymaganych pól, formatu daty, długości tekstu.  
5. **Obsługa wielu użytkowników**
   - Logowanie i osobiste listy zadań (Laravel Auth).  
6. **Udostępnianie zadań bez autoryzacji**
   - Publiczny link z tokenem o ograniczonym czasie działania.  

#### Dodatkowe funkcje (opcjonalne)

7. **Historia edycji**
   - Zapis każdej zmiany (nazwa, opis, priorytet, status, termin itd.) z możliwością podglądu poprzednich wersji.  
8. **Integracja z Google Calendar**
   - Przypięcie zadania do kalendarza przez `spatie/laravel-google-calendar`.  

### Wymagania techniczne

| Warstwa      | Technologia                                                  |
|--------------|--------------------------------------------------------------|
| **Back-end** | Laravel 11, REST API, Eloquent ORM, MySQL/SQLite, migracje   |
| **Front-end**| Laravel Blade (opcjonalnie AJAX)                             |
| **Docker**   | `Dockerfile` + `docker-compose.yml` (opcjonalnie)            |
