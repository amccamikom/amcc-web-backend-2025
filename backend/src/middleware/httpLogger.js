export function httpLogger(request, response, next) {
  const startedAt = performance.now();

  response.on('finish', () => {
    const duration = (performance.now() - startedAt).toFixed(1);
    console.log(`${new Date().toISOString()} ${request.method} ${request.originalUrl} ${response.statusCode} ${duration}ms`);
  });

  next();
}
