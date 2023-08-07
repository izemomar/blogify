export type ArticlePaginationFilterRequest = Record<string, string | number> & {
  page: number;
  perPage: number;
  status?: string;
  search?: string;
  orderBy?: string;
  dir?: string;
  include?: string[];
};
