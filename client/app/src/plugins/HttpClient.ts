import axios, {
  AxiosInstance,
  AxiosResponse,
  AxiosError,
  Method,
  AxiosRequestConfig
} from 'axios';

import { apiConfig } from '@/shared/config/apiConfig';
import {
  HttpException,
  ValidationException
} from '@/shared/utils/types/exceptions';

export class HttpClient {
  private static instance: HttpClient;
  private baseUrl: string;
  private axiosInstance: AxiosInstance;
  private defaultHeaders: AxiosRequestConfig['headers'];

  private constructor() {
    this.baseUrl = apiConfig.baseUrl;
    this.defaultHeaders = {
      Accept: 'application/json',
      'Content-Type': 'application/json'
    };
    this.axiosInstance = axios.create({
      baseURL: this.baseUrl,
      headers: this.defaultHeaders
    });
    this.enableInterceptors();
  }

  public static getInstance(): HttpClient {
    if (!HttpClient.instance) {
      HttpClient.instance = new HttpClient();
    }
    return HttpClient.instance;
  }

  public setBearerToken(token: string | undefined): void {
    if (!this.defaultHeaders) this.defaultHeaders = {};
    if (!token) {
      delete this.defaultHeaders['Authorization'];
    } else {
      this.defaultHeaders['Authorization'] = `Bearer ${token}`;
    }
  }

  private enableInterceptors(): void {
    this.axiosInstance.interceptors.response.use(
      this.getSuccessResponseHandler,
      this.getErrorResponseHandler
    );
  }

  private getSuccessResponseHandler<TResponse>(
    response: AxiosResponse<TResponse>
  ): AxiosResponse<TResponse> {
    return response;
  }

  private getErrorResponseHandler(error: AxiosError): Promise<never> {
    return Promise.reject({ ...error });
  }

  protected async request<TResponse, TData>(
    method: Method,
    url: string,
    data?: TData,
    params?: Record<string, string | number | string[] | number[]>,
    headers?: AxiosRequestConfig['headers']
  ): Promise<TResponse> {
    try {
      const response = await this.axiosInstance.request<TResponse>({
        method,
        url: `${url}`,
        data,
        params,
        headers: {
          ...this.defaultHeaders,
          ...headers
        }
      });
      return response.data;
    } catch (error) {
      throw this.parseApiError(error);
    }
  }

  public async get<TResponse = void>(
    url: string,
    params?: Record<string, string | number>,
    headers?: AxiosRequestConfig['headers']
  ): Promise<TResponse> {
    return this.request<TResponse, undefined>(
      'GET',
      url,
      undefined,
      params,
      headers
    );
  }

  public async post<TResponse = void, TData = unknown>(
    url: string,
    data?: TData,
    params?: Record<string, string | number>,
    headers?: AxiosRequestConfig['headers']
  ): Promise<TResponse> {
    return this.request<TResponse, TData>('POST', url, data, params, headers);
  }

  public async put<TResponse = void, TData = undefined>(
    url: string,
    data?: TData,
    params?: Record<string, string | number>,
    headers?: AxiosRequestConfig['headers']
  ): Promise<TResponse> {
    return this.request<TResponse, TData>('PUT', url, data, params, headers);
  }

  public async delete<TResponse = void>(
    url: string,
    params?: Record<string, string | number>,
    headers?: AxiosRequestConfig['headers']
  ): Promise<TResponse> {
    return this.request<TResponse, undefined>(
      'DELETE',
      url,
      undefined,
      params,
      headers
    );
  }

  /**
   *
   * @param error
   *
   * @throws {HttpException}
   */
  protected parseApiError(
    error: AxiosError | Error | unknown
  ): HttpException | Error {
    if (error && Object.hasOwnProperty.call(error, 'response')) {
      const { response } = error as AxiosError;
      if (response) {
        // get error code
        const { status, data } = response as AxiosResponse;

        if (status === 422) {
          return new ValidationException({
            message: 'Validation error',
            statusCode: status,
            errors: data.errors
          });
        } else {
          return new HttpException(data.message, status);
        }
      }
    }

    return new Error('Something went wrong');
  }
}

export const useHttpClient = () => {
  return HttpClient.getInstance();
};
