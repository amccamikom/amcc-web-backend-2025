export class AppError extends Error {
  constructor(message, statusCode = 500, cause) {
    super(message, { cause });
    this.name = 'AppError';
    this.statusCode = statusCode;
    this.isOperational = true;
  }
}
