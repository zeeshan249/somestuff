---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)
<!-- END_INFO -->

#general
<!-- START_af82433e555a57f31d78233071a5a020 -->
## api/v1/auth

> Example request:

```bash
curl -X POST "http://localhost/api/v1/auth" \
-H "Accept: application/json" \
    -d "email"="granville.keebler@example.org" \
    -d "password"="in" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/v1/auth",
    "method": "POST",
    "data": {
        "email": "granville.keebler@example.org",
        "password": "in"
},
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/auth`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | email |  required  | 
    password | string |  required  | 

<!-- END_af82433e555a57f31d78233071a5a020 -->

<!-- START_b0f5a36a454deb7e0e15c7a4c5f035ab -->
## auth

> Example request:

```bash
curl -X GET "http://localhost/auth" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/auth",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET auth`

`HEAD auth`


<!-- END_b0f5a36a454deb7e0e15c7a4c5f035ab -->

<!-- START_c9a1c827dbd09a44b847639f5cd2cde9 -->
## auth

> Example request:

```bash
curl -X POST "http://localhost/auth" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/auth",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST auth`


<!-- END_c9a1c827dbd09a44b847639f5cd2cde9 -->

<!-- START_aab8b93c5f323d3e6b2310e823dcc78a -->
## control/dashboard

> Example request:

```bash
curl -X GET "http://localhost/control/dashboard" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/control/dashboard",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "message": ""
}
```

### HTTP Request
`GET control/dashboard`

`HEAD control/dashboard`


<!-- END_aab8b93c5f323d3e6b2310e823dcc78a -->

<!-- START_2ff783a67451dd1c124762cc2f811feb -->
## control/settings/role

> Example request:

```bash
curl -X GET "http://localhost/control/settings/role" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/control/settings/role",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "message": ""
}
```

### HTTP Request
`GET control/settings/role`

`HEAD control/settings/role`


<!-- END_2ff783a67451dd1c124762cc2f811feb -->

<!-- START_b5921265f570f0c189be8e2a0785f2d6 -->
## control/settings/role-form

> Example request:

```bash
curl -X GET "http://localhost/control/settings/role-form" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/control/settings/role-form",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "message": ""
}
```

### HTTP Request
`GET control/settings/role-form`

`HEAD control/settings/role-form`


<!-- END_b5921265f570f0c189be8e2a0785f2d6 -->

