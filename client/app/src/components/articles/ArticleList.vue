<template>
  <v-container>
    <v-row>
      <v-col cols="12" v-if="loading">
        <v-progress-linear height="30" color="primary" indeterminate>
          loading articles...
        </v-progress-linear>
      </v-col>
      <v-col cols="12" v-else>
        <v-row class="">
          <v-col
            v-for="article in articles"
            :key="article.id"
            class=""
            cols="12"
            md="4"
            lg="3"
          >
            <ArticleElement :article="article" />
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Article } from '@/shared/utils/models';
import ArticleElement from './ArticleElement.vue';
export default defineComponent({
  name: 'ArticleList',
  props: {
    articles: {
      type: Array as () => Article[],
      required: true
    },
    loading: {
      type: Boolean,
      required: true
    }
  },
  components: {
    ArticleElement
  }
});
</script>
