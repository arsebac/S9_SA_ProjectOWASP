# Security of Web Applications: Project OWASP

This project was about creating a vulnerable application by introducing the top 10 OWASP 2017 vulnerabilities.

This repositories contains three websites :

- The vulnerable website in the folder ``insecureWebsite``.
- The "fixed" website in the folder ``secureWebsite``.
- A "support" malicious website used to intercept data in the folder ``hackerWebsite``.

## Getting Started

### Prerequisites

- WAMP

### Installing

1. Copy all files to your web server directory
2. Right-click on WAMP icon in the taskbar -> Tools -> Command Prompt -> MYSQL/bin
    1. Type ```mysql.exe -uroot``` in the command prompt and press enter
    2. Type the following SQL commands :
    - ```CREATE DATABASE owasp;```
    - ```GRANT ALL ON *.* TO 'root'@'%';```
3. Go to "http://my_web_server/insecureWebsite/**install.php**"
    - This script will setup the database for you
4. Go to "http://my_web_server/insecureWebsite/**index.php**"
    - You should be able to login with `admin` as login and `Azertyuiop09` as password
    - You should be able to login with `alice` as login and `Azertyuiop09` as password
    - You should be able to login with `bob` as login and `password` as password

## OWASP Vulnerabilities

- A1. Injection
- A2. Broken Authentication
- A3. Sensitive Data Exposure
- A4. XML External Entities
- A5. Broken Access Control
- A6. Security Misconfiguration
- A7. Cross-site scripting (XSS)
- A8. Insecure Deserialization
- A9. Using components with known vulnerabilities
- A10. Insufficient Logging & Monitoring