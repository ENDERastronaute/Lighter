
By Leny Bressoud AKA ENDERastronaute

Contacts :  
- school : leny.bressoud@edu.vs.ch
- private : ENDERastronaute@gmail.com

# Lighter :flashlight:

![Postgres](https://img.shields.io/badge/postgres-%23316192.svg?style=for-the-badge&logo=postgresql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/bootstrap-%238511FA.svg?style=for-the-badge&logo=bootstrap&logoColor=white)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)


Lighter is a light, easy to use and intuitive PHP framework. It allows you to fully create an app in a simple way while leaving full control of what you are doing.

Lighter gives you a lot of features and dependencies, some are listed below.

# Table of content

- [Lighter :flashlight:](#lighter-flashlight)
- [Table of content](#table-of-content)
- [MVC](#mvc)
- [Router](#router)
- [Middleware](#middleware)
- [Components](#components)
- [Project](#project)

# MVC

Lighter mainly uses the MVC model (Model View Controller), although one can use views to work with HTML alongside PHP.

# Router

The router gives you full control over : which pages are public or not, which route returns what or custom error pages like 404.php.

It does not use Symphony.

# Middleware

The middleware function allows you to do anything before accessing a route.  
The [Middleware.php](./routes/Middleware.php) file has some examples of use, replace them by your needs.

# Components

The components feature allows one to reuse pieces of code everywhere and to pass data dynamically to them, just like functions but for HTML too.

# Project

Project is the main file of Lighter it is similar to Artisan.

Here's for exemple, how to start the server :

```sh
$ php project start localhost:3000
```

View more on the official documentation : todo