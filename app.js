const express = require('express');

const app = express();

//////////////////////////////////
// permettre l'accès à l'API (CORS)
app.use((req, res, next) => {
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader("Access-Control-Allow-Credentials", "true");
    res.setHeader("Access-Control-Max-Age", "1800");
    res.setHeader('Access-Control-Allow-Headers', 'X-CSRF-Token,Origin, X-Requested-With, Content, Accept, Accept-Version, Content-Length, Content-MD5, Content-Type, Date, X-Api-Version, Authorization');
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    next();
  });

  
  app.use((req, res) => {
    function lancerFichierPHP() {
      fetch('index.php')
          .then(response => response.text())
          .then(data => {
              // Faire quelque chose avec la réponse du fichier PHP
              console.log(data);
          })
          .catch(error => {
              console.log('Une erreur s\'est produite :', error);
          });
  }

  window.onload = lancerFichierPHP; 
 });

module.exports = app;