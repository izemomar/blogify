import { ArticleMeta } from './ArticleMeta';

export interface Article {
  id: number;
  title: string;
  slug: string;
  summary: string;
  content: string;
  status: string;
  image: string | null;
  publishedAt: string | null;
  createdAt: string;
  updatedAt: string;
  meta: ArticleMeta[];
}
