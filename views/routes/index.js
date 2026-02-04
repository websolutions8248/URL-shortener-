const express = require('express');
const router = express.Router();
const Url = require('../models/Url');

// Main Page
router.get('/', async (req, res) => {
  const shortUrls = await Url.find().limit(5).sort({_id: -1}); // Show last 5 links
  res.render('index', { shortUrls: shortUrls });
});

// Menu Pages Routes
router.get('/plans', (req, res) => res.render('plans'));
router.get('/features', (req, res) => res.render('features'));
router.get('/domains', (req, res) => res.render('domains'));
router.get('/resources', (req, res) => res.render('resources'));

// Shorten Logic (Same as before)
router.post('/shortUrls', async (req, res) => {
  let customAlias = req.body.alias;
  let shortCode = customAlias ? customAlias : undefined;
  
  await Url.create({ full: req.body.fullUrl, short: shortCode });
  res.redirect('/');
});

// Redirect Logic
router.get('/:shortUrl', async (req, res) => {
  const shortUrl = await Url.findOne({ short: req.params.shortUrl });
  if (shortUrl == null) return res.sendStatus(404);
  shortUrl.clicks++;
  shortUrl.save();
  res.redirect(shortUrl.full);
});

module.exports = router;
