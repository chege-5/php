CREATE TABLE IF NOT EXISTS continents (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS countries (
    id SERIAL PRIMARY KEY,
    continent_id INTEGER NOT NULL REFERENCES continents(id) ON DELETE CASCADE,
    name VARCHAR(100) NOT NULL,
    UNIQUE(continent_id, name)
);

CREATE INDEX IF NOT EXISTS idx_countries_continent_id ON countries(continent_id);

CREATE TABLE IF NOT EXISTS counties (
    id SERIAL PRIMARY KEY,
    country_id INTEGER NOT NULL REFERENCES countries(id) ON DELETE CASCADE,
    name VARCHAR(100) NOT NULL,
    UNIQUE(country_id, name)
);

CREATE INDEX IF NOT EXISTS idx_counties_country_id ON counties(country_id);

CREATE TABLE IF NOT EXISTS wards (
    id SERIAL PRIMARY KEY,
    county_id INTEGER NOT NULL REFERENCES counties(id) ON DELETE CASCADE,
    name VARCHAR(100) NOT NULL,
    UNIQUE(county_id, name)
);

CREATE INDEX IF NOT EXISTS idx_wards_county_id ON wards(county_id);

CREATE TABLE IF NOT EXISTS villages (
    id SERIAL PRIMARY KEY,
    ward_id INTEGER NOT NULL REFERENCES wards(id) ON DELETE CASCADE,
    name VARCHAR(100) NOT NULL,
    UNIQUE(ward_id, name)
);

CREATE INDEX IF NOT EXISTS idx_villages_ward_id ON villages(ward_id);
