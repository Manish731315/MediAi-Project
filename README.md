MediAI: Intelligent Healthcare E-commerce & AI Consultation System
MediAI is a full-stack healthcare platform designed to bridge the gap between traditional e-commerce and modern artificial intelligence. Built with the Laravel framework, it offers a seamless shopping experience for medicines while providing an AI-powered Symptom Analyzer that recommends over-the-counter (OTC) medications based on real-time pharmacy inventory.

🚀 Core Features
🩺 AI Doctor (Symptom Analyzer)
Intelligent Consultation: Uses Google Gemini 1.5 (Flash/Pro) to analyze user-described symptoms.

Inventory Integration: The AI only suggests medicines that are currently in the database and in stock.

Dynamic Matching: Backend logic reconciles AI text output with actual database IDs for instant "Add to Cart" functionality.

Resiliency: Implemented exponential backoff and retry logic to handle API 503/429 errors.

🛒 E-commerce Engine
Medicine Vault: Categorized listing of medicines (Personal Care, Antibiotics, etc.).

Prescription Logic: Strict separation between OTC products and those requiring a Prescription (Rx).

Cart & Checkout: Fully functional shopping cart with quantity management.

Prescription Upload: Users can upload medical prescriptions for specific orders during checkout.

🔐 Security & Authentication
Dual Authentication: Standard email-based login and Google OAuth integration.

Admin Shield: Namespaced controllers and custom middleware to protect administrative routes.

Profile Management: Secure password setup for social-auth users and profile editing.

📊 Admin Dashboard
Inventory Management: Full CRUD (Create, Read, Update, Delete) for medicines.

PDF Export: Generate high-fidelity, audit-ready inventory reports using DomPDF.

Order Tracking: Monitor order statuses and verify uploaded prescriptions.

🛠️ Tech Stack
Framework: Laravel (v12.x)

Language: PHP 8.2+

Database: MySQL

Frontend: Tailwind CSS, Alpine.js (Laravel Breeze)

AI Integration: Google Gemini API (REST)

Reporting: Barryvdh/Laravel-DomPDF

Environment: Developed on Windows 11

📁 Project Structure Highlights
The project follows a clean Service-Oriented Architecture to ensure the codebase is maintainable and scalable:

app/Services/AiDoctorService.php: Encapsulates all AI logic, prompt engineering, and API communication.

app/Http/Controllers/Admin/: Isolated namespace for administrative logic.

app/Http/Controllers/ShopController.php: Handles the public-facing product catalog.

resources/views/admin/medicines/pdf.blade.php: Specialized print-optimized layout for PDF reports.

⚙️ Installation & Setup
Clone the Repository:

Bash
git clone https://github.com/Manish731315/MediAi-Project.git
cd MediAi-Project
Install Dependencies:

Bash
composer install
npm install && npm run build
Environment Configuration:
Create a .env file from the example:

Bash
cp .env.example .env
Configure your database and add your Gemini API Key:

Code snippet
GEMINI_API_KEY=your_key_here
AI_MODEL=gemini-1.5-flash

RAZORPAY_KEY_ID=your_key_here
RAZORPAY_KEY_SECRET=your_key_here

GOOGLE_CLIENT_ID=your_key_here
GOOGLE_CLIENT_SECRET=your_key_here
GOOGLE_REDIRECT_URL=http://127.0.0.1:8000/auth/google/callback

TWILIO_SID=your_key_here
TWILIO_TOKEN=your_key_here
TWILIO_FROM=your_twilio_number_here

Database Migration:

Bash
php artisan migrate --seed
Storage Link:

Bash
php artisan storage:link
Run the Application:

Bash
php artisan serve
📈 Future Enhancements
Real-time Order Tracking: Integration of a map-based delivery tracking system.

Multi-Model AI Failover: Automatic switching between Gemini and OpenAI if one service experiences downtime.

Pharmacist Chat: A live-chat interface for direct communication with human medical professionals.

👨‍💻 Author
Manish Kumar

3rd-Year BCA Student @ CIMAGE Group of Institutions, Patna.

Focus: Full-Stack Web Development & AI Implementation.

![alt text](127.0.0.1_8000_.png)

![alt text](<Screenshot 2026-01-11 231141.png>)

![alt text](<Screenshot 2026-01-11 231841.png>)

![alt text](<Screenshot 2026-01-11 231244.png>)

![alt text](<Screenshot 2026-01-11 232040.png>)

![alt text](<Screenshot 2026-01-11 232115.png>)

![alt text](<Screenshot 2026-01-11 231422.png>)