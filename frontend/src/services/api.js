import { API_BASE_URL } from '../config/api.js';

async function readResponse(response) {
  const payload = await response.json().catch(() => null);

  if (!response.ok) {
    throw new Error(payload?.message || `Request failed with status ${response.status}.`);
  }

  return payload;
}

export async function checkServices() {
  const response = await fetch(`${API_BASE_URL}/api/status`);
  return readResponse(response);
}

export async function analyzeMachine(machine) {
  const response = await fetch(`${API_BASE_URL}/api/analyze`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(machine),
  });

  return readResponse(response);
}
