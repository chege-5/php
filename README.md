# Location Selector

A simple hierarchical location selector built with raw PHP, PostgreSQL, PDO, and vanilla JavaScript.

## Requirements

- PHP 7.4+ (with PDO_PGSQL extension)
- PostgreSQL 12+
- Web server (PHP built-in server or Apache/Nginx)

## PostgreSQL Database Creation

Create the database:

```bash
psql -U postgres -c "CREATE DATABASE location_selector;"
```

## Run Schema

```bash
psql -U postgres -d location_selector -f database/schema.sql
```

## Run Seed Data

```bash
psql -U postgres -d location_selector -f database/seed.sql
```

## Configure Database Credentials

Edit `config/database.php` and set the `$host`, `$port`, `$dbname`, `$user`, and `$password` variables to match your PostgreSQL setup.

## Start PHP Development Server

From the project root directory:

```bash
php -S localhost:8000 -t public
```

## Access the Application

Open your browser and navigate to:

```
http://localhost:8000
```

## API Endpoints

| Endpoint | Description |
|---|---|
| `GET /api/continents.php` | Returns all continents |
| `GET /api/countries.php?continent_id=ID` | Returns countries for a continent |
| `GET /api/counties.php?country_id=ID` | Returns counties for a country |
| `GET /api/wards.php?county_id=ID` | Returns wards for a county |
| `GET /api/villages.php?ward_id=ID` | Returns villages for a ward |
| `GET /api/location.php?type=TYPE&id=ID` | Resolves full hierarchy for a location |

### location.php Types

- `type=country` — returns continent, country (county, ward, village are null)
- `type=county` — returns continent, country, county (ward, village are null)
- `type=ward` — returns continent, country, county, ward (village is null)
- `type=village` — returns continent, country, county, ward, village

## Database Hierarchy

```
Continents
  └── Countries
        └── Counties
              └── Wards
                    └── Villages
```

Each level has a foreign key referencing its parent. The hierarchy supports both downward cascading selection (selecting a parent loads children) and upward auto-selection (selecting a child resolves all ancestors).
