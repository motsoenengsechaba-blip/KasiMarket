# KasiMarket 🛒

### A Consumer-to-Consumer (C2C) E-Commerce Marketplace

## 1. Project Overview

KasiMarket is a web-based Consumer-to-Consumer (C2C) e-commerce platform developed to provide individuals with an accessible online marketplace where they can buy and sell products directly to one another.

The platform focuses on supporting township communities and small-scale traders by making it easier for people to advertise their products, connect with potential buyers, and participate in online commerce.

Unlike traditional e-commerce platforms that mainly support registered businesses, KasiMarket allows ordinary users to act as both buyers and sellers using a single account.

The system provides a simple and user-friendly environment where users can browse products, search by category, create product listings, contact sellers, place orders, and review products.

## 2. Project Purpose

The main purpose of KasiMarket is to encourage digital participation in local communities by making online buying and selling more accessible.

Many individuals and small businesses rely on informal methods such as WhatsApp groups, Facebook Marketplace, and word-of-mouth advertising to sell their products. Although these methods are useful, they do not always provide a dedicated environment for managing product listings and purchases.

KasiMarket aims to address some of these challenges by providing a centralised marketplace where users can:

- Advertise products they want to sell.
- Discover products offered by other community members.
- Communicate directly with sellers.
- Place orders through the platform.
- Build trust through product reviews and ratings.

The broader goal is to support local entrepreneurship and create opportunities for individuals to participate in the digital economy.

## 3. Project Objectives

The main objectives of KasiMarket are to:

1. Develop an accessible online marketplace for individuals buying and selling products.
2. Provide a simple registration and authentication system.
3. Allow users to create, update, and manage their product listings.
4. Make product discovery easier through search and category filtering.
5. Provide an ordering process for buyers.
6. Encourage trust through product reviews and ratings.
7. Provide administrators with tools to manage users and product listings.
8. Create a user-friendly interface that works across different screen sizes.

## 4. Technologies Used

KasiMarket was developed using the following technologies:

| Technology | Purpose |
|---|---|
| HTML5 | Structures the web pages and application content. |
| CSS3 | Handles the visual design, styling, layout, and responsiveness. |
| JavaScript | Adds client-side interactivity and dynamic behaviour. |
| PHP | Handles server-side functionality, authentication, product management, and order processing. |
| MySQL | Stores user accounts, product listings, orders, and reviews. |
| XAMPP | Provides a local development environment using Apache and MySQL. |
| phpMyAdmin | Used to manage the MySQL database. |
| Git & GitHub | Used for version control and project hosting. |

## 5. Main Features

### 5.1 User Registration and Authentication
- Users can create an account by providing their personal details.
- Registered users can log in and log out securely.
- Passwords are stored using password hashing.
- User sessions are used to manage authenticated access.

### 5.2 Product Management
- Users can add products they want to sell.
- Product listings include a title, description, category, price, and image.
- Users can view and manage their own listings.
- Sellers can edit or remove their products.

### 5.3 Product Browsing and Searching
- Users can browse available products.
- Products are displayed in organised product cards.
- Users can search for products by name or keywords.
- Category filtering helps users find relevant products.

### 5.4 Product Details
Each product has a dedicated details page displaying information such as:
- Product name.
- Product image.
- Price.
- Description.
- Product category.
- Seller information.

Buyers can also access the seller's contact details to communicate directly.

### 5.5 Buying and Ordering
- Buyers can select a product they want to purchase.
- The checkout page displays the selected product and relevant information.
- Buyers can select an available payment method.
- Orders are recorded in the database.
- Buyers can view their order history and order status.

**Note:** The project provides an order and checkout workflow. It does not currently represent a fully integrated online payment gateway.

### 5.6 Product Reviews and Ratings
- Users can submit ratings for products.
- Buyers can leave comments about their experience.
- Reviews help other users make more informed purchasing decisions.

### 5.7 Administration
The platform includes a separate administrator area intended to support marketplace management.

Administrative functionality includes:
- Viewing registered users.
- Managing product listings.
- Monitoring marketplace activity.
- Managing inappropriate or problematic listings.

Administrator access is restricted to authorised accounts.

## 6. How the System Works

KasiMarket follows a client-server architecture.

1. A user accesses the platform through a web browser.
2. HTML, CSS, and JavaScript provide the frontend interface.
3. PHP processes user requests and application logic on the server.
4. PHP communicates with the MySQL database to retrieve or store information.
5. The server returns the appropriate response to the user's browser.

For example, when a user adds a product, the application receives the submitted information, processes it using PHP, and stores the product details in the MySQL database. The product can then appear in the marketplace for other users to discover.

## 7. Database

The application uses MySQL as its relational database management system.

