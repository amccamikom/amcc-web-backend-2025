import cors from 'cors';
import express from 'express';
import { config } from './config.js';
import { apiRouter } from './routes/apiRoutes.js';
import { errorHandler, notFoundHandler } from './middleware/errorHandlers.js';
import { httpLogger } from './middleware/httpLogger.js';

export function createApp() {
  const app = express();

  app.disable('x-powered-by');
  app.use(cors({ origin: config.corsOrigin }));
  app.use(express.json({ limit: '20kb' }));
  app.use(httpLogger);

  app.get('/', (request, response) => {
    response.json({
      success: true,
      data: {
        name: 'AMCC Docker Lab Backend API',
        endpoints: ['GET /health', 'GET /api/status', 'POST /api/analyze'],
      },
    });
  });

  app.get('/health', (request, response) => {
    response.json({
      success: true,
      status: 'healthy',
      timestamp: new Date().toISOString(),
      uptime: Number(process.uptime().toFixed(2)),
    });
  });

  app.use('/api', apiRouter);
  app.use(notFoundHandler);
  app.use(errorHandler);

  return app;
}
