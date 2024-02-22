<template>
  <div class="results-page">
    <div class="filters">
      <select v-model="sortKey">
        <option value="name">名前順</option>
        <option value="access">アクセス順</option>
        <option value="rating">評価順</option> <!-- 新しいソートオプションを追加 -->
      </select>
      
    </div>
    <h1 class="page-title">検索結果</h1>
    <ul class="results-list">
      <li v-for="shop in sortedAndPaginatedResults" :key="shop.id" @click="goToDetailsPage(shop.id)" class="result-item clickable">
    <!-- 店舗情報の表示 -->
        <img :src="shop.logo_image" alt="サムネイル" class="shop-thumbnail">
        <div class="shop-details">
          <div class="shop-name">{{ shop.name }}</div>
          <div class="shop-access">{{ shop.access }}</div>
        </div>
      </li>
    </ul>
    <nav class="pagination">
      <button v-for="page in totalPages" :key="page" @click="changePage(page)" class="page-button">
        {{ page }}
      </button>
    </nav>
  </div>
</template>



<script>
export default {
  data() {
    return {
      results: [],
      currentPage: 1,
      pageSize: 5,
      filterType: '', 
      sortKey: 'name', // ソートキー
    };
  },
  computed: {
    filteredResults() {
      let results = this.results;
      if (this.filterType) {
        results = results.filter(shop => shop.type === this.filterType);
      }
      return results;
    },
    sortedAndPaginatedResults() {
      let results = [...this.filteredResults];
      if (this.sortKey === 'name') {
        results.sort((a, b) => a.name.localeCompare(b.name));
      } else if (this.sortKey === 'access') {
        results.sort((a, b) => a.access.localeCompare(b.access));
      } else if (this.sortKey === 'rating') { 
        results.sort((a, b) => b.rating - a.rating); // 評価が高い順
      }
      const start = (this.currentPage - 1) * this.pageSize;
      return results.slice(start, start + this.pageSize);
    },
    totalPages() {
      return Math.ceil(this.filteredResults.length / this.pageSize);
    }
  },
  mounted() {
    const results = sessionStorage.getItem('searchResults');
    if (results) {
      this.results = JSON.parse(results);
    }
  },
  methods: {
    goToDetailsPage(id) {
      this.$router.push({ name: 'DetailsPage', params: { id } });
    },
    changePage(page) {
      this.currentPage = page;
    },
  },
};
</script>

<style scoped>
.results-page {
  padding: 20px;
}

.page-title {
  margin-bottom: 20px;
  text-align: center;
}

.results-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.result-item {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
  padding: 10px;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  transition: box-shadow 0.3s ease;
}

.result-item:hover {
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.shop-thumbnail {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  margin-right: 20px;
  object-fit: cover;
}

.shop-details {
  flex: 1;
}

.shop-name {
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 5px;
}

.shop-access {
  font-size: 14px;
  color: #666;
}

.clickable {
  cursor: pointer;
}
.pagination {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.page-button {
  margin: 0 5px;
  padding: 5px 10px;
  background-color: #f0f0f0;
  border: 1px solid #ddd;
  cursor: pointer;
}

.page-button:hover {
  background-color: #e0e0e0;
}
</style>