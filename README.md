# Project OWASP

## How to use

- Requires WAMP

1. Copy all files to your web server directory
2. Right-click on WAMP icon in the taskbar -> Tools -> Command Prompt -> MYSQL/bin
    1. Type ```mysql.exe -uroot``` in the command prompt and press enter
    2. Type the following SQL commands :
    * ```CREATE DATABASE owasp;```
    * ```GRANT ALL ON *.* TO 'root'@'%';```
3. Go to "http://my_web_server/install.php"
    - This script will setup the database for you
4. Go to "http://my_web_server/index.php"
    - You should be able to login with `admin` as login and `password` as password
