# CURHATIN API DOCUMENTATION


## Authentication
### Login (POST)
>/api/login

**Request**
```json 
{
    "email": "wahed@gmail.com",
    "password": "wahid123"
}
```

**Response Success**
```json
{
    "success": true,
    "message": "Authenticated",
    "data": {
        "access_token": "4|Za5kRcTWSafiafqaaVbjiTmFq6RCkWWK0mq8nk12",
        "token_type": "Bearer",
        "user": {
            "id": 2,
            "name": "User 1",
            "email": "wahed@gmail.com",
            "email_verified_at": null,
            "role": 0,
            "picture": "1667582831.jpg",
            "phone": "087860501411",
            "is_premium": null,
            "premium_period": null,
            "otp": null,
            "profile_photo_url": "https://ui-avatars.com/api/?name=U+1&color=7F9CF5&background=EBF4FF"
        }
    }
}
```

**Response Error**
```json
{
    "success": false,
    "message": "Invalid password"
}
```
