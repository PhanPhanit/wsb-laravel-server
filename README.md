<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).




# Documentation




## wsb-laravel



## Indices

* [Auth](#auth)

  * [Forgot Password](#1-forgot-password)
  * [Login](#2-login)
  * [Logout](#3-logout)
  * [Register](#4-register)
  * [Reset Password](#5-reset-password)

* [Category](#category)

  * [Admin Get All Category](#1-admin-get-all-category)
  * [Create Category](#2-create-category)
  * [Delete Category](#3-delete-category)
  * [Get All Category](#4-get-all-category)
  * [Update Category](#5-update-category)

* [Check Out With Stripe](#check-out-with-stripe)

  * [Create Payment Intent](#1-create-payment-intent)

* [Order](#order)

  * [Create Order](#1-create-order)
  * [Get All Order](#2-get-all-order)
  * [Get Sinlge Order](#3-get-sinlge-order)
  * [Get Total Order](#4-get-total-order)
  * [Get Total Price](#5-get-total-price)
  * [Show All My Order](#6-show-all-my-order)
  * [Update Order](#7-update-order)

* [Order Item](#order-item)

  * [Create Order Item](#1-create-order-item)
  * [Delete Many Order Item](#2-delete-many-order-item)
  * [Delete Order Item](#3-delete-order-item)
  * [Get Order Item](#4-get-order-item)
  * [Get Single Item](#5-get-single-item)
  * [Update Order Item](#6-update-order-item)

* [Product](#product)

  * [Admin Get All Products](#1-admin-get-all-products)
  * [Admin Get Single Product](#2-admin-get-single-product)
  * [Create Product](#3-create-product)
  * [Delete Product](#4-delete-product)
  * [Get All Product](#5-get-all-product)
  * [Get Single Product](#6-get-single-product)
  * [Increase View Product](#7-increase-view-product)
  * [Update Product](#8-update-product)

* [Review](#review)

  * [Create Review](#1-create-review)
  * [Delete Review](#2-delete-review)
  * [Get All Review](#3-get-all-review)
  * [Get Single Review](#4-get-single-review)
  * [Star Percent](#5-star-percent)
  * [Update Review](#6-update-review)

* [Slide](#slide)

  * [Admin Get All Slide](#1-admin-get-all-slide)
  * [Create Slide](#2-create-slide)
  * [Delete Slide](#3-delete-slide)
  * [Get All Slide](#4-get-all-slide)
  * [Get Single Slide](#5-get-single-slide)
  * [Update Slide](#6-update-slide)

* [Upload File](#upload-file)

  * [Upload File In Cloud](#1-upload-file-in-cloud)
  * [Upload File Local](#2-upload-file-local)

* [User](#user)

  * [Admin Update All User](#1-admin-update-all-user)
  * [Count All User](#2-count-all-user)
  * [Create User](#3-create-user)
  * [Delete User](#4-delete-user)
  * [Get All Users](#5-get-all-users)
  * [Get Single User](#6-get-single-user)
  * [Show current User](#7-show-current-user)
  * [Update User](#8-update-user)
  * [Update User Password](#9-update-user-password)


--------


## Auth



### 1. Forgot Password



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{URLLA}}/auth/forgot-password
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

```js        
{
    "email": "phanphanit.pp12345@gmail.com"
}
```



### 2. Login



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{URLLA}}/auth/login
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

```js        
{
    "email": "phanphanit.pp12345@gmail.com",
    "password": "Phannit7777##"
}
```



### 3. Logout



***Endpoint:***

```bash
Method: DELETE
Type: 
URL: {{URLLA}}/auth/logout
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |
| Authorization | Bearer 9|Di2AJVkFarO7US6e5QcRzvU7qaw727WLIXOZMuOq |  |



### 4. Register



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{URLLA}}/auth/register
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

```js        
{
    "name": "Phan Phanit",
    "email": "phanphanit.pp12345@gmail.com",
    "password": "secret"
}
```



### 5. Reset Password



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{URLLA}}/auth/reset-password
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

```js        
{
    "token": "$2y$10$.ONN9.FCUj4dCnSUR1FxfOciJbS6BxcNiFWs7hImaOxZOs9EH5o9G",
    "email": "phanphanit.pp12345@gmail.com",
    "password": "secret"
}
```



## Category



### 1. Admin Get All Category



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/wsb-cate/all
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 2. Create Category



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{URLLA}}/wsb-cate
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

```js        
{
    "name": "Romance5",
    "image": "https://i.pinimg.com/564x/98/4b/c6/984bc6602463c70bc16c4d71987fc4d3.jpg"
}
```



### 3. Delete Category



***Endpoint:***

```bash
Method: DELETE
Type: 
URL: {{URLLA}}/wsb-cate/1
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 4. Get All Category



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/wsb-cate
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 5. Update Category



***Endpoint:***

```bash
Method: PATCH
Type: RAW
URL: {{URLLA}}/wsb-cate/2
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

```js        
{
    "name": "Romance1",
    "image": "https://cdn-icons-png.flaticon.com/512/1692/1692130.png",
    "isShow": true
}
```



## Check Out With Stripe



### 1. Create Payment Intent



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{URLLA}}/wsb-ch-out/create-payment-intent
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

```js        
{
    "price": 1
}
```



## Order



### 1. Create Order



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{URLLA}}/wsb-od
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

```js        
{
    "delivery": 2,
    "paymentIntent": "test",
    "phoneNumber": "011336353",
    "city": "Phnom Penh",
    "address": "st 191",
    "orderDate": "2022-01-02",
    "orderItem": [
        {
            "name": "Product1",
            "image":"example.png",
            "price": 25,
            "discount": 10,
            "quantity": 2,
            "product": 2
        },
        {
            "name": "Product1",
            "image":"example.png",
            "price": 25,
            "discount": 10,
            "quantity": 2,
            "product": 3
        }
    ]
    
}
```



### 2. Get All Order



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/wsb-od
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| search | 11336353 |  |



### 3. Get Sinlge Order



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/wsb-od/51
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 4. Get Total Order



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/wsb-od/get-total-order
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| status | pending |  |



### 5. Get Total Price



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/wsb-od/get-total-price
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| status | success |  |



### 6. Show All My Order



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/wsb-od/show-all-my-order
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 7. Update Order



***Endpoint:***

```bash
Method: PATCH
Type: RAW
URL: {{URLLA}}/wsb-od/50
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

```js        
{
    "status": "success"
}
```



## Order Item



### 1. Create Order Item



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{URLLA}}/wsb-od-item
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

```js        
{
    "image": "https://m.media-amazon.com/images/I/71uWP+f-EsL._AC_UY327_FMwebp_QL65_.jpg",
    "quantity": 1,
    "product": 4
}
```



### 2. Delete Many Order Item



***Endpoint:***

```bash
Method: DELETE
Type: 
URL: {{URLLA}}/wsb-od-item
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 3. Delete Order Item



***Endpoint:***

```bash
Method: DELETE
Type: 
URL: {{URLLA}}/wsb-od-item/15
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 4. Get Order Item



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/wsb-od-item
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 5. Get Single Item



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/wsb-od-item/1
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 6. Update Order Item



***Endpoint:***

```bash
Method: PATCH
Type: RAW
URL: {{URLLA}}/wsb-od-item/15
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

```js        
{
    "quantity": 200
}
```



## Product



### 1. Admin Get All Products



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/wsb-pro/all
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| search | 1 |  |



### 2. Admin Get Single Product



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/wsb-pro/2/all
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 3. Create Product



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{URLLA}}/wsb-pro
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

```js        
{
    "name": "Engaging Lord Charles: A Regency Romance 15",
    "price": 15.55,
    "discount": 1,
    "author": "Laura Beers",
    "publisher": "Jim Date (Narrator), Pottermore Publishing",
    "genre": "Fansty",
    "language": "English",
    "country": "United State",
    "published": "Semtember 25, 2018",
    "description": "Miss Henrietta Whiston could only be considered unlucky. She didn’t seek out misfortune, but it always seemed to find her. When her sister asks her to engage Lord Charles so she may entertain two suitors of her own, Henrietta is reluctant, despite finding herself intrigued by this man who loves antiquities.",
    "image": [
        "https://i.pinimg.com/236x/5a/cb/98/5acb983b6c313e1ec5722922de48f30d.jpg",
        "https://i.pinimg.com/236x/56/95/fe/5695fe9180eb4bbe198c61a9592feb88.jpg",
        "https://i.pinimg.com/236x/9c/8a/55/9c8a55f4d73140bf53ed89f4e35819fb.jpg"
    ],
    "category": 1
}
```



### 4. Delete Product



***Endpoint:***

```bash
Method: DELETE
Type: 
URL: {{URLLA}}/wsb-pro/1
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 5. Get All Product



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/wsb-pro
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 6. Get Single Product



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/wsb-pro/14
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 7. Increase View Product



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/wsb-pro/increase-view/2
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 8. Update Product



***Endpoint:***

```bash
Method: PATCH
Type: RAW
URL: {{URLLA}}/wsb-pro/2
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

```js        
{
    "views": 88,
    "name": "Wandering Warrior of Wudang",
    "sold": 66,
    "isShow": true,
    "price": 54.99
}
```



## Review



### 1. Create Review



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{URLLA}}/wsb-rev
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

```js        
{
    "rating": 4,
    "comment": "Good product",
    "product": 7
}
```



### 2. Delete Review



***Endpoint:***

```bash
Method: DELETE
Type: 
URL: {{URLLA}}/wsb-rev/7
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 3. Get All Review



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/wsb-rev
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| product | 4 |  |



### 4. Get Single Review



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/wsb-rev/2
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 5. Star Percent



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/wsb-rev/star-percent/2
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 6. Update Review



***Endpoint:***

```bash
Method: PATCH
Type: RAW
URL: {{URLLA}}/wsb-rev/135
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

```js        
{
    "rating": 3.5,
    "comment": "Not bad 1.5 Phan Phanit"
}
```



## Slide



### 1. Admin Get All Slide



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/wsb-slide/admin
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 2. Create Slide



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{URLLA}}/wsb-slide
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

```js        
{
    "title": "Discover Your Unlimited Knowledgeffgre  rgerg",
    "subtitle": "A new world contains in each every pages of the books",
    "product": 3
}
```



### 3. Delete Slide



***Endpoint:***

```bash
Method: DELETE
Type: 
URL: {{URLLA}}/wsb-slide/1
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 4. Get All Slide



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/wsb-slide
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 5. Get Single Slide



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/wsb-slide/16
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 6. Update Slide



***Endpoint:***

```bash
Method: PATCH
Type: RAW
URL: {{URLLA}}/wsb-slide/1
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

```js        
{
    "title": "Hello world 12",
    "subtitle": "Hello subtitle 12",
    "isShow": true,
    "product": 2
}
```



## Upload File



### 1. Upload File In Cloud



***Endpoint:***

```bash
Method: POST
Type: FORMDATA
URL: {{URLLA}}/wsb-upload/upload-cloud
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

| Key | Value | Description |
| --- | ------|-------------|
| images[] |  |  |



### 2. Upload File Local



***Endpoint:***

```bash
Method: POST
Type: FORMDATA
URL: {{URL}}/wsb-upload/upload-local
```



***Body:***

| Key | Value | Description |
| --- | ------|-------------|
| images |  |  |



## User



### 1. Admin Update All User



***Endpoint:***

```bash
Method: PATCH
Type: RAW
URL: {{URLLA}}/users/2
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

```js        
{
    "name": "Phan Phanit",
    "email": "phanphanit1@gmail.com",
    "role": "admin",
    "isActive": true
}
```



### 2. Count All User



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/users/count-all-user
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| role | user |  |



### 3. Create User



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{URLLA}}/users
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

```js        
{
    "name": "PIG PIG",
    "email": "pigvideopeppa.pp567@gmail.com",
    "password": "secret",
    "role": "manager",
    "isActive": true
}
```



### 4. Delete User



***Endpoint:***

```bash
Method: DELETE
Type: 
URL: {{URLLA}}/users/1
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 5. Get All Users



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/users
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 6. Get Single User



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/users/1
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 7. Show current User



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{URLLA}}/users/showMe
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



### 8. Update User



***Endpoint:***

```bash
Method: PATCH
Type: RAW
URL: {{URLLA}}/users/updateUser
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

```js        
{
    "name": "Phan Phanit",
    "email": "phanphanit@gmail.com"
}
```



### 9. Update User Password



***Endpoint:***

```bash
Method: PATCH
Type: RAW
URL: {{URLLA}}/users/updateUserPassword
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |



***Body:***

```js        
{
    "oldPassword": "secret1",
    "newPassword": "secret"
}
```



---
[Back to top](#wsb-laravel)
> Made with &#9829; by [thedevsaddam](https://github.com/thedevsaddam) | Generated at: 2022-05-23 10:14:32 by [docgen](https://github.com/thedevsaddam/docgen)
