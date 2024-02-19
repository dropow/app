<template>
  <div class="search-page">
    <h1>レストラン検索</h1>
    <input v-model="searchQuery" type="text" placeholder="レストランを検索" />
    <button @click="performSearch">検索</button>
  </div>
</template>

<script>
export default {
  name: 'SearchPage',
  data() {
    return {
      searchQuery: '',
    };
  },
  methods: {
    performSearch() {
      // ここで検索機能を実装します。今回はログに出力するだけです。
      console.log('検索実行:', this.searchQuery);
      // 実際には、APIへのリクエストを送信するなどの処理をここに追加します。
    },
  },
};
</script>

<style scoped>
.search-page {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
}

input[type="text"] {
  width: 100%;
  max-width: 300px;
  padding: 0.5rem;
}

button {
  padding: 0.5rem 1rem;
  cursor: pointer;
}
</style>