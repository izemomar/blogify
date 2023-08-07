import { Article } from '@/shared/utils/models';
import { ArticleResponse } from '../DTOS/ArticleResponse';
import { ArticleMetaMapper } from './ArticleMetaMapper';

export class ArticleMapper {
  static responseToModel(response: ArticleResponse): Article {
    return {
      id: response.id,
      title: response.title,
      slug: response.slug,
      summary: response.summary,
      content: response.content,
      image: response.image,
      status: response.status,
      publishedAt: response.published_at,
      createdAt: response.created_at,
      updatedAt: response.updated_at,
      meta: response.metas?.map(meta => ArticleMetaMapper.responseToModel(meta))
    };
  }
}
