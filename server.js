const { spawn } = require('child_process');
const express = require('express');
const path = require('path');

const app = express();
const PORT = 3000;

// Serve static files (like frontend HTML, CSS, JS)
app.use(express.static(path.join(__dirname, 'public')));

// Route for homepage
app.get('/', (req, res) => {
    res.send('<h1>Welcome to the File Repository</h1><p>Node.js is running!</p>');
});

// Function to run PHP scripts
function runPHP(scriptPath, res) {
    const process = spawn("C:\\xampp\\php\\php.exe", [scriptPath]);

    let output = '';
    let error = '';

    process.stdout.on('data', (data) => {
        output += data.toString();
    });

    process.stderr.on('data', (data) => {
        error += data.toString();
    });

    process.on('close', (code) => {
        if (code === 0) {
            res.send(output);
        } else {
            res.status(500).send(`PHP Error: ${error}`);
        }
    });
}

// Route to test PHP execution
app.get('/server-check', (req, res) => {
    const scriptPath = path.join(__dirname, 'php', 'library', 'server-check.php');
    runPHP(scriptPath, res);
});

// Start the Node.js server
app.listen(PORT, () => {
    console.log(`✅ Server running at http://localhost:${PORT}/`);
});
