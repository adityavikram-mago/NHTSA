# NHTSA
PHP API to get information about crash test ratings for vehicles from NHTSA NCAP 5 Star Safety Ratings
URL: https://one.nhtsa.gov/webapi/Default.aspx?SafetyRatings/API/5


## Application Requirements
* PHP >= 5.6.4
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension

## Installation Steps
The system utilizes [Composer](https://getcomposer.org/download/) to manage its dependencies. So, before using the system, make sure you have `Composer` installed on your machine.

* Clone repository via git
```
https://github.com/adityavikram-mago/NHTSA.git
```

* Install Composer after moving to root directory
```
composer install
```
* Start Server 
```
php -S localhost:8080 -t ./public
```

**Note:** check `8080` is available
