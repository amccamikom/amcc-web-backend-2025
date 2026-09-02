const configuredUrl = import.meta.env.VITE_API_BASE_URL?.trim();

export const API_BASE_URL = (configuredUrl || 'http://localhost:3000').replace(/\/$/, '');