The database stores information required for the marketplace to operate.

The main database entities include:

- **Users:** Stores user information, login credentials, and account roles.
- **Products:** Stores product details, prices, images, categories, and availability.
- **Orders:** Records purchases made by buyers.
- **Reviews:** Stores product ratings and comments submitted by users.

The database is supplied in the project through the `kasimarket.sql` file.

## 8. Project Structure

The project is organised into folders according to their responsibilities.

```text
KasiMarket/
│
├── admin/
│   ├── index.php
│   ├── manage_users.php
│   ├── manage_products.php
│   └── admin_auth.php
│
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── main.js
│   └── img/
│
├── auth/
│   ├── register.php
│   ├── login.php
│   ├── logout.php
│   └── verify.php
│
├── config/
│   └── db.php
│
├── orders/
│   ├── checkout.php
│   ├── my_orders.php
│   ├── place_order.php
│   ├── confirm_order.php
│   └── order_history.php
│
├── products/
│   ├── add_product.php
│   ├── edit_product.php
│   ├── delete_product.php
│   └── product_details.php
│
├── reviews/
│   ├── add_review.php
│   └── get_reviews.php
│
├── seller/
│   ├── index.php
│   └── my_listings.php
│
├── uploads/
│
├── index.php
├── search.php
└── kasimarket.sql
```

*Note: The structure above represents the main application files. Some files may differ depending on the latest version of the project.*

## 9. Installation and Setup

Follow these instructions to run KasiMarket on a local computer.

### Requirements

Before installing the project, make sure you have:

- PHP 8.0 or later.
- MySQL.
- Apache web server.
- XAMPP or another compatible PHP development environment.
- A web browser.

### Step 1: Download the Project

Clone the repository:

```bash
git clone https://github.com/motsoenengsechaba-blip/KasiMarket.git
```

Alternatively, download the repository as a ZIP file and extract it.

### Step 2: Move the Project

Place the extracted `KasiMarket` folder inside the XAMPP `htdocs` directory.

For example:

```text
C:\xampp\htdocs\KasiMarket
```

### Step 3: Start XAMPP

Open the XAMPP Control Panel and start:

- Apache
- MySQL

### Step 4: Create the Database

1. Open your browser.
2. Navigate to `http://localhost/phpmyadmin`.
3. Create a new database called:

```text
kasimarket
```

4. Select the database.
5. Open the Import tab.
6. Select the `kasimarket.sql` file from the project.
7. Click Import.

### Step 5: Configure the Database Connection

Open:

```text
config/db.php
```

Update the database connection details to match your local MySQL configuration.

For example:

```php
<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "kasimarket";

$conn = new mysqli(
    $host,
    $user,
    $password,
    $database
);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

?>
```

Make sure the database name and credentials match your own setup.

### Step 6: Run the Application

Open your browser and visit:

```text
http://localhost/KasiMarket/
```

The KasiMarket homepage should now load.

## 10. Security Considerations

The project uses several basic security practices, including:

- Password hashing to avoid storing plain-text passwords.
- PHP sessions for authenticated user access.
- Prepared SQL statements to reduce the risk of SQL injection.
- Role-based access restrictions for administrator functionality.
- Server-side processing of form submissions.

Additional security improvements are recommended before using the platform in a real commercial environment.

## 11. Future Improvements

Although KasiMarket provides the core functionality of a C2C marketplace, several improvements could be introduced in future versions.

Possible improvements include:

- Integration with secure online payment gateways such as PayFast or Paystack.
- An internal messaging system between buyers and sellers.
- Email notifications for orders and account activities.
- Improved seller verification and buyer protection.
- Product reporting and moderation tools.
- Delivery and collection tracking.
- Advanced product filtering and sorting.
- Improved mobile responsiveness and accessibility.
- More detailed analytics for administrators.
- Stronger account security, including password recovery and multi-factor authentication.

## 12. Project Significance

KasiMarket demonstrates how web technologies can be used to develop a practical e-commerce solution that addresses challenges within local communities.

The project combines frontend development, backend programming, database management, authentication, and e-commerce functionality into one application.

It also demonstrates the potential of digital platforms to support small-scale traders, encourage entrepreneurship, and improve access to online marketplaces within township communities.

## 13. Project Status

**Project:** KasiMarket  
**Application Type:** Web-Based Application  
**Architecture:** Client-Server  
**E-Commerce Model:** Consumer-to-Consumer (C2C)  
**Development Status:** Academic Project / Development Version

## 14. Author

Developed as a Software Engineering project.

**GitHub Repository:**  
https://github.com/motsoenengsechaba-blip/KasiMarket

---

*Thank you for checking out KasiMarket!*
