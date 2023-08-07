<template>
  <v-card class="mx-auto my-12" max-width="374">
    <v-img cover height="250" lazy :src="article.image"></v-img>

    <v-card-item>
      <v-card-title>
        {{ article.title }}
      </v-card-title>
    </v-card-item>

    <v-card-text>
      <div>
        {{ article.summary.slice(0, 100) }}
      </div>
    </v-card-text>
    <v-card-text>
      <v-chip color="primary" text-color="white">
        {{ article.status }}
      </v-chip>
    </v-card-text>

    <v-divider class="mx-4 mb-1"></v-divider>

    <v-card-actions>
      <v-spacer></v-spacer>

      <v-btn>Edit</v-btn>

      <v-btn color="primary">View</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Article } from '@/shared/utils/models';

export default defineComponent({
  name: 'ArticleElement',
  props: {
    article: {
      type: Object as () => Article,
      required: true
    }
  }
});
</script>
