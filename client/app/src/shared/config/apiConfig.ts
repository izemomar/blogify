import { env } from './env';

export type ApiConfig = {
  baseUrl: string;
  endpoints: Record<string, string>;
};

export const apiConfig = {
  baseUrl: env.API_URL,
  endpoints: {
    articles: {
      getAll: '/articles',
      getOne: (id: string) => `/articles/${id}`
    }
  }
};
