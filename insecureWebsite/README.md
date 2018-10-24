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

## OWASP CHECKLIST

### 1 - SQL INJECTION

> The SQL query processor is not protected from SQL Injections in `login.process.php`. 
> An hacker may use a malformed password to log in without valid credentials. SQL Query 
> parameters are not properly escaped.

On the index.php

* login :
`admin';--`
* password :
`<empty>`

You will be granted access

### 2 - Broken Authentication : SESSION TOKEN FIXATION

> The application relies on two process to resolve the session :
- A session cookie : `PHPSESSID`
- URL Encoded session : `?SESSID=XXXXXXXXXXXXX`
> An hacker may be able to read this token and use it in order to access the system without being granted.

1) Forge a prepared URL with a fixed SESSID like `localhost/owasp/login.php?SESSID=jcanmp1m9tpcpjadi55bjg19bf`.
 - This is the `HACKER MALICIOUS URL` that will be spread to a victim.
 - In fact, the SESSID `jcanmp1m9tpcpjadi55bjg19bf` is the session id of the hacker.
 - The victim connects with Firefox
2) The victim connects to the application via this URL with his credentials
3) Once the victim connected, use the application because of the fixed session id.
 - The hacker connects via google chrome with `http://localhost/owasp/dashboard.php`

The vulnerability comes from this bad code :
```php
if (!empty($_GET['SESSID'])) {
    session_id ($_GET['SESSID']);
}
```
before `session_start()` anywhere in the project...

### 6 - Security Misconfiguration

> Directory listing is disabled in path `/conf`
> An hacker can access critical config files like `conf.ini`.

Just go to this URL: `http://my_web_server/conf/`
You can access to `conf.ini` and read critical settings like the crypt salt, the database credentials.

