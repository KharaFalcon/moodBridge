const express = require('express');
const session = require('express-session');
const app = express();
const port = 3000;

app.use(session({
    secret: 'secretKey', // Change this to a more secure secret in production
    resave: false,
    saveUninitialized: true
}));

app.use(express.urlencoded({ extended: true }));
app.use(express.static('public'));

// Register endpoint
app.post('/register', (req, res) => {
    const { name, email, password } = req.body;

    // For simplicity, store the user data in a session variable
    req.session.user = {
        name,
        email,
        password
    };

    res.send('Registration successful');
});

// Login endpoint
app.post('/login', (req, res) => {
    const { name, password } = req.body;

    // Retrieve user data from the session
    const user = req.session.user;

    if (user && user.name === name && user.password === password) {
        res.send('Login successful');
    } else {
        res.send('Login failed');
    }
});

app.listen(port, () => {
    console.log(`Server is running on port ${port}`);
});
