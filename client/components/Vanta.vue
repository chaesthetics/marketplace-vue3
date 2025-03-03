<template>
  <div ref="vantaElement" class="vanta-container"></div>
</template>

<script setup>
import { onMounted, ref, onBeforeUnmount } from 'vue';

const vantaElement = ref(null);

onMounted(() => {
  if (typeof window !== 'undefined' && vantaElement.value) {
    // Dynamically load Three.js
    const threeScript = document.createElement('script');
    threeScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js';
    threeScript.onload = () => {
      // Once THREE is loaded, load Vanta.js
      const vantaScript = document.createElement('script');
      vantaScript.src = 'https://cdn.jsdelivr.net/npm/vanta@0.5.24/dist/vanta.net.min.js';
      vantaScript.onload = () => {
        if (typeof VANTA !== 'undefined' && VANTA.NET) {
          VANTA.NET({
            el: vantaElement.value,
            mouseControls: true,
            touchControls: true,
            gyroControls: false,
            minHeight: 200,
            minWidth: 200,
            scale: 1,
            scaleMobile: 1,
            color: 0x19a73c, // Greenish color
            backgroundColor: 0x00, 
            points: 10.00,
            spacing: 15.00,
            maxDistance: 20,
            showDots: true,
          });
        } else {
          console.error('VANTA.NET is still not available.');
        }
      };
      document.head.appendChild(vantaScript);
    };
    document.head.appendChild(threeScript);
  }
});

onBeforeUnmount(() => {
  if (vantaElement.value && vantaElement.value._vantaEffect) {
    vantaElement.value._vantaEffect.destroy();
  }
});
</script>

<style scoped>
.vanta-container {
  width: 100%;
  height: 100vh;
  position: absolute;
  top: 0;
  left: 0;
  z-index: -1;
}
</style>
