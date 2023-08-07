<script lang="ts">
import { defineComponent } from 'vue';
import ArticleList from '@/components/articles/ArticleList.vue';
import ArticleFilter from '@/components/articles/ArticleFilter.vue';
import { usePaginateArticles } from '@/services/useCases/usePaginateArticles';
export default defineComponent({
  components: {
    ArticleList,
    ArticleFilter
  },
  setup() {
    const { articles, updatePage, state, filters, updateFilters, pagination } =
      usePaginateArticles();

    return {
      articles,
      updatePage,
      state,
      filters,
      pagination,
      updateFilters
    };
  }
});
</script>

<template>
  <v-container>
    <ArticleFilter :value="filters" @updateFilter="updateFilters" />
  </v-container>
  <ArticleList :articles="articles" :loading="state.loading" />

  <v-container class="text-center">
    <v-pagination
      class="mx-auto"
      v-model="filters.page"
      :length="pagination.last_page"
      @input="updatePage"
    ></v-pagination>
  </v-container>
</template>

<style scoped></style>
