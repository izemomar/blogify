export type Env = {
  NODE_ENV: string;
  API_URL: string;
};

export const env: Env = {
  NODE_ENV: import.meta.env.MODE,
  API_URL: import.meta.env.VITE_API_URL
};
