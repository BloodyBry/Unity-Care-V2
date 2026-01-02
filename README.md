# 🏥 Care Cliniv v2

**Care Cliniv v2** is a simple web application built with **PHP 8 (POO)** and **MySQL** to manage a medical clinic. It allows administrators, doctors, and patients to handle appointments, prescriptions, and user authentication through a clean PHP interface.

---

## 📁 Project Structure

```text
care_cliniv_v2/
│
├── public/                        # Publicly accessible PHP pages
│   ├── index.php                  # Home / dashboard
│   ├── login.php                  # Login page
│   ├── logout.php                 # Logout script
│   ├── appointments.php           # List / create / cancel appointments
│   ├── prescriptions.php          # List / create prescriptions
│   └── assets/                    # Styling
│       └── css/
│
├── app/
│   ├── Core/                      # Core helper classes
│   │   ├── Database.php           # MySQLi connection (POO)
│   │   ├── BaseModel.php          # Base class with CRUD methods
│   │   ├── Auth.php               # Login / logout / role checking
│   │   └── Session.php            # Session helpers
│   │
│   ├── Models/                     # Entity classes
│   │   ├── User.php
│   │   ├── Admin.php
│   │   ├── Doctor.php
│   │   ├── Patient.php
│   │   ├── Appointment.php
│   │   ├── Medication.php
│   │   └── Prescription.php
│   │
│   ├── Controllers/               
│   │   ├── AuthController.php
│   │   ├── AppointmentController.php
│   │   └── PrescriptionController.php
│   │
│   └── Views/                     
│       ├── auth/
│       ├── appointments/
│       ├── prescriptions/
│       └── admin/
│
├── config/
│   ├── config.php                 # General configs (site name, etc.)
│   └── database.php               # Database credentials
│
├── storage/
│   └── logs/                      # Optional logs
│
├── sql/
│   └── care_cliniv_v2.sql         # Database schema 
│
├── .htaccess                       # Optional security / URL rewrite
└── README.md                        # Project documentation

---

## ⚙️ Requirements

**PHP 8**
**MySQL** 
**Apache**






