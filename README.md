# CURHATIN API DOCUMENTATION


## Authentication
### Login (POST)
>/api/login

**Request**
```json 
{
    "email": String,
    "password": String
}
```

**Response**
```json
{
    "success": true,
    "message": "Authenticated",
    "data": {
        "access_token": "5|Qo5zlrt2KulNpvQTuPuU9Vy1VLOCuwZ5FKZWAJVz",
        "token_type": "Bearer",
        "user": {
            "id": 1,
            "name": "Abd. Wahid",
            "email": "wahed.blog99@gmail.com",
            "email_verified_at": "2022-11-05T13:03:14.000000Z",
            "current_team_id": null,
            "profile_photo_path": null,
            "two_factor_confirmed_at": null,
            "role": 0,
            "picture": null,
            "phone": "087860501411",
            "is_premium": null,
            "premium_period": null,
            "otp": 3835,
            "profile_photo_url": "https://ui-avatars.com/api/?name=A+W&color=7F9CF5&background=EBF4FF"
        }
    }
}
```
***
<br/>

### Register (POST)
>/api/register

**Request**
```json 
{
    "name": String,
    "email": String,
    "phone": String,
    "role": Int,
    "password": String,
    "str_number": String
}
```
**Note**
- role: 0 user, 1 doctor
- str_number: if registration as doctor or role == 1

***

**Response**
```json
{
    "success": true,
    "message": "User Registered, Check tour email"
}
```

<br/>

### User Verification (POST)
>/api/user_verification

**Request**
```json 
{
    "email": String,
    "otp": Int
}
```

**Response**
```json
{
    "success": true,
    "message": "Your account is verified"
}
```
***
<br/>

### Request OTP (GET)
>/api/request_otp

**Request**
```json 
{
    "email": String
}
```

**Response**
```json
{
    "success": true,
    "message": "Your OTP sent successfully, check your email"
}
```
***
<br/>

### Verification OTP (POST)
>/api/verify_otp

**Request**
```json 
{
    "email": String,
    "otp": Int
}
```

**Response**
```json
{
    "success": true,
    "message": "Your otp is verified"
}
```
***

<br/>

### Update User (POST)
>/api/update

**Request**
```json 
{
    "picture": File,
    "name": String
}
```

**Response**
```json
{
    "success": true,
    "message": "User updated"
}
```

**Note**
- all field is nullable

***

<br/>

### Update Doctor (POST)
>/api/update_doctor

**Request**
```json 
{
    "place_of_practice": String,
    "graduates": array of string,
    "categories": array of string
}
```

**Response**
```json
{
    "success": true,
    "message": "User updated"
}
```

**Note**
- all field is nullable

