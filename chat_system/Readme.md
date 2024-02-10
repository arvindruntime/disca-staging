## Node System

- app.js is main file.
- connection.js is for database connection
- function.js is for interact with database.

## pm2 service

- use following command for start service
    -- pm2 start {path to app.js}
- use following command after change in app.js OR any other file of this DIR.
    -- pm2 list
    -- pm2 restart all/pm2 restart {service name}

- use following command after reboot server.
    -- pm2 list
    -- pm2 restart all/pm2 restart {service name}
    -- pm2 save