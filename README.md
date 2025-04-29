# 💸 SpendWise - Personal Expense Tracker

SpendWise is a Laravel-based expense tracking system designed to help individuals in Malaysia manage their finances more consciously in an increasingly cashless society. While digital payments offer convenience, they can also lead to unconscious spending habits. SpendWise aims to counteract that by encouraging intentional financial behavior.

---

## 📌 Project Overview

In today's digital age, the rise of cashless transactions in Malaysia has made spending seamless — and often, invisible. Many individuals struggle to stay on top of their finances as tap-and-go purchases lead to overspending and poor budgeting habits.

**SpendWise** offers a simple, manual-input-driven approach to personal finance, helping users:
- Track daily expenses
- Categorize transactions
- Set monthly budgets
- View financial summaries and reports

This intentional process cultivates better awareness, mindfulness, and discipline when it comes to personal finance.

---

## 🚀 Key Features

- ✍️ **Manual Expense Input**: Encourages mindful spending by avoiding full automation.
- 📊 **Category-Based Tracking**: Classify each transaction for better insights.
- 🎯 **Monthly Budget Setting**: Stay within your limits by setting monthly targets.
- 📈 **Financial Reports**: Visual breakdowns and summaries of spending habits.
- 🔐 **User Authentication**: Secure access to personalized finance data.
- 🚀 **AI Agent Interaction**: User can have interaction with AI Agent
---

## 🛠️ Tech Stack

- **Framework**: Laravel
- **Database**: MySQL
- **Frontend**: Blade
- **Authentication**: Laravel Jetstream

---

## 🧱 Development Methodology

SpendWise is developed using the **Waterfall model**, a structured and sequential approach:

1. **Requirements Gathering** – Identify key user needs and system functionality.
2. **System Design** – Plan user experience and database structure.
3. **Development** – Build core features with a focus on usability and performance.
4. **Testing** – Detect and fix bugs through thorough QA.
5. **Deployment** – Launch the system for real-world use.

Milestones and feedback loops are incorporated to ensure timely delivery and quality output.

---

## 🧪 Setup Instructions

1. **Clone the Repository**
      ```bash
   git clone https://github.com/faizalrazak/spend-wise.git
   cd spend-wise


2. **Install Dependencies**
      ```bash
   composer install
   npm install && npm run dev


3. **Environment Setup**
      ```bash
   cp .env.example .env
   php artisan key:generate


4. **Run Migrations**
   ```bash
    php artisan migrate


5. **Serve the App**
   ```bash
    php artisan serve

   
