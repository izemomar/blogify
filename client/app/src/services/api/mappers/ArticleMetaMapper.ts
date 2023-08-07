import { ArticleMeta } from '@/shared/utils/models';
import { ArticleMetaResponse } from '../DTOS/ArticleMetaResponse';

export class ArticleMetaMapper {
  static responseToModel(response: ArticleMetaResponse): ArticleMeta {
    return {
      id: response.id,
      key: response.key,
      value: response.value,
      type: response.type
    };
  }
}
