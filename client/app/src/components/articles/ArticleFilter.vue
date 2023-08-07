<template>
  <v-row>
    <v-col cols="12" md="4" lg="3">
      <v-text-field
        v-model="filter.search"
        label="Search..."
        outlined
        dense
      ></v-text-field>
    </v-col>
    <v-col cols="12" md="4" lg="3">
      <v-select
        v-model="filter.status"
        :items="statusOptions"
        label="Status"
        item-title="text"
        item-value="value"
        outlined
        dense
      ></v-select>
    </v-col>
    <v-col cols="12" md="4" lg="3">
      <v-select
        v-model="filter.sort"
        :items="[
          { text: 'Newest', value: 'newest' },
          { text: 'Oldest', value: 'oldest' }
        ]"
        label="Sort"
        item-title="text"
        item-value="value"
        outlined
        dense
      ></v-select>
    </v-col>
  </v-row>
</template>

<script lang="ts">
import { ArticlePaginationFilterRequest } from '@/services/api/DTOS/ArticlePaginationFilterRequest';
import { debounce } from 'lodash';
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'ArticleFilter',
  props: {
    value: {
      type: Object as () => ArticlePaginationFilterRequest,
      required: true
    }
  },
  data() {
    return {
      statusOptions: [
        { text: 'Draft', value: 'draft' },
        { text: 'Published', value: 'published' },
        { text: 'Archived', value: 'archived' }
      ]
    };
  },
  emits: ['updateFilter'],
  computed: {
    filter: {
      get() {
        return this.value;
      },
      set(value: ArticlePaginationFilterRequest) {
        debounce(() => {
          if (value.orderBy === 'newest') {
            value.orderBy = 'created_at';
            value.orderDirection = 'DESC';
          } else if (value.orderBy === 'oldest') {
            value.orderBy = 'created_at';
            value.orderDirection = 'ASC';
          }
          this.$emit('updateFilter', value);
        }, 500)();
      }
    }
  }
});
</script>
