import { ArticleMetaResponse } from './ArticleMetaResponse';
import { Pagination } from './Pagination';

export interface ArticleResponse {
  id: number;
  title: string;
  slug: string;
  summary: string;
  content: string;
  image: string | null;
  status: 'draft' | 'published' | 'archived';
  published_at: string | null;
  created_at: string;
  updated_at: string;
  metas: ArticleMetaResponse[];
}

export interface ArticlePaginationResponse {
  data: ArticleResponse[];
  meta: Pagination;
  success: boolean;
  message?: string;
}
