const express = require('express');
const router = express.Router();

router.get('/', (req, res) => {
    res.send('Welcome to the Mobile routes!');
});

router.get('/app', (req, res) => {
    res.send('Mobile App Home');
});

module.exports = router;
