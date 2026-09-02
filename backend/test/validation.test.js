import test from 'node:test';
import assert from 'node:assert/strict';
import { validateAnalyzeRequest } from '../src/validation/analyzeRequest.js';

test('returns normalized valid data', () => {
  const result = validateAnalyzeRequest({
    machineName: '  Machine A  ',
    temperature: 75,
    vibration: 4.2,
    operatingHours: 1200,
  });

  assert.deepEqual(result, {
    machineName: 'Machine A',
    metrics: { temperature: 75, vibration: 4.2, operatingHours: 1200 },
  });
});

test('rejects missing and invalid values', () => {
  assert.throws(
    () => validateAnalyzeRequest({ machineName: '', temperature: 75, vibration: 4.2, operatingHours: 1200 }),
    /Machine name is required/,
  );

  assert.throws(
    () => validateAnalyzeRequest({ machineName: 'A', temperature: Number.NaN, vibration: 4.2, operatingHours: 1200 }),
    /Temperature must be a valid number/,
  );
});
