# PHP Infinite Scroll Multiselect

This project demonstrates the use of [Select2](https://select2.org/) for multiselect dropdowns with infinite scrolling functionality. 

## Demonstration

Designed to efficiently handle large datasets with smooth infinite scrolling. As the user types or scrolls, new data is fetched dynamically, improving performance and usability—ideal for large lists such as thousands of features or projects.

## Project

- Select2 multiselect dropdown for features  
- Select2 single select dropdown for projects  
- Infinite scroll for the both.

## MySQL database Configuration 

MySQL database settings are located in `config/_db.php`.

Sample SQL data is available in `insert_random_data.sql`, which populates:
- A multiselect dropdown for **features**
- A single select dropdown for **projects**

## Running the Local Server

To start the server locally, run the following command from the project root:

```bash
php -S localhost:3000 -t public
