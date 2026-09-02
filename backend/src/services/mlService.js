import { config } from '../config.js';
import { AppError } from '../errors/AppError.js';

async function requestMlService(path, options = {}) {
  try {
    const response = await fetch(`${config.mlServiceUrl}${path}`, {
      ...options,
      signal: AbortSignal.timeout(config.requestTimeoutMs),
    });

    const payload = await response.json().catch(() => null);

    if (!response.ok) {
      const detail = Array.isArray(payload?.detail)
        ? payload.detail.map((item) => item.msg).join(', ')
        : payload?.detail;
      throw new AppError(detail || `ML service returned status ${response.status}.`, 502);
    }

    return payload;
  } catch (error) {
    if (error instanceof AppError) throw error;

    if (error.name === 'TimeoutError') {
      throw new AppError(`ML service did not respond within ${config.requestTimeoutMs} ms.`, 504, error);
    }

    throw new AppError('ML service is unavailable. Make sure it is running and ML_SERVICE_URL is correct.', 503, error);
  }
}

export function getMlHealth() {
  return requestMlService('/health');
}

export function predictMachineHealth(metrics) {
  return requestMlService('/predict', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(metrics),
  });
}
