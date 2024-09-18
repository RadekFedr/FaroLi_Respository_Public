# FaroLi Repository

FaroLi is a web application designed to store URLs (links) of interesting web pages in a **PostgreSQL database**. 

### Overview

#### Features

- **Interactive Tiles**: Displays records from the database as interactive tiles, with clickable links to saved pages, along with titles, descriptions, keywords, and favicons.
- **Web Scraper**: A simple web scraper that extracts the title, description, keywords, and favicon link from a provided URL. The extracted data is loaded into an input form, allowing administrator to modify and submit it to the database.
- **Keyword Visualization**: A Python script generates an interactive network visualization of keywords and web page titles using the pyvis module. The script communicates with the PostgreSQL database and outputs an HTML page, which is accessible from the application's front page.

#### Technologies Used

- **PHP**
- **HTML**
- **CSS**
- **SQL**
- **Python**

#### Application Features

- **Admin Access**: Restricted access for administrators to manage stored data.
- **Web Scraper**: Automatically fetches metadata (title, description, keywords, favicon) from the URLs.
- **Input Form**: Interface for modifying and submitting web page details to the database.
- **Ordering Menu**: Sort and organize saved URLs.
- **Pagination**: Efficient navigation through large datasets.
- **Interactive Network**: Visualizes the relationship between keywords and web pages.

This application is built as a demonstration of skills and a personal portfolio.  

---  

#### Screenshot

![FaroLi Repository Screenshot](FaroLi_App_PrtScr.png)

---

### Configuration

#### Database & Application Setup

The application connects to a PostgreSQL database. To enable data recording through the input form, follow the steps below for database and role setup:

1. **Create the "repository" table**
2. **Create a Web Admin role**
3. **Create a Web Reader role**
4. **Set up the application administrator**

##### 1. Create the Repository Table

Run the following SQL script to create the "repository" table:

```sql
CREATE TABLE repository (
  box_id SERIAL NOT NULL PRIMARY KEY,
  url_web text NOT NULL,
  icon_url text,
  title text,
  descript text,
  keywords text,
  insert_date timestamp,
  checkbox boolean
);
```

##### 2. Create the Web Admin Role

The Web Admin role should have both read and write permissions for the "repository" table. After creating the role in the database, update the `db_access_rw.php` file located in the "config" folder by editing lines 3-7 with the appropriate database connection details and the Web Admin role credentials.

##### 3. Create the Web Reader Role

The Web Reader role should have read-only access to the "repository" table for visualizing the records as tiles in the application. To configure this, update the `db_access_r.php` file in the "config" folder, again on lines 3-7, with the necessary database connection information and Web Reader role credentials.

##### 4. Admin Authorization

To enable administrator login for the section that allows adding web pages to the database and using the web scraper, update the `webadmin_authorization.php` file in the "config" folder. Modify line 4 with the admin username and line 5 with the admin password.

---

### License

This project is licensed for **non-commercial use only**. You are not permitted to copy, modify, or distribute the code for commercial purposes without explicit permission from the author.

© Radek Fedr, 2024. All rights reserved.