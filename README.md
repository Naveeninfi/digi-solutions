# DigiSolutions – Digital Marketing Agency Website

A custom WordPress website developed for a digital marketing agency, featuring a responsive design, portfolio management, and custom administrative functionality.

## Project Overview

DigiSolutions is a WordPress-based digital agency website designed to showcase services, projects, and the agency's digital capabilities.

The project includes a custom WordPress theme and custom plugins to support portfolio management and administrative functionality.

## Technologies Used

- WordPress
- PHP
- HTML5
- CSS3
- JavaScript
- MySQL
- Elementor
- Advanced Custom Fields (ACF)

## Project Structure

```text
digi-solutions/
│
├── app/
│   └── public/
│       └── wp-content/
│           ├── plugins/
│           │   ├── digi-solutions-manager/
│           │   └── digisolutions-admin-ui/
│           │
│           └── themes/
│               └── digi-solutions/
│                   ├── assets/
│                   ├── page-templates/
│                   ├── footer.php
│                   ├── front-page.php
│                   ├── functions.php
│                   ├── header.php
│                   ├── index.php
│                   ├── page.php
│                   ├── single-portfolio.php
│                   └── style.css
│
└── .gitignore
```

## Custom Components

### 1. DigiSolutions Theme
- Custom WordPress theme
- Custom header and footer
- Homepage template
- Portfolio detail template
- Custom CSS and JavaScript assets

### 2. Digi Solutions Manager
- Custom WordPress plugin
- Portfolio management functionality

### 3. DigiSolutions Admin UI
- Custom administrative interface
- CSS assets
- Includes and view files

## Local Development

1. Install a local WordPress development environment.
2. Set up a WordPress installation.
3. Clone this repository.
4. Copy the custom theme into `wp-content/themes/`.
5. Copy the custom plugins into `wp-content/plugins/`.
6. Activate the theme and required plugins from the WordPress dashboard.
7. Configure the required WordPress settings and plugins.

## Security

Sensitive configuration files, database backups, WordPress uploads, and third-party WordPress core files are excluded through `.gitignore`.

## Developer

**DigiSolutions**

Custom WordPress Website Development
