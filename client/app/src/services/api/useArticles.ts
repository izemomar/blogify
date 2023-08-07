import { useHttpClient } from '@/plugins/HttpClient';
import { apiConfig } from '@/shared/config/apiConfig';
import { ArticlePaginationResponse } from './DTOS/ArticleResponse';
import { ArticleMapper } from './mappers/ArticleMapper';
import { ArticlePaginationFilterRequest } from './DTOS/ArticlePaginationFilterRequest';

export function useArticles() {
  const httpClient = useHttpClient();

  const getArticles = async (params: ArticlePaginationFilterRequest) => {
    const response = await httpClient.get<ArticlePaginationResponse>(
      apiConfig.endpoints.articles.getAll,
      params
    );
    return {
      articles:
        response.data?.map(article => ArticleMapper.responseToModel(article)) ??
        [],
      pagination: response?.meta as unknown as ArticlePaginationResponse
    };
  };

  return {
    getArticles
  };
}
