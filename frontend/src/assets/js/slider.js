// src/assets/plugins/jquery.js
import jQuery from 'jquery';

if (typeof window !== 'undefined') {
  window.$ = window.jQuery = jQuery; // Gán jQuery cho window
}

export default defineNuxtPlugin(() => {
  return {
    provide: {
      $: jQuery // Cung cấp jQuery cho các component
    }
  };
});
