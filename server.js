const express = require('express');
const mysql = require('mysql');
const cors = require('cors');
const bodyParser = require('body-parser');

const app = express()
app.use(cors())
app.use(bodyParser.json()); 

const db = mysql.createConnection({
    host: "localhost",
    user: 'root',
    password: '',
    database: 'bballdb'
})

app.get('/teams', (req, res) => {
   const sql = "SELECT * FROM teams"
   db.query(sql, (err, data) => {
    if(err) return res.json(err);
    return res.json(data);
   })
})

app.post('/teams', (req, res) => {
    const { id, homename, homescore, awayname, awayscore } = req.body;
    const sql = `INSERT INTO teams (id, homename, homescore, awayname, awayscore) VALUES (?, ?, ?, ?, ?)`;
    db.query(sql, [id, homename, homescore, awayname, awayscore], (err, result) => {
        if(err) return res.status(400).json(err);
        res.status(201).json({ id, homename, homescore, awayname, awayscore });
    });
});

app.put('/teams/:id', (req, res) => {
    const { homescore, awayscore } = req.body;
    const { id } = req.params; 

    const sql = `UPDATE teams SET homescore = ?, awayscore = ? WHERE id = ?`;

    db.query(sql, [homescore, awayscore, id], (err, result) => {
        if(err) return res.status(400).json(err);
        if(result.affectedRows === 0) return res.status(404).json({ message: "Game not found" }); 
        res.json({ id, homescore, awayscore });
    });
});


app.delete('/teams/:id', (req, res) => {
    const { id } = req.params;
    const sql = `DELETE FROM teams WHERE id = ?`;
    db.query(sql, [id], (err, result) => {
        if(err) return res.status(400).json(err);
        if(result.affectedRows === 0) return res.status(404).json({ message: "Team not found" });
        res.status(204).send(); // 
    });
});

app.listen(8081, () => {
   console.log("Server is running on port 8081") 
})
