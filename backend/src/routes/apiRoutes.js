import { Router } from 'express';
import { getMlHealth, predictMachineHealth } from '../services/mlService.js';
import { validateAnalyzeRequest } from '../validation/analyzeRequest.js';

export const apiRouter = Router();

apiRouter.get('/status', async (request, response) => {
  let mlService;

  try {
    const health = await getMlHealth();
    mlService = { ...health, status: 'online' };
  } catch (error) {
    mlService = { status: 'offline', message: error.message };
  }

  response.json({
    success: true,
    data: {
      backend: { status: 'online' },
      mlService,
      checkedAt: new Date().toISOString(),
    },
  });
});

apiRouter.post('/analyze', async (request, response) => {
  const { machineName, metrics } = validateAnalyzeRequest(request.body);
  const prediction = await predictMachineHealth(metrics);

  response.json({
    success: true,
    data: {
      machineName,
      status: prediction.status,
      riskScore: prediction.riskScore,
      recommendation: prediction.recommendation,
      checkedAt: new Date().toISOString(),
    },
  });
});
