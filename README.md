# SE_School_3

# Requirements
- Docker
- You must have free port 8000

## Quick start
Clone project and run next commands:
```
docker-compose up
docker exec -it se-school-3_php composer install
```

Then you can visit http://localhost:8000/api/rate

## Endpoints:
- [GET] http://localhost:8000/api/rate
- [POST] http://localhost:8000/api/subscribe
  - paramets:
    - (formData) email: string
- [POST] http://localhost:8000/api/sendEmails

## App logic
The application provides the current price of BTC in UAH, allows you to subscribe an email newsletter and send an email with the current price of BTC/UAH to all subscribed emails.

Email addresses are stored in var/storage/emails.txt
