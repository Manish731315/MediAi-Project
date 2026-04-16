🏥 MediAI: Intelligent Healthcare & AI Consultation SystemBridging the gap between traditional pharmaceutical e-commerce and modern Artificial Intelligence.🖼️ Project Gallery<p align="center"><img src="127.0.0.1_8000_.png" width="45%" alt="MediAI Home"><img src="Screenshot 2026-01-11 231141.png" width="45%" alt="Dashboard"><img src="Screenshot 2026-01-11 231841.png" width="45%" alt="AI Consultation"><img src="Screenshot 2026-01-11 231244.png" width="45%" alt="Medicine Vault"><img src="Screenshot 2026-01-11 232040.png" width="30%" alt="Checkout"><img src="Screenshot 2026-01-11 232115.png" width="30%" alt="Orders"><img src="Screenshot 2026-01-11 231422.png" width="30%" alt="Admin Panel"></p>🚀 Core Features🩺 AI Doctor (Symptom Analyzer)Intelligent Consultation: Leverages Google Gemini 1.5 (Flash/Pro) to analyze symptoms in natural language.Inventory Integration: Recommendations are strictly cross-referenced with real-time database stock.Dynamic Matching: Reconciles AI output with database IDs for seamless "Add to Cart" functionality.Resiliency: Optimized with exponential backoff and retry logic for high-demand API states (503/429).🛒 E-commerce EngineMedicine Vault: Highly organized, categorized inventory management (Antibiotics, Personal Care, etc.).Prescription Logic: Smart separation between OTC products and Rx-Required medicines.Cart & Checkout: Advanced quantity management and secure order processing.Prescription Upload: Secure file-handling for medical prescriptions during the checkout flow.🔐 Security & Admin ShieldDual Auth: Secure login via standard credentials or Google OAuth integration.Admin Shield: Namespaced controllers and custom middleware to protect core administrative routes.PDF Export: High-fidelity, audit-ready inventory reports generated via DomPDF.🛠️ Technical StackCategoryTechnologyFrameworkLaravel v12.xLanguagePHP 8.2+AI EngineGoogle Gemini API (REST)DatabaseMySQLPaymentsRazorpay IntegrationCommunicationTwilio SMS APIFrontendTailwind CSS & Alpine.js📁 Project Structure HighlightsMediAI follows a Service-Oriented Architecture to ensure clean code and high scalability:app/Services/AiDoctorService.php: Central hub for AI logic, prompt engineering, and API error handling.app/Http/Controllers/Admin/: Isolated namespace dedicated to administrative CRUD and security.app/Http/Controllers/ShopController.php: Manages the public-facing product lifecycle.resources/views/admin/medicines/pdf.blade.php: Specialized print-optimized Blade layout for inventory reports.⚙️ Installation & Setup1. Clone & InstallBashgit clone https://github.com/Manish731315/MediAi-Project.git
cd MediAi-Project
composer install
npm install && npm run build
2. Environment ConfigurationCreate a .env file and configure your credentials:Code snippetGEMINI_API_KEY=your_key_here
AI_MODEL=gemini-1.5-flash

RAZORPAY_KEY_ID=your_key_here
RAZORPAY_KEY_SECRET=your_key_here

GOOGLE_CLIENT_ID=your_key_here
GOOGLE_CLIENT_SECRET=your_key_here
GOOGLE_REDIRECT_URL=http://127.0.0.1:8000/auth/google/callback

TWILIO_SID=your_key_here
TWILIO_TOKEN=your_key_here
TWILIO_FROM=your_number
3. Database & StorageBashphp artisan migrate --seed
php artisan storage:link
php artisan serve
📈 Future EnhancementsReal-time Tracking: Map-based delivery status using Leaflet.js or Google Maps.Multi-Model Failover: Automated switching to OpenAI if Gemini encounters downtime.Pharmacist Chat: Direct live-chat interface with verified human medical professionals.👨‍💻 AuthorManish Kumar3rd-Year BCA Student @ CIMAGE Group of Institutions, Patna.Focus: Full-Stack Web Development, AI Integration, and Software Architecture.Final Year Project submitted to Patliputra University.