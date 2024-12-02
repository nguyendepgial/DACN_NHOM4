<template>
  <div>
    <Header />
    <nuxt />
    <Footer />
  </div>
</template>

<script>
import Header from '~/components/Header.vue'
import Footer from '~/components/Footer.vue'

export default {
  name: 'DefaultLayout',
  components: {
    Header,
    Footer
  }
}
</script>

<style>
/* Add any additional styles here */
</style>
