<template>
  <div class="details-page-container">
    <div v-if="details" class="details-page">
      <h1 class="shop-title">{{ details.name }}</h1>
      <img :src="details.logo_image" alt="店舗のロゴ" class="shop-thumbnail">
      <div class="shop-info">
        <p><strong>アクセス:</strong> {{ details.access }}</p>
        <p><strong>住所:</strong> {{ details.address }}</p>
        <p><strong>営業時間:</strong> {{ details.open }}</p>
        <p><strong>平均予算:</strong> {{ details.budget.average }}</p>
      </div>
      <button @click="goBack" class="back-button">戻る</button>
    </div>
    <div v-else class="loading">
      <p>店舗の詳細情報を読み込んでいます...</p>
    </div>
  </div>
  
</template>


<script>
export default {
  name: 'DetailsPage',
  data() {
    return {
      details: null // 初期状態はnull
    };
  },
  mounted() {
    this.fetchDetails();
  },
  methods: {
    
    async fetchDetails() {
      const id = this.$route.params.id; // URLから店舗IDを取得
      try {
        const response = await this.$http.get(`/api/get-restaurant-details/${id}`);
        // APIから取得した店舗の詳細情報をセット
        if (response.data.results.shop.length > 0) {
          this.details = response.data.results.shop[0];
        } else {
          console.error('店舗の詳細情報が見つかりません。');
        }
      } catch (error) {
        console.error('詳細情報の取得に失敗しました。', error);
      }
    },
    goBack() {
      this.$router.go(-1); // 一つ前のページに戻る
    }
  }
};
</script>

<style scoped>
.details-page-container {
  max-width: 800px;
  margin: 20px auto;
  padding: 20px;
  background-color: #fff;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  border-radius: 8px;
  font-family: 'Helvetica Neue', Arial, sans-serif;
}

.shop-title {
  color: #333;
  text-align: center;
  margin: 20px 0;
  font-size: 24px;
}

.shop-thumbnail {
  display: block;
  width: 300px; /* 具体的な幅を指定 */
  max-width: 100%; /* コンテナより大きくならないように制限 */
  height: auto; /* アスペクト比を維持 */
  margin: 20px auto;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.shop-info {
  margin: 20px 0;
  padding: 0 10px;
}

.shop-info p {
  font-size: 16px;
  color: #555;
  line-height: 1.5;
  margin: 10px 0;
}

.back-button {
  display: block;
  width: auto; /* ボタンの幅をテキスト内容に合わせる */
  padding: 10px 20px; /* ボタンの内側の余白を増やす */
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
  margin: 20px auto; /* 中央揃え */
  font-size: 16px;
}

.back-button:hover {
  background-color: #0056b3;
}

.loading {
  text-align: center;
  font-size: 16px;
}
</style>