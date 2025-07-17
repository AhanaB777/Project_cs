
# 🖥️ CS Department Portal

A full-stack web application built to manage and streamline academic resources for a Computer Science department. This portal allows faculty to upload, manage, and distribute content like books, notices, past year papers (PYQs), routines, and FAQs, while students can view and download the materials.


## 🎯 Objective

The goal of this portal is to:
- Digitize academic material management.
- Provide a centralized, accessible platform for students and faculty.
- Reduce the dependency on physical bulletin boards and fragmented communication.

---

## ⚙️ Tech Stack

| Layer      | Technology      |
|------------|-----------------|
| Frontend   | HTML, CSS (Glassmorphism & responsive design), JavaScript |
| Backend    | PHP (Core PHP without frameworks) |
| Database   | MySQL (Structured, relational database) |
| Tools      | XAMPP, VS Code, phpMyAdmin |

---

## 🔑 Features

### 👩‍🏫 Faculty/Admin
- Admin login with session-based authentication.
- Upload/Delete/Edit:
  - Books with cover image and downloadable PDF.
  - Notices with date filter.
  - PYQs (Past Year Question Papers) with filtering.
  - Routines.
  - FAQs.
- Restore and soft delete functionalities for data safety.
- Dashboard access to manage all modules.
- Animated UI with a modern glassmorphism theme.

### 👨‍🎓 Student View
- View/download:
  - Semester-wise books.
  - Year/Subject filtered PYQs.
  - Department routine.
  - Dynamic FAQ section.
- Access to faculty profiles.
- Mobile-friendly and responsive layout.

---

## 🧩 Modules

- Home Page
- Admin Dashboard
- View Notices
- View PYQs
- View Books
- View FAQs
- View Faculty Details
- View Routine
- Upload Materials
- Upload Books / PYQs / Routine / Notices / FAQs
- Manage Deleted Items
- Edit/Restore/Delete (soft and permanent)

---

## 🔐 Authentication

- Only faculty/admin users can login.
- Students have access to public-facing views only.
- Session-based access control for secure dashboard pages.

---

## 🧪 Implementation Details

- **Database Connectivity**: via `mysqli` in PHP using prepared statements.
- **File Handling**: Files are uploaded to `uploads/` directories and stored with relative paths in the database.
- **Soft Deletion**: Items marked `deleted` in the DB can be restored.
- **Form Security**: Uses `htmlspecialchars()` to prevent XSS.
- **Page Access Security**: Pages restricted via `$_SESSION['role']`.

---

## 🚀 Future Scope

- Add student login system with custom dashboard.
- Implement password encryption and secure authentication.
- Use Git and GitHub for collaborative version control.
- Host the portal live using a web server or platform like Vercel.
- Introduce advanced features like:
  - Resource search
  - Announcements module
  - Note sharing among students

---

## 🧠 Lessons Learned

- Strengthened backend and frontend integration.
- Learned real-world file handling and session management in PHP.
- Improved CSS layout structuring and visual consistency.
- Collaboration and testing without version control (manually synced).

---

