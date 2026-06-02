-- InfersioAI PostgreSQL schema
-- Database: infersioai_db
-- User: infersioai_user
-- Run via setup/install.php after Lightsail database is created.

CREATE TABLE IF NOT EXISTS admin_users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(80) NOT NULL UNIQUE,
    password_hash TEXT NOT NULL,
    must_change_password BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS clients (
    id SERIAL PRIMARY KEY,
    company_name VARCHAR(180) NOT NULL,
    company_website TEXT NOT NULL,
    logo_path TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS service_projects (
    id SERIAL PRIMARY KEY,
    service_type VARCHAR(60) NOT NULL,
    category VARCHAR(140) NOT NULL DEFAULT '',
    client_name VARCHAR(180) NOT NULL,
    client_website TEXT NOT NULL,
    simple_description TEXT NOT NULL DEFAULT '',
    engagement_start_date DATE NOT NULL,
    delivery_date DATE NOT NULL,
    project_value NUMERIC(12, 2) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS team_members (
    id SERIAL PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    role VARCHAR(120) NOT NULL,
    image_url TEXT NOT NULL,
    profile_link TEXT NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS visitor_comments (
    id SERIAL PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    company VARCHAR(180) NOT NULL,
    comment_text TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW()
);
