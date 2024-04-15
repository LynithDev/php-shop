<center>
  <p style="font-size: 34px; font-weight: 700;">PHP Shop</p>
  Made by <code>Lynith</code>
</center>

## General Description
An all purpose e-commerce store written in PHP utilising MySQL. It consists of user management, a basic permission system and management of product listings. 

## Functionality
- User login + register + logout
- User permissions
- Adding / removing of products
- Searching for products by name and description
- Setting the featured product
- Adding products to the cart for the current session
- "Buying" products

## Technical Description

### File Structure
The file structure is split as follows:
- `assets` - folder containing website graphics
- `categories` - folder containing pages for the categories sub-route
- `components` - folder containing reusable components across the entire website
- `helpers` - folder containing utilities and wrappers
- `products` - folder containing pages for the products sub-route
- `sql`
  - `init.sql` - file containing SQL queries to create an empty database with tables
  - `populate.sql` - file containing a sample dumped SQL database
- `styles` - folder containing CSS
- `user_content` - folder containing uploaded user content, such as product images

### Prepared MySQL Queries
All queries are created with prepared SQL statements, which should disallow the most common and simplest attack on PHP-written websites, **SQL Injection**

### Logic Splitting
The project attempts to split all logic from the routes, which should allow for a cleaner and easier to maintain codebase - of course the logic still needs to be called from the routes.