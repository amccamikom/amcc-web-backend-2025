export function notFoundHandler(request, response) {
  response.status(404).json({
    success: false,
    message: `Route ${request.method} ${request.originalUrl} was not found.`,
  });
}

export function errorHandler(error, request, response, next) {
  if (response.headersSent) {
    return next(error);
  }

  const statusCode = error.statusCode || error.status || 500;

  if (statusCode >= 500) {
    console.error(`${new Date().toISOString()} ${request.method} ${request.originalUrl}`, error);
  }

  return response.status(statusCode).json({
    success: false,
    message: statusCode >= 500 && !error.isOperational
      ? 'An unexpected server error occurred.'
      : error.message,
  });
}
