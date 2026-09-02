import { AppError } from '../errors/AppError.js';

const metricRules = {
  temperature: { label: 'Temperature', max: 200 },
  vibration: { label: 'Vibration', max: 100 },
  operatingHours: { label: 'Operating hours', max: 1_000_000 },
};

export function validateAnalyzeRequest(body) {
  if (!body || typeof body !== 'object' || Array.isArray(body)) {
    throw new AppError('Request body must be a JSON object.', 400);
  }

  const machineName = typeof body.machineName === 'string' ? body.machineName.trim() : '';

  if (!machineName) {
    throw new AppError('Machine name is required.', 400);
  }

  if (machineName.length > 80) {
    throw new AppError('Machine name must be 80 characters or fewer.', 400);
  }

  const metrics = {};

  for (const [field, rule] of Object.entries(metricRules)) {
    const value = body[field];

    if (value === '' || value === null || value === undefined) {
      throw new AppError(`${rule.label} is required.`, 400);
    }

    if (typeof value !== 'number' || !Number.isFinite(value)) {
      throw new AppError(`${rule.label} must be a valid number.`, 400);
    }

    if (value < 0 || value > rule.max) {
      throw new AppError(`${rule.label} must be between 0 and ${rule.max}.`, 400);
    }

    metrics[field] = value;
  }

  return { machineName, metrics };
}
