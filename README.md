# GitHub API CLI - DrDr Code Challenge

A lightweight PHP-based CLI for interacting with the GitHub API to manage repositories.

---

## Features
- **Get Repositories**: Retrieve a list of repositories from GitHub, filterable by the username parameter.
- **Create Repository**: Create a new repository on GitHub.
- **Delete Repository**: Delete an existing repository from GitHub.

---

## Prerequisites
- PHP 8.3 or higher
- Composer (PHP dependency manager)
- Docker (optional, for containerized setup)

---

## Setup Instructions

### Without Docker
1. Clone the repository:
   ```bash
   git clone https://github.com/mehdijalalii/drdr-challenge.git
   cd drdr-challenge
   ```
   
2. Install dependencies:
   ```bash
   composer install
   ```
   
3. Serve the project locally:
   ```bash
   php -S 127.0.0.1:9000 index.php
   ```
   
### With Docker
1. Clone the repository:
   ```bash
   git clone https://github.com/mehdijalalii/drdr-challenge.git
   cd drdr-challenge
   ```
   
2. Build and run the Docker container:
   ```bash
   docker-compose up --build
   ```
   
## Usage

### Retrieve a list of repositories
To retrieve a list of repositories from GitHub, filterable by the username parameter, use the following command:.
   ```curl
   curl --location 'http://127.0.0.1:9001/repos?username=mehdijalalii'
   ```

### Create a New Repository
To create a new repository, use the following command:
   ```bash
   php cli.php create-repo
   ```
### Delete an Existing Repository
To delete a repository, use the following command:

   ```bash
   php cli.php delete-repo
   ```

## Environment Variables
To authenticate with the GitHub API, you need to provide your personal access token. Add the token to a .env file in the root directory:
   ```env
   GITHUB_PERSONAL_ACCESS_TOKEN=your_personal_access_token

   ```


## Run Unit Tests
   ```bash
   vendor/bin/phpunit

   ```




