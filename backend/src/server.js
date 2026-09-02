import { createApp } from './app.js';
import { config } from './config.js';

const app = createApp();
const server = app.listen(config.port, '0.0.0.0', () => {
  console.log(`Backend API listening on http://localhost:${config.port}`);
  console.log(`Using ML service at ${config.mlServiceUrl}`);
});

let isShuttingDown = false;

function shutdown(signal) {
  if (isShuttingDown) return;
  isShuttingDown = true;
  console.log(`\n${signal} received. Closing HTTP server...`);

  server.close((error) => {
    if (error) {
      console.error('Failed to close HTTP server cleanly.', error);
      process.exitCode = 1;
    }
    process.exit();
  });

  setTimeout(() => {
    console.error('Graceful shutdown timed out. Forcing exit.');
    process.exit(1);
  }, 10_000).unref();
}

process.on('SIGINT', () => shutdown('SIGINT'));
process.on('SIGTERM', () => shutdown('SIGTERM'));
