const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');
const { pool } = require('../config/database');
const { redis } = require('../config/redis');

const generateTokens = (userId) => {
  const accessToken = jwt.sign({ userId }, process.env.JWT_SECRET, {
    expiresIn: process.env.JWT_EXPIRES_IN || '15m',
  });
  const refreshToken = jwt.sign({ userId }, process.env.JWT_REFRESH_SECRET, {
    expiresIn: process.env.JWT_REFRESH_EXPIRES_IN || '7d',
  });
  return { accessToken, refreshToken };
};

exports.register = async (req, res, next) => {
  try {
    const { email, password, name } = req.body;
    const hash = await bcrypt.hash(password, 12);
    const { rows } = await pool.query(
      'INSERT INTO users (email, password_hash, name) VALUES ($1, $2, $3) RETURNING id, email, name',
      [email, hash, name]
    );
    const tokens = generateTokens(rows[0].id);
    await redis.setex(`refresh:${rows[0].id}`, 7 * 24 * 3600, tokens.refreshToken);
    res.status(201).json({ user: rows[0], ...tokens });
  } catch (err) {
    next(err);
  }
};

exports.login = async (req, res, next) => {
  try {
    const { email, password } = req.body;
    const { rows } = await pool.query('SELECT * FROM users WHERE email = $1', [email]);
    if (!rows.length || !(await bcrypt.compare(password, rows[0].password_hash))) {
      return res.status(401).json({ error: 'Invalid credentials' });
    }
    const { password_hash, ...user } = rows[0];
    const tokens = generateTokens(user.id);
    await redis.setex(`refresh:${user.id}`, 7 * 24 * 3600, tokens.refreshToken);
    res.json({ user, ...tokens });
  } catch (err) {
    next(err);
  }
};

exports.refresh = async (req, res, next) => {
  try {
    const { refreshToken } = req.body;
    const payload = jwt.verify(refreshToken, process.env.JWT_REFRESH_SECRET);
    const stored = await redis.get(`refresh:${payload.userId}`);
    if (stored !== refreshToken) return res.status(401).json({ error: 'Invalid refresh token' });
    const tokens = generateTokens(payload.userId);
    await redis.setex(`refresh:${payload.userId}`, 7 * 24 * 3600, tokens.refreshToken);
    res.json(tokens);
  } catch (err) {
    next(err);
  }
};

exports.logout = async (req, res, next) => {
  try {
    await redis.del(`refresh:${req.user.id}`);
    res.json({ message: 'Logged out successfully' });
  } catch (err) {
    next(err);
  }
};
