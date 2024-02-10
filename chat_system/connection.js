var mysql = require('mysql');
var env = require('dotenv').config()

var connection = mysql.createConnection({
    host     : process.env.DB_HOST,
    port     : process.env.DB_PORT,
    user     : process.env.DB_USERNAME,
    password : process.env.DB_PASSWORD,
    database : process.env.DB_DATABASE,
});

// Attempt to connect to the database
connection.connect(function(err) {
    if (err) {
        console.error('Error connecting to MySQL:', err);
    } else {
        console.log('Connected to MySQL');
    }
});

// Handle MySQL connection errors
connection.on('error', function(err) {
    console.error('MySQL connection error:', err);
});

module.exports = connection;
