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
    - You should be able to login with `admin` as login and `Azertyuiop09` as password
    - You should be able to login with `alice` as login and `Azertyuiop09` as password
    - You should be able to login with `bob` as login and `password` as password

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

### 8 - Insecure Deserialization

> The application saves the role of the user in the cookie as well as in the session on the server side.
> However, for apikey.php, the role check relies on both sides with an OR operator instead of an AND.
> It results in a possible privilege escalation by modifying the serialized user stored in the `user` cookie.

Proof of Concept :

Regular serialized cookie string example for bob:
```string
a:5:{s:2:"id";s:1:"3";s:4:"role";s:7:"Regular";s:5:"login";s:3:"bob";s:9:"firstname";s:3:"Bob";s:8:"lastname";s:0:"";}
```

Privilege escalation for bob as Administrator:
```string
a:5:{s:2:"id";s:1:"3";s:4:"role";s:13:"Administrator";s:5:"login";s:3:"bob";s:9:"firstname";s:3:"Bob";s:8:"lastname";s:0:"";}
```

Privilege escalation encoded string (for cookie overload):
```string
a%3A5%3A%7Bs%3A2%3A%22id%22%3Bs%3A1%3A%223%22%3Bs%3A4%3A%22role%22%3Bs%3A13%3A%22Administrator%22%3Bs%3A5%3A%22login%22%3Bs%3A3%3A%22bob%22%3Bs%3A9%3A%22firstname%22%3Bs%3A3%3A%22Bob%22%3Bs%3A8%3A%22lastname%22%3Bs%3A0%3A%22%22%3B%7D
```

This hack is only possible on accessing `http://localhost/owasp/dashboard.php?view=apikey`

### 6 - Security Misconfiguration

> Directory listing is disabled in path `/conf`
> An hacker can access critical config files like `conf.ini`.

Just go to this URL: `http://my_web_server/conf/`
You can access to `conf.ini` and read critical settings like the crypt salt, the database credentials.

#### 10 - Insufficient Logging&Monitoring

The authentication mechanism log all tries in local, available for a people who know how to access to it.
`http://localhost/owasp/log.txt`

## Corrections

- XML style configuration: check if style exists before saving it