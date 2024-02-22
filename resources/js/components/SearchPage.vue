<template>
  <div class="search-page">
    <h1 class="title">レストラン検索</h1>
    <div class="search-controls">
      <label for="range" class="label">検索範囲</label>
      <select v-model="range" id="range" class="select">
        <option value="1">300m以内</option>
        <option value="2">500m以内</option>
        <option value="3">1000m以内</option>
        <option value="4">2000m以内</option>
        <option value="5">3000m以内</option>
      </select>
      <label for="genre" class="label">ジャンル</label>
      <select v-model="genre" id="genre" class="select">
        <option value="">すべてのジャンル</option>
        <option v-for="genre in genres" :key="genre.code" :value="genre.code">
          {{ genre.name }}
        </option>
      </select>
      <label for="budget" class="label">予算</label>
      <select v-model="selectedBudget" id="budget" class="select">
        <option value="">予算を選択</option>
        <option v-for="budget in budgets" :key="budget.code" :value="budget.code">
          {{ budget.name }}
        </option>
      </select>
      <button @click="performSearch" class="search-button">検索</button>
    </div>
    <ul class="results-list">
      <li v-for="shop in results" :key="shop.id" class="result-item">
        <div class="shop-name">{{ shop.name }}</div>
        <div class="shop-address">{{ shop.address }}</div>
      </li>
    </ul>
  </div>
</template>


<script>
export default {
  name: 'SearchPage',
  data() {
    return {
      range: '3', // デフォルトで1000m以内
      results: [], // 検索結果を格納する配列
      genres: [],
      genre: '',
      budgets: [], // ディナー予算データを格納する配列
      selectedBudget: '', // 選択されたディナー予算
    };
  },
  mounted() {
    this.fetchGenres();
    this.fetchBudgets(); // ディナー予算データの取得メソッドを呼び出し
  },
  methods: {
    async fetchGenres() {
      try {
        const response = await this.$http.get('/api/genres');
        this.genres = response.data.results.genre;
      } catch (error) {
        console.error('ジャンルデータの取得に失敗しました。', error);
      }
    },
    async fetchBudgets() {
      try {
        const response = await this.$http.get('/api/budgets');
        this.budgets = response.data.results.budget;
      } catch (error) {
        console.error('ディナー予算データの取得に失敗しました。', error);
      }
    },
    performSearch() {
      // Geolocation APIを使用して現在地を取得
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
          this.searchRestaurants(position.coords.latitude, position.coords.longitude);
        }, error => {
          console.error(error);
          alert('位置情報の取得に失敗しました。');
        });
      } else {
        alert('このブラウザではGeolocationがサポートされていません。');
      }
    },
        async searchRestaurants(latitude, longitude) {
          console.log("Selected budget:", this.selectedBudget);
      try {
        const response = await this.$http.get('/api/search-restaurants', {
          params: {
            latitude,
            longitude,
            range: this.range,
            genre: this.genre,
            budget: this.selectedBudget,
          }
        });
        // 検索結果があるかチェック
    if (response.data.results.shop && response.data.results.shop.length > 0) {
      // 検索結果をセッションストレージに保存
      sessionStorage.setItem('searchResults', JSON.stringify(response.data.results.shop));
      // ResultsPage にルーティング
      this.$router.push({ name: 'ResultsPage' });
    } else {
      // 検索結果がない場合、メッセージを表示
      this.results = []; // 結果リストをクリア
      alert('検索結果はありませんでした。');
    }
  } catch (error) {
    console.error('APIからのデータ取得に失敗しました。', error);
      }
    },
  },
};
</script>

<style scoped>
.search-page {
  max-width: 600px;
  margin: 20px auto;
  padding: 20px;
  font-family: 'Helvetica Neue', Arial, sans-serif;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  border-radius: 8px;
  background-color: #ffffff;
}

.title {
  color: #333;
  text-align: center;
  margin-bottom: 30px;
}

.search-controls {
  display: flex;
  flex-direction: column;
  gap: 15px;
  margin-bottom: 30px;
}

.label {
  font-weight: bold;
  margin-bottom: 5px;
  color: #444;
}

.select, .search-button {
  padding: 10px 15px;
  border-radius: 5px;
  border: 1px solid #ccc;
}

.select {
  background-color: #f9f9f9;
  cursor: pointer;
}

.search-button {
  background-color: #007bff;
  color: #ffffff;
  border: none;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.search-button:hover {
  background-color: #0056b3;
}

.results-list {
  list-style: none;
  padding: 0;
  margin-top: 20px;
}

.result-item {
  padding: 15px;
  border-bottom: 1px solid #eee;
  transition: background-color 0.3s ease;
}

.result-item:hover {
  background-color: #f9f9f9;
}

.shop-name {
  font-size: 18px;
  color: #333;
  font-weight: bold;
}

.shop-address {
  font-size: 14px;
  color: #666;
  margin-top: 5px;
}

@media (max-width: 640px) {
  .search-controls {
    flex-direction: column;
  }
  
}
</style>