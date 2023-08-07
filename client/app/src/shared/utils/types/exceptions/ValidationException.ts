import { HttpException } from './HttpException';

type ValidationExceptionOptions = {
  message: string;
  statusCode?: number;
  errors: Record<string, string[]>;
};

export class ValidationException extends HttpException {
  public readonly errors: Record<string, string[]>;

  constructor(options: ValidationExceptionOptions) {
    super(options.message, options.statusCode);
    this.errors = options.errors;
  }
}
