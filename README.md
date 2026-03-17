# Code Snippet Library

[![Live Demo](https://img.shields.io/badge/Live-Demo-brightgreen)](https://code-snippet-first-year-project.onrender.com)

A web application for storing, organizing, and managing programming code snippets.

This project was originally developed as part of my **Year 1 Software Development coursework**.
It has since been expanded and deployed to a **live cloud environment** using containerized infrastructure.

---

# Tech Stack

![HTML](https://img.shields.io/badge/HTML-5-E34F26?logo=html5\&logoColor=white)
![CSS](https://img.shields.io/badge/CSS-3-1572B6?logo=css3\&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-F7DF1E?logo=javascript\&logoColor=black)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php\&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-Supabase-4169E1?logo=postgresql\&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Containerized-2496ED?logo=docker\&logoColor=white)
![Render](https://img.shields.io/badge/Hosting-Render-46E3B7?logo=render\&logoColor=black)

---

# Live Demo

https://code-snippet-first-year-project.onrender.com

You can explore the application by creating an account or using the demo credentials below.

**Demo account**

Email: [guest@example.ie](mailto:guest@example.ie)
Password: Dev123

---

# Features

User authentication system
Create and manage folders
Store programming code snippets
View and edit stored code
Organize snippets into folders
Database-backed storage
Session-based authentication
Responsive interface

---

# Screenshots

### Landing Page

![Landing Page](screenshots/landing-page.png)

### Code Library

![Library Interface](screenshots/library-view.png)

### Creating Code Snippets

![Create Snippet](screenshots/create-snippet.png)

---

# Project Architecture

The application follows a simple **client-server architecture**.

Frontend
HTML, CSS and JavaScript provide the user interface and interact with the backend using the Fetch API.

Backend
PHP handles authentication, database queries, and API endpoints.

Database
PostgreSQL (hosted on Supabase) stores user accounts, folders, and code snippets.

Infrastructure
The application is containerized with Docker and deployed on Render.

---

# What I Learned

Building this project helped me gain practical experience with:

Full stack web development
PHP backend development
Using PDO for secure database access
Session-based authentication
Relational database design
REST-style API endpoints
Debugging production deployments
Docker containerization
Deploying applications to cloud infrastructure

---

# Running the Project Locally

Clone the repository

git clone https://github.com/daniel-mcnamee-dev/Code-Snippet-First-Year-Project

Navigate to the project directory

cd Code-Snippet-First-Year-Project

Run using Docker

docker compose up

Then open your browser and go to

http://localhost

---

# Future Improvements

Syntax highlighting for code snippets
Snippet tagging system
Search functionality
Sharing snippets between users
Improved UI/UX
Export snippets as files

---

# License

This project is licensed under the MIT License.

