console.log("Using nuxt.config.js");

export default {
  srcDir: 'src/',

  // Cấu hình axios
  axios: {
    baseURL: 'http://localhost/api/data.php', // URL của API backend
  },

  buildModules: [
    '@nuxtjs/axios', // Tích hợp axios module
  ],

  css: [
    'bootstrap/dist/css/bootstrap.min.css', // Thêm bootstrap
    'swiper/swiper-bundle.css',            // Thêm swiper cho carousel
    '@fortawesome/fontawesome-free/css/all.min.css', // Thêm font-awesome
    '@/assets/css/main.css',               // CSS tùy chỉnh
  ],

  app: {
    head: {
      title: 'Nội Thất Hiếu Nguyên',
      meta: [
        { name: 'description', content: 'My awesome Nuxt project' },
        { charset: 'utf-8' },
        { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      ],
      link: [{ rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }],
    },
  },

  build: {
    extractCSS: true, // Tách CSS để tối ưu
    useVite: false,   // Không dùng Vite, dùng Webpack
  },

  server: {
    port: 3000,
    host: '0.0.0.0', // Cho phép truy cập từ mọi địa chỉ IP
  },

  plugins: [
    { src: '@/assets/plugins/swiper.js', mode: 'client' }, // Plugin cho swiper
  ],

  pageTransition: 'page', // Hiệu ứng chuyển trang
  components: true, // Tự động phát hiện components
  compatibilityDate: '2024-11-12', // Đặt ngày tương thích

  // Cấu hình router với route động
  router: {
    extendRoutes(routes, resolve) {
      console.log("Debug Routes:", routes); // Log các route để kiểm tra
      routes.push({
        path: '/product/:id', // Định nghĩa route động
        component: resolve(__dirname, 'src/pages/_id.vue'), // Đường dẫn chính xác tới file _id.vue
      });
    },
  },
};
