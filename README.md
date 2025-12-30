GapGuide Website

GapGuide is an educational technology platform developed as part of a real-world startup initiative.
The platform is designed to host structured academic content, including recorded courses and supporting materials, with a focus on accessibility and simplicity.

This repository contains the source code for the GapGuide website.

--------------------------------------------------

Overview

The GapGuide website provides:
- Course listing and navigation pages
- Static and dynamic academic content
- User interaction pages (authentication, payments, uploads)
- Backend scripts for handling subscriptions and content uploads

The project was developed collaboratively and reflects real startup development rather than a coursework-only assignment.

--------------------------------------------------

Technologies Used

- Frontend: HTML, CSS, JavaScript
- Backend: PHP
- Data & Configuration: JSON
- Package Management: Node.js (for tooling and dependencies)

--------------------------------------------------

Project Structure

.
├── index.html
├── courses/
├── uploads/
├── package.json
├── package-lock.json
├── *.html
├── *.php
├── *.json
└── .gitignore

Key folders:
- courses/ – course-related content and pages
- uploads/ – uploaded course materials
- Root HTML files – main website pages (login, signup, payments, etc.)

--------------------------------------------------

Setup Instructions

1. Clone the repository:
   git clone https://github.com/Kamal-nour/GapGuide-website.git

2. Open the project folder in a code editor (VS Code recommended).

3. If using Node-based tooling:
   npm install

4. Serve the project using a local server (e.g. XAMPP, WAMP, or Live Server).

--------------------------------------------------

Notes

- node_modules/ and sensitive files are excluded via .gitignore.
- This repository focuses on the website implementation; deployment and production configuration are not included.
- The project evolved iteratively during the startup’s development phase.

--------------------------------------------------

