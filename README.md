# ChildSafe – Child Labour Reporting and Rescue Management System

![ChildSafe Header](https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=2070&auto=format&fit=crop)

## 📌 Overview
**ChildSafe** is a social impact web platform designed to eradicate child labour by bridging the gap between concerned citizens, rescue authorities, and NGOs. It provides a secure, completely anonymous reporting mechanism that allows anyone to report suspected child labour incidents without fear of backlash. 

The platform features an intelligent admin dashboard equipped with AI risk-classification logic, interactive heatmaps, and a transparent public tracking system to ensure every child gets the help they deserve.

## ✨ Key Features
- **🕵️ Anonymous Reporting:** Citizens can submit incident reports instantly. An "Anonymous Mode" toggle securely strips all identifying information.
- **🤖 AI Risk Classification:** The system automatically categorizes reports into High, Medium, or Low risk based on the child's age and the type of hazardous labour involved.
- **📍 Geolocation & Mapping:** Built-in Leaflet.js maps allow users to pinpoint exact incident coordinates, generating interactive heatmaps for administrators.
- **📊 Admin Dashboard:** A secure backend portal for authorities featuring interactive Chart.js analytics, demographic breakdowns, and dynamic case management.
- **🔍 Transparent Case Tracking:** Reporters receive a unique Complaint ID (e.g., `CLS2026...`) to visually track the status of the investigation in real-time.
- **🤝 NGO Network & Volunteer Portal:** Dedicated spaces for citizens to learn about child rights and register as volunteers.

## 🛠️ Technology Stack
- **Frontend:** HTML5, CSS3, JavaScript (Vanilla)
- **Styling:** Custom CSS + Tailwind CSS (via CDN) with modern glass-morphism and dark-mode support
- **Backend:** PHP (Core)
- **Database:** MySQL
- **Integrations:** Leaflet.js (OpenStreetMap), Chart.js (Data Visualization)

## 🚀 Local Setup Instructions

Follow these steps to run the project locally on your machine using XAMPP:

1. **Install XAMPP**: Download and install [XAMPP](https://www.apachefriends.org/index.html).
2. **Clone the Repository**:
   ```bash
   git clone https://github.com/yourusername/childsafe.git
   ```
3. **Move to Server Directory**: Move the cloned `childsafe` folder into your XAMPP `htdocs` directory (usually `C:\xampp\htdocs\`).
4. **Start the Server**: Open the XAMPP Control Panel and start **Apache** and **MySQL**.
5. **Database Configuration**:
   - Open your browser and navigate to `http://localhost/phpmyadmin`.
   - The script will automatically create the database if you import it directly. Click the **Import** tab.
   - Choose the `database/childsafe.sql` file provided in the repository and click **Go**.
6. **Access the Application**:
   - **Public Portal**: `http://localhost/childsafe/index.php`
   - **Admin Login**: `http://localhost/childsafe/admin_login.php`

### 🔑 Default Admin Credentials
- **Username:** `admin`
- **Password:** `password123`

*(Note: Additional demo accounts like `drakshanyachess@gmail.com` and `harshita.kondamuri@gmail.com` are also configured in the database.)*

## 📱 Screenshots
*(Add screenshots of your project here after uploading them to GitHub)*
- `Home Page`
- `Anonymous Reporting Map`
- `Interactive Admin Dashboard`
- `Complaint Tracking Timeline`

## ⚖️ Disclaimer
This is a university/portfolio project created for educational and social impact demonstration purposes. 

---
**"Protect Childhood. Stop Child Labour."**
