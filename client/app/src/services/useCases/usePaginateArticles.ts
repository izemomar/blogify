import { onMounted, reactive, watch } from 'vue';
import { debounce } from 'lodash';
import { useArticles } from '@/services/api/useArticles';
import { Article } from '@/shared/utils/models';
import { ArticlePaginationFilterRequest } from '@/services/api/DTOS/ArticlePaginationFilterRequest';
import { Pagination } from '@/services/api/DTOS/Pagination';

export const usePaginateArticles = () => {
  const { getArticles } = useArticles();

  const articles = reactive<Article[]>([]);
  const pagination = reactive<Pagination>({} as Pagination);

  const state = reactive({
    loading: false,
    error: ''
  });

  const filters = reactive<ArticlePaginationFilterRequest>({
    search: '',
    orderBy: 'created_at',
    dir: 'asc',
    include: ['metas']
  } as ArticlePaginationFilterRequest);

  const updateFilters = (newFilters: any) => {
    Object.assign(filters, newFilters);
  };

  const execute = async () => {
    try {
      state.loading = true;
      const response = await getArticles({
        ...filters,
        page: pagination.current_page,
        perPage: pagination.per_page
      } as ArticlePaginationFilterRequest);

      articles.splice(0, articles.length, ...(response?.articles ?? []));
      Object.assign(pagination, response?.pagination ?? {});
    } catch (error) {
    } finally {
      state.loading = false;
    }
  };

  watch(
    () => filters,
    () => {
      execute();
    },
    { deep: true }
  );

  onMounted(() => {
    debounce(() => {
      execute();
    }, 500)();
  });

  const updatePage = (page: number) => {
    Object.assign(pagination, { current_page: page });
  };

  // watch current page
  watch(
    () => pagination.current_page,
    () => {
      debounce(() => {
        execute();
      }, 500)();
    }
  );

  return {
    filters,
    updateFilters,
    execute,
    articles,
    state,
    pagination,
    updatePage
  };
};
