# Mobile Otp Verify by Twilio  

## Tags 

[![Laravel](https://img.shields.io/badge/Laravel-red.svg)](https://laravel.com/)
[![JavaScript](https://img.shields.io/badge/JavaScript-yellow.svg)](https://www.javascript.com/)
[![jQuery](https://img.shields.io/badge/jQuery-blue.svg)](https://jquery.com/)
[![Toastr](https://img.shields.io/badge/Toastr-orange.svg)](https://github.com/CodeSeven/toastr)
[![Twilio](https://img.shields.io/badge/Twilio-blue.svg)](https://www.twilio.com)
[![intl-tel-input](https://img.shields.io/badge/intl--tel--input-green.svg)](https://github.com/jackocnr/intl-tel-input)


This project demonstrates how to implement mobile number verification using **Twilio** in a **Laravel** application. The user can:

- Enter their mobile number.
- Receive an OTP (One-Time Password) via SMS using **Twilio**.
- Verify the OTP entered by the user.
- Resend the OTP if needed.
- Use **Toastr** for displaying real-time notifications to users.

## Technologies Used  

- **Frontend** → HTML, CSS ,Blade Template, JavaScript, jQuery 
- **Backend** → Laravel 
- **Library** → Toastr, intl-tel-input (js library to format and validate international phone numbers)
- **Package** → Twilio package

##  Requirements  

- PHP **>=8.0**  
- Laravel **v11.0**  
- Composer  
- Twilio Account  


##  Changes in Project  

- Set the Twilio Details inside `.env`:  
    ```env
    TWILIO_SID=AC78e4c76542d5fghhhdhd13ebe49f1
    TWILIO_AUTH_TOKEN=7457dbhdiidhiddi5a5a798dddba79b56
    TWILIO_PHONE_NUMBER=+162873737977
    ```

## Installation  

1. **Clone the repository**  
    ```sh
    git clone https://github.com/Subodhdhyani/mobile-otp-auth-twilio.git
    cd mobile-otp-auth-twilio
    ```

2. **Install dependencies**  
    ```sh
    composer install
    ```

3. **Copy `.env.example` to `.env` and update environment variables**  
    ```sh
    cp .env.example .env
    php artisan key:generate
    ```
    
4. **Install Twilio package or SDK (Software Development Kit)**
   ```sh
   composer require twilio/sdk
    ```  

5. **Serve the application**  
    ```sh
    php artisan serve
    ```

## Contributors  

- [Subodh Dhyani](https://github.com/subodhdhyani)  


## 📸 Screenshots  


[Initial Form](https://github.com/user-attachments/assets/7c18443a-aacb-4713-94cc-95fde65a297c)
[OTP Send](https://github.com/user-attachments/assets/d1efd4f6-3685-4dc9-b168-383eb191f705)
[Wrong OTP](https://github.com/user-attachments/assets/eb89d49f-f94e-4799-9fb4-45f40ed52e63)
[Resend OTP](https://github.com/user-attachments/assets/7bce3238-76d7-4fd8-9cf7-04f72d3a5b25)



