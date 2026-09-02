import 'dotenv/config';

function toPositiveInteger(value, fallback) {
  const parsed = Number(value);
  return Number.isInteger(parsed) && parsed > 0 ? parsed : fallback;
}

export const config = Object.freeze({
  port: toPositiveInteger(process.env.PORT, 3000),
  mlServiceUrl: (process.env.ML_SERVICE_URL || 'http://localhost:8000').replace(/\/$/, ''),
  corsOrigin: process.env.CORS_ORIGIN || 'http://localhost:5173',
  requestTimeoutMs: toPositiveInteger(process.env.REQUEST_TIMEOUT_MS, 5000),
});
